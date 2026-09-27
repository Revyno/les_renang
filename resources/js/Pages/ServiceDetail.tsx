import { Head, Link } from '@inertiajs/react';
import { ArrowLeft } from 'lucide-react';
import PageHeader from '@/components/PageHeader';
import CtaBand from '@/components/CtaBand';
import { Button } from '@/components/ui/button';
import { routes } from '@/lib/routes';
import { useI18n } from '@/lib/i18n';
import type { Service } from '@/types/models';

export default function ServiceDetail({ service }: { service: Service }) {
    const { t } = useI18n();
    return (
        <>
            <Head title={service.title} />
            <PageHeader
                title={service.title}
                subtitle={service.short_desc}
                crumbs={[{ label: t('nav.services'), href: routes.services() }, { label: service.title }]}
            />

            <article className="container py-16">
                <div className="mx-auto max-w-3xl">
                    {service.description ? (
                        <div className="rich" dangerouslySetInnerHTML={{ __html: service.description }} />
                    ) : (
                        <p className="text-muted-foreground">{t('services.detailNoDesc')}</p>
                    )}

                    <div className="mt-12 border-t border-border pt-8">
                        <Button asChild variant="outline">
                            <Link href={routes.services()}>
                                <ArrowLeft className="h-4 w-4" /> {t('services.detailBack')}
                            </Link>
                        </Button>
                    </div>
                </div>
            </article>

            <div className="pb-20">
                <CtaBand />
            </div>
        </>
    );
}
