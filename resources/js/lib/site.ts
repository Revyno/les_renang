import { usePage } from '@inertiajs/react'
import type { SharedProps, SiteInfo } from '@/types/models'

// Placeholder contact details used until the admin fills the `contacts` settings.
const FALLBACK: SiteInfo = {
  address: 'Surabaya, Jawa Timur, Indonesia',
  phone: '+62 812 3456 7890',
  email: 'halo@tirtanirwana.id',
  whatsapp: '6281234567890',
  whatsapp_message: 'Halo Tirta Nirwana, saya ingin bertanya tentang program renang.',
  social: null,
}

/** Site-wide contact info from Inertia shared props, with sensible fallbacks. */
export function useSite(): SiteInfo {
  const site = (usePage<SharedProps>().props.site ?? {}) as Partial<SiteInfo>
  return {
    address: site.address || FALLBACK.address,
    phone: site.phone || FALLBACK.phone,
    email: site.email || FALLBACK.email,
    whatsapp: site.whatsapp || FALLBACK.whatsapp,
    whatsapp_message: site.whatsapp_message || FALLBACK.whatsapp_message,
    social: site.social ?? FALLBACK.social,
  }
}

/** Build a wa.me link from a raw number + optional prefilled text. */
export function waLink(number: string, message?: string | null): string {
  const digits = number.replace(/[^\d]/g, '')
  const text = message ? `?text=${encodeURIComponent(message)}` : ''
  return `https://wa.me/${digits}${text}`
}
