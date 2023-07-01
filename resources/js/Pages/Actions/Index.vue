<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { usePage, Head, useForm } from "@inertiajs/vue3";
import Action from "@/Components/Action.vue";
import Map from "@/Components/Map.vue";
import { ref } from "vue";

// It should be possible to remove this import as soon as https://github.com/vuejs/core/issues/4294 is completely done in Vue 3.3.0, but currently it is still needed.
import type {
    ActionIndexData,
    ActionsJsonData,
    CategoryData,
} from "@/types/generated.d.ts";

const form = useForm({
    q: "",
});

let categories = usePage().props.categories as CategoryData[];

let props = defineProps<ActionIndexData>();

// amount of fetched elements from actions_json_url
let actionsFromJsonLength = ref(0);
// fetched data from actions_json_url
let geoJson = ref<ActionsJsonData[]>([]);

// fetch data from actions_json_url and make a console log of the length of the json (array)
// and set the geoJson ref to the fetched data
fetch(props.actions_json_url)
    .then((response) => response.json())
    .then((data: ActionsJsonData[]) => {
        actionsFromJsonLength.value = data.length;
        geoJson.value = data;
    });
</script>

<template>
    <Head title="Index" />

    <AuthenticatedLayout>
        <template #header> Index </template>

        <div class="">
            <main class="bg-secondary-300 lg:pl-20">
                <div class="relative h-screen w-full xl:pl-96">
                    <Map
                        api-key="pk.ed59a693277d463a0b1bda2317c16928"
                        :geo-data="geoJson"
                    ></Map>
                </div>
            </main>

            <aside
                class="fixed inset-y-0 left-20 hidden w-96 overflow-y-auto border-r border-gray-200 px-4 py-6 sm:px-6 lg:px-8 xl:block"
            >
                <!-- Fetched elements from actions_json_url:
                {{ actionsFromJsonLength }} -->
                <!-- <CreateAction v-bind="null" /> -->
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8"></div>
                <div class="flex w-full flex-col gap-4">
                    <Action
                        v-for="action in actions"
                        v-bind="action"
                        v-bind:key="action.id"
                    />
                </div>
            </aside>
        </div>
    </AuthenticatedLayout>
</template>
