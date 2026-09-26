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
