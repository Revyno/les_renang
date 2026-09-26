import { ArrowRight, Play } from 'lucide-react'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { img } from '@/lib/media'
import type { Hero as HeroData } from '@/types/models'

const FALLBACK = {
  title: 'Belajar Berenang dengan Aman & Menyenangkan',
  subtitle:
    'Program les renang untuk semua usia bersama instruktur bersertifikat. Dari pemula hingga mahir, kami dampingi setiap tahapnya.',
  image: 'hero-bg.jpg',
}

export default function Hero({ data }: { data: HeroData | null }) {
  const title = data?.title ?? FALLBACK.title
  const subtitle = data?.subtitle ?? FALLBACK.subtitle
  const image = img(data?.image, FALLBACK.image)

  return (
    <section id="beranda" className="relative overflow-hidden pt-24 md:pt-28">
      {/* decorative accents */}
      <div className="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-accent/20 blur-3xl" />
      <div className="pointer-events-none absolute -left-24 top-40 h-72 w-72 rounded-full bg-primary/10 blur-3xl" />

      <div className="container grid items-center gap-12 py-12 md:grid-cols-2 md:py-20">
        <div>
          <Badge variant="accent" className="mb-5">
            Sekolah Renang Terpercaya
          </Badge>
          <h1 className="text-4xl font-bold leading-tight tracking-tight text-primary md:text-5xl lg:text-6xl">
            {title}
          </h1>
          <p className="mt-5 max-w-xl text-lg leading-relaxed text-muted-foreground">{subtitle}</p>
          <div className="mt-8 flex flex-wrap gap-4">
            <Button asChild size="lg">
              <a href={data?.cta_link ?? '#program'}>
                {data?.cta_text ?? 'Lihat Program'}
                <ArrowRight />
              </a>
            </Button>
            <Button asChild size="lg" variant="outline">
              <a href={data?.secondary_cta_link ?? '#tentang'}>
                <Play />
                {data?.secondary_cta_text ?? 'Tentang Kami'}
              </a>
            </Button>
          </div>
        </div>

        <div className="relative">
          <div className="absolute -bottom-4 -right-4 h-full w-full rounded-3xl bg-accent/20" aria-hidden />
          <img
            src={image}
            alt="Kelas renang Les Renang"
            className="relative aspect-[4/3] w-full rounded-3xl object-cover shadow-xl"
            loading="eager"
          />
        </div>
      </div>
    </section>
  )
}
