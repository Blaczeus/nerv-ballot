<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import ContestantCard from '@/components/contestants/ContestantCard.vue';
import Breadcrumb from '@/components/ui/Breadcrumb.vue';
import { useGlobalModals } from '@/composables/useGlobalModals';
import type { ModalContestant } from '@/composables/useGlobalModals';
import Layout from '@/layouts/Layout.vue';

type Contestant = ModalContestant & {
    colors: Array<{
        name: string;
        valueClass: string;
        image: string;
        line?: boolean;
        active?: boolean;
    }>;
    sizes: string[];
};

const contestants: Contestant[] = [
    {
        id: 1,
        slug: 'john-doe',
        name: 'John Doe',
        image: '/tmp/images/products/womens/women-19.jpg',
        hoverImage: '/tmp/images/products/womens/women-20.jpg',
        price: '$219.99',
        oldPrice: '$98.00',
        description:
            'Public voting nominee with strong stage presence and consistent fan engagement.',
        availability: 'Out of stock',
        brand: 'adidas',
        colors: [
            {
                name: 'Green',
                valueClass: 'bg-light-green',
                image: '/tmp/images/products/womens/women-19.jpg',
                active: true,
                line: true,
            },
            {
                name: 'Grey',
                valueClass: 'bg-grey-2',
                image: '/tmp/images/products/womens/women-1.jpg',
            },
            {
                name: 'White',
                valueClass: 'bg-white',
                image: '/tmp/images/products/womens/women-8.jpg',
                line: true,
            },
        ],
        sizes: ['S', 'M', 'L', 'XL', 'XXL'],
    },
    {
        id: 2,
        slug: 'amira-khan',
        name: 'Amira Khan',
        image: '/tmp/images/products/womens/women-29.jpg',
        hoverImage: '/tmp/images/products/womens/women-31.jpg',
        price: '$59.99',
        oldPrice: '$98.00',
        description:
            'Category finalist recognized for advocacy impact and audience consistency.',
        availability: 'Out of stock',
        brand: 'LV',
        colors: [
            {
                name: 'Orange',
                valueClass: 'bg-light-orange',
                image: '/tmp/images/products/womens/women-29.jpg',
                active: true,
            },
            {
                name: 'Orange',
                valueClass: 'bg-orange',
                image: '/tmp/images/products/womens/women-43.jpg',
            },
            {
                name: 'Pink',
                valueClass: 'bg-dark-pink',
                image: '/tmp/images/products/womens/women-47.jpg',
            },
        ],
        sizes: ['S', 'M', 'L', 'XL', 'XXL'],
    },
    {
        id: 3,
        slug: 'emeka-ade',
        name: 'Emeka Ade',
        image: '/tmp/images/products/womens/women-63.jpg',
        hoverImage: '/tmp/images/products/womens/women-64.jpg',
        price: '$219.95',
        oldPrice: '$98.00',
        description:
            'Performance-driven nominee with measurable campaign results across regions.',
        availability: 'In stock',
        brand: 'nike',
        colors: [
            {
                name: 'White',
                valueClass: 'bg-white',
                image: '/tmp/images/products/womens/women-63.jpg',
                active: true,
                line: true,
            },
            {
                name: 'Blue',
                valueClass: 'bg-light-blue',
                image: '/tmp/images/products/womens/women-69.jpg',
                line: true,
            },
            {
                name: 'Dark Blue',
                valueClass: 'bg-dark-blue',
                image: '/tmp/images/products/womens/women-70.jpg',
            },
        ],
        sizes: ['S', 'M', 'L', 'XL', 'XXL'],
    },
    {
        id: 4,
        slug: 'lina-rose',
        name: 'Lina Rose',
        image: '/tmp/images/products/womens/women-37.jpg',
        hoverImage: '/tmp/images/products/womens/women-38.jpg',
        price: '$59.99',
        description:
            'International voting nominee with top rankings in recent contest rounds.',
        availability: 'In stock',
        brand: 'gucci',
        colors: [
            {
                name: 'Light Blue',
                valueClass: 'bg-light-blue',
                image: '/tmp/images/products/womens/women-37.jpg',
                active: true,
            },
            {
                name: 'White',
                valueClass: 'bg-white',
                image: '/tmp/images/products/womens/women-41.jpg',
                line: true,
            },
        ],
        sizes: ['XS', 'L', 'XL', '2XL', '3XL'],
    },
    {
        id: 5,
        slug: 'grace-iyke',
        name: 'Grace Iyke',
        image: '/tmp/images/products/womens/women-133.jpg',
        hoverImage: '/tmp/images/products/womens/women-131.jpg',
        price: '$79.99',
        description:
            'Community-choice nominee with high conversion from shortlist to final votes.',
        availability: 'In stock',
        brand: 'hermes',
        colors: [
            {
                name: 'White',
                valueClass: 'bg-white',
                image: '/tmp/images/products/womens/women-133.jpg',
                active: true,
                line: true,
            },
            {
                name: 'Beige',
                valueClass: 'bg-beige',
                image: '/tmp/images/products/womens/women-124.jpg',
            },
        ],
        sizes: ['S', 'M', 'L', 'XL', 'XXL'],
    },
    {
        id: 6,
        slug: 'victor-lee',
        name: 'Victor Lee',
        image: '/tmp/images/products/womens/women-167.jpg',
        hoverImage: '/tmp/images/products/womens/women-168.jpg',
        price: '$199.25',
        description:
            'Audience favorite nominee with sustained voting activity across categories.',
        availability: 'In stock',
        brand: 'zalando',
        colors: [
            {
                name: 'White',
                valueClass: 'bg-white',
                image: '/tmp/images/products/womens/women-167.jpg',
                active: true,
                line: true,
            },
            {
                name: 'Beige',
                valueClass: 'bg-beige',
                image: '/tmp/images/products/womens/women-162.jpg',
            },
        ],
        sizes: ['S', 'M', 'L', 'XL', 'XXL'],
    },
];

