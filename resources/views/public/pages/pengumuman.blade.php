@extends('layouts.public')

@section('title', 'Pengumuman Resmi - ' . $sekolah['nama'])
@section('meta_description', 'Pemberitahuan, surat edaran, dan pengumuman kedinasan resmi dari pimpinan ' . $sekolah['nama'])

@section('content')
<!-- Header & Breadcrumb -->
<section class="theme-bg-dark text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(var(--theme-accent,#38bdf8)_1px,transparent_1px)] [background-size:16px_16px]"></div>
    @if(!empty($gambarBanner ?? $banner ?? null))
        <!-- Artistic Banner Image Overlay -->
        <div class="absolute inset-y-0 right-0 w-full md:w-3/5 lg:w-1/2 pointer-events-none z-0">
            <img src="{{ $gambarBanner ?? $banner }}" alt="Pengumuman & Surat Edaran" 
                 class="w-full h-full object-cover object-center opacity-40 lg:opacity-60 [mask-image:linear-gradient(to_left,rgba(0,0,0,1)_20%,rgba(0,0,0,0.6)_60%,transparent_100%)] [-webkit-mask-image:linear-gradient(to_left,rgba(0,0,0,1)_20%,rgba(0,0,0,0.6)_60%,transparent_100%)]">
            <div class="absolute inset-0 bg-gradient-to-r from-[var(--theme-header,#0f172a)] via-transparent to-transparent opacity-80"></div>
        </div>
    @endif
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition drop-shadow-xs">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium drop-shadow-xs">Pengumuman Resmi</li>
            </ol>
        </nav>
        <div class="max-w-4xl lg:max-w-5xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-xs border border-white/20 text-xs font-semibold text-sky-200 mb-3">
                <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                <span>Pusat Informasi &amp; Surat Edaran</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3 drop-shadow-sm">
                Pengumuman Resmi Sekolah
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed max-w-3xl drop-shadow-xs">
                Kumpulan rilis kedinasan, surat edaran pimpinan, agenda akademik resmi, serta pengumuman penting bagi siswa, orang tua/wali, dan masyarakat.
            </p>
        </div>
    </div>
</section>

