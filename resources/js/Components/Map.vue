<script setup lang="ts">
import { ActionData, ActionsJsonData, CategoryData } from "@/types/generated";
import maplibregl, { GeoJSONSource } from "maplibre-gl";
import "maplibre-gl/dist/maplibre-gl.css";
import SearchAutoComplete, {
    PlacesData,
} from "@/Components/SearchAutoComplete.vue";
import SearchCategoryFilter from "@/Components/SearchCategoryFilter.vue";
import { onMounted, onUnmounted, ref, watch } from "vue";
import { useThrottleFn } from "@vueuse/core";
import { SearchIcon } from "@heroicons/vue/solid";

const props = defineProps<{
    apiKey: string;
    geoData: ActionsJsonData[];
    categories: CategoryData[];
    formActive: boolean;
    focusedAction?: ActionData;
}>();

const emit = defineEmits(["mapChanged", "categoryChanged", "actionSelected"]);

let actionIsFocused = false;

let searchAutoCompleteRef = ref(null);

let map: maplibregl.Map;
const mapRef = ref<HTMLElement>();
// Workaround for flickering when resizing the map
const resizeObserver = new ResizeObserver(() => {
    window.setTimeout(() => {
        map?.resize();
    }, 0);
});

let currentCategory: CategoryData;

onMounted(() => {
    initMap();
    setActionsInView();
    if (!mapRef?.value) return;
    resizeObserver?.observe(mapRef?.value!);
});

onUnmounted(() => {
    map.remove();
    if (!mapRef?.value) return;
    resizeObserver?.unobserve(mapRef?.value!);
});

function initMap(): void {
    const bounds = new URLSearchParams(window.location.search)
        .get("map")
        ?.split(",");

    const mapConfig = {
        container: mapRef.value!,
        attributionControl: false,
        style: `https://tiles.locationiq.com/v3/light/vector.json?key=${props.apiKey}`,
        trackResize: false, // Automatical resizing leads to flickering
    } as any;

    if (bounds) {
        mapConfig.bounds = [
            [parseFloat(bounds[0]), parseFloat(bounds[1])],
            [parseFloat(bounds[2]), parseFloat(bounds[3])],
        ];
    } else {
        mapConfig.center = [14.95, 50.02];
    }

    map = new maplibregl.Map(mapConfig);
    addImages();
    addControls();
    map.on("load", () => {
        addSourceAndLayers();
        addListeners();
    });
    toggleFocusedAction(props.focusedAction);
}

function addControls(): void {
    addNavigationControl();
    addGeolocateControl();
}

function addNavigationControl(): void {
    map.addControl(
        new maplibregl.NavigationControl({
            showCompass: false,
            showZoom: true,
            visualizePitch: false,
        }),
        "top-right"
    );
}

function addGeolocateControl(): void {
    map.addControl(
        new maplibregl.GeolocateControl({
            positionOptions: undefined,
            fitBoundsOptions: undefined,
            trackUserLocation: true,
            showAccuracyCircle: true,
            showUserLocation: true,
        }),
        "top-right"
    );
}

function addImages(): void {
    props.categories.forEach((category) => {
        map.loadImage(
            `/assets/icons/map/${category.slug}.png`,
            (error, image) => {
                if (error) throw error;
                map.addImage(category.slug, image as ImageBitmap);
            }
        );
    });
}

