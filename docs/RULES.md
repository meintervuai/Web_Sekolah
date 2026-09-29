# Aturan Utama Project & Standar Inisialisasi

## 1. IDENTITAS DAN PERAN AI
- AI bertindak sebagai **Senior Full-Stack Software Architect, UI/UX Engineer, Database Designer, Security Engineer, dan Code Reviewer**.
- Tidak boleh langsung menulis kode sebelum dokumen spesifikasi (docs/01-audit.md dan docs/02-perencanaan.md) lengkap.
- Menggunakan pendekatan **modular berdasarkan section/role**, **mobile-first**, dan tidak menggunakan credentials di kode (selalu lewat `.env`).

## 2. STANDAR FRONTEND (UI/UX)
- Wajib **Mobile-First**: Gunakan default style untuk layar kecil, gunakan breakpoint (`sm:`, `md:`, `lg:`) untuk layar yang lebih besar.
- **Tidak ada burger menu** pada desktop. Navigasi harus terbuka dan jelas.
- Hindari AI Slop (terapkan aturan `anti-slop-ui`).
- **Wajib Loading / Spinner State pada Setiap Aksi & Request**: Setiap kali user mengklik tombol submit, tombol hapus, eksekusi REST API / rute, atau manipulasi DOM, **wajib menampilkan indikator loading/animasi proses** agar antarmuka tidak membeku atau terlihat lag. Proses upload & download wajib menampilkan progress/status berjalan.
- **Wajib gunakan Tailgrids** sebagai sumber komponen UI:
  - Setup: `npx @tailgrids/cli@latest init`
  - Tambah komponen: `npx @tailgrids/cli@latest add <component-id>`
  - Jangan membuat komponen dari nol jika tersedia di Tailgrids.
  - Boleh sesuaikan warna/spacing, tapi jaga struktur HTML dan class pattern Tailgrids.
- Template modular:
  - `layouts/base.blade.php` (hanya shell HTML)
  - `layouts/public.blade.php` (untuk halaman umum)
  - `components/*` (tombol, card, alert - dari Tailgrids)

## 3. STANDAR BACKEND (Laravel Multi-Tenant)
- Single Codebase, Isolated Database per tenant.
- Identifikasi tenant berdasarkan URL (`http://localhost:8000/{tenant-slug}`).
- Database registry (sentral) mencatat daftar tenant.
- Routing dikelompokkan dalam prefix `/{tenant}`.

## 4. SKEMA KONTEN SEKOLAH
- Pisahkan informasi per halaman.
- Contoh tabel tenant:
  - `pages` (Sejarah, Visi Misi, dll.)
  - `posts` (Berita sekolah, Artikel kesiswaan)
  - `programs` (Program Keahlian, dengan dukungan sub-program)
  
*Dokumen ini merupakan intisari aturan kerja untuk Antigravity AI IDE dalam mengembangkan proyek website sekolah.*

## 5. KEWAJIBAN RELASI DATABASE (100% BERELASI)
- Seluruh tabel aplikasi (Central maupun Tenant) **wajib 100% memiliki relasi Foreign Key (FK)** yang formal.
- Setiap relasi tabel wajib tercermin pada model Eloquent (`belongsTo`, `hasMany`) di `App\Models\Tenant` atau `App\Models\Central`.
- Tidak boleh membuat tabel bisnis yang berdiri sendiri tanpa relasi ke data induk (`sekolah`, `pengguna`, `jurusan`, dll).
- Dilarang membuat migration destruktif tanpa memeriksa dampak data.

## 6. WAJIB BACA DOKUMENTASI DI AWAL
Setiap kali menerima perintah, **WAJIB membaca file-file dokumentasi `.md` project** sebelum menulis kode apa pun:

