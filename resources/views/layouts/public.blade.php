<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ $sekolah['nama'] ?? 'Website Sekolah' }}</title>
    
    <!-- Vite for Tailwind CSS & Alpine.js -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Outfit', sans-serif; }
        
        .hero-overlay {
            background: linear-gradient(to right, rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.6));
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased flex flex-col min-h-screen">

    <!-- Top Bar -->
    <div class="bg-indigo-900 text-indigo-100 py-2 text-sm hidden md:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> {{ $sekolah['telepon'] ?? '(022) 7234285' }}</span>
                <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> {{ $sekolah['email'] ?? 'info@sekolah.sch.id' }}</span>
            </div>
            <div class="flex space-x-3">
                <a href="#" class="hover:text-white transition">PPDB</a>
                <a href="#" class="hover:text-white transition">E-Learning</a>
                <a href="#" class="hover:text-white transition">Alumni</a>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav x-data="{ open: false, scrolled: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)"
         :class="{'bg-white shadow-md py-2': scrolled, 'bg-white/90 backdrop-blur-md py-4': !scrolled}" 
         class="sticky top-0 z-50 transition-all duration-300 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 bg-indigo-600 text-white rounded-lg flex items-center justify-center font-bold text-xl group-hover:bg-indigo-700 transition">
                            2
                        </div>
                        <div>
                            <h1 class="font-heading font-bold text-xl leading-tight text-slate-900 group-hover:text-indigo-600 transition">{{ $sekolah['nama'] ?? 'SMK N 2 Bandung' }}</h1>
                            <p class="text-xs text-slate-500 font-medium tracking-wider uppercase">Sekolah Pusat Keunggulan</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-indigo-600 font-medium">Beranda</a>
                    
                    <!-- Dropdown Profil -->
                    <div class="relative group" x-data="{ dropdownOpen: false }" @mouseenter="dropdownOpen = true" @mouseleave="dropdownOpen = false">
                        <button class="flex items-center text-slate-600 hover:text-indigo-600 font-medium transition">
                            Profil <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="dropdownOpen" x-transition.opacity class="absolute top-full left-0 pt-2 w-48">
                            <div class="bg-white rounded-lg shadow-xl border border-slate-100 overflow-hidden py-1">
                                <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600">Sejarah</a>
                                <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600">Visi & Misi</a>
                                <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600">Struktur Organisasi</a>
                                <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600">Fasilitas</a>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="text-slate-600 hover:text-indigo-600 font-medium transition">Akademik</a>
                    <a href="#" class="text-slate-600 hover:text-indigo-600 font-medium transition">Berita</a>
                    <a href="#" class="text-slate-600 hover:text-indigo-600 font-medium transition">Galeri</a>
                    
                    <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-full font-medium transition shadow-md shadow-indigo-200">
                        PPDB 2026
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button @click="open = !open" class="text-slate-600 hover:text-indigo-600 focus:outline-none">
                        <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        <svg x-show="open" style="display: none;" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div x-show="open" style="display: none;" class="md:hidden bg-white border-t border-slate-100 shadow-lg absolute w-full left-0 top-full">
            <div class="px-4 pt-2 pb-6 space-y-1">
                <a href="/" class="block px-3 py-3 rounded-md text-base font-medium text-indigo-600 bg-indigo-50">Beranda</a>
                <a href="#" class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 hover:text-indigo-600 hover:bg-slate-50">Profil Sekolah</a>
                <a href="#" class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 hover:text-indigo-600 hover:bg-slate-50">Akademik & Jurusan</a>
                <a href="#" class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 hover:text-indigo-600 hover:bg-slate-50">Berita & Informasi</a>
                <a href="#" class="block px-3 py-3 mt-4 text-center rounded-md text-base font-medium bg-indigo-600 text-white hover:bg-indigo-700">Daftar PPDB</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-8 border-t-4 border-indigo-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                
                <!-- Identitas -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-12 h-12 bg-white text-indigo-700 rounded-lg flex items-center justify-center font-bold text-2xl">
                            2
                        </div>
                        <div>
                            <h2 class="font-heading font-bold text-2xl text-white">{{ $sekolah['nama'] ?? 'SMK N 2 Bandung' }}</h2>
                            <p class="text-sm text-slate-400">Sekolah Pusat Keunggulan</p>
                        </div>
                    </div>
                    <p class="text-slate-400 mb-6 leading-relaxed max-w-md">
                        {{ $sekolah['deskripsi'] ?? 'Berkomitmen mencetak lulusan yang unggul, berkarakter, dan siap kerja di era industri 4.0.' }}
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Tautan Cepat -->
                <div>
                    <h3 class="font-heading text-white text-lg font-semibold mb-6">Tautan Cepat</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="hover:text-indigo-400 transition flex items-center"><span class="mr-2 text-indigo-500">›</span> Profil Sekolah</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition flex items-center"><span class="mr-2 text-indigo-500">›</span> Data Guru & Staf</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition flex items-center"><span class="mr-2 text-indigo-500">›</span> Prestasi Siswa</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition flex items-center"><span class="mr-2 text-indigo-500">›</span> Kalender Akademik</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition flex items-center"><span class="mr-2 text-indigo-500">›</span> PPDB Online</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h3 class="font-heading text-white text-lg font-semibold mb-6">Kontak Kami</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-indigo-500 mt-1 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>{{ $sekolah['alamat'] ?? 'Jl. Sekolah No.1' }}</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-indigo-500 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>{{ $sekolah['telepon'] ?? '(022) 123456' }}</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-indigo-500 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>{{ $sekolah['email'] ?? 'admin@sekolah.sch.id' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-slate-500">
                <p>&copy; {{ date('Y') }} {{ $sekolah['nama'] ?? 'Sekolah' }}. Hak Cipta Dilindungi.</p>
                <p class="mt-2 md:mt-0">Diberdayakan oleh Platform SaaS Sekolah</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <a href="#" class="fixed bottom-6 right-6 w-14 h-14 bg-green-500 hover:bg-green-600 text-white rounded-full flex items-center justify-center shadow-xl hover:-translate-y-1 transition-all z-40 animate-bounce" style="animation-duration: 3s;">
        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
    </a>
</body>
</html>
