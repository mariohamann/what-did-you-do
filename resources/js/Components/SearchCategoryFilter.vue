<script setup lang="ts">
import { ref, computed } from "vue";
import {
    Listbox,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
} from "@headlessui/vue";
import { CheckIcon, ChevronDownIcon } from "@heroicons/vue/solid";
import { CategoryData } from "@/types/generated";

// TODO add types
const emit = defineEmits(["categoryChanged"]);

const props = defineProps<{
    categories: CategoryData[];
}>();

const updatedCategories = computed(() => {
    return [
        {
            id: 0,
            name: "All categories",
            slug: "all",
        },
        ...props.categories,
    ];
});

const selectedCategory = ref(updatedCategories.value[0]);
</script>

<template>
    <Listbox
        class="w-48 border border-l-0 border-solid border-black"
        v-model="selectedCategory"
        @update:model-value="(value) => emit('categoryChanged', value)"
    >
        <div class="relative">
            <ListboxButton
                class="relative h-full w-full cursor-default bg-white py-2 pl-3 pr-10 text-left"
            >
                <div class="flex items-center gap-2">
                    <img
                        v-if="selectedCategory.slug !== 'all'"
                        class="h-4 w-5"
                        style="font-size: 2rem"
                        :src="`/assets/icons/${selectedCategory.slug}.svg`"
                    />
                    <span class="block truncate">{{
                        selectedCategory.name
                    }}</span>
                </div>
                <span
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
                >
                    <ChevronDownIcon
                        class="h-5 w-5 text-gray-400"
                        aria-hidden="true"
                    />
                </span>
            </ListboxButton>

            <transition
                leave-active-class="transition duration-100 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <ListboxOptions
                    class="absolute -mx-px mt-px w-[calc(100%+2px)] overflow-auto border border-black bg-white text-base shadow-hard"
                >
                    <ListboxOption
                        v-slot="{ active, selected }"
                        v-for="category in updatedCategories"
                        :key="category.id"
                        :value="category"
                        as="template"
                    >
                        <li
                            :class="[
                                active && 'bg-amber-100 text-gray-900',
                                'group relative cursor-default select-none py-3 pl-10 pr-4',
                            ]"
                        >
                            <div class="flex items-center gap-2">
                                <span
                                    :class="[
                                        selected
                                            ? 'font-medium'
                                            : 'font-normal',
                                        'block truncate',
                                    ]"
                                    >{{ category.name }}</span
                                >
                            </div>
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-900"
                            >
                                <CheckIcon
                                    v-if="selected"
                                    class="h-5 w-5"
                                    aria-hidden="true"
                                />
                                <span
                                    v-else-if="category.slug !== 'all'"
                                    class="w-5"
                                >
                                    <img
                                        class="h-4 w-4 opacity-50 transition-opacity group-hover:opacity-100"
                                        style="font-size: 2rem"
                                        :src="`/assets/icons/${category.slug}.svg`"
                                /></span>
                            </span>
                        </li>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>
