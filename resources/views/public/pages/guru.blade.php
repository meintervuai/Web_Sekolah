@extends('layouts.public')
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
