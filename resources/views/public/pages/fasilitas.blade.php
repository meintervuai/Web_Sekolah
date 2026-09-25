@extends('layouts.public')
@section('title', 'Fasilitas')

@section('content')
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-extrabold text-slate-900 mb-4">Fasilitas Sekolah</h1>
            <div class="w-24 h-1 bg-[{{ $sekolah['warna_tema'] ?? '#4F46E5' }}] rounded-full mx-auto"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($fasilitas as $f)
            <div class="group rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300">
                <div class="aspect-w-16 aspect-h-10 overflow-hidden relative">
                    <img src="{{ $f->foto_utama }}" alt="{{ $f->nama_fasilitas }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-6 w-full">
                        <h3 class="text-2xl font-bold text-white mb-2">{{ $f->nama_fasilitas }}</h3>
                    </div>
                </div>
                <div class="p-6 bg-white">
                    <p class="text-slate-600 leading-relaxed">{{ $f->deskripsi }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-slate-500 text-center">Belum ada data fasilitas.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
