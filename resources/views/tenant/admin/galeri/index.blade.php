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

    <!-- Tambah Media (Foto / Video) ke Album -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden" x-data="{ mediaType: 'foto', viewMode: 'grid' }">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Upload Media (Foto / Video) ke Album</h3>
                <p class="text-xs text-slate-500 mt-0.5">Unggah foto atau sematkan video kegiatan ke dalam album yang telah dibuat.</p>
            </div>

            <!-- List vs Grid View Toggle -->
            <div class="flex items-center gap-1 bg-slate-200/80 p-1 rounded-xl self-start sm:self-auto">
                <button 
                    type="button" 
                    @click="viewMode = 'grid'" 
                    :class="viewMode === 'grid' ? 'bg-white text-blue-700 shadow-xs' : 'text-slate-600 hover:text-slate-900'" 
                    class="p-1.5 rounded-lg transition" 
                    title="Tampilan Grid Kartu"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                </button>
                <button 
                    type="button" 
                    @click="viewMode = 'list'" 
                    :class="viewMode === 'list' ? 'bg-white text-blue-700 shadow-xs' : 'text-slate-600 hover:text-slate-900'" 
                    class="p-1.5 rounded-lg transition" 
                    title="Tampilan Tabel Rinci"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        <div class="p-6 sm:p-8 space-y-6">
            <form action="{{ route('tenant.admin.galeri.item.store', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-5 bg-slate-50 border border-slate-200 rounded-2xl space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Album Target <span class="text-rose-500">*</span></label>
                        <select name="album_id" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-medium text-slate-800">
                            <option value="">-- Pilih Album --</option>
                            @foreach($albums as $alb)
                            <option value="{{ $alb->id }}">{{ $alb->nama_album }} ({{ ucfirst($alb->tipe) }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Keterangan / Caption Media <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul_item" placeholder="Contoh: Sesi penyerahan medali kejuaraan atau demo robotika" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-medium text-slate-800">
                    </div>
                </div>

                <!-- Tipe Upload: Foto atau Video -->
                <div class="space-y-3">
                    <div class="flex items-center gap-4 text-xs font-bold text-slate-700">
                        <span>Pilihan Berkas Media:</span>
                        <label class="inline-flex items-center gap-1.5 cursor-pointer">
                            <input type="radio" name="media_tab" value="foto" x-model="mediaType" class="text-blue-600 focus:ring-blue-500">
                            <span>Foto (JPG/PNG/WebP)</span>
                        </label>
                        <label class="inline-flex items-center gap-1.5 cursor-pointer">
                            <input type="radio" name="media_tab" value="video" x-model="mediaType" class="text-blue-600 focus:ring-blue-500">
                            <span>Video (MP4 / Link YouTube)</span>
                        </label>
                    </div>

                    <!-- Input Foto -->
                    <div x-show="mediaType === 'foto'">
                        <x-admin.input-gambar 
                            name="file_media_atau_link" 
                            label="File Foto Dokumentasi" 
                            recommended="Format JPG, PNG, atau WebP. Maks 3MB. Rekomendasi 1600x1000px." 
                            :required="false" 
                        />
                    </div>

                    <!-- Input Video -->
                    <div x-show="mediaType === 'video'" x-cloak class="p-4 bg-white rounded-xl border border-slate-200 space-y-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-700 mb-1">1. Tautan URL Video (YouTube / Vimeo / Direct URL)</label>
                            <input type="url" name="file_media_atau_link" placeholder="https://www.youtube.com/watch?v=..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="h-px bg-slate-200 flex-1"></div>
                            <span class="text-[10px] font-bold text-slate-400">ATAU UPLOAD BERKAS VIDEO</span>
                            <div class="h-px bg-slate-200 flex-1"></div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-700 mb-1">2. Upload Berkas Video (MP4 / WebM / MOV)</label>
                            <input type="file" name="file_media_atau_link_file" accept="video/mp4,video/webm,video/quicktime" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <span class="text-[10px] text-slate-400 mt-1 block">Maksimal 30MB.</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-5 py-2.5 bg-blue-700 hover:bg-blue-600 text-white font-semibold text-xs rounded-xl transition shadow-xs cursor-pointer inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambahkan Media ke Album</span>
                    </button>
                </div>
            </form>

            <!-- Media Terbaru (Grid & List Mode) -->
            <div class="pt-2">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        Media Dokumentasi Terbaru
                    </h4>
                    <span class="text-xs text-slate-400">Total {{ $recentItems->count() }} media</span>
                </div>

                <!-- Tampilan 1: Grid Mode -->
                <div x-show="viewMode === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse($recentItems as $foto)
                    <div class="rounded-xl overflow-hidden border border-slate-200/90 bg-white shadow-2xs hover:shadow-sm transition flex flex-col justify-between">
                        <!-- Media Area (Image or Video) -->
                        <div class="relative aspect-video bg-slate-900 overflow-hidden flex items-center justify-center">
                            @php
                                $mediaUrl = $foto->file_media_atau_link;
                                $isVideoUrl = Str::contains($mediaUrl, ['youtube.com', 'youtu.be', '.mp4', '.webm', '.mov']);
                            @endphp

                            @if($isVideoUrl)
                                @if(Str::contains($mediaUrl, ['.mp4', '.webm', '.mov']))
                                    <video src="{{ $mediaUrl }}" class="w-full h-full object-cover" muted></video>
                                    <span class="absolute inset-0 flex items-center justify-center bg-black/30 pointer-events-none">
                                        <span class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center shadow">
                                            <svg class="w-4 h-4 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </span>
                                    </span>
                                @else
                                    <div class="w-full h-full bg-slate-950 flex flex-col items-center justify-center p-3 text-center">
                                        <svg class="w-8 h-8 text-rose-500 mb-1" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                        <span class="text-[10px] text-slate-300 font-mono line-clamp-1">{{ $mediaUrl }}</span>
                                    </div>
                                @endif
                            @else
                                <img src="{{ $mediaUrl }}" alt="{{ $foto->judul_item }}" class="w-full h-full object-cover">
                            @endif

                            @if($foto->album)
                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md bg-slate-900/80 backdrop-blur-xs text-white text-[10px] font-semibold line-clamp-1 max-w-[80%]">
                                {{ $foto->album->nama_album }}
                            </span>
                            @endif
                        </div>

                        <!-- Info & Tombol Aksi -->
                        <div class="p-3 bg-white flex flex-col justify-between gap-2.5 flex-1">
                            <div class="text-xs text-slate-800 font-semibold line-clamp-2 leading-snug" title="{{ $foto->judul_item }}">
                                {{ $foto->judul_item }}
                            </div>
                            <div class="pt-2 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-[10px] text-slate-400">
                                    {{ $foto->created_at ? $foto->created_at->format('d M Y') : '' }}
                                </span>
                                <form action="{{ route('tenant.admin.galeri.item.destroy', ['tenant' => $tenant->slug, 'id' => $foto->id]) }}" method="POST" onsubmit="return confirm('Hapus media \'{{ addslashes($foto->judul_item) }}\'?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[11px] font-bold text-rose-600 hover:text-white bg-rose-50 hover:bg-rose-600 border border-rose-200 hover:border-rose-600 transition shadow-2xs cursor-pointer">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-4 text-center py-8 text-slate-400 text-xs bg-slate-50 rounded-xl border border-dashed border-slate-200">
                        Belum ada media dokumentasi yang diunggah ke album.
                    </div>
                    @endforelse
                </div>

                <!-- Tampilan 2: List Mode (Tabel Menarik & Jelas) -->
                <div x-show="viewMode === 'list'" x-cloak class="border border-slate-200 rounded-xl overflow-hidden bg-white shadow-2xs">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50/80 text-slate-600 font-bold uppercase text-[10px] tracking-wider">
                                <th class="py-3 px-4">Preview</th>
                                <th class="py-3 px-4">Judul / Keterangan</th>
                                <th class="py-3 px-4">Album</th>
                                <th class="py-3 px-4">Tautan Berkas</th>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentItems as $foto)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-2.5 px-4 w-16">
                                    <div class="w-12 h-9 rounded-lg overflow-hidden bg-slate-900 border border-slate-200 flex items-center justify-center">
                                        @if(Str::contains($foto->file_media_atau_link, ['.mp4', '.webm', '.mov', 'youtube.com', 'youtu.be']))
                                            <svg class="w-5 h-5 text-rose-500" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        @else
                                            <img src="{{ $foto->file_media_atau_link }}" alt="{{ $foto->judul_item }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                </td>
                                <td class="py-2.5 px-4 font-semibold text-slate-900">{{ $foto->judul_item }}</td>
                                <td class="py-2.5 px-4 text-slate-600">
                                    <span class="px-2 py-0.5 rounded bg-slate-100 font-medium text-slate-700">
                                        {{ $foto->album->nama_album ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-2.5 px-4 font-mono text-[11px] text-blue-700 max-w-xs truncate">
                                    <a href="{{ $foto->file_media_atau_link }}" target="_blank" class="hover:underline">{{ $foto->file_media_atau_link }}</a>
                                </td>
                                <td class="py-2.5 px-4 text-slate-400 whitespace-nowrap">{{ $foto->created_at ? $foto->created_at->format('d M Y') : '-' }}</td>
                                <td class="py-2.5 px-4 text-right whitespace-nowrap">
                                    <form action="{{ route('tenant.admin.galeri.item.destroy', ['tenant' => $tenant->slug, 'id' => $foto->id]) }}" method="POST" onsubmit="return confirm('Hapus media ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-rose-600 hover:text-white hover:bg-rose-600 rounded-lg transition" title="Hapus Media">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-slate-400 text-xs">Belum ada media dokumentasi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
