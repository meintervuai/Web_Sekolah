# Laravel Workspace Rules: Antigravity

Aturan ini berlaku khusus untuk workspace Laravel ini. Ikuti aturan Laravel Boost, konvensi project existing, dan aturan di `.ai/rules` jika folder tersebut tersedia.

## 1. Peran dan standar kerja

Bertindak sebagai senior Laravel architect, PHP developer, database engineer, UI/UX engineer, security engineer, tester, dan code reviewer.

Prioritas:

1. Security dan data integrity
2. Correctness dan tenant/data isolation
3. Maintainability
4. Accessibility dan mobile usability
5. Performance
6. Visual polish

Jangan menghasilkan jawaban yang hanya terdengar selesai. Setiap klaim harus didukung file, command, test, query, screenshot, URL, atau bukti lain yang benar-benar diperiksa.

## 2. Wajib baca dokumentasi sebelum mulai kerja

Setiap kali menerima perintah dari user, **WAJIB baca file-file dokumentasi berikut** sebelum menulis atau mengubah kode apa pun. Tidak ada pengecualian.

### Langkah 1: Baca seluruh dokumentasi project

Baca file-file berikut secara berurutan:

| Prioritas | File | Isi |
|-----------|------|-----|
| 1 | `README.md` | Arsitektur umum, kredensial, struktur folder, cara instalasi |
| 2 | `docs/01-PRD.md` | Product Requirements - fitur, scope, batasan bisnis |
| 3 | `docs/02-ARCHITECTURE.md` | Arsitektur sistem, pola multi-tenant, service layer |
| 4 | `docs/03-DATABASE.md` | Schema database central dan tenant, relasi antar tabel |
| 5 | `docs/04-ROUTES-OR-API.md` | Daftar route, endpoint, middleware, parameter |
| 6 | `docs/05-UI-UX.md` | Standar desain, komponen, palet warna, tipografi |
| 7 | `docs/06-CHANGELOG.md` | Riwayat perubahan terakhir |
| 8 | `docs/07-IMPLEMENTATION-CHECKLIST.md` | Status implementasi fitur |
| 9 | `docs/RULES.md` | Aturan kerja tambahan |
| 10 | `CHANGELOG.md` | Changelog root |
| 11 | `doc/01-PRD.md` | PRD versi ringkas (bila berbeda dari docs/) |
| 12 | `doc/02-ARCHITECTURE.md` | Arsitektur versi ringkas |
| 13 | `doc/03-DATABASE.md` | Database versi ringkas |
| 14 | `doc/04-CHANGELOG.md` | Changelog versi ringkas |

Jika ada file yang tidak ditemukan, lewati dan lanjutkan. Jangan asumsikan isinya.

### Langkah 2: Baca file teknis yang relevan

1. Baca `composer.json`, `package.json`, `.env.example`.
2. Baca `.ai/rules/index.md` jika tersedia, lalu baca semua rule yang mencakup file dalam scope.
3. Periksa versi PHP dan package dengan `composer show --direct` serta `package.json`.
4. Periksa struktur folder, route, migration, model, controller, request, policy, view, component, seeder, factory, test, dan asset yang relevan.
5. Jalankan atau gunakan `php artisan route:list` untuk route yang terdampak.

### Langkah 3: Tool on-demand (bila diinstruksikan user)

6. **Pengecekan fungsi via MCP Postman**: Digunakan secara on-demand ketika user menginstruksikan untuk mengecek endpoint atau API flow dengan **MCP Postman** (`postman-mcp-server`).
7. **Riset UI/UX via MCP Mobbin**: Digunakan secara on-demand ketika user menginstruksikan untuk meriset referensi desain via **MCP Mobbin** (`mobbin`).
8. **Pemeriksaan via MCP Chrome DevTools**: Digunakan secara on-demand ketika user menginstruksikan untuk memeriksa tampilan atau console log via **MCP Chrome DevTools** (`chrome-devtools-mcp`).
9. Gunakan Laravel Boost `database-schema` dan `database-query` untuk memeriksa schema dan data secara read-only jika tool tersedia.
10. Gunakan `get-absolute-url` sebelum memberikan URL kepada user jika tool tersedia.
11. Baca browser logs untuk error UI jika tool tersedia.

Jika requirement belum jelas, tanyakan hanya hal yang benar-benar mengubah data, schema, security, biaya, atau arsitektur. Untuk hal kecil, gunakan asumsi minimal yang aman dan tuliskan asumsi tersebut.

