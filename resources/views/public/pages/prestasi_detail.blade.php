@extends('layouts.public')

@section('title', $prestasi->judul_prestasi . ' - Prestasi ' . $sekolah['nama'])
@section('meta_description', 'Pencapaian membanggakan: ' . $prestasi->judul_prestasi . ' diraih oleh ' . ($prestasi->nama_siswa ?? 'siswa') . ' di ' . $sekolah['nama'])

@section('content')
<!-- Breadcrumbs -->
<section class="bg-slate-100 py-4 border-b border-slate-200">
    <div class="container-custom">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-500 overflow-x-auto hide-scrollbar">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-blue-600 transition">Beranda</a></li>
                <li><span>/</span></li>
                <li><a href="{{ url(app('tenant')->slug . '/prestasi') }}" class="hover:text-blue-600 transition">Prestasi</a></li>
                <li><span>/</span></li>
                <li class="text-slate-800 font-semibold truncate max-w-xs md:max-w-md">{{ $prestasi->judul_prestasi }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Detail -->
<section class="section-py bg-white">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            
            <!-- Left: Main Achievement Info (8 cols) -->
            <div class="lg:col-span-8">
                <!-- Badges -->
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-900 border border-amber-300">
                        🏆 {{ $prestasi->juara ?? 'Juara' }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                        Tingkat {{ $prestasi->tingkat ?? 'Nasional' }}
                    </span>
                    <span class="text-xs text-slate-400">
                        Tahun {{ $prestasi->tahun ?? \Carbon\Carbon::parse($prestasi->tanggal)->format('Y') }}
                    </span>
                </div>

                <!-- Title -->
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-900 leading-tight font-heading mb-6">
                    {{ $prestasi->judul_prestasi }}
                </h1>

                <!-- Photo with Lightbox -->
                @if($prestasi->foto)
                <div class="mb-8 rounded-2xl overflow-hidden bg-slate-100 shadow-sm border border-slate-100 relative group">
                    <img src="{{ $prestasi->foto }}" 
                         alt="{{ $prestasi->judul_prestasi }}" 
                         class="w-full h-auto max-h-[460px] object-cover cursor-pointer"
                         @click="lightboxOpen = true; lightboxSrc = '{{ $prestasi->foto }}'; lightboxCaption = '{{ addslashes($prestasi->judul_prestasi) }}'">
                    <div class="p-3 bg-slate-50 border-t border-slate-100 text-center text-xs text-slate-500 italic">
                        Foto Penyerahan Penghargaan & Dokumentasi Kompetisi (Klik untuk memperbesar)
                    </div>
                </div>
                @endif

                <!-- Winner & Details Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8 bg-slate-50 p-6 rounded-2xl border border-slate-200/80">
                    <div>
                        <span class="text-xs text-slate-400 block mb-1">Nama Peraih Prestasi:</span>
                        <strong class="text-sm md:text-base text-slate-900 font-bold block">{{ $prestasi->nama_siswa ?? 'Siswa SMKN 2 Bandung' }}</strong>
                        @if($prestasi->kelas)
                        <span class="text-xs text-slate-500 block">Kelas: {{ $prestasi->kelas }}</span>
                        @endif
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block mb-1">Penyelenggara Kegiatan:</span>
                        <strong class="text-sm md:text-base text-slate-900 font-bold block">{{ $prestasi->penyelenggara ?? 'Kementerian / Lembaga Terkait' }}</strong>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block mb-1">Tanggal Raihan:</span>
                        <strong class="text-xs md:text-sm text-slate-800 font-semibold block">{{ \Carbon\Carbon::parse($prestasi->tanggal)->translatedFormat('l, d F Y') }}</strong>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block mb-1">Tingkat Perlombaan:</span>
                        <strong class="text-xs md:text-sm text-slate-800 font-semibold block">Tingkat {{ $prestasi->tingkat ?? 'Nasional' }}</strong>
                    </div>
                </div>

                <!-- Story / Description -->
                <div class="prose prose-slate max-w-none prose-p:text-slate-700 prose-p:leading-relaxed mb-8">
                    <h2 class="text-xl font-bold text-slate-900 font-heading mb-3">Tentang Pencapaian</h2>
                    <p class="whitespace-pre-line text-sm md:text-base text-slate-700 leading-relaxed">
                        {{ $prestasi->deskripsi ?? 'Pencapaian luar biasa ini merupakan hasil dari dedikasi dan kerja keras para peserta didik serta bimbingan intensif dari guru pembina kejuruan di SMK Negeri 2 Bandung. Prestasi ini semakin mempertegas komitmen sekolah dalam menghasilkan lulusan vokasi yang kompeten dan unggul.' }}
                    </p>
                </div>

                <!-- Back button -->
                <div class="pt-6 border-t border-slate-200">
                    <a href="{{ url(app('tenant')->slug . '/prestasi') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Seluruh Prestasi
                    </a>
                </div>
            </div>

            <!-- Right: Sidebar (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Prestasi Lainnya -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200/80">
                    <h3 class="text-base font-bold text-slate-900 font-heading mb-4 pb-3 border-b border-slate-200">
                        Prestasi Lainnya
                    </h3>
                    <div class="space-y-4">
                        @forelse($prestasiLainnya as $pl)
                        <div class="flex items-start space-x-3 group">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-sm shrink-0">
                                🏆
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="text-[10px] font-bold text-amber-700 uppercase block">
                                    {{ $pl->juara }} • {{ $pl->tingkat }}
                                </span>
                                <h4 class="text-xs font-bold text-slate-800 group-hover:text-blue-600 transition line-clamp-2">
                                    <a href="{{ url(app('tenant')->slug . '/prestasi/' . $pl->slug) }}">
                                        {{ $pl->judul_prestasi }}
                                    </a>
                                </h4>
                                <span class="text-[11px] text-slate-400 block mt-0.5 truncate">
                                    {{ $pl->nama_siswa }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <p class="text-xs text-slate-400 italic">Belum ada prestasi lainnya.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Box Support Bakat Siswa -->
                <div class="bg-blue-50 border border-blue-200/70 rounded-2xl p-6">
                    <h4 class="font-bold text-blue-950 font-heading text-sm mb-2">Pengembangan Minat & Bakat</h4>
                    <p class="text-xs text-blue-800 leading-relaxed mb-4">SMK Negeri 2 Bandung memfasilitasi pembinaan intensif untuk ajang LKS, olimpiade sains terapan, seni, dan olahraga.</p>
                    <a href="{{ url(app('tenant')->slug . '/ekstrakurikuler') }}" class="inline-flex items-center text-xs font-bold text-blue-700 hover:text-blue-900">
                        <span>Lihat Ekstrakurikuler &raquo;</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
