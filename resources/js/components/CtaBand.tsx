import { Link } from '@inertiajs/react';
import { ArrowRight } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { routes } from '@/lib/routes';

export default function CtaBand() {
    return (
        <section className="container">
            <div className="relative overflow-hidden rounded-3xl bg-primary px-6 py-14 text-center text-primary-foreground md:px-16 md:py-20">
                <div aria-hidden className="pointer-events-none absolute inset-0 opacity-20">
                    <div className="absolute -left-10 top-0 h-64 w-64 rounded-full bg-white blur-3xl" />
                    <div className="absolute -right-10 bottom-0 h-64 w-64 rounded-full bg-accent blur-3xl" />
                </div>
                <div className="relative mx-auto max-w-2xl">
                    <h2 className="text-3xl font-bold tracking-tight md:text-4xl">Siap mulai belajar berenang?</h2>
                    <p className="mt-4 text-primary-foreground/85">
                        Bergabung dengan Tirta Nirwana dan rasakan pengalaman belajar renang yang aman, menyenangkan, dan terarah bersama pelatih berpengalaman.
                    </p>
                    <div className="mt-8 flex flex-wrap justify-center gap-3">
                        <Button asChild variant="secondary" size="lg">
                            <Link href={routes.contact()}>
                                Hubungi Kami <ArrowRight className="h-4 w-4" />
                            </Link>
                        </Button>
                        <Button
                            asChild
                            size="lg"
                            variant="outline"
                            className="border-white/40 bg-transparent text-primary-foreground hover:bg-white/10 hover:text-primary-foreground"
                        >
                            <Link href={routes.services()}>Lihat Layanan</Link>
                        </Button>
                    </div>
                </div>
            </div>
        </section>
    );
}
