import { type ReactNode } from 'react'
import { Link } from '@inertiajs/react'
import Seo from '@/components/Seo'
import SiteLayout from '@/Layouts/SiteLayout'
import PageHeader from '@/components/site/PageHeader'
import Faq from '@/components/home/Faq'
import { Button } from '@/components/ui/button'
import type { Faq as FaqItem } from '@/types/models'

interface Props {
  meta: { title: string; description: string }
  faqs: FaqItem[]
}

export default function FaqPage({ meta, faqs }: Props) {
  return (
    <>
      <Seo title={meta.title} description={meta.description} />
      <PageHeader
        title="Pertanyaan yang Sering Diajukan"
        description="Jawaban atas hal-hal yang paling sering ditanyakan seputar les renang di Les Renang."
        crumbs={[{ label: 'FAQ' }]}
      />
      <Faq data={faqs} />

      <section className="pb-24">
        <div className="container text-center">
          <p className="text-muted-foreground">Masih ada pertanyaan lain?</p>
          <Button asChild className="mt-4">
            <Link href="/kontak">Hubungi Kami</Link>
          </Button>
        </div>
      </section>
    </>
  )
}

FaqPage.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>
