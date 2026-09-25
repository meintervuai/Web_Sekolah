# Dokumen Skema Database (DATABASE)
**Nama Proyek:** Template Website Sekolah Multi-Tenant (SaaS)
**Versi:** 1.0.0
**DBMS:** MySQL 8.0+
**Dokumen Terkait:** [PRD.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/01-PRD.md) | [ARCHITECTURE.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/02-ARCHITECTURE.md) | [CHANGELOG.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/04-CHANGELOG.md)

---

## 1. ZONA DATABASE PUSAT (CENTRAL DATABASE)
Database: `website_sekolah_central`

### 1.1 Tabel `super_admin`
Menyimpan kredensial pemilik platform/SaaS.
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `nama`: VARCHAR(150) NOT NULL
- `email`: VARCHAR(150) UNIQUE NOT NULL
- `password`: VARCHAR(255) NOT NULL
- `remember_token`: VARCHAR(100) NULL
- `created_at`, `updated_at`: TIMESTAMP

### 1.2 Tabel `sekolah` (Tenants)
- `id`: VARCHAR(36) PRIMARY KEY (UUID)
- `nama_sekolah`: VARCHAR(200) NOT NULL
- `jenjang`: ENUM('PAUD', 'TK', 'SD', 'MI', 'MTS', 'SMP', 'SMA', 'SMK', 'MAN') NOT NULL
- `status_aktif`: BOOLEAN DEFAULT TRUE
- `tgl_berakhir`: DATE NULL
- `data`: JSON NULL (Untuk konfigurasi internal tenant stancl)
- `created_at`, `updated_at`: TIMESTAMP

### 1.3 Tabel `domain_sekolah` (Domains)
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `sekolah_id`: VARCHAR(36) NOT NULL (FK ke `sekolah.id` ON DELETE CASCADE)
- `domain`: VARCHAR(255) UNIQUE NOT NULL (Contoh: `sdn1.domain.com` atau `sdn1jakarta.sch.id`)
- `created_at`, `updated_at`: TIMESTAMP

---

## 2. ZONA DATABASE SEKOLAH (TENANT DATABASE)
Database dibuat terpisah otomatis untuk setiap sekolah: `tenant_<sekolah_id>`

### 2.1 Tabel `pengguna`
Pengguna admin dan staf operator sekolah.
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `nama`: VARCHAR(150) NOT NULL
- `email`: VARCHAR(150) UNIQUE NOT NULL
- `password`: VARCHAR(255) NOT NULL
- `peran`: ENUM('admin', 'operator', 'penulis') DEFAULT 'operator'
- `foto_profil`: VARCHAR(255) NULL
- `status_aktif`: BOOLEAN DEFAULT TRUE
- `remember_token`: VARCHAR(100) NULL
- `created_at`, `updated_at`: TIMESTAMP

### 2.2 Tabel `pengaturan_umum`
Menyimpan konfigurasi identitas sekolah (Key-Value).
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `kunci`: VARCHAR(100) UNIQUE NOT NULL (Contoh: `nama_sekolah`, `logo`, `warna_tema`, `alamat`, `no_telepon`, `email_sekolah`, `sambutan_kepsek`, `foto_kepsek`)
- `nilai`: LONGTEXT NULL
- `created_at`, `updated_at`: TIMESTAMP

### 2.3 Tabel `pengaturan_fitur` (Feature Toggle)
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `kode_fitur`: VARCHAR(100) UNIQUE NOT NULL (Contoh: `fitur_jurusan`, `fitur_ekskul`, `fitur_ppdb`, `fitur_prestasi`, `fitur_kalender`, `fitur_unduhan`)
- `nama_fitur`: VARCHAR(150) NOT NULL
- `is_aktif`: BOOLEAN DEFAULT TRUE
- `created_at`, `updated_at`: TIMESTAMP

### 2.4 Tabel `sosial_media`
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `nama_platform`: VARCHAR(50) NOT NULL (Contoh: 'Instagram', 'Facebook', 'YouTube', 'TikTok')
- `ikon`: VARCHAR(50) NOT NULL (Nama ikon kelas SVG/Font)
- `url`: VARCHAR(255) NOT NULL
- `urutan`: INT DEFAULT 0
- `is_aktif`: BOOLEAN DEFAULT TRUE
- `created_at`, `updated_at`: TIMESTAMP

### 2.5 Tabel `halaman_statis`
Menyimpan halaman berformat panjang (Sejarah, Visi Misi).
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `judul`: VARCHAR(200) NOT NULL
- `slug`: VARCHAR(200) UNIQUE NOT NULL
- `isi_konten`: LONGTEXT NOT NULL
- `gambar_banner`: VARCHAR(255) NULL
- `created_at`, `updated_at`: TIMESTAMP

