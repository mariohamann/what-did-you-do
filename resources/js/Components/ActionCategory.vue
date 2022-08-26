
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
        class="mr-2 rounded-full bg-[#E6F1FC] px-3 py-1 text-sm font-medium text-[#6B8AC7]"
    >
        {{ category.emoji }} {{ category.name }}
    </span>
</template>
