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
    // fetch data from url
    router.get(
        window.location.origin,
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
    if (!mapData || mapData.center || mapData.bounds) return;
    form.map = (mapData as any)?.bounds;
    mapCenter.value = (mapData as any)?.center;
    getData();
};

const setCategory = (categoryId: number): void => {
    form.category = categoryId;
    getData();
};

const highlightAction = (actionId: number): void => {
    router.get(
        "/action/" + actionId,
        {},
        {
            preserveState: true,
        }
    );
    console.log("highlightAction", actionId);
};

function onActionCreated(): void {
    formActive.value = false;
    setActionsData();
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

        <div class="relative z-0 flex flex-col-reverse">
            <main
                :class="`block w-full lg:fixed lg:inset-y-0 lg:right-0 lg:h-screen ${
                    formActive ? 'lg:w-0' : 'lg:w-[36rem]'
                } overflow-y-auto border-t border-black bg-secondary-300 transition-all lg:border-l`"
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
                :class="`lg:fixed lg:inset-y-0 ${
                    formActive ? 'w-full' : 'lg:w-[calc(100vw-36rem)]'
                } transition-all xl:block`"
            >
                <div class="relative h-[80svh] w-full lg:h-screen">
                    <Map
                        @map-changed="setMap"
                        @category-changed="setCategory"
                        @action-selected="highlightAction"
                        api-key="pk.ed59a693277d463a0b1bda2317c16928"
                        :categories="[...categories]"
                        :formActive="formActive"
                        :geo-data="mapGeoData"
                        :focused-action="
                            actions.meta.per_page === 1
                                ? actions.data[0]
                                : undefined
                        "
                    ></Map>

                    <button
                        @click="formActive = !formActive"
                        :class="`lg-bottom-12 lg-right-12 absolute bottom-4 right-4 z-10 h-[54px] items-center justify-center whitespace-nowrap border border-transparent ${
                            formActive
                                ? 'bg-red-600 hover:bg-red-700'
                                : 'bg-primary-600  hover:bg-primary-700'
                        } px-6 text-base font-medium uppercase text-white shadow-sm`"
                    >
                        {{ formActive ? "x Cancel" : "+ Add action" }}
                    </button>
                    <div
                        v-if="formActive"
                        class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2"
                    >
                        <div class="z-10">
                            <svg
                                width="26"
                                height="26"
                                viewBox="0 0 26 26"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                                class="absolute left-1/2 h-14 w-14 -translate-x-1/2 rotate-180 rounded-full text-black backdrop-brightness-50 backdrop-grayscale backdrop-invert"
                            >
                                <path
                                    opacity="0.2"
                                    d="M25 13C25 15.3734 24.2962 17.6935 22.9776 19.6668C21.6591 21.6402 19.7849 23.1783 17.5922 24.0866C15.3995 24.9948 12.9867 25.2324 10.6589 24.7694C8.33115 24.3064 6.19295 23.1635 4.51472 21.4853C2.83649 19.8071 1.6936 17.6689 1.23058 15.3411C0.767559 13.0133 1.0052 10.6005 1.91345 8.4078C2.8217 6.21509 4.35977 4.34094 6.33316 3.02236C8.30655 1.70379 10.6266 1 13 1C16.1826 1 19.2349 2.26428 21.4853 4.51472C23.7357 6.76516 25 9.8174 25 13Z"
                                    fill="yellow"
                                />
                                <path
                                    d="M13 0C10.4288 0 7.91543 0.762437 5.77759 2.1909C3.63975 3.61935 1.97351 5.64968 0.989572 8.02512C0.0056327 10.4006 -0.251811 13.0144 0.249797 15.5362C0.751405 18.0579 1.98953 20.3743 3.80762 22.1924C5.6257 24.0105 7.94208 25.2486 10.4638 25.7502C12.9856 26.2518 15.5995 25.9944 17.9749 25.0104C20.3503 24.0265 22.3807 22.3603 23.8091 20.2224C25.2376 18.0846 26 15.5712 26 13C25.9964 9.5533 24.6256 6.24882 22.1884 3.81163C19.7512 1.37445 16.4467 0.00363977 13 0ZM14 23.9538V20C14 19.7348 13.8946 19.4804 13.7071 19.2929C13.5196 19.1054 13.2652 19 13 19C12.7348 19 12.4804 19.1054 12.2929 19.2929C12.1054 19.4804 12 19.7348 12 20V23.9538C9.44014 23.7167 7.04377 22.5919 5.22593 20.7741C3.40809 18.9562 2.28326 16.5599 2.04626 14H6.00001C6.26522 14 6.51958 13.8946 6.70711 13.7071C6.89465 13.5196 7.00001 13.2652 7.00001 13C7.00001 12.7348 6.89465 12.4804 6.70711 12.2929C6.51958 12.1054 6.26522 12 6.00001 12H2.04626C2.28326 9.44013 3.40809 7.04376 5.22593 5.22592C7.04377 3.40808 9.44014 2.28325 12 2.04625V6C12 6.26522 12.1054 6.51957 12.2929 6.70711C12.4804 6.89464 12.7348 7 13 7C13.2652 7 13.5196 6.89464 13.7071 6.70711C13.8946 6.51957 14 6.26522 14 6V2.04625C16.5599 2.28325 18.9562 3.40808 20.7741 5.22592C22.5919 7.04376 23.7168 9.44013 23.9538 12H20C19.7348 12 19.4804 12.1054 19.2929 12.2929C19.1054 12.4804 19 12.7348 19 13C19 13.2652 19.1054 13.5196 19.2929 13.7071C19.4804 13.8946 19.7348 14 20 14H23.9538C23.7168 16.5599 22.5919 18.9562 20.7741 20.7741C18.9562 22.5919 16.5599 23.7167 14 23.9538Z"
                                    fill="black"
                                />
                            </svg>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 256 256"
                                class="hidden"
                            >
                                <rect width="256" height="256" fill="none" />
                                <circle
                                    cx="128"
                                    cy="128"
                                    r="32"
                                    opacity="0.2"
                                />
                                <line
                                    x1="128"
                                    y1="232"
                                    x2="128"
                                    y2="200"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="16"
                                />
                                <circle
                                    cx="128"
                                    cy="128"
                                    r="88"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="16"
                                />
                                <line
                                    x1="128"
                                    y1="24"
                                    x2="128"
                                    y2="56"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="16"
                                />
                                <line
                                    x1="24"
                                    y1="128"
                                    x2="56"
                                    y2="128"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="16"
                                />
                                <line
                                    x1="232"
                                    y1="128"
                                    x2="200"
                                    y2="128"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="16"
                                />
                                <circle
                                    cx="128"
                                    cy="128"
                                    r="32"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="16"
                                />
                            </svg>
                            <div class="pt-20">
                                <div class="pointer-events-auto shadow-hard">
                                    <CreateAction
                                        @action-created="onActionCreated"
                                        v-bind="{ action: undefined, mapCenter: mapCenter! }"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </AuthenticatedLayout>
</template>
