<script setup lang="ts">
import Switch from "@/Components/Switch.vue";
import { usePage } from "@inertiajs/inertia-vue3";
const props = defineProps({
    doing: {
        type: Object as () => Doing,
        required: true,
    },
});

/*
The category could be provided by the backend, too.
For now, we'll just calculate it on the client to reduce load on the database.
*/

const calculateCategory = () => {
    const categories = [...(usePage().props.value.categories as Category[])];
    return categories.find(
        (category) => category.id === props.doing.category_id
    ) as Category;
};

const category = calculateCategory();
</script>

<template>
    <tr>
        <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
            {{ doing.content }}
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <span
                class="mr-2 rounded border border-gray-200 bg-gray-50 px-2.5 py-0.5 text-sm font-medium text-gray-900"
            >
                {{ category.emoji }} {{ category.name }}
            </span>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            {{ doing.user.name }}
        </td>
    </tr>
</template>
