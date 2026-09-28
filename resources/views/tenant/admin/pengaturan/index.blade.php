@extends('layouts.tenant_admin')

@section('title', 'Identitas & Statistik Sekolah')
@section('header_title', 'Identitas & Statistik Sekolah')

@section('content')
<div class="max-w-5xl space-y-6">

    <!-- Kartu Navigasi Terarah untuk Mencegah Kebingungan / Duplikasi Input -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Ke Menu Kontak & Layanan -->
        <div class="bg-gradient-to-r from-blue-50/60 to-slate-50 border border-blue-100 rounded-2xl p-5 flex flex-col justify-between gap-3 shadow-2xs">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-600/10 border border-blue-200 text-blue-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-900">Kontak, Layanan & Media Sosial</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5 leading-relaxed">
                        Alamat, telepon, WhatsApp hotline, Google Maps, dan akun medsos (IG, TikTok, YouTube, FB, X) dikelola terpusat di menu <strong>Kontak & Layanan</strong>.
                    </p>
                </div>
            </div>
            <a 
                href="{{ route('tenant.admin.kontak.index', ['tenant' => $tenant->slug]) }}" 
                class="self-start text-xs font-bold text-blue-700 hover:text-blue-800 inline-flex items-center gap-1.5 transition"
            >
                <span>Buka Menu Kontak & Layanan</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        <!-- Ke Menu Profil Sekolah -->
        <div class="bg-gradient-to-r from-slate-50 to-blue-50/40 border border-slate-200 rounded-2xl p-5 flex flex-col justify-between gap-3 shadow-2xs">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-xl bg-slate-200/80 border border-slate-300 text-slate-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-900">Kepala Sekolah & Konten Profil</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5 leading-relaxed">
                        Pas foto resmi, NIP, sambutan pimpinan, rumusan visi & misi, serta sejarah sekolah dikelola terpusat di menu <strong>Profil Sekolah</strong>.
                    </p>
                </div>
            </div>
            <a 
                href="{{ route('tenant.admin.profil.index', ['tenant' => $tenant->slug]) }}" 
                class="self-start text-xs font-bold text-blue-700 hover:text-blue-800 inline-flex items-center gap-1.5 transition"
            >
                <span>Buka Menu Profil Sekolah</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </div>

    <!-- Formulir Identitas Pokok & Statistik -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-base font-bold text-slate-900">Identitas Pokok & Statistik Sekolah</h3>
            <p class="text-xs text-slate-500 mt-0.5">Kelola identitas resmi, akreditasi, dan ringkasan statistik yang tampil pada halaman publik website sekolah.</p>
        </div>

        <form action="{{ route('tenant.admin.pengaturan.update', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
            @csrf
            @method('PUT')

            <!-- Bagian 1: Identitas Pokok Sekolah -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-blue-900 uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    1. Identitas Pokok & Logo Sekolah
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <x-admin.input-gambar 
                            name="logo" 
                            value="{{ old('logo', $pengaturanRaw['logo'] ?? '') }}" 
                            label="Logo Resmi Sekolah (Header & Navigasi)" 
                            recommended="Format PNG (transparan), SVG, atau WebP. Maks 2MB. Resolusi ideal 400x400px." 
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Resmi Sekolah <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $pengaturanRaw['nama_sekolah'] ?? $tenant->nama_sekolah) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jenjang Pendidikan <span class="text-rose-500">*</span></label>
                        <input type="text" name="jenjang" value="{{ old('jenjang', $pengaturanRaw['jenjang'] ?? $tenant->jenjang) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Slogan / Tagline Sekolah</label>
                        <input type="text" name="slogan" value="{{ old('slogan', $pengaturanRaw['slogan'] ?? '') }}" placeholder="Contoh: Terdepan dalam Prestasi, Siap Kerja & Berakhlak Mulia" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">NPSN (Nomor Pokok Sekolah Nasional)</label>
                        <input type="text" name="npsn" value="{{ old('npsn', $pengaturanRaw['npsn'] ?? '') }}" placeholder="Contoh: 20219213" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status Akreditasi</label>
                        <input type="text" name="akreditasi" value="{{ old('akreditasi', $pengaturanRaw['akreditasi'] ?? 'A (Unggul)') }}" placeholder="Contoh: A (Unggul)" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tahun Berdiri</label>
                        <input type="text" name="tahun_berdiri" value="{{ old('tahun_berdiri', $pengaturanRaw['tahun_berdiri'] ?? '1951') }}" placeholder="Contoh: 1951" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi Profil Singkat</label>
                        <textarea name="deskripsi" rows="3" placeholder="Tuliskan gambaran umum profil sekolah yang ringkas dan informatif..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 leading-relaxed">{{ old('deskripsi', $pengaturanRaw['deskripsi'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Statistik Resmi Beranda -->
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-2 border-b border-slate-100 gap-2">
                    <h4 class="text-xs font-bold text-blue-900 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        2. Statistik Sekolah (Tampil di Beranda)
                    </h4>
                    <span class="text-[11px] text-slate-500">
                        Otomatis terhitung: <strong>{{ $countGuru }} Guru</strong> | <strong>{{ $countJurusan }} Jurusan</strong>
                    </span>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Total Guru & Staf</label>
                        <input type="text" name="stat_guru" value="{{ old('stat_guru', $pengaturanRaw['stat_guru'] ?? ($countGuru > 0 ? (string)$countGuru : '98')) }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs sm:text-sm text-slate-900 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Total Siswa Aktif</label>
                        <input type="text" name="stat_siswa" value="{{ old('stat_siswa', $pengaturanRaw['stat_siswa'] ?? '1972') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs sm:text-sm text-slate-900 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Total Rombel</label>
                        <input type="text" name="stat_rombel" value="{{ old('stat_rombel', $pengaturanRaw['stat_rombel'] ?? '54') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs sm:text-sm text-slate-900 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Ruang Kelas & Lab</label>
                        <input type="text" name="stat_kelas" value="{{ old('stat_kelas', $pengaturanRaw['stat_kelas'] ?? '41') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs sm:text-sm text-slate-900 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Program Keahlian</label>
                        <input type="text" name="stat_jurusan" value="{{ old('stat_jurusan', $pengaturanRaw['stat_jurusan'] ?? ($countJurusan > 0 ? (string)$countJurusan : '7')) }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs sm:text-sm text-slate-900 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Mitra Industri (DUDI)</label>
                        <input type="text" name="stat_mitra" value="{{ old('stat_mitra', $pengaturanRaw['stat_mitra'] ?? '85') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs sm:text-sm text-slate-900 focus:bg-white">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Label Sumber Data Statistik</label>
                        <input type="text" name="stat_sumber_label" value="{{ old('stat_sumber_label', $pengaturanRaw['stat_sumber_label'] ?? 'Data Pokok Pendidikan (Dapodik)') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs sm:text-sm text-slate-900 focus:bg-white">
                    </div>
                </div>
            </div>

            <!-- Submit Button Footer -->
            <div class="pt-6 border-t border-slate-200 flex justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-sm shadow-md transition cursor-pointer inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Identitas & Statistik
                </button>
            </div>
        </form>

    </div>

</div>
@endsection
