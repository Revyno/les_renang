import '../css/app.css';
import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';

const appName = 'Les Renang';

createInertiaApp({
  title: (title) => (title ? `${title} — ${appName}` : appName),
  resolve: (name) => {
    const pages = import.meta.glob('./Pages/**/*.tsx', { eager: true });
    const page = pages[`./Pages/${name}.tsx`];
    if (!page) throw new Error(`Inertia page not found: ${name}`);
    return page as { default: React.ComponentType };
  },
  setup({ el, App, props }) {
    createRoot(el).render(<App {...props} />);
  },
  progress: { color: '#d96c89' },
});
