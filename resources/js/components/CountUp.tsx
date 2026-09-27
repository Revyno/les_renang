import { useEffect, useMemo, useRef, useState } from 'react'

// Animates the numeric part of a stat string from 0 to its value when scrolled into
// view, preserving any prefix/suffix ("10+", "2.500+", "4.9/5") and separator style.
// ponytail: id-style formatting only (dot = thousands, "." kept as decimal to match
// source like "4.9"). Upgrade to Intl if the CMS starts emitting other locales.
type Parsed = { prefix: string; suffix: string; target: number; decimals: number; grouped: boolean }

const groupThousands = (intStr: string) => intStr.replace(/\B(?=(\d{3})+(?!\d))/g, '.')

function parseStat(raw: string): Parsed | null {
  const m = raw.match(/[\d.,]+/)
  if (!m) return null
  const num = m[0]
  const prefix = raw.slice(0, m.index)
  const suffix = raw.slice((m.index ?? 0) + num.length)

  if (num.includes(',')) {
    // Indonesian: dot = thousands, comma = decimal ("1.234,5")
    const [ip, dp = ''] = num.replace(/\./g, '').split(',')
    return { prefix, suffix, target: parseFloat(`${ip}.${dp || '0'}`), decimals: dp.length, grouped: num.includes('.') }
  }
  if (num.includes('.')) {
    const parts = num.split('.')
    const thousands = parts.length > 1 && parts[0].length <= 3 && parts.slice(1).every((p) => p.length === 3)
    if (thousands) return { prefix, suffix, target: parseInt(parts.join(''), 10), decimals: 0, grouped: true }
    return { prefix, suffix, target: parseFloat(num), decimals: (parts[1] || '').length, grouped: false }
  }
  return { prefix, suffix, target: parseInt(num, 10) || 0, decimals: 0, grouped: false }
}

const fmt = (val: number, p: Parsed) => {
  if (p.decimals > 0) return val.toFixed(p.decimals)
  const intStr = String(Math.round(val))
  return p.grouped ? groupThousands(intStr) : intStr
}

export default function CountUp({ value, className, duration = 1400 }: { value: string; className?: string; duration?: number }) {
  const raw = String(value ?? '')
  const parsed = useMemo(() => parseStat(raw), [raw])
  const ref = useRef<HTMLSpanElement>(null)
  const [text, setText] = useState(parsed ? parsed.prefix + fmt(0, parsed) + parsed.suffix : raw)

  useEffect(() => {
    if (!parsed) return setText(raw)
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return setText(raw)
    const el = ref.current
    if (!el) return

    let raf = 0
    let done = false
    const run = () => {
      const t0 = performance.now()
      const tick = (now: number) => {
        const prog = Math.min(1, (now - t0) / duration)
        const eased = 1 - Math.pow(1 - prog, 3)
        setText(parsed.prefix + fmt(parsed.target * eased, parsed) + parsed.suffix)
        if (prog < 1) raf = requestAnimationFrame(tick)
      }
      raf = requestAnimationFrame(tick)
    }
    const io = new IntersectionObserver(
      (entries) => entries.forEach((e) => {
        if (e.isIntersecting && !done) {
          done = true
          run()
          io.disconnect()
        }
      }),
      { threshold: 0.4 },
    )
    io.observe(el)
    return () => {
      io.disconnect()
      cancelAnimationFrame(raf)
    }
  }, [parsed, raw, duration])

  return (
    <span ref={ref} className={className}>
      {text}
    </span>
  )
}
