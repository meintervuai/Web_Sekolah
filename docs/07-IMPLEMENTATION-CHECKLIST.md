# Checklist Implementasi: Revisi Web Sekolah (Fase 1 - SMK Negeri 2 Bandung)

## Status Keseluruhan: COMPLETED & VERIFIED (Fase 1 Selesai Penuh)

---

### Tahap 1: Audit dan Penyelarasan Fondasi (Selesai)
- [x] Deteksi stack: Laravel 12, PHP 8.5, MySQL Multi-tenant (`tenant_{slug}`), Tailwind CSS, Alpine.js, Pest.
- [x] Audit database tenant & central.
- [x] Identifikasi celah schema (tabel `agenda`, `pengaturan_fitur`, detail event, foreign key).
- [x] Identifikasi rute dan view yang kurang (14 halaman publik wajib).
- [x] Laporan audit dan konfirmasi rencana ke pengguna.

---

### Tahap 2: Database & Model (Fondasi Data & Feature Flags) (Selesai)
- [x] Migration tenant untuk tabel `agenda`: `2026_09_26_000001_create_agenda_table.php`.
- [x] Migration tenant penambahan kolom `slug`, `pembina`, `tahun`: `2026_09_26_000002_add_slug_to_ekskul_and_prestasi.php`.
- [x] Eksekusi migrasi di seluruh database tenant via `php artisan tenants:migrate`.
- [x] Buat Model Eloquent tenant:
  - [x] `App\Models\Tenant\PengaturanFitur` (helper `isAktif($kodeFitur)`)
  - [x] `App\Models\Tenant\Agenda`
  - [x] `App\Models\Tenant\Ekstrakurikuler`
  - [x] `App\Models\Tenant\PrestasiSiswa`
  - [x] `App\Models\Tenant\Fasilitas` & `FotoFasilitas`
  - [x] `App\Models\Tenant\GuruStaf`
  - [x] `App\Models\Tenant\GaleriAlbum` & `GaleriItem`
  - [x] `App\Models\Tenant\PesanMasuk`
  - [x] `App\Models\Tenant\SliderBeranda`
  - [x] Update model dengan `protected $connection = 'tenant';`: `Post`, `Jurusan`, `Page`, `Menu`, `KategoriArtikel`.
  - [x] Update model central dengan `protected $connection = 'mysql';`: `Sekolah`, `DomainSekolah`, `SuperAdmin`.
- [x] Seeder komprehensif `TenantSmkn2BandungSeeder`:
  - [x] Identitas resmi SMK Negeri 2 Bandung (NPSN 20219146, akreditasi A, Jl. Ciliwung No. 4, telp (022) 7234285, email humas@smkn2bandung.sch.id).
  - [x] Statistik resmi: 98 guru, 1.972 siswa, 54 rombel, 41 ruang kelas, 1 lab, 1 perpus, 7 jurusan, 85 mitra DUDI.
  - [x] 7 Program Keahlian resmi Kurikulum Merdeka (TP, TKR, PPLG, TJKT, DKV, TOI, TAV).
  - [x] 6 Berita lengkap dengan gambar sampul & kategori.
  - [x] 4 Pengumuman kedinasan dengan ringkasan & detail.
  - [x] 4 Agenda (mendatang & lampau) dengan tanggal & lokasi.
  - [x] 6 Prestasi siswa dengan tahun, nama siswa, dan tingkat lomba.
  - [x] 8 Ekstrakurikuler dengan jadwal rutin dan pembina.
  - [x] 8 Guru & Tenaga Kependidikan dengan nama, gelar, dan mapel.
  - [x] 6 Fasilitas unggulan sekolah rasio 4:3.
  - [x] 3 Album galeri foto dokumentasi sekolah.
  - [x] Profil kepala sekolah (Dr. H. Hasanudin, M.Pd.) + sambutan.
  - [x] Halaman statis (sejarah, visi-misi, kurikulum, osis, spmb).
  - [x] 3 Slider hero beranda interaktif.
  - [x] 14 Feature flags modul terkonfigurasi.
  - [x] 29 Menu navigasi hierarkis aktif.

---

