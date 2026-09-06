import { FormEvent } from 'react';
import { Head, useForm } from '@inertiajs/react';
import { Clock, Mail, MapPin, Phone, Send } from 'lucide-react';
import PageHeader from '@/components/PageHeader';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { routes } from '@/lib/routes';

const info = [
    { icon: MapPin, label: 'Alamat', value: 'Surabaya, Jawa Timur, Indonesia' },
    { icon: Phone, label: 'Telepon', value: '+62 000-0000-0000' },
    { icon: Mail, label: 'Email', value: 'info@tirtanirwana.id' },
    { icon: Clock, label: 'Jam Operasional', value: 'Senin – Minggu, 07.00 – 20.00' },
];

export default function Contact() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        phone: '',
        message: '',
    });

    const submit = (e: FormEvent) => {
        e.preventDefault();
        post(routes.contact(), {
            preserveScroll: true,
            onSuccess: () => reset(),
        });
    };

    return (
        <>
            <Head title="Kontak" />
            <PageHeader
                title="Hubungi Kami"
                subtitle="Punya pertanyaan atau ingin mendaftar? Kirim pesan dan tim kami akan segera membalas."
                crumbs={[{ label: 'Kontak' }]}
            />

            <section className="container py-20">
                <div className="grid gap-10 lg:grid-cols-[1fr_1.3fr]">
                    {/* Info */}
                    <div>
                        <span className="inline-block rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-primary">
                            Mari Terhubung
                        </span>
                        <h2 className="mt-4 text-3xl font-bold tracking-tight text-foreground">Kami senang mendengar dari kamu</h2>
                        <p className="mt-3 text-muted-foreground">
                            Isi formulir di samping atau hubungi kami langsung melalui kontak di bawah ini.
                        </p>

                        <ul className="mt-8 space-y-5">
                            {info.map(({ icon: Icon, label, value }) => (
                                <li key={label} className="flex items-start gap-4">
                                    <span className="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                        <Icon className="h-5 w-5" />
                                    </span>
                                    <div>
                                        <p className="text-sm font-medium text-foreground">{label}</p>
                                        <p className="text-sm text-muted-foreground">{value}</p>
                                    </div>
                                </li>
                            ))}
                        </ul>
                    </div>

                    {/* Form */}
                    <div className="rounded-3xl border border-border bg-card p-6 shadow-sm md:p-8">
                        <form onSubmit={submit} className="space-y-5" noValidate>
                            <div className="grid gap-5 sm:grid-cols-2">
                                <div className="space-y-2">
                                    <Label htmlFor="name">Nama Lengkap</Label>
                                    <Input
                                        id="name"
                                        value={data.name}
                                        onChange={(e) => setData('name', e.target.value)}
                                        placeholder="Nama kamu"
                                        autoComplete="name"
                                    />
                                    {errors.name && <p className="text-sm text-destructive">{errors.name}</p>}
                                </div>
                                <div className="space-y-2">
                                    <Label htmlFor="phone">Nomor Telepon</Label>
                                    <Input
                                        id="phone"
                                        value={data.phone}
                                        onChange={(e) => setData('phone', e.target.value)}
                                        placeholder="+62..."
                                        autoComplete="tel"
                                    />
                                    {errors.phone && <p className="text-sm text-destructive">{errors.phone}</p>}
                                </div>
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="email">Email</Label>
                                <Input
                                    id="email"
                                    type="email"
                                    value={data.email}
                                    onChange={(e) => setData('email', e.target.value)}
                                    placeholder="email@contoh.com"
                                    autoComplete="email"
                                />
                                {errors.email && <p className="text-sm text-destructive">{errors.email}</p>}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="message">Pesan</Label>
                                <Textarea
                                    id="message"
                                    value={data.message}
                                    onChange={(e) => setData('message', e.target.value)}
                                    placeholder="Tulis pesan kamu di sini..."
                                />
                                {errors.message && <p className="text-sm text-destructive">{errors.message}</p>}
                            </div>

                            <Button type="submit" size="lg" disabled={processing} className="w-full sm:w-auto">
                                {processing ? 'Mengirim...' : (<>Kirim Pesan <Send className="h-4 w-4" /></>)}
                            </Button>
                        </form>
                    </div>
                </div>
            </section>
        </>
    );
}
