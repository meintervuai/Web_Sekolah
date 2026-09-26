@extends('layouts.public')
@section('title', 'Kalender Akademik')

@section('content')
<div class="py-10 md:py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-8 md:mb-12 text-center">Kalender Akademik</h1>
        
        <!-- Kalender File Viewer (PDF / Image) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 mb-12 md:mb-16">
            <!-- Semester Ganjil -->
            <div class="bg-slate-50 rounded-2xl p-4 md:p-6 shadow-sm border border-slate-100 flex flex-col items-center">
                @if($file_ganjil)
                    @if(Str::endsWith(strtolower($file_ganjil), '.pdf'))
                        <iframe src="{{ Storage::url($file_ganjil) }}" class="w-full h-[400px] md:h-[600px] rounded-lg shadow-sm" frameborder="0"></iframe>
                    @else
                        <img src="{{ Storage::url($file_ganjil) }}" alt="Kalender Semester Ganjil" class="w-full max-w-[300px] md:max-w-full h-auto rounded-lg shadow-sm object-contain">
                    @endif
                @else
                    <img src="https://placehold.co/800x1000/EEF2FF/4F46E5?text=Kalender+Semester+Ganjil" alt="Kalender Semester Ganjil" class="w-full max-w-[300px] md:max-w-full h-auto rounded-lg shadow-sm object-contain">
                @endif
                <p class="mt-4 text-slate-600 font-semibold text-sm md:text-base">Semester Ganjil</p>
            </div>
            
            <!-- Semester Genap -->
            <div class="bg-slate-50 rounded-2xl p-4 md:p-6 shadow-sm border border-slate-100 flex flex-col items-center">
                @if($file_genap)
                    @if(Str::endsWith(strtolower($file_genap), '.pdf'))
                        <iframe src="{{ Storage::url($file_genap) }}" class="w-full h-[400px] md:h-[600px] rounded-lg shadow-sm" frameborder="0"></iframe>
                    @else
                        <img src="{{ Storage::url($file_genap) }}" alt="Kalender Semester Genap" class="w-full max-w-[300px] md:max-w-full h-auto rounded-lg shadow-sm object-contain">
                    @endif
                @else
                    <img src="https://placehold.co/800x1000/EEF2FF/4F46E5?text=Kalender+Semester+Genap" alt="Kalender Semester Genap" class="w-full max-w-[300px] md:max-w-full h-auto rounded-lg shadow-sm object-contain">
                @endif
                <p class="mt-4 text-slate-600 font-semibold text-sm md:text-base">Semester Genap</p>
            </div>
        </div>

        <h2 class="text-xl md:text-2xl font-bold text-slate-800 mb-6 md:mb-8">Detail Kegiatan Akademik</h2>
        
        <!-- Interactive List/Calendar View -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @forelse($kalender as $item)
            <div class="bg-white rounded-xl md:rounded-2xl p-4 md:p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                <div class="flex items-center space-x-3 md:space-x-4 mb-3 md:mb-4">
                    <div class="flex-shrink-0 flex flex-col items-center justify-center w-12 h-12 md:w-16 md:h-16 rounded-xl bg-[{{ $sekolah['warna_tema'] ?? '#4F46E5' }}] bg-opacity-10 text-[{{ $sekolah['warna_tema'] ?? '#4F46E5' }}]">
                        <span class="text-xl md:text-2xl font-bold leading-none">{{ \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('d') }}</span>
                        <span class="text-[10px] md:text-xs uppercase font-semibold mt-1">{{ \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('M') }}</span>
                    </div>
                    <div>
                        <h3 class="text-base md:text-lg font-bold text-slate-900 line-clamp-2">{{ $item->nama_kegiatan }}</h3>
                        <span class="text-xs md:text-sm text-slate-500">
                            @if($item->tgl_selesai && $item->tgl_selesai != $item->tgl_mulai)
                                s/d {{ \Carbon\Carbon::parse($item->tgl_selesai)->translatedFormat('d M Y') }}
                            @else
                                {{ \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('Y') }}
                            @endif
                        </span>
                    </div>
                </div>
                @if($item->keterangan)
                <p class="text-slate-600 text-xs md:text-sm border-t border-slate-100 pt-2 md:pt-3">{{ $item->keterangan }}</p>
                @endif
            </div>
            @empty
            <div class="col-span-full py-8 md:py-12 text-center text-sm md:text-base text-slate-500">Belum ada kegiatan akademik terdaftar.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
