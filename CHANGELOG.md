# Changelog

All notable changes to this project will be documented in this file.

## [Refactoring Modularisasi View Admin Informasi Sekolah] - 2026-10-07

### Refactored & Reorganized
- **Pemisahan Modul View Informasi ke Folder Masing-Masing**:
  - Menghapus folder monolitik `resources/views/tenant/admin/informasi/` dan memisahkannya menjadi modul folder mandiri berarsitektur tab (`index.blade.php` + `tabs/tab-*.blade.php` + `tabs/modals.blade.php`):
    1. **Berita** (`resources/views/tenant/admin/berita/`):
       - `index.blade.php`, `tabs/tab-berita.blade.php`, `tabs/tab-form.blade.php`, `tabs/tab-kategori.blade.php`, `tabs/modals.blade.php`
    2. **Pengumuman** (`resources/views/tenant/admin/pengumuman/`):
       - `index.blade.php`, `tabs/tab-pengumuman.blade.php`, `tabs/tab-form.blade.php`, `tabs/modals.blade.php`
    3. **Agenda** (`resources/views/tenant/admin/agenda/`):
       - `index.blade.php`, `tabs/tab-agenda.blade.php`, `tabs/tab-form.blade.php`, `tabs/modals.blade.php`
    4. **Galeri** (`resources/views/tenant/admin/galeri/`):
       - `index.blade.php`, `tabs/tab-album.blade.php`, `tabs/tab-items.blade.php`, `tabs/tab-form.blade.php`, `tabs/modals.blade.php`
    5. **Fasilitas** (`resources/views/tenant/admin/fasilitas/`):
       - `index.blade.php`, `tabs/tab-fasilitas.blade.php`, `tabs/tab-form.blade.php`, `tabs/tab-stats.blade.php`, `tabs/modals.blade.php`
- **Pembaruan Controller View Return**:
  - Mengarahkan `InformasiController.php` untuk me-render view baru: `tenant.admin.berita.index`, `tenant.admin.pengumuman.index`, `tenant.admin.agenda.index`, `tenant.admin.galeri.index`, dan `tenant.admin.fasilitas.index`.
- **Verifikasi Pengujian**:
  - Feature test suite Pest `TenantAdminInformasiTest.php` (7 passed, 38 assertions).

## [Perbaikan Alpine.js Media Picker & Konfigurasi Database Lokal] - 2026-10-07

### Fixed & Enhanced
- **Sinkronisasi Alpine Data pada Reusable Media Picker (`picker-modal.blade.php`)**:
  - Memperbaiki error `ReferenceError: mediaPickerOpen is not defined`, `pickerFilterType is not defined`, `pickerShowImportForm is not defined`, dll. pada halaman admin informasi.
  - Menyelaraskan kontrak state dan methods Alpine.js di:
    - [resources/views/tenant/admin/informasi/berita.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/berita.blade.php)
    - [resources/views/tenant/admin/informasi/pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/pengumuman.blade.php)
    - [resources/views/tenant/admin/informasi/agenda.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/agenda.blade.php)
    - [resources/views/tenant/admin/informasi/galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/galeri.blade.php)
    - [resources/views/tenant/admin/informasi/fasilitas.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/fasilitas.blade.php)
- **Konfigurasi Database Lokal**:
  - Mengalihkan database tenant & central ke MySQL lokal (`127.0.0.1:3306`).
  - Memperbaiki seeder `TenantSmkn2BandungSeeder.php` dan `TenantDummySeeder.php` agar selaras dengan skema database aktif.


## [Fitur Pengaturan Tab Banner & Slider Hero Beranda untuk Publik] - 2026-10-07

### Added & Enhanced
- **Tab Baru 5. Banner & Slider Beranda di Panel Admin Profil**:
  - [resources/views/tenant/admin/profil/tabs/tab-slider.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/tabs/tab-slider.blade.php): Menyediakan antarmuka visual lengkap untuk:
    1. **Pengaturan Hero Banner Beranda**: Pengaturan cover gambar poster (`hero_banner`) dan video latar/profil (`hero_banner_video`) beranda dengan live preview & integrasi Media Picker.
    2. **Tabel Manajemen Slider Carousel Beranda**: Daftar slide interaktif (`$sliderList`), badge status aktif/draft, urutan tampil, preview thumbnail media, tombol CTA, serta aksi edit & hapus.
  - [resources/views/tenant/admin/profil/tabs/modals.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/tabs/modals.blade.php): Menambahkan modal kustom Tambah/Edit Slide Hero Beranda dan modal konfirmasi hapus slide ramah pengguna.
  - [resources/views/tenant/admin/profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php): Menambahkan pill tab navigasi `slider` ("5. Banner & Slider Beranda"), tombol simpan sticky top bar, integrasi Alpine.js manager untuk slide carousel & banner hero.
- **Backend Controller & Sanitasi**:
  - [app/Http/Controllers/Tenant/Admin/ProfilController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/ProfilController.php):
    - Mengintegrasikan pengambilan kunci `hero_banner` dan `hero_banner_video` di method `index()`.
    - Menambahkan validasi dan auto-sinkronisasi media via `MediaService::sinkronisasiOtomatisUrl()` untuk `hero_banner` dan `hero_banner_video` pada method `updateIdentitas()`.
- **Integrasi Penuh dengan Beranda Publik**:
  - [resources/views/public/home.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/home.blade.php): Menampilkan hero slider dan banner beranda yang telah dikonfigurasi langsung oleh admin sekolah.

## [Fitur Pengaturan Hero Banner / Slider Beranda di Admin & Super Admin] - 2026-10-07

