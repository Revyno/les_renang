import { useEffect, useState } from 'react'
import { Link, usePage } from '@inertiajs/react'
import { Menu, X } from 'lucide-react'
import { cn } from '@/lib/utils'
import { BRAND } from '@/lib/brand'
import { useI18n, LanguageToggle } from '@/lib/i18n'
import type { SharedProps } from '@/types/models'

const NAV = [
  { key: 'nav.home', href: '/' },
  { key: 'nav.services', href: '/layanan' },
  { key: 'nav.about', href: '/tentang' },
  { key: 'nav.blog', href: '/blog' },
  { key: 'nav.faq', href: '/faq' },
]

export default function Navbar() {
  const [scrolled, setScrolled] = useState(false)
  const [open, setOpen] = useState(false)
  const { url, props } = usePage<SharedProps>()
  const { t } = useI18n()
  const user = props.auth?.user

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 24)
    onScroll()
    window.addEventListener('scroll', onScroll, { passive: true })
    return () => window.removeEventListener('scroll', onScroll)
  }, [])

  const isActive = (href: string) => (href === '/' ? url === '/' : url.startsWith(href))
  const onHero = url === '/' && !scrolled && !open

  return (
    <header
      className={cn(
        'fixed inset-x-0 top-0 z-50 transition-colors duration-300',
        onHero ? 'bg-transparent' : 'border-b border-border bg-background/90 backdrop-blur',
      )}
    >
      <div className="mx-auto flex h-16 max-w-screen-2xl items-center justify-between px-4 md:h-20 md:px-10">
        {/* Wordmark */}
        <Link
          href="/"
          className={cn('flex items-center gap-2.5', onHero ? 'text-white' : 'text-foreground')}
        >
          <img src={BRAND.logo} alt={BRAND.name} className="h-10 w-10 shrink-0 object-contain md:h-11 md:w-11" />
          <span className="flex flex-col leading-none">
            <span className="text-lg font-bold tracking-tight">
              Tirta<span className={onHero ? 'text-peach' : 'text-brand-500'}>Nirwana</span>
            </span>
            <span className={cn('mt-0.5 text-[10px] font-medium tracking-wide', onHero ? 'text-white/80' : 'text-muted-foreground')}>
              {BRAND.tagline}
            </span>
          </span>
        </Link>

        {/* Center pill nav */}
        <nav className="hidden items-center gap-1.5 md:flex">
          {NAV.map((item) => {
            const active = isActive(item.href)
            return (
              <Link
                key={item.href}
                href={item.href}
                className={cn(
                  'flex h-10 items-center rounded-full px-4 text-sm font-medium transition-colors',
                  onHero
                    ? active
                      ? 'bg-white text-foreground'
                      : 'bg-white/15 text-white backdrop-blur hover:bg-white/25'
                    : active
                      ? 'bg-brand-500 text-white'
                      : 'text-foreground/80 hover:bg-secondary hover:text-foreground',
                )}
              >
                {t(item.key)}
              </Link>
            )
          })}
        </nav>

        {/* Actions */}
        <div className="hidden items-center gap-2.5 md:flex">
          <LanguageToggle onDark={onHero} />
          {user ? (
            <Link
              href="/logout"
              method="post"
              as="button"
              className={cn('text-sm font-medium', onHero ? 'text-white/90 hover:text-white' : 'text-foreground/80 hover:text-brand-500')}
            >
              {t('nav.logout')}
            </Link>
          ) : (
            <Link
              href="/login"
              className={cn('text-sm font-medium', onHero ? 'text-white/90 hover:text-white' : 'text-foreground/80 hover:text-brand-500')}
            >
              {t('nav.login')}
            </Link>
          )}
          <Link
            href="/daftar"
            className="flex h-11 items-center rounded-full bg-brand-500 px-6 text-sm font-semibold text-white transition-colors hover:bg-brand-600"
          >
            {t('nav.register')}
          </Link>
        </div>

        <button
          type="button"
          className={cn('grid h-10 w-10 place-items-center rounded-lg md:hidden', onHero ? 'text-white' : 'text-foreground')}
          onClick={() => setOpen((v) => !v)}
          aria-label={t('nav.menu')}
          aria-expanded={open}
        >
          {open ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
        </button>
      </div>

      {open && (
        <div className="border-t border-border bg-background md:hidden">
          <nav className="mx-auto flex max-w-screen-2xl flex-col px-4 py-4">
            {NAV.map((item) => (
              <Link
                key={item.href}
                href={item.href}
                onClick={() => setOpen(false)}
                className={cn(
                  'rounded-full px-4 py-2.5 text-sm font-medium',
                  isActive(item.href) ? 'bg-brand-500 text-white' : 'text-foreground/80 hover:bg-secondary',
                )}
              >
                {t(item.key)}
              </Link>
            ))}
            <div className="mt-3 flex flex-col gap-2 border-t border-border pt-3">
              <div className="px-4 py-1">
                <LanguageToggle />
              </div>
              {user ? (
                <Link href="/logout" method="post" as="button" onClick={() => setOpen(false)} className="px-4 py-2 text-left text-sm font-medium text-foreground/80">
                  {t('nav.logout')}
                </Link>
              ) : (
                <Link href="/login" onClick={() => setOpen(false)} className="px-4 py-2 text-sm font-medium text-foreground/80">
                  {t('nav.login')}
                </Link>
              )}
              <Link
                href="/daftar"
                onClick={() => setOpen(false)}
                className="flex h-11 items-center justify-center rounded-full bg-brand-500 px-6 text-sm font-semibold text-white"
              >
                {t('nav.register')}
              </Link>
            </div>
          </nav>
        </div>
      )}
    </header>
  )
}
