import { Clock, Users, ArrowRight } from 'lucide-react'
import SectionHeading from '@/components/home/SectionHeading'
import { Card, CardContent } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { img } from '@/lib/media'
import type { Program } from '@/types/models'

export default function Programs({ data }: { data: Program[] }) {
  if (!data.length) return null

  return (
    <section id="program" className="bg-secondary/40 py-20 md:py-28">
      <div className="container">
        <SectionHeading
          eyebrow="Program Les"
          title="Jadwal & Program Tersedia"
          description="Daftar program renang aktif kami. Pilih yang paling sesuai dengan usia dan jadwal Anda."
        />
        <div className="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          {data.map((program) => (
            <Card key={program.id} className="flex flex-col overflow-hidden">
              <img
                src={img(program.thumbnail, 'services.jpg')}
                alt={program.name}
                className="aspect-video w-full object-cover"
                loading="lazy"
              />
              <CardContent className="flex flex-1 flex-col p-6">
                <div className="flex items-start justify-between gap-3">
                  <h3 className="text-lg font-semibold text-primary">{program.name}</h3>
                  {program.age_range && <Badge>{program.age_range}</Badge>}
                </div>
                {program.description && (
                  <p className="mt-2 line-clamp-2 text-sm text-muted-foreground">{program.description}</p>
                )}
                <ul className="mt-4 space-y-2 text-sm text-foreground/70">
                  {program.schedule && (
                    <li className="flex items-center gap-2">
                      <Clock className="h-4 w-4 text-accent" />
                      {program.schedule}
                    </li>
                  )}
                  {program.instructor && (
                    <li className="flex items-center gap-2">
                      <Users className="h-4 w-4 text-accent" />
                      {program.instructor}
                    </li>
                  )}
                </ul>
                <div className="mt-auto flex items-center justify-between pt-5">
                  {program.price && <span className="text-lg font-bold text-primary">{program.price}</span>}
                  <Button asChild size="sm" variant="ghost">
                    <a href="#kontak">
                      Daftar
                      <ArrowRight />
                    </a>
                  </Button>
                </div>
              </CardContent>
            </Card>
          ))}
        </div>
      </div>
    </section>
  )
}
