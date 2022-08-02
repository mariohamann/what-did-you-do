<script setup>
import Switch from '@/Components/Switch.vue';
const props = defineProps({
    doing: Object
}
)
</script>

<template>
    <tr>
        <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
            {{ doing.content }}
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <span class="bg-pink-100 text-pink-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">
                TBD
            </span>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <Switch />
        </td>
        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit<span class="sr-only">, Lindsay
                    Walton</span></a>
        </td>
    </tr>
</template>

