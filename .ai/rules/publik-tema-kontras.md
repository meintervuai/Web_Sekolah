# Rule: Tema & Auto-Kontras CSS Portal Publik

**Tipe:** wajib / blocking
**Cakupan:**
- `resources/css/public.css`
- `resources/views/layouts/public.blade.php`
- `resources/views/public/**` (beranda, halaman, partial)
- `app/Http/Controllers/Tenant/Public/**`
- `routes/web.php` grup `Route::prefix('{tenant}')`
- `app/Support/WarnaKontras.php`
- `resources/views/tenant/admin/pengaturan/index.blade.php` (pratinjau tema)
- `database/seeders/**` bagian data `menu`

Referensi detail: `docs/08-CSS-ARSITEKTUR-TEMA.md`.

---

## 0. Inti konsep yang tidak boleh dilanggar

Portal publik punya **satu sumber warna**: 13 kunci palet dari panel *Tema & Warna* (`pengaturan_umum`), diinjeksi jadi CSS variable di `:root` oleh `layouts/public.blade.php`.

Teks **tidak pernah** ditulis dengan warna literal. Warna teks dihitung dari luminans latar tempat teks itu berada, lewat dua lapis:

| Lapis | Lokasi | Sifat | Cara kerja |
|-------|--------|-------|------------|
| 1. Server (authoritative) | `app/Support/WarnaKontras.php` dipanggil closure `$kontras()` di `layouts/public.blade.php` | Always on, semua browser | Menghasilkan 16 variabel `--theme-fg-*` berisi hex final per permukaan. Warna usulan admin dipakai bila lolos ambang kontras, selain itu putih / tinta `#0F172A` (argmax). |
| 2. CSS (safety net) | blok `SCOPE AUTO-KONTRAS PER PERMUKAAN` di `resources/css/public.css` | Browser dengan dukungan `@property` + `contrast()` | `@property --kontras-aman` / `--kontras-terang` dipakai sebagai boolean, dihitung dengan `calc(var(--fg) contrast(var(--bg)) >= N)`, lalu `color-mix()` memilih antara nilai server dan fallback. Menyelamatkan kasus override lewat DevTools, ekstensi, JS, atau warna yang belum terhitung server. |

Konsekuensi praktis: **selama markup memakai kelas `.theme-*`, teks otomatis terbaca** di preset apa pun (`navy_classic`, `emerald_nature`, `slate_dark`, dst.) tanpa perlu `if/else` warna di Blade.

Ambang yang dipakai (jangan diubah tanpa alasan WCAG):
- teks isi / judul: **4.5:1**
- teks tombol / teks besar: **3.0:1**
- tautan (bergaris bawah): **2.0:1**

---

## 1. Aturan menulis markup publik (WAJIB)

### 1.1 Boleh: pakai kelas tema
| Kebutuhan | Kelas yang dipakai |
|-----------|--------------------|
| Latar halaman (sudah di `<body>`) | `.theme-page-bg` |
| Latar section selang-seling | `.theme-section-bg`, `.theme-surface-alt` |
| Kartu / panel / box konten | `.theme-card` (+ `.card-radius`) |
| Judul (h1-h6) | `.theme-heading` |
| Teks isi | `.theme-text-body` |
| Teks sekunder / metadata | `.theme-text-muted` |
| Tautan teks | `.theme-link` |
| Pill / label kecil | `.theme-badge` |
| Kotak ikon | `.theme-icon-box` |
| Tombol utama | `.theme-btn-primary` (+ `.btn-radius`) |
| Tombol sekunder | `.theme-btn-ghost`, `.theme-btn-outline` |
| Zona gelap (hero, panel identitas) | `.theme-bg`, `.theme-bg-dark`, `.bg-hero-gradient` |
| Header / footer | `.theme-header`, `.theme-footer` |
| Tabel | `.theme-table-head`, `.theme-table-row` |
| Form | `.theme-input` |
| Garis / pemisah | `.theme-border`, `.theme-divider`, `.theme-divide-x`, `.theme-divide-y` |
| Background aksen solid | `.theme-accent-bg` |

