<!-- TAB 5: SLIDER CAROUSEL & BANNER HERO BERANDA -->
<div x-show="activeTab === 'slider'" x-cloak class="space-y-6">

    <!-- DAFTAR SLIDE CAROUSEL HERO BERANDA -->
    <div class="admin-card space-y-6">
        <div class="admin-card-header flex flex-col sm:flex-row sm:items-center sm:justify-between pb-4 border-b border-slate-100 gap-3">
            <div>
                <h2 class="admin-card-title text-base font-bold text-slate-800">Daftar Slide Carousel Hero Beranda</h2>
                <p class="admin-card-subtitle text-xs text-slate-500 mt-0.5">Kelola kartu berganti otomatis (carousel) di bagian paling atas halaman utama website publik.</p>
            </div>
            <button type="button" 
                    @click="openModalSlider()" 
                    class="admin-btn-save flex items-center gap-1.5 w-full sm:w-auto justify-center cursor-pointer">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Slide Baru</span>
            </button>
        </div>

        @if($sliderList->isEmpty())
        <div class="text-center py-12 px-4 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/50">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-sm font-bold text-slate-800 mb-1">Belum Ada Slide Khusus</h3>
            <p class="text-xs text-slate-500 max-w-md mx-auto mb-4">Portal publik saat ini menggunakan slide default bawaan tema. Tambahkan slide khusus untuk mempromosikan jurusan, SPMB, TEFA, atau prestasi sekolah.</p>
            <button type="button" @click="openModalSlider()" class="admin-btn-action text-xs font-semibold px-4 py-2 inline-flex items-center gap-1.5 cursor-pointer">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>+ Buat Slide Pertama</span>
            </button>
        </div>
        @else
        <div class="overflow-x-auto taildash-scrollbar">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/80 text-slate-600 font-semibold uppercase tracking-wider text-[11px]">
                        <th class="py-3 px-3 text-center w-12">No</th>
                        <th class="py-3 px-3 w-28">Media</th>
                        <th class="py-3 px-3">Judul &amp; Subjudul Slide</th>
                        <th class="py-3 px-3 w-44">Tombol Aksi (CTA)</th>
                        <th class="py-3 px-3 text-center w-20">Urutan</th>
                        <th class="py-3 px-3 text-center w-24">Status</th>
                        <th class="py-3 px-3 text-right w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @foreach($sliderList as $index => $item)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-3 px-3 text-center font-medium text-slate-400">{{ $index + 1 }}</td>
                        <td class="py-3 px-3">
                            <div class="w-24 h-14 rounded-lg border border-slate-200 bg-slate-900 overflow-hidden relative flex items-center justify-center shadow-2xs">
                                @if(!empty($item->video))
                                    <video src="{{ $item->video }}" class="w-full h-full object-cover" muted></video>
                                    <span class="absolute bottom-1 right-1 bg-slate-900/80 text-white text-[9px] px-1.5 py-0.5 rounded font-mono flex items-center gap-0.5">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Vid
                                    </span>
                                @elseif(!empty($item->gambar))
                                    <img src="{{ $item->gambar }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-tr from-slate-800 to-slate-700 flex items-center justify-center text-slate-400 text-[10px] font-medium">
                                        Gradient
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 px-3">
                            <div class="font-bold text-slate-900 text-xs sm:text-sm line-clamp-1">{{ $item->judul }}</div>
                            <div class="text-[11px] text-slate-500 line-clamp-2 mt-0.5">{{ $item->subjudul ?: 'Tidak ada deskripsi tambahan.' }}</div>
                        </td>
                        <td class="py-3 px-3">
                            @if(!empty($item->link_tombol))
                                <div class="inline-flex items-center gap-1 px-2 py-0.5 bg-blue-50 text-blue-700 rounded-md font-semibold text-[11px] border border-blue-100 max-w-[160px] truncate">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    <span class="truncate">{{ $item->teks_tombol ?: 'Pelajari' }}</span>
                                </div>
                                <div class="text-[10px] text-slate-400 font-mono truncate mt-0.5 max-w-[160px]">{{ $item->link_tombol }}</div>
                            @else
                                <span class="text-slate-400 text-[11px] italic">- Tanpa Tombol -</span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-center font-semibold text-slate-600">
                            <span class="inline-block px-2 py-0.5 bg-slate-100 rounded text-slate-700 font-mono text-[11px]">{{ $item->urutan }}</span>
                        </td>
                        <td class="py-3 px-3 text-center">
                            @if($item->is_aktif)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-500 border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400 mr-1"></span> Draft
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <button type="button" 
                                        @click="editSlider({{ json_encode($item) }})" 
                                        class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition cursor-pointer" 
                                        title="Edit Slide">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button type="button" 
                                        @click="deleteSliderConfirm({{ $item->id }}, '{{ addslashes($item->judul) }}')" 
                                        class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition cursor-pointer" 
                                        title="Hapus Slide">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>
