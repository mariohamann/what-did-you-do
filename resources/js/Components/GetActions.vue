<template>
    <button
        class="rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-700"
        @click="fetchRandomActions"
    >
        Fetch Random Actions
    </button>
</template>

<script setup lang="ts">
import { router } from "@inertiajs/vue3";

const MAX_IDS = 300;
const NUM_IDS = 5; // Number of random IDs to fetch, adjust as needed

const fetchRandomActions = () => {
    const ids = Array.from({ length: NUM_IDS }, () =>
        Math.floor(Math.random() * MAX_IDS)
    );

    router.get("/index", { ids }, { replace: true });
};
</script>
