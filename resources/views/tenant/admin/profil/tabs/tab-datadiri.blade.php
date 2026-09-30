<!-- TAB 1: DATA DIRI SEKOLAH -->
<div x-show="activeTab === 'datadiri'" x-cloak class="space-y-6">
    <form action="{{ route('tenant.admin.profil.identitas.update', ['tenant' => app('tenant')->slug]) }}" 
          method="POST" 
          @submit="submitLoading = true">
        @csrf
        @method('PUT')
        <input type="hidden" name="form_type" value="datadiri">
        <input type="hidden" name="current_tab" value="datadiri">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Data Pokok Sekolah & Medsos (Left 7 Cols) -->
            <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">Data Pokok Satuan Pendidikan</h2>
                    <p class="text-xs text-slate-500">Informasi resmi identitas sekolah untuk header, footer, dan kartu profil.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Satuan Pendidikan <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $pengaturan['nama_sekolah']) }}" required
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Slogan / Tagline Sekolah</label>
                        <input type="text" name="slogan" value="{{ old('slogan', $pengaturan['slogan']) }}"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Logo Satuan Pendidikan (Pusat Media / URL)</label>
                        <div class="flex gap-2 items-center">
                            <div class="w-10 h-10 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-center shrink-0 overflow-hidden p-1">
                                <template x-if="logoPreview">
                                    <img :src="logoPreview" alt="Logo Preview" class="w-full h-full object-contain">
                                </template>
                                <template x-if="!logoPreview">
                                    <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </template>
                            </div>
                            <input type="text" name="logo" id="input_logo_sekolah" 
                                   x-model="logoPreview"
                                   class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                   placeholder="https://... atau pilih dari Pusat Media">
                            <button type="button" @click="openMediaPicker('input_logo_sekolah')" 
                                    class="px-3.5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Pilih Media
                            </button>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">Logo resmi sekolah (format PNG transparan / SVG direkomendasikan).</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">NPSN <span class="text-rose-500">*</span></label>
                        <input type="text" name="npsn" value="{{ old('npsn', $pengaturan['npsn']) }}" required
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Peringkat Akreditasi <span class="text-rose-500">*</span></label>
                        <input type="text" name="akreditasi" value="{{ old('akreditasi', $pengaturan['akreditasi']) }}" required
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tahun Berdiri <span class="text-rose-500">*</span></label>
                        <input type="text" name="tahun_berdiri" value="{{ old('tahun_berdiri', $pengaturan['tahun_berdiri']) }}" required
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Telepon Resmi</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon', $pengaturan['no_telepon']) }}"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="2"
                                  class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">{{ old('alamat', $pengaturan['alamat']) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email Sekolah</label>
                        <input type="email" name="email_sekolah" value="{{ old('email_sekolah', $pengaturan['email_sekolah']) }}"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp Humas / SPMB</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $pengaturan['whatsapp']) }}"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Jam Layanan Sekolah</label>
                        <input type="text" name="jam_layanan" value="{{ old('jam_layanan', $pengaturan['jam_layanan']) }}"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                               placeholder="Contoh: Senin - Jumat: 07.00 - 16.00 WIB">
                    </div>

                    <!-- Media Sosial Resmi Satuan Pendidikan -->
                    <div class="sm:col-span-2 pt-3 border-t border-slate-100">
                        <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            Akun Media Sosial Resmi (Tampil di Footer)
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Instagram URL</label>
                                <input type="url" name="instagram" value="{{ old('instagram', $pengaturan['instagram'] ?? '') }}"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                       placeholder="https://instagram.com/akunsekolah">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Facebook URL</label>
                                <input type="url" name="facebook" value="{{ old('facebook', $pengaturan['facebook'] ?? '') }}"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                       placeholder="https://facebook.com/akunsekolah">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">YouTube Channel URL</label>
                                <input type="url" name="youtube" value="{{ old('youtube', $pengaturan['youtube'] ?? '') }}"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                       placeholder="https://youtube.com/@akunsekolah">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">TikTok URL</label>
                                <input type="url" name="tiktok" value="{{ old('tiktok', $pengaturan['tiktok'] ?? '') }}"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                       placeholder="https://tiktok.com/@akunsekolah">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">X (Twitter) URL</label>
                                <input type="url" name="twitter" value="{{ old('twitter', $pengaturan['twitter'] ?? '') }}"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                       placeholder="https://x.com/akunsekolah">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kepala Sekolah & Media Profil (Right 5 Cols) -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Card Kepala Sekolah -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
                    <div class="border-b border-slate-100 pb-3">
                        <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">Kepala Satuan Pendidikan</h2>
                        <p class="text-xs text-slate-500">Nama, NIP, foto, dan sambutan pimpinan sekolah.</p>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap &amp; Gelar</label>
                            <input type="text" name="nama_kepsek" value="{{ old('nama_kepsek', $pengaturan['nama_kepsek']) }}"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">NIP Kepala Sekolah</label>
                            <input type="text" name="nip_kepsek" value="{{ old('nip_kepsek', $pengaturan['nip_kepsek']) }}"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Foto Kepala Sekolah (Pusat Media)</label>
                            <div class="flex gap-2 items-center">
                                <div class="w-10 h-13 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 relative flex items-center justify-center">
                                    <template x-if="fotoKepsekPreview">
                                        <div class="w-full h-full relative flex items-center justify-center">
                                            <img :src="fotoKepsekPreview" alt="" aria-hidden="true" class="absolute inset-0 w-full h-full object-cover blur-md scale-125 opacity-40 pointer-events-none z-0">
                                            <img :src="fotoKepsekPreview" alt="Kepsek Preview" :style="fotoKepsekCropStyle || ''" class="relative z-10 w-full h-full object-cover">
                                        </div>
                                    </template>
                                    <template x-if="!fotoKepsekPreview">
                                        <span class="text-[9px] text-slate-500 font-mono">3:4</span>
                                    </template>
                                </div>
                                <input type="text" name="foto_kepsek" id="input_foto_kepsek" 
                                       x-model="fotoKepsekPreview"
                                       class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                       placeholder="https://... atau pilih dari pustaka media">
                                <button type="button" @click="openMediaPicker('input_foto_kepsek')" 
                                        class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Pilih Media
                                </button>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-1">Rasio baku portrait 3:4. Otomatis membaca framing crop dari Pustaka Media.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Ringkasan Sambutan Kepala Sekolah</label>
                            <textarea name="sambutan_kepsek" rows="3"
                                      class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                      placeholder="Tuliskan kata sambutan kepala sekolah...">{{ old('sambutan_kepsek', $pengaturan['sambutan_kepsek']) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Card Video Profil -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
                    <div class="border-b border-slate-100 pb-3">
                        <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">Video Profil Sekolah</h2>
                        <p class="text-xs text-slate-500">Tautan YouTube atau video MP4 dari Pusat Berkas Media.</p>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Judul Video</label>
                            <input type="text" name="video_profil_judul" value="{{ old('video_profil_judul', $pengaturan['video_profil_judul']) }}"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">URL Video / YouTube (Pusat Media)</label>
                            <div class="flex gap-2">
                                <input type="text" name="video_profil" id="input_video_profil" value="{{ old('video_profil', $pengaturan['video_profil']) }}"
                                       class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                                       placeholder="https://www.youtube.com/... atau URL file media">
                                <button type="button" @click="openMediaPicker('input_video_profil', 'video')" 
                                        class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    Pilih Media
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Kilas Video</label>
                            <textarea name="video_profil_deskripsi" rows="2"
                                      class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">{{ old('video_profil_deskripsi', $pengaturan['video_profil_deskripsi']) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Bottom Bar -->
        <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
            <button type="submit" 
                    :disabled="submitLoading"
                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition flex items-center gap-2 cursor-pointer disabled:opacity-50">
                <template x-if="submitLoading">
                    <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </template>
                <span x-text="submitLoading ? 'Menyimpan ke Database...' : 'Simpan Data Diri Sekolah'"></span>
            </button>
        </div>
    </form>
</div>
