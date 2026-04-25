<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import ContestantCard from '@/components/contestants/ContestantCard.vue';
import FilterModal from '@/components/modals/FilterModal.vue';
import Breadcrumb from '@/components/ui/Breadcrumb.vue';
import Pagination from '@/components/ui/Pagination.vue';
import type { ModalContestant } from '@/composables/useGlobalModals';
import { useGlobalModals } from '@/composables/useGlobalModals';
import { useVoteCart } from '@/composables/useVoteCart';
import Layout from '@/layouts/Layout.vue';

type SortOption = 'votes_desc' | 'votes_asc';

type FiltersState = {
    category: string | null;
    location: string | null;
    gender: string | null;
    active: boolean;
    sort: SortOption;
};

type FilterChipKey = 'active' | 'category' | 'location' | 'gender';

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
    contest_status: 'active' | 'upcoming' | 'ended' | null;
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
        categories: string[];
        locations: string[];
        genders: string[];
    };
    filters?: {
        category?: string | null;
        location?: string | null;
        gender?: string | null;
        active?: boolean | number | string | null;
        sort?: SortOption | null;
    };
};

const FALLBACK_IMAGE = '/tmp/images/products/womens/women-19.jpg';
const LAYOUT_STORAGE_KEY = 'contestants.layout';
const layoutOptions: LayoutMode[] = ['list', 'tf-col-2', 'tf-col-3', 'tf-col-4', 'tf-col-5'];

const sanitizeFilterValue = (value: string | null | undefined) => {
    const trimmed = value?.trim() ?? '';
    return trimmed === '' ? null : trimmed;
};

const normalizeBooleanFilter = (value: unknown) => value === true || value === 1 || value === '1';
const sanitizeSortValue = (value: unknown): SortOption => (value === 'votes_asc' ? 'votes_asc' : 'votes_desc');

const createDefaultFilters = (): FiltersState => ({
    category: null,
    location: null,
    gender: null,
    active: false,
    sort: 'votes_desc',
});

const page = usePage<PageProps>();
const { openQuickView, openCart, openFilter } = useGlobalModals();
const { addVotes, cartNotice } = useVoteCart();

const sortOptions: Array<{ value: SortOption; label: string }> = [
    { value: 'votes_desc', label: 'Highest Votes' },
    { value: 'votes_asc', label: 'Lowest Votes' },
];

const resolveInitialFilters = (): FiltersState => {
    const defaults = createDefaultFilters();
    const incomingFilters = page.props.filters ?? {};

    return {
        category: sanitizeFilterValue(incomingFilters.category),
        location: sanitizeFilterValue(incomingFilters.location),
        gender: sanitizeFilterValue(incomingFilters.gender),
        active: normalizeBooleanFilter(incomingFilters.active),
        sort: sanitizeSortValue(incomingFilters.sort ?? defaults.sort),
    };
};

const filters = ref<FiltersState>(resolveInitialFilters());

watch(
    () => page.props.filters,
    () => {
        filters.value = resolveInitialFilters();
    },
    { deep: true },
);

const rawContestants = computed(() => page.props.contestants?.data ?? []);
const meta = computed(() => page.props.contestants?.meta ?? { total: 0, links: [] });

const filterOptions = computed(() => {
    return (
        page.props.filterOptions ?? {
            categories: [],
            locations: [],
            genders: [],
        }
    );
});