### Tahap 3: Routing & Controller Halaman Publik (Selesai)
- [x] Definisikan 14 rute canonical publik tenant di `routes/web.php`:
  1. `/{tenant}/` -> Beranda (`tenant.home`)
  2. `/{tenant}/profil` -> Profil sekolah (`tenant.profil`)
  3. `/{tenant}/program-keahlian` & `/{tenant}/program-keahlian/{slug}` (`tenant.program-keahlian`, `tenant.program-keahlian.detail`)
  4. `/{tenant}/berita` & `/{tenant}/berita/{slug}` (`tenant.berita`, `tenant.berita.detail`)
  5. `/{tenant}/agenda` & `/{tenant}/agenda/{slug}` (`tenant.agenda`, `tenant.agenda.detail`)
  6. `/{tenant}/pengumuman` & `/{tenant}/pengumuman/{slug}` (`tenant.pengumuman`, `tenant.pengumuman.detail`)
  7. `/{tenant}/prestasi` & `/{tenant}/prestasi/{slug}` (`tenant.prestasi`, `tenant.prestasi.detail`)
  8. `/{tenant}/kegiatan` (`tenant.kegiatan`)
  9. `/{tenant}/ekstrakurikuler` & `/{tenant}/ekstrakurikuler/{slug}` (`tenant.ekstrakurikuler`, `tenant.ekstrakurikuler.detail`)
  10. `/{tenant}/guru-staf` (`tenant.guru-staf`)
  11. `/{tenant}/fasilitas` (`tenant.fasilitas`)
  12. `/{tenant}/galeri` (`tenant.galeri`)
  13. `/{tenant}/spmb` & `/{tenant}/ppdb` (`tenant.spmb`, `ppdb`)
  14. `/{tenant}/kontak` (GET & POST) (`tenant.kontak`, `tenant.kontak.kirim`)
  - Submenu & backward compatibility aliases terdaftar (`profil/*`, `akademik/*`, `kesiswaan/*`, `informasi/*`).
- [x] Implementasi `HomeController` & `PageController`:
  - Feature flag check (`checkFitur($kode)`) -> abort 404 jika nonaktif.
  - Form validation & insert ke tabel `pesan_masuk`.
  - Pagination, search query, dan filter tags.

---

### Tahap 4: UI/UX & Responsive Views (Selesai)
- [x] `layouts/public.blade.php`: Kontainer max 1200px, padding responsive, tipografi Inter & Outfit, drawer menu mobile, modal lightbox foto/video, top bar identitas, flash toast.
- [x] `public/home.blade.php`: Hero carousel, Quick links, Sambutan Kepsek, Animasi Counter Statistik, Grid 7 Jurusan, Berita & Pengumuman, Agenda, Prestasi, Galeri, Banner SPMB, Peta Google Maps.
- [x] `public/pages/profil.blade.php`: Profil lengkap sejarah, visi-misi, pimpinan, statistik.
- [x] `public/pages/jurusan.blade.php` & `jurusan_detail.blade.php`: Grid 7 jurusan & detail kurikulum, silabus, prospek kerja, CTA SPMB.
- [x] `public/pages/berita.blade.php` & `berita_detail.blade.php`: Search, filter kategori, pagination, reading view 760px, share buttons, related posts.
- [x] `public/pages/agenda.blade.php` & `agenda_detail.blade.php`: Filter tab mendatang/lampau/semua, calendar badge, waktu, lokasi, detail rundown.
- [x] `public/pages/pengumuman.blade.php` & `pengumuman_detail.blade.php`: Tampilan surat edaran kedinasan, print button, sidebar pengumuman terbaru.
- [x] `public/pages/prestasi.blade.php` & `prestasi_detail.blade.php`: Filter tingkat & tahun, medal badge, detail pemenang dan foto penghargaan.
- [x] `public/pages/kegiatan.blade.php`: Galeri dokumentasi aktivitas dan jadwal event mendatang.
- [x] `public/pages/ekstrakurikuler.blade.php` & `ekstrakurikuler_detail.blade.php`: 8 ekskul resmi, jadwal, pembina, detail program.
- [x] `public/pages/guru.blade.php`: Direktori 98 pendidik dengan search nama/mapel, kartu profil profesional.
- [x] `public/pages/fasilitas.blade.php`: Rasio 4:3 sarana prasarana dengan trigger lightbox.
- [x] `public/pages/galeri.blade.php`: Filter album, grid foto/video interaktif dengan modal lightbox Alpine.js.
- [x] `public/pages/spmb.blade.php`: Panduan PPDB, jalur afirmasi/prestasi/zonasi, jadwal, syarat berkas, daya tampung rombel, helpdesk.
- [x] `public/pages/kontak.blade.php`: Info kantor, jam layanan, WhatsApp, Google Maps embed, form kirim pesan tervalidasi.

