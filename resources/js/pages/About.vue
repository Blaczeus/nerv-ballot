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
                        <div class="about-us-content flex flex-column align-items-start">
                            <h3 class="title wow fadeInUp">About the Platform</h3>
                            <div class="widget-content-tab wow fadeInUp">
                                <div class="widget-content-inner active">
                                    <p>
                                        A platform built for fair and engaging voting experiences. Discover contestants,
                                        support your favorites, and watch rankings update in real time. Whether it is
                                        competitions, showcases, or community-driven contests, this platform makes
                                        participation simple, transparent, and exciting.
                                    </p>
                                </div>
                            </div>
                            <a href="/contestants" class="tf-btn btn-fill wow fadeInUp mt-4"><span class="text text-button">Explore Contestants</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /about-us -->

        <!-- How it works -->
        <section class="flat-spacing">
            <div class="container">
                <div class="mb_40 text-center">
                    <h3>How It Works</h3>
                    <p class="text-secondary">
                        A simple flow for discovering contestants, voting, and following rankings.
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
                                    Browse and discover participants.
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
                                    Support the ones you like.
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
                                    Watch rankings update in real time.
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
                <div class="heading-section text-center">
                    <h3 class="heading wow fadeInUp">Community Feedback</h3>
                    <p class="subheading wow fadeInUp">Organizers and communities share how their contests grew with this platform.</p>
                </div>
                <div dir="ltr" class="swiper tf-sw-testimonial" data-preview="2" data-tablet="1.3" data-mobile="1" data-space-lg="30" data-space-md="30" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testimonial-item hover-img">
                                <div class="img-style">
                                    <img data-src="/tmp/images/testimonial/tes-1.jpg" src="/tmp/images/testimonial/tes-1.jpg" alt="img-testimonial">
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
                                        <p class="text-secondary">"This platform gave our team a reliable way to manage nominations, publish contestants, and keep the voting experience smooth from start to finish."</p>
                                        <div class="box-author">
                                            <div class="text-title author">Sybil Sharp</div>
                                            <svg class="icon" width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_15758_24563)">
                                                    <path d="M6.875 11.6255L8.75 13.5005L13.125 9.12549" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M10 18.5005C14.1421 18.5005 17.5 15.1426 17.5 11.0005C17.5 6.85835 14.1421 3.50049 10 3.50049C5.85786 3.50049 2.5 6.85835 2.5 11.0005C2.5 15.1426 5.85786 18.5005 10 18.5005Z" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_15758_24563">
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
                                            <p class="text-title text-line-clamp-1">University Event Coordinator</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-item hover-img">
                                <div class="img-style">
                                    <img data-src="/tmp/images/testimonial/tes-2.jpg" src="/tmp/images/testimonial/tes-2.jpg" alt="img-testimonial">
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
                                        <p class="text-secondary">"We needed a voting platform that looked professional, handled traffic well, and made it easy for supporters to participate without confusion."</p>
                                        <div class="box-author">
                                            <div class="text-title author">Mark G.</div>
                                            <svg class="icon" width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_15758_24564)">
                                                    <path d="M6.875 11.6255L8.75 13.5005L13.125 9.12549" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M10 18.5005C14.1421 18.5005 17.5 15.1426 17.5 11.0005C17.5 6.85835 14.1421 3.50049 10 3.50049C5.85786 3.50049 2.5 6.85835 2.5 11.0005C2.5 15.1426 5.85786 18.5005 10 18.5005Z" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_15758_24564">
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
                                            <p class="text-title text-line-clamp-1">Campaign Manager</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-item hover-img">
                                <div class="img-style">
                                    <img data-src="/tmp/images/testimonial/tes-1.jpg" src="/tmp/images/testimonial/tes-1.jpg" alt="img-testimonial">
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
                                        <p class="text-secondary">"What stood out most was how simple it became to keep contestant information organised while still giving voters a clear and credible experience."</p>
                                        <div class="box-author">
                                            <div class="text-title author">Sybil Sharp</div>
                                            <svg class="icon" width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_15758_24565)">
                                                    <path d="M6.875 11.6255L8.75 13.5005L13.125 9.12549" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M10 18.5005C14.1421 18.5005 17.5 15.1426 17.5 11.0005C17.5 6.85835 14.1421 3.50049 10 3.50049C5.85786 3.50049 2.5 6.85835 2.5 11.0005C2.5 15.1426 5.85786 18.5005 10 18.5005Z" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_15758_24565">
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
                                            <p class="text-title text-line-clamp-1">Programme Lead</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-item hover-img">
                                <div class="img-style">
                                    <img data-src="/tmp/images/testimonial/tes-2.jpg" src="/tmp/images/testimonial/tes-2.jpg" alt="img-testimonial">
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
                                        <p class="text-secondary">"Launching a public voting campaign felt far less risky because the platform gave us structure, clarity, and a better experience for both organisers and supporters."</p>
                                        <div class="box-author">
                                            <div class="text-title author">Mark G.</div>
                                            <svg class="icon" width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_15758_24566)">
                                                    <path d="M6.875 11.6255L8.75 13.5005L13.125 9.12549" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M10 18.5005C14.1421 18.5005 17.5 15.1426 17.5 11.0005C17.5 6.85835 14.1421 3.50049 10 3.50049C5.85786 3.50049 2.5 6.85835 2.5 11.0005C2.5 15.1426 5.85786 18.5005 10 18.5005Z" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_15758_24566">
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
                                            <p class="text-title text-line-clamp-1">Community Campaign Director</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sw-pagination-testimonial sw-dots type-circle d-flex justify-content-center">
                    </div>
                </div>
            </div>
        </section>
        <!-- /Testimonial -->
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
                                    <p class="text-secondary">Launch competitions easily.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box">
                                <div class="icon-box"><span class="icon icon-sealCheck"></span></div>
                                <div class="content text-center">
                                    <h6>Scalable Platform</h6>
                                    <p class="text-secondary">Built for Large-Scale Voting.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sw-pagination-iconbox sw-dots type-circle justify-content-center"></div>
                </div>
            </div>
        </section>
        <!-- /Iconbox -->
    </Layout>
</template>
