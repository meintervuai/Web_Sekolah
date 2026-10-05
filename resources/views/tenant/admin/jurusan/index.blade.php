@extends('layouts.tenant_admin')

@section('title', 'Pengaturan Program Keahlian / Jurusan')
@section('header_title', 'Pengaturan Program Keahlian')

@push('styles')
<!-- Quill WYSIWYG CSS -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
<div class="max-w-7xl mx-auto space-y-6" 
     x-data="jurusanManager({
         activeTab: @js(request('tab', 'jurusan')),
         toastMsg: @js(session('success') ?? ''),
         bannerHeroPreview: @js(old('gambar_banner_jurusan', $halamanJurusan->gambar_banner ?? '')),
         isFiturAktif: @js((bool) $isFiturAktif),
         totalJurusan: @js($jurusanList->count()),
         nextUrutan: @js($jurusanList->count() + 1),
         routes: {
             mediaIndex: @js(route('tenant.admin.media.index', ['tenant' => app('tenant')->slug])),
             mediaUpload: @js(route('tenant.admin.media.upload', ['tenant' => app('tenant')->slug])),
             mediaImportUrl: @js(route('tenant.admin.media.import-url', ['tenant' => app('tenant')->slug])),
             toggleStatus: @js(route('tenant.admin.jurusan.toggle-status', ['tenant' => app('tenant')->slug]))
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
                <button type="button" @click="setTab('jurusan')"
                        :class="activeTab === 'jurusan' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span>1. Daftar Program Keahlian</span>
                </button>

                <!-- Tab Form (Edit / Tambah) - Permanen Aktif -->
                <button type="button" @click="setTab('form_jurusan')"
                        :class="activeTab === 'form_jurusan' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span x-text="jurusanForm.id ? '2. Edit: ' + (jurusanForm.singkatan || jurusanForm.nama_jurusan) : '2. Form Program Keahlian'"></span>
                </button>

                <button type="button" @click="setTab('hero')"
                        :class="activeTab === 'hero' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>3. Hero Banner Publik</span>
                </button>

                <button type="button" @click="setTab('visibilitas')"
                        :class="activeTab === 'visibilitas' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span>4. Visibilitas Menu &amp; Rute</span>
                </button>
            </div>

            <!-- Sticky Top Action Buttons -->
            <div class="flex items-center gap-2 shrink-0">
                <template x-if="activeTab === 'jurusan'">
                    <button type="button" @click="openFormJurusan()" 
                            class="admin-btn-save">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Program Keahlian</span>
                    </button>
                </template>

                <template x-if="activeTab === 'form_jurusan'">
                    <div class="flex items-center gap-2">
                        <template x-if="jurusanForm.id">
                            <button type="button" @click="openFormJurusan()" 
                                    class="admin-btn-create">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>[+] Form Baru</span>
                            </button>
                        </template>
                        <button type="button" @click="setTab('jurusan')" 
                                class="admin-btn-cancel">
                            Batal
                        </button>
                        <button type="button" 
                                @click="submitActiveForm('form-jurusan-main')" 
                                :disabled="formSubmitLoading"
                                class="admin-btn-save">
                            <template x-if="formSubmitLoading">
                                <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </template>
                            <template x-if="!formSubmitLoading">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </template>
                            <span x-text="formSubmitLoading ? 'Menyimpan...' : (jurusanForm.id ? 'Simpan Perubahan' : 'Tambah Program Keahlian')"></span>
                        </button>
                    </div>
                </template>

                <template x-if="activeTab === 'hero'">
                    <button type="button" 
                            @click="submitActiveForm('form-jurusan-hero')" 
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
                        <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Pengaturan Hero'"></span>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <!-- INCLUDED TAB PARTIALS -->
    @include('tenant.admin.jurusan.tabs.tab-jurusan')
    @include('tenant.admin.jurusan.tabs.tab-form-jurusan')
    @include('tenant.admin.jurusan.tabs.tab-hero')
    @include('tenant.admin.jurusan.tabs.tab-visibilitas')

    <!-- MODALS -->
    @include('tenant.admin.jurusan.tabs.modals')

</div>
@endsection

@push('scripts')
<!-- Quill.js WYSIWYG Editor Script -->
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('jurusanManager', (config) => ({
            activeTab: config.activeTab || 'jurusan',
            showToast: !!config.toastMsg,
            toastMessage: config.toastMsg || '',
            submitLoading: false,
            formSubmitLoading: false,
            modalSubmitLoading: false,
            bannerHeroPreview: config.bannerHeroPreview || '',
            isFiturAktif: !!config.isFiturAktif,

            totalJurusan: config.totalJurusan || 0,
            jurusanForm: {
                id: null,
                nama_jurusan: '',
                singkatan: '',
                logo: '',
                slug: '',
                guru_id: '',
                deskripsi_singkat: '',
                deskripsi_lengkap: '',
                informasi_tambahan: '',
                ikon_atau_foto: '',
                foto_crop_style: '',
                jenjang: 'SMK (3 Tahun)',
                peluang_kerja: 'Industri & Wirausaha',
                sertifikasi: 'LSP-P1 / BNSP',
                urutan: config.nextUrutan || 1,
                is_aktif: true,
                galeri_fotos: []
            },
            get maxUrutanOptions() {
                const total = Math.max(this.totalJurusan + (this.jurusanForm.id ? 0 : 1), 1);
                const opts = [];
                for (let i = 1; i <= Math.max(total, this.jurusanForm.urutan || 1); i++) {
                    opts.push(i);
                }
                return opts;
            },

            // Modal Delete State
            modalDeleteOpen: false,
            deleteTargetId: null,
            deleteTargetNama: '',

            // Media Picker State (Sinkron dengan picker-modal.blade.php)
            mediaPickerOpen: false,
            mediaPickerTargetInput: '',
            pickerLoading: false,
            pickerSearchQuery: '',
            pickerFilterType: 'semua',
            pickerPerPage: 12,
            mediaItems: [],
            pickerCurrentPage: 1,
            pickerLastPage: 1,
            pickerTotal: 0,
            pickerShowImportForm: false,
            pickerImportUrl: '',
            pickerImportJudul: '',

            init() {
                if (this.showToast) {
                    setTimeout(() => { this.showToast = false; }, 4000);
                }
                this.$watch('activeTab', (val) => {
                    const url = new URL(window.location.href);
                    url.searchParams.set('tab', val);
                    window.history.replaceState({}, '', url);

                    if (val === 'form_jurusan') {
                        this.$nextTick(() => {
                            this.initQuillEditor('editor_jurusan', this.jurusanForm.deskripsi_lengkap || '');
                            this.initQuillInfoEditor('editor_informasi_program', this.jurusanForm.informasi_tambahan || '');
                        });
                    }
                });

                if (this.activeTab === 'form_jurusan') {
                    this.$nextTick(() => {
                        this.initQuillEditor('editor_jurusan', this.jurusanForm.deskripsi_lengkap || '');
                        this.initQuillInfoEditor('editor_informasi_program', this.jurusanForm.informasi_tambahan || '');
                    });
                }
            },

            setTab(tab) {
                this.activeTab = tab;
            },

            triggerToast(msg) {
                this.toastMessage = msg;
                this.showToast = true;
                setTimeout(() => { this.showToast = false; }, 4000);
            },

            initQuillEditor(elementId, initialContent) {
                const el = document.getElementById(elementId);
                if (!el) return null;
                if (!this.quillJurusan) {
                    this.quillJurusan = new Quill('#' + elementId, {
                        theme: 'snow',
                        placeholder: 'Tulis uraian lengkap, profil keahlian, dan silabus...',
                        modules: {
                            toolbar: [
                                [{ 'header': [2, 3, false] }],
                                ['bold', 'italic', 'underline', 'strike'],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                ['blockquote', 'link'],
                                ['clean']
                            ]
                        }
                    });
                }
                this.quillJurusan.root.innerHTML = initialContent || '';
                return this.quillJurusan;
            },

            initQuillInfoEditor(elementId, initialContent) {
                const el = document.getElementById(elementId);
                if (!el) return null;
                if (!this.quillInfoProgram) {
                    this.quillInfoProgram = new Quill('#' + elementId, {
                        theme: 'snow',
                        placeholder: 'Tulis informasi program keahlian: jenjang, sertifikasi LSP/BNSP, peluang kerja, akreditasi...',
                        modules: {
                            toolbar: [
                                [{ 'header': [3, false] }],
                                ['bold', 'italic', 'underline'],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                ['link'],
                                ['clean']
                            ]
                        }
                    });
                }
                this.quillInfoProgram.root.innerHTML = initialContent || '';
                return this.quillInfoProgram;
            },

            syncEditors() {
                if (this.quillJurusan) {
                    const ta = document.getElementById('deskripsi_lengkap');
                    if (ta) ta.value = this.quillJurusan.root.innerHTML;
                }
                if (this.quillInfoProgram) {
                    const ta2 = document.getElementById('informasi_tambahan');
                    if (ta2) ta2.value = this.quillInfoProgram.root.innerHTML;
                }
            },

            submitActiveForm(formId) {
                if (formId === 'form-jurusan-main') {
                    this.syncEditors();
                    this.formSubmitLoading = true;
                } else if (formId === 'form-jurusan-hero') {
                    this.submitLoading = true;
                }
                const form = document.getElementById(formId);
                if (form) {
                    if (typeof form.requestSubmit === 'function') {
                        form.requestSubmit();
                    } else {
                        form.submit();
                    }
                }
            },

            generateSlug() {
                if (!this.jurusanForm.id) {
                    this.jurusanForm.slug = this.jurusanForm.nama_jurusan
                        .toLowerCase()
                        .trim()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/[\s_-]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                }
            },

            tambahGaleriFoto() {
                this.jurusanForm.galeri_fotos.push({
                    url: '',
                    judul: ''
                });
            },

            hapusGaleriFoto(index) {
                this.jurusanForm.galeri_fotos.splice(index, 1);
            },

            openFormJurusan() {
                this.jurusanForm = {
                    id: null,
                    nama_jurusan: '',
                    singkatan: '',
                    logo: '',
                    slug: '',
                    guru_id: '',
                    deskripsi_singkat: '',
                    deskripsi_lengkap: '',
                    informasi_tambahan: '',
                    ikon_atau_foto: '',
                    foto_crop_style: '',
                    jenjang: 'SMK (3 Tahun)',
                    peluang_kerja: 'Industri & Wirausaha',
                    sertifikasi: 'LSP-P1 / BNSP',
                    urutan: config.nextUrutan || 1,
                    is_aktif: true,
                    galeri_fotos: []
                };
                this.activeTab = 'form_jurusan';
                this.$nextTick(() => {
                    this.initQuillEditor('editor_jurusan', '');
                    this.initQuillInfoEditor('editor_informasi_program', '');
                });
            },

            editFormJurusan(data) {
                this.jurusanForm = {
                    id: data.id,
                    nama_jurusan: data.nama_jurusan,
                    singkatan: data.singkatan || '',
                    logo: data.logo || '',
                    slug: data.slug,
                    guru_id: data.guru_id || '',
                    deskripsi_singkat: data.deskripsi_singkat || '',
                    deskripsi_lengkap: data.deskripsi_lengkap || '',
                    informasi_tambahan: data.informasi_tambahan || '',
                    ikon_atau_foto: data.ikon_atau_foto || '',
                    foto_crop_style: data.foto_crop_style || '',
                    jenjang: data.jenjang || 'SMK (3 Tahun)',
                    peluang_kerja: data.peluang_kerja || 'Industri & Wirausaha',
                    sertifikasi: data.sertifikasi || 'LSP-P1 / BNSP',
                    urutan: data.urutan || 1,
                    is_aktif: !!data.is_aktif,
                    galeri_fotos: Array.isArray(data.galeri_fotos) ? JSON.parse(JSON.stringify(data.galeri_fotos)) : []
                };
                this.activeTab = 'form_jurusan';
                this.$nextTick(() => {
                    this.initQuillEditor('editor_jurusan', data.deskripsi_lengkap || '');
                    this.initQuillInfoEditor('editor_informasi_program', data.informasi_tambahan || '');
                });
            },

            deleteJurusan(id, nama) {
                this.deleteTargetId = id;
                this.deleteTargetNama = nama;
                this.modalDeleteOpen = true;
            },

            async toggleJurusanStatus(id, newStatus, nama) {
                try {
                    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const url = config.routes.toggleStatus;
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            target_type: 'jurusan',
                            jurusan_id: id,
                            is_aktif: newStatus
                        })
                    });
                    const data = await res.json();
                    if (res.ok && data.success) {
                        this.triggerToast(`Status ${nama} berhasil diubah.`);
                        setTimeout(() => { window.location.reload(); }, 600);
                    } else {
                        this.triggerToast('Gagal mengubah status program keahlian.');
                    }
                } catch (e) {
                    this.triggerToast('Terjadi kesalahan jaringan.');
                }
            },

            async toggleFeatureFlag(newStatus) {
                try {
                    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const url = config.routes.toggleStatus;
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            target_type: 'fitur',
                            is_aktif: newStatus
                        })
                    });
                    const data = await res.json();
                    if (res.ok && data.success) {
                        this.isFiturAktif = newStatus;
                        this.triggerToast(data.message);
                    } else {
                        this.triggerToast('Gagal mengubah visibilitas fitur.');
                    }
                } catch (e) {
                    this.triggerToast('Terjadi kesalahan jaringan.');
                }
            },

            // Media Picker Handlers (Sinkron 100% dengan komponen picker-modal.blade.php)
            openMediaPicker(targetInputId, defaultType = 'semua') {
                this.mediaPickerTargetInput = targetInputId;
                this.pickerFilterType = defaultType;
                this.pickerCurrentPage = 1;
                this.mediaPickerOpen = true;
                this.pickerShowImportForm = false;
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
                    const baseUrl = (config.routes && config.routes.mediaIndex) ? config.routes.mediaIndex : '/admin/media';
                    const res = await fetch(`${baseUrl}?${params}`, {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const json = await res.json();
                    this.mediaItems = json.data || [];
                    this.pickerCurrentPage = json.current_page || 1;
                    this.pickerLastPage = json.last_page || 1;
                    this.pickerTotal = json.total || 0;
                } catch (e) {
                    console.error(e);
                } finally {
                    this.pickerLoading = false;
                }
            },

            selectMediaItem(item) {
                if (this.mediaPickerTargetInput) {
                    const inputEl = document.getElementById(this.mediaPickerTargetInput);
                    if (inputEl) {
                        inputEl.value = item.url;
                        inputEl.dispatchEvent(new Event('input'));
                    }
                    if (this.mediaPickerTargetInput === 'input_banner_jurusan') {
                        this.bannerHeroPreview = item.url;
                    } else if (this.mediaPickerTargetInput === 'input_foto_jurusan') {
                        this.jurusanForm.ikon_atau_foto = item.url;
                        this.jurusanForm.foto_crop_style = item.smart_crop_style || '';
                    } else if (this.mediaPickerTargetInput === 'input_logo_jurusan') {
                        this.jurusanForm.logo = item.url;
                    } else if (this.mediaPickerTargetInput.startsWith('input_galeri_foto_')) {
                        const idx = parseInt(this.mediaPickerTargetInput.replace('input_galeri_foto_', ''));
                        if (!isNaN(idx) && this.jurusanForm.galeri_fotos[idx]) {
                            this.jurusanForm.galeri_fotos[idx].url = item.url;
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
                formData.append('kategori', 'jurusan');
                formData.append('judul', file.name.replace(/\.[^/.]+$/, ''));

                this.pickerLoading = true;
                try {
                    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const uploadUrl = (config.routes && config.routes.mediaUpload) ? config.routes.mediaUpload : '/admin/media/upload';
                    const res = await fetch(uploadUrl, {
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
                    try { result = await res.json(); } catch (err) { result = {}; }

                    if (res.ok && result.sukses && result.data) {
                        await this.fetchMedia(1);
                        this.selectMediaItem(result.data);
                    } else {
                        const errMsg = result.pesan || result.message || (result.errors ? Object.values(result.errors).flat().join(' ') : 'Gagal mengunggah berkas.');
                        this.triggerToast(errMsg);
                    }
                } catch (err) {
                    this.triggerToast('Terjadi kesalahan saat mengunggah.');
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
                    const importUrl = (config.routes && config.routes.mediaImportUrl) ? config.routes.mediaImportUrl : '/admin/media/import-url';
                    const res = await fetch(importUrl, {
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
                            kategori: 'jurusan'
                        })
                    });

                    let result = {};
                    try { result = await res.json(); } catch (err) { result = {}; }

                    if (res.ok && result.sukses && result.data) {
                        this.pickerShowImportForm = false;
                        this.pickerImportUrl = '';
                        this.pickerImportJudul = '';
                        await this.fetchMedia(1);
                        this.selectMediaItem(result.data);
                    } else {
                        const errMsg = result.pesan || result.message || (result.errors ? Object.values(result.errors).flat().join(' ') : 'Gagal mengimpor media dari URL.');
                        this.triggerToast(errMsg);
                    }
                } catch (e) {
                    this.triggerToast('Terjadi gangguan saat mengimpor media.');
                } finally {
                    this.pickerLoading = false;
                }
            }
        }));
    });
</script>
@endpush
