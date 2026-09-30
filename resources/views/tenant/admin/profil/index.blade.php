@extends('layouts.tenant_admin')

@section('title', 'Pengaturan Profil Sekolah & Halaman')
@section('header_title', 'Pengaturan Profil & Konten Sekolah')

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
        min-height: 220px;
        background-color: #ffffff;
    }
    .ql-editor {
        min-height: 220px;
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
     x-data="profilManager({
         activeTab: '{{ request('tab', 'identitas') }}',
         toastMsg: '{{ session('success') ?? '' }}',
         diagrams: {{ Js::from($diagrams ?? []) }}
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

    <!-- Tab Navigation Pills -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 border-b border-slate-200 taildash-scrollbar text-xs font-semibold">
        <button type="button" @click="setTab('identitas')"
                :class="activeTab === 'identitas' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 shrink-0 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            1. Profil Lengkap
        </button>

        <button type="button" @click="setTab('sejarah')"
                :class="activeTab === 'sejarah' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 shrink-0 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            2. Sejarah Sekolah
        </button>

        <button type="button" @click="setTab('visimisi')"
                :class="activeTab === 'visimisi' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 shrink-0 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            3. Visi, Misi &amp; Tujuan
        </button>

        <button type="button" @click="setTab('struktur')"
                :class="activeTab === 'struktur' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 shrink-0 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            4. Struktur Organisasi
        </button>

        <button type="button" @click="setTab('visibilitas')"
                :class="activeTab === 'visibilitas' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 shrink-0 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            5. Visibilitas Menu &amp; Rute
        </button>
    </div>

    <!-- TAB 1: IDENTITAS & SAMBUTAN -->
    <div x-show="activeTab === 'identitas'" x-cloak class="space-y-6">
        <form action="{{ route('tenant.admin.profil.identitas.update', ['tenant' => app('tenant')->slug]) }}" method="POST" @submit="submitLoading = true">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Data Pokok Sekolah (Left 7 Cols) -->
                <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
                    <div class="border-b border-slate-100 pb-3">
                        <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">Data Pokok Satuan Pendidikan</h2>
                        <p class="text-xs text-slate-500">Informasi resmi identitas sekolah dan header hero halaman profil.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Satuan Pendidikan <span class="text-rose-500">*</span></label>
                            <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $pengaturan['nama_sekolah']) }}" required
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Slogan / Tagline Sekolah</label>
                            <input type="text" name="slogan" value="{{ old('slogan', $pengaturan['slogan']) }}"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Logo Satuan Pendidikan (Pusat Media / URL)</label>
                            <div class="flex gap-2 items-center">
                                <div class="w-10 h-10 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-center shrink-0 overflow-hidden p-1">
                                    <template x-if="logoPreview">
                                        <img :src="logoPreview" alt="Logo Preview" class="w-full h-full object-contain">
                                    </template>
                                    <template x-if="!logoPreview">
                                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </template>
                                </div>
                                <input type="text" name="logo" id="input_logo_sekolah" 
                                       x-model="logoPreview"
                                       class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                       placeholder="https://... atau pilih dari Pusat Media">
                                <button type="button" @click="openMediaPicker('input_logo_sekolah')" 
                                        class="px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Pilih Media
                                </button>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-1">Logo resmi sekolah (format PNG transparan / SVG direkomendasikan).</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">NPSN <span class="text-rose-500">*</span></label>
                            <input type="text" name="npsn" value="{{ old('npsn', $pengaturan['npsn']) }}" required
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Peringkat Akreditasi <span class="text-rose-500">*</span></label>
                            <input type="text" name="akreditasi" value="{{ old('akreditasi', $pengaturan['akreditasi']) }}" required
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tahun Berdiri <span class="text-rose-500">*</span></label>
                            <input type="text" name="tahun_berdiri" value="{{ old('tahun_berdiri', $pengaturan['tahun_berdiri']) }}" required
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Telepon Resmi</label>
                            <input type="text" name="no_telepon" value="{{ old('no_telepon', $pengaturan['no_telepon']) }}"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Lengkap</label>
                            <textarea name="alamat" rows="2"
                                      class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">{{ old('alamat', $pengaturan['alamat']) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Email Sekolah</label>
                            <input type="email" name="email_sekolah" value="{{ old('email_sekolah', $pengaturan['email_sekolah']) }}"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp Humas / SPMB</label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', $pengaturan['whatsapp']) }}"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        </div>

                        <!-- Hero Banner Customization for Profil Overview -->
                        <div class="sm:col-span-2 pt-4 border-t border-slate-100 space-y-4">
                            <div class="border-b border-slate-100 pb-2">
                                <h3 class="text-xs font-bold text-blue-900 uppercase tracking-wider flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Kustomisasi Hero Banner (Halaman Profil Publik)
                                </h3>
                                <p class="text-[11px] text-slate-500">Atur judul utama, deskripsi, pola dekoratif, dan gambar latar hero.</p>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Utama Hero Banner</label>
                                <input type="text" name="judul_profil" value="{{ old('judul_profil', $halamanProfil->judul ?? ('Profil ' . $pengaturan['nama_sekolah'])) }}"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                       placeholder="Contoh: Profil Singkat & Nilai Budaya Sekolah">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Ringkas / Subjudul Hero</label>
                                <textarea name="subjudul_profil" rows="2"
                                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                          placeholder="Contoh: Mengenal lebih dekat sejarah, visi misi, budaya kerja, dan pimpinan satuan pendidikan kejuruan berprestasi.">{{ old('subjudul_profil', $halamanProfil->subjudul) }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Pola Dekorasi Latar</label>
                                    <select name="pola_latar_profil" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                                        <option value="dots" {{ ($halamanProfil->pola_latar ?? 'dots') === 'dots' ? 'selected' : '' }}>Titik-titik Aksial (Radial Dots)</option>
                                        <option value="grid" {{ ($halamanProfil->pola_latar ?? '') === 'grid' ? 'selected' : '' }}>Kisi Garis Kotak (Grid Blueprint)</option>
                                        <option value="mesh" {{ ($halamanProfil->pola_latar ?? '') === 'mesh' ? 'selected' : '' }}>Gradasi Aksen Halus (Soft Mesh)</option>
                                        <option value="polos" {{ ($halamanProfil->pola_latar ?? '') === 'polos' ? 'selected' : '' }}>Polos Bersih (Tanpa Pola)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Gambar Latar Hero (Pusat Media)</label>
                                    <div class="flex gap-2">
                                        <input type="text" name="gambar_banner_profil" id="input_banner_profil" value="{{ old('gambar_banner_profil', $halamanProfil->gambar_banner) }}"
                                               class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                               placeholder="https://... atau pilih media">
                                        <button type="button" @click="openMediaPicker('input_banner_profil')" 
                                                class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1 cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            Pilih
                                        </button>
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-1">Jika diisi, gambar akan tampil artistik di sisi kanan hero dengan efek gradual fade ke kiri &amp; drop-shadow teks.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kepala Sekolah & Media Profil (Right 5 Cols) -->
                <div class="lg:col-span-5 space-y-6">
                    <!-- Card Kepala Sekolah -->
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
                        <div class="border-b border-slate-100 pb-3">
                            <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">Kepala Satuan Pendidikan</h2>
                            <p class="text-xs text-slate-500">Nama, NIP, foto, dan sambutan pimpinan sekolah.</p>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap &amp; Gelar</label>
                                <input type="text" name="nama_kepsek" value="{{ old('nama_kepsek', $pengaturan['nama_kepsek']) }}"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">NIP Kepala Sekolah</label>
                                <input type="text" name="nip_kepsek" value="{{ old('nip_kepsek', $pengaturan['nip_kepsek']) }}"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Foto Kepala Sekolah (Pusat Media)</label>
                                <div class="flex gap-2">
                                    <input type="text" name="foto_kepsek" id="input_foto_kepsek" value="{{ old('foto_kepsek', $pengaturan['foto_kepsek']) }}"
                                           class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                           placeholder="https://... atau pilih dari pustaka media">
                                    <button type="button" @click="openMediaPicker('input_foto_kepsek')" 
                                            class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        Pilih Media
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Ringkasan Sambutan Kepala Sekolah</label>
                                <textarea name="sambutan_kepsek" rows="3"
                                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                          placeholder="Tuliskan kata sambutan kepala sekolah...">{{ old('sambutan_kepsek', $pengaturan['sambutan_kepsek']) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Card Video Profil -->
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
                        <div class="border-b border-slate-100 pb-3">
                            <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">Video Profil Sekolah</h2>
                            <p class="text-xs text-slate-500">Tautan YouTube atau video MP4 dari Pusat Berkas Media.</p>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Video</label>
                                <input type="text" name="video_profil_judul" value="{{ old('video_profil_judul', $pengaturan['video_profil_judul']) }}"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">URL Video / YouTube (Pusat Media)</label>
                                <div class="flex gap-2">
                                    <input type="text" name="video_profil" id="input_video_profil" value="{{ old('video_profil', $pengaturan['video_profil']) }}"
                                           class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                           placeholder="https://www.youtube.com/... atau URL file media">
                                    <button type="button" @click="openMediaPicker('input_video_profil', 'video')" 
                                            class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        Pilih Media
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Kilas Video</label>
                                <textarea name="video_profil_deskripsi" rows="2"
                                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">{{ old('video_profil_deskripsi', $pengaturan['video_profil_deskripsi']) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Bottom Bar -->
            <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                <button type="submit" 
                        :disabled="submitLoading"
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition flex items-center gap-2 cursor-pointer disabled:opacity-50">
                    <template x-if="submitLoading">
                        <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <span x-text="submitLoading ? 'Menyimpan ke Database...' : 'Simpan Identitas & Sambutan'"></span>
                </button>
            </div>
        </form>
    </div>

    <!-- TAB 2: SEJARAH SEKOLAH -->
    <div x-show="activeTab === 'sejarah'" x-cloak class="space-y-6">
        <form action="{{ route('tenant.admin.profil.halaman.update', ['tenant' => app('tenant')->slug, 'slug' => 'sejarah']) }}" 
              method="POST" 
              @submit="syncEditor('editor_sejarah', 'isi_sejarah'); submitLoading = true">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-5">
                <div class="border-b border-slate-100 pb-4">
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">Kelola Halaman Sejarah Sekolah</h2>
                    <p class="text-xs text-slate-500">Edit isi sejarah dengan editor teks WYSIWYG lengkap, banner media, dan pengaturan hero.</p>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Judul Halaman Sejarah <span class="text-rose-500">*</span></label>
                            <input type="text" name="judul" value="{{ old('judul', $halamanSejarah->judul) }}" required
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Pola Dekorasi Latar Hero Banner</label>
                            <select name="pola_latar" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                                <option value="dots" {{ ($halamanSejarah->pola_latar ?? 'dots') === 'dots' ? 'selected' : '' }}>Titik-titik Aksial (Radial Dots)</option>
                                <option value="grid" {{ ($halamanSejarah->pola_latar ?? '') === 'grid' ? 'selected' : '' }}>Kisi Garis Kotak (Grid Blueprint)</option>
                                <option value="mesh" {{ ($halamanSejarah->pola_latar ?? '') === 'mesh' ? 'selected' : '' }}>Gradasi Aksen Halus (Soft Mesh)</option>
                                <option value="polos" {{ ($halamanSejarah->pola_latar ?? '') === 'polos' ? 'selected' : '' }}>Polos Bersih (Tanpa Pola)</option>
                            </select>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Ringkas / Subjudul Hero Banner</label>
                            <textarea name="subjudul" rows="2"
                                      class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">{{ old('subjudul', $halamanSejarah->subjudul) }}</textarea>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Foto Banner / Sampul Sejarah (Pusat Media)</label>
                        <div class="flex gap-2">
                            <input type="text" name="gambar_banner" id="input_banner_sejarah" value="{{ old('gambar_banner', $halamanSejarah->gambar_banner) }}"
                                   class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                   placeholder="https://... atau pilih dari Pusat Berkas Media">
                            <button type="button" @click="openMediaPicker('input_banner_sejarah')" 
                                    class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Pilih dari Media
                            </button>
                        </div>
                    </div>

                    <!-- WYSIWYG Editor Container -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700">Isi Teks Sejarah (WYSIWYG) <span class="text-rose-500">*</span></label>
                            <span class="text-[11px] text-slate-400">Gunakan toolbar untuk format teks, list, heading &amp; kutipan</span>
                        </div>
                        
                        <!-- Hidden textarea that gets submitted -->
                        <textarea name="isi_konten" id="isi_sejarah" class="hidden">{!! old('isi_konten', $halamanSejarah->isi_konten) !!}</textarea>
                        
                        <!-- Quill Editor Element -->
                        <div id="editor_sejarah">{!! old('isi_konten', $halamanSejarah->isi_konten) !!}</div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <button type="submit" 
                            :disabled="submitLoading"
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition flex items-center gap-2 cursor-pointer disabled:opacity-50">
                        <template x-if="submitLoading">
                            <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Perubahan Sejarah'"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- TAB 3: VISI & MISI -->
    <div x-show="activeTab === 'visimisi'" x-cloak class="space-y-6">
        <form action="{{ route('tenant.admin.profil.halaman.update', ['tenant' => app('tenant')->slug, 'slug' => 'visi-misi']) }}" 
              method="POST" 
              @submit="syncEditor('editor_visimisi', 'isi_visimisi'); submitLoading = true">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-5">
                <div class="border-b border-slate-100 pb-4">
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">Kelola Visi, Misi &amp; Sasaran Mutu</h2>
                    <p class="text-xs text-slate-500">Edit visi, misi, deskripsi hero banner, dan tujuan sekolah dengan editor teks terformat.</p>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Judul Halaman Visi &amp; Misi <span class="text-rose-500">*</span></label>
                            <input type="text" name="judul" value="{{ old('judul', $halamanVisiMisi->judul) }}" required
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Pola Dekorasi Latar Hero Banner</label>
                            <select name="pola_latar" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                                <option value="dots" {{ ($halamanVisiMisi->pola_latar ?? 'dots') === 'dots' ? 'selected' : '' }}>Titik-titik Aksial (Radial Dots)</option>
                                <option value="grid" {{ ($halamanVisiMisi->pola_latar ?? '') === 'grid' ? 'selected' : '' }}>Kisi Garis Kotak (Grid Blueprint)</option>
                                <option value="mesh" {{ ($halamanVisiMisi->pola_latar ?? '') === 'mesh' ? 'selected' : '' }}>Gradasi Aksen Halus (Soft Mesh)</option>
                                <option value="polos" {{ ($halamanVisiMisi->pola_latar ?? '') === 'polos' ? 'selected' : '' }}>Polos Bersih (Tanpa Pola)</option>
                            </select>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Ringkas / Subjudul Hero Banner</label>
                            <textarea name="subjudul" rows="2"
                                      class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">{{ old('subjudul', $halamanVisiMisi->subjudul) }}</textarea>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Foto Banner / Sampul (Pusat Media)</label>
                        <div class="flex gap-2">
                            <input type="text" name="gambar_banner" id="input_banner_visimisi" value="{{ old('gambar_banner', $halamanVisiMisi->gambar_banner) }}"
                                   class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                   placeholder="https://... atau pilih dari Pusat Media">
                            <button type="button" @click="openMediaPicker('input_banner_visimisi')" 
                                    class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Pilih dari Media
                            </button>
                        </div>
                    </div>

                    <!-- WYSIWYG Editor Container -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700">Isi Visi, Misi &amp; Sasaran Mutu (WYSIWYG) <span class="text-rose-500">*</span></label>
                            <span class="text-[11px] text-slate-400">Dapat menyusun poin visi, misi, dan indikator sasaran dengan rapi</span>
                        </div>
                        
                        <!-- Hidden textarea that gets submitted -->
                        <textarea name="isi_konten" id="isi_visimisi" class="hidden">{!! old('isi_konten', $halamanVisiMisi->isi_konten) !!}</textarea>
                        
                        <!-- Quill Editor Element -->
                        <div id="editor_visimisi">{!! old('isi_konten', $halamanVisiMisi->isi_konten) !!}</div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <button type="submit" 
                            :disabled="submitLoading"
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition flex items-center gap-2 cursor-pointer disabled:opacity-50">
                        <template x-if="submitLoading">
                            <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Visi & Misi'"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- TAB 4: STRUKTUR ORGANISASI -->
    <div x-show="activeTab === 'struktur'" x-cloak class="space-y-6">
        
        <!-- Pengaturan Mode Tampilan Halaman Struktur Publik & Hero Banner -->
        <form action="{{ route('tenant.admin.profil.struktur.update', ['tenant' => app('tenant')->slug]) }}" method="POST" @submit="submitLoading = true">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-6">
                
                <!-- Pilihan Mode Tampilan Struktur di Publik -->
                <div class="p-4 sm:p-5 bg-gradient-to-r from-blue-50/80 to-indigo-50/60 rounded-2xl border border-blue-100 space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 font-heading flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Mode Pilihan Tampilan Halaman Struktur Publik
                            </h3>
                            <p class="text-xs text-slate-600">Tentukan konten apa saja yang tampil di halaman publik <code>/profil/struktur</code>.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1">
                        <label class="flex items-start gap-3 p-3 bg-white rounded-xl border border-slate-200 hover:border-blue-400 cursor-pointer transition shadow-2xs">
                            <input type="radio" name="mode_tampilan_struktur" value="semua" {{ ($pengaturan['mode_tampilan_struktur'] ?? 'semua') === 'semua' ? 'checked' : '' }} class="mt-0.5 text-blue-600 focus:ring-blue-500">
                            <div>
                                <span class="block text-xs font-bold text-slate-800">Tampilkan Keduanya</span>
                                <span class="block text-[11px] text-slate-500 mt-0.5">Pengunjung dapat beralih antara Tab Jajaran Pejabat &amp; Bagan Diagram.</span>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-3 bg-white rounded-xl border border-slate-200 hover:border-blue-400 cursor-pointer transition shadow-2xs">
                            <input type="radio" name="mode_tampilan_struktur" value="pejabat" {{ ($pengaturan['mode_tampilan_struktur'] ?? 'semua') === 'pejabat' ? 'checked' : '' }} class="mt-0.5 text-blue-600 focus:ring-blue-500">
                            <div>
                                <span class="block text-xs font-bold text-slate-800">Hanya Jajaran Pejabat</span>
                                <span class="block text-[11px] text-slate-500 mt-0.5">Hanya menampilkan kartu foto jajaran pimpinan &amp; pejabat struktural.</span>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-3 bg-white rounded-xl border border-slate-200 hover:border-blue-400 cursor-pointer transition shadow-2xs">
                            <input type="radio" name="mode_tampilan_struktur" value="diagram" {{ ($pengaturan['mode_tampilan_struktur'] ?? 'semua') === 'diagram' ? 'checked' : '' }} class="mt-0.5 text-blue-600 focus:ring-blue-500">
                            <div>
                                <span class="block text-xs font-bold text-slate-800">Hanya Bagan Diagram</span>
                                <span class="block text-[11px] text-slate-500 mt-0.5">Hanya menampilkan gambar diagram alur bagan organisasi.</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Hero Customization for Struktur Page -->
                <div class="p-4 bg-slate-50/80 rounded-2xl border border-slate-200 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-800 mb-1">Pola Dekorasi Latar Hero Banner (Struktur)</label>
                        <select name="pola_latar_struktur" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:border-blue-500 transition">
                            <option value="dots" {{ ($halamanStruktur->pola_latar ?? 'dots') === 'dots' ? 'selected' : '' }}>Titik-titik Aksial (Radial Dots)</option>
                            <option value="grid" {{ ($halamanStruktur->pola_latar ?? '') === 'grid' ? 'selected' : '' }}>Kisi Garis Kotak (Grid Blueprint)</option>
                            <option value="mesh" {{ ($halamanStruktur->pola_latar ?? '') === 'mesh' ? 'selected' : '' }}>Gradasi Aksen Halus (Soft Mesh)</option>
                            <option value="polos" {{ ($halamanStruktur->pola_latar ?? '') === 'polos' ? 'selected' : '' }}>Polos Bersih (Tanpa Pola)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-800 mb-1">Deskripsi Ringkas / Subjudul Hero (Struktur)</label>
                        <textarea name="subjudul_struktur" rows="2"
                                  class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:border-blue-500 transition">{{ old('subjudul_struktur', $halamanStruktur->subjudul) }}</textarea>
                    </div>
                </div>

                <!-- Bagian A: Diagram Struktur Organisasi (Dynamic Repeater) -->
                <div class="space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
                        <div>
                            <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">1. Bagan Diagram Struktur Organisasi</h2>
                            <p class="text-xs text-slate-500">Diagram gambar alur hierarki manajemen sekolah, TEFA/Hubin, dan Bengkel/Lab Praktik.</p>
                        </div>
                        <button type="button" 
                                @click="tambahBagan()" 
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-1.5 self-start cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Bagan Baru
                        </button>
                    </div>

                    <!-- Repeater List -->
                    <div class="space-y-4">
                        <template x-for="(diag, index) in diagramList" :key="index">
                            <div class="p-4 sm:p-5 bg-slate-50/90 rounded-2xl border border-slate-200 space-y-3 relative group">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-xs font-bold text-blue-900 flex items-center gap-2">
                                        <span class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-extrabold" x-text="index + 1"></span>
                                        <span x-text="diag.judul ? diag.judul : `Bagan Diagram #${index + 1}`"></span>
                                    </h3>
                                    <button type="button" 
                                            @click="hapusBagan(index)" 
                                            class="px-2.5 py-1 text-xs font-bold text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 rounded-lg transition flex items-center gap-1 cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus Bagan
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Judul Bagan <span class="text-rose-500">*</span></label>
                                        <input type="text" :name="`diagrams[${index}][judul]`" x-model="diag.judul" required
                                               placeholder="Contoh: Bagan Struktur Utama Manajemen Sekolah"
                                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:border-blue-500 transition">
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Deskripsi Ringkas</label>
                                        <input type="text" :name="`diagrams[${index}][deskripsi]`" x-model="diag.deskripsi"
                                               placeholder="Contoh: Alur garis komando dan koordinasi Kepala Sekolah..."
                                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:border-blue-500 transition">
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label class="block text-[11px] font-bold text-slate-700 mb-1">URL Gambar Diagram (Pusat Berkas Media) <span class="text-rose-500">*</span></label>
                                        <div class="flex gap-2">
                                            <input type="text" :name="`diagrams[${index}][gambar]`" :id="`input_diag_${index}`" x-model="diag.gambar" required
                                                   placeholder="https://... atau pilih dari Pusat Media"
                                                   class="flex-1 px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:border-blue-500 transition">
                                            <button type="button" @click="openMediaPicker(`input_diag_${index}`)" 
                                                    class="px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1 cursor-pointer">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                Pilih Media
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <template x-if="diagramList.length === 0">
                            <div class="py-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-300 p-6">
                                <p class="text-xs text-slate-500">Belum ada bagan diagram. Klik tombol <strong>"Tambah Bagan Baru"</strong> di atas.</p>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <button type="submit" 
                            :disabled="submitLoading"
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition flex items-center gap-2 cursor-pointer disabled:opacity-50">
                        <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Bagan Diagram & Hero'"></span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Bagian B: Manajemen Pejabat Struktural (Relasi Database 100%) -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">2. Daftar Pejabat Struktural</h2>
                    <p class="text-xs text-slate-500">Tersimpan dan berelasi langsung dengan tabel Guru &amp; Staf di database.</p>
                </div>
                <button type="button" @click="openModalPejabat()"
                        class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-1.5 self-start cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Pejabat
                </button>
            </div>

            <!-- Tabel Pejabat Struktural -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3">Urutan</th>
                            <th class="px-4 py-3">Foto</th>
                            <th class="px-4 py-3">Nama Pejabat</th>
                            <th class="px-4 py-3">Jabatan Struktural</th>
                            <th class="px-4 py-3">Relasi Guru/Staf</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pejabatList as $pejabat)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-3 font-bold text-slate-500">{{ $pejabat->urutan }}</td>
                            <td class="px-4 py-3">
                                <div class="w-10 h-10 rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                    <img src="{{ !empty($pejabat->foto) ? $pejabat->foto : asset('images/logo-smkn2.svg') }}" 
                                         alt="{{ $pejabat->nama_lengkap }}" 
                                         class="w-full h-full object-cover">
                                </div>
                            </td>
                            <td class="px-4 py-3 font-bold text-slate-900">{{ $pejabat->nama_lengkap }}</td>
                            <td class="px-4 py-3 text-blue-700 font-semibold">{{ $pejabat->jabatan }}</td>
                            <td class="px-4 py-3">
                                @if($pejabat->guru)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">
                                        {{ $pejabat->guru->nama_lengkap }} (NIP: {{ $pejabat->guru->nip ?? '-' }})
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">- Langsung -</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right space-x-1 whitespace-nowrap">
                                <button type="button" 
                                        @click="editPejabat({
                                            id: {{ $pejabat->id }},
                                            nama: '{{ addslashes($pejabat->nama_lengkap) }}',
                                            jabatan: '{{ addslashes($pejabat->jabatan) }}',
                                            guru_id: '{{ $pejabat->guru_id }}',
                                            foto: '{{ addslashes($pejabat->foto) }}',
                                            urutan: {{ $pejabat->urutan }}
                                        })"
                                        class="px-2.5 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold rounded-lg transition cursor-pointer">
                                    Edit
                                </button>
                                <button type="button" 
                                        @click="deletePejabat({{ $pejabat->id }}, '{{ addslashes($pejabat->nama_lengkap) }}')"
                                        class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold rounded-lg transition cursor-pointer">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-400 italic">
                                Belum ada data pejabat struktural. Klik "Tambah Pejabat" untuk menambahkan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB 5: VISIBILITAS MENU & RUTE PUBLIK -->
    <div x-show="activeTab === 'visibilitas'" x-cloak class="space-y-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">Sakelar Visibilitas Menu &amp; Halaman Profil</h2>
                <p class="text-xs text-slate-500">
                    Sembunyikan atau tampilkan sub-menu profil di portal publik secara instan. Ketika dinonaktifkan, link akan hilang dari navbar desktop, menu HP (drawer), dan rute URL akan terlindungi otomatis (mengembalikan error 404).
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3">Item Menu / Halaman</th>
                            <th class="px-4 py-3">URL Path Rute</th>
                            <th class="px-4 py-3">Kode Fitur</th>
                            <th class="px-4 py-3">Status Saat Ini</th>
                            <th class="px-4 py-3 text-right">Sakelar Visibilitas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        
                        <!-- 1. Profil Utama -->
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-3.5 font-bold text-slate-900 flex items-center gap-2">
                                <div class="w-2.5 h-2.5 rounded-full bg-blue-600"></div>
                                Profil Utama (Overview)
                            </td>
                            <td class="px-4 py-3.5 font-mono text-slate-500">/profil</td>
                            <td class="px-4 py-3.5 font-mono text-xs text-blue-600">profil</td>
                            <td class="px-4 py-3.5">
                                <span :class="menuToggles['profil'] ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'"
                                      class="px-2.5 py-1 rounded-full text-[10px] font-bold">
                                    <span x-text="menuToggles['profil'] ? 'Tampil di Publik' : 'Disembunyikan'"></span>
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <button type="button" 
                                        @click="askToggleConfirmation(null, 'profil', 'Profil Utama', !menuToggles['profil'])"
                                        :class="menuToggles['profil'] ? 'bg-blue-600' : 'bg-slate-300'"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                    <span :style="menuToggles['profil'] ? 'transform: translateX(20px);' : 'transform: translateX(0px);'"
                                          class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md ring-0 transition-transform duration-300 ease-in-out"></span>
                                </button>
                            </td>
                        </tr>

                        <!-- 2. Sejarah Sekolah -->
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-3.5 font-semibold text-slate-800 flex items-center gap-2 pl-7">
                                <span class="text-slate-400">↳</span>
                                Sejarah Sekolah
                            </td>
                            <td class="px-4 py-3.5 font-mono text-slate-500">/profil/sejarah</td>
                            <td class="px-4 py-3.5 font-mono text-xs text-blue-600">sejarah</td>
                            <td class="px-4 py-3.5">
                                <span :class="menuToggles['sejarah'] ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'"
                                      class="px-2.5 py-1 rounded-full text-[10px] font-bold">
                                    <span x-text="menuToggles['sejarah'] ? 'Tampil di Publik' : 'Disembunyikan'"></span>
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <button type="button" 
                                        @click="askToggleConfirmation(null, 'sejarah', 'Sejarah Sekolah', !menuToggles['sejarah'])"
                                        :class="menuToggles['sejarah'] ? 'bg-blue-600' : 'bg-slate-300'"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                    <span :style="menuToggles['sejarah'] ? 'transform: translateX(20px);' : 'transform: translateX(0px);'"
                                          class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md ring-0 transition-transform duration-300 ease-in-out"></span>
                                </button>
                            </td>
                        </tr>

                        <!-- 3. Visi & Misi -->
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-3.5 font-semibold text-slate-800 flex items-center gap-2 pl-7">
                                <span class="text-slate-400">↳</span>
                                Visi &amp; Misi
                            </td>
                            <td class="px-4 py-3.5 font-mono text-slate-500">/profil/visi-misi</td>
                            <td class="px-4 py-3.5 font-mono text-xs text-blue-600">visi_misi</td>
                            <td class="px-4 py-3.5">
                                <span :class="menuToggles['visi_misi'] ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'"
                                      class="px-2.5 py-1 rounded-full text-[10px] font-bold">
                                    <span x-text="menuToggles['visi_misi'] ? 'Tampil di Publik' : 'Disembunyikan'"></span>
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <button type="button" 
                                        @click="askToggleConfirmation(null, 'visi_misi', 'Visi & Misi', !menuToggles['visi_misi'])"
                                        :class="menuToggles['visi_misi'] ? 'bg-blue-600' : 'bg-slate-300'"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                    <span :style="menuToggles['visi_misi'] ? 'transform: translateX(20px);' : 'transform: translateX(0px);'"
                                          class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md ring-0 transition-transform duration-300 ease-in-out"></span>
                                </button>
                            </td>
                        </tr>

                        <!-- 4. Struktur Organisasi -->
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-3.5 font-semibold text-slate-800 flex items-center gap-2 pl-7">
                                <span class="text-slate-400">↳</span>
                                Struktur Organisasi
                            </td>
                            <td class="px-4 py-3.5 font-mono text-slate-500">/profil/struktur</td>
                            <td class="px-4 py-3.5 font-mono text-xs text-blue-600">struktur_organisasi</td>
                            <td class="px-4 py-3.5">
                                <span :class="menuToggles['struktur_organisasi'] ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'"
                                      class="px-2.5 py-1 rounded-full text-[10px] font-bold">
                                    <span x-text="menuToggles['struktur_organisasi'] ? 'Tampil di Publik' : 'Disembunyikan'"></span>
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <button type="button" 
                                        @click="askToggleConfirmation(null, 'struktur_organisasi', 'Struktur Organisasi', !menuToggles['struktur_organisasi'])"
                                        :class="menuToggles['struktur_organisasi'] ? 'bg-blue-600' : 'bg-slate-300'"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                    <span :style="menuToggles['struktur_organisasi'] ? 'transform: translateX(20px);' : 'transform: translateX(0px);'"
                                          class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md ring-0 transition-transform duration-300 ease-in-out"></span>
                                </button>
                            </td>
                        </tr>

                        <!-- 5. Guru & Staf -->
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-3.5 font-semibold text-slate-800 flex items-center gap-2 pl-7">
                                <span class="text-slate-400">↳</span>
                                Guru &amp; Staf (Direktori PTK)
                            </td>
                            <td class="px-4 py-3.5 font-mono text-slate-500">/guru-staf</td>
                            <td class="px-4 py-3.5 font-mono text-xs text-blue-600">guru_staf</td>
                            <td class="px-4 py-3.5">
                                <span :class="menuToggles['guru_staf'] ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'"
                                      class="px-2.5 py-1 rounded-full text-[10px] font-bold">
                                    <span x-text="menuToggles['guru_staf'] ? 'Tampil di Publik' : 'Disembunyikan'"></span>
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <button type="button" 
                                        @click="askToggleConfirmation(null, 'guru_staf', 'Guru & Staf', !menuToggles['guru_staf'])"
                                        :class="menuToggles['guru_staf'] ? 'bg-blue-600' : 'bg-slate-300'"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                    <span :style="menuToggles['guru_staf'] ? 'transform: translateX(20px);' : 'transform: translateX(0px);'"
                                          class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md ring-0 transition-transform duration-300 ease-in-out"></span>
                                </button>
                            </td>
                        </tr>

                        <!-- 6. Fasilitas Sekolah -->
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-3.5 font-semibold text-slate-800 flex items-center gap-2 pl-7">
                                <span class="text-slate-400">↳</span>
                                Fasilitas &amp; Sarana Prasarana
                            </td>
                            <td class="px-4 py-3.5 font-mono text-slate-500">/fasilitas</td>
                            <td class="px-4 py-3.5 font-mono text-xs text-blue-600">fasilitas</td>
                            <td class="px-4 py-3.5">
                                <span :class="menuToggles['fasilitas'] ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'"
                                      class="px-2.5 py-1 rounded-full text-[10px] font-bold">
                                    <span x-text="menuToggles['fasilitas'] ? 'Tampil di Publik' : 'Disembunyikan'"></span>
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <button type="button" 
                                        @click="askToggleConfirmation(null, 'fasilitas', 'Fasilitas Sekolah', !menuToggles['fasilitas'])"
                                        :class="menuToggles['fasilitas'] ? 'bg-blue-600' : 'bg-slate-300'"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                    <span :style="menuToggles['fasilitas'] ? 'transform: translateX(20px);' : 'transform: translateX(0px);'"
                                          class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md ring-0 transition-transform duration-300 ease-in-out"></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- POP-UP MODAL KONFIRMASI UBAH VISIBILITAS -->
    <div x-show="modalConfirmToggleOpen" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-5 space-y-4 border border-slate-200"
             @click.outside="modalConfirmToggleOpen = false">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-slate-900 font-heading">Konfirmasi Visibilitas Menu</h3>
                    <p class="text-xs text-slate-500 mt-0.5" x-html="toggleConfirmMessage"></p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                <button type="button" @click="modalConfirmToggleOpen = false" 
                        class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="button" @click="executeConfirmedToggle()" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer">
                    Ya, Ubah Status
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL PEJABAT STRUKTURAL (ADD / EDIT) -->
    <div x-show="modalPejabatOpen" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden border border-slate-200"
             @click.outside="modalPejabatOpen = false">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <h3 class="font-bold text-sm text-slate-900 font-heading" x-text="pejabatForm.id ? 'Edit Pejabat Struktural' : 'Tambah Pejabat Struktural'"></h3>
                <button type="button" @click="modalPejabatOpen = false" class="text-slate-400 hover:text-slate-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form :action="pejabatForm.id ? `{{ url(app('tenant')->slug . '/admin/profil/pejabat') }}/${pejabatForm.id}` : `{{ route('tenant.admin.profil.pejabat.store', ['tenant' => app('tenant')->slug]) }}`" 
                  method="POST" class="p-5 space-y-4">
                @csrf
                <template x-if="pejabatForm.id">
                    @method('PUT')
                </template>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Hubungkan dengan Data Guru &amp; Staf (FK Database)</label>
                    <select name="guru_id" x-model="pejabatForm.guru_id" @change="onSelectGuru($event)"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        <option value="">-- Bukan dari direktori Guru/Staf --</option>
                        @foreach($guruList as $guru)
                            <option value="{{ $guru->id }}" data-nama="{{ $guru->nama_lengkap }}" data-foto="{{ $guru->foto ?? '' }}">
                                {{ $guru->nama_lengkap }} (NIP: {{ $guru->nip ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap &amp; Gelar <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_lengkap" x-model="pejabatForm.nama" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jabatan Struktural <span class="text-rose-500">*</span></label>
                    <input type="text" name="jabatan" x-model="pejabatForm.jabatan" required
                           placeholder="Contoh: Wakil Kepala Sekolah Bidang Kurikulum"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Foto Pejabat (Pusat Media)</label>
                    <div class="flex gap-2">
                        <input type="text" name="foto" id="input_foto_pejabat_modal" x-model="pejabatForm.foto"
                               class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                               placeholder="https://...">
                        <button type="button" @click="openMediaPicker('input_foto_pejabat_modal')" 
                                class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Pilih Media
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Urut Tampil</label>
                    <input type="number" name="urutan" x-model="pejabatForm.urutan" min="0"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" @click="modalPejabatOpen = false"
                            class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer">
                        Simpan Pejabat
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL INTEGRASI PUSAT MEDIA (MEDIA PICKER) -->
    <div x-show="mediaPickerOpen" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-2 sm:p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full h-[92vh] sm:h-[85vh] flex flex-col overflow-hidden border border-slate-200"
             @click.outside="mediaPickerOpen = false">
            
            <!-- Modal Header -->
            <div class="p-3 sm:p-4 border-b border-slate-200 flex items-center justify-between bg-slate-50 shrink-0">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-xs sm:text-sm text-slate-900 font-heading">Pusat Berkas Media (Pustaka Media Sekolah)</h3>
                        <p class="text-[10px] sm:text-[11px] text-slate-500">Pilih berkas dari database (12 per halaman) atau unggah baru.</p>
                    </div>
                </div>
                <button type="button" @click="mediaPickerOpen = false" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-lg hover:bg-slate-200/60 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Filter, Search & Upload Bar inside Picker -->
            <div class="px-3.5 py-3 border-b border-slate-200 bg-white flex flex-col md:flex-row items-stretch md:items-center justify-between gap-2.5 shrink-0">
                <!-- Tab Kategori Filter -->
                <div class="flex items-center gap-1.5 p-1 bg-slate-100/90 rounded-xl border border-slate-200/80 w-full sm:w-auto shrink-0">
                    <button type="button" @click="pickerFilterType = 'semua'; fetchMedia(1)"
                            :class="pickerFilterType === 'semua' ? 'bg-white text-blue-600 font-bold shadow-2xs' : 'text-slate-600 hover:text-slate-900'"
                            class="flex-1 sm:flex-initial px-3 py-1.5 rounded-lg text-xs transition cursor-pointer text-center">
                        Semua
                    </button>
                    <button type="button" @click="pickerFilterType = 'gambar'; fetchMedia(1)"
                            :class="pickerFilterType === 'gambar' ? 'bg-white text-blue-600 font-bold shadow-2xs' : 'text-slate-600 hover:text-slate-900'"
                            class="flex-1 sm:flex-initial px-3 py-1.5 rounded-lg text-xs transition cursor-pointer text-center">
                        Gambar
                    </button>
                    <button type="button" @click="pickerFilterType = 'video'; fetchMedia(1)"
                            :class="pickerFilterType === 'video' ? 'bg-white text-blue-600 font-bold shadow-2xs' : 'text-slate-600 hover:text-slate-900'"
                            class="flex-1 sm:flex-initial px-3 py-1.5 rounded-lg text-xs transition cursor-pointer text-center">
                        Video
                    </button>
                </div>

                <!-- Input Pencarian & Tombol Unggah Baru -->
                <div class="flex items-center gap-2 w-full md:w-auto">
                    <div class="relative flex-1 sm:w-64">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" x-model="pickerSearchQuery" @keyup.debounce.300ms="fetchMedia(1)"
                               placeholder="Cari nama berkas..."
                               class="w-full pl-9 pr-3 py-2 bg-slate-50 hover:bg-slate-100/70 border border-slate-300 rounded-xl text-xs text-slate-800 placeholder:text-slate-400 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                    </div>
                    
                    <!-- Direct Upload Button inside Modal -->
                    <label class="h-9 px-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition inline-flex items-center justify-center gap-1.5 cursor-pointer shrink-0 shadow-xs active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <span class="whitespace-nowrap">Unggah Baru</span>
                        <input type="file" @change="uploadNewMedia($event)" class="hidden" accept="image/*,video/*">
                    </label>
                </div>
            </div>

            <!-- Media Grid Content -->
            <div class="flex-1 overflow-y-auto p-3 sm:p-4 taildash-scrollbar bg-slate-50/50">
                <template x-if="pickerLoading">
                    <div class="h-64 flex flex-col items-center justify-center text-slate-400 gap-2">
                        <svg class="animate-spin w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-xs">Memuat pustaka media dari database...</span>
                    </div>
                </template>

                <template x-if="!pickerLoading && mediaItems.length === 0">
                    <div class="h-64 flex flex-col items-center justify-center text-slate-400 text-center p-6">
                        <svg class="w-12 h-12 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-xs font-semibold text-slate-600">Belum ada media yang cocok</p>
                        <p class="text-[11px] text-slate-400 mt-1">Unggah berkas baru atau ubah kata kunci pencarian.</p>
                    </div>
                </template>

                <template x-if="!pickerLoading && mediaItems.length > 0">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2.5 sm:gap-3">
                        <template x-for="item in mediaItems" :key="item.id">
                            <div class="group relative rounded-xl border border-slate-200 bg-white overflow-hidden shadow-xs hover:border-blue-500 hover:shadow-md transition cursor-pointer flex flex-col justify-between"
                                 @click="selectMediaItem(item)">
                                <div class="aspect-square bg-slate-900 overflow-hidden relative flex items-center justify-center">
                                    
                                    <!-- 1. Gambar -->
                                    <template x-if="item.tipe_media === 'gambar'">
                                        <img :src="item.url" :alt="item.judul" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                    </template>

                                    <!-- 2. Video YouTube (Thumbnail Otomatis) -->
                                    <template x-if="item.tipe_media === 'youtube'">
                                        <div class="w-full h-full relative overflow-hidden bg-slate-900">
                                            <template x-if="getYoutubeThumbnail(item.url)">
                                                <img :src="getYoutubeThumbnail(item.url)" :alt="item.judul" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                            </template>
                                            <template x-if="!getYoutubeThumbnail(item.url)">
                                                <div class="w-full h-full flex items-center justify-center bg-red-950 text-white p-2">
                                                    <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                                </div>
                                            </template>
                                            <!-- YouTube Badge Overlay -->
                                            <div class="absolute bottom-1 right-1 bg-red-600/90 text-white text-[8px] font-bold px-1.5 py-0.5 rounded flex items-center gap-0.5 shadow-sm">
                                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                                <span>YouTube</span>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- 3. Video Lokal / MP4 (Thumbnail Live Video Preview) -->
                                    <template x-if="item.tipe_media === 'video'">
                                        <div class="w-full h-full relative overflow-hidden bg-slate-950 flex items-center justify-center">
                                            <video :src="item.url" preload="metadata" muted playsinline class="w-full h-full object-cover pointer-events-none opacity-80 group-hover:scale-105 transition-transform duration-200"></video>
                                            <div class="absolute inset-0 flex items-center justify-center bg-black/25">
                                                <div class="w-7 h-7 rounded-full bg-blue-600/90 text-white flex items-center justify-center shadow-md">
                                                    <svg class="w-3.5 h-3.5 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                                </div>
                                            </div>
                                            <div class="absolute bottom-1 right-1 bg-slate-900/80 backdrop-blur-xs text-white text-[8px] font-mono font-bold px-1.5 py-0.5 rounded shadow-sm">
                                                MP4
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Hover Select Button Overlay -->
                                    <div class="absolute inset-0 bg-blue-600/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <span class="px-2 py-1 bg-blue-600 text-white text-[10px] font-bold rounded-md shadow-sm">Pilih</span>
                                    </div>
                                </div>
                                <div class="p-2 bg-white">
                                    <p class="text-[11px] font-semibold text-slate-800 truncate" :title="item.judul" x-text="item.judul"></p>
                                    <div class="flex items-center justify-between text-[9px] text-slate-400 mt-0.5">
                                        <span class="capitalize" x-text="item.tipe_media"></span>
                                        <span class="text-blue-600 font-medium group-hover:underline">Pilih &rarr;</span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </div>

            <!-- Modal Footer & Pagination -->
            <div class="p-2.5 sm:p-3 border-t border-slate-200 bg-slate-50 flex flex-col sm:flex-row items-center justify-between gap-2.5 text-xs text-slate-600 shrink-0">
                <div class="flex items-center justify-between sm:justify-start w-full sm:w-auto gap-3 text-[11px] sm:text-xs">
                    <span class="font-medium text-slate-600" x-text="`Total ${pickerTotal} berkas (12/hal)`"></span>
                    <span class="text-slate-400 hidden sm:inline">&bull;</span>
                    <span class="text-slate-500" x-text="`Hal ${pickerCurrentPage} dari ${pickerLastPage}`"></span>
                </div>

                <!-- Pagination Buttons -->
                <div class="flex items-center gap-1.5 w-full sm:w-auto justify-between sm:justify-end">
                    <div class="flex items-center gap-1">
                        <button type="button" 
                                @click="fetchMedia(pickerCurrentPage - 1)" 
                                :disabled="pickerCurrentPage <= 1 || pickerLoading"
                                class="px-2.5 py-1 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 text-xs font-semibold rounded-lg transition cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            <span>Sebelumnya</span>
                        </button>
                        
                        <span class="px-2 py-1 bg-blue-50 text-blue-700 font-bold border border-blue-200 rounded-lg text-xs" x-text="pickerCurrentPage"></span>

                        <button type="button" 
                                @click="fetchMedia(pickerCurrentPage + 1)" 
                                :disabled="pickerCurrentPage >= pickerLastPage || pickerLoading"
                                class="px-2.5 py-1 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 text-xs font-semibold rounded-lg transition cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed flex items-center gap-1">
                            <span>Selanjutnya</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>

                    <button type="button" @click="mediaPickerOpen = false" 
                            class="px-3.5 py-1 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-lg text-xs transition cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL KONFIRMASI HAPUS PEJABAT -->
    <div x-show="modalDeleteOpen" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-5 space-y-4 border border-slate-200"
             @click.outside="modalDeleteOpen = false">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-slate-900 font-heading">Hapus Pejabat Struktural?</h3>
                    <p class="text-xs text-slate-500 mt-0.5" x-text="`Apakah Anda yakin ingin menghapus '${deleteTargetNama}'?`"></p>
                </div>
            </div>

            <form :action="`{{ url(app('tenant')->slug . '/admin/profil/pejabat') }}/${deleteTargetId}`" method="POST" class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                @csrf
                @method('DELETE')
                <button type="button" @click="modalDeleteOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<!-- Quill.js WYSIWYG Editor Script -->
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('profilManager', (config) => ({
            activeTab: config.activeTab || 'identitas',
            showToast: !!config.toastMsg,
            toastMessage: config.toastMsg || '',
            submitLoading: false,
            logoPreview: '{{ old('logo', $pengaturan['logo'] ?? '') }}',

            // Quill Editors
            quillSejarah: null,
            quillVisiMisi: null,

            // Diagram Repeater List
            diagramList: Array.isArray(config.diagrams) ? JSON.parse(JSON.stringify(config.diagrams)) : [],

            // Modals
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
                urutan: 1
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

            // Media Picker
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

            // Menu toggles
            menuToggles: {
                profil: {{ $fiturProfil['profil'] ? 'true' : 'false' }},
                sejarah: {{ $fiturProfil['sejarah'] ? 'true' : 'false' }},
                visi_misi: {{ $fiturProfil['visi_misi'] ? 'true' : 'false' }},
                struktur_organisasi: {{ $fiturProfil['struktur_organisasi'] ? 'true' : 'false' }},
                guru_staf: {{ $fiturProfil['guru_staf'] ? 'true' : 'false' }},
                fasilitas: {{ $fiturProfil['fasilitas'] ? 'true' : 'false' }}
            },

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
                const quill = editorId === 'editor_sejarah' ? this.quillSejarah : this.quillVisiMisi;
                if (quill) {
                    document.getElementById(textareaId).value = quill.root.innerHTML;
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
                    const res = await fetch(`{{ route('tenant.admin.media.index', ['tenant' => app('tenant')->slug]) }}?${params}`, {
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
                    }
                    if (this.mediaPickerTargetInput === 'input_logo_sekolah') {
                        this.logoPreview = item.url;
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
                    const res = await fetch(`{{ route('tenant.admin.media.upload', ['tenant' => app('tenant')->slug]) }}`, {
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
                } catch (e) {
                    this.triggerToast('Terjadi gangguan jaringan atau server saat mengunggah berkas.');
                } finally {
                    fileInput.value = '';
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
                    urutan: {{ $pejabatList->count() + 1 }}
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
                    }
                }
            },

            deletePejabat(id, nama) {
                this.deleteTargetId = id;
                this.deleteTargetNama = nama;
                this.modalDeleteOpen = true;
            },

            // Confirmation Pop-up Before Visibility Toggle
            askToggleConfirmation(menuId, kodeFitur, labelNama, targetState) {
                this.pendingToggleMenuId = menuId;
                this.pendingToggleKodeFitur = kodeFitur;
                this.pendingToggleLabel = labelNama;
                this.pendingToggleTargetState = targetState;

                const statusText = targetState ? '<strong class="text-blue-600">MENAMPILKAN (AKTIF)</strong>' : '<strong class="text-rose-600">MENYEMBUNYIKAN (NONAKTIF)</strong>';
                const dampakText = targetState 
                    ? 'Menu akan kembali tampil di navbar publik dan rutenya dapat diakses oleh pengunjung.' 
                    : 'Menu akan otomatis hilang dari navbar publik dan rutenya akan mengembalikan 404 (Not Found).';

                this.toggleConfirmMessage = `Apakah Anda yakin ingin ${statusText} halaman/menu <strong>${labelNama}</strong>?<br><span class="text-slate-400 mt-1 block">${dampakText}</span>`;
                this.modalConfirmToggleOpen = true;
            },

            async executeConfirmedToggle() {
                this.modalConfirmToggleOpen = false;
                const menuId = this.pendingToggleMenuId;
                const kodeFitur = this.pendingToggleKodeFitur;
                const targetState = this.pendingToggleTargetState;

                try {
                    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const res = await fetch(`{{ route('tenant.admin.profil.toggle-menu', ['tenant' => app('tenant')->slug]) }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            menu_id: menuId,
                            kode_fitur: kodeFitur,
                            is_aktif: targetState
                        })
                    });
                    const result = await res.json();
                    if (result.success) {
                        if (kodeFitur && this.menuToggles.hasOwnProperty(kodeFitur)) {
                            this.menuToggles[kodeFitur] = targetState;
                        }
                        this.triggerToast(result.message);
                    }
                } catch (e) {
                    alert('Gagal memperbarui status visibilitas.');
                }
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
