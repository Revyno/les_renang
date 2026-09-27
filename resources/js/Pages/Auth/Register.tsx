import { type FormEvent, type ReactNode } from 'react'
import { Link, useForm } from '@inertiajs/react'
import { UserPlus } from 'lucide-react'
import Seo from '@/components/Seo'
import SiteLayout from '@/Layouts/SiteLayout'
import PageHeader from '@/components/site/PageHeader'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { useI18n } from '@/lib/i18n'

interface Props {
  meta: { title: string; description: string }
}

export default function RegisterPage({ meta }: Props) {
  const { t } = useI18n()
  const { data, setData, post, processing, errors } = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
  })

  const submit = (e: FormEvent) => {
    e.preventDefault()
    post('/register')
  }

  return (
    <>
      <Seo title={meta.title} description={meta.description} />
      <PageHeader
        eyebrow={t('auth.eyebrow')}
        title={t('auth.register.title')}
        description={t('auth.register.subtitle')}
        crumbs={[{ label: t('auth.register.title') }]}
      />

      <section className="mx-auto max-w-screen-2xl px-4 py-20 md:px-10 md:py-28">
        <div className="mx-auto max-w-md rounded-3xl border border-border bg-card p-6 shadow-sm md:p-8" data-aos="fade-up">
          <form onSubmit={submit} className="space-y-5">
            <div className="space-y-1.5">
              <Label htmlFor="name">{t('auth.register.name')}</Label>
              <Input
                id="name"
                autoComplete="name"
                value={data.name}
                onChange={(e) => setData('name', e.target.value)}
                required
              />
              {errors.name && <p className="text-xs text-destructive">{errors.name}</p>}
            </div>

            <div className="space-y-1.5">
              <Label htmlFor="email">{t('auth.email')}</Label>
              <Input
                id="email"
                type="email"
                autoComplete="email"
                value={data.email}
                onChange={(e) => setData('email', e.target.value)}
                required
              />
              {errors.email && <p className="text-xs text-destructive">{errors.email}</p>}
            </div>

            <div className="space-y-1.5">
              <Label htmlFor="password">{t('auth.password')}</Label>
              <Input
                id="password"
                type="password"
                autoComplete="new-password"
                value={data.password}
                onChange={(e) => setData('password', e.target.value)}
                required
              />
              {errors.password && <p className="text-xs text-destructive">{errors.password}</p>}
            </div>

            <div className="space-y-1.5">
              <Label htmlFor="password_confirmation">{t('auth.register.passwordConfirmation')}</Label>
              <Input
                id="password_confirmation"
                type="password"
                autoComplete="new-password"
                value={data.password_confirmation}
                onChange={(e) => setData('password_confirmation', e.target.value)}
                required
              />
            </div>

            <Button type="submit" size="lg" disabled={processing} className="w-full">
              <UserPlus />
              {processing ? t('auth.processing') : t('auth.register.submit')}
            </Button>
          </form>

          <p className="mt-6 text-center text-sm text-muted-foreground">
            {t('auth.register.haveAccount')}{' '}
            <Link href="/login" className="font-medium text-brand-600 hover:text-brand-700 hover:underline">
              {t('auth.register.loginCta')}
            </Link>
          </p>
        </div>
      </section>
    </>
  )
}

RegisterPage.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>
