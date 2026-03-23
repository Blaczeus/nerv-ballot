<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { useGlobalModals } from '@/composables/useGlobalModals';
import { useVoteCart } from '@/composables/useVoteCart';
import { COST_PER_VOTE } from '@/config/voting';
import { formatVotes } from '@/utils/formatVotes';

const { state, openCart, closeModal } = useGlobalModals();
const { addVotes, formatCurrency } = useVoteCart();

const votes = ref(1);

const contestant = computed(() => state.contestant);
const isOpen = computed(() => state.activeModal === 'quickView');
const formattedVoteCount = computed(() => {
    if (!contestant.value) return '0 Votes';
    return formatVotes(contestant.value.votes);
});
const costPerVoteLabel = computed(() => formatCurrency(COST_PER_VOTE));
const totalCostLabel = computed(() => formatCurrency(votes.value * COST_PER_VOTE));

const updateVotes = (nextVotes: number) => {
    votes.value = Math.max(1, nextVotes);
};

const handleAddVotes = () => {
    if (!contestant.value) return;

    addVotes(contestant.value.id, votes.value);
    openCart(contestant.value);
};

const handleVoteNow = () => {
    if (!contestant.value) return;

    addVotes(contestant.value.id, votes.value);
    closeModal('quickView');
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
                                        type="text"
                                        class="quantity-product"
                                        name="number"
                                        readonly
                                    />
                                    <span
                                        class="btn-quantity btn-increase"
                                        @click="updateVotes(votes + 1)"
                                    >
                                        +
                                    </span>
                                </div>
                            </div>
                            <div>
                                <div class="tf-product-info-by-btn mb_10">
                                    <button
                                        type="button"
                                        class="btn-style-2 flex-grow-1 text-btn-uppercase fw-6"
                                        @click="handleAddVotes"
                                    >
                                        <span>Add Votes -&nbsp;</span>
                                        <span class="tf-qty-price total-price">{{ totalCostLabel }}</span>
                                    </button>
                                </div>
                                <Link
                                    href="/cart"
                                    class="btn-style-3 text-btn-uppercase"
                                    @click="handleVoteNow"
                                >
                                    Vote Now
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
