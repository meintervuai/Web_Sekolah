<!-- TAB 3: VISIBILITAS MENU & RUTE PROGRAM KEAHLIAN -->
<div x-show="activeTab === 'visibilitas'" x-cloak class="space-y-6">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-5">
        <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">Sakelar Visibilitas Menu &amp; Rute Program Keahlian</h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    Kontrol ketersediaan menu navigasi di header/footer, katalog di halaman beranda, dan akses rute publik (<code>/program-keahlian</code>).
                </p>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 self-start">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                Feature Flag Protection
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3">Komponen &amp; Rute</th>
                        <th class="px-4 py-3">Tipe &amp; Penempatan</th>
                        <th class="px-4 py-3">Kode Fitur</th>
                        <th class="px-4 py-3">Status Saat Ini</th>
                        <th class="px-4 py-3 text-right">Sakelar Visibilitas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="bg-blue-50/60 font-bold text-slate-900 border-t-2 border-blue-200">
                        <td class="px-4 py-3.5 flex items-center gap-2">
                            <div class="w-3 h-3 rounded-md bg-blue-600 flex items-center justify-center text-[9px] text-white">★</div>
                            <span class="text-xs sm:text-sm text-blue-950">Menu Utama &amp; Rute Program Keahlian</span>
                        </td>
                        <td class="px-4 py-3.5 font-mono text-xs text-blue-800">Navbar / Katalog / Detail</td>
                        <td class="px-4 py-3.5 font-mono text-xs text-blue-700 font-semibold">program_keahlian</td>
                        <td class="px-4 py-3.5">
                            <span :class="isFiturAktif ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'"
                                  class="px-2.5 py-1 rounded-full text-[10px] font-bold">
                                <span x-text="isFiturAktif ? 'Aktif (Tampil di Publik)' : 'Nonaktif (Disembunyikan)'"></span>
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-right">
                            <button type="button" 
                                    @click="toggleFeatureFlag(!isFiturAktif)"
                                    :class="isFiturAktif ? 'bg-blue-600' : 'bg-slate-300'"
                                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                <span :style="isFiturAktif ? 'transform: translateX(20px);' : 'transform: translateX(0px);'"
                                      class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md ring-0 transition-transform duration-300 ease-in-out"></span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-2 text-xs text-slate-600">
            <h4 class="font-bold text-slate-800 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Perilaku Sistem Saat Fitur Dinonaktifkan:
            </h4>
            <ul class="list-disc list-inside space-y-1 pl-1 text-[11px] text-slate-500">
                <li>Link <strong>Program Keahlian</strong> pada header navigasi &amp; drawer mobile otomatis disembunyikan.</li>
                <li>Bagian katalog konsentrasi keahlian di halaman depan (<code>/home</code>) tidak akan dimuat.</li>
                <li>Pengunjung yang mengakses langsung URL <code>/program-keahlian</code> atau <code>/program-keahlian/{slug}</code> akan menerima respons 404 (Halaman Tidak Ditemukan) dengan pesan yang aman.</li>
            </ul>
        </div>
    </div>
</div>
