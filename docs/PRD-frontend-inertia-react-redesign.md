# PRD — Redesign Frontend: Migrasi ke Inertia + React + TypeScript

- **Status:** DRAFT — menunggu review
- **Tanggal:** 2026-09-27
- **Ruang lingkup:** Frontend publik saja tapi sinkron dengan  untuk tiap konten Admin (Filament) & logika backend **tidak diubah**.
- **Referensi desain:** `Company Profile Redesign (2).html`

---

## 1. Ringkasan

Mendesain ulang seluruh **frontend publik** situs company profile *Les Renang* dan memigrasikannya dari stack lama (Livewire + Blade + Bootstrap/Vue/Alpine) ke **Inertia.js + React + TypeScript**, dengan **Tailwind CSS** + **shadcn/ui**, font **Poppins** (Google Fonts), seluruh gambar dipindah & dilayani dari **Cloudinary**, serta penambahan **meta tags** (SEO/Open Graph) di tiap halaman.

Backend Laravel (model, migrasi, Filament admin, auth) tetap. Yang berubah hanya lapisan presentasi publik: route publik, controller presentasi, dan view.

---

## 2. Tujuan & Non-Tujuan

**Tujuan**
- Frontend publik jalan di atas Inertia + React + TS.
- Styling penuh Tailwind + komponen shadcn/ui; font Poppins.
- Semua aset gambar dari Cloudinary (bukan `public/assets/img` lokal).
- Meta tags per halaman (title, description, OG, favicon).
- Tampilan mengikuti file referensi redesign.

**Non-Tujuan**
- Tidak mengubah skema DB, model, atau panel Filament.
- Tidak mengubah logika bisnis (pendaftaran, pembayaran, dsb.) — hanya presentasinya.
- Tidak menyentuh area admin/dashboard internal.

---

## 3. Kondisi Saat Ini

**Stack lama (frontend publik):**
- Laravel 9, Livewire (component `app/Http/Livewire/*`), view Blade `resources/views/livewire/*`.
- Build asset: Vite + Bootstrap 5 + Vue 3 + Alpine (dari `package.json`). **Belum ada** React / Inertia / TypeScript / Tailwind / shadcn.
- Route publik aktif hanya `/` (`ShowHome`) dan `/register` (`ShowRegister`); route lain di-comment di `routes/web.php`.

**Section (data-driven, tiap section fetch model sendiri):**
Hero, About, Services, Program, Stats, Instructors/Team, Gallery, Testimonials, Clients, FAQ, Blog, Contact, Footer, Header.

**Model terkait:** `Hero`, `AboutUs`, `Service`, `Program`, `Stats`, `Instructor`, `Teams`, `gallery`, `Testimonial`, `client`, `FAQ`, `Blogs`, `contact`/`contact_submissions`, `Registration`, `Categories`, `Classes`.

**Aset:** 68 file di `public/assets/img/` (subfolder: `clients/`, `portfolio/`, `teacher/`, `team/`, `testimonials/`, `wa/`). Ada 1 video `.mp4` di `teacher/`.

**Nav referensi (yang terbaca dari bundle):** Beranda · Tentang · Layanan · Kontak · FAQ · Blog.

---

## 4. Target Stack

| Lapisan | Teknologi |
|---|---|
| Server adapter | `inertiajs/inertia-laravel` |
| Client | `@inertiajs/react` + React 18 + TypeScript |
| Build | Vite (`@vitejs/plugin-react`) |
| Styling | Tailwind CSS |
| Komponen UI | shadcn/ui (Radix + Tailwind) |
| Ikon | `lucide-react` (bawaan shadcn) |
| Font | Poppins via Google Fonts |
| Route helper | Ziggy (`tightenco/ziggy`) untuk `route()` di React |
| Aset gambar | Cloudinary (delivery URL publik) |

**Scaffold yang direkomendasikan:** `laravel/breeze` varian `--stack=react --typescript`. Satu perintah langsung menyiapkan Inertia + React + TS + Tailwind + auth (login/register/dashboard). shadcn/ui dipasang di atasnya. **Catatan:** Breeze memodifikasi `routes/*`, menambah auth controller & layout — perlu direkonsiliasi hati-hati dengan Livewire/`laravel/ui` yang ada dan **tidak boleh** mengganggu auth Filament. (Alternatif: setup Inertia manual tanpa Breeze bila ingin kontrol penuh — lihat §13.)

