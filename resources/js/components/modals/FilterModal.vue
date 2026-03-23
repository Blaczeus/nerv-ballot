<script setup lang="ts">
import { computed, reactive, ref, watch } from 'vue';
import { useGlobalModals } from '@/composables/useGlobalModals';

type FilterState = {
    contest: string | null;
    category: string | null;
    location: string | null;
    gender: string | null;
    minVotes: number;
    maxVotes: number;
    activeContestsOnly: boolean;
};

type FilterOptions = {
    contests: string[];
    categories: string[];
    locations: string[];
    genders: string[];
};

type VoteBounds = {
    minVotes: number;
    maxVotes: number;
};

const props = withDefaults(defineProps<{
    filters?: FilterState;
    bounds?: VoteBounds;
    options?: FilterOptions;
}>(), {
    filters: () => ({
        contest: null,
        category: null,
        location: null,
        gender: null,
        minVotes: 0,
        maxVotes: 5000,
        activeContestsOnly: false,
    }),
    bounds: () => ({
        minVotes: 0,
        maxVotes: 5000,
    }),
    options: () => ({
        contests: [
            'Campus Queen 2026',
            'Global Talent Showcase',
            'Mr & Miss Tech Fest',
            'Community Awards',
        ],
        categories: ['Beauty', 'Talent', 'Personality', 'Innovation', 'Leadership'],
        locations: ['Lagos', 'Abuja', 'Accra', 'London', 'Nairobi'],
        genders: ['Male', 'Female', 'Mixed'],
    }),
});

const emit = defineEmits<{
    (event: 'update:filters', value: FilterState): void;
    (event: 'reset'): void;
}>();

const { state, closeModal } = useGlobalModals();
const localFilters = reactive<FilterState>({ ...props.filters });
const isSyncing = ref(false);
const isOpen = computed(() => state.activeModal === 'filter');

const voteFormatter = new Intl.NumberFormat('en-US');
const formatVotes = (value: number) => voteFormatter.format(value);

const normalizeVotes = () => {
    if (localFilters.minVotes < props.bounds.minVotes) {
        localFilters.minVotes = props.bounds.minVotes;
    }
    if (localFilters.maxVotes > props.bounds.maxVotes) {
        localFilters.maxVotes = props.bounds.maxVotes;
    }
    if (localFilters.minVotes > localFilters.maxVotes) {
        localFilters.maxVotes = localFilters.minVotes;
    }
};

watch(
    () => props.filters,
    (value) => {
        if (!value) return;
        isSyncing.value = true;
        Object.assign(localFilters, value);
        normalizeVotes();
        Promise.resolve().then(() => {
            isSyncing.value = false;
        });
    },
    { deep: true, immediate: true },
);

watch(
    () => props.bounds,
    () => {
        normalizeVotes();
    },
    { deep: true },
);

watch(
    localFilters,
    () => {
        if (isSyncing.value) return;
        emit('update:filters', { ...localFilters });
    },
    { deep: true },
);

const toggleSelection = (current: string | null, next: string) => {
    return current === next ? null : next;
};

const selectContest = (contest: string) => {
    localFilters.contest = toggleSelection(localFilters.contest, contest);
};

const selectCategory = (category: string) => {
    localFilters.category = toggleSelection(localFilters.category, category);
};

const selectLocation = (location: string) => {
    localFilters.location = toggleSelection(localFilters.location, location);
};

const updateMinVotes = (event: Event) => {
    const value = Number((event.target as HTMLInputElement).value);
    localFilters.minVotes = Math.min(
        Math.max(value, props.bounds.minVotes),
        localFilters.maxVotes,
    );
};

const updateMaxVotes = (event: Event) => {
    const value = Number((event.target as HTMLInputElement).value);
    localFilters.maxVotes = Math.max(
        Math.min(value, props.bounds.maxVotes),
        localFilters.minVotes,
    );
};

const minVotesLabel = computed(() => formatVotes(localFilters.minVotes));
const maxVotesLabel = computed(() => formatVotes(localFilters.maxVotes));

const locationColorMap: Record<string, string> = {
    Lagos: 'bg-light-pink-2',
    Abuja: 'bg-red',
    Accra: 'bg-beige-2',
    London: 'bg-orange-2',
    Nairobi: 'bg-light-green',
};

const resolveLocationColor = (location: string) => {
    return locationColorMap[location] ?? 'bg-grey-2';
};
</script>

