<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50/80 antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') | {{ app()->bound('tenant') ? app('tenant')->nama_sekolah : 'Portal Sekolah' }}</title>
    
    <!-- Taildash Typography: Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #1e293b;
        }
        /* TailDash Smooth Custom Scrollbar */
        .taildash-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .taildash-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .taildash-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 8px;
        }
        .taildash-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .taildash-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Quill WYSIWYG Editor CDN -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <style>
        .ql-toolbar.ql-snow {
            border-top-left-radius: 0.625rem;
            border-top-right-radius: 0.625rem;
            border-color: #e2e8f0;
            background-color: #f8fafc;
            padding: 10px 14px;
        }
        .ql-container.ql-snow {
            border-bottom-left-radius: 0.625rem;
            border-bottom-right-radius: 0.625rem;
            border-color: #e2e8f0;
            background-color: #ffffff;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            min-height: 220px;
        }
        .ql-editor {
            min-height: 220px;
            line-height: 1.65;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-full bg-[#f4f7fb] text-slate-800" x-data="{ sidebarOpen: false, searchOpen: false }">
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
            class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-xs lg:hidden"
            style="display: none;"
            aria-hidden="true"
        ></div>

        <!-- Sidebar Navigation (TailDash Template Styled Sidebar) -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 w-72 h-screen bg-white flex flex-col shrink-0 transition-transform duration-200 ease-in-out lg:sticky lg:top-0 border-r border-slate-200/90 shadow-sm"
        >
            @php
                $adminLogo = \App\Models\Tenant\PengaturanUmum::ambil('logo') ?: (app('tenant')->data['logo'] ?? '');
            @endphp

            <!-- TailDash Brand Header -->
            <div class="h-18 shrink-0 flex items-center justify-between px-6 border-b border-slate-100 bg-white">
                <a href="{{ route('tenant.admin.dashboard', ['tenant' => app('tenant')->slug]) }}" class="flex items-center gap-3 group min-w-0">
                    @if(!empty($adminLogo))
                        <div class="w-9 h-9 rounded-xl bg-slate-50 p-1 border border-slate-200 flex items-center justify-center shrink-0 group-hover:border-primary transition-colors overflow-hidden">
                            <img src="{{ $adminLogo }}" alt="Logo {{ app('tenant')->nama_sekolah }}" class="w-full h-full object-contain">
                        </div>
                    @else
                        <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-sm shrink-0">
                            {{ substr(app('tenant')->nama_sekolah ?? 'S', 0, 1) }}
                        </div>
                    @endif
                    <div class="overflow-hidden min-w-0">
                        <div class="font-bold text-slate-900 text-xs sm:text-sm leading-tight truncate group-hover:text-blue-600 transition-colors">{{ app('tenant')->nama_sekolah }}</div>
                        <div class="text-[10px] text-slate-400 font-semibold tracking-wide uppercase mt-0.5">Admin Management</div>
                    </div>
                </a>
                <button 
                    type="button" 
                    @click="sidebarOpen = false" 
                    class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 focus:outline-none"
                    aria-label="Tutup Menu"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- TailDash Menu Navigation -->
            <nav id="adminSidebarNav" class="flex-1 px-4 py-4 space-y-1 overflow-y-auto overscroll-contain taildash-scrollbar text-xs">
                
                <!-- Section: MENU -->
                <div class="px-3 pt-2 pb-1.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    Menu Utama
                </div>
                
                <a 
                    href="{{ route('tenant.admin.dashboard', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.dashboard') ? 'bg-blue-50 text-blue-600 shadow-2xs font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.dashboard') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Dashboard</span>
                    </div>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-blue-100 text-blue-700">Utama</span>
                </a>

                <!-- Section: TAMPILAN BERANDA -->
                <div class="px-3 pt-4 pb-1.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    Tampilan Beranda
                </div>
                
                <a 
                    href="{{ route('tenant.admin.slider.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.slider.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.slider.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Slider Banner Hero</span>
                </a>
                <a 
                    href="{{ route('tenant.admin.pengaturan.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.pengaturan.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.pengaturan.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span>Identitas & Statistik</span>
                </a>
                <a 
                    href="{{ route('tenant.admin.profil.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.profil.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.profil.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Profil & Visi Misi</span>
                </a>
                <a 
                    href="{{ route('tenant.admin.struktur.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.struktur.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.struktur.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>Struktur Organisasi</span>
                </a>
                <a 
                    href="{{ route('tenant.admin.jurusan.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.jurusan.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.jurusan.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span>Program Keahlian</span>
                </a>

                <!-- Section: KONTEN & PUBLIKASI -->
                <div class="px-3 pt-4 pb-1.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    Konten & Publikasi
                </div>
                
                <a 
                    href="{{ route('tenant.admin.berita.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.berita.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.berita.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <span>Berita & Artikel</span>
                </a>
                <a 
                    href="{{ route('tenant.admin.pengumuman.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.pengumuman.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.pengumuman.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                    <span>Pengumuman</span>
                </a>
                <a 
                    href="{{ route('tenant.admin.agenda.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.agenda.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.agenda.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Agenda Acara</span>
                </a>
                <a 
                    href="{{ route('tenant.admin.galeri.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.galeri.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.galeri.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Galeri Dokumentasi</span>
                </a>

                <!-- Section: KESISWAAN & SDM -->
                <div class="px-3 pt-4 pb-1.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    Kesiswaan & SDM
                </div>
                
                <a 
                    href="{{ route('tenant.admin.prestasi.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.prestasi.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.prestasi.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                    <span>Prestasi Siswa</span>
                </a>
                <a 
                    href="{{ route('tenant.admin.ekskul.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.ekskul.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.ekskul.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>Ekstrakurikuler</span>
                </a>
                <a 
                    href="{{ route('tenant.admin.guru.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.guru.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.guru.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Direktori Guru & Staf</span>
                </a>
                <a 
                    href="{{ route('tenant.admin.fasilitas.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.fasilitas.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.fasilitas.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Fasilitas & Lab</span>
                </a>
                <a 
                    href="{{ route('tenant.admin.spmb.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.spmb.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.spmb.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Informasi SPMB</span>
                </a>
                <a 
                    href="{{ route('tenant.admin.kontak.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.kontak.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.kontak.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>Pesan Pengunjung</span>
                </a>

                <!-- Section: MANAJEMEN BERKAS -->
                <div class="px-3 pt-4 pb-1.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    Sistem & Media
                </div>
                
                <a 
                    href="{{ route('tenant.admin.media.index', ['tenant' => app('tenant')->slug]) }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.media.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.media.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Media & Manajemen Berkas</span>
                </a>
            </nav>

            <!-- TailDash User Profile Card at Sidebar Footer -->
            <div class="p-4 border-t border-slate-100 bg-slate-50/60">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-xs shadow-xs shrink-0">
                            {{ substr(auth('tenant_admin')->user()->nama ?? 'A', 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <div class="text-xs font-bold text-slate-900 truncate">{{ auth('tenant_admin')->user()->nama ?? 'Admin Sekolah' }}</div>
                            <div class="text-[10px] text-slate-500 truncate">{{ auth('tenant_admin')->user()->email ?? 'admin@sekolah.sch.id' }}</div>
                        </div>
                    </div>
                    <form action="{{ route('tenant.admin.logout', ['tenant' => app('tenant')->slug]) }}" method="POST">
                        @csrf
                        <button 
                            type="submit" 
                            class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer"
                            title="Keluar dari Panel Admin"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0">
            
            <!-- TailDash Top Header (h-18 / 72px) -->
            <header class="h-18 bg-white border-b border-slate-200/90 flex items-center justify-between px-6 sm:px-8 sticky top-0 z-30 shadow-2xs">
                <div class="flex items-center gap-4">
                    <button 
                        type="button" 
                        @click="sidebarOpen = true" 
                        class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 focus:outline-none"
                        aria-label="Buka Navigasi"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <!-- Breadcrumbs TailDash Style -->
                    <div>
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                            <span>Admin Portal</span>
                            <span class="text-slate-300">/</span>
                            <span class="text-blue-600">@yield('title', 'Dashboard')</span>
                        </div>
                        <h1 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight leading-tight mt-0.5">
                            @yield('header_title', 'Dashboard')
                        </h1>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Quick View Website Button TailDash pill -->
                    <a 
                        href="{{ url(app('tenant')->slug) }}" 
                        target="_blank" 
                        class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 shadow-2xs transition"
                    >
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span class="hidden sm:inline">Kunjungi Website</span>
                    </a>
                </div>
            </header>

            <!-- Page Content Body TailDash Padding 24px - 32px -->
            <main class="flex-1 p-5 sm:p-7 lg:p-8">
                <!-- Flash Alerts TailDash -->
                @if (session('sukses'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs sm:text-sm font-medium flex items-center justify-between shadow-2xs">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-xs shrink-0">✓</span>
                            <span>{{ session('sukses') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 text-xs sm:text-sm font-medium flex items-center justify-between shadow-2xs">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full bg-rose-500 text-white flex items-center justify-center font-bold text-xs shrink-0">✕</span>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Quill WYSIWYG Editor JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    @stack('scripts')
    <script>
        // Mempertahankan posisi scroll sidebar saat klik navigasi
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

