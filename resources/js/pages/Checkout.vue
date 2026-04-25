<script setup lang="ts">
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed, onMounted, reactive, ref, watch } from 'vue';
import Breadcrumb from '@/components/ui/Breadcrumb.vue';
import { useVoteCart } from '@/composables/useVoteCart';
import Layout from '@/layouts/Layout.vue';

type PageProps = {
    auth?: {
        user?: {
            email?: string | null;
        } | null;
    };
    errors?: {
        checkout?: string;
        system?: string;
        items?: string;
    };
    flash?: {
        success?: string;
    };
};

const page = usePage<PageProps>();
const authenticatedUser = computed(() => page.props.auth?.user ?? null);
const isAuthenticated = computed(() => Boolean(authenticatedUser.value));
const serverErrors = computed(() => page.props.errors ?? {});
const successMessage = computed(() => page.props.flash?.success ?? '');
const checkoutNotice = computed(() => {
    return serverErrors.value.checkout ?? serverErrors.value.system ?? '';
});
const itemsError = computed(() => formErrors.value.items ?? serverErrors.value.items ?? '');
const {
    cartItems,
    cartNotice,
    totalVotes,
    finalTotal,
    costPerVote,
    formatCurrency,
    clearCart,
    isCartReady,
    refreshCart,
} = useVoteCart();

const voterToken = ref('');
const form = reactive({
    email: '',
});
const formErrors = ref<Record<string, string>>({});

const generateUuid = () => {
    if (typeof crypto !== 'undefined') {
        if (typeof crypto.randomUUID === 'function') {
            return crypto.randomUUID();
        }

        if (typeof crypto.getRandomValues === 'function') {
            const array = new Uint8Array(16);
            crypto.getRandomValues(array);

            array[6] = (array[6] & 0x0f) | 0x40;
            array[8] = (array[8] & 0x3f) | 0x80;

            const hex = [...array].map((byte) => byte.toString(16).padStart(2, '0'));

            return `${hex.slice(0, 4).join('')}-${hex.slice(4, 6).join('')}-${hex.slice(6, 8).join('')}-${hex.slice(8, 10).join('')}-${hex.slice(10, 16).join('')}`;
        }
    }

    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, (character) => {
        const random = Math.random() * 16 | 0;
        const value = character === 'x' ? random : (random & 0x3) | 0x8;
        return value.toString(16);
    });
};

const checkoutItems = computed(() => {
    return cartItems.value.map((item) => ({
        contestant_id: item.contestant_id,
        votes: item.votes,
    }));
});

const validateForm = () => {
    formErrors.value = {};

    if (!isAuthenticated.value && !form.email.trim()) {
        formErrors.value.email = 'Email is required';
    } else if (!form.email.trim()) {
        formErrors.value.email = 'Email is required';
    } else if (!/^\S+@\S+\.\S+$/.test(form.email)) {
        formErrors.value.email = 'Enter a valid email';
    }

    if (!cartItems.value.length) {
        formErrors.value.items = 'Your cart is empty';
    }

    return Object.keys(formErrors.value).length === 0;
};

const handleCheckout = () => {
    if (!validateForm() || !voterToken.value) {
        return;
    }

    router.post('/checkout', {
        email: form.email.trim(),
        voter_token: voterToken.value,
        checkout_token: generateUuid(),
        items: checkoutItems.value,
    }, {
        preserveScroll: true,
        onSuccess: () => {
            clearCart();
        },
    });
};

onMounted(() => {
    if (authenticatedUser.value?.email) {
        form.email = authenticatedUser.value.email;
    }

    const storedToken = window.localStorage.getItem('voter_token');

    if (storedToken) {
        voterToken.value = storedToken;
        return;
    }

    voterToken.value = generateUuid();
    window.localStorage.setItem('voter_token', voterToken.value);
});

watch(itemsError, (message) => {
    if (
        message.includes('no longer available')
        || message.includes('not available for voting right now')
    ) {
        void refreshCart();
    }
});