---

## 5. ⚠️ Keamanan & Prasyarat (WAJIB dibaca)

1. **API secret Cloudinary tidak boleh masuk frontend.** API secret adalah *secret* server-side. Dipakai **hanya** untuk skrip upload sekali jalan; disimpan di `.env` (`CLOUDINARY_URL`), **tidak di-commit**, **tidak** pernah dikirim ke bundle React.
2. **Rotate secret** setelah migrasi aset selesai — karena secret ini sudah dibagikan lewat chat, anggap ter-ekspos. Ganti di dashboard Cloudinary.
3. **Frontend hanya butuh `cloud_name`** (publik) untuk membentuk URL delivery. **[BLOKER] Cloud name belum diberikan** — dibutuhkan sebelum implementasi delivery aset.
4. **Referensi desain berupa bundle terkompilasi (minified).** Isi visual tidak bisa dibaca langsung dari sumber. Untuk replikasi setia, perlu salah satu: (a) render file HTML di browser lalu screenshot per section, atau (b) sumber JSX/desain aslinya. **[BLOKER LUNAK]** — aku bisa render & screenshot bila diizinkan.
5. **`.gitignore`:** pastikan `.env` dan file kredensial tidak ikut ter-commit.

---

## 6. Ruang Lingkup Halaman & Section

**Halaman (Inertia pages, `resources/js/Pages/`):**

| Route | Page React | Sumber data (props) |
|---|---|---|
| `/` (Beranda) | `Home.tsx` | Hero, About, Services, Program, Stats, Instructors, Gallery, Testimonials, Clients (satu payload) |
| `/tentang` | `About.tsx` | AboutUs, Teams/Instructor, Stats |
| `/layanan` | `Services.tsx` | Service, Program |
| `/blog` + `/blog/{slug}` | `Blog.tsx`, `BlogDetail.tsx` | Blogs, Categories |
| `/faq` | `Faq.tsx` | FAQ |
| `/kontak` | `Contact.tsx` | form → `contact_submissions` |
| `/daftar` (register program) | `RegisterProgram.tsx` | Program, Classes |
| `/login`, `/register` | `Auth/Login.tsx`, `Auth/Register.tsx` | auth (session) |

**Komponen bersama (`resources/js/Components/`):** `Header/Navbar`, `Footer`, `SectionHero`, `SectionAbout`, `SectionServices`, `SectionProgram`, `SectionStats`, `SectionInstructors`, `SectionGallery`, `SectionTestimonials`, `SectionClients`, `WhatsAppFloat`, `MetaTags` (via `<Head>`).

*(Peta akhir section per halaman dikonfirmasi setelah render referensi — §5.4.)*

---

## 7. Design System

- **Font:** Poppins (300/400/500/600/700) via Google Fonts, di-`preconnect`.
- **Palette awal** (diekstrak dari referensi — dikonfirmasi setelah render):
  - Base/cream: `#faf9f5`, `#f5f4ef`
  - Maroon/teks gelap: `#2a1215`, `#5c2b2e`
  - Rose/coral aksen: `#d96c89`, `#ff8a80`
  - Rust: `#96370d`; netral: `#6b6a68`, `#1f1e1d`
- Token warna & radius diset di `tailwind.config` + CSS variables (mekanisme shadcn: `--background`, `--primary`, dst.), mendukung tema terang (dan gelap bila diinginkan).
- Komponen shadcn yang kemungkinan dipakai: `button`, `card`, `navigation-menu`/`sheet` (mobile nav), `accordion` (FAQ), `dialog`, `input`/`textarea`/`form` (kontak & daftar), `carousel` (testimoni/gallery), `badge`, `avatar`.

---

## 8. Rencana Migrasi Aset ke Cloudinary

