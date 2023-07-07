<script setup lang="ts">
import { ActionsJsonData, CategoryData } from "@/types/generated";
import maplibregl from "maplibre-gl";
import "maplibre-gl/dist/maplibre-gl.css";
import SearchAutoComplete, {
    PlacesData,
} from "@/Components/SearchAutoComplete.vue";
import SearchCategoryFilter from "@/Components/SearchCategoryFilter.vue";
import { onMounted, onUnmounted, ref } from "vue";

interface GeoJSON {
    type: string;
    features: {
        type: string;
        properties: {
            id: number;
            category: number;
        };
        geometry: {
            type: string;
            coordinates: number[];
        };
    }[];
}

const props = defineProps<{
    apiKey: string;
    geoData: ActionsJsonData[];
    categories: CategoryData[];
}>();

const emit = defineEmits(["mapChanged", "categoryChanged"]);

let map: maplibregl.Map;
const mapCanvas = ref<HTMLElement>();

onMounted(() => {
    initMap();
    setActionsInView();
});

onUnmounted(() => {
    map.remove();
});

function initMap(): void {
    map = new maplibregl.Map({
        container: mapCanvas.value!,
        attributionControl: false,
        style: `https://tiles.locationiq.com/v3/light/vector.json?key=${props.apiKey}`,
        center: [14.95, 50.02],
        zoom: 3,
    });
    addControls();
    map.on("load", () => {
        addImages();
        addSourceAndLayers();
        addListeners();
    });
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
            `./assets/icons/map/${category.slug}.png`,
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
        clusterRadius: 50,
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
            },
        });
    });
}

function addListeners(): void {
    // inspect a cluster on click
    map.on("click", "clusters", (e) => {
        const features = map.queryRenderedFeatures(e.point, {
            layers: ["clusters"],
        });
        const clusterId = features[0].properties.cluster_id;
        // TODO: fix types
        // @ts-ignore
        map.getSource("actions")?.getClusterExpansionZoom(
            clusterId,
            // @ts-ignore
            (err, zoom) => {
                if (err) return;

                map.easeTo({
                    // TODO: fix types
                    // @ts-ignore
                    center: features[0].geometry.coordinates,
                    zoom: zoom,
                });
            }
        );
    });

    // when clicking an unclustered point, highlight the action
    map.on("click", "unclustered-point", (e) => {
        if (e.features) {
            const ids: number[] = [e.features[0].properties?.id];
            // TODO highlight the action
        }
    });

    // when the map moves, update the visible actions
    map.on("moveend", () => {
        setActionsInView();
    });

    map.on("mouseenter", "clusters", () => {
        map.getCanvas().style.cursor = "pointer";
    });
    map.on("mouseleave", "clusters", () => {
        map.getCanvas().style.cursor = "";
    });
}

function createGeoJson(
    geoData: ActionsJsonData[],
    categoryFilter?: number
): GeoJSON {
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
    updateSource(selectedCategory);
    hideLayers(selectedCategory);
    emit("categoryChanged", selectedCategory.id);
}

function updateSource(selectedCategory: CategoryData): void {
    const newSource = createGeoJson(props.geoData, selectedCategory.id);
    // TODO: check why types don't match
    // @ts-ignore
    map.getSource("actions")?.setData(newSource);
}

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
</script>

<template>
    <div class="absolute left-0 right-0 top-12 z-40 w-full">
        <div class="mx-auto flex justify-center">
            <SearchAutoComplete
                @place-changed="flyToLocation"
                :api-key="props.apiKey"
            ></SearchAutoComplete>
            <!-- TODO add search filter: content / location -->
            <SearchCategoryFilter
                @category-changed="handleCategoryChange"
                :categories="props.categories"
            ></SearchCategoryFilter>
        </div>
    </div>
    <div ref="mapCanvas" class="h-full w-full"></div>
</template>
