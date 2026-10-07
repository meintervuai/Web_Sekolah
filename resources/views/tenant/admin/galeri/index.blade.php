@extends('layouts.tenant_admin')

@section('title', 'Manajemen Galeri Dokumentasi Foto & Video')
@section('header_title', 'Galeri & Dokumentasi Sekolah')

@section('content')
<div class="max-w-7xl mx-auto space-y-6" 
     x-data="galeriManager({
         activeTab: @js(request('tab', ($selectedAlbum ? 'items' : 'album'))),
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
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

    <!-- Sub-tabs -->
    @include('tenant.admin.galeri.tabs.tab-album')
    @include('tenant.admin.galeri.tabs.tab-items')
    @include('tenant.admin.galeri.tabs.tab-form')
    @include('tenant.admin.galeri.tabs.modals')

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
            this.formTipeAlbum = album.tipe;
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
            if (targetField === 'banner_hero') {
                this.openMediaPicker('input_banner_hero_galeri', 'gambar');
            } else if (targetField === 'cover_album') {
                this.openMediaPicker('input_cover_album', 'gambar');
            } else if (targetField === 'item_galeri') {
                this.openMediaPicker('input_file_item_galeri', 'semua');
            } else {
                this.openMediaPicker('', 'gambar');
            }
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
            if (this.targetMediaField === 'cover_album') {
                this.formCoverAlbum = fileUrl;
            } else if (this.targetMediaField === 'banner_hero') {
                this.bannerHeroPreview = fileUrl;
            } else if (this.targetMediaField === 'item_galeri') {
                this.formItemUrl = fileUrl;
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
            formData.append('kategori', 'galeri');

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
