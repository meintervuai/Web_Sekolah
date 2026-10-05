@extends('layouts.tenant_admin')

@section('title', 'Manajemen Agenda & Kegiatan Sekolah')
@section('header_title', 'Agenda & Kegiatan Sekolah')

@push('styles')
<!-- Quill WYSIWYG CSS -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
<div class="max-w-7xl mx-auto space-y-6" 
     x-data="agendaManager({
         activeTab: @js(request('tab', 'agenda')),
         toastMsg: @js(session('success') ?? session('error') ?? ''),
         isError: @js(session()->has('error')),
         bannerHeroPreview: @js(old('gambar_banner', $halamanAgenda->gambar_banner ?? '')),
         isFiturAktif: @js((bool) $isFiturAktif),
         routes: {
             mediaIndex: @js(route('tenant.admin.media.index', ['tenant' => app('tenant')->slug])),
             mediaUpload: @js(route('tenant.admin.media.upload', ['tenant' => app('tenant')->slug])),
             mediaImportUrl: @js(route('tenant.admin.media.import-url', ['tenant' => app('tenant')->slug])),
             toggleStatus: @js(route('tenant.admin.informasi.toggle-status', ['tenant' => app('tenant')->slug])),
             storeAgenda: @js(route('tenant.admin.informasi.agenda.store', ['tenant' => app('tenant')->slug]))
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
                <button type="button" @click="activeTab = 'agenda'"
                        :class="activeTab === 'agenda' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    1. Daftar Agenda &amp; Kegiatan
                </button>

                <button type="button" @click="activeTab = 'form'"
                        :class="activeTab === 'form' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span x-text="editMode ? '2. Edit Agenda: ' + (formJudul ? formJudul.substring(0,25) + '...' : '') : '2. Jadwalkan Agenda Baru'"></span>
                </button>
            </div>

            <!-- Sticky Right Actions -->
            <div class="flex items-center gap-2 shrink-0">
                <template x-if="activeTab === 'agenda'">
                    <div class="flex items-center gap-2">
                        <button type="button" @click="tambahAgendaBaru()" 
                                class="admin-btn-create">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Jadwalkan Agenda</span>
                        </button>
                        <button type="button" @click="submitActiveForm('form-agenda-hero')" :disabled="isSubmitting"
                                class="admin-btn-save bg-slate-800 hover:bg-slate-900">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="isSubmitting ? 'Menyimpan...' : 'Simpan Hero'"></span>
                        </button>
                    </div>
                </template>

                <template x-if="activeTab === 'form'">
                    <div class="flex items-center gap-2">
                        <template x-if="editMode">
                            <button type="button" @click="tambahAgendaBaru()" 
                                    class="px-3 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold rounded-xl transition flex items-center gap-1 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>[+] Jadwal Baru</span>
                            </button>
                        </template>
                        <button type="button" @click="activeTab = 'agenda'" 
                                class="admin-btn-cancel text-xs">
                            Batal
                        </button>
                        <button type="button" @click="submitActiveForm('form-agenda-main')" :disabled="isSubmitting"
                                class="admin-btn-save">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="isSubmitting ? 'Menyimpan...' : (editMode ? 'Perbarui Agenda' : 'Simpan Agenda')"></span>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         TAB 1: DAFTAR AGENDA & KEGIATAN & HERO BANNER
    ========================================================================== -->
    <div x-show="activeTab === 'agenda'" x-cloak class="space-y-6">
        <!-- Pengaturan Hero Banner Agenda Publik -->
        <form id="form-agenda-hero" action="{{ route('tenant.admin.informasi.hero', ['tenant' => app('tenant')->slug, 'modul' => 'agenda']) }}" method="POST" @submit="isSubmitting = true">
            @csrf
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
                <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Kustomisasi Hero Banner Halaman Agenda
                        </h2>
                        <p class="text-xs text-slate-500">Atur judul pengantar, subjudul motivasional, dan gambar latar artistik pada bagian atas halaman agenda publik.</p>
                    </div>
                    <a href="{{ url(app('tenant')->slug . '/agenda') }}" target="_blank" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 shrink-0">
                        <span>Lihat Kalender Publik</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Judul Utama Hero Banner <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul', $halamanAgenda->judul) }}" required 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Subjudul / Narasi Hero Banner
                        </label>
                        <textarea name="subjudul" rows="2" 
                                  class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">{{ old('subjudul', $halamanAgenda->subjudul) }}</textarea>
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
                                   id="input_banner_hero_agenda"
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
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Daftar Agenda &amp; Kegiatan Sekolah
                    </h2>
                    <p class="text-xs text-slate-500">Kelola jadwal asesmen akademik, workshop kejuruan, ujian kompetensi, dan kegiatan resmi sekolah.</p>
                </div>
                <div class="flex items-center gap-2 self-start sm:self-auto">
                    <a href="{{ url(app('tenant')->slug . '/agenda') }}" target="_blank" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Lihat Kalender Publik
                    </a>
                    <button type="button" @click="tambahAgendaBaru()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Jadwalkan Agenda Baru
                    </button>
                </div>
            </div>

            <!-- Search & Filter Bar with View Mode Toggle -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-1">
                <form action="{{ route('tenant.admin.informasi.agenda', ['tenant' => app('tenant')->slug]) }}" method="GET" class="flex-1 flex flex-col sm:flex-row items-center gap-3 w-full">
                    <input type="hidden" name="tab" value="agenda">
                    <div class="relative flex-1 w-full">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul, lokasi, atau penyelenggara agenda..." 
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button type="submit" class="w-full sm:w-auto px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer">
                            Cari
                        </button>
                        @if(request()->filled('q'))
                            <a href="{{ route('tenant.admin.informasi.agenda', ['tenant' => app('tenant')->slug, 'tab' => 'agenda']) }}" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Switcher Toggle Grid vs List -->
                <div class="flex items-center p-0.5 bg-slate-100 rounded-xl border border-slate-200 shrink-0 self-end sm:self-center">
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

            <!-- TAMPILAN 1: Table Card -->
            <div x-show="viewMode === 'list'" class="overflow-x-auto border border-slate-200 rounded-xl">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4 w-12 text-center">No</th>
                            <th class="py-3 px-4">Agenda &amp; Penyelenggara</th>
                            <th class="py-3 px-4">Jadwal &amp; Waktu</th>
                            <th class="py-3 px-4">Lokasi &amp; Tautan</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($agendaList as $idx => $agenda)
                        @php
                            $tglM = \Carbon\Carbon::parse($agenda->tgl_mulai);
                            $isUpcoming = $tglM->isFuture() || $tglM->isToday();
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 px-4 text-center text-slate-400 font-medium">
                                {{ $agendaList->firstItem() + $idx }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-start space-x-3">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 shrink-0 overflow-hidden border border-slate-200 flex items-center justify-center">
                                        @if($agenda->gambar_sampul)
                                            <img src="{{ $agenda->gambar_sampul }}" alt="{{ $agenda->judul }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="text-center font-heading text-sky-700">
                                                <span class="text-[9px] uppercase font-bold block">{{ $tglM->translatedFormat('M') }}</span>
                                                <span class="text-sm font-extrabold leading-none">{{ $tglM->translatedFormat('d') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-slate-900 text-xs hover:text-blue-600 line-clamp-1">
                                            <a href="{{ url(app('tenant')->slug . '/agenda/' . $agenda->slug) }}" target="_blank">
                                                {{ $agenda->judul }}
                                            </a>
                                        </h4>
                                        <div class="flex items-center space-x-2 mt-1 text-[11px] text-slate-500">
                                            <span>Oleh: <strong>{{ $agenda->penyelenggara ?? 'Sekolah' }}</strong></span>
                                            <span>•</span>
                                            <span>{{ $agenda->pengguna ? $agenda->pengguna->name : 'Admin' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                <div class="font-semibold text-slate-800 text-xs">
                                    {{ $tglM->translatedFormat('d M Y') }}
                                    @if($agenda->tgl_selesai && $agenda->tgl_selesai != $agenda->tgl_mulai)
                                        <span class="text-[11px] text-slate-500 block font-normal">s/d {{ \Carbon\Carbon::parse($agenda->tgl_selesai)->translatedFormat('d M Y') }}</span>
                                    @endif
                                </div>
                                <span class="text-[11px] text-slate-500 block mt-0.5">
                                    {{ $agenda->jam_mulai ? substr($agenda->jam_mulai, 0, 5) . ($agenda->jam_selesai ? ' - ' . substr($agenda->jam_selesai, 0, 5) . ' WIB' : ' WIB') : 'Jadwal Ditentukan' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-medium text-slate-700 block truncate max-w-xs">{{ $agenda->lokasi ?? 'Kampus Sekolah' }}</span>
                                @if($agenda->link_pendaftaran)
                                    <a href="{{ $agenda->link_pendaftaran }}" target="_blank" class="inline-flex items-center text-[11px] text-blue-600 hover:underline mt-0.5 font-semibold">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        Formulir Daftar
                                    </a>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center whitespace-nowrap">
                                @if($isUpcoming)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        Mendatang
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                        Selesai
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <button type="button" 
                                            @click="editAgendaItem(@js($agenda))" 
                                            class="p-1.5 rounded-lg text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition cursor-pointer" 
                                            title="Edit Agenda">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button type="button" 
                                            @click="konfirmasiHapusAgenda(@js($agenda->id), @js($agenda->judul))" 
                                            class="p-1.5 rounded-lg text-slate-600 hover:bg-rose-50 hover:text-rose-600 transition cursor-pointer" 
                                            title="Hapus Agenda">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-400">
                                <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-xs font-semibold text-slate-600">Belum ada agenda atau kegiatan yang dijadwalkan.</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">Klik tombol "Jadwalkan Agenda Baru" untuk menambahkan kegiatan pertama.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- TAMPILAN 2: Grid Card Cards -->
            <div x-show="viewMode === 'grid'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse($agendaList as $agenda)
                    @php
                        $tglM = \Carbon\Carbon::parse($agenda->tgl_mulai);
                        $isUpcoming = $tglM->isFuture() || $tglM->isToday();
                    @endphp
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden flex flex-col justify-between group hover:border-slate-300 hover:shadow-xs transition duration-200">
                        <div>
                            <!-- Cover Image Header -->
                            <div class="relative bg-slate-900 aspect-16/9 overflow-hidden flex items-center justify-center">
                                @if($agenda->gambar_sampul)
                                    <img src="{{ $agenda->gambar_sampul }}" alt="" aria-hidden="true" class="absolute inset-0 w-full h-full object-cover blur-md scale-125 opacity-40 pointer-events-none z-0">
                                    <img src="{{ $agenda->gambar_sampul }}" alt="{{ $agenda->judul }}" loading="lazy" class="relative z-10 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center bg-sky-900 text-white">
                                        <span class="text-xs uppercase font-bold tracking-wider text-sky-300">{{ $tglM->translatedFormat('F Y') }}</span>
                                        <span class="text-2xl font-black">{{ $tglM->translatedFormat('d') }}</span>
                                    </div>
                                @endif

                                <div class="absolute top-2 left-2 z-20">
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-black/60 backdrop-blur-xs text-white border border-white/20">
                                        {{ $tglM->translatedFormat('d M Y') }}
                                    </span>
                                </div>
                                <div class="absolute top-2 right-2 z-20">
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold backdrop-blur-xs {{ $isUpcoming ? 'bg-emerald-600/90 text-white' : 'bg-slate-700/90 text-white' }}">
                                        {{ $isUpcoming ? 'Mendatang' : 'Selesai' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Body -->
                            <div class="p-3.5 space-y-2">
                                <h3 class="font-bold text-xs text-slate-900 line-clamp-2 leading-snug group-hover:text-blue-600 transition" title="{{ $agenda->judul }}">
                                    {{ $agenda->judul }}
                                </h3>
                                <div class="text-[11px] text-slate-500 space-y-1">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>{{ $agenda->jam_mulai ? substr($agenda->jam_mulai, 0, 5) : '00:00' }} WIB</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span class="truncate">{{ $agenda->lokasi ?? 'Kampus Sekolah' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Actions -->
                        <div class="px-3.5 py-2 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between gap-1">
                            <a href="{{ url(app('tenant')->slug . '/agenda/' . $agenda->slug) }}" target="_blank" 
                               class="text-[11px] font-semibold text-slate-600 hover:text-blue-600 flex items-center gap-1 transition"
                               title="Lihat Halaman Publik">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                <span>Lihat</span>
                            </a>
                            <div class="flex items-center gap-1">
                                <button type="button" @click="editAgendaItem({{ Js::from($agenda) }})" 
                                        class="p-1 rounded-lg hover:bg-blue-50 text-slate-600 hover:text-blue-600 transition cursor-pointer"
                                        title="Edit Agenda">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>
                                <button type="button" @click="konfirmasiHapusAgenda({{ Js::from($agenda->id) }}, {{ Js::from($agenda->judul) }})" 
                                        class="p-1 rounded-lg hover:bg-rose-50 text-slate-600 hover:text-rose-600 transition cursor-pointer"
                                        title="Hapus Agenda">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-8 text-center text-slate-400">
                        Belum ada agenda kegiatan yang terdaftar.
                    </div>
                @endforelse
            </div>

            @if($agendaList->hasPages())
                <div class="pt-2">
                    {{ $agendaList->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- =========================================================================
         TAB 2: FORM TAMBAH / EDIT AGENDA
    ========================================================================== -->
    <div x-show="activeTab === 'form'" x-cloak class="space-y-6">
        <form id="form-agenda-main" :action="formActionUrl" method="POST" @submit="submitAgendaForm($event)">
            @csrf
            <template x-if="editMode">
                <input type="hidden" name="_method" value="PUT">
            </template>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Left Column: Primary Fields (8 cols) -->
                <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <div>
                            <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                <span x-text="editMode ? 'Edit Informasi Agenda Kegiatan' : 'Formulir Agenda & Kegiatan Baru'"></span>
                            </h2>
                            <p class="text-xs text-slate-500">Lengkapi formulir di bawah ini untuk menampilkan agenda resmi di kalender publik.</p>
                        </div>
                        <button type="button" @click="activeTab = 'agenda'" class="text-xs font-semibold text-slate-500 hover:text-slate-800">
                            &larr; Batal &amp; Kembali
                        </button>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Judul Agenda Kegiatan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               name="judul" 
                               x-model="formJudul" 
                               required 
                               placeholder="Contoh: Workshop Asesmen Teaching Factory Bersama Mitra Industri" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Tanggal Mulai Pelaksanaan <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" 
                                   name="tgl_mulai" 
                                   x-model="formTglMulai" 
                                   required 
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Tanggal Selesai (Opsional)
                            </label>
                            <input type="date" 
                                   name="tgl_selesai" 
                                   x-model="formTglSelesai" 
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Jam Mulai (Pukul)
                            </label>
                            <input type="text" 
                                   name="jam_mulai" 
                                   x-model="formJamMulai" 
                                   placeholder="Contoh: 08:00" 
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Jam Selesai (Pukul)
                            </label>
                            <input type="text" 
                                   name="jam_selesai" 
                                   x-model="formJamSelesai" 
                                   placeholder="Contoh: 15:30" 
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Tempat / Lokasi Kegiatan
                            </label>
                            <input type="text" 
                                   name="lokasi" 
                                   x-model="formLokasi" 
                                   placeholder="Contoh: Aula Graha Utama SMKN 2 Bandung" 
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Penyelenggara / Panitia
                            </label>
                            <input type="text" 
                                   name="penyelenggara" 
                                   x-model="formPenyelenggara" 
                                   placeholder="Contoh: Pokja Humas & Hubin" 
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Ringkasan Singkat (Lead Highlight)
                        </label>
                        <textarea name="ringkasan" 
                                  x-model="formRingkasan" 
                                  rows="2" 
                                  placeholder="Ringkasan 1-2 kalimat pengantar agenda yang tampil di kartu kalender..." 
                                  class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"></textarea>
                    </div>

                    <!-- WYSIWYG Editor Deskripsi Lengkap -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Rincian &amp; Deskripsi Lengkap Agenda
                        </label>
                        <div id="editor-agenda" class="bg-white"></div>
                        <input type="hidden" name="deskripsi_lengkap" id="input-deskripsi-lengkap" x-model="formDeskripsiLengkap">
                    </div>
                </div>

                <!-- Right Column: Media, Link & Publish (4 cols) -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
                        <div class="border-b border-slate-100 pb-3">
                            <h3 class="text-sm font-bold text-slate-900 font-heading">Media &amp; Publikasi</h3>
                            <p class="text-xs text-slate-500">Sampul poster &amp; tautan pendaftaran</p>
                        </div>

                        <!-- Poster / Sampul Agenda -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Poster / Sampul Agenda
                            </label>
                            <div class="aspect-16/10 rounded-xl overflow-hidden bg-slate-50 border border-slate-200 flex items-center justify-center relative mb-2">
                                <template x-if="formGambarSampul">
                                    <img :src="formGambarSampul" alt="Sampul" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!formGambarSampul">
                                    <div class="text-center p-4 text-slate-400">
                                        <svg class="w-8 h-8 mx-auto mb-1 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span class="text-[10px]">Belum ada gambar sampul</span>
                                    </div>
                                </template>
                            </div>

                            <div class="flex gap-2 items-center">
                                <input type="text" 
                                       name="gambar_sampul" 
                                       id="input_sampul_agenda"
                                       x-model="formGambarSampul" 
                                       placeholder="https://... atau pilih media" 
                                       class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                                
                                <button type="button" 
                                        @click="bukaMediaPicker('sampul_agenda')" 
                                        class="px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Pilih Media
                                </button>
                            </div>
                        </div>

                        <!-- Tautan Pendaftaran -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Tautan Pendaftaran / Konfirmasi Daring
                            </label>
                            <input type="url" 
                                   name="link_pendaftaran" 
                                   x-model="formLinkPendaftaran" 
                                   placeholder="https://forms.gle/... atau tautan konfirmasi" 
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                            <span class="text-[10px] text-slate-400 mt-1 block">Tombol pendaftaran daring otomatis tampil di halaman detail jika diisi.</span>
                        </div>

                        <!-- Status Aktif / Visibilitas -->
                        <div class="pt-2 border-t border-slate-100">
                            <label class="flex items-center gap-2.5 cursor-pointer">
                                <input type="checkbox" name="is_aktif" value="1" x-model="formIsAktif" class="w-4 h-4 text-blue-600 rounded-sm border-slate-300 focus:ring-blue-500">
                                <div>
                                    <span class="text-xs font-bold text-slate-800 block">Tampilkan di Kalender Publik</span>
                                    <span class="text-[10px] text-slate-400 block">Nonaktifkan jika masih berstatus draf internal</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>



    <!-- MODAL KONFIRMASI HAPUS AGENDA -->
    <div x-show="modalHapus" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-5 space-y-4 border border-slate-200"
             @click.outside="modalHapus = false">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-slate-900 font-heading">Hapus Agenda Kegiatan?</h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Anda akan menghapus <strong class="text-slate-800" x-text="hapusJudul"></strong>. Aksi ini permanen.
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
    </div>v>

    <!-- Reusable Media Picker Component -->
    @include('tenant.admin.media.picker-modal')

</div>
@endsection

@push('scripts')
<!-- Quill WYSIWYG JS -->
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('agendaManager', (config) => ({
        activeTab: config.activeTab,
        showToast: false,
        toastText: config.toastMsg,
        isToastError: config.isError,
        viewMode: 'list',
        bannerHeroPreview: config.bannerHeroPreview,
        isFiturAktif: config.isFiturAktif,
        isToggling: false,
        isSubmitting: false,

        // Modal hapus
        modalHapus: false,
        hapusJudul: '',
        hapusActionUrl: '',

        // Form Agenda State
        editMode: false,
        formActionUrl: (config.routes && config.routes.storeAgenda) ? config.routes.storeAgenda : '',
        formJudul: '',
        formTglMulai: '',
        formTglSelesai: '',
        formJamMulai: '',
        formJamSelesai: '',
        formLokasi: '',
        formPenyelenggara: '',
        formRingkasan: '',
        formDeskripsiLengkap: '',
        formGambarSampul: '',
        formLinkPendaftaran: '',
        formIsAktif: true,

        // Quill Instance
        quillInstance: null,
        targetMediaField: null,

        init() {
            if (this.toastText) {
                this.showToast = true;
                setTimeout(() => { this.showToast = false; }, 4000);
            }

            this.$nextTick(() => {
                this.initQuill();
            });
        },

        initQuill() {
            const editorEl = document.getElementById('editor-agenda');
            if (editorEl && !this.quillInstance) {
                this.quillInstance = new Quill(editorEl, {
                    theme: 'snow',
                    placeholder: 'Tuliskan deskripsi lengkap, rincian susunan acara, pemateri, atau persyaratan peserta...',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['blockquote', 'link'],
                            ['clean']
                        ]
                    }
                });

                if (this.formDeskripsiLengkap) {
                    this.quillInstance.root.innerHTML = this.formDeskripsiLengkap;
                }
            }
        },

        tambahAgendaBaru() {
            this.editMode = false;
            this.formActionUrl = (config.routes && config.routes.storeAgenda) ? config.routes.storeAgenda : '';
            this.formJudul = '';
            this.formTglMulai = new Date().toISOString().split('T')[0];
            this.formTglSelesai = '';
            this.formJamMulai = '08:00';
            this.formJamSelesai = '15:00';
            this.formLokasi = 'Kampus SMKN 2 Bandung';
            this.formPenyelenggara = 'SMK Negeri 2 Bandung';
            this.formRingkasan = '';
            this.formDeskripsiLengkap = '';
            this.formGambarSampul = '';
            this.formLinkPendaftaran = '';
            this.formIsAktif = true;

            if (this.quillInstance) {
                this.quillInstance.root.innerHTML = '';
            }

            this.activeTab = 'form';
        },

        editAgendaItem(agenda) {
            this.editMode = true;
            const baseUrl = (config.routes && config.routes.storeAgenda) ? config.routes.storeAgenda : '';
            this.formActionUrl = `${baseUrl}/${agenda.id}`;
            this.formJudul = agenda.judul;
            this.formTglMulai = agenda.tgl_mulai ? agenda.tgl_mulai.substring(0, 10) : '';
            this.formTglSelesai = agenda.tgl_selesai ? agenda.tgl_selesai.substring(0, 10) : '';
            this.formJamMulai = agenda.jam_mulai ? agenda.jam_mulai.substring(0, 5) : '';
            this.formJamSelesai = agenda.jam_selesai ? agenda.jam_selesai.substring(0, 5) : '';
            this.formLokasi = agenda.lokasi || '';
            this.formPenyelenggara = agenda.penyelenggara || '';
            this.formRingkasan = agenda.ringkasan || '';
            this.formDeskripsiLengkap = agenda.deskripsi_lengkap || '';
            this.formGambarSampul = agenda.gambar_sampul || '';
            this.formLinkPendaftaran = agenda.link_pendaftaran || '';
            this.formIsAktif = agenda.is_aktif ? true : false;

            if (this.quillInstance) {
                this.quillInstance.root.innerHTML = this.formDeskripsiLengkap;
            }

            this.activeTab = 'form';
        },

        submitActiveForm(formId) {
            const form = document.getElementById(formId);
            if (!form) return;

            if (formId === 'form-agenda-main') {
                if (this.quillInstance) {
                    this.formDeskripsiLengkap = this.quillInstance.root.innerHTML;
                    const el = document.getElementById('input-deskripsi-lengkap');
                    if (el) el.value = this.formDeskripsiLengkap;
                }
            }

            if (form.reportValidity && !form.reportValidity()) {
                return;
            }

            this.isSubmitting = true;
            if (form.requestSubmit) {
                form.requestSubmit();
            } else {
                form.submit();
            }
        },

        submitAgendaForm(event) {
            if (this.quillInstance) {
                this.formDeskripsiLengkap = this.quillInstance.root.innerHTML;
                const el = document.getElementById('input-deskripsi-lengkap');
                if (el) el.value = this.formDeskripsiLengkap;
            }
            this.isSubmitting = true;
        },

        konfirmasiHapusAgenda(id, judul) {
            this.hapusJudul = judul;
            const baseUrl = (config.routes && config.routes.storeAgenda) ? config.routes.storeAgenda : '';
            this.hapusActionUrl = `${baseUrl}/${id}`;
            this.modalHapus = true;
        },

        bukaMediaPicker(targetField) {
            this.targetMediaField = targetField;
            window.dispatchEvent(new CustomEvent('open-media-picker', {
                detail: {
                    onSelect: (mediaItem) => {
                        const fileUrl = mediaItem.url || mediaItem.file_url || mediaItem.file_path;
                        if (this.targetMediaField === 'sampul_agenda') {
                            this.formGambarSampul = fileUrl;
                        } else if (this.targetMediaField === 'banner_hero') {
                            this.bannerHeroPreview = fileUrl;
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
