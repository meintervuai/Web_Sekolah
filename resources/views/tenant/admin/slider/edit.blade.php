@extends('layouts.tenant_admin')

@section('title', 'Edit Slider Beranda')
@section('header_title', 'Perbarui Slider Banner')

@section('content')
<div class="max-w-3xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900 tracking-tight">Perbarui Slider #{{ $slider->id }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">Edit teks headline, gambar cover, atau tautan banner beranda</p>
            </div>
            <a href="{{ route('tenant.admin.slider.index', ['tenant' => $tenant->slug]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>

        <form action="{{ route('tenant.admin.slider.update', ['tenant' => $tenant->slug, 'slider' => $slider->id]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Banner (Headline)</label>
                    <input type="text" name="judul" value="{{ old('judul', $slider->judul) }}" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Subjudul / Deskripsi Singkat</label>
                    <textarea name="subjudul" rows="2" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition leading-relaxed">{{ old('subjudul', $slider->subjudul) }}</textarea>
                </div>

                <!-- Pilihan Tipe Media: Gambar atau Video -->
                <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/90 space-y-4">
                    <div class="border-b border-slate-200 pb-2.5 flex items-center justify-between">
                        <div>
                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider">Media Banner Hero</label>
                            <p class="text-[11px] text-slate-500 font-medium">Unggah gambar, video, atau keduanya. Jika ada video, video akan diputar terlebih dahulu sebelum beralih ke slide berikutnya.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <!-- 1. Input Gambar -->
                        <div>
                            <x-admin.input-gambar 
                                name="gambar" 
                                value="{{ old('gambar', $slider->gambar) }}" 
                                label="1. Gambar Banner Hero (Background / Fallback)" 
                                recommended="Format JPG, PNG, atau WebP. Maks 4MB. Rekomendasi rasio 16:9 (1600x900px)." 
                                :required="false" 
                            />
                        </div>

                        <!-- 2. Input Video -->
                        <div class="p-4 rounded-xl bg-white border border-slate-200/80 space-y-3">
                            <div class="flex items-center gap-2 text-slate-800">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                <span class="text-xs font-bold">2. Video Banner Hero (Opsional)</span>
                            </div>

                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Unggah Berkas Video Baru (MP4 / WebM, Maks 50MB)</label>
                                <input type="file" name="video_file" accept="video/mp4,video/webm,video/ogg" class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer bg-slate-50/50 border border-slate-200 rounded-xl transition">
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="h-px bg-slate-200 flex-1"></div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">ATAU LINK URL VIDEO</span>
                                <div class="h-px bg-slate-200 flex-1"></div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">URL Video Langsung (CDN / Hosting)</label>
                                <input type="url" name="video" value="{{ old('video', $slider->video) }}" placeholder="https://domain.com/video-banner.mp4" class="w-full px-3.5 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                            </div>

                            @if(!empty($slider->video))
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-3">
                                <div class="text-[11px] text-slate-600 flex items-center gap-2 truncate">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 font-bold text-[10px] border border-blue-200/60">Video Aktif</span>
                                    <span class="font-mono truncate max-w-xs">{{ $slider->video }}</span>
                                </div>
                                <a href="{{ $slider->video }}" target="_blank" class="shrink-0 text-xs font-bold text-blue-600 hover:text-blue-800 transition inline-flex items-center gap-1">
                                    Buka Video
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Teks Tombol (Opsional)</label>
                        <input type="text" name="teks_tombol" value="{{ old('teks_tombol', $slider->teks_tombol) }}" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tautan URL Tombol</label>
                        <input type="text" name="link_tombol" value="{{ old('link_tombol', $slider->link_tombol) }}" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Urutan Tampil <span class="text-rose-500">*</span></label>
                        <input type="number" name="urutan" value="{{ old('urutan', $slider->urutan) }}" required class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>

                    <div class="flex items-center pt-6">
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox" name="is_aktif" value="1" {{ old('is_aktif', $slider->is_aktif) ? 'checked' : '' }} class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                            <span class="text-xs sm:text-sm font-semibold text-slate-700">Aktifkan slider langsung di beranda</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('tenant.admin.slider.index', ['tenant' => $tenant->slug]) }}" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs hover:shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Perbarui Slider
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
