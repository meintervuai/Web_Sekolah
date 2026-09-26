@extends('layouts.public')

@section('title', 'Berita & Informasi - ' . $sekolah['nama'])
@section('meta_description', 'Kumpulan berita terkini, aktivitas sekolah, prestasi, dan agenda kegiatan resmi di ' . $sekolah['nama'])

@section('content')
<!-- Header & Breadcrumb -->
<section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium">Berita & Informasi</li>
            </ol>
        </nav>
        <div class="max-w-2xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3">
                Kabar Sekolah Terkini
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed">
                Dapatkan informasi resmi seputar kegiatan belajar mengajar, pencapaian siswa, inovasi kejuruan, dan agenda di {{ $sekolah['nama'] }}.
            </p>
        </div>
    </div>
</section>

<!-- Filter & Search Bar Section -->
<section class="bg-white border-b border-slate-200/80 sticky top-16 z-30 shadow-xs">
    <div class="container-custom py-4">
        <form method="GET" action="{{ url(app('tenant')->slug . '/berita') }}" class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Category Pills -->
            <div class="flex items-center space-x-2 overflow-x-auto pb-1 md:pb-0 hide-scrollbar text-xs">
                <a href="{{ url(app('tenant')->slug . '/berita') }}" 
                   class="px-3.5 py-1.5 rounded-full font-medium transition whitespace-nowrap {{ !request('kategori') ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Semua Kategori
                </a>
                @foreach($kategoriList as $kat)
                <a href="{{ url(app('tenant')->slug . '/berita?kategori=' . $kat->slug . (request('q') ? '&q=' . request('q') : '')) }}" 
                   class="px-3.5 py-1.5 rounded-full font-medium transition whitespace-nowrap {{ request('kategori') === $kat->slug ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    {{ $kat->nama_kategori }} ({{ $kat->artikels_count }})
                </a>
                @endforeach
            </div>

            <!-- Search Input -->
            <div class="relative w-full md:w-72 shrink-0">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul atau topik..." 
                       class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs md:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
            </div>
        </form>
    </div>
</section>

<!-- Berita List Section -->
<section class="section-py bg-slate-50">
    <div class="container-custom">
        
        @if(request('q') || request('kategori'))
        <div class="mb-6 flex items-center justify-between">
            <p class="text-xs md:text-sm text-slate-600">
                Menampilkan hasil untuk: 
                @if(request('q')) <strong class="text-slate-900">"{{ request('q') }}"</strong> @endif
                @if(request('kategori')) (Kategori: <strong class="text-slate-900">{{ request('kategori') }}</strong>) @endif
            </p>
            <a href="{{ url(app('tenant')->slug . '/berita') }}" class="text-xs text-blue-600 hover:underline">Reset Filter</a>
        </div>
        @endif

        <!-- News Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @forelse($berita as $item)
            <article class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-xs hover:shadow-md transition duration-200 flex flex-col h-full group">
                <!-- Image Ratio 16:9 -->
                <a href="{{ url(app('tenant')->slug . '/berita/' . $item->slug) }}" class="block aspect-video w-full overflow-hidden bg-slate-100 relative">
                    <img src="{{ $item->gambar_sampul ?? 'https://images.unsplash.com/photo-1546410531-ea4cea477149?q=80&w=800&auto=format&fit=crop' }}" 
                         alt="{{ $item->judul }}" 
                         loading="lazy"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @if($item->kategori)
                    <span class="absolute top-3 left-3 bg-blue-900/85 backdrop-blur-xs text-white text-[11px] font-semibold px-2.5 py-1 rounded-full">
                        {{ $item->kategori->nama_kategori }}
                    </span>
                    @endif
                </a>

                <div class="p-5 md:p-6 flex-1 flex flex-col">
                    <div class="flex items-center text-xs text-slate-400 mb-3 space-x-3">
                        <span class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ \Carbon\Carbon::parse($item->tgl_publikasi)->translatedFormat('d M Y') }}
                        </span>
                        <span>•</span>
                        <span class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            {{ $item->jumlah_dilihat ?? 0 }} dilihat
                        </span>
                    </div>

                    <h2 class="text-base md:text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-2 mb-2 font-heading">
                        <a href="{{ url(app('tenant')->slug . '/berita/' . $item->slug) }}">
                            {{ $item->judul }}
                        </a>
                    </h2>

                    <p class="text-xs md:text-sm text-slate-600 line-clamp-3 mb-4 leading-relaxed">
                        {{ $item->ringkasan ?? Str::limit(strip_tags($item->isi_konten), 120) }}
                    </p>

                    <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs text-slate-400">Oleh Humas SMKN 2</span>
                        <a href="{{ url(app('tenant')->slug . '/berita/' . $item->slug) }}" 
                           class="inline-flex items-center text-xs font-bold text-blue-600 group-hover:text-blue-700 transition">
                            <span>Baca Lengkap</span>
                            <svg class="w-3.5 h-3.5 ml-1 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-200/80 p-8">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-800 font-heading mb-1">Tidak Ada Berita Ditemukan</h3>
                <p class="text-xs md:text-sm text-slate-500 max-w-sm mx-auto mb-4">Tidak ada artikel yang cocok dengan kata kunci atau filter yang Anda pilih.</p>
                <a href="{{ url(app('tenant')->slug . '/berita') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 transition">
                    Lihat Semua Berita
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $berita->links() }}
        </div>

    </div>
</section>
@endsection
