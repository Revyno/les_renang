import { Link } from '@inertiajs/react';
import { Mail, MapPin, Phone } from 'lucide-react';
import { Facebook, Instagram, Twitter } from '@/components/icons';
import { navItems, routes } from '@/lib/routes';

const socials = [
    { icon: Instagram, href: 'https://instagram.com', label: 'Instagram' },
    { icon: Facebook, href: 'https://facebook.com', label: 'Facebook' },
    { icon: Twitter, href: 'https://twitter.com', label: 'Twitter' },
];

export default function Footer() {
    const year = new Date().getFullYear();

    return (
        <footer className="mt-24 border-t border-border bg-secondary/40">
            <div className="container grid gap-10 py-14 md:grid-cols-2 lg:grid-cols-4">
                <div className="lg:col-span-1">
                    <Link href={routes.home()} className="flex items-center gap-2.5">
                        <img
                            src="/front/images/logo-icon.png"
                            alt="Logo Tirta Nirwana"
                            width={57}
                            height={44}
                            className="w-auto h-11"
                        />
                        <span className="text-lg font-extrabold tracking-tight">
                            Tirta<span className="text-primary">Nirwana</span>
                        </span>
                    </Link>
                    <p className="max-w-xs mt-4 text-sm leading-relaxed text-muted-foreground">
                        Kursus renang profesional di Surabaya untuk segala usia yang aman, menyenangkan, dan terarah.
                    </p>
                    <div className="flex gap-2 mt-5">
                        {socials.map(({ icon: Icon, href, label }) => (
                            <a
                                key={label}
                                href={href}
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label={label}
                                className="flex items-center justify-center transition-colors border rounded-full h-9 w-9 border-border bg-background text-muted-foreground hover:border-primary hover:text-primary"
                            >
                                <Icon className="w-4 h-4" />
                            </a>
                        ))}
                    </div>
                </div>

                <div>
                    <h4 className="text-sm font-semibold tracking-wider uppercase text-foreground">Navigasi</h4>
                    <ul className="mt-4 space-y-2.5 text-sm">
                        {navItems.map((item) => (
                            <li key={item.href}>
                                <Link href={item.href} className="transition-colors text-muted-foreground hover:text-primary">
                                    {item.label}
                                </Link>
                            </li>
                        ))}
                    </ul>
                </div>

                <div>
                    <h4 className="text-sm font-semibold tracking-wider uppercase text-foreground">Layanan</h4>
                    <ul className="mt-4 space-y-2.5 text-sm">
                        <li><Link href={routes.services()} className="text-muted-foreground hover:text-primary">Semua Layanan</Link></li>
                        <li><Link href={routes.blogs()} className="text-muted-foreground hover:text-primary">Artikel & Blog</Link></li>
                        <li><Link href={routes.faq()} className="text-muted-foreground hover:text-primary">FAQ</Link></li>
                        <li><Link href={routes.contact()} className="text-muted-foreground hover:text-primary">Kontak</Link></li>
                    </ul>
                </div>

                <div>
                    <h4 className="text-sm font-semibold tracking-wider uppercase text-foreground">Kontak</h4>
                    <ul className="mt-4 space-y-3 text-sm text-muted-foreground">
                        <li className="flex items-start gap-3">
                            <MapPin className="mt-0.5 h-4 w-4 shrink-0 text-primary" />
                            <span>Surabaya, Jawa Timur, Indonesia</span>
                        </li>
                        <li className="flex items-center gap-3">
                            <Phone className="w-4 h-4 shrink-0 text-primary" />
                            <a href="tel:+62000000000" className="hover:text-primary">+62 000-0000-0000</a>
                        </li>
                        <li className="flex items-center gap-3">
                            <Mail className="w-4 h-4 shrink-0 text-primary" />
                            <a href="mailto:info@tirtanirwana.id" className="hover:text-primary">info@tirtanirwana.id</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div className="border-t border-border">
                <div className="container flex flex-col items-center justify-between gap-2 py-6 text-sm text-muted-foreground sm:flex-row">
                    <p>© {year} Tirta Nirwana. Seluruh hak cipta dilindungi.</p>
                </div>
            </div>
        </footer>
    );
}
