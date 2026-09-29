# Arsitektur CSS Tema & Auto-Kontras Portal Publik

**File terkait:** `resources/css/public.css`, `resources/views/layouts/public.blade.php`, `app/Support/WarnaKontras.php`, `resources/views/tenant/admin/pengaturan/index.blade.php`.
**Rule operasional (checklist kerja):** `.ai/rules/publik-tema-kontras.md`.
**Aturan desain:** `docs/05-UI-UX.md`.

Referensi teknis: siapa mengirim warna, variabel apa yang tersedia, scope mana yang sudah dilindungi, dan resep menulis menu / halaman / section baru supaya otomatis lolos kontras.

---

## 1. Alur warna dari database ke piksel

```
pengaturan_umum (DB tenant, 13 kunci warna)
        |  PengaturanUmum::ambil()
        v
HomeController / PageController ::getSekolahData()   -> array $sekolah['warna_*']
        |
        v
layouts/public.blade.php
   |- @php  $kontras = fn (bg, panel, min) => WarnaKontras::pilihTeks(...)
   |- <style> :root { 13 var panel + 16 var --theme-fg-* (hex final) }
        |
        v
resources/css/public.css
   |- @property --kontras-aman / --kontras-terang (boolean 0|1)
   |- blok "SCOPE AUTO-KONTRAS PER PERMUKAAN": ulang --theme-heading,
   |  --theme-text, --theme-text-muted, --theme-fg-link, --fg-zona-efektif
   |  di tiap permukaan memakai calc(... contrast(...) >= N)
        |
        v
Kelas .theme-* di view  ->  teks terbaca di preset warna apa pun
```

Dua lapis ini sengaja. Lapis PHP menjamin kontras benar di semua browser. Lapis CSS menahan kasus yang tidak lewat server: override DevTools, ekstensi dark mode, JS pihak ketiga, atau kombinasi warna di luar hitungan awal.

## 2. Helper `App\Support\WarnaKontras`

| Method | Signature | Hasil |
|--------|-----------|-------|
| `luminans` | `(string $hex): float` | Luminans relatif WCAG 2.1 (0..1). Hex 3/6 digit diterima; format tak dikenal = `1.0` (dianggap terang, agar teks tidak pernah ikut hilang). |
| `rasio` | `(string $a, string $b): float` | Rasio kontras simetris, 1..21. |
| `pilihTeks` | `(string $bg, string $pilihanPanel, float $min = 4.5, array $kandidat = [PUTIH, TINTA]): string` | Kembalikan `$pilihanPanel` bila `rasio($bg, $pilihanPanel) >= $min`; jika tidak, argmax kontras terhadap `$kandidat` (tie-break: putih lebih dulu). |
| `campurWarna` | `(string $a, string $b, int $porsiA): string` | Interpolasi sRGB linear, `$porsiA` 0..100 porsi warna A. Dipakai untuk latar badge (aksen 15% + latar halaman). |
| Konstanta | `PUTIH='#FFFFFF'`, `TINTA='#0F172A'`, `MIN_KONTRAS=4.5` | Pemakaian di luar tema publik (email, PDF) wajib memanggil helper ini, bukan menghitung ulang di Blade. |

## 3. Inventaris variabel

### 3.1 Kunci panel (13, dari panel Tema & Warna)
`--theme-color`, `--theme-accent`, `--theme-heading`, `--theme-text`, `--theme-text-muted`, `--theme-page-bg`, `--theme-section-bg`, `--theme-card-bg`, `--theme-border`, `--theme-btn-bg`, `--theme-btn-text`, `--theme-header-bg`, `--theme-footer-bg`.

Turunan otomatis di `:root`: `--theme-color-dark`, `--theme-color-light`, `--theme-color-transparent`, `--theme-neutral-50..950`, `--theme-accent-400`.

### 3.2 Kunci hasil auto-kontras (16, dihitung server)
| Variabel | Latar acuan | Usulan awal | Ambang |
|----------|-------------|-------------|--------|
| `--theme-fg-halaman-heading` | `--theme-page-bg` | `warna_judul` | 4.5 |
| `--theme-fg-halaman-text` | `--theme-page-bg` | `warna_teks` | 4.5 |
| `--theme-fg-halaman-muted` | `--theme-page-bg` | `warna_teks_sekunder` | 4.5 |
| `--theme-fg-section-heading` | `--theme-section-bg` | `warna_judul` | 4.5 |
| `--theme-fg-section-text` | `--theme-section-bg` | `warna_teks` | 4.5 |
| `--theme-fg-section-muted` | `--theme-section-bg` | `warna_teks_sekunder` | 4.5 |
| `--theme-fg-kartu-heading` | `--theme-card-bg` | `warna_judul` | 4.5 |
| `--theme-fg-kartu-text` | `--theme-card-bg` | `warna_teks` | 4.5 |
| `--theme-fg-kartu-muted` | `--theme-card-bg` | `warna_teks_sekunder` | 4.5 |
| `--theme-fg-header` | `--theme-header-bg` | `warna_tombol_teks` | 4.5 |
| `--theme-fg-footer` | `--theme-footer-bg` | `warna_tombol_teks` | 4.5 |
| `--theme-fg-zona` | `--theme-color` | `warna_tombol_teks` | 4.5 |
| `--theme-fg-tombol` | `--theme-btn-bg` | `warna_tombol_teks` | 3.0 |
| `--theme-fg-aksen` | `--theme-accent` | `warna_tombol_teks` | 3.0 |
| `--theme-fg-badge` | `campurWarna(aksen, halaman, 15)` | `campurWarna(tema, hitam, 85)` | 4.5 |
| `--theme-fg-link` | `--theme-page-bg` | `warna_aksen` | 2.0 |

