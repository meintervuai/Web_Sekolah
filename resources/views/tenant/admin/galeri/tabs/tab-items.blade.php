<!-- TAB 2: ISI MEDIA DALAM ALBUM YANG DIPILIH -->
@if($selectedAlbum)
<div x-show="activeTab === 'items'" x-cloak class="space-y-6">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
        <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase {{ $selectedAlbum->tipe === 'video' ? 'bg-rose-100 text-rose-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ $selectedAlbum->tipe === 'video' ? 'Album Video' : 'Album Foto' }}
                    </span>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">{{ $selectedAlbum->nama_album }}</h2>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">{{ $selectedAlbum->deskripsi ?? 'Kelola berkas foto atau tautan video kegiatan yang masuk ke dalam album ini.' }}</p>
            </div>

            <div class="flex items-center gap-2 self-start sm:self-auto">
                <button type="button" @click="activeTab = 'album'" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition cursor-pointer">
                    &larr; Pilih Album Lain
                </button>
            </div>
        </div>

        <!-- Add Media Form -->
        <form action="{{ route('tenant.admin.informasi.galeri.item.store', ['tenant' => app('tenant')->slug, 'album' => $selectedAlbum->id]) }}" method="POST" class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-3">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                <div class="sm:col-span-5">
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        URL Berkas Foto / Link YouTube <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="text" 
                               name="file_media_atau_link" 
                               id="input_file_item_galeri" 
                               x-model="formItemUrl" 
                               required 
                               placeholder="https://... atau pilih media" 
                               class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-hidden focus:border-blue-500 transition">
                        <button type="button" 
                                @click="bukaMediaPicker('item_galeri')" 
                                class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1 cursor-pointer" title="Pilih dari Media Library">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Media
                        </button>
                    </div>
                </div>

                <div class="sm:col-span-5">
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Judul / Keterangan Media
                    </label>
                    <input type="text" 
                           name="judul_item" 
                           placeholder="Contoh: Suasana Praktik Siswa Mesin CNC" 
                           class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-hidden focus:border-blue-500 transition">
                </div>

                <div class="sm:col-span-2 flex items-end">
                    <button type="submit" class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center cursor-pointer">
                        Tambahkan
                    </button>
                </div>
            </div>
        </form>

        <!-- Items Grid in Selected Album (Identik dengan Manajemen Media) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 pt-2">
            @forelse($selectedAlbum->items as $item)
            @php
                $itemSrc = $item->file_media_atau_link ?? $item->file_path ?? '';
                $isVideoItem = Str::contains($itemSrc, ['youtube.com', 'youtu.be', '.mp4', '.webm', '.mov']) || $selectedAlbum->tipe === 'video';
            @endphp
            <div class="group bg-white rounded-xl border border-slate-200/80 overflow-hidden shadow-2xs hover:shadow-md transition-all flex flex-col justify-between relative">
                <div class="relative bg-slate-900 aspect-square overflow-hidden flex items-center justify-center">
                    @if($isVideoItem)
                        <div class="w-full h-full bg-slate-900 flex flex-col items-center justify-center text-white p-2 text-center">
                            <svg class="w-8 h-8 text-rose-500 mb-1" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                            <span class="text-[9px] font-bold truncate max-w-full text-slate-300">{{ Str::limit($item->judul_item ?? $itemSrc, 16) }}</span>
                        </div>
                    @else
                        <!-- Ambient Blurred Backdrop -->
                        <img src="{{ $itemSrc }}" alt="" aria-hidden="true" class="absolute inset-0 w-full h-full object-cover blur-md scale-125 opacity-40 pointer-events-none z-0">
                        <!-- Main Item Image -->
                        <img src="{{ $itemSrc }}" alt="{{ $item->judul_item }}" loading="lazy" class="relative z-10 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @endif

                    <span class="absolute bottom-2 left-2 z-20 px-1.5 py-0.5 bg-black/70 backdrop-blur-xs text-white text-[9px] font-bold rounded uppercase">
                        {{ $isVideoItem ? 'video' : 'foto' }}
                    </span>

                    <!-- Hover Overlay Action Bar -->
                    <div class="absolute inset-0 z-40 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-1.5 p-2">
                        <a href="{{ $itemSrc }}" target="_blank" class="p-2 bg-white text-blue-600 rounded-xl hover:bg-blue-50 shadow-xs text-xs font-semibold transition" title="Lihat Asli">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                        <form action="{{ route('tenant.admin.informasi.galeri.item.destroy', ['tenant' => app('tenant')->slug, 'item' => $item->id]) }}" method="POST" onsubmit="return confirm('Hapus media ini dari album?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-white text-rose-600 rounded-xl hover:bg-rose-50 shadow-xs text-xs font-semibold cursor-pointer transition" title="Hapus Media">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="p-2.5">
                    <div class="font-bold text-slate-900 text-xs truncate" title="{{ $item->judul_item ?? 'Foto Dokumentasi' }}">{{ $item->judul_item ?: 'Foto Dokumentasi' }}</div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-8 text-center text-slate-400 bg-slate-50 rounded-2xl border border-slate-200">
                <p class="text-xs font-medium">Belum ada foto atau video di album ini. Gunakan formulir di atas untuk mengunggah berkas.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endif
