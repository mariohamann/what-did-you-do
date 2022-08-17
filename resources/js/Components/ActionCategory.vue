
<script setup lang="ts">
import { usePage } from "@inertiajs/inertia-vue3";
import { computed } from "vue";

const props = defineProps({
    category_id: {
        type: Object as () => Action['category_id'],
        required: true,
    },
});

/*
The category could be provided by the backend, too.
For now, we'll just calculate it on the client to reduce load on the database.
*/
const categories = usePage().props.value.categories as Category[];

const category = computed(() =>
    categories.find(
        (category) => category.id === props.category_id
    ) as Category
);
</script>

<template>
    <span
        class="mr-2 rounded border border-gray-200 bg-gray-50 px-2.5 py-0.5 text-sm font-medium text-gray-900"
    >
        {{ category.emoji }} {{ category.name }}
    </span>
</template>
