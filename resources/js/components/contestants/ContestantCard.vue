<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    image: string;
    name: string;
    description: string;
    href: string;
}>();
</script>

<template>
    <article class="card-product style-list">
        <div class="card-product-wrapper">
            <Link :href="href" class="product-img">
                <img class="img-product" :src="image" :alt="name" />
            </Link>
        </div>

        <div class="card-product-info">
            <Link :href="href" class="title link">{{ name }}</Link>
            <p class="description text-line-clamp-2 text-secondary">
                {{ description }}
            </p>

            <div class="variant-wrap-list">
                <div class="list-product-btn">
                    <Link :href="href" class="btn-main-product"
                        >View Profile</Link
                    >
                    <Link
                        :href="href"
                        class="box-icon quickview tf-btn-loading"
                    >
                        <span class="icon icon-eye"></span>
                        <span class="tooltip">Quick View</span>
                    </Link>
                </div>
            </div>
        </div>
    </article>
</template>
