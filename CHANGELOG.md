# Changelog

All notable changes to this project will be documented in this file.

## [Unreleased]

### Added
- **Penyelarasan Rules & Alur Kerja Workspace (Streamlined Execution)**:
  - Menghilangkan beban birokrasi checklist audit dan analisis dampak teoritis dari [AGENTS.md](file:///d:/databaru/Magang/website_sekolah/AGENTS.md) dan [docs/RULES.md](file:///d:/databaru/Magang/website_sekolah/docs/RULES.md).
  - Menetapkan alur kerja ringkas dan terikat: **Wajib membaca dokumen .md di awal**, **eksekusi langsung tanpa bertele-tele**, **database wajib 100% berelasi (FK & model)**, dan **wajib sinkronisasi dokumen .md di akhir**.
- **Dukungan Media Video pada Menu Admin Slider Banner Hero & Pemutaran Dinamis Beranda**:
  - Menambahkan kolom `video` (string 500, nullable) pada tabel `slider_beranda` melalui migrasi `2026_09_28_131117_add_video_to_slider_beranda_table.php`.
  - Menambahkan field upload file video (MP4/WebM maks 50MB) dan input URL CDN video pada formulir admin `resources/views/tenant/admin/slider/create.blade.php` & `edit.blade.php`.
  - Memperbarui `SliderController.php` untuk memvalidasi dan memproses penyimpanan berkas video ke `storage/uploads/video/`.
  - Menampilkan badge indikator tipe media `Video` pada daftar tabel dan kartu grid `resources/views/tenant/admin/slider/index.blade.php`.
  - Memperbarui carousel beranda (`resources/views/public/home.blade.php`) agar memutar video otomatis (`autoplay`, `muted`, `playsinline`), melanjutkan ke slide berikutnya setelah video selesai (`@ended="next()"`), atau memutar berulang (`loop`) jika hanya ada 1 item slider.
- **Banner Hero Beranda Dinamis (Video Looping & Sequential Slideshow)**:
  - Mengimplementasikan pemutar media cerdas berbasis Alpine.js pada `resources/views/public/home.blade.php`:
    - **Jika hanya gambar**: Menampilkan slideshow/tampilan banner foto beranda.
    - **Jika hanya video**: Menjalankan video berulang tanpa henti (`loop`).
    - **Jika ada keduanya**: Menjalankan video terlebih dahulu sampai selesai (`@ended`), kemudian bertransisi mulus ke tampilan banner gambar sekolah.
    - Dilengkapi kontrol interaktif: Toggle audio (Mute/Unmute), tombol "Putar Ulang Video", dan tombol "Lihat Gambar".
  - Menambahkan dukungan input dan upload video/gambar untuk `hero_banner` dan `hero_banner_video` pada formulir admin `resources/views/tenant/admin/pengaturan/index.blade.php`.
  - Memperbarui `PengaturanController.php` dan `HomeController.php` untuk menyimpan serta mengalirkan variabel `hero_banner_video` dan `hero_banner` secara dinamis.
- **Relasi Database Lengkap & ERD Seluruh Tabel (100% Berelasi)**:
  - Membuat dan menjalankan migrasi foreign key untuk seluruh 20 tabel database tenant (`jurusan`, `guru_staf`, `ekstrakurikuler`, `prestasi_siswa`, `agenda`, `unduhan`, `struktur_organisasi`, `slider_beranda`, `halaman_statis`, `kalender_akademik`, `pesan_masuk`, `pengaturan_ppdb`, `pengaturan_umum`, `pengaturan_fitur`, dll).
  - Menghubungkan seluruh model Eloquent dua arah (`belongsTo` & `hasMany`) di `App\Models\Tenant`.
  - Memperbarui diagram ERD visual Mermaid lengkap dan tabel relasi constraint di `docs/03-DATABASE.md`.
- **Penghapusan Counter Dapodik & Integrasi Logo Resmi Sekolah**:
  - Menghapus total section counter Dapodik ("SMK Negeri 2 Bandung dalam Angka") dari `home.blade.php`.
  - Mengganti ikon huruf "S" pada Sidebar Admin (`layouts/tenant_admin.blade.php`) dan ikon SVG toga pada Header & Footer Publik (`layouts/public.blade.php`) dengan gambar logo sekolah resmi (`public/images/logo-smkn2.svg`).
  - Memperbaiki sinkronisasi input form logo di `input-gambar.blade.php` dan `PengaturanController.php` agar logo tersimpan aman tanpa tertimpa string kosong.
- **Perombakan Estetika Beranda (Anti-AI Slop)**:
  - Mengganti font heading menjadi `Plus Jakarta Sans` dan body menjadi `Inter` untuk menghilangkan kesan template AI SaaS yang ramai.
  - Merombak warna tombol dan kartu di seluruh beranda menjadi warna institusional terukur (Navy, Slate, dan Neutral) tanpa drop shadow mengambang yang berlebihan.
  - Menghapus section galeri foto dari halaman beranda sesuai instruksi pengguna.
- **Base Tailwind Public Design System**:
  - Implemented sleek modern public aesthetics referencing Base Tailwind across public interfaces (`layouts/public.blade.php`, `home.blade.php`, `kalender.blade.php`, `agenda.blade.php`, and subpages).
  - Modern sticky header with translucent backdrop-blur, subtle borders, high contrast active indicators, and dynamic CTA button.
  - Interactive 3-column Agenda & Calendar page (`public/pages/agenda.blade.php`) matching the requested reference:
    - Left column: interactive Alpine.js calendar navigator (month/year picker, date selection with active events dots indicator, quick category filter pills, academic calendar banner).
    - Right column: featured events hero cards and horizontal event cards with thumbnail cover, date badges, real-time client-side search, and status tags.
  - Redesigned `kalender.blade.php` academic calendar page with PDF/image viewer cards and modern timeline lists.
  - Passing `allAgenda` and `featuredAgenda` in `PageController@agenda` to support calendar interactivity.
- Added slug field generation in `TenantController@store` when registering a new tenant.
- Added `slug` property for `Sekolah` tests.
- Implemented modern UI/UX grid card layout on the public `jurusan` page.
- Added Alpine.js lightbox component and micro-interactions on the public `galeri` page.
- Added hover transform and shadow animations to article cards on the public `berita` page.
- Added seeding for `pengguna` (admin and operator accounts) in `TenantSmkn2BandungSeeder`.
- Configured single-tenant setup for SMK Negeri 2 Bandung across Central, Tenant Admin, and Public interfaces.

### Database & Migrations
- Initialized central database `website_sekolah_central` with Super Admin and SMK Negeri 2 Bandung.
- Initialized tenant database `tenant_smk_negeri_2_bandung` with complete schema (20 tables) and official school data.

### Fixed
- Fixed a SQL error in `SuperAdminAuthTest` causing tests to fail when trying to insert records without a default `slug`.
- Fixed `TenantController@store` failing when creating tenants without passing a generated slug.

### Changed
- **Skema Warna Header, Footer, & Navigasi ke Biru Institusional**:
  - Mengganti warna latar belakang header top bar (`bg-slate-900` -> `theme-bg` / biru tua).
  - Mengganti warna teks dan ikon pada header dari abu-abu ke biru muda (`text-blue-100`, `text-blue-200`).
  - Mengganti warna navigasi aktif pada menu desktop dan mobile drawer dari `bg-slate-900` ke `bg-blue-900`.
  - Mengganti warna hover link navigasi dari `text-blue-400` ke `text-blue-300` untuk konsistensi.
  - Mengganti warna footer dari `bg-slate-900` ke `theme-bg` (biru tua).
  - Mengganti warna teks footer dari `text-slate-300/400` ke `text-blue-100/200/300`.
  - Mengganti warna ikon sosial media footer dari `bg-slate-800` ke `bg-blue-800`.
  - Mengubah warna akreditasi di header dan footer dari `text-emerald-400` ke `text-white` sesuai permintaan.
  - Memperluas lebar container dari 1200px ke 1440px untuk tampilan lebih lebar di desktop.
  - Membuat hero banner beranda full-width (edge-to-edge) dengan menghilangkan container constraint, border radius, shadow, dan border.
  - Meningkatkan tinggi hero banner dari `h-44/64/80` ke `h-64/96/[450px]`.
  - Mengganti warna overlay gradient dan semi Transparan pada hero banner carousel dengan palet biru yang konsisten.

### Removed
- Removed obsolete `ExampleTest.php` that was testing the root `/` endpoint which was removed/changed due to multi-tenancy URL structure.
