@extends('layouts.tenant_admin')

@section('title', 'Manajemen Galeri Foto & Video Sekolah')
@section('header_title', 'Galeri Foto & Video Sekolah')

@section('content')
<div class="max-w-7xl mx-auto space-y-6" 
     x-data="galeriManager({
         activeTab: @js(request('tab', 'album')),
         selectedAlbumId: @js($selectedAlbum->id ?? null),
         toastMsg: @js(session('success') ?? session('error') ?? ''),
         isError: @js(session()->has('error')),
         bannerHeroPreview: @js(old('gambar_banner', $halamanGaleri->gambar_banner ?? '')),
         isFiturAktif: @js((bool) $isFiturAktif),
         routes: {
             mediaIndex: @js(route('tenant.admin.media.index', ['tenant' => app('tenant')->slug])),
             mediaUpload: @js(route('tenant.admin.media.upload', ['tenant' => app('tenant')->slug])),
             mediaImportUrl: @js(route('tenant.admin.media.import-url', ['tenant' => app('tenant')->slug])),
             toggleStatus: @js(route('tenant.admin.informasi.toggle-status', ['tenant' => app('tenant')->slug])),
             storeAlbum: @js(route('tenant.admin.informasi.galeri.album.store', ['tenant' => app('tenant')->slug]))
         }
     })"
     x-init="init()">

    <!-- Toast Notification -->
    <div x-show="showToast" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         style="display: none;"
         :class="isToastError ? 'bg-rose-600' : 'bg-emerald-600'"
         class="fixed bottom-5 right-5 z-50 text-white px-5 py-3.5 rounded-2xl shadow-xl flex items-center gap-3 max-w-md">
        <svg class="w-5 h-5 shrink-0 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-xs sm:text-sm font-medium" x-text="toastText"></span>
        <button @click="showToast = false" class="text-white/80 hover:text-white p-1 ml-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    @if($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl text-xs space-y-1">
        <div class="font-bold flex items-center gap-1.5 text-rose-900">
            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            Terdapat beberapa kesalahan pengisian form:
        </div>
        <ul class="list-disc list-inside pl-1 text-rose-700">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Sticky Tab Navigation & Top Action Bar -->
    <div class="admin-sticky-bar">
        <div class="admin-sticky-container">
            <!-- Tab Pills -->
            <div class="admin-tab-nav">
                <button type="button" @click="activeTab = 'album'"
                        :class="activeTab === 'album' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    1. Daftar Album
                </button>

                @if($selectedAlbum)
                <button type="button" @click="activeTab = 'items'"
                        :class="activeTab === 'items' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Isi Media: {{ Str::limit($selectedAlbum->nama_album, 18) }}</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[10px] bg-white/20 text-white font-bold">{{ $selectedAlbum->items->count() }}</span>
                </button>
                @endif

                <button type="button" @click="activeTab = 'form'"
                        :class="activeTab === 'form' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span x-text="editMode ? 'Edit: ' + (formNamaAlbum ? formNamaAlbum.substring(0,18) + '...' : 'Album') : '2. Buat Album Baru'"></span>
                </button>
            </div>

            <!-- Sticky Right Actions -->
            <div class="flex items-center gap-2 shrink-0">
                <template x-if="activeTab === 'album'">
                    <div class="flex items-center gap-2">
                        <button type="button" @click="tambahAlbumBaru()" 
                                class="admin-btn-create">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Buat Album</span>
                        </button>
                        <button type="button" @click="submitActiveForm('form-galeri-hero')" :disabled="submitLoading"
                                class="admin-btn-save bg-slate-800 hover:bg-slate-900">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Hero'"></span>
                        </button>
                    </div>
                </template>

                <template x-if="activeTab === 'form'">
                    <div class="flex items-center gap-2">
                        <template x-if="editMode">
                            <button type="button" @click="tambahAlbumBaru()" 
                                    class="px-3 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold rounded-xl transition flex items-center gap-1 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>[+] Album Baru</span>
                            </button>
                        </template>
                        <button type="button" @click="activeTab = 'album'" 
                                class="admin-btn-cancel text-xs">
                            Batal
                        </button>
                        <button type="button" @click="submitActiveForm('form-galeri-album')" :disabled="submitLoading"
                                class="admin-btn-save">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="submitLoading ? 'Menyimpan...' : (editMode ? 'Simpan Album' : 'Buat Album')"></span>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         TAB 1: DAFTAR ALBUM GALERI & HERO BANNER
    ========================================================================== -->
    <div x-show="activeTab === 'album'" x-cloak class="space-y-6">
        <!-- Pengaturan Hero Banner Galeri Publik -->
        <form id="form-galeri-hero" action="{{ route('tenant.admin.informasi.hero', ['tenant' => app('tenant')->slug, 'modul' => 'galeri']) }}" method="POST" @submit="submitLoading = true">
            @csrf
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
                <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Kustomisasi Hero Banner Halaman Galeri
                        </h2>
                        <p class="text-xs text-slate-500">Atur judul pengantar, subjudul motivasional, dan gambar latar artistik pada bagian atas halaman galeri dokumentasi.</p>
                    </div>
                    <a href="{{ url(app('tenant')->slug . '/galeri') }}" target="_blank" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 shrink-0">
                        <span>Lihat Galeri Publik</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Judul Utama Hero Banner <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul', $halamanGaleri->judul) }}" required 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Subjudul / Narasi Hero Banner
                        </label>
                        <textarea name="subjudul" rows="2" 
                                  class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">{{ old('subjudul', $halamanGaleri->subjudul) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Gambar Banner Latar (Pusat Media / URL)
                        </label>
                        <div class="flex gap-2 items-center">
                            <div class="w-16 h-10 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 relative flex items-center justify-center">
                                <template x-if="bannerHeroPreview">
                                    <img :src="bannerHeroPreview" alt="Hero Banner Preview" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!bannerHeroPreview">
                                    <span class="text-[9px] text-slate-500 font-mono">16:9</span>
                                </template>
                            </div>
                            <input type="text" 
                                   name="gambar_banner" 
                                   id="input_banner_hero_galeri"
                                   x-model="bannerHeroPreview" 
                                   placeholder="https://... atau pilih dari Pusat Media" 
                                   class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                            <button type="button" 
                                    @click="bukaMediaPicker('banner_hero')" 
                                    class="px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Pilih Media
                            </button>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">Resolusi minimal 1600x600px rasio lebar untuk tampilan tajam di layar desktop &amp; mobile.</p>
                    </div>
                </div>
            </div>
        </form>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Galeri Dokumentasi Foto &amp; Video Sekolah
                    </h2>
                    <p class="text-xs text-slate-500">Kelola album dokumentasi kegiatan, liputan karya kejuruan, dan rekaman video resmi.</p>
                </div>
                <div class="flex items-center gap-2 self-start sm:self-auto">
                    <a href="{{ url(app('tenant')->slug . '/galeri') }}" target="_blank" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Lihat Galeri Publik
                    </a>
                    <button type="button" @click="tambahAlbumBaru()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Buat Album Baru
                    </button>
                </div>
            </div>

            <!-- Search & Filter Bar with View Mode Toggle -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-1">
                <form action="{{ route('tenant.admin.informasi.galeri', ['tenant' => app('tenant')->slug]) }}" method="GET" class="flex-1 flex flex-col sm:flex-row items-center gap-3 w-full">
                    <input type="hidden" name="tab" value="album">
                    <div class="relative flex-1 w-full">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama album atau deskripsi..." 
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>
                    <div class="w-full sm:w-48">
                        <select name="tipe" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                            <option value="">Semua Tipe Album</option>
                            <option value="foto" {{ request('tipe') === 'foto' ? 'selected' : '' }}>Foto Dokumentasi</option>
                            <option value="video" {{ request('tipe') === 'video' ? 'selected' : '' }}>Video Kegiatan</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button type="submit" class="w-full sm:w-auto px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer">
                            Cari
                        </button>
                        @if(request()->filled('q') || request()->filled('tipe'))
                            <a href="{{ route('tenant.admin.informasi.galeri', ['tenant' => app('tenant')->slug, 'tab' => 'album']) }}" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Switcher Toggle Grid vs List -->
                <div class="flex items-center p-0.5 bg-slate-100 rounded-xl border border-slate-200 shrink-0 self-end sm:self-center">
                    <button 
                        type="button" 
                        @click="viewMode = 'grid'" 
                        :class="viewMode === 'grid' ? 'bg-white text-slate-900 font-bold shadow-2xs' : 'text-slate-500 hover:text-slate-800'"
                        class="px-3 py-1.5 rounded-lg text-xs transition cursor-pointer flex items-center gap-1.5"
                        title="Tampilan Grid / Galeri">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span class="text-xs font-semibold">Grid</span>
                    </button>
                    <button 
                        type="button" 
                        @click="viewMode = 'list'" 
                        :class="viewMode === 'list' ? 'bg-white text-slate-900 font-bold shadow-2xs' : 'text-slate-500 hover:text-slate-800'"
                        class="px-3 py-1.5 rounded-lg text-xs transition cursor-pointer flex items-center gap-1.5"
                        title="Tampilan Tabel / Daftar">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <span class="text-xs font-semibold">Tabel</span>
                    </button>
                </div>
            </div>

            <!-- TAMPILAN 1: Album Grid Cards (Sama Persis dengan Manajemen Media) -->
            <div x-show="viewMode === 'grid'" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 pt-2">
                @forelse($albumList as $alb)
                <div class="group bg-white rounded-xl border border-slate-200/80 overflow-hidden shadow-2xs hover:shadow-md transition-all flex flex-col justify-between relative">
                    <!-- Badge Media Count & Tipe -->
                    <div class="absolute top-2 right-2 z-30 pointer-events-auto">
                        <span class="px-2 py-0.5 text-[9px] font-bold rounded-md shadow-xs {{ $alb->tipe === 'video' ? 'bg-rose-600 text-white' : 'bg-blue-600 text-white' }}">
                            {{ $alb->items_count }} {{ $alb->tipe === 'video' ? 'Vid' : 'Foto' }}
                        </span>
                    </div>

                    <!-- Cover Preview Box -->
                    <div class="relative bg-slate-900 aspect-square overflow-hidden flex items-center justify-center">
                        @if($alb->cover_album)
                            <!-- Ambient Blurred Backdrop -->
                            <img src="{{ $alb->cover_album }}" alt="" aria-hidden="true" class="absolute inset-0 w-full h-full object-cover blur-md scale-125 opacity-40 pointer-events-none z-0">
                            <!-- Main Cover Image -->
                            <img src="{{ $alb->cover_album }}" alt="{{ $alb->nama_album }}" loading="lazy" class="relative z-10 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                                <svg class="w-8 h-8 text-slate-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-[9px]">Tanpa Cover</span>
                            </div>
                        @endif

                        <span class="absolute bottom-2 left-2 z-20 px-1.5 py-0.5 bg-black/70 backdrop-blur-xs text-white text-[9px] font-bold rounded uppercase">
                            {{ $alb->tipe }}
                        </span>

                        <!-- Hover Overlay Action Bar -->
                        <div class="absolute inset-0 z-40 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-1.5 p-2">
                            <a href="{{ route('tenant.admin.informasi.galeri', ['tenant' => app('tenant')->slug, 'tab' => 'items', 'album_id' => $alb->id]) }}" 
                               class="p-2 bg-white text-blue-600 rounded-xl hover:bg-blue-50 shadow-xs text-xs font-semibold cursor-pointer transition" 
                               title="Kelola Media">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </a>
                            <button type="button" 
                                    @click="editAlbumItem(@js($alb))" 
                                    class="p-2 bg-white text-amber-600 rounded-xl hover:bg-amber-50 shadow-xs text-xs font-semibold cursor-pointer transition" 
                                    title="Edit Album">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button type="button" 
                                    @click="konfirmasiHapusAlbum(@js($alb->id), @js($alb->nama_album), @js($alb->items_count))" 
                                    class="p-2 bg-white text-rose-600 rounded-xl hover:bg-rose-50 shadow-xs text-xs font-semibold cursor-pointer transition" 
                                    title="Hapus Album">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Meta Details -->
                    <div class="p-2.5">
                        <div class="font-bold text-slate-900 text-xs truncate" title="{{ $alb->nama_album }}">{{ $alb->nama_album }}</div>
                        <div class="flex items-center justify-between text-[10px] text-slate-400 mt-1">
                            <span class="truncate capitalize font-semibold {{ $alb->tipe === 'video' ? 'text-rose-600' : 'text-blue-600' }}">{{ $alb->tipe }}</span>
                            <span>{{ $alb->items_count }} Media</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-10 text-center text-slate-400 bg-slate-50/50 rounded-2xl border border-slate-200">
                    <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <p class="text-xs font-semibold text-slate-600">Belum ada album galeri foto atau video.</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">Klik tombol "Buat Album Baru" untuk membuat koleksi dokumentasi pertama.</p>
                </div>
                @endforelse
            </div>

            <!-- TAMPILAN 2: Table / List View -->
            <div x-show="viewMode === 'list'" x-cloak class="overflow-x-auto border border-slate-200 rounded-xl">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-3 w-12 text-center">No</th>
                            <th class="py-3 px-4 w-16 text-center">Cover</th>
                            <th class="py-3 px-4">Nama Album &amp; Deskripsi</th>
                            <th class="py-3 px-4 text-center">Tipe</th>
                            <th class="py-3 px-4 text-center">Jumlah Media</th>
                            <th class="py-3 px-4 text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($albumList as $idx => $alb)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-2.5 px-3 text-center text-slate-400 font-medium">
                                {{ $idx + 1 }}
                            </td>
                            <td class="py-2.5 px-4 text-center">
                                <div class="w-12 h-12 rounded-lg bg-slate-900 overflow-hidden relative mx-auto flex items-center justify-center border border-slate-200">
                                    @if($alb->cover_album)
                                        <img src="{{ $alb->cover_album }}" alt="{{ $alb->nama_album }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    @endif
                                </div>
                            </td>
                            <td class="py-2.5 px-4">
                                <div class="font-bold text-slate-900 text-xs hover:text-blue-600">
                                    <a href="{{ route('tenant.admin.informasi.galeri', ['tenant' => app('tenant')->slug, 'tab' => 'items', 'album_id' => $alb->id]) }}">
                                        {{ $alb->nama_album }}
                                    </a>
                                </div>
                                <div class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ $alb->deskripsi ?? 'Tidak ada deskripsi' }}</div>
                            </td>
                            <td class="py-2.5 px-4 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold capitalize {{ $alb->tipe === 'video' ? 'bg-rose-100 text-rose-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $alb->tipe }}
                                </span>
                            </td>
                            <td class="py-2.5 px-4 text-center font-semibold text-slate-700">
                                {{ $alb->items_count }} Item
                            </td>
                            <td class="py-2.5 px-4 text-center">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <a href="{{ route('tenant.admin.informasi.galeri', ['tenant' => app('tenant')->slug, 'tab' => 'items', 'album_id' => $alb->id]) }}" 
                                       class="p-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-blue-600 transition" 
                                       title="Kelola Media">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </a>
                                    <button type="button" 
                                            @click="editAlbumItem(@js($alb))" 
                                            class="p-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-amber-600 transition cursor-pointer" 
                                            title="Edit Album">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    <button type="button" 
                                            @click="konfirmasiHapusAlbum(@js($alb->id), @js($alb->nama_album), @js($alb->items_count))" 
                                            class="p-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-600 transition cursor-pointer" 
                                            title="Hapus Album">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 italic">
                                Belum ada album yang ditambahkan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($albumList->hasPages())
                <div class="pt-2">
                    {{ $albumList->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- =========================================================================
         TAB 2: ISI MEDIA DALAM ALBUM YANG DIPILIH
    ========================================================================== -->
    @if($selectedAlbum)
    <div x-show="activeTab === 'items'" x-cloak class="space-y-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase {{ $selectedAlbum->tipe === 'video' ? 'bg-rose-100 text-rose-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $selectedAlbum->tipe === 'video' ? 'Album Video' : 'Album Foto' }}
                        </span>
                        <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">{{ $selectedAlbum->nama_album }}</h2>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $selectedAlbum->deskripsi ?? 'Kelola berkas foto atau tautan video kegiatan yang masuk ke dalam album ini.' }}</p>
                </div>

                <div class="flex items-center gap-2 self-start sm:self-auto">
                    <button type="button" @click="activeTab = 'album'" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition cursor-pointer">
                        &larr; Pilih Album Lain
                    </button>
                </div>
            </div>

            <!-- Add Media Form -->
            <form action="{{ route('tenant.admin.informasi.galeri.item.store', ['tenant' => app('tenant')->slug, 'album' => $selectedAlbum->id]) }}" method="POST" class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-3">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                    <div class="sm:col-span-5">
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            URL Berkas Foto / Link YouTube <span class="text-rose-500">*</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="text" 
                                   name="file_media_atau_link" 
                                   id="input_file_item_galeri"
                                   x-model="formItemUrl" 
                                   required 
                                   placeholder="https://... atau pilih media" 
                                   class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-hidden focus:border-blue-500 transition">
                            <button type="button" 
                                    @click="bukaMediaPicker('item_galeri')" 
                                    class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1 cursor-pointer" title="Pilih dari Media Library">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Media
                            </button>
                        </div>
                    </div>

                    <div class="sm:col-span-5">
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Judul / Keterangan Media
                        </label>
                        <input type="text" 
                               name="judul_item" 
                               placeholder="Contoh: Suasana Praktik Siswa Mesin CNC" 
                               class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-hidden focus:border-blue-500 transition">
                    </div>

                    <div class="sm:col-span-2 flex items-end">
                        <button type="submit" class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center cursor-pointer">
                            Tambahkan
                        </button>
                    </div>
                </div>
            </form>

            <!-- Items Grid in Selected Album (Identik dengan Manajemen Media) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 pt-2">
                @forelse($selectedAlbum->items as $item)
                @php
                    $itemSrc = $item->file_media_atau_link ?? $item->file_path ?? '';
                    $isVideoItem = Str::contains($itemSrc, ['youtube.com', 'youtu.be', '.mp4', '.webm', '.mov']) || $selectedAlbum->tipe === 'video';
                @endphp
                <div class="group bg-white rounded-xl border border-slate-200/80 overflow-hidden shadow-2xs hover:shadow-md transition-all flex flex-col justify-between relative">
                    <div class="relative bg-slate-900 aspect-square overflow-hidden flex items-center justify-center">
                        @if($isVideoItem)
                            <div class="w-full h-full bg-slate-900 flex flex-col items-center justify-center text-white p-2 text-center">
                                <svg class="w-8 h-8 text-rose-500 mb-1" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                <span class="text-[9px] font-bold truncate max-w-full text-slate-300">{{ Str::limit($item->judul_item ?? $itemSrc, 16) }}</span>
                            </div>
                        @else
                            <!-- Ambient Blurred Backdrop -->
                            <img src="{{ $itemSrc }}" alt="" aria-hidden="true" class="absolute inset-0 w-full h-full object-cover blur-md scale-125 opacity-40 pointer-events-none z-0">
                            <!-- Main Item Image -->
                            <img src="{{ $itemSrc }}" alt="{{ $item->judul_item }}" loading="lazy" class="relative z-10 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @endif

                        <span class="absolute bottom-2 left-2 z-20 px-1.5 py-0.5 bg-black/70 backdrop-blur-xs text-white text-[9px] font-bold rounded uppercase">
                            {{ $isVideoItem ? 'video' : 'foto' }}
                        </span>

                        <!-- Hover Overlay Action Bar -->
                        <div class="absolute inset-0 z-40 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-1.5 p-2">
                            <a href="{{ $itemSrc }}" target="_blank" class="p-2 bg-white text-blue-600 rounded-xl hover:bg-blue-50 shadow-xs text-xs font-semibold transition" title="Lihat Asli">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            <form action="{{ route('tenant.admin.informasi.galeri.item.destroy', ['tenant' => app('tenant')->slug, 'item' => $item->id]) }}" method="POST" onsubmit="return confirm('Hapus media ini dari album?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-white text-rose-600 rounded-xl hover:bg-rose-50 shadow-xs text-xs font-semibold cursor-pointer transition" title="Hapus Media">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="p-2.5">
                        <div class="font-bold text-slate-900 text-xs truncate" title="{{ $item->judul_item ?? 'Foto Dokumentasi' }}">{{ $item->judul_item ?: 'Foto Dokumentasi' }}</div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-8 text-center text-slate-400 bg-slate-50 rounded-2xl border border-slate-200">
                    <p class="text-xs font-medium">Belum ada foto atau video di album ini. Gunakan formulir di atas untuk mengunggah berkas.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    @endif

    <!-- =========================================================================
         TAB 3: FORM BUAT / EDIT ALBUM
    ========================================================================== -->
    <div x-show="activeTab === 'form'" x-cloak class="space-y-6">
        <form id="form-galeri-album" :action="formAlbumActionUrl" method="POST" @submit="submitLoading = true">
            @csrf
            <template x-if="editMode">
                <input type="hidden" name="_method" value="PUT">
            </template>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4 max-w-3xl">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            <span x-text="editMode ? 'Edit Rincian Album Galeri' : 'Formulir Buat Album Galeri Baru'"></span>
                        </h2>
                        <p class="text-xs text-slate-500">Tentukan nama album dokumentasi, tipe media (foto atau video), dan gambar sampul utama.</p>
                    </div>
                    <button type="button" @click="activeTab = 'album'" class="text-xs font-semibold text-slate-500 hover:text-slate-800">
                        &larr; Batal &amp; Kembali
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Nama Album Galeri <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               name="nama_album" 
                               x-model="formNamaAlbum" 
                               required 
                               placeholder="Contoh: Gelar Karya & Pameran Teaching Factory 2026" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Tipe Konten Album <span class="text-rose-500">*</span>
                        </label>
                        <select name="tipe" 
                                x-model="formTipeAlbum" 
                                required 
                                class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                            <option value="foto">Foto Dokumentasi Kegiatan</option>
                            <option value="video">Video Liputan &amp; Rekaman</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Deskripsi Singkat Album
                        </label>
                        <textarea name="deskripsi" 
                                  x-model="formDeskripsiAlbum" 
                                  rows="3" 
                                  placeholder="Rincian singkat seputar kegiatan yang didokumentasikan..." 
                                  class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Gambar Sampul (Cover Album)
                        </label>
                        <div class="aspect-16/8 rounded-xl overflow-hidden bg-slate-50 border border-slate-200 mb-2 relative flex items-center justify-center">
                            <template x-if="formCoverAlbum">
                                <img :src="formCoverAlbum" alt="Cover Preview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!formCoverAlbum">
                                <span class="text-xs text-slate-400">Belum ada cover album</span>
                            </template>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="text" 
                                   name="cover_album" 
                                   id="input_cover_album" 
                                   x-model="formCoverAlbum" 
                                   placeholder="https://... atau pilih media" 
                                   class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                            <button type="button" 
                                    @click="bukaMediaPicker('cover_album')" 
                                    class="px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Pilih Media
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>



    <!-- MODAL KONFIRMASI HAPUS ALBUM -->
    <div x-show="modalHapus" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-5 space-y-4 border border-slate-200"
             @click.outside="modalHapus = false">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-slate-900 font-heading">Hapus Album Beserta Isinya?</h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Anda akan menghapus album <strong class="text-slate-800" x-text="hapusNama"></strong> (<span class="font-bold text-rose-600" x-text="hapusCount + ' media'"></span>). Aksi ini permanen.
                    </p>
                </div>
            </div>

            <form :action="hapusActionUrl" method="POST" class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                @csrf
                @method('DELETE')
                <button type="button" @click="modalHapus = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- Reusable Media Picker Component -->
    @include('tenant.admin.media.picker-modal')

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('galeriManager', (config) => ({
        activeTab: config.activeTab,
        selectedAlbumId: config.selectedAlbumId,
        viewMode: 'grid',
        showToast: false,
        toastText: config.toastMsg,
        isToastError: config.isError,
        bannerHeroPreview: config.bannerHeroPreview,
        isFiturAktif: config.isFiturAktif,
        isToggling: false,
        submitLoading: false,

        submitActiveForm(formId) {
            const form = document.getElementById(formId);
            if (!form) return;

            if (form.reportValidity && !form.reportValidity()) {
                return;
            }

            this.submitLoading = true;
            if (form.requestSubmit) {
                form.requestSubmit();
            } else {
                form.submit();
            }
        },

        // Modal hapus
        modalHapus: false,
        hapusNama: '',
        hapusCount: 0,
        hapusActionUrl: '',

        // Form Album State
        editMode: false,
        formAlbumActionUrl: (config.routes && config.routes.storeAlbum) ? config.routes.storeAlbum : '',
        formNamaAlbum: '',
        formTipeAlbum: 'foto',
        formDeskripsiAlbum: '',
        formCoverAlbum: '',

        // Item Form
        formItemUrl: '',

        targetMediaField: null,

        init() {
            if (this.toastText) {
                this.showToast = true;
                setTimeout(() => { this.showToast = false; }, 4000);
            }
        },

        tambahAlbumBaru() {
            this.editMode = false;
            this.formAlbumActionUrl = (config.routes && config.routes.storeAlbum) ? config.routes.storeAlbum : '';
            this.formNamaAlbum = '';
            this.formTipeAlbum = 'foto';
            this.formDeskripsiAlbum = '';
            this.formCoverAlbum = '';
            this.activeTab = 'form';
        },

        editAlbumItem(album) {
            this.editMode = true;
            const baseUrl = (config.routes && config.routes.storeAlbum) ? config.routes.storeAlbum : '';
            this.formAlbumActionUrl = `${baseUrl}/${album.id}`;
            this.formNamaAlbum = album.nama_album;
            this.formTipeAlbum = album.tipe || 'foto';
            this.formDeskripsiAlbum = album.deskripsi || '';
            this.formCoverAlbum = album.cover_album || '';
            this.activeTab = 'form';
        },

        konfirmasiHapusAlbum(id, nama, count) {
            this.hapusNama = nama;
            this.hapusCount = count;
            const baseUrl = (config.routes && config.routes.storeAlbum) ? config.routes.storeAlbum : '';
            this.hapusActionUrl = `${baseUrl}/${id}`;
            this.modalHapus = true;
        },

        bukaMediaPicker(targetField) {
            this.targetMediaField = targetField;
            window.dispatchEvent(new CustomEvent('open-media-picker', {
                detail: {
                    onSelect: (mediaItem) => {
                        const fileUrl = mediaItem.url || mediaItem.file_url || mediaItem.file_path;
                        if (this.targetMediaField === 'cover_album') {
                            this.formCoverAlbum = fileUrl;
                        } else if (this.targetMediaField === 'banner_hero') {
                            this.bannerHeroPreview = fileUrl;
                        } else if (this.targetMediaField === 'item_galeri') {
                            this.formItemUrl = fileUrl;
                        }
                    }
                }
            }));
        },

        async toggleStatusFitur(fitur) {
            this.isToggling = true;
            try {
                const response = await fetch(config.routes.toggleStatus, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ fitur: fitur })
                });
                const res = await response.json();
                if (res.success) {
                    this.isFiturAktif = res.is_aktif;
                    this.toastText = res.message;
                    this.isToastError = false;
                    this.showToast = true;
                    setTimeout(() => { this.showToast = false; }, 3500);
                }
            } catch (e) {
                this.toastText = 'Gagal mengubah status menu.';
                this.isToastError = true;
                this.showToast = true;
            } finally {
                this.isToggling = false;
            }
        }
    }));
});
</script>
@endpush
