<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Breadcrumb from '@/components/ui/Breadcrumb.vue';
import Layout from '@/layouts/Layout.vue';
</script>

<template>
    <Head title="About" />

    <Layout>
        <!-- tf-add-cart-success -->
        <div class="tf-add-cart-success">
            <div class="tf-add-cart-heading">
                <h5>Shopping Cart</h5>
                <i class="icon icon-close tf-add-cart-close"></i>
            </div>
            <div class="tf-add-cart-product">
                <div class="image">
                    <img class="lazyload" data-src="/tmp/images/products/womens/women-3.jpg" alt="" src="/tmp/images/products/womens/women-3.jpg" />
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
                { label: 'About' },
            ]"
            design="image"
            heading="About"
            background-image="/tmp/images/section/page-title.jpg"
            container-class="container-full"
            :use-row="true"
        />

        <!-- about-us -->
        <section class="flat-spacing about-us-main pb_0">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="about-us-features wow fadeInLeft">
                            <img class="lazyload" data-src="/tmp/images/banner/about-us.jpg" src="/tmp/images/banner/about-us.jpg" alt="image-team" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="about-us-content">
                            <h3 class="title wow fadeInUp">Modave - Offering rare and beautiful items worldwide</h3>
                            <div class="widget-tabs style-3">
                                <ul class="widget-menu-tab wow fadeInUp">
                                    <li class="item-title active">
                                        <span class="inner text-button">Introduction</span>
                                    </li>
                                    <li class="item-title">
                                        <span class="inner text-button">Our Vision</span>
                                    </li>
                                    <li class="item-title">
                                        <span class="inner text-button">What Sets Us Apart</span>
                                    </li>
                                    <li class="item-title">
                                        <span class="inner text-button">Our Commitment</span>
                                    </li>
                                </ul>
                                <div class="widget-content-tab wow fadeInUp">
                                    <div class="widget-content-inner active">
                                        <p>
                                            Welcome to Modave Store, your premier destination for fashion-forward clothing and
                                            accessories. We pride ourselves on offering a curated selection of rare and beautiful
                                            items sourced both locally and globally. Our mission is to bring you the latest trends
                                            and timeless styles, ensuring every piece reflects quality and elegance. Discover the
                                            perfect addition to your wardrobe at Modave Store.
                                        </p>
                                    </div>
                                    <div class="widget-content-inner">
                                        <p>
                                            Welcome to Modave Store, your premier destination for fashion-forward clothing and
                                            accessories. We pride ourselves on offering a curated selection of rare and beautiful
                                            items sourced both locally and globally. Our mission is to bring you the latest trends
                                            and timeless styles, ensuring every piece reflects quality and elegance. Discover the
                                            perfect addition to your wardrobe at Modave Store.
                                        </p>
                                    </div>
                                    <div class="widget-content-inner">
                                        <p>
                                            Welcome to Modave Store, your premier destination for fashion-forward clothing and
                                            accessories. We pride ourselves on offering a curated selection of rare and beautiful
                                            items sourced both locally and globally. Our mission is to bring you the latest trends
                                            and timeless styles, ensuring every piece reflects quality and elegance. Discover the
                                            perfect addition to your wardrobe at Modave Store.
                                        </p>
                                    </div>
                                    <div class="widget-content-inner">
                                        <p>
                                            Welcome to Modave Store, your premier destination for fashion-forward clothing and
                                            accessories. We pride ourselves on offering a curated selection of rare and beautiful
                                            items sourced both locally and globally. Our mission is to bring you the latest trends
                                            and timeless styles, ensuring every piece reflects quality and elegance. Discover the
                                            perfect addition to your wardrobe at Modave Store.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="tf-btn btn-fill wow fadeInUp"><span class="text text-button">Read More</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /about-us -->

        <!-- Iconbox -->
        <section class="flat-spacing line-bottom-container">
            <div class="container">
                <div dir="ltr" class="swiper tf-sw-iconbox" data-preview="4" data-tablet="3" data-mobile-sm="2" data-mobile="1" data-space-lg="30" data-space-md="30" data-space="15" data-pagination="1" data-pagination-sm="2" data-pagination-md="3" data-pagination-lg="4">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-2">
                                <div class="icon-box"><span class="icon icon-return"></span></div>
                                <div class="content">
                                    <h6>14-Day Returns</h6>
                                    <p class="text-secondary">Risk-free shopping with easy returns.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-2">
                                <div class="icon-box"><span class="icon icon-shipping"></span></div>
                                <div class="content">
                                    <h6>Free Shipping</h6>
                                    <p class="text-secondary">No extra costs, just the price you see.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-2">
                                <div class="icon-box"><span class="icon icon-headset"></span></div>
                                <div class="content">
                                    <h6>24/7 Support</h6>
                                    <p class="text-secondary">24/7 support, always here just for you</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-2">
                                <div class="icon-box"><span class="icon icon-sealCheck"></span></div>
                                <div class="content">
                                    <h6>Member Discounts</h6>
                                    <p class="text-secondary">Special prices for our loyal customers.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sw-pagination-iconbox sw-dots type-circle justify-content-center"></div>
                </div>
            </div>
        </section>
        <!-- /Iconbox -->

        <!-- How it works -->
        <section class="flat-spacing">
            <div class="container">
                <div class="mb_40 text-center">
                    <h3>How It Works</h3>
                    <p class="text-secondary">
                        A simple process to discover nominees, cast votes, and track results.
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="tf-icon-box">
                            <div class="icon-box">
                                <span class="icon icon-categories"></span>
                            </div>
                            <div class="content text-center">
                                <h6>1. Explore Contestants</h6>
                                <p class="text-secondary">
                                    Browse contestant profiles and shortlist your preferred nominees.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="tf-icon-box">
                            <div class="icon-box">
                                <span class="icon icon-checkCircle"></span>
                            </div>
                            <div class="content text-center">
                                <h6>2. Cast Your Vote</h6>
                                <p class="text-secondary">
                                    Submit your vote securely for your selected contestant.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="tf-icon-box">
                            <div class="icon-box">
                                <span class="icon icon-eye"></span>
                            </div>
                            <div class="content text-center">
                                <h6>3. Follow Results</h6>
                                <p class="text-secondary">
                                    Track updates and final rankings as voting progresses.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /How it works -->

        <!-- Partner -->
        <section class="flat-spacing-5 bg-surface">
            <div dir="ltr" class="swiper tf-sw-partner sw-auto" data-preview="auto" data-tablet="auto" data-mobile-sm="auto" data-mobile="auto" data-space-lg="74" data-space-md="50" data-space="50" data-loop="true" data-auto-play="true" data-delay="0">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <a href="#" class="brand-item">
                            <img src="/tmp/images/brand/vanfaba.png" alt="brand" />
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="#" class="brand-item">
                            <img src="/tmp/images/brand/anvouge.png" alt="brand" />
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="#" class="brand-item">
                            <img src="/tmp/images/brand/carolin.png" alt="brand" />
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="#" class="brand-item">
                            <img src="/tmp/images/brand/shangxi.png" alt="brand" />
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="#" class="brand-item">
                            <img src="/tmp/images/brand/ecomife.png" alt="brand" />
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="#" class="brand-item">
                            <img src="/tmp/images/brand/cheryl.png" alt="brand" />
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="#" class="brand-item">
                            <img src="/tmp/images/brand/sopify.png" alt="brand" />
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="#" class="brand-item">
                            <img src="/tmp/images/brand/pennyw.png" alt="brand" />
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="#" class="brand-item">
                            <img src="/tmp/images/brand/panadoxn.png" alt="brand" />
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Partner -->

        <!-- Testimonial -->
        <section class="flat-spacing">
            <div class="container">
                <div class="heading-section text-center wow fadeInUp">
                    <h3 class="heading">Customer Review</h3>
                </div>
                <div dir="ltr" class="swiper tf-sw-testimonial wow fadeInUp" data-wow-delay="0.1s" data-preview="3" data-tablet="2" data-mobile="1" data-space-lg="30" data-space-md="30" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testimonial-item style-4">
                                <div class="content-top">
                                    <div class="box-icon">
                                        <i class="icon icon-quote"></i>
                                    </div>
                                    <div class="text-title">Variety of Styles!</div>
                                    <p class="text-secondary">
                                        "Fantastic shop! Great selection, fair prices, and friendly staff. Highly
                                        recommended. The quality of the products is exceptional, and the prices are very
                                        reasonable!"
                                    </p>
                                    <div class="box-rate-author">
                                        <div class="box-author">
                                            <div class="text-title author">Sybil Sharp</div>
                                        </div>
                                        <div class="list-star-default color-primary">
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-item style-4">
                                <div class="content-top">
                                    <div class="box-icon">
                                        <i class="icon icon-quote"></i>
                                    </div>
                                    <div class="text-title">Quality of Clothing!</div>
                                    <p class="text-secondary">
                                        "I absolutely love this shop! The products are high-quality and the customer service
                                        is excellent. I always leave with exactly what I need and a smile on my face."
                                    </p>
                                    <div class="box-rate-author">
                                        <div class="box-author">
                                            <div class="text-title author">Mark G.</div>
                                        </div>
                                        <div class="list-star-default color-primary">
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-item style-4">
                                <div class="content-top">
                                    <div class="box-icon">
                                        <i class="icon icon-quote"></i>
                                    </div>
                                    <div class="text-title">Customer Service!</div>
                                    <p class="text-secondary">
                                        "I love this shop! The products are always top-quality, and the staff is incredibly
                                        friendly and helpful. They go out of their way to make sure that I'm satisfied with my
                                        purchase."
                                    </p>
                                    <div class="box-rate-author">
                                        <div class="box-author">
                                            <div class="text-title author">Emily S.</div>
                                        </div>
                                        <div class="list-star-default color-primary">
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-item style-4">
                                <div class="content-top">
                                    <div class="box-icon">
                                        <i class="icon icon-quote"></i>
                                    </div>
                                    <div class="text-title">Variety of Styles!</div>
                                    <p class="text-secondary">
                                        "Fantastic shop! Great selection, fair prices, and friendly staff. Highly
                                        recommended. The quality of the products is exceptional, and the prices are very
                                        reasonable!"
                                    </p>
                                    <div class="box-rate-author">
                                        <div class="box-author">
                                            <div class="text-title author">Sybil Sharp</div>
                                        </div>
                                        <div class="list-star-default color-primary">
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
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
    </Layout>
</template>
