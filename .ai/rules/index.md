# Indeks Aturan Workspace (`.ai/rules`)

Aturan di folder ini bersifat **operasional**: dibaca tepat sebelum menyentuh file yang tercakup. Aturan global project ada di `AGENTS.md` (root) dan `docs/RULES.md`.

| File Rule | Tipe | Cakupan file |
|-----------|------|--------------|
| [publik-tema-kontras.md](publik-tema-kontras.md) | Wajib (blocking) | `resources/css/public.css`, `resources/views/layouts/public.blade.php`, `resources/views/public/**`, `app/Http/Controllers/Tenant/Public/**`, `routes/web.php` (grup `Route::prefix('{tenant}')`), `app/Support/WarnaKontras.php`, `resources/views/tenant/admin/pengaturan/index.blade.php`, `database/seeders/**` (menu) |

Referensi teknis lengkap (tabel variabel, registri scope, resep, anti-pattern): `docs/08-CSS-ARSITEKTUR-TEMA.md`.
Spesifikasi desain: `docs/05-UI-UX.md` (terutama bagian "Sistem Tema Warna Dinamis" dan "Auto-Kontras WCAG Otomatis").

## Cara memakai
1. Sebelum mengubah file publik, buka rule yang cakupannya cocok.
2. Ikuti SOP di rule tersebut (tambah menu, tambah halaman, tambah section/komponen, tambah kunci warna).
3. Jalankan bagian "Verifikasi wajib" pada rule sebelum melapor pekerjaan selesai.
4. Kalau rule bertentangan dengan kenyataan kode, perbaiki kode atau perbarui rule - jangan dibiarkan bertentangan.
