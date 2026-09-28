@extends('layouts.tenant_admin')

@section('title', 'Tambah Ekstrakurikuler')
@section('header_title', 'Tambah Ekstrakurikuler')

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900 tracking-tight">Formulir Ekstrakurikuler Baru</h3>
                <p class="text-xs text-slate-500 mt-0.5">Tambah data kegiatan pembinaan minat dan bakat siswa</p>
            </div>
            <a href="{{ route('tenant.admin.ekskul.index', ['tenant' => $tenant->slug]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>

        <form action="{{ route('tenant.admin.ekskul.store', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf

            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Ekstrakurikuler <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_ekstrakurikuler" value="{{ old('nama_ekstrakurikuler') }}" required placeholder="Contoh: Paskibra (Pasukan Pengibar Bendera)" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Guru Pembina</label>
                        <input type="text" name="pembina" value="{{ old('pembina') }}" placeholder="Contoh: Drs. Yayat Supriatna" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Hari Latihan</label>
                        <input type="text" name="hari_jadwal" value="{{ old('hari_jadwal') }}" placeholder="Contoh: Setiap Rabu & Sabtu" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                    <div>
                        <x-admin.input-waktu name="waktu_jadwal" label="Jam Mulai Latihan" :value="old('waktu_jadwal', '15:30 WIB')" />
                    </div>
                </div>

                <x-admin.input-gambar 
                    name="foto" 
                    label="Foto / Logo Ekstrakurikuler" 
                    :value="old('foto')" 
                    recommended="Format JPG, PNG, atau WebP. Maks 2MB. Rekomendasi 1000x750px." />

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi & Program Kerja Ekskul</label>
                    <textarea name="deskripsi" rows="4" required placeholder="Jelaskan tujuan pembinaan, silabus kegiatan, dan target kejuaraan ekskul..." class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition leading-relaxed">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="pt-2">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="is_aktif" value="1" {{ old('is_aktif', true) ? 'checked' : '' }} class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                        <span class="text-xs sm:text-sm font-semibold text-slate-700">Aktifkan ekskul ini dan tampilkan di website publik</span>
                    </label>
                </div>
            </div>

            <div class="pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('tenant.admin.ekskul.index', ['tenant' => $tenant->slug]) }}" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs hover:shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Ekstrakurikuler
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
