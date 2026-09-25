@extends('layouts.public')
@section('title', 'Guru & Staf')

@section('content')
<div class="py-8 md:py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 md:mb-12">
            <h1 class="text-2xl md:text-4xl font-extrabold text-slate-900 mb-3 md:mb-4 relative inline-block">Tenaga Pendidik & Kependidikan</h1>
            <div class="w-16 md:w-24 h-1 bg-[{{ $sekolah['warna_tema'] ?? '#4F46E5' }}] rounded-full mx-auto"></div>
        </div>
        
        <div class="flex overflow-x-auto pb-8 -mx-4 px-4 snap-x snap-mandatory hide-scrollbar sm:grid sm:grid-cols-2 lg:grid-cols-4 sm:gap-6 sm:overflow-visible sm:pb-0 sm:mx-0 sm:px-0">
            @forelse($guru as $g)
            <div class="flex-none w-44 md:w-auto snap-center mr-4 md:mr-0 h-full">
                <div class="bg-slate-50 rounded-xl overflow-hidden hover:shadow-md transition-shadow group h-full">
                <div class="aspect-square overflow-hidden bg-slate-200">
                    <img src="{{ $g->foto ?? 'https://ui-avatars.com/api/?name='.urlencode($g->nama_lengkap).'&background=random' }}" alt="{{ $g->nama_lengkap }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-4 md:p-5 text-center">
                    <h3 class="font-bold text-slate-800 text-base md:text-lg line-clamp-1" title="{{ $g->nama_lengkap }}">{{ $g->nama_lengkap }}</h3>
                    <p class="text-slate-500 text-xs md:text-sm mt-1">{{ $g->jabatan }}</p>
                    @if($g->mata_pelajaran)
                    <p class="text-[10px] md:text-xs font-semibold mt-2 md:mt-3 px-2 py-0.5 md:px-3 md:py-1 bg-indigo-50 text-indigo-700 rounded-full inline-block">{{ $g->mata_pelajaran }}</p>
                    @endif
                </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-slate-500 text-center">Belum ada data guru.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
