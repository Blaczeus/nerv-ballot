<script setup lang="ts">
import CartModal from '@/components/modals/CartModal.vue';
import FilterModal from '@/components/modals/FilterModal.vue';
import QuickViewModal from '@/components/modals/QuickViewModal.vue';
import type { ModalContestant } from '@/composables/useGlobalModals';

defineOptions({ inheritAttrs: false });

defineProps<{
    modalContestant: ModalContestant | null;
    shareLink: string;
}>();

defineEmits<{
    copyShareLink: [];
}>();
</script>

<template>
    <QuickViewModal :contestant="modalContestant" />
    <CartModal :contestant="modalContestant" />
    <FilterModal />

    <!-- modal ask_question -->
    <div class="modal modalCentered fade tf-product-modal modal-part-content" id="ask_question">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="header">
                    <div class="demo-title">Ask a question</div>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <div class="overflow-y-auto">
                    <form @submit.prevent>
                        <fieldset>
                            <label>Name *</label>
                            <input type="text" required />
                        </fieldset>
                        <fieldset>
                            <label>Email *</label>
                            <input type="email" required />
                        </fieldset>
                        <fieldset>
                            <label>Phone number</label>
                            <input type="number" />
                        </fieldset>
                        <fieldset>
                            <label>Message</label>
                            <textarea name="message" rows="4" required></textarea>
                        </fieldset>
                        <button type="submit" class="btn-style-2 w-100"><span class="text">Send</span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /modal ask_question -->

    <!-- modal delivery_return -->
    <div class="modal modalCentered fade tf-product-modal modal-part-content" id="delivery_return">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="header">
                    <div class="demo-title">Shipping & Delivery</div>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <div class="overflow-y-auto">
                    <div class="tf-product-popup-delivery">
                        <div class="title">Delivery</div>
                        <p class="text-paragraph">All orders shipped with express partners.</p>
                        <p class="text-paragraph">Always free shipping for orders over US $250.</p>
                    </div>
                    <div class="tf-product-popup-delivery">
                        <div class="title">Returns</div>
                        <p class="text-paragraph">Items returned within 14 days are eligible for full refund or store credit.</p>
                        <p class="text-paragraph">Shipping and handling from original purchase is non-refundable.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /modal delivery_return -->

    <!-- modal share social -->
    <div class="modal modalCentered fade tf-product-modal modal-part-content" id="share_social">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="header">
                    <div class="demo-title">Share</div>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <div class="overflow-y-auto">
                    <ul class="tf-social-icon d-flex gap-10">
                        <li><a href="#" class="box-icon social-facebook bg_line"><i class="icon icon-fb"></i></a></li>
                        <li><a href="#" class="box-icon social-twiter bg_line"><i class="icon icon-x"></i></a></li>
                        <li><a href="#" class="box-icon social-instagram bg_line"><i class="icon icon-instagram"></i></a></li>
                        <li><a href="#" class="box-icon social-tiktok bg_line"><i class="icon icon-tiktok"></i></a></li>
                        <li><a href="#" class="box-icon social-pinterest bg_line"><i class="icon icon-pinterest"></i></a></li>
                    </ul>
                    <form class="form-share" method="post" accept-charset="utf-8" @submit.prevent>
                        <fieldset>
                            <input :value="shareLink" type="text" tabindex="0" aria-required="true" readonly />
                        </fieldset>
                        <div class="button-submit">
                            <button class="tf-btn radius-4 btn-fill" type="button" @click="$emit('copyShareLink')">
                                <span class="text">Copy</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /modal share social -->
</template>