### Added & Enhanced
- **Refactor Tab Profil Sekolah**:
  - Menghapus tab *Hero Banner Beranda* dari Panel Profil Sekolah (`/admin/profil`) dan mengembalikan tata letak admin menjadi 4 tab utama (Data Pokok Satuan Pendidikan, Profil Lengkap, Sejarah, Visi Misi).
  - [resources/views/public/home.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/home.blade.php): Memperbarui rendering banner hero beranda publik agar menampilkan gradien tema sekolah yang elegan & bersih saat tanpa foto/media terpasang, serta gradien semi-transparan WCAG AA saat terpasang foto/video.
  - [database/migrations/tenant/2026_10_07_024000_make_gambar_nullable_on_slider_beranda_table.php](file:///d:/databaru/Magang/website_sekolah/database/migrations/tenant/2026_10_07_024000_make_gambar_nullable_on_slider_beranda_table.php): Menjadikan kolom `gambar` nullable pada tabel `slider_beranda` untuk mendukung banner hero clean tanpa media foto/video terpasang.
- **Integrasi Pintasan Super Admin**:
  - [resources/views/central/tenants/show.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/central/tenants/show.blade.php): Menambahkan tombol pintasan langsung *Lihat Website* dan *Panel Admin Sekolah* pada halaman detail tenant Super Admin.
- **Pest Automated Feature Test**:
  - [tests/Feature/TenantAdminProfilTest.php](file:///d:/databaru/Magang/website_sekolah/tests/Feature/TenantAdminProfilTest.php): Menambahkan automated feature test lengkap untuk menguji operasi CRUD Hero Banner Slider Beranda dan verifikasi penayangan di halaman publik beranda (12 tests passed, 122 assertions).

### Added
- **Konfigurasi Serverless Vercel**:
  - [api/index.php](file:///d:/databaru/Magang/website_sekolah/api/index.php): Handler serverless function Vercel dengan otomatisasi pembuatan folder ephemeral `/tmp` untuk cache, view compiler, dan session storage.
  - [vercel.json](file:///d:/databaru/Magang/website_sekolah/vercel.json): Konfigurasi runtime PHP `vercel-php@0.7.3`, routing rute statis (`/build`, `/storage`, `/assets`), dan routing dinamis Laravel.
  - [.vercelignore](file:///d:/databaru/Magang/website_sekolah/.vercelignore): Konfigurasi filter berkas agar deploy Vercel ringan dan optimal.


## [Pemisahan Menu Navigasi Admin Informasi Sekolah Menjadi Menu Mandiri] - 2026-10-06

### Refactored & Enhanced
- **Pemisahan Menu Sidebar Admin**:
  - [resources/views/layouts/tenant_admin.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/tenant_admin.blade.php): Mengubah grup dropdown *Informasi Sekolah* menjadi item menu tingkat atas (top-level) mandiri:
    1. **Berita & Artikel** (`/admin/informasi/berita`)
    2. **Pengumuman** (`/admin/informasi/pengumuman`)
    3. **Agenda Kegiatan** (`/admin/informasi/agenda`)
    4. **Galeri Dokumentasi** (`/admin/informasi/galeri`)
    5. **Fasilitas & Sarpras** (`/admin/informasi/fasilitas`)
  - Setiap menu memiliki ikon khas sendiri dan tetap dikontrol secara reaktif oleh feature flag masing-masing.

## [Penyederhanaan & Kustomisasi Modul SPMB / PPDB] - 2026-10-06

### Refactored & Enhanced
- **Penyederhanaan Modul Panel Admin SPMB (`/admin/spmb`)**:
  - Menghapus tab *Jalur Seleksi* untuk menyederhanakan alur navigasi admin.
  - Mengubah *Persyaratan Dokumen* menjadi form editor **WYSIWYG (Quill)** fleksibel, sehingga admin dapat memformat daftar dokumen persyaratan umum, berkas khusus, dan catatan pendaftaran secara bebas dengan teks kaya (bold, list, bullet, dsb.).
  - Menghapus input *Helpdesk* dan *Daya Tampung / Kuota Rombel Jurusan* dari tab Sidebar karena informasi kontak dan lokasi sudah terpusat di modul Halaman Kontak.
  - Tab Sidebar difokuskan khusus untuk konfigurasi *Portal Pendaftaran Resmi (Eksternal)* (Nama portal, tautan resmi, deskripsi, dan teks tombol).
- **Sinkronisasi Tampilan Publik SPMB (`/spmb`)**:
  - [resources/views/public/pages/spmb.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/spmb.blade.php): Halaman publik SPMB sekarang terbagi rapi menjadi Hero Banner, Alur & Prosedur Pendaftaran Step-by-Step, Persyaratan Dokumen (WYSIWYG), dan Sidebar Portal Pendaftaran Eksternal.
  - [app/Http/Controllers/Tenant/Public/PageController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Public/PageController.php): Mengalirkan data persyaratan WYSIWYG `syaratKonten` dan konfigurasi portal resmi secara presisi.

## [Kustomisasi Embed Google Maps, Filter Medsos Simbol Strip, dan Fleksibilitas Jam Layanan] - 2026-10-06

### Added & Enhanced
- **Input Embed Google Maps (Iframe Peta Lokasi)**:
  - [resources/views/tenant/admin/profil/tabs/tab-datadiri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/tabs/tab-datadiri.blade.php): Menambahkan input khusus `peta_embed` untuk memasukkan URL atau kode iframe embed resmi Google Maps sekolah.
  - [app/Http/Controllers/Tenant/Admin/ProfilController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/ProfilController.php): Memvalidasi dan menyimpan kunci `peta_embed` ke tabel database `pengaturan_umum`.
  - [resources/views/public/home.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/home.blade.php) & [resources/views/public/pages/kontak.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/kontak.blade.php): Peta Google Maps sekarang 100% kondisional hanya dirender bila admin telah menginput embed peta (tidak lagi menampilkan peta default tiruan/dummy jika input kosong).
- **Dukungan Simbol Strip (`-`) untuk Menyembunyikan Ikon Media Sosial**:
  - [resources/views/layouts/public.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/public.blade.php) & [resources/views/public/pages/kontak.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/kontak.blade.php): Menambahkan helper sanitasi `isValidSocial()`. Jika kolom media sosial (Instagram, TikTok, YouTube, Facebook, Twitter) diisi tanda `-`, `#`, string kosong, atau `null`, ikon dan tombolnya otomatis tidak ditampilkan di seluruh portal publik (footer & halaman kontak).
  - Mengizinkan input URL maupun username biasa (otomatis diformat dengan prefix URL resmi).
- **Pembersihan Topbar & Penataan Jam Layanan di Footer**:
  - [resources/views/layouts/public.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/public.blade.php): Menghapus jam layanan dari topbar atas agar header tetap ringkas, bersih, dan tidak tumpang tindih. Jam layanan ditempatkan di Kolom Kontak & Lokasi di footer dan Halaman Kontak dengan dukungan multi-line (`whitespace-pre-line`).
  - [resources/views/tenant/admin/profil/tabs/tab-datadiri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/tabs/tab-datadiri.blade.php): Mengubah input jam layanan menjadi `textarea` multi-line agar sekolah dapat mendeskripsikan jam buka/tutup harian secara lengkap.

## [Penghapusan Bersih Modul Prestasi & Penyelarasan Section Beranda] - 2026-10-06

### Removed
- **Modul & Section Prestasi Siswa**:
  - Menghapus section *"Bakat & Kejuaraan / Prestasi Membanggakan"* dari [resources/views/public/home.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/home.blade.php).
  - Menghapus database table `prestasi_siswa` di seluruh database tenant via migration [database/migrations/tenant/2026_10_06_042507_drop_prestasi_siswa_table.php](file:///d:/databaru/Magang/website_sekolah/database/migrations/tenant/2026_10_06_042507_drop_prestasi_siswa_table.php).
  - Menghapus Model Eloquent `App\Models\Tenant\PrestasiSiswa`, relasi `prestasi()` dari `Jurusan`, serta view template `prestasi.blade.php` dan `prestasi_detail.blade.php`.
  - Menghapus rute publik `/prestasi` dan `/prestasi/{slug}` dari [routes/web.php](file:///d:/databaru/Magang/website_sekolah/routes/web.php).
  - Membersihkan referensi controller di [app/Http/Controllers/Tenant/Public/HomeController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Public/HomeController.php), [app/Http/Controllers/Tenant/Public/PageController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Public/PageController.php), [app/Services/MediaService.php](file:///d:/databaru/Magang/website_sekolah/app/Services/MediaService.php), dan tautan footer di [resources/views/layouts/public.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/public.blade.php).

### Fixed
- **Penyelarasan Tampilan Section Berita & Pengumuman di Beranda**:
  - [resources/views/public/home.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/home.blade.php): Membungkus seluruh kontainer `<section>` Berita & Pengumuman dengan kondisi `@if($isBeritaAktif || $isPengumumanAktif)`.
  - Jika kedua fitur dinonaktifkan, kontainer section dan border pemisahnya hilang total tanpa menyisakan ruang putih kosong.
  - Jika hanya salah satu fitur yang aktif (misal Berita aktif, Pengumuman nonaktif atau sebaliknya), lebar kolom otomatis meluas penuh (`lg:col-span-12`) dengan penataan grid yang proporsional.

## [Sinkronisasi Granular Menu Profil & Proteksi Tab CMS Admin Sekolah] - 2026-10-06

### Fixed & Security
- **Proteksi Akses Tab Profil & GTK CMS Admin Sekolah (`?tab=sejarah`, `?tab=visimisi`, `?tab=guru`, `?tab=struktur`)**:
  - [app/Http/Controllers/Tenant/Admin/ProfilController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/ProfilController.php): Menambahkan proteksi validasi query param `tab` pada method `index()`. Jika admin mencoba mengakses URL tab yang fiturnya dimatikan oleh Super Admin (seperti `?tab=sejarah`), sistem otomatis mengalihkan (redirect) ke tab Data Diri (`?tab=datadiri`) dengan pesan flash error `"Akses ditolak: Modul Sejarah sedang dinonaktifkan oleh Super Admin."`.
  - [app/Http/Controllers/Tenant/Admin/GtkController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/GtkController.php): Menambahkan proteksi validasi query param `tab` (`?tab=guru` dan `?tab=struktur`). Jika salah satu dimatikan, otomatis fallback ke tab yang aktif; jika kedua modul GTK dimatikan, akses seluruh rute `/admin/gtk` ditolak dan dialihkan ke `/admin/profil`.
  - [resources/views/layouts/tenant_admin.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/tenant_admin.blade.php): Menyesuaikan teks label menu sidebar admin secara dinamis (*"Struktur Organisasi"*, *"Direktori Guru & GTK"*, atau *"Struktur & GTK"*) sesuai sub-fitur yang sedang aktif, dan menyembunyikannya secara total jika kedua sub-fitur nonaktif.
  - [app/Http/Controllers/Tenant/Admin/ProfilController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/ProfilController.php): Menambahkan guard pengecekan fitur pada method `updateIdentitas()` dan `updateHalaman()` agar submit form dari sub-fitur yang dinonaktifkan langsung ditolak.

- **Sinkronisasi Reaktif Induk Menu Profil saat Mengaktifkan Sub-Fitur**:
  - [app/Http/Controllers/Central/TenantController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Central/TenantController.php): Ketika salah satu sub-fitur profil (`profil`, `profil_video`, `sejarah`, `visi_misi`, `struktur_organisasi`, `guru_staf`) diaktifkan (`aktif: true`), sistem otomatis menyinkronkan status induk `menu_profil` dan data tabel `menus` (`Profil`) ke aktif (`is_aktif = 1`).
  - [resources/views/layouts/public.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/public.blade.php): Memperbaiki rendering dropdown navbar publik agar menu `Profil` muncul secara dinamis selama terdapat minimal 1 sub-fitur yang berstatus aktif (hanya sub-fitur aktif yang ditampilkan di dropdown).
  - [routes/web.php](file:///d:/databaru/Magang/website_sekolah/routes/web.php): Memisahkan middleware `tenant.feature` per sub-rute profil (`tenant.feature:sejarah`, `tenant.feature:visi_misi`, `tenant.feature:struktur_organisasi`) agar akses sub-halaman bekerja secara mandiri dan presisi.
  - [tests/Feature/TenantRouteVisibilityTest.php](file:///d:/databaru/Magang/website_sekolah/tests/Feature/TenantRouteVisibilityTest.php): Menambahkan automated test untuk memvalidasi proteksi URL tab admin sekolah dan pengalihan ke tab aman saat fiturnya nonaktif.

## [Penyelarasan Visibilitas Menu Dropdown Kosong & Tombol CTA SPMB Navbar] - 2026-10-06

### Fixed
- **Kondisionalitas Tombol CTA SPMB 2026**:
  - [resources/views/layouts/public.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/public.blade.php): Membungkus tombol CTA `SPMB 2026` di header desktop, mobile header, dan drawer footer mobile dengan pengecekan `PengaturanFitur::isAktif('spmb', true)`.
- **Penyembunyian Menu Induk Dropdown Kosong**:
  - [resources/views/layouts/public.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/public.blade.php): Mengeliminasi menu induk dropdown (seperti `Informasi`) dari navbar apabila seluruh sub-menunya nonaktif.
  - [app/Http/Controllers/Central/TenantController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Central/TenantController.php): Menyinkronkan status menu `/kegiatan` saat toggle fitur galeri diubah.
- **Halaman Dasar Kontak & Hubungi Kami Dijadikan Permanen**:
  - [app/Http/Controllers/Central/TenantController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Central/TenantController.php): Menghapus sakelar toggle `Kontak & Buku Tamu` dari Kontrol Visibilitas Super Admin karena **Beranda** dan **Kontak** merupakan halaman wajib utama setiap sekolah.
  - [routes/web.php](file:///d:/databaru/Magang/website_sekolah/routes/web.php): Menghapus pembatasan middleware feature flag pada rute `/{tenant}/kontak` sehingga selalu aktif dan berstatus 200 OK.
  - [resources/views/layouts/public.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/public.blade.php): Menetapkan menu navigasi dan tautan footer Kontak sebagai elemen permanen.
- **Penyelarasan Hero Slider & Footer**:
  - [app/Http/Controllers/Tenant/Public/HomeController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Public/HomeController.php): Menyaring tombol slider beranda jika modul tujuan nonaktif.
  - [resources/views/layouts/public.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/public.blade.php): Menyaring tautan cepat footer berdasarkan status aktif fitur.

## [Proteksi Ketat Rute Admin Sekolah & Penegakan Otoritas Master Super Admin] - 2026-10-05

### Added
- **Middleware Proteksi Fitur Tenant `EnsureTenantFeatureEnabled`**:
  - [app/Http/Middleware/EnsureTenantFeatureEnabled.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Middleware/EnsureTenantFeatureEnabled.php): Memvalidasi status keaktifan modul di `pengaturan_fitur`. Jika nonaktif, rute publik menghasilkan 404 Not Found, rute Admin Sekolah dialihkan ke `tenant.admin.profil.index` dengan notifikasi error penolakan hak akses, dan API AJAX menghasilkan 403 Forbidden.
  - [bootstrap/app.php](file:///d:/databaru/Magang/website_sekolah/bootstrap/app.php): Mendaftarkan alias `tenant.feature`.

### Security & Fixed
- **Penguncian Rute Admin Sekolah Terhadap Modul yang Dinonaktifkan**:
  - [routes/web.php](file:///d:/databaru/Magang/website_sekolah/routes/web.php): Memasang middleware `tenant.feature` pada seluruh grup rute Admin Sekolah (`/gtk`, `/program-keahlian`, `/informasi/berita`, `/informasi/pengumuman`, `/informasi/agenda`, `/informasi/galeri`, `/informasi/fasilitas`).
  - [app/Http/Controllers/Tenant/Admin/InformasiController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/InformasiController.php) & [app/Http/Controllers/Tenant/Admin/JurusanController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/JurusanController.php) & [app/Http/Controllers/Tenant/Admin/ProfilController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/ProfilController.php): Memblokir manipulasi master feature flag dari panel admin sekolah.
  - [tests/Feature/TenantRouteVisibilityTest.php](file:///d:/databaru/Magang/website_sekolah/tests/Feature/TenantRouteVisibilityTest.php): Automated feature test penolakan akses rute admin sekolah ketika modul dinonaktifkan oleh Super Admin.

## [Sentralisasi Pengaturan Tema & Warna Eksklusif Super Admin] - 2026-10-05

### Added
- **Konfigurasi Tema & Palet Warna di Panel Super Admin**:
  - [app/Http/Controllers/Central/TenantController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Central/TenantController.php): Menambahkan integrasi 13 nilai warna (`pengaturan_umum`) pada formulir edit dan penyimpanan dinamis tenant di panel Super Admin.
  - [resources/views/central/tenants/edit.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/central/tenants/edit.blade.php): Menambahkan *Section 4: Konfigurasi Tema & Palet Warna Sekolah (Super Admin Only)* lengkap dengan 7 preset tema (*Navy Classic, Emerald Nature, Maroon Prestige, Royal Purple, Slate Dark, Amber Sunset, Teal Modern*), 13 color picker presisi, dan input hex.

### Changed
- **Pencabutan Hak Akses Tema & Warna dari Admin Sekolah (Tenant Admin)**:
  - [resources/views/layouts/tenant_admin.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/tenant_admin.blade.php): Menghapus menu navigasi *Tema & Warna* dari sidebar admin sekolah dan mengubah tautan logo header agar mengarah ke *Profil Sekolah*.
  - [app/Http/Controllers/Tenant/Admin/PengaturanController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/PengaturanController.php): Mengunci rute `tenant.admin.pengaturan.index` dan `tenant.admin.pengaturan.update` dengan auto-redirect ke halaman profil.
  - [app/Http/Controllers/Tenant/Admin/AuthController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/AuthController.php): Mengarahkan rute login berhasil langsung ke dashboard *Profil Sekolah*.

## [Perbaikan Navigasi Beranda, Penyelarasan Sambutan Kepala Sekolah & Verifikasi Rute Publik] - 2026-10-05

### Fixed
- **Perbaikan Tautan Menu Beranda di Navbar Publik**:
  - [resources/views/layouts/public.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/public.blade.php): Memperbaiki resolusi URL rute Beranda (`url === '/'`) pada navbar desktop dan drawer navigasi mobile agar menghasilkan URL beranda sekolah yang valid (`/{tenant}`) dan bukan link kosong (`#`), sehingga menu Beranda dapat diklik normal dari halaman mana pun.
- **Penambahan Sakelar Video Profil Sekolah di Panel Super Admin**:
  - [app/Http/Controllers/Central/TenantController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Central/TenantController.php): Mendaftarkan kembali sub-section `profil_video` (*Video Profil Sekolah - Sidebar / Pemutar*) pada sub-bagian Menu Profil di panel Super Admin lengkap dengan cascading logic, sehingga Super Admin dapat secara granular menentukan apakah suatu tenant sekolah diizinkan menampilkan pemutar video profil atau tidak pada halaman `/profil` publik.
- **Pemulihan Permanen Kartu Video Profil & Kepala Sekolah di Panel Admin**:
  - [resources/views/tenant/admin/profil/tabs/tab-datadiri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/tabs/tab-datadiri.blade.php): Memastikan kartu formulir *Kepala Satuan Pendidikan* (Nama, NIP, Foto Media, Sambutan) dan kartu formulir *Video Profil Sekolah* (Judul, URL YouTube/Media MP4, Deskripsi) **selalu tersedia permanen** di kolom kanan Tab 1 Data Pokok Sekolah agar Admin Sekolah dapat sewaktu-waktu mengisi dan mengelola media profil tanpa terblokir kondisi apa pun.
- **Penyelarasan & Pemulihan Section Sambutan Kepala Sekolah di Beranda & Halaman Profil Sesuai Manajemen Media**:
  - [resources/views/public/home.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/home.blade.php): Memperbaiki evaluasi field foto, nama, gelar, NIP, dan teks ringkasan sambutan kepala sekolah dengan menerapkan `\App\Services\MediaService::getCropStyle()` agar selalu patuh pada konfigurasi rasio dan titik fokus (smart crop) dari Pusat Media.
  - [resources/views/public/pages/profil.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/profil.blade.php): Menambahkan kartu *Sambutan Kepala Sekolah* resmi (Foto Kepala Sekolah dengan integrasi `MediaService::getCropStyle()`, Nama, NIP, dan Teks Sambutan) di halaman publik `/profil` baik pada layout 2-kolom (dengan video profil) maupun layout 1-kolom terpusat.
- **Penjelasan Struktur Menu Agenda & Kegiatan pada Portal Publik**:
  - Halaman dan rute publik Agenda & Kegiatan tetap aktif dan terdaftar di rute `/{tenant}/agenda`. Pada struktur menu navigasi portal, item *Agenda Kegiatan* dikelompokkan ke dalam dropdown **Informasi** (`Informasi -> Agenda & Kegiatan`) bersama *Berita*, *Pengumuman*, *Galeri*, dan *Fasilitas*.

## [Penyempurnaan Animasi Toggle Switch & Sinkronisasi Menu Super Admin] - 2026-10-05

### Fixed
- **Penegakan Proteksi Rute Publik (HTTP 404) Saat Fitur Dinonaktifkan Super Admin**:
  - [app/Http/Controllers/Tenant/Public/PageController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Public/PageController.php): Memastikan metode `checkFitur()` mengeksekusi `abort(404)` pada semua rute publik (`/profil`, `/profil/sejarah`, `/profil/visi-misi`, `/profil/struktur`, `/program-keahlian`, `/berita`, `/agenda`, `/pengumuman`, `/guru-staf`, `/fasilitas`, `/galeri`, `/spmb`, `/kontak`) jika fiturnya dinonaktifkan di `pengaturan_fitur`.
  - [app/Http/Controllers/Tenant/Admin/ProfilController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/ProfilController.php): Menghapus override `is_aktif` saat Admin Sekolah menyimpan konten halaman statis agar tidak menimpa status visibilitas yang telah diatur oleh Super Admin.
  - [resources/views/public/home.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/home.blade.php): Mengkondisikan seluruh tombol dan link terkait (Profil di slider hero dan tombol Profil Lengkap / Visi Misi di sambutan) agar otomatis disembunyikan ketika fiturnya nonaktif.
  - [tests/Feature/TenantRouteVisibilityTest.php](file:///d:/databaru/Magang/website_sekolah/tests/Feature/TenantRouteVisibilityTest.php): Menambahkan automated feature test untuk memverifikasi bahwa penonaktifan via Super Admin langsung menghasilkan status `404 Not Found` pada rute publik yang bersangkutan.
- **Pembersihan Sub-Section Mikro Profil di Panel Super Admin**:
  - [app/Http/Controllers/Central/TenantController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Central/TenantController.php): Menghapus sakelar sub-bagian mikro yang tidak relevan (`profil_data_pokok`, `profil_sambutan_kepsek`, `profil_video`, `struktur_diagram`, `struktur_pejabat`) dari panel visibilitas Super Admin sehingga daftar sub-bagian menu Profil bersih dan hanya berfokus pada halaman nyata (*Halaman Utama Profil*, *Halaman Sejarah*, *Halaman Visi & Misi*, *Halaman Struktur Organisasi*, dan *Halaman Direktori Guru & GTK*).
- **Penyelarasan Label Tab & Header Data Pokok Satuan Pendidikan**:
  - [resources/views/tenant/admin/profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php): Menyeragamkan label Tab 1 menjadi `1. Data Pokok Satuan Pendidikan` agar selaras 100% dengan judul kartu formulir.
- **Penyesuaian Tampilan Halaman Profil Sekolah di Panel Admin**:
  - [resources/views/tenant/admin/profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php): Membungkus tab *2. Profil Lengkap* dengan `\App\Models\Tenant\PengaturanFitur::isAktif('profil')` sehingga ketika Super Admin menonaktifkan fitur profil publik, tab profil panjang otomatis tersembunyi dan admin hanya fokus pada *Data Pokok Satuan Pendidikan*.
  - [resources/views/tenant/admin/profil/tabs/tab-datadiri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/tabs/tab-datadiri.blade.php): Menyesuaikan layout kartu *Data Pokok Satuan Pendidikan* menjadi **lebar penuh (col-span-12)** secara otomatis serta menyembunyikan box Kepala Sekolah & Video Profil jika modul publiknya dimatikan oleh Super Admin.
- **Ketersediaan Menu Profil Sekolah (Data Pokok & Identitas) di Sidebar Admin**:
  - [resources/views/layouts/tenant_admin.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/tenant_admin.blade.php): Memastikan menu *Profil Sekolah* (Tab Data Diri Sekolah, Logo, Kontak, NPSN, Akreditasi, dan Media Sosial) selalu dapat diakses oleh Admin Sekolah sekalipun menu publik Profil dinonaktifkan oleh Super Admin, karena data pokok tersebut merupakan identitas esensial satuan pendidikan untuk header, footer, dan dokumen resmi.
- **Penanganan Link Induk Dropdown Navigasi Publik Saat Halaman Dinonaktifkan**:
  - [resources/views/layouts/public.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/public.blade.php): Memperbaiki navigasi desktop dan mobile drawer agar ketika sub-fitur `profil` (Halaman Utama Profil) dinonaktifkan tetapi menu induk `menu_profil` masih aktif untuk menaungi sub-halaman lain (Sejarah, Visi Misi, Struktur, GTK), tautan induk `Profil` otomatis menjadi toggle dropdown non-link (`#` / button toggle) sehingga pengguna tidak dapat mengklik atau diarahkan ke rute `404` `/profil`.
- **Perapihan Visual & Animasi Sakelar Toggle Switch Super Admin**:
  - [resources/views/central/tenants/show.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/central/tenants/show.blade.php): Memperbaiki struktur kontainer track dan thumb toggle switch dengan padding `p-0.5`, ukuran proporsional `w-11 h-6` (menu induk) dan `w-9 h-5` (sub-bagian), serta pergeseran `translate-x-5` / `translate-x-4` sehingga indikator thumb berada **rapi dan presisi di dalam batas track** tanpa offset/overflow keluar saat aktif (`bg-emerald-600` di kanan) maupun nonaktif (`bg-slate-300` di kiri).
- **Penghapusan Modul yang Tidak Ada (Prestasi Siswa & Ekstrakurikuler) dari Super Admin**:
  - [app/Http/Controllers/Central/TenantController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Central/TenantController.php): Menghapus modul `prestasi` dan `ekstrakurikuler` dari daftar visibilitas Super Admin sesuai changelog pembersihan menu kesiswaan terdahulu (seluruh dokumentasi aktivitas kesiswaan & OSIS telah dilebur ke modul Berita, Agenda, dan Galeri Dokumentasi Resmi).

## [Pemindahan Pengaturan Visibilitas Menu & Rute ke Super Admin (Anti-Slop Vibecoding)] - 2026-10-05

### Added
- **Panel Kontrol Visibilitas Menu & Rute Terpusat di Super Admin**:
  - [app/Http/Controllers/Central/TenantController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Central/TenantController.php): Menambahkan method `show()` yang memuat konfigurasi `pengaturan_fitur` & `menus` database tenant, serta method `toggleMenu()` dengan dynamic tenant connection switcher dan cascading sub-sections (profil, sejarah, visi misi, struktur, guru/staf, program keahlian, berita, agenda, pengumuman, galeri, fasilitas, prestasi, ekskul, spmb, kontak).
  - [resources/views/central/tenants/show.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/central/tenants/show.blade.php): Menambahkan kartu kontrol visibilitas menu interaktif dengan Alpine.js toggle switch, indikator loading spinner (anti-freeze), feedback status, dan sub-komponen cascading.
  - [routes/web.php](file:///d:/databaru/Magang/website_sekolah/routes/web.php): Mendaftarkan rute `PATCH /superadmin/tenants/{tenant}/toggle-menu` (`superadmin.tenants.toggle-menu`).
  - [tests/Feature/SuperAdminAuthTest.php](file:///d:/databaru/Magang/website_sekolah/tests/Feature/SuperAdminAuthTest.php): Menambahkan feature test komprehensif untuk pengujian kontrol visibilitas menu tenant oleh Super Admin.

### Changed
- **Sinkronisasi Otomatis Panel Admin Sekolah dengan Kontrol Visibilitas Super Admin**:
  - [resources/views/layouts/tenant_admin.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/tenant_admin.blade.php): Seluruh menu navigasi sidebar admin sekolah (Profil, GTK, Program Keahlian, Berita, Pengumuman, Agenda, Galeri, Fasilitas) kini otomatis disembunyikan jika dimatikan oleh Super Admin melalui `\App\Models\Tenant\PengaturanFitur::isAktif()`. Accordion "Informasi Sekolah" dan header "Konten Portal" otomatis disembunyikan jika semua sub-menunya nonaktif.
  - [resources/views/layouts/public.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/public.blade.php): Menyelaraskan seluruh 5 sub-menu Informasi (`/berita`, `/pengumuman`, `/agenda`, `/galeri`, `/fasilitas`) pada `menuFeatureMap` navbar publik sehingga otomatis muncul atau disembunyikan sesuai status sakelar Super Admin.
  - [resources/views/tenant/admin/profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php): Tab sub-halaman *Sejarah* dan *Visi, Misi & Tujuan* otomatis disembunyikan jika dimatikan oleh Super Admin.
  - [resources/views/tenant/admin/gtk/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/gtk/index.blade.php): Tab sub-halaman *Struktur Organisasi* dan *Guru & GTK* otomatis disembunyikan jika dimatikan oleh Super Admin.

### Removed
- **Pembersihan Modul Visibilitas dari Panel Admin Sekolah**:
  - [resources/views/tenant/admin/profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php): Menghapus tombol tab `5. Visibilitas Menu & Rute`, modal konfirmasi, dan method JS toggle.
  - [resources/views/tenant/admin/jurusan/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/index.blade.php): Menghapus tombol tab `4. Visibilitas Menu & Rute`, include partial blade, dan method JS toggle.
  - [resources/views/tenant/admin/informasi/berita.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/berita.blade.php): Menghapus tab & container `4. Visibilitas Menu`.
  - [resources/views/tenant/admin/informasi/pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/pengumuman.blade.php): Menghapus tab & container `3. Visibilitas Menu`.
  - [resources/views/tenant/admin/informasi/agenda.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/agenda.blade.php): Menghapus tab & container `3. Visibilitas Menu`.
  - [resources/views/tenant/admin/informasi/galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/galeri.blade.php): Menghapus tab & container `Visibilitas Menu`.
  - [resources/views/tenant/admin/informasi/fasilitas.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/fasilitas.blade.php): Menghapus tab & container `4. Visibilitas Menu`.
  - Menghapus berkas view usang `resources/views/tenant/admin/profil/tabs/tab-visibilitas.blade.php` dan `resources/views/tenant/admin/jurusan/tabs/tab-visibilitas.blade.php`.


## [Standarisasi Tombol Pencarian & Fitur Toggle Mode Tampilan Tabel / Grid di Admin (Anti-Slop Vibecoding)] - 2026-10-05

### Added
- **Fitur Switcher Tampilan Tabel & Grid (`viewMode: 'list' | 'grid'`) di Seluruh Modul Admin**:
  - [resources/views/tenant/admin/informasi/galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/galeri.blade.php): Menambahkan switcher mode tampilan Grid 6-kolom vs Tabel terstruktur lengkap dengan kolom Nomor, thumbnail cover, statistik media, tanggal kegiatan, status visibilitas, dan menu aksi cepat.
  - [resources/views/tenant/admin/informasi/fasilitas.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/fasilitas.blade.php): Menambahkan switcher mode tampilan Grid 6-kolom vs Tabel terstruktur sarpras fasilitas pembelajaran lengkap dengan kolom Nomor, thumbnail, kapasitas, lokasi/gedung, status kondisi, dan menu aksi cepat.
  - [resources/views/tenant/admin/informasi/berita.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/berita.blade.php): Menambahkan tombol switcher mode tampilan Tabel vs Grid serta kolom Nomor, kartu grid artikel berita lengkap dengan badge kategori, ambient blur backdrop, status publikasi, dan menu aksi cepat.
  - [resources/views/tenant/admin/informasi/pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/pengumuman.blade.php): Menambahkan switcher mode tampilan Tabel vs Grid serta kolom Nomor dan thumbnail gambar sampul/surat resmi pada tabel dan kartu grid edaran resmi.
  - [resources/views/tenant/admin/informasi/agenda.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/agenda.blade.php): Menambahkan switcher mode tampilan Tabel vs Grid serta kartu grid jadwal kegiatan/agenda sekolah.
  - [resources/views/tenant/admin/jurusan/tabs/tab-jurusan.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/tabs/tab-jurusan.blade.php): Menambahkan switcher mode tampilan Tabel vs Grid serta kolom Nomor urut dan kartu grid katalog program keahlian dengan info kaprog.
  - [resources/views/tenant/admin/gtk/tabs/tab-guru.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/gtk/tabs/tab-guru.blade.php): Menambahkan switcher mode tampilan Tabel vs Grid 6-kolom serta kolom Nomor untuk direktori guru & tenaga kependidikan.
  - [resources/views/tenant/admin/media/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/media/index.blade.php): Menambahkan kolom Nomor urut pada tabel daftar berkas pustaka media.

### Fixed
- **Konsistensi Tombol Pencarian & Kolom Nomor Seluruh Modul Admin (Anti-Slop Vibecoding)**:
  - [resources/views/tenant/admin/informasi/berita.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/berita.blade.php): Menyelaraskan tombol pencarian dengan teks baku "Cari" dan tombol "Reset" serta menyertakan kolom Nomor pada tabel.
  - [resources/views/tenant/admin/informasi/pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/pengumuman.blade.php): Menyelaraskan tombol pencarian dengan teks baku "Cari", tombol "Reset", serta menampilkan thumbnail gambar surat resmi dan kolom Nomor pada tabel dan grid.
  - [resources/views/tenant/admin/gtk/tabs/tab-guru.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/gtk/tabs/tab-guru.blade.php): Menyeragamkan kolom Nomor urut pada tabel data guru & PTK.
  - [resources/views/tenant/admin/jurusan/tabs/tab-jurusan.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/tabs/tab-jurusan.blade.php): Menyeragamkan header kolom Nomor urut pada tabel program keahlian.
  - [resources/views/tenant/admin/informasi/galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/galeri.blade.php): Menyeragamkan kolom Nomor pada tabel daftar album.
  - [resources/views/tenant/admin/informasi/fasilitas.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/fasilitas.blade.php): Menyeragamkan kolom Nomor pada tabel daftar sarana prasarana.
  - [resources/views/tenant/admin/media/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/media/index.blade.php): Menyeragamkan kolom Nomor pada tabel pustaka media.

## [Penyeragaman Rasio & Ukuran Grid Foto Galeri & Fasilitas 100% Identik Manajemen Media] - 2026-10-05

### Changed
- **Standardisasi Grid 6-Kolom (`grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4`) & Kartu Compact Persegi 1:1**:
  - [resources/views/tenant/admin/informasi/galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/galeri.blade.php): Menyeragamkan grid album dan grid item media dokumentasi menjadi layout 6-kolom dengan kartu compact `aspect-square`, hover overlay action button, dan ambient blur backdrop identik dengan Manajemen Media.
  - [resources/views/tenant/admin/informasi/fasilitas.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/fasilitas.blade.php): Menyeragamkan grid sarpras fasilitas menjadi layout 6-kolom dengan kartu compact `aspect-square`, hover overlay action button, dan ambient blur backdrop identik dengan Manajemen Media.
  - [resources/views/tenant/admin/informasi/agenda.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/agenda.blade.php): Memindahkan inisialisasi route ke objek config `routes` pada Alpine.js.

## [Perbaikan Blade Syntax & Pembersihan Directives JS / CSS Linter] - 2026-10-05

### Fixed
- **Pembersihan Blade Directives di Alpine.js Script ([resources/views/tenant/admin/jurusan/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/index.blade.php))**:
  - Memindahkan inisialisasi `@js(...)` ke atribut HTML `x-data` config dan mengonsumsi `config.totalJurusan`, `config.nextUrutan`, serta `config.routes` langsung dari dalam script Alpine untuk mencegah error parser JS.
- **Standarisasi Directive `@style` pada Elemen Gambar dengan Smart Crop & Hero Banner**:
  - Mengganti atribut inline `style="{{ ... }}"` dengan Blade directive `@style(...)` pada [resources/views/public/pages/berita.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/berita.blade.php), [resources/views/public/pages/galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/galeri.blade.php), [resources/views/public/pages/jurusan.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/jurusan.blade.php), [resources/views/public/home.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/home.blade.php), [resources/views/public/pages/guru.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/guru.blade.php), [resources/views/public/pages/pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/pengumuman.blade.php), [resources/views/public/pages/jurusan_detail.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/jurusan_detail.blade.php), dan [resources/views/tenant/admin/jurusan/tabs/tab-jurusan.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/tabs/tab-jurusan.blade.php).

## [Standarisasi Penuh CSS & Modal Manajemen Media serta Media Picker (Anti-Slop Vibecoding)] - 2026-10-05

### Changed
- **Standardisasi Modul Manajemen Media & Modal Picker Terpusat**:
  - [resources/views/tenant/admin/media/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/media/index.blade.php): Mengintegrasikan seluruh komponen tabel, sticky bar, modal upload, modal impor URL, modal rename informasi berkas, modal crop framing live, dan modal dialog konfirmasi hapus menggunakan class semantik terpusat (`.admin-sticky-bar`, `.admin-modal-overlay`, `.admin-modal-card`, `.admin-form-label`, `.admin-form-input`, `.admin-btn-save`, `.admin-btn-cancel`, `.admin-badge-*`).
  - [resources/views/tenant/admin/media/picker-modal.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/media/picker-modal.blade.php): Menstandarisasikan dialog pemilih pustaka media (`.admin-modal-overlay`, `.admin-modal-card`, `.admin-btn-save`, `.admin-btn-cancel`, `.admin-form-input`) agar 100% serasi dengan modul pengaturan lainnya.

## [Penyeragaman Rasio Foto & Video Galeri serta Sarana Prasarana] - 2026-10-05

### Changed
- **Standardisasi Rasio Aspek Foto & Media (4:3 Landscape)**:
  - [resources/views/public/pages/galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/galeri.blade.php): Menyeragamkan rasio kartu foto & video dokumentasi ke rasio `aspect-4/3` sehingga sejajar dan serasi dengan tampilan katalog sarana & fasilitas (`fasilitas.blade.php`).
  - [resources/views/tenant/admin/informasi/galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/galeri.blade.php): Menyeragamkan cover album ke rasio `aspect-4/3` yang identik dengan kartu fasilitas admin.

## [Penyatuan CSS & Standarisasi Sticky Bar Modul Pusat Manajemen Media (Anti-Slop Vibecoding)] - 2026-10-05

### Changed
- **Refactoring Modul Manajemen Media ([resources/views/tenant/admin/media/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/media/index.blade.php))**:
  - Menerapkan `.admin-sticky-bar`, `.admin-sticky-container`, `.admin-btn-save` (Unggah Berkas), dan `.admin-btn-cancel` (Impor URL/YT) pada header atas.
  - Memastikan keselarasan token warna dan class semantik terpadu dari `resources/css/admin-panel.css`.

## [Penyatuan CSS & Standarisasi Sticky Bar Modul Tema & Warna Sekolah (Anti-Slop Vibecoding)] - 2026-10-05

### Changed
- **Refactoring Modul Tema & Warna ([resources/views/tenant/admin/pengaturan/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/pengaturan/index.blade.php))**:
  - Menerapkan `.admin-sticky-bar`, `.admin-sticky-container`, dan `.admin-btn-save` di bar navigasi atas.
  - Menghapus tombol simpan duplikat di bagian bawah form.
  - Memanfaatkan class semantik `.admin-card`, `.admin-card-header`, `.admin-card-title`, `.admin-card-subtitle` dari `resources/css/admin-panel.css`.

## [Penyatuan CSS & Standarisasi Class Semantik Seluruh Modul Informasi Sekolah (Anti-Slop Vibecoding)] - 2026-10-05

### Changed
- **Refactoring Modul Informasi Sekolah ([resources/views/tenant/admin/informasi/](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/))**:
  - Menghapus CSS inline Quill.js lokal di modul Berita, Pengumuman, dan Agenda untuk memanfaatkan stylesheet Quill global dari `resources/css/admin-panel.css`.
  - [pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/pengumuman.blade.php): Menggunakan `.admin-sticky-bar`, `.admin-sticky-container`, `.admin-tab-nav`, `.admin-tab-pill-*`, `.admin-btn-save`, `.admin-btn-create`, `.admin-btn-cancel`.
  - [berita.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/berita.blade.php): Menggunakan `.admin-sticky-bar`, `.admin-sticky-container`, `.admin-tab-nav`, `.admin-tab-pill-*`, `.admin-btn-save`, `.admin-btn-create`, `.admin-btn-cancel`.
  - [agenda.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/agenda.blade.php): Menggunakan `.admin-sticky-bar`, `.admin-sticky-container`, `.admin-tab-nav`, `.admin-tab-pill-*`, `.admin-btn-save`, `.admin-btn-create`, `.admin-btn-cancel`.
  - [galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/galeri.blade.php): Menggunakan `.admin-sticky-bar`, `.admin-sticky-container`, `.admin-tab-nav`, `.admin-tab-pill-*`, `.admin-btn-save`, `.admin-btn-create`, `.admin-btn-cancel`.
  - [fasilitas.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/fasilitas.blade.php): Menggunakan `.admin-sticky-bar`, `.admin-sticky-container`, `.admin-tab-nav`, `.admin-tab-pill-*`, `.admin-btn-save`, `.admin-btn-create`, `.admin-btn-cancel`.

## [Penyatuan CSS & Standarisasi Class Semantik Modul Program Keahlian / Jurusan (Anti-Slop Vibecoding)] - 2026-10-05

### Changed
- **Refactoring Modul Program Keahlian ([resources/views/tenant/admin/jurusan/](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/))**:
  - Menghapus CSS inline Quill.js lokal dan menggunakan konfigurasi Quill global dari `resources/css/admin-panel.css`.
  - [index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/index.blade.php): Menggunakan `.admin-sticky-bar`, `.admin-sticky-container`, `.admin-tab-nav`, `.admin-tab-pill-*`, `.admin-btn-save`, `.admin-btn-create`, dan `.admin-btn-cancel`.
  - [tabs/tab-jurusan.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/tabs/tab-jurusan.blade.php): Menggunakan `.admin-card`, `.admin-card-header`, `.admin-table`, `.admin-badge-*`, dan `.admin-btn-action`.
  - [tabs/tab-form-jurusan.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/tabs/tab-form-jurusan.blade.php): Menggunakan `.admin-card`, `.admin-card-header`, `.admin-card-title`, `.admin-card-subtitle`, `.admin-form-label`, `.admin-form-input`, `.admin-form-helper`, dan `.admin-btn-save`.
  - [tabs/tab-hero.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/tabs/tab-hero.blade.php): Menggunakan `.admin-card`, `.admin-form-label`, `.admin-form-input`, `.admin-btn-action`.
  - [tabs/tab-visibilitas.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/tabs/tab-visibilitas.blade.php): Menggunakan `.admin-card`, `.admin-table`, `.admin-badge-*`.
  - [tabs/modals.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/tabs/modals.blade.php): Menggunakan `.admin-modal-overlay`, `.admin-modal-card`, `.admin-btn-cancel`.

## [Penyatuan CSS & Standarisasi Class Semantik Modul Struktur Organisasi & GTK (Anti-Slop Vibecoding)] - 2026-10-05

### Added
- **Ekstensi CSS Terpadu (`resources/css/admin-panel.css`)**:
  - Menambahkan styling class semantik komponen tabel admin: `.admin-table`, `.admin-table-thead`, `.admin-table-th`, `.admin-table-td`, `.admin-table-row`.
  - Menambahkan styling badge status & filter: `.admin-badge-success`, `.admin-badge-slate`, `.admin-badge-primary`.
  - Menambahkan styling modal dialog admin: `.admin-modal-card`, `.admin-modal-header`.
  - Menambahkan tombol aksi kustom: `.admin-btn-action`.

### Changed
- **Refactoring Modul Struktur Organisasi & Direktori GTK ([resources/views/tenant/admin/gtk/](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/gtk/))**:
  - [index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/gtk/index.blade.php): Menggunakan `.admin-sticky-bar`, `.admin-sticky-container`, `.admin-tab-nav`, `.admin-tab-pill-*`, dan `.admin-btn-save` / `.admin-btn-action`.
  - [tabs/tab-struktur.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/gtk/tabs/tab-struktur.blade.php): Menggunakan `.admin-card`, `.admin-card-header`, `.admin-card-title`, `.admin-card-subtitle`, `.admin-form-label`, `.admin-form-input`, `.admin-table`, dan `.admin-badge-primary`.
  - [tabs/tab-guru.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/gtk/tabs/tab-guru.blade.php): Menggunakan `.admin-card`, `.admin-form-label`, `.admin-form-input`, `.admin-table`, dan `.admin-badge-*`.
  - [tabs/modals.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/gtk/tabs/modals.blade.php): Menggunakan `.admin-modal-card`, `.admin-modal-header`, `.admin-form-label`, `.admin-form-input`, `.admin-btn-cancel`, dan `.admin-btn-save`.

## [Pemisahan CSS Admin & Standarisasi Class Semantik Profil Sekolah (Anti-Slop Vibecoding)] - 2026-10-05

### Added
- **Arsitektur CSS Terpisah Admin (`resources/css/admin-panel.css`)**:
  - Dibuat berdasarkan skill `antislop-vibecoding-frontend` (FE-03: Centralized Design Tokens & Clean Architecture) dan `antislop-vibecoding-uiux` (UX-01, UX-05, UX-08).
  - Menyediakan token warna shade ramp primer (`--admin-primary-*`), slate scale (`--admin-slate-*`), status notification palette (`--admin-success-*`, `--admin-danger-*`, dll), serta sizing scale (`--admin-radius-*`).
  - Menyediakan class semantik terstandarisasi:
    - Navigasi & Sticky Bar: `.admin-sticky-bar`, `.admin-sticky-container`, `.admin-tab-nav`, `.admin-tab-pill`, `.admin-tab-pill-active`, `.admin-tab-pill-inactive`.
    - Tombol Aksi: `.admin-btn-save`, `.admin-btn-cancel`, `.admin-btn-create`, `.admin-btn-action`.
    - Kartu & Kontainer: `.admin-card`, `.admin-card-header`, `.admin-card-title`, `.admin-card-subtitle`.
    - Form Elements: `.admin-form-label`, `.admin-form-input`, `.admin-form-helper`.
    - WYSIWYG & Rich Text: Styling global Quill editor (`.admin-quill-wrapper`, `.ql-toolbar`, `.ql-container`).

### Changed
- **Integrasi Asset Build**:
  - Menambahkan `resources/css/admin-panel.css` ke array input [vite.config.js](file:///d:/databaru/Magang/website_sekolah/vite.config.js).
  - Menambahkan pemanggilan `@vite(['resources/css/app.css', 'resources/css/admin-panel.css', 'resources/js/app.js'])` di layout utama admin [resources/views/layouts/tenant_admin.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/tenant_admin.blade.php).
- **Refactoring Modul Pengaturan Profil Sekolah**:
  - Menghapus blok `<style>` lokal di [resources/views/tenant/admin/profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php).
  - Mengganti seluruh class ad-hoc pada seluruh tab profil ([tab-datadiri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/tabs/tab-datadiri.blade.php), [tab-visimisi.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/tabs/tab-visimisi.blade.php), [tab-sejarah.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/tabs/tab-sejarah.blade.php), [tab-profil.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/tabs/tab-profil.blade.php), dan [tab-visibilitas.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/tabs/tab-visibilitas.blade.php)) menggunakan class semantik `.admin-*` yang selaras.

## [Standardisasi Sticky Tab Bar & Top Save Button di Seluruh Pengaturan Admin] - 2026-10-05

### Changed
- **Standardisasi Sticky Tab Bar & Top Save Action di Semua Modul Admin**:
  - Menerapkan bar navigasi tab **`sticky top-16 z-30`** dengan efek `backdrop-blur-md` dan background kontras di seluruh modul pengaturan admin sekolah:
    1. **Profil Sekolah** ([resources/views/tenant/admin/profil/](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/))
    2. **Program Keahlian / Jurusan** ([resources/views/tenant/admin/jurusan/](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/))
    3. **Struktur & GTK** ([resources/views/tenant/admin/gtk/](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/gtk/))
    4. **Pengumuman Resmi** ([resources/views/tenant/admin/informasi/pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/pengumuman.blade.php))
    5. **Berita & Artikel** ([resources/views/tenant/admin/informasi/berita.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/berita.blade.php))
    6. **Agenda & Kegiatan** ([resources/views/tenant/admin/informasi/agenda.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/agenda.blade.php))
    7. **Galeri & Dokumentasi** ([resources/views/tenant/admin/informasi/galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/galeri.blade.php))
    8. **Sarana & Fasilitas** ([resources/views/tenant/admin/informasi/fasilitas.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/fasilitas.blade.php))
  - **Tombol Simpan / Aksi Utama di Sebelah Kanan Atas Bar Tab**: Tombol aksi dinamis berubah sesuai tab yang sedang aktif (misal: tombol *Simpan Hero*, tombol *Terbitkan / Perbarui*, tombol *[+] Buat Baru*, tombol *Batal*).
  - **Pembersihan Tombol Bawah**: Menghapus seluruh tombol simpan/submit di bagian bawah form agar tampilan tidak redundant (hanya ada 1 tombol simpan yang selalu terlihat di atas saat scroll).
  - **Alpine.js Dynamic Submitter**: Mengintegrasikan method `submitActiveForm(formId)` yang menangani validasi native HTML5 form (`reportValidity()`), sinkronisasi konten Quill.js WYSIWYG, dan indikator loading state.

## [Mode Form Tambah Baru & Edit Program Keahlian] - 2026-10-05

### Changed
- **Mode Form Tambah Baru & Edit Jurusan ([resources/views/tenant/admin/jurusan/](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/))**:
  - Mengatur default state `jurusanForm` sebagai **Form Tambah Program Keahlian Baru** yang bersih dan siap diisi.
  - Tab 2 secara default menampilkan label **"2. Form Program Keahlian"** untuk penambahan data baru.
  - Saat pengguna mengklik tombol *"Edit"* pada salah satu jurusan di tabel Tab 1, tab akan beralih ke mode edit (**"2. Edit: [Nama Jurusan]"**).
  - Menambahkan tombol cepat **"Form Tambah Baru (+)"** di header tab form agar admin dapat dengan mudah beralih dari mode edit ke mode tambah kapan saja tanpa harus reload halaman.

## [Sticky Tab Bar & Top Save Button Pengaturan Profil Sekolah] - 2026-10-05

### Changed
- **Sticky Tab Bar & Pembersihan Tombol Simpan Bawah ([resources/views/tenant/admin/profil/](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/))**:
  - Mengubah navigation bar tab profil sekolah menjadi **`sticky top-16`** dengan efek glassmorphism `backdrop-blur-md` dan background kontras.
  - Menempatkan **satu Tombol Simpan Utama di Sebelah Kanan Atas Bar Tab** yang dinamis sesuai tab aktif.
  - **Menghapus seluruh tombol submit duplikat di bagian bawah** masing-masing tab (`tab-datadiri.blade.php`, `tab-profil.blade.php`, `tab-sejarah.blade.php`, dan `tab-visimisi.blade.php`) agar antarmuka bersih dan tidak membingungkan pengguna.
  - Mengintegrasikan sinkronisasi Quill.js WYSIWYG otomatis saat tombol simpan di atas diklik via Alpine.js (`submitActiveForm`).

## [Penyederhanaan & Pemolesan Tampilan Pengumuman Resmi (Admin & Publik)] - 2026-10-05

### Changed
- **Penyederhanaan Form Admin Pengumuman ([resources/views/tenant/admin/informasi/pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/pengumuman.blade.php))**:
  - Menyederhanakan formulir input pengumuman agar fokus pada 3 elemen esensial: **Judul Pengumuman**, **Gambar/Foto Surat Resmi**, dan **Isi Pengumuman** (WYSIWYG), ditambah status publikasi & tanggal.
  - Menghilangkan field ringkasan manual yang redundan agar admin sekolah tidak perlu bekerja dua kali.
- **Polesan Desain Publik Pengumuman ([resources/views/public/pages/pengumuman_detail.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/pengumuman_detail.blade.php) & [pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/pengumuman.blade.php))**:
  - Menerapkan skill **`antislop`** dan **`antislop-ui`**: antarmuka terstruktur, tipografi Plus Jakarta Sans, bebas dari AI slop, dan berstandar Tailgrids.
  - Menghapus mockup kop surat & tanda tangan tiruan, digantikan dengan container dokumen surat resmi berkualitas tinggi.
  - Menambahkan interactive **Lightbox Preview Modal (Alpine.js)** pada detail surat pengumuman sehingga surat edaran yang discan dapat dizoom layar penuh dan diunduh langsung dengan jelas oleh orang tua/wali dan siswa.
  - Listing pengumuman dilengkapi live search, badge kategori resmi, thumbnail surat terformat, dan empty state yang humanis.

## [Pemisahan Modul Mandiri Struktur & GTK di Sidebar Admin] - 2026-10-05

### Added
- **Modul Mandiri Struktur Organisasi & Guru Tenaga Kependidikan (GTK) ([app/Http/Controllers/Tenant/Admin/GtkController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/GtkController.php))**:
  - Menyediakan menu sidebar mandiri **Struktur & GTK** (`/{tenant}/admin/gtk`) dengan 2 sub-tab navigasi terpadu:
    1. **Struktur Organisasi**: Kustomisasi judul & banner hero publik, bagan diagram visual struktur hierarki organisasi, serta CRUD data pejabat struktural berelasi ke Guru & Staf.
    2. **Guru & Tenaga Kependidikan**: Kustomisasi hero banner publik `/guru-staf` dan manajemen data master pendidik dan tenaga kependidikan (PTK).
  - Tampilan admin Blade terpisah di [resources/views/tenant/admin/gtk/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/gtk/index.blade.php) beserta sub-komponen `tab-struktur.blade.php`, `tab-guru.blade.php`, dan `modals.blade.php`.
  - Feature test otomatis di [tests/Feature/TenantAdminGtkTest.php](file:///d:/databaru/Magang/website_sekolah/tests/Feature/TenantAdminGtkTest.php) (5 skenario pengujian - 100% Passed).

### Changed
- **Penyederhanaan Halaman Profil Sekolah ([resources/views/tenant/admin/profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**:
  - Mengeluarkan tab *5. Struktur Organisasi* dan *6. Guru & Tenaga Kependidikan* dari halaman Profil Sekolah.
  - Halaman Profil Sekolah kini memiliki 5 tab fokus: 1. Data Diri Sekolah, 2. Profil Lengkap, 3. Sejarah Sekolah, 4. Visi, Misi & Tujuan, 5. Visibilitas Menu & Rute.
- **Navigasi Sidebar Admin ([resources/views/layouts/tenant_admin.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/tenant_admin.blade.php))**:
  - Menambahkan link navigasi sidebar **Struktur & GTK** dengan icon hierarki organisasi yang elegan di bawah Profil Sekolah.

## [Reposisi Pengaturan Hero Banner di Seluruh Modul Informasi Sekolah] - 2026-10-05

### Changed
- **Penyatuan Pengaturan Hero Banner ke Tab Utama Daftar Modul Informasi ([berita.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/berita.blade.php), [pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/pengumuman.blade.php), [agenda.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/agenda.blade.php), [galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/galeri.blade.php), [fasilitas.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/fasilitas.blade.php))**:
  - Memindahkan card form kustomisasi Hero Banner halaman publik ke bagian atas card daftar tabel/item pada tab utama (Tab 1) di seluruh 5 modul Informasi Sekolah.
  - Menghapus tab navigasi pill *Hero Banner Publik* terpisah agar alur kerja admin lebih ringkas, terpadu, dan efisien tanpa perlu berpindah tab.
  - Menyesuaikan penomoran dan urutan pill navigasi tab di seluruh halaman terkait.

## [Modul CMS Informasi Sekolah Terpadu (Sidebar Multi-Navigasi 5 Sub-Modul)] - 2026-10-01

### Added
- **Modul Pengaturan Informasi Sekolah CMS ([app/Http/Controllers/Tenant/Admin/InformasiController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/InformasiController.php))**:
  - Menyediakan 5 panel navigasi terpisah yang mencakup seluruh kebutuhan publik:
    1. **Berita & Artikel Sekolah** (`/berita`): CRUD berita, editor WYSIWYG Quill.js, filter kategori & status, pencarian, kustomisasi hero banner publik, dan sakelar visibilitas fitur.
    2. **Pengumuman Resmi Sekolah** (`/pengumuman`): CRUD pengumuman resmi, filter status publikasi, kustomisasi hero banner publik, dan sakelar visibilitas fitur.
    3. **Kalender & Agenda Kegiatan** (`/agenda`): Manajemen agenda mendatang/riwayat, tanggal mulai/selesai, jam pelaksanaan, lokasi, penyelenggara, tautan pendaftaran/konfirmasi daring eksternal, hero banner, dan visibilitas fitur.
    4. **Galeri Foto & Video** (`/galeri`): Manajemen album galeri (tipe foto/video), cover album, manajemen item media/YouTube dalam album, hero banner, dan visibilitas fitur.
    5. **Sarana & Fasilitas Sekolah** (`/fasilitas`): Manajemen katalog ruangan/bengkel (foto utama rasio 4:3, multi-foto tambahan repeater), counter statistik sarpras (ruang kelas teori, bengkel lab, perpustakaan, akses internet), hero banner, dan visibilitas fitur.
- **Sidebar Admin Multi-Navigasi Collapsible ([resources/views/layouts/tenant_admin.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/tenant_admin.blade.php))**:
  - Mengimplementasikan grup navigasi *Informasi Sekolah* dengan accordion Alpine.js dan 5 sub-navigasi independen sesuai preferensi arsitektur navigasi.
- **Views Admin Blade Reusable Tailgrids Pattern**:
  - [resources/views/tenant/admin/informasi/berita.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/berita.blade.php)
  - [resources/views/tenant/admin/informasi/pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/pengumuman.blade.php)
  - [resources/views/tenant/admin/informasi/agenda.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/agenda.blade.php)
  - [resources/views/tenant/admin/informasi/galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/galeri.blade.php)
  - [resources/views/tenant/admin/informasi/fasilitas.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/fasilitas.blade.php)
- **Rute Admin & Feature Test Pest**:
  - Rute admin di bawah prefix `{tenant}/admin/informasi/*` di [routes/web.php](file:///d:/databaru/Magang/website_sekolah/routes/web.php).
  - Test suite komprehensif di [tests/Feature/TenantAdminInformasiTest.php](file:///d:/databaru/Magang/website_sekolah/tests/Feature/TenantAdminInformasiTest.php) (7 skenario pengujian - 100% Passed).

### Changed
- **Penyelarasan Konsistensi UI & Arsitektur Blade 100% Seragam (Standar Admin Profil & Jurusan)**:
  - Melakukan refaktorisasi menyeluruh pada 5 sub-modul Informasi Sekolah (`agenda.blade.php`, `galeri.blade.php`, `fasilitas.blade.php`, `berita.blade.php`, `pengumuman.blade.php`).
  - Menyeragamkan seluruh token desain:
    1. **Tab Navigation Pills**: Menggunakan class standar `px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 shrink-0 cursor-pointer` (Aktif: `bg-blue-600 text-white shadow-xs` | Inaktif: `bg-white text-slate-600 hover:bg-slate-100 border border-slate-200`).
    2. **Container Card**: Seluruh pembungkus form dan tabel memakai `bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4` (atau `space-y-5`).
    3. **Header Card**: Judul kartu menggunakan `text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5` dengan subjudul `text-xs text-slate-500`.
    4. **Input, Select, & Textarea Form**: Menggunakan label `block text-xs font-bold text-slate-700 mb-1` dan input `w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition`.
    5. **Tombol Form & Media Picker**: Tombol simpan `px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center gap-2 cursor-pointer`, tombol media picker `px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer`.
    6. **Toast & Modal Dialog**: Toast di kanan bawah `fixed bottom-5 right-5 z-50 text-white px-5 py-3.5 rounded-2xl shadow-xl flex items-center gap-3 max-w-md` (`bg-emerald-600` / `bg-rose-600`) dan modal konfirmasi hapus kustom `bg-slate-900/60 backdrop-blur-xs`.

## [Pembersihan Menu Publik Kesiswaan & Sinkronisasi Navigasi] - 2026-10-01

### Removed
- **Menu Navigasi Publik Kesiswaan & Sub-menu ([database/migrations/2026_10_01_142634_delete_kesiswaan_menu_and_submenus_from_tenant_menus.php](file:///d:/databaru/Magang/website_sekolah/database/migrations/2026_10_01_142634_delete_kesiswaan_menu_and_submenus_from_tenant_menus.php))**:
  - Menghapus menu dropdown publik `Kesiswaan` beserta ketiga sub-menunya (`Prestasi Siswa`, `Ekstrakurikuler`, `OSIS & MPK`) dari tabel `menus` di seluruh database tenant sesuai instruksi (informasi dan dokumentasi OSIS/kesiswaan diarahkan masuk ke modul Berita, Agenda, dan Galeri Dokumentasi Resmi).
  - Menghapus view statis [osis.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/osis.blade.php), helper method `PageController@osis`, dan grup route alias `/{tenant}/kesiswaan/*` di [routes/web.php](file:///d:/databaru/Magang/website_sekolah/routes/web.php).
  - Memperbarui seeder [TenantSmkn2BandungSeeder.php](file:///d:/databaru/Magang/website_sekolah/database/seeders/TenantSmkn2BandungSeeder.php) dan [TenantDummySeeder.php](file:///d:/databaru/Magang/website_sekolah/database/seeders/TenantDummySeeder.php) agar urutan menu navbar tetap rapi dan konsisten.

### Changed
- **Penyelarasan Dokumentasi Rute ([docs/04-ROUTES-OR-API.md](file:///d:/databaru/Magang/website_sekolah/docs/04-ROUTES-OR-API.md))**: Memperbarui tabel rute dan catatan integrasi konten kesiswaan.

### Added
- **Modul Pengaturan Program Keahlian Admin CMS ([resources/views/tenant/admin/jurusan/](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/))**: Tab Katalog Program Keahlian (CRUD + FK `guru_staf`), Tab Hero Banner, Tab Visibilitas Menu & Rute, serta integrasi Media Picker.
- **Controller Admin Jurusan ([JurusanController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/JurusanController.php))**: Manajemen CRUD, upload media, dan toggle status aktif jurusan & feature flag.
- **Sidebar Admin Link ([tenant_admin.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/tenant_admin.blade.php))**: Menambahkan link menu Program Keahlian.
- **Automated Feature Testing ([TenantAdminJurusanTest.php](file:///d:/databaru/Magang/website_sekolah/tests/Feature/TenantAdminJurusanTest.php))**: 4 skenario test lengkap (100% Passed).

## [Layout Adaptif Halaman Profil Publik & Sinkronisasi Cascade 2 Arah] - 2026-09-30

### Fixed
- **Layout Adaptif Halaman Profil Publik ([resources/views/public/pages/profil.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/profil.blade.php))**:
  - Mengatasi masalah tampilan berantakan / teks menyempit saat fitur *Video Profil Sekolah* dinonaktifkan di admin.
  - Menerapkan layout adaptif elegan: saat video aktif menggunakan 2 kolom responsif (`8 : 4`), dan saat video dinonaktifkan otomatis beralih ke format 1 kolom terpusat (`max-w-4xl mx-auto`) dengan tipografi dan kontainer simetris.

### Added
- **Cascade Toggle Dua Arah (Bidirectional)**:
  - Mengaktifkan kembali sakelar induk (misal: `menu_profil`, `profil`, `struktur_organisasi`) kini otomatis ikut mengaktifkan seluruh sub-menu dan sub-section di bawahnya baik di backend maupun antarmuka reaktif frontend (Alpine.js).
- **Penyelarasan Navigasi Publik dengan Pengaturan Fitur ([layouts/public.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/public.blade.php))**:
  - Navbar desktop & mobile drawer kini secara otomatis memeriksa status `PengaturanFitur` (`menu_profil`, `profil`, `sejarah`, `visi_misi`, `struktur_organisasi`, `guru_staf`, `fasilitas`, dll).
  - Jika sakelar **Menu Utama Profil Sekolah (`menu_profil`)** dinonaktifkan di admin, menu navigasi Profil di header/drawer publik otomatis hilang dan tidak dapat diakses.
  - Sub-menu yang dinonaktifkan juga otomatis disaring keluar dari dropdown.
- **Komponen Parsial Media Picker Reusable ([resources/views/tenant/admin/media/picker-modal.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/media/picker-modal.blade.php))**:
  - Mengekstrak modal Media Picker dari Blade admin profil menjadi komponen terisolasi dan reusable sehingga dapat dipanggil kapan saja di seluruh modul admin via `@include('tenant.admin.media.picker-modal')`.
  - Filter kategori berkas lengkap (`Semua`, `Gambar`, `Video Lokal`, `YouTube`, `Dokumen`) dan fitur impor cepat URL YouTube/Gambar langsung di dalam modal.

## [Modularisasi Blade Tab Profil & Hierarki Bertingkat Visibilitas Menu] - 2026-09-30

### Added
- **Modularisasi Berkas Blade Admin Profil ([resources/views/tenant/admin/profil/tabs/](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/tabs/))**:
  - Memisahkan form admin profil sekolah ke dalam 8 partial Blade (`tab-datadiri.blade.php`, `tab-profil.blade.php`, `tab-sejarah.blade.php`, `tab-visimisi.blade.php`, `tab-struktur.blade.php`, `tab-guru.blade.php`, `tab-visibilitas.blade.php`, dan `modals.blade.php`).
- **Hierarki Visibilitas Bertingkat (Cascade Visibility)**:
  - Tab 7 Visibilitas dirinci hingga level sub-section (Menu Induk Navbar -> Data Diri -> Sambutan Kepsek & Video Profil; Struktur Organisasi -> Bagan Diagram & Daftar Pejabat). Jika parent dimatikan, semua sub-komponen otomatis ikut dinonaktifkan.
- **Verifikasi**:
  - Full Pest Suite: **75 passed (489 assertions)**.

## [Penambahan Tab 6 Guru & Tenaga Kependidikan di Admin Profil] - 2026-09-30

### Added
- **Tab 6: Guru & Tenaga Kependidikan pada Admin Profil ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**:
  - Menambahkan tombol tab navigasi `6. Guru & Tenaga Kependidikan` (`?tab=guru`) dan memperbarui nomor tab visibilitas menjadi `7. Visibilitas Menu & Rute`.
  - **Kartu 1 (Kustomisasi Hero Banner Halaman Guru & Staf)**: Pengaturan judul utama (`judul_guru`), subjudul/deskripsi ringkas (`subjudul_guru`), dan foto latar banner (`gambar_banner_guru`) dengan preview box 16:9 (`bannerGuruPreview`) serta pemilih berkas dari Pusat Media (`openMediaPicker('input_banner_guru')`).
  - **Penerapan Konsep Smart Crop & Ambient Blur Media pada Preview Foto**: Memperbaiki kotak preview Foto Kepala Sekolah, Modal Pejabat Struktural, dan Modal Guru/Staf agar menerapkan `:style="...CropStyle"` (membaca crop zoom & focal position langsung dari Pusat Media) dan efek ambient background `blur-md scale-125 opacity-40 z-0` yang konsisten dengan Media Library.
- **Rute Admin & Controller Guru ([web.php](file:///d:/databaru/Magang/website_sekolah/routes/web.php), [ProfilController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/ProfilController.php))**:
  - Menambahkan endpoint `PUT /admin/profil/guru-hero` (`tenant.admin.profil.guru.hero.update`) untuk pembaruan banner hero `/guru-staf`.
  - Menambahkan rute CRUD `POST /admin/profil/guru`, `PUT /admin/profil/guru/{guru}`, `DELETE /admin/profil/guru/{guru}` (`tenant.admin.profil.guru.*`).
- **Pembaruan Halaman Publik Direktori Guru ([guru.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/guru.blade.php), [PageController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Public/PageController.php))**:
  - Halaman `http://127.0.0.1:8000/{tenant}/guru-staf` kini membaca judul dinamis `$halaman->judul`, subjudul bersyarat `@if(!empty($subjudulGuru))`, dan gambar latar banner hero dengan efek artistik right-side gradient mask.
- **Automated Feature Tests ([TenantAdminProfilTest.php](file:///d:/databaru/Magang/website_sekolah/tests/Feature/TenantAdminProfilTest.php))**:
  - Menambahkan test `admin can update guru-staf hero banner and it displays on public guru-staf page` dan `admin can perform CRUD operations on guru and tenaga kependidikan`.
  - Verifikasi: `vendor/bin/pest` **75 test / 489 assertions PASSED**.

## [Perbaikan Render Bersyarat Subjudul & Sambutan Halaman Publik Profil] - 2026-09-30

### Fixed
- **Penghapusan Fallback Teks Keras jika Field Dikosongkan ([resources/views/public/pages/](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/))**:
  - Memperbaiki `sejarah.blade.php`, `visi-misi.blade.php`, `profil.blade.php`, dan `struktur.blade.php` agar membungkus paragraf subjudul/deskripsi ke dalam `@if(!empty($halaman->subjudul))` / `@if(!empty($profil->subjudul))` murni tanpa fallback string bawaan `?? ('Mengenal perjalanan panjang...')`.
  - Jika admin mengosongkan kolom Subjudul / Deskripsi Hero pada panel admin, portal publik kini benar-benar bersih dan tidak menampilkan teks deskripsi apa pun.
  - Memperbaiki `home.blade.php` dan `HomeController.php` agar Sambutan Kepala Sekolah hanya tampil jika diisi (`@if(!empty($sekolahData['sambutan']))`), dan tidak memunculkan kalimat fallback bawaan saat dikosongkan admin.
  - Verifikasi: `php artisan view:clear` & `vendor/bin/pest` **73 test / 461 assertions PASSED**.

## [Penataan & Penyeragaman Tab 5 Struktur Organisasi Admin Profil] - 2026-09-30

### Changed
- **Restrukturisasi Tab 5 Struktur Organisasi ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**:
  - Memisahkan form Struktur Organisasi menjadi kartu-kartu mandiri berdesain Tailgrids yang konsisten dengan Tab 1 (Data Diri), Tab 2 (Profil Lengkap), Tab 3 (Sejarah), dan Tab 4 (Visi Misi).
  - **Kartu 1 (Kustomisasi Hero Banner)**: Kartu putih terpisah di bagian atas dengan ikon header, input Judul Halaman Struktur, Subjudul/Deskripsi Ringkas, input Foto Banner dengan thumbnail preview box 16:9 (`bannerStrukturPreview`), dan trigger Media Picker.
  - **Kartu 2 (Bagan Diagram Struktur Organisasi)**: Kartu dinamis repeater dengan list bagan hierarki, input judul, deskripsi, thumbnail preview box 16:9 (`diag.gambar`), tombol Pilih Media reaktif, dan tombol Simpan lengkap dengan spinner animasi loading state (`<template x-if="submitLoading">`).
  - **Kartu 3 (Daftar Pejabat Struktural)**: Tabel pejabat dengan avatar 3:4, badge NIP berelasi guru/staf, dan aksi modal Add/Edit/Delete.
  - **Alpine.js `profilManager`**: Menambahkan state `bannerStrukturPreview`, serta mengintegrasikan pemilih media untuk `input_banner_struktur` dan `input_diag_*`.
  - Verifikasi: `vendor/bin/pest` **73 test / 461 assertions PASSED**.

## [Penyeragaman Ukuran Teks & Gaya Input Form Admin Profil] - 2026-09-30

### Changed
- **Seragamkan ukuran teks dan gaya seluruh field admin profil ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**:
  - Label seluruh tab dan modal Pejabat diseragamkan ke `text-xs font-bold text-slate-700 mb-1` - termasuk label hero Struktur Organisasi (sebelumnya `slate-800`), sub-field Media Sosial (sebelumnya `text-[11px] font-semibold text-slate-600`), label Bagan Diagram (sebelumnya `text-[11px]`), dan label Video Profil (sebelumnya `slate-800`).
  - Input/textarea/select diseragamkan ke `px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition` - input Video Profil, hero Struktur Organisasi, dan Bagan Diagram (sebelumnya `bg-white` dan/atau padding `px-3 py-2`) kini sama persis dengan tab lain; varian `focus:ring-1 focus:ring-blue-500` diseragamkan agar identik di semua tab.
  - Teks bantuan (hint) diseragamkan ke `text-[10px] text-slate-400`.
  - Tombol "Pilih Media" pada kartu Bagan Diagram disamakan dengan tombol serupa di kartu lain (`px-3.5 py-2`, ikon 16px, `gap-1.5`).
  - Verifikasi: `php artisan view:cache` sukses kompilasi; `vendor/bin/pest` **73 test / 461 assertions PASSED**.

## [Penerapan Banner Hero Artistik & Pelebaran Judul Halaman Publik] - 2026-09-30

### Added
- **Right-Side Artistic Banner Overlay di Seluruh Menu Publik ([resources/views/public/pages/](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/))**:
  - Mengimplementasikan efek visual banner artistik sisi kanan dengan gradient mask (`[mask-image:linear-gradient(to_left,rgba(0,0,0,1)_20%,rgba(0,0,0,0.6)_60%,transparent_100%)]`) dan theme header overlay ke seluruh halaman menu publik (`sejarah`, `visi-misi`, `struktur`, `profil`, `berita`, `galeri`, `fasilitas`, `jurusan`, `jurusan_detail`, `prestasi`, `ekstrakurikuler`, `guru`, `kontak`, `kurikulum`, `osis`, `kegiatan`, `kalender`, `spmb`).
  
### Changed
- **Pelebaran Container Judul Hero (`max-w-4xl lg:max-w-5xl`)**:
  - Mengubah batas sempit `max-w-2xl` / `max-w-3xl` menjadi `max-w-4xl lg:max-w-5xl` pada seluruh hero section publik, sehingga judul panjang (seperti "Sejarah Panjang SMK Negeri 2 Bandung") tampil utuh dan proporsional dalam satu baris tanpa terpotong kaku ke bawah saat ruang layar mencukupi.

## [Pemisahan Tab 1 Data Diri Sekolah & Tab 2 Profil Lengkap] - 2026-09-30

### Added
- **Tab Khusus "1. Data Diri Sekolah" (Tab `datadiri`) ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**:
  - Memisahkan form Data Pokok Satuan Pendidikan (Nama Sekolah, Slogan, Logo, NPSN, Akreditasi, Tahun Berdiri, No Telepon, Alamat, Email, WhatsApp, Jam Layanan, dan Akun Medsos Resmi) serta Kepala Satuan Pendidikan dan Video Profil ke dalam tab mandiri yang terfokus.
  - Tombol simpan "Simpan Data Diri Sekolah" dengan feedback loading state dan redirect langsung ke tab `?tab=datadiri`.
- **Tab "2. Profil Lengkap" (Tab `identitas`)**:
  - Dikhususkan untuk Kustomisasi Hero Banner Halaman Profil (Judul Utama, Subjudul, Gambar Latar) dan Editor WYSIWYG Uraian Lengkap Profil & Budaya Sekolah.
  - Tombol simpan "Simpan Halaman Profil" dengan feedback loading state dan redirect langsung ke tab `?tab=identitas`.

### Changed
- **Controller Admin Profil ([ProfilController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/ProfilController.php))**:
  - Memperbarui `updateIdentitas()` agar dapat memproses form `datadiri` dan `halaman_profil` secara modular dan independen berdasarkan field `form_type` dan `current_tab`.
- **Test Suite Feature ([TenantAdminProfilTest.php](file:///d:/databaru/Magang/website_sekolah/tests/Feature/TenantAdminProfilTest.php))**:
  - Menambahkan test case untuk verifikasi penyimpanan data diri sekolah dan pembaruan halaman profil secara terpisah.

## [Penyelarasan Layout Tab Profil: Hero di Atas, Input Media Sosial & Editor WYSIWYG Profil] - 2026-09-30

### Added
- **Input Akun Media Sosial Resmi di Tab Profil Admin ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**:
  - Menambahkan input URL media sosial resmi (Instagram, Facebook, YouTube, TikTok, dan X/Twitter) di bawah Data Pokok Sekolah pada Tab 1 (Profil Lengkap).
  - Nilai tersimpan langsung disinkronkan ke footer portal publik lewat kunci `pengaturan_umum` (`instagram`, `facebook`, `youtube`, `tiktok`, `twitter`).
- **Editor Teks Bebas WYSIWYG untuk Uraian Lengkap Profil Sekolah**:
  - Menyediakan editor WYSIWYG Quill pada Tab 1 (Profil Lengkap) yang tersimpan ke tabel `halaman_statis` (slug `profil`, kolom `isi_konten`).
  - Halaman publik profil ([profil.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/profil.blade.php)) otomatis merender bagian kartu "Profil & Budaya Sekolah" jika konten WYSIWYG diisi.

### Changed
- **Pemindahan Kustomisasi Hero Banner ke Bagian Teratas Tab 1 (Profil Lengkap)**:
  - Posisi Hero Banner di Tab 1 kini berada paling atas, seragam dan konsisten dengan tata letak Tab 2 (Sejarah), Tab 3 (Visi & Misi), dan Tab 4 (Struktur Organisasi).
- **Controller Admin Profil ([ProfilController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/ProfilController.php))**:
  - Menambahkan validasi dan penyimpanan array input media sosial serta `isi_konten_profil` pada method `updateIdentitas()`.

## [Kelengkapan Field Hero Banner pada Tab Struktur Organisasi] - 2026-09-30

### Added
- **Field "Judul Halaman Struktur Organisasi" dan "Foto Banner / Sampul Struktur (Pusat Media)" di tab Struktur Organisasi admin ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**: tab Struktur Organisasi kini memiliki tiga field hero yang sama dengan tab Sejarah dan Visi & Misi (Judul Halaman, Deskripsi Ringkas / Subjudul Hero, Foto Banner dengan tombol *Pilih dari Media*). Sebelumnya tab ini hanya punya field subjudul dan judulnya di-hardcode.
- **Penyimpanan judul & banner hero struktur ([ProfilController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/ProfilController.php))**: `updateStruktur()` memvalidasi `judul_struktur` dan `gambar_banner_struktur`, menyinkronkan banner ke Pusat Media lewat `MediaService::sinkronisasiOtomatisUrl()`, lalu menyimpan `judul` dan `gambar_banner` ke tabel `halaman_statis` (slug `struktur`). Sebelumnya `judul` selalu ditimpa `'Struktur Organisasi Sekolah'` dan `gambar_banner` tidak pernah disimpan.
- **Banner halaman publik struktur ([struktur.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/struktur.blade.php))**: gambar banner tampil di bagian atas section konten (rasio baku 21:9, `max-h-[420px]`, `rounded-2xl`) mengikuti pola halaman Sejarah dan Visi & Misi, dan `<title>` halaman kini memakai judul dari admin (`$halaman->judul`).
- **Blok header kartu tab Struktur Organisasi**: judul kartu "Kelola Struktur Organisasi & Data Pejabat" beserta deskripsi singkat, mengikuti pola blok header di tab Sejarah ("Kelola Halaman Sejarah Sekolah") dan Visi & Misi ("Kelola Visi, Misi & Sasaran Mutu") agar konsisten.

### Notes
- Test baru: `tests/Feature/TenantAdminProfilTest.php` - "admin can update struktur hero title, description, and banner and it appears on public page" (verifikasi simpan ke database, relasi `pengguna_id`, dan tampilan judul + banner di halaman publik).
- Verifikasi: full suite Pest **72 test / 453 assertions PASSED**; `vendor/bin/pint --dirty` passed; `php artisan view:clear` dijalankan.


## [Pemindahan Menu Fasilitas Sekolah ke Bagian Informasi] - 2026-09-30

### Changed
- **Menu Navigasi Fasilitas Sekolah Dipindahkan ke Dropdown Informasi**:
  - Item menu *Fasilitas Sekolah* (`/fasilitas`) kini berinduk ke menu *Informasi* (`parent_id = 4`) bukan lagi di *Profil*.
  - Pembaruan disinkronkan ke database tenant aktif (`menus` table) dan seeder (`TenantSmkn2BandungSeeder.php` dan `TenantDummySeeder.php`).
- **Penambahan Alias Rute Sub-prefix `/informasi/fasilitas` ([routes/web.php](file:///d:/databaru/Magang/website_sekolah/routes/web.php))**:
  - Menambahkan rute `Route::get('/fasilitas', [PageController::class, 'fasilitas'])->name('fasilitas');` di dalam grup `Route::prefix('informasi')`.
  - Rute langsung `/{tenant}/fasilitas` tetap aktif sebagai rute utama (`tenant.fasilitas`).

## [Penghapusan Mode Tampilan Struktur & Perbaikan Fatal View Publik Struktur] - 2026-09-30

### Removed & Fixed
- **Kontrol "Mode Pilihan Tampilan Halaman Struktur Publik" dihapus dari tab Struktur Organisasi admin ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**: tiga pilihan radio (`semua` / `pejabat` / `diagram`) dihapus karena tidak dibutuhkan operator sekolah.
- **Kunci `mode_tampilan_struktur` tidak lagi dibaca/ditulis**: dihapus dari `ProfilController::index()` dan `updateStruktur()` (validasi + `PengaturanUmum::updateOrCreate`), dari `Public\PageController::struktur()` (variabel `$modeTampilan` dan data view), serta dari view publik `struktur.blade.php`.
- **Halaman publik `/profil/struktur` selalu menampilkan kedua bagian**: tombol pilih tampilan selalu tampil dengan default tab "Jajaran Pejabat", dan blok "Jajaran Pejabat" serta "Bagan Diagram Struktur" dirender tanpa syarat mode.
- **Perbaikan bug fatal pada view publik struktur ([struktur.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/struktur.blade.php))**: directive `@if($mode === 'semua' || $mode === 'pejabat')` tidak pernah ditutup `@endif`, sehingga hasil kompilasi Blade berakhir dengan fatal parse error `unexpected end of file, expecting "elseif" or "else" or "endif"` (halaman publik struktur gagal dirender). Seluruh directive mode dihapus sehingga view valid; dibuktikan lewat kompilasi Blade + `php -l` yang kini bersih.
- **Regression test ditambahkan**: skenario `2b` pada `tests/Feature/TenantPublicPagesTest.php` (halaman `/profil/struktur` merespons 200 dan memuat kedua mode tampilan) serta `assertDontSee('pola_latar_profil')` dan `assertDontSee('mode_tampilan_struktur')` pada `tests/Feature/TenantAdminProfilTest.php`.

### Notes
- Kunci lama `pengaturan_umum.mode_tampilan_struktur` dibiarkan di database (tidak dihapus, tanpa migrasi destruktif) namun sudah tidak dipakai lagi oleh aplikasi.
- Verifikasi: full suite Pest **71 test / 435 assertions PASSED**; `vendor/bin/pint --dirty` bersih; `php artisan view:clear` dijalankan.


## [Tampilan URL & Tombol Salin di Modal Ubah Informasi Media] - 2026-09-30

### Added
- **Tampilan URL Berkas & Tombol Salin Cepat ([media/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/media/index.blade.php))**:
  - Modal *Ubah Informasi Berkas* sekarang menampilkan baris tautan URL berkas media lengkap dengan tombol **"Salin"** (ke clipboard) dan tombol **"Buka di Tab Baru"** agar admin dapat dengan mudah menyalin URL aset untuk digunakan di form/halaman lain.

## [Penghapusan Kontrol Pola Dekorasi Latar Hero di Admin Profil Sekolah] - 2026-09-30

### Removed & Simplified
- **Kontrol "Pola Dekorasi Latar" dihapus dari menu admin Profil Sekolah ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**: dropdown pola dekoratif hero di 4 tab (Identitas/Profil, Sejarah, Visi & Misi, Struktur) dihapus karena tidak berguna bagi operator sekolah dan hanya menambah beban form.
- **Penulisan nilai pola dihentikan di controller ([ProfilController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/ProfilController.php))**: aturan validasi `pola_latar_profil`, `pola_latar`, dan `pola_latar_struktur` beserta penulisan kolom `pola_latar` pada `updateIdentitas()`, `updateHalaman()`, dan `updateStruktur()` dihapus, sehingga penyimpanan form tidak lagi menimpa nilai tersimpan menjadi `dots`.
- **Data lama tetap aman tanpa migrasi destruktif**: kolom `halaman_statis.pola_latar`, `$fillable` model `Page`, dan 4 view publik (`profil`, `sejarah`, `visi-misi`, `struktur`) dipertahankan; hero publik tetap membaca nilai tersimpan dengan fallback `dots`.
- **Layout form hero dirapikan**: judul halaman kini `sm:col-span-2` (full width) pada tab Sejarah dan Visi & Misi, sedangkan panel hero Struktur kembali satu kolom karena hanya berisi subjudul.
- **Verifikasi**: `vendor/bin/pest` full suite **70 test / 429 assertions PASSED**; `vendor/bin/pint --dirty --format agent` bersih; `php artisan view:clear` dijalankan.


## [Standar Baku Matriks Rasio Aspek, Border, & Framing Media] - 2026-09-30

### Added & Standardized
- **Standar Baku Matriks Rasio Aspek ([.ai/rules/standar-rasio-media.md](file:///d:/databaru/Magang/website_sekolah/.ai/rules/standar-rasio-media.md), [docs/05-UI-UX.md](file:///d:/databaru/Magang/website_sekolah/docs/05-UI-UX.md))**:
  - Menetapkan 5 rasio baku terstandarisasi untuk seluruh halaman web: `1:1` (Avatar/Logo/Icon), `3:4` (Foto Pejabat/Kepsek/Guru), `4:3` (Jurusan/Fasilitas/Ekskul), `16:9` (Berita/Agenda/Video), dan `21:9` (Hero Banner).
  - Menetapkan standar token border radius (`rounded-2xl` untuk kartu, `rounded-xl` untuk thumbnail).
  - Menetapkan pola baku *Double Layer Ambient Backdrop* (`blur-md scale-125 opacity-40`) untuk mencegah letterbox hitam/putih saat rasio foto berbeda dengan kartu.
- **Penerapan Matriks Rasio Baku & Ambient Backdrop di Seluruh Halaman**:
  - **Admin Profil Sekolah ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**: Preview Logo (`1:1`), Foto Kepala Sekolah (`3:4`), Banner Hero (`16:9`), Modal Pejabat (`3:4`), dan Thumbnail Tabel Pejabat Struktur (`1:1` + crop style) tersinkronisasi live.
  - **Jurusan & Program Keahlian ([jurusan.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/jurusan.blade.php))**: Rasio baku `4:3` dengan ambient backdrop dan crop style.
  - **Berita & Artikel ([berita.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/berita.blade.php))**: Rasio baku `16:9` (`aspect-video`) dengan ambient backdrop dan crop style.
  - **Galeri Foto & Dokumentasi ([galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/galeri.blade.php))**: Rasio baku `1:1` (`aspect-square`) dengan ambient backdrop dan crop style.
  - **Guru/Staf & Struktur ([guru.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/guru.blade.php), [struktur.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/struktur.blade.php))**: Rasio baku `1:1` / `3:4` squircle dengan ambient backdrop.
- **Sinkronisasi Media Picker Modal**:
  - Menambahkan serialization `$appends = ['smart_crop_style', 'focal_position_css']` di [Media.php](file:///d:/databaru/Magang/website_sekolah/app/Models/Tenant/Media.php) dan styling thumbnail di modal *Pilih Media* agar selalu identik dengan hasil crop di Media Library.

## [Crop & Focal Point Non-Destruktif Universal (CSS Object-Position)] - 2026-09-30

### Added & Improved
- **Crop & Focal Point Non-Destruktif Universal ([Media.php](file:///d:/databaru/Magang/website_sekolah/app/Models/Tenant/Media.php), [MediaController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/MediaController.php), [media/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/media/index.blade.php))**:
  - Menyelesaikan kendala gambar URL eksternal dan file upload tanpa merusak atau menimpa berkas master asli.
  - Menambahkan kolom `crop_settings` JSON pada tabel `media` tenant untuk menyimpan koordinat crop, rotasi, rasio, dan titik fokus persentase (`focal_x`, `focal_y`).
  - Menyediakan tombol **"Simpan Fokus Crop"** pada modal editor media yang menghitung pusat crop dan menyimpannya secara instan via API non-destruktif.
- **Penerapan Otomatis CSS Object-Position di Seluruh Web ([guru.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/guru.blade.php), [struktur.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/struktur.blade.php), [home.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/home.blade.php))**:
  - Gambar kartu Guru & Staf, Pejabat Struktur Organisasi, Foto Kepala Sekolah, dan thumbnail media library otomatis membaca koordinat fokus crop dengan helper `style="object-position: {{ $media->focal_position_css }};"`.

- **Live Thumbnail untuk Video Upload (MP4 / WebM / Lokal)**:
  - Tampilan grid dan list media memuat cuplikan visual video secara instan via `<video preload="metadata">` dengan overlay tombol putar dan tag MP4.
- **Penanda Status Penggunaan Media di Seluruh Website ([MediaService.php](file:///d:/databaru/Magang/website_sekolah/app/Services/MediaService.php), [MediaController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/MediaController.php))**:
  - Sistem mendeteksi otomatis penggunaan setiap berkas media di seluruh database (Pengaturan Umum, Logo, Banner Halaman, Pejabat Struktur, Guru & Staf, Jurusan, Ekskul, Prestasi, Fasilitas, Slider, Galeri, dan Artikel Berita).
  - Badge hijau **"Digunakan"** dengan animasi pulse dan tooltip lokasi pemakaian serta badge **"Bebas"** untuk berkas yang belum disematkan.

## [Pagination 12 Items, Layout Mobile & Thumbnail Video di Media Picker Modal] - 2026-09-29

### Added & Improved
- **Pagination 12 Item per Halaman ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php), [MediaController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/MediaController.php))**: Media Picker modal sekarang melayani pagination 12 item per halaman lengkap dengan kontrol tombol *Sebelumnya*, nomor halaman aktif, tombol *Selanjutnya*, dan indikator total berkas.
- **Thumbnail Otomatis untuk Semua Video**:
  - Video YouTube otomatis menampilkan thumbnail resmi resolusi tinggi (`hqdefault.jpg`) beserta badge YouTube.
  - Video MP4 / lokal otomatis me-render frame `<video preload="metadata">` dengan ikon pemutar dan tag MP4 agar pengguna tahu isi video sebelum memilih.
- **Responsivitas Layar Mobile**: Penyesuaian modal height (`92vh`), grid 2-kolom mobile yang rapi, tombol filter/search responsif, dan touch target ramah smartphone.

## [Auto-Sinkronisasi URL Eksternal ke Pusat Media & Smart Video Player Profil] - 2026-09-29

### Added
- **Auto-Sinkronisasi URL Eksternal ke Entitas `media` ([MediaService.php](file:///d:/databaru/Magang/website_sekolah/app/Services/MediaService.php), [ProfilController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/ProfilController.php))**: URL eksternal yang diinputkan pada form profil otomatis diunduh, dikompresi WebP, dan disimpan sebagai record di tabel `media` lokal. Tautan pada form otomatis diganti dengan link storage lokal. Tautan YouTube otomatis didaftarkan sebagai `tipe_media = 'youtube'`.
- **Smart Video Player Multi-Format ([profil.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/profil.blade.php))**: Deteksi otomatis format video YouTube (`<iframe>`) atau video lokal/sendiri (`<video>` HTML5 multi MIME-type MP4/WebM/OGG).

## [Perbaikan Konversi Gambar Palette WebP & Tangkapan Notifikasi Toast Error Upload] - 2026-09-29

### Fixed
- **Konversi Palette / Indexed Image ke WebP ([MediaService.php](file:///d:/databaru/Magang/website_sekolah/app/Services/MediaService.php))**: Menambahkan konversi otomatis `imagepalettetotruecolor()` untuk mencegah error `imagewebp(): Palette image not supported by webp` pada berkas PNG 8-bit, GIF, dan gambar palet berindeks.
- **Tangkapan Notifikasi Error Toast ([tenant_admin.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/tenant_admin.blade.php))**: Memastikan notifikasi toast merah muncul saat ada error validasi atau eksepsi unggah.

## [Perbaikan Navigasi Halaman Error & Konfigurasi Batas Unggah Media 64MB] - 2026-09-29

### Fixed
- **Halaman Error 500 & 404 ([500.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/errors/500.blade.php), [404.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/errors/404.blade.php))**: Tombol navigasi cerdas kembali ke halaman sebelumnya (`window.history.back()`) dengan fallback ke beranda tenant dan penghapusan tombol Super Admin.
- **Konfigurasi Batas Unggah Media**: Menaikkan limit `upload_max_filesize` dan `post_max_size` PHP menjadi `64MB` serta menghapus alert blocking pada antarmuka.



### Changed
- **Penyederhanaan Header Admin**: Menghapus card sub-header duplikat di dalam view `profil/index.blade.php` dan mengintegrasikan judul utama ke header navigasi layout (`@section('header_title', 'Pengaturan Profil & Konten Sekolah')`).
- **Pembersihan Sakelar Inline Visibilitas**: Menghapus switch sakelar di Tab 2 (Sejarah), Tab 3 (Visi & Misi), dan Tab 4 (Struktur) agar pengaturan visibilitas menu publik terpusat di **Tab 5 (Visibilitas Menu & Rute)**.
- **Mode Tampilan Struktur Organisasi**: Admin dapat memilih apakah halaman publik `/profil/struktur` menampilkan:
  1. *Tampilkan Keduanya* (Jajaran Pejabat & Bagan Diagram dengan tab switcher),
  2. *Hanya Jajaran Pejabat*, atau
  3. *Hanya Bagan Diagram Struktur*.
- **Repeater Dinamis Bagan Diagram**: Menambahkan fitur tombol **"+ Tambah Bagan Baru"** dan **"Hapus Bagan"** dinamis berbasis Alpine.js dengan integrasi Pusat Media sehingga admin bebas menambah/mengurangi bagan diagram tanpa batasan.
- **Perbaikan Animasi Toggle Switch**: Menjamin posisi thumb switch toggle bergeser ke kanan (`translate-x-5`) saat aktif (biru) dan ke kiri (`translate-x-0`) saat nonaktif (abu-abu).

## [Kustomisasi Hero Banner Profil Lengkap, Fade Mask Gambar & Tab 1 Profil Lengkap] - 2026-09-29

### Added
- Penyesuaian nama tab pertama di admin menjadi **"1. Profil Lengkap"**.
- Pengaturan lengkap Hero Banner Profil: **Judul Utama**, **Subjudul**, **Pola Dekorasi Latar**, dan **Gambar Latar Hero** dari Pusat Media.
- Implementasi Hero Banner Split dengan efek **Gradual Fade Mask** di sisi kanan dan *drop-shadow* teks otomatis agar konten selalu terbaca tajam dan tidak bertabrakan dengan gambar latar.

## [CMS Manajemen Profil Sekolah, WYSIWYG Editor, Integrasi Media & Kontrol Visibilitas Rute] - 2026-09-29

### Added
- **Manajemen Profil Sekolah CMS (`app/Http/Controllers/Tenant/Admin/ProfilController.php`)**:
  - Menyediakan panel admin terpadu dengan 5 tab interaktif (*Identitas & Sambutan*, *Sejarah Sekolah*, *Visi & Misi*, *Struktur Organisasi*, dan *Visibilitas Menu & Rute*).
  - Tersimpan 100% berelasi di database (`pengaturan_umum`, `halaman_statis`, `struktur_organisasi`, `pengaturan_fitur`, `menus`) dengan tracking foreign key `pengguna_id = auth('tenant_admin')->id()`.
- **Editor Teks WYSIWYG (Quill.js)**:
  - Integrasi editor teks WYSIWYG clean tanpa AI slop untuk penyuntingan konten *Sejarah Sekolah* dan *Visi, Misi & Sasaran Mutu*.
- **Integrasi Pustaka Media (Pusat Berkas Media Picker)**:
  - Terintegrasi langsung dengan database `media` sekolah sehingga admin dapat memilih foto/video yang telah diunggah atau mengunggah berkas baru langsung dari modal pemilih media.
- **Kontrol Visibilitas Dinamis (Feature Flag & Menu Toggle)**:
  - Admin dapat menyembunyikan atau menampilkan sub-menu/halaman (`Sejarah`, `Visi & Misi`, `Struktur Organisasi`, `Guru & Staf`, `Fasilitas`).
  - Ketika dinonaktifkan: link otomatis hilang dari navbar desktop & mobile drawer publik, dan rute publik mengembalikan respon **HTTP 404 (Not Found)** secara otomatis untuk perlindungan konten.
- **Sidebar Admin Layout (`resources/views/layouts/tenant_admin.blade.php`)**:
  - Menambahkan menu navigasi "Profil Sekolah" pada sidebar panel admin.
- **Pest Feature Test Suite (`tests/Feature/TenantAdminProfilTest.php`)**:
  - 6 unit & feature test komprehensif menguji seluruh alur update identitas, konten WYSIWYG, relasi database pejabat, media picker, dan respon 404 saat fitur dinonaktifkan (69 test / 420 assertions passing 100%).

## [Pengecualian Resmi Identitas Merek Tombol Floating WhatsApp] - 2026-09-29

### Added
- **Pengecualian Resmi Identitas Merek Pihak Ketiga (WhatsApp)**:
  - Memastikan tombol floating WhatsApp resmi pada [`resources/views/layouts/public.blade.php`](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/public.blade.php) tetap mempertahankan warna hijau identitas aslinya (`#25D366` dan hover `#20ba5a`).
  - Memperbarui dokumentasi rule [`.ai/rules/publik-tema-kontras.md`](file:///d:/databaru/Magang/website_sekolah/.ai/rules/publik-tema-kontras.md) dan [`docs/08-CSS-ARSITEKTUR-TEMA.md`](file:///d:/databaru/Magang/website_sekolah/docs/08-CSS-ARSITEKTUR-TEMA.md) dengan klausul pengecualian identitas merek pihak ketiga (seperti WhatsApp, YouTube, Google Maps) agar warna khas brand tidak tertimpa tema sekolah.

## [Perbaikan Durasi Sesi Login Admin 1 Minggu & Isolasi Koneksi Session Database] - 2026-09-29

### Fixed
- **Penyebab Sesi Cepat Logout (Root Cause)**:
  - Pada [`TenantMiddleware`](file:///d:/databaru/Magang/website_sekolah/app/Http/Middleware/TenantMiddleware.php), pemanggilan `DB::setDefaultConnection('tenant')` sebelumnya mengubah koneksi default Laravel secara global. Akibatnya, saat middleware session berjalan menyimpan/membaca data sesi ke tabel `sessions`, query terlempar mencari tabel `sessions` di database tenant (yang memang tidak memiliki tabel sessions), sehingga driver session kehilangan state dan mereset sesi pengguna setelah beberapa menit.
- **Perbaikan Isolasi Koneksi & Durasi Sesi**:
  - Menghapus `DB::setDefaultConnection('tenant')` dari `TenantMiddleware` sehingga koneksi default framework tetap `mysql` (central), sementara model-model tenant tetap terisolasi 100% menggunakan `protected $connection = 'tenant'`.
  - Mengunci konfigurasi `SESSION_CONNECTION=mysql` di [`config/session.php`](file:///d:/databaru/Magang/website_sekolah/config/session.php), [`.env`](file:///d:/databaru/Magang/website_sekolah/.env), dan [`.env.example`](file:///d:/databaru/Magang/website_sekolah/.env.example).
  - Memperpanjang batas waktu sesi `SESSION_LIFETIME` menjadi **10080 menit (7 hari / 1 minggu)** agar admin tidak sering logout secara tiba-tiba saat bekerja.
  - Memperbarui regression test pada [`TenantAdminTest.php`](file:///d:/databaru/Magang/website_sekolah/tests/Feature/TenantAdminTest.php) untuk memverifikasi session lifetime 1 minggu.

### Verification
- `vendor/bin/pest`: **63 test / 377 assertions PASSED** (100% hijau).


## [Penyelarasan Hero Banner Seluruh Halaman Publik Mengikuti Standar Visi Misi & Tema] - 2026-09-29

### Changed
- **Penyelarasan Hero Banner Seluruh Halaman Publik (`resources/views/public/pages/*.blade.php`)**:
  - Mengganti seluruh latar gradient hardcoded (`from-slate-900 via-blue-950 to-indigo-950` dan varian gradient lama) dengan kelas tema baku `theme-bg-dark` dan pola dot matrix radial `var(--theme-accent)`.
  - Halaman yang diselaraskan:
    - [profil.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/profil.blade.php)
    - [visi-misi.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/visi-misi.blade.php)
    - [sejarah.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/sejarah.blade.php)
    - [jurusan.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/jurusan.blade.php)
    - [jurusan_detail.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/jurusan_detail.blade.php)
    - [berita.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/berita.blade.php)
    - [agenda.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/agenda.blade.php)
    - [agenda_detail.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/agenda_detail.blade.php)
    - [ekstrakurikuler.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/ekstrakurikuler.blade.php)
    - [fasilitas.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/fasilitas.blade.php)
    - [galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/galeri.blade.php)
    - [guru.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/guru.blade.php)
    - [kalender.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/kalender.blade.php)
    - [kegiatan.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/kegiatan.blade.php)
    - [kontak.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/kontak.blade.php)
    - [kurikulum.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/kurikulum.blade.php)
    - [osis.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/osis.blade.php)
    - [pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/pengumuman.blade.php)
    - [prestasi.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/prestasi.blade.php)
    - [spmb.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/spmb.blade.php)
    - [struktur.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/struktur.blade.php)
  - Merapikan struktur navigasi breadcrumb menjadi format standar `<ol>` / `<li>` dengan pewarnaan yang seragam dan lolos auto-kontras tema (`text-slate-300`, hover `text-white`, active `text-sky-300 font-medium`).
  - Menyelaraskan seluruh tautan hierarki breadcrumb (seperti rumpun `Beranda / Profil / [Nama Halaman]`, `Beranda / Akademik / Kurikulum`, `Beranda / Kesiswaan / OSIS & MPK`, dan `Beranda / Agenda / Kalender Akademik`).
  - Seluruh halaman publik kini otomatis merespons perubahan tema warna sekolah (Emerald/Hijau, Navy, Maroon, dll.) tanpa teks yang tidak terbaca atau gradien yang tidak selaras.

### Verification
- `vendor/bin/pest`: **63 test / 377 assertions PASSED** (100% hijau).
- `npm run build`: Berhasil mengompilasi aset CSS & JS.

## [Aturan Baru: Kontrak Tema & Auto-Kontras untuk Kode Publik] - 2026-09-29

### Added
- **Rule operasional `.ai/rules/publik-tema-kontras.md`** beserta indeks `.ai/rules/index.md`: aturan blocking untuk `resources/css/public.css`, `resources/views/layouts/public.blade.php`, `resources/views/public/**`, `app/Http/Controllers/Tenant/Public/**`, `routes/web.php` grup `{tenant}`, `app/Support/WarnaKontras.php`, dan pratinjau tema admin. Isinya: kontrak dua lapis auto-kontras, daftar kelas `.theme-*` yang wajib dipakai, daftar larangan warna literal, SOP tambah menu navigasi (tabel `menu` + perilaku filter nama `spmb`/`Profil`/`Program Keahlian` di layout), SOP tambah halaman publik (route -> controller `getSekolahData()` -> view -> test), template 8 baris untuk mendaftarkan scope kontras baru, SOP 6 titik sinkronisasi kunci warna baru, tabel anti-pattern, dan perintah verifikasi wajib.
- **Referensi teknis `docs/08-CSS-ARSITEKTUR-TEMA.md`**: diagram alur warna `pengaturan_umum` -> controller -> `public.blade.php` -> `public.css` -> piksel, tabel API `WarnaKontras`, 13 kunci panel + 16 kunci `--theme-fg-*` lengkap dengan latar acuan dan ambang, registri 8 scope auto-kontras beserta selector dan perilakunya, inventaris kelas tampilan, resep cepat per jenis tugas, catatan fallback browser tanpa `@property`/`contrast()`, dan cara memeriksa compiled CSS.

### Changed
- `docs/RULES.md`: bagian 8 "Standar Tema & Auto-Kontras CSS (Portal Publik)" berisi 8 poin mengikat plus tautan ke rule dan dokumen teknis.
- `docs/05-UI-UX.md`: bagian Auto-Kontras WCAG menautkan rule dan dokumen teknis sebagai acuan penulisan kode baru.
- `docs/07-IMPLEMENTATION-CHECKLIST.md`: Tahap 11 (Penegakan Aturan Tema & Auto-Kontras) ditambahkan dan dicentang.

### Notes
- Dokumen/rule saja, tidak ada perubahan kode runtime, migrasi, maupun perilaku tampilan. Test suite tidak terdampak.


## [Auto-Kontras WCAG Otomatis untuk Seluruh Permukaan Portal] - 2026-09-29

### Added
- **Helper `App\Support\WarnaKontras`** (`app/Support/WarnaKontras.php`): `luminans()`, `rasio()`, `pilihTeks()`, `campurWarna()` sesuai rumus luminance WCAG 2.1. Menerima hex 3 dan 6 digit; format tidak dikenal diperlakukan sebagai latar terang supaya teks tidak pernah ikut hilang.
- **Lapis server-side di `resources/views/layouts/public.blade.php`:** closure `$kontras()` menyuntik 16 kunci teks per permukaan (`--theme-fg-header`, `--theme-fg-footer`, `--theme-fg-zona`, `--theme-fg-tombol`, `--theme-fg-aksen`, `--theme-fg-link`, `--theme-fg-badge`, `--theme-fg-halaman-heading|text|muted`, `--theme-fg-section-heading|text|muted`, `--theme-fg-kartu-heading|text|muted`). Warna usulan admin dipakai selama lolos ambang (teks isi 4.5:1, tombol 3:1, tautan 2:1); bila tidak, putih/tinta `#0F172A` dipilih lewat argmax kontras.
- **Lapis client-side (pengaman) di `resources/css/public.css`:** `@property --kontras-aman` dan `--kontras-terang` bertipe integer yang beranimasi, dipakai sebagai sakelar `color-mix()` pada `--fg-zona-efektif` per scope (`:root`, `.theme-page-bg`, `.theme-section-bg`, `.theme-card` / `.bg-white/80|/90`, `.theme-badge`, zona gelap `.theme-bg`/`bg-blue-900`, `.theme-header`, `footer.theme-bg`/`footer.theme-footer`). Deteksi memakai `calc(var(--fg) contrast(var(--bg)) >= 4.5)`, sehingga override warna dari DevTools, ekstensi browser, atau JS tetap dipaksa terbaca.
- **Pratinjau admin sejalan hasil render (`resources/views/tenant/admin/pengaturan/index.blade.php`):** salinan JS `WarnaKontras` (`luminans`/`rasio`/`pilihTeks`/`campur`) beserta computed getter `fgHeader`, `fgFooter`, `fgTombol`, `fgAksen`, `fgKartuHeading`, `fgKartuTeks`, `fgKartuMuted`, `fgSectionHeading`, `fgBadge`, `fgLink` menggantikan pemakaian warna mentah panel pada mock header, section, kartu, dan footer.
- **Test baru:** `tests/Unit/WarnaKontrasTest.php` (7 skenario / 22 assertion) dan 3 skenario auto-kontras pada `tests/Feature/TenantThemeColorTest.php`.

### Changed
- `--theme-fg-zone` menjadi `--theme-fg-zona` (konsistensi istilah); `--fg-zona-efektif` kini menjadi resolver yang bernilai berbeda per scope (header, footer, halaman, kartu, badge, zona gelap).
- Warna teks tidak lagi membaca `--theme-btn-text` secara mentah. Aturan `.text-blue-900`/`.text-blue-950`, `nav .text-blue-950`, `.theme-btn-ghost`, `.theme-table-head`, `.theme-input`, badge, serta zona gelap (pengganti `color-mix(..., black)`) kini membaca hasil auto-kontras.

### Verification
- `vendor/bin/pest`: **63 test / 377 assertions PASSED** (termasuk 9 skenario `TenantThemeColorTest`).
- `vendor/bin/pint --dirty`: passed.
- `npm run build`: `public/build/assets/public-CMXtt0o7.css` 34.00 kB (gzip 4.52 kB); compiled CSS tetap memuat 2 blok `@property`, 11 panggilan `contrast()`, dan 26 rujukan `--fg-zona-efektif`.
- Verifikasi angka kontras: `#FFFFFF` vs `#000000` = 21:1; judul `#0F2A22` di kartu `#052E1F` = 1.03:1 lalu dipaksa `#FFFFFF`; teks `#FFFFFF` di header `#F1F5F9` = 1.10:1 lalu dipaksa `#0F172A`; `#94A3B8` di atas putih = 2.56:1 (lolos ambang tautan, gagal ambang teks isi).

## [Pusat Media: Filter Monokrom Rapi, Crop Non-Destruktif, Toast Kanan Bawah & Pembersihan Warna] - 2026-09-29

### Changed
- **Penyelarasan & Perapian Filter Bar (Anti-Warna Pelangi)**:
  - Menggabungkan filter chips tipe media, dropdown kategori, form pencarian nama berkas, dan toggle Grid/Tabel ke dalam satu kesatuan toolbar rapi dan simetris.
  - Menghapus penggunaan aneka warna cerah/pelangi pada filter badge dan menggantinya dengan palet netral institusional yang elegan (Slate-900 / Slate-100 / Slate-600).
- **Arsitektur Crop Non-Destruktif (Perlindungan Berkas Master)**:
  - Memodifikasi `MediaService@prosesEditGambar` dan `MediaController@editImage`: Fitur crop dan rotasi gambar kini **TIDAK MENIMPA/MERUSAK** berkas master asli (`media.path` asli tetap utuh di database & storage server).
  - Menyimpan hasil potongan sebagai berkas WebP varian baru terpisah (`{nama}-crop-{timestamp}.webp`) dengan record media baru berstatus WebP teroptimasi.
- **Notifikasi Toast Mengambang di Pojok Kanan Bawah (Floating Auto-Dismiss Toast)**:
  - Menghapus banner flash alert statis di atas layout admin (`layouts/tenant_admin.blade.php`).
  - Menggantinya dengan kartu notifikasi Toast interaktif berbasis Alpine.js yang melayang di pojok kanan bawah (`fixed bottom-6 right-6 z-50`) dengan transisi animasi halus dan menghilang otomatis setelah 4 detik.
- **Perbaikan & Penguatan REST API Upload**:
  - Memastikan endpoint `POST /admin/media/upload` menangani payload JSON/Multipart secara aman dengan validasi respons status 200/422 dan penanganan error yang jelas.

### Verification
- `php artisan test tests/Feature/TenantMediaTest.php`: **10 test / 47 assertions PASSED** (100% hijau).
- `vendor/bin/pint --dirty`: Bersih dan sesuai standar PSR-12 / Laravel Pint.

## [Pusat Manajemen Media: Kotak Crop Interaktif, Bulk Action, Chips Mobile & Loading Feedback] - 2026-09-29

### Added
- **Editor Gambar dengan Kotak Crop Interaktif (Drag & Resize Box)**:
  - Kotak crop visual interaktif dengan garis bantu komposisi (*rule of thirds*), 4 sudut handle penarik ukuran, dan visualisasi area terpotong (*dark overlay*) secara real-time.
  - Perhitungan koordinat skala asli gambar (`crop_x`, `crop_y`, `crop_w`, `crop_h`) otomatis saat digeser atau diubah ukurannya sebelum disimpan ulang ke WebP.
- **Tampilan Filter Chips Mobile-Friendly**:
  - Filter tipe media dirombak menggunakan desain *chips badge* berbalut *horizontal scrollbar* yang ramah sentuhan layar ponsel/tablet.
  - Menampilkan jumlah berkas spesifik untuk setiap tipe secara presisi: `Semua (x)`, `Gambar (x)`, `Video Lokal (x)`, `YouTube (x)`, `Dokumen (x)`.
- **Penghapusan Massal & Multi-Select Checkbox**:
  - Checkbox pemilihan pada setiap kartu grid dan baris tabel, serta tombol centang *Pilih Semua Berkas*.
  - Endpoint & Method `POST /admin/media/bulk-delete` (`MediaController@bulkDestroy`) untuk menghapus banyak berkas sekaligus secara bersih dari database dan storage server.
- **Modal Konfirmasi Hapus Kustom (Anti-Native Alert)**:
  - Mengganti seluruh `window.confirm()` bawaan browser dengan modal dialog kustom Tailwind/Alpine yang modern dan terintegrasi dengan tema.
- **Indikator Loading & Feedback Interaksi Responsif (Anti-Freeze)**:
  - Spinner animasi dan status teks berjalan (*"Mengunggah & mengompresi WebP..."*, *"Mengunduh & menyimpan..."*, *"Memproses crop..."*, *"Menghapus..."*) pada setiap tombol aksi dan modal proses global.
- **Pembaruan Aturan Kerja (RULES.md & AGENTS.md)**:
  - Menambahkan aturan wajib penyediaan status loading animasi/spinner pada setiap pembuatan interaksi asinkron, manipulasi DOM, atau rute/REST API untuk mencegah kesan antarmuka lag atau membeku.
- **Pembersihan Tombol Salin URL & Posisi Layout**:
  - Menghapus tombol salin URL dari kartu dan tabel sesuai arahan.
  - Memposisikan toggle Grid/List konsisten di pojok kanan atas.
- **Test Suite Pest `TenantMediaTest`**: Menambahkan skenario uji bulk delete (total **52 test / 322 assertions PASSED**).

### Verification
- `php artisan test`: **52 test / 322 assertions PASSED** (100% hijau).
- `vendor/bin/pint`: Seluruh kode bersih dan terformat rapi.

## [Otentikasi Admin: Penguatan Remember Me & Durasi Sesi 24 Jam] - 2026-09-29

### Changed
- **Session Lifetime 1 x 24 Jam**: Mengubah durasi sesi login aplikasi (`SESSION_LIFETIME`) dari 120 menit (2 jam) menjadi **1440 menit (24 jam)** pada `.env`, `.env.example`, dan `config/session.php`. Sesi admin kini bertahan 24 jam dan baru logout otomatis setelah 1 x 24 jam tanpa aktivitas.
- **Formulir Login Admin (`login.blade.php`)**: Memperbaiki dan mempertegas atribut input *Ingat saya di perangkat ini* (`id="remember"`, `value="1"`, `{{ old('remember') ? 'checked' : '' }}`) yang terhubung langsung dengan `remember_token` pada database pengguna tenant.
- **Konsistensi Tema**: Memperbarui variabel turunan `--theme-color-light` di [`layouts/public.blade.php`](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/public.blade.php) agar menggunakan `var(--theme-page-bg)` dan tidak lagi menggunakan literal `white`.

### Verification
- `php artisan test`: **43 test / 285 assertions PASSED** (termasuk skenario pengujian remember me & konfigurasi sesi 1440 menit).

## [Halaman Profil: Logo Lebih Besar & Penggantian Sidebar dengan Video Player] - 2026-09-29

### Added
- **Komponen Video Profil Media Player** pada kolom kanan halaman profil publik ([`profil.blade.php`](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/profil.blade.php)) yang mendukung pemutaran video YouTube embed maupun video MP4/HTML5 native lengkap dengan judul dan deskripsinya.

### Changed
- **Logo Resmi Sekolah**: Ukuran ditingkatkan menjadi lebih besar (`w-36 h-36 sm:w-44 sm:h-44 md:w-48 md:h-48`) dan background wadah dibuat transparan (`bg-transparent`) tanpa border berlebih.

### Removed
- Sidebar lama (kartu kepala sekolah & menu navigasi redundan) di halaman profil digantikan oleh kartu video player.

### Verification
- `php artisan test tests/Feature/TenantPublicPagesTest.php`: **17 test / 60 assertions PASSED**.

## [Halaman Profil: Penambahan Logo Sekolah pada Kartu Identitas] - 2026-09-29

### Added
- **Logo Resmi Sekolah** pada kartu *Identitas Satuan Pendidikan* di halaman profil publik ([`profil.blade.php`](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/profil.blade.php)) dengan layout flex responsif yang terintegrasi dinamis dengan data/pengaturan tema.

### Verification
- `php artisan test tests/Feature/TenantPublicPagesTest.php`: **17 test / 60 assertions PASSED**.

## [Pembersihan Halaman Profil: Penghapusan Section Struktur Pimpinan Sekolah] - 2026-09-29

### Removed
- **Section "Struktur Pimpinan Sekolah"** (`#struktur`) pada halaman profil publik ([`profil.blade.php`](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/profil.blade.php)) beserta tautan menu navigasi anchor terkait.

### Verification
- `php artisan test tests/Feature/TenantPublicPagesTest.php`: **17 test / 60 assertions PASSED**.

## [Kelompok Warna Lengkap: Semua Keluarga Ikut Panel Tema Tanpa Pengecualian] - 2026-09-29

### Added
- **133 variabel palet baru di `:root` `resources/css/public.css`** (total 199): `purple`/`violet`/`fuchsia`/`pink` → identitas, `green`/`emerald`/`lime`/`teal`/`cyan`/`yellow`/`red`/`rose` → aksen, `gray`/`zinc`/`stone`/`neutral` → netral, `--color-white` → `--theme-identity-50`, serta aturan arbitrary WhatsApp `bg-[#25D366]`/`hover:bg-[#20ba5a]` → aksen.

### Changed
- **Sapu bersih sisa putih (tindak lanjut laporan "masih ada putih"):** 37 dasar campuran `color-mix(..., white)` di `public.css` → `var(--theme-page-bg)`, `--color-white` → `var(--theme-btn-text)`, titik radial hero → `--theme-accent-400`, dan pratinjau panel admin memakai Alpine `btnText`/`pageBg` (bebas `rgba(255,255,255)`).
- **Seluruh literal putih hardcoded diganti kunci panel `warna_tombol_teks`** (aturan header/footer, breadcrumb `text-blue-100/200`, amber di dark card/section, `group-hover:text-sky-300`, dan aturan zona gelap) sehingga tidak ada lagi warna yang mengabaikan panel Tema & Warna; preset default `#FFFFFF` menghasilkan tampilan identik dengan sebelumnya.
- **Pengecualian semantik dihapus:** `emerald`/`rose`/`red`/WhatsApp kini ikut grup aksen; overlay `bg-black/xx` tetap hitam karena berfungsi sebagai latar redup.

### Verification
- `php artisan test`: **42 test / 278 assertions PASSED**; `vendor/bin/pint --dirty` bersih; `npm run build` sukses (`public-CCKXuORS.css`, 28,54 kB); request HTTP port 8123 & 8000 menautkan stylesheet hash baru tersebut.

## [Penutupan Celah Pemetaan Warna: Override Palet Tailwind v4] - 2026-09-29

### Added
- **Skala turunan `--theme-identity-50..950`, `--theme-accent-50..950`, `--theme-neutral-50..950`** di `resources/css/public.css` (via `color-mix()` dari 13 kunci tema).
- **Override 66 variabel palet Tailwind v4** di `:root`: blue & indigo → identitas, sky, amber, orange → aksen, slate → netral, sehingga kelas yang lolos dari pemetaan sebelumnya ikut mengikuti tema - termasuk varian `hover:`/`focus:`, opacity `/xx`, gradien `from-via-to`, `ring-*`, `placeholder-slate-400`, dan `text-slate-200/300` pada breadcrumb hero gelap.
- **Override pola radial hardcoded `#38bdf8`** (±17 halaman hero) → aksen; `border-slate-*/80|60` → `--theme-border`.
- **Test Pest ke-6** pada `TenantThemeColorTest` untuk guardrail pemetaan palet.

### Changed
- **`resources/css/public.css`**: deklarasi `:root` tanpa layer menang atas `@layer theme` Tailwind v4; aturan kontekstual lama tetap menang berkat spesifisitas + `!important`.
- **Warna semantik dikecualikan:** `emerald` (sukses/Aktif), `rose`/`red` (error form), dan merek WhatsApp `bg-[#25D366]` tidak ikut tema.

### Verification
- `php artisan test`: **42 test / 254 assertions PASSED**; `vendor/bin/pint --dirty` bersih; `npm run build` sukses (`public-DCqQ4nZP.css`, 20.03 kB); request HTTP nyata menautkan stylesheet hash baru tersebut.

## [Sistem Warna Global Terkelompok: 13 Kunci Warna dalam 6 Grup] - 2026-09-29

### Added
- **6 kunci warna baru** di tabel `pengaturan_umum` (skema tidak berubah): `warna_judul`, `warna_teks_sekunder`, `warna_latar_halaman`, `warna_latar_section`, `warna_border`, `warna_footer` - total **13 kunci warna** + `skema_tema`.
- **6 grup pengaturan warna** di panel admin: Warna Identitas, Tipografi & Teks, Latar & Permukaan, Garis & Batas, Tombol & Aksi, Header Navigasi & Footer, masing-masing dengan color picker + input hex tersinkronisasi.
- **Pratinjau langsung** mock header, section + kartu, dan footer yang terikat pada ke-13 variabel warna; **legenda kelas global** untuk pengembang.
- **Test Pest `TenantThemeColorTest`** (5 skenario) untuk injeksi variabel, kelas tema, isi `public.css`, isi panel, dan penyimpanan 13 warna.

### Changed
- **`resources/css/public.css`**: fallback `:root` memuat 13 variabel `--theme-*`, menambah **Legacy Utility Mapping** (utilitas `bg-white`, `bg-slate-*`, `border-slate-*`, `text-slate-*` → variabel tema dengan `!important`, zona gelap dikecualikan), dan `footer` memakai `--theme-footer-bg`.
- **`layouts/public.blade.php`**: injeksi `:root` diperluas menjadi 13 variabel; `<body>`, header, footer memakai kelas tema.
- **`HomeController` & `PageController`**: `$sekolah` memuat 13 kunci warna + `skema_tema`.
- **`PengaturanController`**: validasi 13 kunci warna + `skema_tema`.
- **`tenant/admin/pengaturan/index.blade.php`**: dibangun ulang dengan 6 grup warna, pratinjau langsung, dan legenda kelas global.
- **Seeder `TenantSmkn2BandungSeeder`**: 13 kunci warna + `skema_tema` ditulis ke `pengaturan_umum`.
- **Pest `TenantAdminTest`**: judul panel kini `Pengaturan Tema & Warna Portal Sekolah`.

### Verification
- `php artisan test`: **41 test / 243 assertions PASSED**; `npm run build` sukses; request HTTP nyata memastikan 13 variabel `--theme-*` tersuntik sesuai palet uji `#BE123C`.

## [Penyederhanaan Panel Admin Sekolah: Hanya Menu Tema & Warna] - 2026-09-29

### Removed
- **16 controller modul admin sekolah** di `app/Http/Controllers/Tenant/Admin/`: `DashboardController`, `SliderController`, `ProfilController`, `StrukturController`, `JurusanController`, `BeritaController`, `PengumumanController`, `AgendaController`, `GaleriController`, `PrestasiController`, `EkstrakurikulerController`, `GuruStafController`, `FasilitasController`, `SpmbController`, `KontakController`, dan `MediaController`.
- **36 view modul admin sekolah** pada folder `resources/views/tenant/admin/` (`dashboard`, `slider`, `profil`, `struktur`, `jurusan`, `berita`, `pengumuman`, `agenda`, `galeri`, `prestasi`, `ekskul`, `guru`, `fasilitas`, `spmb`, `kontak`, `media`).
- **Komponen admin tidak terpakai**: `resources/views/components/admin/input-gambar.blade.php`, `input-waktu.blade.php`, `quill-editor.blade.php`, serta aset CDN Quill di `layouts/tenant_admin.blade.php`.
- **`App\Services\ImageService`** karena hanya dipakai modul identitas/upload hero yang sudah dihapus.
- **Rute modul admin lama**: `tenant.admin.dashboard`, `slider`, `profil`, `struktur`, `jurusan`, `berita`, `pengumuman`, `agenda`, `galeri`, `prestasi`, `ekskul`, `guru`, `fasilitas`, `spmb`, `kontak`, `media`.
- **Tab non-tema** pada halaman pengaturan admin: Identitas & Logo, Statistik Beranda, dan Video Profil Sekolah.

### Changed
- **Sidebar admin sekolah (`resources/views/layouts/tenant_admin.blade.php`)**: seluruh item menu dihapus dan disisakan satu menu `Tema & Warna`; logo serta nama sekolah pada header sidebar kini menaut ke halaman pengaturan tema.
- **Login admin sekolah (`App\Http\Controllers\Tenant\Admin\AuthController`)**: admin diarahkan langsung ke `/{tenant}/admin/pengaturan` setelah login dan saat membuka halaman login dalam kondisi sudah terautentikasi. Rute `GET /{tenant}/admin/login` tidak lagi memakai middleware `guest:tenant_admin` agar tidak terlempar ke halaman publik.
- **Shortcut `/admin`** mengarah ke `/{tenant}/admin/pengaturan` saat sesi admin sekolah aktif.
- **`PengaturanController` dipersempit**: hanya menangani `skema_tema` beserta 7 kunci warna (`warna_tema`, `warna_aksen`, `warna_teks`, `warna_kartu`, `warna_tombol`, `warna_tombol_teks`, `warna_header`) dengan pesan validasi berbahasa Indonesia. Halaman `resources/views/tenant/admin/pengaturan/index.blade.php` kini hanya memuat panel Tema & Warna (7 preset, color picker, live preview) tanpa navigasi tab.
- **Pest `TenantAdminTest` disesuaikan**: 9 skenario pengujian (login guest, proteksi auth, redirect ke pengaturan tema, isi sidebar, 404 seluruh rute lama, penyimpanan palet, integritas data tenant) dengan total suite 36 test lulus.

### Notes
- **Database, migrasi, model, dan seeder tetap utuh.** Seluruh tabel tenant (`jurusan`, `artikel`, `agenda`, `prestasi_siswa`, `ekstrakurikuler`, `guru_staf`, `fasilitas`, `galeri_album`, `galeri_item`, `slider_beranda`, `pesan_masuk`, `pengaturan_ppdb`, `pengaturan_umum`, `pengaturan_fitur`, dll.) beserta datanya tidak diubah dan tetap dipakai seluruh halaman portal publik.

## [Unreleased]

### Fixed
- **Penerapan Tema Warna ke Seluruh Halaman Publik (Full Theme Coverage)**:
  - Menambahkan CSS override komprehensif di `resources/views/layouts/public.blade.php` untuk semua kelas warna hardcoded yang belum tertangkap tema: `amber-*`, `indigo-*`, `orange-*`, `bg-blue-950/*`, `section.bg-slate-900`.
  - Mengganti overlay hero carousel `bg-blue-950/85` di `home.blade.php` dengan inline style `color-mix(in srgb, var(--theme-color) 85%, black)`.
  - Mengganti dots indikator carousel dari `:class="'bg-blue-500'"` ke `:style="'background-color: var(--theme-accent)'"`.
  - Mengganti tombol amber `bg-amber-400` di `jurusan_detail.blade.php` dengan class `theme-btn-primary`.
  - Mengganti filter pills `bg-slate-900` di `agenda.blade.php` dengan class `theme-btn-primary` + inline style CSS var.
  - Menambahkan override untuk teks amber di dalam card dark (`bg-blue-900`) agar tetap terbaca sebagai putih.
  - Semua 26+ halaman publik kini mengikuti tema warna yang dipilih admin (termasuk amber badge, indigo pill, orange accent).

### Added

- **Pengaturan Tema & Warna Mandiri (7 Preset + Custom Hex + Live Preview)**:
  - Tab navigasi admin **"Tema & Warna"** di `tenant/admin/pengaturan/index.blade.php`.
  - 7 Pilihan Preset Terverifikasi: *Biru Navy Klasik*, *Hijau Zamrud Edukasi*, *Merah Marun Prestisius*, *Ungu Dinamis Kreatif*, *Abu Gelap Elegan*, *Emas Oranye Enerjik*, dan *Teal Bahari Futuristik*.
  - Opsi *Custom Warna* dengan kontrol hex dan color picker untuk warna teks konten, kartu, tombol, teks tombol, bar header, dan aksen.
  - Simulasi *Live Preview* interaktif di panel admin yang langsung berubah sesuai warna yang dipilih.
  - Penyimpanan permanen ke database tenant (`pengaturan_umum`) melalui `PengaturanController.php`.
  - Refactoring CSS variabel `:root` dan utility classes (`theme-btn-primary`, `theme-card`, `theme-header`) di `resources/views/layouts/public.blade.php` dan `home.blade.php`.
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
