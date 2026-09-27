import { Link } from '@inertiajs/react'
import { ArrowRight } from 'lucide-react'
import { img } from '@/lib/media'
import type { BlogPost } from '@/types/models'

export default function Blog({ data }: { data: BlogPost[] }) {
  if (!data || data.length === 0) return null
  const posts = data.slice(0, 3)

  return (
    <section data-aos="fade-up" className="mx-auto flex max-w-screen-2xl flex-col gap-10 px-4 py-20 md:px-10 md:py-24">
      <div data-aos="fade-up" className="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
        <div className="flex flex-col gap-4">
          <span className="inline-flex w-fit items-center rounded-full bg-brand-600 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider text-white">
            Artikel kami
          </span>
          <h2 className="text-3xl font-medium leading-[1.1] tracking-tight text-foreground md:text-4xl">
            Berita &amp; Blog Terbaru
          </h2>
        </div>
        <Link
          href="/blog"
          className="inline-flex h-11 items-center rounded-full bg-brand-500 px-5 text-sm font-semibold text-white transition-colors hover:bg-brand-600"
        >
          Lihat semua
        </Link>
      </div>

      <div className="grid gap-6 md:grid-cols-3">
        {posts.map((p, i) => (
          <Link key={p.id} data-aos="fade-up" data-aos-delay={Math.min(i, 5) * 80} href={`/blog/${p.id}`} className="group flex flex-col gap-4">
            <div className="overflow-hidden rounded-2xl">
              <img
                src={img(p.image, 'working-1.jpg')}
                alt=""
                className="h-72 w-full object-cover transition-transform duration-500 group-hover:scale-105"
                loading="lazy"
              />
            </div>
            {p.date && <span className="text-sm text-stone-500">{p.date}</span>}
            <span className="text-xl font-semibold leading-snug tracking-tight text-foreground">{p.title}</span>
            <span className="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-500">
              Baca selengkapnya
              <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" />
            </span>
          </Link>
        ))}
      </div>
    </section>
  )
}
