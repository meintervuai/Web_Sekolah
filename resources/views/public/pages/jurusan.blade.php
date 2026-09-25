@extends('layouts.public')
@section('title', 'Program Keahlian')

@section('content')
<div class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-extrabold text-slate-900">Program Keahlian</h1>
            <p class="mt-4 text-xl text-slate-600 max-w-2xl mx-auto">Pilihan jurusan terbaik untuk masa depan gemilang di {{ $sekolah['nama'] ?? 'Sekolah' }}</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($jurusan as $j)
                <div class="group bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 flex flex-col h-full cursor-pointer relative">
                    <div class="h-64 bg-slate-200 relative overflow-hidden">
                        <img src="{{ $j->foto_utama ?? 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop' }}" alt="{{ $j->nama_jurusan }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 ease-in-out">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                        <div class="absolute top-4 right-4 w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-2xl shadow-lg border border-white/30 text-white transform group-hover:rotate-12 transition-transform">
                            {{ $j->ikon_atau_foto ?? '💻' }}
                        </div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <h3 class="font-heading font-bold text-2xl text-white leading-tight mb-2">{{ $j->nama_jurusan }}</h3>
                            @if($j->singkatan)
                            <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm text-white rounded-lg font-bold text-sm">{{ $j->singkatan }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="p-8 flex flex-col flex-grow bg-white relative">
                        <div class="absolute -top-6 right-8 w-12 h-12 rounded-full theme-bg text-white flex items-center justify-center shadow-lg transform scale-0 group-hover:scale-100 transition-transform duration-300 ease-out">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                        <p class="text-slate-600 mb-6 flex-grow line-clamp-3 text-lg leading-relaxed">{{ $j->deskripsi_singkat ?? 'Program keahlian yang mendidik siswa menjadi tenaga profesional dan siap menghadapi dunia industri modern.' }}</p>
                        <a href="{{ url(app('tenant')->slug . '/akademik/jurusan#' . ($j->slug ?? '')) }}" class="inline-flex items-center font-bold theme-text uppercase tracking-wider text-sm group-hover:theme-text-dark transition-colors mt-auto">
                            Pelajari Kurikulum
                        </a>
                    </div>
                </div>
            @empty
            <div class="col-span-full py-12 text-slate-500 text-center">Belum ada data jurusan.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
