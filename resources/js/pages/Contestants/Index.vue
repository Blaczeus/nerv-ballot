<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import ContestantCard from '@/components/contestants/ContestantCard.vue';
import FilterModal from '@/components/modals/FilterModal.vue';
import Breadcrumb from '@/components/ui/Breadcrumb.vue';
import { useGlobalModals } from '@/composables/useGlobalModals';
import { useVoteCart } from '@/composables/useVoteCart';
import { contestants as contestantsData } from '@/data/contestants';
import Layout from '@/layouts/Layout.vue';

type Contestant = (typeof contestantsData)[number];

type FiltersState = {
    contest: string | null;
    category: string | null;
    location: string | null;
    gender: string | null;
    minVotes: number;
    maxVotes: number;
    activeContestsOnly: boolean;
};

type SortOption = 'most-votes' | 'trending' | 'recent' | 'name-az';

type FilterChipKey =
    | 'active'
    | 'contest'
    | 'category'
    | 'location'
    | 'gender'
    | 'votes';

type FilterChip = {
    key: FilterChipKey;
    label: string;
};

const contestants = contestantsData;

const voteFormatter = new Intl.NumberFormat('en-US');
const formatVotes = (value: number) => voteFormatter.format(value);

const voteBounds = computed(() => {
    const values = contestants.map((contestant) => contestant.votes);
    const minVotes = Math.min(...values);
    const maxVotes = Math.max(...values);
    return { minVotes, maxVotes };
});

const createDefaultFilters = (): FiltersState => ({
    contest: null,
    category: null,
    location: null,
    gender: null,
    minVotes: voteBounds.value.minVotes,
    maxVotes: voteBounds.value.maxVotes,
    activeContestsOnly: false,
});

const filters = ref<FiltersState>(createDefaultFilters());

const filterOptions = computed(() => {
    const uniqueSorted = (items: string[]) => {
        return [...new Set(items)].sort((a, b) => a.localeCompare(b));
    };

    return {
        contests: uniqueSorted(contestants.map((contestant) => contestant.contestName)),
        categories: uniqueSorted(contestants.map((contestant) => contestant.category)),
        locations: uniqueSorted(contestants.map((contestant) => contestant.location)),
        genders: uniqueSorted(contestants.map((contestant) => contestant.gender)),
    };
});

const sortOptions: Array<{ value: SortOption; label: string }> = [
    { value: 'most-votes', label: 'Highest Votes' },
    { value: 'trending', label: 'Trending' },
    { value: 'recent', label: 'Recently Added' },
    { value: 'name-az', label: 'Alphabetical (A-Z)' },
];

const sortOption = ref<SortOption>('most-votes');

const setSortOption = (value: SortOption) => {
    sortOption.value = value;
};

const currentSortLabel = computed(() => {
    return sortOptions.find((option) => option.value === sortOption.value)?.label ?? 'Highest Votes';
});

const parseDate = (value: string) => new Date(`${value}T00:00:00`);

const isContestActive = (contestant: Contestant) => {
    const startDate = parseDate(contestant.contestStart);
    const endDate = parseDate(contestant.contestEnd);
    const today = new Date();
    return today >= startDate && today <= endDate;
};

const filteredContestants = computed(() => {
    return contestants.filter((contestant) => {
        if (filters.value.activeContestsOnly && !isContestActive(contestant)) {
            return false;
        }
        if (filters.value.contest && contestant.contestName !== filters.value.contest) {
            return false;
        }
        if (filters.value.category && contestant.category !== filters.value.category) {
            return false;
        }
        if (filters.value.location && contestant.location !== filters.value.location) {
            return false;
        }
        if (filters.value.gender && contestant.gender !== filters.value.gender) {
            return false;
        }
        if (
            contestant.votes < filters.value.minVotes ||
            contestant.votes > filters.value.maxVotes
        ) {
            return false;
        }
        return true;
    });
});

const getTrendingScore = (contestant: Contestant) => {
    const today = new Date();
    const createdDate = parseDate(contestant.createdAt);
    const ageDays = Math.max(1, (today.getTime() - createdDate.getTime()) / 86400000);
    return contestant.votes / ageDays;
};