---

### Tahap 5: QA, Testing, & Anti-Slop Validation (Selesai)
- [x] Pest Feature Test `TenantPublicPagesTest`: 15 skenario pengujian (14 canonical pages + form kontak insert DB + feature flag 404 test) -> **15/15 PASSED (55 assertions)**.
- [x] Full Test Suite: **33/33 PASSED (123 assertions, 100% Green)**.
- [x] Formatter Laravel Pint: Berhasil dijalankan di seluruh file (`vendor/bin/pint --dirty`).
- [x] Anti-slop audit: Tidak ada placeholder atau data generik, seluruh data bersumber dari identitas dan Dapodik riil SMK Negeri 2 Bandung.

---

### Tahap 6: Redesain Publik Base Tailwind & Kalender Interaktif (Selesai)
- [x] Integrasi estetika Base Tailwind pada `layouts/public.blade.php`: Header sticky modern, topbar informasi kontak, drawer mobile, modal lightbox.
- [x] Pembaruan halaman publik (`home.blade.php`, `kalender.blade.php`, `spmb.blade.php`, `kontak.blade.php`, dll.) dengan grid cards, section titles terpusat, dan kontras WCAG AA.
- [x] Perombakan `agenda.blade.php` mengadopsi 3-kolom referensi Events:
  - [x] Sidebar kalender interaktif (Alpine.js navigator bulan/tahun, penanda titik event per tanggal, pemilihan tanggal aktif).
  - [x] Kategori agenda pills di sidebar.
  - [x] Kartu agenda horizontal di kolom kanan (gambar cover kiri, badge tanggal, jam, lokasi, status, dan rincian aksi).
  - [x] Hero section highlight agenda unggulan.
- [x] Update controller `PageController@agenda` menyuplai `$allAgenda` & `$featuredAgenda`.
- [x] Pest automated tests pass (33 tests, 123 assertions).

---

### Tahap 7: Penyederhanaan Panel Admin Sekolah (Hanya Tema & Warna) (Selesai)
- [x] Sidebar admin (`resources/views/layouts/tenant_admin.blade.php`) disisakan satu menu: **Tema & Warna**; brand header sidebar menaut ke halaman pengaturan tema.
- [x] 16 controller dan 36 view modul admin lain dihapus dari sistem; komponen `resources/views/components/admin/*` dan `App\Services\ImageService` yang tidak terpakai dibersihkan, termasuk aset CDN Quill.
- [x] Grup rute `tenant.admin.*` tersisa `login`, `login.submit`, `logout`, `pengaturan.index`, dan `pengaturan.update`; shortcut `/admin` mengarah ke `/{tenant}/admin/pengaturan`.
- [x] Halaman `tenant/admin/pengaturan/index.blade.php` hanya memuat panel Tema & Warna (7 preset, 6 grup rincian warna, custom hex, pratinjau langsung) tanpa navigasi tab dan tanpa kartu navigasi modul lain.
- [x] `PengaturanController` hanya memvalidasi & menyimpan `skema_tema` + 13 kunci warna dengan pesan validasi Bahasa Indonesia.
- [x] Login admin sekolah langsung diarahkan ke halaman pengaturan tema, termasuk saat admin yang sudah login membuka halaman login.
- [x] Database utuh: seluruh migrasi, tabel tenant, model `App\Models\Tenant\*`, seeder, dan data konten (7 jurusan, 10 artikel, slider, agenda, prestasi, ekskul, guru, fasilitas, galeri, SPMB, kontak) tidak diubah dan tetap tampil pada portal publik.
- [x] Pest `TenantAdminTest` diperbarui menjadi 9 skenario (proteksi auth, redirect login, isi sidebar, 404 rute lama, penyimpanan palet, integritas data tenant) dengan full suite **36 test / 135 assertions PASSED**.
- [x] Laravel Pint bersih pada seluruh berkas PHP yang diubah (`vendor/bin/pint --dirty`).

