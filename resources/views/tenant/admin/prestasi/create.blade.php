@extends('layouts.tenant_admin')

@section('title', 'Tambah Prestasi Siswa')
@section('header_title', 'Tambah Prestasi Siswa')

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-900">Formulir Capaian Prestasi Siswa</h3>
            <a href="{{ route('tenant.admin.prestasi.index', ['tenant' => $tenant->slug]) }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                &larr; Kembali ke Daftar
            </a>
        </div>

        <form action="{{ route('tenant.admin.prestasi.store', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Kejuaraan / Prestasi</label>
                    <input type="text" name="nama_prestasi" value="{{ old('nama_prestasi') }}" required placeholder="Contoh: Juara 1 Lomba Kompetensi Siswa (LKS) Bidang Cyber Security" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Siswa / Tim Pemenang</label>
                        <input type="text" name="nama_siswa" value="{{ old('nama_siswa') }}" required placeholder="Contoh: Muhammad Farhan & Tim" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tingkat Kejuaraan</label>
                        <select name="tingkat" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                            <option value="Kota" {{ old('tingkat') == 'Kota' ? 'selected' : '' }}>Kota / Kabupaten</option>
                            <option value="Provinsi" {{ old('tingkat') == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                            <option value="Nasional" {{ old('tingkat') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                            <option value="Internasional" {{ old('tingkat') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tahun</label>
                        <input type="number" name="tahun" value="{{ old('tahun', date('Y')) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Perolehan</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full max-w-xs px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                </div>

                <x-admin.input-gambar 
                    name="foto" 
                    label="Foto Dokumentasi / Piagam Prestasi" 
                    :value="old('foto')" 
                    maxSize="2MB" 
                    recommendedResolution="Format Landscape / Kotak (1000 x 750 px)" />

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Keterangan / Uraian Prestasi</label>
                    <textarea name="deskripsi" rows="4" placeholder="Uraikan detail medali, piagam, dan apresiasi yang diraih..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white leading-relaxed">{{ old('deskripsi') }}</textarea>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex justify-end gap-3">
                <a href="{{ route('tenant.admin.prestasi.index', ['tenant' => $tenant->slug]) }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-md transition cursor-pointer">
                    Simpan Prestasi
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
