# Website Sekolah Multi-Tenant & CMS Sekolah

Platform web sekolah terpadu dengan arsitektur multi-tenant (database per tenant) berbasis Laravel 13. Sistem ini memisahkan kontrol pengelolaan platform (Super Admin), pengelolaan konten sekolah (Admin CMS), dan portal publik informasi sekolah yang responsif dan berstandar aksesibilitas WCAG AA.

Implementasi rujukan resmi saat ini menggunakan data lengkap **SMK Negeri 2 Bandung**.

---

## 1. Spesifikasi Teknologi

- **Backend**: PHP 8.4, Laravel Framework 13
- **Database**: MySQL 8.x (Multi-Database Isolation)
- **Frontend**: Blade Templating, Tailwind CSS, Alpine.js, Vite
- **Testing**: Pest PHP 5
- **Code Linter**: Laravel Pint

---

## 2. Arsitektur Multi-Tenant

Sistem menggunakan pola arsitektur **Single Codebase, Database Per Tenant**:

1. **Database Central (`website_sekolah_central`)**:
   - Menyimpan registri platform, akun Super Admin, data tenant (`sekolah`), pemetaan domain (`domain_sekolah`), dan queue/session pusat.
2. **Database Tenant (`tenant_{slug}`)**:
   - Menyimpan seluruh data operasional sekolah: pengguna/staf, pengaturan umum, fitur aktif, menu, slider, profil, jurusan, berita, agenda, pengumuman, prestasi, kegiatan, ekskul, fasilitas, galeri, kalender akademik, SPMB, dan kontak masuk.

Contoh database tenant aktif: `tenant_smk_negeri_2_bandung`.

---

## 3. Prasyarat Sistem

Pastikan perangkat lokal telah terpasang:
- PHP >= 8.3 dengan ekstensi PDO MySQL, cURL, MBString, OpenSSL, dan GD/Imagick
- Composer >= 2.x
- Node.js >= 20.x dan npm
- MySQL Server (misal via Herd, Laragon, XAMPP, atau Docker)

---

## 4. Panduan Instalasi Lokal

### Langkah 1: Klon Repositori dan Masuk ke Direktori
```bash
cd website_sekolah
```

### Langkah 2: Pasang Dependensi PHP dan Node.js
```bash
composer install
npm install
```

### Langkah 3: Konfigurasi Environment
Salin berkas `.env.example` menjadi `.env`:
```bash
cp .env.example .env
php artisan key:generate
```

Sesuaikan kredensial koneksi database MySQL pada berkas `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=website_sekolah_central
DB_USERNAME=root
DB_PASSWORD=
```

### Langkah 4: Buat Database Central di MySQL
Jalankan perintah SQL atau via client MySQL (HeidiSQL, phpMyAdmin, DBeaver):
```sql
CREATE DATABASE IF NOT EXISTS website_sekolah_central CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Langkah 5: Jalankan Migrasi & Seeder Central
Jalankan migrasi tabel pusat dan daftarkan tenant sekolah awal:
```bash
php artisan migrate --force
php artisan db:seed --class=SuperAdminSeeder --force
```

### Langkah 6: Jalankan Migrasi & Seeder Database Tenant
Perintah ini akan membuat database `tenant_smk_negeri_2_bandung`, menjalankan migrasi tabel tenant, dan mengisi data rujukan lengkap:
```bash
php artisan tenants:migrate --refresh --seed
```

### Langkah 7: Kompilasi Asset Frontend
```bash
npm run build
```

Untuk mode pengembangan aktif:
```bash
npm run dev
```

### Langkah 8: Jalankan Server Lokal
```bash
php artisan serve
```
Aplikasi dapat diakses melalui peramban di `http://localhost:8000`.

---

## 5. Kredensial dan Akses Sistem

### A. Super Administrator (Central Platform)
- **URL Akses**: `http://localhost:8000/superadmin` atau `http://localhost:8000/superadmin/login`
- **Email**: `superadmin@admin.com`
- **Password**: `password123`
- **Tugas**: Manajemen pendaftaran sekolah (tenant), aktivasi/suspend, dan pemetaan domain.

### B. Admin Sekolah (Tenant CMS)
- **URL Akses Global**: `http://localhost:8000/admin` (otomatis diarahkan ke panel admin sekolah aktif)
- **URL Langsung Sekolah**: `http://localhost:8000/smk-negeri-2-bandung/admin/login`
- **Akun Pengembang**:
  - Email: `admin@smkn2bdg.test`
  - Password: `password`
- **Akun Resmi**:
  - Email: `admin@smkn2bandung.sch.id`
  - Password: `password123`
- **Akun Operator**:
  - Email: `operator@smkn2bandung.sch.id`
  - Password: `password123`
- **Tugas**: Pengaturan tema & palet warna portal sekolah (**13 kunci warna dalam 6 grup**, 7 preset terverifikasi + custom hex + pratinjau langsung) melalui satu menu **Tema & Warna**; auto-kontras WCAG dua lapis (helper `App\Support\WarnaKontras` + CSS `contrast()`) memastikan teks tetap terbaca pada latar kustom apa pun. Modul CMS lain (dashboard, slider, profil, struktur, jurusan, berita, pengumuman, agenda, galeri, prestasi, ekskul, guru, fasilitas, SPMB, kontak, media) dihapus dari panel pada 2026-09-29; seluruh datanya tetap utuh di database dan tetap tampil pada portal publik.

