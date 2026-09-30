@extends('layouts.public')

@section('title', 'Galeri Foto & Video - ' . $sekolah['nama'])
@section('meta_description', 'Dokumentasi visual foto dan video pembelajaran, fasilitas, upacara, dan kegiatan siswa di ' . $sekolah['nama'])

@section('content')
<!-- Header & Breadcrumb -->
<section class="theme-bg-dark text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(var(--theme-accent)_1px,transparent_1px)] [background-size:16px_16px]"></div>
    @if(!empty($gambarBanner ?? $banner ?? null))
        <!-- Right-Side Artistic Banner Image with Gradual Mask/Fade to Left & Theme Dark Overlay -->
        <div class="absolute inset-y-0 right-0 w-full md:w-3/5 lg:w-1/2 pointer-events-none z-0">
            <img src="{{ $gambarBanner ?? $banner }}" alt="Galeri Foto & Video" 
                 class="w-full h-full object-cover object-center opacity-40 lg:opacity-60 [mask-image:linear-gradient(to_left,rgba(0,0,0,1)_20%,rgba(0,0,0,0.6)_60%,transparent_100%)] [-webkit-mask-image:linear-gradient(to_left,rgba(0,0,0,1)_20%,rgba(0,0,0,0.6)_60%,transparent_100%)]">
            <div class="absolute inset-0 bg-gradient-to-r from-[var(--theme-header,#0f172a)] via-transparent to-transparent opacity-80"></div>
        </div>
    @endif
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition drop-shadow-xs">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium drop-shadow-xs">Galeri Sekolah</li>
            </ol>
        </nav>
        <div class="max-w-4xl lg:max-w-5xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3 drop-shadow-sm">
                Galeri Foto & Video
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed max-w-3xl drop-shadow-xs">
                Merekam setiap momen bersejarah, kreasi siswa vokasi, pameran karya, dan interaksi hangat di lingkungan {{ $sekolah['nama'] }}.
            </p>
        </div>
    </div>
</section>

