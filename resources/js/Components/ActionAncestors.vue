<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <h2 class="mb-6 text-lg">Inspired by:</h2>
    <div class="flow-root">
        <ul role="list" class="-mb-8">
            <li
                v-for="(ancestor, index) in action.ancestors?.slice().reverse()"
                :key="ancestor.id"
            >
                <div class="relative pb-8">
                    <span
                        v-if="index !== action.ancestors?.length - 1"
                        class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200"
                        aria-hidden="true"
                    />
                    <div class="relative flex space-x-3">
                        <div>
                            <span
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-500 ring-8 ring-white"
                            >
                            </span>
                        </div>
                        <div
                            v-if="ancestor.created_at"
                            class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5"
                        >
                            <div>
                                <p class="text-sm text-gray-500">
                                    <a
                                        :href="`/actions/${ancestor.id}`"
                                        class="font-medium text-gray-900"
                                        >{{ ancestor.description }}<br />
                                        <i class="mt-3 text-gray-400"
                                            >by {{ ancestor.user.name }}</i
                                        ></a
                                    >
                                </p>
                            </div>
                            <div
                                class="whitespace-nowrap text-right text-sm text-gray-500"
                            >
                                <time>{{ ancestor.created_at }}</time>
                            </div>
                        </div>
                        <div v-else class="pt-1.5 text-sm italic text-gray-500">
                            Deleted action.
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup lang="ts">
defineProps({ action: { type: Object as () => Action, required: true } });
</script>
l
