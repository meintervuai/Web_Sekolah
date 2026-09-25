@extends('layouts.public')
@section('title', 'OSIS & MPK')

@section('content')
<div class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight">{{ $halaman->judul ?? 'Organisasi Siswa' }}</h1>
        </div>
        
        @if($halaman && $halaman->gambar_banner)
            <div class="w-full aspect-video md:aspect-[21/9] rounded-3xl overflow-hidden mb-12 shadow-xl">
                <img src="{{ $halaman->gambar_banner }}" alt="Banner {{ $halaman->judul }}" class="w-full h-full object-cover">
            </div>
        @endif

        <div class="prose prose-lg prose-indigo max-w-none text-slate-600 leading-relaxed">
            @if($halaman)
                {!! $halaman->isi_konten !!}
            @else
                <p class="text-center text-slate-500 italic">Informasi OSIS belum tersedia saat ini.</p>
            @endif
        </div>
    </div>
</div>
@endsection
