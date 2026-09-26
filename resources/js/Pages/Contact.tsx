import { type FormEvent, type ReactNode } from 'react'
import { useForm, usePage } from '@inertiajs/react'
import { MapPin, Phone, Mail, MessageCircle, CheckCircle2 } from 'lucide-react'
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
        title="Hubungi Kami"
        description="Punya pertanyaan atau ingin mendaftar? Kirim pesan atau chat langsung via WhatsApp."
        crumbs={[{ label: 'Kontak' }]}
      />

      <section className="py-16 md:py-20">
        <div className="container grid gap-10 lg:grid-cols-2">
          {/* Info */}
          <div>
            <h2 className="text-2xl font-bold text-primary">Informasi Kontak</h2>
            <p className="mt-3 text-muted-foreground">
              Tim kami siap membantu memilih program yang tepat untuk Anda atau keluarga.
            </p>
            <ul className="mt-8 space-y-5">
              {info.map((item) => (
                <li key={item.label} className="flex items-start gap-4">
                  <span className="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-accent/15 text-accent">
                    <item.icon className="h-5 w-5" />
                  </span>
                  <div>
                    <p className="text-xs uppercase tracking-wider text-muted-foreground">{item.label}</p>
                    {item.href ? (
                      <a href={item.href} className="font-medium text-foreground hover:text-accent">
                        {item.value}
                      </a>
                    ) : (
                      <p className="font-medium text-foreground">{item.value}</p>
                    )}
                  </div>
                </li>
              ))}
            </ul>
            {site.whatsapp && (
              <Button asChild variant="accent" className="mt-8">
                <a href={waLink(site.whatsapp, site.whatsapp_message)} target="_blank" rel="noopener noreferrer">
                  <MessageCircle />
                  Chat via WhatsApp
                </a>
              </Button>
            )}
          </div>

          {/* Form */}
          <div className="rounded-3xl border border-border bg-card p-6 shadow-sm md:p-8">
            {flash?.success && (
              <div className="mb-6 flex items-start gap-3 rounded-xl bg-emerald-50 p-4 text-sm text-emerald-800">
                <CheckCircle2 className="mt-0.5 h-5 w-5 shrink-0" />
                <span>{flash.success}</span>
              </div>
            )}
            <form onSubmit={submit} className="space-y-5">
              <div className="grid gap-5 sm:grid-cols-2">
                <Field id="name" label="Nama" error={errors.name}>
                  <Input id="name" value={data.name} onChange={(e) => setData('name', e.target.value)} required />
                </Field>
                <Field id="email" label="Email" error={errors.email}>
                  <Input id="email" type="email" value={data.email} onChange={(e) => setData('email', e.target.value)} required />
                </Field>
              </div>
              <div className="grid gap-5 sm:grid-cols-2">
                <Field id="phone" label="Telepon (opsional)" error={errors.phone}>
                  <Input id="phone" value={data.phone} onChange={(e) => setData('phone', e.target.value)} />
                </Field>
                <Field id="subject" label="Subjek (opsional)" error={errors.subject}>
                  <Input id="subject" value={data.subject} onChange={(e) => setData('subject', e.target.value)} />
                </Field>
              </div>
              <Field id="message" label="Pesan" error={errors.message}>
                <Textarea id="message" value={data.message} onChange={(e) => setData('message', e.target.value)} required />
              </Field>
              <Button type="submit" size="lg" disabled={processing} className="w-full sm:w-auto">
                {processing ? 'Mengirim…' : 'Kirim Pesan'}
              </Button>
            </form>
          </div>
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
