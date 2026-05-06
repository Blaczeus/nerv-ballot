<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import HomeDiscoveryCard from '@/components/contestants/HomeDiscoveryCard.vue';
import { useGlobalModals } from '@/composables/useGlobalModals';
import type { ModalContestant } from '@/composables/useGlobalModals';
import { useVoteCart } from '@/composables/useVoteCart';
import Layout from '@/layouts/Layout.vue';

type FeaturedContest = {
    id: number;
    name: string;
    description: string | null;
    end_date: string | null;
};

type CategorySummary = {
    category: string;
    total: number;
};

type BannerContest = {
    id: number;
    name: string;
    slug: string;
    description: string | null;
    end_date: string | null;
    status_label: string;
    countdown_seconds: number;
};

type HomeContestant = {
    id: number;
    name: string;
    slug: string;
    image: string;
    hoverImage?: string;
    votes: number;
    contest_id: number;
    contest_status: 'active' | 'upcoming' | 'ended' | null;
    contestName: string;
    category: string;
    location: string;
    gender: string;
    contestStart: string;
    contestEnd: string;
    createdAt: string;
    description: string;
};

type DiscoveryTab = 'trending' | 'topRanked' | 'recent';

const props = defineProps<{
    featuredContest: FeaturedContest | null;
    featuredContests: BannerContest[];
    countdownContest: BannerContest | null;
    categories: CategorySummary[];
    trending: HomeContestant[];
    topRanked: HomeContestant[];
    recent: HomeContestant[];
}>();

const { openQuickView, openCart } = useGlobalModals();
const { addVotes } = useVoteCart();
const activeTab = ref<DiscoveryTab>('trending');
const discoveryTabs: Array<{ key: DiscoveryTab; label: string }> = [
    { key: 'trending', label: 'Trending Contestants' },
    { key: 'topRanked', label: 'Top Ranked' },
    { key: 'recent', label: 'Recently Added' },
];
const categoryImages = [
    '/tmp/images/collections/collection-circle/cls-circle1.jpg',
    '/tmp/images/collections/collection-circle/cls-circle2.jpg',
    '/tmp/images/collections/collection-circle/cls-circle3.jpg',
    '/tmp/images/collections/collection-circle/cls-circle4.jpg',
    '/tmp/images/collections/collection-circle/cls-circle5.jpg',
];
const featuredContestDescription = computed(() => {
    const description = props.featuredContest?.description?.trim();

    if (!description) {
        return 'Discover exciting competitions happening around you. Support your favorite contestants and help decide the winners.';
    }

    return description.length > 140 ? `${description.slice(0, 137).trim()}...` : description;
});
const featuredContestEndDate = computed(() => {
    const endDate = props.featuredContest?.end_date;

    if (!endDate) {
        return null;
    }

    const parsed = new Date(endDate);

    if (Number.isNaN(parsed.getTime())) {
        return null;
    }

    return `Ends ${new Intl.DateTimeFormat('en-US', {
        month: 'short',
        day: 'numeric',
    }).format(parsed)}`;
});
const resolveCategoryImage = (index: number) => categoryImages[index % categoryImages.length];
const categoryHref = (category: string) => `/contestants?category=${encodeURIComponent(category)}`;
const categoryCountLabel = (total: number) => `${total} contest${total === 1 ? '' : 's'}`;
const contestHref = (slug: string) => `/contestants?contest=${encodeURIComponent(slug)}`;
const truncateContestDescription = (description: string | null | undefined, fallback: string) => {
    const normalized = description?.trim();

    if (!normalized) {
        return fallback;
    }

    return normalized.length > 140 ? `${normalized.slice(0, 137).trim()}...` : normalized;
};
const bannerFallbackDescriptions = [
    'Support your favorite contestants and help decide the winner before voting closes.',
    'Discover the competition, follow the rankings, and back the contestants you believe in.',
];
const featuredBannerCards = computed(() => props.featuredContests.slice(0, 2));
const countdownDescription = computed(() => {
    if (!props.countdownContest) {
        return 'Voting is heating up across active contests. Support your favorite contestant before time runs out.';
    }

    return `Voting for ${props.countdownContest.name} is ending soon. Support your favorite contestant before time runs out.`;
});
const mapHomeContestant = (contestant: HomeContestant): ModalContestant => ({
    id: contestant.id,
    contestId: contestant.contest_id,
    slug: contestant.slug,
    name: contestant.name,
    contestName: contestant.contestName,
    contestStatus: contestant.contest_status,
    category: contestant.category,
    location: contestant.location,
    gender: contestant.gender,
    votes: contestant.votes,
    contestStart: contestant.contestStart,
    contestEnd: contestant.contestEnd,
    createdAt: contestant.createdAt,
    image: contestant.image,
    hoverImage: contestant.hoverImage ?? contestant.image,
    description: contestant.description,
});
const contestantDiscoverySets = computed<Record<DiscoveryTab, ModalContestant[]>>(() => ({
    trending: props.trending.map(mapHomeContestant),
    topRanked: props.topRanked.map(mapHomeContestant),
    recent: props.recent.map(mapHomeContestant),
}));
const activeContestants = computed(() => contestantDiscoverySets.value[activeTab.value] ?? []);
const setActiveTab = (tab: DiscoveryTab) => {
    activeTab.value = tab;
};
const handleDiscoveryVote = (contestant: ModalContestant) => {
    if (addVotes(contestant.id, 1, contestant)) {
        openCart(contestant);
    }
};
</script>

