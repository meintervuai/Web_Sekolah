@extends('layouts.tenant_admin')

@section('title', 'Tema & Warna Sekolah')
@section('header_title', 'Tema & Warna Sekolah')

@section('content')
<div class="max-w-7xl mx-auto space-y-6"
     x-data="{
         selectedTheme: '{{ old('skema_tema', $pengaturanRaw['skema_tema'] ?? 'navy_classic') }}',
         submitLoading: false,

         /* A. Warna Identitas */
         primary: '{{ old('warna_tema', $pengaturanRaw['warna_tema'] ?? '#1E3A8A') }}',
         accent: '{{ old('warna_aksen', $pengaturanRaw['warna_aksen'] ?? '#0284C7') }}',

         /* B. Tipografi & Teks */
         heading: '{{ old('warna_judul', $pengaturanRaw['warna_judul'] ?? '#0F172A') }}',
         bodyText: '{{ old('warna_teks', $pengaturanRaw['warna_teks'] ?? '#1E293B') }}',
         muted: '{{ old('warna_teks_sekunder', $pengaturanRaw['warna_teks_sekunder'] ?? '#475569') }}',

         /* C. Latar & Permukaan */
         pageBg: '{{ old('warna_latar_halaman', $pengaturanRaw['warna_latar_halaman'] ?? '#F8FAFC') }}',
         sectionBg: '{{ old('warna_latar_section', $pengaturanRaw['warna_latar_section'] ?? '#F1F5F9') }}',
         cardBg: '{{ old('warna_kartu', $pengaturanRaw['warna_kartu'] ?? '#FFFFFF') }}',

         /* D. Garis & Batas */
         garis: '{{ old('warna_border', $pengaturanRaw['warna_border'] ?? '#E2E8F0') }}',

         /* E. Tombol & Aksi */
         btnBg: '{{ old('warna_tombol', $pengaturanRaw['warna_tombol'] ?? '#1D4ED8') }}',
         btnText: '{{ old('warna_tombol_teks', $pengaturanRaw['warna_tombol_teks'] ?? '#FFFFFF') }}',

         /* F. Header, Navigasi & Footer */
         headerBg: '{{ old('warna_header', $pengaturanRaw['warna_header'] ?? '#1E3A8A') }}',
         footerBg: '{{ old('warna_footer', $pengaturanRaw['warna_footer'] ?? '#172F63') }}',

         /* Pemetaan kunci preset ke variabel warna */
         petaPreset: {
             tema: 'primary', aksen: 'accent', judul: 'heading', teks: 'bodyText',
             sekunder: 'muted', halaman: 'pageBg', section: 'sectionBg', kartu: 'cardBg',
             border: 'garis', tombol: 'btnBg', tombol_teks: 'btnText',
             header: 'headerBg', footer: 'footerBg'
         },

         /* Auto-kontras WCAG */
         luminans(hex) {
             let h = String(hex || '').replace('#', '').trim();
             if (h.length === 3) { h = h.split('').map((c) => c + c).join(''); }
             if (!/^[0-9a-fA-F]{6}$/.test(h)) { return 1; }
             const kanal = [0, 2, 4].map((i) => {
                 const c = parseInt(h.substr(i, 2), 16) / 255;
                 return c <= 0.03928 ? c / 12.92 : Math.pow((c + 0.055) / 1.055, 2.4);
             });
             return 0.2126 * kanal[0] + 0.7152 * kanal[1] + 0.0722 * kanal[2];
         },
         rasio(a, b) {
             const la = this.luminans(a), lb = this.luminans(b);
             return (Math.max(la, lb) + 0.05) / (Math.min(la, lb) + 0.05);
         },
         pilihTeks(bg, pilihan, min = 4.5) {
             if (this.rasio(bg, pilihan) >= min) { return pilihan; }
             return this.rasio(bg, '#FFFFFF') >= this.rasio(bg, '#0F172A') ? '#FFFFFF' : '#0F172A';
         },
         campur(a, b, porsiA) {
             const rgd = (hex) => {
                 let h = String(hex || '').replace('#', '').trim();
                 if (h.length === 3) { h = h.split('').map((c) => c + c).join(''); }
                 return /^[0-9a-fA-F]{6}$/.test(h) ? [0, 2, 4].map((i) => parseInt(h.substr(i, 2), 16)) : [0, 0, 0];
             };
             const A = rgd(a), B = rgd(b), t = porsiA / 100;
             return '#' + A.map((v, i) => Math.round(v * t + B[i] * (1 - t)).toString(16).padStart(2, '0')).join('').toUpperCase();
         },

         /* Warna teks per permukaan */
         get fgHeader() { return this.pilihTeks(this.headerBg, this.btnText); },
         get fgFooter() { return this.pilihTeks(this.footerBg, this.btnText); },
         get fgTombol() { return this.pilihTeks(this.btnBg, this.btnText, 3); },
         get fgAksen() { return this.pilihTeks(this.accent, this.btnText, 3); },
         get fgKartuHeading() { return this.pilihTeks(this.cardBg, this.heading); },
         get fgKartuTeks() { return this.pilihTeks(this.cardBg, this.bodyText); },
         get fgKartuMuted() { return this.pilihTeks(this.cardBg, this.muted); },
         get fgSectionHeading() { return this.pilihTeks(this.sectionBg, this.heading); },
         get fgBadge() { return this.pilihTeks(this.campur(this.accent, this.pageBg, 15), this.campur(this.primary, '#000000', 85)); },
         get fgLink() { return this.pilihTeks(this.pageBg, this.accent, 2); },

         presets: {
             navy_classic: { nama: 'Biru Navy Klasik', deskripsi: 'Formal dan berwibawa, lazim dipakai sekolah negeri.', tema: '#1E3A8A', aksen: '#0284C7', judul: '#0F172A', teks: '#1E293B', sekunder: '#475569', halaman: '#F8FAFC', section: '#F1F5F9', kartu: '#FFFFFF', border: '#E2E8F0', tombol: '#1D4ED8', tombol_teks: '#FFFFFF', header: '#1E3A8A', footer: '#172F63' },
             emerald_nature: { nama: 'Hijau Zamrud Edukasi', deskripsi: 'Sejuk, alami, dan ramah lingkungan.', tema: '#065F46', aksen: '#10B981', judul: '#052E1F', teks: '#0F2A22', sekunder: '#4B6B62', halaman: '#F6FBF9', section: '#E7F4EF', kartu: '#FFFFFF', border: '#D5E9E2', tombol: '#059669', tombol_teks: '#FFFFFF', header: '#065F46', footer: '#044435' },
             maroon_prestige: { nama: 'Merah Marun Prestisius', deskripsi: 'Tegas dan berkarakter kuat untuk sekolah berprestasi.', tema: '#881337', aksen: '#F43F5E', judul: '#4C0519', teks: '#3F0B1A', sekunder: '#7C5160', halaman: '#FDF6F7', section: '#FBEAEE', kartu: '#FFFFFF', border: '#F2D7DD', tombol: '#BE123C', tombol_teks: '#FFFFFF', header: '#881337', footer: '#6B0E2B' },
             royal_purple: { nama: 'Ungu Dinamis Kreatif', deskripsi: 'Modern dan kreatif untuk sekolah seni dan teknologi.', tema: '#581C87', aksen: '#A855F7', judul: '#3B0764', teks: '#3F1D5C', sekunder: '#6B5B7B', halaman: '#FAF7FD', section: '#F2E9FA', kartu: '#FFFFFF', border: '#E4D4F0', tombol: '#7E22CE', tombol_teks: '#FFFFFF', header: '#581C87', footer: '#431263' },
             slate_dark: { nama: 'Abu Gelap Elegan', deskripsi: 'Minimalis modern berorientasi industri.', tema: '#0F172A', aksen: '#38BDF8', judul: '#0F172A', teks: '#1E293B', sekunder: '#64748B', halaman: '#F8FAFC', section: '#EEF2F7', kartu: '#FFFFFF', border: '#E2E8F0', tombol: '#1E293B', tombol_teks: '#FFFFFF', header: '#0F172A', footer: '#020617' },
             amber_sunset: { nama: 'Emas Oranye Enerjik', deskripsi: 'Hangat dan inovatif untuk kewirausahaan.', tema: '#78350F', aksen: '#F59E0B', judul: '#451A03', teks: '#431407', sekunder: '#7C5A3C', halaman: '#FFFAF3', section: '#FDF0DC', kartu: '#FFFFFF', border: '#F3DFC2', tombol: '#D97706', tombol_teks: '#FFFFFF', header: '#78350F', footer: '#57260A' },
             teal_modern: { nama: 'Teal Bahari Futuristik', deskripsi: 'Profesional dan futuristik untuk teknologi dan sains.', tema: '#134E4A', aksen: '#14B8A6', judul: '#042F2E', teks: '#073B39', sekunder: '#476A69', halaman: '#F5FBFB', section: '#E5F4F2', kartu: '#FFFFFF', border: '#CFE9E6', tombol: '#0D9488', tombol_teks: '#FFFFFF', header: '#134E4A', footer: '#0A3633' }
         },

         terapkanPreset(kunciPreset) {
             const preset = this.presets[kunciPreset];
             if (!preset) { return; }
             this.selectedTheme = kunciPreset;
             for (const kunci in this.petaPreset) {
                 this[this.petaPreset[kunci]] = preset[kunci];
             }
         },

         tandaiCustom() { this.selectedTheme = 'custom'; },

         submitForm() {
             this.submitLoading = true;
             document.getElementById('form-tema-warna').submit();
         }
     }">

    <!-- Sticky Action Bar Atas -->
    <div class="admin-sticky-bar">
        <div class="admin-sticky-container">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-800">Skema Terpilih:</span>
                    <span class="ml-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200"
                          x-text="selectedTheme === 'custom' ? 'Custom Warna' : (presets[selectedTheme] ? presets[selectedTheme].nama : selectedTheme)"></span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" @click="submitForm()" :disabled="submitLoading"
                        class="admin-btn-save">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Perubahan Tema'"></span>
                </button>
            </div>
        </div>
    </div>

    <div class="admin-card">
        <!-- Header Kartu Pengaturan -->
        <div class="admin-card-header">
            <div>
                <h3 class="admin-card-title">Pengaturan Tema & Warna Portal Sekolah</h3>
                <p class="admin-card-subtitle">
                    Setiap bagian tampilan punya warna tersendiri: huruf judul, teks isi, teks sekunder, latar halaman, latar section, kartu, garis pembatas, tombol, header, dan footer.
                </p>
            </div>
        </div>

        <form id="form-tema-warna" action="{{ route('tenant.admin.pengaturan.update', ['tenant' => $tenant->slug]) }}" method="POST" class="p-6 sm:p-8 space-y-8">
            @csrf
            @method('PUT')

            <input type="hidden" name="skema_tema" :value="selectedTheme">

            <!-- 7 Preset Tema Warna -->
            <div class="space-y-3">
                <div class="border-b border-slate-100 pb-3">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        Preset Cepat (7 Skema Terverifikasi)
                    </h4>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Satu klik menerapkan 13 warna sekaligus. Semua nilai masih bisa disesuaikan pada rincian warna di bawah.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
                    <template x-for="(preset, kunci) in presets" :key="kunci">
                        <button type="button" @click="terapkanPreset(kunci)"
                            :class="selectedTheme === kunci ? 'border-blue-600 ring-2 ring-blue-600/20 bg-blue-50/20' : 'border-slate-200/90 hover:border-slate-300 bg-white'"
                            class="text-left p-3.5 rounded-xl border transition-all cursor-pointer flex flex-col justify-between group shadow-2xs">
                            <div>
                                <div class="flex items-center gap-1.5 mb-2">
                                    <span class="w-4 h-4 rounded-full border border-black/10" :style="'background-color:' + preset.tema"></span>
                                    <span class="w-4 h-4 rounded-full border border-black/10" :style="'background-color:' + preset.aksen"></span>
                                    <span class="w-4 h-4 rounded-full border border-black/10" :style="'background-color:' + preset.tombol"></span>
                                    <span class="w-4 h-4 rounded-full border border-black/10" :style="'background-color:' + preset.header"></span>
                                    <template x-if="selectedTheme === kunci">
                                        <span class="ml-auto text-[10px] font-bold px-1.5 py-0.5 rounded bg-blue-600 text-white">Aktif</span>
                                    </template>
                                </div>
                                <h5 class="text-xs font-bold text-slate-900" x-text="preset.nama"></h5>
                                <p class="text-[11px] text-slate-500 mt-1 leading-relaxed" x-text="preset.deskripsi"></p>
                            </div>
                        </button>
                    </template>
                </div>
            </div>

            @php
                // Satu bagian tampilan = satu pengaturan warna.
                // Urutan mengikuti pengelompokan pada panel: A-F.
                $kelompokWarna = [
                    [
                        'kode' => 'A',
                        'judul' => 'Warna Identitas',
                        'deskripsi' => 'Warna dasar sekolah: dipakai hero, section gelap, ikon, dan elemen aksen.',
                        'bidang' => [
                            ['kunci' => 'warna_tema', 'variabel' => 'primary', 'css' => '--theme-color', 'label' => 'Warna Identitas Utama', 'catatan' => 'Hero, section gelap, ikon, dan focus ring.', 'default' => '#1E3A8A'],
                            ['kunci' => 'warna_aksen', 'variabel' => 'accent', 'css' => '--theme-accent', 'label' => 'Warna Aksen & Tautan', 'catatan' => 'Tautan, badge, dan sorotan teks.', 'default' => '#0284C7'],
                        ],
                    ],
                    [
                        'kode' => 'B',
                        'judul' => 'Tipografi & Teks',
                        'deskripsi' => 'Warna huruf untuk judul, teks isi paragraf, dan teks sekunder.',
                        'bidang' => [
                            ['kunci' => 'warna_judul', 'variabel' => 'heading', 'css' => '--theme-heading', 'label' => 'Huruf Judul (H1-H6)', 'catatan' => 'Semua heading dan nama pada kartu.', 'default' => '#0F172A'],
                            ['kunci' => 'warna_teks', 'variabel' => 'bodyText', 'css' => '--theme-text', 'label' => 'Teks Isi (Paragraf)', 'catatan' => 'Paragraf, daftar, dan deskripsi konten.', 'default' => '#1E293B'],
                            ['kunci' => 'warna_teks_sekunder', 'variabel' => 'muted', 'css' => '--theme-text-muted', 'label' => 'Teks Sekunder', 'catatan' => 'Tanggal, label, dan keterangan kecil.', 'default' => '#475569'],
                        ],
                    ],
                    [
                        'kode' => 'C',
                        'judul' => 'Latar & Permukaan',
                        'deskripsi' => 'Warna dasar halaman, latar section bergantian, dan latar kartu atau panel.',
                        'bidang' => [
                            ['kunci' => 'warna_latar_halaman', 'variabel' => 'pageBg', 'css' => '--theme-page-bg', 'label' => 'Latar Halaman', 'catatan' => 'Warna dasar seluruh halaman publik.', 'default' => '#F8FAFC'],
                            ['kunci' => 'warna_latar_section', 'variabel' => 'sectionBg', 'css' => '--theme-section-bg', 'label' => 'Latar Section Bergantian', 'catatan' => 'Section pembeda dan panel abu-abu.', 'default' => '#F1F5F9'],
                            ['kunci' => 'warna_kartu', 'variabel' => 'cardBg', 'css' => '--theme-card-bg', 'label' => 'Latar Kartu & Panel', 'catatan' => 'Kartu berita, agenda, form, dan dropdown.', 'default' => '#FFFFFF'],
                        ],
                    ],

                    [
                        'kode' => 'D',
                        'judul' => 'Garis & Batas',
                        'deskripsi' => 'Warna garis pembatas kartu, tabel, dan pemisah antar bagian.',
                        'bidang' => [
                            ['kunci' => 'warna_border', 'variabel' => 'garis', 'css' => '--theme-border', 'label' => 'Border & Garis Pemisah', 'catatan' => 'Border kartu, garis tabel, dan pemisah section.', 'default' => '#E2E8F0'],
                        ],
                    ],
                    [
                        'kode' => 'E',
                        'judul' => 'Tombol & Aksi',
                        'deskripsi' => 'Warna tombol aksi utama beserta warna teks di dalamnya.',
                        'bidang' => [
                            ['kunci' => 'warna_tombol', 'variabel' => 'btnBg', 'css' => '--theme-btn-bg', 'label' => 'Latar Tombol Utama', 'catatan' => 'Tombol CTA, filter aktif, dan tombol kirim.', 'default' => '#1D4ED8'],
                            ['kunci' => 'warna_tombol_teks', 'variabel' => 'btnText', 'css' => '--theme-btn-text', 'label' => 'Teks di Tombol Utama', 'catatan' => 'Pastikan kontras minimal 4.5:1.', 'default' => '#FFFFFF'],
                        ],
                    ],
                    [
                        'kode' => 'F',
                        'judul' => 'Header, Navigasi & Footer',
                        'deskripsi' => 'Warna bar informasi atas, area navigasi gelap, dan footer portal.',
                        'bidang' => [
                            ['kunci' => 'warna_header', 'variabel' => 'headerBg', 'css' => '--theme-header-bg', 'label' => 'Latar Header & Navigasi', 'catatan' => 'Bar kontak atas dan area gelap navigasi.', 'default' => '#1E3A8A'],
                            ['kunci' => 'warna_footer', 'variabel' => 'footerBg', 'css' => '--theme-footer-bg', 'label' => 'Latar Footer', 'catatan' => 'Footer bawah dan tombol media sosial.', 'default' => '#172F63'],
                        ],
                    ],
                ];
            @endphp

            <!-- Rincian Warna per Bagian Tampilan -->
            <div class="space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        Rincian Warna per Bagian Tampilan
                    </h4>
                    <p class="text-xs text-slate-500 mt-1 font-medium">13 pengaturan warna terkelompok dalam 6 bagian (A-F). Satu nilai diubah, seluruh halaman publik mengikuti.</p>
                </div>

                @foreach ($kelompokWarna as $kelompok)
                    <div class="rounded-2xl border border-slate-200/90 overflow-hidden">
                        <div class="px-5 py-3.5 bg-slate-50 border-b border-slate-100 flex items-start gap-3">
                            <span class="w-7 h-7 rounded-lg bg-blue-600 text-white text-xs font-bold flex items-center justify-center shrink-0">{{ $kelompok['kode'] }}</span>
                            <div>
                                <h5 class="text-sm font-bold text-slate-900">{{ $kelompok['judul'] }}</h5>
                                <p class="text-[11px] text-slate-500 mt-0.5 font-medium">{{ $kelompok['deskripsi'] }}</p>
                            </div>
                        </div>
                        <div class="p-4 sm:p-5 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                            @foreach ($kelompok['bidang'] as $bidang)
                                <div class="p-3.5 rounded-xl bg-white border border-slate-200/90">
                                    <label for="{{ $bidang['kunci'] }}" class="block text-xs font-bold text-slate-800">{{ $bidang['label'] }}</label>
                                    <p class="text-[11px] text-slate-500 mt-0.5 font-medium">{{ $bidang['catatan'] }}</p>
                                    <div class="mt-2.5 flex items-center gap-2">
                                        <input type="color" x-model="{{ $bidang['variabel'] }}" @input="tandaiCustom()"
                                            aria-label="Pilih warna {{ $bidang['label'] }}"
                                            class="w-9 h-9 rounded-lg border border-slate-200 bg-white p-0.5 cursor-pointer shrink-0">
                                        <input type="text" id="{{ $bidang['kunci'] }}" name="{{ $bidang['kunci'] }}"
                                            x-model="{{ $bidang['variabel'] }}" @input="tandaiCustom()"
                                            placeholder="{{ $bidang['default'] }}"
                                            class="flex-1 min-w-0 px-3 py-2 bg-slate-50/80 border border-slate-200 rounded-lg text-xs font-mono uppercase text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-1.5 font-mono">var({{ $bidang['css'] }}) · default {{ $bidang['default'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pratinjau Langsung -->
            <div class="space-y-3">
                <div class="border-b border-slate-100 pb-3">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        Pratinjau Langsung
                    </h4>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Simulasi komponen portal publik memakai warna yang sedang dipilih. Warna teks tiap permukaan dihitung otomatis (kontras WCAG AA) dari luminans latar.</p>
                </div>

                <div class="rounded-2xl border border-slate-200/90 overflow-hidden" :style="'background-color:' + pageBg">
                    <!-- Bar Header -->
                    <div class="px-5 py-3 flex items-center justify-between gap-3" :style="'background-color:' + headerBg">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-md flex items-center justify-center text-[10px] font-bold" :style="'background-color:' + accent + '; color:' + fgAksen">S2</span>
                            <span class="text-xs font-bold" :style="'color: color-mix(in srgb, ' + fgHeader + ' 92%, transparent)'">SMK Negeri 2 Bandung</span>
                        </div>
                        <div class="hidden sm:flex items-center gap-3 text-[11px]" :style="'color: color-mix(in srgb, ' + fgHeader + ' 75%, transparent)'">
                            <span>Profil</span>
                            <span>Berita</span>
                            <span>Agenda</span>
                            <span class="px-2 py-1 rounded-md font-bold" :style="'background-color:' + accent + '; color:' + fgAksen">SPMB 2026</span>
                        </div>
                    </div>

                    <!-- Section & Kartu -->
                    <div class="p-5 sm:p-6" :style="'background-color:' + sectionBg">
                        <div class="max-w-xl mx-auto rounded-xl border p-5" :style="'background-color:' + cardBg + '; border-color:' + garis">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-bold border"
                                  :style="'background-color: color-mix(in srgb, ' + accent + ' 12%, ' + pageBg + '); color:' + fgBadge + '; border-color: color-mix(in srgb, ' + accent + ' 30%, ' + pageBg + ')'">
                                Prestasi Sekolah
                            </span>
                            <h4 class="mt-2.5 text-sm font-bold leading-snug" :style="'color:' + fgKartuHeading">Juara 1 LKS Nasional Bidang Web Technology</h4>
                            <p class="text-xs mt-1.5 leading-relaxed" :style="'color:' + fgKartuTeks">
                                Siswa SMK Negeri 2 Bandung meraih medali emas pada Lomba Kompetensi Siswa tingkat nasional tahun 2026.
                            </p>
                            <p class="text-[11px] mt-1.5" :style="'color:' + fgKartuMuted">Diterbitkan 28 September 2026 · Humas Sekolah</p>

                            <div class="mt-4 flex flex-wrap items-center gap-2.5 pt-3.5" :style="'border-top: 1px solid ' + garis">
                                <button type="button" class="px-4 py-2 rounded-lg text-xs font-bold" :style="'background-color:' + btnBg + '; color:' + fgTombol">Baca Selengkapnya</button>
                                <button type="button" class="px-4 py-2 rounded-lg text-xs font-bold border" :style="'background-color:' + sectionBg + '; color:' + fgSectionHeading + '; border-color:' + garis">Panduan PPDB</button>
                                <span class="text-xs font-semibold underline" :style="'color:' + fgLink">Lihat semua berita</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bar Footer -->
                    <div class="px-5 py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2" :style="'background-color:' + footerBg">
                        <span class="text-[11px] font-semibold" :style="'color: color-mix(in srgb, ' + fgFooter + ' 85%, transparent)'">&copy; 2026 SMK Negeri 2 Bandung</span>
                        <span class="text-[11px]" :style="'color: color-mix(in srgb, ' + fgFooter + ' 65%, transparent)'">Jl. Ciliwung No. 4, Kota Bandung</span>
                    </div>
                </div>
            </div>

            <!-- Legenda Kelas Global -->
            <div class="rounded-2xl border border-slate-200/90 bg-slate-50 p-4 sm:p-5">
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Kelas Global Warna Portal</h4>
                <p class="text-[11px] text-slate-500 mt-1 font-medium">
                    Seluruh halaman publik memakai kelas bersama di bawah ini, jadi satu perubahan tema langsung berlaku menyeluruh.
                </p>
                <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-1.5 text-[11px] font-mono text-slate-600">
                    <span>.theme-page-bg</span>
                    <span>.theme-section-bg</span>
                    <span>.theme-surface-alt</span>
                    <span>.theme-card</span>
                    <span>.theme-heading</span>
                    <span>.theme-text-body</span>
                    <span>.theme-text-muted</span>
                    <span>.theme-link</span>
                    <span>.theme-border / .theme-divider</span>
                    <span>.theme-badge</span>
                    <span>.theme-icon-box</span>
                    <span>.theme-btn-primary / .theme-btn-ghost</span>
                    <span>.theme-header</span>
                    <span>.theme-footer</span>
                    <span>.theme-table-head / .theme-table-row</span>
                    <span>.theme-input</span>
                </div>
            </div>

            <!-- Informasi Penyimpanan -->
            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-[11px] text-slate-500 font-medium">
                <p>
                    Nilai disimpan pada tabel <code class="font-mono">pengaturan_umum</code> dan langsung dipakai seluruh halaman publik sekolah.
                </p>
            </div>
        </form>

    </div>

</div>
@endsection