# Product Requirements Document (PRD)
**Nama Proyek:** Template Website Sekolah Multi-Tenant (SaaS)
**Versi:** 1.0.0
**Dokumen Terkait:** [ARCHITECTURE.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/02-ARCHITECTURE.md) | [DATABASE.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/03-DATABASE.md) | [CHANGELOG.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/04-CHANGELOG.md)

---

## 1. Ringkasan Eksekutif & Tujuan Produk
Aplikasi ini adalah platform website sekolah multi-tenant (SaaS) yang dibangun menggunakan **Laravel 11, Blade, Tailwind CSS, Alpine.js, dan MySQL**. 
Tujuan produk adalah menyediakan template website sekolah *white-label* yang dapat dijual/disewakan ke berbagai institusi pendidikan dari tingkat PAUD, TK A/B, SD, MI, MTs, SMA, SMK, hingga MAN.

---

## 2. Karakteristik & Sasaran Pengguna
1. **Super Admin (Pemilik Platform/SaaS):**
   - Mengelola tenant (sekolah) yang terdaftar.
   - Mengatur domain/subdomain masing-masing sekolah.
   - Mengontrol status masa aktif operasional sekolah.
2. **Admin Sekolah (Tenant Operator / TU):**
   - Mengelola konten website sekolah secara mandiri.
   - Mengatur tema, logo, warna, dan informasi identitas sekolah.
   - Mengaktifkan/menonaktifkan modul tertentu melalui fitur *Toggle*.
   - Mengunggah dan memanipulasi media (kompresi otomatis WebP, crop, rename).
   - Mengelola data guru, staf, ekstrakurikuler, jurusan, prestasi, berita, dan PPDB.
3. **Pengunjung Publik (Wali Murid, Siswa, Masyarakat Umum):**
   - Menjelajahi informasi profil sekolah, fasilitas, prestasi, dan kegiatan.
   - Membaca berita, pengumuman, dan artikel sekolah.
   - Mengunduh dokumen publik di Download Area.
   - Menghubungi sekolah via formulir kontak atau WhatsApp melayang.
   - Mengakses alur pendaftaran PPDB (Internal/Eksternal).

---

## 3. Fitur Utama & Modul Fungsional

### A. Fitur Publik (Frontend)
- **Beranda (Homepage):**
  - Slider/Banner interaktif (Carousel).
  - Sambutan Kepala Sekolah.
  - Statistik cepat (Siswa, Guru, Prestasi, dsb).
  - Sorotan Informasi Terbaru (Berita, Pengumuman, Agenda).
  - Floating Button WhatsApp & Tautan Media Sosial Dinamis.
- **Profil Sekolah:**
  - Halaman Sejarah, Visi, Misi, dan Tujuan.
  - Bagan Struktur Organisasi.
  - Daftar Fasilitas dan galeri foto fasilitas.
- **Akademik & Direktori:**
  - **Program Keahlian / Jurusan:** Daftar ringkas dan halaman detail/penjelasan lengkap (Dapat dinonaktifkan via toggle untuk jenjang PAUD/SD).
  - **Ekstrakurikuler:** Daftar kegiatan dan halaman detail penjelasan & dokumentasi (Dapat dinonaktifkan via toggle).
  - **Guru & Staf:** Direktori pengajar beserta NIP, jabatan, dan foto.
  - **Prestasi:** Galeri pencapaian siswa dan institusi.
  - **Kalender Akademik:** Jadwal agenda kegiatan akademik sekolah.
- **Informasi & Publikasi (CMS):**
  - Artikel & Berita terbagi per Kategori.
  - Pengumuman resmi.
  - Galeri Album Foto & Video (Embed YouTube).
- **Layanan Publik:**
  - **Download Area:** Pengunduhan dokumen resmi (SOP, Buku Panduan, Formulir).
  - **Kontak & Lokasi:** Formulir pesan "Hubungi Kami" & Embed Google Maps.
- **PPDB (Penerimaan Peserta Didik Baru):**
  - Mode Eksternal: Menampilkan informasi syarat & mengarahkan ke link portal PPDB pemerintah.
  - Mode Internal: Formulir pendaftaran mandiri langsung di website sekolah (khusus sekolah swasta).
  - Mode Nonaktif: Disembunyikan saat periode pendaftaran tutup.

### B. Fitur Admin Sekolah (Tenant CMS)
- **Pengaturan Tampilan & Identitas (Theme Customizer):**
  - Ubah Logo, Favicon, Nama Sekolah, Alamat, Kontak, dan Media Sosial.
  - Ubah Warna Tema Utama (*Primary Color*) dinamis.
- **Pengaturan Modul / Fitur (Module Manager / Toggle):**
  - Sakelar On/Off untuk menampilkan/menyembunyikan menu (Jurusan, PPDB, Ekskul, Prestasi, Kalender, dll).
- **Media Manager Terintegrasi:**
  - Otomatis mengubah gambar menjadi format `.webp` dan mengompresi kualitas (via `Intervention Image`).
  - Fitur *Crop*, *Rename*, dan manajemen file.
  - Desain penyimpanan abstrak (Siap beralih dari Local Storage ke Amazon S3 tanpa ubah kode).
- **Manajemen Konten & Master Data (CRUD Lengkap):**
  - Guru & Staf, Jurusan (beserta konten detail), Ekstrakurikuler (beserta konten detail), Fasilitas.
  - Slider Beranda, Struktur Organisasi, Prestasi, Kalender Akademik.
  - Kategori Berita, Artikel/Berita, Galeri Foto & Video, Download Dokumen.
- **Manajemen PPDB:**
  - Konfigurasi Mode (Eksternal/Internal) dan jadwal.
  - Tabel data pendaftar calon siswa (khusus mode internal) dengan status verifikasi.
- **Kotak Masuk (Inbox):**
  - Rekap pesan masuk dari formulir "Hubungi Kami".

### C. Fitur Super Admin (Platform Owner)
- **Manajemen Tenant:** Pendaftaran sekolah baru, pembuatan database tenant otomatis, alokasi domain/subdomain, aktivasi/suspend akun sekolah.

---

## 4. Kebutuhan Non-Fungsional (NFR)
- **Desain UI/UX:** Mobile-First, responsif di semua perangkat, modern, cepat, ramah aksesibilitas.
- **Performa:** Gambar terkompresi format WebP, aset CSS/JS diminimalisasi dengan Tailwind & Vite.
- **Keamanan:** Proteksi CSRF, sanitasi input XSS, hashing kata sandi aman (Bcrypt), isolasi database per tenant.
