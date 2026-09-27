import { Head } from '@inertiajs/react';
import PageHeader from '@/components/PageHeader';
import SectionHeading from '@/components/SectionHeading';
import TeamCard from '@/components/TeamCard';
import CtaBand from '@/components/CtaBand';
import type { Team } from '@/types/models';

export default function TeamPage({ teams }: { teams: Team[] }) {
    return (
        <>
            <Head title="Tim Kami" />
            <PageHeader
                title="Tim Kami"
                subtitle="Kenali pelatih dan staf berpengalaman yang mendampingi setiap murid."
                crumbs={[{ label: 'Tim' }]}
            />

            <section className="container py-20">
                {teams.length > 0 ? (
                    <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        {teams.map((team) => (
                            <TeamCard key={team.id} team={team} />
                        ))}
                    </div>
                ) : (
                    <SectionHeading title="Belum ada anggota tim" description="Informasi tim akan segera tersedia." />
                )}
            </section>

            <div className="pb-20">
                <CtaBand />
            </div>
        </>
    );
}
