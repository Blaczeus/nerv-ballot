<script setup lang="ts">
import { useDebounceFn } from '@vueuse/core';
import { Head, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import ContestantCard from '@/components/contestants/ContestantCard.vue';
import FilterModal from '@/components/modals/FilterModal.vue';
import Breadcrumb from '@/components/ui/Breadcrumb.vue';
import Pagination from '@/components/ui/Pagination.vue';
import type { ModalContestant } from '@/composables/useGlobalModals';
import { useGlobalModals } from '@/composables/useGlobalModals';
import { useVoteCart } from '@/composables/useVoteCart';
import Layout from '@/layouts/Layout.vue';

type SortOption = 'most-votes' | 'recent' | 'name-az';

type FiltersState = {
    contest: string | null;
    category: string | null;
    location: string | null;
    gender: string | null;
    min_votes: number;
    max_votes: number;
    active: boolean;
};

type FilterChipKey = 'active' | 'contest' | 'category' | 'location' | 'gender' | 'votes';

type FilterChip = {
    key: FilterChipKey;
    label: string;
};

type GridLayoutClass = 'tf-col-2' | 'tf-col-3' | 'tf-col-4' | 'tf-col-5';
type LayoutMode = 'list' | GridLayoutClass;

type BackendContestant = {
    id: number;
    name: string;
    slug: string;
    image: string | null;
    total_votes: number;
    contest_id: number;
    category: string | null;
    gender: string | null;
    location: string | null;
    description: string | null;
    created_at: string | null;
    contest: {
        id: number;
        name: string;
        slug: string;
        start_date: string | null;
        end_date: string | null;
    } | null;
};

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

type PageProps = {
    contestants: {
        data: BackendContestant[];
        meta: {
            total: number;
            links: PaginationLink[];
        };
    };
    filterOptions: {
        contests: Array<{ label: string; value: string }>;
        categories: string[];
        locations: string[];
        genders: string[];
    };
    voteBounds: {
        min_votes: number;
        max_votes: number;
    };
};

const FALLBACK_IMAGE = '/tmp/images/products/womens/women-19.jpg';
const LAYOUT_STORAGE_KEY = 'contestants.layout';
const layoutOptions: LayoutMode[] = ['list', 'tf-col-2', 'tf-col-3', 'tf-col-4', 'tf-col-5'];

const page = usePage<PageProps>();
const { openQuickView, openCart, openFilter } = useGlobalModals();
const { addVotes } = useVoteCart();

const voteFormatter = new Intl.NumberFormat('en-US');
const formatVoteNumber = (value: number) => voteFormatter.format(value);

const rawContestants = computed(() => page.props.contestants?.data ?? []);
const meta = computed(() => {
    return page.props.contestants?.meta ?? { total: 0, links: [] };
});

const voteBounds = computed(() => ({
    min_votes: meta.value.total === 0 ? 0 : Number(page.props.voteBounds?.min_votes ?? 0),
    max_votes: meta.value.total === 0 ? 10000 : Number(page.props.voteBounds?.max_votes ?? 10000),
}));

const filterOptions = computed(() => {
    return (
        page.props.filterOptions ?? {
            contests: [],
            categories: [],
            locations: [],
            genders: [],
        }
    );
});

const contestants = computed<ModalContestant[]>(() => {
    return rawContestants.value.map((contestant) => ({
        id: contestant.id,
        slug: contestant.slug,
        name: contestant.name,
        contestName: contestant.contest?.name ?? 'Contest',
        category: contestant.category ?? 'Uncategorized',
        gender: contestant.gender ?? 'unknown',
        location: contestant.location ?? 'unspecified',
        votes: contestant.total_votes ?? 0,
        contestStart: contestant.contest?.start_date?.slice(0, 10) ?? '',
        contestEnd: contestant.contest?.end_date?.slice(0, 10) ?? '',
        createdAt: contestant.created_at?.slice(0, 10) ?? '',
        image: contestant.image ?? FALLBACK_IMAGE,
        hoverImage: contestant.image ?? FALLBACK_IMAGE,
        description: contestant.description ?? '',
    }));
});

const createDefaultFilters = (bounds = voteBounds.value): FiltersState => {
    return {
        contest: null,
        category: null,
        location: null,
        gender: null,
        min_votes: bounds.min_votes,
        max_votes: bounds.max_votes,
        active: false,
    };
};

const resolveInitialFilters = (): FiltersState => {
    const query = typeof window !== 'undefined' ? new URLSearchParams(window.location.search) : new URLSearchParams();
    const defaults = createDefaultFilters(voteBounds.value);

    return {
        contest: query.get('contest'),
        category: query.get('category'),
        location: query.get('location'),
        gender: query.get('gender'),
        min_votes: Number(query.get('min_votes')) || defaults.min_votes,
        max_votes: Number(query.get('max_votes')) || defaults.max_votes,
        active: query.get('active') === '1',
    };
};

const filters = ref<FiltersState>(resolveInitialFilters());
const sortOptions: Array<{ value: SortOption; label: string }> = [
    { value: 'most-votes', label: 'Highest Votes' },
    { value: 'recent', label: 'Recently Added' },
    { value: 'name-az', label: 'Alphabetical (A-Z)' },
];

const sortOption = ref<SortOption>(
    (() => {
        const query = typeof window !== 'undefined' ? new URLSearchParams(window.location.search) : new URLSearchParams();
        const sort = query.get('sort');
        return sort === 'recent' || sort === 'name-az' || sort === 'most-votes' ? sort : 'most-votes';
    })(),
);

const buildFilterParams = () => {
    const defaults = createDefaultFilters(voteBounds.value);

    return {
        contest: filters.value.contest ?? undefined,
        category: filters.value.category ?? undefined,
        location: filters.value.location ?? undefined,
        gender: filters.value.gender ?? undefined,
        min_votes:
            filters.value.min_votes !== defaults.min_votes ? filters.value.min_votes : undefined,
        max_votes:
            filters.value.max_votes !== defaults.max_votes ? filters.value.max_votes : undefined,
        active: filters.value.active ? 1 : undefined,
        sort: sortOption.value !== 'most-votes' ? sortOption.value : undefined,
    };
};

const applyFilters = useDebounceFn(() => {
    router.get(
        route('contestants.index'),
        buildFilterParams(),
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
}, 300);

const currentSortLabel = computed(() => {
    return sortOptions.find((option) => option.value === sortOption.value)?.label ?? 'Highest Votes';
});

const hasVoteRangeFilter = computed(() => {
    return (
        filters.value.min_votes > voteBounds.value.min_votes ||
        filters.value.max_votes < voteBounds.value.max_votes
    );
});

const hasActiveFilters = computed(() => {
    return Boolean(
        filters.value.active ||
            filters.value.contest ||
            filters.value.category ||
            filters.value.location ||
            filters.value.gender ||
            hasVoteRangeFilter.value,
    );
});

const contestLabelMap = computed(() => {
    return Object.fromEntries(
        filterOptions.value.contests.map((contest) => [contest.value, contest.label]),
    );
});

const filterChips = computed<FilterChip[]>(() => {
    const chips: FilterChip[] = [];

    if (filters.value.active) {
        chips.push({ key: 'active', label: 'Active Contests' });
    }
    if (filters.value.contest) {
        chips.push({
            key: 'contest',
            label: `Contest: ${contestLabelMap.value[filters.value.contest] ?? filters.value.contest}`,
        });
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
            label: `Votes: ${formatVoteNumber(filters.value.min_votes)} - ${formatVoteNumber(filters.value.max_votes)}`,
        });
    }

    return chips;
});

