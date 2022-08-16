<template>
    <div class="mx-auto max-w-md">
        <label for="search" class="block text-sm font-medium text-gray-700"
            >Quick search</label
        >
        <div class="relative mt-1 flex items-center">
            <input
                v-model="search"
                type="text"
                name="search"
                id="search"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            />
            <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5"></div>

            <Listbox
                as="div"
                v-model="selectedCategory"
                class="ml-4 flex-shrink-0"
            >
                <ListboxLabel class="sr-only"> Category </ListboxLabel>
                <div class="relative">
                    <ListboxButton
                        class="relative inline-flex items-center whitespace-nowrap rounded-full bg-gray-50 py-2 px-2 text-sm font-medium text-gray-500 hover:bg-gray-100 sm:px-3"
                    >
                        <TagIcon
                            v-if="selectedCategory.slug === null"
                            class="h-5 w-5 flex-shrink-0 text-gray-300 sm:-ml-1"
                            aria-hidden="true"
                        />

                        <span v-else>{{ selectedCategory.emoji }}</span>

                        <span
                            :class="[
                                selectedCategory.slug === null
                                    ? ''
                                    : 'text-gray-900',
                                'hidden truncate sm:ml-2 sm:block',
                            ]"
                            >{{
                                selectedCategory.slug === null
                                    ? "Category"
                                    : selectedCategory.name
                            }}</span
                        >
                    </ListboxButton>

                    <transition
                        leave-active-class="transition ease-in duration-100"
                        leave-from-class="opacity-100"
                        leave-to-class="opacity-0"
                    >
                        <ListboxOptions
                            class="absolute right-0 z-10 mt-1 max-h-56 w-52 overflow-auto rounded-lg bg-white py-3 text-base shadow ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                        >
                            <ListboxOption
                                as="template"
                                v-for="category in categories"
                                :key="category.slug"
                                :value="category"
                                v-slot="{ active }"
                            >
                                <li
                                    :class="[
                                        active ? 'bg-gray-100' : 'bg-white',
                                        'relative cursor-default select-none py-2 px-3',
                                    ]"
                                >
                                    <div class="flex items-center">
                                        <span> {{ category.emoji }}</span>
                                        <span
                                            class="ml-3 block truncate font-medium"
                                        >
                                            {{ category.name }}
                                        </span>
                                    </div>
                                </li>
                            </ListboxOption>
                        </ListboxOptions>
                    </transition>
                </div>
            </Listbox>
        </div>
            <div class="flex items-center">
                <input v-model="showArchived" id="archived" name="archived" value="archived" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                <label for="archived" class="ml-3 text-sm text-gray-600">
                    Show Archived
                </label>
            </div>
    </div>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import debounce from "lodash/debounce";

import {
    Listbox,
    ListboxButton,
    ListboxLabel,
    ListboxOption,
    ListboxOptions,
} from "@headlessui/vue";
import { TagIcon } from "@heroicons/vue/solid";

const laraveListProps = usePage().props.value as LaravelListProps;

let search = ref(laraveListProps.filters.search);

const categories = [
    { name: "Select category", id: null, slug: null, emoji: null },
    ...laraveListProps.categories as Category[],
];

const selectedCategory = ref(
    categories.find((category) => category.slug === laraveListProps.filters.category) || (categories[0] as Category)
);

const showArchived = ref( false );

const sendRequest = () => {
    Inertia.get(
        laraveListProps.me ? "/me" : "/others",
        {
            ...(search.value && { search: search.value }),
            ...(selectedCategory.value.slug && {
                category: (selectedCategory.value as Category).slug,
            }),
            ...(showArchived.value && {archived: showArchived.value}),
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
};

watch(
    [search],
    debounce(function (value) {
        sendRequest();
    }, 300)
);

watch([selectedCategory, showArchived], () => sendRequest());
</script>
