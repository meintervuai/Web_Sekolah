<!-- TAB 1: DAFTAR ALBUM GALERI & HERO BANNER -->
<div x-show="activeTab === 'album'" x-cloak class="space-y-6">
    <!-- Pengaturan Hero Banner Galeri Publik -->
    <form id="form-galeri-hero" action="{{ route('tenant.admin.informasi.hero', ['tenant' => app('tenant')->slug, 'modul' => 'galeri']) }}" method="POST" @submit="submitLoading = true">
        @csrf
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Kustomisasi Hero Banner Halaman Galeri
                    </h2>
                    <p class="text-xs text-slate-500">Atur judul pengantar, subjudul motivasional, dan gambar latar artistik pada bagian atas halaman galeri dokumentasi.</p>
                </div>
                <a href="{{ url(app('tenant')->slug . '/galeri') }}" target="_blank" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 shrink-0">
                    <span>Lihat Galeri Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Judul Utama Hero Banner <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="judul" value="{{ old('judul', $halamanGaleri->judul) }}" required 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Subjudul / Narasi Hero Banner
                    </label>
                    <textarea name="subjudul" rows="2" 
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">{{ old('subjudul', $halamanGaleri->subjudul) }}</textarea>
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
                               id="input_banner_hero_galeri" 
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
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    Daftar Album Foto &amp; Video Galeri
                </h2>
                <p class="text-xs text-slate-500">Kelola album kegiatan, kunjungan industri, upacara, dan dokumentasi aktivitas sekolah.</p>
            </div>
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <a href="{{ url(app('tenant')->slug . '/galeri') }}" target="_blank" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Lihat Galeri Publik
                </a>
                <button type="button" @click="tambahAlbumBaru()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Buat Album Baru
                </button>
            </div>
        </div>

        <!-- Search & Filter Bar with View Mode Toggle -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-1">
            <form action="{{ route('tenant.admin.informasi.galeri', ['tenant' => app('tenant')->slug]) }}" method="GET" class="flex-1 flex flex-col sm:flex-row items-center gap-3 w-full">
                <input type="hidden" name="tab" value="album">
                <div class="relative flex-1 w-full">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama album atau deskripsi..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer">
                        Cari
                    </button>
                    @if(request()->filled('q'))
                        <a href="{{ route('tenant.admin.informasi.galeri', ['tenant' => app('tenant')->slug, 'tab' => 'album']) }}" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <!-- Switcher Toggle Grid vs List -->
            <div class="flex items-center p-0.5 bg-slate-100 rounded-xl border border-slate-200 shrink-0 self-end sm:self-auto">
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
            </div>
        </div>

        <!-- TAMPILAN 1: Grid Cards (Default) -->
        <div x-show="viewMode === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($albumList as $alb)
            <div class="bg-white rounded-2xl border {{ (isset($selectedAlbum) && $selectedAlbum && $selectedAlbum->id === $alb->id) ? 'border-blue-500 ring-2 ring-blue-500/20' : 'border-slate-200/80' }} shadow-2xs overflow-hidden flex flex-col justify-between group hover:border-slate-300 hover:shadow-xs transition duration-200">
                <div>
                    <!-- Cover Image Header -->
                    <div class="relative bg-slate-900 aspect-16/9 overflow-hidden flex items-center justify-center">
                        @if($alb->cover_album)
                            <img src="{{ $alb->cover_album }}" alt="" aria-hidden="true" class="absolute inset-0 w-full h-full object-cover blur-md scale-125 opacity-40 pointer-events-none z-0">
                            <img src="{{ $alb->cover_album }}" alt="{{ $alb->nama_album }}" loading="lazy" class="relative z-10 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-slate-800 text-slate-400">
                                <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif

                        <div class="absolute top-2 left-2 z-20">
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider bg-black/60 backdrop-blur-xs text-white border border-white/20">
                                {{ $alb->tipe === 'video' ? 'Video' : 'Foto' }}
                            </span>
                        </div>
                        <div class="absolute top-2 right-2 z-20">
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-600/90 text-white backdrop-blur-xs">
                                {{ $alb->items_count }} media
                            </span>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="p-3.5 space-y-1.5">
                        <h3 class="font-bold text-xs text-slate-900 line-clamp-1 leading-snug group-hover:text-blue-600 transition" title="{{ $alb->nama_album }}">
                            {{ $alb->nama_album }}
                        </h3>
                        <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed">
                            {{ $alb->deskripsi ?: 'Tidak ada deskripsi album.' }}
                        </p>
                    </div>
                </div>

                <!-- Card Actions -->
                <div class="px-3.5 py-2.5 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between gap-1">
                    <a href="{{ route('tenant.admin.informasi.galeri', ['tenant' => app('tenant')->slug, 'album_id' => $alb->id, 'tab' => 'items']) }}" 
                       class="px-2.5 py-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold transition flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>Kelola Media</span>
                    </a>
                    <div class="flex items-center gap-1">
                        <button type="button" 
                                @click="editAlbumItem(@js($alb))" 
                                class="p-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-amber-600 transition cursor-pointer" 
                                title="Edit Album">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </button>
                        <button type="button" 
                                @click="konfirmasiHapusAlbum(@js($alb->id), @js($alb->nama_album), @js($alb->items_count))" 
                                class="p-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-600 transition cursor-pointer" 
                                title="Hapus Album">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center text-slate-400 bg-slate-50 rounded-2xl border border-slate-200">
                <svg class="w-12 h-12 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-xs font-semibold">Belum ada album galeri yang dibuat.</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Klik tombol "Buat Album Baru" untuk menambahkan album kegiatan.</p>
            </div>
            @endforelse
        </div>

        <!-- TAMPILAN 2: Tabel / List -->
        <div x-show="viewMode === 'list'" class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-3 w-12 text-center">No</th>
                        <th class="px-3 py-3 w-20 text-center">Cover</th>
                        <th class="px-4 py-3">Nama Album &amp; Deskripsi</th>
                        <th class="px-4 py-3">Tipe</th>
                        <th class="px-4 py-3 text-center">Total Media</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($albumList as $index => $alb)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-3 px-3 text-center text-slate-400 font-medium">
                            {{ $albumList->firstItem() + $index }}
                        </td>
                        <td class="px-3 py-3 text-center">
                            <div class="w-16 h-10 mx-auto rounded-lg border border-slate-200 bg-slate-100 overflow-hidden relative">
                                @if($alb->cover_album)
                                    <img src="{{ $alb->cover_album }}" alt="{{ $alb->nama_album }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 font-medium text-slate-900 max-w-xs">
                            <div class="font-bold text-xs line-clamp-1">{{ $alb->nama_album }}</div>
                            <div class="text-[11px] text-slate-400 mt-0.5 truncate">{{ $alb->deskripsi ?: 'Tidak ada deskripsi.' }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $alb->tipe === 'video' ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                {{ $alb->tipe === 'video' ? 'Video' : 'Foto' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center font-bold text-slate-600">
                            {{ $alb->items_count }} media
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('tenant.admin.informasi.galeri', ['tenant' => app('tenant')->slug, 'album_id' => $alb->id, 'tab' => 'items']) }}" 
                                   class="px-2.5 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold transition flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span>Kelola</span>
                                </a>
                                <button type="button" 
                                        @click="editAlbumItem(@js($alb))" 
                                        class="p-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-amber-600 transition cursor-pointer" 
                                        title="Edit Album">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>
                                <button type="button" 
                                        @click="konfirmasiHapusAlbum(@js($alb->id), @js($alb->nama_album), @js($alb->items_count))" 
                                        class="p-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-600 transition cursor-pointer" 
                                        title="Hapus Album">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400 italic">
                            Belum ada album yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($albumList->hasPages())
            <div class="pt-2">
                {{ $albumList->links() }}
            </div>
        @endif
    </div>
</div>
