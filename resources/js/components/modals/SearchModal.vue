<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { useGlobalModals } from '@/composables/useGlobalModals';
import { useVoteCart } from '@/composables/useVoteCart';
import { contestants } from '@/data/contestants';
import { formatVotes } from '@/utils/formatVotes';

const MAX_RESULTS = 8;
const INITIAL_VISIBLE_RESULTS = 4;
const LOAD_MORE_STEP = 4;

const { state, closeModal, openCart, openQuickView } = useGlobalModals();
const { addVotes } = useVoteCart();

const isOpen = computed(() => state.activeModal === 'search');
const searchQuery = ref('');
const searchInput = ref<HTMLInputElement | null>(null);
const visibleResultsCount = ref(INITIAL_VISIBLE_RESULTS);

const normalizedQuery = computed(() => searchQuery.value.trim().toLowerCase());

const filteredContestants = computed(() => {
    if (!normalizedQuery.value) {
        return [];
    }

    return contestants
        .filter((contestant) =>
            [
                contestant.name,
                contestant.contestName,
                contestant.category,
                contestant.location,
            ].some((field) => field.toLowerCase().includes(normalizedQuery.value)),
        )
        .slice(0, MAX_RESULTS);
});

const visibleContestants = computed(() => {
    return filteredContestants.value.slice(0, visibleResultsCount.value);
});

const hasMoreResults = computed(() => {
    return visibleContestants.value.length < filteredContestants.value.length;
});

const closeSearch = () => {
    closeModal('search');
    searchQuery.value = '';
    visibleResultsCount.value = INITIAL_VISIBLE_RESULTS;
};

const focusSearchInput = async () => {
    await nextTick();
    searchInput.value?.focus();
};

const handleResultClick = () => {
    closeSearch();
};

const handleQuickView = (contestant: (typeof contestants)[number]) => {
    closeModal('search');
    openQuickView(contestant);
};

const handleQuickVote = (contestant: (typeof contestants)[number]) => {
    addVotes(contestant.id, 1);
    closeModal('search');
    openCart(contestant);
};

const goToFirstResult = () => {
    const firstResult = visibleContestants.value[0];

    if (!firstResult) {
        return;
    }

    closeSearch();
    router.visit(`/contestants/${firstResult.slug}`);
};

const handleKeydown = (event: KeyboardEvent) => {
    if (event.key === 'Escape' && isOpen.value) {
        closeSearch();
    }
};

watch(isOpen, async (open) => {
    if (open) {
        await focusSearchInput();
        return;
    }

    searchQuery.value = '';
    visibleResultsCount.value = INITIAL_VISIBLE_RESULTS;
});

watch(normalizedQuery, () => {
    visibleResultsCount.value = INITIAL_VISIBLE_RESULTS;
});

onMounted(() => {
    window.addEventListener('keydown', handleKeydown);
});

onBeforeUnmount(() => {
    window.removeEventListener('keydown', handleKeydown);
});
</script>

<template>
    <div
        v-if="isOpen"
        class="modal fade show modal-search"
        id="search"
        style="display: block;"
        @click.self="closeSearch"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" @keydown.esc="closeSearch">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Search</h5>
                    <span class="icon-close icon-close-popup" @click="closeSearch"></span>
                </div>
                <form class="form-search" @submit.prevent="goToFirstResult">
                    <fieldset class="text">
                        <input
                            ref="searchInput"
                            v-model="searchQuery"
                            type="text"
                            placeholder="Search contestants..."
                            name="text"
                            tabindex="0"
                            aria-label="Search contestants"
                        >
                    </fieldset>
                    <button type="submit">
                        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M21.35 21.0004L17 16.6504" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </form>
                <div v-if="!normalizedQuery">
                    <h5 class="mb_16">Search contestants</h5>
                    <p class="text-secondary mb_16">Start typing to search contestants</p>
                    <ul class="list-tags">
                        <li><button type="button" class="radius-60 link" @click="searchQuery = 'Campus Queen'">Campus Queen</button></li>
                        <li><button type="button" class="radius-60 link" @click="searchQuery = 'Talent'">Talent</button></li>
                        <li><button type="button" class="radius-60 link" @click="searchQuery = 'Lagos'">Lagos</button></li>
                        <li><button type="button" class="radius-60 link" @click="searchQuery = 'Leadership'">Leadership</button></li>
                    </ul>
                </div>
                <div v-else-if="filteredContestants.length">
                    <h6 class="mb_16">Matching contestants</h6>
                    <div class="tf-grid-layout tf-col-2 lg-col-3 xl-col-4">
                    <div
                        v-for="contestant in visibleContestants"
                        :key="contestant.id"
                        class="fl-item card-product"
                    >
                        <div class="card-product-wrapper">
                            <Link
                                :href="`/contestants/${contestant.slug}`"
                                class="product-img"
                                @click="handleResultClick"
                            >
                                <img
                                    class="lazyload img-product"
                                    :src="contestant.image"
                                    :data-src="contestant.image"
                                    :alt="contestant.name"
                                >
                                <img
                                    class="lazyload img-hover"
                                    :src="contestant.hoverImage || contestant.image"
                                    :data-src="contestant.hoverImage || contestant.image"
                                    :alt="contestant.name"
                                >
                            </Link>
                            <div class="list-product-btn">
                                <a
                                    href="#quickView"
                                    class="box-icon quickview tf-btn-loading"
                                    @click.prevent="handleQuickView(contestant)"
                                >
                                    <span class="icon icon-eye"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                            </div>
                            <div class="list-btn-main">
                                <a
                                    href="#shoppingCart"
                                    class="btn-main-product"
                                    @click.prevent="handleQuickVote(contestant)"
                                >
                                    Quick Vote
                                </a>
                            </div>
                        </div>
                        <div class="card-product-info">
                            <Link
                                :href="`/contestants/${contestant.slug}`"
                                class="title link"
                                @click="handleResultClick"
                            >
                                {{ contestant.name }}
                            </Link>
                            <p class="text-caption-1 text-secondary mb_4">{{ contestant.contestName }}</p>
                            <span class="price current-price">{{ formatVotes(contestant.votes) }}</span>
                        </div>
                    </div>
                    <div v-if="hasMoreResults" class="wd-load view-more-button text-center">
                        <button
                            type="button"
                            class="tf-loading tf-btn btn-reset"
                            @click="visibleResultsCount += LOAD_MORE_STEP"
                        >
                            <span class="text text-btn text-btn-uppercase">Load more</span>
                        </button>
                    </div>
                    </div>
                </div>
                <div v-else>
                    <h5 class="mb_16">Search results</h5>
                    <p class="text-secondary">No contestants found</p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.list-tags button {
    display: flex;
    padding: 4px 15px;
    border-radius: 5px;
    border: 1px solid var(--main);
    background: var(--main);
    color: var(--white);
    cursor: pointer;
}

.list-tags button:hover,
.list-tags button:focus-visible {
    background: transparent;
    color: var(--primary);
}

.list-tags button:focus-visible {
    outline: none;
}

.modal-search .card-product-info {
    text-align: left;
}

.modal-search .card-product-wrapper .product-img {
    display: block;
}

.modal-search .card-product-wrapper .product-img img {
    width: 100%;
    display: block;
}

.modal-search .list-product-btn {
    z-index: 3;
}

.modal-search .list-btn-main {
    z-index: 3;
}
</style>

