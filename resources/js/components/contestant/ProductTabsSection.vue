<script setup lang="ts">
import type { ModalContestant } from '@/composables/useGlobalModals';

defineOptions({ inheritAttrs: false });

defineProps<{
    contestant: ModalContestant;
}>();
</script>

<template>
    <!-- Product_Description_Tabs -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="widget-tabs style-menu-tabs">
                        <ul class="widget-menu-tab">
                            <li class="item-title active">
                                <span class="inner">Description</span>
                            </li>
                            <li class="item-title">
                                <span class="inner">Customer Reviews</span>
                            </li>
                            <li class="item-title">
                                <span class="inner">Shipping & Returns</span>
                            </li>
                            <li class="item-title">
                                <span class="inner">Return Policies</span>
                            </li>
                        </ul>
                        <div class="widget-content-tab">
                            <div class="widget-content-inner active">
                                <div class="tab-description">
                                    <div class="right">
                                        <div class="letter-1 text-btn-uppercase mb_12">{{ contestant.name }}</div>
                                        <p class="mb_12 text-secondary">{{ contestant.description }}</p>
                                        <p class="text-secondary">This contestant profile mirrors the original product detail layout while preparing dynamic voting content.</p>
                                    </div>
                                    <div class="left">
                                        <div class="letter-1 text-btn-uppercase mb_12">PROFILE DETAILS</div>
                                        <ul class="list-text type-disc mb_12 gap-6">
                                            <li class="font-2">Slug: {{ contestant.slug }}</li>
                                            <li class="font-2">Brand: {{ contestant.brand }}</li>
                                            <li class="font-2">Availability: {{ contestant.availability }}</li>
                                            <li class="font-2">Current price: {{ contestant.price }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="widget-content-inner">
                                <div class="tab-reviews write-cancel-review-wrap">
                                    <div class="reply-comment style-1">
                                        <div class="reply-comment-heading">
                                            <h4>2 reviews for {{ contestant.name }}</h4>
                                        </div>
                                        <div class="reply-comment-wrap">
                                            <div class="reply-comment-item">
                                                <div class="user">
                                                    <div class="image">
                                                        <img src="/tmp/images/avatar/user-default.jpg" alt="user-default" />
                                                    </div>
                                                    <div>
                                                        <h6><a href="#" class="link">Excellent contestant profile layout</a></h6>
                                                        <div class="day text-secondary-2 text-caption-1">1 day ago</div>
                                                    </div>
                                                </div>
                                                <p class="text-secondary">The section structure and interaction are smooth and clear for public voting flows.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <form class="form-write-review write-review-wrap" @submit.prevent>
                                        <div class="heading">
                                            <h4>Write a review:</h4>
                                        </div>
                                        <div class="mb_32">
                                            <div class="mb_8">Review Title</div>
                                            <fieldset class="mb_20">
                                                <input type="text" placeholder="Give your review a title" />
                                            </fieldset>
                                            <div class="mb_8">Review</div>
                                            <fieldset class="d-flex mb_20">
                                                <textarea rows="4" placeholder="Write your comment here"></textarea>
                                            </fieldset>
                                        </div>
                                        <div class="button-submit">
                                            <button class="text-btn-uppercase" type="submit">Submit Reviews</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="widget-content-inner">
                                <div class="tab-shipping">
                                    <div class="w-100">
                                        <div class="text-btn-uppercase mb_12">We have got your back</div>
                                        <p class="mb_12">One delivery fee to most locations (check Orders & Delivery page).</p>
                                        <p>Free returns within 14 days (excludes final sale items and special categories).</p>
                                    </div>
                                </div>
                            </div>

                            <div class="widget-content-inner">
                                <div class="tab-policies">
                                    <div class="text-btn-uppercase mb_12">Return Policies</div>
                                    <p class="mb_12 text-secondary">If you are not fully satisfied, returns are supported within the policy window.</p>
                                    <ul class="list-text type-number">
                                        <li class="text-secondary font-2">Initiate request online.</li>
                                        <li class="text-secondary font-2">Pack securely with original details.</li>
                                        <li class="text-secondary font-2">Use approved return channel.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Product_Description_Tabs -->
</template>
