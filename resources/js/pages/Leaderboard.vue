<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Layout from '@/layouts/Layout.vue';
</script>

<template>
    <Head title="Leaderboard" />

    <Layout>
        <div class="page-title" style="background-image: url(/tmp/images/section/page-title.jpg);">
            <div class="container-full">
                <div class="row">
                    <div class="col-12">
                        <h3 class="heading text-center">Leaderboard</h3>
                        <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                            <li>
                                <a class="link" href="/">Homepage</a>
                            </li>
                            <li>
                                <i class="icon-arrRight"></i>
                            </li>
                            <li>
                                Leaderboard
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page-title -->
        <!-- Collections -->
        <section class="flat-spacing">
            <div class="container">
                <div class="tf-grid-layout tf-col-2 lg-col-4">
                    <!-- item 1 -->
                    <div class="collection-position-2 radius-lg style-3 hover-img">
                        <a class="img-style" href="/contestants/john-doe">
                            <img class="lazyload" data-src="/tmp/images/collections/shop-cls/men-cls.jpg" src="/tmp/images/collections/shop-cls/men-cls.jpg" alt="banner-cls">
                        </a>
                        <div class="content">
                            <a href="/contestants/john-doe" class="cls-btn"><h6 class="text">Men's</h6> <span class="count-item text-secondary">12 items</span> <i class="icon icon-arrowUpRight"></i></a>
                        </div>
                    </div>
                    <!-- item 2 -->
                    <div class="collection-position-2 radius-lg style-3 hover-img">
                        <a class="img-style" href="/contestants/amira-khan">
                            <img class="lazyload" data-src="/tmp/images/collections/shop-cls/women-cls.jpg" src="/tmp/images/collections/shop-cls/women-cls.jpg" alt="banner-cls">
                        </a>
                        <div class="content">
                            <a href="/contestants/amira-khan" class="cls-btn"><h6 class="text">Women's</h6> <span class="count-item text-secondary">12 items</span> <i class="icon icon-arrowUpRight"></i></a>
                        </div>
                    </div>
                    <!-- item 3 -->
                    <div class="collection-position-2 radius-lg style-3 hover-img">
                        <a class="img-style" href="/contestants/emeka-ade">
                            <img class="lazyload" data-src="/tmp/images/collections/shop-cls/kid-cls.jpg" src="/tmp/images/collections/shop-cls/kid-cls.jpg" alt="banner-cls">
                        </a>
                        <div class="content">
                            <a href="/contestants/emeka-ade" class="cls-btn"><h6 class="text">Kid's</h6> <span class="count-item text-secondary">12 items</span> <i class="icon icon-arrowUpRight"></i></a>
                        </div>
                    </div>
                    <!-- item 4 -->
                    <div class="collection-position-2 radius-lg style-3 hover-img">
                        <a class="img-style" href="/contestants/anita-brown">
                            <img class="lazyload" data-src="/tmp/images/collections/shop-cls/jewelry-cls.jpg" src="/tmp/images/collections/shop-cls/jewelry-cls.jpg" alt="banner-cls">
                        </a>
                        <div class="content">
                            <a href="/contestants/anita-brown" class="cls-btn"><h6 class="text">Jewelry</h6> <span class="count-item text-secondary">12 items</span> <i class="icon icon-arrowUpRight"></i></a>
                        </div>
                    </div>
                    <!-- item 5 -->
                    <div class="collection-position-2 radius-lg style-3 hover-img">
                        <a class="img-style" href="/contestants/kofi-james">
                            <img class="lazyload" data-src="/tmp/images/collections/shop-cls/dresses-cls.jpg" src="/tmp/images/collections/shop-cls/dresses-cls.jpg" alt="banner-cls">
                        </a>
                        <div class="content">
                            <a href="/contestants/kofi-james" class="cls-btn"><h6 class="text">Dresses</h6> <span class="count-item text-secondary">12 items</span> <i class="icon icon-arrowUpRight"></i></a>
                        </div>
                    </div>
                    <!-- item 6 -->
                    <div class="collection-position-2 radius-lg style-3 hover-img">
                        <a class="img-style" href="/contestants/zara-kim">
                            <img class="lazyload" data-src="/tmp/images/collections/shop-cls/top-cls.jpg" src="/tmp/images/collections/shop-cls/top-cls.jpg" alt="banner-cls">
                        </a>
                        <div class="content">
                            <a href="/contestants/zara-kim" class="cls-btn"><h6 class="text">Tops</h6> <span class="count-item text-secondary">12 items</span> <i class="icon icon-arrowUpRight"></i></a>
                        </div>
                    </div>
                    <!-- item 7 -->
                    <div class="collection-position-2 radius-lg style-3 hover-img">
                        <a class="img-style" href="/contestants/michael-odu">
                            <img class="lazyload" data-src="/tmp/images/collections/shop-cls/bottom-cls.jpg" src="/tmp/images/collections/shop-cls/bottom-cls.jpg" alt="banner-cls">
                        </a>
                        <div class="content">
                            <a href="/contestants/michael-odu" class="cls-btn"><h6 class="text">Bottoms</h6> <span class="count-item text-secondary">12 items</span> <i class="icon icon-arrowUpRight"></i></a>
                        </div>
                    </div>
                    <!-- item 8 -->
                    <div class="collection-position-2 radius-lg style-3 hover-img">
                        <a class="img-style" href="/contestants/elsa-adele">
                            <img class="lazyload" data-src="/tmp/images/collections/shop-cls/outerwear-cls.jpg" src="/tmp/images/collections/shop-cls/outerwear-cls.jpg" alt="banner-cls">
                        </a>
                        <div class="content">
                            <a href="/contestants/elsa-adele" class="cls-btn"><h6 class="text">Outerwear</h6> <span class="count-item text-secondary">12 items</span> <i class="icon icon-arrowUpRight"></i></a>
                        </div>
                    </div>
                    <!-- item 9 -->
                    <div class="collection-position-2 radius-lg style-3 hover-img">
                        <a class="img-style" href="/contestants/john-doe">
                            <img class="lazyload" data-src="/tmp/images/collections/shop-cls/shoes-cls.jpg" src="/tmp/images/collections/shop-cls/shoes-cls.jpg" alt="banner-cls">
                        </a>
                        <div class="content">
                            <a href="/contestants/john-doe" class="cls-btn"><h6 class="text">Shoes</h6> <span class="count-item text-secondary">12 items</span> <i class="icon icon-arrowUpRight"></i></a>
                        </div>
                    </div>
                    <!-- item 10 -->
                    <div class="collection-position-2 radius-lg style-3 hover-img">
                        <a class="img-style" href="/contestants/amira-khan">
                            <img class="lazyload" data-src="/tmp/images/collections/shop-cls/bags-cls.jpg" src="/tmp/images/collections/shop-cls/bags-cls.jpg" alt="banner-cls">
                        </a>
                        <div class="content">
                            <a href="/contestants/amira-khan" class="cls-btn"><h6 class="text">Bags</h6> <span class="count-item text-secondary">12 items</span> <i class="icon icon-arrowUpRight"></i></a>
                        </div>
                    </div>
                    <!-- item 11 -->
                    <div class="collection-position-2 radius-lg style-3 hover-img">
                        <a class="img-style" href="/contestants/emeka-ade">
                            <img class="lazyload" data-src="/tmp/images/collections/shop-cls/accessories-cls.jpg" src="/tmp/images/collections/shop-cls/accessories-cls.jpg" alt="banner-cls">
                        </a>
                        <div class="content">
                            <a href="/contestants/emeka-ade" class="cls-btn"><h6 class="text">Accessories</h6> <span class="count-item text-secondary">12 items</span> <i class="icon icon-arrowUpRight"></i></a>
                        </div>
                    </div>
                    <!-- item 12 -->
                    <div class="collection-position-2 radius-lg style-3 hover-img">
                        <a class="img-style" href="/contestants/zara-kim">
                            <img class="lazyload" data-src="/tmp/images/collections/shop-cls/lingerie-cls.jpg" src="/tmp/images/collections/shop-cls/lingerie-cls.jpg" alt="banner-cls">
                        </a>
                        <div class="content">
                            <a href="/contestants/zara-kim" class="cls-btn"><h6 class="text">Lingerie</h6> <span class="count-item text-secondary">12 items</span> <i class="icon icon-arrowUpRight"></i></a>
                        </div>
                    </div>
                    <!-- pagination -->
                    <ul class="wg-pagination justify-content-center">
                        <li><a href="#" class="pagination-item text-button">1</a></li>
                        <li class="active"><div class="pagination-item text-button">2</div></li>
                        <li><a href="#" class="pagination-item text-button">3</a></li>
                        <li><a href="#" class="pagination-item text-button"><i class="icon-arrRight"></i></a></li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- /Collections -->
        
        
        
       
        <!-- Footer -->
    </Layout>
</template>
