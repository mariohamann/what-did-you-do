<script setup lang="ts">
import { ActionsJsonData } from "@/types/generated";
import maplibregl from "maplibre-gl";
import "maplibre-gl/dist/maplibre-gl.css";
import { onMounted, onUnmounted, ref } from "vue";

const props = defineProps<{ apiKey: string; geoData: ActionsJsonData[] }>();

const el = ref();
let map = ref<maplibregl.Map>();

function createGeoJson(geoData: ActionsJsonData[]) {
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

onMounted(() => {
    map.value = new maplibregl.Map({
        container: el.value,
        attributionControl: false,
        style: `https://tiles.locationiq.com/v3/light/vector.json?key=${props.apiKey}`, // stylesheet location
        center: [-74.5, 40], // starting position [lng, lat]
        zoom: 12, // starting zoom
    })
        .addControl(
            new maplibregl.NavigationControl({
                showCompass: false,
                showZoom: true,
                visualizePitch: false,
            }),
            "top-right"
        )
        .addControl(
            new maplibregl.GeolocateControl({
                positionOptions: undefined,
                fitBoundsOptions: undefined,
                trackUserLocation: true,
                showAccuracyCircle: true,
                showUserLocation: true,
            }),
            "bottom-right"
        )
        .addControl(
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

    map.value.on("load", function () {
        // Add a new source from our GeoJSON data and
        // set the 'cluster' option to true. GL-JS will
        // add the point_count property to your source data.
        map.value?.addSource("earthquakes", {
            type: "geojson",
            // Point to GeoJSON data. This example visualizes all M1.0+ earthquakes
            // from 12/22/15 to 1/21/16 as logged by USGS' Earthquake hazards program.
            data: createGeoJson(props.geoData),
            cluster: true,
            clusterMaxZoom: 14, // Max zoom to cluster points on
            clusterRadius: 50, // Radius of each cluster when clustering points (defaults to 50)
        });

        map.value?.addLayer({
            id: "clusters",
            type: "circle",
            source: "earthquakes",
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

        map.value?.addLayer({
            id: "cluster-count",
            type: "symbol",
            source: "earthquakes",
            filter: ["has", "point_count"],
            layout: {
                "text-field": "{point_count_abbreviated}",
                "text-font": ["DIN Offc Pro Medium", "Arial Unicode MS Bold"],
                "text-size": 12,
            },
        });

        map.value?.addLayer({
            id: "unclustered-point",
            type: "circle",
            source: "earthquakes",
            filter: ["!", ["has", "point_count"]],
            paint: {
                "circle-color": "#11b4da",
                "circle-radius": 4,
                "circle-stroke-width": 1,
                "circle-stroke-color": "#fff",
            },
        });

        // inspect a cluster on click
        map.value?.on("click", "clusters", function (e) {
            var features = map.value?.queryRenderedFeatures(e.point, {
                layers: ["clusters"],
            });
            var clusterId = features[0].properties.cluster_id;
            map.value
                ?.getSource("earthquakes")
                .getClusterExpansionZoom(clusterId, function (err, zoom) {
                    if (err) return;

                    map.value?.easeTo({
                        center: features[0].geometry.coordinates,
                        zoom: zoom,
                    });
                });
        });

        // When a click event occurs on a feature in
        // the unclustered-point layer, open a popup at
        // the location of the feature, with
        // description HTML from its properties.
        map.value?.on("click", "unclustered-point", function (e) {
            var coordinates = e.features[0].geometry.coordinates.slice();
            var mag = e.features[0].properties.mag;
            var tsunami;

            if (e.features[0].properties.tsunami === 1) {
                tsunami = "yes";
            } else {
                tsunami = "no";
            }

            // Ensure that if the map is zoomed out such that
            // multiple copies of the feature are visible, the
            // popup appears over the copy being pointed to.
            while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
            }

            // new maplibregl.Popup()
            //   .setLngLat(coordinates)
            //   .setHTML(
            //     'magnitude: ' + mag + '<br>Was there a tsunami?: ' + tsunami
            //   )
            //   .addTo(map);
        });

        map.value?.on("mouseenter", "clusters", function () {
            // map.value?.getCanvas().style.cursor = 'pointer';
        });
        map.value?.on("mouseleave", "clusters", function () {
            // map.value?.getCanvas().style.cursor = '';
        });
    });
});

onUnmounted(() => {
    map.value?.remove();
});
</script>

<template>
    <div class="mx-auto mt-12 max-w-md">
        <p>map component with apiKey: {{ apiKey }}</p>
        <div ref="el" class="h-96"></div>
        <p>{{ JSON.stringify(geoData) }}</p>
    </div>
</template>
