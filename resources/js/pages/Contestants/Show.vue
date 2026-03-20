<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import GallerySection from '@/components/contestant/GallerySection.vue';
import ProductInfoSection from '@/components/contestant/ProductInfoSection.vue';
import ProductModalsSection from '@/components/contestant/ProductModalsSection.vue';
import ProductTabsSection from '@/components/contestant/ProductTabsSection.vue';
import Breadcrumb from '@/components/ui/Breadcrumb.vue';
import { useGlobalModals } from '@/composables/useGlobalModals';
import { contestants } from '@/data/contestants';
import Layout from '@/layouts/Layout.vue';
import { formatVotes } from '@/utils/formatVotes';

type Contestant = (typeof contestants)[number];

type ColorOption = {
    id: string;
    label: string;
    swatchClass: string;
    price: number;
    images: string[];
};

const props = defineProps<{
    slug: string;
}>();

const route = {
    params: {
        slug: props.slug,
    },
};

const fallbackContestant: Contestant = contestants[0] ?? {
    id: 0,
    slug: route.params.slug,
    name: 'Contestant',
    contestName: '',
    category: '',
    location: '',
    gender: '',
    votes: 0,
    contestStart: '',
    contestEnd: '',
    createdAt: '',
    image: '/tmp/images/products/womens/women-19.jpg',
    hoverImage: '/tmp/images/products/womens/women-20.jpg',
    description: '',
};

const contestant = computed<Contestant>(() => {
    return contestants.find((item) => item.slug === route.params.slug) ?? fallbackContestant;
});

const { state: modalState } = useGlobalModals();

const formattedVotes = computed(() => formatVotes(contestant.value.votes));

const basePrice = computed<number>(() => contestant.value.votes);

const shareLink = computed<string>(() => {
    if (typeof window === 'undefined') {
        return `/contestants/${contestant.value.slug}`;
    }

    return `${window.location.origin}/contestants/${contestant.value.slug}`;
});

const colorOptions = computed<ColorOption[]>(() => [
    {
        id: 'beige',
        label: 'Beige',
        swatchClass: 'bg-color-beige1',
        price: basePrice.value,
        images: [
            '/tmp/images/products/womens/women-6.jpg',
            '/tmp/images/products/womens/women-7.jpg',
            '/tmp/images/products/womens/women-8.jpg',
        ],
    },
    {
        id: 'gray',
        label: 'Gray',
        swatchClass: 'bg-color-gray',
        price: basePrice.value,
        images: [
            '/tmp/images/products/womens/women-3.jpg',
            contestant.value.image,
            contestant.value.hoverImage,
            '/tmp/images/products/womens/women-5.jpg',
        ],
    },
    {
        id: 'grey',
        label: 'Grey',
        swatchClass: 'bg-color-grey',
        price: basePrice.value + 10,
        images: [
            '/tmp/images/products/womens/women-23.jpg',
            '/tmp/images/products/womens/women-24.jpg',
            contestant.value.image,
        ],
    },
]);

const sizeOptions = ['S', 'M', 'L', 'XL', 'XXL'] as const;

const gallerySlides = computed<
    Array<{ color: string; label: string; image: string }>
>(() => {
    return colorOptions.value.flatMap((color) =>
        color.images.map((image) => ({
            color: color.id,
            label: color.label,
            image,
        })),
    );
});

const copyShareLink = async () => {
    if (typeof navigator === 'undefined' || !navigator.clipboard) {
        return;
    }

    await navigator.clipboard.writeText(shareLink.value);
};

const breadcrumbItems = computed(() => [
    { label: 'Home', link: '/' },
    { label: 'Contestants', link: '/contestants' },
    { label: contestant.value.name },
]);

const breadcrumbNav = {
    prev: '/contestants',
    back: '/contestants',
    next: '/contestants',
};
</script>

