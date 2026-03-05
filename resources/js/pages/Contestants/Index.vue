<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import ContestantCard from '@/components/contestants/ContestantCard.vue';
import Layout from '@/layouts/Layout.vue';

type Contestant = {
    slug: string;
    name: string;
    description: string;
    image: string;
};

const contestants: Contestant[] = [
    {
        slug: 'john-doe',
        name: 'John Doe',
        description:
            'Award-winning performer with a strong global fanbase and consistent stage presence.',
        image: '/tmp/images/products/womens/women-19.jpg',
    },
    {
        slug: 'amira-khan',
        name: 'Amira Khan',
        description:
            'Social impact advocate and rising nominee known for meaningful community campaigns.',
        image: '/tmp/images/products/womens/women-29.jpg',
    },
    {
        slug: 'emeka-ade',
        name: 'Emeka Ade',
        description:
            'Creative industry nominee recognized for innovation and audience engagement.',
        image: '/tmp/images/products/womens/women-63.jpg',
    },
    {
        slug: 'lina-rose',
        name: 'Lina Rose',
        description:
            'International pageant finalist with a track record of leadership and advocacy.',
        image: '/tmp/images/products/womens/women-121.jpg',
    },
];
</script>

<template>
    <Head title="Contestants" />

    <Layout>
        <div
            class="page-title"
            style="background-image: url('/tmp/images/section/page-title.jpg')"
        >
            <div class="container-full">
                <div class="row">
                    <div class="col-12">
                        <h3 class="heading text-center">Contestants</h3>
                        <ul
                            class="breadcrumbs d-flex align-items-center justify-content-center"
                        >
                            <li><a class="link" href="/">Home</a></li>
                            <li><i class="icon-arrRight"></i></li>
                            <li>Contestants</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <section class="flat-spacing">
            <div class="container-full2">
                <div class="tf-shop-control">
                    <div class="tf-control-filter">
                        <div class="d-flex shop-sale-text">
                            <i class="icon icon-checkCircle"></i>
                            <p class="text-caption-1">
                                Browse nominees and review their profiles before
                                voting.
                            </p>
                        </div>
                    </div>
                    <div class="tf-control-sorting">
                        <p class="text-caption-1">
                            {{ contestants.length }} contestants available
                        </p>
                    </div>
                </div>

                <div class="wrapper-control-shop">
                    <div class="tf-list-layout wrapper-shop">
                        <ContestantCard
                            v-for="contestant in contestants"
                            :key="contestant.slug"
                            :image="contestant.image"
                            :name="contestant.name"
                            :description="contestant.description"
                            :href="`/contestants/${contestant.slug}`"
                        />
                    </div>
                </div>
            </div>
        </section>
    </Layout>
</template>
