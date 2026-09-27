import { useCallback, useEffect, useState } from 'react'
import { Link } from '@inertiajs/react'
import { ArrowRight } from 'lucide-react'
import useEmblaCarousel from 'embla-carousel-react'
import Autoplay from 'embla-carousel-autoplay'
import { cld, img } from '@/lib/media'
import { cn } from '@/lib/utils'
import { useI18n } from '@/lib/i18n'
import type { Hero as HeroData } from '@/types/models'

// Real swim photos cycled as the hero backdrop. A CMS hero image, if set, leads.
const HERO_PHOTOS = [
  'IMG_3383.JPG',
  'teacher/IMG_3473.JPG',
  'teacher/20240804_072031.jpg',
  'pict-1.JPG',
  'teacher/IMG_3599.JPG',
]

// Full-bleed rounded hero card with an auto-playing image carousel. The fixed Navbar
// floats transparent over the top; content is bottom-anchored so it never collides.
export default function Hero({ data }: { data: HeroData | null }) {
  const { t } = useI18n()
  const title = data?.title || t('home.hero.title')
  const subtitle = data?.subtitle || t('home.hero.subtitle')
  const ctaText = data?.cta_text || t('home.hero.cta')
  const ctaLink = data?.cta_link || '/layanan'
  const slides = data?.image ? [img(data.image, HERO_PHOTOS[0]), ...HERO_PHOTOS.map(cld)] : HERO_PHOTOS.map(cld)

  const [emblaRef, emblaApi] = useEmblaCarousel(
    { loop: true, duration: 32 },
    [Autoplay({ delay: 4500, stopOnInteraction: false, stopOnMouseEnter: true })],
  )
  const [selected, setSelected] = useState(0)

  useEffect(() => {
    if (!emblaApi) return
    const onSelect = () => setSelected(emblaApi.selectedScrollSnap())
    onSelect()
    emblaApi.on('select', onSelect)
    return () => void emblaApi.off('select', onSelect)
  }, [emblaApi])

  const scrollTo = useCallback((i: number) => emblaApi?.scrollTo(i), [emblaApi])

  return (
    <section className="px-4 pt-4">
      <div className="relative min-h-[600px] overflow-hidden rounded-4xl bg-ocean md:h-[85vh] md:max-h-[820px]">
        <div className="absolute inset-0 overflow-hidden" ref={emblaRef}>
          <div className="flex h-full">
            {slides.map((src, i) => (
              <div key={i} className="relative h-full min-w-0 flex-[0_0_100%]">
                <img
                  src={src}
                  alt={t('home.hero.imageAlt')}
                  className="h-full w-full object-cover object-[center_40%]"
                  loading={i === 0 ? 'eager' : 'lazy'}
                />
              </div>
            ))}
          </div>
        </div>
        <div className="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/50 via-black/10 to-black/75" aria-hidden />

        <div className="absolute inset-x-6 bottom-8 flex flex-col items-start justify-between gap-10 md:inset-x-14 md:bottom-12 md:flex-row md:items-end">
          <div className="flex flex-col gap-6" data-aos="fade-right" data-aos-duration="900">
            <h1 className="max-w-3xl text-4xl font-medium leading-[1.05] tracking-tight text-white sm:text-5xl md:text-6xl lg:text-[76px]">
              {title}
            </h1>
            <div className="flex gap-2">
              {slides.map((_, i) => (
                <button
                  key={i}
                  type="button"
                  onClick={() => scrollTo(i)}
                  aria-label={`Slide ${i + 1}`}
                  className={cn(
                    'h-1 rounded transition-all duration-300',
                    i === selected ? 'w-10 bg-white' : 'w-3 bg-white/40 hover:bg-white/70',
                  )}
                />
              ))}
            </div>
          </div>
          <div className="flex w-full max-w-md flex-col items-start gap-5" data-aos="fade-left" data-aos-duration="900">
            <p className="text-base leading-relaxed text-stone-100">{subtitle}</p>
            <Link
              href={ctaLink}
              className="inline-flex h-12 items-center gap-2 rounded-full bg-brand-500 px-6 text-sm font-semibold text-white transition-colors hover:bg-brand-600"
            >
              {ctaText}
              <ArrowRight className="h-4 w-4" />
            </Link>
          </div>
        </div>
      </div>
    </section>
  )
}
