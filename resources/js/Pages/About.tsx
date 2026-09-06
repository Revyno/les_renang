import { Head } from '@inertiajs/react';
import { ImageIcon } from 'lucide-react';
import PageHeader from '@/components/PageHeader';
import SectionHeading from '@/components/SectionHeading';
import TeamCard from '@/components/TeamCard';
import CtaBand from '@/components/CtaBand';
import { storageUrl } from '@/lib/utils';
import type { AboutUs, Team } from '@/types/models';

export default function About({ aboutus, teams }: { aboutus: AboutUs | null; teams: Team[] }) {
    const img = storageUrl(aboutus?.img);

    return (
        <>
            <Head title="Tentang Kami" />
            <PageHeader
                title="Tentang Tirta Nirwana"
                subtitle="Mengenal lebih dekat visi, nilai, dan tim di balik sekolah renang kami."
                crumbs={[{ label: 'Tentang' }]}
            />

            <section className="container py-20">
                <div className="grid items-center gap-12 lg:grid-cols-2">
                    <div className="relative overflow-hidden rounded-3xl border border-border bg-secondary shadow-lg">
                        {img ? (
                            <img src={img} alt={aboutus?.title ?? 'Tentang kami'} className="aspect-[4/3] w-full object-cover" />
                        ) : (
                            <div className="flex aspect-[4/3] items-center justify-center text-muted-foreground">
                                <ImageIcon className="h-12 w-12" />
                            </div>
                        )}
                    </div>

                    <div>
                        <span className="inline-block rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-primary">
                            Tentang Kami
                        </span>
                        <h2 className="mt-4 text-3xl font-bold tracking-tight text-foreground md:text-4xl">
                            {aboutus?.title ?? 'Berenang dengan aman dan menyenangkan'}
                        </h2>
                        {aboutus?.description ? (
                            <div className="rich mt-5" dangerouslySetInnerHTML={{ __html: aboutus.description }} />
                        ) : (
                            <p className="mt-5 text-muted-foreground">
                                Tirta Nirwana berkomitmen menghadirkan pengalaman belajar renang terbaik bagi setiap murid.
                            </p>
                        )}
                    </div>
                </div>
            </section>

            {teams.length > 0 && (
                <section className="border-t border-border bg-secondary/40 py-20">
                    <div className="container">
                        <SectionHeading
                            eyebrow="Tim Kami"
                            title="Orang-orang di balik Tirta Nirwana"
                            description="Pelatih dan staf berpengalaman yang siap membimbing perjalanan renangmu."
                        />
                        <div className="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                            {teams.map((team) => (
                                <TeamCard key={team.id} team={team} />
                            ))}
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
