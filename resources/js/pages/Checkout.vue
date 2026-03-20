<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { COST_PER_VOTE } from '@/config/voting';
import Breadcrumb from '@/components/ui/Breadcrumb.vue';
import { contestants as contestantsData } from '@/data/contestants';
import { voteCart as voteCartData } from '@/data/voteCart';
import Layout from '@/layouts/Layout.vue';

type Contestant = (typeof contestantsData)[number];
type VoteSelection = (typeof voteCartData)[number];

type VoteConfirmationItem = {
    id: VoteSelection['id'];
    contestant: Contestant;
    votes: number;
    totalCost: number;
};

type AuthUser = {
    id: number;
    name: string;
    email: string;
} | null;

const page = usePage();
const currentUser = computed(() => page.props.auth?.user as AuthUser);

const currencyFormatter = new Intl.NumberFormat('en-NG', {
    style: 'currency',
    currency: 'NGN',
    currencyDisplay: 'narrowSymbol',
    maximumFractionDigits: 0,
});

const formatCurrency = (amount: number) => currencyFormatter.format(amount);

const cartItems = computed<VoteConfirmationItem[]>(() => {
    return voteCartData.reduce<VoteConfirmationItem[]>((items, selection) => {
        const contestant = contestantsData.find(
            (entry) => entry.id === selection.contestantId,
        );

        if (!contestant) return items;

        items.push({
            id: selection.id,
            contestant,
            votes: selection.votes,
            totalCost: selection.votes * COST_PER_VOTE,
        });

        return items;
    }, []);
});

const totalVotes = computed(() => {
    return cartItems.value.reduce((sum, item) => sum + item.votes, 0);
});

const finalTotal = computed(() => totalVotes.value * COST_PER_VOTE);
</script>

