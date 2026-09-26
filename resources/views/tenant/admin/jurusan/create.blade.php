@extends('layouts.tenant_admin')

@section('title', 'Tambah Program Keahlian')
@section('header_title', 'Tambah Program Keahlian')

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-900">Formulir Program Keahlian Baru</h3>
            <a href="{{ route('tenant.admin.jurusan.index', ['tenant' => $tenant->slug]) }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                &larr; Kembali ke Daftar
            </a>
        </div>

        <form action="{{ route('tenant.admin.jurusan.store', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Program Keahlian <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_jurusan" value="{{ old('nama_jurusan') }}" required placeholder="Contoh: Teknik Mesin" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Singkatan / Kode <span class="text-rose-500">*</span></label>
                    <input type="text" name="singkatan" value="{{ old('singkatan') }}" required placeholder="Contoh: TM" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                </div>
                <div class="md:col-span-2">
                    <x-admin.input-gambar 
                        name="ikon_atau_foto" 
                        value="{{ old('ikon_atau_foto') }}" 
                        label="Foto / Banner Program Keahlian" 
                        recommended="Format JPG, PNG, atau WebP. Maks 2MB. Rekomendasi 1200x800px." 
                    />
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Urutan Tampil <span class="text-rose-500">*</span></label>
                    <input type="number" name="urutan" value="{{ old('urutan', $urutanBerikutnya) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                </div>
                <div class="md:col-span-3">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi Singkat (Tampil di Card Beranda & List)</label>
                    <textarea name="deskripsi_singkat" rows="3" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white leading-relaxed">{{ old('deskripsi_singkat') }}</textarea>
                </div>
                <div class="md:col-span-3">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi Lengkap / Silabus & Prospek Kerja (HTML / Teks)</label>
                    <textarea name="deskripsi_lengkap" rows="6" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white leading-relaxed font-mono">{{ old('deskripsi_lengkap') }}</textarea>
                </div>
                <div class="md:col-span-3">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_aktif" value="1" {{ old('is_aktif', true) ? 'checked' : '' }} class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-xs font-semibold text-slate-700">Aktifkan dan tampilkan di navigasi publik</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex justify-end gap-3">
                <a href="{{ route('tenant.admin.jurusan.index', ['tenant' => $tenant->slug]) }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-md transition cursor-pointer">
                    Simpan Program Keahlian
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
