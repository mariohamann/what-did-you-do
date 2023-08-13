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
    <Combobox
        class="border border-solid border-black"
        @update:model-value="(value) => emit('placeChanged', value)"
    >
        <div class="relative">
            <div
                class="relative w-full cursor-default overflow-hidden bg-white text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 focus-visible:ring-offset-2 focus-visible:ring-offset-amber-300"
            >
                <ComboboxInput
                    class="w-64 border-none py-3 pl-3 pr-10 text-base leading-5 text-gray-900 focus:ring-0"
                    :displayValue="(place) => place.name"
                    @change="searchTerm = $event.target.value"
                    placeholder="Search for a location..."
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
                    v-if="searchTerm.length > 2"
                    class="absolute mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg outline outline-1 outline-black"
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
                        v-slot="{ active }"
                    >
                        <li
                            class="relative cursor-default select-none px-4 py-3 text-gray-900"
                            :class="{
                                'bg-amber-100': active,
                            }"
                        >
                            <span class="block truncate font-normal">
                                {{ place.name }}
                            </span>
                        </li>
                    </ComboboxOption>
                </ComboboxOptions>
            </TransitionRoot>
        </div>
    </Combobox>
</template>
