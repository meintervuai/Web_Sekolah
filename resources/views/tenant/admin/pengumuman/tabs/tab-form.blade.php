<!-- TAB 2: FORM PENGUMUMAN -->
<div x-show="activeTab === 'form_pengumuman'" x-cloak class="space-y-6">
    <form id="form-pengumuman-main"
          :action="pengumumanForm.id ? '{{ url(app('tenant')->slug . '/admin/informasi/pengumuman') }}/' + pengumumanForm.id : '{{ route('tenant.admin.informasi.pengumuman.store', ['tenant' => app('tenant')->slug]) }}'" 
          method="POST" 
          @submit="preparePengumumanSubmit($event)"
          class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
        @csrf
        <template x-if="pengumumanForm.id">
            <input type="hidden" name="_method" value="PUT">
        </template>

        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
            <div>
                <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading" x-text="pengumumanForm.id ? 'Edit Surat Edaran / Pengumuman' : 'Buat Pengumuman Resmi Baru'"></h2>
                <p class="text-xs text-slate-500">Gunakan format surat dinas resmi dengan editor teks dan lampiran gambar/dokumen.</p>
            </div>
            <button type="button" @click="resetFormPengumuman()" class="text-xs text-slate-500 hover:text-slate-800 font-bold cursor-pointer">
                Batal / Bersihkan Form
            </button>
        </div>

        <div class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Pengumuman <span class="text-rose-500">*</span></label>
                <input type="text" name="judul" x-model="pengumumanForm.judul" required placeholder="Contoh: Pengumuman Kelulusan & Jadwal Pengambilan Ijazah Tahun Ajaran 2025/2026"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Gambar / Dokumen Surat Resmi (Pusat Media / URL)</label>
                <div class="flex gap-2 items-center">
                    <div class="w-16 h-10 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 relative flex items-center justify-center">
                        <template x-if="pengumumanForm.gambar_sampul">
                            <img :src="pengumumanForm.gambar_sampul" alt="Gambar Pengumuman Preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!pengumumanForm.gambar_sampul">
                            <span class="text-[9px] text-slate-500 font-mono">16:9 / 3:4</span>
                        </template>
                    </div>
                    <input type="text" name="gambar_sampul" x-model="pengumumanForm.gambar_sampul" placeholder="https://... atau pilih foto surat resmi dari Pusat Berkas Media"
                           class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    <button type="button" @click="openMediaPicker('pengumuman_lampiran')"
                            class="px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Pilih Media
                    </button>
                </div>
                <p class="text-[10px] text-slate-400 mt-1">Unggah foto/scan surat resmi atau banner pengumuman dari sekolah.</p>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Isi Pengumuman (WYSIWYG) <span class="text-rose-500">*</span></label>
                <div id="editorPengumumanKonten"></div>
                <input type="hidden" name="isi_konten" id="hiddenIsiKontenPengumuman">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Publikasi</label>
                    <select name="status_publikasi" x-model="pengumumanForm.status_publikasi" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition font-semibold">
                        <option value="published">Langsung Publikasikan (Published)</option>
                        <option value="draft">Simpan Sebagai Draf (Draft)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Publikasi</label>
                    <input type="datetime-local" name="tgl_publikasi" x-model="pengumumanForm.tgl_publikasi"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>
            </div>
        </div>
    </form>
</div>
