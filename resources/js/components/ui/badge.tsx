import * as React from 'react'
import { cn } from '@/lib/utils'

export interface BadgeProps extends React.HTMLAttributes<HTMLDivElement> {
  variant?: 'default' | 'accent' | 'outline'
}

function Badge({ className, variant = 'default', ...props }: BadgeProps) {
  const variants = {
    default: 'bg-primary/10 text-primary',
    accent: 'bg-accent/15 text-accent',
    outline: 'border border-border text-foreground',
  }
  return (
    <div
      className={cn(
        'inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold tracking-wide uppercase',
        variants[variant],
        className,
      )}
      {...props}
    />
  )
}

export { Badge }
