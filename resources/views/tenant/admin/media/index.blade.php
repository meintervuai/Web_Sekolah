@extends('layouts.tenant_admin')

@section('title', 'Pusat Manajemen Media')

@section('content')
<div x-data="mediaManager()" class="space-y-5">

    <!-- Page Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Pusat Manajemen Media
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Pustaka berkas terpadu: kompresi WebP otomatis, video YouTube/lokal, dan seleksi kelola massal.
            </p>
        </div>
        <div class="flex items-center gap-2.5 shrink-0">
            <!-- Tombol Impor URL / YouTube -->
            <button 
                type="button" 
                @click="openImportUrlModal()"
                class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold shadow-2xs transition cursor-pointer"
            >
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
                <span>Impor URL / YouTube</span>
            </button>

            <!-- Tombol Unggah Berkas Baru -->
            <button 
                type="button" 
                @click="openUploadModal()"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs transition cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                <span>Unggah Berkas Baru</span>
            </button>
        </div>
    </div>

    <!-- Filter Toolbar Terpadu (Monokrom, Bersih, Selaras & Rapi) -->
    <div class="bg-white p-3.5 sm:p-4 rounded-2xl border border-slate-200/80 shadow-2xs space-y-3">
        
        <!-- Baris 1: Filter Chips Kategori Media (Netral Slate, Terpadu) -->
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 text-xs scrollbar-none border-b border-slate-100 sm:border-0 sm:pb-0">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider hidden sm:inline-block mr-1">Tipe:</span>
            
            <a href="{{ route('tenant.admin.media.index', ['tenant' => $tenant->slug, 'tipe' => 'semua', 'q' => request('q'), 'kategori' => request('kategori')]) }}" 
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-semibold transition shrink-0 text-xs {{ $tipe === 'semua' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                <span>Semua</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] font-bold {{ $tipe === 'semua' ? 'bg-slate-800 text-slate-200' : 'bg-white text-slate-600 border border-slate-200/80' }}">{{ $stats['total'] }}</span>
            </a>

            <a href="{{ route('tenant.admin.media.index', ['tenant' => $tenant->slug, 'tipe' => 'gambar', 'q' => request('q'), 'kategori' => request('kategori')]) }}" 
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-semibold transition shrink-0 text-xs {{ $tipe === 'gambar' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                <span>Gambar</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] font-bold {{ $tipe === 'gambar' ? 'bg-slate-800 text-slate-200' : 'bg-white text-slate-600 border border-slate-200/80' }}">{{ $stats['gambar'] }}</span>
            </a>

            <a href="{{ route('tenant.admin.media.index', ['tenant' => $tenant->slug, 'tipe' => 'video', 'q' => request('q'), 'kategori' => request('kategori')]) }}" 
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-semibold transition shrink-0 text-xs {{ $tipe === 'video' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                <span>Video Lokal</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] font-bold {{ $tipe === 'video' ? 'bg-slate-800 text-slate-200' : 'bg-white text-slate-600 border border-slate-200/80' }}">{{ $stats['video'] }}</span>
            </a>

            <a href="{{ route('tenant.admin.media.index', ['tenant' => $tenant->slug, 'tipe' => 'youtube', 'q' => request('q'), 'kategori' => request('kategori')]) }}" 
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-semibold transition shrink-0 text-xs {{ $tipe === 'youtube' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                <span>YouTube</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] font-bold {{ $tipe === 'youtube' ? 'bg-slate-800 text-slate-200' : 'bg-white text-slate-600 border border-slate-200/80' }}">{{ $stats['youtube'] }}</span>
            </a>

            <a href="{{ route('tenant.admin.media.index', ['tenant' => $tenant->slug, 'tipe' => 'dokumen', 'q' => request('q'), 'kategori' => request('kategori')]) }}" 
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-semibold transition shrink-0 text-xs {{ $tipe === 'dokumen' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                <span>Dokumen</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] font-bold {{ $tipe === 'dokumen' ? 'bg-slate-800 text-slate-200' : 'bg-white text-slate-600 border border-slate-200/80' }}">{{ $stats['dokumen'] }}</span>
            </a>
        </div>

        <!-- Baris 2: Form Pencarian, Dropdown Kategori, Bulk Action, dan Switcher Grid/List di Sisi Kanan -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-2.5 sm:border-t sm:border-slate-100">
            
            <!-- Pencarian & Kategori -->
            <form method="GET" action="{{ route('tenant.admin.media.index', ['tenant' => $tenant->slug]) }}" class="flex flex-wrap items-center gap-2 flex-1">
                <input type="hidden" name="tipe" value="{{ $tipe }}">
                
                @if($daftarKategori->count() > 0)
                <select name="kategori" onchange="this.form.submit()" class="text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-slate-900">
                    <option value="">Semua Kategori</option>
                    @foreach($daftarKategori as $kat)
                        <option value="{{ $kat }}" {{ request('kategori') === $kat ? 'selected' : '' }}>{{ ucfirst($kat) }}</option>
                    @endforeach
                </select>
                @endif

                <div class="relative">
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ request('q') }}" 
                        placeholder="Cari nama berkas..." 
                        class="text-xs pl-8 pr-3 py-2 w-44 sm:w-60 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-900"
                    >
                    <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <button type="submit" class="px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs cursor-pointer shadow-2xs transition">
                    Cari
                </button>

                @if(request('q') || request('kategori') || ($tipe && $tipe !== 'semua'))
                <a href="{{ route('tenant.admin.media.index', ['tenant' => $tenant->slug]) }}" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-xs transition">
                    Reset
                </a>
                @endif
            </form>

            <!-- Sisi Kanan: Bulk Action Bar & Toggle Grid/Tabel -->
            <div class="flex items-center justify-between sm:justify-end gap-3 shrink-0">
                
                <!-- Tombol Hapus Massal jika Ada yang Dicentang -->
                <div x-show="selectedIds.length > 0" x-cloak class="flex items-center gap-2 bg-slate-100 border border-slate-200 px-3 py-1 rounded-xl">
                    <span class="text-xs font-bold text-slate-700" x-text="selectedIds.length + ' terpilih'"></span>
                    <button 
                        type="button" 
                        @click="openBulkDeleteModal()" 
                        class="px-2.5 py-1 bg-rose-600 hover:bg-rose-700 text-white text-[11px] font-bold rounded-lg shadow-2xs transition cursor-pointer flex items-center gap-1"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        <span>Hapus</span>
                    </button>
                </div>

                <!-- Toggle Grid vs List (Selalu Mojok ke Kanan) -->
                <div class="flex items-center p-0.5 bg-slate-100 rounded-xl border border-slate-200 shrink-0 ml-auto">
                    <button 
                        type="button" 
                        @click="setViewMode('grid')" 
                        :class="viewMode === 'grid' ? 'bg-white text-slate-900 font-bold shadow-2xs' : 'text-slate-500 hover:text-slate-800'"
                        class="px-3 py-1.5 rounded-lg text-xs transition cursor-pointer flex items-center gap-1.5"
                        title="Tampilan Grid / Galeri"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span class="hidden sm:inline text-xs font-semibold">Grid</span>
                    </button>
                    <button 
                        type="button" 
                        @click="setViewMode('list')" 
                        :class="viewMode === 'list' ? 'bg-white text-slate-900 font-bold shadow-2xs' : 'text-slate-500 hover:text-slate-800'"
                        class="px-3 py-1.5 rounded-lg text-xs transition cursor-pointer flex items-center gap-1.5"
                        title="Tampilan Daftar / Tabel"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <span class="hidden sm:inline text-xs font-semibold">Tabel</span>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Media Container (Empty State / Grid / List) -->
    @if($medias->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center">
            <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="font-bold text-slate-800 text-sm">Pustaka Media Masih Kosong</h3>
            <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                Belum ada berkas yang sesuai dengan kriteria filter. Silakan unggah berkas baru atau impor dari URL.
            </p>
            <div class="mt-4 flex items-center justify-center gap-2">
                <button type="button" @click="openUploadModal()" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs cursor-pointer">
                    Unggah Berkas Sekarang
                </button>
            </div>
        </div>
    @else

        <!-- Toolbar Centang Semua Berkas -->
        <div class="flex items-center justify-between px-2 text-xs text-slate-600">
            <label class="inline-flex items-center gap-2 font-semibold cursor-pointer">
                <input 
                    type="checkbox" 
                    @change="toggleSelectAll($event)" 
                    :checked="isAllSelected()"
                    class="w-4 h-4 rounded text-blue-600 border-slate-300 focus:ring-blue-500 cursor-pointer"
                >
                <span>Pilih Semua Berkas di Halaman Ini ({{ $medias->count() }})</span>
            </label>
        </div>

        <!-- ========================================================================= -->
        <!-- A. TAMPILAN GRID / BENTO -->
        <!-- ========================================================================= -->
        <div x-show="viewMode === 'grid'" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($medias as $media)
                <div class="group bg-white rounded-xl border border-slate-200/80 overflow-hidden shadow-2xs hover:shadow-md transition-all flex flex-col justify-between relative" :class="selectedIds.includes({{ $media->id }}) ? 'ring-2 ring-blue-600 border-blue-600' : ''">
                    
                    <!-- Checkbox Seleksi Grid -->
                    <div class="absolute top-2 left-2 z-10">
                        <input 
                            type="checkbox" 
                            :value="{{ $media->id }}" 
                            x-model="selectedIds"
                            class="w-4 h-4 rounded bg-white/90 text-blue-600 border-slate-300 focus:ring-blue-500 shadow-sm cursor-pointer"
                        >
                    </div>

                    <!-- Badge Status Penggunaan di Website -->
                    <div class="absolute top-2 right-2 z-10">
                        @if($media->is_digunakan)
                            <span class="px-2 py-0.5 text-[9px] font-bold rounded-md shadow-xs bg-emerald-600 text-white flex items-center gap-1 cursor-help" 
                                  title="Sedang Dipakai di: {{ implode(', ', $media->penggunaan) }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                Digunakan
                            </span>
                        @else
                            <span class="px-1.5 py-0.5 text-[9px] font-semibold rounded-md shadow-xs bg-black/60 backdrop-blur-xs text-slate-300 border border-white/20">
                                Bebas
                            </span>
                        @endif
                    </div>

                    <!-- Media Preview Box -->
                    <div class="relative bg-slate-900 aspect-square overflow-hidden flex items-center justify-center">
                        @if($media->tipe_media === 'gambar')
                            <img 
                                src="{{ $media->url }}" 
                                alt="{{ $media->alt_teks ?: $media->judul }}" 
                                loading="lazy"
                                style="{{ $media->smart_crop_style }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            >
                            <span class="absolute bottom-2 left-2 px-1.5 py-0.5 bg-black/70 backdrop-blur-xs text-white text-[9px] font-bold rounded uppercase">
                                {{ $media->ekstensi ?: 'webp' }}
                            </span>
                        @elseif($media->tipe_media === 'youtube')
                            @php
                                $ytId = null;
                                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $media->url, $m)) {
                                    $ytId = $m[1];
                                }
                            @endphp
                            <img 
                                src="{{ $ytId ? 'https://img.youtube.com/vi/' . $ytId . '/hqdefault.jpg' : 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=600' }}" 
                                alt="{{ $media->judul }}" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            >
                            <span class="absolute bottom-2 left-2 px-1.5 py-0.5 bg-rose-600 text-white text-[9px] font-bold rounded uppercase flex items-center gap-1 shadow-xs">
                                <svg class="w-2.5 h-2.5 fill-current" viewBox="0 0 24 24"><path d="M10 15l5.19-3L10 9v6m11.56-7.83c.13.47.22 1.1.28 1.9.07.8.1 1.49.1 2.09L22 12c0 2.19-.16 3.8-.44 4.83-.25.9-.83 1.48-1.73 1.73-.47.13-1.33.22-2.65.28-1.3.07-2.49.1-3.59.1L12 22c-4.19 0-6.8-.16-7.83-.44-.9-.25-1.48-.83-1.73-1.73-.13-.47-.22-1.1-.28-1.9-.07-.8-.1-1.49-.1-2.09L2 12c0-2.19.16-3.8.44-4.83.25-.9.83-1.48 1.73-1.73.47-.13 1.33-.22 2.65-.28 1.3-.07 2.49-.1 3.59-.1L12 2c4.19 0 6.8.16 7.83.44.9.25 1.48.83 1.73 1.73z"/></svg>
                                YouTube
                            </span>
                        @elseif($media->tipe_media === 'video')
                            <!-- Live Thumbnail Video MP4 / Lokal -->
                            <div class="w-full h-full relative overflow-hidden bg-slate-950 flex items-center justify-center">
                                <video src="{{ $media->url }}" preload="metadata" muted playsinline class="w-full h-full object-cover pointer-events-none opacity-85 group-hover:scale-105 transition-transform duration-300"></video>
                                <div class="absolute inset-0 flex items-center justify-center bg-black/25 pointer-events-none">
                                    <div class="w-8 h-8 rounded-full bg-blue-600/90 text-white flex items-center justify-center shadow-md">
                                        <svg class="w-4 h-4 ml-0.5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </div>
                                </div>
                                <span class="absolute bottom-2 left-2 px-1.5 py-0.5 bg-slate-900/90 text-blue-300 font-mono text-[9px] font-bold rounded uppercase shadow-xs">
                                    {{ $media->ekstensi ?: 'mp4' }}
                                </span>
                            </div>
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-slate-50 text-slate-700 p-3 text-center">
                                <svg class="w-8 h-8 text-blue-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="text-[10px] text-slate-600 font-mono uppercase">{{ $media->ekstensi ?: 'pdf' }}</span>
                            </div>
                        @endif

                        <!-- Hover Overlay Action Bar -->
                        <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-1.5 p-2">
                            @if($media->tipe_media === 'gambar')
                            <button 
                                type="button" 
                                @click="openEditorModal({{ json_encode($media) }})" 
                                class="p-2 bg-white text-blue-600 rounded-xl hover:bg-blue-50 shadow-xs text-xs font-semibold cursor-pointer transition"
                                title="Crop Foto &amp; Pratinjau Rasio"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            @endif

                            <button 
                                type="button" 
                                @click="openRenameModal({{ json_encode($media) }})" 
                                class="p-2 bg-white text-amber-600 rounded-xl hover:bg-amber-50 shadow-xs text-xs font-semibold cursor-pointer transition"
                                title="Ubah Nama &amp; Informasi"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                            </button>

                            <button 
                                type="button" 
                                @click="confirmSingleDelete({{ $media->id }}, '{{ addslashes($media->judul) }}')" 
                                class="p-2 bg-white text-rose-600 rounded-xl hover:bg-rose-50 shadow-xs text-xs font-semibold cursor-pointer transition"
                                title="Hapus Berkas"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Meta Details -->
                    <div class="p-2.5">
                        <div class="font-bold text-slate-900 text-xs truncate" title="{{ $media->judul }}">{{ $media->judul }}</div>
                        <div class="flex items-center justify-between text-[10px] text-slate-400 mt-1">
                            <span class="truncate capitalize">{{ $media->kategori }}</span>
                            <span>{{ $media->ukuran_formatted }}</span>
                        </div>
                        @if($media->is_digunakan)
                            <div class="text-[9px] text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded mt-1.5 truncate" title="Digunakan di: {{ implode(', ', $media->penggunaan) }}">
                                &#10003; {{ $media->penggunaan[0] ?? 'Digunakan' }}
                            </div>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>

        <!-- ========================================================================= -->
        <!-- B. TAMPILAN TABEL / LIST -->
        <!-- ========================================================================= -->
        <div x-show="viewMode === 'list'" class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-2xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="py-3 px-4 w-10 text-center">
                                <input 
                                    type="checkbox" 
                                    @change="toggleSelectAll($event)" 
                                    :checked="isAllSelected()"
                                    class="w-4 h-4 rounded text-blue-600 border-slate-300 focus:ring-blue-500 cursor-pointer"
                                >
                            </th>
                            <th class="py-3 px-4 w-16">Preview</th>
                            <th class="py-3 px-4">Nama / Judul Berkas</th>
                            <th class="py-3 px-4">Status Pakai</th>
                            <th class="py-3 px-4">Tipe &amp; Sumber</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4">Ukuran &amp; Dimensi</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4 text-right w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($medias as $media)
                            <tr class="hover:bg-slate-50/80 transition" :class="selectedIds.includes({{ $media->id }}) ? 'bg-blue-50/40' : ''">
                                <!-- Checkbox Baris -->
                                <td class="py-2.5 px-4 text-center">
                                    <input 
                                        type="checkbox" 
                                        :value="{{ $media->id }}" 
                                        x-model="selectedIds"
                                        class="w-4 h-4 rounded text-blue-600 border-slate-300 focus:ring-blue-500 cursor-pointer"
                                    >
                                </td>

                                <!-- Thumbnail -->
                                <td class="py-2.5 px-4">
                                    <div class="w-12 h-12 rounded-lg bg-slate-900 overflow-hidden shrink-0 border border-slate-200 flex items-center justify-center">
                                        @if($media->tipe_media === 'gambar')
                                            <img src="{{ $media->url }}" alt="{{ $media->judul }}" style="{{ $media->smart_crop_style }}" class="w-full h-full object-cover">
                                        @elseif($media->tipe_media === 'youtube')
                                            @php
                                                $ytId = null;
                                                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $media->url, $m)) {
                                                    $ytId = $m[1];
                                                }
                                            @endphp
                                            <img src="{{ $ytId ? 'https://img.youtube.com/vi/' . $ytId . '/hqdefault.jpg' : '' }}" alt="YouTube" class="w-full h-full object-cover">
                                        @elseif($media->tipe_media === 'video')
                                            <video src="{{ $media->url }}" preload="metadata" muted class="w-full h-full object-cover pointer-events-none"></video>
                                        @else
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        @endif
                                    </div>
                                </td>

                                <!-- Judul & File Asli -->
                                <td class="py-2.5 px-4 max-w-xs">
                                    <div class="font-bold text-slate-900 truncate" title="{{ $media->judul }}">{{ $media->judul }}</div>
                                    <div class="text-[11px] text-slate-400 truncate">{{ $media->nama_file_asli ?: $media->nama_file_disimpan }}</div>
                                </td>

                                <!-- Status Penggunaan -->
                                <td class="py-2.5 px-4 whitespace-nowrap">
                                    @if($media->is_digunakan)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200" title="Digunakan di: {{ implode(', ', $media->penggunaan) }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Digunakan ({{ count($media->penggunaan) }})
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-medium bg-slate-100 text-slate-500">
                                            Bebas
                                        </span>
                                    @endif
                                </td>

                                <!-- Tipe & Sumber -->
                                <td class="py-2.5 px-4 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5">
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase bg-slate-100 text-slate-700 border border-slate-200/80">
                                            {{ $media->ekstensi ?: $media->tipe_media }}
                                        </span>
                                        <span class="px-1.5 py-0.5 text-[9px] font-semibold rounded-md bg-slate-50 text-slate-500 border border-slate-200">
                                            {{ $media->sumber === 'youtube' ? 'YouTube' : ($media->sumber === 'url_eksternal' ? 'Impor URL' : 'Upload') }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Kategori -->
                                <td class="py-2.5 px-4 whitespace-nowrap">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700 capitalize">
                                        {{ $media->kategori }}
                                    </span>
                                </td>

                                <!-- Ukuran & Dimensi -->
                                <td class="py-2.5 px-4 whitespace-nowrap text-[11px] text-slate-600">
                                    <div>{{ $media->ukuran_formatted }}</div>
                                    <div class="text-slate-400 text-[10px]">{{ $media->dimensi ?: '-' }}</div>
                                </td>

                                <!-- Tanggal -->
                                <td class="py-2.5 px-4 whitespace-nowrap text-[11px] text-slate-500">
                                    {{ $media->created_at ? $media->created_at->format('d M Y') : '-' }}
                                </td>

                                <!-- Aksi -->
                                <td class="py-2.5 px-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        @if($media->tipe_media === 'gambar')
                                        <button 
                                            type="button" 
                                            @click="openEditorModal({{ json_encode($media) }})" 
                                            class="p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition cursor-pointer"
                                            title="Crop Foto &amp; Pratinjau Rasio"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        @endif

                                        <button 
                                            type="button" 
                                            @click="openRenameModal({{ json_encode($media) }})" 
                                            class="p-1.5 text-amber-600 hover:text-amber-800 hover:bg-amber-50 rounded-lg transition cursor-pointer"
                                            title="Ubah Nama &amp; Informasi"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </button>

                                        <button 
                                            type="button" 
                                            @click="confirmSingleDelete({{ $media->id }}, '{{ addslashes($media->judul) }}')" 
                                            class="p-1.5 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition cursor-pointer"
                                            title="Hapus Berkas"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination Links -->
        <div class="mt-6">
            {{ $medias->links() }}
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- 1. MODAL UNGGAH BERKAS LOKAL DENGAN PROGRESS LOADING -->
    <!-- ========================================================================= -->
    <div 
        x-show="isUploadModalOpen" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4"
    >
        <div 
            @click.away="!isSubmitting && (isUploadModalOpen = false)" 
            class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 space-y-4 relative"
        >
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Unggah Berkas Baru
                </h3>
                <button type="button" :disabled="isSubmitting" @click="isUploadModalOpen = false" class="text-slate-400 hover:text-slate-700 cursor-pointer disabled:opacity-30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form @submit="handleSubmit('Mengunggah &amp; mengompresi WebP...')" action="{{ route('tenant.admin.media.upload', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <!-- File Input Drag & Drop Zone -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Berkas (Gambar / Video / PDF)</label>
                    <input 
                        type="file" 
                        name="file" 
                        required 
                        accept="image/*,video/mp4,video/webm,application/pdf"
                        class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-200 rounded-xl p-2 bg-slate-50 cursor-pointer"
                    >
                    <p class="text-[11px] text-slate-400 mt-1">
                        * Gambar otomatis dikonversi ke format <strong>.webp</strong> &amp; dikompresi agar loading halaman secepat kilat.
                    </p>
                </div>

                <!-- Judul Kustom -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama / Judul Berkas (Opsional)</label>
                    <input 
                        type="text" 
                        name="judul" 
                        placeholder="Contoh: Gedung Workshop TBSM Baru" 
                        class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-600"
                    >
                </div>

                <!-- Kategori Fleksibel -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Kategori</label>
                    <select 
                        name="kategori_select" 
                        x-model="uploadKategoriSelect"
                        @change="onUploadKategoriChange()"
                        class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-600"
                    >
                        @foreach($daftarKategori as $kat)
                            <option value="{{ $kat }}">{{ ucfirst($kat) }}</option>
                        @endforeach
                        @if(!$daftarKategori->contains('umum'))
                            <option value="umum">Umum</option>
                        @endif
                        <option value="__tambah_baru__">+ Tambah Kategori Baru...</option>
                    </select>

                    <div x-show="uploadIsCustomKategori" class="mt-2">
                        <input 
                            type="text" 
                            name="kategori_custom" 
                            x-model="uploadKategoriCustom"
                            placeholder="Ketik nama kategori baru..." 
                            class="w-full text-xs px-3 py-2 bg-white border border-blue-300 rounded-xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-600"
                        >
                    </div>
                    <input type="hidden" name="kategori" :value="uploadFinalKategori">
                </div>

                <!-- Alt Teks -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Alt Teks / Deskripsi (SEO)</label>
                    <input 
                        type="text" 
                        name="alt_teks" 
                        placeholder="Deskripsi singkat gambar..." 
                        class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-600"
                    >
                </div>

                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" :disabled="isSubmitting" @click="isUploadModalOpen = false" class="px-4 py-2 rounded-xl text-slate-600 hover:bg-slate-100 text-xs font-semibold cursor-pointer disabled:opacity-50">
                        Batal
                    </button>
                    <button type="submit" :disabled="isSubmitting" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs cursor-pointer disabled:opacity-60">
                        <svg x-show="isSubmitting" class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span x-text="isSubmitting ? 'Mengunggah & Memproses...' : 'Mulai Unggah'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 2. MODAL IMPOR URL / YOUTUBE DENGAN LIVE CHECK & PREVIEW -->
    <!-- ========================================================================= -->
    <div 
        x-show="isImportModalOpen" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4"
    >
        <div 
            @click.away="!isSubmitting && (isImportModalOpen = false)" 
            class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 space-y-4"
        >
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                    Impor Media dari Tautan URL / YouTube
                </h3>
                <button type="button" :disabled="isSubmitting" @click="isImportModalOpen = false" class="text-slate-400 hover:text-slate-700 cursor-pointer disabled:opacity-30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form @submit="handleSubmit('Menyimpan tautan media...')" action="{{ route('tenant.admin.media.import-url', ['tenant' => $tenant->slug]) }}" method="POST" class="space-y-4">
                @csrf

                <!-- URL Input + Live Check Button -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tautan URL Gambar atau Video YouTube</label>
                    <div class="flex gap-2">
                        <input 
                            type="url" 
                            name="url" 
                            x-model="importUrlInput"
                            required 
                            placeholder="https://www.youtube.com/watch?v=... atau https://domain.com/gambar.jpg" 
                            class="flex-1 text-xs px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-600"
                        >
                        <button 
                            type="button" 
                            @click="checkUrlLive()"
                            :disabled="isCheckingUrl"
                            class="px-3 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold shrink-0 cursor-pointer disabled:opacity-50 flex items-center gap-1.5"
                        >
                            <svg x-show="isCheckingUrl" class="animate-spin w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            <span x-text="isCheckingUrl ? 'Memeriksa...' : 'Cek URL'"></span>
                        </button>
                    </div>
                </div>

                <!-- Preview Container -->
                <div x-show="urlCheckResult.checked" class="p-3 rounded-xl border border-slate-200 bg-slate-50 space-y-2">
                    <div class="flex items-center gap-2">
                        <span 
                            class="w-2.5 h-2.5 rounded-full" 
                            :class="urlCheckResult.valid ? 'bg-emerald-500' : 'bg-rose-500'"
                        ></span>
                        <span class="text-xs font-bold" :class="urlCheckResult.valid ? 'text-emerald-700' : 'text-rose-700'" x-text="urlCheckResult.pesan"></span>
                    </div>

                    <template x-if="urlCheckResult.preview_url">
                        <div class="rounded-lg overflow-hidden bg-black aspect-video border border-slate-200">
                            <img :src="urlCheckResult.preview_url" alt="Pratinjau Media" class="w-full h-full object-cover">
                        </div>
                    </template>
                </div>

                <!-- Judul Kustom -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama / Judul Berkas</label>
                    <input 
                        type="text" 
                        name="judul" 
                        x-model="importJudul"
                        placeholder="Judul untuk media ini" 
                        class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-600"
                    >
                </div>

                <!-- Kategori Fleksibel -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Kategori</label>
                    <select 
                        name="kategori_select" 
                        x-model="importKategoriSelect"
                        @change="onImportKategoriChange()"
                        class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-600"
                    >
                        @foreach($daftarKategori as $kat)
                            <option value="{{ $kat }}">{{ ucfirst($kat) }}</option>
                        @endforeach
                        @if(!$daftarKategori->contains('umum'))
                            <option value="umum">Umum</option>
                        @endif
                        <option value="__tambah_baru__">+ Tambah Kategori Baru...</option>
                    </select>

                    <div x-show="importIsCustomKategori" class="mt-2">
                        <input 
                            type="text" 
                            name="kategori_custom" 
                            x-model="importKategoriCustom"
                            placeholder="Ketik nama kategori baru..." 
                            class="w-full text-xs px-3 py-2 bg-white border border-blue-300 rounded-xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-600"
                        >
                    </div>
                    <input type="hidden" name="kategori" :value="importFinalKategori">
                </div>

                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" :disabled="isSubmitting" @click="isImportModalOpen = false" class="px-4 py-2 rounded-xl text-slate-600 hover:bg-slate-100 text-xs font-semibold cursor-pointer disabled:opacity-50">
                        Batal
                    </button>
                    <button type="submit" :disabled="isSubmitting" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs cursor-pointer disabled:opacity-60">
                        <svg x-show="isSubmitting" class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span x-text="isSubmitting ? 'Mengunduh & Menyimpan...' : 'Impor & Simpan ke Pustaka'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 3. MODAL RENAME / EDIT INFORMASI BERKAS -->
    <!-- ========================================================================= -->
    <div 
        x-show="isRenameModalOpen" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4"
    >
        <div 
            @click.away="!isSubmitting && (isRenameModalOpen = false)" 
            class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4"
        >
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="font-bold text-slate-900 text-base">Ubah Informasi Berkas</h3>
                <button type="button" :disabled="isSubmitting" @click="isRenameModalOpen = false" class="text-slate-400 hover:text-slate-700 cursor-pointer disabled:opacity-30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <template x-if="selectedMedia">
                <form @submit="handleSubmit('Menyimpan perubahan informasi...')" :action="updateUrl" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Judul / Nama Tampilan Berkas</label>
                        <input 
                            type="text" 
                            name="judul" 
                            x-model="selectedMedia.judul" 
                            required 
                            class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-600"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori</label>
                        <select 
                            x-model="editKategoriSelect"
                            @change="onEditKategoriChange()"
                            class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-600"
                        >
                            @foreach($daftarKategori as $kat)
                                <option value="{{ $kat }}">{{ ucfirst($kat) }}</option>
                            @endforeach
                            <option value="__tambah_baru__">+ Tambah Kategori Baru...</option>
                        </select>

                        <div x-show="editIsCustomKategori" class="mt-2">
                            <input 
                                type="text" 
                                x-model="editKategoriCustom"
                                placeholder="Ketik nama kategori baru..." 
                                class="w-full text-xs px-3 py-2 bg-white border border-blue-300 rounded-xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-600"
                            >
                        </div>
                        <input type="hidden" name="kategori" :value="editFinalKategori">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Alt Teks / Deskripsi SEO</label>
                        <input 
                            type="text" 
                            name="alt_teks" 
                            x-model="selectedMedia.alt_teks" 
                            class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-600"
                        >
                    </div>

                    <div class="pt-2 flex items-center justify-end gap-2">
                        <button type="button" :disabled="isSubmitting" @click="isRenameModalOpen = false" class="px-4 py-2 rounded-xl text-slate-600 hover:bg-slate-100 text-xs font-semibold cursor-pointer disabled:opacity-50">
                            Batal
                        </button>
                        <button type="submit" :disabled="isSubmitting" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs cursor-pointer disabled:opacity-60">
                            <svg x-show="isSubmitting" class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            <span x-text="isSubmitting ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                        </button>
                    </div>
                </form>
            </template>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 4. MODAL INTERACTIVE PREVIEW & FRAMING SIMULATOR (ASPEK RASIO LIVE) -->
    <!-- ========================================================================= -->
    <div 
        x-show="isEditorModalOpen" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/80 backdrop-blur-xs flex items-center justify-center p-4 select-none"
    >
        <div 
            @click.away="isEditorModalOpen = false" 
            class="bg-white rounded-2xl max-w-3xl w-full p-6 shadow-2xl border border-slate-200 space-y-4"
        >
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Crop Foto &amp; Simulator Pratinjau Rasio</h3>
                        <p class="text-[11px] text-slate-500">Pratinjau framing aspek rasio langsung secara interaktif sebelum digunakan.</p>
                    </div>
                </div>
                <button type="button" @click="isEditorModalOpen = false" class="text-slate-400 hover:text-slate-700 cursor-pointer p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Toolbar Rasio & Rotasi -->
            <div class="flex flex-wrap items-center justify-between gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200 text-xs">
                <div class="flex flex-wrap items-center gap-1.5">
                    <span class="font-bold text-slate-700 mr-1">Simulasi Rasio:</span>
                    <button type="button" @click="setAspectRatio(null)" :class="aspectRatio === null ? 'bg-blue-600 text-white font-bold' : 'bg-white text-slate-700 hover:bg-slate-100'" class="px-2.5 py-1 rounded-lg border border-slate-200 shadow-2xs cursor-pointer transition">Bebas</button>
                    <button type="button" @click="setAspectRatio(16/9)" :class="aspectRatio === 16/9 ? 'bg-blue-600 text-white font-bold' : 'bg-white text-slate-700 hover:bg-slate-100'" class="px-2.5 py-1 rounded-lg border border-slate-200 shadow-2xs cursor-pointer transition">16:9 (Hero / Banner)</button>
                    <button type="button" @click="setAspectRatio(4/3)" :class="aspectRatio === 4/3 ? 'bg-blue-600 text-white font-bold' : 'bg-white text-slate-700 hover:bg-slate-100'" class="px-2.5 py-1 rounded-lg border border-slate-200 shadow-2xs cursor-pointer transition">4:3 (Kartu Galeri)</button>
                    <button type="button" @click="setAspectRatio(1/1)" :class="aspectRatio === 1/1 ? 'bg-blue-600 text-white font-bold' : 'bg-white text-slate-700 hover:bg-slate-100'" class="px-2.5 py-1 rounded-lg border border-slate-200 shadow-2xs cursor-pointer transition">1:1 (Logo / Avatar)</button>
                    <button type="button" @click="setAspectRatio(9/16)" :class="aspectRatio === 9/16 ? 'bg-blue-600 text-white font-bold' : 'bg-white text-slate-700 hover:bg-slate-100'" class="px-2.5 py-1 rounded-lg border border-slate-200 shadow-2xs cursor-pointer transition">9:16 (Story / Mobile)</button>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" @click="rotateImage(90)" class="px-3 py-1 bg-white text-slate-700 hover:bg-slate-100 rounded-lg font-semibold border border-slate-200 shadow-2xs flex items-center gap-1 cursor-pointer transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Putar Pratinjau
                    </button>
                </div>
            </div>

            <!-- Petunjuk Penggunaan Framing Box -->
            <div class="text-[11px] text-slate-600 bg-blue-50/70 border border-blue-100 px-3 py-2 rounded-xl flex items-center justify-between">
                <span>💡 <strong>Geser / ubah ukuran kotak framing</strong> untuk menguji fokus tampilan dan rasio gambar saat disematkan di halaman web. Berkas fisik asli tetap aman &amp; tidak diubah.</span>
                <button type="button" @click="resetCropBox()" class="text-blue-600 font-bold hover:underline cursor-pointer">Reset Kotak</button>
            </div>

            <!-- Image Canvas / Interactive Crop Preview Container -->
            <div 
                id="cropContainer"
                class="relative bg-slate-950 rounded-xl overflow-hidden min-h-[340px] max-h-[460px] flex items-center justify-center p-2"
                @mousemove="onMouseMove($event)"
                @mouseup="onMouseUp($event)"
                @mouseleave="onMouseUp($event)"
                @touchmove="onTouchMove($event)"
                @touchend="onMouseUp($event)"
            >
                <!-- Wrapper Gambar yang diposisikan & diukur -->
                <div class="relative inline-block overflow-hidden" id="imageWrapper">
                    <img 
                        id="editorImagePreview" 
                        :src="editorImageSrc" 
                        @load="onImageLoaded()"
                        :style="'transform: rotate(' + currentRotation + 'deg);'"
                        alt="Editor Preview" 
                        class="max-h-[380px] max-w-full block object-contain pointer-events-none"
                    >

                    <!-- Semi-transparent Dark Overlay Di Seluruh Gambar -->
                    <div class="absolute inset-0 bg-black/55 pointer-events-none"></div>

                    <!-- Kotak Crop Terang Aktif (Draggable & Resizable) -->
                    <div 
                        id="cropBox"
                        class="absolute border-2 border-white shadow-[0_0_0_9999px_rgba(0,0,0,0.55)] cursor-move transition-[box-shadow]"
                        :style="`left: ${cropBox.x}px; top: ${cropBox.y}px; width: ${cropBox.w}px; height: ${cropBox.h}px;`"
                        @mousedown.stop="startDrag($event)"
                        @touchstart.stop="startDragTouch($event)"
                    >
                        <!-- Grid Lines Rule of Thirds -->
                        <div class="w-full h-full grid grid-cols-3 grid-rows-3 pointer-events-none opacity-40">
                            <div class="border-r border-b border-white/80"></div>
                            <div class="border-r border-b border-white/80"></div>
                            <div class="border-b border-white/80"></div>
                            <div class="border-r border-b border-white/80"></div>
                            <div class="border-r border-b border-white/80"></div>
                            <div class="border-b border-white/80"></div>
                            <div class="border-r border-white/80"></div>
                            <div class="border-r border-white/80"></div>
                            <div></div>
                        </div>

                        <!-- 4 Corner Handles untuk Resize -->
                        <div @mousedown.stop="startResize($event, 'tl')" class="absolute -top-1.5 -left-1.5 w-3.5 h-3.5 bg-blue-500 border-2 border-white rounded-xs cursor-nwse-resize"></div>
                        <div @mousedown.stop="startResize($event, 'tr')" class="absolute -top-1.5 -right-1.5 w-3.5 h-3.5 bg-blue-500 border-2 border-white rounded-xs cursor-nesw-resize"></div>
                        <div @mousedown.stop="startResize($event, 'bl')" class="absolute -bottom-1.5 -left-1.5 w-3.5 h-3.5 bg-blue-500 border-2 border-white rounded-xs cursor-nesw-resize"></div>
                        <div @mousedown.stop="startResize($event, 'br')" class="absolute -bottom-1.5 -right-1.5 w-3.5 h-3.5 bg-blue-500 border-2 border-white rounded-xs cursor-nwse-resize"></div>
                    </div>
                </div>
            </div>

            <!-- Footer Pratinjau & Simpan Focal Point -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-3 border-t border-slate-100">
                <div class="text-xs text-slate-500">
                    * Berkas asli tetap utuh &amp; aman. Titik fokus crop akan otomatis diterapkan di seluruh kartu &amp; banner web.
                </div>

                <div class="flex items-center justify-end gap-2">
                    <button type="button" :disabled="isSubmitting" @click="isEditorModalOpen = false" class="px-4 py-2 rounded-xl text-slate-600 hover:bg-slate-100 text-xs font-semibold cursor-pointer disabled:opacity-50">
                        Tutup
                    </button>
                    <button type="button" :disabled="isSubmitting" @click="saveCropSettings()" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs cursor-pointer disabled:opacity-60">
                        <svg x-show="isSubmitting" class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span x-text="isSubmitting ? 'Menyimpan...' : 'Simpan Fokus Crop'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 5. MODAL KONFIRMASI HAPUS KUSTOM (CUSTOM CONFIRMATION POPUP) -->
    <!-- ========================================================================= -->
    <div 
        x-show="isConfirmModalOpen" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4"
    >
        <div 
            @click.away="!isSubmitting && (isConfirmModalOpen = false)" 
            class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl border border-slate-200 text-center space-y-4"
        >
            <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>

            <div>
                <h3 class="font-bold text-slate-900 text-base" x-text="confirmModalTitle"></h3>
                <p class="text-xs text-slate-500 mt-1.5 leading-relaxed" x-text="confirmModalMessage"></p>
            </div>

            <div class="pt-2 flex items-center justify-center gap-2.5">
                <button 
                    type="button" 
                    :disabled="isSubmitting"
                    @click="isConfirmModalOpen = false" 
                    class="px-4 py-2 rounded-xl text-slate-700 bg-slate-100 hover:bg-slate-200 text-xs font-semibold cursor-pointer disabled:opacity-50"
                >
                    Batal
                </button>
                <button 
                    type="button" 
                    :disabled="isSubmitting"
                    @click="executeConfirmedDelete()" 
                    class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-xs cursor-pointer disabled:opacity-60"
                >
                    <svg x-show="isSubmitting" class="animate-spin w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span x-text="isSubmitting ? 'Menghapus...' : 'Ya, Hapus'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden Form for Single Delete -->
    <form id="globalDeleteMediaForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- Hidden Form for Bulk Delete -->
    <form id="globalBulkDeleteMediaForm" action="{{ route('tenant.admin.media.bulk-destroy', ['tenant' => $tenant->slug]) }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="ids" id="bulkDeleteIdsInput">
    </form>

    <!-- Global Fullscreen Processing Indicator Modal -->
    <div 
        x-show="isSubmitting" 
        x-cloak
        class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-xs flex flex-col items-center justify-center text-white p-4"
    >
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-2xl flex flex-col items-center gap-3 max-w-xs text-center">
            <svg class="animate-spin w-8 h-8 text-blue-500" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            <div class="font-bold text-sm text-slate-100" x-text="submittingText"></div>
            <div class="text-[11px] text-slate-400">Mohon tunggu sebentar, sistem sedang memproses data berkas Anda.</div>
        </div>
    </div>

</div>

<script>
function mediaManager() {
    return {
        viewMode: localStorage.getItem('mediaViewMode') || 'grid',

        isUploadModalOpen: false,
        isImportModalOpen: false,
        isRenameModalOpen: false,
        isEditorModalOpen: false,
        isConfirmModalOpen: false,

        // Loading and Submitting Feedback
        isSubmitting: false,
        submittingText: 'Memproses...',

        // Confirmation Modal State
        confirmModalTitle: '',
        confirmModalMessage: '',
        deleteTargetType: 'single', // 'single' atau 'bulk'
        deleteTargetId: null,

        // Selection IDs for Bulk Action
        selectedIds: [],
        pageMediaIds: @json($medias->pluck('id')),

        selectedMedia: null,
        updateUrl: '',
        editImageUrl: '',

        // Upload Form Kategori State
        uploadKategoriSelect: '{{ $daftarKategori->first() ?? "umum" }}',
        uploadKategoriCustom: '',
        uploadIsCustomKategori: false,
        get uploadFinalKategori() {
            return this.uploadIsCustomKategori ? this.uploadKategoriCustom : this.uploadKategoriSelect;
        },
        onUploadKategoriChange() {
            this.uploadIsCustomKategori = (this.uploadKategoriSelect === '__tambah_baru__');
        },

        // Impor Form Kategori State
        importKategoriSelect: '{{ $daftarKategori->first() ?? "umum" }}',
        importKategoriCustom: '',
        importIsCustomKategori: false,
        get importFinalKategori() {
            return this.importIsCustomKategori ? this.importKategoriCustom : this.importKategoriSelect;
        },
        onImportKategoriChange() {
            this.importIsCustomKategori = (this.importKategoriSelect === '__tambah_baru__');
        },

        // Edit Form Kategori State
        editKategoriSelect: '',
        editKategoriCustom: '',
        editIsCustomKategori: false,
        get editFinalKategori() {
            return this.editIsCustomKategori ? this.editKategoriCustom : this.editKategoriSelect;
        },
        onEditKategoriChange() {
            this.editIsCustomKategori = (this.editKategoriSelect === '__tambah_baru__');
        },

        // Impor URL live check
        importUrlInput: '',
        importJudul: '',
        isCheckingUrl: false,
        urlCheckResult: {
            checked: false,
            valid: false,
            preview_url: null,
            pesan: '',
        },

        // Interactive Crop Box Engine
        editorImageSrc: '',
        currentRotation: 0,
        aspectRatio: null,
        cropBox: { x: 20, y: 20, w: 200, h: 150 },
        isDragging: false,
        isResizing: false,
        resizeHandle: null,
        dragStartX: 0,
        dragStartY: 0,
        boxStartX: 0,
        boxStartY: 0,
        boxStartW: 0,
        boxStartH: 0,
        imgNaturalW: 1,
        imgNaturalH: 1,
        imgRenderW: 1,
        imgRenderH: 1,

        get cropDataPayload() {
            if (!this.imgRenderW || !this.imgRenderH) return { x: 0, y: 0, w: 0, h: 0 };
            const scaleX = this.imgNaturalW / this.imgRenderW;
            const scaleY = this.imgNaturalH / this.imgRenderH;
            return {
                x: Math.round(this.cropBox.x * scaleX),
                y: Math.round(this.cropBox.y * scaleY),
                w: Math.round(this.cropBox.w * scaleX),
                h: Math.round(this.cropBox.h * scaleY),
            };
        },

        setViewMode(mode) {
            this.viewMode = mode;
            localStorage.setItem('mediaViewMode', mode);
        },

        isAllSelected() {
            if (this.pageMediaIds.length === 0) return false;
            return this.pageMediaIds.every(id => this.selectedIds.includes(id));
        },

        toggleSelectAll(e) {
            if (e.target.checked) {
                this.selectedIds = Array.from(new Set([...this.selectedIds, ...this.pageMediaIds]));
            } else {
                this.selectedIds = this.selectedIds.filter(id => !this.pageMediaIds.includes(id));
            }
        },

        handleSubmit(msg) {
            this.submittingText = msg || 'Sedang memproses...';
            this.isSubmitting = true;
        },

        openUploadModal() {
            this.uploadKategoriSelect = '{{ $daftarKategori->first() ?? "umum" }}';
            this.uploadKategoriCustom = '';
            this.uploadIsCustomKategori = false;
            this.isUploadModalOpen = true;
        },

        openImportUrlModal() {
            this.importUrlInput = '';
            this.importJudul = '';
            this.importKategoriSelect = '{{ $daftarKategori->first() ?? "umum" }}';
            this.importKategoriCustom = '';
            this.importIsCustomKategori = false;
            this.urlCheckResult = { checked: false, valid: false, preview_url: null, pesan: '' };
            this.isImportModalOpen = true;
        },

        async checkUrlLive() {
            if (!this.importUrlInput) return;
            this.isCheckingUrl = true;
            try {
                const res = await fetch("{{ route('tenant.admin.media.check-url', ['tenant' => $tenant->slug]) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ url: this.importUrlInput })
                });
                const data = await res.json();
                this.urlCheckResult = {
                    checked: true,
                    valid: data.valid ?? false,
                    preview_url: data.preview_url ?? null,
                    pesan: data.pesan ?? ''
                };
                if (data.judul_saran && !this.importJudul) {
                    this.importJudul = data.judul_saran;
                }
            } catch (e) {
                this.urlCheckResult = {
                    checked: true,
                    valid: false,
                    preview_url: null,
                    pesan: 'Gagal menghubungi server untuk verifikasi URL.'
                };
            } finally {
                this.isCheckingUrl = false;
            }
        },

        openRenameModal(media) {
            this.selectedMedia = Object.assign({}, media);
            this.updateUrl = "{{ url(app('tenant')->slug . '/admin/media') }}/" + media.id;
            this.editKategoriSelect = media.kategori || 'umum';
            this.editKategoriCustom = '';
            this.editIsCustomKategori = false;
            this.isRenameModalOpen = true;
        },

        openEditorModal(media) {
            this.selectedMedia = media;
            this.editorImageSrc = media.url;
            this.currentRotation = (media.crop_settings && media.crop_settings.rotate) ? media.crop_settings.rotate : 0;
            
            // Restore rasio jika tersimpan
            if (media.crop_settings && media.crop_settings.ratio && media.crop_settings.ratio !== 'bebas') {
                this.aspectRatio = parseFloat(media.crop_settings.ratio) || null;
            } else {
                this.aspectRatio = null;
            }

            this.editImageUrl = "{{ url(app('tenant')->slug . '/admin/media') }}/" + media.id + "/edit-image";
            this.isEditorModalOpen = true;
        },

        onImageLoaded() {
            this.$nextTick(() => {
                const img = document.getElementById('editorImagePreview');
                if (img) {
                    this.imgNaturalW = img.naturalWidth || 800;
                    this.imgNaturalH = img.naturalHeight || 600;
                    this.imgRenderW = img.clientWidth || 300;
                    this.imgRenderH = img.clientHeight || 200;

                    // Pulihkan posisi kotak crop sebelumnya jika ada
                    const cs = this.selectedMedia ? this.selectedMedia.crop_settings : null;
                    if (cs && cs.box_w && cs.box_h) {
                        this.cropBox = {
                            x: (cs.box_x / 100) * this.imgRenderW,
                            y: (cs.box_y / 100) * this.imgRenderH,
                            w: (cs.box_w / 100) * this.imgRenderW,
                            h: (cs.box_h / 100) * this.imgRenderH,
                        };
                    } else {
                        this.resetCropBox();
                    }
                }
            });
        },

        resetCropBox() {
            const img = document.getElementById('editorImagePreview');
            if (!img) return;
            const rw = img.clientWidth || 300;
            const rh = img.clientHeight || 200;
            this.imgRenderW = rw;
            this.imgRenderH = rh;

            let bw = rw * 0.8;
            let bh = rh * 0.8;

            if (this.aspectRatio) {
                if (bw / bh > this.aspectRatio) {
                    bw = bh * this.aspectRatio;
                } else {
                    bh = bw / this.aspectRatio;
                }
            }

            this.cropBox = {
                w: Math.max(40, Math.min(rw, bw)),
                h: Math.max(40, Math.min(rh, bh)),
                x: Math.max(0, (rw - bw) / 2),
                y: Math.max(0, (rh - bh) / 2),
            };
        },

        rotateImage(deg) {
            this.currentRotation = (this.currentRotation + deg) % 360;
        },

        setAspectRatio(ratio) {
            this.aspectRatio = ratio;
            this.resetCropBox();
        },

        startDrag(e) {
            this.isDragging = true;
            this.dragStartX = e.clientX;
            this.dragStartY = e.clientY;
            this.boxStartX = this.cropBox.x;
            this.boxStartY = this.cropBox.y;
        },

        startDragTouch(e) {
            if (e.touches && e.touches[0]) {
                this.isDragging = true;
                this.dragStartX = e.touches[0].clientX;
                this.dragStartY = e.touches[0].clientY;
                this.boxStartX = this.cropBox.x;
                this.boxStartY = this.cropBox.y;
            }
        },

        startResize(e, handle) {
            this.isResizing = true;
            this.resizeHandle = handle;
            this.dragStartX = e.clientX;
            this.dragStartY = e.clientY;
            this.boxStartX = this.cropBox.x;
            this.boxStartY = this.cropBox.y;
            this.boxStartW = this.cropBox.w;
            this.boxStartH = this.cropBox.h;
        },

        onMouseMove(e) {
            if (this.isDragging) {
                const dx = e.clientX - this.dragStartX;
                const dy = e.clientY - this.dragStartY;
                const maxX = Math.max(0, this.imgRenderW - this.cropBox.w);
                const maxY = Math.max(0, this.imgRenderH - this.cropBox.h);
                this.cropBox.x = Math.max(0, Math.min(maxX, this.boxStartX + dx));
                this.cropBox.y = Math.max(0, Math.min(maxY, this.boxStartY + dy));
            } else if (this.isResizing) {
                const dx = e.clientX - this.dragStartX;
                const dy = e.clientY - this.dragStartY;

                let newW = this.boxStartW;
                let newH = this.boxStartH;
                let newX = this.boxStartX;
                let newY = this.boxStartY;

                if (this.resizeHandle === 'br') {
                    newW = Math.max(30, Math.min(this.imgRenderW - newX, this.boxStartW + dx));
                    newH = this.aspectRatio ? newW / this.aspectRatio : Math.max(30, Math.min(this.imgRenderH - newY, this.boxStartH + dy));
                } else if (this.resizeHandle === 'bl') {
                    newW = Math.max(30, this.boxStartW - dx);
                    newX = this.boxStartX + (this.boxStartW - newW);
                    newH = this.aspectRatio ? newW / this.aspectRatio : Math.max(30, this.boxStartH + dy);
                } else if (this.resizeHandle === 'tr') {
                    newW = Math.max(30, this.boxStartW + dx);
                    newH = this.aspectRatio ? newW / this.aspectRatio : Math.max(30, this.boxStartH - dy);
                    newY = this.boxStartY + (this.boxStartH - newH);
                } else if (this.resizeHandle === 'tl') {
                    newW = Math.max(30, this.boxStartW - dx);
                    newX = this.boxStartX + (this.boxStartW - newW);
                    newH = this.aspectRatio ? newW / this.aspectRatio : Math.max(30, this.boxStartH - dy);
                    newY = this.boxStartY + (this.boxStartH - newH);
                }

                if (newX >= 0 && newY >= 0 && newX + newW <= this.imgRenderW && newY + newH <= this.imgRenderH) {
                    this.cropBox.w = newW;
                    this.cropBox.h = newH;
                    this.cropBox.x = newX;
                    this.cropBox.y = newY;
                }
            }
        },

        onTouchMove(e) {
            if (this.isDragging && e.touches && e.touches[0]) {
                const dx = e.touches[0].clientX - this.dragStartX;
                const dy = e.touches[0].clientY - this.dragStartY;
                const maxX = Math.max(0, this.imgRenderW - this.cropBox.w);
                const maxY = Math.max(0, this.imgRenderH - this.cropBox.h);
                this.cropBox.x = Math.max(0, Math.min(maxX, this.boxStartX + dx));
                this.cropBox.y = Math.max(0, Math.min(maxY, this.boxStartY + dy));
            }
        },

        onMouseUp() {
            this.isDragging = false;
            this.isResizing = false;
            this.resizeHandle = null;
        },

        async saveCropSettings() {
            if (!this.editImageUrl) return;
            this.handleSubmit('Menyimpan pengaturan crop...');
            
            try {
                // Hitung koordinat persentase kotak crop terhadap gambar
                const boxX = this.imgRenderW > 0 ? (this.cropBox.x / this.imgRenderW) * 100 : 0;
                const boxY = this.imgRenderH > 0 ? (this.cropBox.y / this.imgRenderH) * 100 : 0;
                const boxW = this.imgRenderW > 0 ? (this.cropBox.w / this.imgRenderW) * 100 : 100;
                const boxH = this.imgRenderH > 0 ? (this.cropBox.h / this.imgRenderH) * 100 : 100;

                // Hitung focal point tengah
                const centerX = this.cropBox.x + (this.cropBox.w / 2);
                const centerY = this.cropBox.y + (this.cropBox.h / 2);
                const focalX = this.imgRenderW > 0 ? (centerX / this.imgRenderW) * 100 : 50;
                const focalY = this.imgRenderH > 0 ? (centerY / this.imgRenderH) * 100 : 50;

                const payload = {
                    crop_x: this.cropDataPayload.x,
                    crop_y: this.cropDataPayload.y,
                    crop_w: this.cropDataPayload.w,
                    crop_h: this.cropDataPayload.h,
                    box_x: Math.min(100, Math.max(0, boxX)),
                    box_y: Math.min(100, Math.max(0, boxY)),
                    box_w: Math.min(100, Math.max(1, boxW)),
                    box_h: Math.min(100, Math.max(1, boxH)),
                    focal_x: Math.min(100, Math.max(0, focalX)),
                    focal_y: Math.min(100, Math.max(0, focalY)),
                    ratio: this.aspectRatio ? String(this.aspectRatio) : 'bebas',
                    rotate: this.currentRotation,
                };

                const res = await fetch(this.editImageUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const data = await res.json();
                if (data.sukses) {
                    this.isEditorModalOpen = false;
                    this.isSubmitting = false;
                    window.location.reload();
                } else {
                    alert(data.pesan || 'Gagal menyimpan pengaturan crop.');
                    this.isSubmitting = false;
                }
            } catch (err) {
                alert('Terjadi kesalahan koneksi saat menyimpan.');
                this.isSubmitting = false;
            }
        },

        // Custom Confirmation Modals
        confirmSingleDelete(id, judul) {
            this.deleteTargetType = 'single';
            this.deleteTargetId = id;
            this.confirmModalTitle = 'Hapus Berkas Permanen?';
            this.confirmModalMessage = `Apakah Anda yakin ingin menghapus berkas "${judul}" secara permanen? File fisik di server juga akan dihapus.`;
            this.isConfirmModalOpen = true;
        },

        openBulkDeleteModal() {
            if (this.selectedIds.length === 0) return;
            this.deleteTargetType = 'bulk';
            this.confirmModalTitle = `Hapus ${this.selectedIds.length} Berkas Sekaligus?`;
            this.confirmModalMessage = `Apakah Anda yakin ingin menghapus ${this.selectedIds.length} berkas yang dipilih secara permanen? Data dan file yang terhapus tidak dapat dikembalikan.`;
            this.isConfirmModalOpen = true;
        },

        executeConfirmedDelete() {
            this.handleSubmit('Sedang menghapus berkas...');
            if (this.deleteTargetType === 'single') {
                const form = document.getElementById('globalDeleteMediaForm');
                form.action = "{{ url(app('tenant')->slug . '/admin/media') }}/" + this.deleteTargetId;
                form.submit();
            } else {
                const form = document.getElementById('globalBulkDeleteMediaForm');
                document.getElementById('bulkDeleteIdsInput').value = this.selectedIds.join(',');
                form.submit();
            }
        }
    };
}
</script>
@endsection
