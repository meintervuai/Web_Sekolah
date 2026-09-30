# UI/UX & Design System Specification — Revisi Web Sekolah

## 1. Grid, Container & Spacing
- **Container Maksimum:** 1.200px terpusat (`max-w-[1200px] mx-auto`).
- **Padding Horizontal:**
  - Mobile (<640px): 20px (`px-5`)
  - Tablet (640px - 1024px): 32px (`px-8`)
  - Desktop (>1024px): 40px (`px-10`)
- **Padding Vertikal Section:**
  - Mobile: 48px (`py-12`)
  - Tablet: 64px (`py-16`)
  - Desktop: 88px (`py-20` atau `py-22`)
- **Grid Layout:**
  - Desktop: 12 kolom dengan gap 24px (`gap-6`)
  - Tablet: 8 kolom dengan gap 20px (`gap-5`)
  - Mobile: 4 kolom dengan gap 16px (`gap-4`)
- **Spacing Token:** Kelipatan 4px konsisten. Jarak judul section ke konten: 28–36px (`mb-8` s.d `mb-9`).

## 2. Tipografi & Warna
- **Font Utama:** `Inter` (sans-serif) untuk body dan teks UI.
- **Font Display / Heading:** `Plus Jakarta Sans` (sans-serif) untuk judul (`h1` s.d `h6`) yang tegas dan profesional tanpa kesan AI slop.
- **Skala Tipografi:**
  - H1: Desktop 48–56px, Tablet 40–44px, Mobile 32–36px (`font-bold tracking-tight`).
  - H2: Desktop 32–40px, Tablet 28–32px, Mobile 26–30px.
  - Body: 16–18px dengan line-height 1.6 (`leading-relaxed`).
