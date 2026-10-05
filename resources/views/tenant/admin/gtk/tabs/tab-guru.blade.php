<!-- TAB 2: GURU & TENAGA KEPENDIDIKAN -->
<div x-show="activeTab === 'guru'" x-cloak class="space-y-6">
    <!-- Card 1: Kustomisasi Hero Banner (Halaman Guru & Staf Publik) -->
    <form action="{{ route('tenant.admin.gtk.guru.hero.update', ['tenant' => app('tenant')->slug]) }}" method="POST" @submit="submitLoading = true" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="p-5 sm:p-6 bg-white rounded-2xl border border-slate-200 shadow-xs space-y-4">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Kustomisasi Hero Banner (Halaman Guru &amp; Staf Publik)
                    </h2>
                    <p class="text-xs text-slate-500">Atur judul utama, deskripsi ringkas, dan gambar latar hero pada halaman direktori guru &amp; tenaga kependidikan publik.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Judul Halaman Guru &amp; Staf <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul_guru" value="{{ old('judul_guru', $halamanGuru->judul ?? 'Guru & Tenaga Kependidikan') }}" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                           placeholder="Contoh: Guru & Tenaga Kependidikan">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Ringkas / Subjudul Hero</label>
                    <textarea name="subjudul_guru" rows="2"
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                              placeholder="Contoh: Profil tenaga pendidik profesional dan staf tata usaha yang berdedikasi membentuk generasi unggul.">{{ old('subjudul_guru', $halamanGuru->subjudul) }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Foto Banner / Sampul Guru (Pusat Media)</label>
                    <div class="flex gap-2 items-center">
                        <div class="w-16 h-10 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 relative flex items-center justify-center">
                            <template x-if="bannerGuruPreview">
                                <img :src="bannerGuruPreview" alt="Banner Guru Preview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!bannerGuruPreview">
                                <span class="text-[9px] text-slate-500 font-mono">16:9</span>
                            </template>
                        </div>
                        <input type="text" name="gambar_banner_guru" id="input_banner_guru" 
                               x-model="bannerGuruPreview"
                               class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                               placeholder="https://... atau pilih dari Pusat Berkas Media">
                        <button type="button" @click="openMediaPicker('input_banner_guru')" 
                                class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Pilih dari Media
                        </button>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Rasio baku 16:9 / 21:9. Tampil sebagai latar banner di bagian atas halaman publik /guru-staf.</p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                <button type="submit" 
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Pengaturan Hero Guru
                </button>
            </div>
        </div>
    </form>

    <!-- Card 2: Manajemen CRUD Data Guru & Tenaga Kependidikan -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
        <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Daftar Guru &amp; Tenaga Kependidikan (PTK)
                </h2>
                <p class="text-xs text-slate-500">Kelola master data seluruh guru mata pelajaran, kepala jurusan, teknisi, dan staf tata usaha.</p>
            </div>
            <button type="button" @click="openModalGuru()"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-1.5 self-start cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Guru / Staf
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3">Foto</th>
                        <th class="px-4 py-3">Nama Lengkap &amp; NIP</th>
                        <th class="px-4 py-3">L/P</th>
                        <th class="px-4 py-3">Jabatan / Tugas</th>
                        <th class="px-4 py-3">Mata Pelajaran</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($allGuru as $guru)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3">
                            <div class="w-10 h-13 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden relative flex items-center justify-center">
                                @if($guru->foto)
                                    <div class="w-full h-full relative flex items-center justify-center">
                                        <img src="{{ $guru->foto }}" alt="" aria-hidden="true" class="absolute inset-0 w-full h-full object-cover blur-md scale-125 opacity-40 pointer-events-none z-0">
                                        <img src="{{ $guru->foto }}" alt="{{ $guru->nama_lengkap }}" style="{{ $guru->foto_crop_style }}" class="relative z-10 w-full h-full object-cover">
                                    </div>
                                @else
                                    <span class="text-[9px] text-slate-500 font-mono">3:4</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-bold text-slate-900 text-xs sm:text-sm">{{ $guru->nama_lengkap }}</div>
                            <div class="text-[11px] text-slate-500 font-mono">NIP: {{ $guru->nip ?: '-' }}</div>
                        </td>
                        <td class="px-4 py-3 font-semibold">
                            <span class="px-2 py-0.5 rounded-md text-[10px] {{ $guru->jenis_kelamin === 'L' ? 'bg-blue-50 text-blue-700' : 'bg-pink-50 text-pink-700' }}">
                                {{ $guru->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-slate-700 font-medium">
                            {{ $guru->jabatan ?: '-' }}
                        </td>
                        <td class="px-4 py-3 text-slate-600">
                            {{ $guru->mata_pelajaran ?: '-' }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $guru->status_aktif ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                {{ $guru->status_aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right space-x-1 whitespace-nowrap">
                            <button type="button" 
                                    @click="editGuru({
                                        id: {{ $guru->id }},
                                        nama: '{{ addslashes($guru->nama_lengkap) }}',
                                        nip: '{{ addslashes($guru->nip ?? '') }}',
                                        jenis_kelamin: '{{ $guru->jenis_kelamin }}',
                                        jabatan: '{{ addslashes($guru->jabatan ?? '') }}',
                                        mata_pelajaran: '{{ addslashes($guru->mata_pelajaran ?? '') }}',
                                        foto: '{{ addslashes($guru->foto ?? '') }}',
                                        crop_style: '{{ addslashes($guru->foto_crop_style ?? '') }}',
                                        status_aktif: {{ $guru->status_aktif ? 1 : 0 }}
                                    })"
                                    class="px-2.5 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold rounded-lg transition cursor-pointer">
                                Edit
                            </button>
                            <button type="button" 
                                    @click="deleteGuruConfirm({{ $guru->id }}, '{{ addslashes($guru->nama_lengkap) }}')"
                                    class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold rounded-lg transition cursor-pointer">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-slate-400 italic">
                            Belum ada data Guru &amp; Tenaga Kependidikan. Klik tombol di atas untuk menambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
