import { Link } from '@inertiajs/react';
import { cn } from '@/lib/utils';
import type { PaginationLink } from '@/types/models';

/** Renders Laravel paginator links (labels contain « / » entities). */
export default function Pagination({ links }: { links: PaginationLink[] }) {
    if (links.length <= 3) return null;

    return (
        <nav className="mt-12 flex flex-wrap items-center justify-center gap-1.5" aria-label="Paginasi">
            {links.map((link, i) => {
                const label = link.label
                    .replace('&laquo;', '‹')
                    .replace('&raquo;', '›')
                    .replace('pagination.previous', '‹')
                    .replace('pagination.next', '›');
                const base =
                    'flex h-10 min-w-10 items-center justify-center rounded-xl px-3 text-sm font-medium transition-colors';

                if (!link.url) {
                    return (
                        <span key={i} className={cn(base, 'cursor-default text-muted-foreground/50')}>
                            {label}
                        </span>
                    );
                }
                return (
                    <Link
                        key={i}
                        href={link.url}
                        preserveScroll
                        className={cn(
                            base,
                            link.active
                                ? 'bg-primary text-primary-foreground shadow-sm'
                                : 'border border-border bg-background text-foreground hover:border-primary hover:text-primary',
                        )}
                    >
                        {label}
                    </Link>
                );
            })}
        </nav>
    );
}
