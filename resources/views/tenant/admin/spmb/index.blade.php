@extends('layouts.tenant_admin')

@section('title', 'Navigasi SPMB')
@section('header_title', 'Kelola Informasi SPMB / PPDB')

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100">
            <h3 class="text-sm font-bold text-slate-900">Petunjuk Teknis & Informasi SPMB</h3>
            <p class="text-xs text-slate-500 mt-0.5">Kelola jalur pendaftaran, persyaratan berkas, tautan portal dinas, dan pengumuman penerimaan murid baru</p>
        </div>

        <form action="{{ route('tenant.admin.spmb.update', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Judul Halaman -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Halaman SPMB / PPDB <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul', $spmb->judul ?? 'Sistem Penerimaan Murid Baru (SPMB / PPDB) 2026/2027') }}" required class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                </div>

                <!-- Input Gambar Sampul dengan Auto-Compress WebP -->
                <div>
                    <x-admin.input-gambar 
                        name="gambar_banner" 
                        value="{{ old('gambar_banner', $spmb->gambar_banner ?? '') }}" 
                        label="Banner Gambar Sampul SPMB" 
                        recommended="Format JPG, PNG, atau WebP. Maks 2MB. Rekomendasi lebar 1200 - 1600px." 
                    />
                </div>

                <!-- Pengantar / Sambutan SPMB -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kalimat Pengantar SPMB</label>
                    <textarea name="pengantar" rows="3" placeholder="Tuliskan kalimat pembuka pengumuman PPDB..." class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition leading-relaxed">{{ old('pengantar', $pengantar) }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1.5">Penjelasan singkat mengenai mekanisme seleksi penerimaan murid baru.</p>
                </div>

                <!-- Form Terstruktur: Jalur Penerimaan -->
                <div class="bg-slate-50/70 p-5 sm:p-6 rounded-2xl border border-slate-200/90 space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        1. Form Input Jalur Penerimaan (Format Terstruktur)
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jalur Pendaftaran Tahap 1 <span class="text-rose-500">*</span></label>
                            <textarea name="jalur_tahap_1" rows="3" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 leading-relaxed focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">{{ old('jalur_tahap_1', $jalurTahap1) }}</textarea>
                            <span class="text-[11px] text-slate-400 mt-1 block">Contoh: Tahap 1: Jalur Afirmasi (KETM), Prioritas Terdekat (Zonasi), dll.</span>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jalur Pendaftaran Tahap 2 <span class="text-rose-500">*</span></label>
                            <textarea name="jalur_tahap_2" rows="3" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 leading-relaxed focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">{{ old('jalur_tahap_2', $jalurTahap2) }}</textarea>
                            <span class="text-[11px] text-slate-400 mt-1 block">Contoh: Tahap 2: Jalur Prestasi Nilai Rapor Umum & Kejuaraan.</span>
                        </div>
                    </div>
                </div>

                <!-- Form Terstruktur: Persyaratan Berkas Dokumen -->
                <div class="bg-slate-50/70 p-5 sm:p-6 rounded-2xl border border-slate-200/90 space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        2. Form Persyaratan Umum & Dokumen Berkas
                    </h4>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Daftar Persyaratan (Satu baris per poin persyaratan) <span class="text-rose-500">*</span></label>
                        <textarea name="persyaratan_umum" rows="5" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800 leading-relaxed focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">{{ old('persyaratan_umum', $persyaratanUmum) }}</textarea>
                        <p class="text-[11px] text-slate-400 mt-1.5">Cukup tekan <strong>Enter</strong> untuk membuat poin persyaratan baru. Sistem otomatis merendernya sebagai bullet list rapi.</p>
                    </div>
                </div>

                <!-- Portal Link -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tautan Portal Pendaftaran Resmi Dinas / PPDB Online</label>
                    <input type="url" name="portal_url" value="{{ old('portal_url', $portalUrl) }}" placeholder="https://ppdb.jabarprov.go.id" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                </div>
            </div>

            <div class="pt-5 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs hover:shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan SPMB
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
