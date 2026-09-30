<!-- TAB 2: EDIT / TAMBAH PROGRAM KEAHLIAN (FULL TAB FORM DEDIKASI) -->
<div x-show="activeTab === 'form_jurusan'" x-cloak class="space-y-6">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-5">
        
        <!-- Header Form Tab -->
        <div class="border-b border-slate-100 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold font-heading text-base shrink-0 shadow-xs">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading" x-text="jurusanForm.id ? ('Edit Program Keahlian: ' + jurusanForm.nama_jurusan) : 'Tambah Program Keahlian Baru'"></h2>
                    <p class="text-xs text-slate-500 mt-0.5">Kelola informasi lengkap, silabus kompetensi, kepala program keahlian, dan foto sampul program keahlian.</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <button type="button" @click="setTab('jurusan')" 
                        class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali ke Daftar</span>
                </button>
            </div>
        </div>

        <!-- Form Input -->
        <form :action="jurusanForm.id ? `{{ url(app('tenant')->slug . '/admin/program-keahlian') }}/${jurusanForm.id}` : `{{ route('tenant.admin.jurusan.store', ['tenant' => app('tenant')->slug]) }}`" 
              method="POST" 
              @submit="syncEditor('editor_jurusan', 'deskripsi_lengkap'); formSubmitLoading = true"
              class="space-y-6">
            @csrf
            <template x-if="jurusanForm.id">
                @method('PUT')
            </template>

            <div class="space-y-4">
                
                <!-- Baris 1: Nama Jurusan, Singkatan, Slug -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <!-- Nama Program Keahlian -->
                    <div class="md:col-span-6">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Program Keahlian <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_jurusan" x-model="jurusanForm.nama_jurusan" @input="generateSlug()" required
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                               placeholder="Contoh: Pengembangan Perangkat Lunak dan Gim">
                    </div>

                    <!-- Singkatan / Kode -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Singkatan / Kode</label>
                        <input type="text" name="singkatan" x-model="jurusanForm.singkatan"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition uppercase font-bold text-blue-700"
                               placeholder="Contoh: PPLG">
                    </div>

                    <!-- Slug URL -->
                    <div class="md:col-span-4">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Slug URL <span class="text-rose-500">*</span></label>
                        <input type="text" name="slug" x-model="jurusanForm.slug" required
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 font-mono focus:bg-white focus:border-blue-500 transition"
                               placeholder="pengembangan-perangkat-lunak-dan-gim">
                        <p class="text-[10px] text-slate-400 mt-1">Rute akses publik: <code>/program-keahlian/<span x-text="jurusanForm.slug || 'slug'"></span></code></p>
                    </div>
                </div>

                <!-- Baris 2: Kepala Program Keahlian & Foto Sampul -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Kepala Program Keahlian (Relasi Guru & Staf) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kepala Program Keahlian (Relasi Guru &amp; Staf)</label>
                        <select name="guru_id" x-model="jurusanForm.guru_id"
                                class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                            <option value="">-- Pilih Guru / Tenaga Pendidik --</option>
                            @foreach($guruList as $guru)
                                <option value="{{ $guru->id }}">
                                    {{ $guru->nama_lengkap }} ({{ $guru->jabatan }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-slate-400 mt-1">Terhubung langsung dengan data Master Guru &amp; Tenaga Kependidikan.</p>
                    </div>

                    <!-- Foto / Ikon Unggulan (Pusat Media) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Foto / Gambar Sampul Jurusan (Pusat Media)</label>
                        <div class="flex gap-2 items-center">
                            <div class="w-16 h-10 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 relative flex items-center justify-center">
                                <template x-if="jurusanForm.ikon_atau_foto">
                                    <div class="w-full h-full relative">
                                        <img :src="jurusanForm.ikon_atau_foto" alt="" aria-hidden="true" 
                                             class="absolute inset-0 w-full h-full object-cover blur-xs scale-125 opacity-40 pointer-events-none">
                                        <img :src="jurusanForm.ikon_atau_foto" alt="Preview" 
                                             :style="jurusanForm.foto_crop_style"
                                             class="relative z-10 w-full h-full object-cover">
                                    </div>
                                </template>
                                <template x-if="!jurusanForm.ikon_atau_foto">
                                    <span class="text-[9px] text-slate-500 font-mono">4:3</span>
                                </template>
                            </div>
                            <input type="text" name="ikon_atau_foto" id="input_foto_jurusan_tab" 
                                   x-model="jurusanForm.ikon_atau_foto"
                                   class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                   placeholder="https://... atau pilih dari Pusat Berkas Media">
                            <button type="button" @click="openMediaPicker('input_foto_jurusan_tab')" 
                                    class="px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Pilih Media
                            </button>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">Rasio baku 4:3 (Landscape). Tampil pada kartu katalog jurusan publik dan detail.</p>
                    </div>
                </div>

                <!-- Baris 3: Deskripsi Singkat -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Singkat (Ringkasan Kartu) <span class="text-rose-500">*</span></label>
                    <textarea name="deskripsi_singkat" x-model="jurusanForm.deskripsi_singkat" rows="2" required
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                              placeholder="Ringkasan kompetensi keahlian untuk tampilan kartu katalog beranda & publik."></textarea>
                </div>

                <!-- Baris 4: Uraian Lengkap / Silabus (WYSIWYG Editor) -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-700">Uraian Lengkap, Kompetensi &amp; Prospek Karir (WYSIWYG Editor Luas)</label>
                        <span class="text-[10px] text-slate-400">Gunakan toolbar untuk heading, list kompetensi kejuruan, dan prospek karir</span>
                    </div>
                    <textarea name="deskripsi_lengkap" id="deskripsi_lengkap" class="hidden"></textarea>
                    <div id="editor_jurusan" class="bg-white"></div>
                </div>

                <!-- Baris 5: Urutan Tampil & Status Publikasi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Urutan Tampil (Posisi)</label>
                        <input type="number" name="urutan" x-model="jurusanForm.urutan" min="0"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Status Publikasi</label>
                        <label class="inline-flex items-center gap-2 mt-2 cursor-pointer">
                            <input type="checkbox" name="is_aktif" value="1" x-model="jurusanForm.is_aktif" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4">
                            <span class="text-xs font-semibold text-slate-800">Aktif (Tampilkan di Katalog Publik &amp; Beranda)</span>
                        </label>
                    </div>
                </div>

            </div>

            <!-- Form Action Footer -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                <button type="button" @click="setTab('jurusan')" 
                        class="px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 text-xs font-semibold rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" 
                        :disabled="formSubmitLoading"
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center gap-2 cursor-pointer disabled:opacity-50">
                    <template x-if="formSubmitLoading">
                        <svg class="animate-spin -ml-1 mr-1 h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <span x-text="formSubmitLoading ? 'Menyimpan...' : (jurusanForm.id ? 'Simpan Perubahan' : 'Tambah Program Keahlian')"></span>
                </button>
            </div>
        </form>

    </div>
</div>
