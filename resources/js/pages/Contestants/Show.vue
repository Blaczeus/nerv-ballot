<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Layout from '@/layouts/Layout.vue';

const props = defineProps<{
    slug: string;
}>();

type Contestant = {
    slug: string;
    name: string;
    bio: string;
    image: string;
};

const contestants: Contestant[] = [
    {
        slug: 'john-doe',
        name: 'John Doe',
        bio: 'John Doe is a multi-category nominee recognized for public engagement and live performance consistency.',
        image: '/tmp/images/products/womens/women-19.jpg',
    },
    {
        slug: 'amira-khan',
        name: 'Amira Khan',
        bio: 'Amira Khan is known for advocacy-led campaigns and strong audience participation across regional events.',
        image: '/tmp/images/products/womens/women-29.jpg',
    },
    {
        slug: 'emeka-ade',
        name: 'Emeka Ade',
        bio: 'Emeka Ade brings innovation and strong storytelling to every nomination cycle in the competition.',
        image: '/tmp/images/products/womens/women-63.jpg',
    },
    {
        slug: 'lina-rose',
        name: 'Lina Rose',
        bio: 'Lina Rose is an international finalist with a measurable impact in youth mentorship initiatives.',
        image: '/tmp/images/products/womens/women-121.jpg',
    },
];

const contestant =
    contestants.find((item) => item.slug === props.slug) ??
    ({
        slug: props.slug,
        name: 'Contestant Profile',
        bio: 'Profile details will be connected to live contest data in the next phase.',
        image: '/tmp/images/products/womens/women-19.jpg',
    } satisfies Contestant);
</script>

<template>
    <Head :title="contestant.name" />

    <Layout>
        <section class="flat-spacing">
            <div class="container">
                <div class="mb_20">
                    <Link href="/contestants" class="btn-line"
                        >Back to Contestants</Link
                    >
                </div>

                <div class="row g-4 align-items-center">
                    <div class="col-lg-5">
                        <div class="image">
                            <img
                                :src="contestant.image"
                                :alt="contestant.name"
                            />
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <h3 class="mb_16">{{ contestant.name }}</h3>
                        <p class="mb_24 text-secondary">{{ contestant.bio }}</p>
                        <a href="#" class="tf-btn">
                            <span class="text">Vote Now</span>
                            <i class="icon icon-arrowUpRight"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </Layout>
</template>
