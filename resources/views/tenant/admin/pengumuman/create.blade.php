@extends('layouts.tenant_admin')

@section('title', 'Buat Pengumuman Baru')
@section('header_title', 'Buat Pengumuman Baru')

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Formulir Pengumuman Resmi</h3>
                <p class="text-xs text-slate-500 mt-0.5">Lengkapi rincian surat edaran atau warta informasi resmi sekolah</p>
            </div>
            <a href="{{ route('tenant.admin.pengumuman.index', ['tenant' => $tenant->slug]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>

        <form action="{{ route('tenant.admin.pengumuman.store', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf

            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Pengumuman <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required placeholder="Contoh: Jadwal Pelaksanaan Asesmen Sumatif Akhir Semester Genap" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status Publikasi</label>
                    <select name="status_publikasi" required class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                        <option value="published" {{ old('status_publikasi') == 'published' ? 'selected' : '' }}>Terbitkan Langsung (Published)</option>
                        <option value="draft" {{ old('status_publikasi') == 'draft' ? 'selected' : '' }}>Simpan Sebagai Draft</option>
                    </select>
                </div>

                <x-admin.input-gambar 
                    name="gambar_sampul" 
                    label="Lampiran Gambar / Banner Pengumuman" 
                    :value="old('gambar_sampul')" 
                    recommended="Format JPG, PNG, atau WebP. Maks 2MB. Rekomendasi 1200x675px." />

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Ringkasan Inti Pengumuman</label>
                    <textarea name="ringkasan" rows="2" required placeholder="Tuliskan 1-2 kalimat ringkasan pengumuman..." class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition leading-relaxed">{{ old('ringkasan') }}</textarea>
                </div>

                <div>
                    <x-admin.quill-editor 
                        name="isi_konten" 
                        value="{{ old('isi_konten') }}" 
                        label="Rincian Surat / Edaran Pengumuman Lengkap" 
                        placeholder="Tuliskan edaran resmi, poin-poin instruksi, atau pengumuman sekolah..." 
                        :required="true"
                        height="260px"
                    />
                </div>
            </div>

            <div class="pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('tenant.admin.pengumuman.index', ['tenant' => $tenant->slug]) }}" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs hover:shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Pengumuman
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
