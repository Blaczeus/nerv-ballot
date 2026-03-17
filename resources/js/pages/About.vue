<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Breadcrumb from '@/components/ui/Breadcrumb.vue';
import Layout from '@/layouts/Layout.vue';
</script>

<template>
    <Head title="About" />

    <Layout>
        <Breadcrumb
            :items="[
                { label: 'Home', link: '/' },
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
                            <h3 class="title wow fadeInUp">About the Platform</h3>
                            <div class="widget-content-tab wow fadeInUp">
                                <div class="widget-content-inner active">
                                    <p>
                                        This platform connects communities with their favorite contestants by making voting simple,
                                        transparent, and engaging. Visitors can explore contestants, cast votes for the nominees
                                        they support, and follow rankings as results update. Our goal is to celebrate talent,
                                        encourage participation, and keep every vote accountable from start to finish.
                                    </p>
                                </div>
                            </div>
                            <a href="/contestants" class="tf-btn btn-fill wow fadeInUp"><span class="text text-button">Explore Contestants</span></a>
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
                                    <h6>Fair Voting System</h6>
                                    <p class="text-secondary">Every vote is counted with clear, consistent rules.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-2">
                                <div class="icon-box"><span class="icon icon-shipping"></span></div>
                                <div class="content">
                                    <h6>Real-Time Results</h6>
                                    <p class="text-secondary">Rankings update as votes are submitted.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-2">
                                <div class="icon-box"><span class="icon icon-headset"></span></div>
                                <div class="content">
                                    <h6>Secure Voting Process</h6>
                                    <p class="text-secondary">Protection measures keep voting safe and reliable.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-2">
                                <div class="icon-box"><span class="icon icon-sealCheck"></span></div>
                                <div class="content">
                                    <h6>Community Engagement</h6>
                                    <p class="text-secondary">Support contestants and celebrate their journeys.</p>
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
                                    Browse contestant profiles and discover standout nominees.
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
                                <h6>2. Vote for Your Favorite</h6>
                                <p class="text-secondary">
                                    Submit your vote securely for the contestant you support.
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
                                <h6>3. Track Rankings</h6>
                                <p class="text-secondary">
                                    Follow updates and rankings as voting progresses.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /How it works -->

        <!-- Testimonial -->
        <section class="flat-spacing">
            <div class="container">
                <div class="heading-section text-center wow fadeInUp">
                    <h3 class="heading">Community Feedback</h3>
                </div>
                <div dir="ltr" class="swiper tf-sw-testimonial wow fadeInUp" data-wow-delay="0.1s" data-preview="3" data-tablet="2" data-mobile="1" data-space-lg="30" data-space-md="30" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testimonial-item style-4">
                                <div class="content-top">
                                    <div class="box-icon">
                                        <i class="icon icon-quote"></i>
                                    </div>
                                    <div class="text-title">Clear and Trustworthy</div>
                                    <p class="text-secondary">
                                        "The voting flow is easy to follow, and the rankings update quickly. It feels
                                        transparent and fair."
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
                                    <div class="text-title">Smooth Experience</div>
                                    <p class="text-secondary">
                                        "Exploring contestants and casting votes is simple. I like how everything is laid out."
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
                                    <div class="text-title">Engaging Community</div>
                                    <p class="text-secondary">
                                        "It’s exciting to follow the rankings and support contestants in real time."
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
                                    <div class="text-title">Confident Voting</div>
                                    <p class="text-secondary">
                                        "I appreciate how clear the process is. It feels secure and trustworthy."
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