<template>
    <Head title="Home" />

    <Layout>
    <!-- preload -->
    <!-- <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div> -->
    <!-- /preload -->
     
        <!-- Slider -->
        <section class="tf-slideshow slider-default slider-effect-fade">
            <div dir="ltr" class="swiper tf-sw-slideshow" data-effect="fade" data-preview="1" data-tablet="1" data-mobile="1" data-centered="false" data-space="0" data-space-mb="0" data-loop="true" data-auto-play="true">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="wrap-slider">
                            <img src="/tmp/images/slider/slider-women1.jpg" alt="fashion-slideshow">
                            <div class="box-content">
                                <div class="content-slider">
                                    <div class="box-title-slider">
                                        <p class="fade-item fade-item-1 subheading text-btn-uppercase text-white">FEATURED COMPETITIONS</p>
                                        <div class="fade-item fade-item-2 heading text-white title-display">{{ featuredContest?.name ?? 'Vote. Celebrate. Crown the Winner.' }}</div>
                                        <p class="fade-item fade-item-3 text-white">
                                            {{ featuredContestDescription }}
                                            <span v-if="featuredContestEndDate"> {{ featuredContestEndDate }}</span>
                                        </p>
                                    </div>
                                    <div class="fade-item fade-item-4 box-btn-slider">
                                        <Link :href="featuredContest ? `/contestants?contest_id=${featuredContest.id}` : '/contestants'" class="tf-btn btn-fill btn-white"><span class="text">View Active Contests</span><i class="icon icon-arrowUpRight"></i></Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="wrap-slider">
                            <img src="/tmp/images/slider/slider-women2.jpg" alt="fashion-slideshow">
                            <div class="box-content">
                                <div class="content-slider">
                                    <div class="box-title-slider">
                                        <p class="fade-item fade-item-1 subheading text-btn-uppercase text-white">COMMUNITY VOTING</p>
                                        <div class="fade-item fade-item-2 heading text-white title-display">Every Vote Tells a Story</div>
                                        <p class="fade-item fade-item-3 text-white">From campus competitions to global talent showcases, your vote gives contestants the spotlight they deserve.</p>
                                    </div>
                                    <div class="fade-item fade-item-4 box-btn-slider">
                                        <Link href="/contestants" class="tf-btn btn-fill btn-white"><span class="text">Explore Contestants</span><i class="icon icon-arrowUpRight"></i></Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="wrap-slider">
                            <img src="/tmp/images/slider/slider-fashion-main1.jpg" alt="voting-slideshow">
                            <div class="box-content">
                                <div class="content-slider">
                                    <div class="box-title-slider">
                                        <p class="fade-item fade-item-1 subheading text-btn-uppercase text-white">HOST A CONTEST</p>
                                        <div class="fade-item fade-item-2 heading text-white title-display">Launch Your Own Contest</div>
                                        <p class="fade-item fade-item-3 text-white">Create professional voting competitions for schools, communities, brands, or talent shows with ease.</p>
                                    </div>
                                    <div class="fade-item fade-item-4 box-btn-slider">
                                        <Link href="/about" class="tf-btn btn-fill btn-white"><span class="text">How It Works</span><i class="icon icon-arrowUpRight"></i></Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrap-pagination">
                <div class="container">
                    <div class="sw-dots sw-pagination-slider type-circle white-circle justify-content-center"></div>
                </div>
            </div>
        </section>
        <!-- /Slider -->
        <!-- collection -->
        <section class="flat-spacing-2 pb_0">
            <div class="container">
                <div class="heading-section-2 wow fadeInUp">
                    <h3>Contest Categories</h3>
                    <Link href="/contestants" class="btn-line">View All Contests</Link>
                </div>
                <div class="flat-collection-circle wow fadeInUp" data-wow-delay="0.1s">
                    <div dir="ltr" class="swiper tf-sw-collection" data-preview="5" data-tablet="3" data-mobile="2" data-space-lg="20" data-space-md="20" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
                        <div class="swiper-wrapper">
                            <div v-for="(category, index) in categories" :key="category.category" class="swiper-slide">
                                <div class="collection-circle hover-img">
                                    <Link :href="categoryHref(category.category)" class="img-style">
                                        <img class="lazyload" :data-src="resolveCategoryImage(index)" :src="resolveCategoryImage(index)" alt="collection-img">
                                    </Link>
                                    <div class="collection-content text-center">
                                        <div>
                                            <Link :href="categoryHref(category.category)" class="cls-title">
                                                <h6 class="text">{{ category.category }}</h6>
                                                <i class="icon icon-arrowUpRight"></i>    
                                            </Link>
                                        </div>
                                        <div class="count text-secondary">{{ categoryCountLabel(category.total) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex d-lg-none sw-pagination-collection sw-dots type-circle justify-content-center"></div>
                    </div>
                    <div class="nav-prev-collection d-none d-lg-flex nav-sw style-line nav-sw-left"><i class="icon icon-arrLeft"></i></div>
                    <div class="nav-next-collection d-none d-lg-flex nav-sw style-line nav-sw-right"><i class="icon icon-arrRight"></i></div>
                </div>
            </div>
        </section>
        <!-- /collection -->
        <!-- Seller -->
        <section class="flat-spacing-3">
            <div class="container">
                <div class="flat-animate-tab">
                    <ul class="tab-product justify-content-sm-center" role="tablist">
                        <li v-for="tab in discoveryTabs" :key="tab.key" class="nav-tab-item" role="presentation">
                            <a
                                href="#"
                                :class="{ active: activeTab === tab.key }"
                                @click.prevent="setActiveTab(tab.key)"
                            >
                                {{ tab.label }}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active show" role="tabpanel">
                            <div class="tf-grid-layout tf-col-2 lg-col-3 xl-col-5">
                                <HomeDiscoveryCard
                                    v-for="(contestant, index) in activeContestants"
                                    :key="`${activeTab}-${contestant.id}`"
                                    :contestant="contestant"
                                    class="wow fadeInUp"
                                    :style="{ 'animation-delay': `${index * 0.1}s` }"
                                    @quick-view="openQuickView"
                                    @add-to-cart="handleDiscoveryVote"
                                />
                            </div>
                            <div v-if="activeContestants.length === 0" class="text-center py-10">
                                No contestants available in this section yet.
                            </div>
                            <div class="sec-btn text-center">
                                <Link href="/contestants" class="btn-line">View All Contestants</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Seller -->
        <!-- Banner collection -->
        <section class="flat-spacing pt-0">
            <div class="container">
                <div class="tf-grid-layout md-col-2">
                    <div
                        v-for="(contest, index) in featuredBannerCards"
                        :key="contest.id"
                        :class="[index === 0 ? 'collection-default' : 'collection-position', 'hover-img']"
                    >
                        <Link :href="contestHref(contest.slug)" class="img-style">
                            <img
                                class="lazyload"
                                :data-src="index === 0 ? '/tmp/images/collections/banner-collection/banner-cls1.jpg' : '/tmp/images/collections/banner-collection/banner-cls2.jpg'"
                                :src="index === 0 ? '/tmp/images/collections/banner-collection/banner-cls1.jpg' : '/tmp/images/collections/banner-collection/banner-cls2.jpg'"
                                alt="banner-cls"
                            >
                        </Link>
                        <div class="content">
                            <h3 :class="['title', { 'wow fadeInUp': index === 0 }]">
                                <Link :href="contestHref(contest.slug)" :class="['link', index === 1 ? 'text-white wow fadeInUp' : '']">
                                    {{ contest.name }}
                                </Link>
                            </h3>
                            <p :class="['desc', index === 1 ? 'text-white wow fadeInUp' : 'wow fadeInUp']">
                                {{ truncateContestDescription(contest.description, bannerFallbackDescriptions[index] ?? bannerFallbackDescriptions[0]) }}
                            </p>
                            <p :class="['text-btn-uppercase mb_12', index === 1 ? 'text-white wow fadeInUp' : 'wow fadeInUp']">
                                {{ contest.status_label }}
                            </p>
                            <div class="wow fadeInUp">
                                <Link :href="contestHref(contest.slug)" :class="index === 0 ? 'btn-line' : 'btn-line style-white'">
                                    {{ index === 0 ? 'Vote Now' : 'Explore Contest' }}
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Banner collection -->
        <!-- Banner countdown -->
        <section class="bg-surface flat-spacing flat-countdown-banner">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="banner-left">
                            <div class="box-title">
                                <h3 class="wow fadeInUp">Voting Ends Soon</h3>
                                <p class="text-secondary wow fadeInUp">{{ countdownDescription }}</p>
                            </div>
                            <div class="btn-banner wow fadeInUp">
                                <Link :href="props.countdownContest ? contestHref(props.countdownContest.slug) : '/contestants'" class="tf-btn btn-fill"><span class="text">Cast Your Vote</span><i class="icon icon-arrowUpRight"></i></Link>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="banner-img">
                            <img class="lazyload" data-src="/tmp/images/banner/img-countdown1.png" src="/tmp/images/banner/img-countdown1.png" alt="banner">
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="banner-right">
                            <div class="tf-countdown-lg">
                                <div class="js-countdown" :data-timer="props.countdownContest?.countdown_seconds ?? 0" data-labels="Days,Hours,Mins,Secs"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Banner countdown -->
        <!-- Testimonial -->
        <section class="flat-spacing">
            <div class="container">
                <div class="heading-section text-center">
                    <h3 class="heading wow fadeInUp">Success Stories</h3>
                    <p class="subheading wow fadeInUp">Organizers and communities share how their contests grew with this platform.</p>
                </div>
                <div dir="ltr" class="swiper tf-sw-testimonial" data-preview="2" data-tablet="1.3" data-mobile="1" data-space-lg="30" data-space-md="30" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testimonial-item hover-img">
                                <div class="img-style">
                                    <img data-src="/tmp/images/testimonial/tes-1.jpg" src="/tmp/images/testimonial/tes-1.jpg" alt="img-testimonial">
                                </div>
                                <div class="content">
                                    <div class="content-top">
                                        <div class="list-star-default">
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                        </div>
                                        <p class="text-secondary">"This platform gave our team a reliable way to manage nominations, publish contestants, and keep the voting experience smooth from start to finish."</p>
                                        <div class="box-author">
                                            <div class="text-title author">Sybil Sharp</div>
                                            <svg class="icon" width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_15758_14563)">
                                                <path d="M6.875 11.6255L8.75 13.5005L13.125 9.12549" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M10 18.5005C14.1421 18.5005 17.5 15.1426 17.5 11.0005C17.5 6.85835 14.1421 3.50049 10 3.50049C5.85786 3.50049 2.5 6.85835 2.5 11.0005C2.5 15.1426 5.85786 18.5005 10 18.5005Z" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </g>
                                                <defs>
                                                <clipPath id="clip0_15758_14563">
                                                <rect width="20" height="20" fill="white" transform="translate(0 0.684082)"/>
                                                </clipPath>
                                                </defs>
                                            </svg> 
                                        </div>
                                    </div>
                                    <div class="box-avt">
                                        <div class="avatar avt-60 round">
                                            <img src="/tmp/images/avatar/user-4.jpg" alt="avt">
                                        </div>
                                        <div class="box-price">
                                            <p class="text-title text-line-clamp-1">University Event Coordinator</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-item hover-img">
                                <div class="img-style">
                                    <img data-src="/tmp/images/testimonial/tes-2.jpg" src="/tmp/images/testimonial/tes-2.jpg" alt="img-testimonial">
                                </div>
                                <div class="content">
                                    <div class="content-top">
                                        <div class="list-star-default">
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                        </div>
                                        <p class="text-secondary">"We needed a voting platform that looked professional, handled traffic well, and made it easy for supporters to participate without confusion."</p>
                                        <div class="box-author">
                                            <div class="text-title author">Mark G.</div>
                                            <svg class="icon" width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_15758)">
                                                <path d="M6.875 11.6255L8.75 13.5005L13.125 9.12549" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M10 18.5005C14.1421 18.5005 17.5 15.1426 17.5 11.0005C17.5 6.85835 14.1421 3.50049 10 3.50049C5.85786 3.50049 2.5 6.85835 2.5 11.0005C2.5 15.1426 5.85786 18.5005 10 18.5005Z" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </g>
                                                <defs>
                                                <clipPath id="clip0_15758">
                                                <rect width="20" height="20" fill="white" transform="translate(0 0.684082)"/>
                                                </clipPath>
                                                </defs>
                                            </svg> 
                                        </div>
                                    </div>
                                    <div class="box-avt">
                                        <div class="avatar avt-60 round">
                                            <img src="/tmp/images/avatar/user-5.jpg" alt="avt">
                                        </div>
                                        <div class="box-price">
                                            <p class="text-title text-line-clamp-1">Campaign Manager</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-item hover-img">
                                <div class="img-style">
                                    <img data-src="/tmp/images/testimonial/tes-1.jpg" src="/tmp/images/testimonial/tes-1.jpg" alt="img-testimonial">
                                </div>
                                <div class="content">
                                    <div class="content-top">
                                        <div class="list-star-default">
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                        </div>
                                        <p class="text-secondary">"What stood out most was how simple it became to keep contestant information organised while still giving voters a clear and credible experience."</p>
                                        <div class="box-author">
                                            <div class="text-title author">Sybil Sharp</div>
                                            <svg class="icon" width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_15758_14)">
                                                <path d="M6.875 11.6255L8.75 13.5005L13.125 9.12549" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M10 18.5005C14.1421 18.5005 17.5 15.1426 17.5 11.0005C17.5 6.85835 14.1421 3.50049 10 3.50049C5.85786 3.50049 2.5 6.85835 2.5 11.0005C2.5 15.1426 5.85786 18.5005 10 18.5005Z" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </g>
                                                <defs>
                                                <clipPath id="clip0_15758_14">
                                                <rect width="20" height="20" fill="white" transform="translate(0 0.684082)"/>
                                                </clipPath>
                                                </defs>
                                            </svg> 
                                        </div>
                                    </div>
                                    <div class="box-avt">
                                        <div class="avatar avt-60 round">
                                            <img src="/tmp/images/avatar/user-4.jpg" alt="avt">
                                        </div>
                                        <div class="box-price">
                                            <p class="text-title text-line-clamp-1">Programme Lead</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-item hover-img">
                                <div class="img-style">
                                    <img data-src="/tmp/images/testimonial/tes-2.jpg" src="/tmp/images/testimonial/tes-2.jpg" alt="img-testimonial">
                                </div>
                                <div class="content">
                                    <div class="content-top">
                                        <div class="list-star-default">
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                            <i class="icon icon-star"></i>
                                        </div>
                                        <p class="text-secondary">"Launching a public voting campaign felt far less risky because the platform gave us structure, clarity, and a better experience for both organisers and supporters."</p>
                                        <div class="box-author">
                                            <div class="text-title author">Mark G.</div>
                                            <svg class="icon" width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_15758_145)">
                                                <path d="M6.875 11.6255L8.75 13.5005L13.125 9.12549" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M10 18.5005C14.1421 18.5005 17.5 15.1426 17.5 11.0005C17.5 6.85835 14.1421 3.50049 10 3.50049C5.85786 3.50049 2.5 6.85835 2.5 11.0005C2.5 15.1426 5.85786 18.5005 10 18.5005Z" stroke="#3DAB25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </g>
                                                <defs>
                                                <clipPath id="clip0_15758_145">
                                                <rect width="20" height="20" fill="white" transform="translate(0 0.684082)"/>
                                                </clipPath>
                                                </defs>
                                            </svg> 
                                        </div>
                                    </div>
                                    <div class="box-avt">
                                        <div class="avatar avt-60 round">
                                            <img src="/tmp/images/avatar/user-5.jpg" alt="avt">
                                        </div>
                                        <div class="box-price">
                                            <p class="text-title text-line-clamp-1">Community Campaign Director</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sw-pagination-testimonial sw-dots type-circle d-flex justify-content-center"></div>
                </div>
            </div>
        </section>
        <!-- /Testimonial -->
    </Layout>
</template>


