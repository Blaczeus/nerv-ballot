<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import {
    LayoutDashboard,
    LogIn,
    Mail,
    Phone,
    ShoppingCart,
    UserPlus,
} from 'lucide-vue-next';
import { computed, onMounted, reactive, ref, useSlots, watch } from 'vue';
import ProductModalsSection from '@/components/contestant/ProductModalsSection.vue';
import Footer from '@/components/Footer.vue';
import Header from '@/components/Header.vue';
import CartModal from '@/components/modals/CartModal.vue';
import FilterModal from '@/components/modals/FilterModal.vue';
import QuickViewModal from '@/components/modals/QuickViewModal.vue';
import SearchModal from '@/components/modals/SearchModal.vue';
import ScrollToTop from '@/components/ui/ScrollToTop.vue';
import { useGlobalModals } from '@/composables/useGlobalModals';
import { navigation } from '@/config/navigation';
import type {NavItem,NavRole,ResolvedNavItem,} from '@/config/navigation';
import * as routeRegistry from '@/routes';
import { initTemplatePlugins } from '@/vendor/init-template';

type AuthUser = Record<string, unknown> | null;

const page = usePage<{
    auth?: {
        user?: AuthUser;
    };
}>();
const slots = useSlots();
const hasFilterModalSlot = computed(() => Boolean(slots.filterModal));
const { state: modalState, closeAllModals, closeModal, openAskQuestion, openSearch } = useGlobalModals();
const hasFrontendModalOpen = computed(() => Boolean(modalState.activeModal));
const askQuestionForm = reactive({
    name: '',
    email: '',
    phone: '',
    message: '',
});
const askQuestionSuccessMessage = ref('');

const user = computed<AuthUser>(() => {
    const authProp = page.props.auth as AuthUser | { user?: AuthUser } | undefined;
    if (!authProp) return null;

    if (typeof authProp === 'object' && authProp !== null && 'user' in authProp) {
        return (authProp as { user?: AuthUser }).user ?? null;
    }

    return authProp as AuthUser;
});

const allowedRoles: NavRole[] = ['guest', 'user', 'nominee', 'admin'];

const resolveRole = (authUser: AuthUser): NavRole => {
    if (!authUser) return 'guest';

    const roleFromUser = authUser.role;
    if (typeof roleFromUser === 'string' && allowedRoles.includes(roleFromUser as NavRole)) {
        return roleFromUser as NavRole;
    }

    if (roleFromUser && typeof roleFromUser === 'object' && 'name' in roleFromUser) {
        const roleName = (roleFromUser as { name?: unknown }).name;
        if (typeof roleName === 'string' && allowedRoles.includes(roleName as NavRole)) {
            return roleName as NavRole;
        }
    }

    const rolesFromUser = authUser.roles;
    if (Array.isArray(rolesFromUser)) {
        const role = rolesFromUser.find((value): value is NavRole => {
            if (typeof value === 'string' && allowedRoles.includes(value as NavRole)) {
                return true;
            }

            if (value && typeof value === 'object' && 'name' in value) {
                const roleName = (value as { name?: unknown }).name;
                return typeof roleName === 'string' && allowedRoles.includes(roleName as NavRole);
            }

            return false;
        });

        if (role) return role;
    }

    return 'user';
};

const currentRole = computed<NavRole>(() => resolveRole(user.value));
const isAuthenticated = computed<boolean>(() => Boolean(user.value));

const normalizePath = (path: string): string => {
    if (path === '/') return path;
    return path.replace(/\/+$/, '');
};

const currentPath = computed<string>(() => {
    const pageUrl = typeof page.url === 'string' ? page.url : '/';
    const [path] = pageUrl.split('?');
    return normalizePath(path || '/');
});

const routes = routeRegistry as Record<string, unknown>;

const resolveRouteUrl = (routeName: string): string | null => {
    const resolver = routeName
        .split('.')
        .reduce<unknown>((current, segment) => {
            if (!current || typeof current !== 'object') return null;
            return (current as Record<string, unknown>)[segment] ?? null;
        }, routes);

    if (typeof resolver !== 'function') return null;

    const route = (resolver as () => { url?: unknown })();
    if (!route || typeof route !== 'object') return null;

    return typeof route.url === 'string' ? route.url : null;
};

const isExternalHref = (href: string): boolean => /^(https?:)?\/\//.test(href);

const isActiveHref = (href: string): boolean => {
    if (!href || href.startsWith('#') || isExternalHref(href)) return false;

    const normalizedHref = normalizePath(href);
    if (normalizedHref === '/') return currentPath.value === '/';

    return (
        currentPath.value === normalizedHref ||
        currentPath.value.startsWith(`${normalizedHref}/`)
    );
};

