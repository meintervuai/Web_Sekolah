<!-- TAB 1: DAFTAR SARANA & FASILITAS & HERO BANNER -->
<div x-show="activeTab === 'fasilitas'" x-cloak class="space-y-6">
    <!-- Pengaturan Hero Banner Fasilitas Publik -->
    <form id="form-fasilitas-hero" action="{{ route('tenant.admin.informasi.hero', ['tenant' => app('tenant')->slug, 'modul' => 'fasilitas']) }}" method="POST" @submit="submitLoading = true">
        @csrf
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Kustomisasi Hero Banner Halaman Fasilitas
                    </h2>
                    <p class="text-xs text-slate-500">Atur judul pengantar, subjudul motivasional, dan gambar latar artistik pada bagian atas halaman sarana prasarana publik.</p>
                </div>
                <a href="{{ url(app('tenant')->slug . '/fasilitas') }}" target="_blank" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 shrink-0">
                    <span>Lihat Sarpras Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Judul Utama Hero Banner <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="judul" value="{{ old('judul', $halamanFasilitas->judul) }}" required 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Subjudul / Narasi Hero Banner
                    </label>
                    <textarea name="subjudul" rows="2" 
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">{{ old('subjudul', $halamanFasilitas->subjudul) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Gambar Banner Latar (Pusat Media / URL)
                    </label>
                    <div class="flex gap-2 items-center">
                        <div class="w-16 h-10 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 relative flex items-center justify-center">
                            <template x-if="bannerHeroPreview">
                                <img :src="bannerHeroPreview" alt="Hero Banner Preview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!bannerHeroPreview">
                                <span class="text-[9px] text-slate-500 font-mono">16:9</span>
                            </template>
                        </div>
                        <input type="text" 
                               name="gambar_banner" 
                               id="input_banner_hero_fasilitas" 
                               x-model="bannerHeroPreview" 
                               placeholder="https://... atau pilih dari Pusat Media" 
                               class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        <button type="button" 
                                @click="bukaMediaPicker('banner_hero')" 
                                class="px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Pilih Media
                        </button>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Resolusi minimal 1600x600px rasio lebar untuk tampilan tajam di layar desktop &amp; mobile.</p>
                </div>
            </div>
        </div>
    </form>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
        <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Sarana &amp; Fasilitas Pembelajaran Sekolah
                </h2>
                <p class="text-xs text-slate-500">Kelola katalog bengkel kejuruan, laboratorium komputer, studio multimedia, sarana olahraga, dan sarpras.</p>
            </div>
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <a href="{{ url(app('tenant')->slug . '/fasilitas') }}" target="_blank" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Lihat Sarpras Publik
                </a>
                <button type="button" @click="tambahFasilitasBaru()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Fasilitas Baru
                </button>
            </div>
        </div>

        <!-- Search & Filter Bar with View Mode Toggle -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-1">
            <form action="{{ route('tenant.admin.informasi.fasilitas', ['tenant' => app('tenant')->slug]) }}" method="GET" class="flex-1 flex flex-col sm:flex-row items-center gap-3 w-full">
                <input type="hidden" name="tab" value="fasilitas">
                <div class="relative flex-1 w-full">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama fasilitas, bengkel, atau laboratorium..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer">
                        Cari
                    </button>
                    @if(request()->filled('q'))
                        <a href="{{ route('tenant.admin.informasi.fasilitas', ['tenant' => app('tenant')->slug, 'tab' => 'fasilitas']) }}" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <!-- Switcher Toggle Grid vs List -->
            <div class="flex items-center p-0.5 bg-slate-100 rounded-xl border border-slate-200 shrink-0 self-end sm:self-auto">
                <button 
                    type="button" 
                    @click="viewMode = 'grid'" 
                    :class="viewMode === 'grid' ? 'bg-white text-slate-900 font-bold shadow-2xs' : 'text-slate-500 hover:text-slate-800'"
                    class="px-3 py-1.5 rounded-lg text-xs transition cursor-pointer flex items-center gap-1.5"
                    title="Tampilan Grid / Kartu">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    <span class="text-xs font-semibold">Grid</span>
                </button>
                <button 
                    type="button" 
                    @click="viewMode = 'list'" 
                    :class="viewMode === 'list' ? 'bg-white text-slate-900 font-bold shadow-2xs' : 'text-slate-500 hover:text-slate-800'"
                    class="px-3 py-1.5 rounded-lg text-xs transition cursor-pointer flex items-center gap-1.5"
                    title="Tampilan Tabel / Daftar">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <span class="text-xs font-semibold">Tabel</span>
                </button>
            </div>
        </div>

        <!-- TAMPILAN 1: Grid Cards (Default) -->
        <div x-show="viewMode === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($fasilitasList as $fasilitas)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden flex flex-col justify-between group hover:border-slate-300 hover:shadow-xs transition duration-200">
                <div>
                    <!-- 1:1 Square Image Header -->
                    <div class="relative bg-slate-900 aspect-square overflow-hidden flex items-center justify-center">
                        @if($fasilitas->foto_utama)
                            <img src="{{ $fasilitas->foto_utama }}" alt="" aria-hidden="true" class="absolute inset-0 w-full h-full object-cover blur-md scale-125 opacity-40 pointer-events-none z-0">
                            <img src="{{ $fasilitas->foto_utama }}" alt="{{ $fasilitas->nama_fasilitas }}" loading="lazy" class="relative z-10 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-slate-800 text-slate-400">
                                <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                        @endif

                        <div class="absolute top-2 right-2 z-20">
                            <button type="button" 
                                    @click="toggleItemStatus('fasilitas', {{ $fasilitas->id }})"
                                    class="px-2 py-0.5 rounded-md text-[10px] font-bold backdrop-blur-xs transition cursor-pointer {{ $fasilitas->is_aktif ? 'bg-emerald-600/90 text-white' : 'bg-slate-700/90 text-white' }}">
                                {{ $fasilitas->is_aktif ? 'Aktif' : 'Draf' }}
                            </button>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="p-3.5 space-y-1.5">
                        <h3 class="font-bold text-xs text-slate-900 line-clamp-1 leading-snug group-hover:text-blue-600 transition" title="{{ $fasilitas->nama_fasilitas }}">
                            {{ $fasilitas->nama_fasilitas }}
                        </h3>
                        <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed">
                            {{ $fasilitas->deskripsi ?: 'Tidak ada deskripsi sarana.' }}
                        </p>
                    </div>
                </div>

                <!-- Card Actions -->
                <div class="px-3.5 py-2 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between gap-1">
                    <a href="{{ url(app('tenant')->slug . '/fasilitas') }}" target="_blank" 
                       class="text-[11px] font-semibold text-slate-600 hover:text-blue-600 flex items-center gap-1 transition"
                       title="Lihat Halaman Publik">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>Lihat</span>
                    </a>
                    <div class="flex items-center gap-1">
                        <button type="button" @click="editFasilitasItem({{ Js::from($fasilitas) }})" 
                                class="p-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-blue-600 transition cursor-pointer"
                                title="Edit Fasilitas">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </button>
                        <button type="button" @click="konfirmasiHapusFasilitas({{ Js::from($fasilitas->id) }}, {{ Js::from($fasilitas->nama_fasilitas) }})" 
                                class="p-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-600 transition cursor-pointer"
                                title="Hapus Fasilitas">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center text-slate-400 bg-slate-50 rounded-2xl border border-slate-200">
                <svg class="w-12 h-12 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <p class="text-xs font-semibold">Belum ada data sarana &amp; fasilitas pembelajaran yang ditambahkan.</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Klik tombol "Tambah Fasilitas Baru" untuk memulai katalog sarpras.</p>
            </div>
            @endforelse
        </div>

        <!-- TAMPILAN 2: Tabel / List -->
        <div x-show="viewMode === 'list'" class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-3 w-12 text-center">No</th>
                        <th class="px-3 py-3 w-20 text-center">Foto</th>
                        <th class="px-4 py-3">Nama Sarana &amp; Fasilitas</th>
                        <th class="px-4 py-3">Deskripsi</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($fasilitasList as $index => $fasilitas)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-3 px-3 text-center text-slate-400 font-medium">
                            {{ $fasilitasList->firstItem() + $index }}
                        </td>
                        <td class="px-3 py-3 text-center">
                            <div class="w-12 h-12 mx-auto rounded-lg border border-slate-200 bg-slate-100 overflow-hidden relative">
                                @if($fasilitas->foto_utama)
                                    <img src="{{ $fasilitas->foto_utama }}" alt="{{ $fasilitas->nama_fasilitas }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 font-medium text-slate-900 max-w-xs">
                            <div class="font-bold text-xs line-clamp-1">{{ $fasilitas->nama_fasilitas }}</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">{{ $fasilitas->foto_lainnya ? count($fasilitas->foto_lainnya) . ' foto tambahan' : 'Tanpa foto tambahan' }}</div>
                        </td>
                        <td class="px-4 py-3 text-slate-600 max-w-sm">
                            <div class="line-clamp-2 leading-relaxed">{{ $fasilitas->deskripsi ?: 'Tidak ada deskripsi.' }}</div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button type="button" 
                                    @click="toggleItemStatus('fasilitas', {{ $fasilitas->id }})"
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold transition cursor-pointer {{ $fasilitas->is_aktif ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $fasilitas->is_aktif ? 'bg-emerald-600' : 'bg-slate-400' }}"></span>
                                <span>{{ $fasilitas->is_aktif ? 'Aktif' : 'Draf' }}</span>
                            </button>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ url(app('tenant')->slug . '/fasilitas') }}" target="_blank" 
                                   class="p-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-blue-600 transition"
                                   title="Lihat Halaman Publik">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                                <button type="button" @click="editFasilitasItem({{ Js::from($fasilitas) }})" 
                                        class="p-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-blue-600 transition cursor-pointer"
                                        title="Edit Fasilitas">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>
                                <button type="button" @click="konfirmasiHapusFasilitas({{ Js::from($fasilitas->id) }}, {{ Js::from($fasilitas->nama_fasilitas) }})" 
                                        class="p-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-600 transition cursor-pointer"
                                        title="Hapus Fasilitas">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400 italic">
                            Belum ada fasilitas yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($fasilitasList->hasPages())
            <div class="pt-2">
                {{ $fasilitasList->links() }}
            </div>
        @endif
    </div>
</div>
