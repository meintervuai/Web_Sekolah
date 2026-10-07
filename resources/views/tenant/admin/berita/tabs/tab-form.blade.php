<!-- TAB 2: FORM TULIS / EDIT BERITA -->
<div x-show="activeTab === 'form_berita'" x-cloak class="space-y-6">
    <form id="form-berita-main"
          :action="beritaForm.id ? '{{ url(app('tenant')->slug . '/admin/informasi/berita') }}/' + beritaForm.id : '{{ route('tenant.admin.informasi.berita.store', ['tenant' => app('tenant')->slug]) }}'" 
          method="POST" 
          @submit="prepareBeritaSubmit($event)"
          class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
        @csrf
        <template x-if="beritaForm.id">
            <input type="hidden" name="_method" value="PUT">
        </template>

        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
            <div>
                <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading" x-text="beritaForm.id ? 'Edit Artikel Berita' : 'Tulis Artikel Berita Baru'"></h2>
                <p class="text-xs text-slate-500">Lengkapi judul, kategori, gambar sampul, dan konten artikel dengan editor WYSIWYG.</p>
            </div>
            <button type="button" @click="resetFormBerita()" class="text-xs text-slate-500 hover:text-slate-800 font-bold cursor-pointer">
                Batal / Bersihkan Form
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <!-- Judul Artikel (8 cols) -->
            <div class="md:col-span-8">
                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Berita / Artikel <span class="text-rose-500">*</span></label>
                <input type="text" name="judul" x-model="beritaForm.judul" required placeholder="Contoh: Siswa SMKN 2 Bandung Meraih Juara 1 LKS Tingkat Nasional"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
            </div>

            <!-- Kategori Artikel (4 cols) -->
            <div class="md:col-span-4">
                <label class="block text-xs font-bold text-slate-700 mb-1">Kategori <span class="text-rose-500">*</span></label>
                <select name="kategori_id" x-model="beritaForm.kategori_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoriList as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Ringkasan / Excerpt (12 cols) -->
            <div class="md:col-span-12">
                <label class="block text-xs font-bold text-slate-700 mb-1">Ringkasan Singkat (Muncul di kartu katalog beranda &amp; meta SEO)</label>
                <textarea name="ringkasan" x-model="beritaForm.ringkasan" rows="2" placeholder="Tuliskan 1-2 kalimat pengantar artikel..."
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"></textarea>
            </div>

            <!-- Gambar Sampul Utama (12 cols) -->
            <div class="md:col-span-12">
                <label class="block text-xs font-bold text-slate-700 mb-1">Gambar Sampul Utama (Pusat Media / URL)</label>
                <div class="flex gap-2 items-center">
                    <div class="w-16 h-10 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 relative flex items-center justify-center">
                        <template x-if="beritaForm.gambar_sampul">
                            <img :src="beritaForm.gambar_sampul" alt="Preview Sampul" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!beritaForm.gambar_sampul">
                            <span class="text-[9px] text-slate-500 font-mono">16:9</span>
                        </template>
                    </div>
                    <input type="text" name="gambar_sampul" x-model="beritaForm.gambar_sampul" placeholder="https://... atau pilih dari Pusat Berkas Media"
                           class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    <button type="button" @click="openMediaPicker('berita_sampul')"
                            class="px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Pilih Media
                    </button>
                </div>
                <p class="text-[10px] text-slate-400 mt-1">Rasio standar 16:9 (JPG, PNG, WebP) resolusi minimal 1280x720px.</p>
            </div>

            <!-- Isi Konten Artikel WYSIWYG (12 cols) -->
            <div class="md:col-span-12">
                <label class="block text-xs font-bold text-slate-700 mb-1">Isi Konten Artikel (WYSIWYG) <span class="text-rose-500">*</span></label>
                <div id="editorBeritaKonten"></div>
                <input type="hidden" name="isi_konten" id="hiddenIsiKontenBerita">
            </div>

            <!-- Status Publikasi & Tanggal (12 cols) -->
            <div class="md:col-span-6">
                <label class="block text-xs font-bold text-slate-700 mb-1">Status Publikasi</label>
                <select name="status_publikasi" x-model="beritaForm.status_publikasi" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition font-semibold">
                    <option value="published">Langsung Publikasikan (Published)</option>
                    <option value="draft">Simpan Sebagai Draf (Draft)</option>
                </select>
            </div>
            <div class="md:col-span-6">
                <label class="block text-xs font-bold text-slate-700 mb-1">Jadwal Tanggal &amp; Waktu Publikasi</label>
                <input type="datetime-local" name="tgl_publikasi" x-model="beritaForm.tgl_publikasi"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
            </div>
        </div>
    </form>
</div>
