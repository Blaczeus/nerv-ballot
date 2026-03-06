<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { ModalContestant } from '@/composables/useGlobalModals';

type ColorSwatch = {
    name: string;
    valueClass: string;
    image: string;
    line?: boolean;
    active?: boolean;
};

type CardLayout = 'list' | 'grid';

const props = withDefaults(defineProps<{
    contestant: ModalContestant & {
        colors: ColorSwatch[];
        sizes: string[];
    };
    layout?: CardLayout;
}>(), {
    layout: 'list',
});

const emit = defineEmits<{
    (event: 'quick-view', contestant: ModalContestant): void;
    (event: 'add-to-cart', contestant: ModalContestant): void;
}>();

const contestantLink = computed(() => `/contestants/${props.contestant.slug}`);
</script>

<template>
    <div
        v-if="layout === 'list'"
        class="card-product style-list"
        :data-availability="contestant.availability"
        :data-brand="contestant.brand"
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
            <div v-if="contestant.oldPrice" class="on-sale-wrap">
                <span class="on-sale-item">-25%</span>
            </div>
        </div>
        <div class="card-product-info">
            <Link :href="contestantLink" class="title link">{{ contestant.name }}</Link>
            <div class="price">
                <span v-if="contestant.oldPrice" class="old-price">{{ contestant.oldPrice }}</span>
                <span class="current-price">{{ contestant.price }}</span>
            </div>
            <p class="description text-secondary text-line-clamp-2">
                {{ contestant.description }}
            </p>
            <div class="variant-wrap-list">
                <ul class="list-color-product">
                    <li
                        v-for="(color, index) in contestant.colors"
                        :key="`${contestant.id}-${color.name}-${index}`"
                        :class="[
                            'list-color-item color-swatch',
                            {
                                active: color.active,
                                line: color.line,
                            },
                        ]"
                    >
                        <span class="d-none text-capitalize color-filter">{{ color.name }}</span>
                        <span :class="['swatch-value', color.valueClass]"></span>
                        <img
                            class="lazyload"
                            :data-src="color.image"
                            :src="color.image"
                            alt="image-product"
                        />
                    </li>
                </ul>
                <div class="size-box list-product-btn">
                    <span
                        v-for="(size, index) in contestant.sizes"
                        :key="`${contestant.id}-${size}-${index}`"
                        class="size-item box-icon"
                    >
                        {{ size }}
                    </span>
                </div>
                <div class="list-product-btn">
                    <a
                        href="#shoppingCart"
                        class="btn-main-product"
                        @click.prevent="emit('add-to-cart', contestant)"
                    >
                        Add To cart
                    </a>
                    <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                        <span class="icon icon-heart"></span>
                        <span class="tooltip">Wishlist</span>
                    </a>
                    <a
                        href="#compare"
                        data-bs-toggle="offcanvas"
                        aria-controls="compare"
                        class="box-icon compare btn-icon-action"
                    >
                        <span class="icon icon-gitDiff"></span>
                        <span class="tooltip">Compare</span>
                    </a>
                    <a
                        href="#quickView"
                        class="box-icon quickview tf-btn-loading"
                        @click.prevent="emit('quick-view', contestant)"
                    >
                        <span class="icon icon-eye"></span>
                        <span class="tooltip">Quick View</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div
        v-else
        class="card-product grid"
        :data-availability="contestant.availability"
        :data-brand="contestant.brand"
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
                    <span class="tooltip">Wishlist</span>
                </a>
                <a
                    href="#compare"
                    data-bs-toggle="offcanvas"
                    aria-controls="compare"
                    class="box-icon compare btn-icon-action"
                >
                    <span class="icon icon-gitDiff"></span>
                    <span class="tooltip">Compare</span>
                </a>
                <a
                    href="#quickView"
                    class="box-icon quickview tf-btn-loading"
                    @click.prevent="emit('quick-view', contestant)"
                >
                    <span class="icon icon-eye"></span>
                    <span class="tooltip">Quick View</span>
                </a>
            </div>
            <div class="list-btn-main">
                <a
                    href="#shoppingCart"
                    class="btn-main-product"
                    @click.prevent="emit('add-to-cart', contestant)"
                >
                    Add To cart
                </a>
            </div>
        </div>
        <div class="card-product-info">
            <Link :href="contestantLink" class="title link">
                {{ contestant.name }}
            </Link>
            <span class="price current-price">{{ contestant.price }}</span>
        </div>
    </div>
</template>
