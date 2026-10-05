<!-- TAB 4: VISI & MISI -->
<div x-show="activeTab === 'visimisi'" x-cloak class="space-y-6">
    <form id="form-visimisi"
          action="{{ route('tenant.admin.profil.halaman.update', ['tenant' => app('tenant')->slug, 'slug' => 'visi-misi']) }}" 
          method="POST" 
          @submit="syncEditor('editor_visimisi', 'isi_visimisi'); submitLoading = true">
        @csrf
        @method('PUT')

        <div class="admin-card space-y-5">
            <div class="admin-card-header">
                <div>
                    <h2 class="admin-card-title">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Kelola Visi, Misi &amp; Sasaran Mutu
                    </h2>
                    <p class="admin-card-subtitle">Edit visi, misi, deskripsi hero banner, dan tujuan sekolah dengan editor teks terformat.</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="admin-form-label">Judul Halaman Visi &amp; Misi <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul', $halamanVisiMisi->judul) }}" required
                               class="admin-form-input">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="admin-form-label">Deskripsi Ringkas / Subjudul Hero Banner</label>
                        <textarea name="subjudul" rows="2"
                                  class="admin-form-input">{{ old('subjudul', $halamanVisiMisi->subjudul) }}</textarea>
                    </div>
                </div>

                <div>
                    <label class="admin-form-label">Foto Banner / Sampul (Pusat Media)</label>
                    <div class="flex gap-2">
                        <input type="text" name="gambar_banner" id="input_banner_visimisi" value="{{ old('gambar_banner', $halamanVisiMisi->gambar_banner) }}"
                               class="admin-form-input flex-1"
                               placeholder="https://... atau pilih dari Pusat Media">
                        <button type="button" @click="openMediaPicker('input_banner_visimisi')" 
                                class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Pilih dari Media
                        </button>
                    </div>
                </div>

                <!-- WYSIWYG Editor Container -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="admin-form-label">Isi Visi, Misi &amp; Sasaran Mutu (WYSIWYG) <span class="text-rose-500">*</span></label>
                        <span class="text-[10px] text-slate-400">Dapat menyusun poin visi, misi, dan indikator sasaran dengan rapi</span>
                    </div>
                    
                    <!-- Hidden textarea that gets submitted -->
                    <textarea name="isi_konten" id="isi_visimisi" class="hidden">{!! old('isi_konten', $halamanVisiMisi->isi_konten) !!}</textarea>
                    
                    <!-- Quill Editor Element -->
                    <div id="editor_visimisi">{!! old('isi_konten', $halamanVisiMisi->isi_konten) !!}</div>
                </div>
            </div>
        </div>
    </form>
</div>

