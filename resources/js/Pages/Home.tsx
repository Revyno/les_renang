import { Head, Link } from '@inertiajs/react';
import { ArrowRight, CheckCircle2, HeartHandshake, ShieldCheck, Sparkles, Waves } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion';
import SectionHeading from '@/components/SectionHeading';
import ServiceCard from '@/components/ServiceCard';
import CtaBand from '@/components/CtaBand';
import { routes } from '@/lib/routes';
import type { Faq, Service } from '@/types/models';

const stats = [
    { value: '10+', label: 'Tahun pengalaman' },
    { value: '2.500+', label: 'Murid terlatih' },
    { value: '15+', label: 'Pelatih bersertifikat' },
    { value: '4.9/5', label: 'Rating kepuasan' },
];

const features = [
    { icon: ShieldCheck, title: 'Aman & Terawasi', desc: 'Rasio pelatih–murid ideal dan protokol keselamatan air yang ketat di setiap sesi.' },
    { icon: HeartHandshake, title: 'Pendekatan Personal', desc: 'Program disesuaikan dengan usia, level, dan tujuan setiap murid.' },
    { icon: Sparkles, title: 'Metode Modern', desc: 'Teknik pengajaran terkini yang membuat belajar renang cepat dan menyenangkan.' },
];

export default function Home({ services, faqs }: { services: Service[]; faqs: Faq[] }) {
    return (
        <>
            <Head title="Beranda">
                <meta property="og:type" content="website" head-key="og:type" />
                <meta property="og:title" content="Tirta Nirwana — Sekolah Renang Surabaya" head-key="og:title" />
                <meta
                    property="og:description"
                    content="Kursus renang profesional untuk segala usia  aman, menyenangkan, dan terarah."
                    head-key="og:description"
                />
            </Head>

            {/* Hero */}
            <section className="relative overflow-hidden">
                <div aria-hidden className="absolute inset-0 pointer-events-none">
                    <div className="absolute -right-40 -top-40 h-[32rem] w-[32rem] rounded-full bg-primary/10 blur-3xl" />
                    <div className="absolute rounded-full -left-32 top-40 h-96 w-96 bg-accent/10 blur-3xl" />
                </div>

                <div className="container relative grid items-center gap-12 py-16 md:py-24 lg:grid-cols-2">
                    <div className="animate-fade-up">
                        <span className="inline-flex items-center gap-2 rounded-full border border-border bg-background/60 px-4 py-1.5 text-sm font-medium text-primary backdrop-blur">
                            <Waves className="w-4 h-4" /> Sekolah renang #1 di Surabaya
                        </span>
                        <h1 className="mt-6 text-4xl font-extrabold leading-[1.1] tracking-tight text-foreground sm:text-5xl lg:text-6xl">
                            Belajar berenang dengan <span className="text-primary">percaya diri</span>
                        </h1>
                        <p className="max-w-xl mt-6 text-lg leading-relaxed text-muted-foreground">
                            Tirta Nirwana menghadirkan kursus renang profesional untuk segala usia — dari pengenalan air pertama hingga teknik kompetisi, dibimbing pelatih berpengalaman.
                        </p>
                        <div className="flex flex-wrap gap-3 mt-8">
                            <Button asChild size="lg">
                                <Link href={routes.contact()}>
                                    Daftar Sekarang <ArrowRight className="w-4 h-4" />
                                </Link>
                            </Button>
                            <Button asChild size="lg" variant="outline">
                                <Link href={routes.services()}>Jelajahi Layanan</Link>
                            </Button>
                        </div>
                        <ul className="flex flex-wrap mt-8 text-sm gap-x-6 gap-y-2 text-muted-foreground">
                            {['Instruktur bersertifikat', 'Kelas fleksibel', 'Semua usia'].map((t) => (
                                <li key={t} className="flex items-center gap-2">
                                    <CheckCircle2 className="w-4 h-4 text-primary" /> {t}
                                </li>
                            ))}
                        </ul>
                    </div>

                    <div className="relative animate-fade-up">
                        <div className="relative overflow-hidden rounded-[2rem] border border-border bg-secondary shadow-xl">
                            <img
                                src="/front/images/about-us.png"
                                alt="Suasana kelas renang Tirta Nirwana"
                                className="aspect-[4/3] w-full object-cover"
                                onError={(e) => {
                                    (e.currentTarget as HTMLImageElement).style.display = 'none';
                                }}
                            />
                            <div className="absolute inset-0 bg-gradient-to-tr from-primary/25 to-transparent" />
                        </div>
                        <div className="absolute hidden p-4 border shadow-lg -bottom-6 -left-4 rounded-2xl border-border bg-card sm:block">
                            <p className="text-2xl font-extrabold text-primary">2.500+</p>
                            <p className="text-xs text-muted-foreground">murid telah bergabung</p>
                        </div>
                    </div>
                </div>
            </section>

            {/* Stats */}
            <section className="container">
                <div className="grid grid-cols-2 gap-px overflow-hidden border rounded-2xl border-border bg-border lg:grid-cols-4">
                    {stats.map((s) => (
                        <div key={s.label} className="p-6 text-center bg-card">
                            <p className="text-3xl font-extrabold text-foreground">{s.value}</p>
                            <p className="mt-1 text-sm text-muted-foreground">{s.label}</p>
                        </div>
                    ))}
                </div>
            </section>

            {/* Features */}
            <section className="container py-20">
                <SectionHeading
                    eyebrow="Kenapa Tirta Nirwana"
                    title="Pengalaman belajar renang terbaik"
                    description="Kami menggabungkan keselamatan, metode modern, dan pendekatan personal agar setiap murid berkembang dengan nyaman."
                />
                <div className="grid gap-6 mt-12 md:grid-cols-3">
                    {features.map(({ icon: Icon, title, desc }) => (
                        <div key={title} className="border rounded-2xl border-border bg-card p-7">
                            <span className="flex items-center justify-center w-12 h-12 rounded-xl bg-primary/10 text-primary">
                                <Icon className="w-6 h-6" />
                            </span>
                            <h3 className="mt-5 text-lg font-semibold text-foreground">{title}</h3>
                            <p className="mt-2 text-sm leading-relaxed text-muted-foreground">{desc}</p>
                        </div>
                    ))}
                </div>
            </section>

            {/* Services */}
            <section className="py-20 border-y border-border bg-secondary/40">
                <div className="container">
                    <div className="flex flex-col items-end justify-between gap-6 sm:flex-row">
                        <SectionHeading
                            align="left"
                            eyebrow="Layanan Kami"
                            title="Program yang bisa kamu ikuti"
                            description="Pilihan program renang untuk berbagai kebutuhan dan level kemampuan."
                            className="mx-0"
                        />
                        <Button asChild variant="ghost" className="shrink-0">
                            <Link href={routes.services()}>
                                Semua layanan <ArrowRight className="w-4 h-4" />
                            </Link>
                        </Button>
                    </div>

                    {services.length > 0 ? (
                        <div className="grid gap-6 mt-12 sm:grid-cols-2 lg:grid-cols-3">
                            {services.slice(0, 6).map((service, i) => (
                                <ServiceCard key={service.id} service={service} index={i} />
                            ))}
                        </div>
                    ) : (
                        <p className="mt-12 text-center text-muted-foreground">Belum ada layanan yang tersedia.</p>
                    )}
                </div>
            </section>

            {/* FAQ */}
            {faqs.length > 0 && (
                <section className="container py-20">
                    <SectionHeading
                        eyebrow="FAQ"
                        title="Pertanyaan yang sering diajukan"
                        description="Hal-hal yang paling sering ditanyakan calon murid sebelum bergabung."
                    />
                    <div className="max-w-3xl mx-auto mt-12">
                        <Accordion type="single" collapsible className="space-y-3">
                            {faqs.map((faq) => (
                                <AccordionItem key={faq.id} value={`faq-${faq.id}`}>
                                    <AccordionTrigger>{faq.question}</AccordionTrigger>
                                    <AccordionContent>
                                        <div className="rich" dangerouslySetInnerHTML={{ __html: faq.answer }} />
                                    </AccordionContent>
                                </AccordionItem>
                            ))}
                        </Accordion>
                        <div className="mt-8 text-center">
                            <Button asChild variant="outline">
                                <Link href={routes.faq()}>
                                    Lihat semua FAQ <ArrowRight className="w-4 h-4" />
                                </Link>
                            </Button>
                        </div>
                    </div>
                </section>
            )}

            <div className="py-20">
                <CtaBand />
            </div>
        </>
    );
}