Layout kelas Tailwind (`grid`, `flex`, `py-*`, `rounded-*`, `text-lg`, `font-semibold`, `shadow-*`) bebas dipakai. Yang diatur hanya **warna**.

### 1.2 Dilarang
1. **Warna literal di markup baru**: `text-white`, `text-slate-700`, `bg-white`, `bg-blue-900`, `#25D366`, `rgba(...)`, `color: #fff` di `style=""` atau `@section('styles')`.
   - Kelas berwarna lama masih ditoleransi karena sudah dipetakan ulang di `public.css` (`--color-*` override + Legacy Utility Mapping), tapi **kode baru wajib memakai `.theme-*`** supaya tidak menambah beban pemetaan.
2. **`color: var(--theme-btn-text)` langsung** di komponen. `--theme-btn-text` adalah *usulan* admin, bukan hasil akhir. Yang dibaca komponen: `--theme-fg-tombol`, `--theme-fg-aksen`, `--theme-fg-badge`, `--theme-fg-header`, `--theme-fg-footer`, `--theme-fg-zona`, `--fg-zona-efektif`.
3. **Menulis ulang `--theme-heading` / `--theme-text` / `--theme-text-muted` di dalam view** (inline style atau `@section('styles')`). Variabel ini dimiliki scope permukaan, bukan view.
4. **Menambah file CSS baru** atau `<link>` stylesheet sendiri. Semua style publik masuk `resources/css/public.css`.
5. **`window.confirm()` / `window.alert()`** untuk aksi destruktif; pakai modal Alpine sesuai `AGENTS.md` bagian 12.
6. **Menghapus `focus:` / `outline`** tanpa pengganti. Focus ring aksen: `--tw-ring-color: color-mix(in srgb, var(--theme-accent) 25%, transparent)`.

### 1.3 Setiap permukaan harus berada di scope terdaftar
Sebelum menulis section baru, tentukan latarnya:

| Latar yang dipakai | Scope auto-kontras yang sudah aktif |
|--------------------|-------------------------------------|
| `<body>` / latar halaman | `.theme-page-bg` (sudah terpasang di layout) |
| `--theme-section-bg` | `.theme-section-bg`, `.theme-surface-alt`, `.bg-slate-50/100/200` |
| `--theme-card-bg` | `.theme-card`, `.bg-white`, `.bg-white/90`, `.bg-white/95` |
| Latar terang muda (badge) | `.theme-badge`, `.theme-icon-box`, `.bg-blue-50/100`, `.bg-amber-50/100`, `.bg-indigo-50/100`, `.bg-sky-50/100` |
| Latar identitas gelap | `.theme-bg`, `.theme-bg-dark`, `.theme-bg-darker`, `.bg-hero-gradient`, `[class*="bg-blue-950/900"]`, `[class*="bg-slate-900/800"]` |
| Header | `.theme-header` |
| Footer | `.theme-footer`, `footer.theme-bg` |

Butuh latar yang tidak ada di tabel? Daftarkan scope baru (lihat 4.3), jangan diam-diam pakai warna lepas.

---

## 2. SOP tambah menu navigasi publik

Menu publik dibaca dari tabel tenant `menu` (`App\Models\Tenant\Menu`), bukan dari array di layout. Kolom: `name`, `url`, `parent_id`, `urutan`, `is_aktif`, `type` (`link` | `dropdown`).

Layout (`layouts/public.blade.php` sekitar baris 181-216) melakukan:
1. `$navMenus = $menus ?? Menu::whereNull('parent_id')->where('is_aktif', true)->with('children')->orderBy('urutan')->get()`;
2. menolak menu/child yang namanya mengandung `spmb`;
3. menyembunyikan child bernama `Profil Lengkap` dan `Semua Program Keahlian`;
4. memaksa URL `/profil` untuk menu bernama `Profil`/`Profil Sekolah` dan `/program-keahlian` untuk `Program Keahlian`;
5. menandai aktif dengan `$isPathActive()` (prefix match terhadap path relatif tenant).

Karena itu, saat menambah menu baru:

```php
// lewat seeder tenant (contoh: database/seeders/TenantSmkn2BandungSeeder.php)
\App\Models\Tenant\Menu::create([
    'name'     => 'Hubungi Kami',
    'url'      => '/kontak',
    'parent_id' => null,      // atau id menu induk untuk dropdown
    'urutan'   => 15,
    'is_aktif' => true,
    'type'     => 'link',     // 'dropdown' bila punya children
]);
```

