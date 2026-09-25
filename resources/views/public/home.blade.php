@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section / Slider -->
<div class="relative bg-slate-900 h-[80vh] min-h-[500px] flex items-center justify-center overflow-hidden" x-data="{ currentSlide: 0, slides: {{ count($slider) }} }" x-init="setInterval(() => { currentSlide = (currentSlide + 1) % slides }, 6000)">
    @foreach($slider as $index => $slide)
    <div class="absolute inset-0 transition-opacity duration-1000"
         x-show="currentSlide === {{ $index }}"
         x-transition:enter="transition-opacity ease-out duration-1000"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-1000"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <img src="{{ $slide['gambar'] }}" alt="Hero" class="w-full h-full object-cover">
        <div class="absolute inset-0 hero-overlay"></div>
    </div>
    @endforeach

    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto mt-12">
        <span class="inline-block py-1 px-3 rounded-full bg-indigo-600/30 text-indigo-200 border border-indigo-500/30 text-sm font-semibold tracking-wider mb-4 uppercase backdrop-blur-sm shadow-sm" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 300)" x-show="shown" x-transition.duration.700ms>
            Selamat Datang di Portal Resmi
        </span>
        @foreach($slider as $index => $slide)
            <div x-show="currentSlide === {{ $index }}" x-transition:enter="transition ease-out duration-700 delay-300" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                <h2 class="text-4xl md:text-6xl font-heading font-extrabold text-white leading-tight mb-6 drop-shadow-lg">
                    {{ $slide['judul'] }}
                </h2>
                <p class="text-lg md:text-xl text-slate-200 mb-10 max-w-2xl mx-auto drop-shadow">
                    {{ $slide['subjudul'] }}
                </p>
            </div>
        @endforeach
        
        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="#profil" class="bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-3.5 rounded-full font-semibold transition-all shadow-lg shadow-indigo-600/30 hover:-translate-y-1">
                Jelajahi Profil
            </a>
            <a href="#" class="bg-white/10 hover:bg-white/20 text-white border border-white/30 backdrop-blur-sm px-8 py-3.5 rounded-full font-semibold transition-all hover:-translate-y-1">
                Info PPDB
            </a>
        </div>
    </div>
    
    <!-- Slider Indicators -->
    <div class="absolute bottom-8 left-0 right-0 flex justify-center space-x-2 z-20">
        @foreach($slider as $index => $slide)
        <button @click="currentSlide = {{ $index }}" 
                :class="{'w-8 bg-indigo-500': currentSlide === {{ $index }}, 'w-2 bg-white/50 hover:bg-white/80': currentSlide !== {{ $index }}}" 
                class="h-2 rounded-full transition-all duration-300"></button>
        @endforeach
    </div>
</div>

