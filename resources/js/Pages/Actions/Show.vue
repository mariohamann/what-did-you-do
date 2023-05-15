<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import ActionInteractions from "@/Components/ActionInteractions.vue";
import ActionCategory from "@/Components/ActionCategory.vue";
import ActionAncestors from "@/Components/ActionAncestors.vue";

// It should be possible to remove this import as soon as https://github.com/vuejs/core/issues/4294 is completely done in Vue 3.3.0, but currently it is still needed.
import type { ActionData } from "@/types/generated.d.ts";

defineProps<ActionData>();
</script>

<template>
    <Head :title="description" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Action
            </h2>
        </template>
        <section class="overflow-hidden bg-gray-50 py-12 md:py-20 lg:py-24">
            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <svg
                    class="absolute right-full top-full -translate-y-1/4 translate-x-1/3 transform lg:translate-x-1/2 xl:-translate-y-1/2"
                    width="404"
                    height="404"
                    fill="none"
                    viewBox="0 0 404 404"
                    role="img"
                    aria-labelledby="svg-workcation"
                >
                    <defs>
                        <pattern
                            id="ad119f34-7694-4c31-947f-5c9d249b21f3"
                            x="0"
                            y="0"
                            width="20"
                            height="20"
                            patternUnits="userSpaceOnUse"
                        >
                            <rect
                                x="0"
                                y="0"
                                width="4"
                                height="4"
                                class="text-gray-200"
                                fill="currentColor"
                            />
                        </pattern>
                    </defs>
                    <rect
                        width="404"
                        height="404"
                        fill="url(#ad119f34-7694-4c31-947f-5c9d249b21f3)"
                    />
                </svg>

                <div class="relative">
                    <blockquote class="mt-10">
                        <div
                            class="mx-auto max-w-3xl text-center text-2xl font-medium leading-9 text-gray-900"
                        >
                            <p>&ldquo;{{ description }}&rdquo;</p>
                        </div>
                        <footer class="mt-8">
                            <div
                                class="md:flex md:items-center md:justify-center"
                            >
                                <div
                                    class="mt-3 text-center md:ml-4 md:mt-0 md:flex md:items-center"
                                >
                                    <div
                                        class="text-base font-medium text-gray-900"
                                    >
                                        {{ user.name }}
                                    </div>

                                    <svg
                                        class="mx-1 hidden h-5 w-5 text-indigo-600 md:block"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path d="M11 0h3L9 20H6l5-20z" />
                                    </svg>

                                    <div
                                        class="text-base font-medium text-gray-500"
                                    >
                                        {{ created_at }}
                                    </div>
                                </div>

                                <svg
                                    class="mx-1 hidden h-5 w-5 text-indigo-600 md:block"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path d="M11 0h3L9 20H6l5-20z" />
                                </svg>

                                <div
                                    class="text-base font-medium text-gray-500"
                                >
                                    <ActionCategory v-bind="category" />
                                </div>
                            </div>
                            <div
                                class="mt-12 justify-center gap-3 text-center md:flex md:items-center"
                            >
                                <ActionInteractions v-bind="$props" />
                            </div>
                        </footer>
                    </blockquote>
                </div>
            </div>
            <div v-if="ancestors.length > 0" class="mx-auto mt-24 max-w-md">
                <ActionAncestors v-bind="$props" />
            </div>
        </section>
    </AuthenticatedLayout>
</template>
