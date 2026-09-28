@extends('layouts.tenant_admin')

@section('title', 'Edit Berita')
@section('header_title', 'Edit Berita: ' . $berita->judul)

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Perbarui Artikel Berita</h3>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Perbarui isi konten artikel, gambar sampul, dan status publikasi.</p>
            </div>
            <a href="{{ route('tenant.admin.berita.index', ['tenant' => $tenant->slug]) }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition">
                &larr; Kembali ke Daftar
            </a>
        </div>

        <form action="{{ route('tenant.admin.berita.update', ['tenant' => $tenant->slug, 'berita' => $berita->id]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-800 mb-1.5">Judul Berita <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul', $berita->judul) }}" required class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-800 mb-1.5">Kategori Berita</label>
                        <select name="kategori_id" class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id', $berita->kategori_id) == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-800 mb-1.5">Status Publikasi</label>
                        <select name="status_publikasi" required class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                            <option value="published" {{ old('status_publikasi', $berita->status_publikasi) == 'published' ? 'selected' : '' }}>Publikasikan Langsung (Published)</option>
                            <option value="draft" {{ old('status_publikasi', $berita->status_publikasi) == 'draft' ? 'selected' : '' }}>Simpan Sebagai Draft</option>
                        </select>
                    </div>
                </div>

                <x-admin.input-gambar 
                    name="gambar_sampul" 
                    label="Gambar Sampul / Cover Berita" 
                    :value="old('gambar_sampul', $berita->gambar_sampul)" 
                    recommended="Format JPG, PNG, atau WebP. Maks 2MB. Rekomendasi 1200x700px." />

                <div>
                    <label class="block text-xs font-bold text-slate-800 mb-1.5">Ringkasan Singkat (Lead Paragraph)</label>
                    <textarea name="ringkasan" rows="2" required class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition leading-relaxed">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
                </div>

                <div>
                    <x-admin.quill-editor 
                        name="isi_konten" 
                        value="{{ old('isi_konten', $berita->isi_konten) }}" 
                        label="Isi Konten Berita Lengkap" 
                        placeholder="Tuliskan isi berita, liputan, atau artikel lengkap sekolah..." 
                        :required="true"
                        height="280px"
                    />
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('tenant.admin.berita.index', ['tenant' => $tenant->slug]) }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
