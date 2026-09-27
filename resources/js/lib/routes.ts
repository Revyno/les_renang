/**
 * Typed helpers for the app's named public routes.
 * Mirrors routes/web.php — keep in sync if paths change.
 */
export const routes = {
    home: () => '/',
    services: () => '/services',
    serviceDetail: (id: number) => `/service/${id}`,
    about: () => '/about-us',
    team: () => '/ourteams',
    blogs: (categorySlug?: string) => (categorySlug ? `/blogs?categorySlug=${encodeURIComponent(categorySlug)}` : '/blogs'),
    blogDetail: (id: number) => `/blog-detail/${id}`,
    faq: () => '/faqs',
    contact: () => '/contactus',
} as const;

export interface NavItem {
    label: string;
    href: string;
}

export const navItems: NavItem[] = [
    { label: 'Beranda', href: routes.home() },
    { label: 'Tentang', href: routes.about() },
    { label: 'Layanan', href: routes.services() },
    { label: 'Tim', href: routes.team() },
    { label: 'Blog', href: routes.blogs() },
    { label: 'FAQ', href: routes.faq() },
];
