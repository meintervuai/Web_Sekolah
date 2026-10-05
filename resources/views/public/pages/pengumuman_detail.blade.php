@extends('layouts.public')

@section('title', $post->judul . ' - Pengumuman Resmi ' . $sekolah['nama'])
@section('meta_description', Str::limit(strip_tags($post->ringkasan ?? $post->isi_konten), 160))

@section('content')
<!-- Breadcrumbs -->
<section class="bg-slate-100/90 py-3.5 border-b border-slate-200">
    <div class="container-custom">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-500 overflow-x-auto hide-scrollbar">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-[var(--theme-primary,#1e40af)] transition">Beranda</a></li>
                <li><span class="text-slate-400">/</span></li>
                <li><a href="{{ url(app('tenant')->slug . '/pengumuman') }}" class="hover:text-[var(--theme-primary,#1e40af)] transition">Pengumuman</a></li>
                <li><span class="text-slate-400">/</span></li>
                <li class="text-slate-800 font-semibold truncate max-w-xs md:max-w-md">{{ $post->judul }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Section with Alpine Lightbox -->
<section class="section-py bg-slate-50/60" x-data="{ openLightbox: false }">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
            
            <!-- Announcement Body (8 cols) -->
            <article class="lg:col-span-8">
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 sm:p-8 md:p-10">
                    
                    <!-- Meta Header -->
                    <div class="flex flex-wrap items-center justify-between gap-3 pb-5 mb-6 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-50 text-amber-900 border border-amber-200 text-xs font-bold">
                                Pemberitahuan Resmi
                            </span>
                            <span class="text-xs text-slate-500 flex items-center gap-1 font-medium">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ \Carbon\Carbon::parse($post->tgl_publikasi)->translatedFormat('l, d F Y') }}
                            </span>
                        </div>
                        
                        <div class="flex items-center gap-3 text-xs text-slate-400">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                {{ $post->jumlah_dilihat ?? 0 }} pembaca
                            </span>
                            <button type="button" onclick="window.print()" class="hidden sm:inline-flex items-center gap-1 text-slate-500 hover:text-slate-800 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                Cetak
                            </button>
                        </div>
                    </div>

                    <!-- Main Title -->
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 font-heading mb-6 leading-tight">
                        {{ $post->judul }}
                    </h1>

                    <!-- Featured Image / Dokumen Surat Resmi -->
                    @if($post->gambar_sampul)
                    <div class="mb-8 rounded-2xl overflow-hidden bg-slate-900/5 border border-slate-200/80 shadow-2xs">
                        <div class="relative group cursor-pointer" @click="openLightbox = true">
                            <img src="{{ $post->gambar_sampul }}" 
                                 alt="{{ $post->judul }}" 
                                 loading="lazy"
                                 class="w-full h-auto max-h-[750px] object-contain mx-auto transition-transform duration-300 group-hover:scale-[1.01]">
                            
                            <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3 text-white">
                                <span class="px-4 py-2 rounded-xl bg-slate-900/80 backdrop-blur-xs font-semibold text-xs flex items-center gap-2 shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                    Klik untuk Perbesar Dokumen
                                </span>
                            </div>
                        </div>

                        <!-- Action Bar Dokumen -->
                        <div class="p-3.5 bg-slate-100/90 border-t border-slate-200/80 flex flex-wrap items-center justify-between gap-3 text-xs">
                            <span class="text-slate-600 font-medium flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Lampiran Dokumen Surat Resmi
                            </span>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="openLightbox = true" class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold text-xs shadow-2xs transition">
                                    Perbesar Tampilan
                                </button>
                                <a href="{{ $post->gambar_sampul }}" target="_blank" download class="px-3 py-1.5 rounded-lg bg-[var(--theme-primary,#1e40af)] text-white font-semibold text-xs shadow-2xs hover:opacity-90 transition flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    Unduh Dokumen
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Article Body Content -->
                    <div class="prose prose-slate max-w-none prose-headings:font-heading prose-headings:text-slate-900 prose-p:text-slate-700 prose-p:leading-relaxed prose-li:text-slate-700 prose-strong:text-slate-900">
                        {!! $post->isi_konten !!}
                    </div>

                    <!-- Footer Tags / Verification Notice -->
                    <div class="mt-10 pt-6 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs text-slate-500 bg-slate-50/80 -mx-6 -mb-6 sm:-mx-8 sm:-mb-8 md:-mx-10 md:-mb-10 p-5 sm:p-6 rounded-b-2xl">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span>Dikeluarkan secara resmi oleh Pimpinan {{ $sekolah['nama'] }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span>Bagikan:</span>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($post->judul . ' - ' . url()->current()) }}" target="_blank" rel="noopener" class="text-slate-600 hover:text-emerald-600 font-semibold transition">WhatsApp</a>
                            <span class="text-slate-300">|</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="text-slate-600 hover:text-blue-600 font-semibold transition">Facebook</a>
                        </div>
                    </div>

                </div>

                <!-- Back Navigation -->
                <div class="mt-6">
                    <a href="{{ url(app('tenant')->slug . '/pengumuman') }}" class="inline-flex items-center text-xs font-bold text-[var(--theme-primary,#1e40af)] hover:underline transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Seluruh Arsip Pengumuman
                    </a>
                </div>
            </article>

            <!-- Sidebar (4 cols) -->
            <aside class="lg:col-span-4 space-y-6">
                <!-- Pengumuman Lainnya Card -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs">
                    <h3 class="text-sm font-bold text-slate-900 font-heading mb-4 pb-3 border-b border-slate-100 flex items-center justify-between">
                        <span>Pengumuman Terbaru Lainnya</span>
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    </h3>
                    <div class="space-y-4">
                        @forelse($pengumumanLainnya as $pl)
                        <div class="pb-3 border-b border-slate-100 last:border-b-0 last:pb-0 group">
                            <span class="text-[11px] text-slate-400 block mb-1 flex items-center gap-1">
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ \Carbon\Carbon::parse($pl->tgl_publikasi)->translatedFormat('d M Y') }}
                            </span>
                            <h4 class="text-xs font-bold text-slate-800 group-hover:text-[var(--theme-primary,#1e40af)] transition leading-snug line-clamp-2">
                                <a href="{{ url(app('tenant')->slug . '/pengumuman/' . $pl->slug) }}">
                                    {{ $pl->judul }}
                                </a>
                            </h4>
                        </div>
                        @empty
                        <p class="text-xs text-slate-400 italic">Tidak ada pengumuman lain saat ini.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Pusat Bantuan Tata Usaha -->
                <div class="bg-blue-50/70 border border-blue-200/80 rounded-2xl p-6 shadow-2xs">
                    <div class="flex items-center gap-2 mb-2 text-[var(--theme-primary,#1e40af)]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <h4 class="font-bold font-heading text-sm text-slate-900">Pusat Layanan &amp; TU</h4>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Memerlukan klarifikasi terkait isi surat edaran, administrasi, atau persyaratan berkas? Hubungi bagian Tata Usaha {{ $sekolah['nama'] }}.
                    </p>
                    <a href="{{ url(app('tenant')->slug . '/kontak') }}" 
                       class="inline-flex items-center text-xs font-bold text-[var(--theme-primary,#1e40af)] hover:underline gap-1">
                        <span>Buka Halaman Kontak Sekolah</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </aside>

        </div>
    </div>

    <!-- Lightbox Modal untuk Dokumen -->
    @if($post->gambar_sampul)
    <div x-show="openLightbox" 
         x-cloak 
         @keydown.escape.window="openLightbox = false"
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/90 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="relative max-w-5xl w-full bg-slate-900 rounded-2xl overflow-hidden shadow-2xl border border-slate-700/60"
             @click.away="openLightbox = false">
            <!-- Modal Header -->
            <div class="p-4 bg-slate-900/90 border-b border-slate-800 flex items-center justify-between text-white">
                <div class="truncate max-w-md">
                    <p class="text-xs text-slate-400">Pratinjau Dokumen Surat Resmi</p>
                    <h5 class="text-sm font-bold font-heading truncate">{{ $post->judul }}</h5>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ $post->gambar_sampul }}" target="_blank" download class="px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs transition flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>Unduh Asli</span>
                    </a>
                    <button type="button" @click="openLightbox = false" class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            <!-- Image View Area -->
            <div class="p-3 sm:p-6 bg-slate-950 flex items-center justify-center max-h-[80vh] overflow-auto">
                <img src="{{ $post->gambar_sampul }}" alt="{{ $post->judul }}" class="w-auto max-w-full max-h-[75vh] object-contain rounded-lg">
            </div>
        </div>
    </div>
    @endif
</section>
@endsection

