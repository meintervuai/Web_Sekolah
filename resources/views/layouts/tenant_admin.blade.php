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
                <a href="{{ route('tenant.admin.pengaturan.index', ['tenant' => app('tenant')->slug]) }}" class="flex items-center gap-3 group min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-slate-50 p-1 border border-slate-200 flex items-center justify-center shrink-0 group-hover:border-primary transition-colors overflow-hidden">
                        <img src="{{ !empty($adminLogo) ? $adminLogo : asset('images/logo-smkn2.svg') }}" alt="Logo {{ app('tenant')->nama_sekolah }}" class="w-full h-full object-contain">
                    </div>
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
                
                <!-- Section: KONTEN PORTAL -->
                <div class="px-3 pt-2 pb-1.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    Konten Portal
                </div>

                <a
                    href="{{ route('tenant.admin.profil.index', ['tenant' => app('tenant')->slug]) }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.profil.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.profil.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Profil Sekolah</span>
                </a>

                <!-- Section: PENGATURAN TAMPILAN -->
                <div class="px-3 pt-3 pb-1.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    Pengaturan
                </div>

                <a
                    href="{{ route('tenant.admin.pengaturan.index', ['tenant' => app('tenant')->slug]) }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.pengaturan.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.pengaturan.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4 4 4 0 014-4c2 0 3-1 3-3a5 5 0 0110 0c0 2.2-1.8 4-4 4h-2a2 2 0 00-2 2v1a2 2 0 01-2 2h-3z"/>
                        <circle cx="9" cy="8.5" r="1.5"/>
                        <circle cx="15" cy="8.5" r="1.5"/>
                    </svg>
                    <span>Tema &amp; Warna</span>
                </a>

                <!-- Section: PUSAT MEDIA -->
                <div class="px-3 pt-3 pb-1.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    Pusat Berkas
                </div>

                <a
                    href="{{ route('tenant.admin.media.index', ['tenant' => app('tenant')->slug]) }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('tenant.admin.media.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('tenant.admin.media.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Manajemen Media</span>
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
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Floating Toast Notification (Pojok Kanan Bawah, Auto-dismiss 4s) -->
    <div 
        x-data="{
            show: {{ (session('sukses') || session('error')) ? 'true' : 'false' }},
            type: '{{ session('sukses') ? 'sukses' : (session('error') ? 'error' : '') }}',
            message: '{{ addslashes(session('sukses') ?: session('error') ?: '') }}',
            init() {
                if (this.show) {
                    setTimeout(() => { this.show = false; }, 4000);
                }
            }
        }"
        x-show="show"
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-4 opacity-0 scale-95"
        x-transition:enter-end="translate-y-0 opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        x-cloak
        class="fixed bottom-6 right-6 z-50 max-w-sm w-full pointer-events-auto"
        role="alert"
    >
        <div 
            class="flex items-start gap-3 p-4 rounded-2xl shadow-xl border bg-white"
            :class="type === 'sukses' ? 'border-emerald-200/90 text-slate-800' : 'border-rose-200/90 text-slate-800'"
        >
            <div 
                class="w-7 h-7 rounded-xl flex items-center justify-center shrink-0 mt-0.5"
                :class="type === 'sukses' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600'"
            >
                <template x-if="type === 'sukses'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </template>
                <template x-if="type === 'error'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </template>
            </div>

            <div class="flex-1 min-w-0 pr-1">
                <div class="text-xs font-bold text-slate-900" x-text="type === 'sukses' ? 'Berhasil' : 'Pemberitahuan'"></div>
                <div class="text-xs text-slate-600 mt-0.5 leading-relaxed break-words" x-text="message"></div>
            </div>

            <button 
                type="button" 
                @click="show = false" 
                class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition cursor-pointer"
                aria-label="Tutup"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

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