---

### Tahap 8: Sistem Warna Global Terkelompok (13 Kunci, 6 Grup) (Selesai)
- [x] `resources/css/public.css` memuat fallback 13 variabel `--theme-*`, **Legacy Utility Mapping** utilitas netral (`bg-white`, `bg-slate-50/100/200`, `border-slate-*`, `text-slate-*` → variabel tema dengan `!important`, zona gelap dikecualikan lewat `:is(...)`), kelas global (`.theme-*`), serta `footer` yang memakai `--theme-footer-bg`.
- [x] `layouts/public.blade.php` menginjeksi 13 variabel warna dari `$sekolah`; `<body>`, header, dan footer memakai kelas `.theme-page-bg`, `.theme-text-body`, `.theme-header`, `.theme-footer`.
- [x] `HomeController` & `PageController` menyiapkan 13 kunci warna + `skema_tema`; `PengaturanController` memvalidasi 13 kunci; seeder `TenantSmkn2BandungSeeder` menulis kunci default ke `pengaturan_umum`.
- [x] Panel admin menampilkan 6 grup warna (A-F) dengan 13 color picker + input hex tersinkronisasi, pratinjau langsung (header, section + kartu, footer), dan legenda kelas global.
- [x] Test Pest `TenantThemeColorTest` (5 skenario) lulus; full suite **41 test / 243 assertions PASSED**.
- [x] `npm run build` sukses (`public/build/assets/public-CU8YmPSe.css`, 14.58 kB); request HTTP nyata membuktikan seluruh 13 variabel `--theme-*` tersuntik sesuai palet uji `#BE123C`.
- [x] **Penutup celah kelas warna (Tailwind v4 Palette Override):** `public.css` menimpa `--color-blue-*`/`--color-indigo-*` → skala `--theme-identity-*`, `--color-sky-*`/`--color-amber-*`/`--color-orange-*` → skala `--theme-accent-*`, `--color-slate-*` → skala `--theme-neutral-*`, pola radial `#38bdf8` → aksen, dan `border-slate-*/80|60` → `--theme-border`.
- [x] Test Pest skenario `pemetaan palet Tailwind v4 menutup kelas warna yang lolos dari tema` ditambahkan; full suite **42 test / 254 assertions PASSED**; `npm run build` menghasilkan `public-DCqQ4nZP.css` (20.03 kB) dan request HTTP nyata menautkan stylesheet hash baru tersebut.
- [x] **Kelompok warna lengkap tanpa pengecualian (permintaan pemilik produk):** 12 keluarga tambahan ikut terpetakan di `:root` (purple/violet/fuchsia/pink → identitas; green/emerald/lime/teal/cyan/yellow/red/rose → aksen; gray/zinc/stone/neutral → netral) beserta `--color-white` → `--theme-btn-text`; 37 dasar campuran `color-mix(..., white)` → `warna_latar_halaman` dan titik radial hero → `--theme-accent-400`; seluruh literal putih hardcoded (header/footer, breadcrumb, amber dark card, aturan zona gelap) diganti kunci panel `warna_tombol_teks`; pratinjau panel admin memakai `btnText`/`pageBg`; tombol WhatsApp `bg-[#25D366]` + `hover:bg-[#20ba5a]` → aksen. Full suite **42 test / 278 assertions PASSED**; `npm run build` → `public-CCKXuORS.css` (28,54 kB); request HTTP port 8000 & 8123 menautkan stylesheet hash baru tersebut.

---