<template>
    <div
        v-if="isOpen"
        class="offcanvas offcanvas-start canvas-filter show"
        id="filterShop"
        style="visibility: visible;"
        @click.self="closeModal('filter')"
    >
        <div class="canvas-wrapper">
            <div class="canvas-header">
                <h5>Filter Contestants</h5>
                <span
                    class="icon-close icon-close-popup"
                    aria-label="Close"
                    @click="closeModal('filter')"
                ></span>
            </div>
            <div class="canvas-body">
                <div class="widget-facet facet-categories">
                    <h6 class="facet-title">Contests</h6>
                    <ul class="facet-content">
                        <li v-for="contest in props.options.contests" :key="contest">
                            <button
                                type="button"
                                class="categories-item"
                                :class="{ active: localFilters.contest === contest }"
                                @click="selectContest(contest)"
                            >
                                {{ contest }}
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="widget-facet facet-price">
                    <h6 class="facet-title">Votes Range</h6>
                    <div
                        class="price-val-range"
                        id="votes-value-range"
                        :data-min="props.bounds.minVotes"
                        :data-max="props.bounds.maxVotes"
                    >
                        <div class="range-inputs d-flex flex-column gap-12">
                            <input
                                type="range"
                                class="tf-range-input"
                                :min="props.bounds.minVotes"
                                :max="props.bounds.maxVotes"
                                :value="localFilters.minVotes"
                                @input="updateMinVotes"
                            />
                            <input
                                type="range"
                                class="tf-range-input"
                                :min="props.bounds.minVotes"
                                :max="props.bounds.maxVotes"
                                :value="localFilters.maxVotes"
                                @input="updateMaxVotes"
                            />
                        </div>
                    </div>
                    <div class="box-price-product">
                        <div class="box-price-item">
                            <span class="title-price">Min votes</span>
                            <div class="price-val" data-currency="votes">{{ minVotesLabel }}</div>
                        </div>
                        <div class="box-price-item">
                            <span class="title-price">Max votes</span>
                            <div class="price-val" data-currency="votes">{{ maxVotesLabel }}</div>
                        </div>
                    </div>
                </div>
                <div class="widget-facet facet-size">
                    <h6 class="facet-title">Category</h6>
                    <div class="facet-size-box size-box category-filter-box">
                        <span
                            v-for="category in props.options.categories"
                            :key="category"
                            class="size-item size-check category-pill"
                            :class="{ active: localFilters.category === category }"
                            @click="selectCategory(category)"
                            @keydown.enter.prevent="selectCategory(category)"
                            @keydown.space.prevent="selectCategory(category)"
                            role="button"
                            tabindex="0"
                        >
                            {{ category }}
                        </span>
                    </div>
                </div>
                <div class="widget-facet facet-color">
                    <h6 class="facet-title">Location</h6>
                    <div class="facet-color-box d-flex flex-wrap gap-12">
                        <button
                            v-for="location in props.options.locations"
                            :key="location"
                            type="button"
                            class="color-item color-check"
                            :class="{ active: localFilters.location === location }"
                            @click="selectLocation(location)"
                        >
                            <span class="color" :class="resolveLocationColor(location)"></span>
                            {{ location }}
                        </button>
                    </div>
                </div>
                <div class="widget-facet facet-fieldset">
                    <h6 class="facet-title">Gender</h6>
                    <div class="box-fieldset-item">
                        <fieldset class="fieldset-item" v-for="gender in props.options.genders" :key="gender">
                            <input
                                :id="`gender-${gender}`"
                                v-model="localFilters.gender"
                                type="radio"
                                name="gender"
                                class="tf-check"
                                :value="gender"
                            />
                            <label :for="`gender-${gender}`">{{ gender }}</label>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="canvas-bottom">
                <button id="reset-filter" class="tf-btn btn-reset" type="button" @click="emit('reset')">
                    Reset Filters
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.category-filter-box {
    padding-right: 0;
}

.category-filter-box .category-pill {
    width: auto !important;
    min-width: 0;
    height: auto !important;
    padding: 10px 18px;
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    background-color: var(--main);
    border-color: var(--main);
    color: var(--white);
    font-size: 14px;
    line-height: 20px;
    text-transform: none;
    white-space: nowrap;
    text-align: center;
}

.category-filter-box .category-pill:hover,
.category-filter-box .category-pill:focus-visible {
    background-color: var(--white);
    color: var(--main);
    border-color: var(--main);
    outline: none;
}

.category-filter-box .category-pill.active {
    background-color: var(--main);
    color: var(--white);
    border-color: var(--main);
}
</style>
