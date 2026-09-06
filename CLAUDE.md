# CLAUDE.md

Company profile / CMS website. Public-facing pages (Livewire) + Filament admin panel.

## Stack

- PHP ^8.1, Laravel ^10
- Filament ^3.3 (admin panel)
- Livewire ^3.4 + Volt ^1.0 + Flux ^2.1
- Tailwind ^3.1 + Vite ^5 (frontend build)
- Laravel Breeze (auth scaffolding), Sanctum
- PHPUnit ^10 (`tests/`)

## Layout

- `app/Livewire/` — public page components (full-page routes). `Show*` = pages: `ShowHome`, `ShowServicesPage`, `ShowServiceDetail`, `ShowBlogs`, `ShowBlogDetail`, `ShowAboutUs`, `ShowTeam`/`ShowTeamsPage`, `ShowContactPage`, `FAQ`.
- `app/Filament/Resources/` — admin CRUD: `AboutUSResource`, `BlogsResource`, `CategoriesResource`, `FAQResource`, `ServiceResource`, `TeamsResource`.
- `app/Models/` — `AboutUs`, `Blogs`, `Categories`, `FAQ`, `Service`, `Teams`, `User`.
- `routes/web.php` — public routes → Livewire classes. `routes/auth.php` — Breeze auth.
- `resources/views/livewire/` — page Blade templates. `resources/views/components/` — layout/footer/header partials. Frontend assets under `public/front/`.
- Admin panel: `AdminPanelProvider` (id `admin`, path `/admin`).

## Commands

- Dev: `npm run dev` (Vite) + `php artisan serve` (or Laragon serves it)
- Build: `npm run build`
- Migrate: `php artisan migrate`
- Test: `php artisan test` (or `vendor/bin/phpunit`)
- Lint: `vendor/bin/pint`

## Conventions

- Public routes are Livewire full-page components, not controllers — a page = `App\Livewire\Show*` + `resources/views/livewire/*.blade.php`.
- Content is admin-managed: each public section reads from its model, edited via the matching Filament resource. To add a managed section: migration → model → Filament resource → Livewire page.
- Models/tables use mixed naming (`AboutUs`, `FAQ`) — match existing table names in migrations, don't assume Laravel plural defaults.

## Agent skills

Issue tracker, triage labels, and domain-doc rules live in `AGENTS.md` and `docs/agents/*.md`.
