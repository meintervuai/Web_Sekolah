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

    <!-- Sub-tabs -->
    @include('tenant.admin.berita.tabs.tab-berita')
    @include('tenant.admin.berita.tabs.tab-form')
    @include('tenant.admin.berita.tabs.tab-kategori')
    @include('tenant.admin.berita.tabs.modals')

</div>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
function beritaManager(config) {
    return {
        activeTab: config.activeTab || 'berita',
        viewMode: 'list',
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

        // Media Picker Methods (Sinkron dengan picker-modal.blade.php)
        openMediaPicker(targetInputId, defaultType = 'semua') {
            this.mediaPickerTargetInput = targetInputId;
            this.pickerFilterType = defaultType;
            this.pickerCurrentPage = 1;
            this.mediaPickerOpen = true;
            this.fetchMedia(1);
        },

        getYoutubeThumbnail(url) {
            if (!url) return null;
            const regExp = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i;
            const match = url.match(regExp);
            return match && match[1] ? `https://img.youtube.com/vi/${match[1]}/hqdefault.jpg` : null;
        },

        async fetchMedia(page = 1) {
            this.pickerLoading = true;
            this.pickerCurrentPage = page;
            try {
                const params = new URLSearchParams({
                    tipe: this.pickerFilterType,
                    q: this.pickerSearchQuery,
                    page: page,
                    per_page: this.pickerPerPage
                });
                const url = this.routes && this.routes.mediaIndex ? this.routes.mediaIndex : '/admin/media';
                const res = await fetch(`${url}?${params}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await res.json();
                this.mediaItems = data.data || [];
                this.pickerCurrentPage = data.current_page || 1;
                this.pickerLastPage = data.last_page || 1;
                this.pickerTotal = data.total || 0;
            } catch (e) {
                console.error(e);
            } finally {
                this.pickerLoading = false;
            }
        },

        selectMediaItem(item) {
            if (this.mediaPickerTargetInput) {
                const input = document.getElementById(this.mediaPickerTargetInput);
                if (input) {
                    input.value = item.url;
                    input.dispatchEvent(new Event('input'));
                }
                if (this.mediaPickerTargetInput === 'input_banner_berita') {
                    this.bannerHeroPreview = item.url;
                } else if (this.mediaPickerTargetInput === 'input_sampul_berita' || this.mediaPickerTargetInput === 'berita_sampul') {
                    this.beritaForm.gambar_sampul = item.url;
                }
            }
            this.mediaPickerOpen = false;
        },

        async uploadNewMedia(event) {
            const fileInput = event.target;
            const file = fileInput.files ? fileInput.files[0] : null;
            if (!file) return;

            const formData = new FormData();
            formData.append('file', file);
            formData.append('kategori', 'berita');
            formData.append('judul', file.name.replace(/\.[^/.]+$/, ''));

            this.pickerLoading = true;
            try {
                const csrf = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '{{ csrf_token() }}';
                const url = this.routes && this.routes.mediaUpload ? this.routes.mediaUpload : '/admin/media/upload';
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                if (res.status === 413) {
                    alert('Ukuran berkas terlalu besar.');
                    return;
                }

                let result = {};
                try {
                    result = await res.json();
                } catch (err) {
                    result = {};
                }

                if (res.ok && result.sukses && result.data) {
                    await this.fetchMedia(1);
                    this.selectMediaItem(result.data);
                } else {
                    const errMsg = result.pesan || result.message || (result.errors ? Object.values(result.errors).flat().join(' ') : 'Gagal mengunggah berkas.');
                    alert(errMsg);
                }
            } catch (err) {
                alert('Gagal mengunggah berkas.');
            } finally {
                fileInput.value = '';
                this.pickerLoading = false;
            }
        },

        async submitImportUrl() {
            if (!this.pickerImportUrl) return;

            this.pickerLoading = true;
            try {
                const csrf = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '{{ csrf_token() }}';
                const url = this.routes && this.routes.mediaImportUrl ? this.routes.mediaImportUrl : '/admin/media/import-url';
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        url: this.pickerImportUrl,
                        judul: this.pickerImportJudul || null,
                        kategori: 'berita'
                    })
                });

                let result = {};
                try {
                    result = await res.json();
                } catch (err) {
                    result = {};
                }

                if (res.ok && result.sukses && result.data) {
                    this.pickerShowImportForm = false;
                    this.pickerImportUrl = '';
                    this.pickerImportJudul = '';
                    await this.fetchMedia(1);
                    this.selectMediaItem(result.data);
                } else {
                    const errMsg = result.pesan || result.message || (result.errors ? Object.values(result.errors).flat().join(' ') : 'Gagal mengimpor media dari URL.');
                    alert(errMsg);
                }
            } catch (e) {
                alert('Gagal mengimpor media dari URL.');
            } finally {
                this.pickerLoading = false;
            }
        }
    };
}
</script>
@endpush
