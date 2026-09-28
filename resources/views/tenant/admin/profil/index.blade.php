@extends('layouts.tenant_admin')

@section('title', 'Navigasi Profil Sekolah')
@section('header_title', 'Kelola Halaman Profil Sekolah')

@section('content')
<div class="max-w-6xl space-y-6">

    <!-- Form Konten Utama Profil: Visi Misi, Sejarah, Sambutan Kepsek -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100">
            <h3 class="text-sm font-bold text-slate-900">Konten Profil, Visi-Misi, & Sambutan Kepala Sekolah</h3>
            <p class="text-xs text-slate-500 mt-0.5">Teks dan gambar di sini akan tampil pada navigasi publik Profil, Visi & Misi, serta Kilas Balik Sejarah.</p>
        </div>

        <form action="{{ route('tenant.admin.profil.update', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
            @csrf
            @method('PUT')

            <!-- Bagian 1: Kepala Sekolah & Sambutan -->
            <div class="space-y-5">
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    1. Sambutan & Profil Pimpinan (Kepala Sekolah)
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_kepsek" value="{{ old('nama_kepsek', $namaKepsek) }}" required class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NIP Kepala Sekolah</label>
                        <input type="text" name="nip_kepsek" value="{{ old('nip_kepsek', $nipKepsek) }}" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                    <div class="md:col-span-2">
                        <x-admin.input-gambar 
                            name="foto_kepsek" 
                            value="{{ old('foto_kepsek', $fotoKepsek) }}" 
                            label="Foto Resmi Kepala Sekolah" 
                            recommended="Format JPG, PNG, atau WebP. Maks 2MB. Pas foto rasio 3:4 atau 1:1." 
                        />
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Teks Sambutan Resmi Kepala Sekolah</label>
                        <textarea name="sambutan_kepsek" rows="4" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition leading-relaxed">{{ old('sambutan_kepsek', $sambutanKepsek) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Visi & Misi Terstruktur -->
            <div class="space-y-5">
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    2. Halaman Visi & Misi Sekolah (Formulir Terstruktur)
                </h4>

                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Halaman Visi Misi <span class="text-rose-500">*</span></label>
                        <input type="text" name="visimisi_judul" value="{{ old('visimisi_judul', $visiMisi->judul ?? 'Visi, Misi & Tujuan Satuan Pendidikan') }}" required class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                    <div>
                        <x-admin.input-gambar 
                            name="visimisi_banner" 
                            value="{{ old('visimisi_banner', $visiMisi->gambar_banner ?? '') }}" 
                            label="Banner Gambar Sampul Visi & Misi" 
                            recommended="Format JPG, PNG, atau WebP. Maks 2MB. Rekomendasi 1200x600px." 
                        />
                    </div>
                    
                    <!-- Form Khusus Visi -->
                    <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-200/90 space-y-2.5">
                        <label class="block text-xs font-bold text-slate-900 uppercase tracking-wider">
                            A. Rumusan Visi Sekolah <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="teks_visi" rows="3" required placeholder="Tuliskan rumusan visi sekolah..." class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-800 leading-relaxed focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">{{ old('teks_visi', $teksVisi) }}</textarea>
                        <p class="text-[11px] text-slate-400">Tidak perlu mengetik heading atau tanda kutip, sistem merendernya otomatis secara estetis.</p>
                    </div>

                    <!-- Form Khusus Misi -->
                    <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-200/90 space-y-2.5">
                        <label class="block text-xs font-bold text-slate-900 uppercase tracking-wider">
                            B. Poin-Poin Misi Sekolah (Satu baris per misi) <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="poin_misi" rows="5" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800 leading-relaxed focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">{{ old('poin_misi', $poinMisi) }}</textarea>
                        <p class="text-[11px] text-slate-400">Cukup tekan <strong>Enter</strong> untuk membuat butir misi berikutnya. Tampil otomatis sebagai daftar rapi berangka.</p>
                    </div>

                    <!-- Form Khusus Tujuan Satuan Pendidikan -->
                    <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-200/90 space-y-2.5">
                        <label class="block text-xs font-bold text-slate-900 uppercase tracking-wider">
                            C. Tujuan Satuan Pendidikan
                        </label>
                        <textarea name="teks_tujuan" rows="3" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-800 leading-relaxed focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">{{ old('teks_tujuan', $teksTujuan) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Bagian 3: Sejarah Sekolah -->
            <div class="space-y-5">
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    3. Halaman Sejarah Sekolah
                </h4>

                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Halaman Sejarah <span class="text-rose-500">*</span></label>
                        <input type="text" name="sejarah_judul" value="{{ old('sejarah_judul', $sejarah->judul ?? 'Sejarah Singkat & Kilas Balik Perjalanan') }}" required class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                    <div>
                        <x-admin.input-gambar 
                            name="sejarah_banner" 
                            value="{{ old('sejarah_banner', $sejarah->gambar_banner ?? '') }}" 
                            label="Banner Gambar Sampul Sejarah" 
                            recommended="Format JPG, PNG, atau WebP. Maks 2MB. Rekomendasi 1200x600px." 
                        />
                    </div>
                    <div>
                        <x-admin.quill-editor 
                            name="sejarah_konten" 
                            value="{{ old('sejarah_konten', $sejarah->isi_konten ?? '') }}" 
                            label="Isi Konten Narasi Sejarah Lengkap" 
                            placeholder="Tuliskan kilas balik sejarah perjalanan berdirinya sekolah..." 
                            :required="true"
                            height="240px"
                        />
                    </div>
                </div>
            </div>

            <div class="pt-5 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs hover:shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan Teks Profil & Sambutan
                </button>
            </div>
        </form>
    </div>

    <!-- Tautan Terarah ke Menu Khusus Struktur Organisasi -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-2xs">
        <div class="flex items-start gap-3.5">
            <div class="w-12 h-12 rounded-full bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-900">Bagan Diagram & Personalia Struktur Organisasi</h4>
                <p class="text-xs text-slate-500 mt-0.5 max-w-2xl leading-relaxed">
                    Pengelolaan diagram bagan pimpinan sekolah dan pejabat struktural (Wakasek, Kepala Tata Usaha, Kepala Program) dikelola di menu khusus.
                </p>
            </div>
        </div>
        <a 
            href="{{ route('tenant.admin.struktur.index', ['tenant' => $tenant->slug]) }}" 
            class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-xs font-bold text-slate-700 shadow-xs transition inline-flex items-center gap-2 shrink-0 self-start sm:self-center"
        >
            <span>Buka Struktur Organisasi</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </a>
    </div>

</div>
@endsection
