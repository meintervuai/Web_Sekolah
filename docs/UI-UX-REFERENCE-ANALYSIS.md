# UI/UX Reference Analysis

## 1. Daftar Website Referensi
- https://smkn2solo.sch.id/ (Dianalisis)
- https://smkn1batang.sch.id/ (Dianalisis)
- https://smk17smg.sch.id/galeri/galeri-foto/ (Dianalisis)

## 2. Ringkasan Setiap Website
### SMKN 2 Surakarta (https://smkn2solo.sch.id/)
- **Kesan Pertama**: Menonjolkan pilar sekolah ("Mendunia dan Berbudaya") dengan *hero image* yang besar dan teks bold.
- **Warna & Tipografi**: Menggunakan palet biru kuat (mirip `#277ac0`) di navbar dan tombol CTA, dengan teks putih sebagai kontras. Font Sans-Serif dengan tingkat ketebalan yang tegas.
- **Struktur**: Navigasi atas yang jelas dengan pencarian icon di kanan.

### SMKN 1 Batang (https://smkn1batang.sch.id/)
- **Kesan Pertama**: Menonjolkan prestasi dengan nuansa warna modern (dominan warna yang kontras dengan putih) serta penyajian berita/pengumuman yang rapi.
- **Warna & Tipografi**: Palet bersih (clean) yang memastikan teks lebih terbaca. Header berukuran besar.
- **Struktur**: Menggunakan card-layout untuk konten berita dan program keahlian.
- **Interaksi**: Animasi *hover* pada card artikel dan galeri, memberikan umpan balik visual yang jelas.

### SMK 17 Semarang (https://smk17smg.sch.id/galeri/galeri-foto/)
- **Kesan Pertama**: Fokus pada penyajian media visual dan dokumentasi kegiatan.
- **Warna & Tipografi**: Gaya *minimalist* agar gambar galeri lebih menonjol dibandingkan teks.
- **Struktur**: *Grid layout* responsif untuk menampilkan thumbnail foto.
- **Interaksi**: Fitur *lightbox* atau modal saat gambar di-klik, sangat ramah pengguna.

## 3. Perbandingan Aspek UI/UX
### A. Struktur Informasi
- **SMKN 2 Solo**: Pendekatan *landing page* standar dengan hero section besar.
- **SMKN 1 Batang**: Struktur modular menggunakan komponen kartu (card) untuk memisahkan informasi (berita, program, pengumuman).
- **SMK 17 Semarang (Galeri)**: Struktur grid yang memaksimalkan area layar untuk media gambar.

### B. Navigasi
- **Desktop**: Ketiga website tidak menggunakan *burger menu* di desktop, memastikan link utama mudah diakses dalam satu klik (Home, Profil, Program, Berita, Galeri).
- **Mobile**: Otomatis beralih ke struktur dropdown/*offcanvas* atau *burger menu* agar sesuai dengan ukuran layar sentuh.

### C. Visual & Interaksi (Animasi)
- **Hover States**: SMKN 1 Batang memiliki hover state yang memperjelas area klik (misal: tombol sedikit naik atau berubah warna).
- **Transisi**: Perpindahan halaman cukup cepat. Namun, di Galeri SMK 17, efek *fade-in* saat memuat gambar memberi kesan elegan.

### D. Mobile Experience
- **Responsivitas**: Semua situs menunjukkan kemampuan mengubah grid kolom-kolom (misalnya 3 kolom atau 4 kolom) menjadi 1 kolom yang memanjang ke bawah pada versi mobile.

## 4. Kelebihan dan Kekurangan Umum
### Kelebihan
- Penggunaan warna identitas sekolah secara konsisten.
- Kontras warna yang baik di bagian header dan tombol CTA.
- Mobile-first approach yang cukup terlihat pada pengelompokan konten vertikal.

### Kekurangan
- Terkadang hierarki font pada halaman artikel detail kurang jelas.
- Beberapa transisi statis, bisa lebih interaktif lagi dengan *micro-animations*.

## 5. Temuan yang Bisa Dipelajari (Rekomendasi Desain)
1. **Tidak ada burger menu di desktop**: Tampilkan seluruh menu navigasi secara horizontal.
2. **Gunakan Grid System & Cards**: Sangat cocok untuk menampilkan Program Keahlian, Berita, dan Galeri agar terlihat rapi dan seragam.
3. **Micro-animations**: Tambahkan transisi CSS pada elemen interaktif seperti kartu artikel (transform: translateY(-5px) on hover) dan modal lightbox galeri.
4. **Hero Image yang Kuat**: Hero section di homepage sebaiknya full-width dengan *overlay* tipis agar teks yang di atasnya tetap terbaca.
5. **Palet Warna Profesional**: Gunakan warna sekolah sebagai warna aksen utama, didukung warna netral (slate/gray) untuk teks dan background section.

