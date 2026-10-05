@extends('layouts.tenant_admin')

@section('title', 'Manajemen Sarana & Fasilitas Sekolah')
@section('header_title', 'Sarana & Fasilitas Sekolah')

@section('content')
<div class="max-w-7xl mx-auto space-y-6" 
     x-data="fasilitasManager({
         activeTab: @js(request('tab', 'fasilitas')),
         toastMsg: @js(session('success') ?? session('error') ?? ''),
         isError: @js(session()->has('error')),
         bannerHeroPreview: @js(old('gambar_banner', $halamanFasilitas->gambar_banner ?? '')),
         isFiturAktif: @js((bool) $isFiturAktif),
         routes: {
             mediaIndex: @js(route('tenant.admin.media.index', ['tenant' => app('tenant')->slug])),
             mediaUpload: @js(route('tenant.admin.media.upload', ['tenant' => app('tenant')->slug])),
             mediaImportUrl: @js(route('tenant.admin.media.import-url', ['tenant' => app('tenant')->slug])),
             toggleStatus: @js(route('tenant.admin.informasi.toggle-status', ['tenant' => app('tenant')->slug]))
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

    <!-- Tab Navigation Pills -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 border-b border-slate-200 taildash-scrollbar text-xs font-semibold">
        <button type="button" @click="activeTab = 'fasilitas'"
                :class="activeTab === 'fasilitas' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 shrink-0 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            1. Daftar Sarana &amp; Fasilitas
        </button>

        <button type="button" @click="activeTab = 'form'"
                :class="activeTab === 'form' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 shrink-0 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span x-text="editMode ? 'Edit Fasilitas: ' + formNamaFasilitas.substring(0,25) + '...' : 'Tambah Fasilitas Baru'"></span>
        </button>

        <button type="button" @click="activeTab = 'stats'"
                :class="activeTab === 'stats' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 shrink-0 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            3. Statistik Cepat Sarpras
        </button>

        <button type="button" @click="activeTab = 'visibilitas'"
                :class="activeTab === 'visibilitas' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 shrink-0 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            4. Visibilitas Menu &amp; Rute
        </button>
    </div>

    <!-- =========================================================================
         TAB 1: DAFTAR SARANA & FASILITAS & HERO BANNER
    ========================================================================== -->
    <div x-show="activeTab === 'fasilitas'" x-cloak class="space-y-6">
        <!-- Pengaturan Hero Banner Fasilitas Publik -->
        <form action="{{ route('tenant.admin.informasi.hero', ['tenant' => app('tenant')->slug, 'modul' => 'fasilitas']) }}" method="POST">
            @csrf
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
                <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Kustomisasi Hero Banner Halaman Fasilitas
                        </h2>
                        <p class="text-xs text-slate-500">Atur judul pengantar, subjudul motivasional, dan gambar latar artistik pada bagian atas halaman sarana prasarana publik.</p>
                    </div>
                    <a href="{{ url(app('tenant')->slug . '/fasilitas') }}" target="_blank" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 shrink-0">
                        <span>Lihat Sarpras Publik</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Judul Utama Hero Banner <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul', $halamanFasilitas->judul) }}" required 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Subjudul / Narasi Hero Banner
                        </label>
                        <textarea name="subjudul" rows="2" 
                                  class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">{{ old('subjudul', $halamanFasilitas->subjudul) }}</textarea>
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
                                   id="input_banner_hero_fasilitas"
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

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center gap-2 cursor-pointer">
                        Simpan Perubahan Banner Hero
                    </button>
                </div>
            </div>
        </form>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Sarana &amp; Fasilitas Pembelajaran Sekolah
                    </h2>
                    <p class="text-xs text-slate-500">Kelola katalog bengkel kejuruan, laboratorium komputer, studio multimedia, sarana olahraga, dan sarpras.</p>
                </div>
                <div class="flex items-center gap-2 self-start sm:self-auto">
                    <a href="{{ url(app('tenant')->slug . '/fasilitas') }}" target="_blank" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Lihat Sarpras Publik
                    </a>
                    <button type="button" @click="tambahFasilitasBaru()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Fasilitas Baru
                    </button>
                </div>
            </div>

            <!-- Search & Filter Bar -->
            <form action="{{ route('tenant.admin.informasi.fasilitas', ['tenant' => app('tenant')->slug]) }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 pt-1">
                <input type="hidden" name="tab" value="fasilitas">
                <div class="relative flex-1 w-full">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama fasilitas, bengkel, atau laboratorium..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer">
                        Cari
                    </button>
                    @if(request()->filled('q'))
                        <a href="{{ route('tenant.admin.informasi.fasilitas', ['tenant' => app('tenant')->slug, 'tab' => 'fasilitas']) }}" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <!-- Facilities Grid Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pt-2">
                @forelse($fasilitasList as $f)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-xs hover:shadow-md transition overflow-hidden flex flex-col group">
                    <!-- Foto Utama 4:3 -->
                    <div class="aspect-4/3 bg-slate-100 relative overflow-hidden">
                        <img src="{{ $f->foto_utama ?? 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=800&auto=format&fit=crop' }}" 
                             alt="{{ $f->nama_fasilitas }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold backdrop-blur-md {{ $f->is_aktif ? 'bg-emerald-900/80 text-emerald-200 border border-emerald-700/50' : 'bg-slate-900/80 text-slate-300' }}">
                                {{ $f->is_aktif ? 'Aktif' : 'Draft' }}
                            </span>
                        </div>

                        @if($f->fotoLainnya && $f->fotoLainnya->count() > 0)
                            <div class="absolute bottom-3 left-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold bg-slate-900/80 text-white backdrop-blur-md">
                                    +{{ $f->fotoLainnya->count() }} Foto Tambahan
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Body Info -->
                    <div class="p-4 sm:p-5 flex-1 flex flex-col">
                        <h3 class="font-bold text-slate-900 font-heading text-xs sm:text-sm mb-1 group-hover:text-blue-600 transition">
                            {{ $f->nama_fasilitas }}
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed mb-4 flex-1">
                            {{ $f->deskripsi }}
                        </p>

                        <!-- Foto Tambahan Mini Preview -->
                        @if($f->fotoLainnya && $f->fotoLainnya->count() > 0)
                            <div class="flex items-center space-x-1.5 mb-4 overflow-x-auto pb-1">
                                @foreach($f->fotoLainnya->take(4) as $ft)
                                    <div class="w-8 h-8 rounded-md overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                        <img src="{{ $ft->file_foto }}" alt="Foto" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Action Bar -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] text-slate-400 font-medium">Sarpras SMK</span>
                            <div class="flex items-center space-x-1.5">
                                <button type="button" 
                                        @click="editFasilitasItem(@js($f))" 
                                        class="p-1.5 rounded-lg text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition cursor-pointer" 
                                        title="Edit Fasilitas">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button type="button" 
                                        @click="konfirmasiHapusFasilitas(@js($f->id), @js($f->nama_fasilitas))" 
                                        class="p-1.5 rounded-lg text-slate-600 hover:bg-rose-50 hover:text-rose-600 transition cursor-pointer" 
                                        title="Hapus Fasilitas">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-10 text-center text-slate-400 bg-slate-50/50 rounded-2xl border border-slate-200">
                    <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <p class="text-xs font-semibold text-slate-600">Belum ada data fasilitas atau sarana prasarana.</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">Klik tombol "Tambah Fasilitas Baru" untuk mendaftarkan ruangan atau laboratorium pertama.</p>
                </div>
                @endforelse
            </div>

            @if($fasilitasList->hasPages())
                <div class="pt-2">
                    {{ $fasilitasList->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- =========================================================================
         TAB 2: FORM TAMBAH / EDIT FASILITAS
    ========================================================================== -->
    <div x-show="activeTab === 'form'" x-cloak class="space-y-6">
        <form :action="formFasilitasActionUrl" method="POST">
            @csrf
            <template x-if="editMode">
                <input type="hidden" name="_method" value="PUT">
            </template>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Left: Info Utama (7 cols) -->
                <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <div>
                            <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                <span x-text="editMode ? 'Edit Data Fasilitas' : 'Formulir Sarana & Fasilitas Baru'"></span>
                            </h2>
                            <p class="text-xs text-slate-500">Lengkapi nama ruangan, deskripsi sarana, foto utama, dan dokumentasi foto tambahan.</p>
                        </div>
                        <button type="button" @click="activeTab = 'fasilitas'" class="text-xs font-semibold text-slate-500 hover:text-slate-800">
                            &larr; Batal &amp; Kembali
                        </button>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Nama Fasilitas / Bengkel / Laboratorium <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               name="nama_fasilitas" 
                               x-model="formNamaFasilitas" 
                               required 
                               placeholder="Contoh: Bengkel Permesinan CNC & Bubut Industri" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Deskripsi &amp; Spesifikasi Fasilitas <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="deskripsi" 
                                  x-model="formDeskripsiFasilitas" 
                                  rows="5" 
                                  required 
                                  placeholder="Jelaskan fasilitas, kapasitas siswa, peralatan modern teaching factory yang tersedia, dan fungsinya..." 
                                  class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"></textarea>
                    </div>

                    <!-- Galeri Foto Tambahan Repeater -->
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-3">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-xs font-bold text-slate-800">Foto Dokumentasi Tambahan</h4>
                                <p class="text-[10px] text-slate-400">Tambahkan foto sudut lain ruangan atau aktivitas praktik siswa.</p>
                            </div>
                            <button type="button" @click="tambahBarisFotoTambahan()" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Tambah Foto
                            </button>
                        </div>

                        <!-- List Foto Tambahan Existing saat Edit -->
                        <template x-if="editMode && existingFotoList.length > 0">
                            <div class="space-y-2 pt-2 border-t border-slate-200">
                                <span class="text-[11px] font-bold text-slate-600 block">Foto Tambahan Terpasang:</span>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    <template x-for="item in existingFotoList" :key="item.id">
                                        <div class="relative group rounded-xl overflow-hidden border border-slate-200 bg-white">
                                            <img :src="item.file_foto" class="w-full h-20 object-cover">
                                            <div class="p-1 text-[10px] truncate text-slate-600" x-text="item.keterangan || 'Dokumentasi'"></div>
                                            <button type="button" 
                                                    @click="hapusFotoFasilitasDb(item.id)" 
                                                    class="absolute top-1 right-1 p-1 bg-rose-600 text-white rounded-md text-xs shadow-xs opacity-0 group-hover:opacity-100 transition cursor-pointer">
                                                &times;
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <!-- Repeater Baris Baru -->
                        <div class="space-y-2.5">
                            <template x-for="(row, index) in fotoTambahanBaru" :key="index">
                                <div class="p-3 bg-white rounded-xl border border-slate-200 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[11px] font-bold text-slate-700" x-text="'Foto Tambahan #' + (index + 1)"></span>
                                        <button type="button" @click="hapusBarisFotoTambahan(index)" class="text-rose-500 hover:text-rose-700 text-xs font-bold cursor-pointer">
                                            Hapus Baris
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-2">
                                        <div class="sm:col-span-7 flex items-center gap-1.5">
                                            <input type="text" 
                                                   name="foto_tambahan[]" 
                                                   x-model="row.url" 
                                                   placeholder="URL foto atau pilih media..." 
                                                   class="flex-1 px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                                            <button type="button" 
                                                    @click="bukaMediaPickerRepeater(index)" 
                                                    class="px-2.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition cursor-pointer">
                                                Pilih
                                            </button>
                                        </div>
                                        <div class="sm:col-span-5">
                                            <input type="text" 
                                                   name="keterangan_tambahan[]" 
                                                   x-model="row.keterangan" 
                                                   placeholder="Keterangan singkat..." 
                                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Right: Foto Utama (5 cols) -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
                        <div class="border-b border-slate-100 pb-3">
                            <h3 class="text-sm font-bold text-slate-900 font-heading">Foto &amp; Visibilitas</h3>
                            <p class="text-xs text-slate-500">Foto utama 4:3 &amp; sakelar status</p>
                        </div>

                        <!-- 4:3 Image Box -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Foto Utama Fasilitas (Rasio 4:3) <span class="text-rose-500">*</span>
                            </label>

                            <div class="aspect-4/3 rounded-xl overflow-hidden bg-slate-50 border border-slate-200 flex items-center justify-center relative mb-2">
                                <template x-if="formFotoUtama">
                                    <img :src="formFotoUtama" alt="Foto Utama" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!formFotoUtama">
                                    <div class="text-center p-4 text-slate-400">
                                        <svg class="w-10 h-10 mx-auto mb-1 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span class="text-xs font-medium">Belum ada foto utama</span>
                                    </div>
                                </template>
                            </div>

                            <div class="flex gap-2 items-center">
                                <input type="text" 
                                       name="foto_utama" 
                                       id="input_foto_utama_fasilitas"
                                       x-model="formFotoUtama" 
                                       required 
                                       placeholder="https://... atau pilih media" 
                                       class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                                
                                <button type="button" 
                                        @click="bukaMediaPicker('foto_utama')" 
                                        class="px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Pilih Media
                                </button>
                            </div>
                        </div>

                        <!-- Status Aktif -->
                        <div class="pt-2 border-t border-slate-100">
                            <label class="flex items-center gap-2.5 cursor-pointer">
                                <input type="checkbox" name="is_aktif" value="1" x-model="formIsAktif" class="w-4 h-4 text-blue-600 rounded-sm border-slate-300 focus:ring-blue-500">
                                <div>
                                    <span class="text-xs font-bold text-slate-800 block">Tampilkan di Halaman Sarpras Publik</span>
                                    <span class="text-[10px] text-slate-400 block">Nonaktifkan jika masih berstatus draf</span>
                                </div>
                            </label>
                        </div>

                        <!-- Action Submit Form -->
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                            <button type="submit" 
                                    class="w-full px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer">
                                <span x-text="editMode ? 'Simpan Perubahan Fasilitas' : 'Simpan & Publikasikan Fasilitas'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- =========================================================================
         TAB 3: STATISTIK CEPAT SARPRAS
    ========================================================================== -->
    <div x-show="activeTab === 'stats'" x-cloak class="space-y-6">
        <form action="{{ route('tenant.admin.informasi.fasilitas.stats.update', ['tenant' => app('tenant')->slug]) }}" method="POST">
            @csrf
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4 max-w-2xl">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Statistik Cepat Sarana &amp; Prasarana
                    </h2>
                    <p class="text-xs text-slate-500">Angka metrik ini tampil pada bar ringkasan atas di halaman publik Fasilitas.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Jumlah Ruang Kelas Teori <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="stats_ruang_kelas" value="{{ old('stats_ruang_kelas', $stats['ruang_kelas']) }}" required placeholder="Contoh: 41" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Jumlah Bengkel Praktik &amp; Lab <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="stats_bengkel_lab" value="{{ old('stats_bengkel_lab', $stats['bengkel_lab']) }}" required placeholder="Contoh: 7+" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Perpustakaan Terakreditasi <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="stats_perpustakaan" value="{{ old('stats_perpustakaan', $stats['perpustakaan']) }}" required placeholder="Contoh: 1" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Akses Internet Kampus <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="stats_akses_internet" value="{{ old('stats_akses_internet', $stats['akses_internet']) }}" required placeholder="Contoh: 100%" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center gap-2 cursor-pointer">
                        Simpan Statistik Sarpras
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- =========================================================================
         TAB 4: VISIBILITAS MENU PUBLIK
    ========================================================================== -->
    <div x-show="activeTab === 'visibilitas'" x-cloak class="space-y-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4 max-w-2xl">
            <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">Visibilitas Fitur Sarana &amp; Fasilitas</h2>
                    <p class="text-xs text-slate-500">Kontrol apakah menu Sarana &amp; Fasilitas ditampilkan pada navigasi publik website sekolah.</p>
                </div>
            </div>

            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-200">
                <div>
                    <span class="text-xs font-bold text-slate-800 block">Status Fitur Menu Fasilitas</span>
                    <span class="text-[11px] text-slate-500 block mt-0.5" x-text="isFiturAktif ? 'Aktif - Menu dan halaman fasilitas dapat diakses oleh publik.' : 'Nonaktif - Menu disembunyikan dari navbar publik.'"></span>
                </div>
                
                <button type="button" 
                        @click="toggleStatusFitur('fasilitas')" 
                        :disabled="isToggling"
                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-hidden"
                        :class="isFiturAktif ? 'bg-blue-600' : 'bg-slate-300'">
                    <span class="sr-only">Toggle Status</span>
                    <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow-sm ring-0 transition duration-200 ease-in-out"
                          :class="isFiturAktif ? 'translate-x-5' : 'translate-x-0'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL KONFIRMASI HAPUS FASILITAS -->
    <div x-show="modalHapus" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-5 space-y-4 border border-slate-200"
             @click.outside="modalHapus = false">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-slate-900 font-heading">Hapus Fasilitas Sekolah?</h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Anda akan menghapus fasilitas <strong class="text-slate-800" x-text="hapusNama"></strong> beserta seluruh foto dokumentasinya. Aksi ini permanen.
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

    <!-- Form Hapus Foto Fasilitas Ajax/Post Hidden -->
    <form id="form-hapus-foto-fasilitas" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- Reusable Media Picker Component -->
    @include('tenant.admin.media.picker-modal')

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('fasilitasManager', (config) => ({
        activeTab: config.activeTab,
        showToast: false,
        toastText: config.toastMsg,
        isToastError: config.isError,
        bannerHeroPreview: config.bannerHeroPreview,
        isFiturAktif: config.isFiturAktif,
        isToggling: false,

        // Modal hapus
        modalHapus: false,
        hapusNama: '',
        hapusActionUrl: '',

        // Form Fasilitas State
        editMode: false,
        formFasilitasActionUrl: @js(route('tenant.admin.informasi.fasilitas.store', ['tenant' => app('tenant')->slug])),
        formNamaFasilitas: '',
        formDeskripsiFasilitas: '',
        formFotoUtama: '',
        formIsAktif: true,
        existingFotoList: [],
        fotoTambahanBaru: [],

        targetMediaField: null,
        activeRepeaterIndex: null,

        init() {
            if (this.toastText) {
                this.showToast = true;
                setTimeout(() => { this.showToast = false; }, 4000);
            }
        },

        tambahFasilitasBaru() {
            this.editMode = false;
            this.formFasilitasActionUrl = @js(route('tenant.admin.informasi.fasilitas.store', ['tenant' => app('tenant')->slug]));
            this.formNamaFasilitas = '';
            this.formDeskripsiFasilitas = '';
            this.formFotoUtama = '';
            this.formIsAktif = true;
            this.existingFotoList = [];
            this.fotoTambahanBaru = [];
            this.activeTab = 'form';
        },

        editFasilitasItem(fasilitas) {
            this.editMode = true;
            this.formFasilitasActionUrl = `/{{ app('tenant')->slug }}/admin/informasi/fasilitas/${fasilitas.id}`;
            this.formNamaFasilitas = fasilitas.nama_fasilitas;
            this.formDeskripsiFasilitas = fasilitas.deskripsi || '';
            this.formFotoUtama = fasilitas.foto_utama || '';
            this.formIsAktif = fasilitas.is_aktif ? true : false;
            this.existingFotoList = fasilitas.foto_lainnya || [];
            this.fotoTambahanBaru = [];
            this.activeTab = 'form';
        },

        tambahBarisFotoTambahan() {
            this.fotoTambahanBaru.push({ url: '', keterangan: '' });
        },

        hapusBarisFotoTambahan(index) {
            this.fotoTambahanBaru.splice(index, 1);
        },

        hapusFotoFasilitasDb(fotoId) {
            if (confirm('Hapus foto dokumentasi tambahan ini?')) {
                const form = document.getElementById('form-hapus-foto-fasilitas');
                form.action = `/{{ app('tenant')->slug }}/admin/informasi/fasilitas/foto/${fotoId}`;
                form.submit();
            }
        },

        konfirmasiHapusFasilitas(id, nama) {
            this.hapusNama = nama;
            this.hapusActionUrl = `/{{ app('tenant')->slug }}/admin/informasi/fasilitas/${id}`;
            this.modalHapus = true;
        },

        bukaMediaPicker(targetField) {
            this.targetMediaField = targetField;
            window.dispatchEvent(new CustomEvent('open-media-picker', {
                detail: {
                    onSelect: (mediaItem) => {
                        const fileUrl = mediaItem.url || mediaItem.file_url || mediaItem.file_path;
                        if (this.targetMediaField === 'foto_utama') {
                            this.formFotoUtama = fileUrl;
                        } else if (this.targetMediaField === 'banner_hero') {
                            this.bannerHeroPreview = fileUrl;
                        }
                    }
                }
            }));
        },

        bukaMediaPickerRepeater(index) {
            this.activeRepeaterIndex = index;
            window.dispatchEvent(new CustomEvent('open-media-picker', {
                detail: {
                    onSelect: (mediaItem) => {
                        const fileUrl = mediaItem.url || mediaItem.file_url || mediaItem.file_path;
                        if (this.activeRepeaterIndex !== null && this.fotoTambahanBaru[this.activeRepeaterIndex]) {
                            this.fotoTambahanBaru[this.activeRepeaterIndex].url = fileUrl;
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
