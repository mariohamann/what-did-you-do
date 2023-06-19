<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { usePage, Head, useForm } from "@inertiajs/vue3";
import Action from "@/Components/Action.vue";
import CreateAction from "@/Components/CreateAction.vue";
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
                    <div
                        class="pointer-events-none fixed bottom-12 left-0 z-40 w-full xl:pl-96"
                    >
                        <div class="mx-auto flex justify-center">
                            <form
                                class="pointer-events-auto flex gap-3 rounded-[20px] border-black bg-secondary-300 p-3 shadow-sm shadow-secondary-100/10"
                                action="#"
                                method="GET"
                            >
                                <div class="">
                                    <div class="relative rounded-md">
                                        <label for="q" class="sr-only"
                                            >Search value</label
                                        >
                                        <input
                                            autofocus
                                            type="text"
                                            name="q"
                                            id="q"
                                            class="block w-full rounded-xl border-0 py-3 pl-4 pr-20 text-gray-900 ring-1 ring-inset ring-white placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6"
                                            placeholder="Search..."
                                        />
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center"
                                        >
                                            <label for="mode" class="sr-only"
                                                >Mode for Search</label
                                            >
                                            <select
                                                id="mode"
                                                name="mode"
                                                class="h-full rounded-xl border-0 bg-transparent py-0 pl-2 pr-7 text-gray-500 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm"
                                            >
                                                <option>Location</option>
                                                <option>Content</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="category" class="sr-only"
                                        >Mode for Search</label
                                    >
                                    <select
                                        id="category"
                                        name="category"
                                        class="block w-full rounded-xl border-0 py-3 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-white focus:ring-2 focus:ring-primary-600 sm:text-sm sm:leading-6"
                                    >
                                        <option selected>All Categories</option>
                                        <option
                                            v-for="category in categories"
                                            :key="category.id"
                                        >
                                            {{ category.name }}
                                        </option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
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
