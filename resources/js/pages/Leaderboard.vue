<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import Breadcrumb from '@/components/ui/Breadcrumb.vue';
import ContestantCard from '@/components/contestants/ContestantCard.vue';
import Pagination from '@/components/ui/Pagination.vue';
import type { ModalContestant } from '@/composables/useGlobalModals';
import Layout from '@/layouts/Layout.vue';

type BackendContestant = {
    id: number;
    name: string;
    slug: string;
    image: string | null;
    total_votes: number;
    contest_id: number;
    contest_status: 'active' | 'upcoming' | 'ended' | null;
    contest: {
        id: number;
        name: string;
        slug: string;
    } | null;
};

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

type PageProps = {
    contestants: {
        data: BackendContestant[];
        links: PaginationLink[];
    };
};

const page = usePage<PageProps>();
const FALLBACK_IMAGE = '/tmp/images/products/womens/women-19.jpg';

const contestants = computed<ModalContestant[]>(() => {
    return (page.props.contestants?.data ?? []).map((contestant) => ({
        id: contestant.id,
        contestId: contestant.contest_id,
        slug: contestant.slug,
        name: contestant.name,
        contestName: contestant.contest?.name ?? 'Contest',
        contestStatus: contestant.contest_status,
        category: 'Leaderboard',
        location: 'Unspecified',
        gender: 'unknown',
        votes: contestant.total_votes ?? 0,
        contestStart: '',
        contestEnd: '',
        createdAt: '',
        image: contestant.image ?? FALLBACK_IMAGE,
        hoverImage: contestant.image ?? FALLBACK_IMAGE,
        description: '',
    }));
});

const paginationLinks = computed(() => page.props.contestants?.links ?? []);

const handlePagination = (url: string) => {
    router.get(url, {}, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
};
</script>

<template>
    <Head title="Leaderboard" />

    <Layout>
        <Breadcrumb
            :items="[
                { label: 'Homepage', link: '/' },
                { label: 'Leaderboard' },
            ]"
            design="image"
            heading="Leaderboard"
            background-image="/tmp/images/section/page-title.jpg"
            container-class="container-full"
            :use-row="true"
        />
        <section class="flat-spacing">
            <div class="container">
                <div class="tf-grid-layout tf-col-2 lg-col-4">
                    <ContestantCard
                        v-for="(contestant, index) in contestants"
                        :key="contestant.id"
                        :contestant="contestant"
                        :rank="index + 1"
                        layout="leaderboard"
                    />
                </div>
                <div class="leaderboard-pagination-wrap">
                    <Pagination :links="paginationLinks" @navigate="handlePagination" />
                </div>
            </div>
        </section>
    </Layout>
</template>

<style scoped>
.leaderboard-pagination-wrap {
    margin-top: 40px;
}

.tf-grid-layout > * {
    height: 100%;
}
</style>