const shouldShowItem = (item: NavItem): boolean => {
    if (item.requiresAuth && !isAuthenticated.value) return false;
    if (item.guestOnly && isAuthenticated.value) return false;
    if (item.visibleFor && !item.visibleFor.includes(currentRole.value))
        return false;
    return true;
};

const resolveNavItems = (items: NavItem[], depth = 0): ResolvedNavItem[] => {
    if (depth > 2) return [];

    return items
        .filter((item) => shouldShowItem(item))
        .map((item) => {
            const href =
                item.url ??
                (item.route ? (resolveRouteUrl(item.route) ?? '#') : '#');
            const children =
                depth < 2 && item.children?.length
                    ? resolveNavItems(item.children, depth + 1)
                    : undefined;
            const isActive =
                (children?.some((child) => child.active) ?? false) ||
                isActiveHref(href);

            return {
                ...item,
                href,
                children,
                active: isActive,
                external: isExternalHref(href),
            };
        });
};

const navItems = computed<ResolvedNavItem[]>(() => resolveNavItems(navigation));

const closeMobileMenu = () => {
    if (typeof document === 'undefined' || typeof window === 'undefined') return;

    const mobileMenu = document.getElementById('mobileMenu');
    if (!mobileMenu) return;

    const bootstrapWindow = window as Window & {
        bootstrap?: {
            Offcanvas?: {
                getInstance?: (element: Element) => { hide: () => void } | null;
                getOrCreateInstance?: (element: Element) => { hide: () => void };
            };
        };
    };

    const offcanvasApi = bootstrapWindow.bootstrap?.Offcanvas;
    const instance =
        offcanvasApi?.getInstance?.(mobileMenu) ??
        offcanvasApi?.getOrCreateInstance?.(mobileMenu);

    instance?.hide();
};

const handleMobileSupport = () => {
    closeMobileMenu();
    window.setTimeout(() => {
        openAskQuestion();
    }, 150);
};

const handleMobileSearch = () => {
    closeMobileMenu();
    window.setTimeout(() => {
        openSearch();
    }, 150);
};

const resetAskQuestionForm = () => {
    askQuestionForm.name = '';
    askQuestionForm.email = '';
    askQuestionForm.phone = '';
    askQuestionForm.message = '';
    askQuestionSuccessMessage.value = '';
};

const submitAskQuestion = (event: Event) => {
    const form = event.currentTarget as HTMLFormElement | null;

    if (!form?.reportValidity()) {
        return;
    }

    askQuestionSuccessMessage.value = "Your message has been received. We'll get back to you shortly.";
    askQuestionForm.name = '';
    askQuestionForm.email = '';
    askQuestionForm.phone = '';
    askQuestionForm.message = '';
};

const scheduleTemplateInit = () => {
    window.setTimeout(() => {
        initTemplatePlugins();
    }, 50);
};

onMounted(() => {
    scheduleTemplateInit();
});

watch(
    () => page.url,
    () => {
        closeMobileMenu();
        closeAllModals();
        scheduleTemplateInit();
    },
);

watch(
    () => modalState.activeModal,
    (activeModal) => {
        if (typeof document === 'undefined') return;

        document.body.classList.toggle('modal-open', Boolean(activeModal));

        if (!activeModal) {
            document.body.style.removeProperty('padding-right');
        }

        if (activeModal !== 'askQuestion') {
            resetAskQuestionForm();
        }
    },
    { immediate: true },
);
</script>

