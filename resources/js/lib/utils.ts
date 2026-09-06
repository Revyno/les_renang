import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

/** Prefix a DB-stored upload path with the public storage disk. */
export function storageUrl(path?: string | null): string {
    if (!path) return '';
    if (/^https?:\/\//.test(path)) return path;
    return `/storage/${path.replace(/^\/?storage\/?/, '')}`;
}

export function formatDate(value: string): string {
    return new Date(value).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    });
}
