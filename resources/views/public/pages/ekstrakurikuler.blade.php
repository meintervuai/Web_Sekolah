@extends('layouts.public')
@section('title', 'Ekstrakurikuler')

@section('content')
<div class="py-6 md:py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-6 md:mb-16">
            <h1 class="text-xl md:text-4xl font-extrabold text-slate-900">Ekstrakurikuler</h1>
            <p class="mt-2 md:mt-4 text-xs md:text-xl text-slate-600 max-w-2xl mx-auto">Kembangkan bakat dan minatmu di luar jam akademik bersama {{ $sekolah['nama'] ?? 'Sekolah' }}</p>
        </div>
        
        <div class="flex overflow-x-auto pb-6 -mx-4 px-4 snap-x snap-mandatory hide-scrollbar md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-10 md:overflow-visible md:pb-0 md:mx-0 md:px-0">
            @forelse($ekstrakurikuler as $ekskul)
                <div class="flex-none w-52 md:w-auto snap-center mr-4 md:mr-0 h-full">
                    <div class="group bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 flex flex-col h-full cursor-pointer relative">
                    <div class="aspect-video w-full bg-slate-200 relative overflow-hidden">
                        <img src="{{ $ekskul->foto ?? 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=2070&auto=format&fit=crop' }}" alt="{{ $ekskul->nama_ekstrakurikuler }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 ease-in-out">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                        <div class="absolute bottom-3 left-3 right-3 md:bottom-6 md:left-6 md:right-6">
                            <h3 class="font-heading font-bold text-base md:text-2xl text-white leading-tight mb-1 md:mb-2">{{ $ekskul->nama_ekstrakurikuler }}</h3>
                        </div>
                    </div>
                    <div class="p-3 md:p-8 flex flex-col flex-grow bg-white relative">
                        <p class="text-slate-600 mb-3 md:mb-6 flex-grow text-xs md:text-base leading-relaxed">{{ $ekskul->deskripsi ?? 'Kegiatan ekstrakurikuler untuk mengembangkan kreativitas dan keterampilan siswa.' }}</p>
                        @if($ekskul->hari_jadwal)
                        <div class="mt-auto pt-3 md:pt-4 border-t border-slate-100 flex items-center text-[10px] md:text-sm text-slate-500 font-medium">
                            <svg class="w-3.5 h-3.5 md:w-5 md:h-5 mr-1 md:mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $ekskul->hari_jadwal }} {{ $ekskul->waktu_jadwal ? '('.$ekskul->waktu_jadwal.')' : '' }}
                        </div>
                        @endif
                    </div>
                    </div>
                </div>
            @empty
            <div class="col-span-full py-12 text-slate-500 text-center">Belum ada data ekstrakurikuler.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
