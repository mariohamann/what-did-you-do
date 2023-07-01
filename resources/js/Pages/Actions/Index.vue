<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { usePage, Head, useForm, Link, router } from "@inertiajs/vue3";
import Action from "@/Components/Action.vue";
import CreateAction from "@/Components/CreateAction.vue";
import Map from "@/Components/Map.vue";
import { ref, watch, onMounted } from "vue";

// It should be possible to remove this import as soon as https://github.com/vuejs/core/issues/4294 is completely done in Vue 3.3.0, but currently it is still needed.
import type {
    ActionIndexData,
    ActionsJsonData,
    CategoryData,
    ActionData,
} from "@/types/generated.d.ts";
import { visit } from "maplibre-gl";

const form = useForm({
    q: "",
    category: 0,
    map: "",
});

const landmark = ref(null);
const main = ref(null);
const categories = usePage().props.categories as CategoryData[];
const props = defineProps<ActionIndexData>();
const data = ref<ActionData[]>(props.actions.data);
const formActive = ref(false);
const mapCenter = ref(null);

// watch for changes in the data prop and set the data ref to the new data
watch(
    () => props.actions.data,
    (newData) => {
        // When we had a pagination request, the new data should be added to the existing data
        if (props.actions.meta.prev_cursor !== null) {
            data.value = [...data.value, ...newData];
            return;
        }
        // Otherwise, we should replace the existing data with the new data
        data.value = newData;
        main.value.scrollTop = 0;
    }
);

const observer = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (
                entry.isIntersecting &&
                (props.actions.meta as any).next_page_url
            ) {
                router.get(
                    (props.actions.meta as any).next_page_url!,
                    {},
                    {
                        preserveState: true,
                        replace: true,
                    }
                );
            }
        });
    },
    {
        rootMargin: "200% 0px 0px 0px",
    }
);

onMounted(() => {
    observer.observe(landmark.value);
});

const getData = () => {
    // get current url and append category if available
    let url = new URL(window.location.href.split("?")[0]);
    // fetch data from url
    router.get(
        url.toString(),
        {
            ...(form.q && { q: form.q }),
            ...(form.category != 0 && { category: form.category }),
            ...(form.map && { map: form.map }),
        },
        {
            preserveState: true,
        }
    );
};

const setMap = (mapData: string) => {
    form.map = (mapData as any).bounds;
    mapCenter.value = (mapData as any).center;
    getData();
};

// watch form.category and call getData() when it changes
watch(form, () => {
    getData();
});

// amount of fetched elements from actions_json_url
let actionsFromJsonLength = ref(0);
// fetched data from actions_json_url
let geoJson = ref<ActionsJsonData[]>([]);

// fetch data from actions_json_url and make a console log of the length of the json (array)
// and set the geoJson ref to the fetched data
fetch(props.actions_json_url)
    .then((response) => response.json())
    .then((data: ActionsJsonData[]) => {
        actionsFromJsonLength.value = data.length;
        geoJson.value = data;
    });
</script>

<template>
    <Head title="Index" />

    <AuthenticatedLayout>
        <template #header> Index </template>

        <div class="relative z-0">
            <main
                class="fixed inset-y-0 right-0 block h-screen w-[36rem] overflow-y-auto bg-secondary-300"
                ref="main"
            >
                <div
                    class="relative z-0 flex w-full flex-col gap-6 p-4 sm:p-6 lg:p-8"
                >
                    <div>
                        <button
                            @click="formActive = !formActive"
                            :class="`inline-flex h-[54px] w-full items-center justify-center whitespace-nowrap rounded-md border border-transparent ${
                                formActive
                                    ? 'bg-red-600 hover:bg-red-700'
                                    : 'bg-primary-600  hover:bg-primary-700'
                            } px-6 text-base font-medium uppercase text-white shadow-sm`"
                        >
                            {{
                                formActive ? "x Cancel" : "+ Create new action"
                            }}
                        </button>
                    </div>
                    <Action
                        v-if="!formActive"
                        v-for="action in data"
                        v-bind="action"
                        v-bind:key="action.id"
                    />
                    <p v-else>
                        Describe your action, select location & category – and
                        start to inspire people.
                    </p>
                    <div ref="landmark"></div>
                </div>
            </main>

            <aside
                class="fixed inset-y-0 w-[calc(100vw-36rem)] border-r border-gray-200 xl:block"
            >
                <div class="relative h-screen w-full">
                    <Map
                        @map-changed="setMap"
                        api-key="pk.ed59a693277d463a0b1bda2317c16928"
                        :geo-data="geoJson"
                    ></Map>
                    <div
                        v-if="formActive"
                        class="absolute left-1/2 top-1/2 -translate-x-1/2 translate-y-5 shadow-2xl"
                    >
                        <div class="z-10 rounded-lg">
                            <svg
                                class="absolute -top-5 left-1/2 -translate-x-1/2 rotate-180 fill-white"
                                width="80"
                                height="97"
                                viewBox="0 0 80 97"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M80 40C80 50.9245 75.6206 60.8261 68.5216 68.045L68.5468 68.0702L40.2625 96.3545L15.6286 71.7206C6.12456 64.4076 0 52.919 0 40C0 17.9086 17.9086 0 40 0C62.0914 0 80 17.9086 80 40ZM40 64C53.2548 64 64 53.2548 64 40C64 26.7452 53.2548 16 40 16C26.7452 16 16 26.7452 16 40C16 53.2548 26.7452 64 40 64Z"
                                />
                            </svg>
                            <CreateAction
                                v-bind="{ action: null, mapCenter: mapCenter! }"
                            />
                        </div>
                    </div>
                    <div
                        class="pointer-events-none fixed left-0 top-12 z-40 w-[calc(100vw-36rem)]"
                    >
                        <div class="mx-auto flex justify-center">
                            <form
                                class="border-md pointer-events-auto flex rounded-lg border bg-secondary-300 p-3 shadow-sm shadow-secondary-100/10"
                                action="#"
                                method="GET"
                            >
                                <div
                                    class="overflow-hidden rounded-l-md border border-black"
                                >
                                    <div class="relative">
                                        <label for="q" class="sr-only"
                                            >Search value</label
                                        >
                                        <input
                                            autofocus
                                            type="text"
                                            name="q"
                                            id="q"
                                            class="block w-full border-0 py-[15px] pl-4 pr-20 text-gray-900 ring-1 ring-inset ring-white placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-base sm:leading-6"
                                            placeholder="Search..."
                                        />
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center"
                                        >
                                            <label for="mode" class="sr-only"
                                                >Mode for Search</label
                                            >
                                            <select
                                                id="mode"
                                                name="mode"
                                                class="h-full border-0 bg-transparent py-0 pl-2 pr-7 text-gray-500 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-base"
                                            >
                                                <option>Location</option>
                                                <option>Content</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="!formActive">
                                    <label for="category" class="sr-only"
                                        >Mode for Search</label
                                    >
                                    <select
                                        id="category"
                                        name="category"
                                        v-model="form.category"
                                        class="-ml-px block w-full rounded-r-md border border-black py-4 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-white focus:ring-2 focus:ring-primary-600 sm:text-base sm:leading-6"
                                    >
                                        <option selected value="0">
                                            All Categories
                                        </option>
                                        <option
                                            v-for="category in categories"
                                            :value="category.id"
                                            :key="category.id"
                                        >
                                            {{ category.emoji }}
                                            {{ category.name }}
                                        </option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </AuthenticatedLayout>
</template>
