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
        icon: "map",
        current: route().current("index"),
        logged: ["in", "out"],
    },
    {
        name: "Profile",
        href: route("profile.edit"),
        icon: "profile",
        current: route().current("profile.edit"),
        logged: ["in"],
    },
    {
        name: "Log Out",
        href: route("logout"),
        icon: "logout",
        current: false,
        logged: ["in"],
    },
    {
        name: "Log In",
        href: route("login"),
        icon: "login",
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
    <div class="z-10 w-full text-base">
        <!-- Static sidebar for desktop -->

        <Link class="group fixed left-10 top-6 z-10" href="/">
            <img
                class="w-full select-none pt-8 transition-transform group-hover:scale-125"
                src="/assets/logo.svg"
                alt="Start"
        /></Link>
        <nav
            class="fixed bottom-12 z-10 flex -translate-x-[calc(100%-3.5rem)] flex-col"
        >
            <ul role="list" class="flex w-full flex-col items-end gap-4">
                <li v-for="item in navigation" :key="item.name">
                    <Link
                        class="block -rotate-6 bg-white"
                        :href="item.href"
                        :method="item.href === route('logout') ? 'post' : 'get'"
                        :as="item.href === route('logout') ? 'button' : 'a'"
                    >
                        <div
                            :class="[
                                item.current
                                    ? 'relative translate-x-[calc(100%-3.5rem)] '
                                    : ' text-black hover:translate-x-[calc(100%-3rem)] active:translate-x-[calc(100%-3rem)]',
                                'border-1  group flex h-12 items-center gap-4 border-white bg-white p-2 text-2xl font-semibold leading-6 transition-all',
                            ]"
                        >
                            <span class="text-base uppercase italic">{{
                                item.name
                            }}</span>
                            <img
                                class="px-1"
                                :src="`/assets/icons/${item.icon}.svg`"
                                style="font-size: 0.5rem"
                            />
                        </div>
                    </Link>
                </li>
            </ul>
        </nav>
        <slot />
    </div>
</template>
