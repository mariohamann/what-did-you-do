<script setup lang="ts">
import {
    HeartIcon,
    TrashIcon,
    LightBulbIcon,
    ArchiveIcon,
    ArrowCircleLeftIcon,
} from "@heroicons/vue/solid";
import { usePage } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
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
import { Link } from "@inertiajs/inertia-vue3";
import CreateAction from "@/Components/CreateAction.vue";

const props = defineProps({
    action: {
        type: Object as () => Action,
        required: true,
    },
});

const openDeleteAction = ref(false);
const openCreateAction = ref(false);

const isMine = computed(() => {
    const { user } = usePage().props.value as LaravelListProps;
    return props.action.user.id === user.id;
});

const likeAction = () => {
    Inertia.patch(
        `/actions/${props.action.id}/like`,
        {},
        { preserveScroll: true }
    );
};

const archiveAction = () => {
    Inertia.patch(
        `/actions/${props.action.id}/archive`,
        {},
        { preserveScroll: true }
    );
};


const deleteAction = () => {
    Inertia.delete(
        `/actions/${props.action.id}`,
        { preserveScroll: true }
    );
};

const styles = {
    like: {
        default:
            "inline-flex items-center rounded-md border px-3 py-2 text-sm font-medium leading-4 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2",
        inactive:
            "border-gray-300 bg-white text-gray-700 hover:bg-gray-50 focus:ring-red-500",
        active: "border-transparent bg-red-600 text-white hover:bg-red-700 focus:ring-red-500",
    },
};
</script>

<template>
    <button
        v-if="isMine"
        v-on:click="archiveAction"
        :class="[styles.like.inactive, styles.like.default]"
    >
        <ArchiveIcon
            v-if="!action.archived_at"
            class="-ml-0.5 mr-2 h-4 w-4"
            aria-hidden="true"
        />
        <ArrowCircleLeftIcon
            v-else
            class="-ml-0.5 mr-2 h-4 w-4"
            aria-hidden="true"
        />
        {{ action.archived_at ? "Restore" : "Archive" }}
    </button>
    <button
        v-if="isMine"
        type="button"
        v-on:click="openDeleteAction = true"
        :class="[styles.like.inactive, styles.like.default]"
    >
        <TrashIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true" />
        Delete
    </button>
    <button
        type="button"
        v-on:click="openCreateAction = true"
        :class="[styles.like.inactive, styles.like.default]"
    >
        <LightBulbIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true" />
        {{ action.inspirations.total }}
    </button>
    <button
        v-on:click="likeAction"
        type="submit"
        :class="[
            action.likes.liked ? styles.like.active : styles.like.inactive,
            styles.like.default,
        ]"
    >
        <HeartIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true" />
        {{ action.likes.total }}
    </button>
    <TransitionRoot as="template" :show="openCreateAction">
        <Dialog as="div" class="relative z-10" @close="openCreateAction = false">
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
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                        >
                            <CreateAction :inspired-by="action" />
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <TransitionRoot as="template" :show="openDeleteAction">
        <Dialog as="div" class="relative z-10" @close="openDeleteAction = false">
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
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                        >
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
                                >
                                    <ExclamationIcon
                                        class="h-6 w-6 text-red-600"
                                        aria-hidden="true"
                                    />
                                </div>
                                <div
                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left"
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
                                    @click="deleteAction(); openDeleteAction = false;"
                                    class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
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