@extends('layouts.public')

@section('title', $agenda->judul . ' - Agenda ' . $sekolah['nama'])
@section('meta_description', Str::limit(strip_tags($agenda->deskripsi), 160))

@section('content')
<!-- Header & Breadcrumbs -->
<section class="bg-slate-100 py-4 border-b border-slate-200">
    <div class="container-custom">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-500 overflow-x-auto hide-scrollbar">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-blue-600 transition">Beranda</a></li>
                <li><span>/</span></li>
                <li><a href="{{ url(app('tenant')->slug . '/agenda') }}" class="hover:text-blue-600 transition">Agenda</a></li>
                <li><span>/</span></li>
                <li class="text-slate-800 font-semibold truncate max-w-xs md:max-w-md">{{ $agenda->judul }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Detail -->
<section class="section-py bg-white">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            
            <!-- Left: Main Information (8 cols) -->
            <div class="lg:col-span-8">
                @php
                    $tglMulai = \Carbon\Carbon::parse($agenda->tgl_mulai);
                    $isUpcoming = $tglMulai->isFuture() || $tglMulai->isToday();
                @endphp

                <!-- Status pill -->
                <div class="mb-4">
                    @if($isUpcoming)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                        Agenda Akan Datang
                    </span>
                    @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                        Agenda Telah Terlaksana
                    </span>
                    @endif
                </div>

                <!-- Title -->
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-900 leading-tight font-heading mb-6">
                    {{ $agenda->judul }}
                </h1>

                <!-- Key Info Box Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8 bg-slate-50 p-5 rounded-2xl border border-slate-200/80">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block">Tanggal Pelaksanaan</span>
                            <strong class="text-sm text-slate-800 font-semibold">{{ $tglMulai->translatedFormat('l, d F Y') }}</strong>
                            @if($agenda->tgl_selesai && $agenda->tgl_selesai != $agenda->tgl_mulai)
                                <span class="text-xs text-slate-500 block">s/d {{ \Carbon\Carbon::parse($agenda->tgl_selesai)->translatedFormat('d F Y') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block">Waktu Pelaksanaan</span>
                            <strong class="text-sm text-slate-800 font-semibold">
                                {{ $agenda->jam_mulai ? substr($agenda->jam_mulai, 0, 5) . ($agenda->jam_selesai ? ' - ' . substr($agenda->jam_selesai, 0, 5) . ' WIB' : ' WIB') : 'Jadwal Ditentukan Kemudian' }}
                            </strong>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block">Lokasi Kegiatan</span>
                            <strong class="text-sm text-slate-800 font-semibold">{{ $agenda->lokasi ?? 'Kampus SMKN 2 Bandung' }}</strong>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block">Penyelenggara / Penanggung Jawab</span>
                            <strong class="text-sm text-slate-800 font-semibold">{{ $agenda->penyelenggara ?? 'SMK Negeri 2 Bandung' }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Description / Content Body -->
                <div class="prose prose-slate max-w-none prose-p:text-slate-700 prose-p:leading-relaxed mb-8">
                    <h2 class="text-xl font-bold text-slate-900 font-heading mb-4">Deskripsi & Rundown Kegiatan</h2>
                    <p class="whitespace-pre-line text-sm md:text-base leading-relaxed text-slate-700">
                        {{ $agenda->deskripsi }}
                    </p>
                </div>

                <!-- Share bar -->
                <div class="pt-6 border-t border-slate-200 flex items-center justify-between">
                    <a href="{{ url(app('tenant')->slug . '/agenda') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Seluruh Agenda
                    </a>
                </div>
            </div>

            <!-- Right: Sidebar (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Agenda Lainnya -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200/80">
                    <h3 class="text-base font-bold text-slate-900 font-heading mb-4 pb-3 border-b border-slate-200">
                        Agenda Sekolah Lainnya
                    </h3>
                    <div class="space-y-4">
                        @forelse($agendaLainnya as $al)
                        <div class="flex items-start space-x-3 group">
                            <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 flex flex-col items-center justify-center shrink-0 text-center font-heading">
                                <span class="text-[10px] uppercase font-bold leading-none">{{ \Carbon\Carbon::parse($al->tgl_mulai)->translatedFormat('M') }}</span>
                                <span class="text-base font-extrabold leading-none mt-0.5">{{ \Carbon\Carbon::parse($al->tgl_mulai)->translatedFormat('d') }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xs font-bold text-slate-800 group-hover:text-blue-600 transition line-clamp-2">
                                    <a href="{{ url(app('tenant')->slug . '/agenda/' . $al->slug) }}">
                                        {{ $al->judul }}
                                    </a>
                                </h4>
                                <span class="text-[11px] text-slate-400 block mt-1">
                                    {{ $al->lokasi ?? 'Kampus Sekolah' }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <p class="text-xs text-slate-400 italic">Tidak ada agenda lain saat ini.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Info bantuan kontak -->
                <div class="bg-blue-50 border border-blue-200/60 rounded-2xl p-6">
                    <h4 class="font-bold text-blue-950 font-heading text-sm mb-2">Pertanyaan Seputar Agenda?</h4>
                    <p class="text-xs text-blue-800 leading-relaxed mb-4">Hubungi bidang humas atau kurikulum sekolah untuk koordinasi kegiatan.</p>
                    <a href="{{ url(app('tenant')->slug . '/kontak') }}" class="inline-flex items-center text-xs font-bold text-blue-700 hover:text-blue-900">
                        <span>Kontak Sekolah &raquo;</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
