@extends('layouts.public')

@section('title', $agenda->judul . ' - Agenda ' . $sekolah['nama'])
@section('meta_description', Str::limit(strip_tags($agenda->deskripsi ?? $agenda->ringkasan), 160))

@section('content')
<!-- Header Hero / Breadcrumbs -->
<section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li><a href="{{ url(app('tenant')->slug . '/agenda') }}" class="hover:text-white transition">Agenda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium truncate max-w-xs md:max-w-md">{{ $agenda->judul }}</li>
            </ol>
        </nav>
        <div class="max-w-3xl">
            @php
                $tglMulai = \Carbon\Carbon::parse($agenda->tgl_mulai);
                $isUpcoming = $tglMulai->isFuture() || $tglMulai->isToday();
            @endphp
            <div class="flex items-center space-x-2 mb-3">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $isUpcoming ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-400/30' : 'bg-slate-700 text-slate-300' }}">
                    {{ $isUpcoming ? 'Agenda Akan Datang' : 'Telah Terlaksana' }}
                </span>
                <span class="text-xs text-slate-400">•</span>
                <span class="text-xs text-slate-300 font-medium">{{ $tglMulai->translatedFormat('l, d F Y') }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white leading-tight font-heading mb-4">
                {{ $agenda->judul }}
            </h1>
            @if($agenda->ringkasan)
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    {{ $agenda->ringkasan }}
                </p>
            @endif
        </div>
    </div>
</section>

<!-- Main Detail -->
<section class="section-py bg-slate-50">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            
            <!-- Left: Main Information (8 cols) -->
            <div class="lg:col-span-8 space-y-8">
                
                @if($agenda->gambar_sampul)
                    <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/90 shadow-sm">
                        <img src="{{ $agenda->gambar_sampul }}" 
                             alt="{{ $agenda->judul }}" 
                             class="w-full h-auto max-h-[460px] object-cover">
                    </div>
                @endif

                <!-- Key Info Box Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm">
                    <div class="flex items-start space-x-3.5">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0 border border-blue-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block font-medium">Tanggal Pelaksanaan</span>
                            <strong class="text-sm text-slate-800 font-semibold">{{ $tglMulai->translatedFormat('d F Y') }}</strong>
                            @if($agenda->tgl_selesai && $agenda->tgl_selesai != $agenda->tgl_mulai)
                                <span class="text-xs text-slate-500 block">s/d {{ \Carbon\Carbon::parse($agenda->tgl_selesai)->translatedFormat('d F Y') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-start space-x-3.5">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center shrink-0 border border-indigo-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block font-medium">Waktu / Pukul</span>
                            <strong class="text-sm text-slate-800 font-semibold">
                                {{ $agenda->jam_mulai ? substr($agenda->jam_mulai, 0, 5) . ($agenda->jam_selesai ? ' - ' . substr($agenda->jam_selesai, 0, 5) . ' WIB' : ' WIB') : 'Jadwal Ditentukan Kemudian' }}
                            </strong>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3.5">
                        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-700 flex items-center justify-center shrink-0 border border-rose-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block font-medium">Tempat / Lokasi</span>
                            <strong class="text-sm text-slate-800 font-semibold">{{ $agenda->lokasi ?? 'Kampus SMKN 2 Bandung' }}</strong>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3.5">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0 border border-amber-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block font-medium">Penyelenggara</span>
                            <strong class="text-sm text-slate-800 font-semibold">{{ $agenda->penyelenggara ?? 'SMK Negeri 2 Bandung' }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Description / Content Body -->
                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/90 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900 font-heading mb-4 pb-3 border-b border-slate-100">
                        Deskripsi & Rincian Agenda Kegiatan
                    </h2>
                    <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed text-sm sm:text-base whitespace-pre-line">
                        {{ $agenda->deskripsi }}
                    </div>

                    @if($agenda->link_pendaftaran)
                        <div class="mt-8 pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <span class="text-xs text-slate-500 font-medium block">Pendaftaran / Konfirmasi Kehadiran:</span>
                                <span class="text-xs text-slate-700">Tautan pendaftaran daring resmi panitia penyelenggara</span>
                            </div>
                            <a href="{{ $agenda->link_pendaftaran }}" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition">
                                Isi Formulir Pendaftaran
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Bottom Back Link -->
                <div class="pt-2 flex items-center justify-between">
                    <a href="{{ url(app('tenant')->slug . '/agenda') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Seluruh Agenda
                    </a>
                </div>
            </div>

            <!-- Right: Sidebar (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Agenda Lainnya -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm">
                    <h3 class="text-sm font-bold text-slate-900 font-heading mb-4 pb-3 border-b border-slate-100 flex items-center">
                        <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Agenda Sekolah Lainnya
                    </h3>
                    <div class="space-y-4">
                        @forelse($agendaLainnya as $al)
                            <div class="flex items-start space-x-3 group">
                                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 flex flex-col items-center justify-center shrink-0 text-center font-heading">
                                    <span class="text-[10px] uppercase font-bold leading-none">{{ \Carbon\Carbon::parse($al->tgl_mulai)->translatedFormat('M') }}</span>
                                    <span class="text-base font-extrabold leading-none mt-0.5">{{ \Carbon\Carbon::parse($al->tgl_mulai)->translatedFormat('d') }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-xs font-bold text-slate-800 group-hover:text-blue-600 transition line-clamp-2">
                                        <a href="{{ url(app('tenant')->slug . '/agenda/' . $al->slug) }}">
                                            {{ $al->judul }}
                                        </a>
                                    </h4>
                                    <span class="text-[11px] text-slate-400 block mt-1 truncate">
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
                <div class="bg-gradient-to-br from-slate-900 to-blue-950 text-white rounded-2xl p-6 border border-slate-800 shadow-sm">
                    <h4 class="font-bold text-white font-heading text-sm mb-2">Pertanyaan Seputar Agenda?</h4>
                    <p class="text-xs text-slate-300 leading-relaxed mb-4">
                        Hubungi bagian Humas atau Tata Usaha untuk koordinasi kunjungan, pameran inovasi, atau konfirmasi kegiatan.
                    </p>
                    <a href="{{ url(app('tenant')->slug . '/kontak') }}" class="inline-flex items-center text-xs font-bold text-sky-400 hover:text-white transition">
                        <span>Hubungi Sekretariat Humas</span>
                        <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
