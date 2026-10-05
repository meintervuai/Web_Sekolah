@extends('layouts.tenant_admin')

@section('title', 'Manajemen Struktur Organisasi & Guru Tenaga Kependidikan')
@section('header_title', 'Struktur Organisasi & Direktori GTK')

@section('content')
<div class="max-w-7xl mx-auto space-y-6" 
     x-data="gtkManager({
         activeTab: @js(request('tab', 'struktur')),
         toastMsg: @js(session('success') ?? ''),
         diagrams: @js($diagrams ?? []),
         bannerStrukturPreview: @js(old('gambar_banner_struktur', $halamanStruktur->gambar_banner ?? '')),
         bannerGuruPreview: @js(old('gambar_banner_guru', $halamanGuru->gambar_banner ?? '')),
         pejabatNextUrutan: @js($pejabatList->count() + 1),
         routes: {
             mediaIndex: @js(route('tenant.admin.media.index', ['tenant' => app('tenant')->slug])),
             mediaUpload: @js(route('tenant.admin.media.upload', ['tenant' => app('tenant')->slug])),
             mediaImportUrl: @js(route('tenant.admin.media.import-url', ['tenant' => app('tenant')->slug]))
         }
     })"
     x-init="init()">

    <!-- Alert / Toast Messages -->
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
                <button type="button" @click="setTab('struktur')"
                        :class="activeTab === 'struktur' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>1. Struktur Organisasi</span>
                </button>

                <button type="button" @click="setTab('guru')"
                        :class="activeTab === 'guru' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>2. Guru &amp; Tenaga Kependidikan</span>
                </button>
            </div>

            <!-- Sticky Top Action Buttons -->
            <div class="flex items-center gap-2 shrink-0">
                <template x-if="activeTab === 'struktur'">
                    <div class="flex items-center gap-2">
                        <button type="button" @click="openModalPejabat()" 
                                class="admin-btn-action">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Tambah Pejabat</span>
                        </button>
                        <button type="button" 
                                @click="submitActiveForm('form-gtk-struktur')" 
                                :disabled="submitLoading"
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
                            <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Bagan & Hero Struktur'"></span>
                        </button>
                    </div>
                </template>

                <template x-if="activeTab === 'guru'">
                    <div class="flex items-center gap-2">
                        <button type="button" @click="openModalGuru()" 
                                class="admin-btn-action">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Tambah Guru / Staf</span>
                        </button>
                        <button type="button" 
                                @click="submitActiveForm('form-gtk-guru-hero')" 
                                :disabled="submitLoading"
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
                            <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Hero Guru'"></span>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- INCLUDED TAB PARTIALS -->
    @include('tenant.admin.gtk.tabs.tab-struktur')
    @include('tenant.admin.gtk.tabs.tab-guru')

    <!-- MODALS (PEJABAT, GURU, MEDIA PICKER) -->
    @include('tenant.admin.gtk.tabs.modals')

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('gtkManager', (config) => ({
            activeTab: config.activeTab || 'struktur',
            showToast: !!config.toastMsg,
            toastMessage: config.toastMsg || '',
            submitLoading: false,
            bannerStrukturPreview: config.bannerStrukturPreview || '',
            bannerGuruPreview: config.bannerGuruPreview || '',

            // Diagram Repeater List
            diagramList: Array.isArray(config.diagrams) ? JSON.parse(JSON.stringify(config.diagrams)) : [],

            // Modals Pejabat
            modalPejabatOpen: false,
            modalDeleteOpen: false,
            deleteTargetId: null,
            deleteTargetNama: '',
            pejabatForm: {
                id: null,
                nama: '',
                jabatan: '',
                guru_id: '',
                foto: '',
                crop_style: '',
                urutan: 1
            },

            // Modals Guru & Staf
            modalGuruOpen: false,
            modalDeleteGuruOpen: false,
            deleteTargetGuruId: null,
            deleteTargetGuruNama: '',
            guruForm: {
                id: null,
                nama: '',
                nip: '',
                jenis_kelamin: 'L',
                jabatan: '',
                mata_pelajaran: '',
                foto: '',
                crop_style: '',
                status_aktif: true
            },

            // Dynamic Diagram Repeater Actions
            tambahBagan() {
                this.diagramList.push({
                    judul: '',
                    deskripsi: '',
                    gambar: ''
                });
            },

            hapusBagan(index) {
                if (this.diagramList.length <= 1) {
                    if (confirm('Hapus bagan ini?')) {
                        this.diagramList.splice(index, 1);
                    }
                } else {
                    this.diagramList.splice(index, 1);
                }
            },

            // Media Picker State & Actions
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
                    setTimeout(() => {
                        this.showToast = false;
                    }, 4000);
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

            // Media Picker Handlers
            openMediaPicker(targetInputId, defaultType = 'semua') {
                this.mediaPickerTargetInput = targetInputId;
                this.pickerFilterType = defaultType;
                this.pickerCurrentPage = 1;
                this.mediaPickerOpen = true;
                this.fetchMedia(1);
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
                    const url = config.routes && config.routes.mediaIndex ? config.routes.mediaIndex : '/admin/media';
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
                    if (this.mediaPickerTargetInput === 'input_foto_pejabat_modal') {
                        this.pejabatForm.foto = item.url;
                        this.pejabatForm.crop_style = item.smart_crop_style || '';
                    }
                    if (this.mediaPickerTargetInput === 'input_foto_guru_modal') {
                        this.guruForm.foto = item.url;
                        this.guruForm.crop_style = item.smart_crop_style || '';
                    }
                    if (this.mediaPickerTargetInput === 'input_banner_struktur') {
                        this.bannerStrukturPreview = item.url;
                    }
                    if (this.mediaPickerTargetInput === 'input_banner_guru') {
                        this.bannerGuruPreview = item.url;
                    }
                    if (this.mediaPickerTargetInput.startsWith('input_diag_')) {
                        const idx = parseInt(this.mediaPickerTargetInput.replace('input_diag_', ''));
                        if (!isNaN(idx) && this.diagramList[idx]) {
                            this.diagramList[idx].gambar = item.url;
                        }
                    }
                }
                this.mediaPickerOpen = false;
                this.triggerToast(`Media '${item.judul}' terpilih.`);
            },

            async uploadNewMedia(event) {
                const fileInput = event.target;
                const file = fileInput.files ? fileInput.files[0] : null;
                if (!file) return;

                const formData = new FormData();
                formData.append('file', file);
                formData.append('kategori', 'profil');
                formData.append('judul', file.name.replace(/\.[^/.]+$/, ''));

                this.pickerLoading = true;
                try {
                    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const url = config.routes && config.routes.mediaUpload ? config.routes.mediaUpload : '/admin/media/upload';
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
                        this.triggerToast('Ukuran berkas terlalu besar. Batas maksimal unggah di server adalah 64MB.');
                        return;
                    }

                    let result = {};
                    try {
                        result = await res.json();
                    } catch (err) {
                        result = {};
                    }

                    if (res.ok && result.sukses && result.data) {
                        await this.fetchMedia();
                        this.selectMediaItem(result.data);
                    } else {
                        const errMsg = result.pesan || result.message || (result.errors ? Object.values(result.errors).flat().join(' ') : 'Gagal mengunggah berkas.');
                        this.triggerToast(errMsg);
                    }
                } finally {
                    fileInput.value = '';
                    this.pickerLoading = false;
                }
            },

            async submitImportUrl() {
                if (!this.pickerImportUrl) return;

                this.pickerLoading = true;
                try {
                    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const url = config.routes && config.routes.mediaImportUrl ? config.routes.mediaImportUrl : '/admin/media/import-url';
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
                            kategori: 'profil'
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
                        await this.fetchMedia();
                        this.selectMediaItem(result.data);
                    } else {
                        const errMsg = result.pesan || result.message || (result.errors ? Object.values(result.errors).flat().join(' ') : 'Gagal mengimpor media dari URL.');
                        this.triggerToast(errMsg);
                    }
                } catch (e) {
                    this.triggerToast('Terjadi gangguan saat mengimpor media dari URL.');
                } finally {
                    this.pickerLoading = false;
                }
            },

            // Pejabat Modal Handlers
            openModalPejabat() {
                this.pejabatForm = {
                    id: null,
                    nama: '',
                    jabatan: '',
                    guru_id: '',
                    foto: '',
                    crop_style: '',
                    urutan: config.pejabatNextUrutan || 1
                };
                this.modalPejabatOpen = true;
            },

            editPejabat(data) {
                this.pejabatForm = {
                    id: data.id,
                    nama: data.nama,
                    jabatan: data.jabatan,
                    guru_id: data.guru_id || '',
                    foto: data.foto || '',
                    crop_style: data.crop_style || '',
                    urutan: data.urutan || 1
                };
                this.modalPejabatOpen = true;
            },

            onSelectGuru(e) {
                const selectedOption = e.target.selectedOptions[0];
                if (selectedOption && selectedOption.value) {
                    this.pejabatForm.nama = selectedOption.dataset.nama || '';
                    if (selectedOption.dataset.foto) {
                        this.pejabatForm.foto = selectedOption.dataset.foto;
                        this.pejabatForm.crop_style = selectedOption.dataset.cropStyle || '';
                    }
                }
            },

            deletePejabat(id, nama) {
                this.deleteTargetId = id;
                this.deleteTargetNama = nama;
                this.modalDeleteOpen = true;
            },

            // Guru Modal Handlers
            openModalGuru() {
                this.guruForm = {
                    id: null,
                    nama: '',
                    nip: '',
                    jenis_kelamin: 'L',
                    jabatan: '',
                    mata_pelajaran: '',
                    foto: '',
                    crop_style: '',
                    status_aktif: true
                };
                this.modalGuruOpen = true;
            },

            editGuru(data) {
                this.guruForm = {
                    id: data.id,
                    nama: data.nama,
                    nip: data.nip || '',
                    jenis_kelamin: data.jenis_kelamin || 'L',
                    jabatan: data.jabatan || '',
                    mata_pelajaran: data.mata_pelajaran || '',
                    foto: data.foto || '',
                    crop_style: data.crop_style || '',
                    status_aktif: !!data.status_aktif
                };
                this.modalGuruOpen = true;
            },

            deleteGuruConfirm(id, nama) {
                this.deleteTargetGuruId = id;
                this.deleteTargetGuruNama = nama;
                this.modalDeleteGuruOpen = true;
            },

            triggerToast(msg) {
                this.toastMessage = msg;
                this.showToast = true;
                setTimeout(() => {
                    this.showToast = false;
                }, 3500);
            }
        }));
    });
</script>
@endpush
