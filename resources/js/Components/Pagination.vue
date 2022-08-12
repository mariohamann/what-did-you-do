<script setup lang="ts">
import { Link } from "@inertiajs/inertia-vue3";
import { usePage } from "@inertiajs/inertia-vue3";
import { computed } from "vue";

const pagination = computed(() =>(usePage().props.value as LaravelListProps).actions);

</script>
<template>
    <nav
        class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6"
        aria-label="Pagination"
    >
        <div class="hidden sm:block">
            <p class="text-sm text-gray-700">
                Showing
                <span v-if="pagination.total > 24">
                    <span class="font-medium">{{ pagination.from }}</span>
                    to
                    <span class="font-medium">{{ pagination.to }}</span>
                    of
                </span>
                <span class="font-medium">{{ pagination.total }}</span>
                results
            </p>
        </div>
        <div class="flex flex-1 justify-between sm:justify-end">
            <Link
                v-if="pagination.prev_page_url"
                :href="pagination.prev_page_url"
                class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Previous
            </Link>
            <Link
                v-if="pagination.next_page_url"
                :href="pagination.next_page_url"
                class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Next
            </Link>
        </div>
    </nav>
</template>
