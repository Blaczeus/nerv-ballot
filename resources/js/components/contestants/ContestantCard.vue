<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { ModalContestant } from '@/composables/useGlobalModals';
import { getContestStatusLabel, isVotingOpen } from '@/utils/contestStatus';
import { formatVotes } from '@/utils/formatVotes';

type CardLayout = 'list' | 'grid' | 'leaderboard';

const props = withDefaults(defineProps<{
    contestant: ModalContestant;
    layout?: CardLayout;
    rank?: number;
}>(), {
    layout: 'list',
});

const emit = defineEmits<{
    (event: 'quick-view', contestant: ModalContestant): void;
    (event: 'add-to-cart', contestant: ModalContestant): void;
}>();

const contestantLink = computed(() => `/contestants/${props.contestant.slug}`);
const formattedVotes = computed(() => {
    return formatVotes(props.contestant.votes);
});
const contestStatusLabel = computed(() => getContestStatusLabel(props.contestant.contestStatus));
const canVote = computed(() => isVotingOpen(props.contestant.contestStatus));

const rankMeta = computed(() => {
    if (typeof props.rank !== 'number' || Number.isNaN(props.rank)) {
        return {
            badgeBg: '#f3f4f6',
            badgeText: '#111111',
            accent: '#111111',
            number: null,
        };
    }

    if (props.rank === 1) {
        return { badgeBg: '#d4af37', badgeText: '#1f2937', accent: '#b8860b', number: props.rank };
    }
    if (props.rank === 2) {
        return { badgeBg: '#2563eb', badgeText: '#ffffff', accent: '#2563eb', number: props.rank };
    }
    if (props.rank === 3) {
        return { badgeBg: '#b45309', badgeText: '#ffffff', accent: '#b45309', number: props.rank };
    }

    return { badgeBg: '#f3f4f6', badgeText: '#111111', accent: '#111111', number: props.rank };
});

const rankBadgeStyle = computed(() => ({
    backgroundColor: rankMeta.value.badgeBg,
    color: rankMeta.value.badgeText,
    width: '36px',
    height: '36px',
    fontWeight: '600',
    fontSize: '14px',
}));

const votePillStyle = computed(() => ({
    backgroundColor: rankMeta.value.accent,
    color: '#ffffff',
    fontWeight: '600',
}));

const leaderboardNameStyle = computed(() => ({
    color: rankMeta.value.accent,
}));
</script>

