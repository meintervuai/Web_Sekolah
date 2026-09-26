@extends('layouts.public')

@section('title', $post->judul . ' - ' . $sekolah['nama'])
@section('meta_description', Str::limit(strip_tags($post->ringkasan ?? $post->isi_konten), 160))

@section('content')
<!-- Breadcrumbs & Category Bar -->
<section class="bg-slate-100 py-4 border-b border-slate-200">
    <div class="container-custom">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-500 overflow-x-auto hide-scrollbar">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-blue-600 transition">Beranda</a></li>
                <li><span>/</span></li>
                <li><a href="{{ url(app('tenant')->slug . '/berita') }}" class="hover:text-blue-600 transition">Berita</a></li>
                <li><span>/</span></li>
                @if($post->kategori)
                <li><a href="{{ url(app('tenant')->slug . '/berita?kategori=' . $post->kategori->slug) }}" class="hover:text-blue-600 transition">{{ $post->kategori->nama_kategori }}</a></li>
                <li><span>/</span></li>
                @endif
                <li class="text-slate-800 font-semibold truncate max-w-xs md:max-w-md">{{ $post->judul }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Article Section -->
<section class="section-py bg-white">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            
            <!-- Article Body (8 Cols) -->
            <article class="lg:col-span-8">
                <!-- Meta tags & Category -->
                <div class="mb-4 flex flex-wrap items-center gap-2">
                    @if($post->kategori)
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $post->kategori->nama_kategori }}
                    </span>
                    @endif
                    <span class="text-xs text-slate-400 flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ \Carbon\Carbon::parse($post->tgl_publikasi)->translatedFormat('l, d F Y') }}
                    </span>
                    <span class="text-slate-300">•</span>
                    <span class="text-xs text-slate-400 flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        {{ $post->jumlah_dilihat ?? 0 }} kali dibaca
                    </span>
                </div>

                <!-- Title -->
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-900 leading-tight font-heading mb-6">
                    {{ $post->judul }}
                </h1>

                <!-- Author info bar -->
                <div class="flex items-center space-x-3 pb-6 mb-6 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm">
                        SMK
                    </div>
                    <div>
                        <p class="text-xs md:text-sm font-semibold text-slate-800">Tim Publikasi & Humas</p>
                        <p class="text-[11px] text-slate-400">{{ $sekolah['nama'] }}</p>
                    </div>
                </div>

                <!-- Featured Image with Lightbox Support -->
                @if($post->gambar_sampul)
                <div class="mb-8 rounded-2xl overflow-hidden bg-slate-100 shadow-sm border border-slate-100 group relative">
                    <img src="{{ $post->gambar_sampul }}" 
                         alt="{{ $post->judul }}" 
                         class="w-full h-auto max-h-[480px] object-cover cursor-pointer"
                         @click="lightboxOpen = true; lightboxSrc = '{{ $post->gambar_sampul }}'; lightboxCaption = '{{ addslashes($post->judul) }}'">
                    <div class="p-3 bg-slate-50 border-t border-slate-100 text-center text-xs text-slate-500 italic">
                        Dokumentasi Resmi Humas {{ $sekolah['nama'] }} (Klik gambar untuk memperbesar)
                    </div>
                </div>
                @endif

                <!-- Content Body (Max 760px for readability) -->
                <div class="max-w-[760px] mx-auto prose prose-slate md:prose-lg prose-headings:font-heading prose-headings:text-slate-900 prose-p:text-slate-700 prose-p:leading-relaxed prose-li:text-slate-700 mb-10">
                    @if($post->ringkasan)
                    <p class="text-base md:text-lg font-medium text-slate-700 leading-relaxed border-l-4 border-blue-600 pl-4 py-1 bg-blue-50/50 rounded-r-lg mb-6">
                        {{ $post->ringkasan }}
                    </p>
                    @endif

                    {!! $post->isi_konten !!}
                </div>

                <!-- Share Buttons -->
                <div class="pt-6 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <span class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Bagikan Artikel Ini:</span>
                    <div class="flex items-center space-x-2" x-data="{ copied: false }">
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($post->judul . ' - ' . url()->current()) }}" 
                           target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center px-3.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-xs transition">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            WhatsApp
                        </a>
                        <button @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 3000)"
                                class="inline-flex items-center px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <span x-text="copied ? 'Tautan Disalin!' : 'Salin Tautan'">Salin Tautan</span>
                        </button>
                    </div>
                </div>

                <!-- Back link -->
                <div class="mt-8">
                    <a href="{{ url(app('tenant')->slug . '/berita') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Seluruh Berita
                    </a>
                </div>
            </article>

            <!-- Sidebar (4 Cols) -->
            <aside class="lg:col-span-4 space-y-6">
                <!-- Related News -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200/80">
                    <h3 class="text-base font-bold text-slate-900 font-heading mb-4 pb-3 border-b border-slate-200 flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        Berita Terkait
                    </h3>
                    <div class="space-y-4">
                        @forelse($related as $rel)
                        <article class="flex space-x-3 group">
                            <a href="{{ url(app('tenant')->slug . '/berita/' . $rel->slug) }}" class="w-20 h-16 rounded-lg overflow-hidden shrink-0 bg-slate-200 relative">
                                <img src="{{ $rel->gambar_sampul ?? 'https://images.unsplash.com/photo-1546410531-ea4cea477149?q=80&w=300&auto=format&fit=crop' }}" 
                                     alt="{{ $rel->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-200">
                            </a>
                            <div class="flex-1 min-w-0">
                                <span class="text-[11px] text-slate-400 block mb-1">
                                    {{ \Carbon\Carbon::parse($rel->tgl_publikasi)->translatedFormat('d M Y') }}
                                </span>
                                <h4 class="text-xs font-bold text-slate-800 group-hover:text-blue-600 transition line-clamp-2 leading-snug">
                                    <a href="{{ url(app('tenant')->slug . '/berita/' . $rel->slug) }}">
                                        {{ $rel->judul }}
                                    </a>
                                </h4>
                            </div>
                        </article>
                        @empty
                        <p class="text-xs text-slate-400 italic">Belum ada artikel terkait lainnya.</p>
                        @endforelse
                    </div>
                </div>

                <!-- School Agenda Widget -->
                <div class="bg-blue-900 text-white rounded-2xl p-6 shadow-sm">
                    <h3 class="text-base font-bold font-heading mb-2">Agenda Kegiatan</h3>
                    <p class="text-xs text-blue-200 mb-4">Pantau jadwal ujian, workshop, dan agenda sekolah lainnya di kalender resmi.</p>
                    <a href="{{ url(app('tenant')->slug . '/agenda') }}" class="inline-flex items-center text-xs font-bold text-amber-300 hover:text-amber-200">
                        <span>Lihat Kalender Agenda</span>
                        <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </aside>

        </div>
    </div>
</section>
@endsection