Checklist:
- [ ] `url` **relatif tanpa slug tenant** (`/kontak`, bukan `/smk-negeri-2-bandung/kontak`); layout sudah menempelkan `$tenantSlug`.
- [ ] Nama menu **tidak** mengandung kata `spmb`, dan tidak memakai nama persis `Profil`, `Profil Sekolah`, `Program Keahlian` (URL-nya akan ditimpa layout), kecuali memang itu menu yang dimaksud.
- [ ] `type` dropdown hanya bila ada child aktif; parent dropdown boleh `url` = `'#'`.
- [ ] Tambahkan seed di **semua seeder tenant** yang aktif agar tenant baru ikut punya menu.
- [ ] Kalau halaman baru perlu disembunyikan dari nav, cukup `is_aktif = false` dan tauti dari tombol/CTA.
- [ ] Verifikasi: `php artisan tinker --execute="dump(\App\Models\Tenant\Menu::whereNull('parent_id')->orderBy('urutan')->pluck('name','url'))"` dengan koneksi tenant, lalu buka halaman dan cek item muncul + state aktif benar di mobile drawer.

Dropdown mobile memakai drawer Alpine yang sudah ada; **tidak boleh** membuat markup nav baru, item baru ikut `@foreach($navMenus ...)`.

## 3. SOP tambah halaman publik

Empat perubahan, urutan tetap: route -> controller -> view -> (opsional) menu + test.

### 3.1 Route
Masuk ke grup tenant yang sudah ada di `routes/web.php` (nama route wajib berawalan `tenant.`):

```php
Route::get('/humas', [PageController::class, 'humas'])->name('tenant.humas');
```

Jangan menambah route publik di luar `Route::prefix('{tenant}')->middleware(TenantMiddleware::class)`; tanpa middleware itu koneksi tenant tidak dipindahkan dan `PengaturanUmum` akan error.

### 3.2 Controller
Pakai ulang `PageController::getSekolahData()` (private, berisi 13 kunci warna + identitas sekolah):

```php
public function humas()
{
    return view('public.pages.humas', [
        'sekolah' => $this->getSekolahData(),
        'berita'  => Post::aktif()->latest()->take(6)->get(),
    ]);
}
```

- `$sekolah` **wajib** dikirim; layout memakai fallback default `?? '#1E3A8A'` sehingga kunci yang lupa dikirim tidak error, tapi warnanya diam-diam kembali ke preset navy. Kalau menambah kunci warna baru, tambahkan juga di `PageController::getSekolahData()` **dan** `HomeController` (keduanya sekarang memuat 13 kunci).
- `$menus` tidak perlu dikirim: layout otomatis query tabel `menu`. Kirim `$menus` hanya bila halaman punya navigasi khusus.

### 3.3 View
```blade
@extends('layouts.public')

@section('title', 'Hubungi Kami')
@section('meta_description', 'Kontak dan kanal pengaduan SMK Negeri 2 Bandung.')

@section('content')
    <section class="theme-section-bg py-14">
        <div class="container-custom">
            <span class="theme-badge px-3 py-1 rounded-full text-xs font-semibold">Layanan</span>
            <h1 class="theme-heading font-heading font-extrabold text-3xl mt-4">Hubungi Kami</h1>
            <p class="theme-text-muted mt-3 leading-relaxed">Kirim pertanyaan lewat formulir atau nomor WhatsApp di bawah.</p>

            <div class="theme-card card-radius border p-6 mt-8">
                <h2 class="theme-heading font-bold text-lg">Formulir Pesan</h2>
                <input type="text" class="theme-input w-full rounded-lg px-4 py-2.5 mt-4" placeholder="Nama lengkap">
                <button type="submit" class="theme-btn-primary btn-radius px-5 py-2.5 mt-4 text-sm font-semibold">
                    Kirim Pesan
                </button>
            </div>
        </div>
    </section>
@endsection
```

