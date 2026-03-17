<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import Breadcrumb from '@/components/ui/Breadcrumb.vue';
import ContestantCard from '@/components/contestants/ContestantCard.vue';
import { contestants as contestantsData } from '@/data/contestants';
import Layout from '@/layouts/Layout.vue';

const contestants = contestantsData;
const sortedContestants = computed(() => (
    [...contestants].sort((a, b) => b.votes - a.votes)
));
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
        <!-- Collections -->
        <section class="flat-spacing">
            <div class="container">
                <div class="tf-grid-layout tf-col-2 lg-col-4">
                    <ContestantCard
                        v-for="(contestant, index) in sortedContestants"
                        :key="contestant.id"
                        :contestant="contestant"
                        :rank="index + 1"
                        layout="leaderboard"
                    />
                    <!-- pagination -->
                    <ul class="wg-pagination justify-content-center">
                        <li><a href="#" class="pagination-item text-button">1</a></li>
                        <li class="active"><div class="pagination-item text-button">2</div></li>
                        <li><a href="#" class="pagination-item text-button">3</a></li>
                        <li><a href="#" class="pagination-item text-button"><i class="icon-arrRight"></i></a></li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- /Collections -->
        
        
        
       
        <!-- Footer -->
    </Layout>
</template>
