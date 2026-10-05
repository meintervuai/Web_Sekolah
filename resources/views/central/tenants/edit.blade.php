@extends('layouts.central')

@section('title', 'Edit ' . $tenant->nama_sekolah)
@section('page_title', 'Ubah Konfigurasi Sekolah')
@section('page_subtitle', 'Perbarui identitas, domain, dan parameter operasional tenant')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Back Button -->
    <div>
        <a 
            href="{{ route('superadmin.tenants.show', $tenant) }}" 
            class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-slate-900 transition-colors"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Detail Sekolah</span>
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900">Perbarui Data Tenant</h2>
                <p class="text-xs text-slate-500 mt-0.5">ID Tenant: <span class="font-mono text-slate-700">{{ $tenant->id }}</span></p>
            </div>
            <span class="inline-flex px-2.5 py-0.5 rounded-md text-xs font-bold bg-slate-100 text-slate-800 border border-slate-200">
                {{ $tenant->jenjang }}
            </span>
        </div>

        <form action="{{ route('superadmin.tenants.update', $tenant) }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Identitas Sekolah -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                    1. Identitas & Jenjang Pendidikan
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nama Sekolah -->
                    <div class="sm:col-span-2">
                        <label for="nama_sekolah" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Nama Sekolah / Institusi <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="nama_sekolah" 
                            name="nama_sekolah" 
                            value="{{ old('nama_sekolah', $tenant->nama_sekolah) }}" 
                            required 
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 min-h-[44px]"
                        >
                        @error('nama_sekolah')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenjang -->
                    <div>
                        <label for="jenjang" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Jenjang Pendidikan <span class="text-rose-500">*</span>
                        </label>
                        <select 
                            id="jenjang" 
                            name="jenjang" 
                            required
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 min-h-[44px]"
                        >
                            @foreach ($daftarJenjang as $j)
                                <option value="{{ $j }}" {{ old('jenjang', $tenant->jenjang) == $j ? 'selected' : '' }}>{{ $j }}</option>
                            @endforeach
                        </select>
                        @error('jenjang')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Domain -->
                    <div>
                        <label for="domain" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Domain / Subdomain Utama <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="domain" 
                            name="domain" 
                            value="{{ old('domain', $primaryDomain) }}" 
                            required 
                            class="w-full px-4 py-3 font-mono bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 min-h-[44px]"
                        >
                        @error('domain')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Langganan & Masa Aktif -->
            <div class="pt-4 border-t border-slate-100">
                <h3 class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                    2. Masa Operasional & Status
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Tanggal Berakhir -->
                    <div>
                        <label for="tgl_berakhir" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Tanggal Masa Berakhir
                        </label>
                        <input 
                            type="date" 
                            id="tgl_berakhir" 
                            name="tgl_berakhir" 
                            value="{{ old('tgl_berakhir', $tenant->tgl_berakhir?->format('Y-m-d')) }}" 
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 min-h-[44px]"
                        >
                        @error('tgl_berakhir')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Aktif -->
                    <div class="flex items-center sm:pt-6">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="status_aktif" 
                                value="1" 
                                {{ old('status_aktif', $tenant->status_aktif) ? 'checked' : '' }}
                                class="w-5 h-5 rounded-md border-slate-300 text-indigo-600 focus:ring-indigo-500"
                            >
                            <div>
                                <span class="text-sm font-semibold text-slate-800">Status Aktif Beroperasi</span>
                                <p class="text-xs text-slate-500">Uncheck untuk menangguhkan (suspend) akses website sekolah.</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Section 3: Kontak & Informasi Tambahan -->
            <div class="pt-4 border-t border-slate-100">
                <h3 class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                    3. Data Kontak & Alamat Sekolah
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Telepon -->
                    <div>
                        <label for="telepon" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Nomor Telepon Sekolah
                        </label>
                        <input 
                            type="text" 
                            id="telepon" 
                            name="telepon" 
                            value="{{ old('telepon', $tenant->data['telepon'] ?? '') }}" 
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 min-h-[44px]"
                        >
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Email Resmi Sekolah
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', $tenant->data['email'] ?? '') }}" 
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 min-h-[44px]"
                        >
                    </div>

                    <!-- Alamat -->
                    <div class="sm:col-span-2">
                        <label for="alamat" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Alamat Lengkap Institusi
                        </label>
                        <textarea 
                            id="alamat" 
                            name="alamat" 
                            rows="2" 
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600"
                        >{{ old('alamat', $tenant->data['alamat'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section 4: Tema & Skema Warna Portal Sekolah (Super Admin Exclusive) -->
            <div class="pt-6 border-t border-slate-100 space-y-6"
                 x-data="{
                    selectedTheme: '{{ old('skema_tema', $pengaturanRaw['skema_tema'] ?? 'navy_classic') }}',
                    primary: '{{ old('warna_tema', $pengaturanRaw['warna_tema'] ?? '#1E3A8A') }}',
                    accent: '{{ old('warna_aksen', $pengaturanRaw['warna_aksen'] ?? '#0284C7') }}',
                    heading: '{{ old('warna_judul', $pengaturanRaw['warna_judul'] ?? '#0F172A') }}',
                    bodyText: '{{ old('warna_teks', $pengaturanRaw['warna_teks'] ?? '#1E293B') }}',
                    muted: '{{ old('warna_teks_sekunder', $pengaturanRaw['warna_teks_sekunder'] ?? '#475569') }}',
                    pageBg: '{{ old('warna_latar_halaman', $pengaturanRaw['warna_latar_halaman'] ?? '#F8FAFC') }}',
                    sectionBg: '{{ old('warna_latar_section', $pengaturanRaw['warna_latar_section'] ?? '#F1F5F9') }}',
                    cardBg: '{{ old('warna_kartu', $pengaturanRaw['warna_kartu'] ?? '#FFFFFF') }}',
                    garis: '{{ old('warna_border', $pengaturanRaw['warna_border'] ?? '#E2E8F0') }}',
                    btnBg: '{{ old('warna_tombol', $pengaturanRaw['warna_tombol'] ?? '#1D4ED8') }}',
                    btnText: '{{ old('warna_tombol_teks', $pengaturanRaw['warna_tombol_teks'] ?? '#FFFFFF') }}',
                    headerBg: '{{ old('warna_header', $pengaturanRaw['warna_header'] ?? '#1E3A8A') }}',
                    footerBg: '{{ old('warna_footer', $pengaturanRaw['warna_footer'] ?? '#172F63') }}',

                    presets: {
                        navy_classic: { nama: 'Biru Navy Klasik', deskripsi: 'Formal & berwibawa khas sekolah kejuruan.', tema: '#1E3A8A', aksen: '#0284C7', judul: '#0F172A', teks: '#1E293B', sekunder: '#475569', halaman: '#F8FAFC', section: '#F1F5F9', kartu: '#FFFFFF', border: '#E2E8F0', tombol: '#1D4ED8', tombol_teks: '#FFFFFF', header: '#1E3A8A', footer: '#172F63' },
                        emerald_nature: { nama: 'Hijau Zamrud Edukasi', deskripsi: 'Sejuk, alami, dan ramah lingkungan.', tema: '#065F46', aksen: '#10B981', judul: '#052E1F', teks: '#0F2A22', sekunder: '#4B6B62', halaman: '#F6FBF9', section: '#E7F4EF', kartu: '#FFFFFF', border: '#D5E9E2', tombol: '#059669', tombol_teks: '#FFFFFF', header: '#065F46', footer: '#044435' },
                        maroon_prestige: { nama: 'Merah Marun Prestisius', deskripsi: 'Tegas dan berkarakter kuat untuk sekolah berprestasi.', tema: '#881337', aksen: '#F43F5E', judul: '#4C0519', teks: '#3F0B1A', sekunder: '#7C5160', halaman: '#FDF6F7', section: '#FBEAEE', kartu: '#FFFFFF', border: '#F2D7DD', tombol: '#BE123C', tombol_teks: '#FFFFFF', header: '#881337', footer: '#6B0E2B' },
                        royal_purple: { nama: 'Ungu Dinamis Kreatif', deskripsi: 'Modern dan kreatif untuk sekolah seni dan teknologi.', tema: '#581C87', aksen: '#A855F7', judul: '#3B0764', teks: '#3F1D5C', sekunder: '#6B5B7B', halaman: '#FAF7FD', section: '#F2E9FA', kartu: '#FFFFFF', border: '#E4D4F0', tombol: '#7E22CE', tombol_teks: '#FFFFFF', header: '#581C87', footer: '#431263' },
                        slate_dark: { nama: 'Abu Gelap Elegan', deskripsi: 'Minimalis modern berorientasi industri.', tema: '#0F172A', aksen: '#38BDF8', judul: '#0F172A', teks: '#1E293B', sekunder: '#64748B', halaman: '#F8FAFC', section: '#EEF2F7', kartu: '#FFFFFF', border: '#E2E8F0', tombol: '#1E293B', tombol_teks: '#FFFFFF', header: '#0F172A', footer: '#020617' },
                        amber_sunset: { nama: 'Emas Oranye Enerjik', deskripsi: 'Hangat dan inovatif untuk kewirausahaan.', tema: '#78350F', aksen: '#F59E0B', judul: '#451A03', teks: '#431407', sekunder: '#7C5A3C', halaman: '#FFFAF3', section: '#FDF0DC', kartu: '#FFFFFF', border: '#F3DFC2', tombol: '#D97706', tombol_teks: '#FFFFFF', header: '#78350F', footer: '#57260A' },
                        teal_modern: { nama: 'Teal Bahari Futuristik', deskripsi: 'Profesional dan futuristik untuk teknologi dan sains.', tema: '#134E4A', aksen: '#14B8A6', judul: '#042F2E', teks: '#073B39', sekunder: '#476A69', halaman: '#F5FBFB', section: '#E5F4F2', kartu: '#FFFFFF', border: '#CFE9E6', tombol: '#0D9488', tombol_teks: '#FFFFFF', header: '#134E4A', footer: '#0A3633' }
                    },

                    terapkanPreset(kunci) {
                        const p = this.presets[kunci];
                        if (!p) return;
                        this.selectedTheme = kunci;
                        this.primary = p.tema;
                        this.accent = p.aksen;
                        this.heading = p.judul;
                        this.bodyText = p.teks;
                        this.muted = p.sekunder;
                        this.pageBg = p.halaman;
                        this.sectionBg = p.section;
                        this.cardBg = p.kartu;
                        this.garis = p.border;
                        this.btnBg = p.tombol;
                        this.btnText = p.tombol_teks;
                        this.headerBg = p.header;
                        this.footerBg = p.footer;
                    },

                    tandaiCustom() {
                        this.selectedTheme = 'custom';
                    }
                 }">
                
                <input type="hidden" name="skema_tema" :value="selectedTheme">

                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-1 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                        4. Konfigurasi Tema &amp; Palet Warna Sekolah (Super Admin Only)
                    </h3>
                    <p class="text-xs text-slate-500">
                        Hanya Super Admin yang berwenang menentukan warna dan identitas visual portal sekolah ini. Admin sekolah tidak memiliki akses ke pengaturan tema.
                    </p>
                </div>

                <!-- 7 Preset Tema Cepat -->
                <div class="space-y-3">
                    <label class="block text-xs font-bold text-slate-700">Pilih Skema / Preset Cepat</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <template x-for="(preset, kunci) in presets" :key="kunci">
                            <button type="button" @click="terapkanPreset(kunci)"
                                    :class="selectedTheme === kunci ? 'border-indigo-600 ring-2 ring-indigo-600/20 bg-indigo-50/20' : 'border-slate-200 hover:border-slate-300 bg-white'"
                                    class="text-left p-3 rounded-xl border transition-all cursor-pointer flex flex-col justify-between shadow-2xs">
                                <div>
                                    <div class="flex items-center gap-1.5 mb-2">
                                        <span class="w-3.5 h-3.5 rounded-full border border-black/10" :style="'background-color:' + preset.tema"></span>
                                        <span class="w-3.5 h-3.5 rounded-full border border-black/10" :style="'background-color:' + preset.aksen"></span>
                                        <span class="w-3.5 h-3.5 rounded-full border border-black/10" :style="'background-color:' + preset.tombol"></span>
                                        <span class="w-3.5 h-3.5 rounded-full border border-black/10" :style="'background-color:' + preset.header"></span>
                                        <template x-if="selectedTheme === kunci">
                                            <span class="ml-auto text-[9px] font-bold px-1.5 py-0.5 rounded bg-indigo-600 text-white">Aktif</span>
                                        </template>
                                    </div>
                                    <div class="text-xs font-bold text-slate-900" x-text="preset.nama"></div>
                                    <p class="text-[10px] text-slate-500 mt-0.5 leading-snug" x-text="preset.deskripsi"></p>
                                </div>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- 13 Input Warna Rinci -->
                <div class="space-y-3 pt-2">
                    <label class="block text-xs font-bold text-slate-700">Rincian 13 Palet Warna Presisi</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 text-xs">
                        
                        <!-- Primary -->
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                            <label class="font-bold text-slate-800">Warna Identitas Utama</label>
                            <div class="flex items-center gap-2">
                                <input type="color" x-model="primary" @input="tandaiCustom()" class="w-8 h-8 rounded border border-slate-300 p-0.5 cursor-pointer shrink-0">
                                <input type="text" name="warna_tema" x-model="primary" @input="tandaiCustom()" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs uppercase">
                            </div>
                        </div>

                        <!-- Aksen -->
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                            <label class="font-bold text-slate-800">Warna Aksen &amp; Tautan</label>
                            <div class="flex items-center gap-2">
                                <input type="color" x-model="accent" @input="tandaiCustom()" class="w-8 h-8 rounded border border-slate-300 p-0.5 cursor-pointer shrink-0">
                                <input type="text" name="warna_aksen" x-model="accent" @input="tandaiCustom()" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs uppercase">
                            </div>
                        </div>

                        <!-- Judul -->
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                            <label class="font-bold text-slate-800">Huruf Judul (H1-H6)</label>
                            <div class="flex items-center gap-2">
                                <input type="color" x-model="heading" @input="tandaiCustom()" class="w-8 h-8 rounded border border-slate-300 p-0.5 cursor-pointer shrink-0">
                                <input type="text" name="warna_judul" x-model="heading" @input="tandaiCustom()" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs uppercase">
                            </div>
                        </div>

                        <!-- Teks Body -->
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                            <label class="font-bold text-slate-800">Teks Isi (Paragraf)</label>
                            <div class="flex items-center gap-2">
                                <input type="color" x-model="bodyText" @input="tandaiCustom()" class="w-8 h-8 rounded border border-slate-300 p-0.5 cursor-pointer shrink-0">
                                <input type="text" name="warna_teks" x-model="bodyText" @input="tandaiCustom()" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs uppercase">
                            </div>
                        </div>

                        <!-- Teks Muted -->
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                            <label class="font-bold text-slate-800">Teks Sekunder / Muted</label>
                            <div class="flex items-center gap-2">
                                <input type="color" x-model="muted" @input="tandaiCustom()" class="w-8 h-8 rounded border border-slate-300 p-0.5 cursor-pointer shrink-0">
                                <input type="text" name="warna_teks_sekunder" x-model="muted" @input="tandaiCustom()" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs uppercase">
                            </div>
                        </div>

                        <!-- Latar Halaman -->
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                            <label class="font-bold text-slate-800">Latar Dasar Halaman</label>
                            <div class="flex items-center gap-2">
                                <input type="color" x-model="pageBg" @input="tandaiCustom()" class="w-8 h-8 rounded border border-slate-300 p-0.5 cursor-pointer shrink-0">
                                <input type="text" name="warna_latar_halaman" x-model="pageBg" @input="tandaiCustom()" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs uppercase">
                            </div>
                        </div>

                        <!-- Latar Section -->
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                            <label class="font-bold text-slate-800">Latar Section Alt</label>
                            <div class="flex items-center gap-2">
                                <input type="color" x-model="sectionBg" @input="tandaiCustom()" class="w-8 h-8 rounded border border-slate-300 p-0.5 cursor-pointer shrink-0">
                                <input type="text" name="warna_latar_section" x-model="sectionBg" @input="tandaiCustom()" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs uppercase">
                            </div>
                        </div>

                        <!-- Kartu -->
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                            <label class="font-bold text-slate-800">Latar Kartu &amp; Panel</label>
                            <div class="flex items-center gap-2">
                                <input type="color" x-model="cardBg" @input="tandaiCustom()" class="w-8 h-8 rounded border border-slate-300 p-0.5 cursor-pointer shrink-0">
                                <input type="text" name="warna_kartu" x-model="cardBg" @input="tandaiCustom()" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs uppercase">
                            </div>
                        </div>

                        <!-- Border -->
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                            <label class="font-bold text-slate-800">Border &amp; Garis Pemisah</label>
                            <div class="flex items-center gap-2">
                                <input type="color" x-model="garis" @input="tandaiCustom()" class="w-8 h-8 rounded border border-slate-300 p-0.5 cursor-pointer shrink-0">
                                <input type="text" name="warna_border" x-model="garis" @input="tandaiCustom()" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs uppercase">
                            </div>
                        </div>

                        <!-- Tombol Bg -->
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                            <label class="font-bold text-slate-800">Latar Tombol Utama</label>
                            <div class="flex items-center gap-2">
                                <input type="color" x-model="btnBg" @input="tandaiCustom()" class="w-8 h-8 rounded border border-slate-300 p-0.5 cursor-pointer shrink-0">
                                <input type="text" name="warna_tombol" x-model="btnBg" @input="tandaiCustom()" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs uppercase">
                            </div>
                        </div>

                        <!-- Tombol Teks -->
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                            <label class="font-bold text-slate-800">Teks Tombol Utama</label>
                            <div class="flex items-center gap-2">
                                <input type="color" x-model="btnText" @input="tandaiCustom()" class="w-8 h-8 rounded border border-slate-300 p-0.5 cursor-pointer shrink-0">
                                <input type="text" name="warna_tombol_teks" x-model="btnText" @input="tandaiCustom()" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs uppercase">
                            </div>
                        </div>

                        <!-- Header Bg -->
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                            <label class="font-bold text-slate-800">Latar Header &amp; Topbar</label>
                            <div class="flex items-center gap-2">
                                <input type="color" x-model="headerBg" @input="tandaiCustom()" class="w-8 h-8 rounded border border-slate-300 p-0.5 cursor-pointer shrink-0">
                                <input type="text" name="warna_header" x-model="headerBg" @input="tandaiCustom()" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs uppercase">
                            </div>
                        </div>

                        <!-- Footer Bg -->
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5 sm:col-span-2 lg:col-span-1">
                            <label class="font-bold text-slate-800">Latar Footer Portal</label>
                            <div class="flex items-center gap-2">
                                <input type="color" x-model="footerBg" @input="tandaiCustom()" class="w-8 h-8 rounded border border-slate-300 p-0.5 cursor-pointer shrink-0">
                                <input type="text" name="warna_footer" x-model="footerBg" @input="tandaiCustom()" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs uppercase">
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Form Actions -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a 
                    href="{{ route('superadmin.tenants.show', $tenant) }}" 
                    class="px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold transition-colors min-h-[44px] flex items-center"
                >
                    Batal
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm transition-colors min-h-[44px] flex items-center"
                >
                    Simpan Perubahan &amp; Tema
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
