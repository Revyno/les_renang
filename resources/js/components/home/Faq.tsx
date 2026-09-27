import { useState } from 'react'
import { Plus, Minus } from 'lucide-react'
import { cn } from '@/lib/utils'
import type { Faq as FaqData } from '@/types/models'

const FALLBACK: FaqData[] = [
  { id: 1, question: 'Mulai usia berapa anak bisa ikut kelas?', answer: 'Kelas pengenalan air dapat dimulai sejak balita. Pelatih menilai kesiapan anak di sesi pertama sebelum menentukan level.' },
  { id: 2, question: 'Apakah perlu membawa perlengkapan sendiri?', answer: 'Cukup bawa baju renang, kacamata, dan handuk. Papan pelampung dan alat bantu latihan kami sediakan.' },
  { id: 3, question: 'Bagaimana jika sesi latihan terlewat?', answer: 'Sesi dapat dijadwalkan ulang dengan pemberitahuan sebelumnya sesuai kebijakan reschedule kami.' },
  { id: 4, question: 'Di mana lokasi kolam latihan?', answer: 'Latihan berlangsung di kolam mitra kami di area Surabaya. Hubungi kami untuk detail lokasi terdekat.' },
]

export default function Faq({ data }: { data: FaqData[] }) {
  const faqs = data.length > 0 ? data : FALLBACK
  const [open, setOpen] = useState(0)

  return (
    <section data-aos="fade-up" className="mx-auto flex max-w-screen-2xl flex-col items-center gap-12 px-4 py-20 md:px-10 md:py-24">
      <div data-aos="fade-up" className="flex flex-col items-center gap-4 text-center">
        <span className="inline-flex items-center rounded-full bg-brand-600 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider text-white">
          FAQ
        </span>
        <h2 className="text-3xl font-medium leading-[1.1] tracking-tight text-foreground md:text-4xl lg:text-5xl">
          Pertanyaan yang sering diajukan
        </h2>
      </div>

      <div className="flex w-full max-w-3xl flex-col gap-2.5">
        {faqs.map((f, i) => {
          const isOpen = open === i
          return (
            <div key={f.id} data-aos="fade-up" data-aos-delay={Math.min(i, 5) * 80} className="rounded-2xl bg-stone-100">
              <button
                type="button"
                onClick={() => setOpen(isOpen ? -1 : i)}
                aria-expanded={isOpen}
                className="flex w-full items-center justify-between gap-4 px-6 py-5 text-left text-base font-semibold text-foreground md:text-lg"
              >
                {f.question}
                <span
                  className={cn(
                    'grid h-8 w-8 shrink-0 place-items-center rounded-full transition-colors',
                    isOpen ? 'bg-brand-500 text-white' : 'bg-white text-foreground',
                  )}
                >
                  {isOpen ? <Minus className="h-4 w-4" /> : <Plus className="h-4 w-4" />}
                </span>
              </button>
              {isOpen && <p className="px-6 pb-6 text-sm leading-relaxed text-muted-foreground md:text-base">{f.answer}</p>}
            </div>
          )
        })}
      </div>
    </section>
  )
}
