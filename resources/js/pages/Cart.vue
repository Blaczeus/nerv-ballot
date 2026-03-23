<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Breadcrumb from '@/components/ui/Breadcrumb.vue';
import { useVoteCart } from '@/composables/useVoteCart';
import Layout from '@/layouts/Layout.vue';
import { formatVotes } from '@/utils/formatVotes';

const { cartItems, totalVotes, finalTotal, costPerVote, formatCurrency, updateVotes, removeVotes } =
    useVoteCart();

const decreaseVotes = (selectionId: number, currentVotes: number) => {
    updateVotes(selectionId, currentVotes - 1);
};

const increaseVotes = (selectionId: number, currentVotes: number) => {
    updateVotes(selectionId, currentVotes + 1);
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
                <div class="row">
                    <div class="col-xl-8">
                        <div v-if="!cartItems.length" class="py-5 text-center">
                            <p class="mb_16">No votes selected yet.</p>
                            <Link href="/contestants" class="tf-btn btn-fill">
                                <span class="text">Explore Contestants</span>
                            </Link>
                        </div>
                        <form v-else>
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
                                        :key="item.id"
                                        class="tf-cart-item"
                                    >
                                        <td class="tf-cart-item_product">
                                            <Link
                                                :href="`/contestants/${item.contestant.slug}`"
                                                class="img-box"
                                            >
                                                <img
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
                                                <p class="text-caption-1 text-secondary mb-0">
                                                    Current Votes: {{ formatVotes(item.contestant.votes) }}
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
                                            <div class="wg-quantity mx-md-auto">
                                                <span
                                                    class="btn-quantity vote-stepper-btn"
                                                    @click="decreaseVotes(item.id, item.votes)"
                                                >
                                                    -
                                                </span>
                                                <input
                                                    type="text"
                                                    class="quantity-product"
                                                    name="votes"
                                                    :value="item.votes"
                                                    readonly
                                                >
                                                <span
                                                    class="btn-quantity vote-stepper-btn"
                                                    @click="increaseVotes(item.id, item.votes)"
                                                >
                                                    +
                                                </span>
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
                                                @click="removeVotes(item.id)"
                                            ></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="col-xl-4">
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
                                    <a href="/checkout" class="tf-btn btn-reset">Proceed to Vote</a>
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
