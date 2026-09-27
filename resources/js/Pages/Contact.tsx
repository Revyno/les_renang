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
import { useI18n } from '@/lib/i18n'
import type { SharedProps } from '@/types/models'

interface Props {
  meta: { title: string; description: string }
}

export default function ContactPage({ meta }: Props) {
  const { t } = useI18n()
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
    { icon: MapPin, label: t('support.contact.address'), value: site.address },
    { icon: Phone, label: t('support.contact.phone'), value: site.phone, href: `tel:${site.phone}` },
    { icon: Mail, label: t('support.contact.email'), value: site.email, href: `mailto:${site.email}` },
  ]

  return (
    <>
      <Seo title={meta.title} description={meta.description} />
      <PageHeader
        eyebrow={t('support.contact.eyebrow')}
        title={t('support.contact.title')}
        description={t('support.contact.description')}
        crumbs={[{ label: t('support.contact.eyebrow') }]}
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
                  {t('support.contact.whatsapp')}
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
                <Field id="name" label={t('support.contact.formName')} error={errors.name}>
                  <Input id="name" placeholder={t('support.contact.placeholderName')} value={data.name} onChange={(e) => setData('name', e.target.value)} required />
                </Field>
                <Field id="email" label={t('support.contact.formEmail')} error={errors.email}>
                  <Input id="email" type="email" placeholder={t('support.contact.placeholderEmail')} value={data.email} onChange={(e) => setData('email', e.target.value)} required />
                </Field>
              </div>
              <div className="grid gap-5 sm:grid-cols-2">
                <Field id="phone" label={t('support.contact.formPhone')} error={errors.phone}>
                  <Input id="phone" placeholder={t('support.contact.placeholderPhone')} value={data.phone} onChange={(e) => setData('phone', e.target.value)} />
                </Field>
                <Field id="subject" label={t('support.contact.formSubject')} error={errors.subject}>
                  <Input id="subject" placeholder={t('support.contact.placeholderSubject')} value={data.subject} onChange={(e) => setData('subject', e.target.value)} />
                </Field>
              </div>
              <Field id="message" label={t('support.contact.formMessage')} error={errors.message}>
                <Textarea id="message" rows={5} placeholder={t('support.contact.placeholderMessage')} value={data.message} onChange={(e) => setData('message', e.target.value)} required />
              </Field>
              <Button type="submit" size="lg" disabled={processing} className="w-full sm:w-auto">
                {processing ? t('support.contact.sending') : t('support.contact.submit')}
              </Button>
            </form>
          </div>
        </div>
      </section>

      {/* CTA band */}
      <section className="px-4 pb-20 md:px-10 md:pb-28">
        <div className="mx-auto flex max-w-screen-2xl flex-col items-start gap-6 rounded-4xl bg-brand-500 px-8 py-14 text-white md:flex-row md:items-center md:justify-between md:px-14" data-aos="fade-up">
          <div>
            <h2 className="text-3xl font-medium leading-tight tracking-tight md:text-4xl">{t('support.contact.ctaTitle')}</h2>
            <p className="mt-3 max-w-xl text-brand-50">
              {t('support.contact.ctaTextPre')} {site.address}{t('support.contact.ctaTextPost')}
            </p>
          </div>
          <Button asChild variant="outline" size="lg" className="shrink-0 border-white bg-white text-brand-600 hover:bg-white/90 hover:text-brand-700">
            <a href="https://maps.google.com" target="_blank" rel="noopener noreferrer">
              {t('support.contact.ctaButton')}
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
