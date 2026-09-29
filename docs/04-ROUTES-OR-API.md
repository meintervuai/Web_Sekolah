# Dokumentasi Rute Publik & API — Website Sekolah

## 1. Rute Publik Tenant (Prefix: `/{tenant}`)

Semua rute publik sekolah berjalan di bawah prefix slug tenant (contoh: `/smk-negeri-2-bandung`) atau via domain/subdomain khusus tenant melalui `TenantMiddleware`.

| No | URL Path | Route Name | Method | Modul/Feature Code | Deskripsi Halaman |
|---|---|---|---|---|---|
| 1 | `/{tenant}` | `tenant.home` | GET | `beranda` | Halaman beranda sekolah lengkap dengan hero, statistik, jurusan, berita, agenda, galeri. |
| 2 | `/{tenant}/profil` | `tenant.profil` | GET | `profil` | Profil sekolah, sejarah, visi & misi, tujuan, sambutan kepala sekolah, statistik fasilitas. |
| 3 | `/{tenant}/program-keahlian` | `tenant.program-keahlian` | GET | `program_keahlian` | Katalog 7 program keahlian / jurusan. |
| 4 | `/{tenant}/program-keahlian/{slug}` | `tenant.program-keahlian.detail` | GET | `program_keahlian` | Detail kurikulum, kompetensi, prospek kerja jurusan terkait. |
| 5 | `/{tenant}/berita` | `tenant.berita` | GET | `berita` | Listing artikel berita sekolah dengan pencarian & kategori. |
| 6 | `/{tenant}/berita/{slug}` | `tenant.berita.detail` | GET | `berita` | Artikel berita lengkap, metadata tanggal, penulis, artikel terkait. |
| 7 | `/{tenant}/agenda` | `tenant.agenda` | GET | `agenda` | Jadwal agenda/kegiatan sekolah mendatang & riwayat agenda. |
| 8 | `/{tenant}/agenda/{slug}` | `tenant.agenda.detail` | GET | `agenda` | Detail agenda, waktu, lokasi, penyelenggara, dan link registrasi. |
| 9 | `/{tenant}/pengumuman` | `tenant.pengumuman` | GET | `pengumuman` | Informasi dan pengumuman resmi sekolah. |
| 10 | `/{tenant}/pengumuman/{slug}` | `tenant.pengumuman.detail` | GET | `pengumuman` | Detail pengumuman resmi dan lampiran berkas. |
| 11 | `/{tenant}/prestasi` | `tenant.prestasi` | GET | `prestasi` | Daftar prestasi dan kejuaraan siswa/sekolah. |
| 12 | `/{tenant}/prestasi/{slug}` | `tenant.prestasi.detail` | GET | `prestasi` | Rincian capaian prestasi dan dokumentasi foto. |
| 13 | `/{tenant}/kegiatan` | `tenant.kegiatan` | GET | `kegiatan` | Dokumentasi rangkaian aktivitas & event sekolah. |
| 14 | `/{tenant}/ekstrakurikuler` | `tenant.ekstrakurikuler` | GET | `ekstrakurikuler` | Katalog organisasi & ekstrakurikuler siswa. |
| 15 | `/{tenant}/ekstrakurikuler/{slug}` | `tenant.ekstrakurikuler.detail` | GET | `ekstrakurikuler` | Jadwal latihan, profil pembina, dan galeri ekskul. |
| 16 | `/{tenant}/guru-staf` | `tenant.guru-staf` | GET | `guru_staf` | Direktori pendidik & tenaga kependidikan. |
| 17 | `/{tenant}/fasilitas` | `tenant.fasilitas` | GET | `fasilitas` | Sarana prasarana penunjang pembelajaran di sekolah. |
| 18 | `/{tenant}/galeri` | `tenant.galeri` | GET | `galeri` | Album foto & dokumentasi video sekolah dengan lightbox. |
| 19 | `/{tenant}/spmb` | `tenant.spmb` | GET | `spmb` | Informasi Penerimaan Peserta Didik Baru (PPDB/SPMB), alur, syarat, jadwal. |
| 20 | `/{tenant}/kontak` | `tenant.kontak` | GET | `kontak` | Alamat lengkap, nomor kontak, peta lokasi, dan form pesan. |
| 21 | `/{tenant}/kontak` | `tenant.kontak.kirim` | POST | `kontak` | Submit pesan masuk tervalidasi ke database tenant (`pesan_masuk`). |

## 2. Backward Compatibility Aliases

Untuk mencegah broken link pada rute sebelumnya, alias berikut tetap didukung dan diarahkan ke handler baru:
- `/{tenant}/ppdb` -> `tenant.spmb`
- `/{tenant}/profil/sejarah`, `/visi-misi`, `/struktur`, `/guru`, `/fasilitas`
- `/{tenant}/akademik/jurusan` -> `tenant.program-keahlian`
- `/{tenant}/informasi/berita` -> `tenant.berita`
- `/{tenant}/kesiswaan/ekstrakurikuler` -> `tenant.ekstrakurikuler`
- `/{tenant}/kesiswaan/prestasi` -> `tenant.prestasi`

