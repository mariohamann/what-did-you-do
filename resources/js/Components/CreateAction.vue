<script setup lang="ts">
import type { ActionData } from "@/types/generated.d.ts";
import { ref, reactive } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import { RadioGroup, RadioGroupOption } from "@headlessui/vue";
import {
    ArrowSmLeftIcon,
    ArrowSmRightIcon,
    CheckIcon,
    XIcon,
} from "@heroicons/vue/solid";

const props = defineProps<{
    action?: ActionData;
    mapCenter: string;
}>();

const categories = usePage().props.categories;
const form = reactive({
    category_id: 1,
    lat: (props.mapCenter as any).lat,
    lng: (props.mapCenter as any).lng,
    description: "",
});

let step = ref(1);

const stepClass = (index) => {
    if (index + 1 === step.value) {
        return "bg-primary-600 outline-4 outline-primary-600/30 outline";
    } else if (index + 1 < step.value) {
        return "bg-primary-600";
    } else {
        return "bg-gray-600";
    }
};

const resetForm = () => {
    form.category_id = 1;
    form.lat = null;
    form.lng = null;
    form.description = "";
    step.value = 1;
};

const createAction = () => {
    router.post(
        "/action",
        {
            description: form.description,
            category_id: form.category_id,
            lat: (props.mapCenter as any).lat,
            lng: (props.mapCenter as any).lng,
        },
        { preserveScroll: true, preserveState: true }
    );

    resetForm();
    emit("actionCreated");
};

const emit = defineEmits(["formFocused", "formBlurred", "actionCreated"]);
</script>

<template>
    <form
        @submit.prevent="createAction"
        class="relative w-80 border border-black bg-white shadow-hard"
        @focusin="emit('formFocused')"
        @focusout="emit('formBlurred')"
    >
        <!-- Step 1: Location -->
        <div v-if="step === 1">
            <div class="p-4">
                <p>
                    <b class="mr-3">Current Location:</b>
                    <span class="font-mono"
                        >{{ props.mapCenter.lng }}
                        {{ props.mapCenter.lat }}</span
                    >
                </p>
                <p class="mt-3 text-sm text-neutral-700">
                    To choose a different location, move the map or use the
                    search box at the top.
                </p>
            </div>
        </div>

        <!-- Step 2: Category -->
        <div
            v-if="step === 2"
            class="overflow-hidden focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-primary-500"
        >
            <p class="p-4 pb-0">
                <b>Select a category:</b>
            </p>
            <RadioGroup
                v-model="form.category_id"
                class="flex flex-col gap-0.5 px-2 py-2"
            >
                <div
                    v-for="category in categories"
                    :key="category.id"
                    class="flex items-center"
                >
                    <RadioGroupOption
                        :value="category.id"
                        class="w-full"
                        v-slot="{ checked }"
                    >
                        <RadioGroupLabel
                            class="flex cursor-pointer items-center justify-start rounded-lg border px-4 py-3 outline-none"
                            :class="[
                                checked
                                    ? ' border-primary-600 bg-primary-50'
                                    : ' border-transparent bg-white hover:bg-neutral-50',
                            ]"
                        >
                            <span
                                :class="[
                                    checked
                                        ? 'border-transparent bg-primary-600'
                                        : 'border-gray-300 bg-white',
                                    active
                                        ? 'ring-2 ring-primary-600 ring-offset-2'
                                        : '',
                                    'mr-4 flex h-4 w-4 items-center justify-center rounded-full border',
                                ]"
                                aria-hidden="true"
                            >
                                <span
                                    class="h-1.5 w-1.5 rounded-full bg-white"
                                />
                            </span>
                            <img
                                :src="`/assets/icons/${category.slug}.svg`"
                                alt=""
                                class="mr-4 h-6 w-6"
                            />
                            <span class="text-base font-medium">{{
                                category.name
                            }}</span>
                        </RadioGroupLabel>
                    </RadioGroupOption>
                </div>
            </RadioGroup>
        </div>

        <!-- Step 3: Description -->
        <div v-if="step === 3">
            <div
                class="overflow-hidden shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-primary-500"
            >
                <label for="description" class="sr-only">Content</label>
                <textarea
                    v-model="form.description"
                    rows="3"
                    id="description"
                    class="block w-full border-0 px-5 pb-0 pt-5 text-lg placeholder-gray-500 focus:ring-0"
                    placeholder="What did you do against climate change?"
                />
            </div>
        </div>

        <div class="flex h-[54px] border-t border-black">
            <button
                @click.prevent="step > 1 ? (step = step - 1) : resetForm()"
                class="inline-flex h-full w-1/2 items-center justify-center gap-2 whitespace-nowrap text-base font-medium uppercase shadow-sm"
                :class="
                    step === 1
                        ? 'bg-red-50 text-red-600 hover:bg-red-100'
                        : 'bg-primary-50 text-primary-600  hover:bg-primary-100 '
                "
            >
                <ArrowSmLeftIcon
                    v-if="step > 1"
                    class="h-5 w-5"
                    aria-hidden="true"
                />
                <XIcon v-else class="h-5 w-5" aria-hidden="true" />
                {{ step === 1 ? "Cancel" : "Back" }}
            </button>
            <button
                @click.prevent="step !== 3 ? (step = step + 1) : createAction()"
                class="inline-flex h-full w-1/2 items-center justify-center gap-2 whitespace-nowrap border-l border-black bg-primary-600 text-base font-medium uppercase text-white shadow-sm hover:bg-primary-700"
            >
                <CheckIcon
                    v-if="step === 3"
                    class="h-5 w-5"
                    aria-hidden="true"
                />
                {{ step === 3 ? "Create" : "Next" }}
                <ArrowSmRightIcon
                    v-if="step !== 3"
                    class="h-5 w-5"
                    aria-hidden="true"
                />
            </button>
        </div>
    </form>

    <nav
        class="pointer-events-none mb-4 flex items-center justify-center p-6"
        aria-label="Progress"
    >
        <p class="text-sm font-medium">Step {{ step }} of 3</p>
        <ol role="list" class="ml-8 flex items-center space-x-5">
            <li v-for="(stepItem, index) in [1, 2, 3]" :key="stepItem">
                <div
                    class="block h-2.5 w-2.5 rounded-full"
                    :class="stepClass(index)"
                >
                    <span class="sr-only">Step {{ stepItem }}</span>
                </div>
            </li>
        </ol>
    </nav>
</template>
