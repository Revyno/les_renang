import '../css/app.css';
import 'aos/dist/aos.css';
import { createInertiaApp, router } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';
import AOS from 'aos';
import { I18nProvider } from '@/lib/i18n';

const appName = 'Tirta Nirwana';

createInertiaApp({
  title: (title) => (title ? `${title} — ${appName}` : appName),
  // Lazy: each page becomes its own chunk, loaded on demand (keeps the initial bundle small).
  resolve: (name) => {
    const pages = import.meta.glob('./Pages/**/*.tsx');
    const importPage = pages[`./Pages/${name}.tsx`];
    if (!importPage) throw new Error(`Inertia page not found: ${name}`);
    return importPage();
  },
  setup({ el, App, props }) {
    AOS.init({
      duration: 700,
      easing: 'ease-out-cubic',
      once: true,
      offset: 80,
      // Honour users who prefer no motion.
      disable: () => window.matchMedia('(prefers-reduced-motion: reduce)').matches,
    });
    // Inertia swaps the DOM without a reload; re-scan so new page elements animate.
    router.on('success', () => setTimeout(() => AOS.refreshHard(), 0));
    createRoot(el).render(
      <I18nProvider>
        <App {...props} />
      </I18nProvider>,
    );
  },
  progress: { color: '#C84B16' },
});
