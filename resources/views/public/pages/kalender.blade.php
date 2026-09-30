@extends('layouts.public')

@section('title', 'Kalender Akademik Resmi - ' . $sekolah['nama'])
@section('meta_description', 'Kalender akademik, jadwal kegiatan belajar mengajar, penilaian sumatif, dan masa libur resmi di ' . $sekolah['nama'])

@section('content')
<!-- Header & Breadcrumb -->
<section class="theme-bg-dark text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(var(--theme-accent)_1px,transparent_1px)] [background-size:16px_16px]"></div>
    @if(!empty($gambarBanner ?? $banner ?? null))
        <!-- Right-Side Artistic Banner Image with Gradual Mask/Fade to Left & Theme Dark Overlay -->
        <div class="absolute inset-y-0 right-0 w-full md:w-3/5 lg:w-1/2 pointer-events-none z-0">
            <img src="{{ $gambarBanner ?? $banner }}" alt="Kalender Akademik" 
                 class="w-full h-full object-cover object-center opacity-40 lg:opacity-60 [mask-image:linear-gradient(to_left,rgba(0,0,0,1)_20%,rgba(0,0,0,0.6)_60%,transparent_100%)] [-webkit-mask-image:linear-gradient(to_left,rgba(0,0,0,1)_20%,rgba(0,0,0,0.6)_60%,transparent_100%)]">
            <div class="absolute inset-0 bg-gradient-to-r from-[var(--theme-header,#0f172a)] via-transparent to-transparent opacity-80"></div>
        </div>
    @endif
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition drop-shadow-xs">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li><a href="{{ url(app('tenant')->slug . '/agenda') }}" class="hover:text-white transition drop-shadow-xs">Agenda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium drop-shadow-xs">Kalender Akademik</li>
            </ol>
        </nav>
        <div class="max-w-4xl lg:max-w-5xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3 drop-shadow-sm">
                Kalender Akademik
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed max-w-3xl drop-shadow-xs">
                Rangkaian agenda resmi proses belajar mengajar, masa orientasi, uji kompetensi keahlian (UKK), dan libur semester di {{ $sekolah['nama'] }}.
            </p>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="section-py bg-slate-50">
    <div class="container-custom">
        <!-- Quick Nav & Document Viewers -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 mb-12">
            <!-- Semester Ganjil -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                            Semester Ganjil
                        </span>
                        <span class="text-xs text-slate-500 font-medium">Tahun Ajaran 2025/2026</span>
                    </div>
                    <h2 class="text-lg font-bold text-slate-900 font-heading mb-3">Dokumen Kalender Semester Ganjil</h2>
                    
                    @if($file_ganjil)
                        @if(Str::endsWith(strtolower($file_ganjil), '.pdf'))
                            <iframe src="{{ Storage::url($file_ganjil) }}" class="w-full h-80 rounded-xl border border-slate-100 mb-4" frameborder="0"></iframe>
                        @else
                            <img src="{{ Storage::url($file_ganjil) }}" alt="Kalender Semester Ganjil" class="w-full max-h-80 rounded-xl object-contain mb-4 bg-slate-50 border border-slate-100">
                        @endif
                        <div class="pt-2">
                            <a href="{{ Storage::url($file_ganjil) }}" target="_blank" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800">
                                <span>Unduh / Buka Dokumen Lengkap</span>
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                    @else
                        <div class="p-8 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200 text-slate-500 text-xs mb-4">
                            Dokumen resmi Semester Ganjil belum diunggah oleh Bagian Kurikulum.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Semester Genap -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                            Semester Genap
                        </span>
                        <span class="text-xs text-slate-500 font-medium">Tahun Ajaran 2025/2026</span>
                    </div>
                    <h2 class="text-lg font-bold text-slate-900 font-heading mb-3">Dokumen Kalender Semester Genap</h2>

                    @if($file_genap)
                        @if(Str::endsWith(strtolower($file_genap), '.pdf'))
                            <iframe src="{{ Storage::url($file_genap) }}" class="w-full h-80 rounded-xl border border-slate-100 mb-4" frameborder="0"></iframe>
                        @else
                            <img src="{{ Storage::url($file_genap) }}" alt="Kalender Semester Genap" class="w-full max-h-80 rounded-xl object-contain mb-4 bg-slate-50 border border-slate-100">
                        @endif
                        <div class="pt-2">
                            <a href="{{ Storage::url($file_genap) }}" target="_blank" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800">
                                <span>Unduh / Buka Dokumen Lengkap</span>
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                    @else
                        <div class="p-8 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200 text-slate-500 text-xs mb-4">
                            Dokumen resmi Semester Genap sedang dalam tahap finalisasi kurikulum.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Detail Jadwal Kegiatan Akademik -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-slate-900 font-heading">Daftar Agenda Kegiatan Akademik</h2>
                <p class="text-xs md:text-sm text-slate-500">Rincian tanggal penting semester berjalan</p>
            </div>
            <a href="{{ url(app('tenant')->slug . '/agenda') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800">
                <span>Lihat Agenda Event & Seminar</span>
                <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($kalender as $item)
                @php
                    $tglAwal = \Carbon\Carbon::parse($item->tgl_mulai);
                @endphp
                <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm hover:shadow-md transition">
                    <div class="flex items-start space-x-3.5 mb-3">
                        <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-700 flex flex-col items-center justify-center shrink-0 border border-blue-100">
                            <span class="text-lg font-extrabold font-heading leading-none">{{ $tglAwal->translatedFormat('d') }}</span>
                            <span class="text-[10px] font-bold uppercase mt-0.5">{{ $tglAwal->translatedFormat('M') }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-bold text-slate-900 leading-snug line-clamp-2 font-heading">{{ $item->nama_kegiatan }}</h3>
                            <span class="text-xs text-slate-500 block mt-1">
                                @if($item->tgl_selesai && $item->tgl_selesai != $item->tgl_mulai)
                                    {{ $tglAwal->translatedFormat('d M') }} - {{ \Carbon\Carbon::parse($item->tgl_selesai)->translatedFormat('d M Y') }}
                                @else
                                    {{ $tglAwal->translatedFormat('d F Y') }}
                                @endif
                            </span>
                        </div>
                    </div>
                    @if($item->keterangan)
                        <p class="text-xs text-slate-600 pt-3 border-t border-slate-100 leading-relaxed">
                            {{ $item->keterangan }}
                        </p>
                    @endif
                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-200 p-6 text-slate-500 text-sm">
                    Belum ada kegiatan kalender akademik terdaftar.
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
