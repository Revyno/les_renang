import { cn } from '@/lib/utils';

export default function SectionHeading({
    eyebrow,
    title,
    description,
    align = 'center',
    className,
}: {
    eyebrow?: string;
    title: string;
    description?: string;
    align?: 'center' | 'left';
    className?: string;
}) {
    return (
        <div
            className={cn(
                'max-w-2xl',
                align === 'center' ? 'mx-auto text-center' : 'text-left',
                className,
            )}
        >
            {eyebrow && (
                <span className="inline-block rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-primary">
                    {eyebrow}
                </span>
            )}
            <h2 className="mt-4 text-3xl font-bold tracking-tight text-foreground md:text-4xl">{title}</h2>
            {description && <p className="mt-4 text-muted-foreground">{description}</p>}
        </div>
    );
}
