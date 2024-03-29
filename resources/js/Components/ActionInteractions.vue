<script setup lang="ts">
import {
    HeartIcon,
    TrashIcon,
    LightBulbIcon,
    ArrowCircleLeftIcon,
} from "@heroicons/vue/solid";
import { usePage, router } from "@inertiajs/vue3";
import { ref } from "vue";
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { ExclamationIcon } from "@heroicons/vue/outline";
import { computed } from "vue";
import CreateAction from "@/Components/CreateAction.vue";

import type { ActionData } from "@/types/generated.d.ts";

const props = defineProps<ActionData>();

const openDeleteAction = ref(false);
const openCreateAction = ref(false);

const isMine = computed(() => {
    const currentUserId = usePage().props.auth.user.id;
    return props.user.id === currentUserId;
});

const likeAction = () => {
    // current url from window
    if (props.likes.liked) {
        router.delete(`/like/${props.id}`, {
            preserveScroll: true,
            replace: true,
        });
    } else {
        router.post(
            `/like/${props.id}`,
            {},
            {
                preserveScroll: true,
                replace: true,
            }
        );
    }
};

const deleteAction = () => {
    router.delete(`/action/${props.id}`, { preserveScroll: true });
};

const styles = {
    like: {
        default:
            "inline-flex items-center rounded-md px-3 py-2 text-sm font-medium leading-4 focus:outline-none focus:ring-2 focus:ring-offset-2",
        inactive:
            "bg-gray-50 text-gray-700 hover:bg-gray-100 transition-all focus:ring-primary-500",
        active: "border-transparent bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500",
    },
};
</script>

<template>
    <!-- <button
        v-if="isMine"
        type="button"
        v-on:click="openDeleteAction = true"
        :class="[styles.like.inactive, styles.like.default]"
    >
        <TrashIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true" />
        Delete
    </button> -->
    <button
        v-on:click="likeAction"
        type="submit"
        :class="[
            likes.liked ? styles.like.active : styles.like.inactive,
            styles.like.default,
        ]"
    >
        <HeartIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true" />
        {{ likes.total }}
    </button>
    <TransitionRoot as="template" :show="openCreateAction">
        <Dialog
            as="div"
            class="relative z-10"
            @close="openCreateAction = false"
        >
            <TransitionChild
                as="template"
                enter="ease-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in duration-200"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div
                    class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
                >
                    <TransitionChild
                        as="template"
                        enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100"
                        leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                        >
                            <CreateAction v-bind="$props" />
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <TransitionRoot as="template" :show="openDeleteAction">
        <Dialog
            as="div"
            class="relative z-10"
            @close="openDeleteAction = false"
        >
            <TransitionChild
                as="template"
                enter="ease-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in duration-200"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div
                    class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
                >
                    <TransitionChild
                        as="template"
                        enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100"
                        leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                        >
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-primary-100 sm:mx-0 sm:h-10 sm:w-10"
                                >
                                    <ExclamationIcon
                                        class="h-6 w-6 text-primary-600"
                                        aria-hidden="true"
                                    />
                                </div>
                                <div
                                    class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left"
                                >
                                    <DialogTitle
                                        as="h3"
                                        class="text-lg font-medium leading-6 text-gray-900"
                                    >
                                        Delete action
                                    </DialogTitle>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            Are you sure you want to delete this
                                            action? This cannot be undone.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse"
                            >
                                <button
                                    @click="
                                        deleteAction();
                                        openDeleteAction = false;
                                    "
                                    class="inline-flex w-full justify-center rounded-md border border-transparent bg-primary-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                                >
                                    Delete
                                </button>
                                <button
                                    type="button"
                                    class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm"
                                    @click="openDeleteAction = false"
                                    ref="cancelButtonRef"
                                >
                                    Cancel
                                </button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
