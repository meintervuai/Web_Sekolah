@extends('layouts.public')

@section('title', 'Pengumuman Resmi - ' . $sekolah['nama'])
@section('meta_description', 'Pemberitahuan, surat edaran, dan pengumuman kedinasan resmi dari pimpinan ' . $sekolah['nama'])

@section('content')
<!-- Header & Breadcrumb -->
<section class="theme-bg-dark text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(var(--theme-accent)_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium">Pengumuman</li>
            </ol>
        </nav>
        <div class="max-w-2xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3">
                Pengumuman & Surat Edaran
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed">
                Informasi penting kedinasan, kalender libur/KBM, kelulusan, dan kebijakan pimpinan {{ $sekolah['nama'] }}.
            </p>
        </div>
    </div>
</section>

<!-- Search Bar Section -->
<section class="bg-white border-b border-slate-200/80 sticky top-16 z-30 shadow-xs">
    <div class="container-custom py-4">
        <form method="GET" action="{{ url(app('tenant')->slug . '/pengumuman') }}" class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <span class="text-xs md:text-sm text-slate-600 font-medium">
                Arsip Pengumuman Aktif ({{ $pengumuman->total() }})
            </span>
            <div class="relative w-full sm:w-80">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul pengumuman / kata kunci..." 
                       class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs md:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </form>
    </div>
</section>

<!-- Pengumuman Listing -->
<section class="section-py bg-slate-50">
    <div class="container-custom">
        <div class="space-y-4">
            @forelse($pengumuman as $p)
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition flex flex-col md:flex-row md:items-center justify-between gap-6 group">
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-2.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-900 border border-amber-200">
                            Pemberitahuan Resmi
                        </span>
                        <span class="text-xs text-slate-400 flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ \Carbon\Carbon::parse($p->tgl_publikasi)->translatedFormat('l, d F Y') }}
                        </span>
                    </div>

                    <h2 class="text-lg md:text-xl font-bold text-slate-900 group-hover:text-blue-600 transition font-heading mb-2">
                        <a href="{{ url(app('tenant')->slug . '/pengumuman/' . $p->slug) }}">
                            {{ $p->judul }}
                        </a>
                    </h2>

                    <p class="text-xs md:text-sm text-slate-600 line-clamp-2 leading-relaxed">
                        {{ $p->ringkasan ?? Str::limit(strip_tags($p->isi_konten), 160) }}
                    </p>
                </div>

                <div class="shrink-0 flex items-center">
                    <a href="{{ url(app('tenant')->slug . '/pengumuman/' . $p->slug) }}" 
                       class="w-full md:w-auto inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-blue-50 group-hover:bg-blue-600 text-blue-700 group-hover:text-white font-bold text-xs transition">
                        <span>Baca Pengumuman</span>
                        <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="py-16 text-center bg-white rounded-2xl border border-slate-200/80 p-8">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-800 font-heading mb-1">Tidak Ada Pengumuman</h3>
                <p class="text-xs md:text-sm text-slate-500 max-w-sm mx-auto mb-4">Tidak ada pengumuman yang sesuai dengan pencarian Anda saat ini.</p>
                <a href="{{ url(app('tenant')->slug . '/pengumuman') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 transition">
                    Lihat Semua Pengumuman
                </a>
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $pengumuman->links() }}
        </div>
    </div>
</section>
@endsection
