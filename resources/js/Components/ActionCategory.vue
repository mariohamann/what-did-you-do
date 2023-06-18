<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

import type { CategoryData } from "@/types/generated.d.ts";

const props = defineProps<CategoryData>();
</script>

<template>
    <span
        class="pointer-events-none select-none text-sm font-medium text-gray-900"
    >
        {{ emoji }} {{ name }}
    </span>
</template>
