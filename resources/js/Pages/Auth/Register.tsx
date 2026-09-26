import { type FormEvent, type ReactNode } from 'react'
import { Link, useForm } from '@inertiajs/react'
import { UserPlus } from 'lucide-react'
import Seo from '@/components/Seo'
import SiteLayout from '@/Layouts/SiteLayout'
import PageHeader from '@/components/site/PageHeader'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

interface Props {
  meta: { title: string; description: string }
}

export default function RegisterPage({ meta }: Props) {
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
      <PageHeader title="Daftar Akun" description="Buat akun untuk mulai mendaftar program." crumbs={[{ label: 'Daftar Akun' }]} />

      <section className="py-16 md:py-24">
        <div className="container max-w-md">
          <div className="rounded-3xl border border-border bg-card p-6 shadow-sm md:p-8">
            <form onSubmit={submit} className="space-y-5">
              <div className="space-y-1.5">
                <Label htmlFor="name">Nama Lengkap</Label>
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
                  autoComplete="new-password"
                  value={data.password}
                  onChange={(e) => setData('password', e.target.value)}
                  required
                />
                {errors.password && <p className="text-xs text-destructive">{errors.password}</p>}
              </div>

              <div className="space-y-1.5">
                <Label htmlFor="password_confirmation">Konfirmasi Kata Sandi</Label>
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
                {processing ? 'Memproses…' : 'Daftar'}
              </Button>
            </form>

            <p className="mt-6 text-center text-sm text-muted-foreground">
              Sudah punya akun?{' '}
              <Link href="/login" className="font-medium text-accent hover:underline">
                Masuk di sini
              </Link>
            </p>
          </div>
        </div>
      </section>
    </>
  )
}

RegisterPage.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>
