<!-- TAB 1: DATA DIRI SEKOLAH -->
<div x-show="activeTab === 'datadiri'" x-cloak class="space-y-6">
    <form id="form-datadiri"
          action="{{ route('tenant.admin.profil.identitas.update', ['tenant' => app('tenant')->slug]) }}" 
          method="POST" 
          @submit="submitLoading = true">
        @csrf
        @method('PUT')
        <input type="hidden" name="form_type" value="datadiri">
        <input type="hidden" name="current_tab" value="datadiri">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Data Pokok Sekolah & Medsos (Left 7 Cols) -->
            <div class="lg:col-span-7 admin-card space-y-4">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Data Pokok Satuan Pendidikan</h2>
                    <p class="admin-card-subtitle">Informasi resmi identitas sekolah untuk header, footer, dan kartu profil.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="admin-form-label">Nama Satuan Pendidikan <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $pengaturan['nama_sekolah']) }}" required
                               class="admin-form-input">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="admin-form-label">Slogan / Tagline Sekolah</label>
                        <input type="text" name="slogan" value="{{ old('slogan', $pengaturan['slogan']) }}"
                               class="admin-form-input">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="admin-form-label">Logo Satuan Pendidikan (Pusat Media / URL)</label>
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
                                   class="admin-form-input flex-1"
                                   placeholder="https://... atau pilih dari Pusat Media">
                            <button type="button" @click="openMediaPicker('input_logo_sekolah')" 
                                    class="admin-btn-action shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Pilih Media
                            </button>
                        </div>
                        <p class="admin-form-helper">Logo resmi sekolah (format PNG transparan / SVG direkomendasikan).</p>
                    </div>

                    <div>
                        <label class="admin-form-label">NPSN <span class="text-rose-500">*</span></label>
                        <input type="text" name="npsn" value="{{ old('npsn', $pengaturan['npsn']) }}" required
                               class="admin-form-input">
                    </div>

                    <div>
                        <label class="admin-form-label">Peringkat Akreditasi <span class="text-rose-500">*</span></label>
                        <input type="text" name="akreditasi" value="{{ old('akreditasi', $pengaturan['akreditasi']) }}" required
                               class="admin-form-input">
                    </div>

                    <div>
                        <label class="admin-form-label">Tahun Berdiri <span class="text-rose-500">*</span></label>
                        <input type="text" name="tahun_berdiri" value="{{ old('tahun_berdiri', $pengaturan['tahun_berdiri']) }}" required
                               class="admin-form-input">
                    </div>

                    <div>
                        <label class="admin-form-label">Nomor Telepon Resmi</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon', $pengaturan['no_telepon']) }}"
                               class="admin-form-input">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="admin-form-label">Alamat Lengkap</label>
                        <textarea name="alamat" rows="2"
                                  class="admin-form-input">{{ old('alamat', $pengaturan['alamat']) }}</textarea>
                    </div>

                    <div>
                        <label class="admin-form-label">Email Sekolah</label>
                        <input type="email" name="email_sekolah" value="{{ old('email_sekolah', $pengaturan['email_sekolah']) }}"
                               class="admin-form-input">
                    </div>

                    <div>
                        <label class="admin-form-label">Nomor WhatsApp Humas / SPMB</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $pengaturan['whatsapp']) }}"
                               class="admin-form-input">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="admin-form-label">Jam Layanan Sekolah</label>
                        <input type="text" name="jam_layanan" value="{{ old('jam_layanan', $pengaturan['jam_layanan']) }}"
                               class="admin-form-input"
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
                                <label class="admin-form-label">Instagram URL</label>
                                <input type="url" name="instagram" value="{{ old('instagram', $pengaturan['instagram'] ?? '') }}"
                                       class="admin-form-input"
                                       placeholder="https://instagram.com/akunsekolah">
                            </div>
                            <div>
                                <label class="admin-form-label">Facebook URL</label>
                                <input type="url" name="facebook" value="{{ old('facebook', $pengaturan['facebook'] ?? '') }}"
                                       class="admin-form-input"
                                       placeholder="https://facebook.com/akunsekolah">
                            </div>
                            <div>
                                <label class="admin-form-label">YouTube Channel URL</label>
                                <input type="url" name="youtube" value="{{ old('youtube', $pengaturan['youtube'] ?? '') }}"
                                       class="admin-form-input"
                                       placeholder="https://youtube.com/@akunsekolah">
                            </div>
                            <div>
                                <label class="admin-form-label">TikTok URL</label>
                                <input type="url" name="tiktok" value="{{ old('tiktok', $pengaturan['tiktok'] ?? '') }}"
                                       class="admin-form-input"
                                       placeholder="https://tiktok.com/@akunsekolah">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="admin-form-label">X (Twitter) URL</label>
                                <input type="url" name="twitter" value="{{ old('twitter', $pengaturan['twitter'] ?? '') }}"
                                       class="admin-form-input"
                                       placeholder="https://x.com/akunsekolah">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kepala Sekolah & Media Profil (Right 5 Cols) -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Card Kepala Sekolah -->
                <div class="admin-card space-y-4">
                    <div class="admin-card-header">
                        <h2 class="admin-card-title">Kepala Satuan Pendidikan</h2>
                        <p class="admin-card-subtitle">Nama, NIP, foto, dan sambutan pimpinan sekolah.</p>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="admin-form-label">Nama Lengkap &amp; Gelar</label>
                            <input type="text" name="nama_kepsek" value="{{ old('nama_kepsek', $pengaturan['nama_kepsek']) }}"
                                   class="admin-form-input">
                        </div>

                        <div>
                            <label class="admin-form-label">NIP Kepala Sekolah</label>
                            <input type="text" name="nip_kepsek" value="{{ old('nip_kepsek', $pengaturan['nip_kepsek']) }}"
                                   class="admin-form-input">
                        </div>

                        <div>
                            <label class="admin-form-label">Foto Kepala Sekolah (Pusat Media)</label>
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
                                       class="admin-form-input flex-1"
                                       placeholder="https://... atau pilih dari pustaka media">
                                <button type="button" @click="openMediaPicker('input_foto_kepsek')" 
                                        class="admin-btn-action shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Pilih Media
                                </button>
                            </div>
                            <p class="admin-form-helper">Rasio baku portrait 3:4. Otomatis membaca framing crop dari Pustaka Media.</p>
                        </div>

                        <div>
                            <label class="admin-form-label">Ringkasan Sambutan Kepala Sekolah</label>
                            <textarea name="sambutan_kepsek" rows="3"
                                      class="admin-form-input"
                                      placeholder="Tuliskan kata sambutan kepala sekolah...">{{ old('sambutan_kepsek', $pengaturan['sambutan_kepsek']) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Card Video Profil -->
                <div class="admin-card space-y-4">
                    <div class="admin-card-header">
                        <h2 class="admin-card-title">Video Profil Sekolah</h2>
                        <p class="admin-card-subtitle">Tautan YouTube atau video MP4 dari Pusat Berkas Media.</p>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="admin-form-label">Judul Video</label>
                            <input type="text" name="video_profil_judul" value="{{ old('video_profil_judul', $pengaturan['video_profil_judul']) }}"
                                   class="admin-form-input">
                        </div>

                        <div>
                            <label class="admin-form-label">URL Video / YouTube (Pusat Media)</label>
                            <div class="flex gap-2">
                                <input type="text" name="video_profil" id="input_video_profil" value="{{ old('video_profil', $pengaturan['video_profil']) }}"
                                       class="admin-form-input flex-1"
                                       placeholder="https://www.youtube.com/... atau URL file media">
                                <button type="button" @click="openMediaPicker('input_video_profil', 'video')" 
                                        class="admin-btn-action shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    Pilih Media
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="admin-form-label">Deskripsi Kilas Video</label>
                            <textarea name="video_profil_deskripsi" rows="2"
                                      class="admin-form-input">{{ old('video_profil_deskripsi', $pengaturan['video_profil_deskripsi']) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

