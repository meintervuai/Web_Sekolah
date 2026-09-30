@extends('layouts.tenant_admin')

@section('title', 'Pengaturan Program Keahlian / Jurusan')
@section('header_title', 'Pengaturan Program Keahlian')

@push('styles')
<!-- Quill WYSIWYG CSS -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
    .ql-toolbar.ql-snow {
        border-top-left-radius: 0.75rem;
        border-top-right-radius: 0.75rem;
        border-color: #cbd5e1;
        background-color: #f8fafc;
        padding: 0.6rem 0.8rem;
    }
    .ql-container.ql-snow {
        border-bottom-left-radius: 0.75rem;
        border-bottom-right-radius: 0.75rem;
        border-color: #cbd5e1;
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        font-size: 0.875rem;
        min-height: 200px;
        background-color: #ffffff;
    }
    .ql-editor {
        min-height: 200px;
        line-height: 1.65;
        color: #1e293b;
    }
    .ql-editor.ql-blank::before {
        color: #94a3b8;
        font-style: normal;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto space-y-6" 
     x-data="jurusanManager({
         activeTab: @js(request('tab', 'jurusan')),
         toastMsg: @js(session('success') ?? ''),
         bannerHeroPreview: @js(old('gambar_banner_jurusan', $halamanJurusan->gambar_banner ?? '')),
         isFiturAktif: @js((bool) $isFiturAktif),
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

    <!-- Tab Navigation Pills -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 border-b border-slate-200 taildash-scrollbar text-xs font-semibold">
        <button type="button" @click="setTab('jurusan')"
                :class="activeTab === 'jurusan' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 shrink-0 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            1. Daftar Program Keahlian
        </button>

        <!-- Tab Form (Edit / Tambah) -->
        <button type="button" @click="setTab('form_jurusan')"
                x-show="activeTab === 'form_jurusan' || jurusanForm.id"
                x-cloak
                :class="activeTab === 'form_jurusan' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 shrink-0 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span x-text="jurusanForm.id ? '2. Edit: ' + (jurusanForm.singkatan || jurusanForm.nama_jurusan) : '2. Form Tambah Program Keahlian'"></span>
        </button>

        <button type="button" @click="setTab('hero')"
                :class="activeTab === 'hero' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 shrink-0 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            3. Hero Banner Publik
        </button>

        <button type="button" @click="setTab('visibilitas')"
                :class="activeTab === 'visibilitas' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 shrink-0 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            4. Visibilitas Menu &amp; Rute
        </button>
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

            quillJurusan: null,
            jurusanForm: {
                id: null,
                nama_jurusan: '',
                singkatan: '',
                slug: '',
                guru_id: '',
                deskripsi_singkat: '',
                deskripsi_lengkap: '',
                ikon_atau_foto: '',
                foto_crop_style: '',
                urutan: config.nextUrutan || 1,
                is_aktif: true
            },

            // Modal Delete State
            modalDeleteOpen: false,
            deleteTargetId: null,
            deleteTargetNama: '',

            // Media Picker State
            mediaPickerOpen: false,
            mediaPickerTargetInput: '',
            pickerLoading: false,
            pickerSearch: '',
            pickerFilterType: 'semua',
            pickerItems: [],
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
                        });
                    }
                });

                if (this.activeTab === 'form_jurusan') {
                    this.$nextTick(() => {
                        this.initQuillEditor('editor_jurusan', this.jurusanForm.deskripsi_lengkap || '');
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

            syncEditor(editorId, textareaId) {
                if (this.quillJurusan) {
                    const ta = document.getElementById(textareaId);
                    if (ta) {
                        ta.value = this.quillJurusan.root.innerHTML;
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

            openFormJurusan() {
                this.jurusanForm = {
                    id: null,
                    nama_jurusan: '',
                    singkatan: '',
                    slug: '',
                    guru_id: '',
                    deskripsi_singkat: '',
                    deskripsi_lengkap: '',
                    ikon_atau_foto: '',
                    foto_crop_style: '',
                    urutan: config.nextUrutan || 1,
                    is_aktif: true
                };
                this.activeTab = 'form_jurusan';
                this.$nextTick(() => {
                    this.initQuillEditor('editor_jurusan', '');
                });
            },

            editFormJurusan(data) {
                this.jurusanForm = {
                    id: data.id,
                    nama_jurusan: data.nama_jurusan,
                    singkatan: data.singkatan || '',
                    slug: data.slug,
                    guru_id: data.guru_id || '',
                    deskripsi_singkat: data.deskripsi_singkat || '',
                    deskripsi_lengkap: data.deskripsi_lengkap || '',
                    ikon_atau_foto: data.ikon_atau_foto || '',
                    foto_crop_style: data.foto_crop_style || '',
                    urutan: data.urutan || 1,
                    is_aktif: !!data.is_aktif
                };
                this.activeTab = 'form_jurusan';
                this.$nextTick(() => {
                    this.initQuillEditor('editor_jurusan', data.deskripsi_lengkap || '');
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

            // Media Picker Functions
            openMediaPicker(targetInputId) {
                this.mediaPickerTargetInput = targetInputId;
                this.mediaPickerOpen = true;
                this.pickerShowImportForm = false;
                this.fetchMedia(1);
            },

            async fetchMedia(page = 1) {
                this.pickerLoading = true;
                this.pickerCurrentPage = page;
                try {
                    let url = `${config.routes.mediaIndex}?page=${page}&per_page=12`;
                    if (this.pickerSearch) url += `&q=${encodeURIComponent(this.pickerSearch)}`;
                    if (this.pickerFilterType && this.pickerFilterType !== 'semua') url += `&tipe=${this.pickerFilterType}`;

                    const res = await fetch(url, {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const json = await res.json();
                    if (json.data) {
                        this.pickerItems = json.data;
                        this.pickerCurrentPage = json.current_page || 1;
                        this.pickerLastPage = json.last_page || 1;
                        this.pickerTotal = json.total || 0;
                    }
                } catch (e) {
                    console.error(e);
                } finally {
                    this.pickerLoading = false;
                }
            },

            selectMediaItem(item) {
                if (this.mediaPickerTargetInput === 'input_banner_jurusan') {
                    this.bannerHeroPreview = item.url;
                } else if (this.mediaPickerTargetInput === 'input_foto_jurusan') {
                    this.jurusanForm.ikon_atau_foto = item.url;
                    this.jurusanForm.foto_crop_style = item.smart_crop_style || '';
                }
                const inputEl = document.getElementById(this.mediaPickerTargetInput);
                if (inputEl) {
                    inputEl.value = item.url;
                    inputEl.dispatchEvent(new Event('input'));
                }
                this.mediaPickerOpen = false;
            },

            async handlePickerUpload(e) {
                const files = e.target.files;
                if (!files || files.length === 0) return;

                this.pickerLoading = true;
                const formData = new FormData();
                formData.append('berkas', files[0]);
                formData.append('kategori', 'jurusan');

                try {
                    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const res = await fetch(config.routes.mediaUpload, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });
                    const json = await res.json();
                    if (res.ok && json.data) {
                        await this.fetchMedia(1);
                        this.selectMediaItem(json.data);
                    } else {
                        this.triggerToast(json.pesan || 'Gagal mengunggah berkas.');
                    }
                } catch (err) {
                    this.triggerToast('Terjadi kesalahan saat mengunggah.');
                } finally {
                    this.pickerLoading = false;
                    e.target.value = '';
                }
            },

            async submitImportUrl() {
                if (!this.pickerImportUrl) return;

                this.pickerLoading = true;
                try {
                    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const res = await fetch(config.routes.mediaImportUrl, {
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
                        this.triggerToast(result.pesan || 'Gagal mengimpor media dari URL.');
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
