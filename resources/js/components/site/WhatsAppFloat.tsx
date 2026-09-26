import { cld } from '@/lib/media'
import { useSite, waLink } from '@/lib/site'

export default function WhatsAppFloat() {
  const site = useSite()
  if (!site.whatsapp) return null

  return (
    <a
      href={waLink(site.whatsapp, site.whatsapp_message)}
      target="_blank"
      rel="noopener noreferrer"
      aria-label="Chat WhatsApp"
      className="fixed bottom-5 right-5 z-40 grid h-14 w-14 place-items-center rounded-full bg-[#25D366] shadow-lg transition-transform hover:scale-110"
    >
      <img src={cld('whatsapp.png')} alt="" className="h-8 w-8" loading="lazy" />
    </a>
  )
}
