# Aturan Penggunaan MCP: Postman, Mobbin, dan Chrome DevTools

Panduan ini melengkapi `AGENTS.md` untuk alur kerja verifikasi fungsi, riset desain UI/UX, dan eliminasi AI slop pada workspace ini.

## 1. Pengecekan Fungsi dengan MCP Postman
- **Kapan Digunakan**: Setiap kali membuat, mengubah, menguji, atau memperbaiki fungsionalitas backend, route, middleware, controller, atau endpoint API.
- **Tool**: MCP `postman-mcp-server` (`createCollectionRequest`, `runCollection`, `getCollection`, dll.).
- **Tujuan**:
  - Memverifikasi status code HTTP (200, 302, 401, 403, 404, 422, 500).
  - Memvalidasi payload JSON dan form-data.
  - Memastikan otentikasi (session cookie, token) dan proteksi middleware bekerja dengan benar.
  - Mencegah regresi fungsional sebelum fitur dinyatakan selesai.

## 2. Riset UI/UX dengan MCP Mobbin
- **Kapan Digunakan**: Setiap kali diminta membuat halaman UI/UX baru, merombak tata letak, atau memperbaiki antarmuka pengguna.
- **Tool**: MCP `mobbin` (`search_screens`, `search_flows`, `search_sections`).
- **Tujuan**:
  - Meriset pola antarmuka pengguna nyata dari produk digital terkemuka dunia.
  - Mengambil referensi tata letak navigasi, dashboard, tabel data, filter pencarian, form registrasi/SPMB, drawer mobile, dan kartu informasi.
  - Dilarang membuat desain dari asumsi kosong atau template generik.

## 3. Eliminasi AI Slop dan Verifikasi Visual dengan MCP Chrome DevTools
- **Kapan Digunakan**: Setiap kali ada komponen visual, Blade view, styling CSS, atau interaksi JavaScript yang dibuat atau diubah.
- **Tool**: MCP `chrome-devtools-mcp` (`take_screenshot`, `resize_page`, `list_console_messages`, `get_css_styles`, `evaluate_script`).
- **Prinsip Bebas AI Slop**:
  - **TIDAK BOLEH TERLIHAT SEPERTI BUATAN AI**: Hindari kartu melayang dengan gradien neon ungu-biru tipikal AI, drop shadow berlebihan, dan layout flat bento kosong.
  - **Copywriting Manusiawi**: Dilarang menggunakan kata klise AI ("delve", "leverage", "seamless", "tapestry", "embark", "cutting-edge") dan dilarang em-dash `—`.
  - **Inspeksi Nyata**: Wajib mengambil tangkapan layar (`take_screenshot`) dan menguji responsivitas pada resolusi mobile (375px - 414px) untuk membuktikan tampilan tidak patah dan tidak ada horizontal overflow.
  - **Konsol Bersih**: Pastikan `list_console_messages` tidak menunjukkan error JavaScript atau network failure.
