<!-- =========================================================================
     MODAL REUSABLE: PUSAT BERKAS MEDIA (MEDIA PICKER)
     Fitur terisolasi & independen: Filter Kategori Lengkap (Semua, Gambar, Video MP4, YouTube, Dokumen),
     Pencarian Live, Sorting Urutan/Terbaru, Impor URL/YouTube instan, dan Unggah WebP Otomatis.
========================================================================= -->
<div x-show="mediaPickerOpen" x-cloak 
     class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-2 sm:p-4"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full h-[92vh] sm:h-[86vh] flex flex-col overflow-hidden border border-slate-200"
         @click.outside="mediaPickerOpen = false">
        
        <!-- 1. Modal Header -->
        <div class="p-3 sm:p-4 border-b border-slate-200 flex items-center justify-between bg-slate-50 shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-xs sm:text-sm text-slate-900 font-heading">Pusat Berkas Media (Pustaka Media Sekolah)</h3>
                    <p class="text-[10px] sm:text-[11px] text-slate-500">Pilih berkas dari pustaka, impor YouTube/URL gambar, atau unggah langsung.</p>
                </div>
            </div>
            <button type="button" @click="mediaPickerOpen = false" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-lg hover:bg-slate-200/60 transition cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- 2. Filter Bar (Filter Tipe Media Sesuai Manajemen Media) -->
        <div class="px-3.5 py-2.5 border-b border-slate-200 bg-white flex flex-col md:flex-row items-stretch md:items-center justify-between gap-2.5 shrink-0">
            
            <!-- Filter Kategori Tabs (Semua, Gambar, Video Lokal, YouTube, Dokumen) -->
            <div class="flex items-center gap-1 overflow-x-auto pb-1 md:pb-0 text-xs taildash-scrollbar">
                <button type="button" @click="pickerFilterType = 'semua'; fetchMedia(1)"
                        :class="pickerFilterType === 'semua' ? 'bg-slate-900 text-white font-bold shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900'"
                        class="px-3 py-1.5 rounded-xl transition cursor-pointer text-center text-xs shrink-0 flex items-center gap-1">
                    <span>Semua</span>
                </button>
                <button type="button" @click="pickerFilterType = 'gambar'; fetchMedia(1)"
                        :class="pickerFilterType === 'gambar' ? 'bg-slate-900 text-white font-bold shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900'"
                        class="px-3 py-1.5 rounded-xl transition cursor-pointer text-center text-xs shrink-0 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Gambar</span>
                </button>
                <button type="button" @click="pickerFilterType = 'video'; fetchMedia(1)"
                        :class="pickerFilterType === 'video' ? 'bg-slate-900 text-white font-bold shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900'"
                        class="px-3 py-1.5 rounded-xl transition cursor-pointer text-center text-xs shrink-0 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    <span>Video Lokal</span>
                </button>
                <button type="button" @click="pickerFilterType = 'youtube'; fetchMedia(1)"
                        :class="pickerFilterType === 'youtube' ? 'bg-slate-900 text-white font-bold shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900'"
                        class="px-3 py-1.5 rounded-xl transition cursor-pointer text-center text-xs shrink-0 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    <span>YouTube</span>
                </button>
            </div>

            <!-- Action Buttons: Impor URL / YouTube & Unggah Baru -->
            <div class="flex items-center gap-2 shrink-0">
                <!-- Tombol Toggle Form Impor URL -->
                <button type="button" @click="pickerShowImportForm = !pickerShowImportForm"
                        :class="pickerShowImportForm ? 'bg-blue-50 text-blue-700 border-blue-300' : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100'"
                        class="h-8.5 px-3 rounded-xl border text-xs font-semibold transition inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    <span>Impor URL / YT</span>
                </button>

                <!-- Direct Upload Button inside Modal -->
                <label class="h-8.5 px-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition inline-flex items-center justify-center gap-1.5 cursor-pointer shrink-0 shadow-xs active:scale-95">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <span class="whitespace-nowrap">Unggah Baru</span>
                    <input type="file" @change="uploadNewMedia($event)" class="hidden" accept="image/*,video/*">
                </label>
            </div>
        </div>

        <!-- 3. Form Cepat Impor URL / YouTube (Bila diaktifkan) -->
        <div x-show="pickerShowImportForm" x-cloak 
             x-transition
             class="px-3.5 py-3 border-b border-blue-100 bg-blue-50/50 space-y-2 shrink-0">
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                <div class="relative flex-1">
                    <input type="url" x-model="pickerImportUrl" 
                           placeholder="Tempel URL YouTube (https://youtu.be/...) atau URL Gambar (https://...)" 
                           class="w-full text-xs px-3 py-2 bg-white border border-blue-200 rounded-xl text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-blue-600">
                </div>
                <input type="text" x-model="pickerImportJudul" 
                       placeholder="Judul / Nama Media (opsional)" 
                       class="sm:w-48 text-xs px-3 py-2 bg-white border border-blue-200 rounded-xl text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-blue-600">
                <button type="button" @click="submitImportUrl()" 
                        :disabled="!pickerImportUrl || pickerLoading"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition disabled:opacity-50 cursor-pointer shadow-xs flex items-center justify-center gap-1.5 shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan &amp; Pilih</span>
                </button>
            </div>
            <p class="text-[10px] text-blue-700/80">Tautan video YouTube otomatis membaca thumbnail resolusi tinggi dan terintegrasi dengan pemutar video publik.</p>
        </div>

        <!-- 4. Baris Search & Sorting Toolbar -->
        <div class="px-3.5 py-2.5 border-b border-slate-100 bg-slate-50/70 flex items-center justify-between gap-2.5 shrink-0">
            <!-- Search Field -->
            <div class="relative flex-1 sm:max-w-xs">
                <span class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" x-model="pickerSearchQuery" @keyup.debounce.300ms="fetchMedia(1)"
                       placeholder="Cari judul berkas..."
                       class="w-full pl-8 pr-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-blue-600 transition">
            </div>

            <!-- Sorting & Info -->
            <div class="flex items-center gap-2 text-xs">
                <span class="text-[11px] text-slate-500 hidden sm:inline" x-text="`Total: ${pickerTotal} berkas`"></span>
            </div>
        </div>

        <!-- 5. Media Grid Content -->
        <div class="flex-1 overflow-y-auto p-3 sm:p-4 taildash-scrollbar bg-slate-50/40">
            <template x-if="pickerLoading">
                <div class="h-64 flex flex-col items-center justify-center text-slate-400 gap-2">
                    <svg class="animate-spin w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-xs">Memuat pustaka media dari database...</span>
                </div>
            </template>

            <template x-if="!pickerLoading && mediaItems.length === 0">
                <div class="h-64 flex flex-col items-center justify-center text-slate-400 text-center p-6">
                    <svg class="w-12 h-12 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-xs font-semibold text-slate-600">Belum ada media yang cocok</p>
                    <p class="text-[10px] text-slate-400 mt-1">Unggah berkas baru atau ubah kata kunci pencarian / filter tipe media.</p>
                </div>
            </template>

            <template x-if="!pickerLoading && mediaItems.length > 0">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2.5 sm:gap-3">
                    <template x-for="item in mediaItems" :key="item.id">
                        <div class="group relative rounded-xl border border-slate-200 bg-white overflow-hidden shadow-2xs hover:border-blue-500 hover:shadow-md transition cursor-pointer flex flex-col justify-between"
                             @click="selectMediaItem(item)">
                            <div class="aspect-square bg-slate-900 overflow-hidden relative flex items-center justify-center">
                                
                                <!-- 1. Gambar -->
                                <template x-if="item.tipe_media === 'gambar'">
                                    <img :src="item.url" :alt="item.judul" :style="item.smart_crop_style || ''" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                </template>

                                <!-- 2. Video YouTube (Thumbnail Otomatis) -->
                                <template x-if="item.tipe_media === 'youtube'">
                                    <div class="w-full h-full relative overflow-hidden bg-slate-900">
                                        <template x-if="getYoutubeThumbnail(item.url)">
                                            <img :src="getYoutubeThumbnail(item.url)" :alt="item.judul" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                        </template>
                                        <template x-if="!getYoutubeThumbnail(item.url)">
                                            <div class="w-full h-full flex items-center justify-center bg-red-950 text-white p-2">
                                                <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                            </div>
                                        </template>
                                        <!-- YouTube Badge Overlay -->
                                        <div class="absolute bottom-1 right-1 bg-red-600/90 text-white text-[8px] font-bold px-1.5 py-0.5 rounded flex items-center gap-0.5 shadow-sm">
                                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                            <span>YouTube</span>
                                        </div>
                                    </div>
                                </template>

                                <!-- 3. Video Lokal / MP4 -->
                                <template x-if="item.tipe_media === 'video'">
                                    <div class="w-full h-full relative overflow-hidden bg-slate-950 flex items-center justify-center">
                                        <video :src="item.url" preload="metadata" muted playsinline class="w-full h-full object-cover pointer-events-none opacity-80 group-hover:scale-105 transition-transform duration-200"></video>
                                        <div class="absolute inset-0 flex items-center justify-center bg-black/25">
                                            <div class="w-7 h-7 rounded-full bg-blue-600/90 text-white flex items-center justify-center shadow-md">
                                                <svg class="w-3.5 h-3.5 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                            </div>
                                        </div>
                                        <div class="absolute bottom-1 right-1 bg-slate-900/80 backdrop-blur-xs text-white text-[8px] font-mono font-bold px-1.5 py-0.5 rounded shadow-sm">
                                            MP4
                                        </div>
                                    </div>
                                </template>

                                <!-- 4. Dokumen (PDF, dll) -->
                                <template x-if="item.tipe_media === 'dokumen'">
                                    <div class="w-full h-full bg-slate-100 flex flex-col items-center justify-center p-2 text-slate-500">
                                        <svg class="w-8 h-8 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span class="text-[9px] font-bold uppercase mt-1">DOKUMEN</span>
                                    </div>
                                </template>

                                <!-- Hover Select Button Overlay -->
                                <div class="absolute inset-0 bg-blue-600/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="px-2.5 py-1 bg-blue-600 text-white text-[10px] font-bold rounded-lg shadow-sm">Pilih</span>
                                </div>
                            </div>
                            <div class="p-2 bg-white">
                                <p class="text-[11px] font-semibold text-slate-800 truncate" :title="item.judul" x-text="item.judul"></p>
                                <div class="flex items-center justify-between text-[9px] text-slate-400 mt-0.5">
                                    <span class="capitalize" x-text="item.tipe_media"></span>
                                    <span class="text-blue-600 font-medium group-hover:underline">Pilih &rarr;</span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        <!-- 6. Modal Footer & Pagination -->
        <div class="p-2.5 sm:p-3 border-t border-slate-200 bg-slate-50 flex flex-col sm:flex-row items-center justify-between gap-2.5 text-xs text-slate-600 shrink-0">
            <div class="flex items-center justify-between sm:justify-start w-full sm:w-auto gap-3 text-[11px] sm:text-xs">
                <span class="font-medium text-slate-600" x-text="`Total ${pickerTotal} berkas (12/hal)`"></span>
                <span class="text-slate-400 hidden sm:inline">&bull;</span>
                <span class="text-slate-500" x-text="`Hal ${pickerCurrentPage} dari ${pickerLastPage}`"></span>
            </div>

            <!-- Pagination Buttons -->
            <div class="flex items-center gap-1.5 w-full sm:w-auto justify-between sm:justify-end">
                <div class="flex items-center gap-1">
                    <button type="button" 
                            @click="fetchMedia(pickerCurrentPage - 1)" 
                            :disabled="pickerCurrentPage <= 1 || pickerLoading"
                            class="px-2.5 py-1 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 text-xs font-semibold rounded-lg transition cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        <span>Sebelumnya</span>
                    </button>
                    
                    <span class="px-2 py-1 bg-blue-50 text-blue-700 font-bold border border-blue-200 rounded-lg text-xs" x-text="pickerCurrentPage"></span>

                    <button type="button" 
                            @click="fetchMedia(pickerCurrentPage + 1)" 
                            :disabled="pickerCurrentPage >= pickerLastPage || pickerLoading"
                            class="px-2.5 py-1 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 text-xs font-semibold rounded-lg transition cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed flex items-center gap-1">
                        <span>Selanjutnya</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>

                <button type="button" @click="mediaPickerOpen = false" 
                        class="px-3.5 py-1 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-lg text-xs transition cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
