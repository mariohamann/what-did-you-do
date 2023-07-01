<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import ActionInteractions from "@/Components/ActionInteractions.vue";

import type { ActionData } from "@/types/generated.d.ts";

let props = defineProps<ActionData>();
</script>

<template>
    <section class="rounded-md bg-black">
        <div
            class="relative rounded-md border border-black bg-white p-5 transition-all focus-within:-translate-x-2 focus-within:-translate-y-2 hover:-translate-x-2 hover:-translate-y-2"
        >
            <Link :href="`/action/${id}`" class="z-0">
                <span class="absolute inset-0"></span>
                <h2
                    class="relative mb-8 text-xl font-medium leading-relaxed decoration-white underline-offset-2 hover:decoration-primary-600"
                >
                    <span
                        class="absolute -mt-0 h-8 w-8 rounded-full bg-gray-100 text-center text-sm leading-8"
                        >{{ category.emoji }}
                    </span>
                    <span class="inline-block w-10"> </span>
                    {{ description }}
                </h2></Link
            >
            <!-- <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            {{ user.name }}
        </td> -->
            <div
                class="pointer-events-none relative z-10 mt-4 flex flex-row-reverse items-center justify-between"
            >
                <div class="pointer-events-auto flex gap-2">
                    <ActionInteractions v-bind="$props" />
                </div>
                <p class="text-sm italic">by {{ user.name }}</p>
            </div>
        </div>
    </section>
</template>
