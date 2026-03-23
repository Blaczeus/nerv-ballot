<script setup lang="ts">
import { computed } from 'vue';
import { useGlobalModals } from '@/composables/useGlobalModals';

defineOptions({ inheritAttrs: false });

const { state, closeModal } = useGlobalModals();

const contestant = computed(() => state.contestant);
const isOpen = computed(() => state.activeModal === 'share');
const shareLink = computed(() => {
    const slug = contestant.value?.slug;
    if (!slug) return '/contestants';
    if (typeof window === 'undefined') return `/contestants/${slug}`;
    return `${window.location.origin}/contestants/${slug}`;
});

const encodedShareLink = computed(() => encodeURIComponent(shareLink.value));
const encodedShareText = computed(() =>
    encodeURIComponent(
        contestant.value
            ? `Check out ${contestant.value.name} in ${contestant.value.contestName}.`
            : 'Check out this contestant profile.',
    ),
);

const socialLinks = computed(() => [
    {
        name: 'Facebook',
        icon: 'icon-fb',
        href: `https://www.facebook.com/sharer/sharer.php?u=${encodedShareLink.value}`,
    },
    {
        name: 'X',
        icon: 'icon-x',
        href: `https://twitter.com/intent/tweet?url=${encodedShareLink.value}&text=${encodedShareText.value}`,
    },
    {
        name: 'Instagram',
        icon: 'icon-instagram',
        href: shareLink.value,
    },
]);

const copyShareLink = async () => {
    if (typeof navigator === 'undefined' || !navigator.clipboard) return;
    await navigator.clipboard.writeText(shareLink.value);
};
</script>

<template>
    <div
        v-if="isOpen"
        class="modal modalCentered fade show tf-product-modal modal-part-content"
        id="share_social"
        style="display: block;"
        @click.self="closeModal('share')"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="header">
                    <div class="demo-title">Share contestant profile</div>
                    <span class="icon-close icon-close-popup" @click="closeModal('share')"></span>
                </div>
                <div class="overflow-y-auto">
                    <ul class="tf-social-icon d-flex gap-10">
                        <li v-for="socialLink in socialLinks" :key="socialLink.name">
                            <a
                                :href="socialLink.href"
                                class="box-icon bg_line"
                                target="_blank"
                                rel="noreferrer"
                            >
                                <i class="icon" :class="socialLink.icon"></i>
                            </a>
                        </li>
                    </ul>
                    <form class="form-share" method="post" accept-charset="utf-8" @submit.prevent>
                        <fieldset>
                            <input
                                :value="shareLink"
                                type="text"
                                tabindex="0"
                                aria-required="true"
                                readonly
                            />
                        </fieldset>
                        <div class="button-submit">
                            <button class="tf-btn radius-4 btn-fill" type="button" @click="copyShareLink">
                                <span class="text">Copy</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.tf-social-icon .box-icon .icon {
    color: var(--main);
}
</style>
