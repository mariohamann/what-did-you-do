<script setup>

import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import Users from '../Components/Users.vue';
</script>

<template>
    <AppLayout title="List">


        <!-- When implementing a user search, this will help: https://laracasts.com/series/build-modern-laravel-apps-using-inertia-js/episodes/22 -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Others
            </h2>
            <p class="mt-2 text-gray-600">
                Est qui commodo sunt labore. Voluptate aliquip occaecat ea laboris consequat excepteur commodo Lorem Lorem nisi consectetur esse quis et proident.
            </p>
        </template>
            <div class="mt-12sm:px-6 lg:px-8 max-w-7xl  mx-auto mt-16">
                <div class="flex justify-center">
                    <div class="max-w-lg w-full lg:max-w-xs">
                <label for="search" class="sr-only">Find new connections...</label>
                <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
                </div>
                <input id="search" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Find new connection..." type="search" />
                </div>
            </div>
                    </div>
            </div>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <Users status="➕ Connect"/>
                </div>
            </div>
    </AppLayout>
</template>
