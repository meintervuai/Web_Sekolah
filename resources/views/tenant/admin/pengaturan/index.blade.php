@extends('layouts.tenant_admin')

@section('title', 'Identitas & Statistik Sekolah')
@section('header_title', 'Identitas & Statistik Sekolah')

@section('content')
<div class="space-y-6">

    <!-- Kartu Navigasi Terarah untuk Mencegah Kebingungan / Duplikasi Input -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <!-- Ke Menu Kontak & Layanan -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 flex flex-col justify-between gap-3 shadow-2xs">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900">Kontak, Layanan & Media Sosial</h4>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed font-medium">
                        Alamat, telepon, WhatsApp hotline, Google Maps, dan akun medsos (IG, TikTok, YouTube, FB, X) dikelola terpusat di menu <strong>Kontak & Layanan</strong>.
                    </p>
                </div>
            </div>
            <a 
                href="{{ route('tenant.admin.kontak.index', ['tenant' => $tenant->slug]) }}" 
                class="self-start text-xs font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1.5 transition"
            >
                <span>Buka Menu Kontak & Layanan</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        <!-- Ke Menu Profil Sekolah -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 flex flex-col justify-between gap-3 shadow-2xs">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900">Kepala Sekolah & Konten Profil</h4>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed font-medium">
                        Pas foto resmi, NIP, sambutan pimpinan, rumusan visi & misi, serta sejarah sekolah dikelola terpusat di menu <strong>Profil Sekolah</strong>.
                    </p>
                </div>
            </div>
            <a 
                href="{{ route('tenant.admin.profil.index', ['tenant' => $tenant->slug]) }}" 
                class="self-start text-xs font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1.5 transition"
            >
                <span>Buka Menu Profil Sekolah</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </div>

    <!-- Formulir Pengaturan dengan Tab-Tab Modern -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden" x-data="{ activeTab: 'identitas' }">
        
        <!-- Header & Navigasi Tab -->
        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Identitas, Statistik & Video Profil</h3>
                <p class="text-xs text-slate-500 mt-1 font-medium">Kelola identitas resmi, akreditasi, statistik, dan video profil sekolah terpadu.</p>
            </div>

            <!-- Segmented Tab Navigation -->
            <div class="inline-flex p-1 bg-slate-100 rounded-xl text-xs font-bold text-slate-600 shrink-0 border border-slate-200/80">
                <button 
                    type="button" 
                    @click="activeTab = 'identitas'" 
                    :class="activeTab === 'identitas' ? 'bg-white text-blue-600 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-800'" 
                    class="px-3.5 py-2 rounded-lg transition-all flex items-center gap-1.5 cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Identitas & Logo</span>
                </button>
                <button 
                    type="button" 
                    @click="activeTab = 'statistik'" 
                    :class="activeTab === 'statistik' ? 'bg-white text-blue-600 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-800'" 
                    class="px-3.5 py-2 rounded-lg transition-all flex items-center gap-1.5 cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span>Statistik Beranda</span>
                </button>
                <button 
                    type="button" 
                    @click="activeTab = 'video'" 
                    :class="activeTab === 'video' ? 'bg-white text-blue-600 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-800'" 
                    class="px-3.5 py-2 rounded-lg transition-all flex items-center gap-1.5 cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    <span>Video Profil</span>
                </button>
            </div>
        </div>

        <form action="{{ route('tenant.admin.pengaturan.update', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Tab 1: Identitas Pokok & Logo -->
            <div x-show="activeTab === 'identitas'" x-cloak class="space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        Identitas Pokok & Logo Sekolah
                    </h4>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Informasi utama lembaga yang ditampilkan pada header, navigasi, dan footer portal.</p>
                </div>

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
                        <label class="block text-xs font-bold text-slate-800 mb-1.5">Nama Resmi Sekolah <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $pengaturanRaw['nama_sekolah'] ?? $tenant->nama_sekolah) }}" required class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-800 mb-1.5">Jenjang Pendidikan <span class="text-rose-500">*</span></label>
                        <input type="text" name="jenjang" value="{{ old('jenjang', $pengaturanRaw['jenjang'] ?? $tenant->jenjang) }}" required class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-800 mb-1.5">Slogan / Tagline Sekolah</label>
                        <input type="text" name="slogan" value="{{ old('slogan', $pengaturanRaw['slogan'] ?? '') }}" placeholder="Contoh: Terdepan dalam Prestasi, Siap Kerja & Berakhlak Mulia" class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-800 mb-1.5">NPSN (Nomor Pokok Sekolah Nasional)</label>
                        <input type="text" name="npsn" value="{{ old('npsn', $pengaturanRaw['npsn'] ?? '') }}" placeholder="Contoh: 20219213" class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-800 mb-1.5">Status Akreditasi</label>
                        <input type="text" name="akreditasi" value="{{ old('akreditasi', $pengaturanRaw['akreditasi'] ?? 'A (Unggul)') }}" placeholder="Contoh: A (Unggul)" class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-800 mb-1.5">Tahun Berdiri</label>
                        <input type="text" name="tahun_berdiri" value="{{ old('tahun_berdiri', $pengaturanRaw['tahun_berdiri'] ?? '1951') }}" placeholder="Contoh: 1951" class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-800 mb-1.5">Deskripsi Profil Singkat</label>
                        <textarea name="deskripsi" rows="3" placeholder="Tuliskan gambaran umum profil sekolah yang ringkas dan informatif..." class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition leading-relaxed">{{ old('deskripsi', $pengaturanRaw['deskripsi'] ?? '') }}</textarea>
                    </div>

                    <div class="md:col-span-2 pt-2 border-t border-slate-100 space-y-4">
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-1">
                                Media Hero Banner Beranda (Tepat di Atas Sambutan Kepala Sekolah)
                            </h4>
                            <p class="text-xs text-slate-500 font-medium">
                                Anda dapat mengunggah <strong>Gambar</strong>, <strong>Video</strong>, atau <strong>Keduanya</strong>.
                                <br>
                                <span class="text-slate-600 font-semibold">• Jika gambar saja:</span> Slideshow gambar.
                                <br>
                                <span class="text-slate-600 font-semibold">• Jika video saja:</span> Video berputar berulang terus menerus (looping).
                                <br>
                                <span class="text-slate-600 font-semibold">• Jika ada keduanya:</span> Video diputar terlebih dahulu sampai selesai, lalu berpindah menampilkan gambar banner.
                            </p>
                        </div>

                        <!-- 1. Gambar Hero Banner -->
                        <x-admin.input-gambar 
                            name="hero_banner" 
                            value="{{ old('hero_banner', $pengaturanRaw['hero_banner'] ?? '') }}" 
                            label="1. Gambar Banner Hero (Landscape)" 
                            recommended="Format JPG, PNG, atau WebP. Maks 3MB. Resolusi ideal 1600x600px atau 1920x800px." 
                        />

                        <!-- 2. Video Hero Banner -->
                        <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-200/90 space-y-3">
                            <label class="block text-xs font-bold text-slate-800">
                                2. Video Banner Hero (MP4 / WebM / Link Video)
                            </label>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Upload Berkas Video (Maks 25MB)</label>
                                    <input type="file" name="hero_banner_video_file" accept="video/mp4,video/webm" class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer bg-white border border-slate-200 rounded-xl transition">
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="h-px bg-slate-200 flex-1"></div>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">ATAU INPUT URL VIDEO</span>
                                    <div class="h-px bg-slate-200 flex-1"></div>
                                </div>

                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">URL Video Langsung (MP4 / WebM / CDN)</label>
                                    <input type="url" name="hero_banner_video" value="{{ old('hero_banner_video', $pengaturanRaw['hero_banner_video'] ?? '') }}" placeholder="https://domain.com/video-sekolah.mp4" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                                </div>

                                @if(!empty($pengaturanRaw['hero_banner_video']))
                                <div class="pt-2 border-t border-slate-200">
                                    <div class="text-[11px] font-bold text-slate-700 mb-1">Video Banner Aktif:</div>
                                    <div class="text-xs font-mono text-slate-700 bg-white p-2 rounded-lg border border-slate-200 truncate">
                                        {{ $pengaturanRaw['hero_banner_video'] }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Statistik Beranda -->
            <div x-show="activeTab === 'statistik'" x-cloak class="space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-100 gap-2">
                    <div>
                        <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                            Statistik Sekolah (Tampil di Beranda)
                        </h4>
                        <p class="text-xs text-slate-500 mt-1 font-medium">Angka pencapaian dan sarana yang ditampilkan pada section statistik beranda.</p>
                    </div>
                    <span class="text-xs text-blue-700 bg-blue-50 px-3 py-1.5 rounded-xl font-bold border border-blue-200/50">
                        Otomatis terhitung: <strong>{{ $countGuru }} Guru</strong> | <strong>{{ $countJurusan }} Jurusan</strong>
                    </span>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Total Guru & Staf</label>
                        <input type="text" name="stat_guru" value="{{ old('stat_guru', $pengaturanRaw['stat_guru'] ?? ($countGuru > 0 ? (string)$countGuru : '98')) }}" class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Total Siswa Aktif</label>
                        <input type="text" name="stat_siswa" value="{{ old('stat_siswa', $pengaturanRaw['stat_siswa'] ?? '1972') }}" class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Total Rombel</label>
                        <input type="text" name="stat_rombel" value="{{ old('stat_rombel', $pengaturanRaw['stat_rombel'] ?? '54') }}" class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Ruang Kelas & Lab</label>
                        <input type="text" name="stat_kelas" value="{{ old('stat_kelas', $pengaturanRaw['stat_kelas'] ?? '41') }}" class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Program Keahlian</label>
                        <input type="text" name="stat_jurusan" value="{{ old('stat_jurusan', $pengaturanRaw['stat_jurusan'] ?? ($countJurusan > 0 ? (string)$countJurusan : '7')) }}" class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Mitra Industri (DUDI)</label>
                        <input type="text" name="stat_mitra" value="{{ old('stat_mitra', $pengaturanRaw['stat_mitra'] ?? '85') }}" class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Label Sumber Data Statistik</label>
                        <input type="text" name="stat_sumber_label" value="{{ old('stat_sumber_label', $pengaturanRaw['stat_sumber_label'] ?? 'Data Pokok Pendidikan (Dapodik)') }}" class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                </div>
            </div>

            <!-- Tab 3: Video Profil Sekolah -->
            <div x-show="activeTab === 'video'" x-cloak class="space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        Video Profil Sekolah (Publik)
                    </h4>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Tampilkan video profil resmi sekolah di halaman publik. Anda dapat memasukkan tautan YouTube/Vimeo atau mengunggah video MP4/WebM langsung.</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-800 mb-1.5">Judul Video Profil</label>
                        <input type="text" name="video_profil_judul" value="{{ old('video_profil_judul', $pengaturanRaw['video_profil_judul'] ?? 'Profil & Lingkungan Belajar Sekolah') }}" placeholder="Contoh: Video Profil SMK Negeri 2 Bandung - Generasi Emas Vokasi" class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-800 mb-1.5">Deskripsi Singkat Video</label>
                        <textarea name="video_profil_deskripsi" rows="2" placeholder="Gambaran isi tayangan video..." class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">{{ old('video_profil_deskripsi', $pengaturanRaw['video_profil_deskripsi'] ?? 'Saksikan fasilitas modern, suasana praktek industri, dan ragam kreativitas siswa vokasi kami.') }}</textarea>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/90 space-y-4">
                        <div class="text-xs font-bold text-slate-800">Pilihan Sumber Video:</div>

                        <!-- Opsi 1: URL Video YouTube / Vimeo -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">1. Tautan URL Video (YouTube / Vimeo / Direct URL)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4 text-rose-500" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                </span>
                                <input type="url" name="video_profil" value="{{ old('video_profil', $pengaturanRaw['video_profil'] ?? '') }}" placeholder="https://www.youtube.com/watch?v=..." class="w-full pl-10 pr-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                            </div>
                            <span class="text-[11px] text-slate-400 mt-1 block font-medium">Contoh: https://www.youtube.com/watch?v=... atau tautan berkas video langsung.</span>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="h-px bg-slate-200 flex-1"></div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">ATAU UPLOAD BERKAS</span>
                            <div class="h-px bg-slate-200 flex-1"></div>
                        </div>

                        <!-- Opsi 2: Upload Video File -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">2. Upload Berkas Video Langsung (MP4 / WebM)</label>
                            <input type="file" name="video_profil_file" accept="video/mp4,video/webm" class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer bg-white border border-slate-200 rounded-xl transition">
                            <span class="text-[11px] text-slate-400 mt-1 block font-medium">Maksimal 25MB. Format disarankan: MP4 (H.264).</span>
                        </div>

                        <!-- Pratinjau Video Saat Ini -->
                        @if(!empty($pengaturanRaw['video_profil']))
                        <div class="pt-3 border-t border-slate-200">
                            <div class="text-xs font-bold text-slate-700 mb-1">Video Yang Aktif Saat Ini:</div>
                            <div class="text-xs text-slate-800 font-mono break-all bg-white p-2.5 rounded-xl border border-slate-200 shadow-2xs">
                                {{ $pengaturanRaw['video_profil'] }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Submit Button Footer -->
            <div class="pt-6 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition cursor-pointer inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>

    </div>

</div>
@endsection
