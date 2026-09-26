@extends('layouts.tenant_admin')

@section('title', 'Tambah Slider Beranda')
@section('header_title', 'Tambah Slider Baru')

@section('content')
<div class="max-w-3xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-base font-bold text-slate-900">Formulir Tambah Banner Hero</h3>
            <p class="text-xs text-slate-500 mt-0.5">Lengkapi data gambar dan teks untuk banner beranda baru.</p>
        </div>

        <form action="{{ route('tenant.admin.slider.store', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Judul Banner (Headline)</label>
                <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Mencetak Generasi Vokasi Berdaya Saing Global" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Subjudul / Deskripsi Singkat</label>
                <textarea name="subjudul" rows="2" placeholder="Deskripsi ringkas yang memikat pengunjung..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500">{{ old('subjudul') }}</textarea>
            </div>

            <div>
                <x-admin.input-gambar 
                    name="gambar" 
                    value="{{ old('gambar') }}" 
                    label="Gambar Banner Hero" 
                    recommended="Format JPG, PNG, atau WebP. Maks 2MB. Rekomendasi rasio 16:9 (1600x900px)." 
                    :required="true" 
                />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Teks Tombol (Opsional)</label>
                    <input type="text" name="teks_tombol" value="{{ old('teks_tombol') }}" placeholder="Contoh: Info SPMB 2026" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tautan URL Tombol</label>
                    <input type="text" name="link_tombol" value="{{ old('link_tombol') }}" placeholder="Contoh: /spmb atau /program-keahlian" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Urutan Tampil *</label>
                    <input type="number" name="urutan" value="{{ old('urutan', $urutanBerikutnya) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex items-center pt-6">
                    <label class="flex items-center text-xs font-semibold text-slate-700 cursor-pointer select-none">
                        <input type="checkbox" name="is_aktif" value="1" {{ old('is_aktif', true) ? 'checked' : '' }} class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                        <span class="ml-2">Aktifkan slider ini di beranda</span>
                    </label>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('tenant.admin.slider.index', ['tenant' => $tenant->slug]) }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50 transition">
                    &larr; Batal & Kembali
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-600 text-white text-xs font-bold shadow-sm transition cursor-pointer">
                    Simpan Slider
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
