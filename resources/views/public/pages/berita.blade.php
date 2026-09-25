@extends('layouts.public')
@section('title', 'Berita')

@section('content')
<div class="py-6 md:py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl md:text-4xl font-extrabold text-slate-900 mb-6 md:mb-12">Berita Terbaru</h1>
        
        <div class="flex overflow-x-auto pb-6 -mx-4 px-4 snap-x snap-mandatory hide-scrollbar md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-8 md:overflow-visible md:pb-0 md:mx-0 md:px-0">
            @forelse($berita as $b)
                <div class="flex-none w-52 md:w-auto snap-center mr-4 md:mr-0 h-full">
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 border border-slate-100 flex flex-col h-full transform hover:-translate-y-2">
                <a href="{{ url(app('tenant')->slug . '/informasi/berita#' . ($b->slug ?? '')) }}" class="block aspect-video w-full overflow-hidden relative group">
                    <img src="{{ $b->gambar_sampul ?? 'https://images.unsplash.com/photo-1546410531-ea4cea477149?q=80&w=800&auto=format&fit=crop' }}" alt="{{ $b->judul }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                </a>
                <div class="p-3 md:p-6 flex-1 flex flex-col">
                    <div class="flex items-center text-[10px] md:text-sm text-slate-500 mb-2 md:mb-3">
                        <svg class="w-3.5 h-3.5 md:w-4 md:h-4 mr-1 md:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($b->tgl_publikasi)->translatedFormat('d M Y') }}
                    </div>
                    <a href="{{ url(app('tenant')->slug . '/informasi/berita#' . ($b->slug ?? '')) }}" class="block mt-1 md:mt-2 mb-2 md:mb-4 group">
                        <h3 class="text-base md:text-xl font-bold text-slate-900 group-hover:text-[{{ $sekolah['warna_tema'] ?? '#4F46E5' }}] transition-colors line-clamp-2">{{ $b->judul }}</h3>
                    </a>
                    <p class="text-xs md:text-base text-slate-600 line-clamp-3 mb-3 md:mb-6">{{ $b->ringkasan ?? strip_tags($b->isi_konten) }}</p>
                    
                    <div class="mt-auto pt-3 md:pt-4 border-t border-slate-100">
                        <a href="{{ url(app('tenant')->slug . '/informasi/berita#' . ($b->slug ?? '')) }}" class="inline-flex items-center text-[{{ $sekolah['warna_tema'] ?? '#4F46E5' }}] text-[10px] md:text-base font-medium hover:underline">
                            Baca selengkapnya
                            <svg class="w-3 h-3 md:w-4 md:h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
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
