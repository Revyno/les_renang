import { useEffect, useState } from 'react'
import { Link, usePage } from '@inertiajs/react'
import { Menu, X, Waves } from 'lucide-react'
import { Button } from '@/components/ui/button'
import { cn } from '@/lib/utils'
import type { SharedProps } from '@/types/models'

const NAV = [
  { label: 'Beranda', href: '/' },
  { label: 'Tentang', href: '/tentang' },
  { label: 'Layanan', href: '/layanan' },
  { label: 'Blog', href: '/blog' },
  { label: 'FAQ', href: '/faq' },
  { label: 'Kontak', href: '/kontak' },
]

export default function Navbar() {
  const [scrolled, setScrolled] = useState(false)
  const [open, setOpen] = useState(false)
  const { url, props } = usePage<SharedProps>()
  const user = props.auth?.user

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 24)
    onScroll()
    window.addEventListener('scroll', onScroll, { passive: true })
    return () => window.removeEventListener('scroll', onScroll)
  }, [])

  const isActive = (href: string) => (href === '/' ? url === '/' : url.startsWith(href))

  return (
    <header
      className={cn(
        'fixed inset-x-0 top-0 z-50 transition-all duration-300',
        scrolled ? 'bg-background/90 shadow-sm backdrop-blur border-b border-border/60' : 'bg-transparent',
      )}
    >
      <div className="container flex h-16 items-center justify-between md:h-20">
        <Link href="/" className="flex items-center gap-2 font-bold text-primary">
          <span className="grid h-9 w-9 place-items-center rounded-full bg-primary text-primary-foreground">
            <Waves className="h-5 w-5" />
          </span>
          <span className="text-lg tracking-tight">Les Renang</span>
        </Link>

        <nav className="hidden items-center gap-8 md:flex">
          {NAV.map((item) => (
            <Link
              key={item.href}
              href={item.href}
              className={cn(
                'text-sm font-medium transition-colors hover:text-primary',
                isActive(item.href) ? 'text-primary' : 'text-foreground/80',
              )}
            >
              {item.label}
            </Link>
          ))}
        </nav>

        <div className="hidden items-center gap-3 md:flex">
          {user ? (
            <Link href="/logout" method="post" as="button" className="text-sm font-medium text-foreground/80 hover:text-primary">
              Keluar
            </Link>
          ) : (
            <Link href="/login" className="text-sm font-medium text-foreground/80 hover:text-primary">
              Masuk
            </Link>
          )}
          <Button asChild size="sm">
            <Link href="/daftar">Daftar Sekarang</Link>
          </Button>
        </div>

        <button
          type="button"
          className="grid h-10 w-10 place-items-center rounded-lg text-foreground md:hidden"
          onClick={() => setOpen((v) => !v)}
          aria-label="Buka menu"
          aria-expanded={open}
        >
          {open ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
        </button>
      </div>

      {open && (
        <div className="border-t border-border/60 bg-background md:hidden">
          <nav className="container flex flex-col py-4">
            {NAV.map((item) => (
              <Link
                key={item.href}
                href={item.href}
                onClick={() => setOpen(false)}
                className={cn(
                  'py-2.5 text-sm font-medium hover:text-primary',
                  isActive(item.href) ? 'text-primary' : 'text-foreground/80',
                )}
              >
                {item.label}
              </Link>
            ))}
            {user ? (
              <Link href="/logout" method="post" as="button" onClick={() => setOpen(false)} className="py-2.5 text-left text-sm font-medium text-foreground/80 hover:text-primary">
                Keluar
              </Link>
            ) : (
              <Link href="/login" onClick={() => setOpen(false)} className="py-2.5 text-sm font-medium text-foreground/80 hover:text-primary">
                Masuk
              </Link>
            )}
            <Button asChild size="sm" className="mt-3 w-full">
              <Link href="/daftar" onClick={() => setOpen(false)}>
                Daftar Sekarang
              </Link>
            </Button>
          </nav>
        </div>
      )}
    </header>
  )
}
