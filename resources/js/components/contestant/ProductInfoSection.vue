<script setup lang="ts">
import { computed } from 'vue';
import type { ModalContestant } from '@/composables/useGlobalModals';

defineOptions({ inheritAttrs: false });

const props = defineProps<{
    contestant: ModalContestant;
    colorOptions: Array<{ id: string; label: string; swatchClass: string; price: number }>;
    sizeOptions: readonly string[];
    basePrice: number;
}>();

const voteFormatter = new Intl.NumberFormat('en-US');
const formattedVotes = computed(() => voteFormatter.format(props.contestant.votes));
</script>

<template>
    <!-- tf-product-info-list -->
    <div class="col-md-6">
        <div class="tf-product-info-wrap position-relative">
            <div class="tf-zoom-main"></div>
            <div class="tf-product-info-list other-image-zoom">
                <div class="tf-product-info-heading">
                    <div class="tf-product-info-name">
                        <div class="text text-btn-uppercase">{{ contestant.contestName }}</div>
                        <h3 class="name">{{ contestant.name }}</h3>
                        <div class="sub">
                            <div class="tf-product-info-rate">
                                <div class="list-star">
                                    <i class="icon icon-star"></i>
                                    <i class="icon icon-star"></i>
                                    <i class="icon icon-star"></i>
                                    <i class="icon icon-star"></i>
                                    <i class="icon icon-star"></i>
                                </div>
                                <div class="text text-caption-1">(134 reviews)</div>
                            </div>
                            <div class="tf-product-info-sold">
                                <i class="icon icon-lightning"></i>
                                <div class="text text-caption-1">18 votes in last 32 hours</div>
                            </div>
                        </div>
                    </div>
                    <div class="tf-product-info-desc">
                        <div class="tf-product-info-price">
                            <h5 class="price-on-sale font-2">{{ formattedVotes }} Votes</h5>
                            <div class="compare-at-price font-2">Vote Cost: {{ formattedVotes }}</div>
                        </div>
                        <p>{{ contestant.description }}</p>
                        <div class="tf-product-info-liveview">
                            <i class="icon icon-eye"></i>
                            <p class="text-caption-1">
                                <span class="liveview-count">28</span> people are viewing this right now
                            </p>
                        </div>
                    </div>
                </div>

                <div class="tf-product-info-choose-option">
                    <div class="variant-picker-item">
                        <div class="variant-picker-label mb_12">
                            Vote Options:
                            <span class="text-title variant-picker-label-value value-currentColor">
                                {{ colorOptions[0].label }}
                            </span>
                        </div>
                        <div class="variant-picker-values">
                            <template v-for="(color, colorIndex) in colorOptions" :key="color.id">
                                <input :id="`values-${color.id}`" type="radio" name="color1" :checked="colorIndex === 0" />
                                <label
                                    :class="['hover-tooltip tooltip-bot radius-60 color-btn', { active: colorIndex === 0 }]"
                                    :for="`values-${color.id}`"
                                    :data-value="color.label"
                                    :data-price="color.price"
                                    :data-color="color.id"
                                >
                                    <span :class="['btn-checkbox', color.swatchClass]"></span>
                                    <span class="tooltip">{{ color.label }}</span>
                                </label>
                            </template>
                        </div>
                    </div>

                    <div class="variant-picker-item">
                        <div class="d-flex justify-content-between mb_12">
                            <div class="variant-picker-label">
                                Size:<span class="text-title variant-picker-label-value">M</span>
                            </div>
                            <a href="#size-guide" data-bs-toggle="modal" class="size-guide text-title link">Size Guide</a>
                        </div>
                        <div class="variant-picker-values gap12">
                            <template v-for="size in sizeOptions" :key="size">
                                <input :id="`values-${size.toLowerCase()}`" type="radio" name="size1" :checked="size === 'M'" />
                                <label
                                    :for="`values-${size.toLowerCase()}`"
                                    :class="[
                                        'style-text size-btn',
                                        { active: size === 'M', 'type-disable': size === 'XXL' },
                                    ]"
                                    :data-value="size"
                                    :data-price="basePrice.toFixed(2)"
                                >
                                    <span class="text-title">{{ size }}</span>
                                </label>
                            </template>
                        </div>
                    </div>

                    <div class="tf-product-info-quantity">
                        <div class="title mb_12">Number of Votes:</div>
                        <div class="wg-quantity">
                            <span class="btn-quantity btn-decrease">-</span>
                            <input class="quantity-product" type="text" name="number" value="1" />
                            <span class="btn-quantity btn-increase">+</span>
                        </div>
                    </div>

                    <div>
                        <div class="tf-product-info-by-btn mb_10">
                            <a
                                href="#shoppingCart"
                                data-bs-toggle="modal"
                                class="btn-style-2 grow text-btn-uppercase fw-6 btn-add-to-cart"
                            >
                                <span>Add votes -&nbsp;</span>
                                <span class="tf-qty-price total-price">{{ formattedVotes }}</span>
                            </a>
                            <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon hover-tooltip compare btn-icon-action">
                                <span class="icon icon-gitDiff"></span>
                                <span class="tooltip text-caption-2">Compare</span>
                            </a>
                            <a href="javascript:void(0);" class="box-icon hover-tooltip text-caption-2 wishlist btn-icon-action">
                                <span class="icon icon-heart"></span>
                                <span class="tooltip text-caption-2">Wishlist</span>
                            </a>
                        </div>
                        <a href="#" class="btn-style-3 text-btn-uppercase">Vote now</a>
                    </div>

                    <div class="tf-product-info-help">
                        <div class="tf-product-info-extra-link">
                            <a href="#" class="tf-product-extra-icon">
                                <div class="icon"><i class="icon-shipping"></i></div>
                                <p class="text-caption-1">Voting Info</p>
                            </a>
                            <a href="#ask_question" data-bs-toggle="modal" class="tf-product-extra-icon">
                                <div class="icon"><i class="icon-question"></i></div>
                                <p class="text-caption-1">Ask A Question</p>
                            </a>
                            <a href="#share_social" data-bs-toggle="modal" class="tf-product-extra-icon">
                                <div class="icon"><i class="icon-share"></i></div>
                                <p class="text-caption-1">Share</p>
                            </a>
                        </div>
                        <div class="tf-product-info-time">
                            <div class="icon"><i class="icon-timer"></i></div>
                            <p class="text-caption-1">
                                Estimated Vote Processing: <span>Instant</span> (Online), <span>Same day</span>
                                (Verification)
                            </p>
                        </div>
                        <div class="tf-product-info-return">
                            <div class="icon"><i class="icon-arrowClockwise"></i></div>
                            <p class="text-caption-1">
                                Votes are final once submitted. Please review your selections before confirming.
                            </p>
                        </div>
                    </div>

                    <ul class="tf-product-info-sku">
                        <li>
                            <p class="text-caption-1">Contestant ID:</p>
                            <p class="text-caption-1 text-1">{{ contestant.id }}</p>
                        </li>
                        <li>
                            <p class="text-caption-1">Contest:</p>
                            <p class="text-caption-1 text-1">{{ contestant.contestName }}</p>
                        </li>
                        <li>
                            <p class="text-caption-1">Category:</p>
                            <p class="text-caption-1 text-1">{{ contestant.category }}</p>
                        </li>
                        <li>
                            <p class="text-caption-1">Location:</p>
                            <p class="text-caption-1 text-1">{{ contestant.location }}</p>
                        </li>
                    </ul>

                    <div class="tf-product-info-guranteed">
                        <div class="text-title">Secure vote checkout:</div>
                        <div class="tf-payment">
                            <a href="#"><img src="/tmp/images/payment/img-1.png" alt="payment-1" /></a>
                            <a href="#"><img src="/tmp/images/payment/img-2.png" alt="payment-2" /></a>
                            <a href="#"><img src="/tmp/images/payment/img-3.png" alt="payment-3" /></a>
                            <a href="#"><img src="/tmp/images/payment/img-4.png" alt="payment-4" /></a>
                            <a href="#"><img src="/tmp/images/payment/img-5.png" alt="payment-5" /></a>
                            <a href="#"><img src="/tmp/images/payment/img-6.png" alt="payment-6" /></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /tf-product-info-list -->
</template>
