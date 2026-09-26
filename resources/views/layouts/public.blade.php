<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beranda') - {{ $sekolah['nama'] ?? 'SMK Negeri 2 Bandung' }}</title>
    <meta name="description" content="@yield('meta_description', $sekolah['deskripsi'] ?? 'Website resmi SMK Negeri 2 Bandung - Sekolah Menengah Kejuruan di Kota Bandung.')">
    
    <!-- Vite for Tailwind CSS & Alpine.js -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --theme-color: {{ $sekolah['warna_tema'] ?? '#1E3A8A' }};
            --theme-color-dark: color-mix(in srgb, var(--theme-color) 80%, black);
            --theme-color-light: color-mix(in srgb, var(--theme-color) 15%, white);
            --theme-color-transparent: color-mix(in srgb, var(--theme-color) 20%, transparent);
            --theme-accent: {{ $sekolah['warna_aksen'] ?? '#0284C7' }};
        }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Outfit', sans-serif; }
        
        .container-custom {
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 20px;
            padding-right: 20px;
        }
        @media (min-width: 640px) {
            .container-custom {
                padding-left: 32px;
                padding-right: 32px;
            }
        }
        @media (min-width: 1024px) {
            .container-custom {
                padding-left: 40px;
                padding-right: 40px;
            }
        }

        .section-py {
            padding-top: 48px;
            padding-bottom: 48px;
        }
        @media (min-width: 640px) {
            .section-py {
                padding-top: 64px;
                padding-bottom: 64px;
            }
        }
        @media (min-width: 1024px) {
            .section-py {
                padding-top: 88px;
                padding-bottom: 88px;
            }
        }

        .card-radius {
            border-radius: 16px;
        }
        .btn-radius {
            border-radius: 10px;
        }

        .theme-bg { background-color: var(--theme-color); }
        .theme-bg-dark { background-color: var(--theme-color-dark); }
        .theme-text { color: var(--theme-color); }
        .theme-border { border-color: var(--theme-color); }

        /* Card Hover Behavior */
        .hover-card {
            transition: transform 200ms ease, box-shadow 200ms ease;
        }
        @media (prefers-reduced-motion: no-preference) {
            .hover-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 16px 28px -6px rgba(15, 23, 42, 0.12), 0 8px 12px -4px rgba(15, 23, 42, 0.06);
            }
        }
        
        /* Hide Scrollbar but keep functionality */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-900 antialiased flex flex-col min-h-screen selection:bg-blue-600 selection:text-white"
      x-data="{ mobileNav: false, lightboxOpen: false, lightboxSrc: '', lightboxCaption: '' }"
      @keydown.escape.window="mobileNav = false; lightboxOpen = false">

    <!-- Flash Messages (Toast) -->
    @if(session('sukses'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
             class="fixed bottom-6 right-6 z-50 bg-emerald-600 text-white px-6 py-4 rounded-xl shadow-xl flex items-center space-x-3 transition-all"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <div>
                <p class="font-bold text-sm">Berhasil!</p>
                <p class="text-xs text-emerald-100">{{ session('sukses') }}</p>
            </div>
            <button @click="show = false" class="text-emerald-200 hover:text-white ml-2">&times;</button>
        </div>
    @endif

    <!-- Top Bar -->
    <header class="bg-slate-900 text-slate-300 text-xs py-2 hidden md:block border-b border-slate-800">
        <div class="container-custom flex justify-between items-center">
            <div class="flex items-center space-x-6">
                <span class="flex items-center text-slate-300">
                    <svg class="w-3.5 h-3.5 mr-1.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ $sekolah['telepon'] ?? '(022) 7234285' }}
                </span>
                <span class="flex items-center text-slate-300">
                    <svg class="w-3.5 h-3.5 mr-1.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ $sekolah['email'] ?? 'humas@smkn2bandung.sch.id' }}
                </span>
                <span class="flex items-center text-slate-400 hidden lg:inline-flex">
                    <svg class="w-3.5 h-3.5 mr-1.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $sekolah['jam_layanan'] ?? 'Senin - Jumat: 07.00 - 16.00 WIB' }}
                </span>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-slate-400">NPSN: <strong class="text-white">{{ $sekolah['npsn'] ?? '20219146' }}</strong></span>
                <span class="text-slate-600">|</span>
                <span class="text-slate-400">Akreditasi: <strong class="text-emerald-400">{{ $sekolah['akreditasi'] ?? 'A' }}</strong></span>
                <span class="text-slate-600">|</span>
                <a href="{{ url(app('tenant')->slug . '/kontak') }}" class="hover:text-blue-400 transition">Bantuan & Lokasi</a>
            </div>
        </div>
    </header>

    <!-- Main Navigation Bar -->
    <nav x-data="{ scrolled: false }"
         @scroll.window="scrolled = (window.pageYOffset > 15)"
         :class="scrolled ? 'bg-white shadow-md py-2.5' : 'bg-white/95 backdrop-blur-md py-4 border-b border-slate-100'"
         class="sticky top-0 z-40 transition-all duration-300">
        <div class="container-custom flex justify-between items-center">
            
            <!-- Logo & School Brand -->
            <a href="{{ url(app('tenant')->slug) }}" class="flex items-center space-x-3.5 group">
                <div class="w-11 h-11 bg-gradient-to-br from-blue-900 to-indigo-700 text-white rounded-xl flex items-center justify-center font-bold text-xl shadow-md group-hover:scale-105 transition-transform duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                </div>
                <div>
                    <h1 class="font-heading font-extrabold text-lg sm:text-xl text-slate-900 leading-tight group-hover:text-blue-900 transition-colors">
                        {{ $sekolah['nama'] ?? 'SMK Negeri 2 Bandung' }}
                    </h1>
                    <p class="text-xs text-slate-500 font-medium tracking-wide">
                        {{ $sekolah['slogan'] ?? 'Sekolah Menengah Kejuruan' }}
                    </p>
                </div>
            </a>

            <!-- Desktop Menu Items -->
            @php
                $navMenus = $menus ?? \App\Models\Tenant\Menu::whereNull('parent_id')
                    ->where('is_aktif', true)
                    ->with(['children' => function ($query) {
                        $query->where('is_aktif', true)->orderBy('urutan');
                    }])
                    ->orderBy('urutan')
                    ->get();
                
                $navMenus = $navMenus->reject(fn($menu) => str_contains(strtolower($menu->name), 'spmb'))
                    ->map(function($menu) {
                        $menu->setRelation('children', $menu->children->reject(fn($child) => 
                            str_contains(strtolower($child->name), 'spmb') ||
                            strtolower(trim($child->name)) === 'profil lengkap' ||
                            strtolower(trim($child->name)) === 'semua program keahlian'
                        ));
                        
                        // Override URL if it's the parent of Profil or Jurusan
                        if (strtolower(trim($menu->name)) === 'profil sekolah' || strtolower(trim($menu->name)) === 'profil') {
                            $menu->url = '/profil';
                        } elseif (strtolower(trim($menu->name)) === 'program keahlian') {
                            $menu->url = '/program-keahlian';
                        }
                        
                        return $menu;
                    });
                $currentPath = trim(request()->path(), '/');
                $tenantSlug = trim(app('tenant')->slug, '/');
                $relativePath = trim(\Illuminate\Support\Str::after($currentPath, $tenantSlug), '/');
                $isPathActive = function ($path) use ($relativePath) {
                    $path = trim($path, '/');
                    return $path === ''
                        ? $relativePath === ''
                        : ($relativePath === $path || str_starts_with($relativePath, $path . '/'));
                };
            @endphp

            <div class="hidden lg:flex items-center space-x-1">
                @foreach($navMenus as $menu)
                    @php
                        $path = ltrim($menu->url, '/');
                        $menuUrl = $menu->url === '#' ? '#' : url(app('tenant')->slug . ($path ? '/' . $path : ''));
                        $menuIsActive = $isPathActive($path) || $menu->children->contains(fn ($child) => $isPathActive($child->url));
                    @endphp

                    @if($menu->children->isEmpty())
                        <a href="{{ $menuUrl }}" 
                           @class(['px-3.5 py-2 rounded-lg text-sm font-semibold transition-colors', 'bg-slate-900 text-white shadow-sm hover:bg-slate-800' => $menuIsActive, 'text-slate-700 hover:text-blue-900 hover:bg-slate-100' => !$menuIsActive])>
                            {{ $menu->name }}
                        </a>
                    @else
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                            <a href="{{ $menuUrl }}" @class(['flex items-center px-3.5 py-2 rounded-lg text-sm font-semibold transition-colors focus:outline-none', 'bg-slate-900 text-white shadow-sm hover:bg-slate-800' => $menuIsActive, 'text-slate-700 hover:text-blue-900 hover:bg-slate-100' => !$menuIsActive])>
                                <span>{{ $menu->name }}</span>
                                <svg class="w-4 h-4 ml-1 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </a>
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-180"
                                 x-transition:enter-start="opacity-0 translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-120"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-2"
                                 style="display: none;"
                                 class="absolute top-full left-0 w-64 pt-2 z-50">
                                <div class="bg-white rounded-2xl shadow-xl border border-slate-100 py-2.5 overflow-hidden">
                                    @foreach($menu->children as $child)
                                        @php
                                            $childPath = ltrim($child->url, '/');
                                            $childUrl = $child->url === '#' ? '#' : url(app('tenant')->slug . ($childPath ? '/' . $childPath : ''));
                                        @endphp
                                        <a href="{{ $childUrl }}" @class(['block px-4 py-2.5 text-sm font-medium transition-colors', 'bg-slate-100 text-slate-950 font-bold' => $isPathActive($childPath), 'text-slate-700 hover:bg-blue-50 hover:text-blue-900' => !$isPathActive($childPath)])>
                                            {{ $child->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

                <!-- CTA SPMB -->
                <a href="{{ url(app('tenant')->slug . '/spmb') }}" 
                   class="ml-3 inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-700 to-indigo-700 hover:from-blue-800 hover:to-indigo-800 text-white text-sm font-bold btn-radius shadow-md shadow-blue-900/20 transition-all hover:shadow-lg">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    SPMB 2026
                </a>
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="lg:hidden flex items-center space-x-2">
                <a href="{{ url(app('tenant')->slug . '/spmb') }}" @class(['px-3 py-1.5 text-xs font-bold btn-radius transition-colors', 'bg-slate-900 text-white' => $isPathActive('spmb'), 'bg-blue-700 text-white hover:bg-blue-800' => !$isPathActive('spmb')])>
                    SPMB 2026
                </a>
                <button @click="mobileNav = true" 
                        class="p-2 rounded-xl text-slate-700 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-600"
                        aria-label="Buka Menu Navigasi">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Drawer Menu (Accessible with Escape & Backdrop) -->
    <div x-show="mobileNav" style="display: none;" class="fixed inset-0 z-50 lg:hidden">
        <!-- Backdrop -->
        <div x-show="mobileNav"
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileNav = false"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <!-- Drawer Content -->
        <div x-show="mobileNav"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed right-0 top-0 bottom-0 w-5/6 max-w-sm bg-white shadow-2xl z-50 flex flex-col overflow-y-auto">
            
            <!-- Drawer Header -->
            <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-blue-900 text-white rounded-lg flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
                    </div>
                    <div>
                        <h2 class="font-heading font-bold text-base text-slate-900 leading-tight">SMK Negeri 2 Bandung</h2>
                        <p class="text-xs text-slate-500">Menu Navigasi</p>
                    </div>
                </div>
                <button @click="mobileNav = false" class="p-2 text-slate-400 hover:text-slate-700 rounded-lg" aria-label="Tutup Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Drawer Links -->
            <div class="p-5 space-y-2 flex-1">
                @foreach($navMenus as $menu)
                    @php
                        $path = ltrim($menu->url, '/');
                        $menuUrl = $menu->url === '#' ? '#' : url(app('tenant')->slug . ($path ? '/' . $path : ''));
                    @endphp
                    @if($menu->children->isEmpty())
                        <a href="{{ $menuUrl }}" 
                           @click="mobileNav = false"
                           @class(['block px-3.5 py-2.5 rounded-xl text-sm font-semibold transition', 'bg-slate-900 text-white' => $menuIsActive, 'text-slate-800 hover:bg-blue-50 hover:text-blue-900' => !$menuIsActive])>
                            {{ $menu->name }}
                        </a>
                    @else
                        <div x-data="{ expanded: false }" class="rounded-xl overflow-hidden border border-slate-100">
                            <div class="w-full flex justify-between items-center text-slate-800 hover:bg-slate-50 transition">
                                <a href="{{ $menuUrl }}" @click="mobileNav = false" class="flex-1 px-3.5 py-2.5 text-sm font-semibold">
                                    {{ $menu->name }}
                                </a>
                                <button @click="expanded = !expanded" class="p-2.5">
                                    <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': expanded}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                            </div>
                            <div x-show="expanded" x-transition.opacity class="bg-slate-50 px-3 py-1 space-y-1 border-t border-slate-100">
                                @foreach($menu->children as $child)
                                    @php
                                        $childPath = ltrim($child->url, '/');
                                        $childUrl = $child->url === '#' ? '#' : url(app('tenant')->slug . ($childPath ? '/' . $childPath : ''));
                                    @endphp
                                    <a href="{{ $childUrl }}" 
                                       @click="mobileNav = false"
                                       @class(['block px-3 py-2 text-xs rounded-lg transition', 'bg-slate-200 text-slate-950 font-bold' => $isPathActive($childPath), 'text-slate-700 font-medium hover:text-blue-900 hover:bg-white' => !$isPathActive($childPath)])>
                                        {{ $child->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Drawer Footer CTA -->
            <div class="p-5 border-t border-slate-100 bg-slate-50">
                <a href="{{ url(app('tenant')->slug . '/spmb') }}" 
                   @click="mobileNav = false"
                   class="w-full py-3 bg-blue-900 hover:bg-blue-800 text-white font-bold text-sm btn-radius flex items-center justify-center shadow-md">
                    Daftar SPMB Online 2026
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Body -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Global Lightbox Modal -->
    <div x-show="lightboxOpen" style="display: none;" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-sm"
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <button @click="lightboxOpen = false" class="absolute top-5 right-5 text-white/80 hover:text-white p-2">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div class="max-w-4xl max-h-[85vh] flex flex-col items-center" @click.outside="lightboxOpen = false">
            <img :src="lightboxSrc" class="max-h-[75vh] w-auto object-contain rounded-xl shadow-2xl" alt="Pratinjau Gambar">
            <p x-text="lightboxCaption" class="mt-3 text-sm text-slate-300 text-center font-medium"></p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-12 border-t border-slate-800 mt-auto">
        <div class="container-custom">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-slate-800">
                <!-- Col 1: School Identity -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-600 text-white rounded-lg flex items-center justify-center font-bold text-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
                        </div>
                        <div>
                            <p class="font-heading font-bold text-lg text-white leading-tight">{{ $sekolah['nama'] ?? 'SMK Negeri 2 Bandung' }}</p>
                            <p class="text-xs text-blue-400 font-medium">Sekolah Menengah Kejuruan</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Lembaga pendidikan kejuruan berwawasan global, membekali generasi muda dengan kompetensi teknologi, rekayasa, dan karakter profesional berstandar industri.
                    </p>
                    <div class="text-xs text-slate-400 space-y-1">
                        <p>NPSN: <span class="text-white">{{ $sekolah['npsn'] ?? '20219146' }}</span> | Akreditasi: <span class="text-emerald-400">A</span></p>
                        <p class="text-slate-500">Berdiri sejak tahun 1951 di Kota Bandung</p>
                    </div>

                    <!-- Media Sosial Resmi -->
                    <div class="pt-2">
                        <p class="text-xs font-semibold text-slate-200 uppercase tracking-wider mb-2.5">Media Sosial Resmi</p>
                        <div class="flex items-center flex-wrap gap-2.5">
                            <!-- Instagram -->
                            <a href="{{ $sekolah['instagram'] ?? 'https://instagram.com/smkn2bandung' }}" target="_blank" rel="noopener noreferrer" 
                               class="w-9 h-9 rounded-xl bg-slate-800 border border-slate-700 hover:bg-blue-600 hover:border-blue-500 text-white flex items-center justify-center transition shadow-sm group" 
                               title="Instagram">
                                <svg class="w-4 h-4 fill-current transition-transform group-hover:scale-110" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                            <!-- TikTok -->
                            <a href="{{ $sekolah['tiktok'] ?? 'https://tiktok.com/@smkn2bandung' }}" target="_blank" rel="noopener noreferrer" 
                               class="w-9 h-9 rounded-xl bg-slate-800 border border-slate-700 hover:bg-blue-600 hover:border-blue-500 text-white flex items-center justify-center transition shadow-sm group" 
                               title="TikTok">
                                <svg class="w-4 h-4 fill-current transition-transform group-hover:scale-110" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64c.298 0 .591.045.87.134V9.42a6.35 6.35 0 0 0-.87-.06 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.34-6.34V8.75a8.28 8.28 0 0 0 4.84 1.55v-3.5a4.85 4.85 0 0 1-1.07-.11z"/></svg>
                            </a>
                            <!-- YouTube -->
                            <a href="{{ $sekolah['youtube'] ?? 'https://youtube.com/@smkn2bandung' }}" target="_blank" rel="noopener noreferrer" 
                               class="w-9 h-9 rounded-xl bg-slate-800 border border-slate-700 hover:bg-blue-600 hover:border-blue-500 text-white flex items-center justify-center transition shadow-sm group" 
                               title="YouTube">
                                <svg class="w-4 h-4 fill-current transition-transform group-hover:scale-110" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                            <!-- Facebook -->
                            <a href="{{ $sekolah['facebook'] ?? 'https://facebook.com/smkn2bandung' }}" target="_blank" rel="noopener noreferrer" 
                               class="w-9 h-9 rounded-xl bg-slate-800 border border-slate-700 hover:bg-blue-600 hover:border-blue-500 text-white flex items-center justify-center transition shadow-sm group" 
                               title="Facebook">
                                <svg class="w-4 h-4 fill-current transition-transform group-hover:scale-110" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <!-- X (Twitter) -->
                            <a href="{{ $sekolah['twitter'] ?? 'https://x.com/smkn2bandung' }}" target="_blank" rel="noopener noreferrer" 
                               class="w-9 h-9 rounded-xl bg-slate-800 border border-slate-700 hover:bg-blue-600 hover:border-blue-500 text-white flex items-center justify-center transition shadow-sm group" 
                               title="X (Twitter)">
                                <svg class="w-3.5 h-3.5 fill-current transition-transform group-hover:scale-110" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Col 2: Navigation Links -->
                <div>
                    <h3 class="font-heading font-bold text-white text-base mb-4 tracking-wide uppercase">Tautan Cepat</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ url(app('tenant')->slug . '/profil') }}" class="hover:text-blue-400 transition">Profil & Sejarah</a></li>
                        <li><a href="{{ url(app('tenant')->slug . '/program-keahlian') }}" class="hover:text-blue-400 transition">7 Program Keahlian</a></li>
                        <li><a href="{{ url(app('tenant')->slug . '/berita') }}" class="hover:text-blue-400 transition">Berita & Informasi</a></li>
                        <li><a href="{{ url(app('tenant')->slug . '/agenda') }}" class="hover:text-blue-400 transition">Agenda & Kegiatan</a></li>
                        <li><a href="{{ url(app('tenant')->slug . '/prestasi') }}" class="hover:text-blue-400 transition">Prestasi Siswa</a></li>
                        <li><a href="{{ url(app('tenant')->slug . '/spmb') }}" class="hover:text-blue-400 transition">Penerimaan Siswa (SPMB)</a></li>
                    </ul>
                </div>

                <!-- Col 3: Programs & Facilities -->
                <div>
                    <h3 class="font-heading font-bold text-white text-base mb-4 tracking-wide uppercase">Program Unggulan</h3>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="{{ url(app('tenant')->slug . '/program-keahlian/teknik-mesin') }}" class="hover:text-white transition">Teknik Mesin (TM)</a></li>
                        <li><a href="{{ url(app('tenant')->slug . '/program-keahlian/pengembangan-perangkat-lunak-dan-gim') }}" class="hover:text-white transition">PPLG (Software & Game)</a></li>
                        <li><a href="{{ url(app('tenant')->slug . '/program-keahlian/teknik-jaringan-komputer-dan-telekomunikasi') }}" class="hover:text-white transition">TJKT (Jaringan Komputer)</a></li>
                        <li><a href="{{ url(app('tenant')->slug . '/program-keahlian/desain-komunikasi-visual') }}" class="hover:text-white transition">Desain Komunikasi Visual</a></li>
                        <li><a href="{{ url(app('tenant')->slug . '/program-keahlian/animasi') }}" class="hover:text-white transition">Animasi 2D/3D</a></li>
                        <li><a href="{{ url(app('tenant')->slug . '/fasilitas') }}" class="hover:text-white transition">Fasilitas Bengkel & Lab</a></li>
                    </ul>
                </div>

                <!-- Col 4: Contact & Service Hours -->
                <div>
                    <h3 class="font-heading font-bold text-white text-base mb-4 tracking-wide uppercase">Kontak & Lokasi</h3>
                    <ul class="space-y-2.5 text-sm text-slate-400">
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ $sekolah['alamat'] ?? 'Jl. Ciliwung No. 4, Cihapit, Kec. Bandung Wetan, Kota Bandung' }}</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>{{ $sekolah['telepon'] ?? '(022) 7234285' }}</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>{{ $sekolah['email'] ?? 'humas@smkn2bandung.sch.id' }}</span>
                        </li>
                        <li class="pt-2">
                            <a href="{{ url(app('tenant')->slug . '/kontak') }}" class="inline-flex items-center text-xs font-semibold text-blue-400 hover:text-blue-300">
                                Buka Formulir Hubungi Kami &rarr;
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 space-y-3 sm:space-y-0">
                <p>&copy; {{ date('Y') }} {{ $sekolah['nama'] ?? 'SMK Negeri 2 Bandung' }}. Seluruh hak cipta dilindungi undang-undang.</p>
                <p class="text-slate-400">Platform Website Sekolah Terpadu</p>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button with Tooltip -->
    <div class="fixed bottom-6 right-6 z-50 flex items-center group">
        <!-- Floating Tooltip Box -->
        <div class="mr-3 bg-white text-slate-800 py-2.5 px-4 rounded-2xl shadow-xl border border-slate-200/90 hidden sm:flex flex-col items-start transition-all duration-300 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 pointer-events-none whitespace-nowrap relative">
            <span class="text-xs text-slate-500 font-medium leading-tight">Ada pertanyaan?</span>
            <span class="text-xs sm:text-sm font-extrabold text-emerald-600 leading-tight flex items-center gap-1">
                Silakan hubungi kami via WA &rarr;
            </span>
            <!-- Tooltip Arrow pointing to WhatsApp button -->
            <div class="absolute top-1/2 -right-1.5 -translate-y-1/2 w-3 h-3 bg-white border-t border-r border-slate-200/90 rotate-45"></div>
        </div>

        <!-- Official WhatsApp Round Button -->
        <a href="https://wa.me/62{{ ltrim($sekolah['whatsapp'] ?? '081222333444', '0') }}?text=Halo%20Admin%2C%20saya%20ingin%20bertanya%20informasi%20mengenai%20sekolah." 
           target="_blank" 
           rel="noopener noreferrer"
           class="w-14 h-14 bg-[#25D366] hover:bg-[#20ba5a] text-white rounded-full shadow-2xl hover:shadow-green-500/40 flex items-center justify-center transition-all duration-300 transform hover:scale-110 shrink-0"
           aria-label="Hubungi kami melalui WhatsApp"
           title="Hubungi kami via WhatsApp">
            <svg class="w-8 h-8 fill-white shrink-0" viewBox="0 0 24 24">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M18.403 5.638A8.955 8.955 0 0 0 12.053 3c-4.968 0-9.013 4.045-9.015 9.017a8.98 8.98 0 0 0 1.374 4.815L3 21l4.303-1.129a9.014 9.014 0 0 0 4.748 1.325h.004c4.968 0 9.013-4.046 9.015-9.017a8.963 8.963 0 0 0-2.667-6.541zm-6.35 13.684h-.003a7.51 7.51 0 0 1-3.832-1.051l-.275-.163-2.85.748.76-2.778-.179-.284a7.485 7.485 0 0 1-1.147-3.978c.002-4.14 3.37-7.508 7.513-7.508a7.472 7.472 0 0 1 5.309 2.199 7.48 7.48 0 0 1 2.196 5.31c-.002 4.14-3.37 7.508-7.512 7.508zm4.12-5.625c-.225-.113-1.334-.658-1.541-.733-.207-.075-.357-.113-.508.113-.15.225-.583.733-.715.884-.131.15-.263.169-.489.056-.225-.113-.951-.35-1.812-1.118-.671-.598-1.124-1.338-1.256-1.564-.132-.226-.014-.348.099-.46.102-.101.226-.263.339-.395.113-.131.15-.225.226-.375.075-.15.038-.282-.019-.395-.056-.113-.508-1.224-.696-1.677-.183-.441-.369-.381-.508-.388l-.433-.008c-.15 0-.395.056-.602.282-.207.226-.79.771-.79 1.88 0 1.109.809 2.179.921 2.33.113.15 1.59 2.428 3.854 3.404.538.233.959.372 1.286.476.541.172 1.034.148 1.423.09.434-.065 1.334-.546 1.522-1.072.188-.527.188-.978.132-1.072-.057-.094-.207-.15-.433-.263z"/>
            </svg>
        </a>
    </div>

    @stack('scripts')
</body>
</html>
