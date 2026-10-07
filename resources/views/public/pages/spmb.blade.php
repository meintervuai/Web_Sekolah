@extends('layouts.public')

@section('title', 'SPMB & PPDB - ' . $sekolah['nama'])
@section('meta_description', 'Informasi resmi Sistem Penerimaan Murid Baru (SPMB / PPDB) di ' . $sekolah['nama'] . '. Jalur pendaftaran, persyaratan, alur, dan jadwal.')

@section('content')
<!-- Header & Breadcrumb -->
<section class="theme-bg-dark text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(var(--theme-accent)_1px,transparent_1px)] [background-size:16px_16px]"></div>
    @if(!empty($gambarBanner ?? $banner ?? null))
        <!-- Full-Width Hero Banner Image with Dark Theme Gradient Overlay -->
        <div class="absolute inset-0 pointer-events-none z-0">
            <img src="{{ $gambarBanner ?? $banner }}" alt="SPMB / PPDB" 
                 class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-900/80 to-slate-950/60"></div>
            <div class="absolute inset-0" style="background: linear-gradient(135deg, color-mix(in srgb, var(--theme-header,#0f172a) 85%, black 15%) 0%, color-mix(in srgb, var(--theme-header,#0f172a) 40%, transparent) 70%, transparent 100%); opacity: 0.85;"></div>
        </div>
    @endif
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition drop-shadow-xs">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium drop-shadow-xs">SPMB / PPDB</li>
            </ol>
        </nav>
        <div class="max-w-4xl lg:max-w-5xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3 drop-shadow-sm">
                {{ !empty($halaman->judul) ? $halaman->judul : 'Bergabung Bersama ' . $sekolah['nama'] }}
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed max-w-3xl drop-shadow-xs">
                {{ !empty($halaman->subjudul) ? $halaman->subjudul : 'Wujudkan cita-cita masa depanmu melalui pendidikan vokasi berkualitas, fasilitas teaching factory berstandar industri, dan jaringan kerja sama mitra DUDI nasional & internasional.' }}
            </p>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="section-py bg-slate-50">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            
            <!-- Left: Main Information (8 cols) -->
            <div class="lg:col-span-8 space-y-10">
                
                <!-- Alur Pendaftaran Step-by-Step -->
                @if(!empty($alurList) && count($alurList) > 0)
                <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-200/80 shadow-xs">
                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 font-heading mb-6 flex items-center">
                        <svg class="w-6 h-6 text-blue-600 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Alur & Prosedur Pendaftaran
                    </h2>

                    <div class="space-y-6">
                        @foreach($alurList as $index => $alur)
                        <div class="flex items-start space-x-4">
                            <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shrink-0">{{ $alur['langkah'] ?? ($index + 1) }}</div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">{{ $alur['judul'] ?? '' }}</h3>
                                <p class="text-xs text-slate-600 mt-1 leading-relaxed">{{ $alur['deskripsi'] ?? '' }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Persyaratan Berkas Dokumen (WYSIWYG) -->
                @if(!empty($syaratKonten))
                <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-200/80 shadow-xs">
                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 font-heading mb-4 flex items-center">
                        <svg class="w-6 h-6 text-blue-600 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Persyaratan Dokumen Umum
                    </h2>
                    <div class="prose prose-slate max-w-none text-xs md:text-sm text-slate-700 leading-relaxed">
                        {!! $syaratKonten !!}
                    </div>
                </div>
                @endif

            </div>

            <!-- Right: Sidebar Info (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Portal Link Card -->
                @if(!empty($portalUrl))
                <div class="public-hero-gradient text-white rounded-2xl p-6 shadow-md">
                    <span class="text-xs uppercase tracking-wider font-bold block mb-1 text-white/80">Portal Pendaftaran Resmi</span>
                    <h3 class="text-lg font-bold font-heading mb-3">{{ $portalNama ?? 'Portal PPDB Resmi' }}</h3>
                    @if(!empty($portalDeskripsi))
                    <p class="text-xs text-white/90 leading-relaxed mb-5">
                        {{ $portalDeskripsi }}
                    </p>
                    @endif
                    <a href="{{ $portalUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="inline-flex items-center justify-center w-full px-5 py-3 rounded-xl bg-white text-slate-900 font-bold text-xs shadow hover:bg-slate-100 transition">
                        <span>{{ $portalTombol ?? 'Akses Portal PPDB' }}</span>
                        <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
                @endif
            </div>

        </div>
    </div>
</section>
@endsection