### Tahap 9: Pusat Manajemen Media Induk (File Manager) (Selesai)
- [x] Tabel database tenant `media` (100% berelasi via Foreign Key `pengguna_id` ke `pengguna.id`).
- [x] Model Eloquent `App\Models\Tenant\Media` dengan relasi dua arah ke `Pengguna` (`$media->pengguna` & `$pengguna->medias`).
- [x] Service komprehensif `App\Services\MediaService`:
  - [x] Otomatis kompresi gambar dan konversi ke `.webp` via PHP GD (maks 1920px, kualitas 82%).
  - [x] Penanganan berkas video upload lokal (MP4/WebM) dan dokumen PDF.
  - [x] Pendaftaran video YouTube dengan ekstraksi ID dan poster thumbnail otomatis.
  - [x] Impor media via URL eksternal dengan live checking HTTP & thumbnail preview.
  - [x] Editor gambar interaktif (Crop aspek rasio 16:9, 4:3, 1:1, Bebas & Rotate 90°).
  - [x] Manajemen berkas: ubah judul/nama file, alt text SEO, kategori, copy link URL, dan hapus berkas fisik dari storage.
- [x] Migrator data media existing `TenantMediaSeeder`: 24 aset media dari tabel lama termigrasi ke tabel induk `media`.
- [x] Controller `MediaController` dan 7 endpoint rute admin tenant (`auth:tenant_admin`).
- [x] Antarmuka admin `resources/views/tenant/admin/media/index.blade.php` (Grid Bento, modal upload, modal import URL, modal editor canvas, modal rename).
- [x] Menu *Manajemen Media* di sidebar admin sekolah (`layouts/tenant_admin.blade.php`).
- [x] Feature test `TenantMediaTest` (8 skenario); Full test suite **51 test / 317 assertions PASSED (100% Green)**.

---

### Tahap 10: Auto-Kontras WCAG Server-side & Client-side (Selesai)
- [x] Helper `App\Support\WarnaKontras` (`app/Support/WarnaKontras.php`): `luminans()`, `rasio()`, `pilihTeks()`, `campurWarna()` mengikuti rumus luminance WCAG 2.1; menerima hex 3/6 digit, format tidak dikenal dianggap terang supaya teks tidak pernah ikut hilang.
- [x] **Lapis server-side** `resources/views/layouts/public.blade.php`: closure `$kontras()` menyuntik 16 kunci teks per permukaan (`--theme-fg-header`, `--theme-fg-footer`, `--theme-fg-zona`, `--theme-fg-tombol`, `--theme-fg-aksen`, `--theme-fg-link`, `--theme-fg-badge`, `--theme-fg-halaman-*`, `--theme-fg-section-*`, `--theme-fg-kartu-*`) dengan ambang 4.5:1 (isi), 3:1 (tombol), 2:1 (tautan).
- [x] **Lapis client-side** `resources/css/public.css`: `@property --kontras-aman` + `--kontras-terang` dan detektor `calc(var(--fg) contrast(var(--bg)) >= 4.5)`; `--fg-zona-efektif` diselesaikan per scope (`:root`, `.theme-page-bg`, `.theme-section-bg`, `.theme-card`/`.bg-white/80|90`, `.theme-badge`, `.theme-bg`/`bg-blue-900`, `.theme-header`, `footer.theme-bg`/`footer.theme-footer`).
- [x] `--theme-fg-zone` dinormalkan menjadi `--theme-fg-zona`; `--theme-btn-text`, `color-mix(..., black)`, dan putih hardcoded pada `.text-blue-900/950`, `.theme-btn-ghost`, `.theme-table-head`, `.theme-input`, `nav .text-blue-950`, badge, dan zona gelap diganti resolver hasil auto-kontras.
- [x] Pratinjau panel tema `resources/views/tenant/admin/pengaturan/index.blade.php` memakai salinan JS `WarnaKontras` + computed getter (`fgHeader`, `fgFooter`, `fgTombol`, `fgAksen`, `fgKartuHeading`, `fgKartuTeks`, `fgKartuMuted`, `fgSectionHeading`, `fgBadge`, `fgLink`) sehingga pratinjau identik dengan render publik.
- [x] Unit test `tests/Unit/WarnaKontrasTest.php` (7 skenario / 22 assertion) + 3 skenario auto-kontras pada `tests/Feature/TenantThemeColorTest.php` (mempertahankan warna lolos AA; memaksa putih pada kartu `#052E1F` dan tinta pada header `#F1F5F9`; memastikan scope CSS terpasang).
- [x] Verifikasi: full suite **63 test / 377 assertions PASSED**; `vendor/bin/pint --dirty` passed; `npm run build` menghasilkan `public/build/assets/public-CMXtt0o7.css` (34.00 kB, gzip 4.52 kB) yang tetap memuat 2 blok `@property`, 11 panggilan `contrast()`, dan 26 rujukan `--fg-zona-efektif`.


