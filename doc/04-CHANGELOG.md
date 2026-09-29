# Catatan Perubahan (CHANGELOG)
**Nama Proyek:** Template Website Sekolah Multi-Tenant (SaaS)
**Dokumen Terkait:** [PRD.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/01-PRD.md) | [ARCHITECTURE.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/02-ARCHITECTURE.md) | [DATABASE.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/03-DATABASE.md)

Format changelog ini mengacu pada standar *Keep a Changelog* dan *Semantic Versioning*.

---

## [1.2.4] - 2026-09-29

### Added
- **Rule `.ai/rules/publik-tema-kontras.md` + indeks `.ai/rules/index.md`**: kontrak penulisan kode portal publik agar selalu mengikuti sistem tema dan auto-kontras (wajib kelas `.theme-*`; dilarang warna literal `text-white`/`bg-blue-900`/hex/`rgba()`; komponen membaca variabel ter-scope `--theme-heading`, `--theme-text`, `--theme-text-muted`, `--theme-fg-link`, `--fg-zona-efektif`, bukan `--theme-btn-text`).
- **SOP di dalam rule**: tambah menu navigasi (data tabel `menu` + catatan filter nama `spmb`, `Profil`, `Program Keahlian` di `layouts/public.blade.php`), tambah halaman publik (route `tenant.*` di grup `{tenant}` -> `PageController::getSekolahData()` -> view `@extends('layouts.public')` -> test Pest), tambah permukaan/scope kontras baru (template 8 baris `--kontras-aman`/`--kontras-terang`/`--fallback-teks`/`--fg-zona-efektif`), dan 6 titik sinkronisasi saat menambah kunci warna baru.
- **`docs/08-CSS-ARSITEKTUR-TEMA.md`**: referensi teknis arsitektur CSS tema (diagram alur warna, API `WarnaKontras`, 13 kunci panel + 16 kunci `--theme-fg-*`, registri 8 scope auto-kontras, inventaris kelas `.theme-*`, resep cepat, fallback browser tanpa `@property`/`contrast()`, verifikasi compiled CSS).

### Changed
- `docs/RULES.md`: bagian 8 "Standar Tema & Auto-Kontras CSS (Portal Publik)".
- `docs/05-UI-UX.md`: menautkan rule dan referensi teknis pada bagian Auto-Kontras WCAG.
- `docs/07-IMPLEMENTATION-CHECKLIST.md`: Tahap 11 (Penegakan Aturan Tema) dicentang.

### Notes
- Dokumen dan rule saja; tidak ada perubahan kode runtime, migrasi, atau perilaku tampilan.

---


## [1.2.3] - 2026-09-29

### Added
- **Auto-Kontras WCAG dua lapis** agar teks tidak pernah nabrak latar hasil kustomisasi admin.
- **`App\Support\WarnaKontras`** (`app/Support/WarnaKontras.php`): `luminans()`, `rasio()`, `pilihTeks()`, `campurWarna()` dengan rumus luminance WCAG 2.1, toleran hex 3/6 digit, dan menganggap format warna tidak dikenal sebagai latar terang.
- **Resolver server-side** pada `resources/views/layouts/public.blade.php`: 16 kunci teks per permukaan (`--theme-fg-header`, `--theme-fg-footer`, `--theme-fg-zona`, `--theme-fg-tombol`, `--theme-fg-aksen`, `--theme-fg-link`, `--theme-fg-badge`, `--theme-fg-halaman-*`, `--theme-fg-section-*`, `--theme-fg-kartu-*`) dengan ambang 4.5:1 (teks isi), 3:1 (tombol), 2:1 (tautan); warna usulan admin tetap dipakai selama lolos ambang.
- **Pengaman client-side** pada `resources/css/public.css`: `@property --kontras-aman`/`--kontras-terang` + deteksi `calc(var(--fg) contrast(var(--bg)) >= 4.5)` yang memutuskan `--fg-zona-efektif` per scope (halaman, section, kartu/`.bg-white`, badge, zona gelap, header, footer).
- **Pratinjau panel tema** (`resources/views/tenant/admin/pengaturan/index.blade.php`) memakai salinan JS logika yang sama (`fgHeader`, `fgFooter`, `fgTombol`, `fgAksen`, `fgKartuHeading`, `fgKartuTeks`, `fgKartuMuted`, `fgSectionHeading`, `fgBadge`, `fgLink`) sehingga pratinjau = hasil render publik.
- **Test:** `tests/Unit/WarnaKontrasTest.php` (7 skenario / 22 assertion) dan 3 skenario auto-kontras pada `tests/Feature/TenantThemeColorTest.php`.

