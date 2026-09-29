@extends('layouts.public')

@section('title', 'Prestasi Siswa & Sekolah - ' . $sekolah['nama'])
@section('meta_description', 'Koleksi prestasi membanggakan siswa-siswi ' . $sekolah['nama'] . ' di tingkat Kota, Provinsi, Nasional, dan Internasional.')

@section('content')
<!-- Header & Breadcrumb -->
<section class="theme-bg-dark text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(var(--theme-accent)_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium">Prestasi Sekolah</li>
            </ol>
        </nav>
        <div class="max-w-2xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3">
                Jejak Prestasi Siswa
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed">
                Bukti nyata dedikasi, keterampilan vokasi, dan semangat juang siswa-siswi {{ $sekolah['nama'] }} di berbagai kompetisi bergengsi.
            </p>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="bg-white border-b border-slate-200/80 sticky top-16 z-30 shadow-xs">
    <div class="container-custom py-4">
        <form method="GET" action="{{ url(app('tenant')->slug . '/prestasi') }}" class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-2 text-xs">
                <!-- Tingkat Filter Pills -->
                <a href="{{ url(app('tenant')->slug . '/prestasi' . (request('tahun') ? '?tahun=' . request('tahun') : '')) }}" 
                   class="px-3.5 py-1.5 rounded-full font-medium transition {{ !request('tingkat') ? 'theme-btn-primary shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Semua Tingkat
                </a>
                @foreach($daftarTingkat as $t)
                <a href="{{ url(app('tenant')->slug . '/prestasi?tingkat=' . $t . (request('tahun') ? '&tahun=' . request('tahun') : '')) }}" 
                   class="px-3.5 py-1.5 rounded-full font-medium transition {{ request('tingkat') === $t ? 'theme-btn-primary shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Tingkat {{ $t }}
                </a>
                @endforeach
            </div>

            <!-- Tahun Selector -->
            @if(count($daftarTahun) > 0)
            <div class="flex items-center space-x-2 text-xs">
                <span class="text-slate-500 font-medium">Tahun:</span>
                <select name="tahun" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs text-slate-800 font-medium focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Tahun</option>
                    @foreach($daftarTahun as $thn)
                    <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                    @endforeach
                </select>
                @if(request('tingkat'))
                    <input type="hidden" name="tingkat" value="{{ request('tingkat') }}">
                @endif
            </div>
            @endif
        </form>
    </div>
</section>

<!-- Prestasi Grid Section -->
<section class="section-py bg-slate-50">
    <div class="container-custom">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @forelse($prestasi as $item)
            <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-xs hover:shadow-md transition duration-200 flex flex-col h-full group">
                <!-- Thumbnail -->
                <div class="aspect-4/3 w-full overflow-hidden bg-slate-100 relative">
                    <img src="{{ $item->foto ?? 'https://images.unsplash.com/photo-1578269174936-2709b6aeb913?q=80&w=800&auto=format&fit=crop' }}" 
                         alt="{{ $item->judul_prestasi }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    
                    <!-- Tingkat Badge -->
                    <span class="absolute top-3 left-3 bg-amber-500 text-slate-950 font-extrabold text-[11px] px-2.5 py-1 rounded-full shadow-xs">
                        {{ $item->tingkat ?? 'Nasional' }}
                    </span>

                    <!-- Tahun Badge -->
                    <span class="absolute bottom-3 left-3 text-white text-xs font-semibold">
                        Tahun {{ $item->tahun ?? \Carbon\Carbon::parse($item->tanggal)->format('Y') }}
                    </span>
                </div>

                <div class="p-5 md:p-6 flex-1 flex flex-col">
                    <div class="mb-2">
                        <span class="inline-block text-xs font-extrabold text-blue-600 uppercase tracking-wider">
                            {{ $item->juara ?? 'Juara' }}
                        </span>
                    </div>

                    <h2 class="text-base md:text-lg font-bold text-slate-900 group-hover:text-blue-600 transition font-heading mb-2 line-clamp-2">
                        <a href="{{ url(app('tenant')->slug . '/prestasi/' . $item->slug) }}">
                            {{ $item->judul_prestasi }}
                        </a>
                    </h2>

                    <!-- Winner Info -->
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 mb-4 text-xs text-slate-600 space-y-1">
                        <div class="flex items-center text-slate-800 font-semibold truncate">
                            <svg class="w-3.5 h-3.5 mr-1.5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>{{ $item->nama_siswa ?? 'Tim Siswa SMKN 2' }}</span>
                        </div>
                        @if($item->penyelenggara)
                        <div class="text-[11px] text-slate-500 truncate">
                            Penyelenggara: {{ $item->penyelenggara }}
                        </div>
                        @endif
                    </div>

                    <div class="mt-auto pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</span>
                        <a href="{{ url(app('tenant')->slug . '/prestasi/' . $item->slug) }}" 
                           class="inline-flex items-center text-xs font-bold text-blue-600 group-hover:text-blue-700 transition">
                            <span>Detail Prestasi</span>
                            <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-200/80 p-8">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-800 font-heading mb-1">Data Prestasi Belum Ditemukan</h3>
                <p class="text-xs md:text-sm text-slate-500 max-w-sm mx-auto mb-4">Tidak ada data prestasi yang cocok dengan tingkat atau tahun yang dipilih.</p>
                <a href="{{ url(app('tenant')->slug . '/prestasi') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 transition">
                    Lihat Semua Prestasi
                </a>
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $prestasi->links() }}
        </div>
    </div>
</section>
@endsection
