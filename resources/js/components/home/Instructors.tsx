import { Award } from 'lucide-react'
import { XTwitter } from '@/components/site/SocialIcons'
import SectionHeading from '@/components/home/SectionHeading'
import { Card, CardContent } from '@/components/ui/card'
import { img } from '@/lib/media'
import type { Instructor } from '@/types/models'

const FALLBACK: Instructor[] = [
  { id: 1, name: 'Coach Andi', specialization: 'Renang Anak', certification: 'Sertifikat Nasional', photo: null, bio: null, twitter: null, experience: 8 },
  { id: 2, name: 'Coach Bela', specialization: 'Gaya Bebas & Dada', certification: 'Lisensi Pelatih', photo: null, bio: null, twitter: null, experience: 6 },
  { id: 3, name: 'Coach Dimas', specialization: 'Persiapan Lomba', certification: 'Sertifikat Nasional', photo: null, bio: null, twitter: null, experience: 10 },
  { id: 4, name: 'Coach Sinta', specialization: 'Kelas Dewasa', certification: 'Water Safety', photo: null, bio: null, twitter: null, experience: 5 },
]

export default function Instructors({ data }: { data: Instructor[] }) {
  const items = data.length ? data : FALLBACK

  return (
    <section id="instruktur" className="py-20 md:py-28">
      <div className="container">
        <SectionHeading
          eyebrow="Tim Kami"
          title="Instruktur Bersertifikat"
          description="Belajar langsung dari pelatih berpengalaman yang siap mendampingi perjalanan renang Anda."
        />
        <div className="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
          {items.map((coach) => (
            <Card key={coach.id} className="group overflow-hidden text-center">
              <div className="relative">
                <img
                  src={img(coach.photo, 'working-1.jpg')}
                  alt={coach.name}
                  className="aspect-[3/4] w-full object-cover"
                  loading="lazy"
                />
                {coach.twitter && (
                  <a
                    href={coach.twitter}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="absolute right-3 top-3 grid h-9 w-9 place-items-center rounded-full bg-background/90 text-primary opacity-0 transition-opacity group-hover:opacity-100"
                    aria-label={`Twitter ${coach.name}`}
                  >
                    <XTwitter className="h-4 w-4" />
                  </a>
                )}
              </div>
              <CardContent className="p-5">
                <h3 className="text-base font-semibold text-primary">{coach.name}</h3>
                {coach.specialization && <p className="mt-1 text-sm text-accent">{coach.specialization}</p>}
                {coach.certification && (
                  <p className="mt-2 flex items-center justify-center gap-1.5 text-xs text-muted-foreground">
                    <Award className="h-3.5 w-3.5" />
                    {coach.certification}
                  </p>
                )}
              </CardContent>
            </Card>
          ))}
        </div>
      </div>
    </section>
  )
}
