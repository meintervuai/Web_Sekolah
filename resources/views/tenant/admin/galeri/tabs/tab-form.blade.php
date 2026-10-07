<!-- TAB 3: FORM BUAT / EDIT ALBUM -->
<div x-show="activeTab === 'form'" x-cloak class="space-y-6">
    <form id="form-galeri-album" :action="formAlbumActionUrl" method="POST" @submit="submitLoading = true">
        @csrf
        <template x-if="editMode">
            <input type="hidden" name="_method" value="PUT">
        </template>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4 max-w-3xl">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span x-text="editMode ? 'Edit Rincian Album Galeri' : 'Formulir Buat Album Galeri Baru'"></span>
                    </h2>
                    <p class="text-xs text-slate-500">Tentukan nama album dokumentasi, tipe media (foto atau video), dan gambar sampul utama.</p>
                </div>
                <button type="button" @click="activeTab = 'album'" class="text-xs font-semibold text-slate-500 hover:text-slate-800">
                    &larr; Batal &amp; Kembali
                </button>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Nama Album Galeri <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama_album" 
                           x-model="formNamaAlbum" 
                           required 
                           placeholder="Contoh: Gelar Karya & Pameran Teaching Factory 2026" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Tipe Konten Album <span class="text-rose-500">*</span>
                    </label>
                    <select name="tipe" 
                            x-model="formTipeAlbum" 
                            required 
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        <option value="foto">Foto Dokumentasi Kegiatan</option>
                        <option value="video">Video Liputan &amp; Rekaman</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Deskripsi Singkat Album
                    </label>
                    <textarea name="deskripsi" 
                              x-model="formDeskripsiAlbum" 
                              rows="3" 
                              placeholder="Rincian singkat seputar kegiatan yang didokumentasikan..." 
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Gambar Sampul (Cover Album)
                    </label>
                    <div class="aspect-16/8 rounded-xl overflow-hidden bg-slate-50 border border-slate-200 mb-2 relative flex items-center justify-center">
                        <template x-if="formCoverAlbum">
                            <img :src="formCoverAlbum" alt="Cover Preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!formCoverAlbum">
                            <span class="text-xs text-slate-400">Belum ada cover album</span>
                        </template>
                    </div>
                    <div class="flex gap-2 items-center">
                        <input type="text" 
                               name="cover_album" 
                               id="input_cover_album" 
                               x-model="formCoverAlbum" 
                               placeholder="https://... atau pilih media" 
                               class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        <button type="button" 
                                @click="bukaMediaPicker('cover_album')" 
                                class="px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Pilih Media
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
