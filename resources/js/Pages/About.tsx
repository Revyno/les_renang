import { type ReactNode } from 'react'
import { Link } from '@inertiajs/react'
import Seo from '@/components/Seo'
import SiteLayout from '@/Layouts/SiteLayout'
import PageHeader from '@/components/site/PageHeader'
import About from '@/components/home/About'
import Stats from '@/components/home/Stats'
import Instructors from '@/components/home/Instructors'
import { Button } from '@/components/ui/button'
import type { About as AboutData, Stat, Instructor } from '@/types/models'

interface Props {
  meta: { title: string; description: string }
  about: AboutData | null
  stats: Stat[]
  instructors: Instructor[]
}

export default function AboutPage({ meta, about, stats, instructors }: Props) {
  return (
    <>
      <Seo title={meta.title} description={meta.description} />
      <PageHeader
        title="Tentang Les Renang"
        description="Sekolah renang yang mendampingi setiap murid belajar dengan aman, terstruktur, dan menyenangkan."
        crumbs={[{ label: 'Tentang' }]}
      />
      <About data={about} />
      <Stats data={stats} />
      <Instructors data={instructors} />

      <section className="pb-24">
        <div className="container">
          <div className="rounded-3xl bg-secondary/50 p-10 text-center md:p-14">
            <h2 className="text-2xl font-bold text-primary md:text-3xl">Siap bergabung bersama kami?</h2>
            <p className="mx-auto mt-3 max-w-xl text-muted-foreground">
              Temukan program yang paling sesuai dan mulai perjalanan renang Anda hari ini.
            </p>
            <Button asChild size="lg" className="mt-6">
              <Link href="/daftar">Lihat Program</Link>
            </Button>
          </div>
        </div>
      </section>
    </>
  )
}

AboutPage.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>
