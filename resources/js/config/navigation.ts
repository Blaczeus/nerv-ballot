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
        visibleFor: ['guest', 'user', 'nominee', 'admin'],
    },
    {
        label: 'Categories',
        url: '#categories',
        children: [
            { label: 'National Awards', url: '#categories-national' },
            { label: 'Global Awards', url: '#categories-global' },
        ],
        visibleFor: ['guest', 'user', 'nominee', 'admin'],
    },
    {
        label: 'Nominees',
        url: '#nominees',
        children: [
            { label: 'Top Nominees', url: '#nominees-top' },
            { label: 'New Nominees', url: '#nominees-new' },
        ],
        visibleFor: ['guest', 'user', 'nominee', 'admin'],
    },
    {
        label: 'Vote',
        url: '#vote',
        visibleFor: ['guest', 'user', 'nominee', 'admin'],
    },
    {
        label: 'Results',
        url: '#results',
        visibleFor: ['guest', 'user', 'nominee', 'admin'],
    },
    {
        label: 'Dashboard',
        route: 'dashboard',
        requiresAuth: true,
        visibleFor: ['user', 'nominee', 'admin'],
    },
];
