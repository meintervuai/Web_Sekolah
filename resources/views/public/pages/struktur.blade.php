@extends('layouts.public')
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
