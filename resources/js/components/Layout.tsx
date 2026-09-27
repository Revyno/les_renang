import { useEffect } from 'react';
import { usePage } from '@inertiajs/react';
import type { ReactNode } from 'react';
import Navbar from '@/components/Navbar';
import Footer from '@/components/Footer';
import type { PageProps } from '@/types/models';

export default function Layout({ children }: { children: ReactNode }) {
    const { props } = usePage<PageProps>();
    const success = props.flash?.success;

    // Lightweight, dependency-free flash toast for the contact form etc.
    useEffect(() => {
        if (!success) return;
        const el = document.createElement('div');
        el.textContent = success;
        el.className =
            'fixed bottom-6 left-1/2 z-[60] -translate-x-1/2 rounded-full bg-primary px-6 py-3 text-sm font-medium text-primary-foreground shadow-lg transition-opacity duration-500';
        document.body.appendChild(el);
        const t1 = setTimeout(() => (el.style.opacity = '0'), 3500);
        const t2 = setTimeout(() => el.remove(), 4200);
        return () => {
            clearTimeout(t1);
            clearTimeout(t2);
            el.remove();
        };
    }, [success]);

    return (
        <div className="flex min-h-screen flex-col">
            <Navbar />
            <main className="flex-1">{children}</main>
            <Footer />
        </div>
    );
}
