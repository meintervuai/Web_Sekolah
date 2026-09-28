@extends('layouts.tenant_admin')

@section('title', 'Tambah Prestasi Siswa')
@section('header_title', 'Tambah Prestasi Siswa')

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900 tracking-tight">Formulir Capaian Prestasi Siswa</h3>
                <p class="text-xs text-slate-500 mt-0.5">Catat prestasi dan apresiasi kejuaraan siswa</p>
            </div>
            <a href="{{ route('tenant.admin.prestasi.index', ['tenant' => $tenant->slug]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>

        <form action="{{ route('tenant.admin.prestasi.store', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf

            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Kejuaraan / Prestasi <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_prestasi" value="{{ old('nama_prestasi') }}" required placeholder="Contoh: Juara 1 Lomba Kompetensi Siswa (LKS) Bidang Cyber Security" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Siswa / Tim <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_siswa" value="{{ old('nama_siswa') }}" required placeholder="Contoh: Muhammad Farhan & Tim" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tingkat Kejuaraan <span class="text-rose-500">*</span></label>
                        <select name="tingkat" required class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                            <option value="Kota" {{ old('tingkat') == 'Kota' ? 'selected' : '' }}>Kota / Kabupaten</option>
                            <option value="Provinsi" {{ old('tingkat') == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                            <option value="Nasional" {{ old('tingkat') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                            <option value="Internasional" {{ old('tingkat') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tahun <span class="text-rose-500">*</span></label>
                        <input type="number" name="tahun" value="{{ old('tahun', date('Y')) }}" required class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Perolehan <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full max-w-xs px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                </div>

                <x-admin.input-gambar 
                    name="foto" 
                    label="Foto Dokumentasi / Piagam Prestasi" 
                    :value="old('foto')" 
                    recommended="Format JPG, PNG, atau WebP. Maks 2MB. Rekomendasi 1000x750px." />

                <div>
                    <x-admin.quill-editor 
                        name="deskripsi" 
                        value="{{ old('deskripsi') }}" 
                        label="Keterangan Lengkap Prestasi" 
                        placeholder="Uraikan detail penyelenggara lomba, medali yang diraih, dan cerita inspiratif di baliknya..." 
                        height="200px"
                    />
                </div>
            </div>

            <div class="pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('tenant.admin.prestasi.index', ['tenant' => $tenant->slug]) }}" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs hover:shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Prestasi
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
