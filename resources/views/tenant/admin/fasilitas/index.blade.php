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
             toggleStatus: @js(route('tenant.admin.informasi.toggle-status', ['tenant' => app('tenant')->slug])),
             storeFasilitas: @js(route('tenant.admin.informasi.fasilitas.store', ['tenant' => app('tenant')->slug]))
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
                <button type="button" @click="activeTab = 'fasilitas'"
                        :class="activeTab === 'fasilitas' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    1. Daftar Sarana &amp; Fasilitas
                </button>

                <button type="button" @click="activeTab = 'form'"
                        :class="activeTab === 'form' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span x-text="editMode ? 'Edit: ' + (formNamaFasilitas ? formNamaFasilitas.substring(0,18) + '...' : 'Fasilitas') : '2. Tambah Fasilitas'"></span>
                </button>

                <button type="button" @click="activeTab = 'stats'"
                        :class="activeTab === 'stats' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    3. Statistik Sarpras
                </button>
            </div>

            <!-- Sticky Right Actions -->
            <div class="flex items-center gap-2 shrink-0">
                <template x-if="activeTab === 'fasilitas'">
                    <div class="flex items-center gap-2">
                        <button type="button" @click="tambahFasilitasBaru()" 
                                class="admin-btn-create">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Tambah Fasilitas</span>
                        </button>
                        <button type="button" @click="submitActiveForm('form-fasilitas-hero')" :disabled="submitLoading"
                                class="admin-btn-save bg-slate-800 hover:bg-slate-900">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Hero'"></span>
                        </button>
                    </div>
                </template>

                <template x-if="activeTab === 'form'">
                    <div class="flex items-center gap-2">
                        <template x-if="editMode">
                            <button type="button" @click="tambahFasilitasBaru()" 
                                    class="px-3 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold rounded-xl transition flex items-center gap-1 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>[+] Tambah Baru</span>
                            </button>
                        </template>
                        <button type="button" @click="activeTab = 'fasilitas'" 
                                class="admin-btn-cancel text-xs">
                            Batal
                        </button>
                        <button type="button" @click="submitActiveForm('form-fasilitas-main')" :disabled="submitLoading"
                                class="admin-btn-save">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="submitLoading ? 'Menyimpan...' : (editMode ? 'Perbarui Fasilitas' : 'Simpan Fasilitas')"></span>
                        </button>
                    </div>
                </template>

                <template x-if="activeTab === 'stats'">
                    <div class="flex items-center gap-2">
                        <button type="button" @click="submitActiveForm('form-fasilitas-stats')" :disabled="submitLoading"
                                class="admin-btn-save">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Statistik'"></span>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- TAB CONTENTS -->
    @include('tenant.admin.fasilitas.tabs.tab-fasilitas')
    @include('tenant.admin.fasilitas.tabs.tab-form')
    @include('tenant.admin.fasilitas.tabs.tab-stats')

    <!-- MODALS & PICKER -->
    @include('tenant.admin.fasilitas.tabs.modals')

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('fasilitasManager', (config) => ({
        activeTab: config.activeTab,
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
        hapusActionUrl: '',

        // Form Fasilitas State
        editMode: false,
        formFasilitasActionUrl: (config.routes && config.routes.storeFasilitas) ? config.routes.storeFasilitas : '',
        formNamaFasilitas: '',
        formDeskripsiFasilitas: '',
        formFotoUtama: '',
        formIsAktif: true,
        existingFotoList: [],
        fotoTambahanBaru: [],

        targetMediaField: null,
        activeRepeaterIndex: null,

        // Media Picker State (Sinkron dengan picker-modal.blade.php)
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

        init() {
            if (this.toastText) {
                this.showToast = true;
                setTimeout(() => { this.showToast = false; }, 4000);
            }
        },

        tambahFasilitasBaru() {
            this.editMode = false;
            this.formFasilitasActionUrl = (config.routes && config.routes.storeFasilitas) ? config.routes.storeFasilitas : '';
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
            const baseUrl = (config.routes && config.routes.storeFasilitas) ? config.routes.storeFasilitas : '';
            this.formFasilitasActionUrl = `${baseUrl}/${fasilitas.id}`;
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
                const baseUrl = (config.routes && config.routes.storeFasilitas) ? config.routes.storeFasilitas : '';
                form.action = `${baseUrl}/foto/${fotoId}`;
                form.submit();
            }
        },

        konfirmasiHapusFasilitas(id, nama) {
            this.hapusNama = nama;
            const baseUrl = (config.routes && config.routes.storeFasilitas) ? config.routes.storeFasilitas : '';
            this.hapusActionUrl = `${baseUrl}/${id}`;
            this.modalHapus = true;
        },

        bukaMediaPicker(targetField) {
            this.targetMediaField = targetField;
            this.openMediaPicker('', 'gambar');
        },

        bukaMediaPickerRepeater(index) {
            this.activeRepeaterIndex = index;
            this.targetMediaField = 'repeater';
            this.openMediaPicker('', 'gambar');
        },

        openMediaPicker(targetInputId = '', filterType = 'semua') {
            this.mediaPickerTargetInput = targetInputId;
            this.pickerFilterType = filterType;
            this.mediaPickerOpen = true;
            this.fetchMedia(1);
        },

        async fetchMedia(page = 1) {
            this.pickerLoading = true;
            this.pickerCurrentPage = page;
            const baseUrl = (config.routes && config.routes.mediaIndex) ? config.routes.mediaIndex : '{{ url(app("tenant")->slug . "/admin/media") }}';
            let fetchUrl = `${baseUrl}?page=${page}&per_page=${this.pickerPerPage}`;
            if (this.pickerFilterType && this.pickerFilterType !== 'semua') {
                fetchUrl += `&tipe=${this.pickerFilterType}`;
            }
            if (this.pickerSearchQuery) {
                fetchUrl += `&q=${encodeURIComponent(this.pickerSearchQuery)}`;
            }

            try {
                const res = await fetch(fetchUrl, { credentials: 'same-origin', headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
                const data = await res.json();
                if (data.data) {
                    this.mediaItems = data.data;
                    this.pickerCurrentPage = data.current_page || 1;
                    this.pickerLastPage = data.last_page || 1;
                    this.pickerTotal = data.total || 0;
                } else if (Array.isArray(data)) {
                    this.mediaItems = data;
                    this.pickerTotal = data.length;
                }
            } catch (err) {
                console.error('Gagal mengambil daftar media:', err);
            } finally {
                this.pickerLoading = false;
            }
        },

        selectMediaItem(item) {
            const fileUrl = item.file_url || item.url || item.file_path;
            if (this.targetMediaField === 'foto_utama') {
                this.formFotoUtama = fileUrl;
            } else if (this.targetMediaField === 'banner_hero') {
                this.bannerHeroPreview = fileUrl;
            } else if (this.targetMediaField === 'repeater' && this.activeRepeaterIndex !== null && this.fotoTambahanBaru[this.activeRepeaterIndex]) {
                this.fotoTambahanBaru[this.activeRepeaterIndex].url = fileUrl;
            } else if (this.mediaPickerTargetInput) {
                const el = document.getElementById(this.mediaPickerTargetInput);
                if (el) {
                    el.value = fileUrl;
                    el.dispatchEvent(new Event('input'));
                }
            }
            this.mediaPickerOpen = false;
        },

        async uploadNewMedia(e) {
            const files = e.target.files;
            if (!files || files.length === 0) return;
            const file = files[0];
            const formData = new FormData();
            formData.append('file', file);
            formData.append('kategori', 'fasilitas');

            const tokenEl = document.querySelector('meta[name="csrf-token"]') || document.querySelector('input[name="_token"]');
            const csrfToken = tokenEl ? (tokenEl.content || tokenEl.value) : '{{ csrf_token() }}';

            this.pickerLoading = true;
            try {
                const uploadUrl = (config.routes && config.routes.mediaUpload) ? config.routes.mediaUpload : '{{ url(app("tenant")->slug . "/admin/media/upload") }}';
                const res = await fetch(uploadUrl, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData,
                    credentials: 'same-origin'
                });
                const result = await res.json();
                if (result.success || result.media) {
                    await this.fetchMedia(1);
                    if (result.media) {
                        this.selectMediaItem(result.media);
                    }
                }
            } catch (err) {
                console.error('Gagal mengunggah media baru:', err);
            } finally {
                this.pickerLoading = false;
                e.target.value = '';
            }
        },

        async submitImportUrl() {
            if (!this.pickerImportUrl) return;
            const tokenEl = document.querySelector('meta[name="csrf-token"]') || document.querySelector('input[name="_token"]');
            const csrfToken = tokenEl ? (tokenEl.content || tokenEl.value) : '{{ csrf_token() }}';

            this.pickerLoading = true;
            try {
                const importUrlEndpoint = '{{ url(app("tenant")->slug . "/admin/media/import-url") }}';
                const res = await fetch(importUrlEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ url: this.pickerImportUrl, judul: this.pickerImportJudul }),
                    credentials: 'same-origin'
                });
                const result = await res.json();
                if (result.success && result.media) {
                    this.pickerImportUrl = '';
                    this.pickerImportJudul = '';
                    this.pickerShowImportForm = false;
                    await this.fetchMedia(1);
                    this.selectMediaItem(result.media);
                }
            } catch (err) {
                console.error('Gagal impor media URL:', err);
            } finally {
                this.pickerLoading = false;
            }
        },

        getYoutubeThumbnail(url) {
            if (!url) return '';
            const match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/);
            return match ? `https://img.youtube.com/vi/${match[1]}/mqdefault.jpg` : '';
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
