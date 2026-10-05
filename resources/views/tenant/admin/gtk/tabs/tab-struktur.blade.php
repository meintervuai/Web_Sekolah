<!-- TAB 1: STRUKTUR ORGANISASI -->
<div x-show="activeTab === 'struktur'" x-cloak class="space-y-6">
    
    <!-- Pengaturan Hero Banner & Bagan Diagram Struktur -->
    <form action="{{ route('tenant.admin.gtk.struktur.update', ['tenant' => app('tenant')->slug]) }}" method="POST" @submit="submitLoading = true" class="space-y-6">
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

        <!-- Bagan Alur / Diagram Visual Struktur Organisasi (Card Bawah) -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>
                        Bagan Diagram Visual Struktur Organisasi
                    </h2>
                    <p class="text-xs text-slate-500">Unggah dan kelola beberapa gambar bagan hierarki struktural (Bagan Utama, TEFA/Hubin, Ka. Lab/Bengkel).</p>
                </div>
                <button type="button" @click="tambahBagan()"
                        class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold rounded-xl transition flex items-center gap-1 self-start cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Bagan
                </button>
            </div>

            <!-- Dynamic Bagan Repeater List -->
            <div class="space-y-4">
                <template x-for="(diagram, index) in diagramList" :key="index">
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-3 relative group">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                            <span class="text-xs font-bold text-blue-900" x-text="`Bagan #${index + 1}`"></span>
                            <button type="button" @click="hapusBagan(index)" 
                                    class="text-rose-600 hover:text-rose-800 text-xs font-semibold flex items-center gap-1 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Bagan / Kategori <span class="text-rose-500">*</span></label>
                                <input type="text" :name="`diagrams[${index}][judul]`" x-model="diagram.judul" required
                                       placeholder="Contoh: Bagan Struktur Utama Manajemen Sekolah"
                                       class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-xs text-slate-800 focus:border-blue-500">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Bagan (Opsional)</label>
                                <input type="text" :name="`diagrams[${index}][deskripsi]`" x-model="diagram.deskripsi"
                                       placeholder="Contoh: Alur garis komando dan koordinasi Kepala Sekolah..."
                                       class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-xs text-slate-800 focus:border-blue-500">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Berkas Gambar Bagan (Pusat Berkas Media) <span class="text-rose-500">*</span></label>
                                <div class="flex gap-2 items-center">
                                    <div class="w-12 h-9 rounded-lg border border-slate-200 bg-slate-900 overflow-hidden shrink-0 relative flex items-center justify-center">
                                        <template x-if="diagram.gambar">
                                            <img :src="diagram.gambar" alt="Bagan Preview" class="w-full h-full object-cover">
                                        </template>
                                        <template x-if="!diagram.gambar">
                                            <span class="text-[8px] text-slate-500 font-mono">Bagan</span>
                                        </template>
                                    </div>
                                    <input type="text" :name="`diagrams[${index}][gambar]`" :id="`input_diag_${index}`" x-model="diagram.gambar" required
                                           placeholder="https://... atau pilih dari Media"
                                           class="flex-1 px-3 py-2 bg-white border border-slate-300 rounded-lg text-xs text-slate-800 focus:border-blue-500">
                                    <button type="button" @click="openMediaPicker(`input_diag_${index}`)"
                                            class="px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-semibold rounded-lg shrink-0 transition flex items-center gap-1 cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        Media
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-200">
                <button type="submit" 
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Bagan &amp; Hero Struktur
                </button>
            </div>
        </div>
    </form>

    <!-- Card 2: Pejabat Struktural & Hubungan Guru (Bawah) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
        <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Daftar Pejabat Struktural Sekolah
                </h2>
                <p class="text-xs text-slate-500">Tampilkan jajaran pimpinan, wakil kepala sekolah, kaprog, dan koordinator tata kelola.</p>
            </div>
            <button type="button" @click="openModalPejabat()"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-1.5 self-start cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Pejabat
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3">Urutan</th>
                        <th class="px-4 py-3">Foto</th>
                        <th class="px-4 py-3">Nama Pejabat</th>
                        <th class="px-4 py-3">Jabatan Struktural</th>
                        <th class="px-4 py-3">Tautan Guru/Staf</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pejabatList as $pejabat)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3 font-mono font-bold text-slate-500">
                            #{{ $pejabat->urutan }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="w-10 h-13 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden relative flex items-center justify-center">
                                @if($pejabat->foto)
                                    <div class="w-full h-full relative flex items-center justify-center">
                                        <img src="{{ $pejabat->foto }}" alt="" aria-hidden="true" class="absolute inset-0 w-full h-full object-cover blur-md scale-125 opacity-40 pointer-events-none z-0">
                                        <img src="{{ $pejabat->foto }}" alt="{{ $pejabat->nama_lengkap }}" style="{{ $pejabat->foto_crop_style }}" class="relative z-10 w-full h-full object-cover">
                                    </div>
                                @else
                                    <span class="text-[9px] text-slate-500 font-mono">3:4</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 font-bold text-slate-900">
                            {{ $pejabat->nama_lengkap }}
                        </td>
                        <td class="px-4 py-3 text-slate-600">
                            {{ $pejabat->jabatan }}
                        </td>
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