<template>
    <Head :title="contestant.name" />

    <Layout>
        <Breadcrumb :items="breadcrumbItems" :nav="breadcrumbNav" design="text" />

        <!-- tf-add-cart-success -->
        <div class="tf-add-cart-success">
            <div class="tf-add-cart-heading">
                <h5>Vote Cart</h5>
                <i class="icon icon-close tf-add-cart-close"></i>
            </div>
            <p class="text-caption-1 text-secondary-2">10 votes added to your vote cart</p>
            <div class="tf-add-cart-product">
                <div class="image">
                    <img
                        class="lazyload"
                        :data-src="contestant.image"
                        :src="contestant.image"
                        alt="contestant-cart-preview"
                    />
                </div>
                <div class="content">
                    <div class="text-title">
                        <Link class="link" :href="`/contestants/${contestant.slug}`">{{ contestant.name }}</Link>
                    </div>
                    <div class="text-caption-1 text-secondary-2">Contestant Profile</div>
                    <div class="text-title">{{ formattedVotes }}</div>
                </div>
            </div>
            <a href="#shoppingCart" data-bs-toggle="modal" class="tf-btn w-100 btn-fill radius-4">
                <span class="text text-btn-uppercase">View vote cart</span>
            </a>
        </div>
        <!-- /tf-add-cart-success -->

        <!-- Product_Main -->
        <section class="flat-spacing">
            <div class="tf-main-product section-image-zoom">
                <div class="container">
                    <div class="row">
                        <GallerySection :contestant-slug="contestant.slug" :gallery-slides="gallerySlides" />
                        <ProductInfoSection
                            :contestant="contestant"
                            :color-options="colorOptions"
                            :size-options="sizeOptions"
                            :base-price="basePrice"
                        />
                    </div>
                </div>
            </div>
        </section>

        <div class="tf-sticky-btn-atc">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <form class="form-sticky-atc">
                            <div class="tf-sticky-atc-product">
                                <div class="image">
                                    <img class="lazyload" :data-src="contestant.image" :src="contestant.image" alt="sticky-contestant" />
                                </div>
                                <div class="content">
                                    <div class="text-title">{{ contestant.name }}</div>
                                    <div class="text-caption-1 text-secondary-2">{{ contestant.category }} · {{ contestant.location }}</div>
                                    <div class="text-title">{{ formattedVotes }}</div>
                                </div>
                            </div>
                            <div class="tf-sticky-atc-infos">
                                <div class="tf-sticky-atc-size d-flex gap-12 align-items-center">
                                    <div class="tf-sticky-atc-infos-title text-title">Size:</div>
                                    <div class="tf-dropdown-sort style-2" data-bs-toggle="dropdown">
                                        <div class="btn-select">
                                            <span class="text-sort-value font-2">M</span>
                                            <span class="icon icon-arrow-down"></span>
                                        </div>
                                        <div class="dropdown-menu">
                                            <div class="select-item">
                                                <span class="text-value-item">S</span>
                                            </div>
                                            <div class="select-item active">
                                                <span class="text-value-item">M</span>
                                            </div>
                                            <div class="select-item">
                                                <span class="text-value-item">L</span>
                                            </div>
                                            <div class="select-item">
                                                <span class="text-value-item">XL</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tf-sticky-atc-quantity d-flex gap-12 align-items-center">
                                    <div class="tf-sticky-atc-infos-title text-title">Number of Votes:</div>
                                    <div class="wg-quantity style-1">
                                        <span class="btn-quantity minus-btn">-</span>
                                        <input type="text" name="number" value="1" />
                                        <span class="btn-quantity plus-btn">+</span>
                                    </div>
                                </div>
                                <div class="tf-sticky-atc-btns">
                                    <a href="#shoppingCart" data-bs-toggle="modal" class="tf-btn w-100 btn-reset radius-4 btn-add-to-cart">
                                        <span class="text text-btn-uppercase">Add Votes</span>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Product_Main -->

        <ProductTabsSection :contestant="contestant" />

        <template #overlays>
            <ProductModalsSection
                :modal-contestant="modalState.contestant"
                :share-link="shareLink"
                @copy-share-link="copyShareLink"
            />
        </template>
    </Layout>
</template>
