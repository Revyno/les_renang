import { Link } from '@inertiajs/react'
import { useSite, waLink } from '@/lib/site'
import { useI18n } from '@/lib/i18n'

export default function Cta() {
  const site = useSite()
  const { t } = useI18n()

  return (
    <section className="px-4 py-10 md:py-16">
      <div data-aos="fade-up" className="mx-auto flex max-w-screen-2xl flex-col items-center justify-center gap-5 rounded-4xl bg-brand-500 px-6 py-20 text-center text-white md:py-24">
        <h2 className="max-w-2xl text-3xl font-medium leading-[1.05] tracking-tight md:text-5xl">
          {t('home.cta.title')}
        </h2>
        <p className="max-w-xl text-base leading-relaxed text-brand-50">
          {t('home.cta.description')}
        </p>
        <div className="mt-2 flex flex-wrap justify-center gap-2.5">
          <Link
            href="/kontak"
            className="inline-flex h-12 items-center rounded-full bg-white px-6 text-sm font-semibold text-foreground transition-colors hover:bg-stone-100"
          >
            {t('home.cta.contact')}
          </Link>
          <a
            href={waLink(site.whatsapp || '', site.whatsapp_message)}
            target="_blank"
            rel="noopener noreferrer"
            className="inline-flex h-12 items-center rounded-full bg-brand-700 px-6 text-sm font-semibold text-white transition-colors hover:bg-brand-900"
          >
            {t('home.cta.whatsapp')}
          </a>
        </div>
      </div>
    </section>
  )
}
