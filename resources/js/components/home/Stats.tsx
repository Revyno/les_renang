import { Users, Award, Waves, Smile } from 'lucide-react'
import type { Stat } from '@/types/models'

const FALLBACK: Stat[] = [
  { icon: null, value: '500+', label: 'Murid Terlatih' },
  { icon: null, value: '15+', label: 'Instruktur Bersertifikat' },
  { icon: null, value: '10', label: 'Tahun Pengalaman' },
  { icon: null, value: '98%', label: 'Murid Puas' },
]

const ICONS = [Users, Award, Waves, Smile]

export default function Stats({ data }: { data: Stat[] }) {
  const items = data.length ? data : FALLBACK

  return (
    <section className="bg-primary py-14 text-primary-foreground">
      <div className="container grid grid-cols-2 gap-8 md:grid-cols-4">
        {items.map((stat, i) => {
          const Icon = ICONS[i % ICONS.length]
          return (
            <div key={i} className="flex flex-col items-center text-center">
              <span className="mb-3 grid h-12 w-12 place-items-center rounded-full bg-primary-foreground/10">
                <Icon className="h-6 w-6" />
              </span>
              <span className="text-3xl font-bold md:text-4xl">{stat.value}</span>
              <span className="mt-1 text-sm text-primary-foreground/70">{stat.label}</span>
            </div>
          )
        })}
      </div>
    </section>
  )
}
