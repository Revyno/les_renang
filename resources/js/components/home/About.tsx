import { CheckCircle2 } from 'lucide-react'
import SectionHeading from '@/components/home/SectionHeading'
import { img } from '@/lib/media'
import type { About as AboutData } from '@/types/models'

const FALLBACK = {
  title: 'Tentang Les Renang',
  description:
    'Kami adalah sekolah renang yang berkomitmen membantu setiap orang belajar berenang dengan aman dan percaya diri. Dengan instruktur bersertifikat dan fasilitas kolam yang terjaga, kami menghadirkan pengalaman belajar yang terstruktur untuk anak-anak maupun dewasa.',
  img: 'about.jpg',
}

const POINTS = [
  'Instruktur bersertifikat & berpengalaman',
  'Kelas kecil, perhatian personal',
  'Kolam bersih & standar keamanan',
  'Jadwal fleksibel untuk semua usia',
]

export default function About({ data }: { data: AboutData | null }) {
  const title = data?.title ?? FALLBACK.title
  const description = data?.description ?? FALLBACK.description
  const image = img(data?.img, FALLBACK.img)

  return (
    <section id="tentang" className="py-20 md:py-28">
      <div className="container grid items-center gap-12 md:grid-cols-2">
        <div className="relative order-last md:order-first">
          <div className="absolute -left-4 -top-4 h-full w-full rounded-3xl bg-primary/10" aria-hidden />
          <img
            src={image}
            alt="Tentang Les Renang"
            className="relative aspect-square w-full rounded-3xl object-cover shadow-lg"
            loading="lazy"
          />
        </div>
        <div>
          <SectionHeading eyebrow="Tentang Kami" title={title} description={description} align="left" />
          <ul className="mt-8 grid gap-4 sm:grid-cols-2">
            {POINTS.map((point) => (
              <li key={point} className="flex items-start gap-3">
                <CheckCircle2 className="mt-0.5 h-5 w-5 shrink-0 text-accent" />
                <span className="text-sm text-foreground/80">{point}</span>
              </li>
            ))}
          </ul>
        </div>
      </div>
    </section>
  )
}
