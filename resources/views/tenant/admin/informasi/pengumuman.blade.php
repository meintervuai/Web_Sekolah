@extends('layouts.tenant_admin')

@section('title', 'Manajemen Pengumuman Resmi')
@section('header_title', 'Pengumuman Resmi Sekolah')

@push('styles')
<!-- Quill WYSIWYG CSS -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
<div class="max-w-7xl mx-auto space-y-6" 
     x-data="pengumumanManager({
         activeTab: @js(request('tab', 'pengumuman')),
         toastMsg: @js(session('success') ?? session('error') ?? ''),
         isError: @js(session()->has('error')),
         bannerHeroPreview: @js(old('gambar_banner', $halamanPengumuman->gambar_banner ?? '')),
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
                <button type="button" @click="setTab('pengumuman')"
                        :class="activeTab === 'pengumuman' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    1. Daftar Pengumuman
                </button>

                <button type="button" @click="setTab('form_pengumuman')"
                        :class="activeTab === 'form_pengumuman' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span x-text="pengumumanForm.id ? '2. Edit Pengumuman' : '2. Buat Pengumuman Baru'"></span>
                </button>
            </div>

            <!-- Sticky Right Actions -->
            <div class="flex items-center gap-2 shrink-0">
                <template x-if="activeTab === 'pengumuman'">
                    <div class="flex items-center gap-2">
                        <button type="button" @click="openFormPengumuman()" 
                                class="admin-btn-create">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Buat Pengumuman</span>
                        </button>
                        <button type="button" @click="submitActiveForm('form-pengumuman-hero')" :disabled="submitLoading"
                                class="admin-btn-save bg-slate-800 hover:bg-slate-900">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Hero'"></span>
                        </button>
                    </div>
                </template>

                <template x-if="activeTab === 'form_pengumuman'">
                    <div class="flex items-center gap-2">
                        <template x-if="pengumumanForm.id">
                            <button type="button" @click="openFormPengumuman()" 
                                    class="px-3 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold rounded-xl transition flex items-center gap-1 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>[+] Buat Baru</span>
                            </button>
                        </template>
                        <button type="button" @click="setTab('pengumuman')" 
                                class="admin-btn-cancel text-xs">
                            Batal
                        </button>
                        <button type="button" @click="submitActiveForm('form-pengumuman-main')" :disabled="submitLoading"
                                class="admin-btn-save">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="submitLoading ? 'Menyimpan...' : (pengumumanForm.id ? 'Perbarui Pengumuman' : 'Terbitkan Pengumuman')"></span>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         TAB 1: DAFTAR PENGUMUMAN & HERO BANNER
    ========================================================================== -->
    <div x-show="activeTab === 'pengumuman'" x-cloak class="space-y-6">
        <!-- Pengaturan Hero Banner Pengumuman Publik -->
        <form id="form-pengumuman-hero" action="{{ route('tenant.admin.informasi.hero.update', ['tenant' => app('tenant')->slug, 'modul' => 'pengumuman']) }}" 
              method="POST" 
              @submit="submitLoading = true"
              class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
            @csrf
            @method('PUT')

            <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Kustomisasi Hero Banner (Halaman Pengumuman Publik)
                    </h2>
                    <p class="text-xs text-slate-500">Atur judul utama, deskripsi ringkas, dan gambar latar hero pada halaman direktori pengumuman publik <code>/pengumuman</code>.</p>
                </div>
                <a href="{{ url(app('tenant')->slug . '/pengumuman') }}" target="_blank" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 shrink-0">
                    <span>Lihat Halaman Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Judul Utama Hero Banner <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul_hero" value="{{ old('judul_hero', $halamanPengumuman->judul) }}" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                           placeholder="Contoh: Pengumuman & Surat Edaran Resmi">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Ringkas / Subjudul Hero</label>
                    <textarea name="subjudul_hero" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                              placeholder="Contoh: Temukan pemberitahuan kedinasan, agenda penting, jadwal libur, dan keputusan resmi pimpinan sekolah.">{{ old('subjudul_hero', $halamanPengumuman->subjudul) }}</textarea>
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
                        <input type="text" name="gambar_banner" id="input_banner_pengumuman" 
                               x-model="bannerHeroPreview"
                               class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                               placeholder="https://... atau pilih dari Pusat Berkas Media">
                        <button type="button" @click="openMediaPicker('input_banner_pengumuman')" 
                                class="px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Pilih dari Media
                        </button>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Rasio standar 16:9 / 21:9. Tampil sebagai latar banner di bagian atas direktori pengumuman publik.</p>
                </div>
            </div>
        </form>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        Daftar Pengumuman Kedinasan &amp; Surat Edaran
                    </h2>
                    <p class="text-xs text-slate-500">Informasikan edaran resmi pimpinan sekolah, jadwal libur, dan keputusan penting.</p>
                </div>
                <button type="button" @click="openFormPengumuman()" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center gap-1.5 cursor-pointer shrink-0 self-start sm:self-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Buat Pengumuman Baru</span>
                </button>
            </div>

            <!-- Search & Filter Bar with View Mode Toggle -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 pt-1">
                <form method="GET" action="{{ route('tenant.admin.informasi.pengumuman', ['tenant' => app('tenant')->slug]) }}" class="flex-1 grid grid-cols-1 sm:grid-cols-12 gap-2.5">
                    <input type="hidden" name="tab" value="pengumuman">
                    <div class="sm:col-span-8 relative">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari perihal atau isi surat edaran..." 
                               class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>
                    <div class="sm:col-span-3">
                        <select name="status" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                            <option value="">-- Semua Status --</option>
                            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                    <div class="sm:col-span-1 flex items-center gap-1.5">
                        <button type="submit" class="w-full py-2.5 px-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition flex items-center justify-center cursor-pointer shadow-xs">
                            Cari
                        </button>
                        @if(request()->filled('q') || request()->filled('status'))
                            <a href="{{ route('tenant.admin.informasi.pengumuman', ['tenant' => app('tenant')->slug, 'tab' => 'pengumuman']) }}" class="px-2.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition" title="Reset Filter">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Switcher Toggle Grid vs List -->
                <div class="flex items-center p-0.5 bg-slate-100 rounded-xl border border-slate-200 shrink-0 self-end md:self-center">
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
                    <button 
                        type="button" 
                        @click="viewMode = 'grid'" 
                        :class="viewMode === 'grid' ? 'bg-white text-slate-900 font-bold shadow-2xs' : 'text-slate-500 hover:text-slate-800'"
                        class="px-3 py-1.5 rounded-lg text-xs transition cursor-pointer flex items-center gap-1.5"
                        title="Tampilan Grid / Kartu">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span class="text-xs font-semibold">Grid</span>
                    </button>
                </div>
            </div>

            <!-- TAMPILAN 1: Tabel / List -->
            <div x-show="viewMode === 'list'" class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-3 w-12 text-center">No</th>
                            <th class="px-3 py-3 w-20 text-center">Sampul / Surat</th>
                            <th class="px-4 py-3">Perihal / Judul Pengumuman</th>
                            <th class="px-4 py-3">Tgl Publikasi</th>
                            <th class="px-4 py-3 text-center">Dibaca</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pengumumanList as $idx => $item)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3 px-3 text-center text-slate-400 font-medium">
                                    {{ $pengumumanList->firstItem() + $idx }}
                                </td>
                                <td class="px-3 py-3 text-center">
                                    <div class="w-16 h-10 mx-auto rounded-lg border border-slate-200 bg-slate-100 overflow-hidden relative flex items-center justify-center">
                                        @if($item->gambar_sampul)
                                            <img src="{{ $item->gambar_sampul }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-50">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 font-medium text-slate-900 max-w-md">
                                    <div class="font-bold text-xs line-clamp-1">{{ $item->judul }}</div>
                                    <div class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ $item->ringkasan }}</div>
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
                                        <a href="{{ url(app('tenant')->slug . '/pengumuman/' . $item->slug) }}" target="_blank" 
                                           class="p-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-blue-600 transition"
                                           title="Lihat Halaman Publik">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                        <button type="button" @click="editPengumuman({{ Js::from($item) }})" 
                                                class="p-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-blue-600 transition cursor-pointer"
                                                title="Edit Pengumuman">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </button>
                                        <button type="button" @click="confirmDelete({{ $item->id }}, '{{ addslashes($item->judul) }}')"
                                                class="p-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-600 transition cursor-pointer"
                                                title="Hapus Pengumuman">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400">
                                    Belum ada pengumuman yang ditambahkan. Silakan klik "Buat Pengumuman Baru".
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- TAMPILAN 2: Grid Card Cards -->
            <div x-show="viewMode === 'grid'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse($pengumumanList as $item)
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden flex flex-col justify-between group hover:border-slate-300 hover:shadow-xs transition duration-200">
                        <!-- Image Cover Box if available -->
                        @if($item->gambar_sampul)
                            <div class="relative bg-slate-900 aspect-16/9 overflow-hidden flex items-center justify-center">
                                <img src="{{ $item->gambar_sampul }}" alt="" aria-hidden="true" class="absolute inset-0 w-full h-full object-cover blur-md scale-125 opacity-40 pointer-events-none z-0">
                                <img src="{{ $item->gambar_sampul }}" alt="{{ $item->judul }}" loading="lazy" class="relative z-10 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                        @endif

                        <div class="p-4 space-y-3 flex-1 flex flex-col justify-between">
                            <div class="space-y-2.5">
                                <!-- Card Header Badge & Status -->
                                <div class="flex items-center justify-between gap-2">
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        Edaran Resmi
                                    </span>
                                    <button type="button" 
                                            @click="toggleItemStatus('berita', {{ $item->id }})"
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold transition cursor-pointer {{ $item->status_publikasi === 'published' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $item->status_publikasi === 'published' ? 'bg-emerald-600' : 'bg-amber-600' }}"></span>
                                        <span>{{ ucfirst($item->status_publikasi) }}</span>
                                    </button>
                                </div>

                                <!-- Title & Summary -->
                                <div>
                                    <h3 class="font-bold text-xs text-slate-900 line-clamp-2 leading-snug group-hover:text-blue-600 transition" title="{{ $item->judul }}">
                                        {{ $item->judul }}
                                    </h3>
                                    @if($item->ringkasan)
                                        <p class="text-[11px] text-slate-500 line-clamp-3 mt-1.5 leading-relaxed">
                                            {{ $item->ringkasan }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[10px] text-slate-400">
                                <span>{{ \Carbon\Carbon::parse($item->tgl_publikasi)->translatedFormat('d M Y') }}</span>
                                <span class="flex items-center gap-1 font-semibold text-slate-500">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    {{ number_format($item->jumlah_dilihat) }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Actions -->
                        <div class="px-3.5 py-2 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between gap-1">
                            <a href="{{ url(app('tenant')->slug . '/pengumuman/' . $item->slug) }}" target="_blank" 
                               class="text-[11px] font-semibold text-slate-600 hover:text-blue-600 flex items-center gap-1 transition"
                               title="Lihat Halaman Publik">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                <span>Lihat</span>
                            </a>
                            <div class="flex items-center gap-1">
                                <button type="button" @click="editPengumuman({{ Js::from($item) }})" 
                                        class="p-1 rounded-lg hover:bg-blue-50 text-slate-600 hover:text-blue-600 transition cursor-pointer"
                                        title="Edit Pengumuman">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>
                                <button type="button" @click="confirmDelete({{ $item->id }}, '{{ addslashes($item->judul) }}')"
                                        class="p-1 rounded-lg hover:bg-rose-50 text-slate-600 hover:text-rose-600 transition cursor-pointer"
                                        title="Hapus Pengumuman">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-8 text-center text-slate-400">
                        Belum ada pengumuman yang ditambahkan. Silakan klik "Buat Pengumuman Baru".
                    </div>
                @endforelse
            </div>

            <div class="pt-3 border-t border-slate-100">
                {{ $pengumumanList->links() }}
            </div>
        </div>
    </div>

    <!-- =========================================================================
         TAB 2: FORM PENGUMUMAN
    ========================================================================== -->
    <div x-show="activeTab === 'form_pengumuman'" x-cloak class="space-y-6">
        <form id="form-pengumuman-main"
              :action="pengumumanForm.id ? '{{ url(app('tenant')->slug . '/admin/informasi/pengumuman') }}/' + pengumumanForm.id : '{{ route('tenant.admin.informasi.pengumuman.store', ['tenant' => app('tenant')->slug]) }}'" 
              method="POST" 
              @submit="preparePengumumanSubmit($event)"
              class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
            @csrf
            <template x-if="pengumumanForm.id">
                <input type="hidden" name="_method" value="PUT">
            </template>

            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading" x-text="pengumumanForm.id ? 'Edit Surat Edaran / Pengumuman' : 'Buat Pengumuman Resmi Baru'"></h2>
                    <p class="text-xs text-slate-500">Gunakan format surat dinas resmi dengan editor teks dan lampiran gambar/dokumen.</p>
                </div>
                <button type="button" @click="resetFormPengumuman()" class="text-xs text-slate-500 hover:text-slate-800 font-bold cursor-pointer">
                    Batal / Bersihkan Form
                </button>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Judul Pengumuman <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" x-model="pengumumanForm.judul" required placeholder="Contoh: Pengumuman Kelulusan & Jadwal Pengambilan Ijazah Tahun Ajaran 2025/2026"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Gambar / Dokumen Surat Resmi (Pusat Media / URL)</label>
                    <div class="flex gap-2 items-center">
                        <div class="w-16 h-10 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 relative flex items-center justify-center">
                            <template x-if="pengumumanForm.gambar_sampul">
                                <img :src="pengumumanForm.gambar_sampul" alt="Gambar Pengumuman Preview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!pengumumanForm.gambar_sampul">
                                <span class="text-[9px] text-slate-500 font-mono">16:9 / 3:4</span>
                            </template>
                        </div>
                        <input type="text" name="gambar_sampul" x-model="pengumumanForm.gambar_sampul" placeholder="https://... atau pilih foto surat resmi dari Pusat Berkas Media"
                               class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        <button type="button" @click="openMediaPicker('pengumuman_lampiran')"
                                class="px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Pilih Media
                        </button>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Unggah foto/scan surat resmi atau banner pengumuman dari sekolah.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Isi Pengumuman (WYSIWYG) <span class="text-rose-500">*</span></label>
                    <div id="editorPengumumanKonten"></div>
                    <input type="hidden" name="isi_konten" id="hiddenIsiKontenPengumuman">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Status Publikasi</label>
                        <select name="status_publikasi" x-model="pengumumanForm.status_publikasi" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition font-semibold">
                            <option value="published">Langsung Publikasikan (Published)</option>
                            <option value="draft">Simpan Sebagai Draf (Draft)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Publikasi</label>
                        <input type="datetime-local" name="tgl_publikasi" x-model="pengumumanForm.tgl_publikasi"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>
                </div>
            </div>
        </form>
    </div>



    <!-- Modal Konfirmasi Hapus Data -->
    <div x-show="showDeleteModal" style="display: none;" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 space-y-4 shadow-xl text-center">
            <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 mx-auto flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading">Konfirmasi Hapus Pengumuman</h3>
            <p class="text-xs text-slate-500" x-text="'Apakah Anda yakin ingin menghapus pengumuman \'' + deleteItemName + '\'?'"></p>
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
function pengumumanManager(config) {
    return {
        activeTab: config.activeTab || 'pengumuman',
        viewMode: 'list',
        toastMessage: config.toastMsg || '',
        showToast: !!config.toastMsg,
        isErrorToast: config.isError || false,
        bannerHeroPreview: config.bannerHeroPreview || '',
        isFiturAktif: config.isFiturAktif,
        routes: config.routes,

        quillKonten: null,
        submitLoading: false,

        submitActiveForm(formId) {
            const form = document.getElementById(formId);
            if (!form) return;

            if (formId === 'form-pengumuman-main') {
                const hidden = document.getElementById('hiddenIsiKontenPengumuman');
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

        pengumumanForm: {
            id: null,
            judul: '',
            ringkasan: '',
            gambar_sampul: '',
            isi_konten: '',
            status_publikasi: 'published',
            tgl_publikasi: ''
        },

        showDeleteModal: false,
        deleteActionUrl: '',
        deleteItemName: '',

        // Media Picker
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
            const el = document.getElementById('editorPengumumanKonten');
            if (el && !this.quillKonten) {
                this.quillKonten = new Quill(el, {
                    theme: 'snow',
                    placeholder: 'Tuliskan isi surat edaran / pengumuman resmi di sini...',
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
                if (this.pengumumanForm.isi_konten) {
                    this.quillKonten.root.innerHTML = this.pengumumanForm.isi_konten;
                }
            }
        },

        setTab(tab) {
            this.activeTab = tab;
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);
            window.history.pushState({}, '', url);

            if (tab === 'form_pengumuman') {
                this.$nextTick(() => {
                    this.initQuill();
                });
            }
        },

        openFormPengumuman() {
            this.resetFormPengumuman();
            this.setTab('form_pengumuman');
        },

        editPengumuman(item) {
            this.pengumumanForm = {
                id: item.id,
                judul: item.judul || '',
                ringkasan: item.ringkasan || '',
                gambar_sampul: item.gambar_sampul || '',
                isi_konten: item.isi_konten || '',
                status_publikasi: item.status_publikasi || 'published',
                tgl_publikasi: item.tgl_publikasi ? item.tgl_publikasi.substring(0, 16) : ''
            };
            this.setTab('form_pengumuman');
            this.$nextTick(() => {
                this.initQuill();
                if (this.quillKonten) {
                    this.quillKonten.root.innerHTML = item.isi_konten || '';
                }
            });
        },

        resetFormPengumuman() {
            this.pengumumanForm = {
                id: null,
                judul: '',
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

        preparePengumumanSubmit(e) {
            const hidden = document.getElementById('hiddenIsiKontenPengumuman');
            if (this.quillKonten && hidden) {
                hidden.value = this.quillKonten.root.innerHTML;
            }
        },

        confirmDelete(id, name) {
            this.deleteItemName = name;
            this.deleteActionUrl = `{{ url(app('tenant')->slug . '/admin/informasi/pengumuman') }}/${id}`;
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
                    this.toastMessage = 'Status pengumuman berhasil diperbarui.';
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

        // Media Picker
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
            if (this.pickerTarget === 'pengumuman_lampiran') {
                this.pengumumanForm.gambar_sampul = url;
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
            formData.append('kategori', 'pengumuman');
            formData.append('keterangan', 'Unggahan dari Form Pengumuman');

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
                        kategori: 'pengumuman',
                        keterangan: 'Impor URL dari Form Pengumuman'
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
