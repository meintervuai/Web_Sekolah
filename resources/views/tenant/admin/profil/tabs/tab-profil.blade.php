<!-- TAB 2: PROFIL LENGKAP & BUDAYA SEKOLAH -->
<div x-show="activeTab === 'identitas'" x-cloak class="space-y-6">
    <form id="form-profil"
          action="{{ route('tenant.admin.profil.identitas.update', ['tenant' => app('tenant')->slug]) }}" 
          method="POST" 
          @submit="syncEditor('editor_profil', 'isi_profil'); submitLoading = true">
        @csrf
        @method('PUT')
        <input type="hidden" name="form_type" value="halaman_profil">
        <input type="hidden" name="current_tab" value="identitas">

        <!-- Hero Customization for Profil Page (Top Banner) -->
        <div class="admin-card space-y-4">
            <div class="admin-card-header">
                <div>
                    <h2 class="admin-card-title">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Kustomisasi Hero Banner (Halaman Profil Publik)
                    </h2>
                    <p class="admin-card-subtitle">Atur judul utama, deskripsi ringkas, dan gambar latar hero pada halaman profil.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="admin-form-label">Judul Utama Hero Banner <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul_profil" value="{{ old('judul_profil', $halamanProfil->judul ?? ('Profil ' . $pengaturan['nama_sekolah'])) }}" required
                           class="admin-form-input"
                           placeholder="Contoh: Profil Singkat & Nilai Budaya Sekolah">
                </div>

                <div class="sm:col-span-2">
                    <label class="admin-form-label">Deskripsi Ringkas / Subjudul Hero</label>
                    <textarea name="subjudul_profil" rows="2"
                              class="admin-form-input"
                              placeholder="Contoh: Mengenal lebih dekat sejarah, visi misi, budaya kerja, dan pimpinan satuan pendidikan kejuruan berprestasi.">{{ old('subjudul_profil', $halamanProfil->subjudul) }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="admin-form-label">Gambar Latar Hero (Pusat Media)</label>
                    <div class="flex gap-2 items-center">
                        <div class="w-16 h-10 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 relative flex items-center justify-center">
                            <template x-if="bannerProfilPreview">
                                <img :src="bannerProfilPreview" alt="Banner Preview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!bannerProfilPreview">
                                <span class="text-[9px] text-slate-500 font-mono">16:9</span>
                            </template>
                        </div>
                        <input type="text" name="gambar_banner_profil" id="input_banner_profil" 
                               x-model="bannerProfilPreview"
                               class="admin-form-input flex-1"
                               placeholder="https://... atau pilih dari Pusat Berkas Media">
                        <button type="button" @click="openMediaPicker('input_banner_profil')" 
                                class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Pilih dari Media
                        </button>
                    </div>
                    <p class="admin-form-helper">Rasio standar 16:9 / 21:9. Tampil artistik di hero dengan efek fade halus.</p>
                </div>
            </div>
        </div>

        <!-- Uraian Lengkap Profil Sekolah (WYSIWYG Editor) -->
        <div class="admin-card space-y-4">
            <div class="admin-card-header">
                <div>
                    <h2 class="admin-card-title">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Uraian Lengkap Profil &amp; Budaya Sekolah (WYSIWYG)
                    </h2>
                    <p class="admin-card-subtitle">Teks bebas untuk menjelaskan nilai budaya, keunggulan, atau pengantar sekolah yang tampil di halaman profil publik.</p>
                </div>
            </div>

            <div>
                <!-- Hidden textarea that gets submitted -->
                <textarea name="isi_konten_profil" id="isi_profil" class="hidden">{!! old('isi_konten_profil', $halamanProfil->isi_konten) !!}</textarea>
                
                <!-- Quill Editor Element -->
                <div id="editor_profil">{!! old('isi_konten_profil', $halamanProfil->isi_konten) !!}</div>
            </div>
        </div>
    </form>
</div>

