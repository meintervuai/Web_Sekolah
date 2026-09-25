@extends('layouts.public')
@section('title', $halaman->judul ?? 'Halaman')

@section('content')
<div class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(isset($halaman->gambar_banner) && $halaman->gambar_banner)
            <img src="{{ $halaman->gambar_banner }}" alt="{{ $halaman->judul }}" class="w-full h-64 md:h-96 object-cover rounded-xl shadow-lg mb-8">
        @endif
        <h1 class="text-4xl font-extrabold text-slate-900 mb-6 relative inline-block">
            {{ $halaman->judul ?? 'Halaman' }}
            <span class="absolute bottom-0 left-0 w-1/2 h-1 bg-[{{ $sekolah['warna_tema'] ?? '#4F46E5' }}] rounded-full"></span>
        </h1>
        
        <div class="prose prose-slate prose-lg max-w-none text-slate-700 leading-relaxed">
            {!! $halaman->isi_konten ?? '<p>Konten belum tersedia.</p>' !!}
        </div>
    </div>
</div>
@endsection
