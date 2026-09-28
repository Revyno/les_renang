import { type ReactNode } from 'react'
import { Link } from '@inertiajs/react'
import { ArrowRight, Check, ShieldCheck, HeartHandshake, Sparkles, CalendarClock } from 'lucide-react'
import Seo from '@/components/Seo'
import SiteLayout from '@/Layouts/SiteLayout'
import PageHeader from '@/components/site/PageHeader'
import SectionHeading from '@/components/home/SectionHeading'
import { Button } from '@/components/ui/button'
import { img, cld } from '@/lib/media'
import { BRAND } from '@/lib/brand'
import { useI18n } from '@/lib/i18n'
import RichText from '@/components/RichText'
import type { About as AboutData, Stat, Instructor } from '@/types/models'

interface Props {
  meta: { title: string; description: string }
  about: AboutData | null
  stats: Stat[]
  instructors: Instructor[]
}

export default function AboutPage({ meta, about, instructors }: Props) {
  const { t } = useI18n()

  const VALUES = [
    {
      icon: ShieldCheck,
      title: t('about.valSafeTitle'),
      desc: t('about.valSafeDesc'),
    },
    {
      icon: HeartHandshake,
      title: t('about.valPersonalTitle'),
      desc: t('about.valPersonalDesc'),
    },
    {
      icon: Sparkles,
      title: t('about.valModernTitle'),
      desc: t('about.valModernDesc'),
    },
    {
      icon: CalendarClock,
      title: t('about.valFlexTitle'),
      desc: t('about.valFlexDesc'),
    },
  ]

  const FALLBACK_COACHES = [
    { name: t('about.coach1Name'), specialization: t('about.coach1Spec'), certification: t('about.coach1Cert'), bio: t('about.coach1Bio'), photo: cld('team/team-1.jpg') },
    { name: t('about.coach2Name'), specialization: t('about.coach2Spec'), certification: t('about.coach2Cert'), bio: t('about.coach2Bio'), photo: cld('team/team-2.jpg') },
    { name: t('about.coach3Name'), specialization: t('about.coach3Spec'), certification: t('about.coach3Cert'), bio: t('about.coach3Bio'), photo: cld('team/team-3.jpg') },
  ]

  const description =
    about?.description ||
    `${BRAND.name} ${t('about.descFallback')}`
  const coaches = instructors.length ? instructors : FALLBACK_COACHES

  return (
    <>
      <Seo title={meta.title} description={meta.description} />
      <PageHeader
        eyebrow={t('nav.about')}
        title={about?.title || `${t('nav.about')} ${BRAND.name}`}
        description={t('about.headerDesc')}
        crumbs={[{ label: t('nav.about') }]}
      />

      {/* Section 1 — intro */}
      <section className="mx-auto grid max-w-screen-2xl items-center gap-12 px-4 py-20 md:grid-cols-2 md:px-10 md:py-28">
        <div className="flex flex-col gap-5" data-aos="fade-right">
          <span className="inline-flex w-fit items-center rounded-full bg-brand-50 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider text-brand-700">
            {t('about.storyEyebrow')}
          </span>
          <h2 className="text-3xl font-medium leading-tight tracking-tight text-foreground md:text-4xl">
            {t('about.storyTitle')}
          </h2>
          <RichText html={description} className="text-base leading-relaxed text-muted-foreground md:text-lg" />
        </div>
        <div className="overflow-hidden rounded-4xl bg-stone-100" data-aos="fade-left">
          <img
            src={img(about?.img, 'about.jpg')}
            alt={about?.title || `${t('about.trainingAtAlt')} ${BRAND.name}`}
            className="aspect-[4/5] w-full object-cover"
          />
        </div>
      </section>

      {/* Section 2 — values */}
      <section className="mx-auto max-w-screen-2xl px-4 pb-20 md:px-10 md:pb-28" data-aos="fade-up">
        <SectionHeading
          align="left"
          eyebrow={t('about.valuesEyebrow')}
          title={t('about.valuesTitle')}
        />
        <div className="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
          {VALUES.map((v, i) => (
            <div key={v.title} className="flex flex-col gap-4 rounded-3xl border border-stone-200 bg-stone-100 p-7" data-aos="fade-up" data-aos-delay={Math.min(i, 5) * 80}>
              <span className="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand-500 text-white">
                <Check className="h-5 w-5" />
              </span>
              <div className="flex flex-col gap-1.5">
                <h3 className="text-lg font-medium tracking-tight text-foreground">{v.title}</h3>
                <p className="text-sm leading-relaxed text-muted-foreground">{v.desc}</p>
              </div>
            </div>
          ))}
        </div>
      </section>

      {/* Section 4 — team */}
      <section id="tim" className="bg-night" data-aos="fade-up">
        <div className="mx-auto max-w-screen-2xl px-4 py-20 md:px-10 md:py-28">
          <SectionHeading
            tone="dark"
            eyebrow={t('about.teamEyebrow')}
            title={t('about.teamHeadingTitle')}
            description={t('about.teamHeadingDesc')}
          />
          <div className="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            {coaches.map((c, i) => (
              <div
                key={`${c.name}-${i}`}
                className="overflow-hidden rounded-3xl border border-night-line bg-night-card"
                data-aos="fade-up"
                data-aos-delay={Math.min(i, 5) * 80}
              >
                <img
                  src={img(c.photo, `team/team-${(i % 3) + 1}.jpg`)}
                  alt={`${t('about.photoAlt')} ${c.name}`}
                  className="aspect-[4/5] w-full object-cover"
                />
                <div className="flex flex-col gap-3 p-6">
                  <div className="flex flex-col gap-1">
                    <h3 className="text-lg font-medium tracking-tight text-white">{c.name}</h3>
                    {c.specialization && <p className="text-sm text-stone-400">{c.specialization}</p>}
                  </div>
                  {c.bio && <p className="text-sm leading-relaxed text-stone-400">{c.bio}</p>}
                  {/* {c.certification && (
                    <span className="inline-flex w-fit items-center gap-1.5 rounded-full bg-brand-900 px-3 py-1 text-xs font-medium text-peach">
                      <Check className="h-3.5 w-3.5" />
                      {c.certification}
                    </span>
                  )} */}
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="mx-auto max-w-screen-2xl px-4 py-20 md:px-10 md:py-24" data-aos="fade-up">
        <div className="rounded-4xl bg-primary p-10 text-center text-primary-foreground md:p-16">
          <h2 className="text-2xl font-medium tracking-tight md:text-4xl">{t('about.ctaTitle')}</h2>
          <p className="mx-auto mt-3 max-w-xl text-primary-foreground/80">
            {t('about.ctaSubtitlePre')} {BRAND.name} {t('about.ctaSubtitlePost')}
          </p>
          <div className="mt-8 flex flex-wrap justify-center gap-3">
            <Button asChild size="lg" variant="accent">
              <Link href="/layanan">
                {t('about.ctaPrograms')}
                <ArrowRight className="h-4 w-4" />
              </Link>
            </Button>
            <Button asChild size="lg" variant="outline" className="border-white/30 text-white hover:bg-white/10 hover:text-white">
              <Link href="/kontak">{t('about.ctaConsult')}</Link>
            </Button>
          </div>
        </div>
      </section>
    </>
  )
}

AboutPage.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>
