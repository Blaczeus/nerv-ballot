<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { useGlobalModals } from '@/composables/useGlobalModals';
import { useVoteCart } from '@/composables/useVoteCart';
import { COST_PER_VOTE } from '@/config/voting';
import { getContestStatusLabel, isVotingOpen } from '@/utils/contestStatus';
import { formatVotes } from '@/utils/formatVotes';
import type { ModalContestant } from '@/composables/useGlobalModals';

defineOptions({ inheritAttrs: false });

const props = defineProps<{
    contestant: ModalContestant;
}>();

const { openCart, openAskQuestion, openShare } = useGlobalModals();
const { addVotes, cartNotice, formatCurrency, getMaxVotesAllowed, maxVotesPerContest } = useVoteCart();

const votes = ref(1);

const formattedVoteCount = computed(() => formatVotes(props.contestant.votes));
const voteCostLabel = computed(() => formatCurrency(COST_PER_VOTE));
const selectedVotesTotal = computed(() => formatCurrency(votes.value * COST_PER_VOTE));
const contestStatusLabel = computed(() => getContestStatusLabel(props.contestant.contestStatus));
const canVote = computed(() => isVotingOpen(props.contestant.contestStatus));
const maxVotesAllowed = computed(() => {
    return Math.max(1, getMaxVotesAllowed(props.contestant.id, props.contestant) || maxVotesPerContest);
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
    if (addVotes(props.contestant.id, votes.value, props.contestant)) {
        openCart(props.contestant);
    }
};

const handleVoteNow = () => {
    if (addVotes(props.contestant.id, votes.value, props.contestant)) {
        router.visit('/checkout');
    }
};
</script>

<template>
    <div class="col-md-6">
        <div class="tf-product-info-wrap position-relative">
            <div class="tf-zoom-main"></div>
            <div class="tf-product-info-list other-image-zoom">
                <div class="tf-product-info-heading">
                    <div class="tf-product-info-name">
                        <div class="text text-btn-uppercase">{{ contestant.contestName }}</div>
                        <h3 class="name">{{ contestant.name }}</h3>
                        <span class="contest-status-pill" :class="`status-${contestant.contestStatus ?? 'ended'}`">
                            {{ contestStatusLabel }}
                        </span>
                    </div>
                    <div class="tf-product-info-desc">
                        <div class="tf-product-info-price">
                            <h5 class="price-on-sale font-2">{{ formattedVoteCount }}</h5>
                            <div class="vote-cost-label font-2">Vote Cost: {{ voteCostLabel }} per vote</div>
                        </div>
                        <p>{{ contestant.description }}</p>
                    </div>
                </div>

                <div class="tf-product-info-choose-option">
                    <div class="tf-product-info-quantity">
                        <div class="title mb_12">Number of Votes:</div>
                        <div class="wg-quantity">
                            <span class="btn-quantity btn-decrease" @click="updateVotes(votes - 1)">-</span>
                            <input
                                class="quantity-product"
                                type="number"
                                name="number"
                                :value="votes"
                                min="1"
                                :max="maxVotesAllowed"
                                @input="setVotesFromInput($event)"
                            />
                            <span class="btn-quantity btn-increase" @click="updateVotes(votes + 1)">+</span>
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
                                class="btn-style-2 grow text-btn-uppercase fw-6"
                                :class="{ 'is-disabled-action': !canVote }"
                                @click="handleAddVotes"
                            >
                                <span>Add Votes -&nbsp;</span>
                                <span class="tf-qty-price total-price">{{ selectedVotesTotal }}</span>
                            </button>
                        </div>
                        <button
                            type="button"
                            class="btn-style-3 text-btn-uppercase vote-now-btn"
                            :class="{ 'is-disabled-action': !canVote }"
                            @click="handleVoteNow"
                        >
                            Vote now
                        </button>
                        <p v-if="cartNotice" class="text-caption-1 text-danger mt_12 mb-0">
                            {{ cartNotice }}
                        </p>
                    </div>

                    <div class="tf-product-info-help">
                        <div class="tf-product-info-extra-link">
                            <a href="#" class="tf-product-extra-icon" @click.prevent="router.visit('/about')">
                                <div class="icon"><i class="icon-sealCheck"></i></div>
                                <p class="text-caption-1">Voting Info</p>
                            </a>
                            <a href="#ask_question" class="tf-product-extra-icon" @click.prevent="openAskQuestion">
                                <div class="icon"><i class="icon-question"></i></div>
                                <p class="text-caption-1">Ask A Question</p>
                            </a>
                            <a href="#share_social" class="tf-product-extra-icon" @click.prevent="openShare(contestant)">
                                <div class="icon"><i class="icon-share"></i></div>
                                <p class="text-caption-1">Share</p>
                            </a>
                        </div>
                        <div class="tf-product-info-time">
                            <div class="icon"><i class="icon-timer"></i></div>
                            <p class="text-caption-1">
                                Vote Processing: <span>Instant</span> after confirmation
                            </p>
                        </div>
                        <div class="tf-product-info-return">
                            <div class="icon"><i class="icon-arrowClockwise"></i></div>
                            <p class="text-caption-1">
                                Votes are final once submitted. Please review your selections before confirming.
                            </p>
                        </div>
                    </div>

                    <ul class="tf-product-info-sku">
                        <li>
                            <p class="text-caption-1">Contestant ID:</p>
                            <p class="text-caption-1 text-1">{{ contestant.id }}</p>
                        </li>
                        <li>
                            <p class="text-caption-1">Contest:</p>
                            <p class="text-caption-1 text-1">{{ contestant.contestName }}</p>
                        </li>
                        <li>
                            <p class="text-caption-1">Category:</p>
                            <p class="text-caption-1 text-1">{{ contestant.category }}</p>
                        </li>
                        <li>
                            <p class="text-caption-1">Location:</p>
                            <p class="text-caption-1 text-1">{{ contestant.location }}</p>
                        </li>
                        <li>
                            <p class="text-caption-1">Current Votes:</p>
                            <p class="text-caption-1 text-1">{{ formattedVoteCount }}</p>
                        </li>
                    </ul>

                    <div class="pt_12">
                        <Link :href="`/leaderboard`" class="btn-line">View Leaderboard</Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.vote-cost-label {
    color: var(--main);
    opacity: 1;
    text-decoration: none;
}

.vote-now-btn:hover,
.vote-now-btn:focus-visible {
    color: #fff;
}

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
