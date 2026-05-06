<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { ModalContestant } from '@/composables/useGlobalModals';
import { isVotingOpen } from '@/utils/contestStatus';
import { formatVotes } from '@/utils/formatVotes';

const props = defineProps<{
    contestant: ModalContestant;
}>();

const emit = defineEmits<{
    (event: 'quick-view', contestant: ModalContestant): void;
    (event: 'add-to-cart', contestant: ModalContestant): void;
}>();

const contestantLink = computed(() => `/contestants/${props.contestant.slug}`);
const formattedVotes = computed(() => formatVotes(props.contestant.votes));
const canVote = computed(() => isVotingOpen(props.contestant.contestStatus));
const votingStatusLabel = computed(() => (canVote.value ? 'Voting Open' : 'Voting Closed'));
</script>

<template>
    <div class="card-product grid home-discovery-card">
        <div class="card-product-wrapper">
            <Link :href="contestantLink" class="product-img">
                <img class="lazyload img-product" :data-src="contestant.image" :src="contestant.image"
                    alt="contestant image" />
                <img class="lazyload img-hover" :data-src="contestant.hoverImage" :src="contestant.hoverImage"
                    alt="contestant image" />
            </Link>
            <div class="list-product-btn">
                <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                    <span class="icon icon-heart"></span>
                    <span class="tooltip">Add to Favorites</span>
                </a>
                <a href="#quickView" class="box-icon quickview tf-btn-loading"
                    @click.prevent="emit('quick-view', contestant)">
                    <span class="icon icon-eye"></span>
                    <span class="tooltip">Quick Preview</span>
                </a>
                <Link :href="contestantLink" class="box-icon btn-icon-action">
                    <span class="icon icon-arrowUpRight"></span>
                    <span class="tooltip">Go to Profile</span>
                </Link>
            </div>
            <div class="list-btn-main">
                <a href="#shoppingCart" class="btn-main-product" :class="{ 'is-disabled-action': !canVote }"
                    @click.prevent="emit('add-to-cart', contestant)">
                    Vote Now
                </a>
            </div>
        </div>
        <div class="card-product-info">
            <Link :href="contestantLink" class="title link home-discovery-title">
                {{ contestant.name }}
            </Link>
            <span class="price current-price home-discovery-votes">{{ formattedVotes }}</span>
            <span class="home-discovery-status-pill" :class="{ 'is-open': canVote }">
                {{ votingStatusLabel }}
            </span>
        </div>
    </div>
</template>

<style scoped>
.home-discovery-card {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.home-discovery-card .card-product-wrapper {
    flex-shrink: 0;
}

.home-discovery-card .card-product-info {
    display: flex;
    flex: 1;
    flex-direction: column;
    justify-content: space-between;
    gap: 8px;
    padding-top: 14px;
}

.home-discovery-title {
    display: -webkit-box;
    min-height: 44px;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-box-orient: vertical;
    line-clamp: 2;
    -webkit-line-clamp: 2;
    line-height: 1.4;
}

.home-discovery-votes {
    display: block;
    margin-top: 0;
}

.home-discovery-status-pill {
    display: inline-flex;
    width: fit-content;
    align-items: center;
    justify-content: center;
    padding: 4px 10px;
    border-radius: 999px;
    background: #fef2f2;
    color: #b91c1c;
    font-size: 11px;
    font-weight: 600;
    line-height: 1.2;
}

.home-discovery-status-pill.is-open {
    background: #ecfdf5;
    color: #047857;
}

.is-disabled-action {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
