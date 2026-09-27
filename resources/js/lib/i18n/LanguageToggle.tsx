import { cn } from '@/lib/utils'
import { useI18n } from './context'

/** ID | EN pill toggle. `onDark` styles it for the transparent hero navbar. */
export function LanguageToggle({ onDark = false }: { onDark?: boolean }) {
  const { lang, setLang } = useI18n()
  return (
    <div className={cn('flex items-center rounded-full p-0.5 text-xs font-semibold', onDark ? 'bg-white/15 backdrop-blur' : 'bg-secondary')}>
      {(['id', 'en'] as const).map((l) => (
        <button
          key={l}
          type="button"
          onClick={() => setLang(l)}
          aria-pressed={lang === l}
          className={cn(
            'rounded-full px-2.5 py-1 uppercase transition-colors',
            lang === l
              ? onDark
                ? 'bg-white text-foreground'
                : 'bg-brand-500 text-white'
              : onDark
                ? 'text-white/80 hover:text-white'
                : 'text-foreground/70 hover:text-foreground',
          )}
        >
          {l}
        </button>
      ))}
    </div>
  )
}