<template>
    <div
        v-if="layout === 'list'"
        class="card-product style-list"
    >
        <div class="card-product-wrapper">
            <Link :href="contestantLink" class="product-img">
                <img
                    class="lazyload img-product"
                    :data-src="contestant.image"
                    :src="contestant.image"
                    alt="image-product"
                />
                <img
                    class="lazyload img-hover"
                    :data-src="contestant.hoverImage"
                    :src="contestant.hoverImage"
                    alt="image-product"
                />
            </Link>
        </div>
        <div class="card-product-info">
            <Link :href="contestantLink" class="title link mb_6 d-block">{{ contestant.name }}</Link>
            <p class="text-caption-1 text-secondary mb_8">{{ contestant.contestName }}</p>
            <span class="contest-status-pill" :class="`status-${contestant.contestStatus ?? 'ended'}`">
                {{ contestStatusLabel }}
            </span>
            <div class="price mb_8">
                <span class="current-price">{{ formattedVotes }}</span>
            </div>
            <p class="description text-secondary text-line-clamp-4 mb_12">
                {{ contestant.description }}
            </p>
            <div class="variant-wrap-list">
                <div class="list-product-btn mt_16 d-flex gap-12 flex-wrap align-items-center">
                    <a
                        href="#shoppingCart"
                        class="btn-main-product"
                        :class="{ 'is-disabled-action': !canVote }"
                        @click.prevent="emit('add-to-cart', contestant)"
                    >
                        Vote Now
                    </a>
                    <Link :href="contestantLink" class="btn-line">View Profile</Link>
                    <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                        <span class="icon icon-heart"></span>
                        <span class="tooltip">Add to Favorites</span>
                    </a>
                    <a
                        href="#quickView"
                        class="box-icon quickview tf-btn-loading"
                        @click.prevent="emit('quick-view', contestant)"
                    >
                        <span class="icon icon-eye"></span>
                        <span class="tooltip">Quick Preview</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div
        v-else-if="layout === 'grid'"
        class="card-product grid contestant-grid-card"
    >
        <div class="card-product-wrapper">
            <Link :href="contestantLink" class="product-img">
                <img
                    class="lazyload img-product"
                    :data-src="contestant.image"
                    :src="contestant.image"
                    alt="image-product"
                />
                <img
                    class="lazyload img-hover"
                    :data-src="contestant.hoverImage"
                    :src="contestant.hoverImage"
                    alt="image-product"
                />
            </Link>
            <div class="list-product-btn">
                <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                    <span class="icon icon-heart"></span>
                    <span class="tooltip">Add to Favorites</span>
                </a>
                <a
                    href="#quickView"
                    class="box-icon quickview tf-btn-loading"
                    @click.prevent="emit('quick-view', contestant)"
                >
                    <span class="icon icon-eye"></span>
                    <span class="tooltip">Quick Preview</span>
                </a>
            </div>
            <div class="list-btn-main">
                <a
                    href="#shoppingCart"
                    class="btn-main-product"
                    :class="{ 'is-disabled-action': !canVote }"
                    @click.prevent="emit('add-to-cart', contestant)"
                >
                    Vote Now
                </a>
            </div>
        </div>
        <div class="card-product-info">
            <Link :href="contestantLink" class="title link mb_6 d-block">
                {{ contestant.name }}
            </Link>
            <p class="text-caption-1 text-secondary mb_8">{{ contestant.contestName }}</p>
            <span class="contest-status-pill" :class="`status-${contestant.contestStatus ?? 'ended'}`">
                {{ contestStatusLabel }}
            </span>
            <span class="price current-price d-block mb_10">{{ formattedVotes }}</span>
            <Link :href="contestantLink" class="btn-line mt_12">View Profile</Link>
        </div>
    </div>

    <div
        v-else-if="layout === 'leaderboard'"
        class="collection-position-2 radius-lg style-3 hover-img position-relative leaderboard-card"
    >
        <Link class="img-style" :href="contestantLink">
            <img
                class="lazyload"
                :data-src="contestant.image"
                :src="contestant.image"
                alt="banner-cls"
            />
        </Link>
        <div
            v-if="rankMeta.number"
            class="position-absolute top-0 inset-e-0 m-3 rounded-circle d-flex align-items-center justify-content-center"
            :style="rankBadgeStyle"
        >
            {{ rankMeta.number }}
        </div>
        <div class="content leaderboard-card-content">
            <Link :href="contestantLink" class="leaderboard-name-card">
                <div class="leaderboard-name-row">
                    <h6 class="text mb-0" :style="leaderboardNameStyle">{{ contestant.name }}</h6>
                    <i class="icon icon-arrowUpRight"></i>
                </div>
            </Link>
            <div class="leaderboard-meta-row">
                <span class="leaderboard-votes-pill" :style="votePillStyle">
                    {{ formattedVotes }}
                </span>
                <span class="contest-status-pill mb-0" :class="`status-${contestant.contestStatus ?? 'ended'}`">
                    {{ contestStatusLabel }}
                </span>
            </div>
        </div>
    </div>
</template>

<style scoped>
.contest-status-pill {
    display: inline-flex;
    margin-bottom: 10px;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 600;
}

.status-active {
    background: #ecfdf5;
    color: #047857;
}

.status-upcoming {
    background: #eff6ff;
    color: #1d4ed8;
}

.status-ended {
    background: #fef2f2;
    color: #b91c1c;
}

.is-disabled-action {
    opacity: 0.5;
    cursor: not-allowed;
}

.contestant-grid-card {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.contestant-grid-card .card-product-wrapper {
    flex-shrink: 0;
}

.contestant-grid-card .card-product-info {
    display: flex;
    flex: 1;
    flex-direction: column;
    gap: 8px;
}

.contestant-grid-card .title {
    min-height: 48px;
    line-height: 1.45;
    display: -webkit-box;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}

.leaderboard-name-card {
    display: block;
    background: #fff;
    border-radius: 18px;
    padding: 16px 18px;
    box-shadow: 0 10px 30px rgba(17, 24, 39, 0.08);
}

.leaderboard-card {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.leaderboard-card > .img-style {
    flex-shrink: 0;
}

.leaderboard-card-content {
    display: flex;
    flex: 1;
    flex-direction: column;
    justify-content: space-between;
    gap: 14px;
}

.leaderboard-name-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
}

.leaderboard-name-row .text {
    flex: 1;
    min-width: 0;
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-size: 16px;
    line-height: 1.4;
}

.leaderboard-meta-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-top: 12px;
}

.leaderboard-votes-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 34px;
    min-width: 116px;
    padding: 7px 14px;
    border-radius: 999px;
    font-size: 12px;
    line-height: 1;
    white-space: nowrap;
}

.leaderboard-meta-row .contest-status-pill {
    margin-bottom: 0;
}
</style>