const { openQuickView, openCart, openFilter } = useGlobalModals();
type GridLayoutClass = 'tf-col-2' | 'tf-col-3' | 'tf-col-4' | 'tf-col-5';
type LayoutMode = 'list' | GridLayoutClass;

const layoutMode = ref<LayoutMode>('list');

const isListLayout = computed(() => layoutMode.value === 'list');
const activeGridLayout = computed<GridLayoutClass>(() => {
    return layoutMode.value === 'list' ? 'tf-col-4' : layoutMode.value;
});

const wrapperControlShopClass = computed(() => {
    return [
        'wrapper-control-shop',
        isListLayout.value ? 'listLayout-wrapper' : 'gridLayout-wrapper',
    ];
});

const gridLayoutClass = computed(() => {
    return `tf-grid-layout wrapper-shop ${activeGridLayout.value}`;
});

const setLayoutMode = (mode: LayoutMode) => {
    layoutMode.value = mode;
};

const breadcrumbItems = [
    { label: 'Homepage', link: '/' },
    { label: 'Women' },
];
</script>

<template>

    <Head title="Shop Default List" />

    <Layout>
        <Breadcrumb
            :items="breadcrumbItems"
            design="image"
            heading="Women"
            background-image="/tmp/images/section/page-title.jpg"
            container-class="container-full"
            :use-row="true"
        />
        <!-- Section product -->
        <section class="flat-spacing">
            <div class="container">
                <div class="tf-shop-control">
                    <div class="tf-control-filter">
                        <a href="#filterShop" class="tf-btn-filter" @click.prevent="openFilter">
                            <span class="icon icon-filter"></span>
                            <span class="text">Filters</span>
                        </a>
                        <div class="d-none d-lg-flex shop-sale-text">
                            <i class="icon icon-checkCircle"></i>
                            <p class="text-caption-1">Shop sale items only</p>
                        </div>
                    </div>
                    <ul class="tf-control-layout">
                        <li :class="[
                            'tf-view-layout-switch sw-layout-list list-layout',
                            { active: layoutMode === 'list' },
                        ]" data-value-layout="list" @click="setLayoutMode('list')">
                            <div class="item">
                                <svg class="icon" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="3" cy="6" r="2.5" stroke="#181818" />
                                    <rect x="7.5" y="3.5" width="12" height="5" rx="2.5" stroke="#181818" />
                                    <circle cx="3" cy="14" r="2.5" stroke="#181818" />
                                    <rect x="7.5" y="11.5" width="12" height="5" rx="2.5" stroke="#181818" />
                                </svg>
                            </div>
                        </li>
                        <li :class="[
                            'tf-view-layout-switch sw-layout-2',
                            { active: layoutMode === 'tf-col-2' },
                        ]" data-value-layout="tf-col-2" @click="setLayoutMode('tf-col-2')">
                            <div class="item">
                                <svg class="icon" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="6" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="14" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="6" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="14" cy="14" r="2.5" stroke="#181818" />
                                </svg>
                            </div>
                        </li>
                        <li :class="[
                            'tf-view-layout-switch sw-layout-3',
                            { active: layoutMode === 'tf-col-3' },
                        ]" data-value-layout="tf-col-3" @click="setLayoutMode('tf-col-3')">
                            <div class="item">
                                <svg class="icon" width="22" height="20" viewBox="0 0 22 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="3" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="11" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="19" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="3" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="11" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="19" cy="14" r="2.5" stroke="#181818" />
                                </svg>
                            </div>
                        </li>
                        <li :class="[
                            'tf-view-layout-switch sw-layout-4',
                            { active: layoutMode === 'tf-col-4' },
                        ]" data-value-layout="tf-col-4" @click="setLayoutMode('tf-col-4')">
                            <div class="item">
                                <svg class="icon" width="30" height="20" viewBox="0 0 30 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="3" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="11" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="19" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="27" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="3" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="11" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="19" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="27" cy="14" r="2.5" stroke="#181818" />
                                </svg>
                            </div>
                        </li>
                        <li :class="[
                            'tf-view-layout-switch sw-layout-5',
                            { active: layoutMode === 'tf-col-5' },
                        ]" data-value-layout="tf-col-5" @click="setLayoutMode('tf-col-5')">
                            <div class="item">
                                <svg class="icon" width="38" height="20" viewBox="0 0 38 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="3" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="11" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="19" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="27" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="35" cy="6" r="2.5" stroke="#181818" />
                                    <circle cx="3" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="11" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="19" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="27" cy="14" r="2.5" stroke="#181818" />
                                    <circle cx="35" cy="14" r="2.5" stroke="#181818" />
                                </svg>
                            </div>
                        </li>
                    </ul>
                    <div class="tf-control-sorting">
                        <p class="d-none d-lg-block text-caption-1">Sort by:</p>
                        <div class="tf-dropdown-sort" data-bs-toggle="dropdown">
                            <div class="btn-select">
                                <span class="text-sort-value">Best selling</span>
                                <span class="icon icon-arrow-down"></span>
                            </div>
                            <div class="dropdown-menu">
                                <div class="select-item" data-sort-value="best-selling">
                                    <span class="text-value-item">Best selling</span>
                                </div>
                                <div class="select-item" data-sort-value="a-z">
                                    <span class="text-value-item">Alphabetically, A-Z</span>
                                </div>
                                <div class="select-item" data-sort-value="z-a">
                                    <span class="text-value-item">Alphabetically, Z-A</span>
                                </div>
                                <div class="select-item" data-sort-value="price-low-high">
                                    <span class="text-value-item">Price, low to high</span>
                                </div>
                                <div class="select-item" data-sort-value="price-high-low">
                                    <span class="text-value-item">Price, high to low</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div :class="wrapperControlShopClass">
                    <div class="meta-filter-shop">
                        <div id="product-count-grid" class="count-text"></div>
                        <div id="product-count-list" class="count-text"></div>
                        <div id="applied-filters"></div>
                        <button id="remove-all" class="remove-all-filters text-btn-uppercase" style="display: none">
                            REMOVE ALL <i class="icon icon-close"></i>
                        </button>
                    </div>
                    <div v-show="isListLayout" class="tf-list-layout wrapper-shop" id="listLayout">
                        <ContestantCard v-for="contestant in contestants" :key="contestant.id" :contestant="contestant"
                            layout="list" @quick-view="openQuickView" @add-to-cart="openCart" />
                        <!-- pagination -->
                        <ul class="wg-pagination">
                            <li><a href="#" class="pagination-item text-button">1</a></li>
                            <li class="active">
                                <div class="pagination-item text-button">2</div>
                            </li>
                            <li><a href="#" class="pagination-item text-button">3</a></li>
                            <li>
                                <a href="#" class="pagination-item text-button">
                                    <i class="icon-arrRight"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div v-show="!isListLayout" :class="gridLayoutClass" id="gridLayout">
                        <ContestantCard v-for="contestant in contestants" :key="`grid-${contestant.id}`"
                            :contestant="contestant" layout="grid" @quick-view="openQuickView"
                            @add-to-cart="openCart" />
                        <!-- pagination -->
                        <ul class="wg-pagination">
                            <li><a href="#" class="pagination-item text-button">1</a></li>
                            <li class="active">
                                <div class="pagination-item text-button">2</div>
                            </li>
                            <li><a href="#" class="pagination-item text-button">3</a></li>
                            <li>
                                <a href="#" class="pagination-item text-button">
                                    <i class="icon-arrRight"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Section product -->
    </Layout>
</template>
