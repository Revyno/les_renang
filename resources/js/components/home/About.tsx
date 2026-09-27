import { Link } from '@inertiajs/react'
import { ArrowRight } from 'lucide-react'
import { cn } from '@/lib/utils'
import { cld, img } from '@/lib/media'
import { useI18n } from '@/lib/i18n'
import type { About as AboutData, GalleryItem } from '@/types/models'

// Intro block + staggered 4-up gallery (reference "Kursus Renang Profesional" section).
const GALLERY_FALLBACK = [
  'teacher/20240804_072031.jpg',
  'teacher/IMG_3473.JPG',
  'teacher/IMG_3599.JPG',
  'teacher/20241019_165350.jpg',
]

export default function About({ data, gallery }: { data: AboutData | null; gallery: GalleryItem[] }) {
  const { t } = useI18n()
  const title = data?.title || t('home.about.title')
  const description = data?.description || t('home.about.description')
  const items =
    gallery.length > 0
      ? gallery.slice(0, 4)
      : GALLERY_FALLBACK.map((image, id) => ({ id, title: null, image: cld(image) }))

  return (
    <section className="mx-auto flex max-w-screen-2xl flex-col items-center gap-16 px-4 py-20 md:px-10 md:py-28">
      <div className="flex max-w-3xl flex-col items-center gap-6 text-center" data-aos="fade-up">
        <span className="inline-flex items-center rounded-full bg-brand-600 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider text-white">
          {t('home.about.badge')}
        </span>
        <h2 className="text-3xl font-medium leading-[1.12] tracking-tight text-foreground md:text-4xl lg:text-5xl">
          {title}
        </h2>
        <p className="text-base leading-relaxed text-muted-foreground md:text-lg">{description}</p>
        <Link
          href="/tentang"
          className="inline-flex h-12 items-center gap-2 rounded-full bg-brand-500 px-6 text-sm font-semibold text-white transition-colors hover:bg-brand-600"
        >
          {t('home.about.cta')}
          <ArrowRight className="h-4 w-4" />
        </Link>
      </div>

      <div className="grid w-full grid-cols-2 items-start gap-4 md:grid-cols-4 md:gap-6">
        {items.map((g, i) => (
          <div
            key={g.id}
            className={cn('overflow-hidden rounded-2xl bg-stone-200', i % 2 === 0 && 'md:mt-10')}
            data-aos="fade-up"
            data-aos-delay={Math.min(i, 5) * 80}
          >
            <img
              src={img(g.image, GALLERY_FALLBACK[i % GALLERY_FALLBACK.length])}
              alt={g.title || ''}
              className="h-64 w-full object-cover md:h-80"
              loading="lazy"
            />
          </div>
        ))}
      </div>
    </section>
  )
}
