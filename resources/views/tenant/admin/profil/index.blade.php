@extends('layouts.tenant_admin')

@section('title', 'Navigasi Profil Sekolah')
@section('header_title', 'Kelola Halaman Profil Sekolah')

@section('content')
<div class="max-w-6xl space-y-8">

    <!-- Form Konten Utama Profil: Visi Misi, Sejarah, Sambutan Kepsek -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Konten Profil, Visi-Misi, & Sambutan Kepala Sekolah</h3>
                <p class="text-xs text-slate-500 mt-0.5">Teks dan gambar di sini akan tampil pada navigasi publik Profil, Visi & Misi, serta Sejarah.</p>
            </div>
            <a href="{{ url($tenant->slug . '/profil') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 shadow-2xs transition inline-flex items-center gap-1.5 self-start sm:self-auto">
                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Lihat Halaman Publik
            </a>
        </div>

        <form action="{{ route('tenant.admin.profil.update', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
            @csrf
            @method('PUT')

            <!-- Bagian 1: Kepala Sekolah & Sambutan -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-blue-900 uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    1. Sambutan & Profil Pimpinan (Kepala Sekolah)
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_kepsek" value="{{ old('nama_kepsek', $namaKepsek) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">NIP Kepala Sekolah</label>
                        <input type="text" name="nip_kepsek" value="{{ old('nip_kepsek', $nipKepsek) }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500">
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
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Teks Sambutan Resmi Kepala Sekolah</label>
                        <textarea name="sambutan_kepsek" rows="4" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 leading-relaxed">{{ old('sambutan_kepsek', $sambutanKepsek) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Visi & Misi Terstruktur -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-blue-900 uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    2. Halaman Visi & Misi Sekolah (Formulir Terstruktur)
                </h4>

                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Judul Halaman Visi Misi <span class="text-rose-500">*</span></label>
                        <input type="text" name="visimisi_judul" value="{{ old('visimisi_judul', $visiMisi->judul ?? 'Visi, Misi & Tujuan Satuan Pendidikan') }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white">
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
                    <div class="bg-blue-50/40 p-4 sm:p-5 rounded-2xl border border-blue-100 space-y-2">
                        <label class="block text-xs font-bold text-blue-950 uppercase tracking-wider">
                            A. Rumusan Visi Sekolah <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="teks_visi" rows="3" required placeholder="Tuliskan rumusan visi sekolah..." class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-800 leading-relaxed">{{ old('teks_visi', $teksVisi) }}</textarea>
                        <p class="text-[11px] text-slate-400">Tidak perlu mengetik heading atau tanda kutip, sistem merendernya otomatis secara estetis.</p>
                    </div>

                    <!-- Form Khusus Misi -->
                    <div class="bg-slate-50/70 p-4 sm:p-5 rounded-2xl border border-slate-200 space-y-2">
                        <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                            B. Poin-Poin Misi Sekolah (Satu baris per misi) <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="poin_misi" rows="5" required class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800 leading-relaxed">{{ old('poin_misi', $poinMisi) }}</textarea>
                        <p class="text-[11px] text-slate-400">Cukup tekan <strong>Enter</strong> untuk membuat butir misi berikutnya. Tampil otomatis sebagai daftar rapi.</p>
                    </div>

                    <!-- Form Khusus Tujuan Satuan Pendidikan -->
                    <div class="bg-slate-50/70 p-4 sm:p-5 rounded-2xl border border-slate-200 space-y-2">
                        <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                            C. Tujuan Satuan Pendidikan
                        </label>
                        <textarea name="teks_tujuan" rows="3" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-800 leading-relaxed">{{ old('teks_tujuan', $teksTujuan) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Bagian 3: Sejarah Sekolah -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-blue-900 uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    3. Halaman Sejarah Sekolah
                </h4>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Judul Halaman Sejarah <span class="text-rose-500">*</span></label>
                        <input type="text" name="sejarah_judul" value="{{ old('sejarah_judul', $sejarah->judul ?? 'Sejarah Singkat & Kilas Balik Perjalanan') }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white">
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
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Isi Konten Sejarah Lengkap <span class="text-rose-500">*</span></label>
                        <textarea name="sejarah_konten" rows="6" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white leading-relaxed">{{ old('sejarah_konten', $sejarah->isi_konten ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-sm shadow-md transition cursor-pointer">
                    Simpan Perubahan Teks Profil & Sambutan
                </button>
            </div>
        </form>
    </div>

    <!-- Kelola Anggota Struktur Organisasi -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Kelola Anggota Struktur Organisasi</h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar pimpinan dan penanggung jawab yang tampil di halaman bagan & personalia struktur organisasi.</p>
            </div>
        </div>

        <div class="p-6 sm:p-8 space-y-6">
            <!-- Form Tambah Anggota Struktur -->
            <form action="{{ route('tenant.admin.profil.struktur.store', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-5 bg-slate-50 border border-slate-200 rounded-2xl space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_lengkap" placeholder="Contoh: Dra. Hj. Siti Aminah, M.Si." required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Jabatan Struktural <span class="text-rose-500">*</span></label>
                        <input type="text" name="jabatan" placeholder="Contoh: Wakasek Kurikulum" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Urutan Tampil <span class="text-rose-500">*</span></label>
                        <input type="number" name="urutan" value="{{ ($struktur->max('urutan') ?? 0) + 1 }}" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs">
                    </div>
                </div>

                <div>
                    <x-admin.input-gambar 
                        name="foto" 
                        label="Pas Foto Pejabat Struktural" 
                        recommended="Format JPG, PNG, atau WebP. Maks 2MB. Rasio 1:1 atau 3:4." 
                    />
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-5 py-2.5 bg-blue-700 hover:bg-blue-600 text-white font-semibold text-xs rounded-xl transition shadow-xs cursor-pointer">
                        + Tambah Anggota Struktur
                    </button>
                </div>
            </form>

            <!-- Tabel Daftar Struktur Organisasi -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-100/75 text-slate-600 uppercase font-bold text-[10px]">
                        <tr>
                            <th class="px-4 py-3 rounded-l-lg">Urutan</th>
                            <th class="px-4 py-3">Foto</th>
                            <th class="px-4 py-3">Nama Lengkap</th>
                            <th class="px-4 py-3">Jabatan</th>
                            <th class="px-4 py-3 text-right rounded-r-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($struktur as $item)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-4 py-3 font-semibold text-slate-500">{{ $item->urutan }}</td>
                            <td class="px-4 py-3">
                                @if($item->foto)
                                <img src="{{ $item->foto }}" alt="{{ $item->nama_lengkap }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 font-bold text-[10px]">NA</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-bold text-slate-800">{{ $item->nama_lengkap }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $item->jabatan }}</td>
                            <td class="px-4 py-3 text-right">
                                <form action="{{ route('tenant.admin.profil.struktur.destroy', ['tenant' => $tenant->slug, 'id' => $item->id]) }}" method="POST" onsubmit="return confirm('Hapus anggota ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold cursor-pointer">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-slate-400">Belum ada anggota struktur organisasi yang ditambahkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
