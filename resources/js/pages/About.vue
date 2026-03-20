<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import TestimonialCard from '@/components/testimonials/TestimonialCard.vue';
import { getTestimonials, type Testimonial } from '@/data/testimonials';
import Breadcrumb from '@/components/ui/Breadcrumb.vue';
import Layout from '@/layouts/Layout.vue';

const testimonials = ref<Testimonial[]>([]);
const currentSlide = ref(0);
const isAnimating = ref(true);
const viewportWidth = ref(typeof window === 'undefined' ? 1280 : window.innerWidth);

let autoplayId: number | null = null;

const visibleSlides = computed(() => {
    if (viewportWidth.value < 768) return 1;
    if (viewportWidth.value < 992) return 2;
    return 3;
});

const slideGap = computed(() => (viewportWidth.value < 768 ? 15 : 30));

const shouldLoop = computed(() => testimonials.value.length > visibleSlides.value);

const renderedTestimonials = computed(() => {
    if (!shouldLoop.value) return testimonials.value;

    const buffer = testimonials.value.slice(0, visibleSlides.value);
    return [...testimonials.value, ...buffer];
});

const activeSlide = computed(() => {
    if (!testimonials.value.length) return 0;
    return currentSlide.value % testimonials.value.length;
});

const trackStyle = computed(() => ({
    transform: `translate3d(-${currentSlide.value * (100 / visibleSlides.value)}%, 0, 0)`,
    marginRight: `-${slideGap.value}px`,
}));

const slideStyle = computed(() => ({
    width: `${100 / visibleSlides.value}%`,
    paddingRight: `${slideGap.value}px`,
}));

const stopAutoplay = () => {
    if (autoplayId === null || typeof window === 'undefined') return;
    window.clearInterval(autoplayId);
    autoplayId = null;
};

const startAutoplay = () => {
    stopAutoplay();

    if (typeof window === 'undefined' || !shouldLoop.value) return;

    autoplayId = window.setInterval(() => {
        isAnimating.value = true;
        currentSlide.value += 1;
    }, 4000);
};

const resetCarousel = async () => {
    stopAutoplay();
    isAnimating.value = false;
    currentSlide.value = 0;
    await nextTick();

    requestAnimationFrame(() => {
        isAnimating.value = true;
        startAutoplay();
    });
};

const handleTransitionEnd = async () => {
    if (!shouldLoop.value || currentSlide.value < testimonials.value.length) return;

    isAnimating.value = false;
    currentSlide.value = 0;
    await nextTick();

    requestAnimationFrame(() => {
        isAnimating.value = true;
    });
};

const goToSlide = (index: number) => {
    if (index === currentSlide.value) return;

    isAnimating.value = true;
    currentSlide.value = index;
    startAutoplay();
};

const syncViewportWidth = () => {
    if (typeof window === 'undefined') return;
    viewportWidth.value = window.innerWidth;
};

watch(visibleSlides, () => {
    void resetCarousel();
});

onMounted(async () => {
    testimonials.value = await getTestimonials();
    await resetCarousel();

    if (typeof window !== 'undefined') {
        window.addEventListener('resize', syncViewportWidth);
    }
});

onBeforeUnmount(() => {
    stopAutoplay();

    if (typeof window !== 'undefined') {
        window.removeEventListener('resize', syncViewportWidth);
    }
});
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
                                    <p class="text-secondary">Every vote is counted transparently.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-2">
                                <div class="icon-box"><span class="icon icon-eye"></span></div>
                                <div class="content">
                                    <h6>Real-Time Rankings</h6>
                                    <p class="text-secondary">See results update instantly.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-2">
                                <div class="icon-box"><span class="icon icon-headset"></span></div>
                                <div class="content">
                                    <h6>Secure Participation</h6>
                                    <p class="text-secondary">Votes are handled safely and reliably.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-2">
                                <div class="icon-box"><span class="icon icon-sealCheck"></span></div>
                                <div class="content">
                                    <h6>Community Driven</h6>
                                    <p class="text-secondary">Engage and support your favorites.</p>
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
                <div class="heading-section text-center wow fadeInUp">
                    <h3 class="heading">Community Feedback</h3>
                </div>
                <div
                    dir="ltr"
                    class="swiper tf-sw-testimonial wow fadeInUp"
                    data-wow-delay="0.1s"
                    data-preview="3"
                    data-tablet="2"
                    data-mobile="1"
                    data-space-lg="30"
                    data-space-md="30"
                    data-space="15"
                    data-pagination="1"
                    data-pagination-md="1"
                    data-pagination-lg="1"
                    @mouseenter="stopAutoplay"
                    @mouseleave="startAutoplay"
                >
                    <div class="testimonial-carousel-viewport">
                        <div
                            class="swiper-wrapper testimonial-carousel-track"
                            :class="{ 'is-animating': isAnimating }"
                            :style="trackStyle"
                            @transitionend="handleTransitionEnd"
                        >
                            <div
                                v-for="(testimonial, index) in renderedTestimonials"
                                :key="`${testimonial.id}-${index}`"
                                class="swiper-slide testimonial-carousel-slide"
                                :style="slideStyle"
                            >
                                <TestimonialCard :testimonial="testimonial" />
                            </div>
                        </div>
                    </div>
                    <div class="sw-pagination-testimonial sw-dots type-circle d-flex justify-content-center">
                        <button
                            v-for="(testimonial, index) in testimonials"
                            :key="testimonial.id"
                            type="button"
                            class="swiper-pagination-bullet"
                            :class="{ 'swiper-pagination-bullet-active': index === activeSlide }"
                            :aria-label="`Go to testimonial ${index + 1}`"
                            @click="goToSlide(index)"
                        ></button>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Testimonial -->
    </Layout>
</template>

<style scoped>
.testimonial-carousel-viewport {
    overflow: hidden;
}

.testimonial-carousel-track {
    will-change: transform;
}

.testimonial-carousel-track.is-animating {
    transition: transform 0.6s ease;
}

.testimonial-carousel-slide {
    box-sizing: border-box;
    flex: 0 0 auto;
    height: auto;
}

.sw-pagination-testimonial .swiper-pagination-bullet {
    border: 0;
    padding: 0;
}
</style>
