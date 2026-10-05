@extends('layouts.tenant_admin')

@section('title', 'Manajemen Berita & Artikel Sekolah')
@section('header_title', 'Berita & Artikel Sekolah')

@push('styles')
<!-- Quill WYSIWYG CSS -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
<div class="max-w-7xl mx-auto space-y-6" 
     x-data="beritaManager({
         activeTab: @js(request('tab', 'berita')),
         toastMsg: @js(session('success') ?? session('error') ?? ''),
         isError: @js(session()->has('error')),
         bannerHeroPreview: @js(old('gambar_banner', $halamanBerita->gambar_banner ?? '')),
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
         :class="isErrorToast ? 'bg-rose-600' : 'bg-emerald-600'"
         class="fixed bottom-5 right-5 z-50 text-white px-5 py-3.5 rounded-2xl shadow-xl flex items-center gap-3 max-w-md">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-xs sm:text-sm font-medium" x-text="toastMessage"></span>
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
                <button type="button" @click="setTab('berita')"
                        :class="activeTab === 'berita' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    1. Daftar Berita &amp; Artikel
                </button>

                <button type="button" @click="setTab('form_berita')"
                        :class="activeTab === 'form_berita' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span x-text="beritaForm.id ? '2. Edit Artikel' : '2. Tulis Berita Baru'"></span>
                </button>

                <button type="button" @click="setTab('kategori')"
                        :class="activeTab === 'kategori' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    3. Kategori Berita
                </button>

                <button type="button" @click="setTab('visibilitas')"
                        :class="activeTab === 'visibilitas' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    4. Visibilitas Menu
                </button>
            </div>

            <!-- Sticky Right Actions -->
            <div class="flex items-center gap-2 shrink-0">
                <template x-if="activeTab === 'berita'">
                    <div class="flex items-center gap-2">
                        <button type="button" @click="openFormBerita()" 
                                class="admin-btn-create">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Tulis Berita</span>
                        </button>
                        <button type="button" @click="submitActiveForm('form-berita-hero')" :disabled="submitLoading"
                                class="admin-btn-save bg-slate-800 hover:bg-slate-900">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Hero'"></span>
                        </button>
                    </div>
                </template>

                <template x-if="activeTab === 'form_berita'">
                    <div class="flex items-center gap-2">
                        <template x-if="beritaForm.id">
                            <button type="button" @click="openFormBerita()" 
                                    class="px-3 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold rounded-xl transition flex items-center gap-1 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>[+] Tulis Baru</span>
                            </button>
                        </template>
                        <button type="button" @click="setTab('berita')" 
                                class="admin-btn-cancel text-xs">
                            Batal
                        </button>
                        <button type="button" @click="submitActiveForm('form-berita-main')" :disabled="submitLoading"
                                class="admin-btn-save">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="submitLoading ? 'Menyimpan...' : (beritaForm.id ? 'Perbarui Berita' : 'Terbitkan Berita')"></span>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         TAB 1: DAFTAR BERITA & ARTIKEL & HERO BANNER
    ========================================================================== -->
    <div x-show="activeTab === 'berita'" x-cloak class="space-y-6">
        <!-- Pengaturan Hero Banner Berita Publik -->
        <form id="form-berita-hero" action="{{ route('tenant.admin.informasi.hero.update', ['tenant' => app('tenant')->slug, 'modul' => 'berita']) }}" 
              method="POST" 
              @submit="submitLoading = true"
              class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
            @csrf
            @method('PUT')

            <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Kustomisasi Hero Banner (Halaman Berita Publik)
                    </h2>
                    <p class="text-xs text-slate-500">Atur judul utama, deskripsi ringkas, dan gambar latar hero pada halaman direktori berita publik <code>/berita</code>.</p>
                </div>
                <a href="{{ url(app('tenant')->slug . '/berita') }}" target="_blank" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 shrink-0">
                    <span>Lihat Halaman Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Judul Utama Hero Banner <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul_hero" value="{{ old('judul_hero', $halamanBerita->judul) }}" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                           placeholder="Contoh: Berita & Artikel Terkini">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Ringkas / Subjudul Hero</label>
                    <textarea name="subjudul_hero" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                              placeholder="Contoh: Dapatkan informasi terbaru mengenai agenda penting, prestasi siswa, dan kegiatan sekolah.">{{ old('subjudul_hero', $halamanBerita->subjudul) }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Gambar Latar Hero (Pusat Media / URL)</label>
                    <div class="flex gap-2 items-center">
                        <div class="w-16 h-10 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 relative flex items-center justify-center">
                            <template x-if="bannerHeroPreview">
                                <img :src="bannerHeroPreview" alt="Hero Banner Preview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!bannerHeroPreview">
                                <span class="text-[9px] text-slate-500 font-mono">16:9</span>
                            </template>
                        </div>
                        <input type="text" name="gambar_banner" id="input_banner_berita" 
                               x-model="bannerHeroPreview"
                               class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                               placeholder="https://... atau pilih dari Pusat Berkas Media">
                        <button type="button" @click="openMediaPicker('input_banner_berita')" 
                                class="px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Pilih dari Media
                        </button>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Rasio standar 16:9 / 21:9. Tampil sebagai latar banner di bagian atas direktori berita publik.</p>
                </div>
            </div>
        </form>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        Daftar Berita &amp; Artikel Sekolah
                    </h2>
                    <p class="text-xs text-slate-500">Kelola artikel kegiatan sekolah, prestasi, dan publikasi resmi.</p>
                </div>
                <button type="button" @click="openFormBerita()" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center gap-1.5 cursor-pointer shrink-0 self-start sm:self-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Tulis Berita Baru</span>
                </button>
            </div>

            <!-- Filter & Search Bar -->
            <form method="GET" action="{{ route('tenant.admin.informasi.berita', ['tenant' => app('tenant')->slug]) }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                <input type="hidden" name="tab" value="berita">
                <div class="sm:col-span-6">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul berita atau isi..." 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>
                <div class="sm:col-span-3">
                    <select name="kategori_id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <select name="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        <option value="">-- Semua Status --</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <div class="sm:col-span-1 flex gap-1">
                    <button type="submit" class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition flex items-center justify-center cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </div>
            </form>

            <!-- Table Listing -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="px-3 py-3 w-20 text-center">Sampul</th>
                            <th class="px-4 py-3">Judul Berita</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Tgl Publikasi</th>
                            <th class="px-4 py-3 text-center">Dibaca</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($beritaList as $item)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-3 py-3 text-center">
                                    <div class="w-16 h-10 mx-auto rounded-lg border border-slate-200 bg-slate-100 overflow-hidden relative">
                                        @if($item->gambar_sampul)
                                            <img src="{{ $item->gambar_sampul }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 font-medium text-slate-900 max-w-xs">
                                    <div class="font-bold text-xs line-clamp-1">{{ $item->judul }}</div>
                                    <div class="text-[11px] text-slate-400 font-mono mt-0.5 truncate">{{ $item->slug }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        {{ $item->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-slate-500 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($item->tgl_publikasi)->translatedFormat('d M Y, H:i') }}
                                </td>
                                <td class="px-4 py-3 text-center font-bold text-slate-600">
                                    {{ number_format($item->jumlah_dilihat) }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button type="button" 
                                            @click="toggleItemStatus('berita', {{ $item->id }})"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold transition cursor-pointer {{ $item->status_publikasi === 'published' ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-amber-100 text-amber-800 hover:bg-amber-200' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $item->status_publikasi === 'published' ? 'bg-emerald-600' : 'bg-amber-600' }}"></span>
                                        <span>{{ ucfirst($item->status_publikasi) }}</span>
                                    </button>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ url(app('tenant')->slug . '/berita/' . $item->slug) }}" target="_blank" 
                                           class="p-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-blue-600 transition"
                                           title="Lihat Halaman Publik">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                        <button type="button" @click="editBerita({{ Js::from($item) }})" 
                                                class="p-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-blue-600 transition cursor-pointer"
                                                title="Edit Berita">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </button>
                                        <button type="button" @click="confirmDelete('berita', {{ $item->id }}, '{{ addslashes($item->judul) }}')"
                                                class="p-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-600 transition cursor-pointer"
                                                title="Hapus Berita">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400">
                                    Belum ada artikel berita yang ditambahkan. Silakan klik "Tulis Berita Baru".
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pt-3 border-t border-slate-100">
                {{ $beritaList->links() }}
            </div>
        </div>
    </div>

    <!-- =========================================================================
         TAB 2: FORM TULIS / EDIT BERITA
    ========================================================================== -->
    <div x-show="activeTab === 'form_berita'" x-cloak class="space-y-6">
        <form id="form-berita-main"
              :action="beritaForm.id ? '{{ url(app('tenant')->slug . '/admin/informasi/berita') }}/' + beritaForm.id : '{{ route('tenant.admin.informasi.berita.store', ['tenant' => app('tenant')->slug]) }}'" 
              method="POST" 
              @submit="prepareBeritaSubmit($event)"
              class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
            @csrf
            <template x-if="beritaForm.id">
                <input type="hidden" name="_method" value="PUT">
            </template>

            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading" x-text="beritaForm.id ? 'Edit Artikel Berita' : 'Tulis Artikel Berita Baru'"></h2>
                    <p class="text-xs text-slate-500">Lengkapi judul, kategori, gambar sampul, dan konten artikel dengan editor WYSIWYG.</p>
                </div>
                <button type="button" @click="resetFormBerita()" class="text-xs text-slate-500 hover:text-slate-800 font-bold cursor-pointer">
                    Batal / Bersihkan Form
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <!-- Judul Artikel (8 cols) -->
                <div class="md:col-span-8">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Judul Berita / Artikel <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" x-model="beritaForm.judul" required placeholder="Contoh: Siswa SMKN 2 Bandung Meraih Juara 1 LKS Tingkat Nasional"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>

                <!-- Kategori Artikel (4 cols) -->
                <div class="md:col-span-4">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kategori <span class="text-rose-500">*</span></label>
                    <select name="kategori_id" x-model="beritaForm.kategori_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Ringkasan / Excerpt (12 cols) -->
                <div class="md:col-span-12">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Ringkasan Singkat (Muncul di kartu katalog beranda &amp; meta SEO)</label>
                    <textarea name="ringkasan" x-model="beritaForm.ringkasan" rows="2" placeholder="Tuliskan 1-2 kalimat pengantar artikel..."
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"></textarea>
                </div>

                <!-- Gambar Sampul Utama (12 cols) -->
                <div class="md:col-span-12">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Gambar Sampul Utama (Pusat Media / URL)</label>
                    <div class="flex gap-2 items-center">
                        <div class="w-16 h-10 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 relative flex items-center justify-center">
                            <template x-if="beritaForm.gambar_sampul">
                                <img :src="beritaForm.gambar_sampul" alt="Preview Sampul" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!beritaForm.gambar_sampul">
                                <span class="text-[9px] text-slate-500 font-mono">16:9</span>
                            </template>
                        </div>
                        <input type="text" name="gambar_sampul" x-model="beritaForm.gambar_sampul" placeholder="https://... atau pilih dari Pusat Berkas Media"
                               class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        <button type="button" @click="openMediaPicker('berita_sampul')"
                                class="px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Pilih Media
                        </button>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Rasio standar 16:9 (JPG, PNG, WebP) resolusi minimal 1280x720px.</p>
                </div>

                <!-- Isi Konten Artikel WYSIWYG (12 cols) -->
                <div class="md:col-span-12">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Isi Konten Artikel (WYSIWYG) <span class="text-rose-500">*</span></label>
                    <div id="editorBeritaKonten"></div>
                    <input type="hidden" name="isi_konten" id="hiddenIsiKontenBerita">
                </div>

                <!-- Status Publikasi & Tanggal (12 cols) -->
                <div class="md:col-span-6">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Publikasi</label>
                    <select name="status_publikasi" x-model="beritaForm.status_publikasi" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition font-semibold">
                        <option value="published">Langsung Publikasikan (Published)</option>
                        <option value="draft">Simpan Sebagai Draf (Draft)</option>
                    </select>
                </div>
                <div class="md:col-span-6">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jadwal Tanggal &amp; Waktu Publikasi</label>
                    <input type="datetime-local" name="tgl_publikasi" x-model="beritaForm.tgl_publikasi"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>
            </div>
        </form>
    </div>

    <!-- =========================================================================
         TAB 3: MANAJEMEN KATEGORI BERITA
    ========================================================================== -->
    <div x-show="activeTab === 'kategori'" x-cloak class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            <!-- Form Tambah/Edit Kategori (5 cols) -->
            <div class="md:col-span-5 bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading" x-text="kategoriForm.id ? 'Edit Kategori Berita' : 'Tambah Kategori Baru'"></h3>
                    <p class="text-xs text-slate-500">Kelompokkan berita agar pengunjung mudah mencari topik relevan.</p>
                </div>

                <form :action="kategoriForm.id ? '{{ url(app('tenant')->slug . '/admin/informasi/kategori') }}/' + kategoriForm.id : '{{ route('tenant.admin.informasi.kategori.store', ['tenant' => app('tenant')->slug]) }}'" method="POST" class="space-y-4">
                    @csrf
                    <template x-if="kategoriForm.id">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Kategori <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_kategori" x-model="kategoriForm.nama_kategori" required placeholder="Contoh: Prestasi, Kemitraan Industri, TEFA"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <template x-if="kategoriForm.id">
                            <button type="button" @click="resetKategoriForm()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition cursor-pointer">
                                Batal
                            </button>
                        </template>
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center gap-2 cursor-pointer">
                            <span x-text="kategoriForm.id ? 'Perbarui Kategori' : 'Tambah Kategori'"></span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Daftar Kategori (7 cols) -->
            <div class="md:col-span-7 bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading">Daftar Kategori Aktif</h3>
                    <p class="text-xs text-slate-500">Kategori dengan jumlah artikel yang terhubung.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-2.5">Nama Kategori</th>
                                <th class="px-4 py-2.5">Slug URL</th>
                                <th class="px-4 py-2.5 text-center">Jumlah Artikel</th>
                                <th class="px-4 py-2.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($kategoriList as $kat)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-4 py-3 font-bold text-slate-900">{{ $kat->nama_kategori }}</td>
                                    <td class="px-4 py-3 font-mono text-[11px] text-slate-400">{{ $kat->slug }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                            {{ $kat->artikels_count }} artikel
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <button type="button" @click="editKategori({{ Js::from($kat) }})" class="p-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-blue-600 transition cursor-pointer">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            </button>
                                            <button type="button" @click="confirmDelete('kategori', {{ $kat->id }}, '{{ addslashes($kat->nama_kategori) }}')" class="p-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-600 transition cursor-pointer">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         TAB 4: VISIBILITAS MENU & RUTE
    ========================================================================== -->
    <div x-show="activeTab === 'visibilitas'" x-cloak class="space-y-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-5">
            <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">Sakelar Visibilitas Modul Berita</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Kontrol ketersediaan rute publik (<code>/berita</code>) dan menu navigasi berita di navbar portal.</p>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 self-start">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    Feature Flag Protection
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3">Komponen / Fitur</th>
                            <th class="px-4 py-3">Rute / Endpoint</th>
                            <th class="px-4 py-3">Kode Fitur</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Sakelar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr class="bg-blue-50/60 font-bold text-slate-900 border-t-2 border-blue-200">
                            <td class="px-4 py-3.5 flex items-center gap-2">
                                <div class="w-3 h-3 rounded-md bg-blue-600 flex items-center justify-center text-[9px] text-white">★</div>
                                <span class="text-xs sm:text-sm text-blue-950">Modul Berita &amp; Artikel Publik</span>
                            </td>
                            <td class="px-4 py-3.5 font-mono text-xs text-blue-800">/berita &amp; /berita/{slug}</td>
                            <td class="px-4 py-3.5 font-mono text-xs text-blue-700 font-semibold">berita</td>
                            <td class="px-4 py-3.5">
                                <span :class="isFiturAktif ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'"
                                      class="px-2.5 py-1 rounded-full text-[10px] font-bold">
                                    <span x-text="isFiturAktif ? 'Aktif (Tampil di Publik)' : 'Nonaktif (Disembunyikan)'"></span>
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <button type="button" 
                                        @click="toggleFeatureFlag('berita', !isFiturAktif)"
                                        :class="isFiturAktif ? 'bg-blue-600' : 'bg-slate-300'"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                    <span :style="isFiturAktif ? 'transform: translateX(20px);' : 'transform: translateX(0px);'"
                                          class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md ring-0 transition-transform duration-300 ease-in-out"></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Data -->
    <div x-show="showDeleteModal" style="display: none;" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 space-y-4 shadow-xl text-center">
            <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 mx-auto flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading">Konfirmasi Hapus Data</h3>
            <p class="text-xs text-slate-500" x-text="'Apakah Anda yakin ingin menghapus data \'' + deleteItemName + '\'?'"></p>
            <form :action="deleteActionUrl" method="POST" class="flex gap-2">
                @csrf
                @method('DELETE')
                <button type="button" @click="showDeleteModal = false" class="flex-1 py-2.5 rounded-xl border border-slate-200 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition cursor-pointer">Batal</button>
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition cursor-pointer">Ya, Hapus</button>
            </form>
        </div>
    </div>

    <!-- Modal Media Picker Reusable -->
    @include('tenant.admin.media.picker-modal')

</div>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
function beritaManager(config) {
    return {
        activeTab: config.activeTab || 'berita',
        toastMessage: config.toastMsg || '',
        showToast: !!config.toastMsg,
        isErrorToast: config.isError || false,
        bannerHeroPreview: config.bannerHeroPreview || '',
        isFiturAktif: config.isFiturAktif,
        routes: config.routes,

        // Quill Instance
        quillKonten: null,
        submitLoading: false,

        submitActiveForm(formId) {
            const form = document.getElementById(formId);
            if (!form) return;

            if (formId === 'form-berita-main') {
                const hidden = document.getElementById('hiddenIsiKontenBerita');
                if (this.quillKonten && hidden) {
                    hidden.value = this.quillKonten.root.innerHTML;
                }
            }

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

        // State Forms
        beritaForm: {
            id: null,
            judul: '',
            kategori_id: '',
            ringkasan: '',
            gambar_sampul: '',
            isi_konten: '',
            status_publikasi: 'published',
            tgl_publikasi: ''
        },

        kategoriForm: {
            id: null,
            nama_kategori: ''
        },

        // Delete Modal State
        showDeleteModal: false,
        deleteActionUrl: '',
        deleteItemName: '',

        // Media Picker State
        pickerTarget: null,
        mediaPickerModal: false,
        mediaPickerLoading: false,
        mediaPickerItems: [],
        mediaPickerType: 'semua',
        mediaPickerSearch: '',
        mediaPickerUploading: false,
        mediaPickerImportUrl: '',
        mediaPickerImportLoading: false,

        init() {
            if (this.showToast) {
                setTimeout(() => { this.showToast = false; }, 4000);
            }
            this.$nextTick(() => {
                this.initQuill();
            });
        },

        initQuill() {
            const el = document.getElementById('editorBeritaKonten');
            if (el && !this.quillKonten) {
                this.quillKonten = new Quill(el, {
                    theme: 'snow',
                    placeholder: 'Tuliskan isi berita sekolah secara mendalam di sini...',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['blockquote', 'code-block'],
                            ['link', 'clean']
                        ]
                    }
                });
                if (this.beritaForm.isi_konten) {
                    this.quillKonten.root.innerHTML = this.beritaForm.isi_konten;
                }
            }
        },

        setTab(tab) {
            this.activeTab = tab;
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);
            window.history.pushState({}, '', url);

            if (tab === 'form_berita') {
                this.$nextTick(() => {
                    this.initQuill();
                });
            }
        },

        openFormBerita() {
            this.resetFormBerita();
            this.setTab('form_berita');
        },

        editBerita(item) {
            this.beritaForm = {
                id: item.id,
                judul: item.judul || '',
                kategori_id: item.kategori_id || '',
                ringkasan: item.ringkasan || '',
                gambar_sampul: item.gambar_sampul || '',
                isi_konten: item.isi_konten || '',
                status_publikasi: item.status_publikasi || 'published',
                tgl_publikasi: item.tgl_publikasi ? item.tgl_publikasi.substring(0, 16) : ''
            };
            this.setTab('form_berita');
            this.$nextTick(() => {
                this.initQuill();
                if (this.quillKonten) {
                    this.quillKonten.root.innerHTML = item.isi_konten || '';
                }
            });
        },

        resetFormBerita() {
            this.beritaForm = {
                id: null,
                judul: '',
                kategori_id: '',
                ringkasan: '',
                gambar_sampul: '',
                isi_konten: '',
                status_publikasi: 'published',
                tgl_publikasi: ''
            };
            if (this.quillKonten) {
                this.quillKonten.root.innerHTML = '';
            }
        },

        prepareBeritaSubmit(e) {
            const hidden = document.getElementById('hiddenIsiKontenBerita');
            if (this.quillKonten && hidden) {
                hidden.value = this.quillKonten.root.innerHTML;
            }
        },

        editKategori(kat) {
            this.kategoriForm = {
                id: kat.id,
                nama_kategori: kat.nama_kategori
            };
        },

        resetKategoriForm() {
            this.kategoriForm = {
                id: null,
                nama_kategori: ''
            };
        },

        confirmDelete(type, id, name) {
            this.deleteItemName = name;
            if (type === 'berita') {
                this.deleteActionUrl = `{{ url(app('tenant')->slug . '/admin/informasi/berita') }}/${id}`;
            } else if (type === 'kategori') {
                this.deleteActionUrl = `{{ url(app('tenant')->slug . '/admin/informasi/kategori') }}/${id}`;
            }
            this.showDeleteModal = true;
        },

        async toggleItemStatus(modelType, id) {
            try {
                const res = await fetch(this.routes.toggleStatus, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        target_type: 'item',
                        model_type: modelType,
                        id: id
                    })
                });
                const data = await res.json();
                if (data.success) {
                    this.toastMessage = 'Status artikel berhasil diperbarui.';
                    this.isErrorToast = false;
                    this.showToast = true;
                    setTimeout(() => { location.reload(); }, 600);
                }
            } catch (err) {
                console.error(err);
            }
        },

        async toggleFeatureFlag(kodeFitur, nextState) {
            try {
                const res = await fetch(this.routes.toggleStatus, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        target_type: 'fitur',
                        kode_fitur: kodeFitur,
                        is_aktif: nextState
                    })
                });
                const data = await res.json();
                if (data.success) {
                    this.isFiturAktif = data.is_aktif;
                    this.toastMessage = data.message;
                    this.isErrorToast = false;
                    this.showToast = true;
                    setTimeout(() => { this.showToast = false; }, 3500);
                }
            } catch (err) {
                console.error(err);
            }
        },

        // Media Picker Methods
        openMediaPicker(target) {
            this.pickerTarget = target;
            this.mediaPickerModal = true;
            this.fetchMediaItems();
        },

        closeMediaPicker() {
            this.mediaPickerModal = false;
            this.pickerTarget = null;
        },

        selectMedia(url) {
            if (this.pickerTarget === 'berita_sampul') {
                this.beritaForm.gambar_sampul = url;
            } else if (this.pickerTarget === 'hero_banner') {
                this.bannerHeroPreview = url;
            }
            this.closeMediaPicker();
        },

        async fetchMediaItems() {
            this.mediaPickerLoading = true;
            try {
                let url = `${this.routes.mediaIndex}?format=json&tipe=${this.mediaPickerType}`;
                if (this.mediaPickerSearch) {
                    url += `&q=${encodeURIComponent(this.mediaPickerSearch)}`;
                }
                const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                const json = await res.json();
                this.mediaPickerItems = json.data || json || [];
            } catch (e) {
                this.mediaPickerItems = [];
            } finally {
                this.mediaPickerLoading = false;
            }
        },

        async handlePickerUpload(e) {
            const files = e.target.files;
            if (!files || files.length === 0) return;
            this.mediaPickerUploading = true;
            const formData = new FormData();
            formData.append('berkas', files[0]);
            formData.append('kategori', 'berita');
            formData.append('keterangan', 'Unggahan dari Form Berita');

            try {
                const res = await fetch(this.routes.mediaUpload, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: formData
                });
                const json = await res.json();
                if (json.success && json.media) {
                    this.selectMedia(json.media.file_url);
                }
            } catch (err) {
                alert('Gagal mengunggah berkas.');
            } finally {
                this.mediaPickerUploading = false;
            }
        },

        async handlePickerImportUrl() {
            if (!this.mediaPickerImportUrl) return;
            this.mediaPickerImportLoading = true;
            try {
                const res = await fetch(this.routes.mediaImportUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        url: this.mediaPickerImportUrl,
                        kategori: 'berita',
                        keterangan: 'Impor URL dari Form Berita'
                    })
                });
                const json = await res.json();
                if (json.success && json.media) {
                    this.selectMedia(json.media.file_url);
                }
            } catch (err) {
                alert('Gagal mengimpor media dari URL.');
            } finally {
                this.mediaPickerImportLoading = false;
            }
        }
    };
}
</script>
@endpush
