import os

def write_view(filename, content):
    path = os.path.join('resources/views/public/pages', filename)
    with open(path, 'w', encoding='utf-8') as f:
        f.write(content)

# 1. Halaman Statis (sejarah, visi-misi, kurikulum, osis)
statis_template = """@extends('layouts.public')
@section('title', $halaman->judul ?? 'Halaman')

@section('content')
<div class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(isset($halaman->gambar_banner) && $halaman->gambar_banner)
            <img src="{{ $halaman->gambar_banner }}" alt="{{ $halaman->judul }}" class="w-full h-64 md:h-96 object-cover rounded-xl shadow-lg mb-8">
        @endif
        <h1 class="text-4xl font-extrabold text-slate-900 mb-6 relative inline-block">
            {{ $halaman->judul ?? 'Halaman' }}
            <span class="absolute bottom-0 left-0 w-1/2 h-1 bg-[{{ $sekolah['warna_tema'] ?? '#4F46E5' }}] rounded-full"></span>
        </h1>
        
        <div class="prose prose-slate prose-lg max-w-none text-slate-700 leading-relaxed">
            {!! $halaman->isi_konten ?? '<p>Konten belum tersedia.</p>' !!}
        </div>
    </div>
</div>
@endsection
"""
write_view('sejarah.blade.php', statis_template)
write_view('visi-misi.blade.php', statis_template)
write_view('kurikulum.blade.php', statis_template)
write_view('osis.blade.php', statis_template)

# 2. Struktur Organisasi
struktur = """@extends('layouts.public')
@section('title', 'Struktur Organisasi')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-extrabold text-slate-900 mb-2">Struktur Organisasi</h1>
        <p class="text-lg text-slate-600 mb-12 max-w-2xl mx-auto">Susunan pimpinan dan staf pengajar {{ $sekolah['nama'] ?? 'Sekolah' }}</p>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($struktur as $s)
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-shadow duration-300 border border-slate-100 flex flex-col items-center">
                <div class="w-32 h-32 rounded-full overflow-hidden mb-4 border-4 border-slate-50 shadow-inner">
                    <img src="{{ $s->foto ?? 'https://ui-avatars.com/api/?name='.urlencode($s->nama_lengkap).'&background=random' }}" alt="{{ $s->nama_lengkap }}" class="w-full h-full object-cover">
                </div>
                <h3 class="text-xl font-bold text-slate-800 text-center">{{ $s->nama_lengkap }}</h3>
                <p class="text-sm font-medium text-[{{ $sekolah['warna_tema'] ?? '#4F46E5' }}] uppercase tracking-wider mt-2">{{ $s->jabatan }}</p>
            </div>
            @empty
            <div class="col-span-full py-12 text-slate-500">Belum ada data struktur organisasi.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
"""
write_view('struktur.blade.php', struktur)

# 3. Guru
guru = """@extends('layouts.public')
@section('title', 'Guru & Staf')

@section('content')
<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-slate-900 mb-4 relative inline-block">Tenaga Pendidik & Kependidikan</h1>
            <div class="w-24 h-1 bg-[{{ $sekolah['warna_tema'] ?? '#4F46E5' }}] rounded-full mx-auto"></div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($guru as $g)
            <div class="bg-slate-50 rounded-xl overflow-hidden hover:shadow-md transition-shadow group">
                <div class="aspect-square overflow-hidden bg-slate-200">
                    <img src="{{ $g->foto ?? 'https://ui-avatars.com/api/?name='.urlencode($g->nama_lengkap).'&background=random' }}" alt="{{ $g->nama_lengkap }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5 text-center">
                    <h3 class="font-bold text-slate-800 text-lg line-clamp-1" title="{{ $g->nama_lengkap }}">{{ $g->nama_lengkap }}</h3>
                    <p class="text-slate-500 text-sm mt-1">{{ $g->jabatan }}</p>
                    @if($g->mata_pelajaran)
                    <p class="text-xs font-semibold mt-3 px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full inline-block">{{ $g->mata_pelajaran }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-slate-500 text-center">Belum ada data guru.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
"""
write_view('guru.blade.php', guru)

