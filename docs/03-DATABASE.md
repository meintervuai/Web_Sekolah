# Database Schema & Data Dictionary — Website Sekolah

## 1. Central Database (`website_sekolah_central`)

- **`super_admin`:** `id`, `nama`, `email`, `password`, timestamps.
- **`sekolah`:** `id` (UUID), `nama_sekolah`, `slug`, `jenjang` (SD/SMP/SMA/SMK), `status_aktif`, `tgl_berakhir`, `data` (JSON: telepon, email, alamat, dll), timestamps.
- **`domain_sekolah`:** `id`, `sekolah_id` (FK), `domain` (unique), timestamps.

---

## 2. Tenant Database (`tenant_{slug}`)

1. **`pengaturan_umum`:** `kunci` (PK/unique), `nilai` (longtext).
2. **`pengaturan_fitur`:** `kode_fitur` (unique), `nama_fitur`, `is_aktif` (boolean).
3. **`menus`:** `id`, `name`, `url`, `parent_id` (self-referencing FK), `urutan`, `is_aktif`, `type` (link/dropdown), timestamps.
4. **`halaman_statis`:** `id`, `judul`, `slug` (unique), `isi_konten` (longtext), `gambar_banner`, timestamps.
5. **`slider_beranda`:** `id`, `judul`, `subjudul`, `gambar`, `link_tombol`, `teks_tombol`, `urutan`, `is_aktif`, timestamps.
6. **`struktur_organisasi`:** `id`, `nama_lengkap`, `jabatan`, `foto`, `urutan`, timestamps.
7. **`guru_staf`:** `id`, `nip`, `nama_lengkap`, `jenis_kelamin` (L/P), `jabatan`, `mata_pelajaran`, `foto`, `status_aktif`, timestamps.
8. **`jurusan`:** `id`, `nama_jurusan`, `singkatan`, `slug` (unique), `deskripsi_singkat`, `deskripsi_lengkap`, `ikon_atau_foto`, `urutan`, `is_aktif`, timestamps.
9. **`fasilitas`:** `id`, `nama_fasilitas`, `deskripsi`, `foto_utama`, `is_aktif`, timestamps.
10. **`foto_fasilitas`:** `id`, `fasilitas_id` (FK), `file_foto`, `keterangan`, timestamps.
11. **`kategori_artikel`:** `id`, `nama_kategori`, `slug` (unique), timestamps.
12. **`artikel`:** `id`, `kategori_id` (FK), `pengguna_id` (FK nullable), `judul`, `slug` (unique), `ringkasan`, `isi_konten`, `gambar_sampul`, `is_pengumuman` (boolean), `status_publikasi` (draft/published), `tgl_publikasi`, `jumlah_dilihat`, timestamps.
13. **`agenda`:** `id`, `judul`, `slug` (unique), `ringkasan`, `deskripsi_lengkap`, `tgl_mulai` (date), `tgl_selesai` (date nullable), `jam_mulai` (time/string), `jam_selesai` (time/string), `lokasi`, `penyelenggara`, `gambar_sampul`, `link_pendaftaran`, `is_aktif` (boolean), timestamps.
14. **`kalender_akademik`:** `id`, `nama_kegiatan`, `tgl_mulai`, `tgl_selesai`, `keterangan`, timestamps.
15. **`galeri_album`:** `id`, `nama_album`, `slug` (unique), `tipe` (foto/video), `deskripsi`, `cover_album`, timestamps.
16. **`galeri_item`:** `id`, `album_id` (FK), `file_media_atau_link`, `judul_item`, timestamps.
17. **`ekstrakurikuler`:** `id`, `nama_ekstrakurikuler`, `slug`, `deskripsi`, `foto`, `hari_jadwal`, `waktu_jadwal`, `pembina`, `is_aktif`, timestamps.
18. **`prestasi_siswa`:** `id`, `nama_siswa`, `nama_prestasi`, `slug`, `tingkat`, `tanggal`, `foto`, `deskripsi`, timestamps.
19. **`pesan_masuk`:** `id`, `nama_pengirim`, `email_pengirim`, `no_telepon`, `subjek`, `pesan`, `is_dibaca` (boolean), timestamps.
20. **`pengaturan_ppdb` & `pendaftar_ppdb`:** data pengaturan alur & formulir pendaftaran PPDB.
