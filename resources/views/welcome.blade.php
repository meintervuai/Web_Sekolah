<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Direktori Multi-Sekolah Terpadu</title>
    <meta name="description" content="Portal direktori resmi dan akses sistem manajemen sekolah terpadu multi-tenant di Indonesia.">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col antialiased selection:bg-blue-600 selection:text-white"
      x-data="{ search: '', filterJenjang: 'semua' }">

    <!-- Top Notice Bar -->
    <aside class="bg-slate-900 text-slate-300 text-xs py-2.5 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-blue-900 text-blue-300 font-semibold text-[11px] border border-blue-700/60">
                    Multi-Tenant v2.0
                </span>
                <span class="text-slate-300">
                    Platform Pusat Manajemen Website & Data Sekolah Independen
                </span>
            </div>
            <div class="flex items-center space-x-4 text-slate-400">
                <a href="#direktori" class="hover:text-white transition">Direktori Sekolah</a>
                <span class="text-slate-700">|</span>
                <a href="#panduan-akses" class="hover:text-white transition">Panduan Akses</a>
                <span class="text-slate-700">|</span>
                <a href="{{ route('superadmin.login') }}" class="text-blue-400 hover:text-blue-300 font-semibold transition">
                    Portal Super Admin &rarr;
                </a>
            </div>
        </div>
    </aside>

    <!-- Header Navigation -->
    <header class="bg-white/95 backdrop-blur-md sticky top-0 z-40 border-b border-slate-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                <div class="w-11 h-11 bg-gradient-to-br from-blue-700 to-indigo-800 text-white rounded-xl flex items-center justify-center font-bold text-xl shadow-md group-hover:scale-105 transition-transform duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <span class="font-heading font-extrabold text-xl text-slate-900 tracking-tight block leading-tight">
                        Portal Sekolah
                    </span>
                    <span class="text-xs text-slate-500 font-medium tracking-wide block">
                        Direktori Institusi Pendidikan
                    </span>
                </div>
            </a>

            <!-- Quick Action Links -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.shortcut') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                    <svg class="w-4 h-4 mr-1.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    <span>Login Admin Sekolah</span>
                </a>

                <a href="{{ route('superadmin.login') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-blue-700 hover:bg-blue-800 rounded-xl shadow-sm transition">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>Super Admin</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">

        <!-- Hero Section -->
        <section class="bg-gradient-to-b from-white via-slate-50 to-slate-100/60 pt-16 pb-12 border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                
                <div class="inline-flex items-center space-x-2 px-3 py-1 bg-blue-50 border border-blue-200 rounded-full text-blue-800 text-xs font-semibold mb-6">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    <span>Sistem Multi-Sekolah Terintegrasi</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight max-w-3xl mx-auto leading-tight mb-5">
                    Pusat Informasi & Direktori Website Sekolah
                </h1>

                <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed mb-8">
                    Temukan portal publik resmi dari seluruh unit sekolah yang terdaftar, serta akses langsung ke panel administrasi konten (CMS) masing-masing sekolah.
                </p>

                <!-- Search and Filter Bar -->
                <div class="max-w-2xl mx-auto bg-white p-2 sm:p-2.5 rounded-2xl shadow-lg border border-slate-200 flex flex-col sm:flex-row items-center gap-2">
                    <div class="relative flex-1 w-full">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text"
                               x-model="search"
                               placeholder="Cari nama sekolah, kota, atau NPSN..."
                               class="w-full pl-10 pr-4 py-2.5 bg-transparent border-0 focus:ring-0 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none">
                    </div>

                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <select x-model="filterJenjang" 
                                class="w-full sm:w-auto px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:ring-2 focus:ring-blue-600 focus:outline-none">
                            <option value="semua">Semua Jenjang</option>
                            <option value="SMK">SMK</option>
                            <option value="SMA">SMA</option>
                            <option value="SMP">SMP</option>
                            <option value="SD">SD</option>
                        </select>
                        <a href="#direktori" 
                           class="w-full sm:w-auto px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-xl shadow-sm transition whitespace-nowrap">
                            Cari
                        </a>
                    </div>
                </div>

                <!-- Verified Stats Bar (Real Data Only) -->
                <div class="mt-10 flex flex-wrap items-center justify-center gap-6 sm:gap-12 text-slate-600 text-sm">
                    <div class="flex items-center space-x-2">
                        <strong class="text-xl font-extrabold text-slate-900">{{ $sekolahs->count() }}</strong>
                        <span class="text-slate-500">Sekolah Aktif Terdaftar</span>
                    </div>
                    <div class="w-1.5 h-1.5 rounded-full bg-slate-300 hidden sm:block"></div>
                    <div class="flex items-center space-x-2">
                        <strong class="text-xl font-extrabold text-emerald-600">100%</strong>
                        <span class="text-slate-500">Isolasi Database Terjamin</span>
                    </div>
                    <div class="w-1.5 h-1.5 rounded-full bg-slate-300 hidden sm:block"></div>
                    <div class="flex items-center space-x-2">
                        <strong class="text-xl font-extrabold text-indigo-600">Terbuka</strong>
                        <span class="text-slate-500">Pendaftaran Siswa Baru (SPMB)</span>
                    </div>
                </div>

            </div>
        </section>

        <!-- Directory Section -->
        <section id="direktori" class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Daftar Sekolah Terdaftar
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Pilih sekolah di bawah ini untuk menjelajahi portal publik atau masuk ke dashboard CMS sekolah.
                    </p>
                </div>
                
                <div class="text-xs text-slate-500">
                    Menampilkan <span class="font-bold text-slate-800">{{ $sekolahs->count() }}</span> sekolah terdaftar
                </div>
            </div>

            @if($sekolahs->isEmpty())
                <!-- Empty State -->
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center max-w-lg mx-auto shadow-xs">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-1">Belum Ada Sekolah Terdaftar</h3>
                    <p class="text-sm text-slate-500 mb-6">
                        Silakan login sebagai Super Admin untuk mendaftarkan dan menginisialisasi database sekolah pertama.
                    </p>
                    <a href="{{ route('superadmin.login') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-semibold text-sm rounded-xl transition">
                        Tambah Sekolah Baru &rarr;
                    </a>
                </div>
            @else
                <!-- School Grid Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($sekolahs as $sekolah)
                        @php
                            $data = is_array($sekolah->data) ? $sekolah->data : [];
                            $npsn = $data['npsn'] ?? 'NPSN Belum Diisi';
                            $akreditasi = $data['akreditasi'] ?? 'A';
                            $alamat = $data['alamat'] ?? 'Alamat belum diatur';
                            $telepon = $data['telepon'] ?? '(022) -';
                            $email = $data['email'] ?? 'info@sekolah.sch.id';
                        @endphp
                        <article class="bg-white rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col overflow-hidden"
                                 x-show="(search === '' || '{{ strtolower($sekolah->nama_sekolah . ' ' . $npsn . ' ' . $alamat) }}'.includes(search.toLowerCase())) && (filterJenjang === 'semua' || filterJenjang === '{{ $sekolah->jenjang }}')">
                            
                            <!-- Card Header -->
                            <div class="p-6 border-b border-slate-100 flex items-start justify-between gap-4">
                                <div class="flex items-start space-x-3.5">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-700 to-indigo-800 text-white flex items-center justify-center font-bold text-lg shadow-xs shrink-0">
                                        {{ substr($sekolah->nama_sekolah, 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="font-heading font-bold text-lg text-slate-900 leading-snug">
                                            <a href="{{ url($sekolah->slug) }}" class="hover:text-blue-700 transition">
                                                {{ $sekolah->nama_sekolah }}
                                            </a>
                                        </h3>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 font-semibold text-xs border border-blue-100">
                                                {{ $sekolah->jenjang }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 font-semibold text-xs border border-emerald-100">
                                                Akreditasi {{ $akreditasi }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body Information -->
                            <div class="p-6 space-y-3 text-xs text-slate-600 flex-1">
                                <div class="flex items-start space-x-2.5">
                                    <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="leading-relaxed line-clamp-2">{{ $alamat }}</span>
                                </div>

                                <div class="flex items-center space-x-2.5">
                                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                    </svg>
                                    <span>NPSN: <strong class="text-slate-800">{{ $npsn }}</strong></span>
                                </div>

                                <div class="flex items-center space-x-2.5">
                                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>{{ $telepon }}</span>
                                </div>
                            </div>

                            <!-- Card Footer Links -->
                            <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-2">
                                <a href="{{ url($sekolah->slug) }}" 
                                   class="flex-1 text-center py-2 px-3 bg-blue-700 hover:bg-blue-800 text-white font-semibold text-xs rounded-xl shadow-xs transition">
                                    Website Sekolah &rarr;
                                </a>
                                <a href="{{ url($sekolah->slug . '/admin/login') }}" 
                                   class="py-2 px-3 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 font-semibold text-xs rounded-xl transition"
                                   title="Masuk ke Panel Admin {{ $sekolah->nama_sekolah }}">
                                    CMS Admin
                                </a>
                            </div>

                        </article>
                    @endforeach
                </div>
            @endif

        </section>

        <!-- Access Guide & System Architecture -->
        <section id="panduan-akses" class="py-16 bg-white border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Panduan Akses & Peran Pengguna
                    </h2>
                    <p class="text-sm text-slate-500 mt-2">
                        Sistem ini menggunakan arsitektur multi-tenant dengan database terisolasi untuk setiap sekolah.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <!-- Card 1: Publik -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold mb-4">
                            1
                        </div>
                        <h3 class="font-heading font-bold text-lg text-slate-900 mb-2">Publik & Calon Siswa</h3>
                        <p class="text-sm text-slate-600 leading-relaxed mb-4">
                            Masyarakat dapat mengakses profil sekolah, jurusan, berita, agenda, prestasi, dan pendaftaran online (SPMB) tanpa memerlukan otentikasi login.
                        </p>
                        <p class="text-xs font-semibold text-blue-700">
                            URL Akses: <code>/{slug-sekolah}</code>
                        </p>
                    </div>

                    <!-- Card 2: Admin Sekolah -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold mb-4">
                            2
                        </div>
                        <h3 class="font-heading font-bold text-lg text-slate-900 mb-2">Administrator Sekolah</h3>
                        <p class="text-sm text-slate-600 leading-relaxed mb-4">
                            Pengelola internal sekolah mengelola konten slider, guru, fasilitas, artikel, dan memverifikasi calon pendaftar siswa baru pada basis data sekolahnya.
                        </p>
                        <p class="text-xs font-semibold text-indigo-700">
                            URL Akses: <code>/{slug-sekolah}/admin</code> atau <code>/admin</code>
                        </p>
                    </div>

                    <!-- Card 3: Super Admin -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold mb-4">
                            3
                        </div>
                        <h3 class="font-heading font-bold text-lg text-slate-900 mb-2">Super Administrator</h3>
                        <p class="text-sm text-slate-600 leading-relaxed mb-4">
                            Mengelola pendaftaran sekolah baru, pembuatan database otomatis, aktivasi tenant, dan konfigurasi platform sentral.
                        </p>
                        <p class="text-xs font-semibold text-purple-700">
                            URL Akses: <code>/superadmin</code> atau <code>/superadmin/login</code>
                        </p>
                    </div>

                </div>

                <!-- Credential Box for Quick Testing -->
                <div class="mt-12 bg-slate-900 text-white rounded-2xl p-6 sm:p-8 shadow-xl">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                        <div>
                            <span class="inline-block px-2.5 py-1 bg-amber-400/20 text-amber-300 text-xs font-bold rounded-md mb-2">
                                Informasi Akun Pengujian
                            </span>
                            <h3 class="font-heading text-xl font-bold text-white">Kredensial Login Tersedia</h3>
                            <p class="text-sm text-slate-400 mt-1 max-w-xl">
                                Gunakan kredensial di bawah untuk mencoba masuk ke panel Super Admin atau panel Administrator Sekolah SMKN 2 Bandung.
                            </p>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-mono">
                            <!-- Super Admin Info -->
                            <div class="bg-slate-800/90 p-4 rounded-xl border border-slate-700">
                                <p class="text-slate-400 font-sans font-semibold mb-1">Super Administrator</p>
                                <p><span class="text-slate-500">Email:</span> superadmin@admin.com</p>
                                <p><span class="text-slate-500">Password:</span> password123</p>
                                <a href="{{ route('superadmin.login') }}" class="mt-2 inline-block text-blue-400 hover:text-blue-300 font-sans font-semibold">
                                    Buka Login Super Admin &rarr;
                                </a>
                            </div>

                            <!-- Tenant Admin Info -->
                            <div class="bg-slate-800/90 p-4 rounded-xl border border-slate-700">
                                <p class="text-slate-400 font-sans font-semibold mb-1">Admin SMKN 2 Bandung</p>
                                <p><span class="text-slate-500">Email:</span> admin@smkn2bdg.test</p>
                                <p><span class="text-slate-500">Password:</span> password</p>
                                <a href="{{ route('admin.shortcut') }}" class="mt-2 inline-block text-blue-400 hover:text-blue-300 font-sans font-semibold">
                                    Buka Login Admin Sekolah &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 text-xs py-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; {{ date('Y') }} Platform Website Sekolah Terpadu. Seluruh hak cipta dilindungi undang-undang.</p>
            <div class="flex items-center space-x-6 text-slate-400">
                <a href="{{ route('superadmin.login') }}" class="hover:text-white transition">Login Super Admin</a>
                <a href="{{ route('admin.shortcut') }}" class="hover:text-white transition">Login Admin Sekolah</a>
                <a href="#direktori" class="hover:text-white transition">Kembali ke Atas</a>
            </div>
        </div>
    </footer>

</body>
</html>
