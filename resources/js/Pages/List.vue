<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import Action from "@/Components/Action.vue";
import CreateAction from "@/Components/CreateAction.vue";
import Pagination from "../Components/Pagination.vue";
import FilterAction from "../Components/FilterAction.vue";
import MasonryWall from '@yeger/vue-masonry-wall';

defineProps({ actions: Object, me: Boolean });
</script>

<template>
    <AppLayout title="List">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8"></div>

        <CreateAction v-if="me" />

        <div class="py-12">
            <div class="mx-auto max-w-8xl sm:px-6 lg:px-8">
                <div class="py-12 px-4 sm:px-6 lg:px-8 mx-auto max-w-7xl">
                    <div class="flex flex-wrap">
                        <div class="top-24 self-start pr-8 lg:w-1/4 lg:sticky">
                            <h2 class="text-xl font-semibold mb-4">
                                {{ $page.props.title }}
                            </h2>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis tempora adipisci suscipit</p>
                            <FilterAction />
                        </div>
                        <div class="lg:w-3/4">
                            <masonry-wall :items="actions?.data" :ssr-columns="1" :column-width="280" :gap="32">
                                <template #default="{ item }">
                                    <Action :action="item" v-bind:key="item.id" />
                                </template>
                            </masonry-wall>
                            <Pagination />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
