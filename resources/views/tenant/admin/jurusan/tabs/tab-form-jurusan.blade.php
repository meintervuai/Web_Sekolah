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
              @submit="syncEditors(); formSubmitLoading = true"
              class="space-y-6">
            @csrf
            <template x-if="jurusanForm.id">
                @method('PUT')
            </template>

            <div class="space-y-5">
                
                <!-- Baris 1: Nama Jurusan (70%), Singkatan/Kode (30%), & Logo Jurusan -->
                <!-- Slug URL disimpan otomatis sebagai hidden input -->
                <input type="hidden" name="slug" x-model="jurusanForm.slug">

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <!-- Nama Program Keahlian -->
                    <div class="md:col-span-8">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Program Keahlian <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_jurusan" x-model="jurusanForm.nama_jurusan" @input="generateSlug()" required
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                               placeholder="Contoh: Pengembangan Perangkat Lunak dan Gim">
                    </div>

                    <!-- Singkatan / Kode -->
                    <div class="md:col-span-4">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Singkatan / Kode</label>
                        <input type="text" name="singkatan" x-model="jurusanForm.singkatan"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition uppercase font-bold text-blue-700"
                               placeholder="Contoh: PPLG">
                    </div>
                </div>

                <!-- Baris 2: Deskripsi Singkat (Ringkasan Kartu) - Tepat di bawah Nama Jurusan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Singkat (Ringkasan Kartu) <span class="text-rose-500">*</span></label>
                    <textarea name="deskripsi_singkat" x-model="jurusanForm.deskripsi_singkat" rows="2" required
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                              placeholder="Ringkasan kompetensi keahlian untuk tampilan kartu katalog beranda & publik."></textarea>
                </div>

                <!-- Baris 3: Logo Jurusan & Kepala Program Keahlian -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <!-- Logo / Lambang Jurusan (Opsional - Media Library) -->
                    <div class="md:col-span-6">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Logo / Lambang Jurusan (Opsional)</label>
                        <div class="flex gap-2 items-center">
                            <div class="w-10 h-10 rounded-xl border border-slate-200 bg-slate-50 overflow-hidden shrink-0 flex items-center justify-center relative">
                                <template x-if="jurusanForm.logo">
                                    <img :src="jurusanForm.logo" alt="Logo" class="w-full h-full object-contain p-1">
                                </template>
                                <template x-if="!jurusanForm.logo">
                                    <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </template>
                            </div>
                            <input type="text" name="logo" id="input_logo_jurusan" x-model="jurusanForm.logo"
                                   class="flex-1 px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                   placeholder="URL logo atau pilih media...">
                            <button type="button" @click="openMediaPicker('input_logo_jurusan')"
                                    class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 text-xs font-semibold rounded-xl shrink-0 transition flex items-center gap-1 cursor-pointer">
                                <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Media</span>
                            </button>
                            <template x-if="jurusanForm.logo">
                                <button type="button" @click="jurusanForm.logo = ''" class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition" title="Hapus Logo">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Kepala Program Keahlian (Relasi Guru & Staf) -->
                    <div class="md:col-span-6">
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
                        <p class="text-[10px] text-slate-400 mt-1">Tampil otomatis pada sidebar profil &amp; informasi program publik.</p>
                    </div>
                </div>

                <!-- Baris 4: Foto Sampul Utama (Pusat Media) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Foto Sampul Utama Jurusan (Pusat Media)</label>
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
                                <span class="text-[9px] text-slate-500 font-mono">Tanpa Foto</span>
                            </template>
                        </div>
                        <input type="text" name="ikon_atau_foto" id="input_foto_jurusan" 
                               x-model="jurusanForm.ikon_atau_foto"
                               class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                               placeholder="https://... atau pilih dari Pusat Media">
                        <button type="button" @click="openMediaPicker('input_foto_jurusan')" 
                                class="px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Pilih Media
                        </button>
                        <template x-if="jurusanForm.ikon_atau_foto">
                            <button type="button" @click="jurusanForm.ikon_atau_foto = ''; jurusanForm.foto_crop_style = ''" 
                                    class="p-2.5 text-rose-500 hover:bg-rose-50 rounded-xl transition border border-rose-200" title="Hapus Foto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </template>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Opsional: Jika dikosongkan, halaman publik akan menggunakan lambang/singkatan tanpa gambar dummy palsu.</p>
                </div>

                <!-- Baris 5: Informasi Program (WYSIWYG Editor Bebas) -->
                <div class="p-4 bg-slate-50/80 rounded-2xl border border-slate-200 space-y-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="block text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Informasi Program &amp; Ringkasan Kejuruan (WYSIWYG Editor Sidebar)
                            </label>
                            <p class="text-[10px] text-slate-500">Isi bebas informasi jenjang studi, sertifikasi BNSP/LSP, prospek kerja, akreditasi, atau fakta kejuruan yang tampil pada kartu sidebar detail publik.</p>
                        </div>
                    </div>
                    <textarea name="informasi_tambahan" id="informasi_tambahan" class="hidden"></textarea>
                    <div id="editor_informasi_program" class="bg-white"></div>
                </div>

                <!-- Baris 6: Galeri Multi-Foto Dokumentasi Bengkel / Praktik -->
                <div class="p-4 bg-blue-50/40 rounded-2xl border border-blue-100 space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Galeri Multi-Foto &amp; Dokumentasi Fasilitas/Praktik Jurusan
                            </h4>
                            <p class="text-[11px] text-slate-500">Tambahkan beberapa foto kegiatan, bengkel, lab komputer, atau hasil karya siswa.</p>
                        </div>
                        <button type="button" @click="tambahGaleriFoto()"
                                class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-2xs transition flex items-center gap-1 cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Tambah Foto</span>
                        </button>
                    </div>

                    <!-- List Galeri Multi-Foto -->
                    <div class="space-y-2">
                        <template x-for="(foto, index) in jurusanForm.galeri_fotos" :key="index">
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 p-2.5 bg-white rounded-xl border border-slate-200">
                                <div class="w-14 h-10 rounded-lg bg-slate-900 border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center relative">
                                    <template x-if="foto.url">
                                        <img :src="foto.url" alt="Preview" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!foto.url">
                                        <span class="text-[9px] text-slate-400 font-mono">Foto</span>
                                    </template>
                                </div>
                                <input type="text" :name="'galeri_foto[' + index + ']'" :id="'input_galeri_foto_' + index" x-model="foto.url"
                                       class="flex-1 px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                       placeholder="URL Berkas Foto...">
                                <input type="text" :name="'galeri_judul[' + index + ']'" x-model="foto.judul"
                                       class="w-full sm:w-48 px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                       placeholder="Judul / Keterangan foto (Opsional)">
                                <div class="flex items-center gap-1 shrink-0">
                                    <button type="button" @click="openMediaPicker('input_galeri_foto_' + index)"
                                            class="px-2.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg border border-slate-200 transition cursor-pointer"
                                            title="Pilih dari Media Library">
                                        <svg class="w-3.5 h-3.5 text-blue-600 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        Pilih
                                    </button>
                                    <button type="button" @click="hapusGaleriFoto(index)"
                                            class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition cursor-pointer"
                                            title="Hapus foto ini">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                        <template x-if="jurusanForm.galeri_fotos.length === 0">
                            <p class="text-xs text-slate-400 italic py-2 text-center bg-white/70 rounded-xl border border-dashed border-slate-300">
                                Belum ada foto dokumentasi tambahan. Klik "Tambah Foto" di atas untuk menambahkan foto lab/kegiatan.
                            </p>
                        </template>
                    </div>
                </div>



                <!-- Baris 7: Uraian Lengkap / Silabus (WYSIWYG Editor) -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-700">Uraian Lengkap, Silabus &amp; Profil Kejuruan (WYSIWYG Editor Luas)</label>
                        <span class="text-[10px] text-slate-400">Gunakan toolbar untuk heading, silabus materi, dan prospek karir</span>
                    </div>
                    <textarea name="deskripsi_lengkap" id="deskripsi_lengkap" class="hidden"></textarea>
                    <div id="editor_jurusan" class="bg-white"></div>
                </div>

                <!-- Baris 8: Urutan Tampil & Status Publikasi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-3 border-t border-slate-100 items-center">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Urutan Tampil (Posisi Katalog)</label>
                        <select name="urutan" x-model="jurusanForm.urutan"
                                class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 font-semibold focus:bg-white focus:border-blue-500 transition">
                            <template x-for="pos in maxUrutanOptions" :key="pos">
                                <option :value="pos" :selected="jurusanForm.urutan == pos" x-text="'Urutan ' + pos + (pos === 1 ? ' (Paling Awal / Utama)' : '')"></option>
                            </template>
                        </select>
                        <p class="text-[10px] text-slate-400 mt-1">Menentukan urutan kemunculan kartu jurusan pada beranda dan halaman katalog.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Status Publikasi</label>
                        <input type="hidden" name="is_aktif" value="0">
                        <label class="inline-flex items-center gap-2.5 p-2 bg-slate-50 border border-slate-200 rounded-xl w-full cursor-pointer hover:bg-slate-100 transition">
                            <input type="checkbox" name="is_aktif" value="1" 
                                   :checked="jurusanForm.is_aktif"
                                   @change="jurusanForm.is_aktif = $event.target.checked"
                                   class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4 cursor-pointer">
                            <div>
                                <span class="text-xs font-bold text-slate-800" x-text="jurusanForm.is_aktif ? 'Aktif (Ditampilkan Publik)' : 'Draft (Disembunyikan dari Publik)'"></span>
                                <p class="text-[10px] text-slate-400">Jika dinonaktifkan, program keahlian ini tidak akan muncul di beranda dan katalog.</p>
                            </div>
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
