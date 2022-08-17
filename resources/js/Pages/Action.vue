<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import ActionInteractions from "@/Components/ActionInteractions.vue";
import ActionCategory from "@/Components/ActionCategory.vue";

defineProps({ action: {type: Object as () => Action, required: true} });
</script>

<template>
    <AppLayout title="List">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ $page.props.title }}
            </h2>
        </template>

        <section class="py-12 bg-gray-50 overflow-hidden md:py-20 lg:py-24">
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <svg class="absolute top-full right-full transform translate-x-1/3 -translate-y-1/4 lg:translate-x-1/2 xl:-translate-y-1/2" width="404" height="404" fill="none" viewBox="0 0 404 404" role="img" aria-labelledby="svg-workcation">
                <defs>
                    <pattern id="ad119f34-7694-4c31-947f-5c9d249b21f3" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                    <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                    </pattern>
                </defs>
                <rect width="404" height="404" fill="url(#ad119f34-7694-4c31-947f-5c9d249b21f3)" />
                </svg>

                <div class="relative">
                <blockquote class="mt-10">
                    <div class="max-w-3xl mx-auto text-center text-2xl leading-9 font-medium text-gray-900">
                    <p>&ldquo;{{ action.description }}&rdquo;</p>
                    </div>
                    <footer class="mt-8">
                    <div class="md:flex md:items-center md:justify-center">
                        <div class="mt-3 text-center md:mt-0 md:ml-4 md:flex md:items-center">
                        <div class="text-base font-medium text-gray-900">{{ action.user.name }}</div>

                        <svg class="hidden md:block mx-1 h-5 w-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M11 0h3L9 20H6l5-20z" />
                        </svg>

                        <div class="text-base font-medium text-gray-500">{{ action.created_at }}</div>
                        </div>

                        <svg class="hidden md:block mx-1 h-5 w-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M11 0h3L9 20H6l5-20z" />
                        </svg>

                        <div class="text-base font-medium text-gray-500">
                            <ActionCategory :category_id="action.category_id" />
                        </div>

                    </div>
                    <div class="mt-12 text-center md:flex md:items-center justify-center gap-3">
                        <ActionInteractions :action="action" />
                    </div>
                    </footer>
                </blockquote>
                </div>
            </div>
            </section>
    </AppLayout>
</template>
