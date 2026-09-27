import { createContext, useCallback, useContext, useState, type ReactNode } from 'react'
import { dict, type Lang } from './dict'

const KEY = 'site-lang'

/** Walk a dot-path into a bundle; fall back to the key itself if missing. */
function resolve(bundle: Record<string, unknown>, path: string): string {
  const val = path
    .split('.')
    .reduce<unknown>((o, k) => (o != null && typeof o === 'object' ? (o as Record<string, unknown>)[k] : undefined), bundle)
  return typeof val === 'string' ? val : path
}

type I18n = { lang: Lang; setLang: (l: Lang) => void; t: (path: string) => string }

const Ctx = createContext<I18n | null>(null)

export function I18nProvider({ children }: { children: ReactNode }) {
  const [lang, setLangState] = useState<Lang>(() => {
    try {
      const s = localStorage.getItem(KEY)
      if (s === 'en' || s === 'id') return s
    } catch {
      /* private mode / blocked storage */
    }
    return 'id'
  })

  const setLang = useCallback((l: Lang) => {
    setLangState(l)
    try {
      localStorage.setItem(KEY, l)
    } catch {
      /* ignore */
    }
    if (typeof document !== 'undefined') document.documentElement.lang = l
  }, [])

  const t = useCallback((path: string) => resolve(dict[lang], path), [lang])

  return <Ctx.Provider value={{ lang, setLang, t }}>{children}</Ctx.Provider>
}

export function useI18n(): I18n {
  const ctx = useContext(Ctx)
  if (!ctx) throw new Error('useI18n must be used within I18nProvider')
  return ctx
}
