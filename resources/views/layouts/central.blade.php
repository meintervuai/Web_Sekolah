<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Super Admin') — Platform Website Sekolah</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full text-slate-800" x-data="{ sidebarOpen: false }">
    <div class="min-h-full flex flex-col lg:flex-row">
        
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

        <!-- Sidebar Navigation (Desktop & Mobile Drawer) -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-slate-200 flex flex-col transition-transform duration-200 ease-in-out lg:static lg:inset-auto lg:z-auto"
        >
            <!-- Logo Header -->
            <div class="h-18 flex items-center justify-between px-6 border-b border-slate-800 bg-slate-950/40">
                <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-sm group-hover:bg-indigo-500 transition-colors">
                        WS
                    </div>
                    <div>
                        <div class="font-bold text-white text-base leading-tight tracking-tight">EduPlatform</div>
                        <div class="text-xs text-indigo-300 font-medium">Super Admin Portal</div>
                    </div>
                </a>
                <button 
                    type="button" 
                    @click="sidebarOpen = false" 
                    class="lg:hidden p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 min-h-[44px] min-w-[44px] flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    aria-label="Tutup Menu Navigasi"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                <div class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                    Menu Utama
                </div>
                
                <!-- Dashboard Link -->
                <a 
                    href="{{ route('superadmin.dashboard') }}" 
                    class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl text-sm font-medium transition-colors min-h-[44px] {{ request()->routeIs('superadmin.dashboard') ? 'bg-indigo-600 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Manajemen Tenant -->
                <a 
                    href="{{ route('superadmin.tenants.index') }}" 
                    class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl text-sm font-medium transition-colors min-h-[44px] {{ request()->routeIs('superadmin.tenants.*') ? 'bg-indigo-600 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Kelola Sekolah (Tenant)</span>
                </a>

                <div class="pt-5 px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                    Aksi Cepat
                </div>

                <!-- Tambah Sekolah -->
                <a 
                    href="{{ route('superadmin.tenants.create') }}" 
                    class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition-colors min-h-[44px]"
                >
                    <svg class="w-5 h-5 flex-shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Daftarkan Sekolah Baru</span>
                </a>
            </nav>

            <!-- User Footer Info & Logout -->
            <div class="p-4 border-t border-slate-800 bg-slate-950/60">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center font-semibold text-white text-sm shrink-0">
                            {{ substr(Auth::guard('superadmin')->user()->nama ?? 'SA', 0, 2) }}
                        </div>
                        <div class="truncate">
                            <div class="text-sm font-medium text-white truncate">{{ Auth::guard('superadmin')->user()->nama ?? 'Super Admin' }}</div>
                            <div class="text-xs text-slate-400 truncate">{{ Auth::guard('superadmin')->user()->email ?? 'admin' }}</div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('superadmin.logout') }}" class="shrink-0">
                        @csrf
                        <button 
                            type="submit" 
                            title="Keluar / Logout"
                            class="p-2.5 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-slate-800 transition-colors min-h-[44px] min-w-[44px] flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-rose-500"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0">
            
            <!-- Topbar Header -->
            <header class="h-18 bg-white border-b border-slate-200/80 px-4 sm:px-6 lg:px-8 flex items-center justify-between sticky top-0 z-30 shadow-2xs">
                <div class="flex items-center gap-3">
                    <!-- Hamburger Toggle -->
                    <button 
                        type="button" 
                        @click="sidebarOpen = true" 
                        class="lg:hidden p-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 min-h-[44px] min-w-[44px] flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-indigo-600"
                        aria-label="Buka Menu"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-lg sm:text-xl font-bold text-slate-900 leading-tight">@yield('page_title', 'Dashboard')</h1>
                        <p class="text-xs text-slate-500 hidden sm:block">@yield('page_subtitle', 'Sistem Manajemen SaaS Website Sekolah Multi-Tenant')</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Central DB Aktif
                    </span>

                    <div class="hidden sm:block text-right">
                        <div class="text-xs font-medium text-slate-700">{{ Auth::guard('superadmin')->user()->nama ?? 'Admin' }}</div>
                        <div class="text-[11px] text-slate-400">Platform Owner</div>
                    </div>
                </div>
            </header>

            <!-- Page Body Area -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
                
                <!-- Flash Notification Alerts -->
                @if (session('sukses'))
                    <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start justify-between gap-3 shadow-2xs">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-medium">{{ session('sukses') }}</span>
                        </div>
                        <button type="button" @click="show = false" class="text-emerald-500 hover:text-emerald-800 p-1 min-h-[36px] min-w-[36px] flex items-center justify-center" aria-label="Tutup notifikasi">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start justify-between gap-3 shadow-2xs">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-medium">{{ session('error') }}</span>
                        </div>
                        <button type="button" @click="show = false" class="text-rose-500 hover:text-rose-800 p-1 min-h-[36px] min-w-[36px] flex items-center justify-center" aria-label="Tutup notifikasi">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 shadow-2xs">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2 font-semibold text-sm">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                Mohon periksa kembali formulir Anda:
                            </div>
                            <button type="button" @click="show = false" class="text-amber-600 hover:text-amber-900 p-1 min-h-[36px] min-w-[36px] flex items-center justify-center" aria-label="Tutup">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-1 text-amber-800 pl-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Simple Footer -->
            <footer class="mt-auto py-5 border-t border-slate-200 bg-white text-center text-xs text-slate-500">
                &copy; {{ date('Y') }} EduPlatform Multi-Tenant SaaS. Dirancang untuk standarisasi website institusi pendidikan.
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