const updateFilters = (nextFilters: FiltersState) => {
    filters.value = { ...filters.value, ...nextFilters };
    applyFilters();
};

const setSortOption = (value: SortOption) => {
    sortOption.value = value;
    applyFilters();
};

const toggleActiveContests = () => {
    filters.value = { ...filters.value, active: !filters.value.active };
    applyFilters();
};

const removeFilter = (key: FilterChipKey) => {
    const defaults = createDefaultFilters(voteBounds.value);

    switch (key) {
        case 'active':
            filters.value = { ...filters.value, active: false };
            break;
        case 'contest':
            filters.value = { ...filters.value, contest: null };
            break;
        case 'category':
            filters.value = { ...filters.value, category: null };
            break;
        case 'location':
            filters.value = { ...filters.value, location: null };
            break;
        case 'gender':
            filters.value = { ...filters.value, gender: null };
            break;
        case 'votes':
            filters.value = {
                ...filters.value,
                min_votes: defaults.min_votes,
                max_votes: defaults.max_votes,
            };
            break;
    }

    applyFilters();
};

const resetFilters = () => {
    filters.value = createDefaultFilters(voteBounds.value);
    sortOption.value = 'most-votes';
    applyFilters();
};

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

const handleAddVotes = (contestant: ModalContestant) => {
    addVotes(contestant.id, 1);
    openCart(contestant);
};

const handlePagination = (url: string) => {
    router.get(
        url,
        {},
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
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
                            :aria-pressed="filters.active"
                            @click="toggleActiveContests"
                        >
                            <i
                                class="icon icon-checkCircle"
                                :class="{ 'text-success': filters.active }"
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
                            <span class="count">{{ meta.total }}</span> Contestants Found
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

                    <div v-if="contestants.length === 0" class="text-center py-10">
                        No contestants found.
                    </div>

                    <div v-else>
                        <div v-show="isListLayout" class="tf-list-layout wrapper-shop" id="listLayout">
                            <ContestantCard
                                v-for="contestant in contestants"
                                :key="contestant.id"
                                :contestant="contestant"
                                layout="list"
                                @quick-view="openQuickView"
                                @add-to-cart="handleAddVotes"
                            />
                            <Pagination :links="meta.links" @navigate="handlePagination" />
                        </div>

                        <div v-show="!isListLayout" :class="gridLayoutClass" id="gridLayout">
                            <ContestantCard
                                v-for="contestant in contestants"
                                :key="`grid-${contestant.id}`"
                                :contestant="contestant"
                                layout="grid"
                                @quick-view="openQuickView"
                                @add-to-cart="handleAddVotes"
                            />
                            <Pagination :links="meta.links" @navigate="handlePagination" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </Layout>
</template>
