<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import GallerySection from '@/components/contestant/GallerySection.vue';
import ProductInfoSection from '@/components/contestant/ProductInfoSection.vue';
import ProductTabsSection from '@/components/contestant/ProductTabsSection.vue';
import Breadcrumb from '@/components/ui/Breadcrumb.vue';
import type { ModalContestant } from '@/composables/useGlobalModals';
import Layout from '@/layouts/Layout.vue';
import type { ContestStatus } from '@/utils/contestStatus';

type BackendContestant = {
    id: number;
    slug: string;
    name: string;
    contestName: string;
    contest_status: ContestStatus | null;
    category: string;
    gender: string;
    location: string;
    votes: number;
    contestStart: string;
    contestEnd: string;
    createdAt: string;
    image: string | null;
    hoverImage: string | null;
    images?: string[];
    description: string;
};

type ContestantPageContestant = ModalContestant & {
    images?: string[];
};

const props = defineProps<{
    contestant: BackendContestant;
}>();

const FALLBACK_IMAGE = '/tmp/images/products/womens/women-19.jpg';

const contestant = computed<ContestantPageContestant>(() => ({
    id: props.contestant.id,
    slug: props.contestant.slug,
    name: props.contestant.name,
    contestName: props.contestant.contestName,
    contestStatus: props.contestant.contest_status,
    category: props.contestant.category,
    gender: props.contestant.gender,
    location: props.contestant.location,
    votes: props.contestant.votes,
    contestStart: props.contestant.contestStart,
    contestEnd: props.contestant.contestEnd,
    createdAt: props.contestant.createdAt,
    description: props.contestant.description,
    image: props.contestant.image || FALLBACK_IMAGE,
    hoverImage: props.contestant.hoverImage || props.contestant.image || FALLBACK_IMAGE,
    images: props.contestant.images?.length
        ? props.contestant.images
        : [props.contestant.image || FALLBACK_IMAGE],
}));

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
                        <GallerySection :contestant-slug="contestant.slug" :gallery-images="contestant.images ?? []" />
                        <ProductInfoSection :contestant="contestant" />
                    </div>
                </div>
            </div>
        </section>

        <ProductTabsSection :contestant="contestant" />
    </Layout>
</template>
