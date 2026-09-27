import { type ReactNode } from 'react'
import { Link } from '@inertiajs/react'
import { ArrowRight, Check, Clock, CalendarDays, Phone, MessageCircle, Waves } from 'lucide-react'
import Seo from '@/components/Seo'
import SiteLayout from '@/Layouts/SiteLayout'
import PageHeader from '@/components/site/PageHeader'
import SectionHeading from '@/components/home/SectionHeading'
import { Button } from '@/components/ui/button'
import { cld, img } from '@/lib/media'
import { useSite, waLink } from '@/lib/site'
import { useI18n } from '@/lib/i18n'
import type { Service, Program } from '@/types/models'

interface Props {
  meta: { title: string; description: string }
  services: Service[]
  programs: Program[]
}

// Real swim photos under /assets/img — cycled for cards/rows without their own image.
const SWIM_PHOTOS = [
  'IMG_3383.JPG',
  'teacher/20240804_072031.jpg',
  'teacher/IMG_3473.JPG',
  'pict-1.JPG',
  'teacher/20241019_165350.jpg',
  'teacher/IMG_3599.JPG',
]

export default function ServicesPage({ meta, services, programs }: Props) {
  const site = useSite()
  const { t } = useI18n()

  // Curated defaults so the page never renders empty before the CMS is filled.
  const FALLBACK_SERVICES: Service[] = [
    {
      icon_class: null,
      title: t('services.fbBabyTitle'),
      short_desc: t('services.fbBabyDesc'),
      description: null,
    },
    {
      icon_class: null,
      title: t('services.fbKidsTitle'),
      short_desc: t('services.fbKidsDesc'),
      description: null,
    },
    {
      icon_class: null,
      title: t('services.fbAdultTitle'),
      short_desc: t('services.fbAdultDesc'),
      description: null,
    },
    {
      icon_class: null,
      title: t('services.fbPrivateTitle'),
      short_desc: t('services.fbPrivateDesc'),
      description: null,
    },
    {
      icon_class: null,
      title: t('services.fbCompTitle'),
      short_desc: t('services.fbCompDesc'),
      description: null,
    },
  ]

  const FALLBACK_PROGRAMS: Program[] = [
    {
      id: 1,
      name: t('services.fbBabyTitle'),
      age_range: t('services.p1Age'),
      schedule: t('services.p1Sched'),
      price: t('services.p1Price'),
      thumbnail: null,
      instructor: null,
      description: t('services.p1Desc'),
    },
    {
      id: 2,
      name: t('services.fbKidsTitle'),
      age_range: t('services.p2Age'),
      schedule: t('services.p2Sched'),
      price: t('services.p2Price'),
      thumbnail: null,
      instructor: null,
      description: t('services.p2Desc'),
    },
    {
      id: 3,
      name: t('services.fbAdultTitle'),
      age_range: t('services.p3Age'),
      schedule: t('services.p3Sched'),
      price: t('services.p3Price'),
      thumbnail: null,
      instructor: null,
      description: t('services.p3Desc'),
    },
    {
      id: 4,
      name: t('services.fbPrivateTitle'),
      age_range: t('services.p4Age'),
      schedule: t('services.p4Sched'),
      price: t('services.p4Price'),
      thumbnail: null,
      instructor: null,
      description: t('services.p4Desc'),
    },
    {
      id: 5,
      name: t('services.fbCompTitle'),
      age_range: t('services.p5Age'),
      schedule: t('services.p5Sched'),
      price: t('services.p5Price'),
      thumbnail: null,
      instructor: null,
      description: t('services.p5Desc'),
    },
  ]

  const serviceList = services.length > 0 ? services : FALLBACK_SERVICES
  const programList = programs.length > 0 ? programs : FALLBACK_PROGRAMS

  return (
    <>
      <Seo title={meta.title} description={meta.description} />

      <PageHeader
        eyebrow={t('nav.services')}
        title={t('services.headerTitle')}
        description={t('services.headerDesc')}
        crumbs={[{ label: t('nav.services') }]}
      />

      {/* SERVICES GRID */}
      <section className="mx-auto max-w-screen-2xl px-4 py-20 md:px-10 md:py-28" data-aos="fade-up">
        <SectionHeading
          align="left"
          eyebrow={t('services.gridEyebrow')}
          title={t('services.gridTitle')}
          description={t('services.gridDesc')}
        />

        <div className="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          {serviceList.map((s, i) => (
            <article
              key={`${s.title}-${i}`}
              className="group flex flex-col overflow-hidden rounded-3xl border border-stone-200 bg-stone-100"
              data-aos="fade-up"
              data-aos-delay={Math.min(i, 5) * 80}
            >
              <div className="m-2 overflow-hidden rounded-2xl">
                <img
                  src={img(null, SWIM_PHOTOS[i % SWIM_PHOTOS.length])}
                  alt={s.title}
                  className="h-56 w-full object-cover transition-transform duration-500 group-hover:scale-105"
                  loading="lazy"
                />
              </div>
              <div className="flex flex-1 flex-col gap-3 px-6 pb-7 pt-4">
                <span className="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-brand-500 text-white">
                  <Waves className="h-5 w-5" />
                </span>
                <h3 className="text-xl font-medium tracking-tight text-foreground">{s.title}</h3>
                {s.short_desc && (
                  <p className="text-sm leading-relaxed text-muted-foreground">{s.short_desc}</p>
                )}
                <span className="mt-auto inline-flex items-center gap-1.5 pt-2 text-sm font-medium text-brand-500">
                  {t('services.cardCta')}
                  <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" />
                </span>
              </div>
            </article>
          ))}

          {/* Consultation card (matches reference dark tile) */}
          <div className="flex flex-col justify-between gap-6 rounded-3xl bg-night p-8 text-white" data-aos="fade-up">
            <span className="inline-flex w-fit items-center rounded-full bg-brand-900 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider text-peach">
              {t('services.consultBadge')}
            </span>
            <div className="flex flex-col gap-4">
              <h3 className="text-2xl font-medium leading-tight tracking-tight">
                {t('services.consultTitle')}
              </h3>
              <p className="text-sm leading-relaxed text-stone-400">
                {t('services.consultDesc')}
              </p>
              <Button asChild className="w-fit">
                <Link href="/kontak">{t('services.consultCta')}</Link>
              </Button>
            </div>
          </div>
        </div>
      </section>

      {/* PROGRAM LEVELS — alternating zig-zag rows */}
      <section className="bg-secondary" data-aos="fade-up">
        <div className="mx-auto max-w-screen-2xl px-4 py-20 md:px-10 md:py-28">
          <SectionHeading
            align="left"
            eyebrow={t('services.programsEyebrow')}
            title={t('services.programsTitle')}
            description={t('services.programsDesc')}
          />

          <div className="mt-16 flex flex-col gap-16 md:gap-24">
            {programList.map((p, i) => {
              const reversed = i % 2 === 1
              return (
                <div
                  key={p.id}
                  className="grid items-center gap-8 md:grid-cols-2 md:gap-14"
                >
                  <div className={reversed ? 'md:order-2' : ''} data-aos={reversed ? 'fade-left' : 'fade-right'}>
                    <div className="overflow-hidden rounded-3xl">
                      <img
                        src={img(p.thumbnail, SWIM_PHOTOS[i % SWIM_PHOTOS.length])}
                        alt={p.name}
                        className="aspect-[4/3] w-full object-cover"
                        loading="lazy"
                      />
                    </div>
                  </div>

                  <div className={reversed ? 'md:order-1' : ''} data-aos={reversed ? 'fade-right' : 'fade-left'}>
                    <div className="flex flex-wrap items-center gap-2">
                      {p.age_range && (
                        <span className="inline-flex items-center rounded-full bg-brand-50 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider text-brand-700">
                          {p.age_range}
                        </span>
                      )}
                      {p.price && (
                        <span className="inline-flex items-center rounded-full bg-brand-500 px-3.5 py-1.5 text-xs font-semibold text-white">
                          {p.price}
                        </span>
                      )}
                    </div>

                    <h3 className="mt-4 text-3xl font-medium leading-tight tracking-tight text-foreground md:text-4xl">
                      {p.name}
                    </h3>

                    {p.description && (
                      <p className="mt-4 max-w-xl text-base leading-relaxed text-muted-foreground">
                        {p.description}
                      </p>
                    )}

                    <div className="mt-5 flex flex-col gap-2 text-sm text-stone-600">
                      {p.schedule && (
                        <span className="inline-flex items-center gap-2">
                          <Clock className="h-4 w-4 text-brand-500" />
                          {p.schedule}
                        </span>
                      )}
                      {p.instructor && (
                        <span className="inline-flex items-center gap-2">
                          <CalendarDays className="h-4 w-4 text-brand-500" />
                          {t('services.coachLabel')} {p.instructor}
                        </span>
                      )}
                    </div>

                    <Button asChild size="lg" className="mt-7">
                      <Link href="/daftar">
                        {t('services.enroll')}
                        <ArrowRight className="h-4 w-4" />
                      </Link>
                    </Button>
                  </div>
                </div>
              )
            })}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="mx-auto max-w-screen-2xl px-4 py-20 md:px-10 md:py-28" data-aos="fade-up">
        <div className="overflow-hidden rounded-4xl bg-brand-500 px-6 py-14 text-center text-white md:px-16 md:py-20">
          <h2 className="mx-auto max-w-2xl text-3xl font-medium leading-tight tracking-tight md:text-4xl lg:text-5xl">
            {t('services.ctaTitle')}
          </h2>
          <p className="mx-auto mt-4 max-w-xl text-base leading-relaxed text-brand-50">
            {t('services.ctaDesc')}
          </p>
          <div className="mt-8 flex flex-wrap items-center justify-center gap-3">
            <Button asChild size="lg" className="bg-white text-brand-600 shadow-sm hover:bg-white/90">
              <Link href="/kontak">
                <Phone className="h-4 w-4" />
                {t('services.ctaCall')}
              </Link>
            </Button>
            <Button
              asChild
              size="lg"
              variant="outline"
              className="border-white/40 bg-transparent text-white hover:bg-white/10 hover:text-white"
            >
              <a href={waLink(site.whatsapp ?? '', site.whatsapp_message)} target="_blank" rel="noopener noreferrer">
                <MessageCircle className="h-4 w-4" />
                WhatsApp
              </a>
            </Button>
          </div>
        </div>
      </section>
    </>
  )
}

ServicesPage.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>
