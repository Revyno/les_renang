import { Link } from '@inertiajs/react'
import { ChevronLeft, ChevronRight } from 'lucide-react'
import useEmblaCarousel from 'embla-carousel-react'
import Autoplay from 'embla-carousel-autoplay'
import { cld } from '@/lib/media'
import type { Service } from '@/types/models'

// Service has no image field, so cards cycle real swim photos by index.
const PHOTOS = [
  'teacher/IMG_3473.JPG',
  'teacher/20240804_072031.jpg',
  'teacher/IMG_3599.JPG',
  'teacher/20241019_165350.jpg',
  'IMG_3383.JPG',
]

const FALLBACK: Service[] = [
  { icon_class: null, title: 'Kelas Bayi & Balita', short_desc: 'Pengenalan air yang lembut bersama orang tua.', description: null },
  { icon_class: null, title: 'Kelas Anak', short_desc: 'Dasar gaya bebas, dada, dan punggung.', description: null },
  { icon_class: null, title: 'Kelas Dewasa', short_desc: 'Belajar dari nol atau memperbaiki teknik.', description: null },
  { icon_class: null, title: 'Private Coaching', short_desc: 'Satu pelatih fokus pada target pribadimu.', description: null },
  { icon_class: null, title: 'Persiapan Kompetisi', short_desc: 'Teknik start, pembalikan, dan stamina lomba.', description: null },
]

export default function Services({ data }: { data: Service[] }) {
  const services = data.length > 0 ? data : FALLBACK
  const [emblaRef, emblaApi] = useEmblaCarousel(
    { loop: true, align: 'start' },
    [Autoplay({ delay: 2800, stopOnInteraction: false, stopOnMouseEnter: true })],
  )

  return (
    <section className="px-4">
      <div className="mx-auto flex max-w-screen-2xl flex-col items-center gap-14 overflow-hidden rounded-4xl bg-night py-20 text-white md:py-24">
        <div className="flex max-w-3xl flex-col items-center gap-6 px-6 text-center" data-aos="fade-up">
          <span className="inline-flex items-center rounded-full bg-brand-900 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider text-peach">
            Program unggulan
          </span>
          <h2 className="text-3xl font-medium leading-[1.12] tracking-tight md:text-4xl lg:text-5xl">
            Kami mendampingi setiap murid dari kolam pertama hingga percaya diri di air.
          </h2>
          <Link
            href="/layanan"
            className="inline-flex h-12 items-center rounded-full bg-brand-500 px-6 text-sm font-semibold text-white transition-colors hover:bg-brand-600"
          >
            Semua layanan
          </Link>
        </div>

        <div className="w-full">
          <div className="overflow-hidden px-6 md:px-16" ref={emblaRef}>
            <div className="flex gap-4">
              {services.map((s, i) => (
                <Link
                  key={i}
                  href="/layanan"
                  data-aos="fade-up"
                  data-aos-delay={Math.min(i, 5) * 120}
                  className="flex w-[300px] min-w-0 shrink-0 flex-col overflow-hidden rounded-2xl border border-night-line bg-night-card text-white transition-colors hover:border-brand-500"
                >
                  <div className="h-64 overflow-hidden">
                    <img
                      src={cld(PHOTOS[i % PHOTOS.length])}
                      alt=""
                      className="h-full w-full object-cover transition-transform duration-500 hover:scale-105"
                      loading="lazy"
                    />
                  </div>
                  <div className="flex flex-col gap-1.5 px-5 pb-6 pt-4">
                    <span className="text-lg font-semibold">{s.title}</span>
                    {s.short_desc && <span className="text-sm leading-relaxed text-stone-400">{s.short_desc}</span>}
                  </div>
                </Link>
              ))}
            </div>
          </div>

          <div className="mt-8 flex justify-center gap-2.5">
            <button
              type="button"
              onClick={() => emblaApi?.scrollPrev()}
              aria-label="Sebelumnya"
              className="grid h-12 w-12 place-items-center rounded-full border border-night-line text-white transition-colors hover:bg-white/10"
            >
              <ChevronLeft className="h-5 w-5" />
            </button>
            <button
              type="button"
              onClick={() => emblaApi?.scrollNext()}
              aria-label="Berikutnya"
              className="grid h-12 w-12 place-items-center rounded-full bg-white text-night transition-colors hover:bg-stone-200"
            >
              <ChevronRight className="h-5 w-5" />
            </button>
          </div>
        </div>
      </div>
    </section>
  )
}
