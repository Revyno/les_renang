import { useState, type ReactNode } from 'react'
import { Plus, Minus } from 'lucide-react'
import Seo from '@/components/Seo'
import SiteLayout from '@/Layouts/SiteLayout'
import PageHeader from '@/components/site/PageHeader'
import { cn } from '@/lib/utils'
import type { Faq as FaqItem } from '@/types/models'

interface Props {
  meta: { title: string; description: string }
  faqs: FaqItem[]
}

const FALLBACK: FaqItem[] = [
  {
    id: -1,
    question: 'Mulai usia berapa anak bisa ikut kelas?',
    answer:
      'Kelas pengenalan air dimulai dari usia balita. Pelatih menilai kesiapan anak di sesi pertama sebelum menentukan level yang tepat.',
  },
  {
    id: -2,
    question: 'Apakah perlu membawa perlengkapan sendiri?',
    answer:
      'Cukup bawa baju renang, kacamata, dan handuk. Papan pelampung dan alat bantu latihan sudah kami sediakan.',
  },
  {
    id: -3,
    question: 'Bagaimana jika sesi latihan terlewat?',
    answer:
      'Sesi dapat dijadwalkan ulang dengan pemberitahuan sebelumnya sesuai ketersediaan jadwal pelatih.',
  },
  {
    id: -4,
    question: 'Di mana lokasi kolam latihan?',
    answer:
      'Latihan berlangsung di kolam mitra kami di Surabaya. Hubungi kami untuk alamat lengkap dan jadwal kolam terdekat.',
  },
  {
    id: -5,
    question: 'Apakah tersedia kelas privat?',
    answer:
      'Ya, tersedia Private Coaching dengan satu pelatih untuk satu murid. Hubungi kami untuk mengatur jadwal.',
  },
]

export default function FaqPage({ meta, faqs }: Props) {
  const items = faqs.length ? faqs : FALLBACK
  const [open, setOpen] = useState(0)

  return (
    <>
      <Seo title={meta.title} description={meta.description} />
      <PageHeader
        eyebrow="FAQ"
        title="Pertanyaan yang sering diajukan"
        description="Hal-hal yang paling sering ditanyakan seputar kelas renang di Tirta Nirwana."
        crumbs={[{ label: 'FAQ' }]}
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
