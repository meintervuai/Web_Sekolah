@extends('layouts.tenant_admin')

@section('title', 'Kelola Struktur Organisasi')
@section('header_title', 'Struktur Organisasi Sekolah')

@section('content')
<div class="max-w-6xl space-y-6" x-data="{ editModalOpen: false, editItem: { id: null, nama_lengkap: '', jabatan: '', urutan: 0, foto: '' } }">

    <!-- Blok 1: Bagan Diagram Alur Struktur Organisasi -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Bagan Diagram Alur Struktur Organisasi</h3>
                <p class="text-xs text-slate-500 mt-0.5">Unggah gambar diagram alur komando, koordinasi manajemen, TEFA, atau laboratorium kejuruan</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200/50 self-start sm:self-auto">
                {{ count($diagrams) }} Bagan Aktif
            </span>
        </div>

        <div class="p-6 sm:p-8 space-y-6">
            <!-- Form Tambah Bagan Diagram Baru -->
            <form action="{{ route('tenant.admin.struktur.diagram.store', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-5 sm:p-6 bg-slate-50/70 border border-slate-200 rounded-2xl space-y-4">
                @csrf
                <div class="flex items-center gap-2 pb-3 border-b border-slate-200 text-xs font-bold text-slate-800 uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    Tambah Bagan Diagram Baru
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Bagan Diagram <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul" required placeholder="Contoh: Bagan Struktur Utama Manajemen Sekolah" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi / Keterangan Alur Koordinasi</label>
                        <textarea name="deskripsi" rows="2" placeholder="Jelaskan alur garis komando dan koordinasi pada bagan ini..." class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition leading-relaxed"></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <x-admin.input-gambar 
                            name="gambar" 
                            label="Berkas Gambar Diagram Bagan" 
                            recommended="Format JPG, PNG, atau WebP. Maks 3MB. Disarankan diagram beresolusi tinggi (lebar 1600 - 1920px) agar teks terbaca jelas."
                            :required="true"
                        />
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl transition shadow-xs hover:shadow-sm inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Unggah Bagan Diagram
                    </button>
                </div>
            </form>

            <!-- Daftar Bagan Diagram yang Tersedia -->
            <div>
                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-4">Daftar Bagan Diagram yang Tampil di Halaman Publik</h4>
                
                @if(count($diagrams) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($diagrams as $index => $diag)
                    <div class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden flex flex-col justify-between group hover:border-blue-300 transition shadow-2xs">
                        <div>
                            <div class="aspect-16/10 bg-slate-100 overflow-hidden relative border-b border-slate-100">
                                <img src="{{ $diag['gambar'] }}" alt="{{ $diag['judul'] }}" class="w-full h-full object-cover">
                                <a href="{{ $diag['gambar'] }}" target="_blank" class="absolute bottom-2.5 right-2.5 px-2.5 py-1 rounded-full bg-slate-900/80 hover:bg-slate-900 text-white text-[10px] font-bold flex items-center gap-1.5 backdrop-blur-xs shadow-xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    Perbesar
                                </a>
                            </div>
                            <div class="p-5 space-y-1.5">
                                <h5 class="text-xs font-bold text-slate-900 line-clamp-1">{{ $diag['judul'] }}</h5>
                                <p class="text-[11px] text-slate-500 line-clamp-3 leading-relaxed">{{ $diag['deskripsi'] ?? 'Bagan struktur alur koordinasi sekolah.' }}</p>
                            </div>
                        </div>
                        <div class="p-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] font-mono text-slate-400">Diagram #{{ $index + 1 }}</span>
                            <form action="{{ route('tenant.admin.struktur.diagram.destroy', ['tenant' => $tenant->slug, 'index' => $index]) }}" method="POST" onsubmit="return confirm('Hapus bagan diagram ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-rose-600 hover:text-rose-700 font-bold inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="p-10 text-center bg-slate-50/50 rounded-2xl border border-dashed border-slate-200 text-xs text-slate-400">
                    Belum ada bagan diagram alur yang diunggah.
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Blok 2: Personalia Pejabat Struktural Sekolah -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Jajaran Pejabat Struktural Sekolah</h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar pimpinan dan penanggung jawab yang tampil di halaman bagan & personalia struktur organisasi</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200 self-start sm:self-auto">
                {{ $struktur->count() }} Pejabat Terdaftar
            </span>
        </div>

        <div class="p-6 sm:p-8 space-y-6">
            <!-- Form Tambah Anggota Pejabat Struktural -->
            <form action="{{ route('tenant.admin.struktur.anggota.store', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-5 sm:p-6 bg-slate-50/70 border border-slate-200 rounded-2xl space-y-4">
                @csrf
                <div class="flex items-center gap-2 pb-3 border-b border-slate-200 text-xs font-bold text-slate-800 uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    Tambah Pejabat Struktural Baru
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_lengkap" placeholder="Contoh: Dra. Hj. Siti Aminah, M.Si." required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jabatan Struktural <span class="text-rose-500">*</span></label>
                        <input type="text" name="jabatan" placeholder="Contoh: Wakasek Bidang Kurikulum" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor Urutan Tampil <span class="text-rose-500">*</span></label>
                        <input type="number" name="urutan" value="{{ ($struktur->max('urutan') ?? 0) + 1 }}" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                    <div class="sm:col-span-2 lg:col-span-3">
                        <x-admin.input-gambar 
                            name="foto" 
                            label="Pas Foto Pejabat Struktural" 
                            recommended="Format JPG, PNG, atau WebP. Maks 2MB. Pas foto rasio 1:1 atau 3:4." 
                        />
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl transition shadow-xs hover:shadow-sm inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Pejabat
                    </button>
                </div>
            </form>

            <!-- Tabel & Grid Daftar Pejabat Struktural -->
            <div class="space-y-4" x-data="{ viewModePejabat: 'list' }">
                <div class="flex items-center justify-between gap-3">
                    <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Daftar Pejabat Struktural Aktif</h4>

                    <!-- View Mode Toggle -->
                    <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl border border-slate-200">
                        <button type="button" @click="viewModePejabat = 'list'" :class="viewModePejabat === 'list' ? 'bg-white text-blue-600 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-800'" class="p-1.5 rounded-lg transition text-xs flex items-center gap-1" title="Tampilan Tabel">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <button type="button" @click="viewModePejabat = 'grid'" :class="viewModePejabat === 'grid' ? 'bg-white text-blue-600 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-800'" class="p-1.5 rounded-lg transition text-xs flex items-center gap-1" title="Tampilan Grid">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Mode List (Tabel) -->
                <div x-show="viewModePejabat === 'list'" class="overflow-x-auto rounded-2xl border border-slate-200/90 bg-white shadow-2xs">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50/80 text-slate-500 uppercase font-bold text-[11px] tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="px-5 py-3.5">Urutan</th>
                                <th class="px-4 py-3.5">Foto</th>
                                <th class="px-4 py-3.5">Nama Lengkap & Gelar</th>
                                <th class="px-4 py-3.5">Jabatan Struktural</th>
                                <th class="px-5 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($struktur as $item)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="px-5 py-4 font-mono text-slate-500 text-xs">
                                    {{ $item->urutan }}
                                </td>
                                <td class="px-4 py-4">
                                    @if($item->foto)
                                    <img src="{{ $item->foto }}" alt="{{ $item->nama_lengkap }}" class="w-9 h-9 rounded-full object-cover border border-slate-200">
                                    @else
                                    <div class="w-9 h-9 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                                        {{ substr($item->nama_lengkap, 0, 1) }}
                                    </div>
                                    @endif
                                </td>
                                <td class="px-4 py-4 font-bold text-slate-900">{{ $item->nama_lengkap }}</td>
                                <td class="px-4 py-4 text-slate-600">
                                    <span class="inline-block px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-[11px] font-bold border border-blue-200/50">
                                        {{ $item->jabatan }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <button 
                                            type="button"
                                            @click="editItem = { id: {{ $item->id }}, nama_lengkap: '{{ addslashes($item->nama_lengkap) }}', jabatan: '{{ addslashes($item->jabatan) }}', urutan: {{ $item->urutan }}, foto: '{{ addslashes($item->foto ?? '') }}' }; editModalOpen = true;"
                                            class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-[11px] shadow-xs"
                                        >
                                            Ubah
                                        </button>
                                        <form action="{{ route('tenant.admin.struktur.anggota.destroy', ['tenant' => $tenant->slug, 'id' => $item->id]) }}" method="POST" onsubmit="return confirm('Hapus pejabat struktural ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-white border border-rose-200 hover:bg-rose-50 text-rose-600 font-bold text-[11px] shadow-xs">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    Belum ada pejabat struktural yang ditambahkan. Gunakan formulir di atas untuk menambahkan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mode Grid (Kartu) -->
                <div x-show="viewModePejabat === 'grid'" x-cloak>
                    @if($struktur->isEmpty())
                        <div class="p-10 text-center bg-slate-50/50 rounded-2xl border border-dashed border-slate-200 text-xs text-slate-400">
                            Belum ada pejabat struktural yang ditambahkan.
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                            @foreach($struktur as $item)
                                <div class="bg-white rounded-2xl border border-slate-200/90 p-5 flex flex-col justify-between items-center text-center shadow-2xs hover:border-blue-300 transition">
                                    <div class="flex flex-col items-center space-y-3 w-full">
                                        <div class="relative">
                                            @if($item->foto)
                                                <img src="{{ $item->foto }}" alt="{{ $item->nama_lengkap }}" class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-sm">
                                            @else
                                                <div class="w-16 h-16 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 font-bold text-lg">
                                                    {{ substr($item->nama_lengkap, 0, 1) }}
                                                </div>
                                            @endif
                                            <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-blue-600 text-white font-mono text-[10px] font-bold flex items-center justify-center shadow-xs">
                                                {{ $item->urutan }}
                                            </span>
                                        </div>
                                        <div class="w-full">
                                            <h5 class="text-xs font-bold text-slate-900 line-clamp-1">{{ $item->nama_lengkap }}</h5>
                                            <span class="inline-block mt-1 px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-[10px] font-semibold line-clamp-1">
                                                {{ $item->jabatan }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="pt-3 mt-4 w-full border-t border-slate-100 flex items-center justify-center gap-3">
                                        <button 
                                            type="button"
                                            @click="editItem = { id: {{ $item->id }}, nama_lengkap: '{{ addslashes($item->nama_lengkap) }}', jabatan: '{{ addslashes($item->jabatan) }}', urutan: {{ $item->urutan }}, foto: '{{ addslashes($item->foto ?? '') }}' }; editModalOpen = true;"
                                            class="text-[11px] text-blue-600 hover:text-blue-700 font-bold"
                                        >
                                            Ubah
                                        </button>
                                        <span class="text-slate-300">|</span>
                                        <form action="{{ route('tenant.admin.struktur.anggota.destroy', ['tenant' => $tenant->slug, 'id' => $item->id]) }}" method="POST" onsubmit="return confirm('Hapus pejabat struktural ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[11px] text-rose-600 hover:text-rose-700 font-bold">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ubah Anggota Struktural -->
    <div 
        x-show="editModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4"
        @keydown.escape.window="editModalOpen = false"
    >
        <div 
            class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-7 space-y-5 shadow-xl border border-slate-200"
            @click.away="editModalOpen = false"
        >
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h4 class="text-sm font-bold text-slate-900">Ubah Data Pejabat Struktural</h4>
                <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form :action="'{{ url($tenant->slug . '/admin/struktur/anggota') }}/' + editItem.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_lengkap" x-model="editItem.nama_lengkap" required class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jabatan Struktural <span class="text-rose-500">*</span></label>
                    <input type="text" name="jabatan" x-model="editItem.jabatan" required class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor Urutan Tampil <span class="text-rose-500">*</span></label>
                    <input type="number" name="urutan" x-model="editItem.urutan" required class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Ganti Pas Foto (Opsional)</label>
                    <input type="file" name="foto_file" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer bg-slate-50/70 border border-slate-200 rounded-xl">
                    <p class="text-[11px] text-slate-400 mt-1">Kosongkan jika tidak ingin mengganti foto yang sudah ada.</p>
                </div>

                <div class="flex justify-end gap-2.5 pt-4 border-t border-slate-100">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs hover:shadow-sm transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
