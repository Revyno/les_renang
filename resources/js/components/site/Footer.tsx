import { Link } from '@inertiajs/react'
import { Instagram, Facebook, XTwitter } from '@/components/site/SocialIcons'
import { BRAND } from '@/lib/brand'
import { useSite } from '@/lib/site'

const NAV = [
  { label: 'Beranda', href: '/' },
  { label: 'Layanan', href: '/layanan' },
  { label: 'Tentang Kami', href: '/tentang' },
  { label: 'Tim Pelatih', href: '/tentang#tim' },
]

const INFO = [
  { label: 'Artikel & Blog', href: '/blog' },
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
    <footer className="bg-night text-stone-300">
      <div className="mx-auto max-w-screen-2xl px-4 pb-10 pt-16 md:px-10 md:pt-20">
        <div className="grid grid-cols-2 gap-x-6 gap-y-10 md:grid-cols-12" data-aos="fade-up">
          {/* Brand */}
          <div className="col-span-2 flex flex-col gap-5 md:col-span-4">
            <Link href="/" className="flex items-center gap-3 text-white">
              <img src={BRAND.logo} alt={BRAND.name} className="h-12 w-12 shrink-0 object-contain" />
              <span className="flex flex-col leading-none">
                <span className="text-xl font-bold tracking-tight">
                  Tirta<span className="text-peach">Nirwana</span>
                </span>
                <span className="mt-1 text-[11px] font-medium tracking-wide text-stone-400">
                  {BRAND.tagline}
                </span>
              </span>
            </Link>
            <p className="max-w-xs text-sm leading-relaxed text-stone-400">
              Kursus renang profesional untuk segala usia yang aman, menyenangkan, dan terarah.
            </p>
            {socials.length > 0 && (
              <div className="flex gap-2">
                {socials.map(([key, urlHref]) => {
                  const Icon = SOCIAL_ICON[key.toLowerCase()] ?? Instagram
                  return (
                    <a
                      key={key}
                      href={urlHref}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="grid h-11 w-11 place-items-center rounded-full border border-night-line text-white transition-colors hover:bg-brand-500 hover:border-brand-500"
                      aria-label={key}
                    >
                      <Icon className="h-4 w-4" />
                    </a>
                  )
                })}
              </div>
            )}
          </div>

          <div className="flex flex-col gap-3.5 text-sm md:col-span-3 md:col-start-6">
            <span className="text-xs font-semibold uppercase tracking-wider text-stone-500">Navigasi</span>
            {NAV.map((item) => (
              <Link key={item.href} href={item.href} className="text-stone-200 transition-colors hover:text-brand-400">
                {item.label}
              </Link>
            ))}
          </div>

          <div className="flex flex-col gap-3.5 text-sm md:col-span-2">
            <span className="text-xs font-semibold uppercase tracking-wider text-stone-500">Informasi</span>
            {INFO.map((item) => (
              <Link key={item.href} href={item.href} className="text-stone-200 transition-colors hover:text-brand-400">
                {item.label}
              </Link>
            ))}
          </div>

          <div className="col-span-2 flex flex-col gap-3.5 text-sm md:col-span-3">
            <span className="text-xs font-semibold uppercase tracking-wider text-stone-500">Kontak</span>
            {site.address && <span className="text-stone-200">{site.address}</span>}
            {site.email && (
              <a href={`mailto:${site.email}`} className="text-stone-200 hover:text-brand-400">
                {site.email}
              </a>
            )}
            {site.phone && (
              <a href={`tel:${site.phone}`} className="text-stone-200 hover:text-brand-400">
                {site.phone}
              </a>
            )}
          </div>
        </div>

        {/* Giant wordmark */}
        <div className="mt-16 select-none overflow-hidden text-center text-[12vw] font-extrabold leading-none tracking-tighter text-night-wordmark md:text-[8.5rem]" data-aos="fade-up">
          TIRTA NIRWANA
        </div>

        <div className="mt-6 flex flex-col items-center justify-between gap-2 border-t border-night-line pt-6 text-xs text-stone-500 sm:flex-row">
          <span>© {year} {BRAND.name}. Hak cipta dilindungi.</span>
          <span>Sekolah Renang · Surabaya</span>
        </div>
      </div>
    </footer>
  )
}
