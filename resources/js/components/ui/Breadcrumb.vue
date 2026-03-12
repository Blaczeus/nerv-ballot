<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineOptions({ inheritAttrs: false });

type BreadcrumbItem = {
    label: string;
    link?: string | null;
};

type BreadcrumbNav = {
    prev?: string;
    back?: string;
    next?: string;
};

const props = withDefaults(
    defineProps<{
        items: BreadcrumbItem[];
        design?: 'text' | 'image';
        heading?: string;
        backgroundImage?: string;
        containerClass?: string;
        useRow?: boolean;
        nav?: BreadcrumbNav;
    }>(),
    {
        design: 'text',
        containerClass: 'container',
        useRow: false,
    },
);

const isExternal = (href: string): boolean => /^(https?:)?\/\//.test(href);
const usesAnchorTag = (href: string): boolean =>
    href.startsWith('#') || isExternal(href);
</script>

<template>
    <!-- breadcrumb -->
    <div v-if="props.design === 'text'" class="tf-breadcrumb">
        <div class="container">
            <div class="tf-breadcrumb-wrap">
                <div class="tf-breadcrumb-list">
                    <template v-for="(item, index) in props.items" :key="`${item.label}-${index}`">
                        <i v-if="index > 0" class="icon icon-arrRight"></i>
                        <template v-if="item.link">
                            <component
                                :is="usesAnchorTag(item.link) ? 'a' : Link"
                                :href="item.link"
                                class="text text-caption-1"
                            >
                                {{ item.label }}
                            </component>
                        </template>
                        <span v-else class="text text-caption-1">{{ item.label }}</span>
                    </template>
                </div>
                <div v-if="props.nav" class="tf-breadcrumb-prev-next">
                    <Link v-if="props.nav.prev" :href="props.nav.prev" class="tf-breadcrumb-prev">
                        <i class="icon icon-arrLeft"></i>
                    </Link>
                    <Link v-if="props.nav.back" :href="props.nav.back" class="tf-breadcrumb-back">
                        <i class="icon icon-squares-four"></i>
                    </Link>
                    <Link v-if="props.nav.next" :href="props.nav.next" class="tf-breadcrumb-next">
                        <i class="icon icon-arrRight"></i>
                    </Link>
                </div>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- page-title -->
    <div
        v-else
        class="page-title"
        :style="props.backgroundImage ? { backgroundImage: `url(${props.backgroundImage})` } : undefined"
    >
        <div :class="props.containerClass">
            <div v-if="props.useRow" class="row">
                <div class="col-12">
                    <h3 class="heading text-center">{{ props.heading ?? props.items[props.items.length - 1]?.label }}</h3>
                    <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                        <template v-for="(item, index) in props.items" :key="`${item.label}-${index}`">
                            <li v-if="item.link">
                                <component :is="usesAnchorTag(item.link) ? 'a' : Link" :href="item.link" class="link">
                                    {{ item.label }}
                                </component>
                            </li>
                            <li v-else>{{ item.label }}</li>
                            <li v-if="index < props.items.length - 1">
                                <i class="icon-arrRight"></i>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
            <template v-else>
                <h3 class="heading text-center">{{ props.heading ?? props.items[props.items.length - 1]?.label }}</h3>
                <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                    <template v-for="(item, index) in props.items" :key="`${item.label}-${index}`">
                        <li v-if="item.link">
                            <component :is="usesAnchorTag(item.link) ? 'a' : Link" :href="item.link" class="link">
                                {{ item.label }}
                            </component>
                        </li>
                        <li v-else>{{ item.label }}</li>
                        <li v-if="index < props.items.length - 1">
                            <i class="icon-arrRight"></i>
                        </li>
                    </template>
                </ul>
            </template>
        </div>
    </div>
    <!-- /page-title -->
</template>
