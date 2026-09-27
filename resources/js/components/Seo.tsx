import { Head } from '@inertiajs/react'

interface SeoProps {
  title?: string
  description?: string
  image?: string
  url?: string
}

const SITE = 'Tirta Nirwana'
const DEFAULT_DESC = 'Sekolah renang profesional di Surabaya untuk segala usia. Pelatih bersertifikat, kolam aman, jadwal fleksibel.'

// Centralises <title>, meta description, and Open Graph/Twitter tags.
// createInertiaApp already appends " — Tirta Nirwana" to the title prop.
export default function Seo({ title, description = DEFAULT_DESC, image, url }: SeoProps) {
  const fullTitle = title ? `${title} — ${SITE}` : SITE
  return (
    <Head title={title}>
      <meta name="description" content={description} head-key="description" />
      <meta property="og:type" content="website" head-key="og:type" />
      <meta property="og:site_name" content={SITE} head-key="og:site_name" />
      <meta property="og:title" content={fullTitle} head-key="og:title" />
      <meta property="og:description" content={description} head-key="og:description" />
      {url && <meta property="og:url" content={url} head-key="og:url" />}
      {image && <meta property="og:image" content={image} head-key="og:image" />}
      <meta name="twitter:card" content={image ? 'summary_large_image' : 'summary'} head-key="twitter:card" />
      <meta name="twitter:title" content={fullTitle} head-key="twitter:title" />
      <meta name="twitter:description" content={description} head-key="twitter:description" />
      {image && <meta name="twitter:image" content={image} head-key="twitter:image" />}
    </Head>
  )
}