<template>
    <div class="preload-wrapper popup-loader">
        <ScrollToTop />
        <div id="wrapper">
            <Header :items="navItems" />
            <slot />
            <Footer />
        </div>
        <!-- Global Modals -->
        <div
            v-if="hasFrontendModalOpen"
            class="modal-backdrop fade show"
            style="z-index: 1050;"
            @click="closeModal()"
        ></div>
        <SearchModal />
        <QuickViewModal />
        <CartModal />
        <ProductModalsSection />
        <slot v-if="hasFilterModalSlot" name="filterModal" />
        <FilterModal v-else />
        <slot name="overlays" />
        <!-- mobile menu -->
        <div class="offcanvas offcanvas-start canvas-mb" id="mobileMenu">
            <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
            <div class="mb-canvas-content">
                <div class="mb-body">
                    <div class="mb-content-top">
                        <form class="form-search" @submit.prevent="handleMobileSearch">
                            <fieldset class="text">
                                <input
                                    type="text"
                                    placeholder="Search contestants"
                                    class=""
                                    name="text"
                                    tabindex="0"
                                    value=""
                                    aria-required="true"
                                    required
                                    @focus="handleMobileSearch"
                                    @click="handleMobileSearch"
                                />
                            </fieldset>
                            <button class="" type="submit" @click.prevent="handleMobileSearch">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#181818" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M20.9984 20.9999L16.6484 16.6499" stroke="#181818" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </form>
                        <ul class="nav-ul-mb" id="wrapper-menu-navigation">
                            <li v-for="item in navItems" :key="`mobile-${item.label}`" class="nav-mb-item">
                                <component
                                    :is="item.external || item.href.startsWith('#') ? 'a' : Link"
                                    :href="item.href"
                                    :target="item.external ? '_blank' : undefined"
                                    :rel="item.external ? 'noopener noreferrer' : undefined"
                                    class="mb-menu-link"
                                    @click="closeMobileMenu"
                                >
                                    <span>{{ item.label }}</span>
                                </component>
                            </li>
                            <template v-if="!isAuthenticated">
                                <li class="nav-mb-item">
                                    <Link href="/login" class="mb-menu-link" @click="closeMobileMenu">
                                        <span>Login</span>
                                    </Link>
                                </li>
                                <li class="nav-mb-item">
                                    <Link href="/register" class="mb-menu-link" @click="closeMobileMenu">
                                        <span>Register</span>
                                    </Link>
                                </li>
                            </template>
                            <template v-else>
                                <li class="nav-mb-item">
                                    <Link href="/dashboard" class="mb-menu-link" @click="closeMobileMenu">
                                        <span>Dashboard</span>
                                    </Link>
                                </li>
                                <li class="nav-mb-item">
                                    <Link href="/settings/profile" class="mb-menu-link" @click="closeMobileMenu">
                                        <span>Profile</span>
                                    </Link>
                                </li>
                                <li class="nav-mb-item">
                                    <Link href="/logout" method="post" as="button" type="button" class="mb-menu-link" @click="closeMobileMenu">
                                        <span>Logout</span>
                                    </Link>
                                </li>
                            </template>
                        </ul>
                        <div class="mb-other-content">
                            <div class="group-icon">
                                <template v-if="!isAuthenticated">
                                    <Link href="/login" class="site-nav-icon" @click="closeMobileMenu">
                                        <LogIn class="icon" :size="18" :stroke-width="2" />
                                        Login
                                    </Link>
                                    <Link href="/register" class="site-nav-icon" @click="closeMobileMenu">
                                        <UserPlus class="icon" :size="18" :stroke-width="2" />
                                        Register
                                    </Link>
                                </template>
                                <template v-else>
                                    <Link href="/dashboard" class="site-nav-icon" @click="closeMobileMenu">
                                        <LayoutDashboard class="icon" :size="18" :stroke-width="2" />
                                        Dashboard
                                    </Link>
                                    <Link href="/cart" class="site-nav-icon" @click="closeMobileMenu">
                                        <ShoppingCart class="icon" :size="18" :stroke-width="2" />
                                        Vote Cart
                                    </Link>
                                </template>
                            </div>
                            <div class="mb-notice">
                                <a href="#" class="text-need" @click.prevent="handleMobileSupport">
                                    Need Help With Voting?
                                </a>
                            </div>
                            <div class="mb-contact">
                                <p class="text-caption-1">Questions about contestants, vote confirmation, or your vote cart? Our support team is here to help.</p>
                                <Link href="/about" class="tf-btn-default text-btn-uppercase" @click="closeMobileMenu">
                                    HOW VOTING WORKS<i class="icon-arrowUpRight"></i>
                                </Link>
                            </div>
                            <ul class="mb-info">
                                <li>
                                    <Mail class="icon" :size="18" :stroke-width="2" />
                                    <p>support@nervego.com</p>
                                </li>
                                <li>
                                    <Phone class="icon" :size="18" :stroke-width="2" />
                                    <p>+234 800 000 0000</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /mobile menu -->
        <!-- modal ask_question -->
        <div
            v-if="modalState.activeModal === 'askQuestion'"
            class="modal modalCentered fade show tf-product-modal modal-part-content"
            id="ask_question"
            style="display: block;"
            @click.self="closeModal('askQuestion')"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="header">
                        <div class="demo-title">Ask a question</div>
                        <span class="icon-close icon-close-popup" @click="closeModal('askQuestion')"></span>
                    </div>
                    <div class="overflow-y-auto">
                        <form @submit.prevent="submitAskQuestion">
                            <fieldset>
                                <label>Name *</label>
                                <input v-model="askQuestionForm.name" type="text" required />
                            </fieldset>
                            <fieldset>
                                <label>Email *</label>
                                <input v-model="askQuestionForm.email" type="email" required />
                            </fieldset>
                            <fieldset>
                                <label>Phone number</label>
                                <input v-model="askQuestionForm.phone" type="number" />
                            </fieldset>
                            <fieldset>
                                <label>Message</label>
                                <textarea v-model="askQuestionForm.message" name="message" rows="4" required></textarea>
                            </fieldset>
                            <p v-if="askQuestionSuccessMessage" class="text-caption-1 text-secondary">
                                {{ askQuestionSuccessMessage }}
                            </p>
                            <button type="submit" class="btn-style-2 w-100">
                                <span class="text">Send</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /modal ask_question -->
    </div>
</template>
