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

## 5. PEMERIKSAAN SILANG SEBELUM SELESAI
Sebelum menyatakan tugas selesai, lakukan pemeriksaan silang:
1. Apakah semua keputusan UI/UX sudah masuk ke ruler?
2. Apakah semua keputusan animasi sudah masuk ke ruler?
3. Apakah semua hasil analisis sudah masuk ke file Markdown yang tepat?
4. Apakah halaman yang direkomendasikan memiliki route?
5. Apakah route memiliki sumber data?
6. Apakah sumber data memiliki tabel atau model?
7. Apakah komponen UI sudah memiliki responsive behavior?
8. Apakah fitur tenant sudah diterapkan pada route, query, authorization, dan database?
9. Apakah perubahan sudah dicatat di CHANGELOG.md?
10. Apakah traceability matrix sudah diperbarui?

Jika salah satu jawaban adalah "belum", jangan menyatakan pekerjaan selesai. Laporkan bagian yang masih belum diterapkan.

## 6. ATURAN ANALISIS UI/UX & ANIMASI
- **Tujuan Referensi**: Gunakan referensi web (seperti web sekolah lain) hanya untuk belajar UI/UX, bukan untuk menyalin desain, kode, teks, aset, atau identitas visual.
- **Cakupan Analisis**: Jangan hanya homepage. Analisis halaman internal (profil, visi misi, galeri, formulir, berita, dropdown, dsb).
- **Prosedur Pengambilan Data**: Gunakan browser dev tools untuk melihat viewport, responsive behavior, animasi, loading state, dan struktur di Desktop, Tablet, dan Mobile.
- **Dokumentasi Screenshot**: Simpan screenshot per device di dalam direktori `work/ui-ux-research/{website}/{device}/`.
- **Hasil Dokumen**: Wajib menyusun dokumen `UI-UX-REFERENCE-ANALYSIS.md`, `UI-UX-DESIGN-DIRECTION.md`, `UI-UX-PAGE-INVENTORY.md`, dan `UI-UX-ANIMATION-ANALYSIS.md`.
- **Aturan Audit Animasi**: Animasi harus diuji secara interaktif (scroll, hover, klik), bukan dari statis screenshot. Kategorikan animasi menjadi *essential*, *helpful*, atau *decorative*, dan hindari animasi dekoratif berlebih atau yang memberatkan mobile.
- **Mobile-First Mutlak**: Desain dan animasi harus mengutamakan performa dan *experience* layar mobile, bukan sekadar desktop yang di-scale down.

## 7. WAJIB BACA DOKUMENTASI SEBELUM KERJA
Setiap kali menerima perintah, **WAJIB baca semua file `.md` dokumentasi project** sebelum menulis kode apa pun:

1. `README.md` - arsitektur umum, kredensial, struktur folder
2. `docs/01-PRD.md` - fitur, scope, batasan bisnis
3. `docs/02-ARCHITECTURE.md` - arsitektur sistem, pola multi-tenant
4. `docs/03-DATABASE.md` - schema database, relasi antar tabel
5. `docs/04-ROUTES-OR-API.md` - daftar route, endpoint, middleware
6. `docs/05-UI-UX.md` - standar desain, komponen, palet warna
7. `docs/06-CHANGELOG.md` - riwayat perubahan terakhir
8. `docs/07-IMPLEMENTATION-CHECKLIST.md` - status implementasi fitur
9. `docs/RULES.md` - aturan kerja ini
10. `CHANGELOG.md` - changelog root
11. Semua file di `doc/` - versi ringkas dokumentasi

Tidak ada pengecualian. Ini memastikan setiap perubahan mempertimbangkan konteks penuh project.

## 8. ANALISIS DAMPAK OTOMATIS (IMPACT ANALYSIS)
Setiap perubahan kode **WAJIB disertai analisis dampak** ke semua dimensi:

| Dimensi | Pertanyaan kunci |
|---------|-----------------|
| Alur bisnis | Apakah flow user masih berjalan benar? |
| Database/Schema | Apakah migration, model, seeder konsisten? |
| Struktur file | Apakah view, component, asset terkait masih benar? |
| Route/API | Apakah route, controller, middleware sinkron? |
| Relasi data | Apakah foreign key, relationship, cascade benar? |
| Validasi | Apakah Form Request masih sesuai? |
| Authorization | Apakah policy, gate masih konsisten? |
| UI/Frontend | Apakah navigation, breadcrumb, link masih benar? |
| Test | Apakah test yang ada masih pass? |
| Seeder/Data | Apakah seeder menghasilkan data valid? |

Prosedur: identifikasi perubahan primer, trace dependensi ke atas/bawah/lateral, perbaiki semua area terdampak, verifikasi perbaikan.

**Jangan perbaiki hanya yang diminta user.** Jika user minta ubah field di model, periksa dan perbaiki juga: migration, seeder, controller, form request, view, test, dan dokumentasi.

## 9. SINKRONISASI DOKUMENTASI WAJIB
Setelah setiap perubahan selesai, **WAJIB perbarui semua file `.md` yang terdampak**:

- `docs/06-CHANGELOG.md` dan `CHANGELOG.md` - **SELALU** diperbarui
- `docs/01-PRD.md` - jika scope fitur berubah
- `docs/02-ARCHITECTURE.md` - jika arsitektur berubah
- `docs/03-DATABASE.md` - jika schema berubah
- `docs/04-ROUTES-OR-API.md` - jika route berubah
- `docs/05-UI-UX.md` - jika desain berubah
- `docs/07-IMPLEMENTATION-CHECKLIST.md` - jika status fitur berubah
- `README.md` - jika struktur folder, URL, atau fitur berubah
- Semua file di `doc/` - disinkronkan dengan versi `docs/`

Jangan menunggu user meminta update. Lakukan otomatis.

