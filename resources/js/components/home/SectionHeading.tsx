import { cn } from '@/lib/utils'

interface Props {
  eyebrow?: string
  title: string
  description?: string
  align?: 'left' | 'center'
  tone?: 'light' | 'dark' // dark = on a dark section
  className?: string
}

export default function SectionHeading({
  eyebrow,
  title,
  description,
  align = 'center',
  tone = 'light',
  className,
}: Props) {
  return (
    <div className={cn('flex flex-col gap-4', align === 'center' ? 'items-center text-center' : 'items-start', className)}>
      {eyebrow && (
        <span className="inline-flex items-center rounded-full bg-brand-600 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider text-white">
          {eyebrow}
        </span>
      )}
      <h2
        className={cn(
          'max-w-3xl text-3xl font-medium leading-[1.12] tracking-tight md:text-4xl lg:text-5xl',
          tone === 'dark' ? 'text-white' : 'text-foreground',
        )}
      >
        {title}
      </h2>
      {description && (
        <p className={cn('max-w-2xl text-base leading-relaxed md:text-lg', tone === 'dark' ? 'text-stone-300' : 'text-muted-foreground')}>
          {description}
        </p>
      )}
    </div>
  )
}
