<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import type { ResolvedNavItem } from '@/config/navigation';

defineProps<{
    items: ResolvedNavItem[];
}>();

const isExternal = (item: ResolvedNavItem): boolean => item.external === true;
const usesAnchorTag = (item: ResolvedNavItem): boolean =>
    isExternal(item) || item.href.startsWith('#');
const getTarget = (item: ResolvedNavItem): string | undefined =>
    isExternal(item) ? '_blank' : undefined;
const getRel = (item: ResolvedNavItem): string | undefined =>
    isExternal(item) ? 'noopener noreferrer' : undefined;
</script>

<template>
    <div class="tf-topbar bg-main">
        <div class="container">
            <div class="tf-topbar_wrap d-flex align-items-center justify-content-center justify-content-xl-between">
                <ul class="topbar-left">
                    <li>
                        <a class="text-caption-1 text-white" href="#">support@nervego.com</a>
                    </li>
                </ul>
                <div class="topbar-right d-none d-xl-block">
                    <div class="tf-collapse-content">
                        <ul class="tf-social-icon style-white">
                            <li><a href="#" class="social-facebook"><i class="icon icon-fb"></i></a></li>
                            <li><a href="#" class="social-twiter"><i class="icon icon-x"></i></a></li>
                            <li><a href="#" class="social-instagram"><i class="icon icon-instagram"></i></a></li>
                            <li><a href="#" class="social-tiktok"><i class="icon icon-tiktok"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <header id="header" class="header-default">
        <div class="container">
            <div class="row wrapper-header align-items-center">
                <div class="col-md-4 d-xl-none col-3">
                    <a href="#mobileMenu" class="mobile-menu" data-bs-toggle="offcanvas" aria-controls="mobileMenu">
                        <i class="icon icon-categories"></i>
                    </a>
                </div>
                <div class="col-xl-3 col-md-4 col-6">
                    <Link href="/" class="logo-header">
                        <img src="/tmp/images/logo/logo.svg" alt="logo" class="logo" />
                    </Link>
                </div>
                <div class="col-xl-6 d-none d-xl-block">
                    <nav class="box-navigation text-center">
                        <ul class="box-nav-ul d-flex align-items-center justify-content-center">
                            <li v-for="item in items" :key="item.label" :class="[
                                'menu-item',
                                {
                                    active: item.active,
                                    'position-relative':
                                        !!item.children?.length,
                                },
                            ]">
                                <component :is="usesAnchorTag(item) ? 'a' : Link" :href="item.href"
                                    :target="getTarget(item)" :rel="getRel(item)" class="item-link">
                                    {{ item.label }}
                                    <i v-if="item.children?.length" class="icon icon-arrow-down"></i>
                                </component>

                                <div v-if="item.children?.length" class="sub-menu submenu-default">
                                    <ul class="menu-list">
                                        <li v-for="child in item.children" :key="`${item.label}-${child.label}`" :class="{
                                            'menu-item-2':
                                                !!child.children?.length,
                                        }">
                                            <component :is="usesAnchorTag(child)
                                                    ? 'a'
                                                    : Link
                                                " :href="child.href" :target="getTarget(child)" :rel="getRel(child)"
                                                class="menu-link-text link">
                                                {{ child.label }}
                                            </component>

                                            <div v-if="child.children?.length" class="sub-menu submenu-default">
                                                <ul class="menu-list">
                                                    <li v-for="grandChild in child.children"
                                                        :key="`${item.label}-${child.label}-${grandChild.label}`">
                                                        <component :is="usesAnchorTag(
                                                            grandChild,
                                                        )
                                                                ? 'a'
                                                                : Link
                                                            " :href="grandChild.href
                                                                " :target="getTarget(
                                                                grandChild,
                                                            )
                                                                " :rel="getRel(
                                                                grandChild,
                                                            )
                                                                " class="menu-link-text link">
                                                            {{
                                                                grandChild.label
                                                            }}
                                                        </component>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-xl-3 col-md-4 col-3">
                    <ul class="nav-icon d-flex justify-content-end align-items-center">
                        <li class="nav-search">
                            <a href="#search" data-bs-toggle="modal" class="nav-icon-item">
                                <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z"
                                        stroke="#181818" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M21.35 21.0004L17 16.6504" stroke="#181818" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </li>
                        <li class="nav-account">
                            <a href="#" class="nav-icon-item">
                                <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21"
                                        stroke="#181818" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z"
                                        stroke="#181818" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>
                            <div class="dropdown-account dropdown-login">
                                <div class="sub-top">
                                    <a href="login.html" class="tf-btn btn-reset">Login</a>
                                    <p class="text-secondary-2 text-center">
                                        Don&rsquo;t have an account?
                                        <a href="register.html">Register</a>
                                    </p>
                                </div>
                                <div class="sub-bot">
                                    <span class="body-text-">Support</span>
                                </div>
                            </div>
                        </li>
                        <li class="nav-cart">
                            <a href="#shoppingCart" data-bs-toggle="modal" class="nav-icon-item">
                                <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16.5078 10.8734V6.36686C16.5078 5.17166 16.033 4.02541 15.1879 3.18028C14.3428 2.33514 13.1965 1.86035 12.0013 1.86035C10.8061 1.86035 9.65985 2.33514 8.81472 3.18028C7.96958 4.02541 7.49479 5.17166 7.49479 6.36686V10.8734M4.11491 8.62012H19.8877L21.0143 22.1396H2.98828L4.11491 8.62012Z"
                                        stroke="#181818" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                <span class="count-box">1</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
</template>
