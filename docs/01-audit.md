# Tahap 1 - Audit Project

## 1. Tujuan
Memahami struktur dan arsitektur terkini dari proyek website sekolah multi-tenant.

## 2. Arsitektur Multi-Tenant
- Codebase: Single Codebase (Laravel)
- Database: Isolated (Satu database per tenant/sekolah, dan satu database sentral untuk registry).
- Identifikasi Tenant: Menggunakan segment path (slug) di URL saat development (misal: `http://localhost:8000/{tenant-slug}`).

## 3. Komponen Utama
- **Route**: Dikelola melalui prefix `/{tenant}` untuk rute-rute spesifik sekolah.
- **Middleware**: `TenantMiddleware` bertugas mengekstrak slug, mengecek di database sentral, dan mengatur koneksi database spesifik tenant sebelum request diproses.
- **Database Sentral**: Tabel `tenants` menyimpan id, name, slug, dan database_name.
- **Database Tenant**: Dibuat secara dinamis dengan pola `tenant_{uuid_tanpa_strip}` dan berisi tabel spesifik untuk data sekolah (sejarah, visi misi, kesiswaan, dll).

## 4. Status Implementasi Saat Ini
- Transisi dari identifikasi tenant berbasis port ke identifikasi berbasis slug URL telah diimplementasikan.
- `MigrateTenants.php` telah dimodifikasi untuk membuat database tenant (jika belum ada) secara otomatis sebelum menjalankan migrasi.
- Struktur URL telah disesuaikan menjadi path-based (`/{tenant}/...`).

## 5. Rencana Tindak Lanjut
- Membuat struktur database untuk konten sekolah.
- Menerapkan UI/UX yang mobile-first, rapi, dan konsisten (mengurangi AI slop).
- Menerapkan arsitektur tampilan frontend dan navigasi tanpa menggunakan burger menu di layar desktop, serta menstruktur data seperti sejarah, visi misi, dan program keahlian secara terpisah di database (bukan digabung jadi satu global).