### Changed
- `--theme-fg-zone` -> `--theme-fg-zona`; `--fg-zona-efektif` menjadi resolver bernilai per scope.
- `.text-blue-900`/`.text-blue-950`, `nav .text-blue-950`, `.theme-btn-ghost`, `.theme-table-head`, `.theme-input`, badge, dan zona gelap tidak lagi memakai `--theme-btn-text` mentah atau `color-mix(..., black)`.

### Verification
- `vendor/bin/pest` **63 test / 377 assertions PASSED**; `vendor/bin/pint --dirty` passed; `npm run build` -> `public-CMXtt0o7.css` 34.00 kB (gzip 4.52 kB) tetap memuat `@property` (2 blok), `contrast()` (11 panggilan), `--fg-zona-efektif` (26 rujukan).

## [1.2.2] - 2026-09-29

### Added
- **133 variabel palet Tailwind v4 tambahan di `:root` `resources/css/public.css`** (total 199): `purple`/`violet`/`fuchsia`/`pink` → skala `--theme-identity-*`, `green`/`emerald`/`lime`/`teal`/`cyan`/`yellow`/`red`/`rose` → skala `--theme-accent-*`, `gray`/`zinc`/`stone`/`neutral` → skala `--theme-neutral-*`, `--color-white` → `--theme-identity-50`, plus aturan arbitrary `bg-[#25D366]` & `hover:bg-[#20ba5a]` (tombol WhatsApp) → aksen.

### Changed
- **Sapu bersih sisa putih (tindak lanjut laporan "masih ada putih"):** 37 dasar campuran `color-mix(..., white)` di `public.css` → `var(--theme-page-bg)`, `--color-white` → `var(--theme-btn-text)`, titik radial hero → `--theme-accent-400`, dan pratinjau panel admin memakai `btnText`/`pageBg` (bebas `rgba(255,255,255)`).
- **Seluruh literal putih hardcoded diganti kunci panel `warna_tombol_teks`** (aturan header/footer, breadcrumb `text-blue-100/200`, amber di dark card/section, `group-hover:text-sky-300`, dan aturan zona gelap) sehingga semua teks mengikuti panel Tema & Warna; preset default `#FFFFFF` tetap menghasilkan tampilan identik dengan sebelumnya.
- **Pengecualian semantik dihapus** (`emerald`/`rose`/`red`/merek WhatsApp) atas keputusan pemilik produk: semua keluarga warna wajib terkelompok dan mengikuti tema. Overlay `bg-black/xx` tetap hitam karena fungsi redup, bukan warna tema.

### Verification
- `php artisan test`: **42 test / 278 assertions PASSED**; `vendor/bin/pint --dirty` bersih; `npm run build` sukses (`public-CCKXuORS.css`, 28,54 kB); request HTTP nyata port 8123 & 8000 menautkan stylesheet hash baru.

## [1.2.1] - 2026-09-29

### Added
- **Skala turunan `--theme-identity-50..950`, `--theme-accent-50..950`, `--theme-neutral-50..950`** pada `resources/css/public.css` dan **override 66 variabel palet Tailwind v4** (`--color-blue-*`, `--color-indigo-*`, `--color-sky-*`, `--color-amber-*`, `--color-orange-*`, `--color-slate-*`) sehingga seluruh utilitas warna - termasuk varian `hover:`/`focus:`, opacity `/xx`, gradien `from-via-to`, `ring`, `placeholder`, dan pola radial `#38bdf8` - mengikuti panel Tema & Warna tanpa mengedit view.
- **Test Pest ke-6** `TenantThemeColorTest`: `pemetaan palet Tailwind v4 menutup kelas warna yang lolos dari tema`.

