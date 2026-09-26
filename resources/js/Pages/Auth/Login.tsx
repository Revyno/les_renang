import { type FormEvent, type ReactNode } from 'react'
import { Link, useForm } from '@inertiajs/react'
import { LogIn } from 'lucide-react'
import Seo from '@/components/Seo'
import SiteLayout from '@/Layouts/SiteLayout'
import PageHeader from '@/components/site/PageHeader'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

interface Props {
  meta: { title: string; description: string }
}

export default function LoginPage({ meta }: Props) {
  const { data, setData, post, processing, errors } = useForm({
    email: '',
    password: '',
    remember: false,
  })

  const submit = (e: FormEvent) => {
    e.preventDefault()
    post('/login')
  }

  return (
    <>
      <Seo title={meta.title} description={meta.description} />
      <PageHeader title="Masuk" description="Masuk ke akun Anda untuk melanjutkan." crumbs={[{ label: 'Masuk' }]} />

      <section className="py-16 md:py-24">
        <div className="container max-w-md">
          <div className="rounded-3xl border border-border bg-card p-6 shadow-sm md:p-8">
            <form onSubmit={submit} className="space-y-5">
              <div className="space-y-1.5">
                <Label htmlFor="email">Email</Label>
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
                <Label htmlFor="password">Kata Sandi</Label>
                <Input
                  id="password"
                  type="password"
                  autoComplete="current-password"
                  value={data.password}
                  onChange={(e) => setData('password', e.target.value)}
                  required
                />
                {errors.password && <p className="text-xs text-destructive">{errors.password}</p>}
              </div>

              <label className="flex items-center gap-2 text-sm text-muted-foreground">
                <input
                  type="checkbox"
                  checked={data.remember}
                  onChange={(e) => setData('remember', e.target.checked)}
                  className="h-4 w-4 rounded border-border text-primary focus:ring-primary"
                />
                Ingat saya
              </label>

              <Button type="submit" size="lg" disabled={processing} className="w-full">
                <LogIn />
                {processing ? 'Memproses…' : 'Masuk'}
              </Button>
            </form>

            <p className="mt-6 text-center text-sm text-muted-foreground">
              Belum punya akun?{' '}
              <Link href="/register" className="font-medium text-accent hover:underline">
                Daftar sekarang
              </Link>
            </p>
          </div>
        </div>
      </section>
    </>
  )
}

LoginPage.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>
