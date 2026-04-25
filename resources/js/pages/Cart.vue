<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Breadcrumb from '@/components/ui/Breadcrumb.vue';
import { useVoteCart } from '@/composables/useVoteCart';
import Layout from '@/layouts/Layout.vue';

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
</script>

<template>
    <Head title="Vote Cart" />

    <Layout>
        <Breadcrumb
            :items="[
                { label: 'Homepage', link: '/' },
                { label: 'Vote Cart' },
            ]"
            design="image"
            heading="Vote Cart"
            background-image="/tmp/images/section/page-title.jpg"
        />

        <section class="flat-spacing">
            <div class="container">
                <div
                    v-if="cartNotice"
                    class="tf-notice text-center mb_24"
                    style="padding: 14px 18px; border: 1px solid #fed7aa; background: #fff7ed; color: #9a3412;"
                >
                    {{ cartNotice }}
                </div>
                <div v-if="isCartReady && !cartItems.length" class="cart-empty-state">
                    <div class="cart-empty-content">
                        <p class="mb_16">No contestants selected yet</p>
                        <Link href="/contestants" class="tf-btn btn-fill">
                            <span class="text">Explore Contestants</span>
                        </Link>
                    </div>
                </div>
                <div v-else class="row">
                    <div class="col-xl-8">
                        <form v-if="cartItems.length">
                            <table class="tf-table-page-cart">
                                <thead>
                                    <tr>
                                        <th>Contestants</th>
                                        <th>Cost per Vote</th>
                                        <th>Votes</th>
                                        <th>Total Cost</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="item in cartItems"
                                        :key="item.contestant_id"
                                        class="tf-cart-item"
                                    >
                                        <td class="tf-cart-item_product">
                                            <Link
                                                :href="`/contestants/${item.contestant.slug}`"
                                                class="img-box"
                                            >
                                                <img
                                                    v-if="item.contestant.image"
                                                    :src="item.contestant.image"
                                                    :alt="item.contestant.name"
                                                >
                                            </Link>
                                            <div class="cart-info">
                                                <Link
                                                    :href="`/contestants/${item.contestant.slug}`"
                                                    class="cart-title link"
                                                >
                                                    {{ item.contestant.name }}
                                                </Link>
                                                <p class="text-caption-1 text-secondary mb-0">
                                                    Contest: {{ item.contestant.contestName }}
                                                </p>
                                            </div>
                                        </td>
                                        <td
                                            data-cart-title="Cost per Vote"
                                            class="tf-cart-item_price text-center"
                                        >
                                            <div class="cart-price text-button vote-cost-value">
                                                {{ formatCurrency(costPerVote) }}
                                            </div>
                                        </td>
                                        <td
                                            data-cart-title="Votes"
                                            class="tf-cart-item_quantity"
                                        >
                                            <div class="vote-quantity-cell mx-md-auto">
                                                <div class="wg-quantity">
                                                    <span
                                                        class="btn-quantity vote-stepper-btn"
                                                        @click="decreaseVotes(item.contestant_id, item.votes)"
                                                    >
                                                        -
                                                    </span>
                                                    <input
                                                        type="number"
                                                        class="quantity-product"
                                                        name="votes"
                                                        min="1"
                                                        :max="getMaxVotesAllowed(item.contestant_id)"
                                                        :value="item.votes"
                                                        @input="setVotesFromInput(item.contestant_id, $event)"
                                                    >
                                                    <span
                                                        class="btn-quantity vote-stepper-btn"
                                                        @click="increaseVotes(item.contestant_id, item.votes)"
                                                    >
                                                        +
                                                    </span>
                                                </div>
                                                <div class="vote-quick-actions">
                                                    <button
                                                        type="button"
                                                        class="vote-batch-btn"
                                                        @click="addVoteBatch(item.contestant_id, item.votes, 5)"
                                                    >
                                                        +5
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="vote-batch-btn"
                                                        @click="addVoteBatch(item.contestant_id, item.votes, 10)"
                                                    >
                                                        +10
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="vote-batch-btn"
                                                        @click="addVoteBatch(item.contestant_id, item.votes, 20)"
                                                    >
                                                        +20
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            data-cart-title="Total Cost"
                                            class="tf-cart-item_total text-center"
                                        >
                                            <div class="cart-total text-button total-price">
                                                {{ formatCurrency(item.totalCost) }}
                                            </div>
                                        </td>
                                        <td
                                            data-cart-title="Remove"
                                            class="remove-cart"
                                        >
                                            <span
                                                class="vote-remove icon icon-close"
                                                @click="removeVotes(item.contestant_id)"
                                            ></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div v-if="cartItems.length" class="col-xl-4">
                        <div class="fl-sidebar-cart">
                            <div class="box-order bg-surface">
                                <h5 class="title">Vote Summary</h5>
                                <div class="subtotal text-button d-flex justify-content-between align-items-center">
                                    <span>Total Votes</span>
                                    <span class="total">{{ totalVotes }}</span>
                                </div>
                                <div class="discount text-button d-flex justify-content-between align-items-center">
                                    <span>Cost per Vote</span>
                                    <span class="total">{{ formatCurrency(costPerVote) }}</span>
                                </div>
                                <h5 class="total-order d-flex justify-content-between align-items-center">
                                    <span>Final Total</span>
                                    <span class="total">{{ formatCurrency(finalTotal) }}</span>
                                </h5>
                                <div class="box-progress-checkout">
                                    <fieldset class="check-agree">
                                        <input
                                            type="checkbox"
                                            id="check-agree"
                                            class="tf-check-rounded"
                                        >
                                        <label for="check-agree">
                                            I agree to the
                                            <a href="term-of-use.html">voting terms and conditions</a>
                                        </label>
                                    </fieldset>
                                    <Link href="/checkout" class="tf-btn btn-reset">Proceed to Vote</Link>
                                    <div class="text-center">
                                        <Link href="/contestants" class="text-button">Continue Voting</Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </Layout>
</template>

<style scoped>
.cart-empty-state {
    min-height: 55vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.cart-empty-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.vote-quantity-cell {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}

.vote-quantity-cell .quantity-product {
    width: 88px;
    text-align: center;
}

.vote-quick-actions {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 8px;
}

.vote-batch-btn {
    border: 1px solid rgba(24, 24, 24, 0.14);
    border-radius: 999px;
    background: #fff;
    color: #181818;
    font-size: 12px;
    font-weight: 600;
    line-height: 1;
    padding: 8px 12px;
    transition: all 0.2s ease;
}

.vote-batch-btn:hover,
.vote-batch-btn:focus-visible {
    border-color: #181818;
    background: #181818;
    color: #fff;
    outline: none;
}
</style>
