@extends('layouts.tenant_admin')

@section('title', 'Edit Berita')
@section('header_title', 'Edit Berita: ' . $berita->judul)

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-900">Perbarui Artikel Berita</h3>
            <a href="{{ route('tenant.admin.berita.index', ['tenant' => $tenant->slug]) }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                &larr; Kembali ke Daftar
            </a>
        </div>

        <form action="{{ route('tenant.admin.berita.update', ['tenant' => $tenant->slug, 'berita' => $berita->id]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Judul Berita</label>
                    <input type="text" name="judul" value="{{ old('judul', $berita->judul) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori Berita</label>
                        <select name="kategori_id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id', $berita->kategori_id) == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status Publikasi</label>
                        <select name="status_publikasi" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                            <option value="published" {{ old('status_publikasi', $berita->status_publikasi) == 'published' ? 'selected' : '' }}>Publikasikan Langsung (Published)</option>
                            <option value="draft" {{ old('status_publikasi', $berita->status_publikasi) == 'draft' ? 'selected' : '' }}>Simpan Sebagai Draft</option>
                        </select>
                    </div>
                </div>

                <x-admin.input-gambar 
                    name="gambar_sampul" 
                    label="Gambar Sampul / Cover Berita" 
                    :value="old('gambar_sampul', $berita->gambar_sampul)" 
                    maxSize="2MB" 
                    recommendedResolution="Landscape 1200 x 675 px (16:9)" />

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Ringkasan Singkat (Lead Paragraph)</label>
                    <textarea name="ringkasan" rows="2" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white leading-relaxed">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Isi Konten Berita Lengkap (HTML / Teks)</label>
                    <textarea name="isi_konten" rows="8" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white leading-relaxed font-mono">{{ old('isi_konten', $berita->isi_konten) }}</textarea>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex justify-end gap-3">
                <a href="{{ route('tenant.admin.berita.index', ['tenant' => $tenant->slug]) }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
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
