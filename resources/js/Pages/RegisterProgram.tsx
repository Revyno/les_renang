import { type ReactNode } from 'react'
import { MessageCircle, Clock, Users, ArrowRight } from 'lucide-react'
import Seo from '@/components/Seo'
import SiteLayout from '@/Layouts/SiteLayout'
import PageHeader from '@/components/site/PageHeader'
import { Card, CardContent } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { img } from '@/lib/media'
import { useSite, waLink } from '@/lib/site'
import type { Program } from '@/types/models'

interface Props {
  meta: { title: string; description: string }
  programs: Program[]
}

const STEPS = [
  { n: 1, title: 'Pilih Program', desc: 'Tentukan program yang sesuai usia dan tujuan Anda.' },
  { n: 2, title: 'Hubungi Kami', desc: 'Klik "Daftar" untuk konfirmasi jadwal via WhatsApp.' },
  { n: 3, title: 'Mulai Berlatih', desc: 'Datang sesuai jadwal dan mulai belajar berenang.' },
]

export default function RegisterProgramPage({ meta, programs }: Props) {
  const site = useSite()

  // ponytail: enrollment/payment is admin business logic (out of frontend scope) —
  // registration is routed to WhatsApp confirmation. Upgrade: wire to Registration
  // model + auth when the enrollment flow is in scope.
  const daftar = (name: string) =>
    site.whatsapp
      ? waLink(site.whatsapp, `Halo, saya ingin mendaftar program "${name}". Mohon info jadwal & biaya.`)
      : '/kontak'

  return (
    <>
      <Seo title={meta.title} description={meta.description} />
      <PageHeader
        title="Daftar Program"
        description="Pilih program les renang yang paling sesuai, lalu daftar dengan mudah bersama kami."
        crumbs={[{ label: 'Daftar' }]}
      />

      {/* Steps */}
      <section className="py-14">
        <div className="container grid gap-6 sm:grid-cols-3">
          {STEPS.map((s) => (
            <div key={s.n} className="rounded-2xl border border-border bg-card p-6">
              <span className="grid h-10 w-10 place-items-center rounded-full bg-primary text-lg font-bold text-primary-foreground">
                {s.n}
              </span>
              <h3 className="mt-4 font-semibold text-primary">{s.title}</h3>
              <p className="mt-1 text-sm text-muted-foreground">{s.desc}</p>
            </div>
          ))}
        </div>
      </section>

      {/* Programs */}
      <section className="pb-24">
        <div className="container">
          <h2 className="mb-8 text-2xl font-bold text-primary">Program Tersedia</h2>
          {programs.length === 0 ? (
            <p className="py-10 text-center text-muted-foreground">
              Program belum tersedia. Silakan hubungi kami untuk informasi jadwal terbaru.
            </p>
          ) : (
            <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
              {programs.map((program) => (
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
                    <div className="mt-auto pt-5">
                      {program.price && (
                        <p className="mb-3 text-lg font-bold text-primary">{program.price}</p>
                      )}
                      <Button asChild className="w-full">
                        <a href={daftar(program.name)} target="_blank" rel="noopener noreferrer">
                          <MessageCircle />
                          Daftar Program Ini
                        </a>
                      </Button>
                    </div>
                  </CardContent>
                </Card>
              ))}
            </div>
          )}

          <div className="mt-12 rounded-2xl bg-secondary/50 p-8 text-center">
            <p className="text-muted-foreground">
              Butuh bantuan memilih atau ingin jadwal khusus?
            </p>
            <Button asChild variant="outline" className="mt-4">
              <a href={site.whatsapp ? waLink(site.whatsapp, site.whatsapp_message) : '/kontak'} target="_blank" rel="noopener noreferrer">
                Konsultasi Gratis
                <ArrowRight />
              </a>
            </Button>
          </div>
        </div>
      </section>
    </>
  )
}

RegisterProgramPage.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>
