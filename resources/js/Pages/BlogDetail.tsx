import { type ReactNode } from 'react'
import { Link } from '@inertiajs/react'
import { ArrowLeft, ArrowRight } from 'lucide-react'
import Seo from '@/components/Seo'
import SiteLayout from '@/Layouts/SiteLayout'
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

      <article className="mx-auto max-w-screen-2xl px-4 pt-28 md:px-10 md:pt-32">
        <Link
          href="/blog"
          className="inline-flex items-center gap-1.5 text-sm text-muted-foreground transition-colors hover:text-brand-500"
        >
          <ArrowLeft className="h-4 w-4" />
          Kembali ke Blog
        </Link>

        <div className="mx-auto mt-6 flex max-w-3xl flex-col items-start gap-4" data-aos="fade-up">
          <div className="flex items-center gap-3 text-sm">
            {post.category && (
              <span className="inline-flex items-center rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-600">
                {post.category}
              </span>
            )}
            {post.date && <span className="text-stone-500">{post.date}</span>}
          </div>
          <h1 className="text-3xl font-medium leading-[1.1] tracking-tight text-foreground md:text-5xl">{post.title}</h1>
          {post.short_desc && <p className="text-lg leading-relaxed text-muted-foreground">{post.short_desc}</p>}
        </div>

        <img
          src={img(post.image, 'working-1.jpg')}
          alt={post.title}
          className="mx-auto mt-10 aspect-[16/9] w-full max-w-5xl rounded-4xl object-cover"
          data-aos="zoom-in"
        />

        {post.content && (
          <div
            className="mx-auto mt-10 max-w-3xl space-y-5 text-lg leading-relaxed text-stone-700 [&_a]:text-brand-500 [&_a]:underline [&_h2]:mt-10 [&_h2]:text-2xl [&_h2]:font-medium [&_h2]:text-foreground [&_h3]:mt-8 [&_h3]:text-xl [&_h3]:font-semibold [&_img]:rounded-2xl [&_li]:ml-4 [&_ul]:list-disc"
            data-aos="fade-up"
            // Content authored by admins via the Filament editor (trusted source).
            dangerouslySetInnerHTML={{ __html: post.content }}
          />
        )}
      </article>

      {others.length > 0 && (
        <section className="mx-auto max-w-screen-2xl px-4 py-20 md:px-10 md:py-24">
          <h2 className="mb-8 text-2xl font-medium tracking-tight text-foreground md:text-3xl" data-aos="fade-up">Artikel lainnya</h2>
          <div className="grid gap-8 sm:grid-cols-3">
            {others.map((r, i) => (
              <Link key={r.id} href={`/blog/${r.id}`} className="group flex flex-col gap-4" data-aos="fade-up" data-aos-delay={Math.min(i, 5) * 80}>
                <div className="overflow-hidden rounded-2xl">
                  <img
                    src={img(r.image, 'working-2.jpg')}
                    alt=""
                    className="h-56 w-full object-cover transition-transform duration-500 group-hover:scale-105"
                    loading="lazy"
                  />
                </div>
                {r.date && <span className="text-sm text-stone-500">{r.date}</span>}
                <span className="text-lg font-semibold leading-snug tracking-tight text-foreground">{r.title}</span>
                <span className="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-500">
                  Baca selengkapnya
                  <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" />
                </span>
              </Link>
            ))}
          </div>
        </section>
      )}
    </>
  )
}

BlogDetailPage.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>
