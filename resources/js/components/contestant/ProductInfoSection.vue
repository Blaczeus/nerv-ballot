<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { useGlobalModals } from '@/composables/useGlobalModals';
import { useVoteCart } from '@/composables/useVoteCart';
import { COST_PER_VOTE } from '@/config/voting';
import { formatVotes } from '@/utils/formatVotes';
import type { ModalContestant } from '@/composables/useGlobalModals';

defineOptions({ inheritAttrs: false });

const props = defineProps<{
    contestant: ModalContestant;
}>();

const { openCart, openAskQuestion, openShare } = useGlobalModals();
const { addVotes, formatCurrency } = useVoteCart();

const votes = ref(1);

const formattedVoteCount = computed(() => formatVotes(props.contestant.votes));
const voteCostLabel = computed(() => formatCurrency(COST_PER_VOTE));
const selectedVotesTotal = computed(() => formatCurrency(votes.value * COST_PER_VOTE));

const updateVotes = (nextVotes: number) => {
    votes.value = Math.max(1, nextVotes);
};

const handleAddVotes = () => {
    addVotes(props.contestant.id, votes.value);
    openCart(props.contestant);
};

const handleVoteNow = () => {
    addVotes(props.contestant.id, votes.value);
    router.visit('/checkout');
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
                                type="text"
                                name="number"
                                :value="votes"
                                readonly
                            />
                            <span class="btn-quantity btn-increase" @click="updateVotes(votes + 1)">+</span>
                        </div>
                    </div>

                    <div>
                        <div class="tf-product-info-by-btn mb_10">
                            <button
                                type="button"
                                class="btn-style-2 grow text-btn-uppercase fw-6"
                                @click="handleAddVotes"
                            >
                                <span>Add Votes -&nbsp;</span>
                                <span class="tf-qty-price total-price">{{ selectedVotesTotal }}</span>
                            </button>
                        </div>
                        <button type="button" class="btn-style-3 text-btn-uppercase vote-now-btn" @click="handleVoteNow">
                            Vote now
                        </button>
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
</style>
