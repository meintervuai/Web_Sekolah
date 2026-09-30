<!-- POP-UP MODAL KONFIRMASI UBAH VISIBILITAS -->
<div x-show="modalConfirmToggleOpen" x-cloak 
     class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-5 space-y-4 border border-slate-200"
         @click.outside="modalConfirmToggleOpen = false">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-sm text-slate-900 font-heading">Konfirmasi Visibilitas Menu</h3>
                <p class="text-xs text-slate-500 mt-0.5" x-html="toggleConfirmMessage"></p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
            <button type="button" @click="modalConfirmToggleOpen = false" 
                    class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition cursor-pointer">
                Batal
            </button>
            <button type="button" @click="executeConfirmedToggle()" 
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer">
                Ya, Ubah Status
            </button>
        </div>
    </div>
</div>

<!-- MODAL PEJABAT STRUKTURAL (ADD / EDIT) -->
<div x-show="modalPejabatOpen" x-cloak 
     class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden border border-slate-200"
         @click.outside="modalPejabatOpen = false">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h3 class="font-bold text-sm text-slate-900 font-heading" x-text="pejabatForm.id ? 'Edit Pejabat Struktural' : 'Tambah Pejabat Struktural'"></h3>
            <button type="button" @click="modalPejabatOpen = false" class="text-slate-400 hover:text-slate-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form :action="pejabatForm.id ? `{{ url(app('tenant')->slug . '/admin/profil/pejabat') }}/${pejabatForm.id}` : `{{ route('tenant.admin.profil.pejabat.store', ['tenant' => app('tenant')->slug]) }}`" 
              method="POST" class="p-5 space-y-4">
            @csrf
            <template x-if="pejabatForm.id">
                @method('PUT')
            </template>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Hubungkan dengan Data Guru &amp; Staf (FK Database)</label>
                <select name="guru_id" x-model="pejabatForm.guru_id" @change="onSelectGuru($event)"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    <option value="">-- Bukan dari direktori Guru/Staf --</option>
                    @foreach($guruList as $guru)
                        <option value="{{ $guru->id }}" data-nama="{{ $guru->nama_lengkap }}" data-foto="{{ $guru->foto ?? '' }}" data-crop-style="{{ $guru->foto_crop_style }}">
                            {{ $guru->nama_lengkap }} (NIP: {{ $guru->nip ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap &amp; Gelar <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_lengkap" x-model="pejabatForm.nama" required
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Jabatan Struktural <span class="text-rose-500">*</span></label>
                <input type="text" name="jabatan" x-model="pejabatForm.jabatan" required
                       placeholder="Contoh: Wakil Kepala Sekolah Bidang Kurikulum"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Foto Pejabat (Pusat Media)</label>
                <div class="flex gap-2 items-center">
                    <div class="w-10 h-13 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 relative flex items-center justify-center">
                        <template x-if="pejabatForm.foto">
                            <div class="w-full h-full relative flex items-center justify-center">
                                <img :src="pejabatForm.foto" alt="" aria-hidden="true" class="absolute inset-0 w-full h-full object-cover blur-md scale-125 opacity-40 pointer-events-none z-0">
                                <img :src="pejabatForm.foto" alt="Pejabat Preview" :style="pejabatForm.crop_style || ''" class="relative z-10 w-full h-full object-cover">
                            </div>
                        </template>
                        <template x-if="!pejabatForm.foto">
                            <span class="text-[9px] text-slate-500 font-mono">3:4</span>
                        </template>
                    </div>
                    <input type="text" name="foto" id="input_foto_pejabat_modal" x-model="pejabatForm.foto"
                           class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                           placeholder="https://... atau pilih dari Pusat Media">
                    <button type="button" @click="openMediaPicker('input_foto_pejabat_modal')" 
                            class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Pilih Media
                    </button>
                </div>
                <p class="text-[10px] text-slate-400 mt-1">Rasio baku portrait 3:4. Otomatis presisi di bagan struktur.</p>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Urut Tampil</label>
                <input type="number" name="urutan" x-model="pejabatForm.urutan" min="0"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" @click="modalPejabatOpen = false"
                        class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" 
                        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer">
                    Simpan Pejabat
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL KONFIRMASI HAPUS PEJABAT -->
<div x-show="modalDeleteOpen" x-cloak 
     class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-5 space-y-4 border border-slate-200"
         @click.outside="modalDeleteOpen = false">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-sm text-slate-900 font-heading">Hapus Pejabat Struktural?</h3>
                <p class="text-xs text-slate-500 mt-0.5" x-text="`Apakah Anda yakin ingin menghapus '${deleteTargetNama}'?`"></p>
            </div>
        </div>

        <form :action="`{{ url(app('tenant')->slug . '/admin/profil/pejabat') }}/${deleteTargetId}`" method="POST" class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
            @csrf
            @method('DELETE')
            <button type="button" @click="modalDeleteOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition cursor-pointer">
                Batal
            </button>
            <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer">
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

<!-- MODAL TAMBAH / EDIT GURU & STAF -->
<div x-show="modalGuruOpen" x-cloak 
     class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden border border-slate-200"
         @click.outside="modalGuruOpen = false">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h3 class="font-bold text-sm text-slate-900 font-heading" 
                x-text="guruForm.id ? 'Edit Data Guru / Tenaga Kependidikan' : 'Tambah Guru / Tenaga Kependidikan'"></h3>
            <button type="button" @click="modalGuruOpen = false" class="text-slate-400 hover:text-slate-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form :action="guruForm.id ? `{{ url(app('tenant')->slug . '/admin/profil/guru') }}/${guruForm.id}` : `{{ route('tenant.admin.profil.guru.store', ['tenant' => app('tenant')->slug]) }}`" 
              method="POST" class="p-5 space-y-4">
            @csrf
            <template x-if="guruForm.id">
                @method('PUT')
            </template>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap &amp; Gelar <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_lengkap" x-model="guruForm.nama" required
                           placeholder="Contoh: Drs. H. Ahmad Dahlan, M.Pd."
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">NIP (Opsional)</label>
                    <input type="text" name="nip" x-model="guruForm.nip"
                           placeholder="19800101 200501 1 001"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                    <select name="jenis_kelamin" x-model="guruForm.jenis_kelamin" required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        <option value="L">Laki-laki (L)</option>
                        <option value="P">Perempuan (P)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jabatan / Tugas</label>
                    <input type="text" name="jabatan" x-model="guruForm.jabatan"
                           placeholder="Contoh: Guru Produktif / Ka. Bengkel"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Mata Pelajaran (Mapel)</label>
                    <input type="text" name="mata_pelajaran" x-model="guruForm.mata_pelajaran"
                           placeholder="Contoh: Pemrograman Web & Perangkat Bergerak"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Foto Guru / Staf (Pusat Berkas Media)</label>
                    <div class="flex gap-2 items-center">
                        <div class="w-10 h-13 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 relative flex items-center justify-center">
                            <template x-if="guruForm.foto">
                                <div class="w-full h-full relative flex items-center justify-center">
                                    <img :src="guruForm.foto" alt="" aria-hidden="true" class="absolute inset-0 w-full h-full object-cover blur-md scale-125 opacity-40 pointer-events-none z-0">
                                    <img :src="guruForm.foto" alt="Guru Preview" :style="guruForm.crop_style || ''" class="relative z-10 w-full h-full object-cover">
                                </div>
                            </template>
                            <template x-if="!guruForm.foto">
                                <span class="text-[9px] text-slate-500 font-mono">3:4</span>
                            </template>
                        </div>
                        <input type="text" name="foto" id="input_foto_guru_modal" x-model="guruForm.foto"
                               class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                               placeholder="https://... atau pilih dari Pusat Media">
                        <button type="button" @click="openMediaPicker('input_foto_guru_modal')" 
                                class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Pilih Media
                        </button>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Rasio baku portrait 3:4. Otomatis membaca framing crop dari Pustaka Media.</p>
                </div>

                <div class="sm:col-span-2 flex items-center gap-2 pt-1">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="status_aktif" value="1" x-model="guruForm.status_aktif" class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="ml-2.5 text-xs font-semibold text-slate-700">Status Guru Aktif</span>
                    </label>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" @click="modalGuruOpen = false"
                        class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" 
                        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer">
                    Simpan Data Guru
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL KONFIRMASI HAPUS GURU -->
<div x-show="modalDeleteGuruOpen" x-cloak 
     class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-5 space-y-4 border border-slate-200"
         @click.outside="modalDeleteGuruOpen = false">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-sm text-slate-900 font-heading">Hapus Data Guru / Staf?</h3>
                <p class="text-xs text-slate-500 mt-0.5" x-text="`Apakah Anda yakin ingin menghapus '${deleteTargetGuruNama}'?`"></p>
            </div>
        </div>

        <form :action="`{{ url(app('tenant')->slug . '/admin/profil/guru') }}/${deleteTargetGuruId}`" method="POST" class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
            @csrf
            @method('DELETE')
            <button type="button" @click="modalDeleteGuruOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition cursor-pointer">
                Batal
            </button>
            <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer">
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

<!-- MODAL INTEGRASI PUSAT MEDIA (MEDIA PICKER) - REUSABLE COMPONENT -->
@include('tenant.admin.media.picker-modal')
