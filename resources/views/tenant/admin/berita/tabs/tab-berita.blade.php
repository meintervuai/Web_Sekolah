<!-- TAB 1: DAFTAR BERITA & ARTIKEL & HERO BANNER -->
<div x-show="activeTab === 'berita'" x-cloak class="space-y-6">
    <!-- Pengaturan Hero Banner Berita Publik -->
    <form id="form-berita-hero" action="{{ route('tenant.admin.informasi.hero.update', ['tenant' => app('tenant')->slug, 'modul' => 'berita']) }}" 
          method="POST" 
          @submit="submitLoading = true"
          class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
        @csrf
        @method('PUT')

        <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Kustomisasi Hero Banner (Halaman Berita Publik)
                </h2>
                <p class="text-xs text-slate-500">Atur judul utama, deskripsi ringkas, dan gambar latar hero pada halaman direktori berita publik <code>/berita</code>.</p>
            </div>
            <a href="{{ url(app('tenant')->slug . '/berita') }}" target="_blank" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 shrink-0">
                <span>Lihat Halaman Publik</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Utama Hero Banner <span class="text-rose-500">*</span></label>
                <input type="text" name="judul_hero" value="{{ old('judul_hero', $halamanBerita->judul) }}" required
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                       placeholder="Contoh: Berita & Artikel Terkini">
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Ringkas / Subjudul Hero</label>
                <textarea name="subjudul_hero" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                          placeholder="Contoh: Dapatkan informasi terbaru mengenai agenda penting, prestasi siswa, dan kegiatan sekolah.">{{ old('subjudul_hero', $halamanBerita->subjudul) }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1">Gambar Latar Hero (Pusat Media / URL)</label>
                <div class="flex gap-2 items-center">
                    <div class="w-16 h-10 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 relative flex items-center justify-center">
                        <template x-if="bannerHeroPreview">
                            <img :src="bannerHeroPreview" alt="Hero Banner Preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!bannerHeroPreview">
                            <span class="text-[9px] text-slate-500 font-mono">16:9</span>
                        </template>
                    </div>
                    <input type="text" name="gambar_banner" id="input_banner_berita" 
                           x-model="bannerHeroPreview"
                           class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                           placeholder="https://... atau pilih dari Pusat Berkas Media">
                    <button type="button" @click="openMediaPicker('input_banner_berita')" 
                            class="px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Pilih dari Media
                    </button>
                </div>
                <p class="text-[10px] text-slate-400 mt-1">Rasio standar 16:9 / 21:9. Tampil sebagai latar banner di bagian atas direktori berita publik.</p>
            </div>
        </div>
    </form>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
        <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    Daftar Berita &amp; Artikel Sekolah
                </h2>
                <p class="text-xs text-slate-500">Kelola artikel kegiatan sekolah, prestasi, dan publikasi resmi.</p>
            </div>
            <button type="button" @click="openFormBerita()" 
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center gap-1.5 cursor-pointer shrink-0 self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tulis Berita Baru</span>
            </button>
        </div>

        <!-- Filter & Search Bar with View Mode Toggle -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 pt-1">
            <form method="GET" action="{{ route('tenant.admin.informasi.berita', ['tenant' => app('tenant')->slug]) }}" class="flex-1 grid grid-cols-1 sm:grid-cols-12 gap-2.5">
                <input type="hidden" name="tab" value="berita">
                <div class="sm:col-span-6 relative">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul berita atau isi..." 
                           class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>
                <div class="sm:col-span-3">
                    <select name="kategori_id" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <select name="status" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        <option value="">-- Semua Status --</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <div class="sm:col-span-1 flex items-center gap-1.5">
                    <button type="submit" class="w-full py-2.5 px-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition flex items-center justify-center cursor-pointer shadow-xs">
                        Cari
                    </button>
                    @if(request()->filled('q') || request()->filled('kategori_id') || request()->filled('status'))
                        <a href="{{ route('tenant.admin.informasi.berita', ['tenant' => app('tenant')->slug, 'tab' => 'berita']) }}" class="px-2.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition" title="Reset Filter">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <!-- Switcher Toggle Grid vs List -->
            <div class="flex items-center p-0.5 bg-slate-100 rounded-xl border border-slate-200 shrink-0 self-end md:self-center">
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

        <!-- TAMPILAN 1: Tabel / List -->
        <div x-show="viewMode === 'list'" class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-3 w-12 text-center">No</th>
                        <th class="px-3 py-3 w-20 text-center">Sampul</th>
                        <th class="px-4 py-3">Judul Berita</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Tgl Publikasi</th>
                        <th class="px-4 py-3 text-center">Dibaca</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($beritaList as $idx => $item)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 px-3 text-center text-slate-400 font-medium">
                                {{ $beritaList->firstItem() + $idx }}
                            </td>
                            <td class="px-3 py-3 text-center">
                                <div class="w-16 h-10 mx-auto rounded-lg border border-slate-200 bg-slate-100 overflow-hidden relative">
                                    @if($item->gambar_sampul)
                                        <img src="{{ $item->gambar_sampul }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 font-medium text-slate-900 max-w-xs">
                                <div class="font-bold text-xs line-clamp-1">{{ $item->judul }}</div>
                                <div class="text-[11px] text-slate-400 font-mono mt-0.5 truncate">{{ $item->slug }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ $item->kategori->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-500 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($item->tgl_publikasi)->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="px-4 py-3 text-center font-bold text-slate-600">
                                {{ number_format($item->jumlah_dilihat) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" 
                                        @click="toggleItemStatus('berita', {{ $item->id }})"
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold transition cursor-pointer {{ $item->status_publikasi === 'published' ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-amber-100 text-amber-800 hover:bg-amber-200' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $item->status_publikasi === 'published' ? 'bg-emerald-600' : 'bg-amber-600' }}"></span>
                                    <span>{{ ucfirst($item->status_publikasi) }}</span>
                                </button>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ url(app('tenant')->slug . '/berita/' . $item->slug) }}" target="_blank" 
                                       class="p-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-blue-600 transition"
                                       title="Lihat Halaman Publik">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                    <button type="button" @click="editBerita({{ Js::from($item) }})" 
                                            class="p-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-blue-600 transition cursor-pointer"
                                            title="Edit Berita">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    <button type="button" @click="confirmDelete('berita', {{ $item->id }}, '{{ addslashes($item->judul) }}')"
                                            class="p-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-600 transition cursor-pointer"
                                            title="Hapus Berita">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">
                                Belum ada artikel berita yang ditambahkan. Silakan klik "Tulis Berita Baru".
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- TAMPILAN 2: Grid Card Cards -->
        <div x-show="viewMode === 'grid'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($beritaList as $item)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden flex flex-col group hover:border-slate-300 hover:shadow-xs transition duration-200">
                    <!-- Card Media Cover -->
                    <div class="relative bg-slate-900 aspect-16/9 overflow-hidden flex items-center justify-center">
                        @if($item->gambar_sampul)
                            <img src="{{ $item->gambar_sampul }}" alt="" aria-hidden="true" class="absolute inset-0 w-full h-full object-cover blur-md scale-125 opacity-40 pointer-events-none z-0">
                            <img src="{{ $item->gambar_sampul }}" alt="{{ $item->judul }}" loading="lazy" class="relative z-10 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-100">
                                <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                        @endif
                        <div class="absolute top-2 left-2 z-20">
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-black/60 backdrop-blur-xs text-white border border-white/20">
                                {{ $item->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                        </div>
                        <div class="absolute top-2 right-2 z-20">
                            <button type="button" 
                                    @click="toggleItemStatus('berita', {{ $item->id }})"
                                    class="px-2 py-0.5 rounded-md text-[10px] font-bold backdrop-blur-xs transition cursor-pointer {{ $item->status_publikasi === 'published' ? 'bg-emerald-600/90 text-white' : 'bg-amber-600/90 text-white' }}">
                                {{ ucfirst($item->status_publikasi) }}
                            </button>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-3.5 flex-1 flex flex-col justify-between space-y-2.5">
                        <div>
                            <h3 class="font-bold text-xs text-slate-900 line-clamp-2 leading-snug group-hover:text-blue-600 transition" title="{{ $item->judul }}">
                                {{ $item->judul }}
                            </h3>
                            @if($item->ringkasan)
                                <p class="text-[11px] text-slate-500 line-clamp-2 mt-1 leading-relaxed">
                                    {{ $item->ringkasan }}
                                </p>
                            @endif
                        </div>

                        <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[10px] text-slate-400">
                            <span>{{ \Carbon\Carbon::parse($item->tgl_publikasi)->translatedFormat('d M Y') }}</span>
                            <span class="flex items-center gap-1 font-semibold text-slate-500">
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                {{ number_format($item->jumlah_dilihat) }}
                            </span>
                        </div>
                    </div>

                    <!-- Card Actions -->
                    <div class="px-3.5 py-2 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between gap-1">
                        <a href="{{ url(app('tenant')->slug . '/berita/' . $item->slug) }}" target="_blank" 
                           class="text-[11px] font-semibold text-slate-600 hover:text-blue-600 flex items-center gap-1 transition"
                           title="Lihat Halaman Publik">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            <span>Lihat</span>
                        </a>
                        <div class="flex items-center gap-1">
                            <button type="button" @click="editBerita({{ Js::from($item) }})" 
                                    class="p-1 rounded-lg hover:bg-blue-50 text-slate-600 hover:text-blue-600 transition cursor-pointer"
                                    title="Edit Berita">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button type="button" @click="confirmDelete('berita', {{ $item->id }}, '{{ addslashes($item->judul) }}')"
                                    class="p-1 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-600 transition cursor-pointer"
                                    title="Hapus Berita">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-8 text-center text-slate-400">
                    Belum ada artikel berita yang ditambahkan. Silakan klik "Tulis Berita Baru".
                </div>
            @endforelse
        </div>

        <div class="pt-3 border-t border-slate-100">
            {{ $beritaList->links() }}
        </div>
    </div>
</div>
