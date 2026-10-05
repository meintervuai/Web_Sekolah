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
            <div class="flex items-center gap-2.5 shrink-0 self-start sm:self-auto">
                <!-- Toggle Grid vs List -->
                <div class="flex items-center p-0.5 bg-slate-100 rounded-xl border border-slate-200">
                    <button 
                        type="button" 
                        @click="viewMode = 'list'" 
                        :class="viewMode === 'list' ? 'bg-white text-slate-900 font-bold shadow-2xs' : 'text-slate-500 hover:text-slate-800'"
                        class="px-3 py-1.5 rounded-lg text-xs transition cursor-pointer flex items-center gap-1.5"
                        title="Tampilan Tabel / Daftar">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <span class="text-xs font-semibold">Tabel</span>
                    </button>
                    <button 
                        type="button" 
                        @click="viewMode = 'grid'" 
                        :class="viewMode === 'grid' ? 'bg-white text-slate-900 font-bold shadow-2xs' : 'text-slate-500 hover:text-slate-800'"
                        class="px-3 py-1.5 rounded-lg text-xs transition cursor-pointer flex items-center gap-1.5"
                        title="Tampilan Grid / Kartu">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span class="text-xs font-semibold">Grid</span>
                    </button>
                </div>

                <button type="button" @click="openModalGuru()"
                        class="admin-btn-action">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Guru / Staf
                </button>
            </div>
        </div>

        <!-- TAMPILAN 1: Table List -->
        <div x-show="viewMode === 'list'" class="overflow-x-auto">
            <table class="admin-table">
                <thead class="admin-table-thead">
                    <tr>
                        <th class="admin-table-th w-12 text-center">No</th>
                        <th class="admin-table-th w-16 text-center">Foto</th>
                        <th class="admin-table-th">Nama Lengkap &amp; NIP</th>
                        <th class="admin-table-th">L/P</th>
                        <th class="admin-table-th">Jabatan / Tugas</th>
                        <th class="admin-table-th">Mata Pelajaran</th>
                        <th class="admin-table-th">Status</th>
                        <th class="admin-table-th text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($allGuru as $idx => $guru)
                    <tr class="admin-table-row">
                        <td class="admin-table-td text-center text-slate-400 font-medium">
                            {{ $idx + 1 }}
                        </td>
                        <td class="admin-table-td text-center">
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

        <!-- TAMPILAN 2: Grid Card Cards -->
        <div x-show="viewMode === 'grid'" x-cloak class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse($allGuru as $guru)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden flex flex-col justify-between group hover:border-slate-300 hover:shadow-xs transition duration-200">
                    <div>
                        <!-- Foto 3:4 -->
                        <div class="relative bg-slate-900 aspect-3/4 overflow-hidden flex items-center justify-center">
                            @if($guru->foto)
                                <img src="{{ $guru->foto }}" alt="" aria-hidden="true" class="absolute inset-0 w-full h-full object-cover blur-md scale-125 opacity-40 pointer-events-none z-0">
                                <img src="{{ $guru->foto }}" alt="{{ $guru->nama_lengkap }}" style="{{ $guru->foto_crop_style }}" loading="lazy" class="relative z-10 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400">
                                    <svg class="w-10 h-10 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            @endif

                            <div class="absolute top-2 left-2 z-20">
                                <span class="px-1.5 py-0.5 rounded-md text-[9px] font-bold {{ $guru->jenis_kelamin === 'L' ? 'bg-blue-600/90 text-white' : 'bg-pink-600/90 text-white' }}">
                                    {{ $guru->jenis_kelamin === 'L' ? 'L' : 'P' }}
                                </span>
                            </div>

                            <div class="absolute top-2 right-2 z-20">
                                <span class="px-1.5 py-0.5 rounded-md text-[9px] font-bold {{ $guru->status_aktif ? 'bg-emerald-600/90 text-white' : 'bg-slate-700/90 text-white' }}">
                                    {{ $guru->status_aktif ? 'Aktif' : 'Off' }}
                                </span>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="p-3 space-y-1 text-center">
                            <h3 class="font-bold text-xs text-slate-900 line-clamp-1 group-hover:text-blue-600 transition" title="{{ $guru->nama_lengkap }}">
                                {{ $guru->nama_lengkap }}
                            </h3>
                            <p class="text-[10px] text-blue-600 font-medium line-clamp-1">
                                {{ $guru->jabatan ?: 'Staf PTK' }}
                            </p>
                            @if($guru->mata_pelajaran)
                                <p class="text-[10px] text-slate-400 line-clamp-1">
                                    {{ $guru->mata_pelajaran }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="px-2.5 py-2 bg-slate-50/80 border-t border-slate-100 flex items-center justify-center gap-1.5">
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
                                class="px-2 py-1 bg-white hover:bg-blue-50 text-blue-600 border border-slate-200 rounded-lg text-[10px] font-bold transition cursor-pointer">
                            Edit
                        </button>
                        <button type="button" 
                                @click="deleteGuruConfirm({{ $guru->id }}, '{{ addslashes($guru->nama_lengkap) }}')"
                                class="px-2 py-1 bg-white hover:bg-rose-50 text-rose-600 border border-slate-200 rounded-lg text-[10px] font-bold transition cursor-pointer">
                            Hapus
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-8 text-center text-slate-400 italic">
                    Belum ada data Guru &amp; Tenaga Kependidikan. Klik tombol di atas untuk menambahkan.
                </div>
            @endforelse
        </div>
    </div>
</div>