### 3.3 Variabel internal scope
| Variabel | Tipe | Fungsi |
|----------|------|--------|
| `--kontras-aman` | `@property <number>`, initial `1`, tidak inherit | `1` bila `fg contrast bg >= 4.5`, selain itu `0`. |
| `--kontras-terang` | `@property <number>`, initial `1`, tidak inherit | `1` bila latar cukup gelap untuk teks putih (`#FFFFFF contrast bg >= 3`). |
| `--fallback-teks` | warna | Putih bila latar gelap, tinta `#0F172A` bila latar terang. |
| `--fg-zona-efektif` | warna | Warna teks "zona" yang nilainya beda per scope (lihat tabel 4). Aturan teks zona gelap membacanya lewat `color-mix(... 88%, transparent)`. |

Urutan penulisan dalam blok scope selalu: `--kontras-aman`, `--kontras-terang`, `--fallback-teks`, `--fg-zona-efektif`, baru penimpaan `--theme-heading|text|text-muted|fg-link`.

## 4. Registri scope auto-kontras (`resources/css/public.css`)

| # | Selector | Latar acuan | Perilaku |
|---|----------|-------------|----------|
| 0 | `:root` | - | `--fg-zona-efektif: var(--theme-fg-zona)` (fallback global). |
| 1 | `.theme-page-bg` | `--theme-page-bg` | Resolver penuh heading / text / muted / link. |
| 2 | `.theme-section-bg`, `.theme-surface-alt`, `.bg-slate-50`, `.bg-slate-50/80`, `.bg-slate-100`, `.bg-slate-100/80`, `.bg-slate-200`, `.bg-gray-50`, `.bg-gray-100` | `--theme-section-bg` | Resolver penuh. |
| 3 | `.theme-card`, `.bg-white`, `.bg-white/95`, `.bg-white/90` | `--theme-card-bg` | Resolver penuh + `--color-white` ikut di-resolve; `--fg-zona-efektif` dipaksa tinta (isi kartu terang). |
| 4 | `.theme-badge`, `.theme-icon-box`, `.bg-blue-50/100`, `.bg-sky-50/100`, `.bg-amber-50/100`, `.bg-indigo-50/100` | terang muda (aksen 12-15% + latar halaman) | Semua slot teks = `--theme-fg-badge`, sehingga pill tetap terbaca di dalam kartu gelap. |
| 5 | `.theme-bg`, `.theme-bg-dark`, `.theme-bg-darker`, `.bg-hero-gradient`, `.public-hero-gradient`, `[class*="bg-blue-950"]`, `[class*="bg-blue-900"]`, `[class*="bg-slate-900"]`, `[class*="bg-slate-800"]` | `--theme-color` | `--fg-zona-efektif: var(--theme-fg-zona)`. |
| 6 | `.theme-header`, `header.theme-bg` | `--theme-header-bg` | Resolver + `--color-white` dan `--color-blue-50` ikut di-resolve (kotak logo & top bar ikut warna header). |
| 7 | `.theme-footer`, `footer.theme-bg` | `--theme-footer-bg` | Resolver + `--color-white`. |

Keputusan kontras selalu **per permukaan**: kartu hijau tua tidak mengubah footer, header terang tidak mengubah kartu.

## 5. Inventaris kelas tampilan publik

