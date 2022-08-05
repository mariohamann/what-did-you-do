<script setup lang="ts">
import { HeartIcon } from "@heroicons/vue/solid";
import { usePage } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
const props = defineProps({
    action: {
        type: Object as () => Action,
        required: true,
    },
});

let submit = () => {
    console.log("submit");
    Inertia.post(
        "/like",
        {
            action_id: props.action.id,
        },
        { preserveScroll: true }
    );
};

/*
The category could be provided by the backend, too.
For now, we'll just calculate it on the client to reduce load on the database.
*/

const calculateCategory = () => {
    const categories = [...(usePage().props.value.categories as Category[])];
    return categories.find(
        (category) => category.id === props.action.category_id
    ) as Category;
};

const category = calculateCategory();
</script>

<template>
    <tr>
        <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
            {{ action.description }}
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <span
                class="mr-2 rounded border border-gray-200 bg-gray-50 px-2.5 py-0.5 text-sm font-medium text-gray-900"
            >
                {{ category.emoji }} {{ category.name }}
            </span>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            {{ action.user.name }}
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <form @submit.prevent="submit">
                <button
                    v-if="!action.likes.liked"
                    type="submit"
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                >
                    <HeartIcon
                        class="-ml-0.5 mr-2 h-4 w-4"
                        aria-hidden="true"
                    />
                    {{ action.likes.total }}
                </button>
                <button
                    v-else
                    type="submit"
                    class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                >
                    <HeartIcon
                        class="-ml-0.5 mr-2 h-4 w-4"
                        aria-hidden="true"
                    />
                    {{ action.likes.total }}
                </button>
            </form>
        </td>
    </tr>
</template>
