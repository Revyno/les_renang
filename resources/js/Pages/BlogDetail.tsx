import { Head, Link } from '@inertiajs/react';
import { ArrowLeft, CalendarDays, ImageIcon } from 'lucide-react';
import PageHeader from '@/components/PageHeader';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { formatDate, storageUrl } from '@/lib/utils';
import { routes } from '@/lib/routes';
import type { Blog, Category } from '@/types/models';

export default function BlogDetail({
    blog,
    category,
    recent,
}: {
    blog: Blog;
    category: Category | null;
    recent: Blog[];
}) {
    const img = storageUrl(blog.imgUrl);
    const excerpt = (blog.description ?? '').replace(/<[^>]+>/g, ' ').replace(/\s+/g, ' ').trim().slice(0, 160);

    return (
        <>
            <Head title={blog.title}>
                <meta property="og:type" content="article" head-key="og:type" />
                <meta property="og:title" content={blog.title} head-key="og:title" />
                {excerpt && <meta property="og:description" content={excerpt} head-key="og:description" />}
                {img && <meta property="og:image" content={img} head-key="og:image" />}
            </Head>
            <PageHeader
                title={blog.title}
                crumbs={[{ label: 'Blog', href: routes.blogs() }, { label: category?.name ?? 'Artikel' }]}
            />

            <article className="container py-16">
                <div className="mx-auto max-w-3xl">
                    <div className="flex flex-wrap items-center gap-4 text-sm text-muted-foreground">
                        <span className="flex items-center gap-1.5">
                            <CalendarDays className="h-4 w-4" /> {formatDate(blog.created_at)}
                        </span>
                        {category && <Badge>{category.name}</Badge>}
                    </div>

                    <div className="mt-6 overflow-hidden rounded-2xl border border-border bg-secondary">
                        {img ? (
                            <img src={img} alt={blog.title} className="aspect-[16/9] w-full object-cover" />
                        ) : (
                            <div className="flex aspect-[16/9] items-center justify-center text-muted-foreground">
                                <ImageIcon className="h-12 w-12" />
                            </div>
                        )}
                    </div>

                    {blog.description ? (
                        <div className="rich mt-10" dangerouslySetInnerHTML={{ __html: blog.description }} />
                    ) : (
                        <p className="mt-10 text-muted-foreground">Konten artikel belum tersedia.</p>
                    )}

                    <div className="mt-12 border-t border-border pt-8">
                        <Button asChild variant="outline">
                            <Link href={routes.blogs()}>
                                <ArrowLeft className="h-4 w-4" /> Kembali ke Blog
                            </Link>
                        </Button>
                    </div>
                </div>

                {recent.length > 0 && (
                    <div className="mx-auto mt-20 max-w-5xl border-t border-border pt-12">
                        <h2 className="text-2xl font-bold tracking-tight text-foreground">Artikel Terbaru</h2>
                        <div className="mt-6 grid gap-4 sm:grid-cols-2">
                            {recent.map((r) => (
                                <Link
                                    key={r.id}
                                    href={routes.blogDetail(r.id)}
                                    className="group flex items-center gap-4 rounded-2xl border border-border bg-card p-3 transition-colors hover:border-primary/40"
                                >
                                    <div className="h-16 w-16 shrink-0 overflow-hidden rounded-xl bg-secondary">
                                        {storageUrl(r.imgUrl) && (
                                            <img src={storageUrl(r.imgUrl)} alt={r.title} className="h-full w-full object-cover" />
                                        )}
                                    </div>
                                    <div className="min-w-0">
                                        <p className="truncate font-medium text-foreground group-hover:text-primary">{r.title}</p>
                                        <p className="text-xs text-muted-foreground">{formatDate(r.created_at)}</p>
                                    </div>
                                </Link>
                            ))}
                        </div>
                    </div>
                )}
            </article>
        </>
    );
}
