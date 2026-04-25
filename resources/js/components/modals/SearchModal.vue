<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { useDebounceFn } from '@vueuse/core';
import { useGlobalModals } from '@/composables/useGlobalModals';
import { useVoteCart } from '@/composables/useVoteCart';
import { getContestStatusLabel, isVotingOpen } from '@/utils/contestStatus';
import { formatVotes } from '@/utils/formatVotes';
import type { ModalContestant } from '@/composables/useGlobalModals';
import type { ContestStatus } from '@/utils/contestStatus';

const INITIAL_VISIBLE_RESULTS = 4;
const LOAD_MORE_STEP = 4;

const { state, closeModal, openCart, openQuickView } = useGlobalModals();
const { addVotes, cartNotice } = useVoteCart();

const isOpen = computed(() => state.activeModal === 'search');
const searchQuery = ref('');
const searchInput = ref<HTMLInputElement | null>(null);
const visibleResultsCount = ref(INITIAL_VISIBLE_RESULTS);
const searchResults = ref<ModalContestant[]>([]);
const isSearching = ref(false);
const activeRequest = ref<AbortController | null>(null);

type SearchResultContestant = {
    id: number;
    contest_id: number;
    slug: string;
    name: string;
    contestName: string;
    contest_status: ContestStatus | null;
    category: string;
    gender: string;
    location: string;
    votes: number;
    contestStart: string;
    contestEnd: string;
    createdAt: string;
    image: string;
    hoverImage: string;
    description: string;
};

const normalizedQuery = computed(() => searchQuery.value.trim());
const filteredContestants = computed(() => searchResults.value);

const visibleContestants = computed(() => {
    return filteredContestants.value.slice(0, visibleResultsCount.value);
});

const hasMoreResults = computed(() => {
    return visibleContestants.value.length < filteredContestants.value.length;
});
const getStatusLabel = (status: ModalContestant['contestStatus']) => getContestStatusLabel(status);
const isVoteDisabled = (contestant: ModalContestant) => !isVotingOpen(contestant.contestStatus);

const closeSearch = () => {
    activeRequest.value?.abort();
    activeRequest.value = null;
    closeModal('search');
    searchQuery.value = '';
    searchResults.value = [];
    visibleResultsCount.value = INITIAL_VISIBLE_RESULTS;
};

const focusSearchInput = async () => {
    await nextTick();
    searchInput.value?.focus();
};

const handleResultClick = () => {
    closeSearch();
};

const handleQuickView = (contestant: ModalContestant) => {
    closeModal('search');
    openQuickView(contestant);
};

const handleQuickVote = (contestant: ModalContestant) => {
    if (addVotes(contestant.id, 1, contestant)) {
        closeModal('search');
        openCart(contestant);
    }
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

const searchContestants = useDebounceFn(async (query: string) => {
    if (!query) {
        searchResults.value = [];
        isSearching.value = false;
        activeRequest.value?.abort();
        activeRequest.value = null;
        return;
    }

    activeRequest.value?.abort();
    const controller = new AbortController();
    activeRequest.value = controller;
    isSearching.value = true;

    try {
        const params = new URLSearchParams({ q: query });
        const response = await fetch(`/contestants/search?${params.toString()}`, {
            headers: {
                Accept: 'application/json',
            },
            signal: controller.signal,
        });

        if (!response.ok) {
            searchResults.value = [];
            return;
        }

        const payload = await response.json() as {
            contestants?: SearchResultContestant[];
        };

        searchResults.value = (payload.contestants ?? []).map((contestant) => ({
            id: contestant.id,
            contestId: contestant.contest_id,
            slug: contestant.slug,
            name: contestant.name,
            contestName: contestant.contestName,
            contestStatus: contestant.contest_status,
            category: contestant.category,
            gender: contestant.gender,
            location: contestant.location,
            votes: contestant.votes,
            contestStart: contestant.contestStart,
            contestEnd: contestant.contestEnd,
            createdAt: contestant.createdAt,
            image: contestant.image,
            hoverImage: contestant.hoverImage,
            description: contestant.description,
        }));
    } catch (error) {
        if ((error as DOMException).name !== 'AbortError') {
            searchResults.value = [];
        }
    } finally {
        if (activeRequest.value === controller) {
            activeRequest.value = null;
        }
        isSearching.value = false;
    }
}, 250);

watch(isOpen, async (open) => {
    if (open) {
        await focusSearchInput();
        return;
    }

    activeRequest.value?.abort();
    activeRequest.value = null;
    searchQuery.value = '';
    searchResults.value = [];
    visibleResultsCount.value = INITIAL_VISIBLE_RESULTS;
    isSearching.value = false;
});

watch(normalizedQuery, (query) => {
    visibleResultsCount.value = INITIAL_VISIBLE_RESULTS;
    void searchContestants(query);
});

onMounted(() => {
    window.addEventListener('keydown', handleKeydown);
});

onBeforeUnmount(() => {
    activeRequest.value?.abort();
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
                <div v-if="cartNotice" class="text-caption-1 text-danger mb_16">
                    {{ cartNotice }}
                </div>
                <div v-if="!normalizedQuery">
                    <h5 class="mb_16">Search contestants</h5>
                    <p class="text-secondary mb_16">Start typing to search contestants</p>
                    <ul class="list-tags">
                        <li><button type="button" class="radius-60 link" @click="searchQuery = 'Campus'">Campus</button></li>
                        <li><button type="button" class="radius-60 link" @click="searchQuery = 'Talent'">Talent</button></li>
                        <li><button type="button" class="radius-60 link" @click="searchQuery = 'Lagos'">Lagos</button></li>
                        <li><button type="button" class="radius-60 link" @click="searchQuery = 'Leadership'">Leadership</button></li>
                    </ul>
                </div>
                <div v-else-if="isSearching">
                    <h5 class="mb_16">Search results</h5>
                    <p class="text-secondary">Searching contestants...</p>
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
                                        :class="{ 'is-disabled-action': isVoteDisabled(contestant) }"
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
                                <span class="contest-status-pill" :class="`status-${contestant.contestStatus ?? 'ended'}`">
                                    {{ getStatusLabel(contestant.contestStatus) }}
                                </span>
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

.contest-status-pill {
    display: inline-flex;
    margin-bottom: 8px;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 600;
}

.status-active {
    background: #ecfdf5;
    color: #047857;
}

.status-upcoming {
    background: #eff6ff;
    color: #1d4ed8;
}

.status-ended {
    background: #fef2f2;
    color: #b91c1c;
}

.is-disabled-action {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