Aturan wajib view baru:
1. `<section>` pembungkus memakai salah satu latar terdaftar (`.theme-page-bg` tidak perlu ditulis, sudah di `<body>`).
2. Judul `.theme-heading`, isi `.theme-text-body`, metadata `.theme-text-muted`, kartu `.theme-card card-radius border`, tombol `.theme-btn-primary btn-radius`.
3. Warna dekorasi (garis, dot pattern, glow) pakai `color-mix(in srgb, var(--theme-*) N%, var(--theme-page-bg))`, bukan hex.
4. Loading / empty / error state tetap wajib sesuai `AGENTS.md` 11-12, tapi warnanya tetap kelas `.theme-*`.
5. Tidak ada `href="#"` mati dan tidak ada teks placeholder.

### 3.4 Test
Tambahkan skenario di `tests/Feature/TenantPublicPagesTest.php` (assert 200 + string khas halaman). Kalau halaman menambah permukaan warna baru, tambahkan assertion variabel di `tests/Feature/TenantThemeColorTest.php`.


---

## 4. SOP tambah section / komponen dengan latar baru

### 4.1 Prioritas (dari yang paling murah)
1. Pakai latar terdaftar: `.theme-page-bg`, `.theme-section-bg`, `.theme-surface-alt`, `.theme-card`, `.theme-bg`, `.theme-badge`, `.theme-icon-box`, `.theme-accent-bg`.
2. Butuh turunan? Pakai `color-mix()` berbasis variabel, contoh pola yang sudah dipakai:
   ```css
   background-color: color-mix(in srgb, var(--theme-accent) 12%, var(--theme-page-bg));
   border-color: color-mix(in srgb, var(--theme-footer-bg) 75%, black);
   ```
   Campuran gelap selalu `..., black` untuk latar, **bukan** untuk warna teks.
3. Baru kalau dua-duanya tidak cocok: daftar scope baru.

### 4.2 Komponen baru selalu baca variabel ter-scope
```css
/* BENAR: ikut permukaan tempat komponen berada */
.theme-kartu-humas {
    background-color: var(--theme-card-bg) !important;
    border-color: var(--theme-border) !important;
    color: var(--theme-text) !important;
}
.theme-kartu-humas .judul { color: var(--theme-heading) !important; }
.theme-kartu-humas a       { color: var(--theme-fg-link) !important; }

/* SALAH: memaksa warna, kontrasnya tidak ikut dihitung */
.theme-kartu-humas { background-color: #0F2A22; color: #334155; }
```

### 4.3 Mendaftarkan scope auto-kontras baru
Tambahkan blok **di akhir blok `SCOPE AUTO-KONTRAS PER PERMUKAAN`** dengan nomor berurutan dan template baku:

```css
/* 8) <Nama permukaan> - latar <var latar> */
.theme-kartu-humas {
    --kontras-aman: calc(var(--theme-fg-kartu-text) contrast(var(--theme-card-bg)) >= 4.5);
    --kontras-terang: calc(#FFFFFF contrast(var(--theme-card-bg)) >= 3);
    --fallback-teks: color-mix(in srgb, #FFFFFF calc(100% * var(--kontras-terang)), #0F172A);
    --fg-zona-efektif: var(--theme-text);
    --theme-heading: color-mix(in srgb, var(--theme-fg-kartu-heading) calc(100% * var(--kontras-aman)), var(--fallback-teks));
    --theme-text: color-mix(in srgb, var(--theme-fg-kartu-text) calc(100% * var(--kontras-aman)), var(--fallback-teks));
    --theme-text-muted: color-mix(in srgb, var(--theme-fg-kartu-muted) calc(100% * var(--kontras-aman)), var(--fallback-teks));
    --theme-fg-link: color-mix(in srgb, var(--theme-fg-link) calc(100% * var(--kontras-aman)), var(--theme-text));
}
```

Aturan main blok scope:
- Pilih **satu** latar acuan dan gunakan `--theme-fg-*` yang sepasang (`kartu-*` untuk `--theme-card-bg`, `section-*` untuk `--theme-section-bg`, `halaman-*` untuk `--theme-page-bg`).
- Kalau permukaan punya latar warna sendiri (mis. panel aksen solid), acuan `contrast()` harus warna itu; tambahkan variabel latarnya lebih dulu di `:root` layout.
- Zona teks gelap cukup menyetel `--fg-zona-efektif`.
- Jangan lupa `npm run build`; compiled CSS harus masih memuat `@property` dan `contrast()`.

