<template>
    <div class="mx-auto max-w-md">
        <label for="search" class="block text-sm font-medium text-gray-700"
            >Quick search</label
        >
        <div class="relative mt-1 flex items-center">
            <input
                v-model="search"
                type="text"
                name="search"
                id="search"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            />
            <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5"></div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import debounce from "lodash/debounce";

let search = ref((usePage().props.value as LaravelListProps).filters.search);

watch(
    search,
    debounce(function (value) {
        Inertia.get(
            "/others",
            { search: value },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            }
        );
    }, 300)
);
</script>
