# Dokumen Arsitektur Sistem (ARCHITECTURE)
**Nama Proyek:** Template Website Sekolah Multi-Tenant (SaaS)
**Versi:** 1.0.0
**Dokumen Terkait:** [PRD.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/01-PRD.md) | [DATABASE.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/03-DATABASE.md) | [CHANGELOG.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/04-CHANGELOG.md)

---

## 1. Pola & Arsitektur Utama

Aplikasi dirancang dengan pola **Model-View-Controller (MVC)** standar Laravel yang diperluas dengan kemampuan **Multi-Tenancy** (menggunakan package `stancl/tenancy`).

### A. Multi-Tenancy Architecture (Multi-Database MySQL)
1. **Central Domain (`routes/web.php`):**
   - Menghandle halaman registrasi SaaS, landing page produk, dan Dashboard Super Admin.
   - Menggunakan database utama (`website_sekolah_central`).
2. **Tenant Domain (`routes/tenant.php`):**
   - Menghandle website masing-masing sekolah (frontend publik dan admin dashboard sekolah).
   - Setiap sekolah memiliki database MySQL terisolasi (`tenant_<id>`).
   - Identifikasi tenant dilakukan melalui Subdomain (misal `sdn1.domain.com`) atau Kustom Domain (misal `sdn1jakarta.sch.id`).

---

## 2. Struktur Folder & Modul Direktori

```text
website_sekolah/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Central/               # Controller untuk Super Admin & Landing SaaS
│   │   │   │   ├── TenantController.php
│   │   │   │   └── DashboardController.php
│   │   │   └── Tenant/                # Controller untuk Website & Admin Sekolah
│   │   │       ├── Public/            # Controller Frontend Publik
│   │   │       │   ├── HomeController.php
│   │   │       │   ├── ProfilController.php
│   │   │       │   ├── AkademikController.php
│   │   │       │   ├── BeritaController.php
│   │   │       │   ├── GaleriController.php
│   │   │       │   ├── PpdbController.php
│   │   │       │   ├── UnduhanController.php
│   │   │       │   └── KontakController.php
│   │   │       └── Admin/             # Controller Panel Admin Sekolah
│   │   │           ├── AuthController.php        # Login & logout admin sekolah
│   │   │           └── PengaturanController.php  # Pengaturan tema & palet warna portal
│   │   └── Middleware/
│   ├── Models/
│   │   ├── Central/                   # Model untuk Central (Sekolah, Domain, SuperAdmin)
│   │   │   ├── Sekolah.php
│   │   │   └── DomainSekolah.php
│   │   └── Tenant/                    # Model untuk Tenant (Bahasa Indonesia)
│   │       ├── Pengguna.php
│   │       ├── PengaturanUmum.php
│   │       ├── PengaturanFitur.php
│   │       ├── SosialMedia.php
│   │       ├── HalamanStatis.php
│   │       ├── SliderBeranda.php
│   │       ├── StrukturOrganisasi.php
│   │       ├── GuruStaf.php
│   │       ├── Jurusan.php
│   │       ├── Fasilitas.php
│   │       ├── FotoFasilitas.php
│   │       ├── KalenderAkademik.php
│   │       ├── KategoriArtikel.php
│   │       ├── Artikel.php
│   │       ├── GaleriAlbum.php
│   │       ├── GaleriItem.php
│   │       ├── Unduhan.php
│   │       ├── PesanMasuk.php
│   │       ├── PengaturanPpdb.php
│   │       └── PendaftarPpdb.php
│   └── Services/
│       ├── ImageOptimizationService.php  # Service kompresi & konversi WebP
│       └── FeatureToggleService.php      # Helper pengecekan status toggle aktif
├── config/
│   ├── tenancy.php                    # Konfigurasi Stancl Tenancy
│   └── filesystems.php                # Konfigurasi Storage & S3
├── database/
│   └── migrations/
│       ├── central/                   # Migrasi untuk Database Central
│       │   ├── 2026_01_01_000001_create_sekolah_table.php
│       │   └── 2026_01_01_000002_create_domain_sekolah_table.php
│       └── tenant/                    # Migrasi untuk Database Tenant (Sekolah)
│           ├── 2026_01_01_000003_create_pengguna_table.php
│           ├── 2026_01_01_000004_create_pengaturan_umum_table.php
│           ├── 2026_01_01_000005_create_pengaturan_fitur_table.php
│           └── ... (migrasi tabel tenant lainnya)
├── docs/                              # Dokumentasi Proyek Terpadu
│   ├── 01-PRD.md
│   ├── 02-ARCHITECTURE.md
│   ├── 03-DATABASE.md
│   └── 04-CHANGELOG.md
├── resources/
│   ├── css/
│   │   └── app.css                    # Tailwind CSS Config
│   ├── js/
│   │   └── app.js                     # Alpine.js init & custom scripts
│   └── views/
│       ├── layouts/
│       │   ├── public.blade.php       # Master layout publik (dinamis warna & tema)
│       │   ├── admin.blade.php        # Master layout admin CMS tenant
│       │   └── central.blade.php      # Master layout super admin
│       ├── components/                # Reusable Blade components
│       ├── public/                    # View halaman publik
│       └── admin/                     # View dashboard admin sekolah
└── routes/
    ├── web.php                        # Rute Central / Super Admin
    └── tenant.php                     # Rute Tenant / Website Sekolah
```

---

## 3. Strategi Pengolahan Media & Penyimpanan

### A. Pipeline Konversi & Kompresi WebP
1. **Upload Handler:** Setiap upload gambar melewati `ImageOptimizationService`.
2. **Intervention Image Processing:**
   - Membaca file gambar masukan (JPG, PNG, GIF).
   - Melakukan auto-orientasi dan pembatasan resolusi maksimal (misal: lebar max 1600px).
   - Melakukan *encoding* ke format modern **`.webp`** dengan kualitas kompresi optimal (80%).
   - Menyimpan versi thumbnail otomatis (resolusi 400px) untuk galeri dan daftar artikel.
3. **Hasil:** Penghematan ruang disk 60-80% dan peningkatan skor Core Web Vitals (LCP).

### B. Abstraksi Penyimpanan (Local Disk ke Amazon S3)
- Menggunakan `Illuminate\Support\Facades\Storage`.
- Penyimpanan file tidak pernah menggunakan path hardcoded, melainkan `Storage::disk(config('filesystems.default'))->url($path)`.
- **Fase Development:** Menggunakan driver `public` lokal.
- **Fase Production/Cloud:** Cukup mengganti variabel di `.env`:
  ```env
  FILESYSTEM_DISK=s3
  AWS_ACCESS_KEY_ID=xxx
  AWS_SECRET_ACCESS_KEY=xxx
  AWS_DEFAULT_REGION=xxx
  AWS_BUCKET=xxx
  ```
  Tidak ada satu baris kode PHP pun yang perlu diubah.

---

## 4. Mekanisme Feature Toggle (Module Manager)
1. Tabel `pengaturan_fitur` menyimpan status `kode_fitur` (misal: `fitur_jurusan`, `fitur_ppdb`, `fitur_kalender`) dan `is_aktif` (boolean).
2. Disediakan Blade Directive / Helper `@if(fitur_aktif('fitur_jurusan')) ... @endif` dan Middleware pengecekan rute.
3. Jika sebuah fitur dinonaktifkan oleh admin sekolah:
   - Menu navigasi publik disembunyikan.
   - Rute publik terkait menghasilkan respons 404 (Not Found) atau redirect ramah.
   - Menu manajemen di dashboard admin sekolah disembunyikan atau diberi label nonaktif.
