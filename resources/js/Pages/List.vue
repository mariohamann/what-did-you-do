<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import Doing from "@/Components/Doing.vue";
import CreateDoing from "@/Components/CreateDoing.vue";
import Pagination from "../Components/Pagination.vue";

defineProps({ doings: Object, me: Boolean });
</script>

<template>
    <AppLayout title="List">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ $page.props.title }}
            </h2>
        </template>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8"></div>

        <CreateDoing v-if="me" />

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="flex flex-col">
                        <div
                            class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8"
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
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="divide-y divide-gray-200 bg-white"
                                        >
                                            <Doing
                                                v-for="doing in (doings.data as Doing[])"
                                                :doing="doing"
                                                v-bind:key="doing.id"
                                            />
                                        </tbody>
                                    </table>
                                    <Pagination :pagination="doings" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
