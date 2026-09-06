import { useEffect, useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import { Menu } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Sheet, SheetClose, SheetContent, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
import ThemeToggle from '@/components/ThemeToggle';
import { navItems, routes } from '@/lib/routes';
import { cn } from '@/lib/utils';

function Brand({ onClick }: { onClick?: () => void }) {
    return (
        <Link href={routes.home()} onClick={onClick} className="flex items-center gap-2.5">
            <img
                src="/front/images/logo-icon.png"
                alt="Logo Tirta Nirwana"
                width={57}
                height={44}
                className="h-11 w-auto"
            />
            <span className="text-lg font-extrabold tracking-tight">
                Tirta<span className="text-primary">Nirwana</span>
            </span>
        </Link>
    );
}

export default function Navbar() {
    const { url } = usePage();
    const [scrolled, setScrolled] = useState(false);
    const [open, setOpen] = useState(false);

    useEffect(() => {
        const onScroll = () => setScrolled(window.scrollY > 8);
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
        return () => window.removeEventListener('scroll', onScroll);
    }, []);

    const isActive = (href: string) => {
        const path = href.split('?')[0];
        return path === '/' ? url === '/' : url.startsWith(path);
    };

    return (
        <header
            className={cn(
                'sticky top-0 z-40 w-full border-b transition-colors duration-300',
                scrolled
                    ? 'border-border bg-background/80 backdrop-blur-lg supports-[backdrop-filter]:bg-background/60'
                    : 'border-transparent bg-transparent',
            )}
        >
            <nav className="container flex h-16 items-center justify-between py-3">
                <Brand />

                <ul className="hidden items-center gap-1 lg:flex">
                    {navItems.map((item) => (
                        <li key={item.href}>
                            <Link
                                href={item.href}
                                className={cn(
                                    'rounded-full px-4 py-2 text-sm font-medium transition-colors',
                                    isActive(item.href)
                                        ? 'bg-secondary text-primary'
                                        : 'text-muted-foreground hover:bg-secondary hover:text-foreground',
                                )}
                            >
                                {item.label}
                            </Link>
                        </li>
                    ))}
                </ul>

                <div className="flex items-center gap-2">
                    <ThemeToggle />
                    <Button asChild className="hidden lg:inline-flex">
                        <Link href={routes.contact()}>Hubungi Kami</Link>
                    </Button>

                    <Sheet open={open} onOpenChange={setOpen}>
                        <SheetTrigger asChild>
                            <Button variant="ghost" size="icon" className="lg:hidden" aria-label="Buka menu">
                                <Menu className="h-6 w-6" />
                            </Button>
                        </SheetTrigger>
                        <SheetContent>
                            <SheetTitle className="sr-only">Menu navigasi</SheetTitle>
                            <div className="mb-8">
                                <Brand onClick={() => setOpen(false)} />
                            </div>
                            <ul className="flex flex-col gap-1">
                                {navItems.map((item) => (
                                    <li key={item.href}>
                                        <SheetClose asChild>
                                            <Link
                                                href={item.href}
                                                className={cn(
                                                    'block rounded-xl px-4 py-3 text-base font-medium transition-colors',
                                                    isActive(item.href)
                                                        ? 'bg-secondary text-primary'
                                                        : 'text-muted-foreground hover:bg-secondary',
                                                )}
                                            >
                                                {item.label}
                                            </Link>
                                        </SheetClose>
                                    </li>
                                ))}
                            </ul>
                            <SheetClose asChild>
                                <Button asChild className="mt-6 w-full">
                                    <Link href={routes.contact()}>Hubungi Kami</Link>
                                </Button>
                            </SheetClose>
                        </SheetContent>
                    </Sheet>
                </div>
            </nav>
        </header>
    );
}
