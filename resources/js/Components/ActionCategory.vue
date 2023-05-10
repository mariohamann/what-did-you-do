<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

import type { CategoryData } from "../types/generated.d.ts";

const props = defineProps<CategoryData>();
</script>

<template>
    <span
        class="mr-2 rounded border border-gray-200 bg-gray-50 px-2.5 py-0.5 text-sm font-medium text-gray-900"
    >
        {{ emoji }} {{ name }}
    </span>
</template>
