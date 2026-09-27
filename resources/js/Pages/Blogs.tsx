import { Head, Link } from '@inertiajs/react';
import { Newspaper } from 'lucide-react';
import PageHeader from '@/components/PageHeader';
import BlogCard from '@/components/BlogCard';
import Pagination from '@/components/Pagination';
import { routes } from '@/lib/routes';
import { cn } from '@/lib/utils';
import { useI18n } from '@/lib/i18n';
import type { Blog, Category, Paginated } from '@/types/models';

export default function Blogs({
    blogs,
    categories,
    categorySlug,
}: {
    blogs: Paginated<Blog>;
    categories: Category[];
    categorySlug: string | null;
}) {
    const { t } = useI18n();
    return (
        <>
            <Head title={t('nav.blog')} />
            <PageHeader
                title={t('blog.listTitle')}
                subtitle={t('blog.listSubtitle')}
                crumbs={[{ label: t('nav.blog') }]}
            />

            <section className="container py-20">
                <div className="grid gap-10 lg:grid-cols-[1fr_280px]">
                    {/* Main list */}
                    <div>
                        {blogs.data.length > 0 ? (
                            <div className="grid gap-6 sm:grid-cols-2">
                                {blogs.data.map((blog) => (
                                    <BlogCard key={blog.id} blog={blog} />
                                ))}
                            </div>
                        ) : (
                            <div className="rounded-2xl border border-dashed border-border py-20 text-center">
                                <Newspaper className="mx-auto h-10 w-10 text-muted-foreground" />
                                <p className="mt-4 text-muted-foreground">{t('blog.emptyCategory')}</p>
                            </div>
                        )}
                        <Pagination links={blogs.links} />
                    </div>

                    {/* Sidebar */}
                    <aside className="lg:sticky lg:top-24 lg:self-start">
                        <div className="rounded-2xl border border-border bg-card p-6">
                            <h3 className="text-sm font-semibold uppercase tracking-wider text-foreground">{t('blog.categories')}</h3>
                            <ul className="mt-4 space-y-1.5">
                                <li>
                                    <Link
                                        href={routes.blogs()}
                                        className={cn(
                                            'block rounded-lg px-3 py-2 text-sm transition-colors',
                                            !categorySlug
                                                ? 'bg-primary/10 font-medium text-primary'
                                                : 'text-muted-foreground hover:bg-secondary',
                                        )}
                                    >
                                        {t('blog.allArticles')}
                                    </Link>
                                </li>
                                {categories.map((cat) => (
                                    <li key={cat.id}>
                                        <Link
                                            href={routes.blogs(cat.slug)}
                                            className={cn(
                                                'block rounded-lg px-3 py-2 text-sm transition-colors',
                                                categorySlug === cat.slug
                                                    ? 'bg-primary/10 font-medium text-primary'
                                                    : 'text-muted-foreground hover:bg-secondary',
                                            )}
                                        >
                                            {cat.name}
                                        </Link>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    </aside>
                </div>
            </section>
        </>
    );
}
