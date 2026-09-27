import { type ReactNode } from 'react'
import { ArrowRight, Clock, MessageCircle, Users } from 'lucide-react'
import Seo from '@/components/Seo'
import SiteLayout from '@/Layouts/SiteLayout'
import PageHeader from '@/components/site/PageHeader'
import SectionHeading from '@/components/home/SectionHeading'
import { Button } from '@/components/ui/button'
import { img, cld } from '@/lib/media'
import { useSite, waLink } from '@/lib/site'
import { useI18n } from '@/lib/i18n'
import type { Program } from '@/types/models'

interface Props {
  meta: { title: string; description: string }
  programs: Program[]
}

// Real swim photos under /assets/img — cycled for cards without their own thumbnail.
const SWIM_PHOTOS = [
  'IMG_3383.JPG',
  'teacher/20240804_072031.jpg',
  'teacher/IMG_3473.JPG',
  'pict-1.JPG',
  'teacher/20241019_165350.jpg',
  'teacher/IMG_3599.JPG',
]

// Curated defaults so the grid never renders blank when the CMS is empty.
const FALLBACK_PROGRAMS: Program[] = [
  {
    id: -1,
    name: 'Kelas Bayi & Balita',
    age_range: '6 bln – 3 thn',
    schedule: 'Sabtu & Minggu',
    price: 'Mulai Rp350rb',
    thumbnail: null,
    description: 'Pengenalan air yang lembut bersama orang tua untuk membangun rasa nyaman sejak dini.',
    instructor: 'Pelatih bersertifikat',
  },
  {
    id: -2,
    name: 'Kelas Anak',
    age_range: '4 – 12 thn',
    schedule: 'Jadwal fleksibel',
    price: 'Mulai Rp400rb',
    thumbnail: null,
    description: 'Dasar gaya bebas, dada, dan punggung dengan kelompok kecil sesuai level.',
    instructor: 'Pelatih bersertifikat',
  },
  {
    id: -3,
    name: 'Kelas Dewasa',
    age_range: '13 thn ke atas',
    schedule: 'Pagi & sore',
    price: 'Mulai Rp450rb',
    thumbnail: null,
    description: 'Belajar dari nol atau memperbaiki teknik — jadwal fleksibel untuk pekerja.',
    instructor: 'Pelatih bersertifikat',
  },
  {
    id: -4,
    name: 'Private Coaching',
    age_range: 'Semua usia',
    schedule: 'Sesuai kesepakatan',
    price: 'Hubungi kami',
    thumbnail: null,
    description: 'Satu pelatih untuk satu murid, fokus penuh pada target pribadi Anda.',
    instructor: 'Pelatih bersertifikat',
  },
]

