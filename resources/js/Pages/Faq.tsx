import { useState, type ReactNode } from 'react'
import { Plus, Minus } from 'lucide-react'
import Seo from '@/components/Seo'
import SiteLayout from '@/Layouts/SiteLayout'
import PageHeader from '@/components/site/PageHeader'
import { cn } from '@/lib/utils'
import { useI18n } from '@/lib/i18n'
import type { Faq as FaqItem } from '@/types/models'

interface Props {
  meta: { title: string; description: string }
  faqs: FaqItem[]
}

export default function FaqPage({ meta, faqs }: Props) {
  const { t } = useI18n()
  const fallback: FaqItem[] = [
    { id: -1, question: t('support.faq.items.q1'), answer: t('support.faq.items.a1') },
    { id: -2, question: t('support.faq.items.q2'), answer: t('support.faq.items.a2') },
    { id: -3, question: t('support.faq.items.q3'), answer: t('support.faq.items.a3') },
    { id: -4, question: t('support.faq.items.q4'), answer: t('support.faq.items.a4') },
    { id: -5, question: t('support.faq.items.q5'), answer: t('support.faq.items.a5') },
  ]
  const items = faqs.length ? faqs : fallback
  const [open, setOpen] = useState(0)

  return (
    <>
      <Seo title={meta.title} description={meta.description} />
      <PageHeader
        eyebrow={t('nav.faq')}
        title={t('support.faq.title')}
        description={t('support.faq.description')}
        crumbs={[{ label: t('nav.faq') }]}
      />

      <section className="mx-auto max-w-screen-2xl px-4 py-20 md:px-10 md:py-28" data-aos="fade-up">
        <div className="mx-auto flex max-w-3xl flex-col gap-3">
          {items.map((f, i) => {
            const isOpen = open === i
            return (
              <div key={f.id} className="rounded-2xl bg-stone-100" data-aos="fade-up" data-aos-delay={Math.min(i, 5) * 80}>
                <button
                  type="button"
                  aria-expanded={isOpen}
                  onClick={() => setOpen(isOpen ? -1 : i)}
                  className="flex w-full items-center justify-between gap-4 px-6 py-5 text-left"
                >
                  <span className="text-base font-semibold text-foreground md:text-lg">{f.question}</span>
                  <span
                    className={cn(
                      'grid h-8 w-8 shrink-0 place-items-center rounded-full transition-colors',
                      isOpen ? 'bg-brand-500 text-white' : 'bg-white text-stone-600',
                    )}
                  >
                    {isOpen ? <Minus className="h-4 w-4" /> : <Plus className="h-4 w-4" />}
                  </span>
                </button>
                {isOpen && (
                  <p className="px-6 pb-6 leading-relaxed text-stone-600">{f.answer}</p>
                )}
              </div>
            )
          })}
        </div>
      </section>
    </>
  )
}

FaqPage.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>
