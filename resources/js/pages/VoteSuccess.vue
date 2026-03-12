<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Breadcrumb from '@/components/ui/Breadcrumb.vue';
import Layout from '@/layouts/Layout.vue';
</script>

<template>
    <Head title="Vote Success" />

    <Layout>
        <!-- tf-add-cart-success -->
        <div class="tf-add-cart-success">
            <div class="tf-add-cart-heading">
                <h5>Shopping Cart</h5>
                <i class="icon icon-close tf-add-cart-close"></i>
            </div>
            <div class="tf-add-cart-product">
                <div class="image">
                    <img class=" ls-is-cached lazyloaded" data-src="/tmp/images/products/womens/women-3.jpg" alt="" src="/tmp/images/products/womens/women-3.jpg">
                </div>
                <div class="content">
                    <div class="text-title">
                        <a class="link" href="/contestants/john-doe">Biker-style leggings</a>
                    </div>
                    <div class="text-caption-1 text-secondary-2">Green, XS, Cotton</div>
                    <div class="text-title">$68.00</div>
                </div>
            </div>
            <a href="/cart" class="tf-btn w-100 btn-fill radius-4"><span class="text text-btn-uppercase">View cart</span></a>
        </div>
        <!-- /tf-add-cart-success -->

        <Breadcrumb
            :items="[
                { label: 'Homepage', link: '/' },
                { label: 'Pages', link: '#' },
                { label: 'Payment confirmation' },
            ]"
            design="image"
            heading="Payment confirmation"
            background-image="/tmp/images/section/page-title.jpg"
            container-class="container-full"
            :use-row="true"
        />

        <!-- Payment confirmation -->
        <section class="flat-spacing">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <h5 class="fw-5 mb_20">Payment confirmation</h5>
                        <div class="tf-page-cart-checkout">
                            <div class="d-flex align-items-center justify-content-between mb_15">
                                <div class="fs-18">Date</div>
                                <p>01/01/2024</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb_15">
                                <div class="fs-18">Payment method</div>
                                <p>Visa</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb_15">
                                <div class="fs-18">Card number</div>
                                <p>**** **** **** 9999</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb_15">
                                <div class="fs-18">Cardholder name</div>
                                <p>Themesflat</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb_15">
                                <div class="fs-18">Email</div>
                                <p>info@fashionshop.com</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb_15">
                                <div class="fs-18">Phone</div>
                                <p>(212) 555-1234</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb_24">
                                <div class="fs-22 fw-6">Subtotal</div>
                                <span class="total-value">$188.00 USD</span>
                            </div>
                            <div class="d-flex gap-10">
                                <a href="/checkout" class="tf-btn w-100 btn-white radius-4 has-border"><span class="text">Cancel Payment</span></a>
                                <a href="#" class="tf-btn w-100 btn-fill radius-4"><span class="text">Confirm Payment</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Payment confirmation -->

        <!-- Footer -->
    </Layout>
</template>
