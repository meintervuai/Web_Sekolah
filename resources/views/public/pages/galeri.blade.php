@extends('layouts.public')
@section('title', 'Galeri')

@section('content')
<div class="py-6 md:py-16 bg-slate-50" x-data="{ lightboxOpen: false, currentImage: '', currentTitle: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl md:text-4xl font-extrabold text-slate-900 mb-6 md:mb-12 text-center">Galeri Sekolah</h1>
        
        <div class="flex overflow-x-auto pb-6 -mx-4 px-4 snap-x snap-mandatory hide-scrollbar md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-8 md:overflow-visible md:pb-0 md:mx-0 md:px-0">
            @forelse($album as $a)
            <div class="flex-none w-52 md:w-auto snap-center mr-4 md:mr-0 h-full">
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group cursor-pointer transform hover:-translate-y-2 h-full" @click="lightboxOpen = true; currentImage = '{{ $a->cover_album ?? 'https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?q=80&w=800&auto=format&fit=crop' }}'; currentTitle = '{{ $a->nama_album }}'">
                <div class="aspect-video w-full relative overflow-hidden">
                    <img src="{{ $a->cover_album ?? 'https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?q=80&w=800&auto=format&fit=crop' }}" alt="{{ $a->nama_album }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-0 left-0 p-3 md:p-6 w-full flex justify-between items-end">
                        <div>
                            <h3 class="text-base md:text-2xl font-bold text-white leading-tight mb-1">{{ $a->nama_album }}</h3>
                            <p class="text-slate-300 text-[10px] md:text-sm flex items-center">
                                <svg class="w-3.5 h-3.5 md:w-4 md:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $a->tipe == 'video' ? 'Video' : 'Foto' }}
                            </p>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-slate-500 text-center">Belum ada album galeri.</div>
            @endforelse
        </div>
        
        <!-- Lightbox Modal -->
        <div x-show="lightboxOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 backdrop-blur-sm" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <button @click="lightboxOpen = false" class="absolute top-6 right-6 text-white/70 hover:text-white focus:outline-none transition-colors">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="max-w-5xl w-full px-4 transform transition-all" @click.away="lightboxOpen = false" x-show="lightboxOpen" x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                <img :src="currentImage" :alt="currentTitle" class="w-full h-auto max-h-[85vh] object-contain mx-auto rounded-xl shadow-2xl ring-1 ring-white/10">
                <h3 x-text="currentTitle" class="text-white text-2xl font-heading font-bold mt-6 text-center drop-shadow-md"></h3>
            </div>
        </div>
    </div>
</div>
@endsection
