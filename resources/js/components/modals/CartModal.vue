<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useGlobalModals } from '@/composables/useGlobalModals';
import { useVoteCart } from '@/composables/useVoteCart';

const { state, closeModal } = useGlobalModals();
const {
    cartItems,
    cartNotice,
    totalVotes,
    finalTotal,
    costPerVote,
    formatCurrency,
    isCartReady,
    getMaxVotesAllowed,
    updateVotes,
    removeVotes,
} = useVoteCart();

const isOpen = computed(() => state.activeModal === 'cart');

const decreaseVotes = (contestantId: number, currentVotes: number) => {
    updateVotes(contestantId, currentVotes - 1);
};

const increaseVotes = (contestantId: number, currentVotes: number) => {
    updateVotes(contestantId, currentVotes + 1);
};

const setVotesFromInput = (contestantId: number, event: Event) => {
    const target = event.target as HTMLInputElement | null;
    const value = target?.value ?? '1';
    const parsedValue = Number(value);
    updateVotes(contestantId, Number.isFinite(parsedValue) ? parsedValue : 1);
};

const addVoteBatch = (contestantId: number, currentVotes: number, amount: number) => {
    updateVotes(contestantId, currentVotes + amount);
};

const closeCart = () => {
    closeModal('cart');
};
</script>

<template>
    <div
        v-if="isOpen"
        class="modal fullRight fade show modal-shopping-cart"
        id="shoppingCart"
        style="display: block;"
        @click.self="closeCart"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="d-flex flex-column grow h-100">
                    <div class="header">
                        <h5 class="title">Vote Cart</h5>
                        <span class="icon-close icon-close-popup" @click="closeCart"></span>
                    </div>
                    <div class="wrap">
                        <div class="tf-mini-cart-wrap">
                            <div
                                v-if="cartNotice"
                                class="tf-notice text-center mb_16"
                                style="padding: 14px 18px; border: 1px solid #fed7aa; background: #fff7ed; color: #9a3412;"
                            >
                                {{ cartNotice }}
                            </div>
                            <div class="tf-mini-cart-main">
                                <div class="tf-mini-cart-sroll">
                                    <div v-if="cartItems.length" class="tf-mini-cart-items">
                                        <div
                                            v-for="item in cartItems"
                                            :key="item.contestant_id"
                                            class="tf-mini-cart-item file-delete"
                                        >
                                            <div class="tf-mini-cart-image">
                                                <img
                                                    v-if="item.contestant.image"
                                                    class="lazyload"
                                                    :data-src="item.contestant.image"
                                                    :src="item.contestant.image"
                                                    :alt="item.contestant.name"
                                                />
                                            </div>
                                            <div class="tf-mini-cart-info grow">
                                                <div
                                                    class="mb_12 d-flex align-items-center justify-content-between flex-wrap gap-12"
                                                >
                                                    <div class="text-title">
                                                        <Link
                                                            :href="`/contestants/${item.contestant.slug}`"
                                                            class="link text-line-clamp-1"
                                                            @click="closeCart"
                                                        >
                                                            {{ item.contestant.name }}
                                                        </Link>
                                                        <div class="text-caption-1 text-secondary">
                                                            {{ item.contestant.contestName }}
                                                        </div>
                                                    </div>
                                                    <span
                                                        class="remove icon-close"
                                                        @click="removeVotes(item.contestant_id)"
                                                    ></span>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap gap-12 mb_12"
                                                >
                                                    <div class="mini-cart-vote-controls">
                                                        <div class="wg-quantity">
                                                            <span
                                                                class="btn-quantity btn-decrease"
                                                                @click="decreaseVotes(item.contestant_id, item.votes)"
                                                            >
                                                                -
                                                            </span>
                                                            <input
                                                                :value="item.votes"
                                                                type="number"
                                                                min="1"
                                                                :max="getMaxVotesAllowed(item.contestant_id)"
                                                                class="quantity-product"
                                                                @input="setVotesFromInput(item.contestant_id, $event)"
                                                            />
                                                            <span
                                                                class="btn-quantity btn-increase"
                                                                @click="increaseVotes(item.contestant_id, item.votes)"
                                                            >
                                                                +
                                                            </span>
                                                        </div>
                                                        <div class="mini-cart-batch-actions">
                                                            <button type="button" class="mini-cart-batch-btn" @click="addVoteBatch(item.contestant_id, item.votes, 5)">+5</button>
                                                            <button type="button" class="mini-cart-batch-btn" @click="addVoteBatch(item.contestant_id, item.votes, 10)">+10</button>
                                                        </div>
                                                    </div>
                                                    <div class="text-secondary-2">
                                                        {{ formatCurrency(costPerVote) }} per vote
                                                    </div>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap gap-12"
                                                >
                                                    <div class="text-secondary-2">
                                                        Votes: {{ item.votes }}
                                                    </div>
                                                    <div class="text-button">
                                                        {{ formatCurrency(item.totalCost) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else-if="isCartReady" class="text-center py-5">
                                        <p class="text-secondary mb_12">No contestants selected yet.</p>
                                        <Link href="/contestants" class="btn-line" @click="closeCart">
                                            Explore Contestants
                                        </Link>
                                    </div>
                                </div>
                            </div>
                            <div class="tf-mini-cart-bottom">
                                <div class="tf-mini-cart-bottom-wrap">
                                    <div class="tf-cart-totals-discounts">
                                        <h5>Votes</h5>
                                        <h5 class="tf-totals-total-value">{{ totalVotes }}</h5>
                                    </div>
                                    <div class="tf-cart-totals-discounts">
                                        <h5>Subtotal</h5>
                                        <h5 class="tf-totals-total-value">
                                            {{ formatCurrency(finalTotal) }}
                                        </h5>
                                    </div>
                                    <div class="tf-mini-cart-view-checkout">
                                        <Link
                                            href="/cart"
                                            class="tf-btn w-100 btn-white radius-4 has-border"
                                            @click="closeCart"
                                        >
                                            <span class="text">View Vote Cart</span>
                                        </Link>
                                        <Link
                                            href="/checkout"
                                            class="tf-btn w-100 btn-fill radius-4"
                                            @click="closeCart"
                                        >
                                            <span class="text">Confirm Votes</span>
                                        </Link>
                                    </div>
                                    <div class="text-center">
                                        <Link
                                            href="/contestants"
                                            class="link text-btn-uppercase"
                                            @click="closeCart"
                                        >
                                            Continue Voting
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.mini-cart-vote-controls {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.mini-cart-vote-controls .quantity-product {
    width: 72px;
    text-align: center;
}

.mini-cart-batch-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.mini-cart-batch-btn {
    border: 1px solid rgba(24, 24, 24, 0.14);
    border-radius: 999px;
    background: #fff;
    color: #181818;
    font-size: 11px;
    font-weight: 600;
    line-height: 1;
    padding: 7px 10px;
}

.mini-cart-batch-btn:hover,
.mini-cart-batch-btn:focus-visible {
    border-color: #181818;
    background: #181818;
    color: #fff;
    outline: none;
}
</style>
