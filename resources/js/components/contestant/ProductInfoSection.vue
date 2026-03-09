<script setup lang="ts">
import type { ModalContestant } from '@/composables/useGlobalModals';

defineOptions({ inheritAttrs: false });

defineProps<{
    contestant: ModalContestant;
    compareAtPrice: string;
    colorOptions: Array<{ id: string; label: string; swatchClass: string; price: number }>;
    sizeOptions: readonly string[];
    basePrice: number;
    stockLabel: string;
}>();
</script>

<template>
    <!-- tf-product-info-list -->
    <div class="col-md-6">
        <div class="tf-product-info-wrap position-relative">
            <div class="tf-zoom-main"></div>
            <div class="tf-product-info-list other-image-zoom">
                <div class="tf-product-info-heading">
                    <div class="tf-product-info-name">
                        <div class="text text-btn-uppercase">{{ contestant.brand }}</div>
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
                                <div class="text text-caption-1">18 sold in last 32 hours</div>
                            </div>
                        </div>
                    </div>
                    <div class="tf-product-info-desc">
                        <div class="tf-product-info-price">
                            <h5 class="price-on-sale font-2">{{ contestant.price }}</h5>
                            <div class="compare-at-price font-2">{{ compareAtPrice }}</div>
                            <div v-if="contestant.oldPrice" class="badges-on-sale text-btn-uppercase">-25%</div>
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
                            Colors:
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
                        <div class="title mb_12">Quantity:</div>
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
                                <span>Add to cart -&nbsp;</span>
                                <span class="tf-qty-price total-price">{{ contestant.price }}</span>
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
                        <a href="#" class="btn-style-3 text-btn-uppercase">Buy it now</a>
                    </div>

                    <div class="tf-product-info-help">
                        <div class="tf-product-info-extra-link">
                            <a href="#delivery_return" data-bs-toggle="modal" class="tf-product-extra-icon">
                                <div class="icon"><i class="icon-shipping"></i></div>
                                <p class="text-caption-1">Delivery & Return</p>
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
                                Estimated Delivery: <span>12-26 days</span> (International), <span>3-6 days</span>
                                (United States)
                            </p>
                        </div>
                        <div class="tf-product-info-return">
                            <div class="icon"><i class="icon-arrowClockwise"></i></div>
                            <p class="text-caption-1">
                                Return within <span>45 days</span> of purchase. Duties & taxes are non-refundable.
                            </p>
                        </div>
                    </div>

                    <ul class="tf-product-info-sku">
                        <li>
                            <p class="text-caption-1">SKU:</p>
                            <p class="text-caption-1 text-1">{{ contestant.id }}</p>
                        </li>
                        <li>
                            <p class="text-caption-1">Vendor:</p>
                            <p class="text-caption-1 text-1">{{ contestant.brand }}</p>
                        </li>
                        <li>
                            <p class="text-caption-1">Available:</p>
                            <p class="text-caption-1 text-1">{{ stockLabel }}</p>
                        </li>
                        <li>
                            <p class="text-caption-1">Categories:</p>
                            <p class="text-caption-1">
                                <a href="#" class="text-1 link">Contest</a>,
                                <a href="#" class="text-1 link">Nominee</a>,
                                <a href="#" class="text-1 link">{{ contestant.slug }}</a>
                            </p>
                        </li>
                    </ul>

                    <div class="tf-product-info-guranteed">
                        <div class="text-title">Guranteed safe checkout:</div>
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
