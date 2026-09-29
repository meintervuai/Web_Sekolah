@extends('layouts.public')

@section('title', 'Struktur Organisasi & Pimpinan - ' . $sekolah['nama'])
@section('meta_description', 'Susunan struktur organisasi, diagram bagan alur manajerial, dan jajaran pimpinan di ' . $sekolah['nama'])

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
                <li class="text-sky-300 font-medium">Struktur Organisasi</li>
            </ol>
        </nav>
        <div class="max-w-2xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3">
                Struktur Organisasi Sekolah
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed">
                Jajaran pimpinan, kepala program keahlian, dan koordinator tata kelola manajerial di {{ $sekolah['nama'] }}.
            </p>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="section-py bg-slate-50" x-data="{ 
    activeTab: 'pejabat', 
    activeDiagram: 0,
    diagrams: {{ Js::from($diagrams ?? []) }}
}">
    <div class="container-custom">

        <!-- Mode Switcher Tabs -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8 pb-4 border-b border-slate-200">
            <div>
                <h2 class="font-heading font-bold text-lg text-slate-900">Pilihan Tampilan Struktur</h2>
                <p class="text-xs text-slate-600 mt-0.5">Lihat dalam format jajaran pejabat atau diagram bagan alur organisasi</p>
            </div>
            
            <div class="inline-flex p-1 bg-slate-200/90 rounded-2xl border border-slate-300/80 shadow-inner">
                <button type="button"
                        @click="activeTab = 'pejabat'"
                        :class="activeTab === 'pejabat' ? 'bg-white text-blue-900 shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                        class="px-4 py-2 rounded-xl text-xs md:text-sm transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Jajaran Pejabat
                </button>
                <button type="button"
                        @click="activeTab = 'diagram'"
                        :class="activeTab === 'diagram' ? 'bg-white text-blue-900 shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                        class="px-4 py-2 rounded-xl text-xs md:text-sm transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Bagan Diagram Struktur
                </button>
            </div>
        </div>

        <!-- TAB 1: JAJARAN PEJABAT & PIMPINAN (GRID FOTO) -->
        <div x-show="activeTab === 'pejabat'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($struktur as $s)
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition text-center flex flex-col items-center group">
                    <div class="w-28 h-28 rounded-2xl overflow-hidden bg-slate-100 mb-4 ring-4 ring-slate-100 group-hover:ring-blue-100 transition shadow-inner">
                        <img src="{{ $s->foto ?? 'https://ui-avatars.com/api/?name='.urlencode($s->nama_lengkap).'&background=1E3A8A&color=fff&size=200' }}" 
                             alt="{{ $s->nama_lengkap }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <h2 class="text-base font-bold text-slate-900 font-heading mb-1 leading-snug">
                        {{ $s->nama_lengkap }}
                    </h2>
                    <p class="text-xs font-semibold text-blue-600 mb-2">
                        {{ $s->jabatan }}
                    </p>
                    @if($s->keterangan)
                    <p class="text-[11px] text-slate-500 mt-auto pt-2 border-t border-slate-100 w-full">
                        {{ $s->keterangan }}
                    </p>
                    @endif
                </div>
                @empty
                <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-200 p-8">
                    <p class="text-sm text-slate-500">Belum ada data jajaran struktur pimpinan.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- TAB 2: BAGAN DIAGRAM STRUKTUR (1 ATAU BEBERAPA GAMBAR) -->
        <div x-show="activeTab === 'diagram'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" style="display: none;">
            <template x-if="diagrams.length > 0">
                <div class="space-y-6">
                    <!-- Main Active Diagram Card -->
                    <div class="bg-white rounded-3xl p-4 sm:p-6 md:p-8 border border-slate-200/80 shadow-sm">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 pb-4 mb-4 border-b border-slate-100">
                            <div>
                                <h3 class="font-heading font-extrabold text-lg sm:text-xl text-slate-900" x-text="diagrams[activeDiagram].judul"></h3>
                                <p class="text-xs sm:text-sm text-slate-600 mt-1" x-text="diagrams[activeDiagram].deskripsi"></p>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <button type="button"
                                        @click="lightboxOpen = true; lightboxSrc = diagrams[activeDiagram].gambar; lightboxCaption = diagrams[activeDiagram].judul"
                                        class="inline-flex items-center px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs rounded-xl transition gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                                    Perbesar Fullscreen
                                </button>
                                <a :href="diagrams[activeDiagram].gambar" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center p-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs transition" title="Buka Tab Baru">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            </div>
                        </div>

                        <!-- Active Diagram Image Viewer -->
                        <div class="relative rounded-2xl overflow-hidden bg-slate-900/5 border border-slate-200 cursor-pointer group"
                             @click="lightboxOpen = true; lightboxSrc = diagrams[activeDiagram].gambar; lightboxCaption = diagrams[activeDiagram].judul">
                            <img :src="diagrams[activeDiagram].gambar" 
                                 :alt="diagrams[activeDiagram].judul" 
                                 class="w-full h-auto max-h-[600px] object-contain mx-auto transition-transform duration-300 group-hover:scale-[1.01]">
                            
                            <!-- Hover Overlay Prompt -->
                            <div class="absolute inset-0 bg-slate-950/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                                <span class="px-4 py-2 bg-slate-900/80 backdrop-blur-xs text-white text-xs font-bold rounded-xl shadow-lg flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                                    Klik untuk Zoom Ukuran Penuh
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Multiple Diagrams Thumbnail Selector (if more than 1) -->
                    <template x-if="diagrams.length > 1">
                        <div>
                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Diagram Lainnya (Klik untuk Membuka):</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                <template x-for="(d, idx) in diagrams" :key="idx">
                                    <button type="button"
                                            @click="activeDiagram = idx"
                                            :class="activeDiagram === idx ? 'ring-2 ring-blue-600 bg-blue-50/50' : 'bg-white hover:bg-slate-50'"
                                            class="p-3.5 rounded-2xl border border-slate-200 text-left transition flex items-center gap-3">
                                        <div class="w-16 h-12 rounded-lg overflow-hidden bg-slate-100 shrink-0 border border-slate-200">
                                            <img :src="d.gambar" :alt="d.judul" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-bold text-xs text-slate-900 truncate" x-text="d.judul"></p>
                                            <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5" x-text="d.deskripsi"></p>
                                        </div>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
            <template x-if="diagrams.length === 0">
                <div class="py-12 text-center bg-white rounded-2xl border border-slate-200 p-8">
                    <p class="text-sm text-slate-500">Diagram bagan struktur organisasi sedang disiapkan.</p>
                </div>
            </template>
        </div>

        <div class="mt-10 text-center">
            <a href="{{ url(app('tenant')->slug . '/profil') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Halaman Profil Lengkap
            </a>
        </div>
    </div>
</section>
@endsection
