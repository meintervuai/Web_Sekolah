# Changelog — Website Sekolah

Format mengacu pada [Keep a Changelog](https://keepachangelog.com/).

## [Perbaikan Konversi Gambar Palette WebP & Tangkapan Notifikasi Toast Error Upload] - 2026-09-29

### Fixed
- **Konversi Palette / Indexed Image ke WebP ([MediaService.php](file:///d:/databaru/Magang/website_sekolah/app/Services/MediaService.php))**:
  - Menambahkan pengecekan otomatis `imageistruecolor()` dan konversi `imagepalettetotruecolor()` sebelum memproses dan menyimpan berkas gambar ke format WebP.
  - Memperbaiki kegagalan unggah dengan pesan error `imagewebp(): Palette image not supported by webp` pada berkas PNG 8-bit, GIF, dan gambar berpalet indexed.
  - Mengamankan channel transparansi alpha pada seluruh alur proses resize, crop, dan kompresi WebP.
- **Tangkapan Notifikasi Error Toast ([tenant_admin.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/tenant_admin.blade.php), [MediaController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/MediaController.php))**:
  - Memastikan toast alert merah muncul otomatis di antarmuka pengguna ketika terjadi error validasi berkas (`$errors->any()`) atau eksepsi kegagalan unggah server (`session('error')`).

## [Perbaikan Navigasi Halaman Error & Konfigurasi Batas Unggah Media 64MB] - 2026-09-29

### Fixed
- **Halaman Error 500 & 404 ([500.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/errors/500.blade.php), [404.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/errors/404.blade.php))**:
  - Mengganti tombol static menjadi tombol pintar **"Kembali ke Halaman Sebelumnya"** (`window.history.back()`) dengan fallback ke beranda sekolah tenant (`/{tenant}`).
  - Menghapus tombol **Super Admin** dari halaman error tenant publik.
- **Konfigurasi Direktori Temporer Unggah (`upload_tmp_dir`)**: Menetapkan folder dedicated `storage/tmp` pada `php.ini` untuk mengatasi error `PHP Request Startup: File upload error - unable to create a temporary file` akibat kendala izin folder AppData Temp Windows.
- **Animasi Geser Halus Toggle Switch ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**: Menambahkan binding style `transform: translateX(20px)` saat aktif dan `translateX(0px)` saat nonaktif dengan `transition-transform duration-300 ease-in-out` agar bulatan sakelar meluncur mulus.



### Changed
- **Penyederhanaan Header Admin**: Menghapus card sub-header duplikat di dalam view `profil/index.blade.php` dan mengintegrasikan judul utama ke header navigasi layout (`@section('header_title', 'Pengaturan Profil & Konten Sekolah')`).
- **Pembersihan Sakelar Inline Visibilitas**: Menghapus switch sakelar di Tab 2 (Sejarah), Tab 3 (Visi & Misi), dan Tab 4 (Struktur) agar pengaturan visibilitas menu publik terpusat di **Tab 5 (Visibilitas Menu & Rute)**.
- **Mode Tampilan Struktur Organisasi**: Admin dapat memilih apakah halaman publik `/profil/struktur` menampilkan:
  1. *Tampilkan Keduanya* (Jajaran Pejabat & Bagan Diagram dengan tab switcher),
  2. *Hanya Jajaran Pejabat*, atau
  3. *Hanya Bagan Diagram Struktur*.
- **Repeater Dinamis Bagan Diagram**: Menambahkan fitur tombol **"+ Tambah Bagan Baru"** dan **"Hapus Bagan"** dinamis berbasis Alpine.js dengan integrasi Pusat Media sehingga admin bebas menambah/mengurangi bagan diagram tanpa batasan.
- **Perbaikan Animasi Toggle Switch**: Menjamin posisi thumb switch toggle bergeser ke kanan (`translate-x-5`) saat aktif (biru) dan ke kiri (`translate-x-0`) saat nonaktif (abu-abu).

## [Kustomisasi Hero Banner Profil Lengkap, Fade Mask Gambar & Tab 1 Profil Lengkap] - 2026-09-29

### Added
- **Kustomisasi Hero Banner Halaman Profil Publik ([profil.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/profil.blade.php))**:
  - Penyesuaian nama tab pertama di admin menjadi **"1. Profil Lengkap"**.
  - Menyediakan input pengaturan **Judul Utama Hero**, **Subjudul / Deskripsi Hero**, **Pola Dekorasi Latar (Radial Dots / Grid / Mesh / Polos)**, serta **Gambar Latar Hero** dari Pusat Media.
  - Implementasi desain hero banner artistik (Opsi 1): jika gambar latar diisi oleh Admin, gambar tampil di sisi kanan dengan efek *gradual fade mask* ke kiri (luntur menyatu halus dengan warna latar gelap) disertai *drop-shadow* pada teks judul dan deskripsi agar tetap kontras dan sangat mudah dibaca. Jika tidak diisi gambar, hero kembali ke tampilan tema gelap bersih standar.
- **Pembaruan Controller Admin ([ProfilController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/ProfilController.php))**:
  - Menyimpan `judul_profil`, `subjudul_profil`, `pola_latar_profil`, dan `gambar_banner_profil` ke tabel `halaman_statis` (slug `profil`).

## [CMS Manajemen Profil Sekolah, WYSIWYG Editor, Integrasi Media & Kontrol Visibilitas Rute] - 2026-09-29

### Added
- **Manajemen Profil Sekolah CMS (`app/Http/Controllers/Tenant/Admin/ProfilController.php`)**:
  - Menyediakan panel admin terpadu dengan 5 tab interaktif (*Identitas & Sambutan*, *Sejarah Sekolah*, *Visi & Misi*, *Struktur Organisasi*, dan *Visibilitas Menu & Rute*).
  - Tersimpan 100% berelasi di database (`pengaturan_umum`, `halaman_statis`, `struktur_organisasi`, `pengaturan_fitur`, `menus`) dengan tracking foreign key `pengguna_id = auth('tenant_admin')->id()`.
- **Editor Teks WYSIWYG (Quill.js)**:
  - Integrasi editor teks WYSIWYG clean tanpa AI slop untuk penyuntingan konten *Sejarah Sekolah* dan *Visi, Misi & Sasaran Mutu*.
- **Integrasi Pustaka Media (Pusat Berkas Media Picker)**:
  - Terintegrasi langsung dengan database `media` sekolah sehingga admin dapat memilih foto/video yang telah diunggah atau mengunggah berkas baru langsung dari modal pemilih media.
- **Kontrol Visibilitas Dinamis (Feature Flag & Menu Toggle)**:
  - Admin dapat menyembunyikan atau menampilkan sub-menu/halaman (`Sejarah`, `Visi & Misi`, `Struktur Organisasi`, `Guru & Staf`, `Fasilitas`).
  - Ketika dinonaktifkan: link otomatis hilang dari navbar desktop & mobile drawer publik, dan rute publik mengembalikan respon **HTTP 404 (Not Found)** secara otomatis untuk perlindungan konten.
- **Sidebar Admin Layout (`resources/views/layouts/tenant_admin.blade.php`)**:
  - Menambahkan menu navigasi "Profil Sekolah" pada sidebar panel admin.
- **Pest Feature Test Suite (`tests/Feature/TenantAdminProfilTest.php`)**:
  - 6 unit & feature test komprehensif menguji seluruh alur update identitas, konten WYSIWYG, relasi database pejabat, media picker, dan respon 404 saat fitur dinonaktifkan (69 test / 420 assertions passing 100%).

## [Pengecualian Resmi Identitas Merek Tombol Floating WhatsApp] - 2026-09-29

### Added
- **Pengecualian Resmi Identitas Merek Pihak Ketiga (WhatsApp)**:
  - Memastikan tombol floating WhatsApp resmi pada [`resources/views/layouts/public.blade.php`](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/public.blade.php) tetap mempertahankan warna hijau identitas aslinya (`#25D366` dan hover `#20ba5a`).
  - Memperbarui dokumentasi rule [`.ai/rules/publik-tema-kontras.md`](file:///d:/databaru/Magang/website_sekolah/.ai/rules/publik-tema-kontras.md) dan [`docs/08-CSS-ARSITEKTUR-TEMA.md`](file:///d:/databaru/Magang/website_sekolah/docs/08-CSS-ARSITEKTUR-TEMA.md) dengan klausul pengecualian identitas merek pihak ketiga (seperti WhatsApp, YouTube, Google Maps) agar warna khas brand tidak tertimpa tema sekolah.

## [Perbaikan Durasi Sesi Login Admin 1 Minggu & Isolasi Koneksi Session Database] - 2026-09-29

### Fixed
- **Penyebab Sesi Cepat Logout (Root Cause)**:
  - Pada [`TenantMiddleware`](file:///d:/databaru/Magang/website_sekolah/app/Http/Middleware/TenantMiddleware.php), pemanggilan `DB::setDefaultConnection('tenant')` sebelumnya mengubah koneksi default Laravel secara global. Akibatnya, saat middleware session berjalan menyimpan/membaca data sesi ke tabel `sessions`, query terlempar mencari tabel `sessions` di database tenant (yang memang tidak memiliki tabel sessions), sehingga driver session kehilangan state dan mereset sesi pengguna setelah beberapa menit.
- **Perbaikan Isolasi Koneksi & Durasi Sesi**:
  - Menghapus `DB::setDefaultConnection('tenant')` dari `TenantMiddleware` sehingga koneksi default framework tetap `mysql` (central), sementara model-model tenant tetap terisolasi 100% menggunakan `protected $connection = 'tenant'`.
  - Mengunci konfigurasi `SESSION_CONNECTION=mysql` di [`config/session.php`](file:///d:/databaru/Magang/website_sekolah/config/session.php), [`.env`](file:///d:/databaru/Magang/website_sekolah/.env), dan [`.env.example`](file:///d:/databaru/Magang/website_sekolah/.env.example).
  - Memperpanjang batas waktu sesi `SESSION_LIFETIME` menjadi **10080 menit (7 hari / 1 minggu)** agar admin tidak sering logout secara tiba-tiba saat bekerja.
  - Memperbarui regression test pada [`TenantAdminTest.php`](file:///d:/databaru/Magang/website_sekolah/tests/Feature/TenantAdminTest.php) untuk memverifikasi session lifetime 1 minggu.

### Verification
- `vendor/bin/pest`: **63 test / 377 assertions PASSED** (100% hijau).


## [Penyelarasan Hero Banner Seluruh Halaman Publik Mengikuti Standar Visi Misi & Tema] - 2026-09-29

### Changed
- **Penyelarasan Hero Banner Seluruh Halaman Publik (`resources/views/public/pages/*.blade.php`)**:
  - Mengganti seluruh latar gradient hardcoded (`from-slate-900 via-blue-950 to-indigo-950` dan varian gradient lama) dengan kelas tema baku `theme-bg-dark` dan pola dot matrix radial `var(--theme-accent)`.
  - Halaman yang diselaraskan:
    - [profil.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/profil.blade.php)
    - [visi-misi.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/visi-misi.blade.php)
    - [sejarah.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/sejarah.blade.php)
    - [jurusan.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/jurusan.blade.php)
    - [jurusan_detail.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/jurusan_detail.blade.php)
    - [berita.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/berita.blade.php)
    - [agenda.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/agenda.blade.php)
    - [agenda_detail.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/agenda_detail.blade.php)
    - [ekstrakurikuler.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/ekstrakurikuler.blade.php)
    - [fasilitas.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/fasilitas.blade.php)
    - [galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/galeri.blade.php)
    - [guru.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/guru.blade.php)
    - [kalender.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/kalender.blade.php)
    - [kegiatan.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/kegiatan.blade.php)
    - [kontak.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/kontak.blade.php)
    - [kurikulum.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/kurikulum.blade.php)
    - [osis.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/osis.blade.php)
    - [pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/pengumuman.blade.php)
    - [prestasi.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/prestasi.blade.php)
    - [spmb.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/spmb.blade.php)
    - [struktur.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/struktur.blade.php)
  - Merapikan struktur navigasi breadcrumb menjadi format standar `<ol>` / `<li>` dengan pewarnaan yang seragam dan lolos auto-kontras tema (`text-slate-300`, hover `text-white`, active `text-sky-300 font-medium`).
  - Menyelaraskan seluruh tautan hierarki breadcrumb (seperti rumpun `Beranda / Profil / [Nama Halaman]`, `Beranda / Akademik / Kurikulum`, `Beranda / Kesiswaan / OSIS & MPK`, dan `Beranda / Agenda / Kalender Akademik`).
  - Seluruh halaman publik kini otomatis merespons perubahan tema warna sekolah (Emerald/Hijau, Navy, Maroon, dll.) tanpa teks yang tidak terbaca atau gradien yang tidak selaras.

### Verification
- `vendor/bin/pest`: **63 test / 377 assertions PASSED** (100% hijau).
- `npm run build`: Berhasil mengompilasi aset CSS & JS.

## [Aturan Baru: Kontrak Tema & Auto-Kontras untuk Kode Publik] - 2026-09-29

### Added
- `.ai/rules/publik-tema-kontras.md` + `.ai/rules/index.md`: rule blocking (dibaca lewat `AGENTS.md` bagian 2) yang membuat setiap penambahan menu, halaman, section, atau komponen publik ditulis mengikuti sistem tema dan auto-kontras yang sudah ada: wajib kelas `.theme-*`, dilarang warna literal, komponen membaca variabel ter-scope (`--theme-heading`, `--theme-text`, `--theme-fg-link`, `--fg-zona-efektif`), SOP tambah menu (data `menu` + filter nama layout), SOP tambah halaman (`route tenant.*` -> `getSekolahData()` -> view `layouts.public` -> test), template scope kontras baru, SOP 6 titik kunci warna baru, anti-pattern, dan daftar verifikasi.
- `docs/08-CSS-ARSITEKTUR-TEMA.md`: referensi teknis (diagram alur warna, API `WarnaKontras`, 13 kunci panel + 16 kunci `--theme-fg-*`, registri 8 scope, inventaris kelas, resep cepat, fallback browser, pemeriksaan compiled CSS).

### Changed
- `docs/RULES.md` bagian 8: 8 poin standar tema & auto-kontras portal publik.
- `docs/05-UI-UX.md`: tautan ke rule dan referensi teknis pada bagian Auto-Kontras WCAG.
- `docs/07-IMPLEMENTATION-CHECKLIST.md`: Tahap 11 ditambahkan.

### Notes
- Tanpa perubahan kode runtime dan tanpa migrasi; test suite tidak terdampak.


## [Auto-Kontras WCAG Otomatis untuk Seluruh Permukaan Portal] - 2026-09-29

### Added
- **Helper `App\Support\WarnaKontras`** (`app/Support/WarnaKontras.php`): `luminans()`, `rasio()`, `pilihTeks()`, `campurWarna()` sesuai rumus luminance WCAG 2.1. Menerima hex 3 dan 6 digit; format tidak dikenal diperlakukan sebagai latar terang supaya teks tidak pernah ikut hilang.
- **Lapis server-side di `resources/views/layouts/public.blade.php`:** closure `$kontras()` menyuntik 16 kunci teks per permukaan (`--theme-fg-header`, `--theme-fg-footer`, `--theme-fg-zona`, `--theme-fg-tombol`, `--theme-fg-aksen`, `--theme-fg-link`, `--theme-fg-badge`, `--theme-fg-halaman-heading|text|muted`, `--theme-fg-section-heading|text|muted`, `--theme-fg-kartu-heading|text|muted`). Warna usulan admin dipakai selama lolos ambang (teks isi 4.5:1, tombol 3:1, tautan 2:1); bila tidak, putih/tinta `#0F172A` dipilih lewat argmax kontras.
- **Lapis client-side (pengaman) di `resources/css/public.css`:** `@property --kontras-aman` dan `--kontras-terang` bertipe integer yang beranimasi, dipakai sebagai sakelar `color-mix()` pada `--fg-zona-efektif` per scope (`:root`, `.theme-page-bg`, `.theme-section-bg`, `.theme-card` / `.bg-white/80|/90`, `.theme-badge`, zona gelap `.theme-bg`/`bg-blue-900`, `.theme-header`, `footer.theme-bg`/`footer.theme-footer`). Deteksi memakai `calc(var(--fg) contrast(var(--bg)) >= 4.5)`, sehingga override warna dari DevTools, ekstensi browser, atau JS tetap dipaksa terbaca.
- **Pratinjau admin sejalan hasil render (`resources/views/tenant/admin/pengaturan/index.blade.php`):** salinan JS `WarnaKontras` (`luminans`/`rasio`/`pilihTeks`/`campur`) beserta computed getter `fgHeader`, `fgFooter`, `fgTombol`, `fgAksen`, `fgKartuHeading`, `fgKartuTeks`, `fgKartuMuted`, `fgSectionHeading`, `fgBadge`, `fgLink` menggantikan pemakaian warna mentah panel pada mock header, section, kartu, dan footer.
- **Test baru:** `tests/Unit/WarnaKontrasTest.php` (7 skenario / 22 assertion) dan 3 skenario auto-kontras pada `tests/Feature/TenantThemeColorTest.php`.

### Changed
- `--theme-fg-zone` menjadi `--theme-fg-zona` (konsistensi istilah); `--fg-zona-efektif` kini menjadi resolver yang bernilai berbeda per scope (header, footer, halaman, kartu, badge, zona gelap).
- Warna teks tidak lagi membaca `--theme-btn-text` secara mentah. Aturan `.text-blue-900`/`.text-blue-950`, `nav .text-blue-950`, `.theme-btn-ghost`, `.theme-table-head`, `.theme-input`, badge, serta zona gelap (pengganti `color-mix(..., black)`) kini membaca hasil auto-kontras.

### Verification
- `vendor/bin/pest`: **63 test / 377 assertions PASSED** (termasuk 9 skenario `TenantThemeColorTest`).
- `vendor/bin/pint --dirty`: passed.
- `npm run build`: `public/build/assets/public-CMXtt0o7.css` 34.00 kB (gzip 4.52 kB); compiled CSS tetap memuat 2 blok `@property`, 11 panggilan `contrast()`, dan 26 rujukan `--fg-zona-efektif`.
- Verifikasi angka kontras: `#FFFFFF` vs `#000000` = 21:1; judul `#0F2A22` di kartu `#052E1F` = 1.03:1 lalu dipaksa `#FFFFFF`; teks `#FFFFFF` di header `#F1F5F9` = 1.10:1 lalu dipaksa `#0F172A`; `#94A3B8` di atas putih = 2.56:1 (lolos ambang tautan, gagal ambang teks isi).

## [Pusat Media: Filter Monokrom Rapi, Crop Non-Destruktif, Toast Kanan Bawah & Pembersihan Warna] - 2026-09-29

### Changed
- **Penyelarasan & Perapian Filter Bar (Anti-Warna Pelangi)**:
  - Menggabungkan filter chips tipe media, dropdown kategori, form pencarian nama berkas, dan toggle Grid/Tabel ke dalam satu kesatuan toolbar rapi dan simetris.
  - Menghapus penggunaan aneka warna cerah/pelangi pada filter badge dan menggantinya dengan palet netral institusional yang elegan (Slate-900 / Slate-100 / Slate-600).
- **Arsitektur Crop Non-Destruktif (Perlindungan Berkas Master)**:
  - Memodifikasi `MediaService@prosesEditGambar` dan `MediaController@editImage`: Fitur crop dan rotasi gambar kini **TIDAK MENIMPA/MERUSAK** berkas master asli (`media.path` asli tetap utuh di database & storage server).
  - Menyimpan hasil potongan sebagai berkas WebP varian baru terpisah (`{nama}-crop-{timestamp}.webp`) dengan record media baru berstatus WebP teroptimasi.
- **Notifikasi Toast Mengambang di Pojok Kanan Bawah (Floating Auto-Dismiss Toast)**:
  - Menghapus banner flash alert statis di atas layout admin (`layouts/tenant_admin.blade.php`).
  - Menggantinya dengan kartu notifikasi Toast interaktif berbasis Alpine.js yang melayang di pojok kanan bawah (`fixed bottom-6 right-6 z-50`) dengan transisi animasi halus dan menghilang otomatis setelah 4 detik.
- **Perbaikan & Penguatan REST API Upload**:
  - Memastikan endpoint `POST /admin/media/upload` menangani payload JSON/Multipart secara aman dengan validasi respons status 200/422 dan penanganan error yang jelas.

### Verification
- `php artisan test tests/Feature/TenantMediaTest.php`: **10 test / 47 assertions PASSED** (100% hijau).
- `vendor/bin/pint --dirty`: Bersih dan sesuai standar PSR-12 / Laravel Pint.

## [Pusat Manajemen Media: Kotak Crop Interaktif, Bulk Action, Chips Mobile & Loading Feedback] - 2026-09-29

### Added
- **Editor Gambar dengan Kotak Crop Interaktif (Drag & Resize Box)**:
  - Kotak crop visual interaktif dengan garis bantu komposisi (*rule of thirds*), 4 sudut handle penarik ukuran, dan visualisasi area terpotong (*dark overlay*) secara real-time.
  - Perhitungan koordinat skala asli gambar (`crop_x`, `crop_y`, `crop_w`, `crop_h`) otomatis saat digeser atau diubah ukurannya sebelum disimpan ulang ke WebP.
- **Tampilan Filter Chips Mobile-Friendly**:
  - Filter tipe media dirombak menggunakan desain *chips badge* berbalut *horizontal scrollbar* yang ramah sentuhan layar ponsel/tablet.
  - Menampilkan jumlah berkas spesifik untuk setiap tipe secara presisi: `Semua (x)`, `Gambar (x)`, `Video Lokal (x)`, `YouTube (x)`, `Dokumen (x)`.
- **Penghapusan Massal & Multi-Select Checkbox**:
  - Checkbox pemilihan pada setiap kartu grid dan baris tabel, serta tombol centang *Pilih Semua Berkas*.
  - Endpoint & Method `POST /admin/media/bulk-delete` (`MediaController@bulkDestroy`) untuk menghapus banyak berkas sekaligus secara bersih dari database dan storage server.
- **Modal Konfirmasi Hapus Kustom (Anti-Native Alert)**:
  - Mengganti seluruh `window.confirm()` bawaan browser dengan modal dialog kustom Tailwind/Alpine yang modern dan terintegrasi dengan tema.
- **Indikator Loading & Feedback Interaksi Responsif (Anti-Freeze)**:
  - Spinner animasi dan status teks berjalan (*"Mengunggah & mengompresi WebP..."*, *"Mengunduh & menyimpan..."*, *"Memproses crop..."*, *"Menghapus..."*) pada setiap tombol aksi dan modal proses global.
- **Pembaruan Aturan Kerja (RULES.md & AGENTS.md)**:
  - Menambahkan aturan wajib penyediaan status loading animasi/spinner pada setiap pembuatan interaksi asinkron, manipulasi DOM, atau rute/REST API untuk mencegah kesan antarmuka lag atau membeku.
- **Pembersihan Tombol Salin URL & Posisi Layout**:
  - Menghapus tombol salin URL dari kartu dan tabel sesuai arahan.
  - Memposisikan toggle Grid/List konsisten di pojok kanan atas.
- **Test Suite Pest `TenantMediaTest`**: Menambahkan skenario uji bulk delete (total **52 test / 322 assertions PASSED**).

### Verification
- `php artisan test`: **52 test / 322 assertions PASSED** (100% hijau).
- `vendor/bin/pint`: Seluruh kode bersih dan terformat rapi.

## [Otentikasi Admin: Penguatan Remember Me & Durasi Sesi 24 Jam] - 2026-09-29

### Changed
- **Session Lifetime 1 x 24 Jam**: Mengubah durasi sesi login aplikasi (`SESSION_LIFETIME`) dari 120 menit (2 jam) menjadi **1440 menit (24 jam)** pada `.env`, `.env.example`, dan `config/session.php`. Sesi admin kini bertahan 24 jam dan baru logout otomatis setelah 1 x 24 jam tanpa aktivitas.
- **Formulir Login Admin (`login.blade.php`)**: Memperbaiki dan mempertegas atribut input *Ingat saya di perangkat ini* (`id="remember"`, `value="1"`, `{{ old('remember') ? 'checked' : '' }}`) yang terhubung langsung dengan `remember_token` pada database pengguna tenant.
- **Konsistensi Tema**: Memperbarui variabel turunan `--theme-color-light` di [`layouts/public.blade.php`](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/public.blade.php) agar menggunakan `var(--theme-page-bg)` dan tidak lagi menggunakan literal `white`.

### Verification
- `php artisan test`: **43 test / 285 assertions PASSED** (termasuk skenario pengujian remember me & konfigurasi sesi 1440 menit).

## [Halaman Profil: Logo Lebih Besar & Penggantian Sidebar dengan Video Player] - 2026-09-29

### Added
- **Komponen Video Profil Media Player** pada kolom kanan halaman profil publik ([`profil.blade.php`](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/profil.blade.php)) yang mendukung pemutaran video YouTube embed maupun video MP4/HTML5 native lengkap dengan judul dan deskripsinya.

### Changed
- **Logo Resmi Sekolah**: Ukuran ditingkatkan menjadi lebih besar (`w-36 h-36 sm:w-44 sm:h-44 md:w-48 md:h-48`) dan background wadah dibuat transparan (`bg-transparent`) tanpa border berlebih.

### Removed
- Sidebar lama (kartu kepala sekolah & menu navigasi redundan) di halaman profil digantikan oleh kartu video player.

### Verification
- `php artisan test tests/Feature/TenantPublicPagesTest.php`: **17 test / 60 assertions PASSED**.

## [Halaman Profil: Penambahan Logo Sekolah pada Kartu Identitas] - 2026-09-29

### Added
- **Logo Resmi Sekolah** pada kartu *Identitas Satuan Pendidikan* di halaman profil publik ([`profil.blade.php`](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/profil.blade.php)) dengan layout flex responsif yang terintegrasi dinamis dengan data/pengaturan tema.

### Verification
- `php artisan test tests/Feature/TenantPublicPagesTest.php`: **17 test / 60 assertions PASSED**.

## [Pembersihan Halaman Profil: Penghapusan Section Struktur Pimpinan Sekolah] - 2026-09-29

### Removed
- **Section "Struktur Pimpinan Sekolah"** (`#struktur`) pada halaman profil publik ([`profil.blade.php`](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/profil.blade.php)) beserta tautan menu navigasi anchor terkait.

### Verification
- `php artisan test`: **42 test / 278 assertions PASSED**.

## [Kelompok Warna Lengkap: Semua Keluarga Ikut Panel Tema Tanpa Pengecualian] - 2026-09-29

### Added
- **133 variabel palet baru di `:root` `resources/css/public.css`** (total kini **199**): `--color-purple-*`/`--color-violet-*`/`--color-fuchsia-*`/`--color-pink-*` → skala `--theme-identity-*`; `--color-green-*`/`--color-emerald-*`/`--color-lime-*`/`--color-teal-*`/`--color-cyan-*`/`--color-yellow-*`/`--color-red-*`/`--color-rose-*` → skala `--theme-accent-*`; `--color-gray-*`/`--color-zinc-*`/`--color-stone-*`/`--color-neutral-*` → skala `--theme-neutral-*`; `--color-white` → `--theme-identity-50`.
- **Aturan arbitrary value WhatsApp**: `.bg-\[\#25D366\]` → `--theme-accent` + `--theme-btn-text`, `.hover\:bg-\[\#20ba5a\]:hover` → aksen digelapkan (tenant `smk-negeri-2-bandung`, `layouts/public.blade.php:529`).

### Changed
- **Sapu bersih sisa putih (tindak lanjut laporan "masih ada putih"):** 37 dasar campuran `color-mix(..., white)` di `public.css` → `var(--theme-page-bg)`, `--color-white` → `var(--theme-btn-text)` (sebelumnya `--theme-identity-50` yang ±95% putih), titik radial hero → `--theme-accent-400`, serta pratinjau panel admin memakai Alpine `btnText`/`pageBg` (4 teks `rgba(255,255,255,..)` + badge `white` dihapus; 1 bug CSS `rgba(...0.85"` ikut terbenahi).
- **Seluruh literal putih hardcoded diganti kunci panel `warna_tombol_teks`** (permintaan pemilik produk: "semua dikelompokan dan ikut tema"): aturan header/footer (`theme-text`/`theme-accent-text`/`text-blue-700`), breadcrumb `text-blue-100`/`text-blue-200`, amber di dark card & `section.theme-bg`, `group-hover:text-sky-300`, dan aturan "PENGECUALIAN ZONA GELAP" kini `color-mix(in srgb, var(--theme-btn-text) …, transparent)`. Dengan preset default (`warna_tombol_teks` = `#FFFFFF`) hasil visual identik dengan sebelumnya; saat kunci diubah lewat panel Tema & Warna, semua teks ikut berubah.
- **Pengecualian semantik dihapus:** `emerald`/`green`/`red`/`rose`/`yellow`/`teal`/`cyan`/`lime` kini ikut grup aksen; merek WhatsApp `#25D366`/`#20ba5a` ikut aksen. Hanya overlay `bg-black/xx` yang tetap hitam (fungsi redup, bukan warna tema).

### Verification
- `php artisan test`: **42 test / 278 assertions PASSED**; `vendor/bin/pint --dirty` bersih (guardrail baru: `public.css` & pratinjau panel dilarang memuat `, white` / `rgba(255,255,255`).
- `npm run build`: sukses, `public/build/assets/public-CCKXuORS.css` (28,54 kB); sisa `, white` & `rgba(255` di file hasil build = 0.
- Request HTTP nyata ke `/{tenant}` pada port **8123 dan 8000** menautkan `public-CCKXuORS.css`.

## [Penutupan Celah Pemetaan Warna: Override Palet Tailwind v4] - 2026-09-29

### Added
- **Skala turunan baru di `resources/css/public.css`:** `--theme-identity-50..950` (dari `--theme-color`), `--theme-accent-50..950` (dari `--theme-accent`), dan `--theme-neutral-50..950` (terang dari `--theme-text-muted`, gelap dari `--theme-color`), semuanya via `color-mix()`.
- **Override 66 variabel palet Tailwind v4 di `:root`:** `--color-blue-*` & `--color-indigo-*` → skala identitas, `--color-sky-*`, `--color-amber-*`, `--color-orange-*` → skala aksen, `--color-slate-*` → skala netral. Menutup kelas yang sebelumnya lolos dari Legacy Utility Mapping: `text-blue-300/400/50`, `hover:text-blue-300`, varian opacity (`bg-blue-950/70`, `border-blue-900/30`, `border-slate-200/80`), gradien (`from-blue-700`, `via-blue-950`, `to-indigo-950`, `from-slate-900`), `ring-blue-*`, `placeholder-slate-400`, serta `text-slate-200/300` pada breadcrumb hero gelap.
- **Override pola titik radial hardcoded `#38bdf8`** (dekorasi hero ±17 halaman) → mengikuti `--theme-accent`; `border-slate-100/200` ber-opacity → `--theme-border`.
- **Test Pest `TenantThemeColorTest` skenario ke-6:** `pemetaan palet Tailwind v4 menutup kelas warna yang lolos dari tema`.

### Changed
- **`resources/css/public.css`**: blok `:root` baru di akhir file; deklarasi tanpa layer menang atas `@layer theme` bawaan Tailwind v4, sehingga seluruh utilitas (termasuk varian `hover:`/`focus:`, opacity `/xx`, gradien `from-via-to`, `ring`, `placeholder`) ikut mengikuti tema tanpa mengedit view. Aturan kontekstual lama (zona gelap, `.bg-blue-600` → tombol, dll) tetap menang karena lebih spesifik dan `!important`.
- **Keputusan semantik:** keluarga `emerald` (sukses/Aktif), `rose`/`red` (error & validasi form), dan merek WhatsApp `bg-[#25D366]` sengaja TIDAK dipetakan agar makna status tetap terbaca.

### Verification
- `php artisan test`: **42 test / 254 assertions PASSED**; `vendor/bin/pint --dirty` bersih.
- `npm run build`: sukses, `public/build/assets/public-DCqQ4nZP.css` (20.03 kB) memuat seluruh override `--color-*`.
- Request HTTP nyata ke `/{tenant}/program-keahlian/teknik-mesin` menautkan `public-DCqQ4nZP.css` dan tetap menyuntik palet `#BE123C`.

## [Sistem Warna Global Terkelompok: 13 Kunci Warna dalam 6 Grup] - 2026-09-29

### Added
- **6 kunci warna baru** pada tabel `pengaturan_umum` (tanpa perubahan skema): `warna_judul`, `warna_teks_sekunder`, `warna_latar_halaman`, `warna_latar_section`, `warna_border`, `warna_footer`. Total kini **13 kunci warna** + `skema_tema`.
- **Pengelompokan warna di panel admin** menjadi 6 grup: A Warna Identitas, B Tipografi & Teks, C Latar & Permukaan, D Garis & Batas, E Tombol & Aksi, F Header, Navigasi & Footer.
- **Pratinjau langsung** (mock header, section + kartu, footer) yang terikat pada ke-13 variabel warna sebelum disimpan.
- **Legenda kelas global** untuk pengembang (`.theme-page-bg`, `.theme-card`, `.theme-heading`, `.theme-btn-ghost`, `.theme-header`, `.theme-footer`, `.theme-input`, dll.).
- **Test Pest `TenantThemeColorTest`** (5 skenario): injeksi 13 variabel ke 3 halaman publik, kelas tema pada kerangka halaman, isi `public.css`, isi panel admin (6 grup + 13 field), dan penyimpanan 13 warna via `PUT tenant.admin.pengaturan.update`.

### Changed
- **`resources/css/public.css`**: blok `:root` fallback kini memuat 13 variabel `--theme-*`; ditambah **Legacy Utility Mapping** (`.bg-white`, `.bg-slate-50/100/200`, `.border-slate-*`, `.text-slate-*` → variabel tema dengan `!important`, zona gelap dikecualikan agar teks tetap kontras); `footer` memakai `--theme-footer-bg`.
- **`layouts/public.blade.php`**: injeksi `:root` diperluas dari 7 menjadi 13 variabel; `<body>`, header, dan footer memakai kelas `.theme-page-bg`, `.theme-text-body`, `.theme-header`, `.theme-footer`.
- **`HomeController` & `PageController`**: `$sekolah` memuat seluruh 13 kunci warna + `skema_tema`.
- **`PengaturanController`**: validasi 13 kunci warna + `skema_tema` dengan pesan validasi Bahasa Indonesia.
- **`tenant/admin/pengaturan/index.blade.php`**: dibangun ulang (Alpine `x-data`, 7 preset, 6 kartu grup rincian warna, pratinjau langsung, legenda, tombol simpan).
- **Seeder `TenantSmkn2BandungSeeder`**: menulis 13 kunci warna + `skema_tema` ke `pengaturan_umum`.
- **Pest `TenantAdminTest`**: judul panel disesuaikan menjadi `Pengaturan Tema & Warna Portal Sekolah`.

### Verification
- `php artisan test`: **41 test / 243 assertions PASSED**.
- `npm run build`: sukses, aset `public/build/assets/public-CU8YmPSe.css` (14.58 kB) memuat seluruh kelas tema.
- Request HTTP nyata ke `/{tenant}` (port 8123) mengembalikan seluruh 13 variabel `--theme-*` sesuai palet uji `#BE123C` dan menautkan kedua stylesheet hasil build.

## [Penyederhanaan Panel Admin Sekolah: Hanya Menu Tema & Warna] - 2026-09-29

### Removed
- **Modul admin sekolah selain tema dihapus dari sistem** (sesuai permintaan, tanpa menyentuh database):
  - 16 controller di `app/Http/Controllers/Tenant/Admin/` (`DashboardController`, `SliderController`, `ProfilController`, `StrukturController`, `JurusanController`, `BeritaController`, `PengumumanController`, `AgendaController`, `GaleriController`, `PrestasiController`, `EkstrakurikulerController`, `GuruStafController`, `FasilitasController`, `SpmbController`, `KontakController`, `MediaController`).
  - 36 view pada folder `resources/views/tenant/admin/` (dashboard, slider, profil, struktur, jurusan, berita, pengumuman, agenda, galeri, prestasi, ekskul, guru, fasilitas, spmb, kontak, media).
  - Komponen `components/admin/input-gambar`, `input-waktu`, `quill-editor` dan aset CDN Quill di `layouts/tenant_admin.blade.php`.
  - `App\Services\ImageService` (hanya dipakai modul identitas/hero yang dihapus).
  - Seluruh rute modul admin lama pada grup `tenant.admin.*` kecuali `login`, `login.submit`, `logout`, `pengaturan.index`, dan `pengaturan.update`.
  - Tab Identitas & Logo, Statistik Beranda, dan Video Profil pada halaman pengaturan admin.

### Changed
- **Sidebar admin (`layouts/tenant_admin.blade.php`)** kini hanya memuat satu menu: **Tema & Warna** (route `tenant.admin.pengaturan.index`).
- **Login admin (`Tenant\Admin\AuthController`)** diarahkan langsung ke halaman pengaturan tema, termasuk saat admin yang sudah login membuka halaman login (rute GET login tidak lagi memakai middleware `guest:tenant_admin`).
- **Shortcut `/admin`** mengarah ke `/{tenant}/admin/pengaturan` bila sesi admin sekolah aktif.
- **`PengaturanController`** dipersempit menjadi pengelola `skema_tema` dan 7 kunci warna palet (`warna_tema`, `warna_aksen`, `warna_teks`, `warna_kartu`, `warna_tombol`, `warna_tombol_teks`, `warna_header`) dengan pesan validasi Bahasa Indonesia dan flash `Tema dan palet warna portal sekolah berhasil disimpan.`
- **Pest `TenantAdminTest`**: 9 skenario baru (login guest, proteksi auth, redirect otomatis ke pengaturan tema, isi sidebar, 404 seluruh rute lama, penyimpanan palet, dan integritas data tenant). Full suite **36 test / 135 assertions lulus**.

### Preserved
- **Database, migrasi, model Eloquent, dan seeder tidak diubah**: seluruh data konten sekolah (7 jurusan, 10 artikel, agenda, prestasi, ekskul, guru & staf, fasilitas, galeri, SPMB, pesan kontak, pengaturan umum) tetap tersimpan dan tetap tampil pada portal publik.

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
