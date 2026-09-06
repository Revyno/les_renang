import { createInertiaApp, type ResolvedComponent } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot, hydrateRoot } from 'react-dom/client';
import { StrictMode, type ReactNode } from 'react';
import Layout from '@/components/Layout';

createInertiaApp({
    title: (title) => (title ? `${title} — Tirta Nirwana` : 'Tirta Nirwana'),
    resolve: async (name) => {
        const page = await resolvePageComponent<{ default: ResolvedComponent }>(
            `./Pages/${name}.tsx`,
            import.meta.glob<{ default: ResolvedComponent }>('./Pages/**/*.tsx'),
        );
        const Component = page.default;
        Component.layout ??= (child: ReactNode) => <Layout>{child}</Layout>;
        return Component;
    },
    setup({ el, App, props }) {
        if (!el) return;
        const app = (
            <StrictMode>
                <App {...props} />
            </StrictMode>
        );
        if (el.hasChildNodes()) {
            hydrateRoot(el, app);
        } else {
            createRoot(el).render(app);
        }
    },
    progress: {
        color: '#e07a1a',
        showSpinner: false,
    },
});
