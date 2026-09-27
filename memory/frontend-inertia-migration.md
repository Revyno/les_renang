---
name: frontend-inertia-migration
description: Public frontend is Inertia+React+TS; Livewire deps stay only for Filament/Breeze
metadata:
  type: project
---

Public frontend fully migrated from Livewire/Blade to **Inertia + React 19 + TypeScript + Tailwind + shadcn/ui**, per `docs/PRD-frontend-redesign.md` (the approved design spec — editorial corporate look, keep teal/water brand). Pages live in `resources/js/Pages/*`, routes → `App\Http\Controllers\PageController`. Old `App\Livewire\Show*` classes + `resources/views/livewire/show-*.blade.php` were **deleted** (dead).

**Do NOT `composer remove livewire/livewire` (Filament 3 needs it), nor `livewire/volt` / `livewire/flux` — Breeze auth routes (`routes/auth.php`) still use Volt/Flux.** Remaining `app/Livewire/{Actions,Forms}` + `resources/views/livewire/{pages,profile,layout,welcome}` are Breeze auth — keep.

Gotchas:
- `FAQ.answer`, `Service.description`, `AboutUs.description`, `Blogs.description` are Filament **RichEditor HTML** — render via the `.rich` class + `dangerouslySetInnerHTML`, never as plain text.
- `tsc` needs `"types": ["vite/client"]` (for `import.meta.glob`) and Inertia v3.7's resolver must return the **component** (`page.default`), not the module. Verify with `npx tsc --noEmit`.
- React needs `@viteReactRefresh` **before** `@vite(...)` in `resources/views/app.blade.php`, or dev mode throws `@vitejs/plugin-react can't detect preamble`.
- **Inertia protocol match:** client core 3.7.0 reads initial page only from `<script data-page="app" type="application/json">`, but inertia-laravel 2.0.26 defaults to the old `<div id="app" data-page>`. Must set `config/inertia.php` → `use_script_element_for_initial_page => true` (published + defaulted true), else `createInertiaApp` crashes with `Cannot read properties of null (reading 'component')` / blank page.
- Blank page after stopping `npm run dev`: stale `public/hot` makes `@vite` target the dead dev server. Delete `public/hot` to serve from `public/build/`, or keep `npm run dev` running.
