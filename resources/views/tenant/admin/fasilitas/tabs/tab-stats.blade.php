{{-- =========================================================================
     TAB 3: STATISTIK CEPAT SARPRAS
========================================================================== --}}
<div x-show="activeTab === 'stats'" x-cloak class="space-y-6">
    <form id="form-fasilitas-stats" action="{{ route('tenant.admin.informasi.fasilitas.stats.update', ['tenant' => app('tenant')->slug]) }}" method="POST" @submit="submitLoading = true">
        @csrf
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4 max-w-2xl">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Statistik Cepat Sarana &amp; Prasarana
                </h2>
                <p class="text-xs text-slate-500">Angka metrik ini tampil pada bar ringkasan atas di halaman publik Fasilitas.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Jumlah Ruang Kelas Teori <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="stats_ruang_kelas" value="{{ old('stats_ruang_kelas', $stats['ruang_kelas']) }}" required placeholder="Contoh: 41" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Jumlah Bengkel Praktik &amp; Lab <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="stats_bengkel_lab" value="{{ old('stats_bengkel_lab', $stats['bengkel_lab']) }}" required placeholder="Contoh: 7+" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Perpustakaan Terakreditasi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="stats_perpustakaan" value="{{ old('stats_perpustakaan', $stats['perpustakaan']) }}" required placeholder="Contoh: 1" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Akses Internet Kampus <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="stats_akses_internet" value="{{ old('stats_akses_internet', $stats['akses_internet']) }}" required placeholder="Contoh: 100%" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>
            </div>
        </div>
    </form>
</div>