- **Sistem Tema Warna Dinamis & CSS Variables (13 Kunci Warna, 6 Grup):**
  - Konfigurasi warna disimpan di database tenant (`pengaturan_umum`) dan diinjeksi via `:root` di `layouts/public.blade.php`; fallback identik juga didefinisikan di `resources/css/public.css`:
    - **Grup A - Warna Identitas:** `--theme-color` (`warna_tema`, default `#1E3A8A`), `--theme-accent` (`warna_aksen`, default `#0284C7`).
    - **Grup B - Tipografi & Teks:** `--theme-heading` (`warna_judul`, default `#0F172A`), `--theme-text` (`warna_teks`, default `#0F172A`), `--theme-text-muted` (`warna_teks_sekunder`, default `#475569`).
    - **Grup C - Latar & Permukaan:** `--theme-page-bg` (`warna_latar_halaman`, default `#F8FAFC`), `--theme-section-bg` (`warna_latar_section`, default `#F1F5F9`), `--theme-card-bg` (`warna_kartu`, default `#FFFFFF`).
    - **Grup D - Garis & Batas:** `--theme-border` (`warna_border`, default `#E2E8F0`).
    - **Grup E - Tombol & Aksi:** `--theme-btn-bg` (`warna_tombol`, default `#1D4ED8`), `--theme-btn-text` (`warna_tombol_teks`, default `#FFFFFF`).
    - **Grup F - Header, Navigasi & Footer:** `--theme-header-bg` (`warna_header`, default `#1E3A8A`), `--theme-footer-bg` (`warna_footer`, default `#1E3A8A`).
    - Turunan otomatis dari `--theme-color` memakai `color-mix()`: `--theme-color-dark`, `--theme-color-light`, `--theme-color-transparent`.
  - **Legacy Utility Mapping (pemetaan kelas utilitas netral lama):** `resources/css/public.css` memetakan `.bg-white`, `.bg-slate-50/100/200`, `.border-slate-*`, dan `.text-slate-*` ke variabel tema dengan `!important`, sehingga seluruh view publik yang masih memakai utilitas Tailwind netral ikut berganti warna tanpa diedit satu per satu. Zona gelap (`theme-header`, `footer`, section `bg-blue-950`/`bg-slate-900`) memakai kunci panel `warna_tombol_teks` untuk teks terangnya, sehingga nilainya selalu mengikuti Tema & Warna, bukan putih hardcoded.
  - **Tailwind v4 Palette Override (penutup celah kelas berwarna):** Tailwind v4 merender utilitas seperti `.text-blue-600`, `.bg-slate-900`, atau `.from-blue-900` menjadi `var(--color-<keluarga>-<shade>)`. `resources/css/public.css` menimpa variabel palet tersebut di `:root` (deklarasi tanpa layer menang atas `@layer theme` bawaan Tailwind) dengan pengelompokan **tanpa pengecualian semantik**: **blue, indigo, purple, violet, fuchsia, pink → skala `--theme-identity-50..950`** (turunan `--theme-color`); **sky, cyan, teal, green, emerald, lime, yellow, amber, orange, red, rose → skala `--theme-accent-50..950`** (turunan `--theme-accent`, termasuk keluarga status); **slate, gray, zinc, stone, neutral → skala `--theme-neutral-50..950`** (terang dari `--theme-text-muted`, gelap dari `--theme-color`); serta **`--color-white` → `--theme-btn-text`** agar literal `text-white`/`border-white`/`bg-white/xx` mengikuti kunci teks terang panel (default `#FFFFFF`, ikut panel). Total 199 variabel palet di-override. Karena berjalan di level variabel, varian `hover:`/`focus:`/`group-hover:`, opacity `/xx`, gradien `from-via-to`, `ring-*`, `placeholder-*`, serta border `border-slate-200/80|60` ikut mengikuti tema tanpa mengedit view; aturan kontekstual yang sudah ada (mis. `.bg-blue-600` → tombol) tetap menang karena lebih spesifik dan ber-`!important`, namun **seluruh literal putih hardcoded pada aturan lama diganti kunci panel `warna_tombol_teks`** (aturan header/footer, breadcrumb `text-blue-100/200`, amber di dark card/section, `group-hover:text-sky-300`, dan aturan zona gelap `h1..p`). Pola titik radial hardcoded `#38bdf8` pada hero (~17 halaman) dipetakan ke aksen, dan tombol WhatsApp `bg-[#25D366]` + `hover:bg-[#20ba5a]` juga dipetakan ke aksen. Pengecualian semantik sebelumnya (`emerald`/`rose`/`red`/WhatsApp) dihapus atas keputusan pemilik produk: semua warna wajib mengikuti panel. **Tidak ada putih literal tersisa**: dasar campuran terang seluruh skala `color-mix` (identitas, aksen, netral, badge, hover, tabel) memakai `warna_latar_halaman`, `--color-white` memakai `warna_tombol_teks`, titik radial hero memakai `--theme-accent-400`, dan pratinjau panel admin memakai `btnText`/`pageBg`. Overlay `bg-black/xx` tetap hitam karena berfungsi sebagai latar redup, bukan warna tema.
  - **Kelas Global Tema:** `.theme-page-bg`, `.theme-section-bg`, `.theme-surface-alt`, `.theme-card`, `.theme-heading`, `.theme-text-body`, `.theme-text-muted`, `.theme-link`, `.theme-border`, `.theme-divider`, `.theme-badge`, `.theme-icon-box`, `.theme-btn-primary`, `.theme-btn-ghost`, `.theme-header`, `.theme-footer`, `.theme-table-head`, `.theme-table-row`, `.theme-input` - kelas bersama yang dipakai layout dan seluruh halaman publik.
  - **7 Preset Tema Warna Siap Pakai:**
    1. *Biru Navy Klasik* (`navy_classic`): `#1E3A8A` / `#0284C7` / `#1D4ED8` (Formal & wibawa).
    2. *Hijau Zamrud Edukasi* (`emerald_nature`): `#065F46` / `#10B981` / `#059669` (Islami & alami).
    3. *Merah Marun Prestisius* (`maroon_prestige`): `#881337` / `#F43F5E` / `#BE123C` (Bergengsi).
    4. *Ungu Dinamis Kreatif* (`royal_purple`): `#581C87` / `#A855F7` / `#7E22CE` (Kreatif & vokasi).
    5. *Abu Gelap Elegan* (`slate_dark`): `#0F172A` / `#38BDF8` / `#1E293B` (Minimalis modern).
    6. *Emas Oranye Enerjik* (`amber_sunset`): `#78350F` / `#F59E0B` / `#D97706` (Inovatif & wirausaha).
    7. *Teal Bahari Futuristik* (`teal_modern`): `#134E4A` / `#14B8A6` / `#0D9488` (Bahari & teknologi).
  - **Custom Hex & Live Preview:** Admin mengatur 13 kunci warna per grup dengan Color Picker + input heksadesimal yang tersinkronisasi dua arah, disertai pratinjau langsung berupa mock header, section + kartu, dan footer yang langsung merespons perubahan sebelum disimpan.
  - **Auto-Kontras WCAG Otomatis (dua lapis, teks tidak pernah nabrak latar):**
    - **Lapis 1 - server-side.** Helper `App\Support\WarnaKontras` (`luminans()`, `rasio()`, `pilihTeks()`, `campurWarna()`) menghitung luminans dan rasio kontras resmi WCAG 2.1. `layouts/public.blade.php` memanggil closure `$kontras()` untuk menyuntik **16 kunci teks per permukaan**: `--theme-fg-header`, `--theme-fg-footer`, `--theme-fg-zona`, `--theme-fg-tombol`, `--theme-fg-aksen`, `--theme-fg-link`, `--theme-fg-badge`, `--theme-fg-halaman-heading|text|muted`, `--theme-fg-section-heading|text|muted`, `--theme-fg-kartu-heading|text|muted`. Warna pilihan admin tetap dipakai selama lolos ambang; kalau tidak, putih/tinta `#0F172A` dipilih otomatis (argmax). Ambang: teks isi **4.5:1**, tombol/teks besar **3:1**, tautan **2:1**.
    - **Lapis 2 - client-side (pengaman).** `resources/css/public.css` mendaftarkan `@property --kontras-aman` dan `--kontras-terang` (boolean teranimasi) lalu mendeteksi kontras tiap scope dengan `calc(var(--fg) contrast(var(--bg)) >= 4.5)`. Scope yang dilindungi lewat variabel `--fg-zona-efektif`: `:root` (fallback), `.theme-page-bg`, `.theme-section-bg`, `.theme-card` + `.bg-white/90|/95`, `.theme-badge`, zona gelap `.theme-bg`/`bg-blue-900`, `.theme-header`, serta `footer.theme-bg`/`footer.theme-footer`. Efeknya, override warna dari DevTools, ekstensi browser, atau JS tetap dipaksa terbaca.
    - **Pratinjau admin sejalan.** `resources/views/tenant/admin/pengaturan/index.blade.php` memuat salinan JS `WarnaKontras` (`luminans/rasio/pilihTeks/campur`) dan computed getter (`fgHeader`, `fgFooter`, `fgTombol`, `fgAksen`, `fgKartuHeading`, `fgKartuTeks`, `fgKartuMuted`, `fgSectionHeading`, `fgBadge`, `fgLink`), sehingga pratinjau menampilkan hasil render publik, bukan warna mentah panel.
    - Literal putih hardcoded pada tombol dan zona gelap sudah diganti resolver ini: `--theme-btn-text` hanya menjadi *usulan* warna teks, bukan nilai akhir.
  - Panduan menulis kode agar mengikuti sistem ini: rule `.ai/rules/publik-tema-kontras.md` (checklist wajib saat menambah menu, halaman, atau section publik) dan `docs/08-CSS-ARSITEKTUR-TEMA.md` (diagram alur warna, tabel variabel, registri scope, resep komponen, fallback browser).

  - Kontras teks memenuhi standar **WCAG AA** (minimal 4.5:1 untuk normal text); kombinasi warna teks terang pada latar gelap (hero, header, footer) dijaga agar tidak tereduksi oleh pemetaan utilitas netral.

