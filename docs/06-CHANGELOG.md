# Changelog — Website Sekolah

Format mengacu pada [Keep a Changelog](https://keepachangelog.com/).

## [Penyeragaman Rasio & Ukuran Grid Foto Galeri & Fasilitas 100% Identik Manajemen Media] - 2026-10-05

### Changed
- **Standardisasi Grid 6-Kolom (`grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4`) & Kartu Compact Persegi 1:1**:
  - [resources/views/tenant/admin/informasi/galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/galeri.blade.php): Menyeragamkan grid album dan grid item media dokumentasi menjadi layout 6-kolom dengan kartu compact `aspect-square`, hover overlay action button, dan ambient blur backdrop identik dengan Manajemen Media.
  - [resources/views/tenant/admin/informasi/fasilitas.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/fasilitas.blade.php): Menyeragamkan grid sarpras fasilitas menjadi layout 6-kolom dengan kartu compact `aspect-square`, hover overlay action button, dan ambient blur backdrop identik dengan Manajemen Media.
  - [resources/views/tenant/admin/informasi/agenda.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/agenda.blade.php): Memindahkan inisialisasi route ke objek config `routes` pada Alpine.js.

## [Perbaikan Blade Syntax & Pembersihan Directives JS / CSS Linter] - 2026-10-05

### Fixed
- **Pembersihan Blade Directives di Alpine.js Script ([resources/views/tenant/admin/jurusan/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/index.blade.php))**:
  - Memindahkan inisialisasi `@js(...)` ke atribut HTML `x-data` config dan mengonsumsi `config.totalJurusan`, `config.nextUrutan`, serta `config.routes` langsung dari dalam script Alpine untuk mencegah error parser JS.
- **Standarisasi Directive `@style` pada Elemen Gambar dengan Smart Crop & Hero Banner**:
  - Mengganti atribut inline `style="{{ ... }}"` dengan Blade directive `@style(...)` pada [resources/views/public/pages/berita.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/berita.blade.php), [resources/views/public/pages/galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/galeri.blade.php), [resources/views/public/pages/jurusan.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/jurusan.blade.php), [resources/views/public/home.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/home.blade.php), [resources/views/public/pages/guru.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/guru.blade.php), [resources/views/public/pages/pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/pengumuman.blade.php), [resources/views/public/pages/jurusan_detail.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/jurusan_detail.blade.php), dan [resources/views/tenant/admin/jurusan/tabs/tab-jurusan.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/tabs/tab-jurusan.blade.php).

## [Standarisasi Penuh CSS & Modal Manajemen Media serta Media Picker (Anti-Slop Vibecoding)] - 2026-10-05

### Changed
- **Standardisasi Modul Manajemen Media & Modal Picker Terpusat**:
  - [resources/views/tenant/admin/media/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/media/index.blade.php): Mengintegrasikan seluruh komponen tabel, sticky bar, modal upload, modal impor URL, modal rename informasi berkas, modal crop framing live, dan modal dialog konfirmasi hapus menggunakan class semantik terpusat (`.admin-sticky-bar`, `.admin-modal-overlay`, `.admin-modal-card`, `.admin-form-label`, `.admin-form-input`, `.admin-btn-save`, `.admin-btn-cancel`, `.admin-badge-*`).
  - [resources/views/tenant/admin/media/picker-modal.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/media/picker-modal.blade.php): Menstandarisasikan dialog pemilih pustaka media (`.admin-modal-overlay`, `.admin-modal-card`, `.admin-btn-save`, `.admin-btn-cancel`, `.admin-form-input`) agar 100% serasi dengan modul pengaturan lainnya.

## [Penyeragaman Rasio Foto & Video Galeri serta Sarana Prasarana] - 2026-10-05

### Changed
- **Standardisasi Rasio Aspek Foto & Media (4:3 Landscape)**:
  - [resources/views/public/pages/galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/galeri.blade.php): Menyeragamkan rasio kartu foto & video dokumentasi ke rasio `aspect-4/3` sehingga sejajar dan serasi dengan tampilan katalog sarana & fasilitas (`fasilitas.blade.php`).
  - [resources/views/tenant/admin/informasi/galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/galeri.blade.php): Menyeragamkan cover album ke rasio `aspect-4/3` yang identik dengan kartu fasilitas admin.

## [Penyatuan CSS & Standarisasi Sticky Bar Modul Pusat Manajemen Media (Anti-Slop Vibecoding)] - 2026-10-05

### Changed
- **Refactoring Modul Manajemen Media ([resources/views/tenant/admin/media/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/media/index.blade.php))**:
  - Menerapkan `.admin-sticky-bar`, `.admin-sticky-container`, `.admin-btn-save` (Unggah Berkas), dan `.admin-btn-cancel` (Impor URL/YT) pada header atas.
  - Memastikan keselarasan token warna dan class semantik terpadu dari `resources/css/admin-panel.css`.

## [Penyatuan CSS & Standarisasi Sticky Bar Modul Tema & Warna Sekolah (Anti-Slop Vibecoding)] - 2026-10-05

### Changed
- **Refactoring Modul Tema & Warna ([resources/views/tenant/admin/pengaturan/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/pengaturan/index.blade.php))**:
  - Menerapkan `.admin-sticky-bar`, `.admin-sticky-container`, dan `.admin-btn-save` di bar navigasi atas.
  - Menghapus tombol simpan duplikat di bagian bawah form.
  - Memanfaatkan class semantik `.admin-card`, `.admin-card-header`, `.admin-card-title`, `.admin-card-subtitle` dari `resources/css/admin-panel.css`.

## [Penyatuan CSS & Standarisasi Class Semantik Seluruh Modul Informasi Sekolah (Anti-Slop Vibecoding)] - 2026-10-05

### Changed
- **Refactoring Modul Informasi Sekolah ([resources/views/tenant/admin/informasi/](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/))**:
  - Menghapus CSS inline Quill.js lokal di modul Berita, Pengumuman, dan Agenda untuk memanfaatkan stylesheet Quill global dari `resources/css/admin-panel.css`.
  - [pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/pengumuman.blade.php): Menggunakan `.admin-sticky-bar`, `.admin-sticky-container`, `.admin-tab-nav`, `.admin-tab-pill-*`, `.admin-btn-save`, `.admin-btn-create`, `.admin-btn-cancel`.
  - [berita.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/berita.blade.php): Menggunakan `.admin-sticky-bar`, `.admin-sticky-container`, `.admin-tab-nav`, `.admin-tab-pill-*`, `.admin-btn-save`, `.admin-btn-create`, `.admin-btn-cancel`.
  - [agenda.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/agenda.blade.php): Menggunakan `.admin-sticky-bar`, `.admin-sticky-container`, `.admin-tab-nav`, `.admin-tab-pill-*`, `.admin-btn-save`, `.admin-btn-create`, `.admin-btn-cancel`.
  - [galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/galeri.blade.php): Menggunakan `.admin-sticky-bar`, `.admin-sticky-container`, `.admin-tab-nav`, `.admin-tab-pill-*`, `.admin-btn-save`, `.admin-btn-create`, `.admin-btn-cancel`.
  - [fasilitas.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/fasilitas.blade.php): Menggunakan `.admin-sticky-bar`, `.admin-sticky-container`, `.admin-tab-nav`, `.admin-tab-pill-*`, `.admin-btn-save`, `.admin-btn-create`, `.admin-btn-cancel`.

## [Penyatuan CSS & Standarisasi Class Semantik Modul Program Keahlian / Jurusan (Anti-Slop Vibecoding)] - 2026-10-05

### Changed
- **Refactoring Modul Program Keahlian ([resources/views/tenant/admin/jurusan/](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/))**:
  - Menghapus CSS inline Quill.js lokal dan menggunakan konfigurasi Quill global dari `resources/css/admin-panel.css`.
  - [index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/index.blade.php): Menggunakan `.admin-sticky-bar`, `.admin-sticky-container`, `.admin-tab-nav`, `.admin-tab-pill-*`, `.admin-btn-save`, `.admin-btn-create`, dan `.admin-btn-cancel`.
  - [tabs/tab-jurusan.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/tabs/tab-jurusan.blade.php): Menggunakan `.admin-card`, `.admin-card-header`, `.admin-table`, `.admin-badge-*`, dan `.admin-btn-action`.
  - [tabs/tab-form-jurusan.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/tabs/tab-form-jurusan.blade.php): Menggunakan `.admin-card`, `.admin-card-header`, `.admin-card-title`, `.admin-card-subtitle`, `.admin-form-label`, `.admin-form-input`, `.admin-form-helper`, dan `.admin-btn-save`.
  - [tabs/tab-hero.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/tabs/tab-hero.blade.php): Menggunakan `.admin-card`, `.admin-form-label`, `.admin-form-input`, `.admin-btn-action`.
  - [tabs/tab-visibilitas.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/tabs/tab-visibilitas.blade.php): Menggunakan `.admin-card`, `.admin-table`, `.admin-badge-*`.
  - [tabs/modals.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/tabs/modals.blade.php): Menggunakan `.admin-modal-overlay`, `.admin-modal-card`, `.admin-btn-cancel`.

## [Standardisasi Sticky Tab Bar & Top Save Button di Seluruh Pengaturan Admin] - 2026-10-05

### Changed
- **Standardisasi Sticky Tab Bar & Top Save Action di Semua Modul Pengaturan Admin**:
  - Menerapkan bar navigasi tab **`sticky top-16 z-30`** dengan efek `backdrop-blur-md` dan background kontras di seluruh modul pengaturan admin sekolah:
    1. **Profil Sekolah** ([resources/views/tenant/admin/profil/](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/))
    2. **Program Keahlian / Jurusan** ([resources/views/tenant/admin/jurusan/](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/))
    3. **Struktur & GTK** ([resources/views/tenant/admin/gtk/](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/gtk/))
    4. **Pengumuman Resmi** ([resources/views/tenant/admin/informasi/pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/pengumuman.blade.php))
    5. **Berita & Artikel** ([resources/views/tenant/admin/informasi/berita.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/berita.blade.php))
    6. **Agenda & Kegiatan** ([resources/views/tenant/admin/informasi/agenda.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/agenda.blade.php))
    7. **Galeri & Dokumentasi** ([resources/views/tenant/admin/informasi/galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/galeri.blade.php))
    8. **Sarana & Fasilitas** ([resources/views/tenant/admin/informasi/fasilitas.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/fasilitas.blade.php))
  - **Tombol Simpan / Aksi Utama di Sebelah Kanan Atas Bar Tab**: Tombol aksi dinamis berubah sesuai tab yang sedang aktif (misal: tombol *Simpan Hero*, tombol *Terbitkan / Perbarui*, tombol *[+] Buat Baru*, tombol *Batal*).
  - **Pembersihan Tombol Bawah**: Menghapus seluruh tombol simpan/submit di bagian bawah form agar tampilan tidak redundant (hanya ada 1 tombol simpan yang selalu terlihat di atas saat scroll).
  - **Alpine.js Dynamic Submitter**: Mengintegrasikan method `submitActiveForm(formId)` yang menangani validasi native HTML5 form (`reportValidity()`), sinkronisasi konten Quill.js WYSIWYG, dan indikator loading state.

## [Penyederhanaan Format Pengumuman Resmi (Admin & Publik)] - 2026-10-05

### Changed
- **Penyederhanaan Form Admin Pengumuman ([resources/views/tenant/admin/informasi/pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/pengumuman.blade.php))**:
  - Menyederhanakan formulir input pengumuman agar fokus pada 3 elemen esensial: **Judul Pengumuman**, **Gambar/Foto Surat Resmi**, dan **Isi Pengumuman** (WYSIWYG), ditambah status publikasi & tanggal.
  - Menghilangkan field ringkasan manual yang redundan agar admin sekolah tidak perlu bekerja dua kali.
- **Penyederhanaan Tampilan Publik Pengumuman ([resources/views/public/pages/pengumuman_detail.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/pengumuman_detail.blade.php) & [pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/pengumuman.blade.php))**:
  - Menghapus mockup kop surat dan tanda tangan tiruan pada detail pengumuman publik.
  - Tampilan publik kini menyajikan artikel pengumuman bersih dan elegan: Judul, Lampiran Gambar Dokumen Surat Resmi (jika ada), dan Isi Teks Pengumuman.
  - Listing pengumuman menampilkan thumbnail gambar surat resmi secara proporsional dan rapi.

## [Pemisahan Modul Mandiri Struktur & GTK di Sidebar Admin] - 2026-10-05

### Added
- **Modul Mandiri Struktur Organisasi & Guru Tenaga Kependidikan (GTK) ([app/Http/Controllers/Tenant/Admin/GtkController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/GtkController.php))**:
  - Menyediakan menu sidebar mandiri **Struktur & GTK** (`/{tenant}/admin/gtk`) dengan 2 sub-tab navigasi terpadu:
    1. **Struktur Organisasi**: Kustomisasi judul & banner hero publik, bagan diagram visual struktur hierarki organisasi, serta CRUD data pejabat struktural berelasi ke Guru & Staf.
    2. **Guru & Tenaga Kependidikan**: Kustomisasi hero banner publik `/guru-staf` dan manajemen data master pendidik dan tenaga kependidikan (PTK).
  - Tampilan admin Blade terpisah di [resources/views/tenant/admin/gtk/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/gtk/index.blade.php) beserta sub-komponen `tab-struktur.blade.php`, `tab-guru.blade.php`, dan `modals.blade.php`.
  - Feature test otomatis di [tests/Feature/TenantAdminGtkTest.php](file:///d:/databaru/Magang/website_sekolah/tests/Feature/TenantAdminGtkTest.php) (5 skenario pengujian - 100% Passed).

### Changed
- **Penyederhanaan Halaman Profil Sekolah ([resources/views/tenant/admin/profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**:
  - Mengeluarkan tab *5. Struktur Organisasi* dan *6. Guru & Tenaga Kependidikan* dari halaman Profil Sekolah.
  - Halaman Profil Sekolah kini memiliki 5 tab fokus: 1. Data Diri Sekolah, 2. Profil Lengkap, 3. Sejarah Sekolah, 4. Visi, Misi & Tujuan, 5. Visibilitas Menu & Rute.
- **Navigasi Sidebar Admin ([resources/views/layouts/tenant_admin.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/tenant_admin.blade.php))**:
  - Menambahkan link navigasi sidebar **Struktur & GTK** dengan icon hierarki organisasi yang elegan di bawah Profil Sekolah.

## [Reposisi Pengaturan Hero Banner di Seluruh Modul Informasi Sekolah] - 2026-10-05

### Changed
- **Penyatuan Pengaturan Hero Banner ke Tab Utama Daftar Modul Informasi ([berita.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/berita.blade.php), [pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/pengumuman.blade.php), [agenda.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/agenda.blade.php), [galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/galeri.blade.php), [fasilitas.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/fasilitas.blade.php))**:
  - Memindahkan card form kustomisasi Hero Banner halaman publik ke bagian atas card daftar tabel/item pada tab utama (Tab 1) di seluruh 5 modul Informasi Sekolah.
  - Menghapus tab navigasi pill *Hero Banner Publik* terpisah agar alur kerja admin lebih ringkas, terpadu, dan efisien tanpa perlu berpindah tab.
  - Menyesuaikan penomoran dan urutan pill navigasi tab di seluruh halaman terkait.

## [Modul CMS Informasi Sekolah Terpadu (Sidebar Multi-Navigasi 5 Sub-Modul)] - 2026-10-01

### Added
- **Modul Pengaturan Informasi Sekolah CMS ([app/Http/Controllers/Tenant/Admin/InformasiController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/InformasiController.php))**:
  - Menyediakan 5 sub-navigasi independen yang terhubung ke seluruh elemen publik:
    1. **Berita & Artikel Sekolah** (`/berita`): CRUD berita, editor WYSIWYG Quill.js, filter kategori & status publikasi, pencarian judul/ringkasan/konten, kustomisasi hero banner publik, dan sakelar visibilitas fitur.
    2. **Pengumuman Resmi Sekolah** (`/pengumuman`): CRUD pengumuman resmi dengan filter status publikasi, kustomisasi hero banner publik, dan sakelar visibilitas fitur.
    3. **Kalender & Agenda Kegiatan** (`/agenda`): Manajemen agenda mendatang/riwayat, tanggal mulai/selesai, jam pelaksanaan, lokasi, penyelenggara, tautan pendaftaran/konfirmasi daring eksternal, hero banner, dan visibilitas fitur.
    4. **Galeri Foto & Video** (`/galeri`): Manajemen album galeri (tipe foto/video), cover album, manajemen item media/YouTube dalam album, hero banner, dan visibilitas fitur.
    5. **Sarana & Fasilitas Sekolah** (`/fasilitas`): Manajemen katalog ruangan/bengkel (foto utama rasio 4:3, multi-foto tambahan repeater), counter statistik sarpras (ruang kelas teori, bengkel lab, perpustakaan, akses internet), hero banner, dan visibilitas fitur.
- **Sidebar Admin Multi-Navigasi Collapsible ([resources/views/layouts/tenant_admin.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/tenant_admin.blade.php))**:
  - Mengimplementasikan grup navigasi *Informasi Sekolah* dengan accordion Alpine.js dan 5 sub-navigasi independen.
- **Views Admin Blade Reusable Tailgrids Pattern**:
  - [resources/views/tenant/admin/informasi/berita.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/berita.blade.php)
  - [resources/views/tenant/admin/informasi/pengumuman.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/pengumuman.blade.php)
  - [resources/views/tenant/admin/informasi/agenda.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/agenda.blade.php)
  - [resources/views/tenant/admin/informasi/galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/galeri.blade.php)
  - [resources/views/tenant/admin/informasi/fasilitas.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/informasi/fasilitas.blade.php)
- **Rute Admin & Feature Test Pest**:
  - Rute admin di bawah prefix `{tenant}/admin/informasi/*` di [routes/web.php](file:///d:/databaru/Magang/website_sekolah/routes/web.php).
  - Test suite komprehensif di [tests/Feature/TenantAdminInformasiTest.php](file:///d:/databaru/Magang/website_sekolah/tests/Feature/TenantAdminInformasiTest.php) (7 skenario pengujian - 100% Passed).

### Changed
- **Penyelarasan Konsistensi UI & Arsitektur Blade 100% Seragam (Standar Admin Profil & Jurusan)**:
  - Melakukan refaktorisasi menyeluruh pada 5 sub-modul Informasi Sekolah (`agenda.blade.php`, `galeri.blade.php`, `fasilitas.blade.php`, `berita.blade.php`, `pengumuman.blade.php`).
  - Menyeragamkan seluruh token desain:
    1. **Tab Navigation Pills**: Menggunakan class standar `px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 shrink-0 cursor-pointer` (Aktif: `bg-blue-600 text-white shadow-xs` | Inaktif: `bg-white text-slate-600 hover:bg-slate-100 border border-slate-200`).
    2. **Container Card**: Seluruh pembungkus form dan tabel memakai `bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4` (atau `space-y-5`).
    3. **Header Card**: Judul kartu menggunakan `text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5` dengan subjudul `text-xs text-slate-500`.
    4. **Input, Select, & Textarea Form**: Menggunakan label `block text-xs font-bold text-slate-700 mb-1` dan input `w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition`.
    5. **Tombol Form & Media Picker**: Tombol simpan `px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center gap-2 cursor-pointer`, tombol media picker `px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer`.
    6. **Toast & Modal Dialog**: Toast di kanan bawah `fixed bottom-5 right-5 z-50 text-white px-5 py-3.5 rounded-2xl shadow-xl flex items-center gap-3 max-w-md` (`bg-emerald-600` / `bg-rose-600`) dan modal konfirmasi hapus kustom `bg-slate-900/60 backdrop-blur-xs`.

## [Pembersihan Menu Publik Kesiswaan & Sinkronisasi Navigasi] - 2026-10-01

### Removed
- **Menu Navigasi Publik Kesiswaan & Sub-menu ([database/migrations/2026_10_01_142634_delete_kesiswaan_menu_and_submenus_from_tenant_menus.php](file:///d:/databaru/Magang/website_sekolah/database/migrations/2026_10_01_142634_delete_kesiswaan_menu_and_submenus_from_tenant_menus.php))**:
  - Menghapus menu dropdown publik `Kesiswaan` beserta ketiga sub-menunya (`Prestasi Siswa`, `Ekstrakurikuler`, `OSIS & MPK`) dari tabel `menus` di seluruh database tenant sesuai instruksi (informasi dan dokumentasi OSIS/kesiswaan diarahkan masuk ke modul Berita, Agenda, dan Galeri Dokumentasi Resmi).
  - Menghapus view statis [osis.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/osis.blade.php), helper method `PageController@osis`, dan grup route alias `/{tenant}/kesiswaan/*` di [routes/web.php](file:///d:/databaru/Magang/website_sekolah/routes/web.php).
  - Memperbarui seeder [TenantSmkn2BandungSeeder.php](file:///d:/databaru/Magang/website_sekolah/database/seeders/TenantSmkn2BandungSeeder.php) dan [TenantDummySeeder.php](file:///d:/databaru/Magang/website_sekolah/database/seeders/TenantDummySeeder.php) agar urutan menu navbar tetap rapi dan konsisten.

### Changed
- **Penyelarasan Dokumentasi Rute ([docs/04-ROUTES-OR-API.md](file:///d:/databaru/Magang/website_sekolah/docs/04-ROUTES-OR-API.md))**: Memperbarui tabel rute dan catatan integrasi konten kesiswaan.

## [Pengaturan Program Keahlian / Jurusan CMS & Dual WYSIWYG Editor] - 2026-09-30

### Added
- **Dukungan WYSIWYG Editor untuk Informasi Program ([tab-form-jurusan.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/tabs/tab-form-jurusan.blade.php) & [Jurusan.php](file:///d:/databaru/Magang/website_sekolah/app/Models/Tenant/Jurusan.php))**:
  - Menambahkan kolom `informasi_tambahan` pada database tenant dan menghubungkannya dengan Quill.js WYSIWYG editor kedua di panel admin.
  - Admin kini bebas memformat daftar jenjang studi, sertifikasi LSP/BNSP, peluang karir, akreditasi, atau poin keunggulan lainnya menggunakan heading, list bullet/numbered, bold, dan links.
  - Mengintegrasikan rendering HTML dinamis di kartu sidebar detail publik ([jurusan_detail.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/jurusan_detail.blade.php)).
- **Modul Pengaturan Program Keahlian Admin CMS ([resources/views/tenant/admin/jurusan/](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/jurusan/))**:
  - Menyediakan panel manajemen lengkap berbasis tab independen:
    - `tab-jurusan.blade.php`: Tabel interaktif daftar konsentrasi keahlian, relasi kepala program keahlian (`guru_id` berelasi 100% dengan `guru_staf`), urutan tampil, sakelar status publikasi instan (AJAX), tombol edit & hapus dengan konfirmasi modal kustom.
    - `tab-form-jurusan.blade.php`: Tab form dedikasi luas mandiri untuk tambah & edit jurusan (bukan modal pop-up sempit), dilengkapi pemilih Logo/Lambang jurusan, auto-slug generator dinamis di latar belakang (hidden input), dual WYSIWYG Quill.js editor, dropdown relasi kepala program (`guru_staf`), Galeri Multi-Foto Dokumentasi Bengkel/Lab, live preview rasio 4:3 ambient background, dan Media Picker terpadu.
    - `tab-hero.blade.php`: Kustomisasi judul halaman, subjudul/deskripsi pengantar hero publik, dan foto latar hero (16:9) dengan pemilih media terpadu.
    - `tab-visibilitas.blade.php`: Sakelar feature flag `program_keahlian` yang otomatis menyinkronkan ketersediaan menu navbar, katalog beranda, dan proteksi rute publik.
    - `modals.blade.php`: Modal konfirmasi hapus data dan integrasi pemilih berkas media terpusat.
- **Tabel & Model Baru Galeri Multi-Foto Jurusan ([FotoJurusan.php](file:///d:/databaru/Magang/website_sekolah/app/Models/Tenant/FotoJurusan.php) & Migrasi `foto_jurusan`)**:
  - Mendukung upload banyak foto dokumentasi fasilitas laboratorium, mesin, dan karya siswa per program keahlian dengan relasi `jurusan_id` FK (100% cascade).
- **Halaman Detail Jurusan Publik Dinamis ([jurusan_detail.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/jurusan_detail.blade.php))**:
  - Menampilkan Logo jurusan (jika tersedia) atau fallback ke singkatan teks dengan rapi.
  - Menampilkan kartu terpadu Kepala Program Keahlian (terhubung ke data master `guru_staf`) dan seksi Informasi Program fleksibel berbasis WYSIWYG.
  - Menampilkan seksi **Fasilitas Praktik & Dokumentasi Kejuruan** (Galeri Multi-Foto) di bawah silabus.

## [Layout Adaptif Halaman Profil Publik & Sinkronisasi Cascade 2 Arah] - 2026-09-30

### Fixed
- **Layout Adaptif Halaman Profil Publik ([resources/views/public/pages/profil.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/profil.blade.php))**:
  - Mengatasi masalah tampilan berantakan / teks menyempit saat fitur *Video Profil Sekolah* dinonaktifkan di admin.
  - Menerapkan layout adaptif elegan: saat video aktif menggunakan 2 kolom responsif (`8 : 4`), dan saat video dinonaktifkan otomatis beralih ke format 1 kolom terpusat (`max-w-4xl mx-auto`) dengan tipografi dan kontainer simetris.

### Added
- **Cascade Toggle Dua Arah (Bidirectional)**:
  - Mengaktifkan kembali sakelar induk (misal: `menu_profil`, `profil`, `struktur_organisasi`) kini otomatis ikut mengaktifkan seluruh sub-menu dan sub-section di bawahnya baik di backend maupun antarmuka reaktif frontend (Alpine.js).
- **Penyelarasan Navigasi Publik dengan Pengaturan Fitur ([layouts/public.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/layouts/public.blade.php))**:
  - Navbar desktop & mobile drawer kini secara otomatis memeriksa status `PengaturanFitur` (`menu_profil`, `profil`, `sejarah`, `visi_misi`, `struktur_organisasi`, `guru_staf`, `fasilitas`, dll).
  - Jika sakelar **Menu Utama Profil Sekolah (`menu_profil`)** dinonaktifkan di admin, menu navigasi Profil di header/drawer publik otomatis hilang dan tidak dapat diakses.
  - Sub-menu yang dinonaktifkan juga otomatis disaring keluar dari dropdown.
- **Komponen Parsial Media Picker Reusable ([resources/views/tenant/admin/media/picker-modal.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/media/picker-modal.blade.php))**:
  - Mengekstrak modal Media Picker dari Blade admin profil menjadi komponen terisolasi dan reusable sehingga dapat dipanggil kapan saja di seluruh modul admin via `@include('tenant.admin.media.picker-modal')`.
  - Filter kategori berkas lengkap (`Semua`, `Gambar`, `Video Lokal`, `YouTube`, `Dokumen`) dan fitur impor cepat URL YouTube/Gambar langsung di dalam modal.

## [Modularisasi Blade Tab Profil & Hierarki Bertingkat Visibilitas Menu] - 2026-09-30

### Added
- **Modularisasi Berkas Blade Admin Profil ([resources/views/tenant/admin/profil/tabs/](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/tabs/))**:
  - Memisahkan seluruh konten per-tab yang sebelumnya menumpuk 2.200 baris menjadi berkas parsial independen:
    - `tab-datadiri.blade.php`: Data Pokok, Medsos, Kepala Sekolah & Sambutan, serta Video Profil.
    - `tab-profil.blade.php`: Kustomisasi Hero Banner & Uraian Lengkap Profil (WYSIWYG).
    - `tab-sejarah.blade.php`: Judul, Subjudul, Banner & Konten Sejarah (WYSIWYG).
    - `tab-visimisi.blade.php`: Judul, Subjudul, Banner & Konten Visi, Misi & Sasaran Mutu (WYSIWYG).
    - `tab-struktur.blade.php`: Hero Banner, Bagan Diagram Dinamis (Repeater), dan Tabel Pejabat Struktural.
    - `tab-guru.blade.php`: Hero Banner dan Direktori Master Guru & Tenaga Kependidikan.
    - `tab-visibilitas.blade.php`: Tabel sakelar visibilitas bertingkat (*cascade*).
    - `modals.blade.php`: Dialog pop-up Pejabat, Guru, Konfirmasi Hapus, Konfirmasi Visibilitas, dan Media Picker.
- **Hierarki Visibilitas Bertingkat (Cascade Visibility)**:
  - Tab 7 Visibilitas dirinci dari level tertinggi hingga level sub-section:
    - `1. Menu Utama Profil Sekolah` (`menu_profil`) -> jika dinonaktifkan, mematikan seluruh sub-halaman & sub-section di bawahnya.
    - `I. Data Diri Sekolah` (`profil_data_pokok`) -> memiliki sub-sakelar `Kepala Sekolah & Sambutan` (`profil_sambutan_kepsek`) dan `Video Profil` (`profil_video`).
    - `II. Profil Lengkap` (`profil`).
    - `III. Sejarah Sekolah` (`sejarah`).
    - `IV. Visi, Misi & Sasaran Mutu` (`visi_misi`).
    - `V. Struktur Organisasi` (`struktur_organisasi`) -> memiliki sub-sakelar `Bagan Diagram Struktur` (`struktur_diagram`) dan `Daftar Pejabat Struktural` (`struktur_pejabat`).
    - `VI. Guru & Tenaga Kependidikan` (`guru_staf`).
    - `VII. Fasilitas Sekolah` (`fasilitas`).
  - Halaman publik (`profil.blade.php`, `struktur.blade.php`, `home.blade.php`) kini memeriksa flag sub-section ini secara dinamis.
- **Verifikasi**:
  - Full Pest Suite: **75 passed (489 assertions)**.

## [Penambahan Tab 6 Guru & Tenaga Kependidikan di Admin Profil] - 2026-09-30

### Added
- **Tab 6: Guru & Tenaga Kependidikan pada Admin Profil ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**:
  - Menambahkan tombol tab navigasi `6. Guru & Tenaga Kependidikan` (`?tab=guru`) dan memperbarui nomor tab visibilitas menjadi `7. Visibilitas Menu & Rute`.
  - **Kartu 1 (Kustomisasi Hero Banner Halaman Guru & Staf)**: Pengaturan judul utama (`judul_guru`), subjudul/deskripsi ringkas (`subjudul_guru`), dan foto latar banner (`gambar_banner_guru`) dengan preview box 16:9 (`bannerGuruPreview`) serta pemilih berkas dari Pusat Media (`openMediaPicker('input_banner_guru')`).
  - **Penerapan Konsep Smart Crop & Ambient Blur Media pada Preview Foto**: Memperbaiki kotak preview Foto Kepala Sekolah, Modal Pejabat Struktural, dan Modal Guru/Staf agar menerapkan `:style="...CropStyle"` (membaca crop zoom & focal position langsung dari Pusat Media) dan efek ambient background `blur-md scale-125 opacity-40 z-0` yang konsisten dengan Media Library.
- **Rute Admin & Controller Guru ([web.php](file:///d:/databaru/Magang/website_sekolah/routes/web.php), [ProfilController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/ProfilController.php))**:
  - Menambahkan endpoint `PUT /admin/profil/guru-hero` (`tenant.admin.profil.guru.hero.update`) untuk pembaruan banner hero `/guru-staf`.
  - Menambahkan rute CRUD `POST /admin/profil/guru`, `PUT /admin/profil/guru/{guru}`, `DELETE /admin/profil/guru/{guru}` (`tenant.admin.profil.guru.*`).
- **Pembaruan Halaman Publik Direktori Guru ([guru.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/guru.blade.php), [PageController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Public/PageController.php))**:
  - Halaman `http://127.0.0.1:8000/{tenant}/guru-staf` kini membaca judul dinamis `$halaman->judul`, subjudul bersyarat `@if(!empty($subjudulGuru))`, dan gambar latar banner hero dengan efek artistik right-side gradient mask.
- **Automated Feature Tests ([TenantAdminProfilTest.php](file:///d:/databaru/Magang/website_sekolah/tests/Feature/TenantAdminProfilTest.php))**:
  - Menambahkan test `admin can update guru-staf hero banner and it displays on public guru-staf page` dan `admin can perform CRUD operations on guru and tenaga kependidikan`.
  - Verifikasi: `vendor/bin/pest` **75 test / 489 assertions PASSED**.

## [Perbaikan Render Bersyarat Subjudul & Sambutan Halaman Publik Profil] - 2026-09-30

### Fixed
- **Penghapusan Fallback Teks Keras jika Field Dikosongkan ([resources/views/public/pages/](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/))**:
  - Memperbaiki `sejarah.blade.php`, `visi-misi.blade.php`, `profil.blade.php`, dan `struktur.blade.php` agar membungkus paragraf subjudul/deskripsi ke dalam `@if(!empty($halaman->subjudul))` / `@if(!empty($profil->subjudul))` murni tanpa fallback string bawaan `?? ('Mengenal perjalanan panjang...')`.
  - Jika admin mengosongkan kolom Subjudul / Deskripsi Hero pada panel admin, portal publik kini benar-benar bersih dan tidak menampilkan teks deskripsi apa pun.
  - Memperbaiki `home.blade.php` dan `HomeController.php` agar Sambutan Kepala Sekolah hanya tampil jika diisi (`@if(!empty($sekolahData['sambutan']))`), dan tidak memunculkan kalimat fallback bawaan saat dikosongkan admin.
  - Verifikasi: `php artisan view:clear` & `vendor/bin/pest` **73 test / 461 assertions PASSED**.

## [Penataan & Penyeragaman Tab 5 Struktur Organisasi Admin Profil] - 2026-09-30

### Changed
- **Restrukturisasi Tab 5 Struktur Organisasi ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**:
  - Memisahkan form Struktur Organisasi menjadi kartu-kartu mandiri berdesain Tailgrids yang konsisten dengan Tab 1 (Data Diri), Tab 2 (Profil Lengkap), Tab 3 (Sejarah), dan Tab 4 (Visi Misi).
  - **Kartu 1 (Kustomisasi Hero Banner)**: Kartu putih terpisah di bagian atas dengan ikon header, input Judul Halaman Struktur, Subjudul/Deskripsi Ringkas, input Foto Banner dengan thumbnail preview box 16:9 (`bannerStrukturPreview`), dan trigger Media Picker.
  - **Kartu 2 (Bagan Diagram Struktur Organisasi)**: Kartu dinamis repeater dengan list bagan hierarki, input judul, deskripsi, thumbnail preview box 16:9 (`diag.gambar`), tombol Pilih Media reaktif, dan tombol Simpan lengkap dengan spinner animasi loading state (`<template x-if="submitLoading">`).
  - **Kartu 3 (Daftar Pejabat Struktural)**: Tabel pejabat dengan avatar 3:4, badge NIP berelasi guru/staf, dan aksi modal Add/Edit/Delete.
  - **Alpine.js `profilManager`**: Menambahkan state `bannerStrukturPreview`, serta mengintegrasikan pemilih media untuk `input_banner_struktur` dan `input_diag_*`.
  - Verifikasi: `vendor/bin/pest` **73 test / 461 assertions PASSED**.

## [Penyeragaman Ukuran Teks & Gaya Input Form Admin Profil] - 2026-09-30

### Changed
- **Seragamkan ukuran teks dan gaya seluruh field admin profil ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**:
  - Label seluruh tab dan modal Pejabat diseragamkan ke `text-xs font-bold text-slate-700 mb-1` - termasuk label hero Struktur Organisasi (sebelumnya `slate-800`), sub-field Media Sosial (sebelumnya `text-[11px] font-semibold text-slate-600`), label Bagan Diagram (sebelumnya `text-[11px]`), dan label Video Profil (sebelumnya `slate-800`).
  - Input/textarea/select diseragamkan ke `px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition` - input Video Profil, hero Struktur Organisasi, dan Bagan Diagram (sebelumnya `bg-white` dan/atau padding `px-3 py-2`) kini sama persis dengan tab lain; varian `focus:ring-1 focus:ring-blue-500` diseragamkan agar identik di semua tab.
  - Teks bantuan (hint) diseragamkan ke `text-[10px] text-slate-400`.
  - Tombol "Pilih Media" pada kartu Bagan Diagram disamakan dengan tombol serupa di kartu lain (`px-3.5 py-2`, ikon 16px, `gap-1.5`).
  - Verifikasi: `php artisan view:cache` sukses kompilasi; `vendor/bin/pest` **73 test / 461 assertions PASSED**.

## [Penerapan Banner Hero Artistik & Pelebaran Judul Halaman Publik] - 2026-09-30

### Added
- **Right-Side Artistic Banner Overlay di Seluruh Menu Publik ([resources/views/public/pages/](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/))**:
  - Mengimplementasikan efek visual banner artistik sisi kanan dengan gradient mask (`[mask-image:linear-gradient(to_left,rgba(0,0,0,1)_20%,rgba(0,0,0,0.6)_60%,transparent_100%)]`) dan theme header overlay ke seluruh halaman menu publik (`sejarah`, `visi-misi`, `struktur`, `profil`, `berita`, `galeri`, `fasilitas`, `jurusan`, `jurusan_detail`, `prestasi`, `ekstrakurikuler`, `guru`, `kontak`, `kurikulum`, `osis`, `kegiatan`, `kalender`, `spmb`).
  
### Changed
- **Pelebaran Container Judul Hero (`max-w-4xl lg:max-w-5xl`)**:
  - Mengubah batas sempit `max-w-2xl` / `max-w-3xl` menjadi `max-w-4xl lg:max-w-5xl` pada seluruh hero section publik, sehingga judul panjang (seperti "Sejarah Panjang SMK Negeri 2 Bandung") tampil utuh dan proporsional dalam satu baris tanpa terpotong kaku ke bawah saat ruang layar mencukupi.

## [Pemisahan Tab 1 Data Diri Sekolah & Tab 2 Profil Lengkap] - 2026-09-30

### Added
- **Tab Khusus "1. Data Diri Sekolah" (Tab `datadiri`) ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**:
  - Memisahkan form Data Pokok Satuan Pendidikan (Nama Sekolah, Slogan, Logo, NPSN, Akreditasi, Tahun Berdiri, No Telepon, Alamat, Email, WhatsApp, Jam Layanan, dan Akun Medsos Resmi) serta Kepala Satuan Pendidikan dan Video Profil ke dalam tab mandiri yang terfokus.
  - Tombol simpan "Simpan Data Diri Sekolah" dengan feedback loading state dan redirect langsung ke tab `?tab=datadiri`.
- **Tab "2. Profil Lengkap" (Tab `identitas`)**:
  - Dikhususkan untuk Kustomisasi Hero Banner Halaman Profil (Judul Utama, Subjudul, Gambar Latar) dan Editor WYSIWYG Uraian Lengkap Profil & Budaya Sekolah.
  - Tombol simpan "Simpan Halaman Profil" dengan feedback loading state dan redirect langsung ke tab `?tab=identitas`.

### Changed
- **Controller Admin Profil ([ProfilController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/ProfilController.php))**:
  - Memperbarui `updateIdentitas()` agar dapat memproses form `datadiri` dan `halaman_profil` secara modular dan independen berdasarkan field `form_type` dan `current_tab`.
- **Test Suite Feature ([TenantAdminProfilTest.php](file:///d:/databaru/Magang/website_sekolah/tests/Feature/TenantAdminProfilTest.php))**:
  - Menambahkan test case untuk verifikasi penyimpanan data diri sekolah dan pembaruan halaman profil secara terpisah.

## [Penyelarasan Layout Tab Profil: Hero di Atas, Input Media Sosial & Editor WYSIWYG Profil] - 2026-09-30

### Added
- **Input Akun Media Sosial Resmi di Tab Profil Admin ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**:
  - Menambahkan input URL media sosial resmi (Instagram, Facebook, YouTube, TikTok, dan X/Twitter) di bawah Data Pokok Sekolah pada Tab 1 (Profil Lengkap).
  - Nilai tersimpan langsung disinkronkan ke footer portal publik lewat kunci `pengaturan_umum` (`instagram`, `facebook`, `youtube`, `tiktok`, `twitter`).
- **Editor Teks Bebas WYSIWYG untuk Uraian Lengkap Profil Sekolah**:
  - Menyediakan editor WYSIWYG Quill pada Tab 1 (Profil Lengkap) yang tersimpan ke tabel `halaman_statis` (slug `profil`, kolom `isi_konten`).
  - Halaman publik profil ([profil.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/profil.blade.php)) otomatis merender bagian kartu "Profil & Budaya Sekolah" jika konten WYSIWYG diisi.

### Changed
- **Pemindahan Kustomisasi Hero Banner ke Bagian Teratas Tab 1 (Profil Lengkap)**:
  - Posisi Hero Banner di Tab 1 kini berada paling atas, seragam dan konsisten dengan tata letak Tab 2 (Sejarah), Tab 3 (Visi & Misi), dan Tab 4 (Struktur Organisasi).
- **Controller Admin Profil ([ProfilController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/ProfilController.php))**:
  - Menambahkan validasi dan penyimpanan array input media sosial serta `isi_konten_profil` pada method `updateIdentitas()`.

## [Kelengkapan Field Hero Banner pada Tab Struktur Organisasi] - 2026-09-30

### Added
- **Field "Judul Halaman Struktur Organisasi" dan "Foto Banner / Sampul Struktur (Pusat Media)" di tab Struktur Organisasi admin ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**: tab Struktur Organisasi kini memiliki tiga field hero yang sama dengan tab Sejarah dan Visi & Misi (Judul Halaman, Deskripsi Ringkas / Subjudul Hero, Foto Banner dengan tombol *Pilih dari Media*). Sebelumnya tab ini hanya punya field subjudul dan judulnya di-hardcode.
- **Penyimpanan judul & banner hero struktur ([ProfilController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/ProfilController.php))**: `updateStruktur()` memvalidasi `judul_struktur` dan `gambar_banner_struktur`, menyinkronkan banner ke Pusat Media lewat `MediaService::sinkronisasiOtomatisUrl()`, lalu menyimpan `judul` dan `gambar_banner` ke tabel `halaman_statis` (slug `struktur`). Sebelumnya `judul` selalu ditimpa `'Struktur Organisasi Sekolah'` dan `gambar_banner` tidak pernah disimpan.
- **Banner halaman publik struktur ([struktur.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/struktur.blade.php))**: gambar banner tampil di bagian atas section konten (rasio baku 21:9, `max-h-[420px]`, `rounded-2xl`) mengikuti pola halaman Sejarah dan Visi & Misi, dan `<title>` halaman kini memakai judul dari admin (`$halaman->judul`).
- **Blok header kartu tab Struktur Organisasi**: judul kartu "Kelola Struktur Organisasi & Data Pejabat" beserta deskripsi singkat, mengikuti pola blok header di tab Sejarah ("Kelola Halaman Sejarah Sekolah") dan Visi & Misi ("Kelola Visi, Misi & Sasaran Mutu") agar konsisten.

### Notes
- Test baru: `tests/Feature/TenantAdminProfilTest.php` - "admin can update struktur hero title, description, and banner and it appears on public page" (verifikasi simpan ke database, relasi `pengguna_id`, dan tampilan judul + banner di halaman publik).
- Verifikasi: full suite Pest **72 test / 453 assertions PASSED**; `vendor/bin/pint --dirty` passed; `php artisan view:clear` dijalankan.


## [Pemindahan Menu Fasilitas Sekolah ke Bagian Informasi] - 2026-09-30

### Changed
- **Menu Navigasi Fasilitas Sekolah Dipindahkan ke Dropdown Informasi**:
  - Item menu *Fasilitas Sekolah* (`/fasilitas`) kini berinduk ke menu *Informasi* (`parent_id = 4`) bukan lagi di *Profil*.
  - Pembaruan disinkronkan ke database tenant aktif (`menus` table) dan seeder (`TenantSmkn2BandungSeeder.php` dan `TenantDummySeeder.php`).
- **Penambahan Alias Rute Sub-prefix `/informasi/fasilitas` ([routes/web.php](file:///d:/databaru/Magang/website_sekolah/routes/web.php))**:
  - Menambahkan rute `Route::get('/fasilitas', [PageController::class, 'fasilitas'])->name('fasilitas');` di dalam grup `Route::prefix('informasi')`.
  - Rute langsung `/{tenant}/fasilitas` tetap aktif sebagai rute utama (`tenant.fasilitas`).

## [Penghapusan Mode Tampilan Struktur & Perbaikan Fatal View Publik Struktur] - 2026-09-30

### Removed & Fixed
- **Kontrol "Mode Pilihan Tampilan Halaman Struktur Publik" dihapus dari tab Struktur Organisasi admin ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**: tiga pilihan radio (`semua` / `pejabat` / `diagram`) dihapus karena tidak dibutuhkan operator sekolah.
- **Kunci `mode_tampilan_struktur` tidak lagi dibaca/ditulis**: dihapus dari `ProfilController::index()` dan `updateStruktur()` (validasi + `PengaturanUmum::updateOrCreate`), dari `Public\PageController::struktur()` (variabel `$modeTampilan` dan data view), serta dari view publik `struktur.blade.php`.
- **Halaman publik `/profil/struktur` selalu menampilkan kedua bagian**: tombol pilih tampilan selalu tampil dengan default tab "Jajaran Pejabat", dan blok "Jajaran Pejabat" serta "Bagan Diagram Struktur" dirender tanpa syarat mode.
- **Perbaikan bug fatal pada view publik struktur ([struktur.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/struktur.blade.php))**: directive `@if($mode === 'semua' || $mode === 'pejabat')` tidak pernah ditutup `@endif`, sehingga hasil kompilasi Blade berakhir dengan fatal parse error `unexpected end of file, expecting "elseif" or "else" or "endif"` (halaman publik struktur gagal dirender). Seluruh directive mode dihapus sehingga view valid; dibuktikan lewat kompilasi Blade + `php -l` yang kini bersih.
- **Regression test ditambahkan**: skenario `2b` pada `tests/Feature/TenantPublicPagesTest.php` (halaman `/profil/struktur` merespons 200 dan memuat kedua mode tampilan) serta `assertDontSee('pola_latar_profil')` dan `assertDontSee('mode_tampilan_struktur')` pada `tests/Feature/TenantAdminProfilTest.php`.

### Notes
- Kunci lama `pengaturan_umum.mode_tampilan_struktur` dibiarkan di database (tidak dihapus, tanpa migrasi destruktif) namun sudah tidak dipakai lagi oleh aplikasi.
- Verifikasi: full suite Pest **71 test / 435 assertions PASSED**; `vendor/bin/pint --dirty` bersih; `php artisan view:clear` dijalankan.


## [Tampilan URL & Tombol Salin di Modal Ubah Informasi Media] - 2026-09-30

### Added
- **Tampilan URL Berkas & Tombol Salin Cepat ([media/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/media/index.blade.php))**:
  - Modal *Ubah Informasi Berkas* sekarang menampilkan baris tautan URL berkas media lengkap dengan tombol **"Salin"** (ke clipboard) dan tombol **"Buka di Tab Baru"** agar admin dapat dengan mudah menyalin URL aset untuk digunakan di form/halaman lain.

## [Penghapusan Kontrol Pola Dekorasi Latar Hero di Admin Profil Sekolah] - 2026-09-30

### Removed & Simplified
- **Kontrol "Pola Dekorasi Latar" dihapus dari menu admin Profil Sekolah ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**: dropdown pola dekoratif hero di 4 tab (Identitas/Profil, Sejarah, Visi & Misi, Struktur) dihapus karena tidak berguna bagi operator sekolah dan hanya menambah beban form.
- **Penulisan nilai pola dihentikan di controller ([ProfilController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/ProfilController.php))**: aturan validasi `pola_latar_profil`, `pola_latar`, dan `pola_latar_struktur` beserta penulisan kolom `pola_latar` pada `updateIdentitas()`, `updateHalaman()`, dan `updateStruktur()` dihapus, sehingga penyimpanan form tidak lagi menimpa nilai tersimpan menjadi `dots`.
- **Data lama tetap aman tanpa migrasi destruktif**: kolom `halaman_statis.pola_latar`, `$fillable` model `Page`, dan 4 view publik (`profil`, `sejarah`, `visi-misi`, `struktur`) dipertahankan; hero publik tetap membaca nilai tersimpan dengan fallback `dots`.
- **Layout form hero dirapikan**: judul halaman kini `sm:col-span-2` (full width) pada tab Sejarah dan Visi & Misi, sedangkan panel hero Struktur kembali satu kolom karena hanya berisi subjudul.
- **Verifikasi**: `vendor/bin/pest` full suite **70 test / 429 assertions PASSED**; `vendor/bin/pint --dirty --format agent` bersih; `php artisan view:clear` dijalankan.


## [Standar Baku Matriks Rasio Aspek, Border, & Framing Media] - 2026-09-30

### Added & Standardized
- **Standar Baku Matriks Rasio Aspek ([.ai/rules/standar-rasio-media.md](file:///d:/databaru/Magang/website_sekolah/.ai/rules/standar-rasio-media.md), [docs/05-UI-UX.md](file:///d:/databaru/Magang/website_sekolah/docs/05-UI-UX.md))**:
  - Menetapkan 5 rasio baku terstandarisasi untuk seluruh halaman web: `1:1` (Avatar/Logo/Icon), `3:4` (Foto Pejabat/Kepsek/Guru), `4:3` (Jurusan/Fasilitas/Ekskul), `16:9` (Berita/Agenda/Video), dan `21:9` (Hero Banner).
  - Menetapkan standar token border radius (`rounded-2xl` untuk kartu, `rounded-xl` untuk thumbnail).
  - Menetapkan pola baku *Double Layer Ambient Backdrop* (`blur-md scale-125 opacity-40`) untuk mencegah letterbox hitam/putih saat rasio foto berbeda dengan kartu.
- **Penerapan Matriks Rasio Baku & Ambient Backdrop di Seluruh Halaman**:
  - **Admin Profil Sekolah ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php))**: Preview Logo (`1:1`), Foto Kepala Sekolah (`3:4`), Banner Hero (`16:9`), Modal Pejabat (`3:4`), dan Thumbnail Tabel Pejabat Struktur (`1:1` + crop style) tersinkronisasi live.
  - **Jurusan & Program Keahlian ([jurusan.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/jurusan.blade.php))**: Rasio baku `4:3` dengan ambient backdrop dan crop style.
  - **Berita & Artikel ([berita.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/berita.blade.php))**: Rasio baku `16:9` (`aspect-video`) dengan ambient backdrop dan crop style.
  - **Galeri Foto & Dokumentasi ([galeri.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/galeri.blade.php))**: Rasio baku `1:1` (`aspect-square`) dengan ambient backdrop dan crop style.
  - **Guru/Staf & Struktur ([guru.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/guru.blade.php), [struktur.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/struktur.blade.php))**: Rasio baku `1:1` / `3:4` squircle dengan ambient backdrop.
- **Sinkronisasi Media Picker Modal**:
  - Menambahkan serialization `$appends = ['smart_crop_style', 'focal_position_css']` di [Media.php](file:///d:/databaru/Magang/website_sekolah/app/Models/Tenant/Media.php) dan styling thumbnail di modal *Pilih Media* agar selalu identik dengan hasil crop di Media Library.

## [Crop & Focal Point Non-Destruktif Universal (CSS Object-Position)] - 2026-09-30

### Added & Improved
- **Crop & Focal Point Non-Destruktif Universal ([Media.php](file:///d:/databaru/Magang/website_sekolah/app/Models/Tenant/Media.php), [MediaController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/MediaController.php), [media/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/media/index.blade.php))**:
  - Menyelesaikan kendala gambar URL eksternal dan file upload tanpa merusak atau menimpa berkas master asli.
  - Menambahkan kolom `crop_settings` JSON pada tabel `media` tenant untuk menyimpan koordinat crop, rotasi, rasio, dan titik fokus persentase (`focal_x`, `focal_y`).
  - Menyediakan tombol **"Simpan Fokus Crop"** pada modal editor media yang menghitung pusat crop dan menyimpannya secara instan via API non-destruktif.
- **Penerapan Otomatis CSS Object-Position di Seluruh Web ([guru.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/guru.blade.php), [struktur.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/struktur.blade.php), [home.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/home.blade.php))**:
  - Gambar kartu Guru & Staf, Pejabat Struktur Organisasi, Foto Kepala Sekolah, dan thumbnail media library otomatis membaca koordinat fokus crop dengan helper `style="object-position: {{ $media->focal_position_css }};"`.

- **Live Thumbnail untuk Video Upload (MP4 / WebM / Lokal)**:
  - Tampilan grid dan list media memuat cuplikan visual video secara instan via `<video preload="metadata">` dengan overlay tombol putar dan tag badge MP4.
- **Penanda Status Penggunaan Media di Seluruh Website ([MediaService.php](file:///d:/databaru/Magang/website_sekolah/app/Services/MediaService.php), [MediaController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/MediaController.php))**:
  - Sistem melacak otomatis penggunaan setiap berkas media di seluruh database (Pengaturan Umum, Logo, Banner Halaman, Pejabat Struktur, Guru & Staf, Jurusan, Ekskul, Prestasi, Fasilitas, Slider, Galeri, dan Artikel Berita).
  - Badge hijau **"Digunakan"** dengan animasi pulse dan tooltip lokasi pemakaian serta badge **"Bebas"** untuk berkas yang belum disematkan.

## [Pagination 12 Items, Layout Mobile & Thumbnail Video di Media Picker Modal] - 2026-09-29

### Added & Improved
- **Pagination 12 Item per Halaman ([profil/index.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/tenant/admin/profil/index.blade.php), [MediaController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/MediaController.php))**:
  - Dukungan parameter dinamis `per_page=12` dan `page={n}` pada endpoint JSON AJAX `MediaController::index()`.
  - Media Picker modal menyajikan 12 item per halaman dengan navigasi tombol *Sebelumnya*, nomor halaman aktif, tombol *Selanjutnya*, dan indikator jumlah berkas.
- **Thumbnail Otomatis untuk Semua Jenis Video**:
  - Video YouTube otomatis mengambil dan menampilkan gambar thumbnail resolusi tinggi (`hqdefault.jpg`) beserta tag label badge YouTube.
  - Video MP4 / lokal otomatis me-render frame `<video preload="metadata">` dengan ikon play overlay dan badge format MP4.
- **Responsivitas & Optimasi Tampilan Mobile**:
  - Modal picker responsif dengan tinggi proporsional (`92vh` di mobile, `85vh` di desktop), padding compact, tata letak grid 2 kolom di ponsel, dan kontrol tombol yang nyaman disentuh.

## [Auto-Sinkronisasi URL Eksternal ke Pusat Media & Smart Video Player Profil] - 2026-09-29

### Added
- **Auto-Sinkronisasi URL Eksternal ke Entitas `media` ([MediaService.php](file:///d:/databaru/Magang/website_sekolah/app/Services/MediaService.php), [ProfilController.php](file:///d:/databaru/Magang/website_sekolah/app/Http/Controllers/Tenant/Admin/ProfilController.php))**:
  - Menyediakan method `sinkronisasiOtomatisUrl()`: ketika admin memasukkan tautan URL eksternal (Unsplash, tautan gambar/video web luar) pada kolom input Logo, Foto Kepala Sekolah, Banner Hero, Video Profil, Diagram Struktur, atau Foto Pejabat, sistem otomatis mengunduh file, mengonversi gambar ke WebP lokal, dan menyimpannya sebagai record terstruktur di database `media`.
  - Tautan URL pada pengaturan sekolah otomatis digantikan dengan URL storage internal lokal sehingga aset tersentralisasi penuh di satu entitas database `media`.
  - Tautan video YouTube otomatis didaftarkan ke tabel `media` dengan `tipe_media = 'youtube'`.
- **Smart Video Player Multi-Format ([profil.blade.php](file:///d:/databaru/Magang/website_sekolah/resources/views/public/pages/profil.blade.php))**:
  - Smart player otomatis mendeteksi apakah sumber video berasal dari YouTube (`<iframe>` embed dengan mode privasi `youtube-nocookie.com`) atau berkas video sendiri / lokal (HTML5 `<video>` player responsif dengan dukungan MIME type `video/mp4`, `video/webm`, `video/ogg`).

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
