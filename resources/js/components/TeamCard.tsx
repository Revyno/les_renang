import { User } from 'lucide-react';
import { Facebook, Instagram, Twitter } from '@/components/icons';
import { Card } from '@/components/ui/card';
import { storageUrl } from '@/lib/utils';
import type { Team } from '@/types/models';

export default function TeamCard({ team }: { team: Team }) {
    const img = storageUrl(team.imgUrl);
    const socials = [
        { href: team.instalink, icon: Instagram, label: 'Instagram' },
        { href: team.fblink, icon: Facebook, label: 'Facebook' },
        { href: team.twitterlink, icon: Twitter, label: 'Twitter' },
    ].filter((s) => s.href);

    return (
        <Card className="group overflow-hidden p-0 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
            <div className="relative aspect-[4/5] overflow-hidden bg-secondary">
                {img ? (
                    <img
                        src={img}
                        alt={team.name}
                        loading="lazy"
                        className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                    />
                ) : (
                    <div className="flex h-full w-full items-center justify-center text-muted-foreground">
                        <User className="h-12 w-12" />
                    </div>
                )}
                {socials.length > 0 && (
                    <div className="absolute inset-x-0 bottom-0 flex translate-y-full justify-center gap-2 bg-gradient-to-t from-black/60 to-transparent p-4 transition-transform duration-300 group-hover:translate-y-0">
                        {socials.map(({ href, icon: Icon, label }) => (
                            <a
                                key={label}
                                href={href as string}
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label={`${team.name} di ${label}`}
                                className="flex h-9 w-9 items-center justify-center rounded-full bg-white/90 text-slate-800 transition-colors hover:bg-primary hover:text-primary-foreground"
                            >
                                <Icon className="h-4 w-4" />
                            </a>
                        ))}
                    </div>
                )}
            </div>
            <div className="p-5 text-center">
                <h3 className="font-semibold text-foreground">{team.name}</h3>
                <p className="mt-0.5 text-sm text-primary">{team.position}</p>
            </div>
        </Card>
    );
}
