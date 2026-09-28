# Changelog — Website Sekolah

Format mengacu pada [Keep a Changelog](https://keepachangelog.com/).

## [Phase 5: Pengaturan Tema Warna Mandiri & 7 Preset Tema] - 2026-09-28

### Added
- **Pengaturan Tema Warna Mandiri pada Panel Admin (`PengaturanController` & `tenant/admin/pengaturan/index.blade.php`)**:
  - Tab navigasi baru **"Tema & Warna"** pada menu Identitas & Tampilan Sekolah.
  - **7 Preset Tema Warna Sekolah Terverifikasi**:
    1. *Biru Navy Klasik* (`navy_classic`): Institusi formal & wibawa (`#1E3A8A`, aksen `#0284C7`, tombol `#1D4ED8`).
    2. *Hijau Zamrud Edukasi* (`emerald_nature`): Bernuansa alam, islami & ramah lingkungan (`#065F46`, aksen `#10B981`, tombol `#059669`).
    3. *Merah Marun Prestisius* (`maroon_prestige`): Berani, bergengsi & berkarakter kuat (`#881337`, aksen `#F43F5E`, tombol `#BE123C`).
    4. *Ungu Dinamis Kreatif* (`royal_purple`): Modern, seni, teknologi & kreativitas vokasi (`#581C87`, aksen `#A855F7`, tombol `#7E22CE`).
    5. *Abu Gelap Elegan* (`slate_dark`): Minimalis modern berorientasi industri (`#0F172A`, aksen `#38BDF8`, tombol `#1E293B`).
    6. *Emas Oranye Enerjik* (`amber_sunset`): Hangat, inovatif & kewirausahaan (`#78350F`, aksen `#F59E0B`, tombol `#D97706`).
    7. *Teal Bahari Futuristik* (`teal_modern`): Profesional, teknologi & sains kelautan/vokasi (`#134E4A`, aksen `#14B8A6`, tombol `#0D9488`).
  - **Custom Color Pickers**: Dukungan pemilihan kode Hex bebas untuk Warna Tema Utama (`warna_tema`), Warna Aksen (`warna_aksen`), Warna Teks Konten (`warna_teks`), Warna Kartu (`warna_kartu`), Warna Tombol (`warna_tombol`), Warna Teks Tombol (`warna_tombol_teks`), dan Warna Header Bar (`warna_header`).
  - **Pratinjau Interaktif Real-Time (Live Preview)**: Komponen simulasi interaktif di panel admin yang langsung merespons setiap perubahan warna kartu, teks, tombol, badge aksen, dan header.
  - **Penyimpanan Permanen ke Database**: Seluruh konfigurasi warna tersimpan di database tenant tabel `pengaturan_umum` dan diakses terpadu oleh controller publik.
- **Refactoring CSS Variabel Dinamis & Komponen Publik (`layouts/public.blade.php` & `home.blade.php`)**:
  - Penambahan CSS variables `:root` (`--theme-color`, `--theme-accent`, `--theme-text`, `--theme-card-bg`, `--theme-btn-bg`, `--theme-btn-text`, `--theme-header-bg`).
  - Penggantian warna statis/hardcoded Tailwind dengan kelas utilitas tema (`theme-btn-primary`, `theme-card`, `theme-header`).

## [Unreleased] - 2026-09-28

### Changed
- **Skema Warna Header, Footer, & Navigasi ke Biru Institusional**:
  - Header top bar: latar belakang `theme-bg` (biru tua) mengganti `bg-slate-900`, teks ikon `text-blue-100/200`.
  - Navigasi desktop & mobile drawer: warna aktif `bg-blue-900` mengganti `bg-slate-900`, hover link `text-blue-300`.
  - Footer: latar belakang `theme-bg`, teks `text-blue-100/200/300`, ikon sosial `bg-blue-800`.
  - Akreditasi di header & footer: `text-emerald-400` diganti `text-white` sesuai permintaan pengguna.
- **Container Lebih Lebar**: max-width `container-custom` diperluas dari 1200px ke 1440px untuk tampilan desktop yang lebih lega.
- **Hero Banner Full Width**: banner hero beranda diubah full-width (edge-to-edge) dengan menghilangkan border-radius, shadow, dan border. Tinggi dinaikkan dari `h-44/64/80` ke `h-64/96/[450px]`.
- **Warna Hero Carousel**: overlay gradient dan semi-transparent diganti ke palet biru yang konsisten.

## [Phase 4: Penyelarasan Rules & Direct Workflow] - 2026-09-28

### Added
- **Penyederhanaan Rules & Efisiensi Alur Kerja**:
  - Menghilangkan bagian checklist audit dan analisis dampak teoritis dari [AGENTS.md](file:///d:/databaru/Magang/website_sekolah/AGENTS.md) dan [docs/RULES.md](file:///d:/databaru/Magang/website_sekolah/docs/RULES.md).
  - Menegaskan prinsip: **Wajib membaca file .md di awal**, **eksekusi langsung tanpa bertele-tele**, **database wajib 100% berelasi (FK & model)**, dan **wajib sinkronisasi dokumen .md di akhir**.

## [Phase 3: Media Video Slider Banner Hero & Banner Beranda Terpadu] - 2026-09-28

### Added
- **Dukungan Video pada Menu Admin Slider Banner Hero**:
  - Menambahkan kolom `video` pada tabel `slider_beranda` dengan migrasi tenant.
  - Memperbarui formulir Tambah (`create.blade.php`) dan Edit (`edit.blade.php`) pada menu admin **Slider Banner Hero** agar pengelola sekolah dapat mengunggah file video (MP4/WebM hingga 50MB) atau memasukkan tautan CDN video.
  - Menambahkan validasi dan penyimpanan file video pada `SliderController.php`.
  - Menambahkan indikator status badge `Video` pada daftar tabel dan kartu grid `index.blade.php`.
  - Menghubungkan pemutaran otomatis video pada slider carousel utama beranda (`home.blade.php`) dengan transisi ke slide berikutnya saat video selesai diputar.

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