### Changed
- **`resources/css/public.css`**: `border-slate-100/200` ber-opacity kini memakai `--theme-border`; warna semantik `emerald`/`rose`/`red` dan merek WhatsApp `bg-[#25D366]` sengaja dikecualikan dari pemetaan.

### Verification
- `php artisan test`: **42 test / 254 assertions PASSED**; `vendor/bin/pint --dirty` bersih; `npm run build` sukses (`public-DCqQ4nZP.css`, 20.03 kB); request HTTP nyata memastikan stylesheet hash baru tersalin pada portal publik.

## [1.2.0] - 2026-09-29

### Added
- **13 kunci warna tema** di tabel `pengaturan_umum` (6 kunci baru: `warna_judul`, `warna_teks_sekunder`, `warna_latar_halaman`, `warna_latar_section`, `warna_border`, `warna_footer`), dikelompokkan menjadi 6 grup di panel admin: Warna Identitas, Tipografi & Teks, Latar & Permukaan, Garis & Batas, Tombol & Aksi, Header Navigasi & Footer.
- **Pratinjau langsung** (header, section + kartu, footer) dan **legenda kelas global** pada halaman pengaturan tema.
- **Test Pest `TenantThemeColorTest`** (5 skenario: injeksi variabel, kelas tema, isi `public.css`, isi panel, penyimpanan).

### Changed
- **`resources/css/public.css`**: 13 variabel fallback `--theme-*`, **Legacy Utility Mapping** utilitas netral (`bg-white`, `bg-slate-*`, `border-slate-*`, `text-slate-*`) ke variabel tema, footer memakai `--theme-footer-bg`.
- **`layouts/public.blade.php`**: injeksi `:root` 13 variabel; `<body>`, header, footer memakai kelas tema.
- **`HomeController`, `PageController`, `PengaturanController`, seeder**: seluruh 13 kunci warna + `skema_tema`.
- **Halaman pengaturan admin**: dibangun ulang (7 preset, 6 grup rincian warna, pratinjau langsung, legenda, tombol simpan).
- **Pest `TenantAdminTest`**: judul panel `Pengaturan Tema & Warna Portal Sekolah`; full suite **41 test / 243 assertions PASSED**.

### Notes
- Tidak ada perubahan skema database; hanya penambahan baris kunci pada `pengaturan_umum`.

---

## [1.1.0] - 2026-09-29

### Removed
- **Modul admin sekolah selain pengaturan tema dihapus dari sistem** (database tidak disentuh):
  - 16 controller `Tenant\Admin` (Dashboard, Slider, Profil, Struktur, Jurusan, Berita, Pengumuman, Agenda, Galeri, Prestasi, Ekstrakurikuler, GuruStaf, Fasilitas, Spmb, Kontak, Media).
  - 36 view dalam `resources/views/tenant/admin/` dan komponen `components/admin/*` serta aset CDN Quill.
  - `App\Services\ImageService`.
  - Rute `tenant.admin.*` untuk seluruh modul tersebut.

### Changed
- **Sidebar admin sekolah** kini hanya memuat satu menu: **Tema & Warna** (`tenant.admin.pengaturan.index`).
- **Login admin sekolah** langsung diarahkan ke `/{tenant}/admin/pengaturan`; rute `GET /{tenant}/admin/login` tidak lagi memakai middleware `guest:tenant_admin`.
- **Halaman pengaturan admin** hanya memuat panel Tema & Warna (7 preset, custom hex, live preview); tab Identitas, Statistik Beranda, dan Video Profil dihapus.
- **`PengaturanController`** hanya memvalidasi & menyimpan `skema_tema` + 7 kunci warna palet pada tabel `pengaturan_umum`.
- **Pest `TenantAdminTest`** diperbarui menjadi 9 skenario; full suite **36 test / 135 assertions lulus**.

### Notes
- Migrasi, model Eloquent, seeder, dan seluruh data tenant tetap utuh dan tetap dipakai portal publik.

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

### Changed
- **Menu Navigasi:** Mengubah "Program Keahlian" menjadi menu dinamis dari database tenant.

### Removed
- **Modul Kesiswaan:** Menghapus entitas dan tabel `ekstrakurikuler` serta `prestasi` dari skema dan dokumentasi.
