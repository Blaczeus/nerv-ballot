<script setup lang="ts">
import { computed } from 'vue';

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

const props = withDefaults(defineProps<{
    links: PaginationLink[];
    centered?: boolean;
}>(), {
    centered: true,
});

const emit = defineEmits<{
    (event: 'navigate', url: string): void;
}>();

const normalizeLabel = (label: string) => {
    const plainLabel = label.replace(/&laquo;|&raquo;|&amp;laquo;|&amp;raquo;/g, '').trim().toLowerCase();

    if (plainLabel === 'previous') {
        return '<i class="icon-arrLeft"></i>';
    }

    if (plainLabel === 'next') {
        return '<i class="icon-arrRight"></i>';
    }

    return label;
};

const visibleLinks = computed(() => {
    return props.links.map((link) => ({
        ...link,
        displayLabel: normalizeLabel(link.label),
    }));
});

const handleNavigate = (url: string | null) => {
    if (!url) return;
    emit('navigate', url);
};
</script>

<template>
    <ul class="wg-pagination" :class="{ 'justify-content-center': centered }">
        <li
            v-for="link in visibleLinks"
            :key="`${link.label}-${link.url ?? 'current'}`"
            :class="{ active: link.active }"
        >
            <div
                v-if="link.active"
                class="pagination-item text-button"
                v-html="link.displayLabel"
            />
            <a
                v-else-if="link.url"
                :href="link.url"
                class="pagination-item text-button"
                @click.prevent="handleNavigate(link.url)"
                v-html="link.displayLabel"
            />
            <div
                v-else
                class="pagination-item text-button"
                v-html="link.displayLabel"
            />
        </li>
    </ul>
</template>
