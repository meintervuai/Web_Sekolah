<!-- TAB 2: DAFTAR & KATALOG PROGRAM KEAHLIAN -->
<div x-show="activeTab === 'jurusan'" x-cloak class="space-y-6">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
        <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-sm sm:text-base font-bold text-slate-900 font-heading flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Daftar Konsentrasi &amp; Program Keahlian
                </h2>
                <p class="text-xs text-slate-500">Kelola kompetensi keahlian, silabus, kepala program, dan urutan tampil pada katalog publik.</p>
            </div>
            <button type="button" @click="openFormJurusan()" 
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center gap-1.5 cursor-pointer shrink-0 self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Program Keahlian</span>
            </button>
        </div>

        <!-- Table Listing -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-3 py-3 w-12 text-center">Urutan</th>
                        <th class="px-3 py-3 w-20 text-center">Foto / Ikon</th>
                        <th class="px-4 py-3">Nama Program Keahlian</th>
                        <th class="px-4 py-3">Kepala Program</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($jurusanList as $item)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-3 py-3 text-center font-bold text-slate-500">
                                {{ $item->urutan }}
                            </td>
                            <td class="px-3 py-3 text-center">
                                <div class="w-14 h-10 mx-auto rounded-lg border border-slate-200 bg-slate-900 overflow-hidden relative flex items-center justify-center">
                                    @if($item->ikon_atau_foto)
                                        <!-- Ambient Blur Background -->
                                        <img src="{{ $item->ikon_atau_foto }}" alt="" aria-hidden="true" 
                                             class="absolute inset-0 w-full h-full object-cover blur-xs scale-125 opacity-40 pointer-events-none">
                                        <!-- Main Cropped Image -->
                                        <img src="{{ $item->ikon_atau_foto }}" alt="{{ $item->nama_jurusan }}" 
                                             style="{{ $item->foto_crop_style }}"
                                             class="relative z-10 w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-blue-50 text-blue-700 font-bold font-heading text-[10px]">
                                            {{ $item->singkatan ?? 'PK' }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-bold text-slate-900 text-xs flex items-center gap-2">
                                    <span>{{ $item->nama_jurusan }}</span>
                                    @if($item->singkatan)
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                            {{ $item->singkatan }}
                                        </span>
                                    @endif
                                </div>
                                <div class="text-[11px] text-slate-500 font-mono mt-0.5 flex items-center gap-1.5">
                                    <span>/program-keahlian/{{ $item->slug }}</span>
                                    <a href="{{ url(app('tenant')->slug . '/program-keahlian/' . $item->slug) }}" target="_blank" class="text-blue-600 hover:text-blue-800" title="Buka di Tab Baru">
                                        <svg class="w-3 h-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
                                @if($item->deskripsi_singkat)
                                    <p class="text-[11px] text-slate-400 line-clamp-1 mt-1">{{ $item->deskripsi_singkat }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($item->kepalaProgram)
                                    <div class="flex items-center gap-2">
                                        @if($item->kepalaProgram->foto)
                                            <div class="w-7 h-7 rounded-full overflow-hidden border border-slate-200 shrink-0">
                                                <img src="{{ $item->kepalaProgram->foto }}" alt="{{ $item->kepalaProgram->nama_lengkap }}" class="w-full h-full object-cover">
                                            </div>
                                        @else
                                            <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-600 font-bold flex items-center justify-center text-[10px] shrink-0">
                                                {{ substr($item->kepalaProgram->nama_lengkap, 0, 1) }}
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <div class="font-semibold text-slate-800 truncate text-[11px]">{{ $item->kepalaProgram->nama_lengkap }}</div>
                                            <div class="text-[10px] text-slate-400">NIP: {{ $item->kepalaProgram->nip ?? '-' }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">- Belum ditentukan -</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" 
                                        @click="toggleJurusanStatus({{ $item->id }}, {{ $item->is_aktif ? 'false' : 'true' }}, '{{ addslashes($item->nama_jurusan) }}')"
                                        :class="{{ $item->is_aktif ? 'true' : 'false' }} ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'"
                                        class="px-2.5 py-1 rounded-full text-[10px] font-bold cursor-pointer hover:opacity-80 transition inline-flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $item->is_aktif ? 'bg-emerald-600' : 'bg-slate-400' }}"></span>
                                    <span>{{ $item->is_aktif ? 'Aktif' : 'Draft' }}</span>
                                </button>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" 
                                            @click="editFormJurusan({
                                                id: {{ $item->id }},
                                                nama_jurusan: '{{ addslashes($item->nama_jurusan) }}',
                                                singkatan: '{{ addslashes($item->singkatan ?? '') }}',
                                                slug: '{{ addslashes($item->slug) }}',
                                                guru_id: '{{ $item->guru_id ?? '' }}',
                                                deskripsi_singkat: '{{ addslashes($item->deskripsi_singkat ?? '') }}',
                                                deskripsi_lengkap: @js($item->deskripsi_lengkap ?? ''),
                                                ikon_atau_foto: '{{ addslashes($item->ikon_atau_foto ?? '') }}',
                                                foto_crop_style: '{{ addslashes($item->foto_crop_style ?? '') }}',
                                                urutan: {{ $item->urutan ?? 1 }},
                                                is_aktif: {{ $item->is_aktif ? 'true' : 'false' }}
                                            })"
                                            class="p-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition cursor-pointer"
                                            title="Edit Program Keahlian">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button type="button" 
                                            @click="deleteJurusan({{ $item->id }}, '{{ addslashes($item->nama_jurusan) }}')"
                                            class="p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg transition cursor-pointer"
                                            title="Hapus Program Keahlian">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                                <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                <p class="font-bold text-slate-600 text-xs">Belum ada Program Keahlian</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Klik tombol Tambah Program Keahlian di atas untuk memulai.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