1. **Struktur folder Cloudinary** meniru lokal: `les-renang/{hero,about,services,program,instructors,team,clients,gallery,portfolio,testimonials,misc}`.
2. **Skrip upload sekali jalan** (server-side, pakai `CLOUDINARY_URL` dari `.env`): unggah 68 file dari `public/assets/img/**` → catat mapping `path lokal → public_id Cloudinary` ke `docs/cloudinary-assets.json`.
3. **Helper delivery** (frontend, hanya `cloud_name`): fungsi kecil `cld(publicId, opts)` menghasilkan URL dengan transformasi (`f_auto,q_auto`, width responsif).
4. **Video `.mp4`** teacher: diunggah sebagai resource `video` (atau dipindah ke asset lain bila tak dipakai di frontend).
5. Setelah verifikasi tampil benar, folder `public/assets/img` boleh dipangkas (opsional, tahap akhir).

---

## 9. Meta Tags / SEO

- `<Head>` Inertia per page: `title`, `meta description`, Open Graph (`og:title`, `og:description`, `og:image` → aset Cloudinary), `twitter:card`, `canonical`, favicon/apple-touch-icon (dari Cloudinary), `lang="id"`.
- Default global di root layout, override per page.
- `og:image` pakai satu gambar brand dari Cloudinary.

---

## 10. Arsitektur Inertia & Alur Data

- **Controller presentasi baru** (mis. `HomeController@index`) meng-*eager-load* semua data section dan mengembalikan `Inertia::render('Home', [...props])`. Menggantikan pola tiap Livewire section fetch sendiri (hindari N query terpisah).
- **Root layout** Blade `app.blade.php` minimal berisi `@inertia` + `@viteReactRefresh` + link Google Fonts + tag meta default.
- **Route publik lama Livewire dinonaktifkan/diganti** route Inertia di `routes/web.php`. Route Filament & auth tetap.
- **Form** (kontak, daftar) submit via `useForm` Inertia (POST) ke controller yang menyimpan ke model existing (`contact_submissions`, `Registration`).
- Livewire component publik lama menjadi *deprecated* (dibiarkan / dihapus di tahap akhir).

---

## 11. Fase Implementasi (usulan)

| Fase | Isi | Hasil |
|---|---|---|
| 0 | Prasyarat: cloud name + render referensi + rotate rencana | Bloker teratasi |
| 1 | Setup Inertia+React+TS (Breeze), Tailwind, shadcn init, Poppins | App boot dgn 1 page dummy |
| 2 | Migrasi aset → Cloudinary + helper `cld()` | `cloudinary-assets.json` |
| 3 | Layout + Navbar + Footer + MetaTags + WhatsApp float | Kerangka global |
| 4 | Home (semua section) + controller props | `/` selesai |
| 5 | Subpage: Tentang, Layanan, Blog(+detail), FAQ, Kontak, Daftar | Halaman publik |
| 6 | Auth pages (Login/Register) redesign | Auth publik |
| 7 | Meta/SEO finalisasi, responsif, a11y, QA, hapus sisa lama | Rilis |

---

## 12. Risiko

- **Referensi tak terbaca** → tampilan bisa meleset dari desain bila tidak di-render dulu (§5.4).
- **Breeze bentrok** dengan Livewire/`laravel/ui`/Filament auth → perlu rekonsiliasi route & guard hati-hati.
- **Konsistensi data:** memindah fetch dari per-section ke controller butuh cek relasi model.
- **Kredensial ter-ekspos** bila secret tak ditangani sesuai §5.
- Migrasi 68 aset + update semua referensi path.

---

## 13. Pertanyaan Terbuka / Keputusan

1. **Cloud name Cloudinary?** (wajib) 
2. **Izin render** file referensi untuk screenshot desain? (sangat disarankan)
3. **Scaffold:** Breeze (cepat, ada auth) **[rekomendasi]** vs setup Inertia manual (kontrol penuh, tanpa auth bawaan)?
4. **Tema gelap** diperlukan atau terang saja?
5. **Bahasa route:** Indonesia (`/tentang`, `/layanan`, `/kontak`) atau Inggris?
6. **Nasib Livewire lama:** hapus di fase akhir atau biarkan sebagai fallback?
7. Konfirmasi: benar migrasi penuh ke Inertia/React, **bukan** sekadar restyle Blade dengan Tailwind (opsi jauh lebih ringan bila berubah pikiran).

---

## 14. Di Luar Ruang Lingkup

Panel Filament, skema DB & migrasi, logika pembayaran/enrollment, API backend, testing backend, deployment/infra.
