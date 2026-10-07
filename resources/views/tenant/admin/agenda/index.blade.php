@extends('layouts.tenant_admin')

@section('title', 'Manajemen Agenda & Kalender Kegiatan')
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

    <!-- Sub-tabs -->
    @include('tenant.admin.agenda.tabs.tab-agenda')
    @include('tenant.admin.agenda.tabs.tab-form')
    @include('tenant.admin.agenda.tabs.modals')

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

        // Form agenda state
        editMode: false,
        formActionUrl: config.routes.storeAgenda,
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
        quill: null,
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

            this.$nextTick(() => {
                this.initQuill();
            });
        },

        initQuill() {
            if (!this.quill && document.getElementById('editor-agenda')) {
                this.quill = new Quill('#editor-agenda', {
                    theme: 'snow',
                    placeholder: 'Tuliskan rincian agenda, susunan acara, narasumber, atau petunjuk teknis di sini...',
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

                this.quill.on('text-change', () => {
                    this.formDeskripsiLengkap = this.quill.root.innerHTML;
                });
            }
        },

        submitActiveForm(formId) {
            const form = document.getElementById(formId);
            if (!form) return;

            if (formId === 'form-agenda-main' && this.quill) {
                const hiddenInput = document.getElementById('input-deskripsi-lengkap');
                if (hiddenInput) {
                    hiddenInput.value = this.quill.root.innerHTML;
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

        tambahAgendaBaru() {
            this.editMode = false;
            this.formActionUrl = config.routes.storeAgenda;
            this.formJudul = '';
            this.formTglMulai = '';
            this.formTglSelesai = '';
            this.formJamMulai = '';
            this.formJamSelesai = '';
            this.formLokasi = '';
            this.formPenyelenggara = '';
            this.formRingkasan = '';
            this.formDeskripsiLengkap = '';
            this.formGambarSampul = '';
            this.formLinkPendaftaran = '';
            this.formIsAktif = true;

            if (this.quill) {
                this.quill.root.innerHTML = '';
            }

            this.activeTab = 'form';
            this.$nextTick(() => {
                this.initQuill();
            });
        },

        editAgendaItem(agenda) {
            this.editMode = true;
            this.formActionUrl = `${config.routes.storeAgenda}/${agenda.id}`;
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

            this.activeTab = 'form';
            this.$nextTick(() => {
                this.initQuill();
                if (this.quill) {
                    this.quill.root.innerHTML = this.formDeskripsiLengkap;
                }
            });
        },

        submitAgendaForm(e) {
            if (this.quill) {
                const hiddenInput = document.getElementById('input-deskripsi-lengkap');
                if (hiddenInput) {
                    hiddenInput.value = this.quill.root.innerHTML;
                }
            }
            this.isSubmitting = true;
        },

        konfirmasiHapusAgenda(id, judul) {
            this.hapusJudul = judul;
            this.hapusActionUrl = `${config.routes.storeAgenda}/${id}`;
            this.modalHapus = true;
        },

        bukaMediaPicker(targetField) {
            this.targetMediaField = targetField;
            if (targetField === 'banner_hero') {
                this.openMediaPicker('input_banner_hero_agenda', 'gambar');
            } else if (targetField === 'sampul_agenda') {
                this.openMediaPicker('input_sampul_agenda', 'gambar');
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
                const url = (config.routes && config.routes.mediaIndex) ? config.routes.mediaIndex : '/admin/media';
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
                if (this.mediaPickerTargetInput === 'banner_hero' || this.mediaPickerTargetInput === 'input_banner_hero_agenda') {
                    this.bannerHeroPreview = item.url;
                } else if (this.mediaPickerTargetInput === 'sampul_agenda' || this.mediaPickerTargetInput === 'input_sampul_agenda') {
                    this.formGambarSampul = item.url;
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
            formData.append('kategori', 'agenda');
            formData.append('judul', file.name.replace(/\.[^/.]+$/, ''));

            this.pickerLoading = true;
            try {
                const csrf = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '{{ csrf_token() }}';
                const url = (config.routes && config.routes.mediaUpload) ? config.routes.mediaUpload : '/admin/media/upload';
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
                const url = (config.routes && config.routes.mediaImportUrl) ? config.routes.mediaImportUrl : '/admin/media/import-url';
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
                        kategori: 'agenda'
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
