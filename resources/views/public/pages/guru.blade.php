@extends('layouts.public')

@section('title', 'Guru & Tenaga Kependidikan - ' . $sekolah['nama'])
@section('meta_description', 'Direktori pendidik dan tenaga kependidikan profesional bersertifikasi di ' . $sekolah['nama'] . ' Bandung.')

@section('content')
<!-- Header & Breadcrumb -->
<section class="theme-bg-dark text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(var(--theme-accent)_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li><a href="{{ url(app('tenant')->slug . '/profil') }}" class="hover:text-white transition">Profil</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium">Guru & Tenaga Kependidikan</li>
            </ol>
        </nav>
        <div class="max-w-2xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3">
                Guru & Tenaga Kependidikan
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed">
                Didukung oleh 98 guru dan staf kependidikan berpengalaman, berpendidikan S1/S2, dan bersertifikasi keahlian industri.
            </p>
        </div>
    </div>
</section>

<!-- Search Bar Section -->
<section class="bg-white border-b border-slate-200/80 sticky top-16 z-30 shadow-xs">
    <div class="container-custom py-4">
        <form method="GET" action="{{ url(app('tenant')->slug . '/guru-staf') }}" class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <span class="text-xs md:text-sm text-slate-600 font-medium">
                Total Direktori: <strong class="text-slate-900">{{ $guru->total() }} Pendidik</strong> (Dapodik 2025/2026)
            </span>
            <div class="relative w-full sm:w-80">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama guru / mata pelajaran..." 
                       class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs md:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </form>
    </div>
</section>

<!-- Guru Grid Section -->
<section class="section-py bg-slate-50">
    <div class="container-custom">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($guru as $g)
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition text-center flex flex-col items-center group">
                <!-- Photo -->
                <div class="w-28 h-28 rounded-2xl overflow-hidden bg-slate-100 mb-4 ring-4 ring-slate-100 group-hover:ring-blue-100 transition shadow-inner">
                    <img src="{{ $g->foto ?? 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=400&auto=format&fit=crop' }}" 
                         alt="{{ $g->nama_lengkap }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>

                <!-- Name & Degree -->
                <h2 class="text-base font-bold text-slate-900 font-heading mb-1 leading-snug">
                    {{ $g->nama_lengkap }}
                </h2>

                <!-- Position -->
                <p class="text-xs font-semibold text-blue-600 mb-2">
                    {{ $g->jabatan ?? 'Tenaga Pendidik' }}
                </p>

                <!-- Subject pill -->
                @if($g->mata_pelajaran)
                <div class="mt-auto pt-3 border-t border-slate-100 w-full">
                    <span class="inline-block px-2.5 py-1 bg-slate-50 border border-slate-200/70 text-slate-600 rounded-lg text-[11px] font-medium truncate max-w-full">
                        {{ $g->mata_pelajaran }}
                    </span>
                </div>
                @endif
            </div>
            @empty
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-200 p-8">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-800 font-heading mb-1">Guru Tidak Ditemukan</h3>
                <p class="text-xs md:text-sm text-slate-500 max-w-sm mx-auto mb-4">Tidak ada nama pendidik yang sesuai dengan pencarian Anda.</p>
                <a href="{{ url(app('tenant')->slug . '/guru-staf') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 transition">
                    Lihat Semua Guru & Staf
                </a>
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $guru->links() }}
        </div>
    </div>
</section>
@endsection
