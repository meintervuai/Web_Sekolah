@extends('layouts.public')

@section('title', 'Galeri Foto & Video - ' . $sekolah['nama'])
@section('meta_description', 'Dokumentasi visual foto dan video pembelajaran, fasilitas, upacara, dan kegiatan siswa di ' . $sekolah['nama'])

@section('content')
<!-- Header & Breadcrumb -->
<section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium">Galeri Sekolah</li>
            </ol>
        </nav>
        <div class="max-w-2xl">
            <div class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-sky-300 text-xs font-semibold mb-3">
                <span>🖼️ Dokumentasi Visual</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3">
                Galeri Foto & Video
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed">
                Merekam setiap momen bersejarah, kreasi siswa vokasi, pameran karya, dan interaksi hangat di lingkungan {{ $sekolah['nama'] }}.
            </p>
        </div>
    </div>
</section>

<!-- Galeri Content Section -->
<section class="section-py bg-slate-50" x-data="{ activeAlbum: 'all' }">
    <div class="container-custom">
        
        <!-- Album Filter Pills -->
        <div class="flex items-center space-x-2 overflow-x-auto pb-4 mb-8 hide-scrollbar">
            <button @click="activeAlbum = 'all'" 
                    :class="activeAlbum === 'all' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'"
                    class="px-4 py-2 rounded-full text-xs font-semibold transition shrink-0">
                Semua Koleksi Foto
            </button>
            @foreach($album as $alb)
            <button @click="activeAlbum = '{{ $alb->id }}'" 
                    :class="activeAlbum === '{{ $alb->id }}' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'"
                    class="px-4 py-2 rounded-full text-xs font-semibold transition shrink-0">
                {{ $alb->nama_album }} ({{ $alb->items->count() }})
            </button>
            @endforeach
        </div>

        <!-- Photos Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @php $hasPhotos = false; @endphp
            @foreach($album as $alb)
                @foreach($alb->items as $item)
                @php $hasPhotos = true; @endphp
                <div x-show="activeAlbum === 'all' || activeAlbum === '{{ $alb->id }}'" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-xs hover:shadow-lg transition-all group flex flex-col cursor-pointer"
                     @click="lightboxOpen = true; lightboxSrc = '{{ $item->file_path }}'; lightboxCaption = '{{ addslashes($item->caption ?? $alb->nama_album) }}'">
                    
                    <div class="aspect-square w-full overflow-hidden bg-slate-100 relative">
                        <img src="{{ $item->file_path }}" 
                             alt="{{ $item->caption ?? $alb->nama_album }}" 
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-black/25 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="p-2.5 rounded-full bg-white/90 text-slate-900 shadow">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                            </span>
                        </div>
                    </div>

                    <div class="p-3 bg-white">
                        <p class="text-xs font-semibold text-slate-800 truncate">{{ $item->caption ?? $alb->nama_album }}</p>
                        <span class="text-[10px] text-slate-400 block">{{ $alb->nama_album }}</span>
                    </div>
                </div>
                @endforeach
            @endforeach

            @if(!$hasPhotos)
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-200 p-8">
                <p class="text-sm text-slate-500">Belum ada foto yang diunggah ke dalam galeri.</p>
            </div>
            @endif
        </div>

    </div>
</section>
@endsection
