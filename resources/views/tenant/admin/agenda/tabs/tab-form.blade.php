<!-- TAB 2: FORM TAMBAH / EDIT AGENDA -->
<div x-show="activeTab === 'form'" x-cloak class="space-y-6">
    <form id="form-agenda-main" :action="formActionUrl" method="POST" @submit="submitAgendaForm($event)">
        @csrf
        <template x-if="editMode">
            <input type="hidden" name="_method" value="PUT">
        </template>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left Column: Primary Fields (8 cols) -->
            <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            <span x-text="editMode ? 'Edit Informasi Agenda Kegiatan' : 'Formulir Agenda & Kegiatan Baru'"></span>
                        </h2>
                        <p class="text-xs text-slate-500">Lengkapi formulir di bawah ini untuk menampilkan agenda resmi di kalender publik.</p>
                    </div>
                    <button type="button" @click="activeTab = 'agenda'" class="text-xs font-semibold text-slate-500 hover:text-slate-800">
                        &larr; Batal &amp; Kembali
                    </button>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Judul Agenda Kegiatan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="judul" 
                           x-model="formJudul" 
                           required 
                           placeholder="Contoh: Workshop Asesmen Teaching Factory Bersama Mitra Industri" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Tanggal Mulai Pelaksanaan <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" 
                               name="tgl_mulai" 
                               x-model="formTglMulai" 
                               required 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Tanggal Selesai (Opsional)
                        </label>
                        <input type="date" 
                               name="tgl_selesai" 
                               x-model="formTglSelesai" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Jam Mulai (Pukul)
                        </label>
                        <input type="text" 
                               name="jam_mulai" 
                               x-model="formJamMulai" 
                               placeholder="Contoh: 08:00" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Jam Selesai (Pukul)
                        </label>
                        <input type="text" 
                               name="jam_selesai" 
                               x-model="formJamSelesai" 
                               placeholder="Contoh: 15:30" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Tempat / Lokasi Kegiatan
                        </label>
                        <input type="text" 
                               name="lokasi" 
                               x-model="formLokasi" 
                               placeholder="Contoh: Aula Graha Utama SMKN 2 Bandung" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Penyelenggara / Panitia
                        </label>
                        <input type="text" 
                               name="penyelenggara" 
                               x-model="formPenyelenggara" 
                               placeholder="Contoh: Pokja Humas & Hubin" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Ringkasan Singkat (Lead Highlight)
                    </label>
                    <textarea name="ringkasan" 
                              x-model="formRingkasan" 
                              rows="2" 
                              placeholder="Ringkasan 1-2 kalimat pengantar agenda yang tampil di kartu kalender..." 
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"></textarea>
                </div>

                <!-- WYSIWYG Editor Deskripsi Lengkap -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Rincian &amp; Deskripsi Lengkap Agenda
                    </label>
                    <div id="editor-agenda" class="bg-white"></div>
                    <input type="hidden" name="deskripsi_lengkap" id="input-deskripsi-lengkap" x-model="formDeskripsiLengkap">
                </div>
            </div>

            <!-- Right Column: Media, Link & Publish (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
                    <div class="border-b border-slate-100 pb-3">
                        <h3 class="text-sm font-bold text-slate-900 font-heading">Media &amp; Publikasi</h3>
                        <p class="text-xs text-slate-500">Sampul poster &amp; tautan pendaftaran</p>
                    </div>

                    <!-- Poster / Sampul Agenda -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Poster / Sampul Agenda
                        </label>
                        <div class="aspect-16/10 rounded-xl overflow-hidden bg-slate-50 border border-slate-200 flex items-center justify-center relative mb-2">
                            <template x-if="formGambarSampul">
                                <img :src="formGambarSampul" alt="Sampul" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!formGambarSampul">
                                <div class="text-center p-4 text-slate-400">
                                    <svg class="w-8 h-8 mx-auto mb-1 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-[10px]">Belum ada gambar sampul</span>
                                </div>
                            </template>
                        </div>

                        <div class="flex gap-2 items-center">
                            <input type="text" 
                                   name="gambar_sampul" 
                                   id="input_sampul_agenda"
                                   x-model="formGambarSampul" 
                                   placeholder="https://... atau pilih media" 
                                   class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                            
                            <button type="button" 
                                    @click="bukaMediaPicker('sampul_agenda')" 
                                    class="px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Pilih Media
                            </button>
                        </div>
                    </div>

                    <!-- Tautan Pendaftaran -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Tautan Pendaftaran / Konfirmasi Daring
                        </label>
                        <input type="url" 
                               name="link_pendaftaran" 
                               x-model="formLinkPendaftaran" 
                               placeholder="https://forms.gle/... atau tautan konfirmasi" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        <span class="text-[10px] text-slate-400 mt-1 block">Tombol pendaftaran daring otomatis tampil di halaman detail jika diisi.</span>
                    </div>

                    <!-- Status Aktif / Visibilitas -->
                    <div class="pt-2 border-t border-slate-100">
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox" name="is_aktif" value="1" x-model="formIsAktif" class="w-4 h-4 text-blue-600 rounded-sm border-slate-300 focus:ring-blue-500">
                            <div>
                                <span class="text-xs font-bold text-slate-800 block">Tampilkan di Kalender Publik</span>
                                <span class="text-[10px] text-slate-400 block">Nonaktifkan jika masih berstatus draf internal</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
