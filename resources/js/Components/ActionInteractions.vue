<script setup lang="ts">
import { HeartIcon, TrashIcon, ArchiveIcon, ArrowCircleLeftIcon } from "@heroicons/vue/solid";
import { usePage } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationIcon } from '@heroicons/vue/outline'
import { computed } from "vue";
import { Link } from '@inertiajs/inertia-vue3'

const props = defineProps({
    action: {
        type: Object as () => Action,
        required: true,
    },
});

const open = ref(false)

const isMine = computed(() => {
    const { user } = usePage().props.value as LaravelListProps;
    return props.action.user.id === user.id;
});

const inertiaPost = (endpoint: string) => {
    if(endpoint === 'archive'){
        Inertia.patch(
            `/${endpoint}`,
            {
                action_id: props.action.id,
            },
            { preserveScroll: true }
        );
        return;
    }

    Inertia.post(
        `/${endpoint}`,
        {
            action_id: props.action.id,
        },
        { preserveScroll: true }
    );
}

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
    <form  v-if="isMine"  @submit.prevent="inertiaPost('archive')">
        <button
            type="submit"
            :class="[ styles.like.inactive, styles.like.default, ]"
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
            {{ action.archived_at ? 'Restore' : 'Archive' }}
        </button>
    </form>
        <button
        v-if="isMine"
        type="button"
        v-on:click="open = true"
        :class="[ styles.like.inactive, styles.like.default, ]"
    >
        <TrashIcon
            class="-ml-0.5 mr-2 h-4 w-4"
            aria-hidden="true"
        />
        Delete
    </button>
    <form @submit.prevent="inertiaPost('like')">
        <button
            type="submit"
            :class="[
                action.likes.liked
                    ? styles.like.active
                    : styles.like.inactive,
                styles.like.default,
            ]"
        >
            <HeartIcon
                class="-ml-0.5 mr-2 h-4 w-4"
                aria-hidden="true"
            />
            {{ action.likes.total }}
        </button>
    </form>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="open = false">
        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
        </TransitionChild>

        <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <DialogPanel class="relative bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Delete action </DialogTitle>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">Are you sure you want to delete this action? This cannot be undone.</p>
                    </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <form @submit.prevent="inertiaPost('delete')">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" @click="open = false">Delete</button>
                    </form>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" @click="open = false" ref="cancelButtonRef">Cancel</button>
                </div>
                </DialogPanel>
            </TransitionChild>
            </div>
        </div>
        </Dialog>
    </TransitionRoot>
</template>
