import { MapPin, Phone, Mail, MessageCircle } from 'lucide-react'
import { Button } from '@/components/ui/button'
import { Card, CardContent } from '@/components/ui/card'
import { useSite, waLink } from '@/lib/site'

export default function Contact() {
  const site = useSite()
  const info = [
    { icon: MapPin, label: 'Alamat', value: site.address },
    { icon: Phone, label: 'Telepon', value: site.phone },
    { icon: Mail, label: 'Email', value: site.email },
  ]

  return (
    <section id="kontak" className="py-20 md:py-28">
      <div className="container">
        <div className="grid overflow-hidden rounded-3xl bg-primary text-primary-foreground md:grid-cols-2">
          <div className="p-10 md:p-14">
            <h2 className="text-3xl font-bold tracking-tight md:text-4xl">Siap Mulai Berenang?</h2>
            <p className="mt-4 max-w-md text-primary-foreground/80">
              Daftar sekarang atau hubungi kami untuk konsultasi gratis. Tim kami siap membantu memilih program yang
              tepat untuk Anda.
            </p>
            {site.whatsapp && (
              <Button asChild size="lg" variant="accent" className="mt-8">
                <a href={waLink(site.whatsapp, site.whatsapp_message)} target="_blank" rel="noopener noreferrer">
                  <MessageCircle />
                  Chat via WhatsApp
                </a>
              </Button>
            )}
          </div>

          <div className="flex flex-col justify-center gap-4 bg-primary-foreground/5 p-10 md:p-14">
            {info.map((item) => (
              <Card key={item.label} className="border-0 bg-primary-foreground/10 text-primary-foreground">
                <CardContent className="flex items-center gap-4 p-5">
                  <span className="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-primary-foreground/15">
                    <item.icon className="h-5 w-5" />
                  </span>
                  <div>
                    <p className="text-xs uppercase tracking-wider text-primary-foreground/60">{item.label}</p>
                    <p className="text-sm font-medium">{item.value}</p>
                  </div>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </div>
    </section>
  )
}