<!-- Galeri Content Section -->
<section class="section-py bg-slate-50" x-data="{ 
    activeAlbum: 'all', 
    mediaFilter: 'all',
    lightboxOpen: false, 
    lightboxSrc: '', 
    lightboxCaption: '', 
    isVideo: false,
    openMedia(src, caption, video) {
        this.lightboxSrc = src;
        this.lightboxCaption = caption;
        this.isVideo = video;
        this.lightboxOpen = true;
    }
}">
    <div class="container-custom">
        
        <!-- Filter Controls: Filter Tipe Media & Album -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <!-- Filter Tipe Media (Semua, Foto, Video) -->
            <div class="inline-flex p-1 bg-slate-200/80 rounded-2xl text-xs font-semibold text-slate-700 self-start">
                <button @click="mediaFilter = 'all'" :class="mediaFilter === 'all' ? 'bg-white text-blue-700 shadow-xs' : 'hover:text-slate-900'" class="px-4 py-2 rounded-xl transition">
                    Semua Media
                </button>
                <button @click="mediaFilter = 'foto'" :class="mediaFilter === 'foto' ? 'bg-white text-blue-700 shadow-xs' : 'hover:text-slate-900'" class="px-4 py-2 rounded-xl transition">
                    Foto Dokumentasi
                </button>
                <button @click="mediaFilter = 'video'" :class="mediaFilter === 'video' ? 'bg-white text-blue-700 shadow-xs' : 'hover:text-slate-900'" class="px-4 py-2 rounded-xl transition">
                    Video Kegiatan
                </button>
            </div>

            <!-- Album Filter Pills -->
            <div class="flex items-center space-x-2 overflow-x-auto pb-1 max-w-full sm:max-w-xl hide-scrollbar">
                <button @click="activeAlbum = 'all'" 
                        :class="activeAlbum === 'all' ? 'bg-blue-700 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'"
                        class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition shrink-0">
                    Semua Album
                </button>
                @foreach($album as $alb)
                <button @click="activeAlbum = '{{ $alb->id }}'" 
                        :class="activeAlbum === '{{ $alb->id }}' ? 'bg-blue-700 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'"
                        class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition shrink-0">
                    {{ $alb->nama_album }} ({{ $alb->items->count() }})
                </button>
                @endforeach
            </div>
        </div>

        <!-- Media Grid (Foto & Video) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @php $hasItems = false; @endphp
            @foreach($album as $alb)
                @foreach($alb->items as $item)
                @php 
                    $hasItems = true;
                    $src = $item->file_media_atau_link ?? $item->file_path ?? '';
                    $isVideo = Str::contains($src, ['youtube.com', 'youtu.be', '.mp4', '.webm', '.mov']) || $alb->tipe === 'video';
                @endphp
                <div x-show="(activeAlbum === 'all' || activeAlbum === '{{ $alb->id }}') && (mediaFilter === 'all' || (mediaFilter === 'video' && {{ $isVideo ? 'true' : 'false' }}) || (mediaFilter === 'foto' && !{{ $isVideo ? 'true' : 'false' }}))" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-xs hover:shadow-lg transition-all group flex flex-col cursor-pointer"
                     @click="openMedia('{{ $src }}', '{{ addslashes($item->judul_item ?? $item->caption ?? $alb->nama_album) }}', {{ $isVideo ? 'true' : 'false' }})">
                    
                    <div class="aspect-square w-full overflow-hidden bg-slate-900 relative flex items-center justify-center">
                        @if($isVideo)
                            @if(Str::contains($src, ['.mp4', '.webm', '.mov']))
                                <video src="{{ $src }}" class="w-full h-full object-cover" muted></video>
                            @else
                                <div class="w-full h-full bg-slate-950 flex flex-col items-center justify-center p-3 text-center">
                                    <svg class="w-10 h-10 text-rose-500 mb-1" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                    <span class="text-[10px] text-slate-300 font-bold uppercase tracking-wider">Video YouTube</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-black/30 flex items-center justify-center group-hover:bg-black/50 transition-colors">
                                <span class="w-12 h-12 rounded-full bg-blue-600/90 text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </span>
                            </div>
                        @else
                            <img src="{{ $src }}" 
                                 alt="" 
                                 aria-hidden="true" 
                                 class="absolute inset-0 w-full h-full object-cover blur-md scale-125 opacity-40 pointer-events-none">
                            <img src="{{ $src }}" 
                                 alt="{{ $item->judul_item ?? $item->caption ?? $alb->nama_album }}" 
                                 loading="lazy"
                                 style="{{ \App\Services\MediaService::getCropStyle($src) }}"
                                 class="relative z-10 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute inset-0 z-20 bg-black/25 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                                <span class="p-2.5 rounded-full bg-white/90 text-slate-900 shadow">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="p-3 bg-white">
                        <div class="flex items-center gap-1.5 mb-1">
                            <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded {{ $isVideo ? 'bg-rose-50 text-rose-700' : 'bg-blue-50 text-blue-700' }}">
                                {{ $isVideo ? 'Video' : 'Foto' }}
                            </span>
                            <span class="text-[10px] text-slate-400 truncate">{{ $alb->nama_album }}</span>
                        </div>
                        <p class="text-xs font-semibold text-slate-800 truncate">{{ $item->judul_item ?? $item->caption ?? $alb->nama_album }}</p>
                    </div>
                </div>
                @endforeach
            @endforeach

            @if(!$hasItems)
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-200 p-8">
                <p class="text-sm text-slate-500">Belum ada foto atau video yang diunggah ke dalam galeri.</p>
            </div>
            @endif
        </div>

    </div>

    <!-- Lightbox Modal untuk Foto & Video -->
    <div 
        x-show="lightboxOpen" 
        x-cloak
        @keydown.escape.window="lightboxOpen = false" 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md"
    >
        <div class="relative w-full max-w-4xl bg-slate-900 rounded-3xl overflow-hidden shadow-2xl border border-slate-800" @click.away="lightboxOpen = false">
            <div class="flex items-center justify-between p-4 border-b border-slate-800 text-white">
                <h4 class="text-sm font-bold truncate pr-4" x-text="lightboxCaption"></h4>
                <button @click="lightboxOpen = false" class="p-1 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="aspect-video bg-black flex items-center justify-center">
                <template x-if="isVideo">
                    <div class="w-full h-full">
                        <template x-if="lightboxSrc.includes('youtube.com') || lightboxSrc.includes('youtu.be')">
                            <iframe :src="lightboxSrc.includes('embed') ? lightboxSrc : lightboxSrc.replace('watch?v=', 'embed/')" class="w-full h-full border-0" allowfullscreen></iframe>
                        </template>
                        <template x-if="!lightboxSrc.includes('youtube.com') && !lightboxSrc.includes('youtu.be')">
                            <video :src="lightboxSrc" controls autoplay class="w-full h-full object-contain"></video>
                        </template>
                    </div>
                </template>
                <template x-if="!isVideo">
                    <img :src="lightboxSrc" :alt="lightboxCaption" class="w-full h-full object-contain">
                </template>
            </div>
        </div>
    </div>
</section>
@endsection
