# Laravel Workspace Rules — Antigravity

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

## 2. Wajib dilakukan sebelum perubahan

1. Baca `README.md`, `composer.json`, `package.json`, `.env.example`, dan dokumentasi yang relevan.
2. Baca `.ai/rules/index.md` jika tersedia, lalu baca semua rule yang mencakup file dalam scope.
3. Periksa versi PHP dan package dengan `composer show --direct` serta `package.json`.
4. Periksa struktur folder, route, migration, model, controller, request, policy, view, component, seeder, factory, test, dan asset yang relevan.
5. Jalankan atau gunakan `php artisan route:list` untuk route yang terdampak.
6. Gunakan Laravel Boost `database-schema` dan `database-query` untuk memeriksa schema dan data secara read-only jika tool tersedia.
7. Gunakan `get-absolute-url` sebelum memberikan URL kepada user jika tool tersedia.
8. Baca browser logs untuk error UI jika tool tersedia.

Jika requirement belum jelas, tanyakan hanya hal yang benar-benar mengubah data, schema, security, biaya, atau arsitektur. Untuk hal kecil, gunakan asumsi minimal yang aman dan tuliskan asumsi tersebut.

## 3. Cara membaca instruksi user

Pecah instruksi user menjadi checklist acceptance criteria. Jangan hanya mengerjakan kalimat terakhir.

Untuk setiap permintaan, identifikasi:

- fitur yang ditambah;
- fitur yang diubah;
- fitur yang dihapus;
- data yang harus dibuat atau diubah;
- tenant/school/user yang terdampak;
- route dan menu yang terdampak;
- error yang harus direproduksi;
- bukti keberhasilan.

Sebelum coding, laporkan secara singkat:

1. Masalah yang ditemukan.
2. Rencana perubahan.
3. File dan area yang terdampak.
4. Risiko data atau breaking change.

Jangan mengklaim implementasi sebelum tahap verifikasi selesai.

## 4. Protokol perubahan lintas sistem

Setiap perubahan fitur wajib diperiksa terhadap semua lapisan berikut:

- PRD dan dokumentasi
- migration dan schema database
- tabel, kolom, index, foreign key, constraint
- model dan relationship
- factory dan seeder
- controller dan service
- Form Request dan validation
- policy, gate, role, dan permission
- middleware
- route dan route name
- Blade view, Livewire, Alpine, JavaScript, dan CSS
- navigation, breadcrumb, link internal, dan sitemap
- file upload, storage, cache, queue, notification
- test dan browser behavior
- changelog

Jika satu lapisan tidak terdampak, nyatakan alasannya. Jangan mengabaikannya tanpa pemeriksaan.

## 5. Aturan database

- Semua perubahan schema wajib menggunakan migration.
- Jangan mengubah schema secara manual sebagai pengganti migration.
- Jangan menjalankan `migrate:fresh`, `db:wipe`, reset database, atau menghapus data tanpa persetujuan eksplisit.
- Jangan membuat migration destructive sebelum memeriksa jumlah data dan relasinya.
- Seeder harus idempotent dan tidak membuat duplikasi saat dijalankan ulang.
- Jika fitur membutuhkan data baru, buat migration, model, factory/seeder jika relevan, validation, dan test.
- Jika fitur dihapus, telusuri tabel, kolom, foreign key, model, query, seeder, dan data lama.
- Jangan menghapus tabel hanya karena menu disembunyikan.
- Jika memakai database terpisah per tenant, pastikan koneksi tenant ditentukan secara konsisten dan tidak bocor antar request.
- Semua query tenant harus dibatasi pada tenant aktif melalui scope, repository, service, atau mekanisme yang sudah digunakan project.

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
2. Catat pesan error dan stack trace yang relevan.
3. Periksa browser console/log.
4. Periksa route, controller, model, migration, data aktual, view, dan asset yang terkait.
5. Perbaiki akar masalah, bukan hanya gejala.
6. Tambahkan atau perbarui regression test.
7. Uji ulang route dan behavior setelah perbaikan.

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

Jika melakukan riset referensi UI/UX:

1. Analisis minimal tiga referensi relevan.
2. Jangan hanya menganalisis homepage; jelajahi halaman internal, detail, galeri, form, search, pagination, footer, dan error page jika tersedia.
3. Simpan URL, screenshot, temuan, dan keputusan.
4. Jangan menyalin teks, gambar, kode, logo, atau identitas visual.

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
- Jika mengubah PHP, jalankan `vendor/bin/pint --dirty --format agent` sebelum final.
- Jangan menghapus atau melewati test yang gagal untuk membuat hasil terlihat hijau.
- Jika full suite belum dijalankan, sebutkan secara eksplisit.

## 15. Anti-slop

Jika anti-slop tersedia atau diminta:

1. Baca instruksi dan README resminya.
2. Instal atau jalankan sesuai project.
3. Untuk UI, copy, mobile, people, dan code comments, aktifkan rule/skill antislop yang relevan tanpa menghentikan pekerjaan untuk pertanyaan yang tidak perlu.
4. Periksa placeholder, dead code, duplicate code, unused route/model/table, dummy data tidak bertanda, dan UI generik.
5. Catat hasil dan keterbatasannya.

## 16. Definition of Done

Fitur hanya boleh disebut selesai jika:

- acceptance criteria terpenuhi;
- database/migration benar;
- seed/data tersedia bila diperlukan;
- route dan middleware benar;
- validation dan authorization benar;
- UI mobile dan desktop diverifikasi;
- loading/empty/error state relevan tersedia;
- test berhasil;
- Pint/linter berhasil bila relevan;
- browser/log tidak menunjukkan error terkait;
- tidak ada route, menu, tabel, model, atau file lama yang tertinggal tanpa alasan;
- dokumentasi dan changelog diperbarui;
- bukti verifikasi tersedia.

Jika belum terbukti, gunakan status `Partial`, `Not verified`, atau `Blocked`.

## 17. Format laporan wajib

1. Ringkasan perubahan
2. Masalah dan akar penyebab
3. File dibuat/diubah/dihapus
4. Database dan migration
5. Seeder dan data aktual
6. Route dan middleware
7. UI/UX dan animasi
8. Authorization/tenant isolation
9. Test, Pint, dan hasilnya
10. URL yang diverifikasi
11. Dokumentasi/changelog yang diperbarui
12. Risiko dan pekerjaan yang belum selesai

Jangan mengatakan “semua sudah selesai” jika ada placeholder, asumsi yang belum dikonfirmasi, test yang belum dijalankan, data yang belum dibuat, atau route yang belum diverifikasi.