const sortedContestants = computed(() => {
    const list = [...filteredContestants.value];
    switch (sortOption.value) {
        case 'most-votes':
            return list.sort((a, b) => b.votes - a.votes);
        case 'trending':
            return list.sort((a, b) => getTrendingScore(b) - getTrendingScore(a));
        case 'recent':
            return list.sort(
                (a, b) => parseDate(b.createdAt).getTime() - parseDate(a.createdAt).getTime(),
            );
        case 'name-az':
            return list.sort((a, b) => a.name.localeCompare(b.name));
        default:
            return list;
    }
});

const displayedContestants = computed(() => sortedContestants.value);

const hasVoteRangeFilter = computed(() => {
    return (
        filters.value.minVotes > voteBounds.value.minVotes ||
        filters.value.maxVotes < voteBounds.value.maxVotes
    );
});

const hasActiveFilters = computed(() => {
    return Boolean(
        filters.value.activeContestsOnly ||
            filters.value.contest ||
            filters.value.category ||
            filters.value.location ||
            filters.value.gender ||
            hasVoteRangeFilter.value,
    );
});

const filterChips = computed<FilterChip[]>(() => {
    const chips: FilterChip[] = [];

    if (filters.value.activeContestsOnly) {
        chips.push({ key: 'active', label: 'Active Contests' });
    }
    if (filters.value.contest) {
        chips.push({ key: 'contest', label: `Contest: ${filters.value.contest}` });
    }
    if (filters.value.category) {
        chips.push({ key: 'category', label: `Category: ${filters.value.category}` });
    }
    if (filters.value.location) {
        chips.push({ key: 'location', label: `Location: ${filters.value.location}` });
    }
    if (filters.value.gender) {
        chips.push({ key: 'gender', label: `Gender: ${filters.value.gender}` });
    }
    if (hasVoteRangeFilter.value) {
        chips.push({
            key: 'votes',
            label: `Votes: ${formatVotes(filters.value.minVotes)} - ${formatVotes(filters.value.maxVotes)}`,
        });
    }

    return chips;
});

const removeFilter = (key: FilterChipKey) => {
    switch (key) {
        case 'active':
            filters.value.activeContestsOnly = false;
            break;
        case 'contest':
            filters.value.contest = null;
            break;
        case 'category':
            filters.value.category = null;
            break;
        case 'location':
            filters.value.location = null;
            break;
        case 'gender':
            filters.value.gender = null;
            break;
        case 'votes':
            filters.value.minVotes = voteBounds.value.minVotes;
            filters.value.maxVotes = voteBounds.value.maxVotes;
            break;
    }
};

const resetFilters = () => {
    filters.value = createDefaultFilters();
};

const updateFilters = (nextFilters: FiltersState) => {
    filters.value = { ...filters.value, ...nextFilters };
};

const toggleActiveContests = () => {
    filters.value.activeContestsOnly = !filters.value.activeContestsOnly;
};

const { openQuickView, openCart, openFilter } = useGlobalModals();
const { addVotes } = useVoteCart();
type GridLayoutClass = 'tf-col-2' | 'tf-col-3' | 'tf-col-4' | 'tf-col-5';
type LayoutMode = 'list' | GridLayoutClass;

const LAYOUT_STORAGE_KEY = 'contestants.layout';
const layoutOptions: LayoutMode[] = ['list', 'tf-col-2', 'tf-col-3', 'tf-col-4', 'tf-col-5'];
const resolveInitialLayout = (): LayoutMode => {
    if (typeof window === 'undefined') return 'tf-col-4';
    const stored = window.localStorage.getItem(LAYOUT_STORAGE_KEY);
    if (stored && layoutOptions.includes(stored as LayoutMode)) {
        return stored as LayoutMode;
    }
    return 'tf-col-4';
};

const layoutMode = ref<LayoutMode>(resolveInitialLayout());

const isListLayout = computed(() => layoutMode.value === 'list');
const activeGridLayout = computed<GridLayoutClass>(() => {
    return layoutMode.value === 'list' ? 'tf-col-4' : layoutMode.value;
});

const wrapperControlShopClass = computed(() => {
    return [
        'wrapper-control-shop',
        isListLayout.value ? 'listLayout-wrapper' : 'gridLayout-wrapper',
    ];
});

