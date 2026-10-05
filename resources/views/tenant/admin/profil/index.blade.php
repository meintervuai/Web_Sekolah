@extends('layouts.tenant_admin')

@section('title', 'Pengaturan Profil Sekolah & Halaman')
@section('header_title', 'Pengaturan Profil & Konten Sekolah')

@push('styles')
<!-- Quill WYSIWYG CSS -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
<div class="max-w-7xl mx-auto space-y-6" 
     x-data="profilManager({
         activeTab: @js(request('tab', 'datadiri')),
         toastMsg: @js(session('success') ?? ''),
         diagrams: @js($diagrams ?? []),
         logoPreview: @js(old('logo', $pengaturan['logo'] ?? '')),
         fotoKepsekPreview: @js(old('foto_kepsek', $pengaturan['foto_kepsek'] ?? '')),
         fotoKepsekCropStyle: @js(\App\Services\MediaService::getCropStyle($pengaturan['foto_kepsek'] ?? '')),
         bannerProfilPreview: @js(old('gambar_banner_profil', $halamanProfil->gambar_banner ?? '')),
         bannerStrukturPreview: @js(old('gambar_banner_struktur', $halamanStruktur->gambar_banner ?? '')),
         bannerGuruPreview: @js(old('gambar_banner_guru', $halamanGuru->gambar_banner ?? '')),
         pejabatNextUrutan: @js($pejabatList->count() + 1),
         routes: {
             mediaIndex: @js(route('tenant.admin.media.index', ['tenant' => app('tenant')->slug])),
             mediaUpload: @js(route('tenant.admin.media.upload', ['tenant' => app('tenant')->slug])),
             mediaImportUrl: @js(route('tenant.admin.media.import-url', ['tenant' => app('tenant')->slug])),
             toggleMenu: @js(route('tenant.admin.profil.toggle-menu', ['tenant' => app('tenant')->slug]))
         },
          menuToggles: @js([
              'menu_profil' => (bool) ($fiturProfil['menu_profil'] ?? true),
              'profil' => (bool) ($fiturProfil['profil'] ?? true),
              'profil_data_pokok' => (bool) ($fiturProfil['profil_data_pokok'] ?? true),
              'profil_sambutan_kepsek' => (bool) ($fiturProfil['profil_sambutan_kepsek'] ?? true),
              'profil_video' => (bool) ($fiturProfil['profil_video'] ?? true),
              'sejarah' => (bool) ($fiturProfil['sejarah'] ?? true),
              'visi_misi' => (bool) ($fiturProfil['visi_misi'] ?? true),
              'struktur_organisasi' => (bool) ($fiturProfil['struktur_organisasi'] ?? true),
              'struktur_diagram' => (bool) ($fiturProfil['struktur_diagram'] ?? true),
              'struktur_pejabat' => (bool) ($fiturProfil['struktur_pejabat'] ?? true),
              'guru_staf' => (bool) ($fiturProfil['guru_staf'] ?? true),
          ])
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
                <button type="button" @click="setTab('datadiri')"
                        :class="activeTab === 'datadiri' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                        class="admin-tab-pill">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>1. Data Pokok Satuan Pendidikan</span>
                </button>

                @if (\App\Models\Tenant\PengaturanFitur::isAktif('profil', true))
                    <button type="button" @click="setTab('identitas')"
                            :class="activeTab === 'identitas' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                            class="admin-tab-pill">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>2. Profil Lengkap</span>
                    </button>
                @endif

                @if (\App\Models\Tenant\PengaturanFitur::isAktif('sejarah', true))
                    <button type="button" @click="setTab('sejarah')"
                            :class="activeTab === 'sejarah' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                            class="admin-tab-pill">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>3. Sejarah Sekolah</span>
                    </button>
                @endif

                @if (\App\Models\Tenant\PengaturanFitur::isAktif('visi_misi', true))
                    <button type="button" @click="setTab('visimisi')"
                            :class="activeTab === 'visimisi' ? 'admin-tab-pill-active' : 'admin-tab-pill-inactive'"
                            class="admin-tab-pill">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>4. Visi, Misi &amp; Tujuan</span>
                    </button>
                @endif
            </div>

            <!-- Sticky Top Save Button (Dispatched to active form) -->
            <div class="flex items-center gap-2 shrink-0">
                <template x-if="activeTab === 'datadiri'">
                    <button type="button" 
                            @click="submitActiveForm('form-datadiri')" 
                            :disabled="submitLoading"
                            class="admin-btn-save w-full sm:w-auto">
                        <template x-if="submitLoading">
                            <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <template x-if="!submitLoading">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </template>
                        <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Data Diri'"></span>
                    </button>
                </template>

                <template x-if="activeTab === 'identitas'">
                    <button type="button" 
                            @click="submitActiveForm('form-profil')" 
                            :disabled="submitLoading"
                            class="admin-btn-save w-full sm:w-auto">
                        <template x-if="submitLoading">
                            <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <template x-if="!submitLoading">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </template>
                        <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Profil Lengkap'"></span>
                    </button>
                </template>

                <template x-if="activeTab === 'sejarah'">
                    <button type="button" 
                            @click="submitActiveForm('form-sejarah')" 
                            :disabled="submitLoading"
                            class="admin-btn-save w-full sm:w-auto">
                        <template x-if="submitLoading">
                            <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <template x-if="!submitLoading">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </template>
                        <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Sejarah'"></span>
                    </button>
                </template>

                <template x-if="activeTab === 'visimisi'">
                    <button type="button" 
                            @click="submitActiveForm('form-visimisi')" 
                            :disabled="submitLoading"
                            class="admin-btn-save w-full sm:w-auto">
                        <template x-if="submitLoading">
                            <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <template x-if="!submitLoading">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </template>
                        <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Visi Misi'"></span>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <!-- INCLUDED TAB PARTIALS -->
    @include('tenant.admin.profil.tabs.tab-datadiri')
    @include('tenant.admin.profil.tabs.tab-profil')
    @include('tenant.admin.profil.tabs.tab-sejarah')
    @include('tenant.admin.profil.tabs.tab-visimisi')

    <!-- MODALS (MEDIA PICKER, CONFIRM TOGGLE) -->
    @include('tenant.admin.profil.tabs.modals')

