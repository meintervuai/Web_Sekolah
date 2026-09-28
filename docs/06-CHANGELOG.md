# Changelog — Website Sekolah

Format mengacu pada [Keep a Changelog](https://keepachangelog.com/).

## [Phase 2: Redesign Publik Base Tailwind & Kalender Interaktif] - 2026-09-28

### Added
- **Perombakan Estetika Beranda (Anti-AI Slop)**:
  - Tipografi: Mengganti font heading menjadi `Plus Jakarta Sans` dan teks bacaan menjadi `Inter` untuk menghilangkan nuansa membulat ala template AI SaaS.
  - Statistik Counter Dapodik: Menghilangkan latar gradien neon ungu-biru dan warna pelangi (kuning, hijau, ungu, cyan, rose) pada angka 0; diganti dengan angka monokromatik putih yang solid dan kartu berlatar `bg-slate-800/80` berbingkai halus.
  - Desain Kartu & Tombol: Menghilangkan efek glow mengambang dan saturasi warna berlebih pada tombol dan kartu fitur; menerapkan palet warna institusional yang tenang (Navy, Slate, dan Neutral).
  - Galeri Foto Beranda: Menghapus bagian galeri foto dari halaman beranda sesuai instruksi pengguna.
- **Redesain Antarmuka Publik (Base Tailwind Theme)**:
  - Pembaruan `layouts/public.blade.php`: Header sticky modern, topbar informasi kontak, drawer mobile yang responsif dan dapat ditutup via tombol Escape, modal lightbox global tanpa overflow, footer korporat modern.
  - Pembaruan `home.blade.php`: Hero section dengan kontras WCAG AA, kartu fitur terstruktur, bento grid proporsional, integrasi sambutan kepala sekolah, statistik Dapodik teranimasi, serta integrasi agenda.
  - Perombakan total `agenda.blade.php` sesuai referensi [Events Reference](https://projeto-website-escolar-i1jo.vercel.app/events):
    - Layout 3-kolom: Sidebar kiri berisi widget Kalender Interaktif (Alpine.js dengan navigasi bulan/tahun, deteksi hari ber-agenda, pemilihan tanggal dinamis) dan daftar filter kategori agenda.
    - Kolom kanan berisi daftar agenda dalam kartu horizontal (thumbnail cover di sebelah kiri, badge tanggal, jam, lokasi, deskripsi, dan tombol aksi).
    - Hero section agenda dilengkapi dengan kartu featured highlight agenda unggulan.
  - Pembaruan `kalender.blade.php`: Penampil dokumen resmi PDF/gambar Semester Ganjil & Genap dengan kartu ringkas dan daftar timeline agenda akademik.
  - Pembaruan `PageController@agenda`: Menyediakan variabel `$allAgenda` dan `$featuredAgenda` untuk mendukung interaktivitas widget kalender dan highlight hero.

### Compliance & Anti-Slop
- Seluruh kode bebas dari AI slop (tanpa tanda baca em-dash `—`, tanpa gradien neon berlebih, tanpa angka pelangi, tanpa link kosong `#`, serta touch target >= 44px).
- Verifikasi otomatis Pest: 33 tests passed (123 assertions, 100% green).

## [Phase 1: Implementasi Publik SMK Negeri 2 Bandung] - 2026-09-26

### Added
- **14 Halaman Publik Canonical & Responsif:**
  - `/` (Beranda lengkap: Hero carousel interaktif, sambutan kepala sekolah, counter statistik Dapodik, 7 program keahlian, berita, agenda, pengumuman, prestasi, galeri, SPMB, Google Maps).
  - `/profil` (Profil lengkap: sejarah, visi-misi-tujuan, struktur organisasi, data statistik).
  - `/program-keahlian` & `/program-keahlian/{slug}` (7 jurusan resmi dengan detail silabus, kompetensi, prospek karir, dan CTA SPMB).
  - `/berita` & `/berita/{slug}` (Listing berita dengan filter kategori, pencarian, pagination, detail artikel dengan reading width 760px, metadata lengkap, share buttons, dan related posts).
  - `/agenda` & `/agenda/{slug}` (Kalender agenda dengan filter tab mendatang/lampau, pencarian, calendar box badge, waktu, lokasi, dan detail rundown).
  - `/pengumuman` & `/pengumuman/{slug}` (Format surat edaran kedinasan resmi, pencarian, tombol cetak dokumen, dan sidebar pengumuman terkini).
  - `/prestasi` & `/prestasi/{slug}` (Hall of fame prestasi dengan filter tingkat & tahun, medal badges, nama peraih penghargaan, dan lightbox dokumentasi).
  - `/kegiatan` (Dokumentasi aktivitas sekolah, preview strip album, dan timeline event).
  - `/ekstrakurikuler` & `/ekstrakurikuler/{slug}` (8 kegiatan ekskul resmi dengan jadwal, nama pembina, dan deskripsi program).
  - `/guru-staf` (Direktori 98 tenaga pendidik resmi, pencarian nama/mapel, kartu profil profesional).
  - `/fasilitas` (Koleksi sarana & prasarana rasio 4:3, overview statistik, dan trigger zoom lightbox).
  - `/galeri` (Galeri foto & video dengan filter album dan modal lightbox Alpine.js).
  - `/spmb` & `/ppdb` (Informasi pendaftaran PPDB Jawa Barat, jalur seleksi, alur pendaftaran, persyaratan dokumen, kuota rombel 7 jurusan, kontak helpdesk).
  - `/kontak` (Informasi kantor, jam operasional layanan, nomor telepon/WhatsApp, peta Google Maps interaktif, formulir kirim pesan tervalidasi yang tersimpan ke tabel `pesan_masuk`).
- **Database & Model:**
  - Migrasi `agenda` dan penambahan kolom `slug`, `pembina`, `tahun` di tabel tenant.
  - Model `PengaturanFitur` dengan helper `isAktif($kodeFitur, $default = true)`.
  - Model-model tenant: `Agenda`, `Ekstrakurikuler`, `PrestasiSiswa`, `Fasilitas`, `FotoFasilitas`, `GuruStaf`, `GaleriAlbum`, `GaleriItem`, `PesanMasuk`, `SliderBeranda`.
  - Konfigurasi `protected $connection = 'tenant'` pada seluruh model tenant dan `protected $connection = 'mysql'` pada seluruh model central.
  - Perbaikan `TenantMiddleware` dengan `DB::purge('tenant')` dan `DB::reconnect('tenant')` untuk isolasi koneksi multi-tenant yang aman dan konsisten.
- **Seeder Resmi SMKN 2 Bandung (`TenantSmkn2BandungSeeder`):**
  - Data valid resmi: NPSN 20219146, Akreditasi A, Jl. Ciliwung No. 4, telp (022) 7234285, email humas@smkn2bandung.sch.id.
  - Data Dapodik: 98 guru, 1.972 siswa, 54 rombel, 41 kelas, 1 lab, 1 perpus, 7 jurusan, 85 mitra industri.
  - Data lengkap terisi di seluruh 14 modul (tidak ada halaman kosong/lorem ipsum).
- **Pengujian & QA:**
  - Pest Feature Test `TenantPublicPagesTest`: 15 skenario pengujian mencakup 14 rute publik, form kontak ke database, dan feature flag.
  - Total 24 pengujian di seluruh test suite berhasil (82 assertions, 100% green).
  - Pembersihan kode menggunakan Laravel Pint (`vendor/bin/pint --dirty`).
