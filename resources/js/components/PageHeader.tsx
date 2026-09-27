import { Link } from '@inertiajs/react';
import { ChevronRight } from 'lucide-react';
import { routes } from '@/lib/routes';

export interface Crumb {
    label: string;
    href?: string;
}

export default function PageHeader({
    title,
    subtitle,
    crumbs = [],
}: {
    title: string;
    subtitle?: string;
    crumbs?: Crumb[];
}) {
    return (
        <section className="relative overflow-hidden border-b border-border bg-secondary/40">
            {/* soft aquatic backdrop */}
            <div aria-hidden className="pointer-events-none absolute inset-0">
                <div className="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-primary/10 blur-3xl" />
                <div className="absolute -bottom-32 -left-20 h-72 w-72 rounded-full bg-accent/10 blur-3xl" />
            </div>

            <div className="container relative py-16 md:py-20">
                <nav className="flex flex-wrap items-center gap-1.5 text-sm text-muted-foreground">
                    <Link href={routes.home()} className="hover:text-primary">Beranda</Link>
                    {crumbs.map((c) => (
                        <span key={c.label} className="flex items-center gap-1.5">
                            <ChevronRight className="h-4 w-4" />
                            {c.href ? (
                                <Link href={c.href} className="hover:text-primary">{c.label}</Link>
                            ) : (
                                <span className="text-foreground">{c.label}</span>
                            )}
                        </span>
                    ))}
                </nav>

                <h1 className="mt-4 max-w-3xl text-4xl font-extrabold tracking-tight text-foreground md:text-5xl">
                    {title}
                </h1>
                {subtitle && <p className="mt-4 max-w-2xl text-lg text-muted-foreground">{subtitle}</p>}
            </div>
        </section>
    );
}
