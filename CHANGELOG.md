# Changelog

All notable changes to this project will be documented in this file.

## [Perbaikan Konversi Gambar Palette WebP & Tangkapan Notifikasi Toast Error Upload] - 2026-09-29

### Fixed
- **Konversi Palette / Indexed Image ke WebP ([MediaService.php](file:///d:/databaru/Magang/website_sekolah/app/Services/MediaService.php))**: Menambahkan konversi otomatis `imagepalettetotruecolor()` untuk mencegah error `imagewebp(): Palette image not supported by webp` pada berkas PNG 8-bit, GIF, dan gambar palet berindeks.
- **Tangkapan Notifikasi Error Toast ([tenant_admin.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/tenant_admin.blade.php))**: Memastikan notifikasi toast merah muncul saat ada error validasi atau eksepsi unggah.

## [Perbaikan Navigasi Halaman Error & Konfigurasi Batas Unggah Media 64MB] - 2026-09-29

### Fixed
- **Halaman Error 500 & 404 ([500.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/errors/500.blade.php), [404.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/errors/404.blade.php))**: Tombol navigasi cerdas kembali ke halaman sebelumnya (`window.history.back()`) dengan fallback ke beranda tenant dan penghapusan tombol Super Admin.
- **Konfigurasi Batas Unggah Media**: Menaikkan limit `upload_max_filesize` dan `post_max_size` PHP menjadi `64MB` serta menghapus alert blocking pada antarmuka.



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
- Penyesuaian nama tab pertama di admin menjadi **"1. Profil Lengkap"**.
- Pengaturan lengkap Hero Banner Profil: **Judul Utama**, **Subjudul**, **Pola Dekorasi Latar**, dan **Gambar Latar Hero** dari Pusat Media.
- Implementasi Hero Banner Split dengan efek **Gradual Fade Mask** di sisi kanan dan *drop-shadow* teks otomatis agar konten selalu terbaca tajam dan tidak bertabrakan dengan gambar latar.

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
- **Rule operasional `.ai/rules/publik-tema-kontras.md`** beserta indeks `.ai/rules/index.md`: aturan blocking untuk `resources/css/public.css`, `resources/views/layouts/public.blade.php`, `resources/views/public/**`, `app/Http/Controllers/Tenant/Public/**`, `routes/web.php` grup `{tenant}`, `app/Support/WarnaKontras.php`, dan pratinjau tema admin. Isinya: kontrak dua lapis auto-kontras, daftar kelas `.theme-*` yang wajib dipakai, daftar larangan warna literal, SOP tambah menu navigasi (tabel `menu` + perilaku filter nama `spmb`/`Profil`/`Program Keahlian` di layout), SOP tambah halaman publik (route -> controller `getSekolahData()` -> view -> test), template 8 baris untuk mendaftarkan scope kontras baru, SOP 6 titik sinkronisasi kunci warna baru, tabel anti-pattern, dan perintah verifikasi wajib.
- **Referensi teknis `docs/08-CSS-ARSITEKTUR-TEMA.md`**: diagram alur warna `pengaturan_umum` -> controller -> `public.blade.php` -> `public.css` -> piksel, tabel API `WarnaKontras`, 13 kunci panel + 16 kunci `--theme-fg-*` lengkap dengan latar acuan dan ambang, registri 8 scope auto-kontras beserta selector dan perilakunya, inventaris kelas tampilan, resep cepat per jenis tugas, catatan fallback browser tanpa `@property`/`contrast()`, dan cara memeriksa compiled CSS.

### Changed
- `docs/RULES.md`: bagian 8 "Standar Tema & Auto-Kontras CSS (Portal Publik)" berisi 8 poin mengikat plus tautan ke rule dan dokumen teknis.
- `docs/05-UI-UX.md`: bagian Auto-Kontras WCAG menautkan rule dan dokumen teknis sebagai acuan penulisan kode baru.
- `docs/07-IMPLEMENTATION-CHECKLIST.md`: Tahap 11 (Penegakan Aturan Tema & Auto-Kontras) ditambahkan dan dicentang.

### Notes
- Dokumen/rule saja, tidak ada perubahan kode runtime, migrasi, maupun perilaku tampilan. Test suite tidak terdampak.


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
- `php artisan test tests/Feature/TenantPublicPagesTest.php`: **17 test / 60 assertions PASSED**.

## [Kelompok Warna Lengkap: Semua Keluarga Ikut Panel Tema Tanpa Pengecualian] - 2026-09-29

### Added
- **133 variabel palet baru di `:root` `resources/css/public.css`** (total 199): `purple`/`violet`/`fuchsia`/`pink` → identitas, `green`/`emerald`/`lime`/`teal`/`cyan`/`yellow`/`red`/`rose` → aksen, `gray`/`zinc`/`stone`/`neutral` → netral, `--color-white` → `--theme-identity-50`, serta aturan arbitrary WhatsApp `bg-[#25D366]`/`hover:bg-[#20ba5a]` → aksen.

### Changed
- **Sapu bersih sisa putih (tindak lanjut laporan "masih ada putih"):** 37 dasar campuran `color-mix(..., white)` di `public.css` → `var(--theme-page-bg)`, `--color-white` → `var(--theme-btn-text)`, titik radial hero → `--theme-accent-400`, dan pratinjau panel admin memakai Alpine `btnText`/`pageBg` (bebas `rgba(255,255,255)`).
- **Seluruh literal putih hardcoded diganti kunci panel `warna_tombol_teks`** (aturan header/footer, breadcrumb `text-blue-100/200`, amber di dark card/section, `group-hover:text-sky-300`, dan aturan zona gelap) sehingga tidak ada lagi warna yang mengabaikan panel Tema & Warna; preset default `#FFFFFF` menghasilkan tampilan identik dengan sebelumnya.
- **Pengecualian semantik dihapus:** `emerald`/`rose`/`red`/WhatsApp kini ikut grup aksen; overlay `bg-black/xx` tetap hitam karena berfungsi sebagai latar redup.

### Verification
- `php artisan test`: **42 test / 278 assertions PASSED**; `vendor/bin/pint --dirty` bersih; `npm run build` sukses (`public-CCKXuORS.css`, 28,54 kB); request HTTP port 8123 & 8000 menautkan stylesheet hash baru tersebut.

## [Penutupan Celah Pemetaan Warna: Override Palet Tailwind v4] - 2026-09-29

### Added
- **Skala turunan `--theme-identity-50..950`, `--theme-accent-50..950`, `--theme-neutral-50..950`** di `resources/css/public.css` (via `color-mix()` dari 13 kunci tema).
- **Override 66 variabel palet Tailwind v4** di `:root`: blue & indigo → identitas, sky, amber, orange → aksen, slate → netral, sehingga kelas yang lolos dari pemetaan sebelumnya ikut mengikuti tema - termasuk varian `hover:`/`focus:`, opacity `/xx`, gradien `from-via-to`, `ring-*`, `placeholder-slate-400`, dan `text-slate-200/300` pada breadcrumb hero gelap.
- **Override pola radial hardcoded `#38bdf8`** (±17 halaman hero) → aksen; `border-slate-*/80|60` → `--theme-border`.
- **Test Pest ke-6** pada `TenantThemeColorTest` untuk guardrail pemetaan palet.

### Changed
- **`resources/css/public.css`**: deklarasi `:root` tanpa layer menang atas `@layer theme` Tailwind v4; aturan kontekstual lama tetap menang berkat spesifisitas + `!important`.
- **Warna semantik dikecualikan:** `emerald` (sukses/Aktif), `rose`/`red` (error form), dan merek WhatsApp `bg-[#25D366]` tidak ikut tema.

### Verification
- `php artisan test`: **42 test / 254 assertions PASSED**; `vendor/bin/pint --dirty` bersih; `npm run build` sukses (`public-DCqQ4nZP.css`, 20.03 kB); request HTTP nyata menautkan stylesheet hash baru tersebut.

## [Sistem Warna Global Terkelompok: 13 Kunci Warna dalam 6 Grup] - 2026-09-29

### Added
- **6 kunci warna baru** di tabel `pengaturan_umum` (skema tidak berubah): `warna_judul`, `warna_teks_sekunder`, `warna_latar_halaman`, `warna_latar_section`, `warna_border`, `warna_footer` - total **13 kunci warna** + `skema_tema`.
- **6 grup pengaturan warna** di panel admin: Warna Identitas, Tipografi & Teks, Latar & Permukaan, Garis & Batas, Tombol & Aksi, Header Navigasi & Footer, masing-masing dengan color picker + input hex tersinkronisasi.
- **Pratinjau langsung** mock header, section + kartu, dan footer yang terikat pada ke-13 variabel warna; **legenda kelas global** untuk pengembang.
- **Test Pest `TenantThemeColorTest`** (5 skenario) untuk injeksi variabel, kelas tema, isi `public.css`, isi panel, dan penyimpanan 13 warna.

### Changed
- **`resources/css/public.css`**: fallback `:root` memuat 13 variabel `--theme-*`, menambah **Legacy Utility Mapping** (utilitas `bg-white`, `bg-slate-*`, `border-slate-*`, `text-slate-*` → variabel tema dengan `!important`, zona gelap dikecualikan), dan `footer` memakai `--theme-footer-bg`.
- **`layouts/public.blade.php`**: injeksi `:root` diperluas menjadi 13 variabel; `<body>`, header, footer memakai kelas tema.
- **`HomeController` & `PageController`**: `$sekolah` memuat 13 kunci warna + `skema_tema`.
- **`PengaturanController`**: validasi 13 kunci warna + `skema_tema`.
- **`tenant/admin/pengaturan/index.blade.php`**: dibangun ulang dengan 6 grup warna, pratinjau langsung, dan legenda kelas global.
- **Seeder `TenantSmkn2BandungSeeder`**: 13 kunci warna + `skema_tema` ditulis ke `pengaturan_umum`.
- **Pest `TenantAdminTest`**: judul panel kini `Pengaturan Tema & Warna Portal Sekolah`.

### Verification
- `php artisan test`: **41 test / 243 assertions PASSED**; `npm run build` sukses; request HTTP nyata memastikan 13 variabel `--theme-*` tersuntik sesuai palet uji `#BE123C`.

## [Penyederhanaan Panel Admin Sekolah: Hanya Menu Tema & Warna] - 2026-09-29

### Removed
- **16 controller modul admin sekolah** di `app/Http/Controllers/Tenant/Admin/`: `DashboardController`, `SliderController`, `ProfilController`, `StrukturController`, `JurusanController`, `BeritaController`, `PengumumanController`, `AgendaController`, `GaleriController`, `PrestasiController`, `EkstrakurikulerController`, `GuruStafController`, `FasilitasController`, `SpmbController`, `KontakController`, dan `MediaController`.
- **36 view modul admin sekolah** pada folder `resources/views/tenant/admin/` (`dashboard`, `slider`, `profil`, `struktur`, `jurusan`, `berita`, `pengumuman`, `agenda`, `galeri`, `prestasi`, `ekskul`, `guru`, `fasilitas`, `spmb`, `kontak`, `media`).
- **Komponen admin tidak terpakai**: `resources/views/components/admin/input-gambar.blade.php`, `input-waktu.blade.php`, `quill-editor.blade.php`, serta aset CDN Quill di `layouts/tenant_admin.blade.php`.
- **`App\Services\ImageService`** karena hanya dipakai modul identitas/upload hero yang sudah dihapus.
- **Rute modul admin lama**: `tenant.admin.dashboard`, `slider`, `profil`, `struktur`, `jurusan`, `berita`, `pengumuman`, `agenda`, `galeri`, `prestasi`, `ekskul`, `guru`, `fasilitas`, `spmb`, `kontak`, `media`.
- **Tab non-tema** pada halaman pengaturan admin: Identitas & Logo, Statistik Beranda, dan Video Profil Sekolah.

### Changed
- **Sidebar admin sekolah (`resources/views/layouts/tenant_admin.blade.php`)**: seluruh item menu dihapus dan disisakan satu menu `Tema & Warna`; logo serta nama sekolah pada header sidebar kini menaut ke halaman pengaturan tema.
- **Login admin sekolah (`App\Http\Controllers\Tenant\Admin\AuthController`)**: admin diarahkan langsung ke `/{tenant}/admin/pengaturan` setelah login dan saat membuka halaman login dalam kondisi sudah terautentikasi. Rute `GET /{tenant}/admin/login` tidak lagi memakai middleware `guest:tenant_admin` agar tidak terlempar ke halaman publik.
- **Shortcut `/admin`** mengarah ke `/{tenant}/admin/pengaturan` saat sesi admin sekolah aktif.
- **`PengaturanController` dipersempit**: hanya menangani `skema_tema` beserta 7 kunci warna (`warna_tema`, `warna_aksen`, `warna_teks`, `warna_kartu`, `warna_tombol`, `warna_tombol_teks`, `warna_header`) dengan pesan validasi berbahasa Indonesia. Halaman `resources/views/tenant/admin/pengaturan/index.blade.php` kini hanya memuat panel Tema & Warna (7 preset, color picker, live preview) tanpa navigasi tab.
- **Pest `TenantAdminTest` disesuaikan**: 9 skenario pengujian (login guest, proteksi auth, redirect ke pengaturan tema, isi sidebar, 404 seluruh rute lama, penyimpanan palet, integritas data tenant) dengan total suite 36 test lulus.

### Notes
- **Database, migrasi, model, dan seeder tetap utuh.** Seluruh tabel tenant (`jurusan`, `artikel`, `agenda`, `prestasi_siswa`, `ekstrakurikuler`, `guru_staf`, `fasilitas`, `galeri_album`, `galeri_item`, `slider_beranda`, `pesan_masuk`, `pengaturan_ppdb`, `pengaturan_umum`, `pengaturan_fitur`, dll.) beserta datanya tidak diubah dan tetap dipakai seluruh halaman portal publik.

## [Unreleased]

### Fixed
- **Penerapan Tema Warna ke Seluruh Halaman Publik (Full Theme Coverage)**:
  - Menambahkan CSS override komprehensif di `resources/views/layouts/public.blade.php` untuk semua kelas warna hardcoded yang belum tertangkap tema: `amber-*`, `indigo-*`, `orange-*`, `bg-blue-950/*`, `section.bg-slate-900`.
  - Mengganti overlay hero carousel `bg-blue-950/85` di `home.blade.php` dengan inline style `color-mix(in srgb, var(--theme-color) 85%, black)`.
  - Mengganti dots indikator carousel dari `:class="'bg-blue-500'"` ke `:style="'background-color: var(--theme-accent)'"`.
  - Mengganti tombol amber `bg-amber-400` di `jurusan_detail.blade.php` dengan class `theme-btn-primary`.
  - Mengganti filter pills `bg-slate-900` di `agenda.blade.php` dengan class `theme-btn-primary` + inline style CSS var.
  - Menambahkan override untuk teks amber di dalam card dark (`bg-blue-900`) agar tetap terbaca sebagai putih.
  - Semua 26+ halaman publik kini mengikuti tema warna yang dipilih admin (termasuk amber badge, indigo pill, orange accent).

### Added

- **Pengaturan Tema & Warna Mandiri (7 Preset + Custom Hex + Live Preview)**:
  - Tab navigasi admin **"Tema & Warna"** di `tenant/admin/pengaturan/index.blade.php`.
  - 7 Pilihan Preset Terverifikasi: *Biru Navy Klasik*, *Hijau Zamrud Edukasi*, *Merah Marun Prestisius*, *Ungu Dinamis Kreatif*, *Abu Gelap Elegan*, *Emas Oranye Enerjik*, dan *Teal Bahari Futuristik*.
  - Opsi *Custom Warna* dengan kontrol hex dan color picker untuk warna teks konten, kartu, tombol, teks tombol, bar header, dan aksen.
  - Simulasi *Live Preview* interaktif di panel admin yang langsung berubah sesuai warna yang dipilih.
  - Penyimpanan permanen ke database tenant (`pengaturan_umum`) melalui `PengaturanController.php`.
  - Refactoring CSS variabel `:root` dan utility classes (`theme-btn-primary`, `theme-card`, `theme-header`) di `resources/views/layouts/public.blade.php` dan `home.blade.php`.
- **Penyelarasan Rules & Alur Kerja Workspace (Streamlined Execution)**:
  - Menghilangkan beban birokrasi checklist audit dan analisis dampak teoritis dari [AGENTS.md](file:///d:/databaru/Magang/website_sekolah/AGENTS.md) dan [docs/RULES.md](file:///d:/databaru/Magang/website_sekolah/docs/RULES.md).
  - Menetapkan alur kerja ringkas dan terikat: **Wajib membaca dokumen .md di awal**, **eksekusi langsung tanpa bertele-tele**, **database wajib 100% berelasi (FK & model)**, dan **wajib sinkronisasi dokumen .md di akhir**.
- **Dukungan Media Video pada Menu Admin Slider Banner Hero & Pemutaran Dinamis Beranda**:
  - Menambahkan kolom `video` (string 500, nullable) pada tabel `slider_beranda` melalui migrasi `2026_09_28_131117_add_video_to_slider_beranda_table.php`.
  - Menambahkan field upload file video (MP4/WebM maks 50MB) dan input URL CDN video pada formulir admin `resources/views/tenant/admin/slider/create.blade.php` & `edit.blade.php`.
  - Memperbarui `SliderController.php` untuk memvalidasi dan memproses penyimpanan berkas video ke `storage/uploads/video/`.
  - Menampilkan badge indikator tipe media `Video` pada daftar tabel dan kartu grid `resources/views/tenant/admin/slider/index.blade.php`.
  - Memperbarui carousel beranda (`resources/views/public/home.blade.php`) agar memutar video otomatis (`autoplay`, `muted`, `playsinline`), melanjutkan ke slide berikutnya setelah video selesai (`@ended="next()"`), atau memutar berulang (`loop`) jika hanya ada 1 item slider.
- **Banner Hero Beranda Dinamis (Video Looping & Sequential Slideshow)**:
  - Mengimplementasikan pemutar media cerdas berbasis Alpine.js pada `resources/views/public/home.blade.php`:
    - **Jika hanya gambar**: Menampilkan slideshow/tampilan banner foto beranda.
    - **Jika hanya video**: Menjalankan video berulang tanpa henti (`loop`).
    - **Jika ada keduanya**: Menjalankan video terlebih dahulu sampai selesai (`@ended`), kemudian bertransisi mulus ke tampilan banner gambar sekolah.
    - Dilengkapi kontrol interaktif: Toggle audio (Mute/Unmute), tombol "Putar Ulang Video", dan tombol "Lihat Gambar".
  - Menambahkan dukungan input dan upload video/gambar untuk `hero_banner` dan `hero_banner_video` pada formulir admin `resources/views/tenant/admin/pengaturan/index.blade.php`.
  - Memperbarui `PengaturanController.php` dan `HomeController.php` untuk menyimpan serta mengalirkan variabel `hero_banner_video` dan `hero_banner` secara dinamis.
- **Relasi Database Lengkap & ERD Seluruh Tabel (100% Berelasi)**:
  - Membuat dan menjalankan migrasi foreign key untuk seluruh 20 tabel database tenant (`jurusan`, `guru_staf`, `ekstrakurikuler`, `prestasi_siswa`, `agenda`, `unduhan`, `struktur_organisasi`, `slider_beranda`, `halaman_statis`, `kalender_akademik`, `pesan_masuk`, `pengaturan_ppdb`, `pengaturan_umum`, `pengaturan_fitur`, dll).
  - Menghubungkan seluruh model Eloquent dua arah (`belongsTo` & `hasMany`) di `App\Models\Tenant`.
  - Memperbarui diagram ERD visual Mermaid lengkap dan tabel relasi constraint di `docs/03-DATABASE.md`.
- **Penghapusan Counter Dapodik & Integrasi Logo Resmi Sekolah**:
  - Menghapus total section counter Dapodik ("SMK Negeri 2 Bandung dalam Angka") dari `home.blade.php`.
  - Mengganti ikon huruf "S" pada Sidebar Admin (`layouts/tenant_admin.blade.php`) dan ikon SVG toga pada Header & Footer Publik (`layouts/public.blade.php`) dengan gambar logo sekolah resmi (`public/images/logo-smkn2.svg`).
  - Memperbaiki sinkronisasi input form logo di `input-gambar.blade.php` dan `PengaturanController.php` agar logo tersimpan aman tanpa tertimpa string kosong.
- **Perombakan Estetika Beranda (Anti-AI Slop)**:
  - Mengganti font heading menjadi `Plus Jakarta Sans` dan body menjadi `Inter` untuk menghilangkan kesan template AI SaaS yang ramai.
  - Merombak warna tombol dan kartu di seluruh beranda menjadi warna institusional terukur (Navy, Slate, dan Neutral) tanpa drop shadow mengambang yang berlebihan.
  - Menghapus section galeri foto dari halaman beranda sesuai instruksi pengguna.
- **Base Tailwind Public Design System**:
  - Implemented sleek modern public aesthetics referencing Base Tailwind across public interfaces (`layouts/public.blade.php`, `home.blade.php`, `kalender.blade.php`, `agenda.blade.php`, and subpages).
  - Modern sticky header with translucent backdrop-blur, subtle borders, high contrast active indicators, and dynamic CTA button.
  - Interactive 3-column Agenda & Calendar page (`public/pages/agenda.blade.php`) matching the requested reference:
    - Left column: interactive Alpine.js calendar navigator (month/year picker, date selection with active events dots indicator, quick category filter pills, academic calendar banner).
    - Right column: featured events hero cards and horizontal event cards with thumbnail cover, date badges, real-time client-side search, and status tags.
  - Redesigned `kalender.blade.php` academic calendar page with PDF/image viewer cards and modern timeline lists.
  - Passing `allAgenda` and `featuredAgenda` in `PageController@agenda` to support calendar interactivity.
- Added slug field generation in `TenantController@store` when registering a new tenant.
- Added `slug` property for `Sekolah` tests.
- Implemented modern UI/UX grid card layout on the public `jurusan` page.
- Added Alpine.js lightbox component and micro-interactions on the public `galeri` page.
- Added hover transform and shadow animations to article cards on the public `berita` page.
- Added seeding for `pengguna` (admin and operator accounts) in `TenantSmkn2BandungSeeder`.
- Configured single-tenant setup for SMK Negeri 2 Bandung across Central, Tenant Admin, and Public interfaces.

### Database & Migrations
- Initialized central database `website_sekolah_central` with Super Admin and SMK Negeri 2 Bandung.
- Initialized tenant database `tenant_smk_negeri_2_bandung` with complete schema (20 tables) and official school data.

### Fixed
- Fixed a SQL error in `SuperAdminAuthTest` causing tests to fail when trying to insert records without a default `slug`.
- Fixed `TenantController@store` failing when creating tenants without passing a generated slug.

### Changed
- **Skema Warna Header, Footer, & Navigasi ke Biru Institusional**:
  - Mengganti warna latar belakang header top bar (`bg-slate-900` -> `theme-bg` / biru tua).
  - Mengganti warna teks dan ikon pada header dari abu-abu ke biru muda (`text-blue-100`, `text-blue-200`).
  - Mengganti warna navigasi aktif pada menu desktop dan mobile drawer dari `bg-slate-900` ke `bg-blue-900`.
  - Mengganti warna hover link navigasi dari `text-blue-400` ke `text-blue-300` untuk konsistensi.
  - Mengganti warna footer dari `bg-slate-900` ke `theme-bg` (biru tua).
  - Mengganti warna teks footer dari `text-slate-300/400` ke `text-blue-100/200/300`.
  - Mengganti warna ikon sosial media footer dari `bg-slate-800` ke `bg-blue-800`.
  - Mengubah warna akreditasi di header dan footer dari `text-emerald-400` ke `text-white` sesuai permintaan.
  - Memperluas lebar container dari 1200px ke 1440px untuk tampilan lebih lebar di desktop.
  - Membuat hero banner beranda full-width (edge-to-edge) dengan menghilangkan container constraint, border radius, shadow, dan border.
  - Meningkatkan tinggi hero banner dari `h-44/64/80` ke `h-64/96/[450px]`.
  - Mengganti warna overlay gradient dan semi Transparan pada hero banner carousel dengan palet biru yang konsisten.

### Removed
- Removed obsolete `ExampleTest.php` that was testing the root `/` endpoint which was removed/changed due to multi-tenancy URL structure.
