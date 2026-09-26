import { Baby, Waves, Trophy, ShieldCheck, HeartPulse, GraduationCap } from 'lucide-react'
import SectionHeading from '@/components/home/SectionHeading'
import { Card, CardContent } from '@/components/ui/card'
import type { Service } from '@/types/models'

const ICONS = [Baby, Waves, Trophy, ShieldCheck, HeartPulse, GraduationCap]

const FALLBACK: Service[] = [
  { icon_class: null, title: 'Kelas Anak', short_desc: 'Pengenalan air yang aman & menyenangkan untuk si kecil.', description: null },
  { icon_class: null, title: 'Kelas Dewasa', short_desc: 'Belajar dari nol atau tingkatkan teknik renang Anda.', description: null },
  { icon_class: null, title: 'Kelas Privat', short_desc: 'Pendampingan 1-on-1 sesuai target dan jadwal Anda.', description: null },
  { icon_class: null, title: 'Persiapan Lomba', short_desc: 'Latihan intensif untuk perenang kompetitif.', description: null },
]

export default function Services({ data }: { data: Service[] }) {
  const items = data.length ? data : FALLBACK

  return (
    <section id="layanan" className="py-20 md:py-28">
      <div className="container">
        <SectionHeading
          eyebrow="Layanan Kami"
          title="Program yang Sesuai untuk Setiap Perenang"
          description="Pilih kelas yang paling cocok dengan kebutuhan dan tingkat kemampuan Anda."
        />
        <div className="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
          {items.map((service, i) => {
            const Icon = ICONS[i % ICONS.length]
            return (
              <Card key={i} className="group transition-shadow hover:shadow-md">
                <CardContent className="p-6">
                  <span className="mb-5 grid h-12 w-12 place-items-center rounded-xl bg-accent/15 text-accent transition-colors group-hover:bg-accent group-hover:text-accent-foreground">
                    <Icon className="h-6 w-6" />
                  </span>
                  <h3 className="text-lg font-semibold text-primary">{service.title}</h3>
                  {service.short_desc && (
                    <p className="mt-2 text-sm leading-relaxed text-muted-foreground">{service.short_desc}</p>
                  )}
                </CardContent>
              </Card>
            )
          })}
        </div>
      </div>
    </section>
  )
}
