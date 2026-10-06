@extends('layouts.tenant_admin')

@section('title', 'Pengaturan SPMB & Penerimaan Peserta Didik Baru')
@section('header_title', 'SPMB / PPDB Sekolah')

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
<div class="max-w-7xl mx-auto space-y-6"
     x-data="spmbManager({
         activeTab: @js(request('tab', 'hero')),
         toastMsg: @js(session('success') ?? ''),
         bannerHeroPreview: @js(old('gambar_banner_spmb', $halamanSpmb->gambar_banner ?? '')),
         isFiturAktif: @js((bool) $isFiturAktif),
         alurList: @js($alurList),
         routes: {
             mediaIndex: @js(route('tenant.admin.media.index', ['tenant' => app('tenant')->slug])),
             mediaUpload: @js(route('tenant.admin.media.upload', ['tenant' => app('tenant')->slug])),
             mediaImportUrl: @js(route('tenant.admin.media.import-url', ['tenant' => app('tenant')->slug])),
             toggleStatus: @js(route('tenant.admin.spmb.toggle-status', ['tenant' => app('tenant')->slug]))
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
         class="fixed bottom-5 right-5 z-50 bg-emerald-600 text-white px-5 py-3.5 rounded-2xl shadow-xl flex items-center gap-3 max-w-md">
        <svg class="w-5 h-5 shrink-0 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-xs sm:text-sm font-medium" x-text="toastMessage"></span>
        <button @click="showToast = false" class="text-emerald-200 hover:text-white p-1 ml-auto">
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
            <!-- Tab Navigation Pills -->
            <div class="admin-tab-nav taildash-scrollbar">
                <button type="button" @click="setTab('hero')"
                        :class="activeTab === 'hero' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>1. Hero & Banner</span>
                </button>

                <button type="button" @click="setTab('alur')"
                        :class="activeTab === 'alur' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span>2. Alur Pendaftaran</span>
                </button>

                <button type="button" @click="setTab('syarat')"
                        :class="activeTab === 'syarat' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    <span>3. Persyaratan Dokumen</span>
                </button>

                <button type="button" @click="setTab('sidebar')"
                        :class="activeTab === 'sidebar' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    <span>4. Portal Pendaftaran</span>
                </button>
            </div>

            <!-- Sticky Right Action Buttons -->
            <div class="flex items-center gap-2 shrink-0">
                <template x-if="activeTab === 'hero'">
                    <button type="button" @click="submitActiveForm('form-spmb-hero')" :disabled="submitLoading"
                            class="admin-btn-save">
                        <template x-if="submitLoading">
                            <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <template x-if="!submitLoading">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </template>
                        <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Hero'"></span>
                    </button>
                </template>

                <template x-if="activeTab === 'alur'">
                    <div class="flex items-center gap-2">
                        <button type="button" @click="tambahAlur()" class="admin-btn-action">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Tambah Langkah</span>
                        </button>
                        <button type="button" @click="submitActiveForm('form-spmb-alur')" :disabled="submitLoading" class="admin-btn-save">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Alur'"></span>
                        </button>
                    </div>
                </template>

                <template x-if="activeTab === 'syarat'">
                    <button type="button" @click="submitActiveForm('form-spmb-syarat')" :disabled="submitLoading" class="admin-btn-save">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Persyaratan'"></span>
                    </button>
                </template>

                <template x-if="activeTab === 'sidebar'">
                    <button type="button" @click="submitActiveForm('form-spmb-sidebar')" :disabled="submitLoading" class="admin-btn-save">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Portal'"></span>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <!-- ============================= TAB 1: HERO & BANNER ============================= -->
    <div x-show="activeTab === 'hero'" x-cloak class="space-y-6">
        <form id="form-spmb-hero"
              action="{{ route('tenant.admin.spmb.hero.update', ['tenant' => app('tenant')->slug]) }}"
              method="POST" @submit="submitLoading = true" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="admin-card space-y-4">
                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-card-title">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Kustomisasi Hero Banner Halaman SPMB / PPDB
                        </h2>
                        <p class="admin-card-subtitle">Atur judul utama, deskripsi pengantar, dan gambar latar hero pada halaman publik SPMB (<code>/spmb</code>).</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="admin-form-label">Judul Utama Halaman SPMB <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul_halaman" value="{{ old('judul_halaman', $halamanSpmb->judul) }}" required
                               class="admin-form-input"
                               placeholder="Contoh: Bergabung Bersama SMK Negeri 2 Bandung">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="admin-form-label">Deskripsi Ringkas / Subjudul Pengantar Hero</label>
                        <textarea name="subjudul_halaman" rows="2"
                                  class="admin-form-input"
                                  placeholder="Deskripsi singkat yang tampil di bawah judul hero SPMB.">{{ old('subjudul_halaman', $halamanSpmb->subjudul) }}</textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="admin-form-label">Foto Banner / Sampul Hero SPMB (Pusat Media)</label>
                        <div class="flex gap-2 items-center">
                            <div class="w-16 h-10 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 relative flex items-center justify-center">
                                <template x-if="bannerHeroPreview">
                                    <img :src="bannerHeroPreview" alt="Banner SPMB Preview" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!bannerHeroPreview">
                                    <span class="text-[9px] text-slate-500 font-mono">16:9</span>
                                </template>
                            </div>
                            <input type="text" name="gambar_banner_spmb" id="input_banner_spmb"
                                   x-model="bannerHeroPreview"
                                   class="admin-form-input flex-1"
                                   placeholder="https://... atau pilih dari Pusat Berkas Media">
                            <button type="button" @click="openMediaPicker('input_banner_spmb')"
                                    class="admin-btn-action shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Pilih dari Media
                            </button>
                        </div>
                        <p class="admin-form-helper">Rasio baku 16:9 / 21:9. Tampil sebagai latar banner di bagian atas halaman publik SPMB dengan efek gradien tema.</p>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- ============================= TAB 2: ALUR PENDAFTARAN ============================= -->
    <div x-show="activeTab === 'alur'" x-cloak class="space-y-6">
        <form id="form-spmb-alur"
              action="{{ route('tenant.admin.spmb.alur.update', ['tenant' => app('tenant')->slug]) }}"
              method="POST" @submit="submitLoading = true" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="admin-card space-y-4">
                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-card-title">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Alur & Prosedur Pendaftaran PPDB
                        </h2>
                        <p class="admin-card-subtitle">Urutan langkah-langkah pendaftaran yang ditampilkan secara visual sebagai timeline di halaman publik SPMB.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <template x-for="(alur, index) in alurItems" :key="index">
                        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-3 relative group">
                            <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-xs shrink-0" x-text="index + 1"></div>
                                    <span class="text-xs font-bold text-slate-800" x-text="alur.judul || `Langkah ${index + 1}`"></span>
                                </div>
                                <button type="button" @click="hapusAlur(index)"
                                        class="text-rose-600 hover:text-rose-800 text-xs font-semibold flex items-center gap-1 cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </div>
                            <input type="hidden" :name="`alur[${index}][langkah]`" :value="index + 1">
                            <div class="grid grid-cols-1 gap-3">
                                <div>
                                    <label class="admin-form-label">Judul Langkah <span class="text-rose-500">*</span></label>
                                    <input type="text" :name="`alur[${index}][judul]`" x-model="alur.judul" required
                                           placeholder="Contoh: Registrasi Akun PPDB Online"
                                           class="admin-form-input bg-white">
                                </div>
                                <div>
                                    <label class="admin-form-label">Deskripsi Langkah <span class="text-rose-500">*</span></label>
                                    <textarea :name="`alur[${index}][deskripsi]`" x-model="alur.deskripsi" rows="2" required
                                              placeholder="Penjelasan detail mengenai langkah ini."
                                              class="admin-form-input bg-white"></textarea>
                                </div>
                            </div>
                        </div>
                    </template>

                    <template x-if="alurItems.length === 0">
                        <div class="p-6 text-center text-slate-400 text-xs border border-dashed border-slate-200 rounded-xl">
                            Belum ada langkah alur pendaftaran. Klik <strong>Tambah Langkah</strong> untuk menambahkan.
                        </div>
                    </template>
                </div>
            </div>
        </form>
    </div>

    <!-- ============================= TAB 3: PERSYARATAN BERKAS DOKUMEN (WYSIWYG) ============================= -->
    <div x-show="activeTab === 'syarat'" x-cloak class="space-y-6">
        <form id="form-spmb-syarat"
              action="{{ route('tenant.admin.spmb.syarat.update', ['tenant' => app('tenant')->slug]) }}"
              method="POST" @submit="syncEditor(); submitLoading = true" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Persyaratan & Konten Detail WYSIWYG -->
            <div class="admin-card space-y-4">
                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-card-title">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            Persyaratan Dokumen & Ketentuan Pendaftaran (WYSIWYG Editor)
                        </h2>
                        <p class="admin-card-subtitle">Kelola seluruh persyaratan dokumen umum, berkas khusus per jurusan, serta catatan penting pendaftaran calon siswa dengan format teks kaya.</p>
                    </div>
                </div>

                <textarea name="syarat_konten" id="syarat_konten_spmb" class="hidden">{!! old('syarat_konten', $spmbSyaratKonten) !!}</textarea>
                <div id="editor_spmb_syarat" class="bg-white min-h-[280px]">{!! old('syarat_konten', $spmbSyaratKonten) !!}</div>
            </div>
        </form>
    </div>

    <!-- ============================= TAB 4: PORTAL PENDAFTARAN RESMI (SIDEBAR) ============================= -->
    <div x-show="activeTab === 'sidebar'" x-cloak class="space-y-6">
        <form id="form-spmb-sidebar"
              action="{{ route('tenant.admin.spmb.sidebar.update', ['tenant' => app('tenant')->slug]) }}"
              method="POST" @submit="submitLoading = true" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Portal Pendaftaran Eksternal -->
            <div class="admin-card space-y-4">
                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-card-title">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            Portal Pendaftaran Resmi (Eksternal)
                        </h2>
                        <p class="admin-card-subtitle">Informasi dan tombol akses portal PPDB resmi yang ditampilkan di sidebar halaman SPMB publik.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="admin-form-label">Nama Portal <span class="text-rose-500">*</span></label>
                        <input type="text" name="portal_nama" value="{{ old('portal_nama', $spmbConfig['portal_nama']) }}" required
                               class="admin-form-input" placeholder="Contoh: Portal PPDB Jawa Barat">
                    </div>
                    <div>
                        <label class="admin-form-label">URL Portal <span class="text-rose-500">*</span></label>
                        <input type="url" name="portal_url" value="{{ old('portal_url', $spmbConfig['portal_url']) }}" required
                               class="admin-form-input" placeholder="https://ppdb.jabarprov.go.id">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="admin-form-label">Deskripsi Portal</label>
                        <textarea name="portal_deskripsi" rows="2" class="admin-form-input"
                                  placeholder="Keterangan singkat mengenai portal pendaftaran.">{{ old('portal_deskripsi', $spmbConfig['portal_deskripsi']) }}</textarea>
                    </div>
                    <div>
                        <label class="admin-form-label">Label Tombol Akses</label>
                        <input type="text" name="portal_tombol" value="{{ old('portal_tombol', $spmbConfig['portal_tombol']) }}"
                               class="admin-form-input" placeholder="Contoh: Akses Portal PPDB Jabar">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- MODAL INTEGRASI PUSAT MEDIA (MEDIA PICKER) -->
    @include('tenant.admin.media.picker-modal')

</div>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('spmbManager', (config) => ({
            activeTab: config.activeTab || 'hero',
            showToast: !!config.toastMsg,
            toastMessage: config.toastMsg || '',
            submitLoading: false,
            bannerHeroPreview: config.bannerHeroPreview || '',
            isFiturAktif: !!config.isFiturAktif,

            alurItems: Array.isArray(config.alurList) ? JSON.parse(JSON.stringify(config.alurList)) : [],

            // Media Picker State
            mediaPickerOpen: false,
            mediaPickerTargetInput: '',
            pickerFilterType: 'semua',
            pickerSearchQuery: '',
            pickerLoading: false,
            pickerCurrentPage: 1,
            pickerLastPage: 1,
            pickerTotal: 0,
            pickerPerPage: 12,
            mediaItems: [],
            pickerShowImportForm: false,
            pickerImportUrl: '',
            pickerImportJudul: '',

            quillEditor: null,

            init() {
                if (this.showToast) {
                    setTimeout(() => { this.showToast = false; }, 4000);
                }
                this.$watch('activeTab', (val) => {
                    if (val === 'syarat') {
                        this.$nextTick(() => this.initQuill());
                    }
                });
                if (this.activeTab === 'syarat') {
                    this.$nextTick(() => this.initQuill());
                }
            },

            initQuill() {
                const el = document.getElementById('editor_spmb_syarat');
                if (el && !this.quillEditor) {
                    this.quillEditor = new Quill('#editor_spmb_syarat', {
                        theme: 'snow',
                        placeholder: 'Tulis persyaratan dokumen pendaftaran...',
                        modules: {
                            toolbar: [
                                [{ header: [2, 3, false] }],
                                ['bold', 'italic', 'underline', 'strike'],
                                [{ list: 'ordered' }, { list: 'bullet' }],
                                ['blockquote', 'link'],
                                ['clean']
                            ]
                        }
                    });
                }
            },

            syncEditor() {
                if (this.quillEditor) {
                    const hidden = document.getElementById('syarat_konten_spmb');
                    if (hidden) {
                        hidden.value = this.quillEditor.root.innerHTML;
                    }
                }
            },

            setTab(tab) {
                this.activeTab = tab;
                const url = new URL(window.location);
                url.searchParams.set('tab', tab);
                window.history.replaceState({}, '', url);
            },

            submitActiveForm(formId) {
                this.submitLoading = true;
                const form = document.getElementById(formId);
                if (form) {
                    if (typeof form.requestSubmit === 'function') {
                        form.requestSubmit();
                    } else {
                        form.submit();
                    }
                }
            },

            // Alur CRUD
            tambahAlur() {
                this.alurItems.push({
                    langkah: this.alurItems.length + 1,
                    judul: '',
                    deskripsi: ''
                });
            },
            hapusAlur(index) { this.alurItems.splice(index, 1); },

            // Media Picker Methods
            openMediaPicker(targetInputId) {
                this.mediaPickerTargetInput = targetInputId;
                this.mediaPickerOpen = true;
                this.fetchMedia(1);
            },

            async fetchMedia(page = 1) {
                this.pickerLoading = true;
                this.pickerCurrentPage = page;
                try {
                    const params = new URLSearchParams({
                        page: page,
                        per_page: this.pickerPerPage,
                        tipe: this.pickerFilterType,
                    });
                    if (this.pickerSearchQuery) params.set('q', this.pickerSearchQuery);

                    const response = await fetch(`${config.routes.mediaIndex}?${params}`, {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const data = await response.json();
                    this.mediaItems = data.data || [];
                    this.pickerCurrentPage = data.current_page || 1;
                    this.pickerLastPage = data.last_page || 1;
                    this.pickerTotal = data.total || 0;
                } catch (e) {
                    console.error('Media fetch error:', e);
                } finally {
                    this.pickerLoading = false;
                }
            },

            selectMedia(url) {
                const input = document.getElementById(this.mediaPickerTargetInput);
                if (input) {
                    input.value = url;
                    input.dispatchEvent(new Event('input', { bubbles: true }));
                }
                this.bannerHeroPreview = (this.mediaPickerTargetInput === 'input_banner_spmb') ? url : this.bannerHeroPreview;
                this.mediaPickerOpen = false;
            },

            async importMediaUrl() {
                if (!this.pickerImportUrl) return;
                this.pickerLoading = true;
                try {
                    const formData = new FormData();
                    formData.append('url', this.pickerImportUrl);
                    formData.append('judul', this.pickerImportJudul || 'Impor Media SPMB');
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                    const response = await fetch(config.routes.mediaImportUrl, {
                        method: 'POST',
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        body: formData
                    });
                    const data = await response.json();
                    if (data.url) {
                        this.selectMedia(data.url);
                        this.pickerImportUrl = '';
                        this.pickerImportJudul = '';
                        this.pickerShowImportForm = false;
                    }
                } catch (e) {
                    console.error('Import error:', e);
                } finally {
                    this.pickerLoading = false;
                }
            },

            async uploadMediaFile(event) {
                const file = event.target.files[0];
                if (!file) return;
                this.pickerLoading = true;
                try {
                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('judul', file.name);
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                    const response = await fetch(config.routes.mediaUpload, {
                        method: 'POST',
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        body: formData
                    });
                    const data = await response.json();
                    if (data.url) {
                        this.selectMedia(data.url);
                    }
                } catch (e) {
                    console.error('Upload error:', e);
                } finally {
                    this.pickerLoading = false;
                    event.target.value = '';
                }
            },

            // Toggle SPMB Status
            async toggleFiturSpmb() {
                const newStatus = !this.isFiturAktif;
                try {
                    const formData = new FormData();
                    formData.append('is_aktif', newStatus ? '1' : '0');
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                    const response = await fetch(config.routes.toggleStatus, {
                        method: 'POST',
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        body: formData
                    });
                    const data = await response.json();
                    if (data.success) {
                        this.isFiturAktif = data.is_aktif;
                        this.toastMessage = data.message;
                        this.showToast = true;
                        setTimeout(() => { this.showToast = false; }, 4000);
                    }
                } catch (e) {
                    console.error('Toggle error:', e);
                }
            }
        }));
    });
</script>
@endpush