const contestants = computed<ModalContestant[]>(() => {
    return rawContestants.value.map((contestant) => ({
        id: contestant.id,
        contestId: contestant.contest_id,
        slug: contestant.slug,
        name: contestant.name,
        contestName: contestant.contest?.name ?? 'Contest',
        contestStatus: contestant.contest_status,
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

const cleanFiltersForRequest = () => ({
    category: sanitizeFilterValue(filters.value.category) ?? undefined,
    location: sanitizeFilterValue(filters.value.location) ?? undefined,
    gender: sanitizeFilterValue(filters.value.gender) ?? undefined,
    active: filters.value.active ? 1 : undefined,
    sort: filters.value.sort !== 'votes_desc' ? filters.value.sort : undefined,
});

const applyFilters = () => {
    router.get('/contestants', cleanFiltersForRequest(), {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
};

const updateFilters = (nextFilters: FiltersState) => {
    filters.value = {
        ...filters.value,
        ...nextFilters,
        category: sanitizeFilterValue(nextFilters.category ?? filters.value.category),
        location: sanitizeFilterValue(nextFilters.location ?? filters.value.location),
        gender: sanitizeFilterValue(nextFilters.gender ?? filters.value.gender),
        active: nextFilters.active ?? filters.value.active,
        sort: sanitizeSortValue(nextFilters.sort ?? filters.value.sort),
    };

    applyFilters();
};

const toggleActiveContests = () => {
    filters.value = { ...filters.value, active: !filters.value.active };
    applyFilters();
};

const setSortOption = (value: SortOption) => {
    filters.value = { ...filters.value, sort: value };
    applyFilters();
};

const removeFilter = (key: FilterChipKey) => {
    switch (key) {
        case 'active':
            filters.value = { ...filters.value, active: false };
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
    }

    applyFilters();
};

const resetFilters = () => {
    filters.value = createDefaultFilters();
    applyFilters();
};

const hasActiveFilters = computed(() => {
    return Boolean(
        filters.value.active ||
            filters.value.category ||
            filters.value.location ||
            filters.value.gender,
    );
});

const filterChips = computed<FilterChip[]>(() => {
    const chips: FilterChip[] = [];

    if (filters.value.active) {
        chips.push({ key: 'active', label: 'Active Contests' });
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

    return chips;
});

const currentSortLabel = computed(() => {
    return sortOptions.find((option) => option.value === filters.value.sort)?.label ?? 'Highest Votes';
});

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
const activeGridLayout = computed<GridLayoutClass>(() => (layoutMode.value === 'list' ? 'tf-col-4' : layoutMode.value));

const wrapperControlShopClass = computed(() => [
    'wrapper-control-shop',
    isListLayout.value ? 'listLayout-wrapper' : 'gridLayout-wrapper',
]);

const gridLayoutClass = computed(() => `tf-grid-layout wrapper-shop ${activeGridLayout.value}`);

const setLayoutMode = (mode: LayoutMode) => {
    layoutMode.value = mode;

    if (typeof window !== 'undefined') {
        window.localStorage.setItem(LAYOUT_STORAGE_KEY, mode);
    }
};

const handleAddVotes = (contestant: ModalContestant) => {
    if (addVotes(contestant.id, 1, contestant)) {
        openCart(contestant);
    }
};

const handlePagination = (url: string) => {
    router.get(url, {}, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
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
                            <i class="icon icon-checkCircle" :class="{ 'text-success': filters.active }"></i>
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
                                <svg class="icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                <svg class="icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                <svg class="icon" width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                <svg class="icon" width="30" height="20" viewBox="0 0 30 20" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                <svg class="icon" width="38" height="20" viewBox="0 0 38 20" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                    :class="{ active: filters.sort === option.value }"
                                    @click="setSortOption(option.value)"
                                >
                                    <span class="text-value-item">{{ option.label }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div :class="wrapperControlShopClass">
                    <div
                        v-if="cartNotice"
                        class="tf-notice text-center mb_24"
                        style="padding: 14px 18px; border: 1px solid #fed7aa; background: #fff7ed; color: #9a3412;"
                    >
                        {{ cartNotice }}
                    </div>
                    <div v-if="hasActiveFilters" class="meta-filter-shop">
                        <div class="count-text">
                            <span class="count">{{ meta.total }}</span> Contestants Found
                        </div>
                        <div id="applied-filters" class="text-caption-1">
                            <span v-for="chip in filterChips" :key="chip.key" class="filter-tag">
                                {{ chip.label }}
                                <span class="remove-tag icon-close" role="button" @click="removeFilter(chip.key)"></span>
                            </span>
                        </div>
                        <button id="remove-all" class="remove-all-filters text-btn-uppercase" type="button" @click="resetFilters">
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