function addSourceAndLayers(): void {
    map.addSource("actions", {
        type: "geojson",
        // TODO: what happens when internet is slow and geoData is not yet loaded?
        // does this have to be reactive?
        data: createGeoJson(props.geoData),
        cluster: true,
        clusterMaxZoom: 14,
        clusterRadius: 40,
    });

    map.addLayer({
        id: "clusters",
        type: "circle",
        source: "actions",
        filter: ["has", "point_count"],
        paint: {
            // Use step expressions (https://maplibre.org/maplibre-style-spec/#expressions-step)
            // with three steps to implement three types of circles:
            //   * Blue, 20px circles when point count is less than 100
            //   * Yellow, 30px circles when point count is between 100 and 750
            //   * Pink, 40px circles when point count is greater than or equal to 750
            "circle-color": [
                "step",
                ["get", "point_count"],
                "#1947E5",
                100,
                "#1947E5",
                750,
                "#1947E5",
            ],
            "circle-radius": [
                "step",
                ["get", "point_count"],
                20, // default size
                100, // next step
                30, // next size
                750, // next step
                40, // next size
            ],
            "circle-stroke-width": 12,
            "circle-stroke-color": "hsl(216 100% 71%)",
        },
    });

    map.addLayer({
        id: "cluster-count",
        type: "symbol",
        source: "actions",
        filter: ["has", "point_count"],
        layout: {
            "text-field": "{point_count_abbreviated}",
            "text-font": ["Nunito"],
            "text-size": 16,
        },
        paint: {
            "text-color": "#ffffff",
        },
    });

    props.categories.forEach((category) => {
        map.addLayer({
            id: category.name,
            type: "symbol",
            source: "actions",
            filter: [
                "all",
                ["==", ["get", "category"], category.id],
                ["!", ["has", "point_count"]],
            ],
            layout: {
                "icon-image": category.slug,
                "icon-size": 0.5,
                "icon-allow-overlap": true,
                "icon-anchor": "bottom",
            },
        });
    });
}

function addListeners(): void {
    map.on("click", "clusters", (e) => {
        const features = map.queryRenderedFeatures(e.point, {
            layers: ["clusters"],
        });
        const clusterId = features[0].properties.cluster_id;
        (map.getSource("actions") as GeoJSONSource).getClusterExpansionZoom(
            clusterId,
            (err, zoom) => {
                if (err) return;
                const geometry = features[0].geometry;
                let coordinates;

                if (geometry.type === "Point") {
                    coordinates = {
                        lng: geometry.coordinates[0],
                        lat: geometry.coordinates[1],
                    };
                }
                map.easeTo({
                    center: coordinates,
                    zoom: zoom as number,
                });
            }
        );
    });

    map.on("mouseenter", "clusters", () => {
        map.getCanvas().style.cursor = "pointer";
    });
    map.on("mouseleave", "clusters", () => {
        map.getCanvas().style.cursor = "";
    });

    props.categories.forEach((category) => {
        map.on("click", category.name, (e) => {
            const id = e.features![0].properties?.id;
            emit("actionSelected", id);
        });

        map.on("mouseenter", category.name, () => {
            map.getCanvas().style.cursor = "pointer";
        });

        map.on("mouseleave", category.name, () => {
            map.getCanvas().style.cursor = "";
        });
    });

    // when the map moves, update the visible actions
    map.on("moveend", () => {
        useThrottleFn(() => {
            setActionsInView();
        }, 200)();
    });
}

function createGeoJson(
    geoData: ActionsJsonData[],
    categoryFilter?: number
): GeoJSON.GeoJSON {
    return {
        type: "FeatureCollection",
        features: geoData
            .filter((elem) => {
                if (categoryFilter) return elem.ca === categoryFilter;
                return true;
            })
            .map((action) => {
                return {
                    type: "Feature",
                    properties: {
                        id: action.id,
                        category: action.ca,
                    },
                    geometry: {
                        type: "Point",
                        coordinates: [action.ln, action.la],
                    },
                };
            }),
    };
}

function setActionsInView(): void {
    const mapBounds = getMapBoundsAsString();
    const mapCenter = map.getCenter();
    if (actionIsFocused) return;
    emit("mapChanged", { bounds: mapBounds, center: mapCenter });
}

function getMapBoundsAsString(): string {
    const bounds = map.getBounds();
    return [
        bounds.getNorthEast().lng.toFixed(5),
        bounds.getNorthEast().lat.toFixed(5),
        bounds.getSouthWest().lng.toFixed(5),
        bounds.getSouthWest().lat.toFixed(5),
    ].join(",");
}

