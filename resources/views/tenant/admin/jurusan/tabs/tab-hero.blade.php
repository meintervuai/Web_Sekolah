<!-- TAB 1: KUSTOMISASI HERO BANNER PROGRAM KEAHLIAN -->
<div x-show="activeTab === 'hero'" x-cloak class="space-y-6">
    <form id="form-jurusan-hero"
          action="{{ route('tenant.admin.jurusan.hero.update', ['tenant' => app('tenant')->slug]) }}" 
          method="POST" 
          @submit="submitLoading = true" 
          class="space-y-6">
        @csrf
        @method('PUT')

        <div class="admin-card space-y-4">
            <div class="admin-card-header">
                <div>
                    <h2 class="admin-card-title">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Kustomisasi Hero Banner (Halaman Program Keahlian Publik)
                    </h2>
                    <p class="admin-card-subtitle">Atur judul utama, deskripsi ringkas pengantar, dan gambar latar hero pada katalog program keahlian publik (<code>/program-keahlian</code>).</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="admin-form-label">Judul Utama Halaman Publik <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul_halaman" value="{{ old('judul_halaman', $halamanJurusan->judul ?? 'Program Keahlian Unggulan') }}" required
                           class="admin-form-input"
                           placeholder="Contoh: Program Keahlian Unggulan">
                </div>

                <div class="sm:col-span-2">
                    <label class="admin-form-label">Deskripsi Ringkas / Subjudul Pengantar Hero</label>
                    <textarea name="subjudul_halaman" rows="2"
                              class="admin-form-input"
                              placeholder="Contoh: SMK Negeri 2 Bandung menyelenggarakan 7 konsentrasi keahlian berstandar industri dengan fasilitas modern.">{{ old('subjudul_halaman', $halamanJurusan->subjudul) }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="admin-form-label">Foto Banner / Sampul Hero (Pusat Media)</label>
                    <div class="flex gap-2 items-center">
                        <div class="w-16 h-10 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 relative flex items-center justify-center">
                            <template x-if="bannerHeroPreview">
                                <img :src="bannerHeroPreview" alt="Banner Hero Preview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!bannerHeroPreview">
                                <span class="text-[9px] text-slate-500 font-mono">16:9</span>
                            </template>
                        </div>
                        <input type="text" name="gambar_banner_jurusan" id="input_banner_jurusan" 
                               x-model="bannerHeroPreview"
                               class="admin-form-input flex-1"
                               placeholder="https://... atau pilih dari Pusat Berkas Media">
                        <button type="button" @click="openMediaPicker('input_banner_jurusan')" 
                                class="admin-btn-action shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Pilih dari Media
                        </button>
                    </div>
                    <p class="admin-form-helper">Rasio baku 16:9 / 21:9. Tampil artistik di bagian atas halaman publik <code>/program-keahlian</code> dengan efek gradien tema.</p>
                </div>
            </div>
        </div>
    </form>
</div>

