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
- **Warna & CSS Variables:**
  - `--theme-color`: Warna identitas sekolah (default: `#1E3A8A` atau `#0284C7` / `#2563EB`).
  - Kontras teks memenuhi standar **WCAG AA** (minimal 4.5:1 untuk normal text).

## 3. Komponen Card & Media Ratios
- **Border Radius:**
  - Card & Container: 16px (`rounded-2xl`).
  - Button & Form Input: 10px (`rounded-xl` / `rounded-[10px]`).
- **Rasio Aspek Media & Banner:**
  - Hero Slider Carousel: Rasio 16:9 desktop (tinggi 420–540px), mobile 380px, mendukung media Gambar atau Video MP4/WebM (`autoplay`, `muted`, `playsinline`, auto-next slide on ended).
  - Banner Hero Beranda (atas Sambutan Kepsek): Tinggi responsif 288–480px, mendukung mode Gambar, Video Looping, atau Keduanya (video diputar sampai tamat baru berganti ke gambar) dengan kontrol mute/unmute audio.
  - Berita / Pengumuman / Agenda: Rasio 16:9 thumbnail cover.
  - Fasilitas & Program Keahlian: Rasio 4:3.
  - Staff / Guru Avatar: Rasio 1:1 bulat/persegi minimal 160x160px desktop, 112x112px mobile.
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
