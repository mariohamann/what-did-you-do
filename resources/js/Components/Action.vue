<script setup lang="ts">
import { usePage } from "@inertiajs/inertia-vue3";
import { computed } from "vue";
import { Link } from '@inertiajs/inertia-vue3'
import ActionInteractions from "@/Components/ActionInteractions.vue";
import ActionCategory from "@/Components/ActionCategory.vue";

const props = defineProps({
    action: {
        type: Object as () => Action,
        required: true,
    },
});
</script>

<template>
    <tr :class="action.archived_at ? 'bg-red-200' : ''">
        <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
            <Link class="underline decoration-gray-300 underline-offset-2 hover:decoration-indigo-300" :href="`/action/${ action.id }`">
            {{ action.description }}
            </Link>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <ActionCategory :category_id="action.category_id" />
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            {{ action.user.name }}
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 flex gap-4">
            <ActionInteractions :action="action" />
        </td>
    </tr>
</template>
