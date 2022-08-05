<template>
    <form @submit.prevent="submit" class="relative mx-auto mt-12 max-w-md">
        <div
            class="overflow-hidden rounded-lg border border-gray-300 shadow-sm focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500"
        >
            <label for="description" class="sr-only">Content</label>
            <textarea
                v-model="form.description"
                rows="3"
                name="description"
                id="description"
                class="block w-full border-0 pb-0 pt-2.5 text-lg placeholder-gray-500 focus:ring-0"
                placeholder="Describe what you did..."
            />

            <!-- Spacer element to match the height of the toolbar -->
            <div aria-hidden="true">
                <div class="py-2">
                    <div class="h-9" />
                </div>
                <div class="py-2"></div>
            </div>
        </div>

        <div class="absolute inset-x-px bottom-0">
            <!-- Actions: These are just examples to demonstrate the concept, replace/wire these up however makes sense for your project. -->

            <div
                class="flex items-center justify-between space-x-3 border-t border-gray-200 px-2 py-2 sm:px-3"
            >
                <div
                    class="flex flex-nowrap justify-end space-x-2 py-2 px-2 sm:px-3"
                >
                    <Listbox
                        as="div"
                        v-model="categorized"
                        class="flex-shrink-0"
                    >
                        <ListboxLabel class="sr-only"> Category </ListboxLabel>
                        <div class="relative">
                            <ListboxButton
                                class="relative inline-flex items-center whitespace-nowrap rounded-full bg-gray-50 py-2 px-2 text-sm font-medium text-gray-500 hover:bg-gray-100 sm:px-3"
                            >
                                <TagIcon
                                    v-if="categorized.id === null"
                                    class="h-5 w-5 flex-shrink-0 text-gray-300 sm:-ml-1"
                                    aria-hidden="true"
                                />

                                <span v-else>{{ categorized.emoji }}</span>

                                <span
                                    :class="[
                                        categorized.id === null
                                            ? ''
                                            : 'text-gray-900',
                                        'hidden truncate sm:ml-2 sm:block',
                                    ]"
                                    >{{
                                        categorized.id === null
                                            ? "Category"
                                            : categorized.name
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
                                        :key="category.id"
                                        :value="category"
                                        v-slot="{ active }"
                                    >
                                        <li
                                            :class="[
                                                active
                                                    ? 'bg-gray-100'
                                                    : 'bg-white',
                                                'relative cursor-default select-none py-2 px-3',
                                            ]"
                                        >
                                            <div class="flex items-center">
                                                <span>
                                                    {{ category.emoji }}</span
                                                >
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
                <div class="flex-shrink-0">
                    <button
                        type="submit"
                        class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Create
                    </button>
                </div>
            </div>
        </div>
    </form>
</template>

<script setup lang="ts">
import { ref, reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { usePage } from "@inertiajs/inertia-vue3";
import {
    Listbox,
    ListboxButton,
    ListboxLabel,
    ListboxOption,
    ListboxOptions,
} from "@headlessui/vue";
import { TagIcon } from "@heroicons/vue/solid";

const categories = [...(usePage().props.value.categories as Category[])];

//
const categorized = ref(categories[0] as Category);

let form = reactive({
    description: "",
});

let submit = () => {
    Inertia.post(
        "/me",
        {
            description: form.description,
            category_id: categorized.value.id,
        },
        { preserveScroll: true }
    );
    form.description = "";
};
</script>
