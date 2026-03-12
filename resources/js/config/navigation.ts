export type NavRole = 'guest' | 'user' | 'nominee' | 'admin';

export interface NavItem {
    label: string;
    route?: string;
    url?: string;
    children?: NavItem[];
    requiresAuth?: boolean;
    guestOnly?: boolean;
    visibleFor?: NavRole[];
}

export interface ResolvedNavItem extends Omit<NavItem, 'children'> {
    href: string;
    external?: boolean;
    active?: boolean;
    children?: ResolvedNavItem[];
}

export const navigation: NavItem[] = [
    {
        label: 'Home',
        route: 'home',
    },
    {
        label: 'Contestants',
        route: 'contestants',
    },
    {
        label: 'Leaderboard',
        route: 'leaderboard',
    },
    {
        label: 'About',
        route: 'about',
    },
    {
        label: 'Cart',
        route: 'cart',
    },
    {
        label: 'Dashboard',
        route: 'dashboard',
        requiresAuth: true,
        visibleFor: ['user', 'nominee', 'admin'],
    },
];