## Tahap 11: Penegakan Aturan Tema & Auto-Kontras (Dokumentasi)
**Status:** Selesai

- [x] Rule operasional dibuat di `.ai/rules/publik-tema-kontras.md` + indeks `.ai/rules/index.md` (dibaca otomatis sesuai `AGENTS.md` bagian 2 Langkah 2) sehingga tiap permintaan tambah menu/halaman/section publik ditulis mengikuti pola auto-kontras.
- [x] Referensi teknis `docs/08-CSS-ARSITEKTUR-TEMA.md`: diagram alur warna, tabel 13 kunci panel + 16 kunci `--theme-fg-*`, registri 8 scope, inventaris kelas `.theme-*`, resep cepat, fallback browser, verifikasi.
- [x] `docs/RULES.md` bagian 8 "Standar Tema & Auto-Kontras CSS (Portal Publik)" (8 poin mengikat).
- [x] `docs/05-UI-UX.md` menautkan rule dan dokumen teknis pada bagian Auto-Kontras WCAG.
- [x] Tidak ada perubahan kode runtime; test suite tidak terdampak.


---

## Tahap 12: Pembersihan Kontrol Tidak Terpakai pada Admin Profil Sekolah
**Status:** Selesai

- [x] Dropdown **"Pola Dekorasi Latar"** dihapus dari 4 tab admin Profil Sekolah (`resources/views/tenant/admin/profil/index.blade.php`) karena tidak dipakai operator sekolah.
- [x] `ProfilController` tidak lagi memvalidasi/menulis `pola_latar_profil`, `pola_latar`, dan `pola_latar_struktur` pada `updateIdentitas()`, `updateHalaman()`, dan `updateStruktur()` sehingga nilai tersimpan tidak ditimpa lagi menjadi `dots`.
- [x] Kolom `halaman_statis.pola_latar`, `$fillable` model `Page`, dan rendering pola hero publik (`profil`, `sejarah`, `visi-misi`, `struktur`) dipertahankan agar tidak ada data hilang dan tampilan publik tidak berubah.
- [x] Layout form hero dirapikan: judul halaman `sm:col-span-2` pada tab Sejarah dan Visi & Misi, panel hero Struktur satu kolom.
- [x] Verifikasi: full suite Pest **70 test / 429 assertions PASSED**, `vendor/bin/pint --dirty` bersih, `php artisan view:clear` dijalankan.

---

## Tahap 13: Pembersihan Mode Tampilan Struktur & Perbaikan Fatal View Publik
**Status:** Selesai

- [x] Radio **"Mode Pilihan Tampilan Halaman Struktur Publik"** (`semua` / `pejabat` / `diagram`) dihapus dari tab Struktur Organisasi admin (`resources/views/tenant/admin/profil/index.blade.php`).
- [x] Kunci `mode_tampilan_struktur` tidak lagi divalidasi/disimpan di `ProfilController::updateStruktur()` dan tidak lagi diambil di `ProfilController::index()` maupun `Tenant\Public\PageController::struktur()`.
- [x] Halaman publik `/profil/struktur` selalu menampilkan Tab Jajaran Pejabat + Tab Bagan Diagram (default tab "Jajaran Pejabat").
- [x] Bug fatal `@if($mode === 'semua' || $mode === 'pejabat')` tanpa `@endif` pada `resources/views/public/pages/struktur.blade.php` diperbaiki; kompilasi Blade dan `php -l` kini bersih.
- [x] Regression test: `TenantPublicPagesTest` skenario `2b` (halaman struktur publik 200 + kedua bagian tampil) dan `TenantAdminProfilTest` memastikan kontrol `pola_latar_profil` serta `mode_tampilan_struktur` tidak muncul lagi di form admin.
- [x] Verifikasi: full suite Pest **71 test / 435 assertions PASSED**; `vendor/bin/pint --dirty` bersih; `php artisan view:clear` dijalankan.


---