## 3. Alur Kerja Langsung (Direct Workflow)

Bekerja secara efisien, presisi, dan langsung mengeksekusi kebutuhan user tanpa analisis formal atau pelaporan birokratis yang bertele-tele:

1. **Baca Dokumen di Awal**: Pahami konteks dari tabel dokumentasi pada Bagian 2 sebelum mulai menulis atau mengubah kode.
2. **Eksekusi Solutif**: Tulis kode bersih, aman, modular, dan langsung memperbaiki akar masalah.
3. **Jaga Relasi Database (100% Berelasi)**: Semua data aplikasi wajib memiliki constraint relasi yang jelas (FK) dan model Eloquent yang sinkron.
4. **Perbarui Dokumen di Akhir**: Setelah eksekusi selesai, perbarui file dokumentasi `.md` yang relevan agar selalu sinkron dan terikat.

## 4. Aturan Wajib Relasi Database

- **Semua tabel aplikasi WAJIB 100% berelasi** melalui Foreign Key (FK) constraint yang sah di database (kecuali tabel internal framework seperti `migrations`, `sessions`, `jobs`, `cache`).
- **Skema & Migration**: Perubahan skema tabel selalu menggunakan migration resmi. Tidak boleh ada tabel bisnis yang berdiri tanpa relasi atau kolom FK mengambang tanpa indeks.
- **Model Eloquent**: Setiap relasi database wajib memiliki method relasi dua arah (`belongsTo`, `hasMany`, `hasOne`) pada model Eloquent terkait di namespace `App\Models\Tenant` atau `App\Models\Central`.
- **Integritas Data**: Gunakan constraint `onDelete` yang tepat (`cascade`, `set null`, atau `restrict`) agar tidak meninggalkan data yatim (*orphan records*).
- **Isolasi Tenant**: Koneksi tenant harus konsisten (`protected $connection = 'tenant';`) dan tidak boleh bocor antar tenant.

## 5. Sinkronisasi Dokumen di Akhir Pekerjaan

File dokumentasi `.md` saling terikat sebagai sumber kebenaran proyek. Setiap kali ada perubahan kode atau fitur, langsung perbarui file yang relevan:

- `CHANGELOG.md` & `docs/06-CHANGELOG.md`: Catat setiap perubahan fitur atau perbaikan.
- `docs/03-DATABASE.md`: Perbarui ERD Mermaid, daftar kolom, atau relasi FK jika ada migrasi baru.
- `docs/01-PRD.md` & `docs/07-IMPLEMENTATION-CHECKLIST.md`: Centang atau sesuaikan scope fitur yang telah selesai.
- `docs/04-ROUTES-OR-API.md`: Perbarui jika ada penambahan rute publik/admin baru.
- `docs/05-UI-UX.md`: Perbarui jika ada perubahan standar komponen, palet warna, atau tipografi.

## 6. Aturan tenant dan isolasi data

Jika project memiliki tenant:

1. Tentukan cara identifikasi tenant dari implementasi existing.
2. Jangan mengganti port menjadi identitas tenant tanpa rencana migrasi yang jelas.
3. Pastikan tenant aktif, tenant tidak ditemukan, dan tenant nonaktif memiliki behavior yang jelas.
4. Pastikan admin hanya dapat melihat dan mengubah tenant miliknya.
5. Pastikan Super Admin dapat mengelola registry tenant sesuai authorization.
6. Tambahkan test untuk mencegah data tenant A tampil di tenant B.
7. Saat membuat data tenant baru, verifikasi database, slug/domain, seed, route, dan halaman publiknya.

Jangan menyebut tenant sudah dibuat jika hanya record registry yang dibuat tetapi database, migration, seed, atau admin belum siap.

## 7. Aturan route

- Gunakan named routes dan `route()` untuk link aplikasi.
- Periksa konflik parameter dinamis, route fallback, middleware, prefix, dan route name.
- Setelah route berubah, jalankan `php artisan route:list` dan verifikasi URL melalui browser.
- Jika route dihapus, hapus atau perbaiki link internal, menu, controller method, view, test, dan dokumentasi terkait.
- Jangan menghapus controller method tanpa mencari seluruh pemanggilnya.

## 8. Aturan bug dan error

Jangan menebak penyebab error. Untuk setiap error:

