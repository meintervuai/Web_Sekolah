@extends('layouts.public')
@section('title', 'Agenda & Kalender Akademik')

@section('content')
<div class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-extrabold text-slate-900 mb-12 text-center">Agenda Sekolah</h1>
        
        <div class="relative border-l-4 border-slate-200 ml-4 md:ml-6 space-y-12">
            @forelse($kalender ?? $agenda as $item)
            <div class="relative pl-8 md:pl-10">
                <div class="absolute -left-[14px] top-1 w-6 h-6 rounded-full bg-white border-4 border-[{{ $sekolah['warna_tema'] ?? '#4F46E5' }}]"></div>
                <div class="bg-slate-50 rounded-2xl p-6 shadow-sm border border-slate-100">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-2">
                        <h3 class="text-xl font-bold text-slate-900">{{ $item->nama_kegiatan }}</h3>
                        <span class="inline-flex items-center mt-2 md:mt-0 px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 font-semibold text-sm">
                            {{ \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('d M Y') }}
                            @if($item->tgl_selesai && $item->tgl_selesai != $item->tgl_mulai)
                                - {{ \Carbon\Carbon::parse($item->tgl_selesai)->translatedFormat('d M Y') }}
                            @endif
                        </span>
                    </div>
                    @if($item->keterangan)
                    <p class="text-slate-600 mt-3">{{ $item->keterangan }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="py-12 text-slate-500 pl-8">Belum ada agenda terdaftar.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