<!-- Filter & Search Bar -->
<section class="bg-white border-b border-slate-200/80 sticky top-16 z-30 shadow-xs">
    <div class="container-custom py-3.5">
        <form method="GET" action="{{ url(app('tenant')->slug . '/pengumuman') }}" class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-2 text-xs md:text-sm text-slate-700 font-medium">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Total Pengumuman Aktif: <strong class="text-slate-900 font-bold font-heading">{{ $pengumuman->total() }}</strong></span>
            </div>
            <div class="relative w-full sm:w-80">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nomor/judul pengumuman..." 
                       class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs md:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[var(--theme-primary,#1e40af)] focus:bg-white transition">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                @if(request('q'))
                <a href="{{ url(app('tenant')->slug . '/pengumuman') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs font-bold" title="Reset pencarian">✕</a>
                @endif
            </div>
        </form>
    </div>
</section>

<!-- Pengumuman Listing -->
<section class="section-py bg-slate-50/80">
    <div class="container-custom">
        
        @if(request('q'))
        <div class="mb-6 flex items-center justify-between bg-blue-50/60 border border-blue-100 rounded-xl px-4 py-2.5">
            <p class="text-xs md:text-sm text-slate-700">
                Hasil pencarian untuk kata kunci: <strong class="text-slate-900 font-semibold">"{{ request('q') }}"</strong>
            </p>
            <a href="{{ url(app('tenant')->slug . '/pengumuman') }}" class="text-xs font-bold text-[var(--theme-primary,#1e40af)] hover:underline">Hapus Filter</a>
        </div>
        @endif

        <div class="grid grid-cols-1 gap-5">
            @forelse($pengumuman as $p)
            <article class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-xs hover:shadow-md hover:border-slate-300 transition-all duration-200 flex flex-col md:flex-row gap-5 lg:gap-6 group items-start md:items-center">
                <!-- Thumbnail Dokumen / Gambar Sampul -->
                @if($p->gambar_sampul)
                <a href="{{ url(app('tenant')->slug . '/pengumuman/' . $p->slug) }}" 
                   class="w-full md:w-48 lg:w-52 h-40 md:h-32 rounded-xl overflow-hidden bg-slate-100 shrink-0 border border-slate-200/80 relative block group/img">
                    <img src="{{ $p->gambar_sampul }}" 
                         alt="{{ $p->judul }}" 
                         loading="lazy"
                         style="{{ \App\Services\MediaService::getCropStyle($p->gambar_sampul ?? '') }}"
                         class="w-full h-full object-cover group-hover/img:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-slate-900/10 opacity-0 group-hover/img:opacity-100 transition-opacity"></div>
                    <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-slate-900/75 backdrop-blur-xs text-[10px] font-semibold text-white flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        Lampiran
                    </span>
                </a>
                @else
                <div class="w-full md:w-36 h-28 hidden md:flex rounded-xl bg-slate-100 shrink-0 border border-slate-200/80 items-center justify-center text-slate-400">
                    <svg class="w-8 h-8 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                @endif

                <!-- Content Area -->
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2.5 mb-2.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-900 border border-amber-200">
                            Pemberitahuan Resmi
                        </span>
                        <span class="text-xs text-slate-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ \Carbon\Carbon::parse($p->tgl_publikasi)->translatedFormat('l, d F Y') }}
                        </span>
                        @if($p->jumlah_dilihat)
                        <span class="text-xs text-slate-400 flex items-center gap-1">
                            <span>•</span>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            {{ $p->jumlah_dilihat }} kali dibaca
                        </span>
                        @endif
                    </div>

                    <h2 class="text-base sm:text-lg md:text-xl font-bold text-slate-900 group-hover:text-[var(--theme-primary,#1e40af)] transition-colors font-heading mb-2 leading-snug">
                        <a href="{{ url(app('tenant')->slug . '/pengumuman/' . $p->slug) }}">
                            {{ $p->judul }}
                        </a>
                    </h2>

                    <p class="text-xs md:text-sm text-slate-600 line-clamp-2 leading-relaxed">
                        {{ $p->ringkasan ?? Str::limit(strip_tags($p->isi_konten), 160) }}
                    </p>
                </div>

                <!-- Action Button -->
                <div class="w-full md:w-auto shrink-0 flex items-center justify-end pt-2 md:pt-0">
                    <a href="{{ url(app('tenant')->slug . '/pengumuman/' . $p->slug) }}" 
                       class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-slate-100 group-hover:bg-[var(--theme-primary,#1e40af)] text-slate-800 group-hover:text-white font-bold text-xs transition-all duration-200 shadow-2xs">
                        <span>Buka Pengumuman</span>
                        <svg class="w-4 h-4 ml-1.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </article>
            @empty
            <div class="py-16 text-center bg-white rounded-2xl border border-slate-200/80 p-8 shadow-xs">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-800 font-heading mb-1">Tidak Ada Pengumuman Ditemukan</h3>
                <p class="text-xs md:text-sm text-slate-500 max-w-sm mx-auto mb-4">Belum ada rilis pengumuman yang sesuai dengan kata kunci pencarian Anda.</p>
                <a href="{{ url(app('tenant')->slug . '/pengumuman') }}" class="inline-flex items-center px-4 py-2 bg-[var(--theme-primary,#1e40af)] text-white text-xs font-bold rounded-xl hover:opacity-90 transition">
                    Lihat Semua Pengumuman
                </a>
            </div>
            @endforelse
        </div>

        @if($pengumuman->hasPages())
        <div class="mt-8">
            {{ $pengumuman->links() }}
        </div>
        @endif
    </div>
</section>
@endsection

