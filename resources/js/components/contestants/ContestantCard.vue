<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { ModalContestant } from '@/composables/useGlobalModals';
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

const rankMeta = computed(() => {
    if (typeof props.rank !== 'number' || Number.isNaN(props.rank)) {
        return {
            badgeBg: '#f1f3f5',
            badgeText: '#1f2937',
            accent: '#6c757d',
            number: null,
        };
    }

    if (props.rank === 1) {
        return { badgeBg: '#d4af37', badgeText: '#1f2937', accent: '#d4af37', number: props.rank };
    }
    if (props.rank === 2) {
        return { badgeBg: '#c0c0c0', badgeText: '#1f2937', accent: '#c0c0c0', number: props.rank };
    }
    if (props.rank === 3) {
        return { badgeBg: '#cd7f32', badgeText: '#1f2937', accent: '#cd7f32', number: props.rank };
    }

    return { badgeBg: '#f1f3f5', badgeText: '#1f2937', accent: '#6c757d', number: props.rank };
});

const rankBadgeStyle = computed(() => ({
    backgroundColor: rankMeta.value.badgeBg,
    color: rankMeta.value.badgeText,
    width: '36px',
    height: '36px',
    fontWeight: '600',
    fontSize: '14px',
}));

const voteStyle = computed(() => ({
    color: rankMeta.value.accent,
    fontWeight: '600',
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
                        href="#compare"
                        data-bs-toggle="offcanvas"
                        aria-controls="compare"
                        class="box-icon compare btn-icon-action"
                    >
                        <span class="icon icon-gitDiff"></span>
                        <span class="tooltip">Compare Contestants</span>
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
        class="card-product grid"
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
                    href="#compare"
                    data-bs-toggle="offcanvas"
                    aria-controls="compare"
                    class="box-icon compare btn-icon-action"
                >
                    <span class="icon icon-gitDiff"></span>
                    <span class="tooltip">Compare Contestants</span>
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
            <span class="price current-price d-block mb_10">{{ formattedVotes }}</span>
            <Link :href="contestantLink" class="btn-line mt_12">View Profile</Link>
        </div>
    </div>

    <div
        v-else-if="layout === 'leaderboard'"
        class="collection-position-2 radius-lg style-3 hover-img position-relative"
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
        <div class="content">
            <Link :href="contestantLink" class="cls-btn d-flex flex-row align-items-start">
                <h6 class="text mb-0">{{ contestant.name }}</h6>
                <span class="count-item" :style="voteStyle">{{ formattedVotes }}</span>
                <i class="icon icon-arrowUpRight"></i>
            </Link>
        </div>
    </div>
</template>
