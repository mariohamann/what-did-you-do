<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Action from "@/Components/Action.vue";
import CreateAction from "@/Components/CreateAction.vue";
import GetActions from "@/Components/GetActions.vue";
import Map from "@/Components/Map.vue";
import { ref } from "vue";

// It should be possible to remove this import as soon as https://github.com/vuejs/core/issues/4294 is completely done in Vue 3.3.0, but currently it is still needed.
import type { ActionIndexData, ActionsJsonData } from "@/types/generated.d.ts";

let props = defineProps<ActionIndexData>();

// amount of fetched elements from actions_json_url
let actionsFromJsonLength = ref(0);

// fetch data from actions_json_url and make a console log of the length of the json (array)
fetch(props.actions_json_url)
    .then((response) => response.json())
    .then(
        (data: ActionsJsonData[]) => (actionsFromJsonLength.value = data.length)
    );
</script>

<template>
    <Head title="Index" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Index
            </h2>
        </template>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <CreateAction v-bind="null" />
        </div>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <GetActions />
        </div>

        <div class="mx-auto mt-12 max-w-7xl sm:px-6 lg:px-8">
            Fetched elements from actions_json_url: {{ actionsFromJsonLength }}
        </div>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <Map apiKey="pk.ed59a693277d463a0b1bda2317c16928"></Map>
        </div>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="mt-8 overflow-hidden bg-white shadow-xl sm:rounded-lg"
                >
                    <div class="flex flex-col">
                        <div
                            class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8"
                        >
                            <div
                                class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8"
                            >
                                <div
                                    class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg"
                                >
                                    <table
                                        class="min-w-full divide-y divide-gray-300"
                                    >
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th
                                                    scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                                >
                                                    What did you do?
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Category
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    User
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Where
                                                </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="divide-y divide-gray-200 bg-white"
                                        >
                                            <Action
                                                v-for="action in actions"
                                                v-bind="action"
                                                v-bind:key="action.id"
                                            />
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
