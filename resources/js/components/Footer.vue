<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { useGlobalModals } from '@/composables/useGlobalModals';

const { openAskQuestion } = useGlobalModals();
</script>

<template>
    <footer id="footer" class="footer">
        <div class="footer-wrap">
            <div class="footer-body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="footer-infor">
                                <div class="footer-logo">
                                    <Link href="/">
                                        <img src="/tmp/images/logo/logo.svg" alt="logo" />
                                    </Link>
                                </div>
                            <div class="footer-address">
                                    <p>Discover and vote in live contests. Support your favorite contestants and track results in real time.</p>
                                    <Link href="/contestants" class="tf-btn-default fw-6">Explore Active Contests<i
                                            class="icon-arrowUpRight"></i>
                                    </Link>
                                </div>
                                <ul class="footer-info">
                                    <li>
                                        <i class="icon-mail"></i>
                                        <p>support@nervego.com</p>
                                    </li>
                                    <li>
                                        <i class="icon-phone"></i>
                                        <p>+234 800 000 0000</p>
                                    </li>
                                </ul>
                                <ul class="tf-social-icon">
                                    <li><a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="social-facebook"><i class="icon icon-fb"></i></a></li>
                                    <li><a href="https://x.com" target="_blank" rel="noopener noreferrer" class="social-twiter"><i class="icon icon-x"></i></a></li>
                                    <li><a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="social-instagram"><i class="icon icon-instagram"></i></a>
                                    </li>
                                    <li><a href="https://tiktok.com" target="_blank" rel="noopener noreferrer" class="social-tiktok"><i class="icon icon-tiktok"></i></a></li>
                                    <li><a href="https://amazon.com" target="_blank" rel="noopener noreferrer" class="social-amazon"><i class="icon icon-amazon"></i></a></li>
                                    <li><a href="https://pinterest.com" target="_blank" rel="noopener noreferrer" class="social-pinterest"><i class="icon icon-pinterest"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="footer-menu">
                                <div class="footer-col-block">
                                    <div class="footer-heading text-button footer-heading-mobile">
                                        Platform
                                    </div>
                                    <div class="tf-collapse-content">
                                        <ul class="footer-menu-list">
                                            <li class="text-caption-1">
                                                <Link href="/contestants" class="footer-menu_item">Contestants</Link>
                                            </li>
                                            <li class="text-caption-1">
                                                <Link href="/cart" class="footer-menu_item">Vote Cart</Link>
                                            </li>
                                            <li class="text-caption-1">
                                                <Link href="/leaderboard" class="footer-menu_item">Leaderboard</Link>
                                            </li>
                                            <li class="text-caption-1">
                                                <Link href="/about" class="footer-menu_item">About</Link>
                                            </li>
                                            <li class="text-caption-1">
                                                <a href="javascript:void(0)" class="footer-menu_item" @click.prevent="openAskQuestion">Contact</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="footer-col-block">
                                <div class="footer-heading text-button footer-heading-mobile">
                                    Support
                                </div>
                                <div class="tf-collapse-content">
                                    <ul class="footer-menu-list">
                                        <li class="text-caption-1">
                                            <a href="javascript:void(0)" class="footer-menu_item"
                                                @click.prevent="openAskQuestion">Help / FAQ</a>
                                        </li>
                                        <li class="text-caption-1">
                                            <a href="javascript:void(0)" class="footer-menu_item"
                                                @click.prevent="openAskQuestion">
                                                Ask a Question
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="footer-bottom-wrap justify-content-center">
                                <div class="left text-center">
                                    <p class="text-caption-1">
                                        &copy;2026
                                        <a href="https://nervego.com" target="_blank" rel="noopener noreferrer" class="link">
                                            Nervego
                                        </a>.
                                        All Rights Reserved.
                                    </p>
                                    <div class="tf-cur justify-content-end">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>
