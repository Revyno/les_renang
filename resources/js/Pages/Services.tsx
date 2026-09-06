import { Head } from '@inertiajs/react';
import PageHeader from '@/components/PageHeader';
import SectionHeading from '@/components/SectionHeading';
import ServiceCard from '@/components/ServiceCard';
import CtaBand from '@/components/CtaBand';
import type { Service } from '@/types/models';

export default function Services({ services }: { services: Service[] }) {
    return (
        <>
            <Head title="Layanan" />
            <PageHeader
                title="Layanan Kami"
                subtitle="Program renang lengkap untuk segala usia dan level mulai dari pemula hingga mahir."
                crumbs={[{ label: 'Layanan' }]}
            />

            <section className="container py-20">
                {services.length > 0 ? (
                    <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        {services.map((service, i) => (
                            <ServiceCard key={service.id} service={service} index={i} />
                        ))}
                    </div>
                ) : (
                    <SectionHeading title="Belum ada layanan" description="Layanan akan segera tersedia. Silakan cek kembali nanti." />
                )}
            </section>

            <div className="pb-20">
                <CtaBand />
            </div>
        </>
    );
}
