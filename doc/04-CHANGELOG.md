# Catatan Perubahan (CHANGELOG)
**Nama Proyek:** Template Website Sekolah Multi-Tenant (SaaS)
**Dokumen Terkait:** [PRD.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/01-PRD.md) | [ARCHITECTURE.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/02-ARCHITECTURE.md) | [DATABASE.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/03-DATABASE.md)

Format changelog ini mengacu pada standar *Keep a Changelog* dan *Semantic Versioning*.

---

## [1.2.13] - 2026-09-30

### Added
- **Penambahan Tab 6 Guru & Tenaga Kependidikan di Admin Profil**: Menambahkan tab `?tab=guru` yang memuat Kustomisasi Hero Banner (judul, subjudul, foto latar banner 16:9) untuk halaman publik `/guru-staf` dan Direktori Master Guru & Tenaga Kependidikan lengkap (live search, filter gender & status, preview foto 3:4, modal Tambah/Edit, dan modal Hapus). Memperbarui `PageController::guruStaf` dan `guru.blade.php` agar dinamis dan artistik. Verifikasi: `vendor/bin/pest` **75 test / 489 assertions PASSED**.

---

## [1.2.12] - 2026-09-30

### Fixed
- **Perbaikan Render Bersyarat Subjudul & Sambutan Halaman Publik Profil**: Menghapus fallback string bawaan di Blade (`sejarah`, `visi-misi`, `profil`, `struktur`) sehingga saat input subjudul/deskripsi dikosongkan oleh admin di panel, halaman portal publik benar-benar tidak memunculkan teks deskripsi apa pun (bersih 100%). Serta memastikan sambutan kepsek di beranda hanya muncul jika tidak kosong. Verifikasi: `vendor/bin/pest` **73 test / 461 assertions PASSED**.

---

## [1.2.11] - 2026-09-30

### Changed
- **Penataan & Penyeragaman Tab 5 Struktur Organisasi Admin Profil**: Memisahkan form Struktur Organisasi menjadi kartu terstruktur (Kartu Hero Banner dengan preview box 16:9, Kartu Bagan Diagram dengan repeater dinamis dan tombol submit beranimasi spinner, dan Kartu Daftar Pejabat Struktural dengan relasi guru/staf), serta menambahkan binding `bannerStrukturPreview` pada Alpine.js `profilManager`. Verifikasi: `vendor/bin/pest` **73 test / 461 assertions PASSED**.

---

## [1.2.10] - 2026-09-30

### Changed
- **Penyeragaman Ukuran Teks & Gaya Input Form Admin Profil**: seluruh label diseragamkan ke `text-xs font-bold text-slate-700 mb-1` (hero Struktur, sub-field Media Sosial, Bagan Diagram, Video Profil sebelumnya berbeda), seluruh input/textarea/select diseragamkan ke `px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition` (Video Profil, hero Struktur, dan Bagan Diagram sebelumnya `bg-white` / `px-3 py-2`; varian `focus:ring` diseragamkan), hint diseragamkan ke `text-[10px] text-slate-400`, dan tombol "Pilih Media" kartu Bagan Diagram disamakan. Verifikasi: `php artisan view:cache` sukses, `vendor/bin/pest` **73 test / 461 assertions PASSED**.

---

## [1.2.9] - 2026-09-30

### Added
- **Right-Side Artistic Banner Overlay pada Semua Halaman Publik**: Mengaplikasikan efek visual background banner sisi kanan dengan gradient mask halus (`[mask-image:linear-gradient(to_left,rgba(0,0,0,1)_20%,rgba(0,0,0,0.6)_60%,transparent_100%)]`) dan theme header overlay ke seluruh halaman menu publik jika tersedia gambar sampul / banner.
- **Pelebaran Container Judul Hero (`max-w-4xl lg:max-w-5xl`)**: Menghilangkan batasan sempit `max-w-2xl` pada hero halaman publik agar judul panjang tidak terpotong kaku ke bawah dan tampil optimal dalam satu baris.

---

## [1.2.8] - 2026-09-30

### Added
- **Tab Khusus "1. Data Diri Sekolah" (Tab `datadiri`)**: Memisahkan form Data Pokok Satuan Pendidikan (Nama Sekolah, Slogan, Logo, NPSN, Akreditasi, Tahun Berdiri, Kontak, Alamat, Email, WA, Jam Layanan, Medsos Resmi), Kepala Satuan Pendidikan, dan Video Profil ke dalam tab tersendiri.
- **Tab "2. Profil Lengkap" (Tab `identitas`)**: Dikhususkan untuk Kustomisasi Hero Banner Halaman Profil (Judul, Subjudul, Gambar Banner) dan Editor WYSIWYG Uraian Lengkap Profil & Budaya Sekolah.
- **Dukungan Controller `updateIdentitas()`**: Mendukung penyimpanan parsial form `datadiri` dan `halaman_profil` secara independen dengan redirect tepat sasaran.