watch(authenticatedUser, (user) => {
    if (user?.email) {
        form.email = user.email;
    }
}, { immediate: true });
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
                <div v-if="successMessage || checkoutNotice || cartNotice || itemsError" class="mb_24">
                    <div
                        v-if="successMessage"
                        class="tf-notice text-center"
                        style="padding: 14px 18px; border: 1px solid #d1fae5; background: #ecfdf5; color: #065f46;"
                    >
                        {{ successMessage }}
                    </div>
                    <div
                        v-if="checkoutNotice"
                        class="tf-notice text-center"
                        style="padding: 14px 18px; border: 1px solid #fecaca; background: #fef2f2; color: #991b1b;"
                    >
                        <strong class="d-block mb_4">Checkout notice</strong>
                        {{ checkoutNotice }}
                    </div>
                    <div
                        v-if="cartNotice"
                        class="tf-notice text-center"
                        style="padding: 14px 18px; border: 1px solid #fed7aa; background: #fff7ed; color: #9a3412;"
                    >
                        {{ cartNotice }}
                    </div>
                    <div
                        v-if="itemsError"
                        class="tf-notice text-center"
                        style="padding: 14px 18px; border: 1px solid #fed7aa; background: #fff7ed; color: #9a3412;"
                    >
                        <strong class="d-block mb_4">Vote submission issue</strong>
                        {{ itemsError }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="flat-spacing tf-page-checkout">
                            <div class="wrap">
                                <h5 class="title">Voter Details</h5>
                                <p v-if="checkoutNotice" class="text-caption-1 text-danger mb_16">
                                    {{ checkoutNotice }}
                                </p>
                                <form class="info-box">
                                    <div>
                                        <input
                                            v-model="form.email"
                                            type="email"
                                            placeholder="Email Address*"
                                            :readonly="isAuthenticated"
                                            :disabled="isAuthenticated"
                                            :required="!isAuthenticated"
                                            :style="isAuthenticated ? 'opacity: 0.7; cursor: not-allowed;' : ''"
                                        >
                                        <p v-if="formErrors.email" class="text-danger mt_8 mb-0">{{ formErrors.email }}</p>
                                    </div>
                                </form>
                            </div>
                            <div class="wrap">
                                <h5 class="title">Choose Payment Method</h5>
                                <form class="form-payment" @submit.prevent="handleCheckout">
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
                                                <span class="text-title">Secure Payment</span>
                                            </label>
                                            <div id="credit-card-payment" class="collapse show" data-bs-parent="#payment-box">
                                                <div class="payment-body">
                                                    <p class="text-secondary">
                                                        Payments are processed securely via our payment provider.
                                                    </p>
                                                    <p class="text-secondary mb-0">
                                                        You will be redirected to complete your payment.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="tf-btn btn-reset" type="submit" :disabled="!cartItems.length || !voterToken">
                                        Proceed to Payment
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-1">
                        <div class="line-separation"></div>
                    </div>
                    <div class="col-xl-5">
                        <div class="flat-spacing flat-sidebar-checkout">
                            <div class="sidebar-checkout-content">
                                <h5 class="title">Your Vote Selection</h5>
                                <p v-if="itemsError" class="text-caption-1 text-danger mb_16">
                                    {{ itemsError }}
                                </p>
                                <div class="list-product">
                                    <div
                                        v-for="item in cartItems"
                                        :key="item.contestant_id"
                                        class="item-product"
                                    >
                                        <Link :href="`/contestants/${item.contestant.slug}`" class="img-product">
                                            <img v-if="item.contestant.image" :src="item.contestant.image" :alt="item.contestant.name">
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
                                                    Votes: {{ item.votes }} x {{ formatCurrency(costPerVote) }}
                                                </div>
                                            </div>
                                            <div class="total-price text-button">{{ formatCurrency(item.totalCost) }}</div>
                                        </div>
                                    </div>
                                    <div v-if="isCartReady && !cartItems.length" class="item-product">
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
                                            <span>{{ formatCurrency(costPerVote) }}</span>
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
