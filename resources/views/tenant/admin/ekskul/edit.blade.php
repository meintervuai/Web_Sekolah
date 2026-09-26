@extends('layouts.tenant_admin')

@section('title', 'Edit Ekstrakurikuler')
@section('header_title', 'Edit Ekstrakurikuler: ' . $ekskul->nama_ekstrakurikuler)

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-900">Perbarui Data Ekstrakurikuler</h3>
            <a href="{{ route('tenant.admin.ekskul.index', ['tenant' => $tenant->slug]) }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                &larr; Kembali ke Daftar
            </a>
        </div>

        <form action="{{ route('tenant.admin.ekskul.update', ['tenant' => $tenant->slug, 'ekskul' => $ekskul->id]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Ekstrakurikuler</label>
                    <input type="text" name="nama_ekstrakurikuler" value="{{ old('nama_ekstrakurikuler', $ekskul->nama_ekstrakurikuler) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Guru Pembina</label>
                        <input type="text" name="pembina" value="{{ old('pembina', $ekskul->pembina) }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Hari Latihan</label>
                        <input type="text" name="hari_jadwal" value="{{ old('hari_jadwal', $ekskul->hari_jadwal) }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                    </div>
                    <div>
                        <x-admin.input-waktu name="waktu_jadwal" label="Jam / Waktu Mulai Latihan" :value="old('waktu_jadwal', $ekskul->waktu_jadwal)" />
                    </div>
                </div>

                <x-admin.input-gambar 
                    name="foto" 
                    label="Foto / Logo Ekstrakurikuler" 
                    :value="old('foto', $ekskul->foto)" 
                    maxSize="2MB" 
                    recommendedResolution="Landscape / Kotak (1000 x 750 px)" />

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi & Program Kerja Ekskul</label>
                    <textarea name="deskripsi" rows="4" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white leading-relaxed">{{ old('deskripsi', $ekskul->deskripsi) }}</textarea>
                </div>

                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_aktif" value="1" {{ old('is_aktif', $ekskul->is_aktif) ? 'checked' : '' }} class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-xs font-semibold text-slate-700">Aktifkan ekskul ini dan tampilkan di website publik</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex justify-end gap-3">
                <a href="{{ route('tenant.admin.ekskul.index', ['tenant' => $tenant->slug]) }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-md transition cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
