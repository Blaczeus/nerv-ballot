<script setup lang="ts">
import { computed, reactive, ref, watch } from 'vue';
import { useGlobalModals } from '@/composables/useGlobalModals';

type FilterState = {
    contest: string | null;
    category: string | null;
    location: string | null;
    gender: string | null;
    min_votes: number;
    max_votes: number;
    active: boolean;
};

type ContestOption = {
    label: string;
    value: string;
};

type FilterOptions = {
    contests: ContestOption[];
    categories: string[];
    locations: string[];
    genders: string[];
};

type VoteBounds = {
    min_votes: number;
    max_votes: number;
};

const props = withDefaults(
    defineProps<{
        filters?: FilterState;
        bounds?: VoteBounds;
        options?: FilterOptions;
    }>(),
    {
        filters: () => ({
            contest: null,
            category: null,
            location: null,
            gender: null,
            min_votes: 0,
            max_votes: 10000,
            active: false,
        }),
        bounds: () => ({
            min_votes: 0,
            max_votes: 10000,
        }),
        options: () => ({
            contests: [],
            categories: [],
            locations: [],
            genders: [],
        }),
    },
);

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
    if (localFilters.min_votes < props.bounds.min_votes) {
        localFilters.min_votes = props.bounds.min_votes;
    }
    if (localFilters.max_votes > props.bounds.max_votes) {
        localFilters.max_votes = props.bounds.max_votes;
    }
    if (localFilters.min_votes > localFilters.max_votes) {
        localFilters.max_votes = localFilters.min_votes;
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
    localFilters.min_votes = Math.min(
        Math.max(value, props.bounds.min_votes),
        localFilters.max_votes,
    );
};

const updateMaxVotes = (event: Event) => {
    const value = Number((event.target as HTMLInputElement).value);
    localFilters.max_votes = Math.max(
        Math.min(value, props.bounds.max_votes),
        localFilters.min_votes,
    );
};

const minVotesLabel = computed(() => formatVotes(localFilters.min_votes));
const maxVotesLabel = computed(() => formatVotes(localFilters.max_votes));

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
                        <li v-if="props.options.contests.length === 0" class="text-secondary text-caption-1">
                            No contests available yet.
                        </li>
                        <li v-for="contest in props.options.contests" :key="contest.value">
                            <button
                                type="button"
                                class="categories-item"
                                :class="{ active: localFilters.contest === contest.value }"
                                @click="selectContest(contest.value)"
                            >
                                {{ contest.label }}
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="widget-facet facet-price">
                    <h6 class="facet-title">Votes Range</h6>
                    <div
                        class="price-val-range"
                        id="votes-value-range"
                        :data-min="props.bounds.min_votes"
                        :data-max="props.bounds.max_votes"
                    >
                        <div class="range-inputs d-flex flex-column gap-12">
                            <input
                                type="range"
                                class="tf-range-input"
                                :min="props.bounds.min_votes"
                                :max="props.bounds.max_votes"
                                :value="localFilters.min_votes"
                                @input="updateMinVotes"
                            />
                            <input
                                type="range"
                                class="tf-range-input"
                                :min="props.bounds.min_votes"
                                :max="props.bounds.max_votes"
                                :value="localFilters.max_votes"
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
                        <p v-if="props.options.categories.length === 0" class="text-secondary text-caption-1 mb-0">
                            No categories available yet.
                        </p>
                        <span
                            v-for="category in props.options.categories"
                            :key="category"
                            class="size-item size-check category-pill"
                            :class="{ active: localFilters.category === category }"
                            role="button"
                            tabindex="0"
                            @click="selectCategory(category)"
                            @keydown.enter.prevent="selectCategory(category)"
                            @keydown.space.prevent="selectCategory(category)"
                        >
                            {{ category }}
                        </span>
                    </div>
                </div>
                <div class="widget-facet facet-color">
                    <h6 class="facet-title">Location</h6>
                    <div class="facet-color-box d-flex flex-wrap gap-12">
                        <p v-if="props.options.locations.length === 0" class="text-secondary text-caption-1 mb-0">
                            No locations available yet.
                        </p>
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
                        <p v-if="props.options.genders.length === 0" class="text-secondary text-caption-1 mb-0">
                            No gender options available yet.
                        </p>
                        <fieldset
                            v-for="gender in props.options.genders"
                            :key="gender"
                            class="fieldset-item"
                        >
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
