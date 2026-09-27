import { Head } from '@inertiajs/react';
import PageHeader from '@/components/PageHeader';
import SectionHeading from '@/components/SectionHeading';
import TeamCard from '@/components/TeamCard';
import CtaBand from '@/components/CtaBand';
import { useI18n } from '@/lib/i18n';
import type { Team } from '@/types/models';

export default function TeamPage({ teams }: { teams: Team[] }) {
    const { t } = useI18n();
    return (
        <>
            <Head title={t('about.teamTitle')} />
            <PageHeader
                title={t('about.teamTitle')}
                subtitle={t('about.teamSubtitle')}
                crumbs={[{ label: t('about.teamCrumb') }]}
            />

            <section className="container py-20">
                {teams.length > 0 ? (
                    <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        {teams.map((team) => (
                            <TeamCard key={team.id} team={team} />
                        ))}
                    </div>
                ) : (
                    <SectionHeading title={t('about.teamEmptyTitle')} description={t('about.teamEmptyDesc')} />
                )}
            </section>

            <div className="pb-20">
                <CtaBand />
            </div>
        </>
    );
}
