<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { usePage, Head, useForm, Link, router } from "@inertiajs/vue3";
import Action from "@/Components/Action.vue";
import Map from "@/Components/Map.vue";
import { ref, watch, onMounted } from "vue";
import CreateAction from "@/Components/CreateAction.vue";

// It should be possible to remove this import as soon as https://github.com/vuejs/core/issues/4294 is completely done in Vue 3.3.0, but currently it is still needed.
import type {
    ActionIndexData,
    ActionsJsonData,
    CategoryData,
    ActionData,
} from "@/types/generated.d.ts";

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
const mapGeoData = ref<ActionsJsonData[]>([]);
const formActive = ref(false);
const mapCenter = ref(null);

setActionsData();

// watch for changes in the data prop and set the data ref to the new data
watch(
    () => props.actions.data,
    (newData) => {
        // When we had an update request, the updated actions should be replaced in the existing data
        if (usePage().props?.flash?.updated?.actions) {
            const updatedActions = usePage().props.flash.updated
                .actions as ActionData[];
            // update all actions
            data.value = data.value.map((action) => {
                // find the action that was updated
                const updatedAction = updatedActions.find(
                    (updatedAction) => updatedAction.id === action.id
                );
                // if the action was updated, return the updated action
                if (updatedAction) {
                    return updatedAction;
                }
                // otherwise return the original action
                return action;
            });
            return;
        }
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

const setMap = (mapData: string): void => {
    form.map = (mapData as any).bounds;
    mapCenter.value = (mapData as any).center;
    getData();
};

const setCategory = (categoryId: number): void => {
    form.category = categoryId;
    getData();
};

const highlightAction = (actionId: number): void => {
    console.log("highlightAction", actionId);
};

function onActionCreated(): void {
    console.log("onActionCreated");
    // formActive.value = false;
    // setActionsData()
}

// fetch data from actions_json_url
async function fetchActionsData(): Promise<ActionsJsonData[]> {
    try {
        const response = await fetch(props.actions_json_url);
        return await response.json();
    } catch (error) {
        console.error("Error fetching or parsing data:", error);
        throw error;
    }
}

async function setActionsData(): Promise<void> {
    mapGeoData.value = await fetchActionsData().then((data) => data);
}
</script>

<template>
    <Head title="Index" />

    <AuthenticatedLayout>
        <template #header> Index </template>

        <div class="relative z-0">
            <main
                :class="`fixed inset-y-0 right-0 block h-screen ${
                    formActive ? 'w-0' : 'w-[36rem]'
                } overflow-y-auto bg-secondary-300 transition-all`"
                ref="main"
            >
                <div
                    class="relative z-0 flex w-full flex-col gap-6 p-4 sm:p-6 lg:p-8"
                >
                    <Action
                        v-for="action in data"
                        v-bind="action"
                        v-bind:key="action.id"
                    />
                    <div ref="landmark"></div>
                </div>
            </main>

            <aside
                :class="`fixed inset-y-0 ${
                    formActive ? 'w-full' : 'w-[calc(100vw-36rem)]'
                } border-r border-gray-200 transition-all xl:block`"
            >
                <div class="relative h-screen w-full">
                    <Map
                        @map-changed="setMap"
                        @category-changed="setCategory"
                        @action-selected="highlightAction"
                        api-key="pk.ed59a693277d463a0b1bda2317c16928"
                        :categories="[...categories]"
                        :formActive="formActive"
                        :geo-data="mapGeoData"
                    ></Map>

                    <button
                        @click="formActive = !formActive"
                        :class="`absolute bottom-12 right-12 z-10 h-[54px] items-center justify-center whitespace-nowrap border border-transparent ${
                            formActive
                                ? 'bg-red-600 hover:bg-red-700'
                                : 'bg-primary-600  hover:bg-primary-700'
                        } px-6 text-base font-medium uppercase text-white shadow-sm`"
                    >
                        {{ formActive ? "x Cancel" : "+ Add action" }}
                    </button>
                    <div
                        v-if="formActive"
                        class="absolute left-1/2 top-1/2 -translate-x-1/2 translate-y-5 shadow-2xl"
                    >
                        <div class="z-10 rounded-lg">
                            <svg
                                class="absolute -top-5 left-1/2 -translate-x-1/2 rotate-180 fill-black"
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
                                @action-created="onActionCreated"
                                v-bind="{ action: undefined, mapCenter: mapCenter! }"
                            />
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </AuthenticatedLayout>
</template>
