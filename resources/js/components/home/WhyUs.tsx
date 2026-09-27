import { useState } from 'react'
import { Plus } from 'lucide-react'
import { cn } from '@/lib/utils'
import { cld } from '@/lib/media'
import CountUp from '@/components/CountUp'
import type { Stat } from '@/types/models'

// Evergreen value props (not admin-managed) + DB-driven stat cards.
const WHY = [
  {
    title: 'Aman dan selalu terawasi',
    desc: 'Rasio pelatih–murid ideal dan protokol keselamatan air yang ketat di setiap sesi, sehingga orang tua bisa tenang.',
  },
  {
    title: 'Pendekatan personal',
    desc: 'Program disesuaikan dengan usia, level, dan tujuan setiap murid — dari takut air hingga siap lomba.',
  },
  {
    title: 'Metode pengajaran modern',
    desc: 'Teknik pengajaran terkini yang membuat belajar renang cepat, bertahap, dan menyenangkan.',
  },
  {
    title: 'Jadwal kelas fleksibel',
    desc: 'Pilihan jadwal pagi, sore, dan akhir pekan yang bisa disesuaikan dengan aktivitasmu.',
  },
]

const STAT_FALLBACK: Stat[] = [
  { icon: null, value: '10+', label: 'Tahun pengalaman' },
  { icon: null, value: '2.500+', label: 'Murid terlatih' },
  { icon: null, value: '15+', label: 'Pelatih bersertifikat' },
  { icon: null, value: '4.9/5', label: 'Rating kepuasan' },
]

export default function WhyUs({ stats }: { stats: Stat[] }) {
  const [open, setOpen] = useState(0)
  const items = stats.length > 0 ? stats.slice(0, 4) : STAT_FALLBACK

  return (
    <section data-aos="fade-up" className="mx-auto flex max-w-screen-2xl flex-col gap-14 px-4 py-20 md:px-10 md:py-28">
      <div data-aos="fade-up" className="flex flex-col gap-5">
        <span className="inline-flex w-fit items-center rounded-full bg-brand-600 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider text-white">
          Kenapa memilih kami
        </span>
        <h2 className="max-w-3xl text-3xl font-medium leading-[1.08] tracking-tight text-foreground md:text-4xl lg:text-5xl">
          Dibangun dari pengalaman. Digerakkan oleh kepedulian.
        </h2>
      </div>

      <div className="grid gap-8 lg:grid-cols-12">
        <div data-aos="fade-right" className="flex flex-col gap-3 lg:col-span-7">
          {WHY.map((w, i) => {
            const isOpen = open === i
            return (
              <div
                key={i}
                className={cn('rounded-2xl bg-stone-100 transition-colors', isOpen ? 'border border-stone-200' : 'border border-transparent')}
              >
                <button
                  type="button"
                  onClick={() => setOpen(isOpen ? -1 : i)}
                  aria-expanded={isOpen}
                  className="flex w-full items-center gap-4 px-6 py-5 text-left text-lg font-semibold text-foreground"
                >
                  <span className="grid h-8 w-8 shrink-0 place-items-center rounded-[10px] bg-brand-500 text-white">
                    <Plus className={cn('h-4 w-4 transition-transform', isOpen && 'rotate-45')} strokeWidth={2.4} />
                  </span>
                  {w.title}
                </button>
                {isOpen && <p className="px-6 pb-6 pl-[4.5rem] text-sm leading-relaxed text-muted-foreground">{w.desc}</p>}
              </div>
            )
          })}
        </div>

        <div data-aos="fade-left" className="relative h-72 overflow-hidden rounded-3xl lg:col-span-5 lg:h-auto">
          <img
            src={cld('teacher/IMG_3599.JPG')}
            alt="Murid fokus berlatih gaya bebas"
            className="absolute inset-0 h-full w-full object-cover"
            loading="lazy"
          />
        </div>
      </div>

      <div className="grid grid-cols-2 gap-4 md:grid-cols-4">
        {items.map((st, i) => (
          <div key={i} data-aos="fade-up" data-aos-delay={Math.min(i, 5) * 80} className="flex flex-col gap-2 rounded-2xl bg-stone-100 p-7">
            <CountUp value={st.value} className="text-4xl font-medium tracking-tight text-foreground md:text-5xl" />
            <span className="text-sm text-muted-foreground">{st.label}</span>
          </div>
        ))}
      </div>
    </section>
  )
}
