# Product Requirements Document (PRD) — Revisi Web Sekolah

**Nama Proyek:** Website Sekolah Multi-Tenant & CMS Sekolah  
**Versi:** 2.0.0 (Fase 1: Implementasi Publik SMK Negeri 2 Bandung)  
**Dokumen Terkait:** [02-ARCHITECTURE.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/02-ARCHITECTURE.md) | [03-DATABASE.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/03-DATABASE.md) | [04-ROUTES-OR-API.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/04-ROUTES-OR-API.md) | [05-UI-UX.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/05-UI-UX.md) | [06-CHANGELOG.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/06-CHANGELOG.md) | [07-IMPLEMENTATION-CHECKLIST.md](file:///c:/Users/r/Documents/Magang/website_sekolah/docs/07-IMPLEMENTATION-CHECKLIST.md)

---

## 1. Tujuan Utama & Scope Fase 1

Membangun ulang website sekolah sebagai platform CMS sekolah yang modern, responsif, cepat, accessible, dan mudah dikelola admin. Fokus fase pertama adalah menghadirkan **seluruh halaman publik secara end-to-end tanpa ada halaman kosong** menggunakan data rujukan resmi **SMK Negeri 2 Bandung**.

### Data Rujukan Resmi SMK Negeri 2 Bandung
- **Nama Sekolah:** SMK Negeri 2 Bandung
- **Alamat:** Jl. Ciliwung No. 4, Bandung Wetan, Kota Bandung, Jawa Barat 40114
- **NPSN:** 20219146
- **Akreditasi:** A
- **Kontak:** Telepon (022) 7234285, Email: `humas@smkn2bandung.sch.id`
- **Statistik Resmi:** 98 Guru & Tendik, 1.972 Siswa, 54 Rombel, 41 Ruang Kelas, 1 Laboratorium, 1 Perpustakaan (disertai label sumber & tahun).

---

## 2. 14 Halaman Publik Wajib (Tidak Boleh Kosong)

1. **`/` Beranda:** Hero carousel (pause on hover, swipe mobile, reduced-motion support), quick links, sambutan kepala sekolah, profil singkat, counter statistik interaktif, katalog jurusan, berita terbaru, pengumuman penting, agenda, prestasi, ekskul, galeri preview, CTA SPMB, lokasi/kontak.
2. **`/profil`:** Profil sekolah, sejarah, visi-misi-tujuan, sambutan kepala sekolah, struktur organisasi, akreditasi, statistik.
3. **`/program-keahlian` & `/program-keahlian/{slug}`:** 7 program keahlian resmi SMK Negeri 2 Bandung (Teknik Mesin, Teknik Pengelasan & Fabrikasi Logam, PPLG, TJKT, DKV, Animasi, Desain Gambar Mesin).
4. **`/berita` & `/berita/{slug}`:** Minimal 6 berita dengan kategori, tanggal, pencarian, dan artikel detail + related posts.
5. **`/agenda` & `/agenda/{slug}`:** Minimal 4 agenda dengan kalender/list, tanggal, jam, lokasi, detail kegiatan, link pendaftaran.
6. **`/pengumuman` & `/pengumuman/{slug}`:** Minimal 4 pengumuman penting dengan masa berlaku, target audiens, dan berkas/lampiran.
7. **`/prestasi` & `/prestasi/{slug}`:** Minimal 6 prestasi dengan filter tingkat, tahun, nama siswa, foto/sertifikat.
8. **`/kegiatan`:** Rangkaian dokumentasi aktivitas sekolah dengan galeri dan deskripsi.
9. **`/ekstrakurikuler` & `/ekstrakurikuler/{slug}`:** Minimal 8 ekskul dengan pembina, jadwal latihan, lokasi, dan galeri.
10. **`/guru-staf`:** Direktori 8 guru & tenaga kependidikan dengan NIP, mata pelajaran, foto, dan filter pencarian.
11. **`/fasilitas`:** Minimal 6 fasilitas sekolah dengan gambar rasio 4:3 dan deskripsi fungsi.
12. **`/galeri`:** Minimal 3 album galeri dengan grid responsive, filter kategori, dan modal lightbox.
13. **`/spmb`:** Halaman PPDB/SPMB lengkap dengan periode, alur, jalur, syarat, dokumen, jadwal, dan link pendaftaran eksternal/internal.
14. **`/kontak`:** Informasi kontak, jam operasional layanan, peta interaktif embed, dan formulir pengiriman pesan tervalidasi yang tersimpan ke database `pesan_masuk`.

---

## 3. Prinsip Wajib & Feature Toggle
- Setiap modul terhubung ke tabel `pengaturan_fitur`. Jika fitur nonaktif, navbar item, homepage section, dan rute publik mengembalikan status 404 (tidak boleh ada halaman kosong atau broken link).
- Konten hanya tampil jika berstatus `published` (`draft` tidak muncul di publik).
- Aksesibilitas WCAG AA, responsive mobile-first, dan loading/empty/error states tersedia untuk setiap listing.
