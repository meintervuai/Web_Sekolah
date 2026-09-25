@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section / Slider -->
<div class="relative w-full h-[90vh] min-h-[600px] xl:min-h-[700px] overflow-hidden group" x-data="{ currentSlide: 0, slides: {{ count($slider) > 0 ? count($slider) : 1 }} }" x-init="setInterval(() => { currentSlide = (currentSlide + 1) % slides }, 6000)">
    
    @if(count($slider) > 0)
        @foreach($slider as $index => $slide)
        <div class="absolute inset-0 transition-all duration-1000 ease-in-out"
             x-show="currentSlide === {{ $index }}"
             x-transition:enter="transition-opacity ease-out duration-1000"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition-opacity ease-in duration-1000"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <img src="{{ $slide->gambar ?? 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop' }}" alt="{{ $slide->judul ?? 'Slider' }}" class="w-full h-full object-cover">
            <!-- Premium Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/95 via-slate-900/60 to-transparent"></div>
        </div>
        @endforeach
    @else
        <!-- Fallback if no slider data -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop" alt="Sekolah" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/95 via-slate-900/60 to-transparent"></div>
        </div>
    @endif

    <div class="absolute inset-0 flex items-center z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative">
            @if(count($slider) > 0)
                @foreach($slider as $index => $slide)
                    <div x-show="currentSlide === {{ $index }}" 
                         class="max-w-3xl"
                         x-transition:enter="transition ease-out duration-1000 delay-300" 
                         x-transition:enter-start="opacity-0 translate-y-12" 
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="inline-flex items-center space-x-2 bg-white/10 border border-white/20 text-white px-5 py-2 rounded-full text-sm font-semibold tracking-wide mb-8 backdrop-blur-md shadow-[0_0_15px_rgba(255,255,255,0.1)]">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>Selamat Datang di {{ $sekolah['nama'] ?? 'Website Resmi' }}</span>
                        </div>
                        <h2 class="text-5xl md:text-7xl lg:text-8xl font-heading font-extrabold text-white mb-6 leading-tight tracking-tight drop-shadow-xl">
                            {{ $slide->judul ?? 'Membangun Generasi Unggul' }}
                        </h2>
                        <p class="text-lg md:text-2xl text-slate-200 mb-10 leading-relaxed font-light max-w-2xl text-shadow-sm border-l-4 theme-border pl-4">
                            {{ $slide->subjudul ?? 'Berkomitmen memberikan pendidikan vokasi terbaik untuk mencetak lulusan berkarakter dan siap kerja.' }}
                        </p>
                        <div class="flex flex-wrap gap-5">
                            @if(isset($slide->link_tombol) && $slide->link_tombol !== '#')
                            <a href="{{ $slide->link_tombol }}" class="theme-bg hover:theme-bg-dark text-white px-8 py-4 rounded-xl font-bold transition-all duration-300 shadow-xl shadow-indigo-900/50 flex items-center group transform hover:-translate-y-1">
                                {{ $slide->teks_tombol ?? 'Selengkapnya' }}
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            @endif
                            <a href="#profil" class="bg-white/10 hover:bg-white/20 backdrop-blur-lg text-white border border-white/30 px-8 py-4 rounded-xl font-bold transition-all duration-300 flex items-center hover:-translate-y-1">
                                Jelajahi Profil
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="max-w-3xl">
                    <h2 class="text-5xl md:text-7xl font-heading font-extrabold text-white mb-6 leading-tight drop-shadow-lg">
                        Website Resmi<br><span class="theme-text">{{ $sekolah['nama'] ?? 'Sekolah' }}</span>
                    </h2>
                    <p class="text-2xl text-slate-200 mb-10 leading-relaxed border-l-4 theme-border pl-4">
                        Pusat informasi dan layanan digital terpadu untuk civitas akademika dan masyarakat luas.
                    </p>
                    <a href="#profil" class="theme-bg hover:theme-bg-dark text-white px-8 py-4 rounded-xl font-bold transition-all shadow-xl hover:-translate-y-1">
                        Mulai Jelajah
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Slider Controls & Decorative Elements -->
    @if(count($slider) > 1)
    <div class="absolute bottom-12 left-0 right-0 flex justify-center space-x-4 z-20">
        @foreach($slider as $index => $slide)
        <button @click="currentSlide = {{ $index }}" 
                :class="{'w-16 theme-bg': currentSlide === {{ $index }}, 'w-4 bg-white/50 hover:bg-white': currentSlide !== {{ $index }}}" 
                class="h-1.5 rounded-full transition-all duration-500 cursor-pointer focus:outline-none shadow-lg"></button>
        @endforeach
    </div>
    @endif
    
    <!-- Abstract Bottom Decoration -->
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-slate-50 to-transparent z-10"></div>
</div>

<!-- Quick Actions & Stats Overlay -->
<div class="relative -mt-20 z-30 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
    <div class="bg-white/90 backdrop-blur-2xl rounded-3xl shadow-2xl p-2 flex flex-col md:flex-row justify-between items-stretch border border-white">
        <a href="/ppdb" class="flex-1 p-6 md:p-8 flex flex-col items-center justify-center text-center rounded-2xl hover:bg-slate-50 transition-colors group cursor-pointer border-b md:border-b-0 md:border-r border-slate-100">
            <div class="w-16 h-16 rounded-2xl theme-bg-light text-indigo-700 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-indigo-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-1">Informasi PPDB</h3>
            <p class="text-sm text-slate-500 font-medium">Pendaftaran Peserta Didik Baru</p>
        </a>
        <a href="#jurusan" class="flex-1 p-6 md:p-8 flex flex-col items-center justify-center text-center rounded-2xl hover:bg-slate-50 transition-colors group cursor-pointer border-b md:border-b-0 md:border-r border-slate-100">
            <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-emerald-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-1">Program Keahlian</h3>
            <p class="text-sm text-slate-500 font-medium">Jelajahi {{ $sekolah['jenjang'] ?? 'Jurusan' }} Kami</p>
        </a>
        <a href="/portal" class="flex-1 p-6 md:p-8 flex flex-col items-center justify-center text-center rounded-2xl hover:bg-slate-50 transition-colors group cursor-pointer">
            <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-amber-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-1">Portal E-Learning</h3>
            <p class="text-sm text-slate-500 font-medium">Sistem Pembelajaran Daring</p>
        </a>
    </div>
</div>

<!-- Profil Sambutan Kepala Sekolah -->
<section id="profil" class="py-16 md:py-24 bg-slate-50 relative overflow-hidden">
    <!-- Dekorasi Pattern Background -->
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(#4F46E5 2px, transparent 2px); background-size: 32px 32px;"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-16 xl:gap-24">
            
            <div class="w-full lg:w-5/12 flex justify-center relative">
                <!-- Frame / Badge absolute -->
                <div class="absolute -bottom-8 -right-8 bg-white/90 backdrop-blur-md p-5 rounded-2xl shadow-2xl z-20 border border-white flex items-center gap-5">
                    <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-bold uppercase tracking-wider">Terakreditasi</p>
                        <p class="text-3xl font-extrabold text-slate-800 font-heading">A <span class="text-base text-slate-500 font-medium">(Unggul)</span></p>
                    </div>
                </div>
                <!-- Foto Kepsek dengan Styling Premium -->
                <div class="relative z-10 rounded-3xl overflow-hidden border-[10px] border-white shadow-2xl group w-full max-w-sm">
                    @if(!empty($sekolah['foto_kepsek']))
                        <img src="{{ $sekolah['foto_kepsek'] }}" alt="Foto Kepala Sekolah" class="w-full h-auto object-cover aspect-[3/4] group-hover:scale-105 transition-transform duration-700">
                    @else
                        <img src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?q=80&w=2070&auto=format&fit=crop" alt="Kepala Sekolah Placeholder" class="w-full h-auto object-cover aspect-[3/4] group-hover:scale-105 transition-transform duration-700">
                    @endif
                    <!-- Inner overlay gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-60"></div>
                </div>
                <!-- Background Offset blob -->
                <div class="absolute inset-0 theme-bg rounded-3xl transform translate-x-6 translate-y-6 -z-10 opacity-20"></div>
                <div class="absolute -top-10 -left-10 w-32 h-32 theme-bg rounded-full blur-3xl opacity-30"></div>
            </div>
            
            <div class="w-full lg:w-7/12">
                <div class="inline-flex items-center space-x-2 bg-indigo-50 border border-indigo-100 text-indigo-700 px-4 py-1.5 rounded-full text-sm font-bold tracking-wider uppercase mb-4">
                    <span>Sambutan Pimpinan</span>
                </div>
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-heading font-extrabold text-slate-900 mb-6 leading-[1.15]">Mencetak Lulusan <span class="theme-text">Kompeten</span> & Berkarakter</h2>
                
                <div class="text-lg text-slate-600 mb-8 leading-relaxed space-y-4">
                    <p class="text-2xl text-slate-800 font-medium italic border-l-4 theme-border pl-6 mb-6">
                        "Pendidikan vokasi adalah kunci kemajuan bangsa. Kami mendidik tidak hanya skill teknis, tetapi juga karakter yang tangguh."
                    </p>
                    <p class="text-justify">
                        {{ $sekolah['sambutan'] ?? 'Selamat datang di website resmi sekolah kami. Kami berkomitmen untuk menyelenggarakan pendidikan vokasi berkualitas yang relevan dengan kebutuhan dunia kerja (Link and Match). Dengan dukungan fasilitas yang memadai dan tenaga pendidik profesional, kami siap mencetak generasi yang kompeten, inovatif, dan berakhlak mulia.' }}
                    </p>
                </div>
                
                <div class="flex items-center mt-10 pt-8 border-t border-slate-200">
                    <div>
                        <h4 class="text-2xl font-extrabold text-slate-900">{{ $sekolah['kepsek'] ?? 'H. Nama Kepala Sekolah, M.Pd.' }}</h4>
                        <p class="theme-text font-bold tracking-wide">Kepala Sekolah</p>
                    </div>
                    <div class="ml-auto hidden sm:block">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Signature_Placeholder.png" alt="Tanda Tangan" class="h-12 opacity-50 contrast-125 grayscale mix-blend-multiply">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistik Section (Antislop UI) -->
<section class="py-16 theme-bg text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black/10 mix-blend-multiply"></div>
    <!-- Abstract SVG Background -->
    <svg class="absolute top-0 right-0 transform translate-x-1/3 -translate-y-1/4 opacity-10" width="800" height="800" fill="none" viewBox="0 0 800 800"><circle cx="400" cy="400" r="400" fill="currentColor"/></svg>
    <svg class="absolute bottom-0 left-0 transform -translate-x-1/3 translate-y-1/4 opacity-10" width="600" height="600" fill="none" viewBox="0 0 800 800"><circle cx="400" cy="400" r="400" fill="currentColor"/></svg>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 divide-x divide-white/20">
            <div class="text-center px-4">
                <h4 class="text-5xl md:text-6xl font-heading font-extrabold mb-2">{{ $sekolah['stat_siswa'] ?? '1.200+' }}</h4>
                <p class="text-white/80 font-bold uppercase tracking-wider text-sm">Siswa Aktif</p>
            </div>
            <div class="text-center px-4">
                <h4 class="text-5xl md:text-6xl font-heading font-extrabold mb-2">{{ $sekolah['stat_guru'] ?? '85' }}</h4>
                <p class="text-white/80 font-bold uppercase tracking-wider text-sm">Tenaga Pendidik</p>
            </div>
            <div class="text-center px-4">
                <h4 class="text-5xl md:text-6xl font-heading font-extrabold mb-2">{{ $sekolah['stat_prestasi'] ?? '150+' }}</h4>
                <p class="text-white/80 font-bold uppercase tracking-wider text-sm">Penghargaan</p>
            </div>
            <div class="text-center px-4">
                <h4 class="text-5xl md:text-6xl font-heading font-extrabold mb-2">{{ $sekolah['stat_alumni'] ?? '5K+' }}</h4>
                <p class="text-white/80 font-bold uppercase tracking-wider text-sm">Alumni Sukses</p>
            </div>
        </div>
    </div>
</section>

<!-- Program Keahlian / Jurusan -->
<section id="jurusan" class="py-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="max-w-2xl">
                <div class="inline-flex items-center space-x-2 bg-indigo-50 border border-indigo-100 text-indigo-700 px-4 py-1.5 rounded-full text-sm font-bold tracking-wider uppercase mb-4">
                    <span>Kompetensi Keahlian</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-heading font-extrabold text-slate-900 leading-tight">Program Keahlian Unggulan</h2>
            </div>
            <div>
                <a href="/jurusan" class="group inline-flex items-center text-slate-600 font-bold hover:text-indigo-600 transition-colors">
                    Lihat Semua Jurusan 
                    <span class="ml-3 w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center group-hover:border-indigo-600 group-hover:bg-indigo-50 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @if(isset($jurusan) && count($jurusan) > 0)
                @foreach($jurusan as $j)
                <div class="group bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 flex flex-col h-full cursor-pointer relative">
                    <div class="h-64 bg-slate-200 relative overflow-hidden">
                        <img src="{{ $j->foto_utama ?? 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop' }}" alt="{{ $j->nama_jurusan }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 ease-in-out">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                        <div class="absolute top-4 right-4 w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-2xl shadow-lg border border-white/30 text-white transform group-hover:rotate-12 transition-transform">
                            {{ $j->ikon_atau_foto ?? '💻' }}
                        </div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <h3 class="font-heading font-bold text-2xl text-white leading-tight mb-2">{{ $j->nama_jurusan }}</h3>
                        </div>
                    </div>
                    <div class="p-8 flex flex-col flex-grow bg-white relative">
                        <!-- Floating badge -->
                        <div class="absolute -top-6 right-8 w-12 h-12 rounded-full theme-bg text-white flex items-center justify-center shadow-lg transform scale-0 group-hover:scale-100 transition-transform duration-300 ease-out">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                        <p class="text-slate-600 mb-6 flex-grow line-clamp-3 text-lg leading-relaxed">{{ $j->deskripsi_singkat ?? 'Program keahlian yang mendidik siswa menjadi tenaga profesional dan siap menghadapi dunia industri modern.' }}</p>
                        <a href="/jurusan/{{ $j->slug ?? '#' }}" class="inline-flex items-center font-bold theme-text uppercase tracking-wider text-sm group-hover:theme-text-dark transition-colors mt-auto">
                            Pelajari Kurikulum
                        </a>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Fallback dummy data if no jurusan found -->
                @for($i=1; $i<=3; $i++)
                <div class="group bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 flex flex-col h-full cursor-pointer relative">
                    <div class="h-64 bg-slate-200 relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                        <div class="absolute top-4 right-4 w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-2xl shadow-lg border border-white/30 text-white transform group-hover:rotate-12 transition-transform">
                            💻
                        </div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <h3 class="font-heading font-bold text-2xl text-white leading-tight mb-2">Rekayasa Perangkat Lunak</h3>
                        </div>
                    </div>
                    <div class="p-8 flex flex-col flex-grow bg-white relative">
                        <div class="absolute -top-6 right-8 w-12 h-12 rounded-full theme-bg text-white flex items-center justify-center shadow-lg transform scale-0 group-hover:scale-100 transition-transform duration-300 ease-out">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                        <p class="text-slate-600 mb-6 flex-grow text-lg leading-relaxed">Mendidik tenaga profesional di bidang pemrograman, pengembangan aplikasi web dan mobile dengan standar industri.</p>
                        <a href="#" class="inline-flex items-center font-bold theme-text uppercase tracking-wider text-sm">Pelajari Kurikulum</a>
                    </div>
                </div>
                @endfor
            @endif
        </div>
    </div>
</section>

<!-- Berita & Informasi Berita Terbaru -->
<section class="py-24 bg-slate-50 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 max-w-3xl mx-auto">
            <div class="inline-flex items-center space-x-2 bg-indigo-50 border border-indigo-100 text-indigo-700 px-4 py-1.5 rounded-full text-sm font-bold tracking-wider uppercase mb-4">
                <span>Pusat Informasi</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-heading font-extrabold text-slate-900 mb-6">Kabar & Agenda Terbaru</h2>
            <p class="text-xl text-slate-600">Ikuti perkembangan terbaru, prestasi, dan kegiatan menarik dari civitas akademika kami.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @if(isset($berita) && count($berita) > 0)
                @foreach($berita as $item)
                <article class="flex flex-col group bg-white rounded-3xl p-4 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="aspect-[16/10] rounded-2xl overflow-hidden bg-slate-100 mb-6 relative">
                        <img src="{{ $item->gambar_sampul ?? 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop' }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @if($item->is_pengumuman ?? false)
                        <div class="absolute top-4 left-4 bg-amber-500/90 backdrop-blur-sm text-white text-xs font-bold px-4 py-2 rounded-lg shadow-lg uppercase tracking-wider">
                            Pengumuman
                        </div>
                        @else
                        <div class="absolute top-4 left-4 theme-bg-light/90 backdrop-blur-sm theme-text text-xs font-bold px-4 py-2 rounded-lg shadow-lg uppercase tracking-wider">
                            Berita
                        </div>
                        @endif
                    </div>
                    <div class="px-4 pb-4 flex-grow flex flex-col">
                        <div class="flex items-center text-sm text-slate-500 mb-4 font-medium font-mono">
                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ \Carbon\Carbon::parse($item->tgl_publikasi)->translatedFormat('d M Y') }}
                        </div>
                        <h3 class="font-heading font-extrabold text-2xl text-slate-900 mb-4 line-clamp-2 group-hover:theme-text transition-colors leading-tight">
                            <a href="/berita/{{ $item->slug ?? '#' }}" class="focus:outline-none before:absolute before:inset-0">
                                {{ $item->judul }}
                            </a>
                        </h3>
                        <p class="text-slate-600 line-clamp-2 mb-6 text-base leading-relaxed flex-grow">
                            {{ $item->ringkasan ?? Str::limit(strip_tags($item->isi_konten), 100) }}
                        </p>
                        <div class="border-t border-slate-100 pt-4 flex items-center justify-between mt-auto">
                            <span class="text-sm font-bold theme-text uppercase tracking-wider group-hover:underline">Baca Artikel</span>
                            <svg class="w-5 h-5 text-slate-400 group-hover:theme-text transform group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </div>
                </article>
                @endforeach
            @else
                <div class="col-span-3 text-center py-20 bg-white rounded-3xl border border-slate-200 border-dashed">
                    <svg class="mx-auto h-12 w-12 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                    <h3 class="text-lg font-medium text-slate-900">Belum ada publikasi</h3>
                    <p class="mt-1 text-slate-500">Berita dan informasi terbaru akan segera hadir.</p>
                </div>
            @endif
        </div>
        
        <div class="mt-16 text-center">
            <a href="/berita" class="inline-flex items-center justify-center px-10 py-4 border-2 theme-border text-lg font-bold rounded-xl theme-text bg-transparent hover:theme-bg hover:text-white transition-all transform hover:-translate-y-1 shadow-lg hover:shadow-indigo-200">
                Lihat Indeks Berita Lengkap
            </a>
        </div>
    </div>
</section>

<!-- Call to Action PPDB Premium -->
<section class="relative py-32 theme-bg overflow-hidden mt-10">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop" alt="Background PPDB" class="w-full h-full object-cover opacity-20">
        <div class="absolute inset-0 bg-black/60 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
    </div>
    
    <!-- Floating geometric shapes -->
    <div class="absolute top-10 left-10 w-32 h-32 border-4 border-white/10 rounded-full animate-spin-slow"></div>
    <div class="absolute bottom-10 right-20 w-48 h-48 border-4 border-white/10 rounded-xl transform rotate-45"></div>

    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
        <div class="inline-block bg-white/20 backdrop-blur-md px-6 py-2 rounded-full text-white font-bold tracking-widest uppercase mb-8 border border-white/30 shadow-xl">
            Tahun Ajaran 2026/2027
        </div>
        <h2 class="text-5xl md:text-7xl font-heading font-extrabold text-white mb-8 drop-shadow-2xl">Penerimaan Peserta Didik Baru (PPDB)</h2>
        <p class="text-2xl text-slate-200 mb-12 max-w-3xl mx-auto font-light">
            Segera bergabung bersama kami. Wujudkan potensi terbaikmu dan persiapkan diri menghadapi tantangan global di masa depan.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-6">
            <a href="/ppdb" class="inline-flex items-center justify-center px-10 py-5 border border-transparent text-xl font-extrabold rounded-2xl theme-text bg-white hover:bg-slate-50 shadow-2xl transition-all transform hover:-translate-y-2 hover:scale-105">
                Daftar Sekarang
                <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
            <a href="/brosur" class="inline-flex items-center justify-center px-10 py-5 border-2 border-white/80 text-xl font-bold rounded-2xl text-white bg-white/10 backdrop-blur-sm hover:bg-white/20 transition-all">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Unduh Brosur
            </a>
        </div>
    </div>
</section>
@endsection
