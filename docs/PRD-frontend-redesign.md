# PRD — Frontend Redesign & Migration (Inertia + React + TypeScript)

**Product:** Tirta Nirwana — Company Profile / CMS website (public frontend)
**Design reference:** [Company Profile Website — Rastekindo (Dribbble #27604084)](https://dribbble.com/shots/27604084-Company-Profile-Website-Rastekindo) — used for *layout, hierarchy, and whitespace discipline*, not for palette (we keep the water/teal brand).
**Author:** Engineering + Design
**Status:** Draft v1 · Last updated 2026-09-06
**Scope:** Public-facing frontend only. The Filament admin panel at `/admin` is **out of scope and untouched.**

---

## 1. Summary

Migrate the public frontend from **Livewire + Blade** to **Inertia.js + React 19 + TypeScript**, styled with **Tailwind CSS 3** and **shadcn/ui** primitives (Radix + CVA), and ship a **clean, editorial, corporate-modern redesign** inspired by the Rastekindo reference.

The backend, database, models, and Filament admin stay as-is. Laravel controllers render Inertia pages instead of Blade views; content is still 100% admin-managed through the existing Filament resources.

> **Reality check:** the migration scaffold already exists in the working tree (`resources/js/**`, `app/Http/Controllers/PageController.php`, Inertia routes). This PRD documents the *target* and the *remaining* work rather than a greenfield build. Section 11 tracks status.

### Goals
- G1 — Replace every Livewire/Blade public page with an Inertia React page, **preserving all existing route names** so links/SEO don't break (see [routes/web.php](../routes/web.php)).
- G2 — Ship one coherent **design system** (tokens, type scale, spacing, motion) so pages read as one product.
- G3 — Clean, *human* UI/UX — no generic AI-template look (§4 defines "no slop" concretely).
- G4 — Fully responsive (360px → 1440px+), accessible (WCAG 2.1 AA), and fast (LCP < 2.5s on 4G).
- G5 — Type-safe data contracts between Laravel controllers and React pages (§8).

### Non-goals
- N1 — No changes to Filament admin, models, migrations, or DB schema.
- N2 — No new CMS-managed content types (design works with the data that already exists).
- N3 — No i18n framework — copy stays Indonesian (matching current content).
- N4 — No SSR in v1 (client-side Inertia render; SSR is a later option, §10).
- N5 — No auth/account UI on the public site (Breeze scaffolding stays for admin only).

---

## 2. Stack (decided)

| Layer | Choice | Notes |
|---|---|---|
| Server routing | Laravel 10 + `inertiajs/inertia-laravel ^2.0` | Controllers return `Inertia::render()` |
| Client | React 19 + TypeScript, `@inertiajs/react ^3.7` | SPA-style nav, no full reloads |
| Styling | Tailwind 3.1 + `tailwindcss-animate` | HSL CSS-var tokens, light + dark |
| Components | shadcn/ui (Radix primitives + `class-variance-authority`) | Lives in `resources/js/components/ui/` |
| Icons | `lucide-react` | One icon set only |
| Build | Vite 5 + `@vitejs/plugin-react` + `laravel-vite-plugin` | |

Dependencies for all of the above are already in [package.json](../package.json) / [composer.json](../composer.json). **No new runtime dependency should be added without a line in this PRD justifying it.**

---

## 3. Design System

The token layer already exists in [resources/css/app.css](../resources/css/app.css) as HSL CSS variables with a `.dark` variant. Treat these as the source of truth; **do not hardcode hex colors in components** — always go through Tailwind tokens (`bg-primary`, `text-muted-foreground`, …).

### 3.1 Color
- **Brand primary:** teal `--primary: 174 84% 30%` (light) — evokes water; on-brand for a swim school and reads clean/corporate. Keep it.
- **Accent:** cyan `--accent: 189 94% 43%` — used sparingly for highlights, never for large fills.
- **Neutrals:** cool slate scale for `background / foreground / muted / border`.
- Semantic tokens (`card`, `popover`, `secondary`, `destructive`, `ring`) are defined for both themes — use them, don't invent new ones.
- **Rule:** max one primary CTA color per viewport. Accent is a seasoning, not a base.

### 3.2 Typography
- Type scale (Tailwind): display `text-5xl/text-6xl` (hero), h2 `text-3xl/4xl`, h3 `text-lg/xl`, body `text-base` (15px via `.rich`), small `text-sm`.
- Weights: `font-extrabold` for display, `font-semibold` for headings, `font-normal` body. Tracking `tracking-tight` on large headings only.
- Line length: body capped at `max-w-xl`/`max-w-2xl` (~65ch). Never full-width paragraphs.
- Admin-authored HTML renders through the `.rich` prose styles already defined in app.css — reuse for every `description`/`answer` field.

### 3.3 Spacing & layout
- Section rhythm: `py-20` desktop / `py-16` mobile between major sections. Be consistent — inconsistent vertical rhythm is the #1 "AI slop" tell.
- Container: single `.container` (centered, `px-4`) — no ad-hoc max-widths per page.
- Radius: `--radius: 0.75rem`; cards `rounded-2xl`, pills `rounded-full`. Pick and hold.
- Grid: 12-col mental model; card grids are `sm:grid-cols-2 lg:grid-cols-3`.

### 3.4 Elevation & borders
- Prefer **1px borders (`border-border`) over heavy shadows.** One soft shadow (`shadow-lg`) reserved for floating/hero accents.
- Dark mode: elevation via surface lightness (`card` lighter than `background`), not shadows.

### 3.5 Motion
- Use `tailwindcss-animate` + a small set: `animate-fade-up` on section entrance, `transition-colors` on interactive states, `hover:-translate-y-0.5` on cards.
- Durations 150–300ms, ease-out. **No** parallax, no autoplaying carousels, no bounce. Respect `prefers-reduced-motion` (disable transforms/entrance animations).

### 3.6 "No AI slop" — concrete rules
1. No emoji as UI icons (use lucide). No gradient-on-gradient. No purple-blue "AI" gradients.
2. No three identical feature cards with a circle-icon + lorem — every card must carry *real* content from the models.
3. Real imagery with graceful fallback (`onError` hide, already patterned in Home hero) — never a broken-image glyph.
4. Asymmetric, editorial layouts where it helps (offset hero, left-aligned section headings with a "view all" action) — not everything centered.
5. Consistent icon stroke width, consistent corner radius, consistent shadow — mismatches read as generated.
6. Copy is specific and human (Indonesian), not "Lorem ipsum" or "Empower your business".

---

## 4. Information Architecture

Routes are already migrated in [routes/web.php](../routes/web.php); **names are frozen** (breaking them breaks the Filament links, sitemap, and any external inbound links).

| Path | Name | Inertia page | Controller method |
|---|---|---|---|
| `/` | `Home` | `Pages/Home` | `PageController@home` |
| `/services` | `Service` | `Pages/Services` | `PageController@services` |
| `/service/{id}` | `ServiceDetail` | `Pages/ServiceDetail` | `PageController@serviceShow` |
| `/about-us` | `AboutUs` | `Pages/About` | `PageController@about` |
| `/ourteams` | `team` | `Pages/Team` | `PageController@team` |
| `/blogs` | `Blog` | `Pages/Blogs` | `PageController@blogs` |
| `/blog-detail/{id}` | `BlogDetail` | `Pages/BlogDetail` | `PageController@blogShow` |
| `/faqs` | `FAQ` | `Pages/Faq` | `PageController@faq` |
| `/contactus` (GET/POST) | `Contact` / `Contact.submit` | `Pages/Contact` | `PageController@contact` / `ContactController@submit` |

Global chrome: **Navbar** (sticky, with `ThemeToggle` + mobile `Sheet`), **Footer**, and a shared **Layout** wrap every page. Persistent Inertia layout so the navbar doesn't remount on navigation.

---

## 5. Page Specifications

Each page lists its **sections top→bottom** and the **props** it receives. Props are the contract in §8. Redesign each to the §3 system; keep data-driven — empty states required everywhere a list can be empty.

### 5.1 Home (`Pages/Home`) — props: `{ services: Service[] }`
1. **Hero** — eyebrow pill, display headline w/ one colored keyword, sub-copy (`max-w-xl`), dual CTA (primary → Contact, outline → Services), trust checklist, offset image card with a floating stat chip. (Already implemented — keep as the design north star.)
2. **Stats band** — 4 KPI tiles in a bordered grid.
3. **Features / "Why us"** — 3 cards, icon + real value prop (safety, personal approach, method).
4. **Services preview** — left-aligned `SectionHeading` + "Semua layanan" link; grid of up to 6 `ServiceCard`. Empty state if none.
5. **CTA band** — `CtaBand` (contact conversion).

### 5.2 Services (`Pages/Services`) — props: `{ services: Service[] }`
- `PageHeader` (title + breadcrumb) → responsive `ServiceCard` grid → CTA band. Card links to `ServiceDetail`. Empty state.

### 5.3 Service Detail (`Pages/ServiceDetail`) — props: `{ service: Service }`
- `PageHeader` (service title) → two-col: `.rich` `description` (HTML) main + sticky sidebar (contact CTA / related). `short_desc` as lead paragraph. `icon_class` optional.

### 5.4 About (`Pages/About`) — props: `{ aboutus: AboutUs, teams: Team[] }`
- Hero/intro from `aboutus.title` + `.rich` `aboutus.description` + `aboutus.img`. Optional values grid. **Team preview** grid of `TeamCard` → link to `/ourteams`. Handle `aboutus === null` (no row yet) gracefully.

### 5.5 Team (`Pages/Team`) — props: `{ teams: Team[] }`
- `PageHeader` → `TeamCard` grid (photo, name, position, social links: `fblink`/`instalink`/`twitterlink`, render only those present). Empty state.

### 5.6 Blogs (`Pages/Blogs`) — props: `{ blogs: Paginated<Blog>, categories: Category[], categorySlug: string|null }`
- `PageHeader` → **category filter** (chips/tabs driving `?categorySlug=` via Inertia `router.get` with `preserveState`) → `BlogCard` grid (6/page) → `Pagination` from Laravel `links`. Active-filter + empty states. `BlogCard` links to `BlogDetail`.

### 5.7 Blog Detail (`Pages/BlogDetail`) — props: `{ blog: Blog, category: Category|null, recent: Blog[] }`
- Cover `imgUrl`, category badge, title, `created_at` (formatted `id-ID`), `.rich` `description`. Sidebar/footer: **recent posts** list (4). Back-to-blog link.

### 5.8 FAQ (`Pages/Faq`) — props: `{ faqs: Faq[] }`
- `PageHeader` → shadcn **Accordion** (`ui/accordion`) of question/answer. Only `status = 1` sent by controller. Empty state.

### 5.9 Contact (`Pages/Contact`) — props: `{}` (+ shared `flash`)
- Two-col: contact info/map + form (name, email, phone, message). Uses Inertia `useForm` → POST `Contact.submit`. Client validation mirrors server rules in [ContactController](../app/Http/Controllers/ContactController.php) (`name≤120, email, phone≤40, message≤5000`). Show `flash.success` toast/banner; render field errors from the Inertia error bag; disable submit while `processing`.

---

## 6. Component Inventory

Existing (in `resources/js/components/`) — **reuse, don't duplicate:**

- **Primitives** `ui/`: `button`, `card`, `input`, `textarea`, `label`, `badge`, `accordion`, `sheet`. Add from shadcn only when a page needs it (candidates: `dialog` present via radix, `sonner`/toast for flash, `tabs` for blog filter, `skeleton` for loading).
- **Composed**: `Layout`, `Navbar`, `Footer`, `ThemeToggle`, `PageHeader`, `SectionHeading`, `CtaBand`, `Pagination`, `ServiceCard`, `BlogCard`, `TeamCard`, `icons`.

Rule: a component earns its file when reused ≥2 places **or** it isolates non-trivial logic. Otherwise inline it. No one-off wrapper components.

---

## 7. Cross-cutting Requirements

- **Responsive:** mobile-first. Breakpoints `sm 640 / md 768 / lg 1024 / xl 1280`. Nav collapses to `Sheet` below `md`. No horizontal scroll at 360px.
- **Accessibility (WCAG 2.1 AA):** semantic landmarks (`header/nav/main/footer`), visible focus rings (`ring` token), labelled inputs, `alt` on all `img`, accordion/sheet keyboard-operable (Radix gives this), contrast ≥ 4.5:1 (verify teal-on-white for small text), `prefers-reduced-motion` honored.
- **Dark mode:** `ThemeToggle` persists choice (localStorage) and respects system default; both themes fully tokenized (already defined).
- **SEO:** per-page `<Head>` (title + meta description) via Inertia `Head`. Preserve URL structure. Add `og:` tags on Home + blog detail. `lang="id"` on `<html>`.
- **Performance:** LCP < 2.5s / CLS < 0.1 on mid-tier mobile 4G. Lazy-load below-the-fold images (`loading="lazy"`), width/height to reserve space, Vite code-split per page (Inertia does this by default). Ship only used lucide icons.
- **Error/empty/loading states:** every list has an empty state; every async nav shows Inertia progress bar; images fail gracefully.

---

## 8. Data Contracts

TypeScript interfaces live in [resources/js/types/models.ts](../resources/js/types/models.ts) and **must stay in sync** with the `get([...])` column lists in [PageController](../app/Http/Controllers/PageController.php). Controllers select explicit columns — pages may only rely on those fields:

- `Service`: `id, title, short_desc, icon_class?` (+ `description?` HTML on detail only).
- `Team`: `id, name, position, imgUrl, fblink?, instalink?, twitterlink?`.
- `AboutUs`: `title, description(HTML), img` — **may be `null`** (no row).
- `Blog`: `id, title, short_desc?, imgUrl, categories_id, created_at` (+ `description?` HTML on detail).
- `Category`: `id, name, slug`.
- `Faq`: `id, question, answer` (only `status=1` reaches the client).
- `Paginated<T>`: Laravel paginator shape (`data, links, current_page, last_page, total, from, to`).
- Shared props (via `HandleInertiaRequests` middleware): `appName`, `flash: { success?, error? }`.

**Contract rule:** if a page needs a new field, add the column to the controller's select **and** the interface in the same change — never read an undeclared field.

---

## 9. Acceptance Criteria

- [ ] All 9 routes render Inertia React pages; **zero** Blade/Livewire public views remain referenced by `routes/web.php`.
- [ ] All route **names** unchanged vs. the pre-migration setup.
- [ ] Every page matches the §3 design system (spacing rhythm, tokens, type scale) and passes the §4 anti-slop rules on visual review.
- [ ] Contact form: client + server validation, success flash, disabled-while-submitting, error bag rendered.
- [ ] Blog filter + pagination work via Inertia without full reload; deep-linkable (`?categorySlug=`, `?page=`).
- [ ] Light + dark both correct on every page; `prefers-reduced-motion` respected.
- [ ] Lighthouse (mobile): Performance ≥ 90, Accessibility ≥ 95, SEO ≥ 95 on Home.
- [ ] No TypeScript errors (`tsc --noEmit`); no `any` on prop boundaries.
- [ ] Filament admin at `/admin` unaffected; content edits still reflect on the public site.

---

## 10. Future / Optional (not v1)
- Inertia SSR (`@inertiajs/react/server`) for SEO-critical pages.
- Toast system (`sonner`) if flash banners feel weak.
- Sitemap.xml + structured data (Organization, Article).
- Image CDN / responsive `srcset` pipeline.

---

## 11. Migration Status & Remaining Work

Scaffold **already present** in the working tree (uncommitted): Inertia pages, shadcn primitives, `PageController`, `ContactController`, `HandleInertiaRequests`, migrated routes, design tokens, and a strong `Pages/Home`.

**Remaining / to verify:**
- [ ] Audit each of the 9 pages against §5 spec (sections + empty states present).
- [ ] Confirm `HandleInertiaRequests` shares `appName` + `flash` (§8).
- [ ] Verify `ThemeToggle` persistence + no FOUC (inline theme script in root Blade before Vite).
- [ ] Contact page wired to `useForm` with server-rule-mirrored validation.
- [ ] Delete dead Blade/Livewire public views + `App\Livewire\Show*` classes once parity confirmed (keep Filament).
- [ ] Remove unused Livewire/Flux/Volt public-facing deps *only after* confirming Filament doesn't need Livewire (it does — keep `livewire/livewire`).
- [ ] Add per-page `<Head>` meta + `lang="id"`.
- [ ] `tsc --noEmit` clean; run `vendor/bin/pint`.
- [ ] Lighthouse + axe pass on Home, Blogs, Contact.

> ⚠️ **Do not** `composer remove livewire/livewire` — Filament 3 depends on it. Only public Blade/Livewire *page* classes are removable.
