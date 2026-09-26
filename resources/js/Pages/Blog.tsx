import { type ReactNode } from 'react'
import { Link } from '@inertiajs/react'
import { ArrowRight, CalendarDays } from 'lucide-react'
import Seo from '@/components/Seo'
import SiteLayout from '@/Layouts/SiteLayout'
import PageHeader from '@/components/site/PageHeader'
import { Card, CardContent } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { cn } from '@/lib/utils'
import { img } from '@/lib/media'
import type { BlogPost, Paginated } from '@/types/models'

interface Props {
  meta: { title: string; description: string }
  blogs: Paginated<BlogPost>
}

export default function BlogPage({ meta, blogs }: Props) {
  return (
    <>
      <Seo title={meta.title} description={meta.description} />
      <PageHeader
        title="Blog & Artikel"
        description="Tips latihan, wawasan, dan kabar terbaru seputar dunia renang."
        crumbs={[{ label: 'Blog' }]}
      />

      <section className="py-16 md:py-20">
        <div className="container">
          {blogs.data.length === 0 ? (
            <p className="py-16 text-center text-muted-foreground">
              Belum ada artikel. Nantikan tulisan terbaru dari kami segera.
            </p>
          ) : (
            <div className="grid gap-6 md:grid-cols-3">
              {blogs.data.map((post) => (
                <Card key={post.id} className="flex flex-col overflow-hidden">
                  <Link href={`/blog/${post.id}`}>
                    <img
                      src={img(post.image, 'services-1.jpg')}
                      alt={post.title}
                      className="aspect-video w-full object-cover transition-transform hover:scale-105"
                      loading="lazy"
                    />
                  </Link>
                  <CardContent className="flex flex-1 flex-col p-6">
                    <div className="mb-3 flex items-center gap-3 text-xs text-muted-foreground">
                      {post.category && <Badge variant="accent">{post.category}</Badge>}
                      {post.date && (
                        <span className="flex items-center gap-1">
                          <CalendarDays className="h-3.5 w-3.5" />
                          {post.date}
                        </span>
                      )}
                    </div>
                    <h3 className="text-lg font-semibold leading-snug text-primary">
                      <Link href={`/blog/${post.id}`} className="hover:text-accent">
                        {post.title}
                      </Link>
                    </h3>
                    {post.excerpt && (
                      <p className="mt-2 line-clamp-3 text-sm text-muted-foreground">{post.excerpt}</p>
                    )}
                    <Link
                      href={`/blog/${post.id}`}
                      className="mt-auto inline-flex items-center gap-1.5 pt-4 text-sm font-medium text-accent hover:underline"
                    >
                      Baca selengkapnya
                      <ArrowRight className="h-4 w-4" />
                    </Link>
                  </CardContent>
                </Card>
              ))}
            </div>
          )}

          {blogs.last_page > 1 && (
            <nav className="mt-12 flex flex-wrap justify-center gap-1.5">
              {blogs.links.map((link, i) =>
                link.url ? (
                  <Link
                    key={i}
                    href={link.url}
                    preserveScroll
                    className={cn(
                      'grid h-9 min-w-9 place-items-center rounded-lg px-3 text-sm transition-colors',
                      link.active
                        ? 'bg-primary text-primary-foreground'
                        : 'bg-secondary text-foreground/70 hover:bg-secondary/70',
                    )}
                    dangerouslySetInnerHTML={{ __html: link.label }}
                  />
                ) : (
                  <span
                    key={i}
                    className="grid h-9 min-w-9 place-items-center rounded-lg px-3 text-sm text-muted-foreground/50"
                    dangerouslySetInnerHTML={{ __html: link.label }}
                  />
                ),
              )}
            </nav>
          )}
        </div>
      </section>
    </>
  )
}

BlogPage.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>
