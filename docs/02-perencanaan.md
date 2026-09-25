# Tahap 2 - Perencanaan dan Dokumentasi Terstruktur

## 1. Ringkasan Requirement
- **Nama Aplikasi**: Website Sekolah Multi-Tenant
- **Tujuan Utama**: Menyediakan platform website profil sekolah untuk banyak sekolah dalam satu sistem codebase.
- **Target Pengguna**: Publik (pengunjung web sekolah), Admin Sekolah (pengelola konten), dan Super Admin (pengelola seluruh tenant).
- **Fitur Utama**: Manajemen Tenant, Konten Publik (Sejarah, Visi Misi, Program Keahlian, Berita/Kesiswaan).

## 2. Pilihan Stack Final
- **Backend**: Laravel 11.x, PHP 8.4
- **Frontend**: Blade Templating + Tailwind CSS
- **Database**: MySQL/MariaDB dengan arsitektur multi-tenant (1 DB Sentral + N DB Tenant).

## 3. Pembagian Section/Role
- **Super Admin**: Mengelola tenant (sekolah baru), memantau sistem.
- **Admin Tenant**: Mengelola konten spesifik sekolah (sejarah, berita, dll).
- **Public**: Pengunjung website melihat konten dari sekolah spesifik (via `/{tenant-slug}`).

## 4. Rancangan Arsitektur Multi-Tenant
- **URL Pattern**: `http://localhost:8000/{tenant-slug}/...`
- **Isolasi Database**: Diatur melalui `TenantMiddleware` yang memilih database berdasarkan slug di URL.

## 5. Rancangan Database (Tenant)
Database masing-masing tenant akan menyimpan struktur konten:
- **`pages`**: Untuk konten statis seperti sejarah, visi misi.
- **`posts`**: Untuk artikel, berita, dan informasi kesiswaan.
- **`programs`**: Untuk menyimpan data program keahlian.
*(Desain skema lengkap akan didefinisikan pada tahap implementasi migrasi tenant)*

## 6. Rancangan UI/UX
- **Mobile-first**: UI dirancang responsif mulai dari layar terkecil.
- **Desktop Navigation**: Menghindari penggunaan "burger menu" pada tampilan desktop; navigasi akan ditampilkan secara penuh dan rapi.
- **Modern & Clean**: Sesuai dengan panduan `anti-slop-ui`.

## 7. Risiko/Asumsi
- Migration harus dijaga ketat agar tersinkronisasi di setiap database tenant.
- Penamaan slug tenant harus unik di database sentral.