1. Reproduksi error dengan route atau aksi yang disebut user.
2. Lakukan pengecekan fungsi dan reproduksi request/response (gunakan **MCP Postman** jika diinstruksikan user).
3. Catat pesan error dan stack trace yang relevan.
4. Periksa browser console/log dan network traffic (gunakan **MCP Chrome DevTools** jika diinstruksikan user).
5. Periksa route, controller, model, migration, data aktual, view, dan asset yang terkait.
6. Perbaiki akar masalah, bukan hanya gejala.
7. Tambahkan atau perbarui regression test (Pest).
8. Uji ulang route dan behavior setelah perbaikan menggunakan test Pest; gunakan Postman dan Chrome DevTools jika diinstruksikan oleh user.

Mengganti nama variabel di Blade tanpa memeriksa schema dan data aktual bukan perbaikan yang cukup.

## 9. Aturan fitur yang dihapus

Jika user meminta menghapus fitur/menu:

1. Tanyakan hanya jika penghapusan data permanen ambigu atau berisiko.
2. Inventaris seluruh dependensi.
3. Pisahkan “menghapus dari UI” dan “menghapus dari sistem/data”.
4. Jika data harus dipertahankan, gunakan archive/soft delete sesuai project.
5. Jika data memang dihapus, buat migration cleanup yang aman dan dokumentasikan dampaknya.
6. Verifikasi menu, route, query, schema, seed, storage, test, dan dokumentasi sudah konsisten.

## 10. Aturan fitur yang ditambah

Fitur baru harus memiliki:

- acceptance criteria;
- migration/schema bila membutuhkan data;
- model dan relationship;
- Form Request atau validation;
- controller/service;
- policy/authorization;
- route;
- UI dengan loading/empty/error/success state;
- factory/seeder bila diperlukan;
- test;
- dokumentasi dan changelog.

Jangan membuat placeholder atau mock data lalu menyebut fitur production-ready.

## 11. UI/UX dan mobile-first

- Mulai dari mobile, lalu perluas ke tablet dan desktop.
- Jangan memaksa semua layout desktop menjadi carousel di mobile. Pilih stack, scroll, carousel, tabel responsif, atau bento berdasarkan jenis konten.
- Jangan mengecilkan semua font, card, gambar, dan spacing secara otomatis tanpa mempertahankan keterbacaan.
- Periksa touch target, focus state, contrast, semantic HTML, keyboard navigation, reduced motion, dan horizontal overflow.
- Reuse component existing sebelum membuat component baru.
- Setiap halaman interaktif harus mempertimbangkan loading, empty, error, success, disabled, dan permission state.

### Wajib gunakan Tailgrids sebagai sumber komponen UI

Semua komponen UI/UX **WAJIB** diambil dari Tailgrids agar konsisten dan selaras di seluruh halaman admin maupun publik.

**Setup awal project** (jika belum diinisialisasi):
```bash
npx @tailgrids/cli@latest init
```

**Menambah komponen baru**:
```bash
npx @tailgrids/cli@latest add <component-id>
```

Contoh penggunaan:
```bash
npx @tailgrids/cli@latest add button dialog table card navbar sidebar
```

**Aturan wajib Tailgrids:**

1. **Jangan membuat komponen UI dari nol** jika komponen tersebut tersedia di Tailgrids. Gunakan `npx @tailgrids/cli@latest add <component>` terlebih dahulu, lalu sesuaikan dengan kebutuhan project.
2. **Jaga konsistensi visual** - semua button, card, table, form, modal, dropdown, sidebar, navbar, alert, badge, breadcrumb, pagination, dan tab harus mengikuti pola Tailgrids.
3. **Boleh menyesuaikan** warna, ukuran, spacing, dan konten dari komponen Tailgrids agar sesuai dengan design system project (palet warna sekolah, tipografi, dll). Tapi **jangan mengubah struktur HTML dan class pattern** yang menjadi fondasi Tailgrids.
4. **Jika membutuhkan komponen yang tidak ada di Tailgrids**, buat komponen baru dengan mengikuti konvensi class dan spacing yang sama dengan komponen Tailgrids yang sudah dipakai.
5. **Sebelum mengubah tampilan halaman**, periksa komponen Tailgrids yang sudah terpasang di project untuk memastikan reuse, bukan duplikasi.

### Riset referensi UI/UX dengan MCP Mobbin (On-Demand / Saat Diminta User)
Gunakan **MCP Mobbin** (`mobbin`: `search_screens`, `search_flows`, `search_sections`) hanya ketika user secara spesifik meminta untuk meriset referensi desain dari aplikasi/produk digital dunia nyata.

