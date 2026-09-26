import { useState } from 'react'
import { ChevronDown } from 'lucide-react'
import SectionHeading from '@/components/home/SectionHeading'
import { cn } from '@/lib/utils'
import type { Faq as FaqItem } from '@/types/models'

const FALLBACK: FaqItem[] = [
  { id: 1, question: 'Mulai usia berapa anak bisa ikut les renang?', answer: 'Kami menerima murid mulai usia 4 tahun dengan kelas yang disesuaikan untuk pengenalan air yang aman.' },
  { id: 2, question: 'Apakah tersedia kelas untuk pemula dewasa?', answer: 'Tentu. Kelas dewasa kami cocok untuk yang belum pernah berenang sama sekali maupun yang ingin memperbaiki teknik.' },
  { id: 3, question: 'Bagaimana cara mendaftar?', answer: 'Anda bisa mendaftar melalui tombol "Daftar Sekarang" atau menghubungi kami langsung via WhatsApp.' },
  { id: 4, question: 'Apakah perlu membawa peralatan sendiri?', answer: 'Cukup bawa baju renang dan handuk. Peralatan latihan lainnya kami sediakan.' },
]

export default function Faq({ data }: { data: FaqItem[] }) {
  const items = data.length ? data : FALLBACK
  const [open, setOpen] = useState<number | null>(items[0]?.id ?? null)

  return (
    <section id="faq" className="py-20 md:py-28">
      <div className="container">
        <SectionHeading
          eyebrow="FAQ"
          title="Pertanyaan yang Sering Diajukan"
          description="Belum menemukan jawabannya? Hubungi kami dan tim kami akan membantu."
        />
        <div className="mx-auto mt-12 max-w-3xl space-y-3">
          {items.map((item) => {
            const expanded = open === item.id
            return (
              <div key={item.id} className="overflow-hidden rounded-xl border border-border bg-card">
                <button
                  type="button"
                  onClick={() => setOpen(expanded ? null : item.id)}
                  className="flex w-full items-center justify-between gap-4 px-5 py-4 text-left"
                  aria-expanded={expanded}
                >
                  <span className="font-medium text-primary">{item.question}</span>
                  <ChevronDown
                    className={cn('h-5 w-5 shrink-0 text-accent transition-transform', expanded && 'rotate-180')}
                  />
                </button>
                <div
                  className={cn(
                    'grid transition-all duration-300',
                    expanded ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0',
                  )}
                >
                  <div className="overflow-hidden">
                    <p className="px-5 pb-5 text-sm leading-relaxed text-muted-foreground">{item.answer}</p>
                  </div>
                </div>
              </div>
            )
          })}
        </div>
      </div>
    </section>
  )
}