# 4. Jurusan
jurusan = """@extends('layouts.public')
@section('title', 'Program Keahlian')

@section('content')
<div class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-extrabold text-slate-900">Program Keahlian</h1>
            <p class="mt-4 text-xl text-slate-600 max-w-2xl mx-auto">Pilihan jurusan terbaik untuk masa depan gemilang di {{ $sekolah['nama'] ?? 'Sekolah' }}</p>
        </div>
        
        <div class="space-y-12">
            @forelse($jurusan as $j)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col md:flex-row group">
                <div class="w-full md:w-1/3 bg-slate-100 flex items-center justify-center p-12 text-6xl group-hover:bg-[{{ $sekolah['warna_tema'] ?? '#4F46E5' }}] group-hover:text-white transition-colors duration-500">
                    {{ $j->ikon_atau_foto ?? '🎓' }}
                </div>
                <div class="w-full md:w-2/3 p-8 lg:p-12 flex flex-col justify-center">
                    <div class="flex items-center space-x-3 mb-4">
                        <h2 class="text-3xl font-bold text-slate-800">{{ $j->nama_jurusan }}</h2>
                        @if($j->singkatan)
                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg font-bold text-sm">{{ $j->singkatan }}</span>
                        @endif
                    </div>
                    <p class="text-lg text-slate-600 mb-6">{{ $j->deskripsi_singkat }}</p>
                    <div class="prose prose-slate max-w-none text-slate-700">
                        {!! $j->deskripsi_lengkap !!}
                    </div>
                </div>
            </div>
            @empty
            <div class="py-12 text-slate-500 text-center">Belum ada data jurusan.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
"""
write_view('jurusan.blade.php', jurusan)

# 5. Fasilitas
fasilitas = """@extends('layouts.public')
@section('title', 'Fasilitas')

@section('content')
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-extrabold text-slate-900 mb-4">Fasilitas Sekolah</h1>
            <div class="w-24 h-1 bg-[{{ $sekolah['warna_tema'] ?? '#4F46E5' }}] rounded-full mx-auto"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($fasilitas as $f)
            <div class="group rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300">
                <div class="aspect-w-16 aspect-h-10 overflow-hidden relative">
                    <img src="{{ $f->foto_utama }}" alt="{{ $f->nama_fasilitas }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-6 w-full">
                        <h3 class="text-2xl font-bold text-white mb-2">{{ $f->nama_fasilitas }}</h3>
                    </div>
                </div>
                <div class="p-6 bg-white">
                    <p class="text-slate-600 leading-relaxed">{{ $f->deskripsi }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-slate-500 text-center">Belum ada data fasilitas.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
"""
write_view('fasilitas.blade.php', fasilitas)

# 6. Ekstrakurikuler
ekstrakurikuler = """@extends('layouts.public')
@section('title', 'Ekstrakurikuler')

@section('content')
<div class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-extrabold text-slate-900 mb-4">Kegiatan Ekstrakurikuler</h1>
            <p class="text-lg text-slate-600">Kembangkan minat dan bakatmu melalui berbagai ekstrakurikuler di {{ $sekolah['nama'] ?? 'Sekolah' }}</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($ekskul as $e)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow flex flex-col sm:flex-row h-full border border-slate-100">
                @if($e->foto_utama)
                <div class="w-full sm:w-2/5 h-48 sm:h-auto">
                    <img src="{{ $e->foto_utama }}" alt="{{ $e->nama_ekskul }}" class="w-full h-full object-cover">
                </div>
                @endif
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-2">{{ $e->nama_ekskul }}</h3>
                        <p class="text-slate-600 mb-4 line-clamp-2">{{ $e->deskripsi_singkat }}</p>
                    </div>
                    <div class="space-y-2 mt-4 text-sm text-slate-500 border-t border-slate-100 pt-4">
                        @if($e->nama_pembina)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Pembina: {{ $e->nama_pembina }}
                        </div>
                        @endif
                        @if($e->jadwal_kegiatan)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Jadwal: {{ $e->jadwal_kegiatan }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-slate-500 text-center">Belum ada data ekstrakurikuler.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
"""
write_view('ekstrakurikuler.blade.php', ekstrakurikuler)

# 7. Prestasi
prestasi = """@extends('layouts.public')
@section('title', 'Prestasi Sekolah')

@section('content')
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 border-b border-slate-200 pb-6">
            <div>
                <h1 class="text-4xl font-extrabold text-slate-900 mb-2">Prestasi Gemilang</h1>
                <p class="text-slate-600 text-lg">Kebanggaan {{ $sekolah['nama'] ?? 'Sekolah' }}</p>
            </div>
            <div class="hidden md:block">
                <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100 text-yellow-500">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"></path></svg>
                </span>
            </div>
        </div>
        
        <div class="space-y-8">
            @forelse($prestasi as $p)
            <div class="flex flex-col md:flex-row bg-slate-50 rounded-2xl overflow-hidden shadow-sm hover:shadow-md border border-slate-100 transition-all">
                @if($p->foto_dokumentasi)
                <div class="w-full md:w-1/3 h-64 md:h-auto">
                    <img src="{{ $p->foto_dokumentasi }}" alt="{{ $p->nama_penghargaan }}" class="w-full h-full object-cover">
                </div>
                @endif
                <div class="w-full md:w-2/3 p-6 md:p-8 flex flex-col justify-center">
                    <div class="flex flex-wrap items-center gap-3 mb-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                            @if($p->tingkat == 'Nasional' || $p->tingkat == 'Internasional') bg-yellow-100 text-yellow-800 
                            @elseif($p->tingkat == 'Provinsi') bg-blue-100 text-blue-800
                            @else bg-slate-200 text-slate-700 @endif
                        ">Tingkat {{ $p->tingkat }}</span>
                        @if($p->tgl_perolehan)
                        <span class="text-sm text-slate-500 font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ \Carbon\Carbon::parse($p->tgl_perolehan)->translatedFormat('d F Y') }}
                        </span>
                        @endif
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2">{{ $p->nama_penghargaan }}</h3>
                    <p class="text-lg font-medium text-slate-700 mb-4">Oleh: {{ $p->peraih_prestasi }}</p>
                    <p class="text-slate-600">{{ $p->deskripsi }}</p>
                </div>
            </div>
            @empty
            <div class="py-12 text-slate-500 text-center">Belum ada data prestasi.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
"""
write_view('prestasi.blade.php', prestasi)

