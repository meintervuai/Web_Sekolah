<!-- TAB 7: VISIBILITAS MENU, HALAMAN & SECTION PROFIL -->
<div x-show="activeTab === 'visibilitas'" x-cloak class="space-y-6">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-5">
        <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">Sakelar Visibilitas Menu, Sub-Menu &amp; Section Profil</h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    Kelola visibilitas hierarki dari Menu Utama, Halaman Khusus, hingga Bagian/Section internal. Jika menu tingkat tertinggi dinonaktifkan, seluruh sub-item dan section di bawahnya otomatis ikut dinonaktifkan.
                </p>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 self-start">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                Hierarki Bertingkat (Cascade)
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3">Tingkat / Komponen Menu &amp; Section</th>
                        <th class="px-4 py-3">Tipe &amp; Penempatan</th>
                        <th class="px-4 py-3">Kode Fitur</th>
                        <th class="px-4 py-3">Status Saat Ini</th>
                        <th class="px-4 py-3 text-right">Sakelar Visibilitas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    
                    <!-- =========================================================
                         LEVEL 1: INDUK MENU PROFIL SEKOLAH (NAVBAR UTAMA)
                    ========================================================== -->
                    <tr class="bg-blue-50/60 font-bold text-slate-900 border-t-2 border-blue-200">
                        <td class="px-4 py-3.5 flex items-center gap-2">
                            <div class="w-3 h-3 rounded-md bg-blue-600 flex items-center justify-center text-[9px] text-white">★</div>
                            <span class="text-xs sm:text-sm text-blue-950">1. Menu Utama Profil Sekolah (Induk Navbar)</span>
                        </td>
                        <td class="px-4 py-3.5 font-mono text-xs text-blue-800">Navbar / Profil</td>
                        <td class="px-4 py-3.5 font-mono text-xs text-blue-700 font-semibold">menu_profil</td>
                        <td class="px-4 py-3.5">
                            <span :class="menuToggles['menu_profil'] ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'"
                                  class="px-2.5 py-1 rounded-full text-[10px] font-bold">
                                <span x-text="menuToggles['menu_profil'] ? 'Aktif (Tampil di Navbar)' : 'Nonaktif (Sembunyi Semua)'"></span>
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-right">
                            <button type="button" 
                                    @click="askToggleConfirmation(null, 'menu_profil', 'Menu Utama Profil Sekolah', !menuToggles['menu_profil'])"
                                    :class="menuToggles['menu_profil'] ? 'bg-blue-600' : 'bg-slate-300'"
                                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                <span :style="menuToggles['menu_profil'] ? 'transform: translateX(20px);' : 'transform: translateX(0px);'"
                                      class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md ring-0 transition-transform duration-300 ease-in-out"></span>
                            </button>
                        </td>
                    </tr>

                    <!-- ---------------------------------------------------------
                         SUB I: TAB 1 / SECTION DATA DIRI SEKOLAH
                    ---------------------------------------------------------- -->
                    <tr class="hover:bg-slate-50 transition" :class="!menuToggles['menu_profil'] ? 'opacity-40 pointer-events-none bg-slate-50/50' : ''">
                        <td class="px-4 py-3 font-bold text-slate-800 pl-7 flex items-center gap-2">
                            <span class="text-blue-500 font-mono">I.</span>
                            Data Diri Sekolah &amp; Identitas Pokok
                        </td>
                        <td class="px-4 py-3 text-slate-500 text-[11px]">Sub-Section / Halaman Profil</td>
                        <td class="px-4 py-3 font-mono text-xs text-slate-600">profil_data_pokok</td>
                        <td class="px-4 py-3">
                            <span :class="(menuToggles['menu_profil'] && menuToggles['profil_data_pokok']) ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'"
                                  class="px-2.5 py-1 rounded-full text-[10px] font-bold">
                                <span x-text="(menuToggles['menu_profil'] && menuToggles['profil_data_pokok']) ? 'Tampil' : 'Disembunyikan'"></span>
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button type="button" 
                                    @click="askToggleConfirmation(null, 'profil_data_pokok', 'Section Data Pokok Sekolah', !menuToggles['profil_data_pokok'])"
                                    :class="(menuToggles['menu_profil'] && menuToggles['profil_data_pokok']) ? 'bg-blue-600' : 'bg-slate-300'"
                                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                <span :style="(menuToggles['menu_profil'] && menuToggles['profil_data_pokok']) ? 'transform: translateX(20px);' : 'transform: translateX(0px);'"
                                      class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md ring-0 transition-transform duration-300 ease-in-out"></span>
                            </button>
                        </td>
                    </tr>

                    <!-- SUB I.1: Kepala Satuan Pendidikan & Sambutan (Beranda & Profil) -->
                    <tr class="hover:bg-slate-50 transition" :class="(!menuToggles['menu_profil'] || !menuToggles['profil_data_pokok']) ? 'opacity-40 pointer-events-none bg-slate-50/50' : ''">
                        <td class="px-4 py-2.5 font-medium text-slate-700 pl-12 flex items-center gap-2">
                            <span class="text-slate-400">↳</span>
                            Kepala Satuan Pendidikan &amp; Sambutan
                        </td>
                        <td class="px-4 py-2.5 text-slate-500 text-[11px]">Card Beranda &amp; Profil</td>
                        <td class="px-4 py-2.5 font-mono text-xs text-slate-500">profil_sambutan_kepsek</td>
                        <td class="px-4 py-2.5">
                            <span :class="(menuToggles['menu_profil'] && menuToggles['profil_data_pokok'] && menuToggles['profil_sambutan_kepsek']) ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'"
                                  class="px-2.5 py-1 rounded-full text-[10px] font-bold">
                                <span x-text="(menuToggles['menu_profil'] && menuToggles['profil_data_pokok'] && menuToggles['profil_sambutan_kepsek']) ? 'Tampil' : 'Disembunyikan'"></span>
                            </span>
                        </td>
                        <td class="px-4 py-2.5 text-right">
                            <button type="button" 
                                    @click="askToggleConfirmation(null, 'profil_sambutan_kepsek', 'Sambutan Kepala Sekolah', !menuToggles['profil_sambutan_kepsek'])"
                                    :class="(menuToggles['menu_profil'] && menuToggles['profil_data_pokok'] && menuToggles['profil_sambutan_kepsek']) ? 'bg-blue-600' : 'bg-slate-300'"
                                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                <span :style="(menuToggles['menu_profil'] && menuToggles['profil_data_pokok'] && menuToggles['profil_sambutan_kepsek']) ? 'transform: translateX(20px);' : 'transform: translateX(0px);'"
                                      class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md ring-0 transition-transform duration-300 ease-in-out"></span>
                            </button>
                        </td>
                    </tr>

                    <!-- SUB I.2: Video Profil Sekolah -->
                    <tr class="hover:bg-slate-50 transition" :class="(!menuToggles['menu_profil'] || !menuToggles['profil_data_pokok']) ? 'opacity-40 pointer-events-none bg-slate-50/50' : ''">
                        <td class="px-4 py-2.5 font-medium text-slate-700 pl-12 flex items-center gap-2">
                            <span class="text-slate-400">↳</span>
                            Video Profil Sekolah (Player Media)
                        </td>
                        <td class="px-4 py-2.5 text-slate-500 text-[11px]">Kolom Kanan / Halaman Profil</td>
                        <td class="px-4 py-2.5 font-mono text-xs text-slate-500">profil_video</td>
                        <td class="px-4 py-2.5">
                            <span :class="(menuToggles['menu_profil'] && menuToggles['profil_data_pokok'] && menuToggles['profil_video']) ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'"
                                  class="px-2.5 py-1 rounded-full text-[10px] font-bold">
                                <span x-text="(menuToggles['menu_profil'] && menuToggles['profil_data_pokok'] && menuToggles['profil_video']) ? 'Tampil' : 'Disembunyikan'"></span>
                            </span>
                        </td>
                        <td class="px-4 py-2.5 text-right">
                            <button type="button" 
                                    @click="askToggleConfirmation(null, 'profil_video', 'Video Profil Sekolah', !menuToggles['profil_video'])"
                                    :class="(menuToggles['menu_profil'] && menuToggles['profil_data_pokok'] && menuToggles['profil_video']) ? 'bg-blue-600' : 'bg-slate-300'"
                                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                <span :style="(menuToggles['menu_profil'] && menuToggles['profil_data_pokok'] && menuToggles['profil_video']) ? 'transform: translateX(20px);' : 'transform: translateX(0px);'"
                                      class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md ring-0 transition-transform duration-300 ease-in-out"></span>
                            </button>
                        </td>
                    </tr>

                    <!-- ---------------------------------------------------------
                         SUB II: PROFIL LENGKAP & BUDAYA SEKOLAH
                    ---------------------------------------------------------- -->
                    <tr class="hover:bg-slate-50 transition" :class="!menuToggles['menu_profil'] ? 'opacity-40 pointer-events-none bg-slate-50/50' : ''">
                        <td class="px-4 py-3 font-bold text-slate-800 pl-7 flex items-center gap-2">
                            <span class="text-blue-500 font-mono">II.</span>
                            Profil Lengkap &amp; Budaya Sekolah
                        </td>
                        <td class="px-4 py-3 font-mono text-slate-500">/profil</td>
                        <td class="px-4 py-3 font-mono text-xs text-blue-600">profil</td>
                        <td class="px-4 py-3">
                            <span :class="(menuToggles['menu_profil'] && menuToggles['profil']) ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'"
                                  class="px-2.5 py-1 rounded-full text-[10px] font-bold">
                                <span x-text="(menuToggles['menu_profil'] && menuToggles['profil']) ? 'Tampil di Publik' : 'Disembunyikan'"></span>
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button type="button" 
                                    @click="askToggleConfirmation(null, 'profil', 'Halaman Profil Lengkap', !menuToggles['profil'])"
                                    :class="(menuToggles['menu_profil'] && menuToggles['profil']) ? 'bg-blue-600' : 'bg-slate-300'"
                                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                <span :style="(menuToggles['menu_profil'] && menuToggles['profil']) ? 'transform: translateX(20px);' : 'transform: translateX(0px);'"
                                      class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md ring-0 transition-transform duration-300 ease-in-out"></span>
                            </button>
                        </td>
                    </tr>

                    <!-- ---------------------------------------------------------
                         SUB III: SEJARAH SEKOLAH
                    ---------------------------------------------------------- -->
                    <tr class="hover:bg-slate-50 transition" :class="!menuToggles['menu_profil'] ? 'opacity-40 pointer-events-none bg-slate-50/50' : ''">
                        <td class="px-4 py-3 font-bold text-slate-800 pl-7 flex items-center gap-2">
                            <span class="text-blue-500 font-mono">III.</span>
                            Sejarah Sekolah
                        </td>
                        <td class="px-4 py-3 font-mono text-slate-500">/profil/sejarah</td>
                        <td class="px-4 py-3 font-mono text-xs text-blue-600">sejarah</td>
                        <td class="px-4 py-3">
                            <span :class="(menuToggles['menu_profil'] && menuToggles['sejarah']) ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'"
                                  class="px-2.5 py-1 rounded-full text-[10px] font-bold">
                                <span x-text="(menuToggles['menu_profil'] && menuToggles['sejarah']) ? 'Tampil di Publik' : 'Disembunyikan'"></span>
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button type="button" 
                                    @click="askToggleConfirmation(null, 'sejarah', 'Halaman Sejarah Sekolah', !menuToggles['sejarah'])"
                                    :class="(menuToggles['menu_profil'] && menuToggles['sejarah']) ? 'bg-blue-600' : 'bg-slate-300'"
                                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                <span :style="(menuToggles['menu_profil'] && menuToggles['sejarah']) ? 'transform: translateX(20px);' : 'transform: translateX(0px);'"
                                      class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md ring-0 transition-transform duration-300 ease-in-out"></span>
                            </button>
                        </td>
                    </tr>

                    <!-- ---------------------------------------------------------
                         SUB IV: VISI, MISI & TUJUAN
                    ---------------------------------------------------------- -->
                    <tr class="hover:bg-slate-50 transition" :class="!menuToggles['menu_profil'] ? 'opacity-40 pointer-events-none bg-slate-50/50' : ''">
                        <td class="px-4 py-3 font-bold text-slate-800 pl-7 flex items-center gap-2">
                            <span class="text-blue-500 font-mono">IV.</span>
                            Visi, Misi &amp; Sasaran Mutu
                        </td>
                        <td class="px-4 py-3 font-mono text-slate-500">/profil/visi-misi</td>
                        <td class="px-4 py-3 font-mono text-xs text-blue-600">visi_misi</td>
                        <td class="px-4 py-3">
                            <span :class="(menuToggles['menu_profil'] && menuToggles['visi_misi']) ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'"
                                  class="px-2.5 py-1 rounded-full text-[10px] font-bold">
                                <span x-text="(menuToggles['menu_profil'] && menuToggles['visi_misi']) ? 'Tampil di Publik' : 'Disembunyikan'"></span>
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button type="button" 
                                    @click="askToggleConfirmation(null, 'visi_misi', 'Visi & Misi', !menuToggles['visi_misi'])"
                                    :class="(menuToggles['menu_profil'] && menuToggles['visi_misi']) ? 'bg-blue-600' : 'bg-slate-300'"
                                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                <span :style="(menuToggles['menu_profil'] && menuToggles['visi_misi']) ? 'transform: translateX(20px);' : 'transform: translateX(0px);'"
                                      class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md ring-0 transition-transform duration-300 ease-in-out"></span>
                            </button>
                        </td>
                    </tr>

                    <!-- ---------------------------------------------------------
                         SUB V: STRUKTUR ORGANISASI (INDUK HALAMAN STRUKTUR)
                    ---------------------------------------------------------- -->
                    <tr class="hover:bg-slate-50 transition" :class="!menuToggles['menu_profil'] ? 'opacity-40 pointer-events-none bg-slate-50/50' : ''">
                        <td class="px-4 py-3 font-bold text-slate-800 pl-7 flex items-center gap-2">
                            <span class="text-blue-500 font-mono">V.</span>
                            Struktur Organisasi (Halaman / Rute)
                        </td>
                        <td class="px-4 py-3 font-mono text-slate-500">/profil/struktur</td>
                        <td class="px-4 py-3 font-mono text-xs text-blue-600">struktur_organisasi</td>
                        <td class="px-4 py-3">
                            <span :class="(menuToggles['menu_profil'] && menuToggles['struktur_organisasi']) ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'"
                                  class="px-2.5 py-1 rounded-full text-[10px] font-bold">
                                <span x-text="(menuToggles['menu_profil'] && menuToggles['struktur_organisasi']) ? 'Tampil di Publik' : 'Disembunyikan'"></span>
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button type="button" 
                                    @click="askToggleConfirmation(null, 'struktur_organisasi', 'Halaman Struktur Organisasi', !menuToggles['struktur_organisasi'])"
                                    :class="(menuToggles['menu_profil'] && menuToggles['struktur_organisasi']) ? 'bg-blue-600' : 'bg-slate-300'"
                                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                <span :style="(menuToggles['menu_profil'] && menuToggles['struktur_organisasi']) ? 'transform: translateX(20px);' : 'transform: translateX(0px);'"
                                      class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md ring-0 transition-transform duration-300 ease-in-out"></span>
                            </button>
                        </td>
                    </tr>

                    <!-- SUB V.1: Bagan Diagram Struktur Organisasi -->
                    <tr class="hover:bg-slate-50 transition" :class="(!menuToggles['menu_profil'] || !menuToggles['struktur_organisasi']) ? 'opacity-40 pointer-events-none bg-slate-50/50' : ''">
                        <td class="px-4 py-2.5 font-medium text-slate-700 pl-12 flex items-center gap-2">
                            <span class="text-slate-400">↳</span>
                            Bagan Diagram Struktur Organisasi
                        </td>
                        <td class="px-4 py-2.5 text-slate-500 text-[11px]">Tab Bagan / Gambar Alur</td>
                        <td class="px-4 py-2.5 font-mono text-xs text-slate-500">struktur_diagram</td>
                        <td class="px-4 py-2.5">
                            <span :class="(menuToggles['menu_profil'] && menuToggles['struktur_organisasi'] && menuToggles['struktur_diagram']) ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'"
                                  class="px-2.5 py-1 rounded-full text-[10px] font-bold">
                                <span x-text="(menuToggles['menu_profil'] && menuToggles['struktur_organisasi'] && menuToggles['struktur_diagram']) ? 'Tampil' : 'Disembunyikan'"></span>
                            </span>
                        </td>
                        <td class="px-4 py-2.5 text-right">
                            <button type="button" 
                                    @click="askToggleConfirmation(null, 'struktur_diagram', 'Bagan Diagram Struktur', !menuToggles['struktur_diagram'])"
                                    :class="(menuToggles['menu_profil'] && menuToggles['struktur_organisasi'] && menuToggles['struktur_diagram']) ? 'bg-blue-600' : 'bg-slate-300'"
                                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                <span :style="(menuToggles['menu_profil'] && menuToggles['struktur_organisasi'] && menuToggles['struktur_diagram']) ? 'transform: translateX(20px);' : 'transform: translateX(0px);'"
                                      class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md ring-0 transition-transform duration-300 ease-in-out"></span>
                            </button>
                        </td>
                    </tr>

                    <!-- SUB V.2: Daftar Pejabat Struktural -->
                    <tr class="hover:bg-slate-50 transition" :class="(!menuToggles['menu_profil'] || !menuToggles['struktur_organisasi']) ? 'opacity-40 pointer-events-none bg-slate-50/50' : ''">
                        <td class="px-4 py-2.5 font-medium text-slate-700 pl-12 flex items-center gap-2">
                            <span class="text-slate-400">↳</span>
                            Daftar Pejabat Struktural (Grid Foto Pimpinan)
                        </td>
                        <td class="px-4 py-2.5 text-slate-500 text-[11px]">Tab Jajaran Pejabat</td>
                        <td class="px-4 py-2.5 font-mono text-xs text-slate-500">struktur_pejabat</td>
                        <td class="px-4 py-2.5">
                            <span :class="(menuToggles['menu_profil'] && menuToggles['struktur_organisasi'] && menuToggles['struktur_pejabat']) ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'"
                                  class="px-2.5 py-1 rounded-full text-[10px] font-bold">
                                <span x-text="(menuToggles['menu_profil'] && menuToggles['struktur_organisasi'] && menuToggles['struktur_pejabat']) ? 'Tampil' : 'Disembunyikan'"></span>
                            </span>
                        </td>
                        <td class="px-4 py-2.5 text-right">
                            <button type="button" 
                                    @click="askToggleConfirmation(null, 'struktur_pejabat', 'Daftar Pejabat Struktural', !menuToggles['struktur_pejabat'])"
                                    :class="(menuToggles['menu_profil'] && menuToggles['struktur_organisasi'] && menuToggles['struktur_pejabat']) ? 'bg-blue-600' : 'bg-slate-300'"
                                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                <span :style="(menuToggles['menu_profil'] && menuToggles['struktur_organisasi'] && menuToggles['struktur_pejabat']) ? 'transform: translateX(20px);' : 'transform: translateX(0px);'"
                                      class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md ring-0 transition-transform duration-300 ease-in-out"></span>
                            </button>
                        </td>
                    </tr>

                    <!-- ---------------------------------------------------------
                         SUB VI: GURU & TENAGA KEPENDIDIKAN
                    ---------------------------------------------------------- -->
                    <tr class="hover:bg-slate-50 transition" :class="!menuToggles['menu_profil'] ? 'opacity-40 pointer-events-none bg-slate-50/50' : ''">
                        <td class="px-4 py-3 font-bold text-slate-800 pl-7 flex items-center gap-2">
                            <span class="text-blue-500 font-mono">VI.</span>
                            Guru &amp; Tenaga Kependidikan (Direktori PTK)
                        </td>
                        <td class="px-4 py-3 font-mono text-slate-500">/guru-staf</td>
                        <td class="px-4 py-3 font-mono text-xs text-blue-600">guru_staf</td>
                        <td class="px-4 py-3">
                            <span :class="(menuToggles['menu_profil'] && menuToggles['guru_staf']) ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'"
                                  class="px-2.5 py-1 rounded-full text-[10px] font-bold">
                                <span x-text="(menuToggles['menu_profil'] && menuToggles['guru_staf']) ? 'Tampil di Publik' : 'Disembunyikan'"></span>
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button type="button" 
                                    @click="askToggleConfirmation(null, 'guru_staf', 'Guru & Staf', !menuToggles['guru_staf'])"
                                    :class="(menuToggles['menu_profil'] && menuToggles['guru_staf']) ? 'bg-blue-600' : 'bg-slate-300'"
                                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                <span :style="(menuToggles['menu_profil'] && menuToggles['guru_staf']) ? 'transform: translateX(20px);' : 'transform: translateX(0px);'"
                                      class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md ring-0 transition-transform duration-300 ease-in-out"></span>
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