</div>
@endsection

@push('scripts')
<!-- Quill.js WYSIWYG Editor Script -->
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('profilManager', (config) => ({
            activeTab: config.activeTab || 'datadiri',
            showToast: !!config.toastMsg,
            toastMessage: config.toastMsg || '',
            submitLoading: false,
            logoPreview: config.logoPreview || '',
            fotoKepsekPreview: config.fotoKepsekPreview || '',
            fotoKepsekCropStyle: config.fotoKepsekCropStyle || '',
            bannerProfilPreview: config.bannerProfilPreview || '',
            bannerStrukturPreview: config.bannerStrukturPreview || '',
            bannerGuruPreview: config.bannerGuruPreview || '',

            // Quill Editors
            quillProfil: null,
            quillSejarah: null,
            quillVisiMisi: null,

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

            // Confirmation Pop-up for Visibility Toggle
            modalConfirmToggleOpen: false,
            pendingToggleMenuId: null,
            pendingToggleKodeFitur: null,
            pendingToggleLabel: '',
            pendingToggleTargetState: false,
            toggleConfirmMessage: '',

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

            // Menu & Section toggles
            menuToggles: config.menuToggles || {},

            init() {
                this.$nextTick(() => {
                    this.initQuillEditors();
                });

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

                if (tab === 'identitas' && !this.quillProfil) {
                    this.$nextTick(() => this.initQuillEditors());
                }
                if (tab === 'sejarah' && !this.quillSejarah) {
                    this.$nextTick(() => this.initQuillEditors());
                }
                if (tab === 'visimisi' && !this.quillVisiMisi) {
                    this.$nextTick(() => this.initQuillEditors());
                }
            },

            initQuillEditors() {
                const toolbarOptions = [
                    [{ 'header': [2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'clean']
                ];

                const elProfil = document.getElementById('editor_profil');
                if (elProfil && !this.quillProfil) {
                    this.quillProfil = new Quill(elProfil, {
                        theme: 'snow',
                        placeholder: 'Tuliskan uraian profil sekolah, budaya kerja, atau pengantar umum...',
                        modules: { toolbar: toolbarOptions }
                    });
                }

                const elSejarah = document.getElementById('editor_sejarah');
                if (elSejarah && !this.quillSejarah) {
                    this.quillSejarah = new Quill(elSejarah, {
                        theme: 'snow',
                        placeholder: 'Tuliskan rangkaian sejarah lengkap berdirinya sekolah...',
                        modules: { toolbar: toolbarOptions }
                    });
                }

                const elVisiMisi = document.getElementById('editor_visimisi');
                if (elVisiMisi && !this.quillVisiMisi) {
                    this.quillVisiMisi = new Quill(elVisiMisi, {
                        theme: 'snow',
                        placeholder: 'Tuliskan visi, misi, dan target capaian mutu sekolah...',
                        modules: { toolbar: toolbarOptions }
                    });
                }
            },

            syncEditor(editorId, textareaId) {
                let quill = null;
                if (editorId === 'editor_profil') quill = this.quillProfil;
                else if (editorId === 'editor_sejarah') quill = this.quillSejarah;
                else if (editorId === 'editor_visimisi') quill = this.quillVisiMisi;

                if (quill) {
                    const targetTextarea = document.getElementById(textareaId);
                    if (targetTextarea) {
                        targetTextarea.value = quill.root.innerHTML;
                    }
                }
            },

            submitActiveForm(formId) {
                if (formId === 'form-profil') {
                    this.syncEditor('editor_profil', 'isi_profil');
                } else if (formId === 'form-sejarah') {
                    this.syncEditor('editor_sejarah', 'isi_sejarah');
                } else if (formId === 'form-visimisi') {
                    this.syncEditor('editor_visimisi', 'isi_visimisi');
                }

                const form = document.getElementById(formId);
                if (form) {
                    this.submitLoading = true;
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
                    if (this.mediaPickerTargetInput === 'input_logo_sekolah') {
                        this.logoPreview = item.url;
                    }
                    if (this.mediaPickerTargetInput === 'input_foto_kepsek') {
                        this.fotoKepsekPreview = item.url;
                        this.fotoKepsekCropStyle = item.smart_crop_style || '';
                    }
                    if (this.mediaPickerTargetInput === 'input_banner_profil') {
                        this.bannerProfilPreview = item.url;
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
