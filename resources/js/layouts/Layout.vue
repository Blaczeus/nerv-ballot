<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed, onMounted, useSlots, watch } from 'vue';
import Footer from '@/components/Footer.vue';
import Header from '@/components/Header.vue';
import CartModal from '@/components/modals/CartModal.vue';
import FilterModal from '@/components/modals/FilterModal.vue';
import QuickViewModal from '@/components/modals/QuickViewModal.vue';
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
const hasOverlaySlot = computed(() => Boolean(slots.overlays));
const { state: modalState } = useGlobalModals();

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
    const resolver = routes[routeName];
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
        scheduleTemplateInit();
    },
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
        <QuickViewModal v-if="!hasOverlaySlot" :contestant="modalState.contestant" />
        <CartModal v-if="!hasOverlaySlot" :contestant="modalState.contestant" />
        <FilterModal v-if="!hasOverlaySlot" />
        <slot name="overlays" />
    </div>
</template>