### C. Portal Direktori & Publik Sekolah
- **URL Utama Direktori Multi-Sekolah**: `http://localhost:8000/` (Daftar direktori seluruh sekolah terdaftar dengan tautan langsung ke website dan CMS masing-masing)
- **Portal Publik Sekolah (SMKN 2 Bandung)**:
  - Beranda: `/smk-negeri-2-bandung`
  - Profil: `/smk-negeri-2-bandung/profil` (Sejarah, Visi-Misi, Struktur Organisasi)
  - Program Keahlian: `/smk-negeri-2-bandung/program-keahlian` (+ 7 sub-detail kompetensi keahlian)
  - Berita: `/smk-negeri-2-bandung/berita` (+ detail berita)
  - Agenda: `/smk-negeri-2-bandung/agenda` (+ detail agenda)
  - Pengumuman: `/smk-negeri-2-bandung/pengumuman` (+ detail pengumuman)
  - Prestasi Siswa: `/smk-negeri-2-bandung/prestasi` (+ detail prestasi)
  - Kegiatan: `/smk-negeri-2-bandung/kegiatan`
  - Ekstrakurikuler: `/smk-negeri-2-bandung/ekstrakurikuler` (+ detail ekskul)
  - Guru & Tenaga Kependidikan: `/smk-negeri-2-bandung/guru-staf`
  - Fasilitas & Sarpras: `/smk-negeri-2-bandung/fasilitas`
  - Galeri Dokumentasi: `/smk-negeri-2-bandung/galeri`
  - SPMB / PPDB: `/smk-negeri-2-bandung/spmb`
  - Kontak & Lokasi: `/smk-negeri-2-bandung/kontak`

---

## 6. Pengujian dan Kualitas Kode

### Menjalankan Test Otomatis
Project ini dilengkapi 63 pengujian (Feature + Unit, 377 assertion) menggunakan Pest PHP:
```bash
php artisan test
```

Cakupan pengujian meliputi:
- Autentikasi dan otorisasi Super Admin (`Tests\Feature\SuperAdminAuthTest`)
- Autentikasi dan otorisasi Admin Tenant (`Tests\Feature\TenantAdminTest`)
- Portal direktori utama dan ketersediaan seluruh 14 halaman publik tenant (`Tests\Feature\TenantPublicPagesTest`)
- Auto-kontras WCAG per permukaan tema (`Tests\Unit\WarnaKontrasTest`, `Tests\Feature\TenantThemeColorTest`)

### Menjalankan Linter Kode
Pastikan format kode mengikuti standar Laravel Pint:
```bash
vendor/bin/pint
```
### Aturan Penulisan Kode Portal Publik
Seluruh perubahan pada portal publik (menu, halaman, section, komponen, warna) wajib mengikuti rule `.ai/rules/publik-tema-kontras.md` (indeks: `.ai/rules/index.md`) dan referensi teknis `docs/08-CSS-ARSITEKTUR-TEMA.md`: gunakan kelas `.theme-*`, jangan menulis warna literal, dan daftarkan permukaan baru ke scope auto-kontras agar teks tetap terbaca di preset warna apa pun.


---

## 7. Struktur Direktori Utama

```
├── .ai/
│   └── rules/                  # Rule AI per area (index.md + publik-tema-kontras.md)

website_sekolah/
├── app/
│   ├── Console/Commands/       # Command Artisan (MigrateTenants)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Central/        # Auth & Tenant Manajemen Super Admin
│   │   │   └── Tenant/
│   │   │       ├── Admin/      # Panel Admin Sekolah (Pengaturan Tema)
│   │   │       └── Public/     # Halaman Publik Sekolah
│   │   └── Middleware/         # TenantMiddleware (Database Switching)
│   ├── Models/
│   │   ├── Central/            # SuperAdmin, Sekolah, DomainSekolah
│   │   └── Tenant/             # Artikel, Jurusan, GuruStaf, dll.
│   ├── Providers/
│   ├── Services/                # MediaService (upload, WebP, crop, import URL)
│   └── Support/WarnaKontras.php # Auto-kontras WCAG 2.1 (luminans, rasio, pilihTeks)
├── database/
│   ├── migrations/
│   │   ├── central/            # Migrasi database central
│   │   └── tenant/             # Migrasi database per tenant
│   └── seeders/
│       ├── SuperAdminSeeder.php
│       └── TenantSmkn2BandungSeeder.php
├── docs/                       # PRD, arsitektur, database, route, UI/UX, arsitektur CSS tema
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── central/            # Tampilan Super Admin
│       ├── tenant/admin/       # Tampilan Panel CMS Sekolah
│       └── public/             # Tampilan Portal Publik Sekolah
├── routes/
│   ├── console.php
│   └── web.php                 # Rute Super Admin, Tenant Admin, & Publik
└── tests/
    └── Feature/                # Pengujian Pest PHP
```

---

## 8. Lisensi

Hak cipta dilindungi undang-undang. Dikembangkan untuk implementasi Sistem Manajemen Sekolah Terintegrasi.
