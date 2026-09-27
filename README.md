# Les Renang

Aplikasi web kursus renang: **company profile** publik + **panel admin** untuk mengelola konten, program, kelas, instruktur, pendaftaran, dan pembayaran.

## Stack

- **Backend:** Laravel 10 (PHP 8.1+)
- **Admin panel:** Filament v2 (`/admin`) + spatie/laravel-permission
- **Frontend publik:** Inertia + React + TypeScript, Vite, Tailwind CSS
- **Database:** MySQL / MariaDB

## Instalasi

```bash
git clone <repo-url>
cd Les_renang

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Set database di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=les_renang
DB_USERNAME=root
DB_PASSWORD=
```

Migrasi + seed, lalu build/serve:

```bash
php artisan migrate --seed
npm run dev          # atau: npm run build
php artisan serve
```

## Akun Admin (dari seeder)

`AdminUserSeeder` membuat akun admin panel Filament:

| Field    | Value             |
|----------|-------------------|
| URL      | `/admin`          |
| Email    | `admin@admin.com` |
| Password | `admin123`        |

Jalankan seeder saja tanpa migrate ulang:

```bash
php artisan db:seed --class=AdminUserSeeder
```

> Ganti password default setelah login pertama di lingkungan produksi.

## Struktur Folder

```
Les_renang/
├── app/
│   ├── Filament/          # Resources, Pages, Widgets panel admin (Filament v2)
│   ├── Http/              # Controllers, Middleware, Requests
│   ├── Livewire/          # Komponen Livewire
│   ├── Models/            # Eloquent models (User, Program, Instructor, dll.)
│   ├── Observers/         # Model observers
│   ├── Providers/         # Service & Filament panel providers
│   ├── Exports/ Mail/ Support/ View/
├── config/                # Konfigurasi Laravel
├── database/
│   ├── migrations/        # Skema tabel
│   └── seeders/           # AdminUserSeeder, InstructorSeeder, ProgramSeeder, ...
├── docs/                  # ADR + panduan agent (lihat CONTEXT.md, docs/adr/)
├── lang/                  # File terjemahan
├── public/                # Entry point + hasil build Vite
├── resources/
│   ├── js/                # Frontend Inertia + React + TypeScript
│   ├── css/               # Tailwind
│   └── views/             # Blade (shell Inertia)
├── routes/                # web.php, api.php, dll.
├── storage/ tests/
├── vite.config.js  tailwind.config.js  tsconfig.json
└── composer.json  package.json
```

## Perintah Umum

```bash
php artisan migrate:status          # cek status migrasi
php artisan db:seed                 # jalankan semua seeder
npm run dev                         # Vite dev server (HMR)
npm run build                       # build produksi
```