## 3. Feature Flag Protection

Setiap modul diperiksa ketersediaannya melalui `PengaturanFitur::isAktif($kodeFitur)`. Jika nonaktif:
- Rute mengembalikan respons HTTP 404 (Not Found).
- Item pada header/navbar otomatis disembunyikan.
- Section terkait pada homepage otomatis disembunyikan.

## 4. Rute Panel Admin Sekolah (Prefix: `/{tenant}/admin`)

Panel admin sekolah mengelola identitas, konten profil sekolah, manajemen media, dan tema visual portal.

| No | URL Path | Route Name | Method | Middleware | Deskripsi Halaman |
|---|---|---|---|---|---|
| 1 | `/{tenant}/admin` | `tenant.admin.dashboard` | GET | `auth:tenant_admin` | Mengalihkan otomatis ke `tenant.admin.profil.index`. |
| 2 | `/{tenant}/admin/login` | `tenant.admin.login` | GET | - | Formulir login Admin Sekolah. Jika sesi admin masih aktif, otomatis dialihkan ke `tenant.admin.profil.index`. |
| 3 | `/{tenant}/admin/login` | `tenant.admin.login.submit` | POST | `guest:tenant_admin` | Proses autentikasi Admin Sekolah. |
| 4 | `/{tenant}/admin/logout` | `tenant.admin.logout` | POST | `auth:tenant_admin` | Mengakhiri sesi Admin Sekolah. |
| 5 | `/{tenant}/admin/profil` | `tenant.admin.profil.index` | GET | `auth:tenant_admin` | Manajemen Profil Sekolah CMS (Identitas, Sambutan Kepsek, Sejarah, Visi Misi, Struktur, Visibilitas Menu). |
| 5 | `/{tenant}/admin/profil/identitas` | `tenant.admin.profil.identitas.update` | PUT | `auth:tenant_admin` | Simpan identitas sekolah, kepala sekolah, dan video profil ke `pengaturan_umum` (berelasi `pengguna_id`). |
| 6 | `/{tenant}/admin/profil/halaman/{slug}` | `tenant.admin.profil.halaman.update` | PUT | `auth:tenant_admin` | Simpan konten Sejarah / Visi Misi WYSIWYG ke `halaman_statis` (berelasi `pengguna_id`). |
| 7 | `/{tenant}/admin/profil/struktur` | `tenant.admin.profil.struktur.update` | PUT | `auth:tenant_admin` | Simpan diagram bagan struktur organisasi ke `pengaturan_umum`. |
| 8 | `/{tenant}/admin/profil/pejabat` | `tenant.admin.profil.pejabat.store` | POST | `auth:tenant_admin` | Tambah data pejabat struktural (FK `guru_id` ke `guru_staf`). |
| 9 | `/{tenant}/admin/profil/pejabat/{pejabat}` | `tenant.admin.profil.pejabat.update` | PUT | `auth:tenant_admin` | Perbarui data pejabat struktural. |
| 10 | `/{tenant}/admin/profil/pejabat/{pejabat}` | `tenant.admin.profil.pejabat.destroy` | DELETE | `auth:tenant_admin` | Hapus data pejabat struktural. |
| 11 | `/{tenant}/admin/profil/toggle-menu` | `tenant.admin.profil.toggle-menu` | POST | `auth:tenant_admin` | Sakelar AJAX untuk sembunyikan/tampilkan menu/rute profil di publik (`menus` & `pengaturan_fitur`). |
| 12 | `/{tenant}/admin/media` | `tenant.admin.media.index` | GET | `auth:tenant_admin` | Manajemen Pustaka Berkas & File Media Induk (mendukung JSON API picker). |
| 13 | `/{tenant}/admin/media/upload` | `tenant.admin.media.upload` | POST | `auth:tenant_admin` | Unggah dan konversi berkas media ke WebP (berelasi `pengguna_id`). |
| 14 | `/{tenant}/admin/pengaturan` | `tenant.admin.pengaturan.index` | GET | `auth:tenant_admin` | Panel pengaturan tema & palet warna portal sekolah. |
| 15 | `/{tenant}/admin/pengaturan` | `tenant.admin.pengaturan.update` | PUT | `auth:tenant_admin` | Menyimpan `skema_tema` dan 7 kunci warna palet ke tabel tenant `pengaturan_umum`. |

### 4.1 Shortcut Global

| URL | Route Name | Perilaku |
|---|---|---|
| `/admin` | `admin.shortcut` | Mengarah ke `/{tenant}/admin/profil` bila tenant terikat & sesi admin aktif, selain itu ke `/{tenant}/admin/login`. |
| `/admin/login` | `admin.login.shortcut` | Mengarah ke halaman login admin sekolah aktif pertama. |

