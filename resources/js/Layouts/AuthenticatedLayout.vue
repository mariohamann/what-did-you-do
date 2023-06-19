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
    LoginIcon,
    LogoutIcon,
    MapIcon,
    UserIcon,
    XIcon,
} from "@heroicons/vue/solid";

import { Link, usePage } from "@inertiajs/vue3";

const navigation = [
    {
        name: "Map",
        href: route("index"),
        icon: MapIcon,
        current: route().current("index"),
        logged: ["in", "out"],
    },
    {
        name: "Profile",
        href: route("profile.edit"),
        icon: UserIcon,
        current: route().current("profile.edit"),
        logged: ["in"],
    },
    {
        name: "Log Out",
        href: route("logout"),
        icon: LogoutIcon,
        current: false,
        logged: ["in"],
    },
    {
        name: "Log In",
        href: route("login"),
        icon: LoginIcon,
        current: false,
        logged: ["out"],
    },
].filter((item) =>
    item.logged.includes(usePage().props.auth?.user ? "in" : "out")
);

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
        <!-- Static sidebar for desktop -->
        <div
            class="hidden flex-col justify-between border-gray-600 lg:fixed lg:inset-y-0 lg:left-0 lg:z-50 lg:flex lg:w-20 lg:overflow-y-auto lg:bg-secondary-200 lg:pb-4"
        >
            <div class="flex shrink-0 items-center justify-center">
                <img
                    class="w-full pt-8"
                    src="/assets/logo.png"
                    alt="Your Company"
                />
            </div>
            <nav class="flex flex-col">
                <ul role="list" class="flex w-full flex-col items-center gap-4">
                    <li v-for="item in navigation" :key="item.name">
                        <Link
                            class="block rounded-md bg-black"
                            :href="item.href"
                            :method="
                                item.href === route('logout') ? 'post' : 'get'
                            "
                            :as="item.href === route('logout') ? 'button' : 'a'"
                        >
                            <div
                                :class="[
                                    item.current
                                        ? 'relative -translate-x-2 -translate-y-2 bg-white text-primary-600'
                                        : 'bg-white text-black hover:-translate-x-1 hover:-translate-y-1',
                                    'group flex h-12 w-12 rounded-md  p-2 text-2xl font-semibold leading-6 transition-all',
                                ]"
                            >
                                <component
                                    :is="item.icon"
                                    class="h-8 w-8 shrink-0"
                                    aria-hidden="true"
                                />
                            </div>
                            <span class="sr-only">{{ item.name }}</span>
                        </Link>
                    </li>
                </ul>
            </nav>
        </div>
        <slot />
    </div>
</template>
