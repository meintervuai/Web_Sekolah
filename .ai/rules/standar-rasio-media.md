# Standar Baku Rasio Aspek, Border, & Framing Media

Aturan ini mengikat seluruh perancangan antarmuka (Frontend Publik & CMS Admin) agar setiap komponen gambar, kartu, dan media memiliki rasio kelipatan yang proporsional, seragam, dan tidak dibuat secara sembarangan (*no ad-hoc sizing*).

---

## 1. Matriks Standar Rasio Aspek (Aspect Ratio Matrix)

Semua kontainer media di seluruh portal **WAJIB** menggunakan salah satu dari 5 rasio baku berikut:

| Kategori Rasio | Kelas Tailwind | Peruntukan / Konten | Contoh Penggunaan |
|---|---|---|---|
| **1:1 (Persegi)** | `aspect-square` | Logo, Avatar Guru, Thumbnail Media Manager, Icon Box | Logo Sekolah, Grid Media Manager, Foto Avatar |
| **3:4 (Portrait)** | `aspect-[3/4]` | Foto Pejabat, Sambutan Kepsek, Kartu Guru/Staf Formal | Sambutan Beranda, Struktur Organisasi, Profil Guru |
| **4:3 (Landscape Standar)** | `aspect-[4/3]` | Fasilitas, Jurusan / Program Keahlian, Ekstrakurikuler | Kartu Jurusan, Galeri Foto Fasilitas, Prestasi Siswa |
| **16:9 (Widescreen)** | `aspect-video` / `aspect-[16/9]` | Berita, Pengumuman, Agenda, Thumbnail YouTube/Video | Kartu Berita, Artikel Populer, Video Dokumentasi |
| **21:9 / Hero Banner** | `aspect-[21/9]` atau tinggi adaptif | Hero Carousel Slider Beranda, Header Banner Halaman | Hero Slider Halaman Depan, Banner Profil |

---

## 2. Aturan Border Radius & Shadow Token

- **Kartu & Card Media:** Wajib `rounded-2xl` (16px) dengan `overflow-hidden`.
- **Thumbnail Grid & Picker Modal:** Wajib `rounded-xl` (12px) dengan `overflow-hidden`.
- **Avatar Guru / User:** `rounded-full` (lingkaran) atau `rounded-2xl` (squircle).
- **Border Outline:** `border border-slate-200/80` (terang) atau `border-white/10` (gelap/overlay).

---

## 3. Standar Framing Anti-Distorsi & Anti-Freeze (Ambient Backdrop Pattern)

Jika foto yang diunggah pengguna memiliki rasio asli yang berbeda dengan kartu tujuan, **DILARANG** membiarkan sisi kosong hitam/putih kaku atau memaksa gambar melar (*stretched/distorted*).

Gunakan pola baku **Double Layer Ambient Backdrop**:

```blade
<!-- Kontainer Kartu dengan Rasio Baku -->
<div class="aspect-[3/4] rounded-2xl overflow-hidden relative bg-slate-900 flex items-center justify-center">
    
    <!-- Lapis 1: Ambient Blurred Backdrop (Mengisi sisa ruang secara dinamis) -->
    <img src="{{ $fotoUrl }}" 
         alt="" 
         aria-hidden="true" 
         class="absolute inset-0 w-full h-full object-cover blur-md scale-125 opacity-40 pointer-events-none">
    
    <!-- Lapis 2: Foto Utama dengan Smart Crop Style -->
    <img src="{{ $fotoUrl }}" 
         alt="{{ $judul }}" 
         style="{{ \App\Services\MediaService::getCropStyle($fotoUrl) }}"
         class="relative z-10 w-full h-full object-cover">
         
</div>
```

---

## 4. Checklist Kepatuhan Sebelum Rilis Tampilan Baru
1. [ ] Apakah kontainer media memakai salah satu dari 5 rasio baku di atas?
2. [ ] Apakah sudah menggunakan `overflow-hidden` dan `rounded-2xl` / `rounded-xl`?
3. [ ] Apakah foto membaca `$media->smart_crop_style` atau `MediaService::getCropStyle($url)`?
4. [ ] Apakah terdapat ambient blurred backdrop untuk mencegah letterboxing hitam/putih?
5. [ ] Apakah tampilan sudah responsif pada mobile (<640px) hingga desktop tanpa horizontal overflow?