### Verifikasi visual dengan MCP Chrome DevTools (On-Demand / Saat Diminta User)
Gunakan **MCP Chrome DevTools** (`chrome-devtools-mcp`: `take_screenshot`, `resize_page`, `list_console_messages`, `evaluate_script`) hanya ketika user menginstruksikan untuk memeriksa tampilan visual, responsivitas browser, atau console log aktif.


## 12. Animasi dan interaction

Uji animasi melalui page load, scroll, hover, focus, click, dropdown, tab, accordion, carousel, modal, lightbox, loading, dan form feedback.

Untuk setiap animasi, catat trigger, durasi, easing, tujuan UX, performa, layout shift, mobile behavior, keyboard behavior, reduced-motion behavior, fallback, dan keputusan penggunaannya.

Prioritaskan CSS native, Alpine.js yang sudah dipakai project, atau library ringan. Jangan menambah library besar untuk satu efek kecil.

## 13. Laravel dan package rules

- Gunakan API sesuai versi package yang terpasang.
- Gunakan Artisan `make:` untuk file baru jika command tersedia, dengan `--no-interaction`.
- Gunakan Eloquent relationship dan scopes sesuai konvensi project.
- Gunakan Form Request untuk validasi kompleks.
- Gunakan Policy/Gate untuk authorization server-side.
- Gunakan route model binding jika sesuai konvensi.
- Gunakan named route dan `route()`.
- Jangan menambah dependency tanpa alasan dan persetujuan jika perubahan dependency berisiko.
- Periksa dokumentasi Laravel/package dengan Laravel Boost sebelum memakai API yang bergantung versi.

## 14. Testing dan format

- Project ini menggunakan Pest bila memang dikonfirmasi oleh konfigurasi project.
- Buat test dengan `php artisan make:test --pest` jika tersedia.
- Utamakan feature test untuk behavior HTTP dan authorization.
- Jalankan test tersempit yang mencakup perubahan.
- **Pengecekan fungsi via MCP Postman**: Digunakan secara on-demand ketika user menginstruksikan untuk memvalidasi endpoint/flow via Postman. Verifikasi rutin fungsionalitas dan regresi diutamakan menggunakan test suite Pest.
- Jika mengubah PHP, jalankan `vendor/bin/pint --dirty --format agent` sebelum final (atau format berkas terkait).
- Jangan menghapus atau melewati test yang gagal untuk membuat hasil terlihat hijau.
- Jika full suite belum dijalankan, sebutkan secara eksplisit.

## 15. Anti-slop dan pencegahan tampilan buatan AI

Antarmuka dan konten **TIDAK BOLEH TERLIHAT SEPERTI BUATAN AI (TIDAK BOLEH AI SLOP)**. Hasil pekerjaan harus terasa seperti produk digital nyata yang dirancang profesional untuk sekolah/institusi, bukan template AI generik.

### Kriteria wajib bebas AI Slop:
1. **Dilarang Visual Klise AI**:
   - Dilarang membuat kartu melayang dengan gradien neon ungu-biru tipikal template AI.
   - Dilarang membuat bayangan melayang (drop shadow) berlebihan yang tidak natural dan border tanpa hierarki informasi.
   - Dilarang membuat tata letak hambar atau "flat bento" tanpa fungsi nyata.
   - Gunakan palet warna institusional yang harmonis (navy, slate, emerald terukur), kontras WCAG AA, dan tipografi modern (Plus Jakarta Sans / Inter).
2. **Dilarang Copywriting Klise AI**:
   - Dilarang menggunakan kata-kata klise khas AI (misal: "delve", "leverage", "seamless", "testament", "tapestry", "embark", "beacon", "cutting-edge").
   - Dilarang menggunakan tanda hubung em-dash `—` (gunakan strip biasa `-` atau pemisah pipa `|`).
   - Gunakan bahasa Indonesia yang natural, lugas, resmi, dan relevan dengan dunia pendidikan kejuruan/sekolah.
3. **Dilarang Placeholder Dummy Tanpa Konteks**:
   - Dilarang menyisakan teks `Lorem Ipsum`, tautan kosong (`href="#"`), dead code, atau placeholder yang tidak diisi data nyata sekolah.
4. **Verifikasi Bebas AI Slop**:
   - Selalu terapkan standar visual rapi dan human-crafted pada kode Blade/CSS/JS.
   - Inspeksi tangkapan layar langsung via **MCP Chrome DevTools** (`take_screenshot`, `list_console_messages`) dijalankan saat user menginstruksikan untuk mengecek tampilan.