function flyToLocation(location: PlacesData): void {
    map.flyTo({
        center: [location.ln, location.la],
        zoom: 14,
        essential: true,
    });
}
function handleCategoryChange(selectedCategory: CategoryData): void {
    if (selectedCategory.name !== "empty") {
        currentCategory = selectedCategory;
    }
    updateSource(selectedCategory.id);
    hideLayers(selectedCategory);
    emit("categoryChanged", selectedCategory.id);
}

function updateSource(selectedCategoryId: number): void {
    const newSource = createGeoJson(props.geoData, selectedCategoryId);
    (map.getSource("actions") as GeoJSONSource).setData(newSource);
}

// TODO: check if this is still needed
function hideLayers(selectedCategory: CategoryData): void {
    props.categories.forEach((category) => {
        if (
            category.name === selectedCategory.name ||
            selectedCategory.id === 0
        ) {
            map.setLayoutProperty(category.name, "visibility", "visible");
        } else {
            map.setLayoutProperty(category.name, "visibility", "none");
        }
    });
}

// watch for changes in categories prop and update the map accordingly
watch(
    () => props.formActive,
    (formActive) => {
        console.log("categories changed");
        // hide layers if categories are empty
        if (formActive) {
            updateSource(-1);
        } else {
            updateSource(currentCategory?.id || 0);
        }
    }
);

// watch for focused action and update the map accordingly if an action is focused
watch(
    () => props.focusedAction,
    (focusedAction) => {
        toggleFocusedAction(focusedAction);
    }
);

async function toggleFocusedAction(focusedAction: ActionData | undefined) {
    if (focusedAction) {
        console.log("focused action changed");
        actionIsFocused = true;
        await map.flyTo(
            {
                center: [focusedAction.lng, focusedAction.lat],
                zoom: 10,
                essential: true,
            },
            { focusedAction: true }
        );
        setActionsOpacity(focusedAction.id);

        map.on("move", (event) => {
            if (!event.focusedAction) {
                /**
                 * When an action was focused and something moves, we want switch to "index view"
                 */
                if (!actionIsFocused) return;
                console.log("reset focused action");
                actionIsFocused = false;
                setActionsInView();
                setActionsOpacity();
            }
        });
    }
}
// makes all actions except the one with the given id half transparent
function setActionsOpacity(idToExclude?: number): void {
    if (idToExclude) {
        props.categories.forEach((category) => {
            map.setPaintProperty(category.name, "icon-opacity", [
                "case",
                ["==", ["get", "id"], idToExclude],
                1, // Opacity for the element you want to exclude
                0.5, // Opacity for all other elements
            ]);
        });
    } else {
        props.categories.forEach((category) => {
            map.setPaintProperty(category.name, "icon-opacity", 1);
        });
    }
}
</script>

<template>
    <div class="absolute left-0 right-0 top-12 z-40 w-full">
        <div class="mx-auto flex justify-center">
            <div class="flex justify-center bg-black">
                <div class="flex -translate-x-1 -translate-y-1">
                    <div
                        class="flex h-full w-12 items-center justify-center border border-r-0 border-black bg-primary-600"
                    >
                        <SearchIcon class="h-5 w-5 text-white"></SearchIcon>
                    </div>
                    <SearchAutoComplete
                        ref="searchAutoCompleteRef"
                        id="location-search"
                        @place-changed="flyToLocation"
                        :api-key="props.apiKey"
                    ></SearchAutoComplete>
                    <!-- TODO add search filter: content / location -->
                    <SearchCategoryFilter
                        v-if="!formActive"
                        @category-changed="handleCategoryChange"
                        :categories="props.categories"
                    ></SearchCategoryFilter>
                </div>
            </div>
        </div>
    </div>
    <div ref="mapRef" class="h-full w-full"></div>
</template>

<style>
.maplibregl-ctrl-group .maplibregl-ctrl-zoom-in,
.maplibregl-ctrl-group .maplibregl-ctrl-zoom-out {
    display: none;
}

@media (min-width: 1024px) {
    .maplibregl-ctrl-group .maplibregl-ctrl-zoom-in,
    .maplibregl-ctrl-group .maplibregl-ctrl-zoom-out {
        display: block;
    }
}
</style>
