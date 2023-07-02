<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import ActionInteractions from "@/Components/ActionInteractions.vue";

import type { ActionData } from "@/types/generated.d.ts";

let props = defineProps<ActionData>();
</script>

<template>
    <section class="bg-black">
        <div
            class="relative border border-black bg-white p-5 transition-all focus-within:-translate-x-2 focus-within:-translate-y-2 hover:-translate-x-2 hover:-translate-y-2"
        >
            <Link :href="`/action/${id}`" class="z-0">
                <span class="absolute inset-0"></span>
                <h2
                    class="relative mb-8 text-xl font-medium leading-relaxed decoration-white underline-offset-2 hover:decoration-primary-600"
                >
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
                <div class="flex items-center gap-5">
                    <span
                        class="flex items-center justify-center rounded-full text-lg leading-8"
                    >
                        <img
                            class="h-5 w-5"
                            style="font-size: 2rem"
                            :src="`/assets/icons/${category.slug}.svg`"
                        />
                    </span>
                    <p class="text-sm italic">by {{ user.name }}</p>
                </div>
            </div>
        </div>
    </section>
</template>
