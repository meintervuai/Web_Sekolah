<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') | {{ app()->bound('tenant') ? app('tenant')->nama_sekolah : 'Portal Sekolah' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        /* Sleek custom scrollbar for dark admin sidebar */
        .admin-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .admin-scrollbar::-webkit-scrollbar-track {
            background: #0f172a;
        }
        .admin-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 9999px;
        }
        .admin-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }
        .admin-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #334155 #0f172a;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-full bg-slate-50 text-slate-800" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex flex-col lg:flex-row">
        
        <!-- Mobile Sidebar Backdrop -->
        <div 
            x-show="sidebarOpen" 
            x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false" 
            class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-xs lg:hidden"
            style="display: none;"
            aria-hidden="true"
        ></div>

        <!-- Sidebar Navigation (Sticky on desktop with its own independent scroll) -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 w-72 h-screen bg-slate-900 text-slate-200 flex flex-col shrink-0 transition-transform duration-200 ease-in-out lg:sticky lg:top-0 border-r border-slate-800"
        >
            @php
                $adminLogo = \App\Models\Tenant\PengaturanUmum::ambil('logo', app('tenant')->data['logo'] ?? '');
            @endphp
            <!-- Logo Header -->
            <div class="h-20 shrink-0 flex items-center justify-between px-5 border-b border-slate-800/80 bg-slate-950/80">
                <a href="{{ route('tenant.admin.dashboard', ['tenant' => app('tenant')->slug]) }}" class="flex items-center gap-3 group min-w-0">
                    @if(!empty($adminLogo))
                        <div class="w-10 h-10 rounded-xl bg-white p-1 border border-slate-700/60 shadow-sm flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                            <img src="{{ $adminLogo }}" alt="Logo {{ app('tenant')->nama_sekolah }}" class="w-full h-full object-contain">
                        </div>
                    @else
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-700 to-indigo-700 flex items-center justify-center text-white font-bold text-lg shadow-sm group-hover:scale-105 transition-transform shrink-0">
                            <svg class="w-5 h-5 fill-none stroke-current" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="overflow-hidden min-w-0">
                        <div class="font-bold text-white text-xs leading-tight truncate group-hover:text-blue-300 transition-colors">{{ app('tenant')->nama_sekolah }}</div>
                        <div class="text-[10px] text-blue-400 font-semibold tracking-wide mt-0.5">Panel Admin CMS</div>
                    </div>
                </a>
                <button 
                    type="button" 
                    @click="sidebarOpen = false" 
                    class="lg:hidden p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none"
                    aria-label="Tutup Menu"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links with ID for Persistent Scroll -->
            <nav id="adminSidebarNav" class="flex-1 px-3.5 py-4 space-y-1 overflow-y-auto overscroll-contain admin-scrollbar">
                <!-- Dashboard -->
                <a 
                    href="{{ route('tenant.admin.dashboard', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-colors {{ request()->routeIs('tenant.admin.dashboard') ? 'bg-blue-700 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard Utama</span>
                </a>

                <!-- 1. Navigasi: Beranda -->
                <div class="pt-3 px-3 pb-1.5 text-[10px] font-extrabold uppercase tracking-wider text-slate-500 flex items-center justify-between">
                    <span>1. Navigasi Beranda</span>
                </div>
                <a 
                    href="{{ route('tenant.admin.slider.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('tenant.admin.slider.*') ? 'bg-blue-700 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Slider Banner Beranda</span>
                </a>
                <a 
                    href="{{ route('tenant.admin.pengaturan.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('tenant.admin.pengaturan.*') ? 'bg-blue-700 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span>Statistik & Identitas</span>
                </a>

                <!-- 2. Navigasi: Profil Sekolah -->
                <div class="pt-3 px-3 pb-1.5 text-[10px] font-extrabold uppercase tracking-wider text-slate-500 flex items-center justify-between">
                    <span>2. Navigasi Profil</span>
                </div>
                <a 
                    href="{{ route('tenant.admin.profil.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('tenant.admin.profil.*') ? 'bg-blue-700 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Profil & Visi Misi</span>
                </a>
                <a 
                    href="{{ route('tenant.admin.struktur.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('tenant.admin.struktur.*') ? 'bg-blue-700 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>Struktur Organisasi</span>
                </a>

                <!-- 3. Navigasi: Program Keahlian -->
                <div class="pt-3 px-3 pb-1.5 text-[10px] font-extrabold uppercase tracking-wider text-slate-500 flex items-center justify-between">
                    <span>3. Program Keahlian</span>
                </div>
                <a 
                    href="{{ route('tenant.admin.jurusan.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('tenant.admin.jurusan.*') ? 'bg-blue-700 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span>Kelola Jurusan Kejuruan</span>
                </a>

                <!-- 4. Navigasi: Informasi -->
                <div class="pt-3 px-3 pb-1.5 text-[10px] font-extrabold uppercase tracking-wider text-slate-500 flex items-center justify-between">
                    <span>4. Navigasi Informasi</span>
                </div>
                <a 
                    href="{{ route('tenant.admin.berita.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('tenant.admin.berita.*') ? 'bg-blue-700 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <span>Berita & Artikel</span>
                </a>
                <a 
                    href="{{ route('tenant.admin.pengumuman.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('tenant.admin.pengumuman.*') ? 'bg-blue-700 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                    <span>Pengumuman Resmi</span>
                </a>
                <a 
                    href="{{ route('tenant.admin.agenda.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('tenant.admin.agenda.*') ? 'bg-blue-700 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Agenda Kegiatan</span>
                </a>
                <a 
                    href="{{ route('tenant.admin.galeri.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('tenant.admin.galeri.*') ? 'bg-blue-700 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Galeri Foto & Album</span>
                </a>

                <!-- 5. Navigasi: Kesiswaan -->
                <div class="pt-3 px-3 pb-1.5 text-[10px] font-extrabold uppercase tracking-wider text-slate-500 flex items-center justify-between">
                    <span>5. Navigasi Kesiswaan</span>
                </div>
                <a 
                    href="{{ route('tenant.admin.prestasi.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('tenant.admin.prestasi.*') ? 'bg-blue-700 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                    <span>Prestasi Siswa</span>
                </a>
                <a 
                    href="{{ route('tenant.admin.ekskul.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('tenant.admin.ekskul.*') ? 'bg-blue-700 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>Ekstrakurikuler</span>
                </a>

                <!-- 6. Navigasi: Guru & Staf -->
                <div class="pt-3 px-3 pb-1.5 text-[10px] font-extrabold uppercase tracking-wider text-slate-500 flex items-center justify-between">
                    <span>6. Guru & Staf</span>
                </div>
                <a 
                    href="{{ route('tenant.admin.guru.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('tenant.admin.guru.*') ? 'bg-blue-700 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Direktori Guru & Staf</span>
                </a>

                <!-- 7. Navigasi: Fasilitas -->
                <div class="pt-3 px-3 pb-1.5 text-[10px] font-extrabold uppercase tracking-wider text-slate-500 flex items-center justify-between">
                    <span>7. Fasilitas Sekolah</span>
                </div>
                <a 
                    href="{{ route('tenant.admin.fasilitas.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('tenant.admin.fasilitas.*') ? 'bg-blue-700 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Sarana & Lab Praktik</span>
                </a>

                <!-- 8. Navigasi: SPMB 2026 -->
                <div class="pt-3 px-3 pb-1.5 text-[10px] font-extrabold uppercase tracking-wider text-slate-500 flex items-center justify-between">
                    <span>8. Navigasi SPMB</span>
                </div>
                <a 
                    href="{{ route('tenant.admin.spmb.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('tenant.admin.spmb.*') ? 'bg-blue-700 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Informasi SPMB / PPDB</span>
                </a>

                <!-- Media & File Manager -->
                <div class="pt-3 px-3 pb-1.5 text-[10px] font-extrabold uppercase tracking-wider text-slate-500 flex items-center justify-between">
                    <span>10. Media & Dokumen</span>
                </div>
                <a 
                    href="{{ route('tenant.admin.media.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('tenant.admin.media.*') ? 'bg-blue-700 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Media & Manajemen Berkas</span>
                </a>

                <div class="pt-4 px-3 pb-1.5 text-[10px] font-extrabold uppercase tracking-wider text-slate-500">
                    Akses Cepat
                </div>

                <!-- Tinjau Website Publik -->
                <a 
                    href="{{ url(app('tenant')->slug) }}" 
                    target="_blank" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-300 hover:bg-slate-800 hover:text-white transition-colors"
                >
                    <svg class="w-4 h-4 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    <span>Lihat Website Sekolah</span>
                </a>
            </nav>

            <!-- User Footer Profile & Logout -->
            <div class="p-4 border-t border-slate-800 bg-slate-950/40">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div class="w-9 h-9 rounded-lg bg-blue-600/30 border border-blue-500/40 text-blue-400 flex items-center justify-center font-bold text-xs shrink-0">
                            {{ substr(auth('tenant_admin')->user()->nama ?? 'A', 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <div class="text-sm font-medium text-white truncate">{{ auth('tenant_admin')->user()->nama ?? 'Admin Sekolah' }}</div>
                            <div class="text-xs text-slate-400 truncate">{{ auth('tenant_admin')->user()->email ?? 'admin@smkn2bdg.test' }}</div>
                        </div>
                    </div>
                    <form action="{{ route('tenant.admin.logout', ['tenant' => app('tenant')->slug]) }}" method="POST">
                        @csrf
                        <button 
                            type="submit" 
                            class="p-2 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-slate-800 transition-colors cursor-pointer"
                            title="Keluar dari Panel Admin"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0">
            
            <!-- Top Bar Header -->
            <header class="h-16 bg-white border-b border-slate-200/80 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-30 shadow-2xs">
                <div class="flex items-center gap-3">
                    <button 
                        type="button" 
                        @click="sidebarOpen = true" 
                        class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 focus:outline-none"
                        aria-label="Buka Navigasi"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h2 class="text-base sm:text-lg font-bold text-slate-900 leading-tight">
                        @yield('header_title', 'Panel Admin Sekolah')
                    </h2>
                </div>

                <div class="flex items-center gap-3">
                    <a 
                        href="{{ url(app('tenant')->slug) }}" 
                        target="_blank" 
                        class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition"
                    >
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>Pratinjau Publik</span>
                    </a>
                </div>
            </header>

            <!-- Page Content Body -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <!-- Flash Alerts -->
                @if (session('sukses'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>{{ session('sukses') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
    <script>
        // Mempertahankan posisi scroll sidebar saat klik navigasi (agar tidak reset ke atas)
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarNav = document.getElementById('adminSidebarNav');
            if (sidebarNav) {
                const savedScroll = sessionStorage.getItem('admin_sidebar_scroll');
                if (savedScroll !== null) {
                    sidebarNav.scrollTop = parseInt(savedScroll, 10);
                }
                sidebarNav.addEventListener('scroll', function () {
                    sessionStorage.setItem('admin_sidebar_scroll', sidebarNav.scrollTop);
                }, { passive: true });
            }
        });
    </script>
</body>
</html>
