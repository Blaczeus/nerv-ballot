<script setup lang="ts">
import { computed } from 'vue';
import type { Testimonial } from '@/data/testimonials';

const props = defineProps<{
    testimonial: Testimonial;
}>();

const ratingStars = computed(() => Array.from({ length: props.testimonial.rating }));
</script>

<template>
    <div class="testimonial-item style-4">
        <div class="content-top">
            <div class="box-icon">
                <i class="icon icon-quote"></i>
            </div>
            <div class="text-title">{{ testimonial.title }}</div>
            <p class="text-secondary">
                "{{ testimonial.quote }}"
            </p>
            <div class="box-rate-author">
                <div class="box-author">
                    <div class="text-title author">{{ testimonial.author }}</div>
                </div>
                <div class="list-star-default color-primary">
                    <i
                        v-for="(_, index) in ratingStars"
                        :key="`${testimonial.id}-star-${index}`"
                        class="icon icon-star"
                    ></i>
                </div>
            </div>
        </div>
    </div>
</template>