1. `README.md` - arsitektur umum, kredensial, struktur folder
2. `docs/01-PRD.md` - fitur, scope, batasan bisnis
3. `docs/02-ARCHITECTURE.md` - arsitektur sistem, pola multi-tenant
4. `docs/03-DATABASE.md` - schema database, relasi antar tabel (ERD)
5. `docs/04-ROUTES-OR-API.md` - daftar route, endpoint, middleware
6. `docs/05-UI-UX.md` - standar desain, komponen, palet warna, tipografi
7. `docs/06-CHANGELOG.md` - riwayat perubahan terakhir
8. `docs/07-IMPLEMENTATION-CHECKLIST.md` - status implementasi fitur
9. `docs/RULES.md` - aturan kerja ini
10. `CHANGELOG.md` - changelog root

Semua file `.md` saling terikat sebagai sumber kebenaran proyek.

## 7. SINKRONISASI DOKUMENTASI DI AKHIR PEKERJAAN
Setelah setiap perubahan selesai, **WAJIB langsung perbarui file-file `.md` yang terdampak** tanpa menunggu instruksi tambahan:

- `docs/06-CHANGELOG.md` dan `CHANGELOG.md` - **SELALU** diperbarui
- `docs/03-DATABASE.md` - perbarui jika ada perubahan skema, kolom, atau relasi FK
- `docs/07-IMPLEMENTATION-CHECKLIST.md` - centang fitur yang telah selesai
- `docs/01-PRD.md` - jika scope fitur berubah
- `docs/04-ROUTES-OR-API.md` - jika ada perubahan rute
- `docs/05-UI-UX.md` - jika ada perubahan standar visual/komponen
- `README.md` - jika struktur folder, URL, atau fitur berubah



## 8. STANDAR TEMA & AUTO-KONTRAS CSS (Portal Publik)

Aturan lengkap: `.ai/rules/publik-tema-kontras.md` (checklist kerja) dan `docs/08-CSS-ARSITEKTUR-TEMA.md` (tabel variabel, registri scope, resep).

Poin yang mengikat setiap perubahan pada portal publik:

1. **Satu sumber warna.** Semua warna publik berasal dari 13 kunci panel *Tema & Warna* yang diinjeksi ke `:root` oleh `resources/views/layouts/public.blade.php`. Jangan menambah palet kedua.
2. **Dua lapis auto-kontras.** `App\Support\WarnaKontras` (server, hasil akhir di `--theme-fg-*`) + `@property`/`contrast()` di `resources/css/public.css` (pengaman). Keduanya wajib tetap ada.
3. **Markup tidak menulis warna.** Pakai kelas `.theme-*` (heading, text-body, text-muted, card, badge, icon-box, btn-primary, btn-ghost, input, header, footer, table, border, link). Warna literal (`text-white`, `bg-blue-900`, `#hex`, `rgba()`) dilarang di kode baru.
4. **Komponen membaca variabel ter-scope**: `--theme-heading`, `--theme-text`, `--theme-text-muted`, `--theme-fg-link`, `--fg-zona-efektif`, `--theme-fg-tombol/aksen/badge/header/footer/zona`. Bukan `--theme-btn-text`.
5. **Permukaan baru harus terdaftar di scope** `SCOPE AUTO-KONTRAS PER PERMUKAAN` (template 8 baris) atau memakai `color-mix()` berbasis variabel tema.
6. **Tambah menu publik = data `menu` + route di grup `{tenant}`** dengan nama route `tenant.*`; view `@extends('layouts.public')` dan controller memakai `getSekolahData()`.
7. **Setiap kunci warna baru** harus sinkron di 6 titik: migrasi/seed, `PengaturanController`, `PageController::getSekolahData()` + `HomeController`, `layouts/public.blade.php`, `public.css`, dan JS pratinjau admin.
8. **Verifikasi**: `vendor/bin/pest tests/Unit/WarnaKontrasTest.php`, `vendor/bin/pest tests/Feature/TenantThemeColorTest.php`, `npm run build`, lalu pastikan compiled CSS tetap memuat `@property` dan `contrast()`.

