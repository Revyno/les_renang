import { Link } from '@inertiajs/react';
import { ArrowRight, Droplets, LifeBuoy, Medal, Users, Waves } from 'lucide-react';
import { Card } from '@/components/ui/card';
import { routes } from '@/lib/routes';
import type { Service } from '@/types/models';

const icons = [Waves, Droplets, LifeBuoy, Medal, Users];

export default function ServiceCard({ service, index = 0 }: { service: Service; index?: number }) {
    const Icon = icons[index % icons.length];

    return (
        <Link href={routes.serviceDetail(service.id)} className="group block">
            <Card className="h-full p-6 transition-all duration-300 hover:-translate-y-1 hover:border-primary/40 hover:shadow-lg">
                <span className="flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10 text-primary transition-colors group-hover:bg-primary group-hover:text-primary-foreground">
                    <Icon className="h-6 w-6" />
                </span>
                <h3 className="mt-5 text-lg font-semibold text-foreground">{service.title}</h3>
                <p className="mt-2 line-clamp-3 text-sm leading-relaxed text-muted-foreground">{service.short_desc}</p>
                <span className="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
                    Selengkapnya
                    <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" />
                </span>
            </Card>
        </Link>
    );
}
