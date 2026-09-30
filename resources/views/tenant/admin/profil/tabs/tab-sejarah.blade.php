<!-- TAB 3: SEJARAH SEKOLAH -->
<div x-show="activeTab === 'sejarah'" x-cloak class="space-y-6">
    <form action="{{ route('tenant.admin.profil.halaman.update', ['tenant' => app('tenant')->slug, 'slug' => 'sejarah']) }}" 
          method="POST" 
          @submit="syncEditor('editor_sejarah', 'isi_sejarah'); submitLoading = true">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-5">
            <div class="border-b border-slate-100 pb-4">
                <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">Kelola Halaman Sejarah Sekolah</h2>
                <p class="text-xs text-slate-500">Edit isi sejarah dengan editor teks WYSIWYG lengkap, banner media, dan pengaturan hero.</p>
            </div>

            <div class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Judul Halaman Sejarah <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul', $halamanSejarah->judul) }}" required
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Ringkas / Subjudul Hero Banner</label>
                        <textarea name="subjudul" rows="2"
                                  class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">{{ old('subjudul', $halamanSejarah->subjudul) }}</textarea>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Foto Banner / Sampul Sejarah (Pusat Media)</label>
                    <div class="flex gap-2">
                        <input type="text" name="gambar_banner" id="input_banner_sejarah" value="{{ old('gambar_banner', $halamanSejarah->gambar_banner) }}"
                               class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                               placeholder="https://... atau pilih dari Pusat Berkas Media">
                        <button type="button" @click="openMediaPicker('input_banner_sejarah')" 
                                class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Pilih dari Media
                        </button>
                    </div>
                </div>

                <!-- WYSIWYG Editor Container -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-700">Isi Teks Sejarah (WYSIWYG) <span class="text-rose-500">*</span></label>
                        <span class="text-[10px] text-slate-400">Gunakan toolbar untuk format teks, list, heading &amp; kutipan</span>
                    </div>
                    
                    <!-- Hidden textarea that gets submitted -->
                    <textarea name="isi_konten" id="isi_sejarah" class="hidden">{!! old('isi_konten', $halamanSejarah->isi_konten) !!}</textarea>
                    
                    <!-- Quill Editor Element -->
                    <div id="editor_sejarah">{!! old('isi_konten', $halamanSejarah->isi_konten) !!}</div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                <button type="submit" 
                        :disabled="submitLoading"
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition flex items-center gap-2 cursor-pointer disabled:opacity-50">
                    <template x-if="submitLoading">
                        <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Perubahan Sejarah'"></span>
                </button>
            </div>
        </div>
    </form>
</div>
