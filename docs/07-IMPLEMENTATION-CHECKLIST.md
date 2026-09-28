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
