import { Badge } from '@/components/ui/badge'
import { cn } from '@/lib/utils'

interface Props {
  eyebrow?: string
  title: string
  description?: string
  align?: 'left' | 'center'
  className?: string
}

export default function SectionHeading({ eyebrow, title, description, align = 'center', className }: Props) {
  return (
    <div className={cn('max-w-2xl', align === 'center' && 'mx-auto text-center', className)}>
      {eyebrow && (
        <Badge variant="accent" className="mb-3">
          {eyebrow}
        </Badge>
      )}
      <h2 className="text-3xl font-bold tracking-tight text-primary md:text-4xl">{title}</h2>
      {description && <p className="mt-4 text-base leading-relaxed text-muted-foreground">{description}</p>}
    </div>
  )
}
