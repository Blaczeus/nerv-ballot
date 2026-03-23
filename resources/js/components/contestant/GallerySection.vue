<script setup lang="ts">
defineOptions({ inheritAttrs: false });

defineProps<{
    contestantSlug: string;
    galleryImages: string[];
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
                            v-for="(image, imageIndex) in galleryImages"
                            :key="`${contestantSlug}-thumb-${imageIndex}`"
                            class="swiper-slide stagger-item"
                        >
                            <div class="item">
                                <img class="lazyload" :data-src="image" :src="image" alt="contestant-thumbnail" />
                            </div>
                        </div>
                    </div>
                </div>
                <div dir="ltr" class="swiper tf-product-media-main" id="gallery-swiper-started">
                    <div class="swiper-wrapper">
                        <div
                            v-for="(image, imageIndex) in galleryImages"
                            :key="`${contestantSlug}-main-${imageIndex}`"
                            class="swiper-slide"
                        >
                            <a
                                :href="image"
                                target="_blank"
                                class="item"
                                data-pswp-width="600px"
                                data-pswp-height="800px"
                            >
                                <img
                                    class="tf-image-zoom lazyload"
                                    :data-zoom="image"
                                    :data-src="image"
                                    :src="image"
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
