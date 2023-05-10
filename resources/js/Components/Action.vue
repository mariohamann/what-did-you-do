<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import ActionInteractions from "@/Components/ActionInteractions.vue";
import ActionCategory from "@/Components/ActionCategory.vue";

import type { ActionData } from "../types/generated.d.ts";

const props = defineProps<{
    action: ActionData;
}>();
</script>

<template>
    <tr :class="action.archived_at ? 'bg-red-200' : ''">
        <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
            <Link
                class="underline decoration-gray-300 underline-offset-2 hover:decoration-indigo-300"
                :href="`/actions/${action.id}`"
            >
                {{ action.description }}
            </Link>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <ActionCategory v-bind="action.category" />
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            {{ action.user.name }}
        </td>
        <td
            class="flex gap-4 whitespace-nowrap px-3 py-4 text-sm text-gray-500"
        >
            <ActionInteractions v-bind="action" />
        </td>
    </tr>
</template>
