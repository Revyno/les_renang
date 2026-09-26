import { type ReactNode } from 'react'
import Navbar from '@/components/site/Navbar'
import Footer from '@/components/site/Footer'
import WhatsAppFloat from '@/components/site/WhatsAppFloat'

// Persistent public layout. Attach via `Page.layout = (page) => <SiteLayout>{page}</SiteLayout>`
// so the navbar/footer stay mounted across Inertia visits.
export default function SiteLayout({ children }: { children: ReactNode }) {
  return (
    <div className="flex min-h-screen flex-col bg-background">
      <Navbar />
      <main className="flex-1">{children}</main>
      <Footer />
      <WhatsAppFloat />
    </div>
  )
}
