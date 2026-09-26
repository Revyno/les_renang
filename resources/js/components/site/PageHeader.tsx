import { Link } from '@inertiajs/react'
import { ChevronRight } from 'lucide-react'
import { cld } from '@/lib/media'

interface Crumb {
  label: string
  href?: string
}

interface PageHeaderProps {
  title: string
  description?: string
  crumbs?: Crumb[]
}

export default function PageHeader({ title, description, crumbs = [] }: PageHeaderProps) {
  return (
    <section className="relative overflow-hidden pt-28 md:pt-32">
      <div
        className="absolute inset-0 bg-cover bg-center opacity-10"
        style={{ backgroundImage: `url(${cld('page-title-bg.webp')})` }}
        aria-hidden
      />
      <div className="pointer-events-none absolute -right-24 -top-10 h-72 w-72 rounded-full bg-accent/20 blur-3xl" />
      <div className="container relative py-14 md:py-20">
        <nav className="mb-4 flex items-center gap-1.5 text-sm text-muted-foreground">
          <Link href="/" className="hover:text-primary">
            Beranda
          </Link>
          {crumbs.map((c) => (
            <span key={c.label} className="flex items-center gap-1.5">
              <ChevronRight className="h-3.5 w-3.5" />
              {c.href ? (
                <Link href={c.href} className="hover:text-primary">
                  {c.label}
                </Link>
              ) : (
                <span className="text-foreground/80">{c.label}</span>
              )}
            </span>
          ))}
        </nav>
        <h1 className="max-w-3xl text-3xl font-bold tracking-tight text-primary md:text-5xl">{title}</h1>
        {description && <p className="mt-4 max-w-2xl text-lg text-muted-foreground">{description}</p>}
      </div>
    </section>
  )
}
