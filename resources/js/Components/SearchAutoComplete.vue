<script setup lang="ts">
import { watchThrottled } from "@vueuse/core";
import { ref } from "vue";
import {
    Combobox,
    ComboboxInput,
    ComboboxButton,
    ComboboxOptions,
    ComboboxOption,
    TransitionRoot,
} from "@headlessui/vue";
import { CheckIcon, ChevronDownIcon } from "@heroicons/vue/solid";

// TODO add types
const emit = defineEmits(["placeChanged"]);

export interface PlacesData {
    name: string;
    ln: number;
    la: number;
}

const props = defineProps<{
    apiKey: string;
}>();

const searchTerm = ref("");
const searchResults = ref([] as PlacesData[]);

watchThrottled(
    searchTerm,
    async (newTerm) => {
        if (newTerm.length > 2) {
            try {
                const response = await fetch(
                    `https://api.locationiq.com/v1/autocomplete?key=${props.apiKey}&q=${newTerm}&limit=5&dedupe=1`
                );
                const data = await response.json();
                if (data.error) {
                    console.log(data.error);
                    return;
                }
                searchResults.value = data.map((place: any) => {
                    return {
                        name: place.display_name,
                        ln: place.lon,
                        la: place.lat,
                    };
                });
            } catch (error) {
                console.log(error);
            }
        } else {
            searchResults.value = [];
        }
    },
    { throttle: 500 }
);
</script>

<template>
    <Combobox @update:model-value="(value) => emit('placeChanged', value)">
        <div class="relative mt-1">
            <div
                class="relative w-full cursor-default overflow-hidden rounded-lg bg-white text-left shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 focus-visible:ring-offset-2 focus-visible:ring-offset-teal-300 sm:text-sm"
            >
                <ComboboxInput
                    class="w-full border-none py-2 pl-3 pr-10 text-sm leading-5 text-gray-900 focus:ring-0"
                    :displayValue="(place) => place.name"
                    @change="searchTerm = $event.target.value"
                />
                <ComboboxButton
                    v-if="searchResults.length > 0"
                    class="absolute inset-y-0 right-0 flex items-center pr-2"
                >
                    <ChevronDownIcon
                        class="h-5 w-5 text-gray-400"
                        aria-hidden="true"
                    />
                </ComboboxButton>
            </div>
            <TransitionRoot
                leave="transition ease-in duration-100"
                leaveFrom="opacity-100"
                leaveTo="opacity-0"
                @after-leave="searchTerm = ''"
            >
                <ComboboxOptions
                    class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                >
                    <div
                        v-if="searchResults.length === 0 && searchTerm !== ''"
                        class="relative cursor-default select-none px-4 py-2 text-gray-700"
                    >
                        Nothing found.
                    </div>

                    <ComboboxOption
                        v-for="place in searchResults"
                        as="template"
                        :key="place.name"
                        :value="place"
                        v-slot="{ selected, active }"
                    >
                        <li
                            class="relative cursor-default select-none py-2 pl-10 pr-4"
                            :class="{
                                'bg-teal-600 text-white': active,
                                'text-gray-900': !active,
                            }"
                        >
                            <span
                                class="block truncate"
                                :class="{
                                    'font-medium': selected,
                                    'font-normal': !selected,
                                }"
                            >
                                {{ place.name }}
                            </span>
                            <span
                                v-if="selected"
                                class="absolute inset-y-0 left-0 flex items-center pl-3"
                                :class="{
                                    'text-white': active,
                                    'text-teal-600': !active,
                                }"
                            >
                                <CheckIcon class="h-5 w-5" aria-hidden="true" />
                            </span>
                        </li>
                    </ComboboxOption>
                </ComboboxOptions>
            </TransitionRoot>
        </div>
    </Combobox>
</template>
