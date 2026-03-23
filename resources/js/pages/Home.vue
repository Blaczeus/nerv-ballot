<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import {
    LayoutDashboard,
    LogIn,
    Mail,
    Phone,
    ShoppingCart,
    UserPlus,
} from 'lucide-vue-next';
import { computed } from 'vue';
import { useGlobalModals } from '@/composables/useGlobalModals';
import Layout from '@/layouts/Layout.vue';

const { openAskQuestion } = useGlobalModals();
const page = usePage();
const currentUser = computed(() => page.props.auth?.user as Record<string, unknown> | null);
const isAuthenticated = computed(() => Boolean(currentUser.value));
</script>

<template>
    <Head title="Home" />

    <Layout>
<!-- RTL -->
    <a href="javascript:void(0);" id="toggle-rtl" class="btn-style-2 radius-3"><span>RTL</span></a>
    <!-- /RTL  -->

    <!-- preload -->
    <!-- <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div> -->
    <!-- /preload -->
<!-- Slider -->
        <section class="tf-slideshow slider-default slider-effect-fade">
            <div dir="ltr" class="swiper tf-sw-slideshow" data-effect="fade" data-preview="1" data-tablet="1" data-mobile="1" data-centered="false" data-space="0" data-space-mb="0" data-loop="true" data-auto-play="true">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="wrap-slider">
                            <img src="/tmp/images/slider/slider-women1.jpg" alt="fashion-slideshow">
                            <div class="box-content">
                                <div class="content-slider">
                                    <div class="box-title-slider">
                                        <p class="fade-item fade-item-1 subheading text-btn-uppercase text-white">FEATURED COMPETITIONS</p>
                                        <div class="fade-item fade-item-2 heading text-white title-display">Vote. Celebrate. Crown the Winner.</div>
                                        <p class="fade-item fade-item-3 text-white">Discover exciting competitions happening around you. Support your favorite contestants and help decide the winners.</p>
                                    </div>
                                    <div class="fade-item fade-item-4 box-btn-slider">
                                        <a href="/contestants" class="tf-btn btn-fill btn-white"><span class="text">View Active Contests</span><i class="icon icon-arrowUpRight"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="wrap-slider">
                            <img src="/tmp/images/slider/slider-women2.jpg" alt="fashion-slideshow">
                            <div class="box-content">
                                <div class="content-slider">
                                    <div class="box-title-slider">
                                        <p class="fade-item fade-item-1 subheading text-btn-uppercase text-white">COMMUNITY VOTING</p>
                                        <div class="fade-item fade-item-2 heading text-white title-display">Every Vote Tells a Story</div>
                                        <p class="fade-item fade-item-3 text-white">From campus competitions to global talent showcases, your vote gives contestants the spotlight they deserve.</p>
                                    </div>
                                    <div class="fade-item fade-item-4 box-btn-slider">
                                        <a href="/contestants" class="tf-btn btn-fill btn-white"><span class="text">Explore Contests</span><i class="icon icon-arrowUpRight"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="wrap-slider">
                            <img src="/tmp/images/slider/slider-fashion-main1.jpg" alt="voting-slideshow">
                            <div class="box-content">
                                <div class="content-slider">
                                    <div class="box-title-slider">
                                        <p class="fade-item fade-item-1 subheading text-btn-uppercase text-white">HOST A CONTEST</p>
                                        <div class="fade-item fade-item-2 heading text-white title-display">Launch Your Own Contest</div>
                                        <p class="fade-item fade-item-3 text-white">Create professional voting competitions for schools, communities, brands, or talent shows with ease.</p>
                                    </div>
                                    <div class="fade-item fade-item-4 box-btn-slider">
                                        <a href="/about" class="tf-btn btn-fill btn-white"><span class="text">Start a Contest</span><i class="icon icon-arrowUpRight"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrap-pagination">
                <div class="container">
                    <div class="sw-dots sw-pagination-slider type-circle white-circle justify-content-center"></div>
                </div>
            </div>
        </section>
        <!-- /Slider -->
        <!-- collection -->
        <section class="flat-spacing-2 pb_0">
            <div class="container">
                <div class="heading-section-2 wow fadeInUp">
                    <h3>Contest Categories</h3>
                    <a href="/contestants" class="btn-line">View All Contests</a>
                </div>
                <div class="flat-collection-circle wow fadeInUp" data-wow-delay="0.1s">
                    <div dir="ltr" class="swiper tf-sw-collection" data-preview="5" data-tablet="3" data-mobile="2" data-space-lg="20" data-space-md="20" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
                        <div class="swiper-wrapper">
                            <!-- item 1 -->
                            <div class="swiper-slide">
                                <div class="collection-circle hover-img">
                                    <a href="shop-collection.html" class="img-style">
                                        <img class="lazyload" data-src="/tmp/images/collections/collection-circle/cls-circle1.jpg" src="/tmp/images/collections/collection-circle/cls-circle1.jpg" alt="collection-img">
                                    </a>
                                    <div class="collection-content text-center">
                                        <div>
                                            <a href="shop-collection.html" class="cls-title">
                                                <h6 class="text">Campus Competitions</h6>
                                                <i class="icon icon-arrowUpRight"></i>    
                                            </a>
                                        </div>
                                        <div class="count text-secondary">12 active contests</div>
                                    </div>
                                </div>
                            </div>
                            <!-- item 2 -->
                            <div class="swiper-slide">
                                <div class="collection-circle hover-img">
                                    <a href="shop-collection.html" class="img-style">
                                        <img class="lazyload" data-src="/tmp/images/collections/collection-circle/cls-circle2.jpg" src="/tmp/images/collections/collection-circle/cls-circle2.jpg" alt="collection-img">
                                    </a>
                                    <div class="collection-content text-center">
                                        <div>
                                            <a href="shop-collection.html" class="cls-title">
                                                <h6 class="text">Talent Shows</h6>
                                                <i class="icon icon-arrowUpRight"></i>    
                                            </a>
                                        </div>
                                        <div class="count text-secondary">9 active contests</div>
                                    </div>
                                </div>
                            </div>
                            <!-- item 3 -->
                            <div class="swiper-slide">
                                <div class="collection-circle hover-img">
                                    <a href="shop-collection.html" class="img-style">
                                        <img class="lazyload" data-src="/tmp/images/collections/collection-circle/cls-circle3.jpg" src="/tmp/images/collections/collection-circle/cls-circle3.jpg" alt="collection-img">
                                    </a>
                                    <div class="collection-content text-center">
                                        <div>
                                            <a href="shop-collection.html" class="cls-title">
                                                <h6 class="text">Beauty Pageants</h6>
                                                <i class="icon icon-arrowUpRight"></i>    
                                            </a>
                                        </div>
                                        <div class="count text-secondary">8 active contests</div>
                                    </div>
                                </div>
                            </div>
                            <!-- item 4 -->
                            <div class="swiper-slide">
                                <div class="collection-circle hover-img">
                                    <a href="shop-collection.html" class="img-style">
                                        <img class="lazyload" data-src="/tmp/images/collections/collection-circle/cls-circle4.jpg" src="/tmp/images/collections/collection-circle/cls-circle4.jpg" alt="collection-img">
                                    </a>
                                    <div class="collection-content text-center">
                                        <div>
                                            <a href="shop-collection.html" class="cls-title">
                                                <h6 class="text">Brand Campaigns</h6>
                                                <i class="icon icon-arrowUpRight"></i>    
                                            </a>
                                        </div>
                                        <div class="count text-secondary">6 active contests</div>
                                    </div>
                                </div>
                            </div>
                            <!-- item 5 -->
                            <div class="swiper-slide">
                                <div class="collection-circle hover-img">
                                    <a href="shop-collection.html" class="img-style">
                                        <img class="lazyload" data-src="/tmp/images/collections/collection-circle/cls-circle5.jpg" src="/tmp/images/collections/collection-circle/cls-circle5.jpg" alt="collection-img">
                                    </a>
                                    <div class="collection-content text-center">
                                        <div>
                                            <a href="shop-collection.html" class="cls-title">
                                                <h6 class="text">Community Awards</h6>
                                                <i class="icon icon-arrowUpRight"></i>    
                                            </a>
                                        </div>
                                        <div class="count text-secondary">10 active contests</div>
                                    </div>
                                </div>
                            </div>
                            <!-- item 6 -->
                            <div class="swiper-slide">
                                <div class="collection-circle hover-img">
                                    <a href="shop-collection.html" class="img-style">
                                        <img class="lazyload" data-src="/tmp/images/collections/collection-circle/cls-circle1.jpg" src="/tmp/images/collections/collection-circle/cls-circle1.jpg" alt="collection-img">
                                    </a>
                                    <div class="collection-content text-center">
                                        <div>
                                            <a href="shop-collection.html" class="cls-title">
                                                <h6 class="text">Online Challenges</h6>
                                                <i class="icon icon-arrowUpRight"></i>    
                                            </a>
                                        </div>
                                        
                                        <div class="count text-secondary">7 active contests</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex d-lg-none sw-pagination-collection sw-dots type-circle justify-content-center"></div>
                    </div>
                    <div class="nav-prev-collection d-none d-lg-flex nav-sw style-line nav-sw-left"><i class="icon icon-arrLeft"></i></div>
                    <div class="nav-next-collection d-none d-lg-flex nav-sw style-line nav-sw-right"><i class="icon icon-arrRight"></i></div>
                </div>
            </div>
        </section>
        <!-- /collection -->
        <!-- Seller -->
        <section class="flat-spacing-3">
            <div class="container">
                <div class="flat-animate-tab">
                    <ul class="tab-product justify-content-sm-center" role="tablist">
                        <li class="nav-tab-item" role="presentation">
                            <a href="#newArrivals" class="active" data-bs-toggle="tab">Trending Contestants</a>
                        </li>
                        <li class="nav-tab-item" role="presentation">
                            <a href="#bestSeller" data-bs-toggle="tab">Top Ranked</a>
                        </li>
                        <li class="nav-tab-item" role="presentation">
                            <a href="#onSale" data-bs-toggle="tab">Recently Added</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active show" id="newArrivals" role="tabpanel">
                            <div class="tf-grid-layout tf-col-2 lg-col-3 xl-col-4">
                                <!-- card product 1 -->
                                <div class="card-product wow fadeInUp">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-19.jpg" src="/tmp/images/products/womens/women-19.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-20.jpg" src="/tmp/images/products/womens/women-20.jpg" alt="image-product">
                                        </a>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/cart" class="btn-main-product">Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price">1,245 votes</span>
                                    </div>
                                </div>
                                <!-- card product 2 -->
                                <div class="card-product wow fadeInUp" data-wow-delay="0.1s">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-176.jpg" src="/tmp/images/products/womens/women-176.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-179.jpg" src="/tmp/images/products/womens/women-179.jpg" alt="image-product">
                                        </a>
                                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                                        <div class="marquee-product bg-main">
                                            <div class="marquee-wrapper">
                                                <div class="initial-child-container">
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="marquee-wrapper">
                                                <div class="initial-child-container">
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/cart" class="btn-main-product">Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price"><span class="old-price">1,245 votes</span> 1,245 votes</span>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch active line">
                                                <span class="swatch-value bg-light-blue"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-176.jpg" src="/tmp/images/products/womens/women-176.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-light-blue-2"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-177.jpg" src="/tmp/images/products/womens/women-177.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- card product 3 -->
                                <div class="card-product card-product-size wow fadeInUp" data-wow-delay="0.2s">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-29.jpg" src="/tmp/images/products/womens/women-29.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-30.jpg" src="/tmp/images/products/womens/women-30.jpg" alt="image-product">
                                        </a>
                                        <div class="variant-wrap size-list">
                                            <ul class="variant-box">
                                                <li class="size-item">S</li>
                                                <li class="size-item">M</li>
                                                <li class="size-item">L</li>
                                                <li class="size-item">XL</li>
                                            </ul>
                                        </div>
                                        <div class="variant-wrap countdown-wrap">
                                            <div class="variant-box">
                                                <div class="js-countdown" data-timer="1007500" data-labels="D :,H :,M :,S"></div>
                                            </div>
                                        </div>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/contestants" class="btn-main-product">Quick Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price"><span class="old-price">1,245 votes</span> 1,245 votes</span>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch active line">
                                                <span class="swatch-value bg-light-orange"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-29.jpg" src="/tmp/images/products/womens/women-29.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-light-grey"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-33.jpg" src="/tmp/images/products/womens/women-33.jpg" alt="image-product">
                                            </li>
                                            
                                        </ul>
                                    </div>
                                </div>
                                <!-- card product 4 -->
                                <div class="card-product wow fadeInUp" data-wow-delay="0.3s">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-1.jpg" src="/tmp/images/products/womens/women-1.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-2.jpg" src="/tmp/images/products/womens/women-2.jpg" alt="image-product">
                                        </a>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/cart" class="btn-main-product">Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price">1,245 votes</span>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch active line">
                                                <span class="swatch-value bg-dark-grey"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-1.jpg" src="/tmp/images/products/womens/women-1.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-light-pink"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-2.jpg" src="/tmp/images/products/womens/women-2.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-dark-grey-2"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-3.jpg" src="/tmp/images/products/womens/women-3.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- card product 5 -->
                                <div class="card-product card-product-size wow fadeInUp">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-8.jpg" src="/tmp/images/products/womens/women-8.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-9.jpg" src="/tmp/images/products/womens/women-9.jpg" alt="image-product">
                                        </a>
                                        <div class="variant-wrap size-list">
                                            <ul class="variant-box">
                                                <li class="size-item">S</li>
                                                <li class="size-item">M</li>
                                                <li class="size-item">L</li>
                                                <li class="size-item">XL</li>
                                            </ul>
                                        </div>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/contestants" class="btn-main-product">Quick Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price">1,245 votes</span>
                                    </div>
                                </div>
                                <!-- card product 6 -->
                                <div class="card-product wow fadeInUp" data-wow-delay="0.1s">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-171.jpg" src="/tmp/images/products/womens/women-171.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-172.jpg" src="/tmp/images/products/womens/women-172.jpg" alt="image-product">
                                        </a>
                                        
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/contestants" class="btn-main-product">Quick Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price">1,245 votes</span>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch active">
                                                <span class="swatch-value bg-orange"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-171.jpg" src="/tmp/images/products/womens/women-171.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-dark-pink"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-172.jpg" src="/tmp/images/products/womens/women-172.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- card product 7 -->
                                <div class="card-product card-product-size wow fadeInUp" data-wow-delay="0.2s">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-83.jpg" src="/tmp/images/products/womens/women-83.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-84.jpg" src="/tmp/images/products/womens/women-84.jpg" alt="image-product">
                                        </a>
                                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                                        <div class="variant-wrap size-list">
                                            <ul class="variant-box">
                                                <li class="size-item">S</li>
                                                <li class="size-item">M</li>
                                                <li class="size-item">L</li>
                                                <li class="size-item">XL</li>
                                            </ul>
                                        </div>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/contestants" class="btn-main-product">Quick Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price"><span class="old-price">1,245 votes</span>1,245 votes</span>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch active">
                                                <span class="swatch-value bg-light-green"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-83.jpg" src="/tmp/images/products/womens/women-83.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-grey"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-94.jpg" src="/tmp/images/products/womens/women-94.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch line">
                                                <span class="swatch-value bg-white"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-87.jpg" src="/tmp/images/products/womens/women-87.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- card product 8 -->
                                <div class="card-product card-product-size wow fadeInUp" data-wow-delay="0.3s">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-102.jpg" src="/tmp/images/products/womens/women-102.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-103.jpg" src="/tmp/images/products/womens/women-103.jpg" alt="image-product">
                                        </a>
                                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                                        <div class="variant-wrap size-list">
                                            <ul class="variant-box">
                                                <li class="size-item">S</li>
                                                <li class="size-item">M</li>
                                                <li class="size-item">L</li>
                                                <li class="size-item">XL</li>
                                            </ul>
                                        </div>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/contestants" class="btn-main-product">Quick Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price"><span class="old-price">1,245 votes</span>1,245 votes</span>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch active">
                                                <span class="swatch-value bg-grey-2"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-102.jpg" src="/tmp/images/products/womens/women-102.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-light-orange"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-111.jpg" src="/tmp/images/products/womens/women-111.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch line">
                                                <span class="swatch-value bg-white"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-104.jpg" src="/tmp/images/products/womens/women-104.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="sec-btn text-center">
                                <a href="/contestants" class="btn-line">View All Contestants</a>
                            </div>
                        </div>
                        <div class="tab-pane" id="bestSeller" role="tabpanel">
                            <div class="tf-grid-layout tf-col-2 lg-col-3 xl-col-4">
                                <!-- card product 1 -->
                                <div class="card-product">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-19.jpg" src="/tmp/images/products/womens/women-19.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-20.jpg" src="/tmp/images/products/womens/women-20.jpg" alt="image-product">
                                        </a>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/cart" class="btn-main-product">Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price">1,245 votes</span>
                                        
                                    </div>
                                </div>
                                <!-- card product 2 -->
                                <div class="card-product">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-176.jpg" src="/tmp/images/products/womens/women-176.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-179.jpg" src="/tmp/images/products/womens/women-179.jpg" alt="image-product">
                                        </a>
                                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                                        <div class="marquee-product bg-main">
                                            <div class="marquee-wrapper">
                                                <div class="initial-child-container">
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="marquee-wrapper">
                                                <div class="initial-child-container">
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/cart" class="btn-main-product">Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price"><span class="old-price">1,245 votes</span> 1,245 votes</span>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch active line">
                                                <span class="swatch-value bg-light-blue"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-176.jpg" src="/tmp/images/products/womens/women-176.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-light-blue-2"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-177.jpg" src="/tmp/images/products/womens/women-177.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- card product 3 -->
                                <div class="card-product card-product-size">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-29.jpg" src="/tmp/images/products/womens/women-29.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-30.jpg" src="/tmp/images/products/womens/women-30.jpg" alt="image-product">
                                        </a>
                                        <div class="variant-wrap size-list">
                                            <ul class="variant-box">
                                                <li class="size-item">S</li>
                                                <li class="size-item">M</li>
                                                <li class="size-item">L</li>
                                                <li class="size-item">XL</li>
                                            </ul>
                                        </div>
                                        <div class="variant-wrap countdown-wrap">
                                            <div class="variant-box">
                                                <div class="js-countdown" data-timer="1007500" data-labels="D :,H :,M :,S"></div>
                                            </div>
                                        </div>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/contestants" class="btn-main-product">Quick Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price"><span class="old-price">1,245 votes</span> 1,245 votes</span>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch active line">
                                                <span class="swatch-value bg-light-orange"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-29.jpg" src="/tmp/images/products/womens/women-29.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-light-grey"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-33.jpg" src="/tmp/images/products/womens/women-33.jpg" alt="image-product">
                                            </li>
                                            
                                        </ul>
                                    </div>
                                </div>
                                <!-- card product 4 -->
                                <div class="card-product">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-1.jpg" src="/tmp/images/products/womens/women-1.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-2.jpg" src="/tmp/images/products/womens/women-2.jpg" alt="image-product">
                                        </a>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/cart" class="btn-main-product">Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price">1,245 votes</span>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch active line">
                                                <span class="swatch-value bg-dark-grey"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-1.jpg" src="/tmp/images/products/womens/women-1.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-light-pink"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-2.jpg" src="/tmp/images/products/womens/women-2.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-dark-grey-2"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-3.jpg" src="/tmp/images/products/womens/women-3.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- card product 5 -->
                                <div class="card-product card-product-size">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-8.jpg" src="/tmp/images/products/womens/women-8.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-9.jpg" src="/tmp/images/products/womens/women-9.jpg" alt="image-product">
                                        </a>
                                        <div class="variant-wrap size-list">
                                            <ul class="variant-box">
                                                <li class="size-item">S</li>
                                                <li class="size-item">M</li>
                                                <li class="size-item">L</li>
                                                <li class="size-item">XL</li>
                                            </ul>
                                        </div>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/contestants" class="btn-main-product">Quick Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price">1,245 votes</span>
                                    </div>
                                </div>
                                <!-- card product 6 -->
                                <div class="card-product">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-171.jpg" src="/tmp/images/products/womens/women-171.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-172.jpg" src="/tmp/images/products/womens/women-172.jpg" alt="image-product">
                                        </a>
                                        
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/contestants" class="btn-main-product">Quick Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price">1,245 votes</span>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch active">
                                                <span class="swatch-value bg-orange"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-171.jpg" src="/tmp/images/products/womens/women-171.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-dark-pink"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-172.jpg" src="/tmp/images/products/womens/women-172.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- card product 7 -->
                                <div class="card-product card-product-size">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-83.jpg" src="/tmp/images/products/womens/women-83.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-84.jpg" src="/tmp/images/products/womens/women-84.jpg" alt="image-product">
                                        </a>
                                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                                        <div class="variant-wrap size-list">
                                            <ul class="variant-box">
                                                <li class="size-item">S</li>
                                                <li class="size-item">M</li>
                                                <li class="size-item">L</li>
                                                <li class="size-item">XL</li>
                                            </ul>
                                        </div>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/contestants" class="btn-main-product">Quick Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price"><span class="old-price">1,245 votes</span>1,245 votes</span>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch active">
                                                <span class="swatch-value bg-light-green"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-83.jpg" src="/tmp/images/products/womens/women-83.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-grey"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-94.jpg" src="/tmp/images/products/womens/women-94.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch line">
                                                <span class="swatch-value bg-white"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-87.jpg" src="/tmp/images/products/womens/women-87.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- card product 8 -->
                                <div class="card-product card-product-size">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-102.jpg" src="/tmp/images/products/womens/women-102.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-103.jpg" src="/tmp/images/products/womens/women-103.jpg" alt="image-product">
                                        </a>
                                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                                        <div class="variant-wrap size-list">
                                            <ul class="variant-box">
                                                <li class="size-item">S</li>
                                                <li class="size-item">M</li>
                                                <li class="size-item">L</li>
                                                <li class="size-item">XL</li>
                                            </ul>
                                        </div>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/contestants" class="btn-main-product">Quick Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price"><span class="old-price">1,245 votes</span>1,245 votes</span>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch active">
                                                <span class="swatch-value bg-grey-2"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-102.jpg" src="/tmp/images/products/womens/women-102.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-light-orange"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-111.jpg" src="/tmp/images/products/womens/women-111.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch line">
                                                <span class="swatch-value bg-white"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-104.jpg" src="/tmp/images/products/womens/women-104.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="sec-btn text-center">
                                <a href="shop-default-grid.html" class="btn-line">View All Contestants</a>
                            </div>
                        </div>
                        <div class="tab-pane" id="onSale" role="tabpanel">
                            <div class="tf-grid-layout tf-col-2 lg-col-3 xl-col-4">
                                <!-- card product 1 -->
                                <div class="card-product">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-19.jpg" src="/tmp/images/products/womens/women-19.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-20.jpg" src="/tmp/images/products/womens/women-20.jpg" alt="image-product">
                                        </a>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/cart" class="btn-main-product">Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price">1,245 votes</span>
                                        
                                    </div>
                                </div>
                                <!-- card product 2 -->
                                <div class="card-product">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-176.jpg" src="/tmp/images/products/womens/women-176.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-179.jpg" src="/tmp/images/products/womens/women-179.jpg" alt="image-product">
                                        </a>
                                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                                        <div class="marquee-product bg-main">
                                            <div class="marquee-wrapper">
                                                <div class="initial-child-container">
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="marquee-wrapper">
                                                <div class="initial-child-container">
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                                    </div>
                                                    <div class="marquee-child-item">
                                                        <span class="icon icon-lightning text-critical"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/cart" class="btn-main-product">Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price"><span class="old-price">1,245 votes</span> 1,245 votes</span>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch active line">
                                                <span class="swatch-value bg-light-blue"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-176.jpg" src="/tmp/images/products/womens/women-176.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-light-blue-2"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-177.jpg" src="/tmp/images/products/womens/women-177.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- card product 3 -->
                                <div class="card-product card-product-size">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-29.jpg" src="/tmp/images/products/womens/women-29.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-30.jpg" src="/tmp/images/products/womens/women-30.jpg" alt="image-product">
                                        </a>
                                        <div class="variant-wrap size-list">
                                            <ul class="variant-box">
                                                <li class="size-item">S</li>
                                                <li class="size-item">M</li>
                                                <li class="size-item">L</li>
                                                <li class="size-item">XL</li>
                                            </ul>
                                        </div>
                                        <div class="variant-wrap countdown-wrap">
                                            <div class="variant-box">
                                                <div class="js-countdown" data-timer="1007500" data-labels="D :,H :,M :,S"></div>
                                            </div>
                                        </div>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/contestants" class="btn-main-product">Quick Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price"><span class="old-price">1,245 votes</span> 1,245 votes</span>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch active line">
                                                <span class="swatch-value bg-light-orange"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-29.jpg" src="/tmp/images/products/womens/women-29.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-light-grey"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-33.jpg" src="/tmp/images/products/womens/women-33.jpg" alt="image-product">
                                            </li>
                                            
                                        </ul>
                                    </div>
                                </div>
                                <!-- card product 4 -->
                                <div class="card-product">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-1.jpg" src="/tmp/images/products/womens/women-1.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-2.jpg" src="/tmp/images/products/womens/women-2.jpg" alt="image-product">
                                        </a>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/cart" class="btn-main-product">Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price">1,245 votes</span>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch active line">
                                                <span class="swatch-value bg-dark-grey"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-1.jpg" src="/tmp/images/products/womens/women-1.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-light-pink"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-2.jpg" src="/tmp/images/products/womens/women-2.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-dark-grey-2"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-3.jpg" src="/tmp/images/products/womens/women-3.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- card product 5 -->
                                <div class="card-product card-product-size">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-8.jpg" src="/tmp/images/products/womens/women-8.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-9.jpg" src="/tmp/images/products/womens/women-9.jpg" alt="image-product">
                                        </a>
                                        <div class="variant-wrap size-list">
                                            <ul class="variant-box">
                                                <li class="size-item">S</li>
                                                <li class="size-item">M</li>
                                                <li class="size-item">L</li>
                                                <li class="size-item">XL</li>
                                            </ul>
                                        </div>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/contestants" class="btn-main-product">Quick Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price">1,245 votes</span>
                                    </div>
                                </div>
                                <!-- card product 6 -->
                                <div class="card-product">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-171.jpg" src="/tmp/images/products/womens/women-171.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-172.jpg" src="/tmp/images/products/womens/women-172.jpg" alt="image-product">
                                        </a>
                                        
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/contestants" class="btn-main-product">Quick Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price">1,245 votes</span>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch active">
                                                <span class="swatch-value bg-orange"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-171.jpg" src="/tmp/images/products/womens/women-171.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-dark-pink"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-172.jpg" src="/tmp/images/products/womens/women-172.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- card product 7 -->
                                <div class="card-product card-product-size">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-83.jpg" src="/tmp/images/products/womens/women-83.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-84.jpg" src="/tmp/images/products/womens/women-84.jpg" alt="image-product">
                                        </a>
                                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                                        <div class="variant-wrap size-list">
                                            <ul class="variant-box">
                                                <li class="size-item">S</li>
                                                <li class="size-item">M</li>
                                                <li class="size-item">L</li>
                                                <li class="size-item">XL</li>
                                            </ul>
                                        </div>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/contestants" class="btn-main-product">Quick Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price"><span class="old-price">1,245 votes</span>1,245 votes</span>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch active">
                                                <span class="swatch-value bg-light-green"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-83.jpg" src="/tmp/images/products/womens/women-83.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-grey"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-94.jpg" src="/tmp/images/products/womens/women-94.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch line">
                                                <span class="swatch-value bg-white"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-87.jpg" src="/tmp/images/products/womens/women-87.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- card product 8 -->
                                <div class="card-product card-product-size">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="lazyload img-product" data-src="/tmp/images/products/womens/women-102.jpg" src="/tmp/images/products/womens/women-102.jpg" alt="image-product">
                                            <img class="lazyload img-hover" data-src="/tmp/images/products/womens/women-103.jpg" src="/tmp/images/products/womens/women-103.jpg" alt="image-product">
                                        </a>
                                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                                        <div class="variant-wrap size-list">
                                            <ul class="variant-box">
                                                <li class="size-item">S</li>
                                                <li class="size-item">M</li>
                                                <li class="size-item">L</li>
                                                <li class="size-item">XL</li>
                                            </ul>
                                        </div>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Favorite</span>
                                            </a>
                                            <a href="/contestants" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">View Profile</span>
                                            </a>
                                        </div>
                                        <div class="list-btn-main">
                                            <a href="/contestants" class="btn-main-product">Quick Vote</a>
                                        </div> 
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="title link">Contestant Name</a>
                                        <span class="price"><span class="old-price">1,245 votes</span>1,245 votes</span>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch active">
                                                <span class="swatch-value bg-grey-2"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-102.jpg" src="/tmp/images/products/womens/women-102.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch">
                                                <span class="swatch-value bg-light-orange"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-111.jpg" src="/tmp/images/products/womens/women-111.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch line">
                                                <span class="swatch-value bg-white"></span>
                                                <img class="lazyload" data-src="/tmp/images/products/womens/women-104.jpg" src="/tmp/images/products/womens/women-104.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="sec-btn text-center">
                                <a href="shop-default-grid.html" class="btn-line">View All Contestants</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Seller -->
        <!-- Banner collection -->
        <section class="flat-spacing pt-0">
            <div class="container">
                <div class="tf-grid-layout md-col-2">
                    <div class="collection-default hover-img">
                        <a class="img-style">
                            <img class="lazyload" data-src="/tmp/images/collections/banner-collection/banner-cls1.jpg" src="/tmp/images/collections/banner-collection/banner-cls1.jpg" alt="banner-cls">
                        </a>
                        <div class="content">
                            <h3 class="title wow fadeInUp"><a href="/contestants" class="link">Campus Crown 2026</a></h3>
                            <p class="desc wow fadeInUp">The biggest inter-university beauty contest. Support your school’s representative.</p>
                            <div class="wow fadeInUp">
                                <a href="/contestants" class="btn-line">Vote Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="collection-position hover-img">
                        <a class="img-style">
                            <img class="lazyload" data-src="/tmp/images/collections/banner-collection/banner-cls2.jpg" src="/tmp/images/collections/banner-collection/banner-cls2.jpg" alt="banner-cls">
                        </a>
                        <div class="content">
                            <h3 class="title"><a href="/contestants" class="link text-white wow fadeInUp">Global Talent Showcase</a></h3>
                            <p class="desc text-white wow fadeInUp">Singers, dancers, creators — vote for the most talented performer.</p>
                            <div class=" wow fadeInUp">
                                <a href="/contestants" class="btn-line style-white">Explore Contest</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Banner collection -->
        <!-- Banner countdown -->
        <section class="bg-surface flat-spacing flat-countdown-banner">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="banner-left">
                            <div class="box-title">
                                <h3 class="wow fadeInUp">Voting Ends Soon</h3>
                                <p class="text-secondary wow fadeInUp">Only a limited time left to support your favorite contestant.</p>
                            </div>
                            <div class="btn-banner wow fadeInUp">
                                <a href="/contestants" class="tf-btn btn-fill"><span class="text">Cast Your Vote</span><i class="icon icon-arrowUpRight"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="banner-img">
                            <img class="lazyload" data-src="/tmp/images/banner/img-countdown1.png" src="/tmp/images/banner/img-countdown1.png" alt="banner">
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="banner-right">
                            <div class="tf-countdown-lg">
                                <div class="js-countdown" data-timer="1007500" data-labels="Days,Hours,Mins,Secs"></div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
        <!-- /Banner countdown -->
        <!-- Testimonial -->
        <section class="flat-spacing">
            <div class="container">
                <div class="heading-section text-center">
                    <h3 class="heading wow fadeInUp">Success Stories</h3>
                    <p class="subheading wow fadeInUp">Organizers and communities share how their contests grew with this platform.</p>
                </div>
                <div dir="ltr" class="swiper tf-sw-testimonial" data-preview="2" data-tablet="1.3" data-mobile="1" data-space-lg="30" data-space-md="30" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testimonial-item hover-img">
                                <div class="img-style">
                                    <img data-src="/tmp/images/testimonial/tes-1.jpg" src="/tmp/images/testimonial/tes-1.jpg" alt="img-testimonial">
                                    <a href="/contestants" class="box-icon hover-tooltip center">
                                        <span class="icon icon-eye"></span>
                                        <span class="tooltip">View Profile</span>
                                    </a>
                                </div>
                                <div class="content">
                                    <div class="content-top">
                                        <div class="list-star-default">
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                        </div>
                                        <p class="text-secondary">"This platform helped our university run a seamless voting competition with thousands of participants."</p>
                                        <div class="box-author">
                                            <div class="text-title author">Sybil Sharp</div>
                                            <svg class="icon" width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_15758_14563)">
                                                <path d="M6.875 11.6255L8.75 13.5005L13.125 9.12549" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M10 18.5005C14.1421 18.5005 17.5 15.1426 17.5 11.0005C17.5 6.85835 14.1421 3.50049 10 3.50049C5.85786 3.50049 2.5 6.85835 2.5 11.0005C2.5 15.1426 5.85786 18.5005 10 18.5005Z" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </g>
                                                <defs>
                                                <clipPath id="clip0_15758_14563">
                                                <rect width="20" height="20" fill="white" transform="translate(0 0.684082)"/>
                                                </clipPath>
                                                </defs>
                                            </svg> 
                                        </div>
                                    </div>
                                    <div class="box-avt">
                                        <div class="avatar avt-60 round">
                                            <img src="/tmp/images/avatar/user-4.jpg" alt="avt">
                                        </div>
                                        <div class="box-price">
                                            <p class="text-title text-line-clamp-1">Campus Crown 2026</p>
                                            <div class="text-button price">1,245 votes</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-item hover-img">
                                <div class="img-style">
                                    <img data-src="/tmp/images/testimonial/tes-2.jpg" src="/tmp/images/testimonial/tes-2.jpg" alt="img-testimonial">
                                    <a href="/contestants" class="box-icon hover-tooltip center">
                                        <span class="icon icon-eye"></span>
                                        <span class="tooltip">View Profile</span>
                                    </a>
                                </div>
                                <div class="content">
                                    <div class="content-top">
                                        <div class="list-star-default">
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                        </div>
                                        <p class="text-secondary">"Our brand campaign received over 50,000 votes using this platform."</p>
                                        <div class="box-author">
                                            <div class="text-title author">Mark G.</div>
                                            <svg class="icon" width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_15758)">
                                                <path d="M6.875 11.6255L8.75 13.5005L13.125 9.12549" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M10 18.5005C14.1421 18.5005 17.5 15.1426 17.5 11.0005C17.5 6.85835 14.1421 3.50049 10 3.50049C5.85786 3.50049 2.5 6.85835 2.5 11.0005C2.5 15.1426 5.85786 18.5005 10 18.5005Z" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </g>
                                                <defs>
                                                <clipPath id="clip0_15758">
                                                <rect width="20" height="20" fill="white" transform="translate(0 0.684082)"/>
                                                </clipPath>
                                                </defs>
                                            </svg> 
                                        </div>
                                    </div>
                                    <div class="box-avt">
                                        <div class="avatar avt-60 round">
                                            <img src="/tmp/images/avatar/user-5.jpg" alt="avt">
                                        </div>
                                        <div class="box-price">
                                            <p class="text-title text-line-clamp-1">Global Talent Showcase</p>
                                            <div class="text-button price">1,245 votes</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-item hover-img">
                                <div class="img-style">
                                    <img data-src="/tmp/images/testimonial/tes-1.jpg" src="/tmp/images/testimonial/tes-1.jpg" alt="img-testimonial">
                                    <a href="/contestants" class="box-icon hover-tooltip center">
                                        <span class="icon icon-eye"></span>
                                        <span class="tooltip">View Profile</span>
                                    </a>
                                </div>
                                <div class="content">
                                    <div class="content-top">
                                        <div class="list-star-default">
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                        </div>
                                        <p class="text-secondary">"Managing contestants and votes became incredibly easy."</p>
                                        <div class="box-author">
                                            <div class="text-title author">Sybil Sharp</div>
                                            <svg class="icon" width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_15758_14)">
                                                <path d="M6.875 11.6255L8.75 13.5005L13.125 9.12549" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M10 18.5005C14.1421 18.5005 17.5 15.1426 17.5 11.0005C17.5 6.85835 14.1421 3.50049 10 3.50049C5.85786 3.50049 2.5 6.85835 2.5 11.0005C2.5 15.1426 5.85786 18.5005 10 18.5005Z" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </g>
                                                <defs>
                                                <clipPath id="clip0_15758_14">
                                                <rect width="20" height="20" fill="white" transform="translate(0 0.684082)"/>
                                                </clipPath>
                                                </defs>
                                            </svg> 
                                        </div>
                                    </div>
                                    <div class="box-avt">
                                        <div class="avatar avt-60 round">
                                            <img src="/tmp/images/avatar/user-4.jpg" alt="avt">
                                        </div>
                                        <div class="box-price">
                                            <p class="text-title text-line-clamp-1">Community Awards</p>
                                            <div class="text-button price">1,245 votes</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-item hover-img">
                                <div class="img-style">
                                    <img data-src="/tmp/images/testimonial/tes-2.jpg" src="/tmp/images/testimonial/tes-2.jpg" alt="img-testimonial">
                                    <a href="/contestants" class="box-icon hover-tooltip center">
                                        <span class="icon icon-eye"></span>
                                        <span class="tooltip">View Profile</span>
                                    </a>
                                </div>
                                <div class="content">
                                    <div class="content-top">
                                        <div class="list-star-default">
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                        </div>
                                        <p class="text-secondary">"We launched a community awards contest in days and saw engagement surge."</p>
                                        <div class="box-author">
                                            <div class="text-title author">Mark G.</div>
                                            <svg class="icon" width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_15758_145)">
                                                <path d="M6.875 11.6255L8.75 13.5005L13.125 9.12549" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M10 18.5005C14.1421 18.5005 17.5 15.1426 17.5 11.0005C17.5 6.85835 14.1421 3.50049 10 3.50049C5.85786 3.50049 2.5 6.85835 2.5 11.0005C2.5 15.1426 5.85786 18.5005 10 18.5005Z" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </g>
                                                <defs>
                                                <clipPath id="clip0_15758_145">
                                                <rect width="20" height="20" fill="white" transform="translate(0 0.684082)"/>
                                                </clipPath>
                                                </defs>
                                            </svg> 
                                        </div>
                                    </div>
                                    <div class="box-avt">
                                        <div class="avatar avt-60 round">
                                            <img src="/tmp/images/avatar/user-5.jpg" alt="avt">
                                        </div>
                                        <div class="box-price">
                                            <p class="text-title text-line-clamp-1">Rising Star Challenge</p>
                                            <div class="text-button price">1,245 votes</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sw-pagination-testimonial sw-dots type-circle d-flex justify-content-center"></div>
                </div>
            </div>
        </section>
        <!-- /Testimonial -->
        <!-- Latest new -->
        <section class="flat-spacing pt-0">
            <div class="container">
                <div class="heading-section text-center">
                    <h3 class="heading wow fadeInUp">Announcements & Updates</h3>
                    <p class="subheading text-secondary wow fadeInUp">Insights and guidance for running modern voting competitions.</p>
                </div>
                <div dir="ltr" class="swiper tf-sw-recent" data-preview="3" data-tablet="2" data-mobile="1" data-space-lg="30" data-space-md="30" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="wg-blog style-1 hover-image wow fadeInUp">
                                <div class="image">
                                    <img class="lazyload" data-src="/tmp/images/blog/blog-grid-1.jpg" src="/tmp/images/blog/blog-grid-1.jpg" alt="">
                                </div>
                                <div class="content">
                                    <p class="text-btn-uppercase text-secondary-2">13 August</p>
                                    <div>
                                        <h6 class="title fw-5">
                                            <a class="link" href="blog-detail.html">How Online Voting is Transforming Campus Competitions</a>
                                        </h6>
                                        <div class="body-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed vulputate massa.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="wg-blog style-1 hover-image wow fadeInUp" data-wow-delay="0.1s">
                                <div class="image">
                                    <img class="lazyload" data-src="/tmp/images/blog/blog-grid-8.jpg" src="/tmp/images/blog/blog-grid-8.jpg" alt="">
                                </div>
                                <div class="content">
                                    <p class="text-btn-uppercase text-secondary-2">13 August</p>
                                    <div>
                                        <h6 class="title fw-5">
                                            <a class="link" href="blog-detail.html">5 Tips for Running a Successful Voting Contest</a>
                                        </h6>
                                        <div class="body-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed vulputate massa.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="wg-blog style-1 hover-image wow fadeInUp" data-wow-delay="0.2s">
                                <div class="image">
                                    <img class="lazyload" data-src="/tmp/images/blog/blog-grid-6.jpg" src="/tmp/images/blog/blog-grid-6.jpg" alt="">
                                </div>
                                <div class="content">
                                    <p class="text-btn-uppercase text-secondary-2">13 August</p>
                                    
                                    <div>
                                        <h6 class="title fw-5">
                                            <a class="link" href="blog-detail.html">Behind the Scenes of the Global Talent Showcase</a>
                                        </h6>
                                        <div class="body-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed vulputate massa.</div>
                                    </div>
                                </div>
                            </div>
                        </div>       
                    </div>
                    <div class="sw-pagination-recent sw-dots type-circle justify-content-center"></div>
                </div>
            </div>
        </section>
        <!-- /Latest new -->
        <!-- Gallery shop gram -->
        <section>
            <div class="container">
                <div class="heading-section text-center">
                    <h3 class="heading wow fadeInUp">Contest Moments</h3>
                    <p class="subheading text-secondary wow fadeInUp">Highlights from competitions, winners, and celebrations.</p>
                </div>
                <div dir="ltr" class="swiper tf-sw-shop-gallery" data-preview="5" data-tablet="3" data-mobile="2" data-space-lg="10" data-space-md="10" data-space="8" data-pagination="2" data-pagination-md="3" data-pagination-lg="1">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="gallery-item hover-overlay hover-img wow fadeInUp" data-wow-delay=".1s">
                                <div class="img-style">
                                    <img class="lazyload img-hover" data-src="/tmp/images/gallery/gallery-1.jpg" src="/tmp/images/gallery/gallery-1.jpg" alt="image-gallery">
                                </div>
                                <a href="product-detail.html" class="box-icon hover-tooltip"><span class="icon icon-eye"></span> <span class="tooltip">View Moment</span></a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="gallery-item hover-overlay hover-img wow fadeInUp" data-wow-delay=".2s">
                                <div class="img-style">
                                    <img class="lazyload img-hover" data-src="/tmp/images/gallery/gallery-2.jpg" src="/tmp/images/gallery/gallery-2.jpg" alt="image-gallery">
                                </div>
                                <a href="product-detail.html" class="box-icon hover-tooltip"><span class="icon icon-eye"></span> <span class="tooltip">View Moment</span></a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="gallery-item hover-overlay hover-img wow fadeInUp" data-wow-delay=".3s">
                                <div class="img-style">
                                    <img class="lazyload img-hover" data-src="/tmp/images/gallery/gallery-3.jpg" src="/tmp/images/gallery/gallery-3.jpg" alt="image-gallery">
                                </div>
                                <a href="product-detail.html" class="box-icon hover-tooltip"><span class="icon icon-eye"></span> <span class="tooltip">View Moment</span></a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="gallery-item hover-overlay hover-img wow fadeInUp" data-wow-delay=".4s">
                                <div class="img-style">
                                    <img class="lazyload img-hover" data-src="/tmp/images/gallery/gallery-4.jpg" src="/tmp/images/gallery/gallery-4.jpg" alt="image-gallery">
                                </div>
                                <a href="product-detail.html" class="box-icon hover-tooltip"><span class="icon icon-eye"></span> <span class="tooltip">View Moment</span></a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="gallery-item hover-overlay hover-img wow fadeInUp" data-wow-delay=".5s">
                                <div class="img-style">
                                    <img class="lazyload img-hover" data-src="/tmp/images/gallery/gallery-5.jpg" src="/tmp/images/gallery/gallery-5.jpg" alt="image-gallery">
                                </div>
                                <a href="product-detail.html" class="box-icon hover-tooltip"><span class="icon icon-eye"></span> <span class="tooltip">View Moment</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="sw-pagination-gallery sw-dots type-circle justify-content-center"></div>
                </div>
            </div>
        </section>
        <!-- /Gallery shop gram -->
        <!-- Iconbox -->
        <section class="flat-spacing">
            <div class="container">
                <div dir="ltr" class="swiper tf-sw-iconbox" data-preview="4" data-tablet="3" data-mobile-sm="2" data-mobile="1" data-space-lg="30" data-space-md="30" data-space="15" data-pagination="1" data-pagination-sm="2" data-pagination-md="3" data-pagination-lg="4">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="tf-icon-box">
                                <div class="icon-box"><span class="icon icon-return"></span></div>
                                <div class="content text-center">
                                    <h6>Secure Voting</h6>
                                    <p class="text-secondary">Advanced fraud prevention ensures fair results.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box">
                                <div class="icon-box"><span class="icon icon-shipping"></span></div>
                                <div class="content text-center">
                                    <h6>Real-Time Leaderboards</h6>
                                    <p class="text-secondary">Watch contestants climb the rankings instantly.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box">
                                <div class="icon-box"><span class="icon icon-headset"></span></div>
                                <div class="content text-center">
                                    <h6>Easy Contest Setup</h6>
                                    <p class="text-secondary">Launch competitions in minutes.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box">
                                <div class="icon-box"><span class="icon icon-sealCheck"></span></div>
                                <div class="content text-center">
                                    <h6>Scalable Platform</h6>
                                    <p class="text-secondary">Perfect for schools, brands, and global events.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sw-pagination-iconbox sw-dots type-circle justify-content-center"></div>
                </div>
            </div>
        </section>
        <!-- /Iconbox -->
    <template #overlays>

    <div class="modal modalCentered fade auto-popup modal-newleter">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-top">
                    <img class="lazyload" data-src="/tmp/images/section/newsletter.jpg" src="/tmp/images/section/newsletter.jpg" alt="images">
                    <span class="icon icon-close btn-hide-popup" data-bs-dismiss="modal"></span>
                </div>
                <div class="modal-bottom text-center">
                    <p class="text-btn-uppercase fw-4 font-2">Join the Voting Community</p>
                    <h5>Be the first to discover new contests and vote for your favorites.</h5>
                    <div class="sib-form">
                        <div id="sib-form-container" class="sib-form-container">
                            <div id="error-message" class="sib-form-message-panel">
                                <div class="sib-form-message-panel__text sib-form-message-panel__text--center">
                                    <span class="sib-form-message-panel__inner-text">
                                        Your subscription could not be saved. Please try again.
                                    </span>
                                </div>
                            </div>
                            <div id="success-message" class="sib-form-message-panel">
                                <div class="sib-form-message-panel__text sib-form-message-panel__text--center">
                                    <span class="sib-form-message-panel__inner-text">
                                        Your subscription has been successful.
                                    </span>
                                </div>
                            </div>
                            <div id="sib-container" class="sib-container--large sib-container--vertical">
                                <form id="sib-form" method="POST"
                                    action="https://3c02c1a1.sibforms.com/serve/MUIFAOAhSCDRnPhdPWLTpLBkaFR0CvSbJ_okYrjCbXQRLkZZU67Hn2jdn18hTWJuGupI4VUfB4deuJIyP5yRoHWVb9pIrENAMcal9Jtz8q_qN4dpHNMIG454DwSVNVmnLXuePoOCvDqN_Vvs0ga_kzg7ouD63HjCaukRz3LGCQsfnQJBN4-KS2D3DVitqvFsDHSqevjjqLk2xFO4"
                                    data-type="subscription">
                                    <div>
                                        <div class="sib-form-block">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="sib-form-block">
                                            <div class="sib-text-form-block">
                                                <p></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="sib-input sib-form-block">
                                            <div class="form__entry entry_block">
                                                <div class="form__label-row ">
                                                    <label class="entry__label" for="EMAIL">
                                                    </label>
                                                    <div class="entry__field">
                                                        <input class="input " type="text" id="EMAIL" name="EMAIL" autocomplete="off"
                                                            placeholder="Enter Your Email..." data-required="true" required />
                                                    </div>
                                                </div>
                                                <label class="entry__error entry__error--primary"></label>
                                                <label class="entry__specification">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="sib-optin sib-form-block">
                                            <div class="form__entry entry_mcq">
                                                <div class="form__label-row ">
                                                    <div class="entry__choice">
                                                        <label>
                                                            <input type="checkbox" class="input_replaced" value="1" id="OPT_IN"
                                                                name="OPT_IN" />
                                                            <span class="checkbox checkbox_tick_positive"></span>
                                                            <span>
                                                                <p></p>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <label class="entry__error entry__error--primary">
                                                </label>
                                                <label class="entry__specification">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="sib-form-block">
                                            <button
                                                class="sib-form-block__button sib-form-block__button-with-loader btn-style-2 radius-12 w-100 justify-content-center"
                                                form="sib-form" type="submit">
                                                <svg class="icon clickable__icon progress-indicator__icon sib-hide-loader-icon"
                                                    viewBox="0 0 512 512">
                                                    <path
                                                        d="M460.116 373.846l-20.823-12.022c-5.541-3.199-7.54-10.159-4.663-15.874 30.137-59.886 28.343-131.652-5.386-189.946-33.641-58.394-94.896-95.833-161.827-99.676C261.028 55.961 256 50.751 256 44.352V20.309c0-6.904 5.808-12.337 12.703-11.982 83.556 4.306 160.163 50.864 202.11 123.677 42.063 72.696 44.079 162.316 6.031 236.832-3.14 6.148-10.75 8.461-16.728 5.01z" />
                                                </svg>
                                                <span class="text text-btn-uppercase">SUBSCRIBE</span>
                                            </button>
                                        </div>
                                    </div>
                                    <input type="text" name="email_address_check" value="" class="input--hidden">
                                    <input type="hidden" name="locale" value="en">
                                </form>
                            </div>
                        </div>
                    </div>
                    <ul class="tf-social-icon style-default justify-content-center">
                        <li><a href="#" class="social-facebook"><i class="icon icon-fb"></i></a></li>
                        <li><a href="#" class="social-twiter"><i class="icon icon-x"></i></a></li>
                        <li><a href="#" class="social-instagram"><i class="icon icon-instagram"></i></a></li>
                        <li><a href="#" class="social-pinterest"><i class="icon icon-pinterest"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /auto popup  -->


    <!-- modalDemo -->
    <div class="modal fade modalDemo" id="modalDemo">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="mega-menu">
                    <div class="row-demo">
                        <div class="demo-item">
                            <a href="index.html">
                                <div class="demo-image position-relative">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-fashion-womenswear.jpg" src="/tmp/images/demo/home-fashion-womenswear.jpg" alt="home-fashion-womenswear">
                                    <div class="demo-label">
                                        <span class="demo-new">New</span>
                                        <span>Trend</span>
                                    </div>
                                </div>
                                <span class="demo-name">Fashion Womenswear</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-fashion-eleganceNest.html">
                                <div class="demo-image position-relative">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-fashion-eleganceNest.jpg" src="/tmp/images/demo/home-fashion-eleganceNest.jpg" alt="home-fashion-eleganceNest">
                                    <div class="demo-label">
                                        <span class="demo-new">New</span>
                                        <span class="demo-hot">Hot</span>
                                    </div>
                                </div>
                                <span class="demo-name">Fashion EleganceNest</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-fashion-main.html">
                                <div class="demo-image position-relative">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-fashion-main.jpg" src="/tmp/images/demo/home-fashion-main.jpg" alt="home-fashion-main">
                                    <div class="demo-label">
                                        <span class="demo-hot">Hot</span>
                                    </div>
                                </div>
                                <span class="demo-name">Fashion Main</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-fashion-trendset.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-fashion-trendset.jpg" src="/tmp/images/demo/home-fashion-trendset.jpg" alt="home-fashion-trendset">
                                </div>
                                <span class="demo-name">Fashion TrendsetHome</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-fashion-vogueLing.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-fashion-vogueLiving.jpg" src="/tmp/images/demo/home-fashion-vogueLiving.jpg" alt="home-fashion-vogueLiving">
                                </div>
                                <span class="demo-name">Fashion VogueLiving</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-fashion-elegantAbode.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-fashion-elegantAbode.jpg" src="/tmp/images/demo/home-fashion-elegantAbode.jpg" alt="home-fashion-elegantAbode">
                                </div>
                                <span class="demo-name">Fashion ElegantAbode</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-fashion-glamDwell.html">
                                <div class="demo-image position-relative">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-fashion-glamDwell.jpg" src="/tmp/images/demo/home-fashion-glamDwell.jpg" alt="home-fashion-glamDwell">
                                    <div class="demo-label">
                                        <span class="demo-new">New</span>
                                    </div>
                                </div>
                                <span class="demo-name">Fashion GlamDwell</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-fashion-classyCove.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-fashion-classycove.jpg" src="/tmp/images/demo/home-fashion-classycove.jpg" alt="home-fashion-classyCove">
                                </div>
                                <span class="demo-name">Fashion ClassyCove</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-fashion-chicHaven.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-fashion-chicHaven.jpg" src="/tmp/images/demo/home-fashion-chicHaven.jpg" alt="home-fashion-chicHaven1">
                                </div>
                                <span class="demo-name">Fashion ChicHaven 1</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-fashion-chicHaven-02.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-fashion-chicHaven2.jpg" src="/tmp/images/demo/home-fashion-chicHaven2.jpg" alt="home-fashion-chicHaven2">
                                </div>
                                <span class="demo-name">Fashion ChicHaven 2</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-fashion-tiktok.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-fashion-tiktok.jpg" src="/tmp/images/demo/home-fashion-tiktok.jpg" alt="home-fashion-tiktok">
                                </div>
                                <span class="demo-name">Fashion TikTok</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-fashion-luxeLiving.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-fashion-luxeLiving.jpg" src="/tmp/images/demo/home-fashion-luxeLiving.jpg" alt="home-fashion-luxeLiving">
                                </div>
                                <span class="demo-name">Fashion LuxeLiving</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-fashion-modernRetreat.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-fashion-modernRetreat.jpg" src="/tmp/images/demo/home-fashion-modernRetreat.jpg" alt="home-fashion-modernRetreat">
                                </div>
                                <span class="demo-name">Fashion ModernRetreat</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-beauty.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-beauty.jpg" src="/tmp/images/demo/home-beauty.jpg" alt="home-beauty">
                                </div>
                                <span class="demo-name">Beauty</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-skincare.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-skinCare.jpg" src="/tmp/images/demo/home-skinCare.jpg" alt="home-skincare">
                                </div>
                                <span class="demo-name">Skin Care</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-cosmetic.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-cosmetic.jpg" src="/tmp/images/demo/home-cosmetic.jpg" alt="home-cosmetic">
                                </div>
                                <span class="demo-name">Cosmetic</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-decor.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-decor.jpg" src="/tmp/images/demo/home-decor.jpg" alt="home-decor">
                                </div>
                                <span class="demo-name">Decor</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-furniture.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-furniture.jpg" src="/tmp/images/demo/home-furniture.jpg" alt="home-furniture">
                                </div>
                                <span class="demo-name">Furniture</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-jewelry-01.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-jewelry.jpg" src="/tmp/images/demo/home-jewelry.jpg" alt="home-jewelry-elegantGems">
                                </div>
                                <span class="demo-name">Jewelry ElegantGems</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-jewelry-02.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-jewelry2.jpg" src="/tmp/images/demo/home-jewelry2.jpg" alt="home-jewelry-glitterGlam">
                                </div>
                                <span class="demo-name">Jewelry GlitterGlam</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-activewear.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-activewear.jpg" src="/tmp/images/demo/home-activewear.jpg" alt="home-activewear">
                                </div>
                                <span class="demo-name">Activewear</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-organic.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-organic.jpg" src="/tmp/images/demo/home-organic.jpg" alt="home-organic">
                                </div>
                                <span class="demo-name">Organic</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-sock.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-sock.jpg" src="/tmp/images/demo/home-sock.jpg" alt="home-sock">
                                </div>
                                <span class="demo-name">Socks</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-camping.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-camping.jpg" src="/tmp/images/demo/home-camping.jpg" alt="home-camping">
                                </div>
                                <span class="demo-name">Camping</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-electronic.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-electronic.jpg" src="/tmp/images/demo/home-electronic.jpg" alt="home-electronic">
                                </div>
                                <span class="demo-name">Electronic Market</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-pet-store.html">
                                <div class="demo-image">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-pet-store.jpg" src="/tmp/images/demo/home-pet-store.jpg" alt="home-pet-store">
                                </div>
                                <span class="demo-name">Pet Store</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-pickleball.html">
                                <div class="demo-image position-relative">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-pickleball.jpg" src="/tmp/images/demo/home-pickleball.jpg" alt="home-pickleball">
                                    <div class="demo-label">
                                        <span class="demo-new">New</span>
                                    </div>
                                </div>
                                <span class="demo-name">PickleBall</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-sock-2.html">
                                <div class="demo-image position-relative">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-sock2.jpg" src="/tmp/images/demo/home-sock2.jpg" alt="home-sock2">
                                    <div class="demo-label">
                                        <span class="demo-new">New</span>
                                    </div>
                                </div>
                                <span class="demo-name">Socks 2</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-bookstore.html">
                                <div class="demo-image position-relative">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-bookstore.jpg" src="/tmp/images/demo/home-bookstore.jpg" alt="home-bookstore">
                                    <div class="demo-label">
                                        <span class="demo-new">New</span>
                                    </div>
                                </div>
                                <span class="demo-name">Bookstore</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-baby.html">
                                <div class="demo-image position-relative">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-baby.jpg" src="/tmp/images/demo/home-baby.jpg" alt="home-baby">
                                    <div class="demo-label">
                                        <span class="demo-new">New</span>
                                    </div>
                                </div>
                                <span class="demo-name">Baby</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-electronics-store.html">
                                <div class="demo-image position-relative">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-electronic-store.jpg" src="/tmp/images/demo/home-electronic-store.jpg" alt="home-electronic-store">
                                    <div class="demo-label">
                                        <span class="demo-new">New</span>
                                    </div>
                                </div>
                                <span class="demo-name">Electronics Store</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-sneaker.html">
                                <div class="demo-image position-relative">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-sneaker.jpg" src="/tmp/images/demo/home-sneaker.jpg" alt="home-sneaker">
                                    <div class="demo-label">
                                        <span class="demo-new">New</span>
                                    </div>
                                </div>
                                <span class="demo-name">Sneaker</span>
                            </a>
                        </div>
                        <div class="demo-item">
                            <a href="home-gaming.html">
                                <div class="demo-image position-relative">
                                    <img class="lazyload" data-src="/tmp/images/demo/home-gaming-accessory.jpg" src="/tmp/images/demo/home-gaming-accessory.jpg" alt="home-gaming-accessory">
                                    <div class="demo-label">
                                        <span class="demo-new">New</span>
                                    </div>
                                </div>
                                <span class="demo-name">Gaming Accessory</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <!-- /modalDemo -->    <!-- mobile menu -->
    <div class="offcanvas offcanvas-start canvas-mb" id="mobileMenu">
        <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
        <div class="mb-canvas-content">
            <div class="mb-body">
                <div class="mb-content-top">
                    <form class="form-search">
                        <fieldset class="text">
                            <input type="text" placeholder="Search contestants" class="" name="text" tabindex="0" value="" aria-required="true" required>
                        </fieldset>
                        <button class="" type="submit">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#181818" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M20.9984 20.9999L16.6484 16.6499" stroke="#181818" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </form>
                    <ul class="nav-ul-mb" id="wrapper-menu-navigation">
                        <li class="nav-mb-item">
                            <Link href="/" class="mb-menu-link" data-bs-dismiss="offcanvas">
                                <span>Home</span>
                            </Link>
                        </li>
                        <li class="nav-mb-item">
                            <Link href="/contestants" class="mb-menu-link" data-bs-dismiss="offcanvas">
                                <span>Contestants</span>
                            </Link>
                        </li>
                        <li class="nav-mb-item">
                            <Link href="/leaderboard" class="mb-menu-link" data-bs-dismiss="offcanvas">
                                <span>Leaderboard</span>
                            </Link>
                        </li>
                        <li class="nav-mb-item">
                            <Link href="/about" class="mb-menu-link" data-bs-dismiss="offcanvas">
                                <span>About</span>
                            </Link>
                        </li>
                        <li class="nav-mb-item">
                            <Link href="/cart" class="mb-menu-link" data-bs-dismiss="offcanvas">
                                <span>Vote Cart</span>
                            </Link>
                        </li>
                        <template v-if="!isAuthenticated">
                            <li class="nav-mb-item">
                                <Link href="/login" class="mb-menu-link" data-bs-dismiss="offcanvas">
                                    <span>Login</span>
                                </Link>
                            </li>
                            <li class="nav-mb-item">
                                <Link href="/register" class="mb-menu-link" data-bs-dismiss="offcanvas">
                                    <span>Register</span>
                                </Link>
                            </li>
                        </template>
                        <template v-else>
                            <li class="nav-mb-item">
                                <Link href="/dashboard" class="mb-menu-link" data-bs-dismiss="offcanvas">
                                    <span>Dashboard</span>
                                </Link>
                            </li>
                            <li class="nav-mb-item">
                                <Link href="/settings/profile" class="mb-menu-link" data-bs-dismiss="offcanvas">
                                    <span>Profile</span>
                                </Link>
                            </li>
                            <li class="nav-mb-item">
                                <Link href="/logout" method="post" as="button" type="button" class="mb-menu-link" data-bs-dismiss="offcanvas">
                                    <span>Logout</span>
                                </Link>
                            </li>
                        </template>
                    </ul>
                    <div class="mb-other-content">
                        <div class="group-icon">
                            <template v-if="!isAuthenticated">
                                <Link href="/login" class="site-nav-icon" data-bs-dismiss="offcanvas">
                                    <LogIn class="icon" :size="18" :stroke-width="2" />
                                    Login
                                </Link>

                                <Link href="/register" class="site-nav-icon" data-bs-dismiss="offcanvas">
                                    <UserPlus class="icon" :size="18" :stroke-width="2" />
                                    Register
                                </Link>
                            </template>
                            <template v-else>
                                <Link href="/dashboard" class="site-nav-icon" data-bs-dismiss="offcanvas">
                                    <LayoutDashboard class="icon" :size="18" :stroke-width="2" />
                                    Dashboard
                                </Link>

                                <Link href="/cart" class="site-nav-icon" data-bs-dismiss="offcanvas">
                                    <ShoppingCart class="icon" :size="18" :stroke-width="2" />
                                    Vote Cart
                                </Link>
                            </template>
                        </div>
                        <div class="mb-notice">
                            <a href="#" class="text-need" data-bs-dismiss="offcanvas" @click.prevent="openAskQuestion">
                                Need Help With Voting?
                            </a>
                        </div>
                        <div class="mb-contact">
                            <p class="text-caption-1">Questions about contestants, vote confirmation, or your vote cart? Our support team is here to help.</p>
                            <Link href="/about" class="tf-btn-default text-btn-uppercase" data-bs-dismiss="offcanvas">
                                HOW VOTING WORKS<i class="icon-arrowUpRight"></i>
                            </Link>
                        </div>
                        <ul class="mb-info">
                            <li>
                                <Mail class="icon" :size="18" :stroke-width="2" />
                                <p>support@nervego.com</p>
                            </li>
                            <li>
                                <Phone class="icon" :size="18" :stroke-width="2" />
                                <p>+234 800 000 0000</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /mobile menu -->

    <!-- Categories -->
    <div class="offcanvas offcanvas-start canvas-filter canvas-categories" id="shopCategories">
        <div class="canvas-wrapper">
            <div class="canvas-header">
                <span class="icon-left icon-filter"></span>
                <h5>Categories</h5>
                <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
            </div>
            <div class="canvas-body">
                <div class="wd-facet-categories">
                    <div role="dialog" class="facet-title collapsed" data-bs-target="#forWomen" data-bs-toggle="collapse" aria-expanded="true" aria-controls="forWomen">
                        <img class="avt" src="/tmp/images/avatar/women.jpg" alt="avt">
                        <span class="title">For Women</span>
                        <span class="icon icon-arrow-down"></span>
                    </div>
                    <div id="forWomen" class="collapse">
                        <ul class="facet-body">
                            <li>
                                <a href="#" class="item link"><img class="avt" src="/tmp/images/avatar/new-in.jpg" alt="avt"><span class="title-sub text-caption-1 text-secondary">New in</span></a>
                            </li>
                            <li>
                                <a href="#" class="item link"><img class="avt" src="/tmp/images/avatar/promotion.jpg" alt="avt"><span class="title-sub text-caption-1 text-secondary">Promotion</span></a>
                            </li>
                            <li>
                                <a href="#" class="item link"><img class="avt" src="/tmp/images/avatar/clothing.jpg" alt="avt"><span class="title-sub text-caption-1 text-secondary">Clothing</span></a>
                            </li>
                            <li>
                                <a href="#" class="item link"><img class="avt" src="/tmp/images/avatar/shoes.jpg" alt="avt"><span class="title-sub text-caption-1 text-secondary">Shoes</span></a>
                            </li>
                            <li>
                                <a href="#" class="item link"><img class="avt" src="/tmp/images/avatar/bags.jpg" alt="avt"><span class="title-sub text-caption-1 text-secondary">Bags</span></a>
                            </li>
                            <li>
                                <a href="#" class="item link"><img class="avt" src="/tmp/images/avatar/accessories.jpg" alt="avt"><span class="title-sub text-caption-1 text-secondary">Accessories</span></a>
                            </li>
                            <li>
                                <a href="#" class="item link"><img class="avt" src="/tmp/images/avatar/jewelry.jpg" alt="avt"><span class="title-sub text-caption-1 text-secondary">Jewelry</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="wd-facet-categories">
                    <div role="dialog" class="facet-title collapsed" data-bs-target="#forMen" data-bs-toggle="collapse" aria-expanded="true" aria-controls="forMen">
                        <img class="avt" src="/tmp/images/avatar/men.jpg" alt="avt">
                        <span class="title">For Men</span>
                        <span class="icon icon-arrow-down"></span>
                    </div>
                    <div id="forMen" class="collapse">
                        <ul class="facet-body">
                            <li>
                                <a href="#" class="item link"><img class="avt" src="/tmp/images/avatar/men.jpg" alt="avt"><span class="title-sub text-caption-1 text-secondary">Men</span></a>
                            </li>
                            <li>
                                <a href="#" class="item link"><img class="avt" src="/tmp/images/avatar/men.jpg" alt="avt"><span class="title-sub text-caption-1 text-secondary">Men</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="wd-facet-categories">
                    <div role="dialog" class="facet-title collapsed" data-bs-target="#forKid" data-bs-toggle="collapse" aria-expanded="true" aria-controls="forKid">
                        <img class="avt" src="/tmp/images/avatar/kid.jpg" alt="avt">
                        <span class="title">For Kid</span>
                        <span class="icon icon-arrow-down"></span>
                    </div>
                    <div id="forKid" class="collapse">
                        <ul class="facet-body">
                            <li>
                                <a href="#" class="item link"><img class="avt" src="/tmp/images/avatar/kid.jpg" alt="avt"><span class="title-sub text-caption-1 text-secondary">Kid</span></a>
                            </li>
                            <li>
                                <a href="#" class="item link"><img class="avt" src="/tmp/images/avatar/kid.jpg" alt="avt"><span class="title-sub text-caption-1 text-secondary">Kid</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="wd-facet-categories">
                    <div role="dialog" class="facet-title collapsed" data-bs-target="#accessories" data-bs-toggle="collapse" aria-expanded="true" aria-controls="accessories">
                        <img class="avt" src="/tmp/images/avatar/accessories.jpg" alt="avt">
                        <span class="title">Accessories</span>
                        <span class="icon icon-arrow-down"></span>
                    </div>
                    <div id="accessories" class="collapse">
                        <ul class="facet-body">
                            <li>
                                <a href="#" class="item link"><img class="avt" src="/tmp/images/avatar/accessories.jpg" alt="avt"><span class="title-sub text-caption-1 text-secondary">Accessories</span></a>
                            </li>
                            <li>
                                <a href="#" class="item link"><img class="avt" src="/tmp/images/avatar/accessories.jpg" alt="avt"><span class="title-sub text-caption-1 text-secondary">Accessories</span></a>
                            </li>
                        </ul>
                    </div>
                </div>     
            </div>
        </div>
    </div> 
    <!-- /Categories -->

    </template>
    </Layout>
</template>

