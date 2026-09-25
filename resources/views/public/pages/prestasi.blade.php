@extends('layouts.public')
@section('title', 'Prestasi Siswa')

@section('content')
<div class="py-6 md:py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-6 md:mb-16">
            <h1 class="text-xl md:text-4xl font-extrabold text-slate-900">Prestasi Siswa</h1>
            <p class="mt-2 md:mt-4 text-xs md:text-xl text-slate-600 max-w-2xl mx-auto">Membanggakan almamater melalui karya dan juara.</p>
        </div>
        
        <div class="flex overflow-x-auto pb-6 -mx-4 px-4 snap-x snap-mandatory hide-scrollbar md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-8 md:overflow-visible md:pb-0 md:mx-0 md:px-0">
            @forelse($prestasi as $p)
                <div class="flex-none w-52 md:w-auto snap-center mr-4 md:mr-0 h-full">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow border border-slate-100 flex flex-col group h-full">
                    <div class="aspect-video w-full relative overflow-hidden bg-slate-100">
                        <img src="{{ $p->foto ?? 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=2070&auto=format&fit=crop' }}" alt="{{ $p->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @if($p->tingkat)
                        <div class="absolute top-2 right-2 md:top-4 md:right-4 px-1.5 py-0.5 md:px-3 md:py-1 bg-yellow-500 text-white font-bold text-[9px] md:text-xs rounded-full shadow-lg">
                            Tingkat {{ $p->tingkat }}
                        </div>
                        @endif
                    </div>
                    <div class="p-3 md:p-6 flex flex-col flex-grow">
                        <div class="text-[10px] md:text-sm text-indigo-600 font-bold mb-1 md:mb-2 uppercase tracking-wide">{{ $p->kategori ?? 'Akademik' }}</div>
                        <h3 class="text-base md:text-xl font-bold text-slate-900 mb-2 md:mb-3 leading-snug">{{ $p->judul }}</h3>
                        <div class="text-slate-600 text-xs md:text-sm mb-3 line-clamp-3 flex-grow">{{ $p->deskripsi }}</div>
                        <div class="mt-auto pt-3 md:pt-4 border-t border-slate-100 flex items-center justify-between text-[10px] md:text-sm text-slate-500">
                            <span class="flex items-center">
                                <svg class="w-3.5 h-3.5 md:w-4 md:h-4 mr-1 md:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ $p->nama_siswa }}
                            </span>
                            <span>{{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}</span>
                        </div>
                    </div>
                    </div>
                </div>
            @empty
            <div class="col-span-full py-12 text-slate-500 text-center bg-white rounded-2xl border border-slate-100">
                Belum ada data prestasi yang dipublikasikan.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
