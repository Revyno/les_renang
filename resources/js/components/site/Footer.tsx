import { Link } from '@inertiajs/react'
import { Waves, MapPin, Phone, Mail } from 'lucide-react'
import { Instagram, Facebook, XTwitter } from '@/components/site/SocialIcons'
import { useSite } from '@/lib/site'

const NAV = [
  { label: 'Tentang', href: '/tentang' },
  { label: 'Layanan', href: '/layanan' },
  { label: 'Blog', href: '/blog' },
  { label: 'FAQ', href: '/faq' },
  { label: 'Kontak', href: '/kontak' },
]

const SOCIAL_ICON: Record<string, typeof Instagram> = {
  instagram: Instagram,
  facebook: Facebook,
  twitter: XTwitter,
  x: XTwitter,
}

export default function Footer() {
  const year = new Date().getFullYear()
  const site = useSite()
  const socials = site.social ? Object.entries(site.social) : []

  return (
    <footer className="bg-primary text-primary-foreground">
      <div className="container grid gap-10 py-14 md:grid-cols-4">
        <div className="md:col-span-1">
          <Link href="/" className="flex items-center gap-2 font-bold">
            <span className="grid h-9 w-9 place-items-center rounded-full bg-primary-foreground text-primary">
              <Waves className="h-5 w-5" />
            </span>
            <span className="text-lg">Les Renang</span>
          </Link>
          <p className="mt-4 text-sm text-primary-foreground/70">
            Kursus & program renang profesional untuk semua usia. Belajar aman, nyaman, dan menyenangkan.
          </p>
          {socials.length > 0 && (
            <div className="mt-5 flex gap-3">
              {socials.map(([key, url]) => {
                const Icon = SOCIAL_ICON[key.toLowerCase()] ?? Instagram
                return (
                  <a
                    key={key}
                    href={url}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="grid h-9 w-9 place-items-center rounded-full bg-primary-foreground/10 transition-colors hover:bg-primary-foreground/20"
                    aria-label={key}
                  >
                    <Icon className="h-4 w-4" />
                  </a>
                )
              })}
            </div>
          )}
        </div>

        <div>
          <h4 className="mb-4 text-sm font-semibold uppercase tracking-wider">Navigasi</h4>
          <ul className="space-y-2.5 text-sm text-primary-foreground/70">
            {NAV.map((item) => (
              <li key={item.href}>
                <Link href={item.href} className="transition-colors hover:text-primary-foreground">
                  {item.label}
                </Link>
              </li>
            ))}
          </ul>
        </div>

        <div>
          <h4 className="mb-4 text-sm font-semibold uppercase tracking-wider">Kontak</h4>
          <ul className="space-y-3 text-sm text-primary-foreground/70">
            <li className="flex gap-3">
              <MapPin className="mt-0.5 h-4 w-4 shrink-0" />
              <span>{site.address}</span>
            </li>
            <li className="flex gap-3">
              <Phone className="h-4 w-4 shrink-0" />
              <a href={`tel:${site.phone}`} className="hover:text-primary-foreground">
                {site.phone}
              </a>
            </li>
            <li className="flex gap-3">
              <Mail className="h-4 w-4 shrink-0" />
              <a href={`mailto:${site.email}`} className="hover:text-primary-foreground">
                {site.email}
              </a>
            </li>
          </ul>
        </div>

        <div>
          <h4 className="mb-4 text-sm font-semibold uppercase tracking-wider">Jam Operasional</h4>
          <ul className="space-y-2.5 text-sm text-primary-foreground/70">
            <li className="flex justify-between">
              <span>Senin – Jumat</span>
              <span>06.00 – 20.00</span>
            </li>
            <li className="flex justify-between">
              <span>Sabtu – Minggu</span>
              <span>06.00 – 18.00</span>
            </li>
          </ul>
        </div>
      </div>

      <div className="border-t border-primary-foreground/10">
        <div className="container flex flex-col items-center justify-between gap-2 py-5 text-xs text-primary-foreground/60 sm:flex-row">
          <p>© {year} Les Renang. Semua hak dilindungi.</p>
          <p>Dibuat dengan semangat untuk berenang.</p>
        </div>
      </div>
    </footer>
  )
}
