@extends('layouts.tenant_admin')

@section('title', 'Navigasi SPMB')
@section('header_title', 'Kelola Informasi SPMB / PPDB')

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Petunjuk Teknis & Informasi SPMB</h3>
                <p class="text-xs text-slate-500 mt-0.5">Kelola jalur pendaftaran, persyaratan umum, tautan portal dinas, dan pengumuman penerimaan murid baru.</p>
            </div>
            <a href="{{ url($tenant->slug . '/spmb') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 shadow-2xs transition inline-flex items-center gap-1.5 self-start sm:self-auto">
                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Lihat di Publik
            </a>
        </div>

        <form action="{{ route('tenant.admin.spmb.update', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Judul Halaman -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Judul Halaman SPMB / PPDB <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul', $spmb->judul ?? 'Sistem Penerimaan Murid Baru (SPMB / PPDB) 2026/2027') }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
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
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kalimat Pengantar SPMB</label>
                    <textarea name="pengantar" rows="3" placeholder="Tuliskan kalimat pembuka pengumuman PPDB..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white leading-relaxed">{{ old('pengantar', $pengantar) }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1">Penjelasan singkat mengenai pelaksanaan seleksi penerimaan murid baru.</p>
                </div>

                <!-- Form Terstruktur: Jalur Penerimaan -->
                <div class="bg-blue-50/40 p-4 sm:p-5 rounded-2xl border border-blue-100 space-y-4">
                    <h4 class="text-xs font-bold text-blue-900 uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        1. Form Input Jalur Penerimaan (Tidak Perlu Ketik Heading 3 / Tag HTML)
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Jalur Pendaftaran Tahap 1 <span class="text-rose-500">*</span></label>
                            <textarea name="jalur_tahap_1" rows="3" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 leading-relaxed">{{ old('jalur_tahap_1', $jalurTahap1) }}</textarea>
                            <span class="text-[10px] text-slate-400">Contoh: Tahap 1: Jalur Afirmasi (KETM), Prioritas Terdekat (Zonasi), dll.</span>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Jalur Pendaftaran Tahap 2 <span class="text-rose-500">*</span></label>
                            <textarea name="jalur_tahap_2" rows="3" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 leading-relaxed">{{ old('jalur_tahap_2', $jalurTahap2) }}</textarea>
                            <span class="text-[10px] text-slate-400">Contoh: Tahap 2: Jalur Prestasi Nilai Rapor Umum & Kejuaraan.</span>
                        </div>
                    </div>
                </div>

                <!-- Form Terstruktur: Persyaratan Berkas Dokumen -->
                <div class="bg-slate-50/70 p-4 sm:p-5 rounded-2xl border border-slate-200 space-y-4">
                    <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        2. Form Persyaratan Umum & Dokumen Berkas
                    </h4>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Daftar Persyaratan (Satu baris per poin persyaratan) <span class="text-rose-500">*</span></label>
                        <textarea name="persyaratan_umum" rows="5" required class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800 leading-relaxed">{{ old('persyaratan_umum', $persyaratanUmum) }}</textarea>
                        <p class="text-[11px] text-slate-400 mt-1">Cukup tekan <strong>Enter</strong> untuk membuat poin persyaratan baru. Sistem otomatis merendernya sebagai bullet list rapi.</p>
                    </div>
                </div>

                <!-- Portal Link -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tautan Portal Pendaftaran Resmi Dinas / PPDB Online</label>
                    <input type="url" name="portal_url" value="{{ old('portal_url', $portalUrl) }}" placeholder="https://ppdb.jabarprov.go.id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-md transition cursor-pointer">
                    Simpan Perubahan SPMB
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
