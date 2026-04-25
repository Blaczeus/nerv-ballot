<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { useGlobalModals } from '@/composables/useGlobalModals';
import { useVoteCart } from '@/composables/useVoteCart';
import { COST_PER_VOTE } from '@/config/voting';
import { getContestStatusLabel, isVotingOpen } from '@/utils/contestStatus';
import { formatVotes } from '@/utils/formatVotes';

const { state, openCart, closeModal } = useGlobalModals();
const { addVotes, cartNotice, formatCurrency, getMaxVotesAllowed, maxVotesPerContest } = useVoteCart();

const votes = ref(1);

const contestant = computed(() => state.contestant);
const isOpen = computed(() => state.activeModal === 'quickView');
const formattedVoteCount = computed(() => {
    if (!contestant.value) return '0 Votes';
    return formatVotes(contestant.value.votes);
});
const costPerVoteLabel = computed(() => formatCurrency(COST_PER_VOTE));
const totalCostLabel = computed(() => formatCurrency(votes.value * COST_PER_VOTE));
const contestStatusLabel = computed(() => getContestStatusLabel(contestant.value?.contestStatus));
const canVote = computed(() => isVotingOpen(contestant.value?.contestStatus));
const maxVotesAllowed = computed(() => {
    if (!contestant.value) return maxVotesPerContest;
    return Math.max(1, getMaxVotesAllowed(contestant.value.id, contestant.value));
});

const updateVotes = (nextVotes: number) => {
    votes.value = Math.min(maxVotesAllowed.value, Math.max(1, Math.floor(nextVotes)));
};

const setVotesFromInput = (event: Event) => {
    const target = event.target as HTMLInputElement | null;
    const value = target?.value ?? '1';
    const parsedValue = Number(value);
    updateVotes(Number.isFinite(parsedValue) ? parsedValue : 1);
};

const addQuickVotes = (amount: number) => {
    updateVotes(votes.value + amount);
};

const handleAddVotes = () => {
    if (!contestant.value) return;

    if (addVotes(contestant.value.id, votes.value, contestant.value)) {
        openCart(contestant.value);
    }
};

const handleVoteNow = () => {
    if (!contestant.value) return;

    if (addVotes(contestant.value.id, votes.value, contestant.value)) {
        closeModal('quickView');
        router.visit('/cart');
    }
};

watch(
    contestant,
    () => {
        votes.value = 1;
    },
);
</script>

<template>
    <div
        v-if="isOpen"
        class="modal fullRight fade show modal-quick-view"
        id="quickView"
        style="display: block;"
        @click.self="closeModal('quickView')"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="tf-quick-view-image">
                    <div class="wrap-quick-view">
                        <div class="quickView-item">
                            <img
                                class="lazyload"
                                :data-src="contestant?.image ?? '/tmp/images/products/womens/women-19.jpg'"
                                :src="contestant?.image ?? '/tmp/images/products/womens/women-19.jpg'"
                                :alt="contestant?.name ?? 'contestant preview'"
                            />
                        </div>
                    </div>
                </div>
                <div class="wrap">
                    <div class="header">
                        <h5 class="title">Contestant Preview</h5>
                        <span class="icon-close icon-close-popup" @click="closeModal('quickView')"></span>
                    </div>
                    <div class="tf-product-info-list">
                        <div class="tf-product-info-heading">
                            <div class="tf-product-info-name">
                                <div class="text text-btn-uppercase">{{ contestant?.contestName ?? 'Contest' }}</div>
                                <h3 class="name">{{ contestant?.name ?? 'Contestant' }}</h3>
                                <span
                                    v-if="contestant"
                                    class="contest-status-pill"
                                    :class="`status-${contestant.contestStatus ?? 'ended'}`"
                                >
                                    {{ contestStatusLabel }}
                                </span>
                            </div>
                            <div class="tf-product-info-desc">
                                <div class="tf-product-info-price">
                                    <h5 class="price-on-sale font-2">{{ formattedVoteCount }}</h5>
                                    <div class="compare-at-price font-2">Vote Cost: {{ costPerVoteLabel }}</div>
                                </div>
                                <p>
                                    {{
                                        contestant?.description ??
                                        'Preview the contestant profile, review the current vote count, and choose how many votes you want to add.'
                                    }}
                                </p>
                            </div>
                        </div>

                        <div class="tf-product-info-choose-option">
                            <div class="tf-product-info-quantity">
                                <div class="title mb_12">Number of Votes:</div>
                                <div class="wg-quantity">
                                    <span
                                        class="btn-quantity btn-decrease"
                                        @click="updateVotes(votes - 1)"
                                    >
                                        -
                                    </span>
                                    <input
                                        :value="votes"
                                        type="number"
                                        class="quantity-product"
                                        name="number"
                                        min="1"
                                        :max="maxVotesAllowed"
                                        @input="setVotesFromInput($event)"
                                    />
                                    <span
                                        class="btn-quantity btn-increase"
                                        @click="updateVotes(votes + 1)"
                                    >
                                        +
                                    </span>
                                </div>
                                <div class="quick-vote-batch-actions">
                                    <button type="button" class="quick-vote-batch-btn" @click="addQuickVotes(5)">+5</button>
                                    <button type="button" class="quick-vote-batch-btn" @click="addQuickVotes(10)">+10</button>
                                    <button type="button" class="quick-vote-batch-btn" @click="addQuickVotes(20)">+20</button>
                                </div>
                            </div>
                            <div>
                                <div class="tf-product-info-by-btn mb_10">
                                    <button
                                        type="button"
                                        class="btn-style-2 flex-grow-1 text-btn-uppercase fw-6"
                                        :class="{ 'is-disabled-action': !canVote }"
                                        @click="handleAddVotes"
                                    >
                                        <span>Add Votes -&nbsp;</span>
                                        <span class="tf-qty-price total-price">{{ totalCostLabel }}</span>
                                    </button>
                                </div>
                                <Link
                                    href="/cart"
                                    class="btn-style-3 text-btn-uppercase"
                                    :class="{ 'is-disabled-action': !canVote }"
                                    @click.prevent="handleVoteNow"
                                >
                                    Vote Now
                                </Link>
                                <p v-if="cartNotice" class="text-caption-1 text-danger mt_12 mb-0">
                                    {{ cartNotice }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.contest-status-pill {
    display: inline-flex;
    margin-top: 12px;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
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

.quick-vote-batch-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 12px;
}

.quick-vote-batch-btn {
    border: 1px solid rgba(24, 24, 24, 0.14);
    border-radius: 999px;
    background: #fff;
    color: #181818;
    font-size: 12px;
    font-weight: 600;
    line-height: 1;
    padding: 8px 12px;
}

.quick-vote-batch-btn:hover,
.quick-vote-batch-btn:focus-visible {
    border-color: #181818;
    background: #181818;
    color: #fff;
    outline: none;
}
</style>
