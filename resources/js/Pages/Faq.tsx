import { Head, Link } from '@inertiajs/react';
import { HelpCircle } from 'lucide-react';
import PageHeader from '@/components/PageHeader';
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion';
import { Button } from '@/components/ui/button';
import { routes } from '@/lib/routes';
import type { Faq as FaqType } from '@/types/models';

export default function Faq({ faqs }: { faqs: FaqType[] }) {
    return (
        <>
            <Head title="FAQ" />
            <PageHeader
                title="Pertanyaan Umum"
                subtitle="Jawaban atas pertanyaan yang paling sering ditanyakan seputar layanan kami."
                crumbs={[{ label: 'FAQ' }]}
            />

            <section className="container py-20">
                <div className="mx-auto max-w-3xl">
                    {faqs.length > 0 ? (
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
                    ) : (
                        <div className="rounded-2xl border border-dashed border-border py-20 text-center">
                            <HelpCircle className="mx-auto h-10 w-10 text-muted-foreground" />
                            <p className="mt-4 text-muted-foreground">Belum ada pertanyaan yang tersedia.</p>
                        </div>
                    )}

                    <div className="mt-12 rounded-2xl border border-border bg-secondary/50 p-8 text-center">
                        <h3 className="text-lg font-semibold text-foreground">Masih ada pertanyaan?</h3>
                        <p className="mt-2 text-sm text-muted-foreground">
                            Tim kami dengan senang hati membantu. Hubungi kami kapan saja.
                        </p>
                        <Button asChild className="mt-5">
                            <Link href={routes.contact()}>Hubungi Kami</Link>
                        </Button>
                    </div>
                </div>
            </section>
        </>
    );
}
