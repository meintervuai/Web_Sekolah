@extends('layouts.tenant_admin')

@section('title', 'Tambah Fasilitas')
@section('header_title', 'Tambah Fasilitas Sekolah')

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-900">Formulir Sarana & Fasilitas</h3>
            <a href="{{ route('tenant.admin.fasilitas.index', ['tenant' => $tenant->slug]) }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                &larr; Kembali ke Daftar
            </a>
        </div>

        <form action="{{ route('tenant.admin.fasilitas.store', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Fasilitas / Laboratorium</label>
                    <input type="text" name="nama_fasilitas" value="{{ old('nama_fasilitas') }}" required placeholder="Contoh: Laboratorium Praktik CNC & Bubut Modern" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                </div>

                <x-admin.input-gambar 
                    name="foto_utama" 
                    label="Foto Utama Fasilitas / Ruang Praktik" 
                    :value="old('foto_utama')" 
                    maxSize="2MB" 
                    recommendedResolution="Landscape 1200 x 800 px (3:2 / 16:9)" />

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi Spesifikasi & Pemanfaatan Fasilitas</label>
                    <textarea name="deskripsi" rows="4" required placeholder="Jelaskan kapasitas alat, merk mesin industri yang digunakan, dan peruntukan praktiknya..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white leading-relaxed">{{ old('deskripsi') }}</textarea>
                </div>

                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_aktif" value="1" {{ old('is_aktif', true) ? 'checked' : '' }} class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-xs font-semibold text-slate-700">Aktifkan dan tampilkan di halaman fasilitas publik</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex justify-end gap-3">
                <a href="{{ route('tenant.admin.fasilitas.index', ['tenant' => $tenant->slug]) }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-md transition cursor-pointer">
                    Simpan Fasilitas
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
