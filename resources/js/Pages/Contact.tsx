import { type FormEvent, type ReactNode } from 'react'
import { useForm, usePage } from '@inertiajs/react'
import { MapPin, Phone, Mail, MessageCircle, CheckCircle2, ArrowUpRight } from 'lucide-react'
import Seo from '@/components/Seo'
import SiteLayout from '@/Layouts/SiteLayout'
import PageHeader from '@/components/site/PageHeader'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Textarea } from '@/components/ui/textarea'
import { Label } from '@/components/ui/label'
import { useSite, waLink } from '@/lib/site'
import type { SharedProps } from '@/types/models'

interface Props {
  meta: { title: string; description: string }
}

export default function ContactPage({ meta }: Props) {
  const site = useSite()
  const flash = usePage<SharedProps>().props.flash
  const { data, setData, post, processing, errors, reset } = useForm({
    name: '',
    email: '',
    phone: '',
    subject: '',
    message: '',
  })

  const submit = (e: FormEvent) => {
    e.preventDefault()
    post('/kontak', { preserveScroll: true, onSuccess: () => reset() })
  }

  const info = [
    { icon: MapPin, label: 'Alamat', value: site.address },
    { icon: Phone, label: 'Telepon', value: site.phone, href: `tel:${site.phone}` },
    { icon: Mail, label: 'Email', value: site.email, href: `mailto:${site.email}` },
  ]

  return (
    <>
      <Seo title={meta.title} description={meta.description} />
      <PageHeader
        eyebrow="Kontak"
        title="Telepon, kirim pesan, atau mampir kapan saja."
        description="Kami balas di hari kerja berikutnya."
        crumbs={[{ label: 'Kontak' }]}
      />

      <section className="mx-auto max-w-screen-2xl px-4 py-20 md:px-10 md:py-28">
        <div className="grid gap-10 lg:grid-cols-[5fr_7fr] lg:gap-16">
          {/* Contact info */}
          <div className="flex flex-col gap-4" data-aos="fade-right">
            {info.map((item) => (
              <div key={item.label} className="flex items-start gap-4 rounded-2xl bg-stone-100 p-6">
                <span className="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-brand-50 text-brand-500">
                  <item.icon className="h-5 w-5" />
                </span>
                <div>
                  <p className="text-xs uppercase tracking-wider text-stone-500">{item.label}</p>
                  {item.href ? (
                    <a href={item.href} className="mt-1 block font-medium text-foreground hover:text-brand-600">
                      {item.value}
                    </a>
                  ) : (
                    <p className="mt-1 font-medium text-foreground">{item.value}</p>
                  )}
                </div>
              </div>
            ))}
            {site.whatsapp && (
              <Button asChild variant="accent" size="lg" className="mt-2 self-start">
                <a href={waLink(site.whatsapp, site.whatsapp_message)} target="_blank" rel="noopener noreferrer">
                  <MessageCircle />
                  Chat via WhatsApp
                </a>
              </Button>
            )}
          </div>

          {/* Form */}
          <div className="rounded-3xl border border-border bg-background p-6 shadow-[0_24px_48px_-24px_rgba(23,23,23,0.18)] md:p-8" data-aos="fade-left">
            {flash?.success && (
              <div className="mb-6 flex items-start gap-3 rounded-2xl bg-emerald-50 p-4 text-sm text-emerald-800">
                <CheckCircle2 className="mt-0.5 h-5 w-5 shrink-0" />
                <span>{flash.success}</span>
              </div>
            )}
            <form onSubmit={submit} className="space-y-5">
              <div className="grid gap-5 sm:grid-cols-2">
                <Field id="name" label="Nama" error={errors.name}>
                  <Input id="name" placeholder="Nama lengkap" value={data.name} onChange={(e) => setData('name', e.target.value)} required />
                </Field>
                <Field id="email" label="Email" error={errors.email}>
                  <Input id="email" type="email" placeholder="nama@email.com" value={data.email} onChange={(e) => setData('email', e.target.value)} required />
                </Field>
              </div>
              <div className="grid gap-5 sm:grid-cols-2">
                <Field id="phone" label="Telepon (opsional)" error={errors.phone}>
                  <Input id="phone" placeholder="08xx xxxx xxxx" value={data.phone} onChange={(e) => setData('phone', e.target.value)} />
                </Field>
                <Field id="subject" label="Program yang diminati (opsional)" error={errors.subject}>
                  <Input id="subject" placeholder="mis. Kelas Anak" value={data.subject} onChange={(e) => setData('subject', e.target.value)} />
                </Field>
              </div>
              <Field id="message" label="Pesan" error={errors.message}>
                <Textarea id="message" rows={5} placeholder="Tulis pesanmu di sini" value={data.message} onChange={(e) => setData('message', e.target.value)} required />
              </Field>
              <Button type="submit" size="lg" disabled={processing} className="w-full sm:w-auto">
                {processing ? 'Mengirim…' : 'Kirim pesan'}
              </Button>
            </form>
          </div>
        </div>
      </section>

      {/* CTA band */}
      <section className="px-4 pb-20 md:px-10 md:pb-28">
        <div className="mx-auto flex max-w-screen-2xl flex-col items-start gap-6 rounded-4xl bg-brand-500 px-8 py-14 text-white md:flex-row md:items-center md:justify-between md:px-14" data-aos="fade-up">
          <div>
            <h2 className="text-3xl font-medium leading-tight tracking-tight md:text-4xl">Ingin lihat kolamnya langsung?</h2>
            <p className="mt-3 max-w-xl text-brand-50">
              Mampir ke {site.address}. Kami senang menyambutmu dan menjawab pertanyaan seputar kelas.
            </p>
          </div>
          <Button asChild variant="outline" size="lg" className="shrink-0 border-white bg-white text-brand-600 hover:bg-white/90 hover:text-brand-700">
            <a href="https://maps.google.com" target="_blank" rel="noopener noreferrer">
              Lihat lokasi di peta
              <ArrowUpRight />
            </a>
          </Button>
        </div>
      </section>
    </>
  )
}

function Field({
  id,
  label,
  error,
  children,
}: {
  id: string
  label: string
  error?: string
  children: ReactNode
}) {
  return (
    <div className="space-y-1.5">
      <Label htmlFor={id}>{label}</Label>
      {children}
      {error && <p className="text-xs text-destructive">{error}</p>}
    </div>
  )
}

ContactPage.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>
