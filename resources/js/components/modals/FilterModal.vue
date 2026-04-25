<script setup lang="ts">
import { computed, reactive, ref, watch } from 'vue';
import { useGlobalModals } from '@/composables/useGlobalModals';

type SortOption = 'votes_desc' | 'votes_asc';

type FilterState = {
    category: string | null;
    location: string | null;
    gender: string | null;
    active: boolean;
    sort: SortOption;
};

type FilterOptions = {
    categories: string[];
    locations: string[];
    genders: string[];
};

const props = withDefaults(
    defineProps<{
        filters?: FilterState;
        options?: FilterOptions;
    }>(),
    {
        filters: () => ({
            category: null,
            location: null,
            gender: null,
            active: false,
            sort: 'votes_desc',
        }),
        options: () => ({
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

watch(
    () => props.filters,
    (value) => {
        if (!value) return;

        isSyncing.value = true;
        Object.assign(localFilters, value);

        Promise.resolve().then(() => {
            isSyncing.value = false;
        });
    },
    { deep: true, immediate: true },
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
