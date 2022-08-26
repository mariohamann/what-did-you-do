<script setup lang="ts">
import { usePage } from "@inertiajs/inertia-vue3";
import { computed } from "vue";
import { Link } from '@inertiajs/inertia-vue3'
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { CodeIcon, DotsVerticalIcon, FlagIcon, StarIcon } from '@heroicons/vue/solid'
import ActionInteractions from "@/Components/ActionInteractions.vue";
import ActionCategory from "@/Components/ActionCategory.vue";

const props = defineProps({
  action: {
    type: Object as () => Action,
    required: true,
  },
});
</script>

<template>
  <div class="border-black border py-6 px-4" :class="action.archived_at ? 'bg-red-200' : 'bg-white'">
    <div class="mb-6 flex justify-between">
      <ActionCategory :category_id="action.category_id" />
      <Menu as="div" class="relative z-30 inline-block text-left">
        <div>
          <MenuButton class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600">
            <span class="sr-only">Open options</span>
            <DotsVerticalIcon class="h-5 w-5" aria-hidden="true" />
          </MenuButton>
        </div>
        <transition enter-active-class="transition ease-out duration-100"
          enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
          leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100"
          leave-to-class="transform opacity-0 scale-95">
          <MenuItems
            class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
            <div class="py-1">
              <MenuItem v-slot="{ active }">
              <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex px-4 py-2 text-sm']">
                <StarIcon class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true" />
                <span>feature 01</span>
              </a>
              </MenuItem>
              <MenuItem v-slot="{ active }">
              <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex px-4 py-2 text-sm']">
                <CodeIcon class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true" />
                <span>feature 02</span>
              </a>
              </MenuItem>
              <MenuItem v-slot="{ active }">
              <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex px-4 py-2 text-sm']">
                <FlagIcon class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true" />
                <span>feature 03</span>
              </a>
              </MenuItem>
            </div>
          </MenuItems>
        </transition>
      </Menu>
    </div>
    <div class="mb-16">
      <p class="text-xl font-medium mb-3">
        {{ action.description }}
      </p>
      <p class="text-sm">
        {{ action.user.name }}
      </p>
    </div>
    <ActionInteractions :action="action" />
  </div>
</template>
