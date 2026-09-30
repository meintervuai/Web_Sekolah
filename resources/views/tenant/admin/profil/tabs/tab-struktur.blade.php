<!-- TAB 5: STRUKTUR ORGANISASI -->
<div x-show="activeTab === 'struktur'" x-cloak class="space-y-6">
    
    <!-- Pengaturan Hero Banner & Bagan Diagram Struktur -->
    <form action="{{ route('tenant.admin.profil.struktur.update', ['tenant' => app('tenant')->slug]) }}" method="POST" @submit="submitLoading = true" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Hero Customization for Struktur Page (Top Banner Card) -->
        <div class="p-5 sm:p-6 bg-white rounded-2xl border border-slate-200 shadow-xs space-y-4">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Kelola Struktur Organisasi &amp; Kustomisasi Hero Banner
                    </h2>
                    <p class="text-xs text-slate-500">Atur judul utama, deskripsi ringkas, dan gambar latar hero pada halaman struktur organisasi publik.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Judul Halaman Struktur Organisasi <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul_struktur" value="{{ old('judul_struktur', $halamanStruktur->judul ?? 'Struktur Organisasi Sekolah') }}" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                           placeholder="Contoh: Struktur Organisasi Sekolah">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Ringkas / Subjudul Hero (Struktur)</label>
                    <textarea name="subjudul_struktur" rows="2"
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                              placeholder="Contoh: Susunan hierarki kepemimpinan, jajaran manajerial, dan unit pelaksana teknis sekolah.">{{ old('subjudul_struktur', $halamanStruktur->subjudul) }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Foto Banner / Sampul Struktur (Pusat Media)</label>
                    <div class="flex gap-2 items-center">
                        <div class="w-16 h-10 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 relative flex items-center justify-center">
                            <template x-if="bannerStrukturPreview">
                                <img :src="bannerStrukturPreview" alt="Banner Struktur Preview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!bannerStrukturPreview">
                                <span class="text-[9px] text-slate-500 font-mono">16:9</span>
                            </template>
                        </div>
                        <input type="text" name="gambar_banner_struktur" id="input_banner_struktur" 
                               x-model="bannerStrukturPreview"
                               class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition"
                               placeholder="https://... atau pilih dari Pusat Berkas Media">
                        <button type="button" @click="openMediaPicker('input_banner_struktur')" 
                                class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Pilih dari Media
                        </button>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Rasio baku 16:9 / 21:9. Tampil sebagai latar banner di bagian atas halaman publik struktur organisasi.</p>
                </div>
            </div>
        </div>

        <!-- Card 2: Bagan Diagram Struktur Organisasi (Dynamic Repeater) -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">1. Bagan Diagram Struktur Organisasi</h2>
                    <p class="text-xs text-slate-500">Diagram gambar alur hierarki manajemen sekolah, TEFA/Hubin, dan Bengkel/Lab Praktik.</p>
                </div>
                <button type="button" 
                        @click="tambahBagan()" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-1.5 self-start cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Bagan Baru
                </button>
            </div>

            <!-- Repeater List -->
            <div class="space-y-4">
                <template x-for="(diag, index) in diagramList" :key="index">
                    <div class="p-4 sm:p-5 bg-slate-50/90 rounded-2xl border border-slate-200 space-y-3 relative group">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xs font-bold text-blue-900 flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-extrabold" x-text="index + 1"></span>
                                <span x-text="diag.judul ? diag.judul : `Bagan Diagram #${index + 1}`"></span>
                            </h3>
                            <button type="button" 
                                    @click="hapusBagan(index)" 
                                    class="px-2.5 py-1 text-xs font-bold text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 rounded-lg transition flex items-center gap-1 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus Bagan
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Bagan <span class="text-rose-500">*</span></label>
                                <input type="text" :name="`diagrams[${index}][judul]`" x-model="diag.judul" required
                                       placeholder="Contoh: Bagan Struktur Utama Manajemen Sekolah"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Ringkas</label>
                                <input type="text" :name="`diagrams[${index}][deskripsi]`" x-model="diag.deskripsi"
                                       placeholder="Contoh: Alur garis komando dan koordinasi Kepala Sekolah..."
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">URL Gambar Diagram (Pusat Berkas Media) <span class="text-rose-500">*</span></label>
                                <div class="flex gap-2 items-center">
                                    <div class="w-16 h-10 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 relative flex items-center justify-center">
                                        <template x-if="diag.gambar">
                                            <img :src="diag.gambar" alt="Diagram Preview" class="w-full h-full object-cover">
                                        </template>
                                        <template x-if="!diag.gambar">
                                            <span class="text-[9px] text-slate-500 font-mono">16:9</span>
                                        </template>
                                    </div>
                                    <input type="text" :name="`diagrams[${index}][gambar]`" :id="`input_diag_${index}`" x-model="diag.gambar" required
                                           placeholder="https://... atau pilih dari Pusat Media"
                                           class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                                    <button type="button" @click="openMediaPicker(`input_diag_${index}`)" 
                                            class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        Pilih Media
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <template x-if="diagramList.length === 0">
                    <div class="py-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-300 p-6">
                        <p class="text-xs text-slate-500">Belum ada bagan diagram. Klik tombol <strong>"Tambah Bagan Baru"</strong> di atas.</p>
                    </div>
                </template>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                <button type="submit" 
                        :disabled="submitLoading"
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition flex items-center gap-2 cursor-pointer disabled:opacity-50">
                    <template x-if="submitLoading">
                        <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <span x-text="submitLoading ? 'Menyimpan...' : 'Simpan Bagan Diagram & Hero'"></span>
                </button>
            </div>
        </div>
    </form>

    <!-- Bagian B: Manajemen Pejabat Struktural (Relasi Database 100%) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
            <div>
                <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading">2. Daftar Pejabat Struktural</h2>
                <p class="text-xs text-slate-500">Tersimpan dan berelasi langsung dengan tabel Guru &amp; Staf di database.</p>
            </div>
            <button type="button" @click="openModalPejabat()"
                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-1.5 self-start cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Pejabat
            </button>
        </div>

        <!-- Tabel Pejabat Struktural -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3">Urutan</th>
                        <th class="px-4 py-3">Foto</th>
                        <th class="px-4 py-3">Nama Pejabat</th>
                        <th class="px-4 py-3">Jabatan Struktural</th>
                        <th class="px-4 py-3">Relasi Guru/Staf</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pejabatList as $pejabat)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="px-4 py-3 font-bold text-slate-500">{{ $pejabat->urutan }}</td>
                        <td class="px-4 py-3">
                            <div class="w-10 h-10 rounded-xl overflow-hidden bg-slate-900 border border-slate-200 relative flex items-center justify-center">
                                <img src="{{ !empty($pejabat->foto) ? $pejabat->foto : asset('images/logo-smkn2.svg') }}" 
                                     alt="" aria-hidden="true" class="absolute inset-0 w-full h-full object-cover blur-xs scale-125 opacity-30 pointer-events-none">
                                <img src="{{ !empty($pejabat->foto) ? $pejabat->foto : asset('images/logo-smkn2.svg') }}" 
                                     alt="{{ $pejabat->nama_lengkap }}" 
                                     style="{{ $pejabat->foto_crop_style }}"
                                     class="relative z-10 w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-4 py-3 font-bold text-slate-900">{{ $pejabat->nama_lengkap }}</td>
                        <td class="px-4 py-3 text-blue-700 font-semibold">{{ $pejabat->jabatan }}</td>
                        <td class="px-4 py-3">
                            @if($pejabat->guru)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">
                                    {{ $pejabat->guru->nama_lengkap }} (NIP: {{ $pejabat->guru->nip ?? '-' }})
                                </span>
                            @else
                                <span class="text-slate-400 italic text-[11px]">- Langsung -</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right space-x-1 whitespace-nowrap">
                            <button type="button" 
                                    @click="editPejabat({
                                         id: {{ $pejabat->id }},
                                         nama: '{{ addslashes($pejabat->nama_lengkap) }}',
                                         jabatan: '{{ addslashes($pejabat->jabatan) }}',
                                         guru_id: '{{ $pejabat->guru_id }}',
                                         foto: '{{ addslashes($pejabat->foto) }}',
                                         crop_style: '{{ addslashes($pejabat->foto_crop_style) }}',
                                         urutan: {{ $pejabat->urutan }}
                                     })"
                                    class="px-2.5 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold rounded-lg transition cursor-pointer">
                                Edit
                            </button>
                            <button type="button" 
                                    @click="deletePejabat({{ $pejabat->id }}, '{{ addslashes($pejabat->nama_lengkap) }}')"
                                    class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold rounded-lg transition cursor-pointer">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-slate-400 italic">
                            Belum ada data pejabat struktural. Klik "Tambah Pejabat" untuk menambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