const gridLayoutClass = computed(() => {
    return `tf-grid-layout wrapper-shop ${activeGridLayout.value}`;
});

const setLayoutMode = (mode: LayoutMode) => {
    layoutMode.value = mode;
    if (typeof window !== 'undefined') {
        window.localStorage.setItem(LAYOUT_STORAGE_KEY, mode);
    }
};

const handleAddVotes = (contestant: Contestant) => {
    addVotes(contestant.id, 1);
    openCart(contestant);
};

const breadcrumbItems = [
    { label: 'Home', link: '/' },
    { label: 'Contestants' },
];
</script>

<template>
    <Head title="Contestants" />

    <Layout>
        <template #filterModal>
            <FilterModal
                :filters="filters"
                :bounds="voteBounds"
                :options="filterOptions"
                @update:filters="updateFilters"
                @reset="resetFilters"
            />
        </template>
        <Breadcrumb
            :items="breadcrumbItems"
            design="image"
            heading="Explore Contestants"
            subtitle="Discover contestants from active competitions and support your favorites."
            background-image="/tmp/images/section/page-title.jpg"
            container-class="container-full"
            :use-row="true"
        />
        <!-- Section product -->
        <section class="flat-spacing">
            <div class="container">
                <div class="tf-shop-control">
                    <div class="tf-control-filter">
                        <a
                            href="#filterShop"
                            class="tf-btn-filter flex items-center justify-center gap-8"
                            @click.prevent="openFilter"
                        >
                            <span class="icon icon-filter"></span>
                            <span class="text">Filters</span>
                        </a>
                        <button
                            type="button"
                            class="d-none d-lg-flex shop-sale-text align-items-center gap-8"
                            :aria-pressed="filters.activeContestsOnly"
                            @click="toggleActiveContests"
                        >
                            <i
                                class="icon icon-checkCircle"
                                :class="{ 'text-success': filters.activeContestsOnly }"
                            ></i>
                            <p class="text-caption-1 mb-0">Active Contests</p>
                        </button>
                    </div>
                    <ul class="tf-control-layout">
                        <li
                            :class="[
                                'tf-view-layout-switch sw-layout-list list-layout',
                                { active: layoutMode === 'list' },
                            ]"
                            data-value-layout="list"
                            @click="setLayoutMode('list')"
                        >
                            <div class="item">
                                <svg
                                    class="icon"
                                    width="20"
                                    height="20"
                                    viewBox="0 0 20 20"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <circle cx="3" cy="6" r="2.5" stroke="#181818" />
                                    <rect x="7.5" y="3.5" width="12" height="5" rx="2.5" stroke="#181818" />
                                    <circle cx="3" cy="14" r="2.5" stroke="#181818" />
                                    <rect x="7.5" y="11.5" width="12" height="5" rx="2.5" stroke="#181818" />
                                </svg>
                            </div>
                        </li>
                        <li
                            :class="[
                                'tf-view-layout-switch sw-layout-2',
                                { active: layoutMode === 'tf-col-2' },
                            ]"
                            data-value-layout="tf-col-2"
                            @click="setLayoutMode('tf-col-2')"
                        >
                            <div class="item">
                                <svg
                                    class="icon"
                                    width="20"
                                    height="20"
                                    viewBox="0 0 20 20"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <circle cx="6" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="14" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="6" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="14" cy="14" r="2.5" stroke="#181818" />
                                </svg>
                            </div>
                        </li>
                        <li
                            :class="[
                                'tf-view-layout-switch sw-layout-3',
                                { active: layoutMode === 'tf-col-3' },
                            ]"
                            data-value-layout="tf-col-3"
                            @click="setLayoutMode('tf-col-3')"
                        >
                            <div class="item">
                                <svg
                                    class="icon"
                                    width="22"
                                    height="20"
                                    viewBox="0 0 22 20"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <circle cx="3" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="11" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="19" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="3" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="11" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="19" cy="14" r="2.5" stroke="#181818" />
                                </svg>
                            </div>
                        </li>
                        <li
                            :class="[
                                'tf-view-layout-switch sw-layout-4',
                                { active: layoutMode === 'tf-col-4' },
                            ]"
                            data-value-layout="tf-col-4"
                            @click="setLayoutMode('tf-col-4')"
                        >
                            <div class="item">
                                <svg
                                    class="icon"
                                    width="30"
                                    height="20"
                                    viewBox="0 0 30 20"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <circle cx="3" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="11" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="19" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="27" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="3" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="11" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="19" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="27" cy="14" r="2.5" stroke="#181818" />
                                </svg>
                            </div>
                        </li>
                        <li
                            :class="[
                                'tf-view-layout-switch sw-layout-5',
                                { active: layoutMode === 'tf-col-5' },
                            ]"
                            data-value-layout="tf-col-5"
                            @click="setLayoutMode('tf-col-5')"
                        >
                            <div class="item">
                                <svg
                                    class="icon"
                                    width="38"
                                    height="20"
                                    viewBox="0 0 38 20"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <circle cx="3" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="11" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="19" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="27" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="35" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="3" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="11" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="19" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="27" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="35" cy="14" r="2.5" stroke="#181818" />
                                </svg>
                            </div>
                        </li>
                    </ul>
                    <div class="tf-control-sorting">
                        <p class="d-none d-lg-block text-caption-1">Sort by:</p>
                        <div class="tf-dropdown-sort" data-bs-toggle="dropdown">
                            <div class="btn-select">
                                <span class="text-sort-value">{{ currentSortLabel }}</span>
                                <span class="icon icon-arrow-down"></span>
                            </div>
                            <div class="dropdown-menu">
                                <div
                                    v-for="option in sortOptions"
                                    :key="option.value"
                                    class="select-item"
                                    :class="{ active: sortOption === option.value }"
                                    @click="setSortOption(option.value)"
                                >
                                    <span class="text-value-item">{{ option.label }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div :class="wrapperControlShopClass">
                    <div v-if="hasActiveFilters" class="meta-filter-shop">
                        <div class="count-text">
                            <span class="count">{{ displayedContestants.length }}</span> Contestants Found
                        </div>
                        <div id="applied-filters" class="text-caption-1">
                            <span v-for="chip in filterChips" :key="chip.key" class="filter-tag">
                                {{ chip.label }}
                                <span
                                    class="remove-tag icon-close"
                                    role="button"
                                    @click="removeFilter(chip.key)"
                                ></span>
                            </span>
                        </div>
                        <button
                            id="remove-all"
                            class="remove-all-filters text-btn-uppercase"
                            type="button"
                            @click="resetFilters"
                        >
                            REMOVE ALL <i class="icon icon-close"></i>
                        </button>
                    </div>
                    <div v-show="isListLayout" class="tf-list-layout wrapper-shop" id="listLayout">
                        <ContestantCard
                            v-for="contestant in displayedContestants"
                            :key="contestant.id"
                            :contestant="contestant"
                            layout="list"
                            @quick-view="openQuickView"
                            @add-to-cart="handleAddVotes"
                        />
                        <!-- pagination -->
                        <ul class="wg-pagination">
                            <li><a href="#" class="pagination-item text-button">1</a></li>
                            <li class="active">
                                <div class="pagination-item text-button">2</div>
                            </li>
                            <li><a href="#" class="pagination-item text-button">3</a></li>
                            <li>
                                <a href="#" class="pagination-item text-button">
                                    <i class="icon-arrRight"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div v-show="!isListLayout" :class="gridLayoutClass" id="gridLayout">
                        <ContestantCard
                            v-for="contestant in displayedContestants"
                            :key="`grid-${contestant.id}`"
                            :contestant="contestant"
                            layout="grid"
                            @quick-view="openQuickView"
                            @add-to-cart="handleAddVotes"
                        />
                        <!-- pagination -->
                        <ul class="wg-pagination">
                            <li><a href="#" class="pagination-item text-button">1</a></li>
                            <li class="active">
                                <div class="pagination-item text-button">2</div>
                            </li>
                            <li><a href="#" class="pagination-item text-button">3</a></li>
                            <li>
                                <a href="#" class="pagination-item text-button">
                                    <i class="icon-arrRight"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Section product -->
    </Layout>
</template>
