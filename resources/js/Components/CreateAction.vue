<script setup lang="ts">
import { ref, reactive } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import {
    Listbox,
    ListboxButton,
    ListboxLabel,
    ListboxOption,
    ListboxOptions,
} from "@headlessui/vue";
import { TagIcon } from "@heroicons/vue/solid";

import type { ActionData, CategoryData } from "@/types/generated.d.ts";

const props = defineProps<{
    action?: ActionData;
    mapCenter: string;
}>();

const categories = usePage().props.categories as CategoryData[];

const categorized = ref(categories[props?.action?.category?.id - 1 || 0]);

const emit = defineEmits(["formFocused", "formBlurred"]);

let form = reactive({
    description: props.action?.description || "",
});

let createAction = () => {
    router.post(
        "/action",
        {
            description: form.description,
            category_id: categorized.value.id,
            inspired_by: props.action?.id,
            lat: (props.mapCenter as any).lat,
            lng: (props.mapCenter as any).lng,
        },
        { preserveScroll: true, preserveState: false }
    );
    form.description = "";
};
</script>

<template>
    <form
        @submit.prevent="createAction"
        class="relative rounded-md bg-white"
        @focusin="emit('formFocused')"
        @focusout="emit('formBlurred')"
    >
        <div
            class="w-[360px] overflow-hidden rounded-md shadow-sm focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500"
        >
            <label for="description" class="sr-only">Content</label>
            <textarea
                v-model="form.description"
                rows="3"
                name="description"
                id="description"
                class="block w-full border-0 px-5 pb-0 pt-5 text-lg placeholder-gray-500 focus:ring-0"
                placeholder="What did you do against climate change?"
            />

            <!-- Spacer element to match the height of the toolbar -->
            <div aria-hidden="true">
                <div class="py-2">
                    <div class="h-9" />
                </div>
                <div class="py-2"></div>
            </div>
        </div>

        <div class="absolute inset-x-0 bottom-0">
            <!-- Actions: These are just examples to demonstrate the concept, replace/wire these up however makes sense for your project. -->

            <div
                class="flex h-14 items-center justify-between border-t border-black"
            >
                <div class="flex w-full flex-nowrap justify-end">
                    <Listbox
                        as="div"
                        v-model="categorized"
                        class="h-full w-full"
                    >
                        <ListboxLabel class="sr-only"> Category </ListboxLabel>
                        <div class="relative">
                            <ListboxButton
                                class="relative flex h-[54px] w-[calc(100%)] items-center justify-between whitespace-nowrap rounded-bl-lg px-4 text-base font-medium text-primary-600 hover:bg-gray-50"
                            >
                                <div class="inline-flex">
                                    <TagIcon
                                        v-if="categorized.id === null"
                                        class="h-5 w-5 flex-shrink-0 sm:-ml-1"
                                        aria-hidden="true"
                                    />

                                    <span
                                        class="ml-0.5 inline-block w-6"
                                        v-else
                                        >{{ categorized.emoji }}</span
                                    >

                                    <span
                                        :class="[
                                            categorized.id === null
                                                ? ''
                                                : 'text-primary-600',
                                            'hidden truncate sm:ml-2 sm:block',
                                        ]"
                                        >{{
                                            categorized.id === null
                                                ? "Category"
                                                : categorized.name
                                        }}</span
                                    >
                                </div>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 text-primary-600"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </ListboxButton>

                            <transition
                                leave-active-class="transition ease-in duration-100"
                                leave-from-class="opacity-100"
                                leave-to-class="opacity-0"
                            >
                                <ListboxOptions
                                    class="absolute -left-px z-10 mt-1 max-h-56 w-[calc(100%+3px)] overflow-auto rounded-md border border-black bg-white py-3 text-base shadow shadow-md ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
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
                                                'relative cursor-default select-none px-4 py-2',
                                            ]"
                                        >
                                            <div
                                                class="flex items-center text-base"
                                            >
                                                <span
                                                    class="block w-6 text-center"
                                                >
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
                <div>
                    <button
                        type="submit"
                        class="inline-flex h-[54px] items-center whitespace-nowrap rounded-br-md border border-transparent bg-primary-600 px-6 text-base font-medium uppercase text-white shadow-sm hover:bg-primary-700"
                    >
                        + Create
                    </button>
                </div>
            </div>
        </div>
    </form>
</template>
