@extends('layouts.tenant_admin')

@section('title', 'Kelola Struktur Organisasi')
@section('header_title', 'Struktur Organisasi Sekolah')

@section('content')
<div class="max-w-6xl space-y-8" x-data="{ editModalOpen: false, editItem: { id: null, nama_lengkap: '', jabatan: '', urutan: 0, foto: '' } }">

    <!-- Blok 1: Bagan Diagram Alur Struktur Organisasi -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Bagan Diagram Alur Struktur Organisasi</h3>
                <p class="text-xs text-slate-500 mt-0.5">Unggah gambar diagram bagan alur komando, koordinasi manajemen, TEFA, atau laboratorium kejuruan.</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100 self-start sm:self-auto">
                {{ count($diagrams) }} Bagan Aktif
            </span>
        </div>

        <div class="p-6 sm:p-8 space-y-8">
            <!-- Form Tambah Bagan Diagram Baru -->
            <form action="{{ route('tenant.admin.struktur.diagram.store', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-5 sm:p-6 bg-slate-50/80 border border-slate-200 rounded-2xl space-y-5">
                @csrf
                <div class="flex items-center gap-2 pb-2 border-b border-slate-200 text-xs font-bold text-slate-800 uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    Tambah Bagan Diagram Baru
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Judul Bagan Diagram <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul" required placeholder="Contoh: Bagan Struktur Utama Manajemen Sekolah" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi / Keterangan Alur Koordinasi</label>
                        <textarea name="deskripsi" rows="2" placeholder="Jelaskan alur garis komando dan koordinasi pada bagan ini..." class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 leading-relaxed"></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <x-admin.input-gambar 
                            name="gambar" 
                            label="Berkas Gambar Diagram Bagan" 
                            recommended="Format JPG, PNG, atau WebP. Maks 3MB. Disarankan diagram beresolusi tinggi (lebar 1600 - 1920px) agar bagan teks terbaca jelas."
                            :required="true"
                        />
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-5 py-2.5 bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs rounded-xl transition shadow-xs cursor-pointer inline-flex items-center gap-2">
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
                    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden flex flex-col justify-between group hover:border-blue-300 transition shadow-2xs">
                        <div>
                            <div class="aspect-16/10 bg-slate-100 overflow-hidden relative border-b border-slate-100">
                                <img src="{{ $diag['gambar'] }}" alt="{{ $diag['judul'] }}" class="w-full h-full object-cover group-hover:scale-102 transition duration-300">
                                <a href="{{ $diag['gambar'] }}" target="_blank" class="absolute bottom-2 right-2 px-2 py-1 rounded bg-slate-900/80 hover:bg-slate-900 text-white text-[10px] font-semibold flex items-center gap-1 backdrop-blur-xs">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    Perbesar
                                </a>
                            </div>
                            <div class="p-4 space-y-1.5">
                                <h5 class="text-xs font-bold text-slate-900 line-clamp-1">{{ $diag['judul'] }}</h5>
                                <p class="text-[11px] text-slate-500 line-clamp-3 leading-relaxed">{{ $diag['deskripsi'] ?? 'Bagan struktur alur koordinasi sekolah.' }}</p>
                            </div>
                        </div>
                        <div class="p-3 bg-slate-50/70 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[10px] font-semibold text-slate-400">Diagram #{{ $index + 1 }}</span>
                            <form action="{{ route('tenant.admin.struktur.diagram.destroy', ['tenant' => $tenant->slug, 'index' => $index]) }}" method="POST" onsubmit="return confirm('Hapus bagan diagram ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-rose-600 hover:text-rose-800 font-semibold cursor-pointer inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="p-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                    <p class="text-xs text-slate-500">Belum ada bagan diagram alur yang diunggah.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Blok 2: Personalia Pejabat Struktural Sekolah -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Jajaran Pejabat Struktural Sekolah</h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar pimpinan dan penanggung jawab yang tampil di halaman bagan & personalia struktur organisasi.</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100 self-start sm:self-auto">
                {{ $struktur->count() }} Pejabat Terdaftar
            </span>
        </div>

        <div class="p-6 sm:p-8 space-y-8">
            <!-- Form Tambah Anggota Pejabat Struktural -->
            <form action="{{ route('tenant.admin.struktur.anggota.store', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-5 sm:p-6 bg-slate-50/80 border border-slate-200 rounded-2xl space-y-5">
                @csrf
                <div class="flex items-center gap-2 pb-2 border-b border-slate-200 text-xs font-bold text-slate-800 uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    Tambah Pejabat Struktural Baru
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_lengkap" placeholder="Contoh: Dra. Hj. Siti Aminah, M.Si." required class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jabatan Struktural <span class="text-rose-500">*</span></label>
                        <input type="text" name="jabatan" placeholder="Contoh: Wakasek Bidang Kurikulum" required class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Urutan Tampil <span class="text-rose-500">*</span></label>
                        <input type="number" name="urutan" value="{{ ($struktur->max('urutan') ?? 0) + 1 }}" required class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:ring-2 focus:ring-blue-500">
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
                    <button type="submit" class="px-5 py-2.5 bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs rounded-xl transition shadow-xs cursor-pointer inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Pejabat Struktural
                    </button>
                </div>
            </form>

            <!-- Tabel Daftar Pejabat Struktural -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Daftar Pejabat Struktural Aktif</h4>

                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-100/75 text-slate-600 uppercase font-bold text-[10px] border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3">Urutan</th>
                                <th class="px-4 py-3">Foto</th>
                                <th class="px-4 py-3">Nama Lengkap & Gelar</th>
                                <th class="px-4 py-3">Jabatan Struktural</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($struktur as $item)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-4 py-3 font-bold text-slate-500">
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-slate-100 text-slate-700 text-xs">
                                        {{ $item->urutan }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if($item->foto)
                                    <img src="{{ $item->foto }}" alt="{{ $item->nama_lengkap }}" class="w-9 h-9 rounded-full object-cover border border-slate-200 shadow-2xs">
                                    @else
                                    <div class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 font-bold text-[10px]">
                                        {{ substr($item->nama_lengkap, 0, 1) }}
                                    </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 font-bold text-slate-900">{{ $item->nama_lengkap }}</td>
                                <td class="px-4 py-3 text-slate-600">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[11px] font-medium border border-slate-200">
                                        {{ $item->jabatan }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="inline-flex items-center gap-3">
                                        <button 
                                            type="button"
                                            @click="editItem = { id: {{ $item->id }}, nama_lengkap: '{{ addslashes($item->nama_lengkap) }}', jabatan: '{{ addslashes($item->jabatan) }}', urutan: {{ $item->urutan }}, foto: '{{ addslashes($item->foto ?? '') }}' }; editModalOpen = true;"
                                            class="text-blue-600 hover:text-blue-800 font-semibold cursor-pointer text-xs"
                                        >
                                            Ubah
                                        </button>
                                        <form action="{{ route('tenant.admin.struktur.anggota.destroy', ['tenant' => $tenant->slug, 'id' => $item->id]) }}" method="POST" onsubmit="return confirm('Hapus pejabat struktural ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold cursor-pointer text-xs">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-slate-400">
                                    Belum ada pejabat struktural yang ditambahkan. Gunakan formulir di atas untuk menambahkan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ubah Anggota Struktural -->
    <div 
        x-show="editModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4"
        @keydown.escape.window="editModalOpen = false"
    >
        <div 
            class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-7 space-y-5 shadow-xl border border-slate-200"
            @click.away="editModalOpen = false"
        >
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h4 class="text-sm font-bold text-slate-900">Ubah Data Pejabat Struktural</h4>
                <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form :action="'{{ url($tenant->slug . '/admin/struktur/anggota') }}/' + editItem.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_lengkap" x-model="editItem.nama_lengkap" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jabatan Struktural <span class="text-rose-500">*</span></label>
                    <input type="text" name="jabatan" x-model="editItem.jabatan" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Urutan Tampil <span class="text-rose-500">*</span></label>
                    <input type="number" name="urutan" x-model="editItem.urutan" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Ganti Pas Foto (Opsional)</label>
                    <input type="file" name="foto_file" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer bg-slate-50 border border-slate-200 rounded-xl">
                    <p class="text-[11px] text-slate-400 mt-1">Kosongkan jika tidak ingin mengganti foto yang sudah ada.</p>
                </div>

                <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-xs cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