<template>
    <Head title="Confirm Vote" />

    <Layout>
        <Breadcrumb
            :items="[
                { label: 'Home', link: '/' },
                { label: 'Vote Cart', link: '/cart' },
                { label: 'Confirm Vote' },
            ]"
            design="image"
            heading="Confirm Your Vote"
            background-image="/tmp/images/section/page-title.jpg"
        />

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="flat-spacing tf-page-checkout">
                            <div v-if="!currentUser" class="wrap">
                                <h5 class="title">Authentication Required</h5>
                                <p class="text-secondary mb_16">
                                    Login or create an account to complete your vote.
                                </p>
                                <div class="d-flex flex-wrap gap-12">
                                    <Link href="/login" class="tf-btn btn-reset">Login</Link>
                                    <Link href="/register" class="tf-btn">Create Account</Link>
                                </div>
                            </div>
                            <template v-else>
                                <div class="wrap">
                                    <h5 class="title">Voter Details</h5>
                                    <form class="info-box">
                                        <div class="grid-2">
                                            <input type="text" placeholder="First Name*">
                                            <input type="text" placeholder="Last Name*">
                                        </div>
                                        <div class="grid-2">
                                            <input type="text" placeholder="Email Address*">
                                            <input type="text" placeholder="Phone Number*">
                                        </div>
                                    </form>
                                </div>
                                <div class="wrap">
                                    <h5 class="title">Choose Payment Method</h5>
                                    <form class="form-payment">
                                        <div class="payment-box" id="payment-box">
                                            <div class="payment-item payment-choose-card active">
                                                <label
                                                    for="credit-card-method"
                                                    class="payment-header"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#credit-card-payment"
                                                    aria-controls="credit-card-payment"
                                                >
                                                    <input
                                                        type="radio"
                                                        name="payment-method"
                                                        class="tf-check-rounded"
                                                        id="credit-card-method"
                                                        checked
                                                    >
                                                    <span class="text-title">Card Payment</span>
                                                </label>
                                                <div id="credit-card-payment" class="collapse show" data-bs-parent="#payment-box">
                                                    <div class="payment-body">
                                                        <p class="text-secondary">
                                                            Enter your card details to confirm your vote selection securely.
                                                        </p>
                                                        <div class="input-payment-box">
                                                            <input type="text" placeholder="Name On Card*">
                                                            <div class="ip-card">
                                                                <input type="text" placeholder="Card Numbers*">
                                                                <div class="list-card">
                                                                    <img src="/tmp/images/payment/img-7.png" width="48" height="16" alt="card">
                                                                    <img src="/tmp/images/payment/img-8.png" width="21" height="16" alt="card">
                                                                    <img src="/tmp/images/payment/img-9.png" width="22" height="16" alt="card">
                                                                    <img src="/tmp/images/payment/img-10.png" width="24" height="16" alt="card">
                                                                </div>
                                                            </div>
                                                            <div class="grid-2">
                                                                <input type="date">
                                                                <input type="text" placeholder="CVV*">
                                                            </div>
                                                        </div>
                                                        <div class="check-save">
                                                            <input type="checkbox" class="tf-check" id="check-card" checked>
                                                            <label for="check-card">Save Card Details</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="payment-item paypal-item">
                                                <label
                                                    for="paypal-method"
                                                    class="payment-header collapsed"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#paypal-method-payment"
                                                    aria-controls="paypal-method-payment"
                                                >
                                                    <input
                                                        type="radio"
                                                        name="payment-method"
                                                        class="tf-check-rounded"
                                                        id="paypal-method"
                                                    >
                                                    <span class="paypal-title">
                                                        <img src="/tmp/images/payment/paypal.png" alt="paypal">
                                                    </span>
                                                </label>
                                                <div id="paypal-method-payment" class="collapse" data-bs-parent="#payment-box">
                                                    <div class="payment-body">
                                                        <p class="text-secondary mb-0">
                                                            Continue with PayPal to complete payment and submit your votes.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="tf-btn btn-reset">Confirm &amp; Pay</button>
                                    </form>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="col-xl-1">
                        <div class="line-separation"></div>
                    </div>
                    <div class="col-xl-5">
                        <div class="flat-spacing flat-sidebar-checkout">
                            <div class="sidebar-checkout-content">
                                <h5 class="title">Your Vote Selection</h5>
                                <div class="list-product">
                                    <div
                                        v-for="item in cartItems"
                                        :key="item.id"
                                        class="item-product"
                                    >
                                        <Link :href="`/contestants/${item.contestant.slug}`" class="img-product">
                                            <img :src="item.contestant.image" :alt="item.contestant.name">
                                        </Link>
                                        <div class="content-box">
                                            <div class="info">
                                                <Link
                                                    :href="`/contestants/${item.contestant.slug}`"
                                                    class="name-product link text-title"
                                                >
                                                    {{ item.contestant.name }}
                                                </Link>
                                                <div class="variant text-caption-1 text-secondary">
                                                    {{ item.contestant.contestName }}
                                                </div>
                                                <div class="variant text-caption-1 text-secondary">
                                                    Votes: {{ item.votes }} x {{ formatCurrency(COST_PER_VOTE) }}
                                                </div>
                                            </div>
                                            <div class="total-price text-button">{{ formatCurrency(item.totalCost) }}</div>
                                        </div>
                                    </div>
                                    <div v-if="!cartItems.length" class="item-product">
                                        <div class="content-box">
                                            <div class="info">
                                                <div class="name-product text-title">No vote selections found.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sec-total-price">
                                    <div class="top">
                                        <div class="item d-flex align-items-center justify-content-between text-button">
                                            <span>Total Votes</span>
                                            <span>{{ totalVotes }}</span>
                                        </div>
                                        <div class="item d-flex align-items-center justify-content-between text-button">
                                            <span>Cost per Vote</span>
                                            <span>{{ formatCurrency(COST_PER_VOTE) }}</span>
                                        </div>
                                    </div>
                                    <div class="bottom">
                                        <h5 class="d-flex justify-content-between">
                                            <span>Final Total</span>
                                            <span class="total-price-checkout">{{ formatCurrency(finalTotal) }}</span>
                                        </h5>
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
