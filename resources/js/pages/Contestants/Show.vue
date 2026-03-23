<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import GallerySection from '@/components/contestant/GallerySection.vue';
import ProductInfoSection from '@/components/contestant/ProductInfoSection.vue';
import ProductTabsSection from '@/components/contestant/ProductTabsSection.vue';
import Breadcrumb from '@/components/ui/Breadcrumb.vue';
import { contestants } from '@/data/contestants';
import Layout from '@/layouts/Layout.vue';

type Contestant = (typeof contestants)[number];

const props = defineProps<{
    slug: string;
}>();

const fallbackContestant: Contestant = contestants[0] ?? {
    id: 0,
    slug: props.slug,
    name: 'Contestant',
    contestName: '',
    category: '',
    location: '',
    gender: '',
    votes: 0,
    contestStart: '',
    contestEnd: '',
    createdAt: '',
    image: '/tmp/images/products/womens/women-19.jpg',
    hoverImage: '/tmp/images/products/womens/women-20.jpg',
    images: [
        '/tmp/images/products/womens/women-19.jpg',
        '/tmp/images/products/womens/women-20.jpg',
    ],
    description: '',
};

const contestant = computed<Contestant>(() => {
    return contestants.find((item) => item.slug === props.slug) ?? fallbackContestant;
});

const breadcrumbItems = computed(() => [
    { label: 'Home', link: '/' },
    { label: 'Contestants', link: '/contestants' },
    { label: contestant.value.name },
]);

const breadcrumbNav = {
    prev: '/contestants',
    back: '/contestants',
    next: '/contestants',
};
</script>

<template>
    <Head :title="contestant.name" />

    <Layout>
        <Breadcrumb :items="breadcrumbItems" :nav="breadcrumbNav" design="text" />

        <section class="flat-spacing">
            <div class="tf-main-product section-image-zoom">
                <div class="container">
                    <div class="row">
                        <GallerySection :contestant-slug="contestant.slug" :gallery-images="contestant.images" />
                        <ProductInfoSection :contestant="contestant" />
                    </div>
                </div>
            </div>
        </section>

        <ProductTabsSection :contestant="contestant" />
    </Layout>
</template>
