# Aturan Penggunaan MCP: On-Demand Sesuai Permintaan User

Panduan ini mengatur penggunaan tool MCP (**Postman**, **Mobbin**, dan **Chrome DevTools**) pada workspace ini.

## Prinsip Utama
Tool MCP **TIDAK DIJALANKAN OTOMATIS** pada setiap perbaikan atau pembuatan fitur.
Tool MCP digunakan **HANYA KETIKA DIINSTRUKSIKAN / DIMINTA OLEH USER**.

---

## 1. MCP Postman (`postman-mcp-server`)
- **Kapan Digunakan**: Hanya ketika user meminta/menyuruh untuk melakukan pengecekan endpoint, status code, atau API request flow via Postman.
- **Verifikasi Default Tanpa MCP**: Menggunakan Pest feature & unit test (`php artisan test`) serta `php artisan route:list`.

## 2. MCP Mobbin (`mobbin`)
- **Kapan Digunakan**: Hanya ketika user secara spesifik meminta untuk meriset referensi desain aplikasi dunia nyata via Mobbin.
- **Pendekatan Default Tanpa MCP**: Mengikuti pola desain institusi yang sudah ada pada project, TailwindCSS bersih, dan standar web modern.

## 3. MCP Chrome DevTools (`chrome-devtools-mcp`)
- **Kapan Digunakan**: Hanya ketika user menyuruh untuk mengecek tampilan visual (`take_screenshot`), menguji responsivitas mobile (`resize_page`), atau memeriksa log konsol browser (`list_console_messages`).
- **Prinsip Anti-Slop Tetap Wajib**:
  - Walaupun inspeksi visual MCP Chrome DevTools bersifat on-demand, kode Blade, CSS, dan copywriting **wajib selalu bebas dari AI slop** (tanpa gradien neon ungu-biru, tanpa drop-shadow berlebihan, tanpa em-dash `—`, tanpa kata-kata klise AI).
