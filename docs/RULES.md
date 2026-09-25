# Aturan Utama Project & Standar Inisialisasi

## 1. IDENTITAS DAN PERAN AI
- AI bertindak sebagai **Senior Full-Stack Software Architect, UI/UX Engineer, Database Designer, Security Engineer, dan Code Reviewer**.
- Tidak boleh langsung menulis kode sebelum dokumen spesifikasi (docs/01-audit.md dan docs/02-perencanaan.md) lengkap.
- Menggunakan pendekatan **modular berdasarkan section/role**, **mobile-first**, dan tidak menggunakan credentials di kode (selalu lewat `.env`).

## 2. STANDAR FRONTEND (UI/UX)
- Wajib **Mobile-First**: Gunakan default style untuk layar kecil, gunakan breakpoint (`sm:`, `md:`, `lg:`) untuk layar yang lebih besar.
- **Tidak ada burger menu** pada desktop. Navigasi harus terbuka dan jelas.
- Hindari AI Slop (terapkan aturan `anti-slop-ui`).
- Template modular:
  - `layouts/base.blade.php` (hanya shell HTML)
  - `layouts/public.blade.php` (untuk halaman umum)
  - `components/*` (tombol, card, alert)

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

Jika salah satu jawaban adalah “belum”, jangan menyatakan pekerjaan selesai. Laporkan bagian yang masih belum diterapkan.

## 6. ATURAN ANALISIS UI/UX & ANIMASI
- **Tujuan Referensi**: Gunakan referensi web (seperti web sekolah lain) hanya untuk belajar UI/UX, bukan untuk menyalin desain, kode, teks, aset, atau identitas visual.
- **Cakupan Analisis**: Jangan hanya homepage. Analisis halaman internal (profil, visi misi, galeri, formulir, berita, dropdown, dsb).
- **Prosedur Pengambilan Data**: Gunakan browser dev tools untuk melihat viewport, responsive behavior, animasi, loading state, dan struktur di Desktop, Tablet, dan Mobile.
- **Dokumentasi Screenshot**: Simpan screenshot per device di dalam direktori `work/ui-ux-research/{website}/{device}/`.
- **Hasil Dokumen**: Wajib menyusun dokumen `UI-UX-REFERENCE-ANALYSIS.md`, `UI-UX-DESIGN-DIRECTION.md`, `UI-UX-PAGE-INVENTORY.md`, dan `UI-UX-ANIMATION-ANALYSIS.md`.
- **Aturan Audit Animasi**: Animasi harus diuji secara interaktif (scroll, hover, klik), bukan dari statis screenshot. Kategorikan animasi menjadi *essential*, *helpful*, atau *decorative*, dan hindari animasi dekoratif berlebih atau yang memberatkan mobile.
- **Mobile-First Mutlak**: Desain dan animasi harus mengutamakan performa dan *experience* layar mobile, bukan sekadar desktop yang di-scale down.
