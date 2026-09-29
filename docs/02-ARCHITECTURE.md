# Architecture Document — Website Sekolah

## 1. Pola Arsitektur Multi-Tenant

Sistem menggunakan arsitektur **Single Codebase, Database Per Tenant**:
- **Database Central (`website_sekolah_central`):** Menyimpan tabel `sekolah`, `domain_sekolah`, dan `super_admin`.
- **Database Tenant (`tenant_{slug}`):** Menyimpan seluruh data operasional sekolah: `pengaturan_umum`, `pengaturan_fitur`, `menus`, `halaman_statis`, `jurusan`, `artikel`, `agenda`, `galeri_album`, `guru_staf`, `fasilitas`, `ekstrakurikuler`, `prestasi_siswa`, `pesan_masuk`, dsb.

```
                          ┌────────────────────────┐
                          │  HTTP Request Browser  │
                          └───────────┬────────────┘
                                      │
                                      ▼
                        ┌───────────────────────────┐
                        │     TenantMiddleware      │
                        │ 1. Parse {tenant} / Host  │
                        │ 2. Find Sekolah Record    │
                        │ 3. Switch Connection 'db' │
                        └─────────────┬─────────────┘
                                      │
               ┌──────────────────────┴──────────────────────┐
               ▼                                             ▼
  ┌─────────────────────────┐                   ┌─────────────────────────┐
  │      Central DB         │                   │        Tenant DB        │
  │ website_sekolah_central │                   │  tenant_smk_negeri_2... │
  │ - sekolah               │                   │ - artikel, guru_staf    │
  │ - domain_sekolah        │                   │ - jurusan, fasilitas    │
  │ - super_admin           │                   │ - agenda, galeri_album  │
  └─────────────────────────┘                   └─────────────────────────┘
```

## 2. Struktur Layer Aplikasi

1. **Routing (`routes/web.php`):**
   - Rute Central: `/superadmin/*` (Super Admin dashboard & manajemen tenant).
   - Landing SaaS: `/` (Beranda promosi sistem SaaS).
   - Rute Tenant: `/{tenant}/*` (Seluruh rute publik sekolah melalui `TenantMiddleware`).
2. **Middleware:**
   - `TenantMiddleware`: Mengidentifikasi sekolah, memvalidasi status aktif, melakukan *tenant database switching*, mengeset default URL parameter `tenant`, dan binding instance `tenant` ke service container.
3. **Controller Layer:**
   - `App\Http\Controllers\Tenant\Public\HomeController`: Menyajikan beranda sekolah dengan agregasi data modul yang aktif.
   - `App\Http\Controllers\Tenant\Public\PageController`: Menyajikan halaman listing dan detail profil, jurusan, berita, agenda, pengumuman, prestasi, kegiatan, ekskul, guru-staf, fasilitas, galeri, SPMB, dan kontak.
   - `App\Http\Controllers\Tenant\Admin\AuthController`: Menangani login/logout Admin Sekolah dan mengarahkan admin langsung ke panel pengaturan tema.
   - `App\Http\Controllers\Tenant\Admin\PengaturanController`: Mengelola `skema_tema` dan 7 kunci warna palet pada tabel tenant `pengaturan_umum` (7 preset, custom hex, live preview).
   - Modul admin sekolah lainnya (dashboard, slider, profil, struktur, jurusan, berita, pengumuman, agenda, galeri, prestasi, ekskul, guru, fasilitas, SPMB, kontak, media) dihapus dari sistem pada 2026-09-29. Data, model, migrasi, dan seeder tetap utuh.
4. **Model Layer (`app/Models/Tenant`):**
   - Menggunakan koneksi default `tenant` yang telah diset oleh middleware.
   - Dilengkapi fungsi helper seperti `PengaturanFitur::isAktif($kodeFitur)`.
5. **View Layer (`resources/views`):**
   - `layouts/public.blade.php`: Kerangka utama responsive dengan topbar, header sticky, navigasi dinamis, drawer mobile, modal lightbox, dan footer.
   - `public/home.blade.php`: Beranda modular berbasis section.
   - `public/pages/*`: Template listing dan detail artikel, agenda, jurusan, profil, ekskul, prestasi, galeri, guru, fasilitas, SPMB, kontak.
