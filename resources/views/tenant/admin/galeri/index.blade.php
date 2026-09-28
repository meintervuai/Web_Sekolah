@extends('layouts.tenant_admin')

@section('title', 'Galeri Foto & Album')
@section('header_title', 'Kelola Album & Dokumentasi')

@section('content')
<div class="max-w-6xl space-y-8">

    <!-- Buat Album Baru & Daftar Album -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-base font-bold text-slate-900">Album Galeri Kegiatan</h3>
            <p class="text-xs text-slate-500 mt-0.5">Kelola album foto dan dokumentasi kegiatan sekolah yang tampil pada navigasi publik Galeri.</p>
        </div>

        <div class="p-6 sm:p-8 space-y-6">
            <!-- Form Tambah Album Baru -->
            <form action="{{ route('tenant.admin.galeri.album.store', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-5 bg-slate-50 border border-slate-200 rounded-2xl space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 items-end">
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Album Baru <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_album" placeholder="Contoh: Upacara Hari Kemerdekaan RI" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Tipe Album</label>
                        <select name="tipe" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs">
                            <option value="foto">Foto Dokumentasi</option>
                            <option value="video">Video Kegiatan</option>
                        </select>
                    </div>
                    <div class="lg:col-span-3">
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Singkat Album</label>
                        <input type="text" name="deskripsi" placeholder="Deskripsi kilas kegiatan..." class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs">
                    </div>
                </div>

                <div>
                    <x-admin.input-gambar 
                        name="cover_album" 
                        label="Cover Sampul Album" 
                        recommended="Format JPG, PNG, atau WebP. Maks 2MB. Rekomendasi 1200x800px." 
                        :required="true" 
                    />
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-5 py-2.5 bg-blue-700 hover:bg-blue-600 text-white font-semibold text-xs rounded-xl transition shadow-xs cursor-pointer">
                        + Buat Album
                    </button>
                </div>
            </form>

            <!-- Grid Album Yang Sudah Ada -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($albums as $album)
                <div class="border border-slate-200 rounded-xl overflow-hidden bg-white flex flex-col justify-between shadow-2xs hover:shadow-sm transition">
                    <div class="relative h-36 bg-slate-100">
                        @if($album->cover_album)
                        <img src="{{ $album->cover_album }}" alt="{{ $album->nama_album }}" class="w-full h-full object-cover">
                        @endif
                        <span class="absolute top-2 right-2 px-2.5 py-0.5 rounded-full bg-slate-900/80 backdrop-blur-xs text-white text-[10px] font-bold uppercase tracking-wider">
                            {{ $album->items_count }} Foto
                        </span>
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="font-bold text-slate-800 text-xs leading-snug">{{ $album->nama_album }}</div>
                            <div class="text-[11px] text-slate-500 line-clamp-2 mt-1">{{ $album->deskripsi ?? 'Tanpa deskripsi' }}</div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[10px] text-slate-500 uppercase font-bold tracking-wider bg-slate-100 px-2 py-0.5 rounded">{{ $album->tipe }}</span>
                            <form action="{{ route('tenant.admin.galeri.album.destroy', ['tenant' => $tenant->slug, 'id' => $album->id]) }}" method="POST" onsubmit="return confirm('Hapus album ini beserta seluruh foto di dalamnya?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-semibold text-rose-600 hover:text-white bg-rose-50 hover:bg-rose-600 transition cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus Album
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 py-6 text-center text-slate-400 text-xs">Belum ada album galeri yang dibuat.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Tambah Foto / Media ke Album -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-base font-bold text-slate-900">Upload Foto Dokumentasi Baru</h3>
            <p class="text-xs text-slate-500 mt-0.5">Masukkan foto kegiatan baru ke dalam salah satu album yang sudah tersedia.</p>
        </div>

        <div class="p-6 sm:p-8 space-y-6">
            <form action="{{ route('tenant.admin.galeri.item.store', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-5 bg-slate-50 border border-slate-200 rounded-2xl space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Album Target <span class="text-rose-500">*</span></label>
                        <select name="album_id" required class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium text-slate-800">
                            <option value="">-- Pilih Album --</option>
                            @foreach($albums as $alb)
                            <option value="{{ $alb->id }}">{{ $alb->nama_album }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Keterangan / Caption Foto <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul_item" placeholder="Contoh: Sesi penyerahan medali kejuaraan" required class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium text-slate-800">
                    </div>
                </div>

                <div>
                    <x-admin.input-gambar 
                        name="file_media_atau_link" 
                        label="File Foto Dokumentasi" 
                        recommended="Format JPG, PNG, atau WebP. Maks 3MB. Rekomendasi 1600x1000px." 
                        :required="true" 
                    />
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-5 py-2.5 bg-blue-700 hover:bg-blue-600 text-white font-semibold text-xs rounded-xl transition shadow-xs cursor-pointer">
                        + Tambahkan Foto ke Album
                    </button>
                </div>
            </form>

            <!-- Foto Terbaru dengan Card Proper, Jelas, & Kontras Tinggi -->
            <div class="pt-2">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        Foto Dokumentasi Terbaru
                    </h4>
                    <span class="text-xs text-slate-400">Total {{ $recentItems->count() }} foto ditampilkan</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse($recentItems as $foto)
                    <div class="rounded-xl overflow-hidden border border-slate-200/90 bg-white shadow-2xs hover:shadow-sm transition flex flex-col justify-between">
                        <!-- Gambar Area -->
                        <div class="relative aspect-video bg-slate-100 overflow-hidden">
                            <img src="{{ $foto->file_media_atau_link }}" alt="{{ $foto->judul_item }}" class="w-full h-full object-cover">
                            @if($foto->album)
                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md bg-slate-900/80 backdrop-blur-xs text-white text-[10px] font-semibold line-clamp-1 max-w-[80%]">
                                {{ $foto->album->nama_album }}
                            </span>
                            @endif
                        </div>

                        <!-- Info & Tombol Aksi di Bawah Gambar (Tidak Ditumpuk) -->
                        <div class="p-3 bg-white flex flex-col justify-between gap-2.5 flex-1">
                            <div class="text-xs text-slate-800 font-semibold line-clamp-2 leading-snug" title="{{ $foto->judul_item }}">
                                {{ $foto->judul_item }}
                            </div>
                            <div class="pt-2 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-[10px] text-slate-400">
                                    {{ $foto->created_at ? $foto->created_at->format('d M Y') : '' }}
                                </span>
                                <form action="{{ route('tenant.admin.galeri.item.destroy', ['tenant' => $tenant->slug, 'id' => $foto->id]) }}" method="POST" onsubmit="return confirm('Hapus foto \'{{ addslashes($foto->judul_item) }}\'?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[11px] font-bold text-rose-600 hover:text-white bg-rose-50 hover:bg-rose-600 border border-rose-200 hover:border-rose-600 transition shadow-2xs cursor-pointer">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus Foto
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-4 text-center py-8 text-slate-400 text-xs bg-slate-50 rounded-xl border border-dashed border-slate-200">
                        Belum ada foto dokumentasi yang diupload ke album.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
