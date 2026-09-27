import { cld } from '@/lib/media'

// Single source of truth for brand identity. Real brand per the logo assets is
// "Tirta Nirwana" (Sekolah Renang Surabaya). Change here to rebrand everywhere.
export const BRAND = {
  name: 'Tirta Nirwana',
  short: 'TirtaNirwana',
  tagline: 'Sekolah Renang Surabaya',
  logo: cld('logo-mark.png'), // transparent badge — works on light & dark
} as const
