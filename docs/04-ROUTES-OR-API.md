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
- `/{tenant}/informasi/berita`, `/pengumuman`, `/galeri`, `/fasilitas` -> `tenant.fasilitas` / `tenant.*`

*Catatan: Menu publik Kesiswaan dan submenunya telah dihapus dari navbar; informasi kegiatan & OSIS diintegrasikan ke modul Berita & Agenda Sekolah.*

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
| 11 | `/{tenant}/admin/profil/guru-hero` | `tenant.admin.profil.guru.hero.update` | PUT | `auth:tenant_admin` | Simpan kustomisasi hero banner (judul, subjudul, foto sampul 16:9) halaman direktori `/guru-staf`. |
| 12 | `/{tenant}/admin/profil/guru` | `tenant.admin.profil.guru.store` | POST | `auth:tenant_admin` | Tambah data master Guru & Tenaga Kependidikan ke tabel `guru_staf`. |
| 13 | `/{tenant}/admin/profil/guru/{guru}` | `tenant.admin.profil.guru.update` | PUT | `auth:tenant_admin` | Perbarui data Guru & Tenaga Kependidikan. |
| 14 | `/{tenant}/admin/profil/guru/{guru}` | `tenant.admin.profil.guru.destroy` | DELETE | `auth:tenant_admin` | Hapus data Guru & Tenaga Kependidikan. |
| 15 | `/{tenant}/admin/profil/toggle-menu` | `tenant.admin.profil.toggle-menu` | POST | `auth:tenant_admin` | Sakelar AJAX untuk sembunyikan/tampilkan menu/rute profil di publik (`menus` & `pengaturan_fitur`). |
| 16 | `/{tenant}/admin/program-keahlian` | `tenant.admin.jurusan.index` | GET | `auth:tenant_admin` | Manajemen Program Keahlian CMS (Katalog Jurusan, Hero Banner Publik, Visibilitas). |
| 17 | `/{tenant}/admin/program-keahlian/hero` | `tenant.admin.jurusan.hero.update` | PUT | `auth:tenant_admin` | Simpan hero banner (judul, subjudul, gambar latar 16:9) halaman katalog jurusan. |
| 18 | `/{tenant}/admin/program-keahlian` | `tenant.admin.jurusan.store` | POST | `auth:tenant_admin` | Tambah program keahlian baru (FK `guru_id`, sinkronisasi Media, slug). |
| 19 | `/{tenant}/admin/program-keahlian/{jurusan}` | `tenant.admin.jurusan.update` | PUT | `auth:tenant_admin` | Perbarui data program keahlian. |
| 20 | `/{tenant}/admin/program-keahlian/{jurusan}` | `tenant.admin.jurusan.destroy` | DELETE | `auth:tenant_admin` | Hapus program keahlian. |
| 21 | `/{tenant}/admin/program-keahlian/toggle-status` | `tenant.admin.jurusan.toggle-status` | POST | `auth:tenant_admin` | Sakelar AJAX status per jurusan atau feature flag global `program_keahlian`. |
| 22 | `/{tenant}/admin/media` | `tenant.admin.media.index` | GET | `auth:tenant_admin` | Manajemen Pustaka Berkas & File Media Induk (mendukung JSON API picker). |
| 23 | `/{tenant}/admin/media/upload` | `tenant.admin.media.upload` | POST | `auth:tenant_admin` | Unggah dan konversi berkas media ke WebP (berelasi `pengguna_id`). |
| 24 | `/{tenant}/admin/pengaturan` | `tenant.admin.pengaturan.index` | GET | `auth:tenant_admin` | Panel pengaturan tema & palet warna portal sekolah. |
| 26 | `/{tenant}/admin/informasi/berita` | `tenant.admin.informasi.berita` | GET | `auth:tenant_admin` | Manajemen Berita & Artikel Sekolah (listing, filter status, kategori). |
| 27 | `/{tenant}/admin/informasi/berita` | `tenant.admin.informasi.berita.store` | POST | `auth:tenant_admin` | Tambah artikel berita baru dengan editor WYSIWYG & media picker. |
| 28 | `/{tenant}/admin/informasi/berita/{berita}` | `tenant.admin.informasi.berita.update` | PUT | `auth:tenant_admin` | Perbarui artikel berita sekolah. |
| 29 | `/{tenant}/admin/informasi/berita/{berita}` | `tenant.admin.informasi.berita.destroy` | DELETE | `auth:tenant_admin` | Hapus artikel berita sekolah. |
| 30 | `/{tenant}/admin/informasi/pengumuman` | `tenant.admin.informasi.pengumuman` | GET | `auth:tenant_admin` | Manajemen Pengumuman Resmi Kedinasan/Sekolah. |
| 31 | `/{tenant}/admin/informasi/pengumuman` | `tenant.admin.informasi.pengumuman.store` | POST | `auth:tenant_admin` | Terbitkan pengumuman resmi baru. |
| 32 | `/{tenant}/admin/informasi/pengumuman/{pengumuman}` | `tenant.admin.informasi.pengumuman.update` | PUT | `auth:tenant_admin` | Perbarui pengumuman resmi. |
| 33 | `/{tenant}/admin/informasi/pengumuman/{pengumuman}` | `tenant.admin.informasi.pengumuman.destroy` | DELETE | `auth:tenant_admin` | Hapus pengumuman resmi. |
| 34 | `/{tenant}/admin/informasi/agenda` | `tenant.admin.informasi.agenda` | GET | `auth:tenant_admin` | Manajemen Kalender & Agenda Kegiatan (tanggal, waktu, lokasi, registrasi). |
| 35 | `/{tenant}/admin/informasi/agenda` | `tenant.admin.informasi.agenda.store` | POST | `auth:tenant_admin` | Tambah agenda kegiatan baru. |
| 36 | `/{tenant}/admin/informasi/agenda/{agenda}` | `tenant.admin.informasi.agenda.update` | PUT | `auth:tenant_admin` | Perbarui agenda kegiatan sekolah. |
| 37 | `/{tenant}/admin/informasi/agenda/{agenda}` | `tenant.admin.informasi.agenda.destroy` | DELETE | `auth:tenant_admin` | Hapus agenda kegiatan sekolah. |
| 38 | `/{tenant}/admin/informasi/galeri` | `tenant.admin.informasi.galeri` | GET | `auth:tenant_admin` | Manajemen Galeri Album Foto & Video Dokumentasi. |
| 39 | `/{tenant}/admin/informasi/galeri/album` | `tenant.admin.informasi.galeri.album.store` | POST | `auth:tenant_admin` | Buat album galeri baru (tipe foto/video). |
| 40 | `/{tenant}/admin/informasi/galeri/album/{album}` | `tenant.admin.informasi.galeri.album.update` | PUT | `auth:tenant_admin` | Perbarui data album galeri. |
| 41 | `/{tenant}/admin/informasi/galeri/album/{album}` | `tenant.admin.informasi.galeri.album.destroy` | DELETE | `auth:tenant_admin` | Hapus album galeri beserta seluruh isinya. |
| 42 | `/{tenant}/admin/informasi/galeri/album/{album}/item` | `tenant.admin.informasi.galeri.item.store` | POST | `auth:tenant_admin` | Tambah berkas foto / video YouTube ke dalam album. |
| 43 | `/{tenant}/admin/informasi/galeri/item/{item}` | `tenant.admin.informasi.galeri.item.destroy` | DELETE | `auth:tenant_admin` | Hapus satu item media dari album. |
| 44 | `/{tenant}/admin/informasi/fasilitas` | `tenant.admin.informasi.fasilitas` | GET | `auth:tenant_admin` | Manajemen Sarana & Fasilitas Sekolah (foto utama 4:3, multi-foto tambahan, stats). |
| 45 | `/{tenant}/admin/informasi/fasilitas` | `tenant.admin.informasi.fasilitas.store` | POST | `auth:tenant_admin` | Tambah fasilitas/ruangan baru beserta galeri fotonya. |
| 46 | `/{tenant}/admin/informasi/fasilitas/{fasilitas}` | `tenant.admin.informasi.fasilitas.update` | PUT | `auth:tenant_admin` | Perbarui data fasilitas dan galeri fotonya. |
| 47 | `/{tenant}/admin/informasi/fasilitas/{fasilitas}` | `tenant.admin.informasi.fasilitas.destroy` | DELETE | `auth:tenant_admin` | Hapus fasilitas sekolah. |
| 48 | `/{tenant}/admin/informasi/fasilitas/foto/{foto}` | `tenant.admin.informasi.fasilitas.foto.destroy` | DELETE | `auth:tenant_admin` | Hapus satu foto dokumentasi tambahan fasilitas. |
| 49 | `/{tenant}/admin/informasi/fasilitas/stats/update` | `tenant.admin.informasi.fasilitas.stats.update` | POST/PUT | `auth:tenant_admin` | Simpan angka metrik statistik sarpras (ruang kelas, lab, perpustakaan, internet). |
| 50 | `/{tenant}/admin/informasi/hero/{modul}` | `tenant.admin.informasi.hero` | POST/PUT | `auth:tenant_admin` | Simpan kustomisasi hero banner publik untuk modul informasi terkait. |
| 51 | `/{tenant}/admin/informasi/toggle-status` | `tenant.admin.informasi.toggle-status` | POST | `auth:tenant_admin` | Sakelar AJAX untuk visibilitas per-item atau feature flag global modul informasi. |
| 52 | `/{tenant}/admin/gtk` | `tenant.admin.gtk.index` | GET | `auth:tenant_admin` | Panel Manajemen Struktur Organisasi & Guru Tenaga Kependidikan (GTK). |
| 53 | `/{tenant}/admin/gtk/struktur` | `tenant.admin.gtk.struktur.update` | PUT | `auth:tenant_admin` | Simpan kustomisasi banner hero & diagram struktur organisasi. |
| 54 | `/{tenant}/admin/gtk/pejabat` | `tenant.admin.gtk.pejabat.store` | POST | `auth:tenant_admin` | Tambah data pejabat struktural baru. |
| 55 | `/{tenant}/admin/gtk/pejabat/{pejabat}` | `tenant.admin.gtk.pejabat.update` | PUT | `auth:tenant_admin` | Perbarui data pejabat struktural. |
| 56 | `/{tenant}/admin/gtk/pejabat/{pejabat}` | `tenant.admin.gtk.pejabat.destroy` | DELETE | `auth:tenant_admin` | Hapus data pejabat struktural. |
| 57 | `/{tenant}/admin/gtk/guru-hero` | `tenant.admin.gtk.guru.hero.update` | PUT | `auth:tenant_admin` | Simpan pengaturan banner hero halaman Guru & Staf publik. |
| 58 | `/{tenant}/admin/gtk/guru` | `tenant.admin.gtk.guru.store` | POST | `auth:tenant_admin` | Tambah data Guru / Tenaga Kependidikan baru. |
| 59 | `/{tenant}/admin/gtk/guru/{guru}` | `tenant.admin.gtk.guru.update` | PUT | `auth:tenant_admin` | Perbarui data Guru / Tenaga Kependidikan. |
| 60 | `/{tenant}/admin/gtk/guru/{guru}` | `tenant.admin.gtk.guru.destroy` | DELETE | `auth:tenant_admin` | Hapus data Guru / Tenaga Kependidikan. |

### 4.1 Shortcut Global

| URL | Route Name | Perilaku |
|---|---|---|
| `/admin` | `admin.shortcut` | Mengarah ke `/{tenant}/admin/profil` bila tenant terikat & sesi admin aktif, selain itu ke `/{tenant}/admin/login`. |
| `/admin/login` | `admin.login.shortcut` | Mengarah ke halaman login admin sekolah aktif pertama. |

