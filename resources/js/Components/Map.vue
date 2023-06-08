<script setup lang="ts">
import { ActionsJsonData } from "@/types/generated";
import maplibregl from "maplibre-gl";
import "maplibre-gl/dist/maplibre-gl.css";
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

const props = defineProps<{ apiKey: string; geoData: ActionsJsonData[] }>();

const mapCanvas = ref<HTMLElement>();
let map = ref<maplibregl.Map>();

function createGeoJson(geoData: ActionsJsonData[]): GeoJSON {
    return {
        type: "FeatureCollection",
        features: geoData.map((action) => {
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

function initMap(): void {
    map.value = new maplibregl.Map({
        container: mapCanvas.value!,
        attributionControl: false,
        style: `https://tiles.locationiq.com/v3/light/vector.json?key=${props.apiKey}`, // stylesheet location
        center: [-74.5, 40], // starting position [lng, lat]
        zoom: 12, // starting zoom
    });
    addNavigationControl(map.value);
    addGeolocateControl(map.value);
    addAutoCompleteControl(map.value);
    addSourceAndLayers(map.value);
}

function addNavigationControl(map: maplibregl.Map): void {
    map.addControl(
        new maplibregl.NavigationControl({
            showCompass: false,
            showZoom: true,
            visualizePitch: false,
        }),
        "top-right"
    );
}

function addGeolocateControl(map: maplibregl.Map): void {
    map.addControl(
        new maplibregl.GeolocateControl({
            positionOptions: undefined,
            fitBoundsOptions: undefined,
            trackUserLocation: true,
            showAccuracyCircle: true,
            showUserLocation: true,
        }),
        "bottom-right"
    );
}

function addAutoCompleteControl(map: maplibregl.Map): void {
    map.addControl(
        // new MapbodxGeocder class is loaded via CDN in app.blade.php
        // @ts-ignore
        new MapboxGeocoder({
            accessToken: props.apiKey,
            mapboxgl: maplibregl,
            limit: 5,
            dedupe: 1,
            flyTo: {
                screenSpeed: 7,
                speed: 4,
            },
        }),
        "top-left"
    );
}

function addSourceAndLayers(map: maplibregl.Map): void {
    map.on("load", () => {
        // Add a new source from our GeoJSON data and
        // set the 'cluster' option to true. GL-JS will
        // add the point_count property to your source data.
        map.addSource("actions", {
            type: "geojson",
            data: createGeoJson(props.geoData),
            cluster: true,
            clusterMaxZoom: 14, // Max zoom to cluster points on
            clusterRadius: 50, // Radius of each cluster when clustering points (defaults to 50)
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
                    "#51bbd6",
                    100,
                    "#f1f075",
                    750,
                    "#f28cb1",
                ],
                "circle-radius": [
                    "step",
                    ["get", "point_count"],
                    20,
                    100,
                    30,
                    750,
                    40,
                ],
            },
        });

        map.addLayer({
            id: "cluster-count",
            type: "symbol",
            source: "actions",
            filter: ["has", "point_count"],
            layout: {
                "text-field": "{point_count_abbreviated}",
                "text-font": ["DIN Offc Pro Medium", "Arial Unicode MS Bold"],
                "text-size": 12,
            },
        });

        map.addLayer({
            id: "unclustered-point",
            type: "circle",
            source: "actions",
            filter: ["!", ["has", "point_count"]],
            paint: {
                "circle-color": "#11b4da",
                "circle-radius": 4,
                "circle-stroke-width": 1,
                "circle-stroke-color": "#fff",
            },
        });

        // inspect a cluster on click
        map.on("click", "clusters", (e) => {
            var features = map.queryRenderedFeatures(e.point, {
                layers: ["clusters"],
            });
            var clusterId = features[0].properties.cluster_id;
            // TODO: fix types
            // @ts-ignore
            map.getSource("actions")?.getClusterExpansionZoom(
                clusterId,
                function (err, zoom) {
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

        map.on("click", "unclustered-point", (e) => {
            console.log("SHOW ACTION IN LIST NEXT TO MAP", e);
        });

        map.on("mouseenter", "clusters", () => {
            map.getCanvas().style.cursor = "pointer";
        });
        map.on("mouseleave", "clusters", () => {
            map.getCanvas().style.cursor = "";
        });
    });
}

onMounted(() => {
    initMap();
});

onUnmounted(() => {
    map.value?.remove();
});
</script>

<template>
    <div class="mx-auto mt-12 grid w-full grid-cols-2 grid-rows-1 gap-8">
        <div ref="mapCanvas" class="aspect-square"></div>
        <div>
            <h2>actions</h2>
        </div>
    </div>
</template>
