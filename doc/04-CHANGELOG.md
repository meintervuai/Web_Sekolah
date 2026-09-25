# Catatan Perubahan (CHANGELOG)
**Nama Proyek:** Template Website Sekolah Multi-Tenant (SaaS)
**Dokumen Terkait:** [PRD.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/01-PRD.md) | [ARCHITECTURE.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/02-ARCHITECTURE.md) | [DATABASE.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/03-DATABASE.md)

Format changelog ini mengacu pada standar *Keep a Changelog* dan *Semantic Versioning*.

---

## [1.0.0] - 2026-09-25

### Added
- **Central Database (MySQL):** Database `website_sekolah_central` dan `website_sekolah_testing` telah dibuat dan dikonfigurasikan di `.env` serta `phpunit.xml`.
- **Central Migrations:** Migrasi skema database pusat untuk tabel `super_admin`, `sekolah` (UUID), dan `domain_sekolah` di folder `database/migrations/central/`.
- **Eloquent Models:** Model `SuperAdmin`, `Sekolah`, dan `DomainSekolah` di namespace `App\Models\Central`.
- **Autentikasi & Guard Superadmin:** Guard `superadmin` dengan provider `superadmins` berbasis session database di `config/auth.php` dan pengaturan redirect otomatis di `bootstrap/app.php`.
- **Controller Super Admin:**
  - `AuthController`: Menangani halaman login, validasi kredensial, regenerasi sesi, dan proses logout aman.
  - `DashboardController`: Menghitung metrik total sekolah, sekolah aktif, sekolah suspend, total domain, serta grafik distribusi jenjang pendidikan.
  - `TenantController`: Menangani direktori sekolah dengan pencarian dan filter (jenjang & status), pendaftaran sekolah baru, detail profil sekolah, edit data, toggle cepat status aktif/suspend, dan penghapusan tenant.
- **Tampilan Antarmuka (UI/UX) Anti-Slop & Mobile-First:**
  - `layouts/central.blade.php`: Master layout panel Super Admin dengan sidebar desktop, drawer mobile responsif (Alpine.js), topbar, dan notifikasi flash alert.
  - `central/auth/login.blade.php`: Halaman login profesional dengan penampil sandi dinamis dan hint kredensial demo.
  - `central/dashboard/index.blade.php`: Dashboard analitik ringkasan metrik tenant, distribusi jenjang, dan tabel pendaftaran terkini.
  - `central/tenants/index.blade.php`: Tabel direktori tenant interaktif dengan kontrol filter dan pencarian.
  - `central/tenants/create.blade.php`: Formulir pendaftaran sekolah dan domain baru terstruktur.
  - `central/tenants/show.blade.php`: Halaman detail operasional sekolah dan domain terhubung.
  - `central/tenants/edit.blade.php`: Formulir edit data tenant.
- **Database Seeder:** `SuperAdminSeeder` untuk menyuntikkan akun Super Admin default (`superadmin@admin.com` / `password123`) serta 4 sampel institusi sekolah lintas jenjang (SD, SMP, SMA, SMK).
- **Pengujian (Automated Testing):** Pest test komprehensif `tests/Feature/SuperAdminAuthTest.php` mencakup 8 skenario pengujian autentikasi, otorisasi, proteksi guest, operasi tenant, dan logout dengan 100% kelulusan.