export default function RegisterProgramPage({ meta, programs }: Props) {
  const site = useSite()
  const { t } = useI18n()
  const list = programs.length > 0 ? programs : FALLBACK_PROGRAMS

  const STEPS = [
    { n: 1, title: t('register.programs.choose'), desc: t('register.steps.s1Desc') },
    { n: 2, title: t('common.contactUs'), desc: t('register.steps.s2Desc') },
    { n: 3, title: t('register.steps.s3Title'), desc: t('register.steps.s3Desc') },
  ]

  // ponytail: enrollment/payment is admin business logic (out of frontend scope) —
  // registration is routed to WhatsApp confirmation. Upgrade: wire to a Registration
  // model + auth when the enrollment flow is in scope.
  const daftar = (name: string) =>
    site.whatsapp
      ? waLink(site.whatsapp, t('register.wa.message').replace('{name}', name))
      : '/kontak'

  return (
    <>
      <Seo title={meta.title} description={meta.description} />
      <PageHeader
        eyebrow={t('register.header.eyebrow')}
        title={t('register.header.title')}
        description={t('register.header.description')}
        crumbs={[{ label: t('register.header.crumb') }]}
      />

      {/* Programs grid */}
      <section className="mx-auto max-w-screen-2xl px-4 py-20 md:px-10 md:py-28">
        <SectionHeading
          align="left"
          eyebrow={t('register.programs.eyebrow')}
          title={t('register.programs.title')}
          description={t('register.programs.description')}
        />

        <div className="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          {list.map((p, i) => (
            <article
              key={p.id}
              className="flex flex-col overflow-hidden rounded-3xl border border-stone-200 bg-stone-100"
              data-aos="fade-up"
              data-aos-delay={Math.min(i, 5) * 80}
            >
              <div className="m-2 h-52 overflow-hidden rounded-2xl">
                <img
                  src={img(p.thumbnail, SWIM_PHOTOS[i % SWIM_PHOTOS.length])}
                  alt={p.name}
                  className="h-full w-full object-cover transition-transform duration-300 hover:scale-105"
                  loading="lazy"
                />
              </div>

              <div className="flex flex-1 flex-col gap-3 px-6 pb-7 pt-3">
                <div className="flex items-start justify-between gap-3">
                  <h3 className="text-xl font-medium tracking-tight text-foreground">{p.name}</h3>
                  {p.age_range && (
                    <span className="mt-0.5 shrink-0 rounded-full bg-white px-3 py-1 text-xs font-medium text-stone-600">
                      {p.age_range}
                    </span>
                  )}
                </div>

                {p.description && (
                  <p className="line-clamp-2 text-sm leading-relaxed text-stone-600">{p.description}</p>
                )}

                <ul className="mt-1 space-y-2 text-sm text-stone-600">
                  {p.schedule && (
                    <li className="flex items-center gap-2">
                      <Clock className="h-4 w-4 text-brand-500" />
                      {p.schedule}
                    </li>
                  )}
                  {p.instructor && (
                    <li className="flex items-center gap-2">
                      <Users className="h-4 w-4 text-brand-500" />
                      {p.instructor}
                    </li>
                  )}
                </ul>

                <div className="mt-auto flex flex-col gap-4 pt-5">
                  {p.price && (
                    <span className="inline-flex w-fit items-center rounded-full bg-brand-50 px-3.5 py-1.5 text-sm font-semibold text-brand-700">
                      {p.price}
                    </span>
                  )}
                  <Button asChild className="w-full">
                    <a href={daftar(p.name)} target="_blank" rel="noopener noreferrer">
                      <MessageCircle />
                      {t('register.programs.choose')}
                    </a>
                  </Button>
                </div>
              </div>
            </article>
          ))}
        </div>
      </section>

      {/* Cara mendaftar + WhatsApp CTA */}
      <section className="border-t border-border">
        <div className="mx-auto grid max-w-screen-2xl gap-12 px-4 py-20 md:grid-cols-2 md:px-10 md:py-28">
          <div data-aos="fade-right">
            <SectionHeading
              align="left"
              eyebrow={t('register.how.eyebrow')}
              title={t('register.how.title')}
              description={t('register.how.description')}
            />
            <ol className="mt-10 space-y-6">
              {STEPS.map((s) => (
                <li key={s.n} className="flex gap-4">
                  <span className="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-brand-500 text-base font-medium text-white">
                    {s.n}
                  </span>
                  <div>
                    <h3 className="text-lg font-medium tracking-tight text-foreground">{s.title}</h3>
                    <p className="mt-1 text-sm leading-relaxed text-stone-600">{s.desc}</p>
                  </div>
                </li>
              ))}
            </ol>
          </div>

          <div className="flex flex-col justify-between gap-8 rounded-4xl bg-night p-8 md:p-10" data-aos="fade-left">
            <div
              className="h-44 w-full rounded-3xl bg-cover bg-center"
              style={{ backgroundImage: `url(${cld('working-2.jpg')})` }}
              aria-hidden
            />
            <div className="flex flex-col gap-4">
              <span className="inline-flex w-fit items-center rounded-full bg-brand-900 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider text-peach">
                {t('register.cta.badge')}
              </span>
              <h3 className="text-2xl font-medium leading-tight tracking-tight text-white md:text-3xl">
                {t('register.cta.title')}
              </h3>
              <p className="text-stone-400">
                {t('register.cta.description')}
              </p>
              <Button asChild size="lg" className="mt-2 w-fit">
                <a
                  href={site.whatsapp ? waLink(site.whatsapp, site.whatsapp_message) : '/kontak'}
                  target="_blank"
                  rel="noopener noreferrer"
                >
                  {t('register.cta.button')}
                  <ArrowRight />
                </a>
              </Button>
            </div>
          </div>
        </div>
      </section>
    </>
  )
}

RegisterProgramPage.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>
