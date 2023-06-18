<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import ActionInteractions from "@/Components/ActionInteractions.vue";
import ActionCategory from "@/Components/ActionCategory.vue";

import type { ActionData } from "@/types/generated.d.ts";

let props = defineProps<ActionData>();

console.log(props.lng, props.lat);
</script>

<template>
    <section class="rounded-lg bg-black">
        <div
            class="relative rounded-lg bg-white p-5 transition-all focus-within:-translate-x-2 focus-within:-translate-y-2 hover:-translate-x-2 hover:-translate-y-2"
        >
            <Link :href="`/action/${id}`" class="z-0">
                <span class="absolute inset-0"></span>
                <h2
                    class="mb-8 text-xl font-medium decoration-white underline-offset-2 hover:decoration-primary-600"
                >
                    {{ description }}
                </h2></Link
            >
            <!-- <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            {{ user.name }}
        </td> -->
            <div
                class="pointer-events-none relative z-10 mt-4 flex items-center justify-between"
            >
                <div class="pointer-events-auto flex gap-2">
                    <ActionInteractions v-bind="$props" />
                </div>
                <ActionCategory v-bind="category" />
            </div>
        </div>
    </section>
</template>
