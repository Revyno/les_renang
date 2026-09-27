import { Link } from '@inertiajs/react'
import { ChevronRight } from 'lucide-react'
import { cn } from '@/lib/utils'
import { cld } from '@/lib/media'
import { useI18n } from '@/lib/i18n'

interface Crumb {
  label: string
  href?: string
}

interface PageHeaderProps {
  title: string
  description?: string
  eyebrow?: string
  crumbs?: Crumb[]
  /** Local asset path relative to assets/img (e.g. 'services.jpg'). */
  image?: string
}

export default function PageHeader({ title, description, eyebrow, crumbs = [], image = 'hero-bg.jpg' }: PageHeaderProps) {
  const { t } = useI18n()
  return (
    <section className="relative overflow-hidden bg-night pt-28 md:pt-32">
      <img
        src={cld(image)}
        alt=""
        className="absolute inset-0 h-full w-full object-cover object-[center_40%]"
        loading="eager"
        aria-hidden
      />
      {/* Left-weighted dark gradient keeps the left-aligned copy readable over any photo. */}
      <div className="absolute inset-0 bg-gradient-to-r from-black/80 via-black/55 to-black/25" aria-hidden />
      <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent" aria-hidden />

      <div className="relative mx-auto max-w-screen-2xl px-4 pb-14 pt-10 md:px-10 md:pb-20 md:pt-16" data-aos="fade-up">
        <nav className="mb-5 flex items-center gap-1.5 text-sm text-white/70">
          <Link href="/" className="transition-colors hover:text-white">
            {t('nav.home')}
          </Link>
          {crumbs.map((c) => (
            <span key={c.label} className="flex items-center gap-1.5">
              <ChevronRight className="h-3.5 w-3.5" />
              {c.href ? (
                <Link href={c.href} className="transition-colors hover:text-white">
                  {c.label}
                </Link>
              ) : (
                <span className="text-white">{c.label}</span>
              )}
            </span>
          ))}
        </nav>

        {eyebrow && (
          <span className="mb-4 inline-flex items-center rounded-full bg-brand-500 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider text-white">
            {eyebrow}
          </span>
        )}
        <h1 className={cn('max-w-4xl text-4xl font-medium leading-[1.08] tracking-tight text-white md:text-6xl')}>
          {title}
        </h1>
        {description && <p className="mt-5 max-w-2xl text-lg leading-relaxed text-white/85">{description}</p>}
      </div>
    </section>
  )
}