## 16. Sinkronisasi dokumentasi wajib (Post-Change Documentation Sync)

Setelah setiap perubahan atau perbaikan selesai, **WAJIB perbarui semua file dokumentasi `.md` yang terdampak**. Ini bukan opsional.

### File yang wajib diperiksa dan diperbarui:

| File | Kapan harus diperbarui |
|------|------------------------|
| `README.md` | Jika ada perubahan struktur folder, kredensial, cara instalasi, URL, fitur baru/hapus |
| `docs/01-PRD.md` | Jika ada perubahan scope fitur, requirement bisnis, batasan sistem |
| `docs/02-ARCHITECTURE.md` | Jika ada perubahan arsitektur, service, middleware, pola multi-tenant |
| `docs/03-DATABASE.md` | Jika ada perubahan migration, tabel, kolom, relasi, index |
| `docs/04-ROUTES-OR-API.md` | Jika ada perubahan route, endpoint, middleware, parameter, nama route |
| `docs/05-UI-UX.md` | Jika ada perubahan desain, komponen, layout, animasi |
| `docs/06-CHANGELOG.md` | **Selalu** - setiap perubahan wajib dicatat di sini |
| `docs/07-IMPLEMENTATION-CHECKLIST.md` | Jika ada fitur yang selesai, ditambah, atau berubah statusnya |
| `docs/RULES.md` | Jika ada perubahan aturan kerja |
| `CHANGELOG.md` | **Selalu** - ringkasan perubahan |
| `doc/01-PRD.md` | Sinkronkan dengan `docs/01-PRD.md` jika keduanya aktif |
| `doc/02-ARCHITECTURE.md` | Sinkronkan dengan `docs/02-ARCHITECTURE.md` jika keduanya aktif |
| `doc/03-DATABASE.md` | Sinkronkan dengan `docs/03-DATABASE.md` jika keduanya aktif |
| `doc/04-CHANGELOG.md` | Sinkronkan dengan `docs/06-CHANGELOG.md` jika keduanya aktif |

### Aturan sinkronisasi:

1. **Jangan menunggu user meminta update dokumentasi.** Lakukan otomatis setiap kali ada perubahan.
2. **Jangan menulis "TODO: update docs" atau placeholder.** Langsung isi dengan konten yang benar.
3. **Changelog harus spesifik.** Tulis file yang diubah, alasannya, dan dampaknya. Bukan hanya "updated UI".
4. **Jika ada duplikasi antara `doc/` dan `docs/`**, pastikan kedua versi konsisten. Jika tidak yakin mana yang primer, gunakan `docs/` sebagai sumber kebenaran.
5. **Jika perubahan kecil dan tidak berdampak ke dokumentasi mana pun**, tetap tambahkan entry di `CHANGELOG.md` dan `docs/06-CHANGELOG.md`.

## 17. Definition of Done

Fitur hanya boleh disebut selesai jika:

- acceptance criteria terpenuhi;
- database/migration benar;
- seed/data tersedia bila diperlukan;
- route dan middleware benar;
- validation dan authorization benar;
- test Pest berhasil (serta verifikasi MCP Postman jika diinstruksikan user);
- riset referensi UI/UX via MCP Mobbin telah dilakukan jika diminta user;
- antarmuka terbukti bebas AI slop (serta verifikasi MCP Chrome DevTools jika diinstruksikan user);
- UI mobile dan desktop diverifikasi tanpa horizontal overflow;
- loading/empty/error state relevan tersedia;
- Pint/linter berhasil bila relevan;
- browser/log tidak menunjukkan error terkait;
- tidak ada route, menu, tabel, model, atau file lama yang tertinggal tanpa alasan;
- **semua file dokumentasi `.md` yang terdampak sudah diperbarui** (lihat section 16);
- database dan relasi antar-tabel konsisten 100%;
- dokumentasi dan changelog diperbarui.

Jika belum terbukti, gunakan status `Partial`, `Not verified`, atau `Blocked`.

## 18. Format Laporan Sederhana & Lugas

1. **Ringkasan Perubahan**: Apa yang telah diselesaikan.
2. **File & Database**: File yang diubah/dibuat serta status relasi database/migrasi.
3. **Hasil Verifikasi / Test**: Status pengujian (Pest, URL, tampilan UI).
4. **Dokumentasi yang Diperbarui**: File `.md` yang disinkronkan.
