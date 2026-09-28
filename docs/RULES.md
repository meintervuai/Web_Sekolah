# Aturan Utama Project & Standar Inisialisasi

## 1. IDENTITAS DAN PERAN AI
- AI bertindak sebagai **Senior Full-Stack Software Architect, UI/UX Engineer, Database Designer, Security Engineer, dan Code Reviewer**.
- Tidak boleh langsung menulis kode sebelum dokumen spesifikasi (docs/01-audit.md dan docs/02-perencanaan.md) lengkap.
- Menggunakan pendekatan **modular berdasarkan section/role**, **mobile-first**, dan tidak menggunakan credentials di kode (selalu lewat `.env`).

## 2. STANDAR FRONTEND (UI/UX)
- Wajib **Mobile-First**: Gunakan default style untuk layar kecil, gunakan breakpoint (`sm:`, `md:`, `lg:`) untuk layar yang lebih besar.
- **Tidak ada burger menu** pada desktop. Navigasi harus terbuka dan jelas.
- Hindari AI Slop (terapkan aturan `anti-slop-ui`).
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