## 3. Matriks Rasio Media, Border, & Framing Baku
Semua kontainer media di seluruh halaman (publik & admin) wajib mematuhi matriks 5 rasio baku berikut (lihat `.ai/rules/standar-rasio-media.md`):

1. **Rasio 1:1 (Persegi - `aspect-square`):**
   - Peruntukan: Logo Sekolah, Avatar Guru/Staf, Thumbnail Media Manager, Icon Box.
   - Ukuran: 48x48px (badge), 96x96px s.d 160x160px (avatar), full grid card di media manager.
2. **Rasio 3:4 (Portrait Vertikal - `aspect-[3/4]`):**
   - Peruntukan: Foto Pejabat / Struktur Organisasi, Kartu Sambutan Kepala Sekolah di Beranda, Detail Profil Guru Formal.
3. **Rasio 4:3 (Landscape Standar - `aspect-[4/3]`):**
   - Peruntukan: Kartu Jurusan / Program Keahlian, Galeri Foto Fasilitas Sekolah, Ekstrakurikuler, Prestasi Siswa.
4. **Rasio 16:9 (Widescreen - `aspect-video` / `aspect-[16/9]`):**
   - Peruntukan: Thumbnail Berita, Artikel Populer, Pengumuman, Agenda Kegiatan, Video MP4 & YouTube.
5. **Rasio 21:9 / Banner Adaptif (`aspect-[21/9]` atau tinggi responsif):**
   - Peruntukan: Hero Carousel Utama Beranda, Header Banner Halaman Statis/Profil (tinggi desktop 420–540px, mobile 380px).

- **Border Radius & Styling Token:**
  - Card & Container Media: 16px (`rounded-2xl`) + `overflow-hidden`.
  - Thumbnail Grid & Modal Picker: 12px (`rounded-xl`) + `overflow-hidden`.
  - Button & Form Input: 10px (`rounded-xl` / `rounded-[10px]`).
- **Pola Framing Baku (Double Layer Ambient Backdrop):**
  - Mencegah letterboxing hitam/putih saat rasio foto berbeda dengan kartu:
  - Lapis 1: `absolute inset-0 w-full h-full object-cover blur-md scale-125 opacity-40 pointer-events-none`
  - Lapis 2: `relative z-10 w-full h-full object-cover` + `style="{{ MediaService::getCropStyle($url) }}"`
- **Card Hover:**
  - `transform: translateY(-4px)`, shadow bertambah, durasi transition 200ms.
  - Dinonaktifkan pada `prefers-reduced-motion: reduce`.

