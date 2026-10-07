<!-- TAB 2: FORM TAMBAH / EDIT FASILITAS -->
<div x-show="activeTab === 'form'" x-cloak class="space-y-6">
    <form id="form-fasilitas-main" :action="formFasilitasActionUrl" method="POST" @submit="submitLoading = true">
        @csrf
        <template x-if="editMode">
            <input type="hidden" name="_method" value="PUT">
        </template>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left: Info Utama (7 cols) -->
            <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            <span x-text="editMode ? 'Edit Data Fasilitas' : 'Formulir Sarana & Fasilitas Baru'"></span>
                        </h2>
                        <p class="text-xs text-slate-500">Lengkapi nama ruangan, deskripsi sarana, foto utama, dan dokumentasi foto tambahan.</p>
                    </div>
                    <button type="button" @click="activeTab = 'fasilitas'" class="text-xs font-semibold text-slate-500 hover:text-slate-800">
                        &larr; Batal &amp; Kembali
                    </button>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Nama Fasilitas / Bengkel / Laboratorium <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama_fasilitas" 
                           x-model="formNamaFasilitas" 
                           required 
                           placeholder="Contoh: Bengkel Permesinan CNC & Bubut Industri" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Deskripsi &amp; Spesifikasi Fasilitas <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="deskripsi" 
                              x-model="formDeskripsiFasilitas" 
                              rows="5" 
                              required 
                              placeholder="Jelaskan fasilitas, kapasitas siswa, peralatan modern teaching factory yang tersedia, dan fungsinya..." 
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"></textarea>
                </div>

                <!-- Galeri Foto Tambahan Repeater -->
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-xs font-bold text-slate-800">Foto Dokumentasi Tambahan</h4>
                            <p class="text-[10px] text-slate-400">Tambahkan foto sudut lain ruangan atau aktivitas praktik siswa.</p>
                        </div>
                        <button type="button" @click="tambahBarisFotoTambahan()" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1 cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Foto
                        </button>
                    </div>

                    <!-- List Foto Tambahan Existing saat Edit -->
                    <template x-if="editMode && existingFotoList.length > 0">
                        <div class="space-y-2 pt-2 border-t border-slate-200">
                            <span class="text-[11px] font-bold text-slate-600 block">Foto Tambahan Terpasang:</span>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <template x-for="item in existingFotoList" :key="item.id">
                                    <div class="relative group rounded-xl overflow-hidden border border-slate-200 bg-white">
                                        <img :src="item.file_foto" class="w-full h-20 object-cover">
                                        <div class="p-1 text-[10px] truncate text-slate-600" x-text="item.keterangan || 'Dokumentasi'"></div>
                                        <button type="button" 
                                                @click="hapusFotoFasilitasDb(item.id)" 
                                                class="absolute top-1 right-1 p-1 bg-rose-600 text-white rounded-md text-xs shadow-xs opacity-0 group-hover:opacity-100 transition cursor-pointer">
                                            &times;
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                    <!-- Repeater Baris Baru -->
                    <div class="space-y-2.5">
                        <template x-for="(row, index) in fotoTambahanBaru" :key="index">
                            <div class="p-3 bg-white rounded-xl border border-slate-200 space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[11px] font-bold text-slate-700" x-text="'Foto Tambahan #' + (index + 1)"></span>
                                    <button type="button" @click="hapusBarisFotoTambahan(index)" class="text-rose-500 hover:text-rose-700 text-xs font-bold cursor-pointer">
                                        Hapus Baris
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-12 gap-2">
                                    <div class="sm:col-span-7 flex items-center gap-1.5">
                                        <input type="text" 
                                               name="foto_tambahan[]" 
                                               x-model="row.url" 
                                               placeholder="URL foto atau pilih media..." 
                                               class="flex-1 px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                                        <button type="button" 
                                                @click="bukaMediaPickerRepeater(index)" 
                                                class="px-2.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition cursor-pointer">
                                            Pilih
                                        </button>
                                    </div>
                                    <div class="sm:col-span-5">
                                        <input type="text" 
                                               name="keterangan_tambahan[]" 
                                               x-model="row.keterangan" 
                                               placeholder="Keterangan singkat..." 
                                               class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Right: Foto Utama (5 cols) -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
                    <div class="border-b border-slate-100 pb-3">
                        <h3 class="text-sm font-bold text-slate-900 font-heading">Foto &amp; Visibilitas</h3>
                        <p class="text-xs text-slate-500">Foto utama 4:3 &amp; sakelar status</p>
                    </div>

                    <!-- 1:1 Square Image Box -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Foto Utama Fasilitas (Rasio 1:1 Persegi) <span class="text-rose-500">*</span>
                        </label>

                        <div class="aspect-square max-w-xs mx-auto rounded-xl overflow-hidden bg-slate-50 border border-slate-200 flex items-center justify-center relative mb-2">
                            <template x-if="formFotoUtama">
                                <img :src="formFotoUtama" alt="Foto Utama" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!formFotoUtama">
                                <div class="text-center p-4 text-slate-400">
                                    <svg class="w-10 h-10 mx-auto mb-1 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-xs font-medium">Belum ada foto utama</span>
                                </div>
                            </template>
                        </div>

                        <div class="flex gap-2 items-center">
                            <input type="text" 
                                   name="foto_utama" 
                                   id="input_foto_utama_fasilitas"
                                   x-model="formFotoUtama" 
                                   required 
                                   placeholder="https://... atau pilih media" 
                                   class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                            
                            <button type="button" 
                                    @click="bukaMediaPicker('foto_utama')" 
                                    class="px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Pilih Media
                            </button>
                        </div>
                    </div>

                    <!-- Status Aktif -->
                    <div class="pt-2 border-t border-slate-100">
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox" name="is_aktif" value="1" x-model="formIsAktif" class="w-4 h-4 text-blue-600 rounded-sm border-slate-300 focus:ring-blue-500">
                            <div>
                                <span class="text-xs font-bold text-slate-800 block">Tampilkan di Halaman Sarpras Publik</span>
                                <span class="text-[10px] text-slate-400 block">Nonaktifkan jika masih berstatus draf</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
