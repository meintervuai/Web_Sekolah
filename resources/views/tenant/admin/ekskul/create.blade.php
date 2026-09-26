@extends('layouts.tenant_admin')

@section('title', 'Tambah Ekstrakurikuler')
@section('header_title', 'Tambah Ekstrakurikuler')

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-900">Formulir Ekstrakurikuler Baru</h3>
            <a href="{{ route('tenant.admin.ekskul.index', ['tenant' => $tenant->slug]) }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                &larr; Kembali ke Daftar
            </a>
        </div>

        <form action="{{ route('tenant.admin.ekskul.store', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Ekstrakurikuler</label>
                    <input type="text" name="nama_ekstrakurikuler" value="{{ old('nama_ekstrakurikuler') }}" required placeholder="Contoh: Paskibra (Pasukan Pengibar Bendera)" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Guru Pembina</label>
                        <input type="text" name="pembina" value="{{ old('pembina') }}" placeholder="Contoh: Drs. Yayat Supriatna" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Hari Latihan</label>
                        <input type="text" name="hari_jadwal" value="{{ old('hari_jadwal') }}" placeholder="Contoh: Setiap Rabu & Sabtu" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                    </div>
                    <div>
                        <x-admin.input-waktu name="waktu_jadwal" label="Jam / Waktu Mulai Latihan" :value="old('waktu_jadwal', '15:30 WIB')" />
                    </div>
                </div>

                <x-admin.input-gambar 
                    name="foto" 
                    label="Foto / Logo Ekstrakurikuler" 
                    :value="old('foto')" 
                    maxSize="2MB" 
                    recommendedResolution="Landscape / Kotak (1000 x 750 px)" />

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi & Program Kerja Ekskul</label>
                    <textarea name="deskripsi" rows="4" required placeholder="Jelaskan tujuan, materi pembinaan, dan target kejuaraan ekskul..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white leading-relaxed">{{ old('deskripsi') }}</textarea>
                </div>

                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_aktif" value="1" {{ old('is_aktif', true) ? 'checked' : '' }} class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-xs font-semibold text-slate-700">Aktifkan ekskul ini dan tampilkan di website publik</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex justify-end gap-3">
                <a href="{{ route('tenant.admin.ekskul.index', ['tenant' => $tenant->slug]) }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-md transition cursor-pointer">
                    Simpan Ekstrakurikuler
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
