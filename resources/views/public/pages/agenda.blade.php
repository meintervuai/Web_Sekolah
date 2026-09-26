@extends('layouts.public')

@section('title', 'Agenda Kegiatan - ' . $sekolah['nama'])
@section('meta_description', 'Kalender agenda akademik, workshop, uji kompetensi, dan kegiatan sekolah resmi di ' . $sekolah['nama'])

@section('content')
<!-- Header & Breadcrumb -->
<section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium">Agenda Sekolah</li>
            </ol>
        </nav>
        <div class="max-w-2xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3">
                Kalender & Agenda Kegiatan
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed">
                Jadwal resmi kegiatan akademik, sertifikasi industri, asesmen, seminar, dan event siswa di {{ $sekolah['nama'] }}.
            </p>
        </div>
    </div>
</section>

<!-- Filter & Search Bar -->
<section class="bg-white border-b border-slate-200/80 sticky top-16 z-30 shadow-xs">
    <div class="container-custom py-4">
        <form method="GET" action="{{ url(app('tenant')->slug . '/agenda') }}" class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <!-- Filter Tabs -->
            <div class="flex items-center space-x-2 text-xs">
                <a href="{{ url(app('tenant')->slug . '/agenda?filter=mendatang' . (request('q') ? '&q=' . request('q') : '')) }}" 
                   class="px-4 py-2 rounded-xl font-medium transition {{ $filter === 'mendatang' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Akan Datang
                </a>
                <a href="{{ url(app('tenant')->slug . '/agenda?filter=lampau' . (request('q') ? '&q=' . request('q') : '')) }}" 
                   class="px-4 py-2 rounded-xl font-medium transition {{ $filter === 'lampau' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Telah Selesai
                </a>
                <a href="{{ url(app('tenant')->slug . '/agenda?filter=semua' . (request('q') ? '&q=' . request('q') : '')) }}" 
                   class="px-4 py-2 rounded-xl font-medium transition {{ $filter === 'semua' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Semua
                </a>
            </div>

            <!-- Search Input -->
            <div class="relative w-full sm:w-72 shrink-0">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama agenda / lokasi..." 
                       class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs md:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="hidden" name="filter" value="{{ $filter }}">
            </div>
        </form>
    </div>
</section>

<!-- Agenda Listing Section -->
<section class="section-py bg-slate-50">
    <div class="container-custom">
        <div class="space-y-4">
            @forelse($agenda as $item)
            @php
                $tglMulai = \Carbon\Carbon::parse($item->tgl_mulai);
                $isUpcoming = $tglMulai->isFuture() || $tglMulai->isToday();
            @endphp
            <div class="bg-white rounded-2xl p-5 md:p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition flex flex-col sm:flex-row sm:items-center gap-5 group">
                <!-- Date Badge Box -->
                <div class="flex sm:flex-col items-center justify-center shrink-0 w-full sm:w-24 sm:h-24 rounded-2xl {{ $isUpcoming ? 'bg-gradient-to-br from-blue-600 to-indigo-700 text-white' : 'bg-slate-100 text-slate-600' }} p-3 text-center shadow-xs">
                    <span class="text-xs uppercase font-bold tracking-wider opacity-90">{{ $tglMulai->translatedFormat('M') }}</span>
                    <span class="text-2xl sm:text-3xl font-extrabold font-heading mx-2 sm:mx-0 leading-none">{{ $tglMulai->translatedFormat('d') }}</span>
                    <span class="text-[11px] opacity-80">{{ $tglMulai->translatedFormat('Y') }}</span>
                </div>

                <!-- Agenda Info Details -->
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        @if($isUpcoming)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800">
                            Akan Datang
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                            Selesai
                        </span>
                        @endif

                        @if($item->penyelenggara)
                        <span class="text-xs text-slate-500 flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            {{ $item->penyelenggara }}
                        </span>
                        @endif
                    </div>

                    <h2 class="text-base md:text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors font-heading mb-2">
                        <a href="{{ url(app('tenant')->slug . '/agenda/' . $item->slug) }}">
                            {{ $item->judul }}
                        </a>
                    </h2>

                    <!-- Time & Location metadata -->
                    <div class="flex flex-wrap items-center gap-y-1 gap-x-4 text-xs text-slate-500 mb-3">
                        <span class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $item->jam_mulai ? substr($item->jam_mulai, 0, 5) . ($item->jam_selesai ? ' - ' . substr($item->jam_selesai, 0, 5) . ' WIB' : ' WIB') : 'Waktu menyesuaikan' }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $item->lokasi ?? 'Kampus SMKN 2 Bandung' }}
                        </span>
                    </div>

                    <p class="text-xs md:text-sm text-slate-600 line-clamp-2">
                        {{ $item->deskripsi }}
                    </p>
                </div>

                <!-- Action Button -->
                <div class="shrink-0 pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100 flex sm:flex-col justify-end">
                    <a href="{{ url(app('tenant')->slug . '/agenda/' . $item->slug) }}" 
                       class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-slate-100 group-hover:bg-blue-600 group-hover:text-white text-slate-700 text-xs font-bold transition">
                        <span>Detail Kegiatan</span>
                        <svg class="w-3.5 h-3.5 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="py-16 text-center bg-white rounded-2xl border border-slate-200/80 p-8">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-800 font-heading mb-1">Belum Ada Agenda</h3>
                <p class="text-xs md:text-sm text-slate-500 max-w-sm mx-auto mb-4">Tidak ada jadwal kegiatan yang cocok dengan kriteria filter yang Anda pilih saat ini.</p>
                <a href="{{ url(app('tenant')->slug . '/agenda?filter=semua') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 transition">
                    Tampilkan Semua Agenda
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $agenda->links() }}
        </div>
    </div>
</section>
@endsection