| Kelas | Efek |
|-------|------|
| `.theme-page-bg`, `.theme-section-bg`, `.theme-surface-alt`, `.theme-card` | Latar permukaan (+ border pada kartu). |
| `.theme-heading`, `.theme-text-body`, `.theme-text-muted`, `.theme-link` | Warna teks dari variabel ter-scope. |
| `.theme-badge`, `.theme-icon-box`, `.theme-accent-bg` | Pill, kotak ikon, blok aksen; teks sudah ikut dihitung. |
| `.theme-btn-primary`, `.theme-btn-outline`, `.theme-btn-ghost` | Tombol; teks pakai `--theme-fg-tombol` / `--theme-fg-section-heading`. |
| `.theme-bg`, `.theme-bg-dark`, `.theme-bg-darker`, `.bg-hero-gradient`, `.public-hero-gradient` | Zona gelap berbasis warna identitas. |
| `.theme-header`, `.theme-footer` | Latar header/footer + scope kontras sendiri. |
| `.theme-table-head`, `.theme-table-row` | Tabel. |
| `.theme-input` | Input dengan latar kartu, border & ring berbasis aksen. |
| `.theme-border`, `.theme-divider`, `.theme-divide-x`, `.theme-divide-y` | Garis. |
| `.card-radius` (16px), `.btn-radius` (10px) | Radius baku, terpisah dari warna. |

Kelas Tailwind warna lama (`text-slate-*`, `bg-blue-*`, `text-white`, dst.) dipetakan ulang ke variabel tema di blok `THEME COLOR OVERRIDES` + `--color-*`. Mapping itu warisan; **kode baru cukup pakai `.theme-*`**.

> [!NOTE]
> **Pengecualian Identitas Merek Pihak Ketiga**:
> Aset atau tombol pihak ketiga seperti tombol mengambang resmi WhatsApp (`#25D366` / hover `#20ba5a`), YouTube (`#FF0000`), dan Google Maps sengaja dikecualikan dari manipulasi tema warna sekolah agar identitas resmi merek pihak ketiga tetap konsisten dan langsung dikenali pengunjung.

## 6. Resep cepat

| Tugas | Yang dilakukan |
|-------|----------------|
| Tambah menu navigasi | Insert data di tabel tenant `menu` (`name`, `url` relatif, `parent_id`, `urutan`, `is_aktif`, `type`) + seed. Detail dan jebakan namanya ada di `.ai/rules/publik-tema-kontras.md` bagian 2. |
| Tambah halaman publik | Route di grup `{tenant}` -> method controller pakai `getSekolahData()` -> view `@extends('layouts.public')` dengan kelas `.theme-*` -> test. |
| Tambah section di halaman lama | Bungkus dengan `.theme-section-bg` atau `.theme-surface-alt`; judul `.theme-heading`; isi `.theme-text-body`; metadata `.theme-text-muted`. |
| Tambah kartu | `.theme-card card-radius border p-6`. Teks di dalamnya otomatis menyesuaikan, tidak perlu warna. |
| Tambah badge / label | `.theme-badge px-3 py-1 rounded-full text-xs font-semibold`. |
| Tambah tombol | `.theme-btn-primary btn-radius px-5 py-2.5 text-sm font-semibold` (sekunder: `.theme-btn-ghost`). |
| Tambah panel berwarna identitas | `.theme-bg` / `.theme-bg-dark`; teks di dalamnya biarkan tanpa kelas warna, aturan zona gelap yang menangani. |
| Butuh latar baru | `color-mix()` berbasis variabel, atau daftarkan scope baru memakai template 8 baris di rule bagian 4.3. |
| Tambah kunci warna baru | Enam titik sinkronisasi: seeder/migrasi, `PengaturanController`, `getSekolahData()` + `HomeController`, `layouts/public.blade.php`, `public.css`, JS pratinjau admin. |

## 7. Fallback & dukungan browser

- Browser tanpa `@property` / `contrast()` (mis. Chrome < 119, Safari < 16.4) mengabaikan blok scope; yang tersisa adalah warna hasil perhitungan server. Tampilan tetap benar, hanya lapisan pengamannya tidak aktif.
- Karena itu **jangan** menghapus atau melemahkan perhitungan PHP demi CSS, dan sebaliknya.
- Nilai `--kontras-aman` / `--kontras-terang` di luar dukungan bernilai invalid, sehingga `color-mix(... calc(100% * invalid), ...)` ikut diabaikan dan nilai awal variabel tetap dipakai (initial-value `1` = pakai nilai server).

## 8. Verifikasi

```bash
vendor/bin/pest tests/Unit/WarnaKontrasTest.php
vendor/bin/pest tests/Feature/TenantThemeColorTest.php
npm run build
```

```powershell
# compiled CSS harus masih membawa mekanismenya
$c = Get-Content (Get-ChildItem public/build/assets/public-*.css | Sort-Object LastWriteTime -Descending | Select-Object -First 1) -Raw
([regex]::Matches($c,'@property')).Count          # >= 2
([regex]::Matches($c,'contrast\(')).Count         # >= 11
([regex]::Matches($c,'--fg-zona-efektif')).Count  # bertambah saat scope baru ditambah
```

Uji manual: buka `/{tenant}/berita`, ganti kartu ke warna gelap di *Admin > Pengaturan > Tema & Warna*, pastikan judul dan isi kartu menjadi putih sementara badge/pill tetap gelap, lalu cek nav dan footer tidak ikut berubah.