## 4. Interaksi & Aksesibilitas
- **Hero Carousel:** Otomatis berputar (5-7 detik), jeda saat di-hover atau difokuskan oleh keyboard, tombol Previous/Next, indikator titik, dan dukungan swipe layar sentuh.
- **Counter Statistik:** Terpicu saat masuk viewport (menggunakan IntersectionObserver), berdurasi 800–1.200ms, hanya berjalan sekali.
- **Navigasi Mobile:** Drawer menu dengan penutup tombol Esc dan transisi mulus tanpa pergeseran layout.
- **Empty States:** Ditampilkan secara eksplisit dengan ikon dan teks informatif jika belum ada data.

## 5. Implementasi Desain Base Tailwind & Kalender Agenda 3-Kolom
- **Base Tailwind Core Language:**
  - Header: Sticky navbar dengan translucent blur (`bg-white/95 backdrop-blur-md`), topbar identitas sekolah, CTA button dengan gradient halus dan shadow terukur.
  - Section Headings: Judul display tebal dengan aksen gradient halus atau subtitle kontras tinggi, bebas dari badge klise AI yang mengulang teks judul.
  - Footer: Struktur 4-kolom yang rapi, tautan terverifikasi tanpa link kosong (`#`), copyright resmi, dan tombol WhatsApp mengambang.
- **Kalender & Agenda Kegiatan (3-Column Layout):**
  - Kolom Kiri (Desktop 4 kolom): Widget Kalender Interaktif berbasis Alpine.js dengan pemilih bulan/tahun, penanda titik tanggal ber-agenda, filter tanggal satu-klik, serta pills kategori agenda.
  - Kolom Kanan (Desktop 8 kolom): Daftar agenda dalam kartu horizontal (thumbnail gambar rasio 16:10 / 4:3 di kiri, badge tanggal, jam pelaksanaan, lokasi, status pendaftaran, deskripsi, dan tombol aksi ke rincian).
  - Bagian Atas: Hero section kontras tinggi dengan kartu featured agenda highlight.

## 6. Panel Admin Sekolah (Hanya Pengaturan Tema)

Sejak 2026-09-29, panel admin sekolah (`resources/views/layouts/tenant_admin.blade.php`) dipersempit menjadi satu modul tampilan:

- **Sidebar:** satu grup section `Pengaturan` dengan satu item menu **Tema & Warna** (ikon palet, padding `px-3.5 py-2.5`, radius `rounded-xl`). Tidak ada lagi menu konten, media, maupun SPMB.
- **Brand header sidebar:** logo sekolah 36x36px (`rounded-xl`, border `slate-200`) dan nama sekolah menaut ke halaman pengaturan tema; sub-label tetap `Admin Management`.
- **Header atas:** breadcrumb `Admin Portal / Tema & Warna Sekolah` dan tombol pill `Kunjungi Website`.
- **Halaman `tenant/admin/pengaturan/index.blade.php`:**
- **Header kartu:** judul `Pengaturan Tema & Warna Portal Sekolah` dan label status statis `Tema & Warna` sebagai pengganti segmented tab.
  - **Preset cepat:** grid 7 kartu preset (`grid-cols-1 sm:grid-cols-2 lg:grid-cols-4`, radius `rounded-xl`, `shadow-2xs`); kartu aktif ditandai `border-blue-600 ring-2 ring-blue-600/20` dan badge `Aktif`.
  - **Rincian warna per bagian tampilan:** 6 kartu grup (A Warna Identitas, B Tipografi & Teks, C Latar & Permukaan, D Garis & Batas, E Tombol & Aksi, F Header, Navigasi & Footer) dengan total 13 color picker + input heksadesimal tersinkronisasi, tampilan chip warna, dan petunjuk pemakaian `var(--theme-*)`.
  - **Pratinjau langsung:** mock header, section + kartu, serta footer yang terikat (Alpine `:style`) pada ke-13 variabel warna.
  - **Legenda kelas global** untuk pengembang (`.theme-page-bg`, `.theme-card`, `.theme-heading`, `.theme-btn-ghost`, `.theme-header`, `.theme-footer`, `.theme-input`, dll.).
  - Satu tombol submit `Simpan Perubahan` dengan flash sukses `Tema dan palet warna portal sekolah berhasil disimpan.`
- **State yang ditangani:** flash sukses/gagal di layout, proteksi `auth:tenant_admin`, serta fallback preset `navy_classic` bila tabel `pengaturan_umum` belum memiliki nilai.
- **Aksesibilitas:** label eksplisit pada setiap input warna, tombol preset native `button` sehingga dapat difokuskan keyboard, kontras mengikuti WCAG AA, dan layout tetap satu kolom pada mobile tanpa horizontal overflow.
