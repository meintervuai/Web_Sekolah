<!-- TAB 3: VISIBILITAS MENU & RUTE PROGRAM KEAHLIAN -->
<div x-show="activeTab === 'visibilitas'" x-cloak class="space-y-6">
    <div class="admin-card space-y-5">
        <div class="admin-card-header">
            <div>
                <h2 class="admin-card-title">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Sakelar Visibilitas Menu &amp; Rute Program Keahlian
                </h2>
                <p class="admin-card-subtitle mt-0.5">
                    Kontrol ketersediaan menu navigasi di header/footer, katalog di halaman beranda, dan akses rute publik (<code>/program-keahlian</code>).
                </p>
            </div>
            <span class="admin-badge-primary self-start">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                Feature Flag Protection
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead class="admin-table-thead">
                    <tr>
                        <th class="admin-table-th">Komponen &amp; Rute</th>
                        <th class="admin-table-th">Tipe &amp; Penempatan</th>
                        <th class="admin-table-th">Kode Fitur</th>
                        <th class="admin-table-th">Status Saat Ini</th>
                        <th class="admin-table-th text-right">Sakelar Visibilitas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="bg-blue-50/60 font-bold text-slate-900 border-t-2 border-blue-200">
                        <td class="admin-table-td flex items-center gap-2">
                            <div class="w-3 h-3 rounded-md bg-blue-600 flex items-center justify-center text-[9px] text-white">★</div>
                            <span class="text-xs sm:text-sm text-blue-950">Menu Utama &amp; Rute Program Keahlian</span>
                        </td>
                        <td class="admin-table-td font-mono text-xs text-blue-800">Navbar / Katalog / Detail</td>
                        <td class="admin-table-td font-mono text-xs text-blue-700 font-semibold">program_keahlian</td>
                        <td class="admin-table-td">
                            <span :class="isFiturAktif ? 'admin-badge-success' : 'admin-badge-slate'">
                                <span x-text="isFiturAktif ? 'Aktif (Tampil di Publik)' : 'Nonaktif (Disembunyikan)'"></span>
                            </span>
                        </td>
                        <td class="admin-table-td text-right">
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
