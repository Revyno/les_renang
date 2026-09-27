import { type ReactNode } from 'react'
import { Link } from '@inertiajs/react'
import { ArrowRight } from 'lucide-react'
import Seo from '@/components/Seo'
import SiteLayout from '@/Layouts/SiteLayout'
import PageHeader from '@/components/site/PageHeader'
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
        eyebrow="Blog"
        title="Berita & Blog Terbaru"
        description="Tips latihan, wawasan, dan kabar terbaru seputar dunia renang."
        crumbs={[{ label: 'Blog' }]}
      />

      <section className="mx-auto max-w-screen-2xl px-4 py-16 md:px-10 md:py-24">
        {blogs.data.length === 0 ? (
          <p className="py-16 text-center text-muted-foreground">
            Belum ada artikel. Nantikan tulisan terbaru dari kami segera.
          </p>
        ) : (
          <div className="grid gap-8 md:grid-cols-3">
            {blogs.data.map((post, i) => (
              <Link key={post.id} href={`/blog/${post.id}`} className="group flex flex-col gap-4" data-aos="fade-up" data-aos-delay={Math.min(i, 5) * 80}>
                <div className="overflow-hidden rounded-2xl">
                  <img
                    src={img(post.image, 'working-1.jpg')}
                    alt=""
                    className="h-64 w-full object-cover transition-transform duration-500 group-hover:scale-105"
                    loading="lazy"
                  />
                </div>
                <div className="flex items-center gap-3 text-sm">
                  {post.category && (
                    <span className="inline-flex items-center rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-600">
                      {post.category}
                    </span>
                  )}
                  {post.date && <span className="text-stone-500">{post.date}</span>}
                </div>
                <span className="text-xl font-semibold leading-snug tracking-tight text-foreground">{post.title}</span>
                {post.excerpt && <p className="line-clamp-3 text-sm leading-relaxed text-muted-foreground">{post.excerpt}</p>}
                <span className="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-500">
                  Baca selengkapnya
                  <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" />
                </span>
              </Link>
            ))}
          </div>
        )}

        {blogs.last_page > 1 && (
          <nav className="mt-14 flex flex-wrap justify-center gap-1.5">
            {blogs.links.map((link, i) =>
              link.url ? (
                <Link
                  key={i}
                  href={link.url}
                  preserveScroll
                  className={cn(
                    'grid h-10 min-w-10 place-items-center rounded-full px-3.5 text-sm font-medium transition-colors',
                    link.active ? 'bg-brand-500 text-white' : 'bg-stone-100 text-foreground/70 hover:bg-stone-200',
                  )}
                  dangerouslySetInnerHTML={{ __html: link.label }}
                />
              ) : (
                <span
                  key={i}
                  className="grid h-10 min-w-10 place-items-center rounded-full px-3.5 text-sm text-muted-foreground/40"
                  dangerouslySetInnerHTML={{ __html: link.label }}
                />
              ),
            )}
          </nav>
        )}
      </section>
    </>
  )
}

BlogPage.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>
