<!-- TAB 3: SEJARAH SEKOLAH -->
<div x-show="activeTab === 'sejarah'" x-cloak class="space-y-6">
    <form id="form-sejarah"
          action="{{ route('tenant.admin.profil.halaman.update', ['tenant' => app('tenant')->slug, 'slug' => 'sejarah']) }}" 
          method="POST" 
          @submit="syncEditor('editor_sejarah', 'isi_sejarah'); submitLoading = true">
        @csrf
        @method('PUT')

        <div class="admin-card space-y-5">
            <div class="admin-card-header">
                <div>
                    <h2 class="admin-card-title">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Kelola Halaman Sejarah Sekolah
                    </h2>
                    <p class="admin-card-subtitle">Edit isi sejarah dengan editor teks WYSIWYG lengkap, banner media, dan pengaturan hero.</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="admin-form-label">Judul Halaman Sejarah <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul', $halamanSejarah->judul) }}" required
                               class="admin-form-input">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="admin-form-label">Deskripsi Ringkas / Subjudul Hero Banner</label>
                        <textarea name="subjudul" rows="2"
                                  class="admin-form-input">{{ old('subjudul', $halamanSejarah->subjudul) }}</textarea>
                    </div>
                </div>

                <div>
                    <label class="admin-form-label">Foto Banner / Sampul Sejarah (Pusat Media)</label>
                    <div class="flex gap-2">
                        <input type="text" name="gambar_banner" id="input_banner_sejarah" value="{{ old('gambar_banner', $halamanSejarah->gambar_banner) }}"
                               class="admin-form-input flex-1"
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
                        <label class="admin-form-label">Isi Teks Sejarah (WYSIWYG) <span class="text-rose-500">*</span></label>
                        <span class="text-[10px] text-slate-400">Gunakan toolbar untuk format teks, list, heading &amp; kutipan</span>
                    </div>
                    
                    <!-- Hidden textarea that gets submitted -->
                    <textarea name="isi_konten" id="isi_sejarah" class="hidden">{!! old('isi_konten', $halamanSejarah->isi_konten) !!}</textarea>
                    
                    <!-- Quill Editor Element -->
                    <div id="editor_sejarah">{!! old('isi_konten', $halamanSejarah->isi_konten) !!}</div>
                </div>
            </div>
        </div>
    </form>
</div>

