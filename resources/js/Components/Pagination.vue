<script setup>
import { Link } from '@inertiajs/inertia-vue3';
const props = defineProps({
    pagination: Object
}
)
</script>
<template>
    <nav class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6"
        aria-label="Pagination">
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
        <div class="flex-1 flex justify-between sm:justify-end">
            <Link v-if="pagination.prev_page_url" :href="pagination.prev_page_url"
                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            Previous </Link>
            <Link v-if="pagination.next_page_url" :href="pagination.next_page_url"
                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            Next </Link>
        </div>
    </nav>
</template>
