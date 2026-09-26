import { type ReactNode } from 'react'
import { Link } from '@inertiajs/react'
import { ArrowLeft, CalendarDays } from 'lucide-react'
import Seo from '@/components/Seo'
import SiteLayout from '@/Layouts/SiteLayout'
import { Badge } from '@/components/ui/badge'
import { img } from '@/lib/media'
import type { BlogDetailPost, BlogPost } from '@/types/models'

interface Props {
  meta: { title: string; description: string }
  post: BlogDetailPost
  related: BlogPost[]
}

export default function BlogDetailPage({ meta, post, related }: Props) {
  const others = related.filter((r) => r.id !== post.id).slice(0, 3)

  return (
    <>
      <Seo title={meta.title} description={meta.description} image={post.image ?? undefined} />

      <article className="pt-28 md:pt-32">
        <div className="container max-w-3xl py-10">
          <Link href="/blog" className="inline-flex items-center gap-1.5 text-sm text-muted-foreground hover:text-primary">
            <ArrowLeft className="h-4 w-4" />
            Kembali ke Blog
          </Link>

          <div className="mt-6 flex items-center gap-3 text-sm text-muted-foreground">
            {post.category && <Badge variant="accent">{post.category}</Badge>}
            {post.date && (
              <span className="flex items-center gap-1">
                <CalendarDays className="h-3.5 w-3.5" />
                {post.date}
              </span>
            )}
          </div>

          <h1 className="mt-3 text-3xl font-bold leading-tight tracking-tight text-primary md:text-4xl">
            {post.title}
          </h1>
          {post.short_desc && <p className="mt-4 text-lg text-muted-foreground">{post.short_desc}</p>}

          <img
            src={img(post.image, 'services-1.jpg')}
            alt={post.title}
            className="mt-8 aspect-video w-full rounded-2xl object-cover shadow-md"
          />

          {post.content && (
            <div
              className="mt-8 space-y-4 leading-relaxed text-foreground/80 [&_a]:text-accent [&_a]:underline [&_h2]:mt-8 [&_h2]:text-xl [&_h2]:font-semibold [&_h2]:text-primary [&_img]:rounded-xl [&_li]:ml-4 [&_ul]:list-disc"
              // Content is authored by admins via the Filament editor (trusted source).
              dangerouslySetInnerHTML={{ __html: post.content }}
            />
          )}
        </div>
      </article>

      {others.length > 0 && (
        <section className="py-16">
          <div className="container max-w-5xl">
            <h2 className="mb-8 text-xl font-bold text-primary">Artikel Lainnya</h2>
            <div className="grid gap-6 sm:grid-cols-3">
              {others.map((r) => (
                <Link key={r.id} href={`/blog/${r.id}`} className="group">
                  <img
                    src={img(r.image, 'services-1.jpg')}
                    alt={r.title}
                    className="aspect-video w-full rounded-xl object-cover"
                    loading="lazy"
                  />
                  <h3 className="mt-3 font-semibold leading-snug text-primary group-hover:text-accent">{r.title}</h3>
                  {r.date && <p className="mt-1 text-xs text-muted-foreground">{r.date}</p>}
                </Link>
              ))}
            </div>
          </div>
        </section>
      )}
    </>
  )
}

BlogDetailPage.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>
