<script setup lang="ts">
defineOptions({ inheritAttrs: false });

defineProps<{
    contestantSlug: string;
    gallerySlides: Array<{ color: string; label: string; image: string }>;
}>();
</script>

<template>
    <!-- Product default -->
    <div class="col-md-6">
        <div class="tf-product-media-wrap sticky-top">
            <div class="thumbs-slider">
                <div dir="ltr" class="swiper tf-product-media-thumbs other-image-zoom" data-direction="vertical">
                    <div class="swiper-wrapper stagger-wrap">
                        <div
                            v-for="(slide, imageIndex) in gallerySlides"
                            :key="`${contestantSlug}-thumb-${imageIndex}`"
                            class="swiper-slide stagger-item"
                            :data-color="slide.color"
                        >
                            <div class="item">
                                <img class="lazyload" :data-src="slide.image" :src="slide.image" alt="contestant-thumbnail" />
                            </div>
                        </div>
                    </div>
                </div>
                <div dir="ltr" class="swiper tf-product-media-main" id="gallery-swiper-started">
                    <div class="swiper-wrapper">
                        <div
                            v-for="(slide, imageIndex) in gallerySlides"
                            :key="`${contestantSlug}-main-${imageIndex}`"
                            class="swiper-slide"
                            :data-color="slide.color"
                        >
                            <a
                                :href="slide.image"
                                target="_blank"
                                class="item"
                                data-pswp-width="600px"
                                data-pswp-height="800px"
                            >
                                <img
                                    class="tf-image-zoom lazyload"
                                    :data-zoom="slide.image"
                                    :data-src="slide.image"
                                    :src="slide.image"
                                    alt="contestant-image"
                                />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Product default -->
</template>