## 5. SOP tambah kunci warna / fg var baru

Satu kunci baru wajib muncul di **enam** tempat, kalau ada yang ketinggalan warnanya diam-diam kembali ke default:

1. Migrasi/seed: kunci `pengaturan_umum` (`database/migrations/tenant/*`, `database/seeders/Tenant*Seeder.php`).
2. Validasi + daftar kunci simpan: `app/Http/Controllers/Tenant/Admin/PengaturanController.php`.
3. Sumber data publik: `PageController::getSekolahData()` **dan** `HomeController` (dua-duanya, 13 kunci hari ini).
4. Injeksi `:root` + perhitungan `$kontras()` di `resources/views/layouts/public.blade.php`.
5. Fallback `:root` dan pemakaiannya di `resources/css/public.css`.
6. Salinan JS pratinjau (`luminans/rasio/pilihTeks/campur` + getter `fg*`) di `resources/views/tenant/admin/pengaturan/index.blade.php` supaya preview = hasil render.

Lalu: tambah assertion di `tests/Feature/TenantThemeColorTest.php` (jumlah kunci & nilai) + `tests/Unit/WarnaKontrasTest.php` bila logika helper ikut berubah.

## 6. Anti-pattern cepat

| Anti-pattern | Yang terjadi | Ganti dengan |
|--------------|--------------|--------------|
| `text-white` di kartu yang bisa diganti gelap | teks hilang saat admin memilih kartu gelap | biarkan warna datang dari `.theme-card` (variabel ter-scope) |
| `color: var(--theme-btn-text)` | mengabaikan hasil hitungan kontras | `var(--theme-fg-tombol)` / `--fg-zona-efektif` |
| `#38bdf8`, `#25D366`, `rgba(255,255,255,.88)` hardcoded | keluar dari tema, tidak ikut preset | `color-mix()` berbasis `--theme-*` |
| `--text-gray-500` atau `text-slate-*` baru di view | bergantung pada mapping lama, rawan bocor | `.theme-text-muted` |
| menyetel `--theme-text` di `@section('styles')` | merusak auto-kontras seluruh halaman | buat scope sendiri dengan `--kontras-aman` |
| menghapus `focus:` | gagal aksesibilitas keyboard | ring berbasis `--theme-accent` |

## 7. Verifikasi wajib sebelum melapor selesai

```bash
vendor/bin/pest tests/Unit/WarnaKontrasTest.php
vendor/bin/pest tests/Feature/TenantThemeColorTest.php
vendor/bin/pest tests/Feature/TenantPublicPagesTest.php
vendor/bin/pest                      # full suite
vendor/bin/pint --dirty --format agent
npm run build
```

Lalu cek hasil build benar-benar memuat mekanismenya:

```powershell
$c = Get-Content (Get-ChildItem public/build/assets/public-*.css | Sort-Object LastWriteTime -Descending | Select-Object -First 1) -Raw
([regex]::Matches($c,'@property')).Count      # harus >= 2
([regex]::Matches($c,'contrast\(')).Count     # harus >= 11
([regex]::Matches($c,'--fg-zona-efektif')).Count  # bertambah saat scope baru ditambah
```

Bukti visual (bila user meminta): aktifkan MCP Chrome DevTools, buka salah satu halaman publik, ganti preset ke `emerald_nature` dan satu preset latar kartu gelap, lalu pastikan (a) judul/isi kartu ikut putih, (b) nav & footer tetap terbaca, (c) tidak ada horizontal overflow.

Sinkronkan dokumentasi sesuai `AGENTS.md` 16: `CHANGELOG.md`, `docs/06-CHANGELOG.md`, `docs/05-UI-UX.md` bila kelas/variabel baru bertambah, `docs/08-CSS-ARSITEKTUR-TEMA.md` (registri scope & tabel variabel), `docs/04-ROUTES-OR-API.md` (route baru), `docs/07-IMPLEMENTATION-CHECKLIST.md`.

