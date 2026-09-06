import { Link } from '@inertiajs/react';
import { ArrowUpRight, CalendarDays, ImageIcon } from 'lucide-react';
import { Card } from '@/components/ui/card';
import { formatDate, storageUrl } from '@/lib/utils';
import { routes } from '@/lib/routes';
import type { Blog } from '@/types/models';

export default function BlogCard({ blog }: { blog: Blog }) {
    const img = storageUrl(blog.imgUrl);

    return (
        <Card className="group flex h-full flex-col overflow-hidden p-0 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
            <Link href={routes.blogDetail(blog.id)} className="relative block aspect-[16/10] overflow-hidden bg-secondary">
                {img ? (
                    <img
                        src={img}
                        alt={blog.title}
                        loading="lazy"
                        className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                    />
                ) : (
                    <div className="flex h-full w-full items-center justify-center text-muted-foreground">
                        <ImageIcon className="h-10 w-10" />
                    </div>
                )}
            </Link>
            <div className="flex flex-1 flex-col p-5">
                <p className="flex items-center gap-1.5 text-xs font-medium text-muted-foreground">
                    <CalendarDays className="h-3.5 w-3.5" />
                    {formatDate(blog.created_at)}
                </p>
                <h3 className="mt-2 text-lg font-semibold leading-snug text-foreground">
                    <Link href={routes.blogDetail(blog.id)} className="transition-colors hover:text-primary">
                        {blog.title}
                    </Link>
                </h3>
                {blog.short_desc && (
                    <p className="mt-2 line-clamp-2 flex-1 text-sm text-muted-foreground">{blog.short_desc}</p>
                )}
                <Link
                    href={routes.blogDetail(blog.id)}
                    className="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-primary"
                >
                    Baca Selengkapnya
                    <ArrowUpRight className="h-4 w-4 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" />
                </Link>
            </div>
        </Card>
    );
}
