export interface Service {
    id: number;
    title: string;
    short_desc: string;
    description?: string; // HTML
    icon_class?: string | null;
}

export interface Team {
    id: number;
    name: string;
    position: string;
    imgUrl: string;
    fblink?: string | null;
    instalink?: string | null;
    twitterlink?: string | null;
}

export interface AboutUs {
    title: string;
    description: string; // HTML
    img: string;
}

export interface Category {
    id: number;
    name: string;
    slug: string;
}

export interface Blog {
    id: number;
    title: string;
    short_desc?: string;
    description?: string; // HTML
    imgUrl: string;
    categories_id: number;
    created_at: string;
}

export interface Faq {
    id: number;
    question: string;
    answer: string;
}

export interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

export interface Paginated<T> {
    data: T[];
    links: PaginationLink[];
    current_page: number;
    last_page: number;
    total: number;
    from: number | null;
    to: number | null;
}

export interface PageProps {
    appName: string;
    flash: {
        success?: string | null;
        error?: string | null;
    };
    [key: string]: unknown;
}