## Tahap 14: Kelengkapan Field Hero Banner Tab Struktur Organisasi
**Status:** Selesai

- [x] Tab Struktur Organisasi admin kini memuat **Judul Halaman**, **Deskripsi Ringkas / Subjudul Hero**, dan **Foto Banner / Sampul (Pusat Media)** seperti tab Sejarah dan Visi & Misi.
- [x] `ProfilController::updateStruktur()` memvalidasi `judul_struktur` + `gambar_banner_struktur`, menyinkronkan banner ke Pusat Media, dan menyimpan `judul`/`subjudul`/`gambar_banner` ke `halaman_statis` slug `struktur` (sebelumnya judul di-hardcode `'Struktur Organisasi Sekolah'` dan banner tidak pernah disimpan).
- [x] Halaman publik `/profil/struktur` menampilkan banner di atas section konten (21:9, `max-h-[420px]`) dan `<title>` mengikuti judul dari admin.
- [x] Test baru `TenantAdminProfilTest` membuktikan penyimpanan database, relasi `pengguna_id`, dan tampilan judul + banner di halaman publik.
- [x] Blok header kartu tab Struktur ("Kelola Struktur Organisasi & Data Pejabat") ditambahkan agar konsisten dengan tab Sejarah dan Visi & Misi; diafirmasi test admin.
- [x] Verifikasi: full suite Pest **72 test / 453 assertions PASSED**; `vendor/bin/pint --dirty` passed; `php artisan view:clear` dijalankan.

---

---

## Tahap 16: Pengaturan Program Keahlian / Jurusan CMS & Manajemen Hero
**Status:** Selesai

- [x] Membuat modul mandiri Pengaturan Program Keahlian Admin CMS (`resources/views/tenant/admin/jurusan/`) dengan struktur tab terpadu:
  - **Tab 1: Daftar Konsentrasi & Program Keahlian** (`tab-jurusan.blade.php`) - Tabel interaktif, thumbnail rasio baku 4:3, tombol toggle status publikasi instan (AJAX), tombol edit modal & hapus modal kustom.
  - **Tab 2: Form Program Keahlian** (`tab-form-jurusan.blade.php`) - Form input mandiri dedikasi luas dengan auto-slug generator, dual WYSIWYG editor Quill.js, dropdown relasi kepala program keahlian (`guru_id` FK ke `guru_staf`), galeri multi-foto dokumentasi bengkel/lab, dan pemilih berkas Pustaka Media.
  - **Tab 3: Hero Banner Publik** (`tab-hero.blade.php`) - Kustomisasi judul, subjudul, dan foto sampul 16:9 yang terhubung dengan Pusat Media.
  - **Tab 4: Visibilitas Menu & Rute** (`tab-visibilitas.blade.php`) - Sakelar feature flag `program_keahlian` yang otomatis menyinkronkan navbar, katalog beranda, dan proteksi rute 404 publik.
- [x] Controller `JurusanController` (`App\Http\Controllers\Tenant\Admin\JurusanController`): Mengelola `index`, `updateHero`, `store`, `update`, `destroy`, dan `toggleStatus` dengan auto-sinkronisasi `MediaService`.
- [x] Model `Jurusan` (`App\Models\Tenant\Jurusan`): Menambahkan helper `$jurusan->foto_crop_style` dan `$jurusan->foto_focal_position`.
- [x] Sidebar Admin (`resources/views/layouts/tenant_admin.blade.php`): Menambahkan link menu navigasi "Program Keahlian" di bawah "Profil Sekolah".
- [x] Halaman Publik `jurusan.blade.php` & `jurusan_detail.blade.php`: Terhubung dinamis dengan data hero banner yang disimpan admin serta rasio baku media 4:3 dengan double-layer ambient backdrop.
- [x] Automated Feature Test: `tests/Feature/TenantAdminJurusanTest.php` mencakup pengujian aksesibilitas tab admin, update hero banner, CRUD jurusan, dan sakelar visibilitas fitur publik.
- [x] Verifikasi: Full suite Pest **79 test / 525 assertions PASSED** (100% Green).

---

## Tahap 17: Modul CMS Informasi Sekolah Terpadu (Sidebar Multi-Navigasi 5 Sub-Modul)
**Status:** Selesai

