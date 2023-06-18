<script setup>
import { ref } from "vue";
import {
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import {
    PlusIcon,
    CalendarIcon,
    ChartPieIcon,
    DocumentDuplicateIcon,
    FolderIcon,
    HomeIcon,
    UsersIcon,
    XIcon,
} from "@heroicons/vue/solid";

const navigation = [
    {
        name: "Dashboard",
        href: route("index"),
        icon: HomeIcon,
        current: route().current("index"),
    },
    { name: "Team", href: "#", icon: UsersIcon, current: false },
    { name: "Projects", href: "#", icon: FolderIcon, current: false },
    { name: "Calendar", href: "#", icon: CalendarIcon, current: false },
    {
        name: "Documents",
        href: "#",
        icon: DocumentDuplicateIcon,
        current: false,
    },
    { name: "Reports", href: "#", icon: ChartPieIcon, current: false },
];

const sidebarOpen = ref(false);
</script>

<template>
    <!--
    This example requires updating your template:

    ```
    <html class="h-full bg-white">
    <body class="h-full">
    ```
  -->
    <div class="text-base">
        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog
                as="div"
                class="relative z-50 lg:hidden"
                @close="sidebarOpen = false"
            >
                <TransitionChild
                    as="template"
                    enter="transition-opacity ease-linear duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="transition-opacity ease-linear duration-300"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-gray-900/80" />
                </TransitionChild>

                <div class="fixed inset-0 flex">
                    <TransitionChild
                        as="template"
                        enter="transition ease-in-out duration-300 transform"
                        enter-from="-translate-x-full"
                        enter-to="translate-x-0"
                        leave="transition ease-in-out duration-300 transform"
                        leave-from="translate-x-0"
                        leave-to="-translate-x-full"
                    >
                        <DialogPanel
                            class="relative mr-16 flex w-full max-w-xs flex-1"
                        >
                            <TransitionChild
                                as="template"
                                enter="ease-in-out duration-300"
                                enter-from="opacity-0"
                                enter-to="opacity-100"
                                leave="ease-in-out duration-300"
                                leave-from="opacity-100"
                                leave-to="opacity-0"
                            >
                                <div
                                    class="absolute left-full top-0 flex w-16 justify-center pt-5"
                                >
                                    <button
                                        type="button"
                                        class="-m-2.5 p-2.5"
                                        @click="sidebarOpen = false"
                                    >
                                        <span class="sr-only"
                                            >Close sidebar</span
                                        >
                                        <XIcon
                                            class="h-6 w-6 text-white"
                                            aria-hidden="true"
                                        />
                                    </button>
                                </div>
                            </TransitionChild>

                            <div
                                class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 pb-2 ring-1 ring-white/10"
                            >
                                <div class="flex h-16 shrink-0 items-center">
                                    <img
                                        class="h-8 w-auto"
                                        src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                                        alt="Your Company"
                                    />
                                </div>
                                <nav class="flex flex-1 flex-col">
                                    <ul
                                        role="list"
                                        class="-mx-2 flex-1 space-y-1"
                                    >
                                        <li
                                            v-for="item in navigation"
                                            :key="item.name"
                                        >
                                            <a
                                                :href="item.href"
                                                :class="[
                                                    item.current
                                                        ? 'bg-gray-800 text-white'
                                                        : 'text-gray-400 hover:bg-gray-800 hover:text-white',
                                                    'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6',
                                                ]"
                                            >
                                                <component
                                                    :is="item.icon"
                                                    class="h-6 w-6 shrink-0"
                                                    aria-hidden="true"
                                                />
                                                {{ item.name }}
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Static sidebar for desktop -->
        <div
            class="hidden border-gray-600 lg:fixed lg:inset-y-0 lg:left-0 lg:z-50 lg:block lg:w-20 lg:overflow-y-auto lg:bg-secondary-200 lg:pb-4"
        >
            <div class="flex shrink-0 items-center justify-center">
                <img
                    class="w-full pt-8"
                    src="/assets/logo.png"
                    alt="Your Company"
                />
            </div>
            <nav class="mt-8">
                <ul role="list" class="flex flex-col items-center space-y-1">
                    <li v-for="item in navigation" :key="item.name">
                        <!-- <a
                            :href="item.href"
                            :class="[
                                item.current
                                    ? 'bg-gray-800 text-white'
                                    : 'text-gray-400 hover:bg-gray-800 hover:text-white',
                                'group flex gap-x-3 rounded-md bg-primary-400 p-3 text-sm font-semibold leading-6',
                            ]"
                        >
                            <component
                                :is="item.icon"
                                class="h-6 w-6 shrink-0"
                                aria-hidden="true"
                            />
                            <span class="sr-only">{{ item.name }}</span>
                        </a> -->
                    </li>
                </ul>
            </nav>
        </div>

        <div
            class="sticky top-0 z-40 flex items-center gap-x-6 bg-gray-900 px-4 py-4 shadow-sm sm:px-6 lg:hidden"
        >
            <button
                type="button"
                class="-m-2.5 p-2.5 text-gray-400 lg:hidden"
                @click="sidebarOpen = true"
            >
                <span class="sr-only">Open sidebar</span>
                <PlusIcon class="h-6 w-6" aria-hidden="true" />
            </button>
            <div class="flex-1 text-sm font-semibold leading-6 text-white">
                <slot name="header" />
            </div>
            <a href="#">
                <span class="sr-only">Your profile</span>
                <img
                    class="h-8 w-8 rounded-full bg-gray-800"
                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                    alt=""
                />
                <div class="mt-3 space-y-1">
                    <ResponsiveNavLink :href="route('profile.edit')">
                        Profile
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        :href="route('logout')"
                        method="post"
                        as="button"
                    >
                        Log Out
                    </ResponsiveNavLink>
                </div>
            </a>
        </div>
        <slot />
    </div>
</template>
