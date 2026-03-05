<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Layout from '@/layouts/Layout.vue';
</script>

<template>
    <Head title="How It Works" />

    <Layout>
        <section class="flat-spacing">
            <div class="container">
                <div class="mb_40 text-center">
                    <h3>How It Works</h3>
                    <p class="text-secondary">
                        A simple process to discover nominees, cast votes, and
                        track results.
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
                                    Browse contestant profiles and shortlist
                                    your preferred nominees.
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
                                <h6>2. Cast Your Vote</h6>
                                <p class="text-secondary">
                                    Submit your vote securely for your selected
                                    contestant.
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
                                <h6>3. Follow Results</h6>
                                <p class="text-secondary">
                                    Track updates and final rankings as voting
                                    progresses.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </Layout>
</template>
