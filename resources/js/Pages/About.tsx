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
import type { About as AboutData, Stat, Instructor } from '@/types/models'

interface Props {
  meta: { title: string; description: string }
  about: AboutData | null
  stats: Stat[]
  instructors: Instructor[]
}

const VALUES = [
  {
    icon: ShieldCheck,
    title: 'Aman & terawasi',
    desc: 'Protokol air yang ketat dan pengawasan penuh pada setiap sesi latihan.',
  },
  {
    icon: HeartHandshake,
    title: 'Pendekatan personal',
    desc: 'Kelas kecil dan sabar, terutama untuk murid yang masih takut air.',
  },
  {
    icon: Sparkles,
    title: 'Metode modern',
    desc: 'Kurikulum berjenjang dengan progres yang jelas dan mudah dipantau.',
  },
  {
    icon: CalendarClock,
    title: 'Jadwal fleksibel',
    desc: 'Pilih waktu latihan yang paling pas dengan rutinitas Anda.',
  },
]

const FALLBACK_COACHES = [
  { name: 'Kepala Pelatih', specialization: 'Renang Prestasi', certification: 'Bersertifikat Nasional', bio: 'Memimpin program prestasi dengan pengalaman melatih perenang dari usia dini hingga tingkat kompetisi.', photo: cld('team/team-1.jpg') },
  { name: 'Pelatih Anak', specialization: 'Kelas Anak & Pemula', certification: 'Water Safety', bio: 'Sabar dan telaten mendampingi anak mengenal air dengan pendekatan yang aman dan menyenangkan.', photo: cld('team/team-2.jpg') },
  { name: 'Pelatih Dewasa', specialization: 'Teknik & Ketahanan', certification: 'Lisensi Pelatih', bio: 'Fokus pada perbaikan teknik gaya dan ketahanan untuk perenang dewasa di segala level.', photo: cld('team/team-3.jpg') },
]

export default function AboutPage({ meta, about, instructors }: Props) {
  const description =
    about?.description ||
    `${BRAND.name} adalah sekolah renang di Surabaya yang fokus pada keselamatan, kenyamanan, dan kemajuan setiap murid. Kami mendampingi anak hingga dewasa belajar berenang secara bertahap, aman, dan menyenangkan.`
  const coaches = instructors.length ? instructors : FALLBACK_COACHES

  return (
    <>
      <Seo title={meta.title} description={meta.description} />
      <PageHeader
        eyebrow="Tentang"
        title={about?.title || `Tentang ${BRAND.name}`}
        description="Sekolah renang di Surabaya yang fokus pada keselamatan, kenyamanan, dan kemajuan setiap murid."
        crumbs={[{ label: 'Tentang' }]}
      />

      {/* Section 1 — intro */}
      <section className="mx-auto grid max-w-screen-2xl items-center gap-12 px-4 py-20 md:grid-cols-2 md:px-10 md:py-28">
        <div className="flex flex-col gap-5" data-aos="fade-right">
          <span className="inline-flex w-fit items-center rounded-full bg-brand-50 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider text-brand-700">
            Cerita kami
          </span>
          <h2 className="text-3xl font-medium leading-tight tracking-tight text-foreground md:text-4xl">
            Dibangun dari pengalaman. Digerakkan oleh kepedulian.
          </h2>
          <p className="whitespace-pre-line text-base leading-relaxed text-muted-foreground md:text-lg">{description}</p>
        </div>
        <div className="overflow-hidden rounded-4xl bg-stone-100" data-aos="fade-left">
          <img
            src={img(about?.img, 'about.jpg')}
            alt={about?.title || `Suasana latihan di ${BRAND.name}`}
            className="aspect-[4/5] w-full object-cover"
          />
        </div>
      </section>

      {/* Section 2 — values */}
      <section className="mx-auto max-w-screen-2xl px-4 pb-20 md:px-10 md:pb-28" data-aos="fade-up">
        <SectionHeading
          align="left"
          eyebrow="Kenapa memilih kami"
          title="Alasan keluarga mempercayakan latihan renang kepada kami"
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
            eyebrow="Tim Pelatih"
            title="Dibimbing oleh yang ahli"
            description="Pelatih berpengalaman dan bersertifikat yang siap mendampingi perjalanan renang Anda."
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
                  alt={`Foto ${c.name}`}
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
          <h2 className="text-2xl font-medium tracking-tight md:text-4xl">Siap mulai perjalanan renang Anda?</h2>
          <p className="mx-auto mt-3 max-w-xl text-primary-foreground/80">
            Temukan program yang paling sesuai dan mulai latihan bersama {BRAND.name} hari ini.
          </p>
          <div className="mt-8 flex flex-wrap justify-center gap-3">
            <Button asChild size="lg" variant="accent">
              <Link href="/layanan">
                Lihat Program
                <ArrowRight className="h-4 w-4" />
              </Link>
            </Button>
            <Button asChild size="lg" variant="outline" className="border-white/30 text-white hover:bg-white/10 hover:text-white">
              <Link href="/kontak">Konsultasi Gratis</Link>
            </Button>
          </div>
        </div>
      </section>
    </>
  )
}

AboutPage.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>
