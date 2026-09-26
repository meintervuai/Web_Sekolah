@extends('layouts.public')
@section('title', 'Program Keahlian')

@section('content')
<div class="py-6 md:py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-6 md:mb-16">
            <h1 class="text-xl md:text-4xl font-extrabold text-slate-900">Program Keahlian</h1>
            <p class="mt-2 md:mt-4 text-xs md:text-xl text-slate-600 max-w-2xl mx-auto">Pilihan jurusan terbaik untuk masa depan gemilang di {{ $sekolah['nama'] ?? 'Sekolah' }}</p>
        </div>
        
        <div class="flex overflow-x-auto pb-6 -mx-4 px-4 snap-x snap-mandatory hide-scrollbar md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-10 md:overflow-visible md:pb-0 md:mx-0 md:px-0 mb-16">
            @forelse($jurusan as $j)
                <div class="flex-none w-52 md:w-auto snap-center mr-4 md:mr-0 h-full">
                    <a href="{{ route('akademik.jurusan.detail', $j->slug) }}" class="group bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 flex flex-col h-full cursor-pointer relative block">
                    <div class="aspect-video w-full bg-slate-200 relative overflow-hidden">
                        <img src="{{ $j->foto_utama ?? 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop' }}" alt="{{ $j->nama_jurusan }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 ease-in-out">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                        <div class="absolute top-2 right-2 w-8 h-8 md:top-4 md:right-4 md:w-12 md:h-12 bg-white/20 backdrop-blur-md rounded-lg md:rounded-2xl flex items-center justify-center text-sm md:text-2xl shadow-lg border border-white/30 text-white transform group-hover:rotate-12 transition-transform">
                            {{ $j->ikon_atau_foto ?? '💻' }}
                        </div>
                        <div class="absolute bottom-3 left-3 right-3 md:bottom-6 md:left-6 md:right-6">
                            <h3 class="font-heading font-bold text-base md:text-2xl text-white leading-tight mb-1 md:mb-2">{{ $j->nama_jurusan }}</h3>
                            @if($j->singkatan)
                            <span class="inline-block px-1.5 py-0.5 md:px-3 md:py-1 bg-white/20 backdrop-blur-sm text-white rounded-md font-bold text-[10px] md:text-sm">{{ $j->singkatan }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="p-3 md:p-8 flex flex-col flex-grow bg-white relative">
                        <div class="absolute -top-4 right-4 md:-top-6 md:right-8 w-8 h-8 md:w-12 md:h-12 rounded-full theme-bg text-white flex items-center justify-center shadow-lg transform scale-0 group-hover:scale-100 transition-transform duration-300 ease-out">
                            <svg class="w-3.5 h-3.5 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                        <p class="text-slate-600 mb-3 md:mb-6 flex-grow line-clamp-3 text-xs md:text-lg leading-relaxed">{{ $j->deskripsi_singkat ?? 'Program keahlian yang mendidik siswa menjadi tenaga profesional dan siap menghadapi dunia industri modern.' }}</p>
                        <span class="inline-flex items-center font-bold theme-text uppercase tracking-wider text-[10px] md:text-sm group-hover:theme-text-dark transition-colors mt-auto">
                            Pelajari Selengkapnya
                        </span>
                    </div>
                    </a>
                </div>
            @empty
            <div class="col-span-full py-12 text-slate-500 text-center">Belum ada data jurusan.</div>
            @endforelse
        </div>

        <!-- Content removed, moving to detail page -->
    </div>
</div>
@endsection
