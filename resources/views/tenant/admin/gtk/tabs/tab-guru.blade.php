<!-- TAB 2: GURU & TENAGA KEPENDIDIKAN -->
<div x-show="activeTab === 'guru'" x-cloak class="space-y-6">
    <!-- Card 1: Kustomisasi Hero Banner (Halaman Guru & Staf Publik) -->
    <form id="form-gtk-guru-hero" action="{{ route('tenant.admin.gtk.guru.hero.update', ['tenant' => app('tenant')->slug]) }}" method="POST" @submit="submitLoading = true" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="admin-card space-y-4">
            <div class="admin-card-header">
                <div>
                    <h2 class="admin-card-title">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Kustomisasi Hero Banner (Halaman Guru &amp; Staf Publik)
                    </h2>
                    <p class="admin-card-subtitle">Atur judul utama, deskripsi ringkas, dan gambar latar hero pada halaman direktori guru &amp; tenaga kependidikan publik.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="admin-form-label">Judul Halaman Guru &amp; Staf <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul_guru" value="{{ old('judul_guru', $halamanGuru->judul ?? 'Guru & Tenaga Kependidikan') }}" required
                           class="admin-form-input"
                           placeholder="Contoh: Guru & Tenaga Kependidikan">
                </div>

                <div class="sm:col-span-2">
                    <label class="admin-form-label">Deskripsi Ringkas / Subjudul Hero</label>
                    <textarea name="subjudul_guru" rows="2"
                              class="admin-form-input"
                              placeholder="Contoh: Profil tenaga pendidik profesional dan staf tata usaha yang berdedikasi membentuk generasi unggul.">{{ old('subjudul_guru', $halamanGuru->subjudul) }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="admin-form-label">Foto Banner / Sampul Guru (Pusat Media)</label>
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
                               class="admin-form-input flex-1"
                               placeholder="https://... atau pilih dari Pusat Berkas Media">
                        <button type="button" @click="openMediaPicker('input_banner_guru')" 
                                class="admin-btn-action shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Pilih dari Media
                        </button>
                    </div>
                    <p class="admin-form-helper">Rasio baku 16:9 / 21:9. Tampil sebagai latar banner di bagian atas halaman publik /guru-staf.</p>
                </div>
            </div>
        </div>
    </form>

    <!-- Card 2: Manajemen CRUD Data Guru & Tenaga Kependidikan -->
    <div class="admin-card space-y-4">
        <div class="admin-card-header">
            <div>
                <h2 class="admin-card-title">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Daftar Guru &amp; Tenaga Kependidikan (PTK)
                </h2>
                <p class="admin-card-subtitle">Kelola master data seluruh guru mata pelajaran, kepala jurusan, teknisi, dan staf tata usaha.</p>
            </div>
            <button type="button" @click="openModalGuru()"
                    class="admin-btn-action self-start">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Guru / Staf
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead class="admin-table-thead">
                    <tr>
                        <th class="admin-table-th">Foto</th>
                        <th class="admin-table-th">Nama Lengkap &amp; NIP</th>
                        <th class="admin-table-th">L/P</th>
                        <th class="admin-table-th">Jabatan / Tugas</th>
                        <th class="admin-table-th">Mata Pelajaran</th>
                        <th class="admin-table-th">Status</th>
                        <th class="admin-table-th text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($allGuru as $guru)
                    <tr class="admin-table-row">
                        <td class="admin-table-td">
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
                        <td class="admin-table-td">
                            <div class="font-bold text-slate-900 text-xs sm:text-sm">{{ $guru->nama_lengkap }}</div>
                            <div class="text-[11px] text-slate-500 font-mono">NIP: {{ $guru->nip ?: '-' }}</div>
                        </td>
                        <td class="admin-table-td font-semibold">
                            <span class="px-2 py-0.5 rounded-md text-[10px] {{ $guru->jenis_kelamin === 'L' ? 'bg-blue-50 text-blue-700' : 'bg-pink-50 text-pink-700' }}">
                                {{ $guru->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </td>
                        <td class="admin-table-td text-slate-700 font-medium">
                            {{ $guru->jabatan ?: '-' }}
                        </td>
                        <td class="admin-table-td text-slate-600">
                            {{ $guru->mata_pelajaran ?: '-' }}
                        </td>
                        <td class="admin-table-td">
                            <span class="{{ $guru->status_aktif ? 'admin-badge-success' : 'admin-badge-slate' }}">
                                {{ $guru->status_aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="admin-table-td text-right space-x-1 whitespace-nowrap">
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
