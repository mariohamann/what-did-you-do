<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import Doing from "@/Components/Doing.vue";
import Pagination from "../Components/Pagination.vue";

defineProps({ doings: Object });
</script>

<template>
    <AppLayout title="List">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ $page.props.title }}
            </h2>
        </template>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8"></div>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-4 justify-end sm:flex sm:items-center">
                    <div class="mt-4 sm:mt-0 sm:flex-none">
                        <button
                            type="button"
                            class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                        >
                            Add item
                        </button>
                    </div>
                </div>
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
                                                    Public
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="relative py-3.5 pl-3 pr-4 sm:pr-6"
                                                >
                                                    <span class="sr-only"
                                                        >Edit</span
                                                    >
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="divide-y divide-gray-200 bg-white"
                                        >
                                            <Doing
                                                v-for="doing in doings.data"
                                                :doing="doing"
                                                :categories="
                                                    $page.props.categories
                                                "
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