### 2.6 Tabel `slider_beranda`
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `judul`: VARCHAR(200) NULL
- `subjudul`: VARCHAR(255) NULL
- `gambar`: VARCHAR(255) NOT NULL
- `link_tombol`: VARCHAR(255) NULL
- `teks_tombol`: VARCHAR(50) NULL
- `urutan`: INT DEFAULT 0
- `is_aktif`: BOOLEAN DEFAULT TRUE
- `created_at`, `updated_at`: TIMESTAMP

### 2.7 Tabel `struktur_organisasi`
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `nama_lengkap`: VARCHAR(150) NOT NULL
- `jabatan`: VARCHAR(100) NOT NULL
- `foto`: VARCHAR(255) NULL
- `urutan`: INT DEFAULT 0
- `created_at`, `updated_at`: TIMESTAMP

### 2.8 Tabel `guru_staf`
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `nip`: VARCHAR(50) NULL
- `nama_lengkap`: VARCHAR(150) NOT NULL
- `jenis_kelamin`: ENUM('L', 'P') NOT NULL
- `jabatan`: VARCHAR(100) NOT NULL
- `mata_pelajaran`: VARCHAR(100) NULL
- `foto`: VARCHAR(255) NULL
- `status_aktif`: BOOLEAN DEFAULT TRUE
- `created_at`, `updated_at`: TIMESTAMP

### 2.9 Tabel `jurusan`
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `nama_jurusan`: VARCHAR(150) NOT NULL
- `singkatan`: VARCHAR(20) NULL
- `slug`: VARCHAR(150) UNIQUE NOT NULL
- `deskripsi_singkat`: TEXT NULL
- `deskripsi_lengkap`: LONGTEXT NULL (Mendukung rich text untuk halaman detail)
- `ikon_atau_foto`: VARCHAR(255) NULL
- `urutan`: INT DEFAULT 0
- `is_aktif`: BOOLEAN DEFAULT TRUE
- `created_at`, `updated_at`: TIMESTAMP

### 2.10 Tabel `ekstrakurikuler`
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `nama_ekskul`: VARCHAR(150) NOT NULL
- `slug`: VARCHAR(150) UNIQUE NOT NULL
- `nama_pembina`: VARCHAR(150) NULL
- `jadwal_kegiatan`: VARCHAR(100) NULL
- `deskripsi_singkat`: TEXT NULL
- `deskripsi_lengkap`: LONGTEXT NULL (Mendukung rich text untuk halaman detail)
- `foto_utama`: VARCHAR(255) NULL
- `is_aktif`: BOOLEAN DEFAULT TRUE
- `created_at`, `updated_at`: TIMESTAMP

### 2.11 Tabel `fasilitas`
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `nama_fasilitas`: VARCHAR(150) NOT NULL
- `deskripsi`: TEXT NULL
- `foto_utama`: VARCHAR(255) NOT NULL
- `is_aktif`: BOOLEAN DEFAULT TRUE
- `created_at`, `updated_at`: TIMESTAMP

### 2.12 Tabel `foto_fasilitas` (One-to-Many ke `fasilitas`)
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `fasilitas_id`: BIGINT UNSIGNED NOT NULL (FK ke `fasilitas.id` ON DELETE CASCADE)
- `file_foto`: VARCHAR(255) NOT NULL
- `keterangan`: VARCHAR(200) NULL
- `created_at`, `updated_at`: TIMESTAMP

### 2.13 Tabel `kalender_akademik`
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `nama_kegiatan`: VARCHAR(200) NOT NULL
- `tgl_mulai`: DATE NOT NULL
- `tgl_selesai`: DATE NULL
- `keterangan`: TEXT NULL
- `created_at`, `updated_at`: TIMESTAMP

### 2.14 Tabel `kategori_artikel`
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `nama_kategori`: VARCHAR(100) NOT NULL
- `slug`: VARCHAR(100) UNIQUE NOT NULL
- `created_at`, `updated_at`: TIMESTAMP

### 2.15 Tabel `artikel`
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `pengguna_id`: BIGINT UNSIGNED NOT NULL (FK ke `pengguna.id` ON DELETE RESTRICT)
- `kategori_id`: BIGINT UNSIGNED NOT NULL (FK ke `kategori_artikel.id` ON DELETE RESTRICT)
- `judul`: VARCHAR(255) NOT NULL
- `slug`: VARCHAR(255) UNIQUE NOT NULL
- `ringkasan`: TEXT NULL
- `isi_konten`: LONGTEXT NOT NULL
- `gambar_sampul`: VARCHAR(255) NULL
- `is_pengumuman`: BOOLEAN DEFAULT FALSE
- `status_publikasi`: ENUM('draft', 'published') DEFAULT 'published'
- `tgl_publikasi`: DATETIME DEFAULT CURRENT_TIMESTAMP
- `jumlah_dilihat`: INT DEFAULT 0
- `created_at`, `updated_at`: TIMESTAMP