- [x] Membuat 5 sub-navigasi independen untuk Informasi Sekolah di sidebar admin:
  - **1. Berita & Artikel** (`/berita`): CRUD berita, editor WYSIWYG Quill.js, filter kategori & status publikasi, pencarian, hero banner, dan feature toggle status.
  - **2. Pengumuman Resmi** (`/pengumuman`): CRUD pengumuman kedinasan, filter draft/published, WYSIWYG editor, hero banner, dan feature toggle status.
  - **3. Agenda & Kegiatan** (`/agenda`): Manajemen kalender agenda (tgl mulai/selesai, jam mulai/selesai, lokasi, penyelenggara, deskripsi Quill.js, link formulir registrasi daring), hero banner, dan feature toggle status.
  - **4. Galeri Foto & Video** (`/galeri`): Manajemen album dokumentasi (foto/video), cover album, manajemen item media/YouTube dalam album, hero banner, dan feature toggle status.
  - **5. Sarana & Fasilitas** (`/fasilitas`): Manajemen katalog fasilitas (foto utama rasio 4:3, repeater galeri multi-foto), counter statistik sarpras (`stats_ruang_kelas`, `stats_bengkel_lab`, `stats_perpustakaan`, `stats_akses_internet`), hero banner, dan feature toggle status.
- [x] Controller `InformasiController` (`App\Http\Controllers\Tenant\Admin\InformasiController`): Menyediakan endpoint CRUD lengkap 5 modul, sinkronisasi otomatis `MediaService`, update hero banner global, dan toggle status AJAX.
- [x] Desain & Interaksi Konsisten Tailgrids: Seluruh blade view (`berita.blade.php`, `pengumuman.blade.php`, `agenda.blade.php`, `galeri.blade.php`, `fasilitas.blade.php`) menggunakan pola visual modern, indikator loading spinner (anti-freeze), toast notification terpadu, modal konfirmasi kustom (bukan native browser confirm), dan integrasi pemilih berkas Media Picker.
---

## Tahap 18: Pemindahan Pengaturan Visibilitas Menu & Rute ke Super Admin Platform (Central)
**Status:** Selesai

- [x] Sentralisasi Kontrol Visibilitas ke Super Admin (`/superadmin/tenants/{tenant}`):
  - Super Admin kini memiliki wewenang eksklusif untuk mengaktifkan/menonaktifkan modul menu navbar dan rute publik tenant (`menus` & `pengaturan_fitur`).
  - Mendukung kontrol tingkat menu induk, rute publik, serta sub-komponen cascading (data pokok, sambutan kepsek, video profil, bagan struktur, daftar pejabat, dll.).
- [x] Backend Controller Central (`App\Http\Controllers\Central\TenantController`):
  - Method `show()` membaca konfigurasi `pengaturan_fitur` & `menus` dari database tenant secara dinamis.
  - Method `toggleMenu()` melakukan update AJAX dengan dynamic database switching (`tenant_{slug}`) dan auto-cascading state.
- [x] Antarmuka Tailgrids & Interaksi Anti-Freeze:
  - Kartu kontrol visibilitas dilengkapi dengan toggle switch interaktif Alpine.js, spinner animasi ("Menyinkronkan..."), status badge sukses, dan penanganan error responsif tanpa reload halaman.
- [x] Pembersihan Panel Admin Sekolah:
  - Tab 5 Visibilitas dihapus dari Pengaturan Profil Sekolah (`tab-visibilitas.blade.php`).
  - Tab 4 Visibilitas dihapus dari Pengaturan Program Keahlian / Jurusan (`tab-visibilitas.blade.php`).
  - Admin Sekolah kini fokus murni pada pengelolaan konten, media, dan tema visual portal sekolah.
- [x] Automated Feature Test:
  - `tests/Feature/SuperAdminAuthTest.php` memvalidasi akses Super Admin dan eksekusi toggle menu AJAX.
  - `tests/Feature/TenantAdminProfilTest.php` & `tests/Feature/TenantAdminJurusanTest.php` disinkronkan.
- [x] Verifikasi: Full suite Pest **92 test / 618 assertions PASSED** (100% Green).