<!-- Sambutan Kepala Sekolah -->
<section id="profil" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            <div class="w-full lg:w-5/12 relative">
                <div class="absolute -inset-4 bg-indigo-100 rounded-3xl transform -rotate-3 z-0"></div>
                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=800&auto=format&fit=crop" alt="Kepala Sekolah" class="relative z-10 w-full h-[500px] object-cover rounded-2xl shadow-xl">
                <div class="absolute bottom-6 -right-6 bg-white p-4 rounded-xl shadow-xl z-20 flex items-center gap-4 border border-slate-100">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Akreditasi</p>
                        <p class="font-bold text-slate-900 text-lg">A (Unggul)</p>
                    </div>
                </div>
            </div>
            
            <div class="w-full lg:w-7/12">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-12 h-1 bg-indigo-600 rounded-full"></span>
                    <h3 class="text-indigo-600 font-bold uppercase tracking-wider text-sm">Sambutan Kepala Sekolah</h3>
                </div>
                <h2 class="text-3xl md:text-4xl font-heading font-bold text-slate-900 mb-6 leading-tight">
                    Mencetak Lulusan yang Siap Menghadapi <span class="text-indigo-600">Tantangan Global</span>
                </h2>
                <div class="prose prose-lg text-slate-600 mb-8">
                    <p class="lead">
                        {{ $sekolah['sambutan'] }}
                    </p>
                    <p>
                        Kami berkomitmen untuk tidak hanya memberikan pengetahuan akademis, tetapi juga keterampilan vokasi yang relevan dengan kebutuhan industri saat ini, dipadukan dengan pembentukan karakter mulia.
                    </p>
                </div>
                
                <div class="pt-6 border-t border-slate-200">
                    <p class="font-bold text-xl text-slate-900">{{ $sekolah['kepsek'] }}</p>
                    <p class="text-indigo-600 font-medium">Kepala {{ $sekolah['nama'] }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistik Sekolah -->
<section class="py-16 bg-indigo-900 text-white relative overflow-hidden">
    <!-- Dekorasi -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-400 opacity-20 rounded-full blur-3xl transform -translate-x-1/2 translate-y-1/2"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="p-4">
                <div class="text-4xl md:text-5xl font-heading font-bold mb-2 text-indigo-300">1.200+</div>
                <div class="text-indigo-100 font-medium">Siswa Aktif</div>
            </div>
            <div class="p-4">
                <div class="text-4xl md:text-5xl font-heading font-bold mb-2 text-indigo-300">85</div>
                <div class="text-indigo-100 font-medium">Guru & Staf</div>
            </div>
            <div class="p-4">
                <div class="text-4xl md:text-5xl font-heading font-bold mb-2 text-indigo-300">4</div>
                <div class="text-indigo-100 font-medium">Program Keahlian</div>
            </div>
            <div class="p-4">
                <div class="text-4xl md:text-5xl font-heading font-bold mb-2 text-indigo-300">95%</div>
                <div class="text-indigo-100 font-medium">Serapan Kerja</div>
            </div>
        </div>
    </div>
</section>

<!-- Program Keahlian / Jurusan -->
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <div class="flex items-center justify-center gap-3 mb-4">
                <span class="w-8 h-1 bg-indigo-600 rounded-full"></span>
                <h3 class="text-indigo-600 font-bold uppercase tracking-wider text-sm">Program Keahlian</h3>
                <span class="w-8 h-1 bg-indigo-600 rounded-full"></span>
            </div>
            <h2 class="text-3xl md:text-4xl font-heading font-bold text-slate-900 mb-4">Kompetensi Jurusan</h2>
            <p class="text-slate-600">Pilihan program keahlian yang disesuaikan dengan kebutuhan industri masa kini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($jurusan as $j)
            <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-slate-100 transition-all duration-300 group hover:-translate-y-2">
                <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                    {{ $j['ikon'] }}
                </div>
                <h3 class="font-heading font-bold text-xl text-slate-900 mb-3">{{ $j['nama'] }}</h3>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">{{ $j['deskripsi'] }}</p>
                <a href="#" class="text-indigo-600 font-medium text-sm flex items-center group-hover:text-indigo-700">
                    Detail Jurusan
                    <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Berita Terbaru -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-12">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-12 h-1 bg-indigo-600 rounded-full"></span>
                    <h3 class="text-indigo-600 font-bold uppercase tracking-wider text-sm">Publikasi</h3>
                </div>
                <h2 class="text-3xl md:text-4xl font-heading font-bold text-slate-900">Berita Terbaru</h2>
            </div>
            <a href="#" class="hidden sm:flex items-center text-indigo-600 font-semibold hover:text-indigo-700 transition">
                Lihat Semua Berita
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($berita as $item)
            <div class="bg-white rounded-2xl overflow-hidden shadow-md border border-slate-100 group">
                <div class="relative overflow-hidden h-56">
                    <img src="{{ $item['gambar'] }}" alt="{{ $item['judul'] }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm text-indigo-700 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                        {{ $item['tanggal'] }}
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="font-heading font-bold text-xl text-slate-900 mb-3 group-hover:text-indigo-600 transition-colors line-clamp-2">
                        <a href="#">{{ $item['judul'] }}</a>
                    </h3>
                    <p class="text-slate-600 text-sm mb-4 line-clamp-3">
                        Informasi selengkapnya mengenai berita ini dapat Anda baca pada halaman detail. Kami terus memberikan pembaruan tentang aktivitas sekolah.
                    </p>
                    <a href="#" class="text-indigo-600 font-medium text-sm flex items-center hover:text-indigo-700">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-8 text-center sm:hidden">
            <a href="#" class="inline-flex items-center text-indigo-600 font-semibold border border-indigo-200 px-6 py-2.5 rounded-full hover:bg-indigo-50 transition">
                Lihat Semua Berita
            </a>
        </div>
    </div>
</section>

<!-- CTA PPDB -->
<section class="py-16 bg-gradient-to-r from-indigo-600 to-indigo-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center bg-white/10 backdrop-blur-md rounded-3xl p-10 border border-white/20">
            <div class="mb-8 md:mb-0 md:mr-8 text-center md:text-left">
                <h2 class="text-3xl md:text-4xl font-heading font-bold text-white mb-4">Mari Bergabung Bersama Kami!</h2>
                <p class="text-indigo-100 text-lg max-w-2xl">
                    Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran 2026/2027 telah dibuka. Daftarkan diri Anda sekarang dan jadilah bagian dari generasi vokasi juara.
                </p>
            </div>
            <div class="shrink-0">
                <a href="#" class="bg-white text-indigo-700 hover:bg-slate-50 px-8 py-4 rounded-full font-bold text-lg transition-all shadow-lg hover:shadow-xl inline-flex items-center">
                    Daftar PPDB Sekarang
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
