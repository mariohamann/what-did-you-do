<script setup lang="ts">
import maplibregl from "maplibre-gl";
import "maplibre-gl/dist/maplibre-gl.css";
import { onMounted, onUnmounted, ref } from "vue";

const props = defineProps<{ apiKey: string }>();

const el = ref();
let map = ref<maplibregl.Map>();

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
        );

    // new MapbodxGeocder class is loaded via CDN in app.blade.php
    // @ts-ignore
    map.value.addControl(
        new MapboxGeocoder({
            accessToken: props.apiKey,
            mapboxgl: maplibregl,
            limit: 5,
            dedupe: 1,
            flyTo: {
                screenSpeed: 7,
                speed: 4,
            },
        }) as unknown as any,
        "top-left"
    );
});

onUnmounted(() => {
    map.value?.remove();
});
</script>

<template>
    <div class="mx-auto mt-12 max-w-md">
        <p>map component with apiKey: {{ apiKey }}</p>
        <div ref="el" class="h-96"></div>
    </div>
</template>
