import { type ReactNode } from 'react'
import { Link } from '@inertiajs/react'
import Seo from '@/components/Seo'
import SiteLayout from '@/Layouts/SiteLayout'
import PageHeader from '@/components/site/PageHeader'
import Services from '@/components/home/Services'
import Programs from '@/components/home/Programs'
import { Button } from '@/components/ui/button'
import type { Service, Program } from '@/types/models'

interface Props {
  meta: { title: string; description: string }
  services: Service[]
  programs: Program[]
}

export default function ServicesPage({ meta, services, programs }: Props) {
  return (
    <>
      <Seo title={meta.title} description={meta.description} />
      <PageHeader
        title="Layanan & Program"
        description="Dari pengenalan air untuk pemula hingga persiapan lomba — pilih layanan yang sesuai kebutuhan Anda."
        crumbs={[{ label: 'Layanan' }]}
      />
      <Services data={services} />
      <Programs data={programs} />

      <section className="pb-24">
        <div className="container">
          <div className="rounded-3xl bg-primary p-10 text-center text-primary-foreground md:p-14">
            <h2 className="text-2xl font-bold md:text-3xl">Belum yakin pilih yang mana?</h2>
            <p className="mx-auto mt-3 max-w-xl text-primary-foreground/80">
              Tim kami siap membantu Anda memilih program yang paling tepat sesuai usia dan tujuan.
            </p>
            <Button asChild size="lg" variant="accent" className="mt-6">
              <Link href="/kontak">Konsultasi Gratis</Link>
            </Button>
          </div>
        </div>
      </section>
    </>
  )
}

ServicesPage.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>