### 2.16 Tabel `galeri_album`
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `nama_album`: VARCHAR(150) NOT NULL
- `slug`: VARCHAR(150) UNIQUE NOT NULL
- `tipe`: ENUM('foto', 'video') DEFAULT 'foto'
- `deskripsi`: TEXT NULL
- `cover_album`: VARCHAR(255) NULL
- `created_at`, `updated_at`: TIMESTAMP

### 2.17 Tabel `galeri_item` (One-to-Many ke `galeri_album`)
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `album_id`: BIGINT UNSIGNED NOT NULL (FK ke `galeri_album.id` ON DELETE CASCADE)
- `file_media_atau_link`: VARCHAR(255) NOT NULL (Path file WebP atau URL embed YouTube)
- `judul_item`: VARCHAR(150) NULL
- `created_at`, `updated_at`: TIMESTAMP

### 2.18 Tabel `prestasi`
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `nama_penghargaan`: VARCHAR(200) NOT NULL
- `tingkat`: ENUM('Kecamatan', 'Kota/Kabupaten', 'Provinsi', 'Nasional', 'Internasional') NOT NULL
- `peraih_prestasi`: VARCHAR(150) NOT NULL (Nama siswa / tim / sekolah)
- `tgl_perolehan`: DATE NULL
- `foto_dokumentasi`: VARCHAR(255) NULL
- `deskripsi`: TEXT NULL
- `created_at`, `updated_at`: TIMESTAMP

### 2.19 Tabel `unduhan`
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `nama_dokumen`: VARCHAR(200) NOT NULL
- `kategori_dokumen`: VARCHAR(100) NULL
- `file_path`: VARCHAR(255) NOT NULL
- `ekstensi`: VARCHAR(10) NOT NULL (Contoh: pdf, docx, xlsx)
- `ukuran_file`: VARCHAR(20) NOT NULL (Contoh: '2.4 MB')
- `jumlah_unduh`: INT DEFAULT 0
- `created_at`, `updated_at`: TIMESTAMP

### 2.20 Tabel `pesan_masuk`
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `nama_pengirim`: VARCHAR(150) NOT NULL
- `email_pengirim`: VARCHAR(150) NOT NULL
- `no_telepon`: VARCHAR(50) NULL
- `subjek`: VARCHAR(200) NOT NULL
- `pesan`: TEXT NOT NULL
- `is_dibaca`: BOOLEAN DEFAULT FALSE
- `created_at`, `updated_at`: TIMESTAMP

### 2.21 Tabel `pengaturan_ppdb`
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `status_buka`: BOOLEAN DEFAULT FALSE
- `mode_ppdb`: ENUM('internal', 'eksternal') DEFAULT 'eksternal'
- `link_eksternal`: VARCHAR(255) NULL (Link portal resmi pemerintah)
- `tahun_ajaran`: VARCHAR(20) NOT NULL
- `tgl_mulai`: DATE NULL
- `tgl_selesai`: DATE NULL
- `informasi_syarat`: LONGTEXT NULL
- `created_at`, `updated_at`: TIMESTAMP

### 2.22 Tabel `pendaftar_ppdb`
- `id`: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- `nomor_pendaftaran`: VARCHAR(50) UNIQUE NOT NULL
- `nisn`: VARCHAR(20) NULL
- `nama_lengkap`: VARCHAR(150) NOT NULL
- `jenis_kelamin`: ENUM('L', 'P') NOT NULL
- `tempat_lahir`: VARCHAR(100) NOT NULL
- `tgl_lahir`: DATE NOT NULL
- `asal_sekolah`: VARCHAR(150) NOT NULL
- `nama_wali`: VARCHAR(150) NOT NULL
- `no_whatsapp_wali`: VARCHAR(30) NOT NULL
- `alamat_lengkap`: TEXT NOT NULL
- `pilihan_jurusan_id`: BIGINT UNSIGNED NULL (FK ke `jurusan.id` ON DELETE SET NULL, jika jenjang SMK/SMA)
- `status_verifikasi`: ENUM('menunggu', 'diterima', 'ditolak') DEFAULT 'menunggu'
- `created_at`, `updated_at`: TIMESTAMP