# 8. Berita
berita = """@extends('layouts.public')
@section('title', 'Berita')

@section('content')
<div class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-extrabold text-slate-900 mb-12">Berita Terbaru</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($berita as $b)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <a href="#" class="block h-56 overflow-hidden relative group">
                    <img src="{{ $b->gambar_sampul ?? 'https://images.unsplash.com/photo-1546410531-ea4cea477149?q=80&w=800&auto=format&fit=crop' }}" alt="{{ $b->judul }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                </a>
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-center text-sm text-slate-500 mb-3">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($b->tgl_publikasi)->translatedFormat('d M Y') }}
                    </div>
                    <a href="#" class="block mt-2 mb-4 group">
                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-[{{ $sekolah['warna_tema'] ?? '#4F46E5' }}] transition-colors line-clamp-2">{{ $b->judul }}</h3>
                    </a>
                    <p class="text-slate-600 line-clamp-3 mb-6">{{ $b->ringkasan ?? strip_tags($b->isi_konten) }}</p>
                    
                    <div class="mt-auto pt-4 border-t border-slate-100">
                        <a href="#" class="inline-flex items-center text-[{{ $sekolah['warna_tema'] ?? '#4F46E5' }}] font-medium hover:underline">
                            Baca selengkapnya
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-slate-500 text-center">Belum ada berita.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
"""
write_view('berita.blade.php', berita)
write_view('pengumuman.blade.php', berita.replace('Berita', 'Pengumuman').replace('$berita', '$pengumuman').replace('$b->', '$p->').replace('sebagai_pengumuman', 'Pengumuman'))

# 9. Kalender Akademik & Agenda
kalender = """@extends('layouts.public')
@section('title', 'Agenda & Kalender Akademik')

@section('content')
<div class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-extrabold text-slate-900 mb-12 text-center">Agenda Sekolah</h1>
        
        <div class="relative border-l-4 border-slate-200 ml-4 md:ml-6 space-y-12">
            @forelse($kalender ?? $agenda as $item)
            <div class="relative pl-8 md:pl-10">
                <div class="absolute -left-[14px] top-1 w-6 h-6 rounded-full bg-white border-4 border-[{{ $sekolah['warna_tema'] ?? '#4F46E5' }}]"></div>
                <div class="bg-slate-50 rounded-2xl p-6 shadow-sm border border-slate-100">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-2">
                        <h3 class="text-xl font-bold text-slate-900">{{ $item->nama_kegiatan }}</h3>
                        <span class="inline-flex items-center mt-2 md:mt-0 px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 font-semibold text-sm">
                            {{ \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('d M Y') }}
                            @if($item->tgl_selesai && $item->tgl_selesai != $item->tgl_mulai)
                                - {{ \Carbon\Carbon::parse($item->tgl_selesai)->translatedFormat('d M Y') }}
                            @endif
                        </span>
                    </div>
                    @if($item->keterangan)
                    <p class="text-slate-600 mt-3">{{ $item->keterangan }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="py-12 text-slate-500 pl-8">Belum ada agenda terdaftar.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
"""
write_view('kalender.blade.php', kalender)
write_view('agenda.blade.php', kalender)

# 10. Galeri
galeri = """@extends('layouts.public')
@section('title', 'Galeri')

@section('content')
<div class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-extrabold text-slate-900 mb-12 text-center">Galeri Sekolah</h1>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($album as $a)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group cursor-pointer">
                <div class="aspect-w-4 aspect-h-3 relative overflow-hidden h-64">
                    <img src="{{ $a->cover_album ?? 'https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?q=80&w=800&auto=format&fit=crop' }}" alt="{{ $a->nama_album }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-6 w-full flex justify-between items-end">
                        <div>
                            <h3 class="text-2xl font-bold text-white leading-tight mb-1">{{ $a->nama_album }}</h3>
                            <p class="text-slate-300 text-sm flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $a->tipe == 'video' ? 'Video' : 'Foto' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-slate-500 text-center">Belum ada album galeri.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
"""
write_view('galeri.blade.php', galeri)

print("Views written successfully.")
