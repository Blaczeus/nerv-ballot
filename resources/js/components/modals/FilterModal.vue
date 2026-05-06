<script setup lang="ts">
import { computed, reactive, ref, watch } from 'vue';
import { useGlobalModals } from '@/composables/useGlobalModals';

type SortOption = 'votes_desc' | 'votes_asc';

type ContestOption = {
    label: string;
    value: number;
};

type VoteBounds = {
    min_votes: number;
    max_votes: number;
};

type FilterState = {
    contest_id: number | null;
    category: string | null;
    location: string | null;
    gender: string | null;
    min_votes: number;
    max_votes: number;
    active: boolean;
    sort: SortOption;
};

type FilterOptions = {
    contests: ContestOption[];
    categories: string[];
    locations: string[];
    genders: string[];
};

const props = withDefaults(
    defineProps<{
        filters?: FilterState;
        bounds?: VoteBounds;
        options?: FilterOptions;
    }>(),
    {
        filters: () => ({
            contest_id: null,
            category: null,
            location: null,
            gender: null,
            min_votes: 0,
            max_votes: 10000,
            active: false,
            sort: 'votes_desc',
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
const isOpen = computed(() => state.activeModal === 'filter');
const isSyncing = ref(false);
const localFilters = reactive<FilterState>({ ...props.filters });
const voteFormatter = new Intl.NumberFormat('en-US');

const formatVotes = (value: number) => voteFormatter.format(value);
const normalizeVoteNumber = (value: unknown, fallback: number) => {
    const parsedValue = Number(value);

    if (!Number.isFinite(parsedValue)) {
        return fallback;
    }

    return Math.floor(parsedValue);
};

const safeBounds = computed<VoteBounds>(() => {
    const minimumVotes = normalizeVoteNumber(props.bounds?.min_votes, 0);
    const maximumVotes = normalizeVoteNumber(props.bounds?.max_votes, 10000);

    return {
        min_votes: Math.max(0, minimumVotes),
        max_votes: Math.max(Math.max(0, minimumVotes), maximumVotes),
    };
});

const safeMinVotes = computed(() => normalizeVoteNumber(localFilters.min_votes, safeBounds.value.min_votes));
const safeMaxVotes = computed(() => normalizeVoteNumber(localFilters.max_votes, safeBounds.value.max_votes));

const normalizeVotes = () => {
    const minBound = safeBounds.value.min_votes;
    const maxBound = safeBounds.value.max_votes;
    const nextMinimumVotes = Math.min(
        Math.max(normalizeVoteNumber(localFilters.min_votes, minBound), minBound),
        maxBound,
    );
    const nextMaximumVotes = Math.max(
        nextMinimumVotes,
        Math.min(
            Math.max(normalizeVoteNumber(localFilters.max_votes, maxBound), minBound),
            maxBound,
        ),
    );

    localFilters.min_votes = nextMinimumVotes;
    localFilters.max_votes = nextMaximumVotes;
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

const toggleSelection = (current: string | null, next: string) => (current === next ? null : next);

const selectContest = (contestId: number) => {
    localFilters.contest_id = localFilters.contest_id === contestId ? null : contestId;
};

const selectCategory = (category: string) => {
    localFilters.category = toggleSelection(localFilters.category, category);
};

const selectLocation = (location: string) => {
    localFilters.location = toggleSelection(localFilters.location, location);
};

const selectGender = (gender: string) => {
    localFilters.gender = toggleSelection(localFilters.gender, gender);
};

const toggleActiveOnly = () => {
    localFilters.active = !localFilters.active;
};

const updateMinVotes = (event: Event) => {
    const value = normalizeVoteNumber(
        (event.target as HTMLInputElement).value,
        safeBounds.value.min_votes,
    );
    localFilters.min_votes = Math.min(
        Math.max(value, safeBounds.value.min_votes),
        safeMaxVotes.value,
    );
};

const updateMaxVotes = (event: Event) => {
    const value = normalizeVoteNumber(
        (event.target as HTMLInputElement).value,
        safeBounds.value.max_votes,
    );
    localFilters.max_votes = Math.max(
        Math.min(value, safeBounds.value.max_votes),
        safeMinVotes.value,
    );
};

const updateMinVotesInput = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const rawValue = target.value.trim();

    if (rawValue === '') {
        localFilters.min_votes = safeBounds.value.min_votes;
        return;
    }

    updateMinVotes(event);
};

const updateMaxVotesInput = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const rawValue = target.value.trim();

    if (rawValue === '') {
        localFilters.max_votes = safeBounds.value.max_votes;
        return;
    }

    updateMaxVotes(event);
};

const minVotesLabel = computed(() => formatVotes(safeMinVotes.value));
const maxVotesLabel = computed(() => formatVotes(safeMaxVotes.value));

const locationColorMap: Record<string, string> = {
    Lagos: 'bg-light-pink-2',
    Abuja: 'bg-red',
    Accra: 'bg-beige-2',
    London: 'bg-orange-2',
    Nairobi: 'bg-light-green',
};

const resolveLocationColor = (location: string) => locationColorMap[location] ?? 'bg-grey-2';
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
                <span class="icon-close icon-close-popup" aria-label="Close" @click="closeModal('filter')"></span>
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
                                :class="{ active: localFilters.contest_id === contest.value }"
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
                        :data-min="safeBounds.min_votes"
                        :data-max="safeBounds.max_votes"
                    >
                        <div class="range-inputs d-flex flex-column gap-12">
                            <div class="vote-range-input-grid">
                                <label class="vote-range-field">
                                    <span class="title-price">Min votes</span>
                                    <input
                                        type="number"
                                        class="vote-range-number-input"
                                        :min="safeBounds.min_votes"
                                        :max="safeMaxVotes"
                                        :value="safeMinVotes"
                                        @input="updateMinVotesInput"
                                    />
                                </label>
                                <label class="vote-range-field">
                                    <span class="title-price">Max votes</span>
                                    <input
                                        type="number"
                                        class="vote-range-number-input"
                                        :min="safeMinVotes"
                                        :max="safeBounds.max_votes"
                                        :value="safeMaxVotes"
                                        @input="updateMaxVotesInput"
                                    />
                                </label>
                            </div>
                            <input
                                type="range"
                                class="tf-range-input"
                                :min="safeBounds.min_votes"
                                :max="safeBounds.max_votes"
                                :value="safeMinVotes"
                                @input="updateMinVotes"
                            />
                            <input
                                type="range"
                                class="tf-range-input"
                                :min="safeBounds.min_votes"
                                :max="safeBounds.max_votes"
                                :value="safeMaxVotes"
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
                    <div class="facet-size-box size-box category-filter-box">
                        <p v-if="props.options.genders.length === 0" class="text-secondary text-caption-1 mb-0">
                            No gender options available yet.
                        </p>
                        <span
                            v-for="gender in props.options.genders"
                            :key="gender"
                            class="size-item size-check category-pill"
                            :class="{ active: localFilters.gender === gender }"
                            role="button"
                            tabindex="0"
                            @click="selectGender(gender)"
                            @keydown.enter.prevent="selectGender(gender)"
                            @keydown.space.prevent="selectGender(gender)"
                        >
                            {{ gender }}
                        </span>
                    </div>
                </div>

                <div class="widget-facet facet-fieldset">
                    <h6 class="facet-title">Contest Status</h6>
                    <button
                        type="button"
                        class="categories-item active-toggle-btn"
                        :class="{ active: localFilters.active }"
                        @click="toggleActiveOnly"
                    >
                        Active contests only
                    </button>
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

.range-inputs .tf-range-input {
    width: 100%;
}

.vote-range-input-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
}

.vote-range-field {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.vote-range-number-input {
    width: 100%;
    min-height: 48px;
    border: 1px solid rgba(24, 24, 24, 0.14);
    border-radius: 12px;
    padding: 12px 14px;
    background: #fff;
    color: #181818;
}

.vote-range-number-input:focus-visible {
    outline: 1px solid var(--main);
    border-color: var(--main);
}

.active-toggle-btn {
    border: 1px solid rgba(24, 24, 24, 0.1);
    border-radius: 999px;
    padding: 12px 18px;
    background: #fff;
    transition: all 0.2s ease;
}

.active-toggle-btn.active {
    background: var(--main);
    border-color: var(--main);
    color: var(--white);
}
</style>