---

## [1.2.7] - 2026-09-30

### Added
- **Judul Halaman & Foto Banner pada tab Struktur Organisasi admin**: tab kini punya tiga field hero seperti tab Sejarah dan Visi & Misi (`judul_struktur`, `subjudul_struktur`, `gambar_banner_struktur` + tombol *Pilih dari Media*).
- **Penyimpanan ke `halaman_statis` slug `struktur`**: `ProfilController::updateStruktur()` menyimpan `judul`, `subjudul`, dan `gambar_banner` (banner disinkronkan ke Pusat Media via `MediaService::sinkronisasiOtomatisUrl()`).
- **Banner & judul tampil di halaman publik struktur**: banner dirender di atas section konten (21:9, `max-h-[420px]`) dan `<title>` memakai `$halaman->judul`.
- **Blok header kartu tab Struktur Organisasi**: judul "Kelola Struktur Organisasi & Data Pejabat" + deskripsi singkat, konsisten dengan tab Sejarah dan Visi & Misi.

### Notes
- Sebelumnya `judul` halaman struktur selalu di-hardcode `'Struktur Organisasi Sekolah'` dan `gambar_banner` tidak pernah disimpan.
- Test baru pada `tests/Feature/TenantAdminProfilTest.php`. Full suite Pest **72 test / 453 assertions PASSED**; `vendor/bin/pint --dirty` passed.

---


## [1.2.6] - 2026-09-30

### Removed
- **Kontrol "Mode Pilihan Tampilan Halaman Struktur Publik"** dihapus dari tab Struktur Organisasi admin (`resources/views/tenant/admin/profil/index.blade.php`).
- **Kunci `mode_tampilan_struktur`** dihapus dari `ProfilController::index()` / `updateStruktur()`, `Tenant\Public\PageController::struktur()`, dan view publik `struktur.blade.php`.

### Fixed
- **Fatal parse error view publik struktur**: `@if($mode === 'semua' || $mode === 'pejabat')` tanpa `@endif` membuat kompilasi Blade gagal (`unexpected end of file, expecting "elseif" or "else" or "endif"`). Directive mode dihapus sehingga halaman `/profil/struktur` kembali dirender normal.
- Halaman publik struktur kini selalu menampilkan kedua bagian (Jajaran Pejabat + Bagan Diagram) dengan tab default "Jajaran Pejabat".

### Notes
- Kunci `pengaturan_umum.mode_tampilan_struktur` dibiarkan di database sebagai data lama (tidak dipakai lagi, tanpa migrasi destruktif).
- Regression test: `TenantPublicPagesTest` skenario `2b` dan tambahan `assertDontSee` pada `TenantAdminProfilTest`. Full suite Pest **71 test / 435 assertions PASSED**.

---


## [1.2.5] - 2026-09-30

### Removed
- **Dropdown "Pola Dekorasi Latar" di admin Profil Sekolah**: dihapus dari 4 tab (`Identitas/Profil`, `Sejarah`, `Visi & Misi`, `Struktur`) pada `resources/views/tenant/admin/profil/index.blade.php` karena tidak dipakai operator sekolah.
- **Validasi & penulisan `pola_latar*`** di `app/Http/Controllers/Tenant/Admin/ProfilController.php`: `pola_latar_profil`, `pola_latar` (updateHalaman), dan `pola_latar_struktur` beserta penulisan kolom pada `updateIdentitas()`, `updateHalaman()`, dan `updateStruktur()` dihapus.

### Changed
- Layout hero admin dirapikan: judul halaman `sm:col-span-2` pada tab Sejarah dan Visi & Misi; panel hero Struktur kembali satu kolom.

### Notes
- Kolom `halaman_statis.pola_latar`, `$fillable` model `Page`, dan rendering pola hero pada 4 halaman publik dipertahankan; tidak ada migrasi destruktif dan tampilan publik tidak berubah (fallback `dots`).
- Verifikasi: full suite Pest **70 test / 429 assertions PASSED**; `vendor/bin/pint --dirty` bersih.
- Ringkasan rinci ada di `docs/06-CHANGELOG.md` dan `CHANGELOG.md`.

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
