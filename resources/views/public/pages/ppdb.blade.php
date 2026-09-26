@extends('layouts.public')

@section('title', 'Penerimaan Peserta Didik Baru (PPDB)')

@section('content')
<!-- Header Section -->
<section class="relative pt-24 pb-16 md:pt-32 md:pb-24 overflow-hidden bg-slate-900">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover opacity-20" alt="Sekolah">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center space-x-2 bg-indigo-500/20 text-indigo-300 border border-indigo-400/30 px-3 py-1 md:px-4 md:py-1.5 rounded-full text-xs md:text-sm font-bold tracking-wider uppercase mb-4 md:mb-6 backdrop-blur-sm">
            <span>Pendaftaran Resmi</span>
        </div>
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-heading font-extrabold text-white mb-6 leading-tight drop-shadow-lg">
            PPDB <span class="text-indigo-400">{{ date('Y') }}/{{ date('Y') + 1 }}</span>
        </h1>
        <p class="text-lg md:text-2xl text-slate-300 max-w-3xl mx-auto mb-10 leading-relaxed">
            Bergabunglah bersama kami di {{ $sekolah['nama'] ?? 'Sekolah' }}. Daftarkan diri Anda sekarang dan jadilah bagian dari generasi unggul.
        </p>
        <div class="flex justify-center gap-4">
            <a href="#informasi" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 md:px-8 md:py-4 rounded-xl font-bold transition-all shadow-lg hover:shadow-indigo-500/50 hover:-translate-y-1">
                Informasi Pendaftaran
            </a>
            <a href="#" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white px-6 py-3 md:px-8 md:py-4 rounded-xl font-bold transition-all backdrop-blur-sm hover:-translate-y-1">
                Jadwal Seleksi
            </a>
        </div>
    </div>
</section>

<!-- Konten PPDB -->
<section id="informasi" class="py-16 md:py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 mb-12 border border-slate-100">
            @if(isset($halaman) && $halaman && $halaman->isi_konten)
                <div class="prose prose-slate prose-lg md:prose-xl max-w-none">
                    {!! $halaman->isi_konten !!}
                </div>
            @else
                <div class="text-center py-10">
                    <div class="w-20 h-20 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-4">Informasi PPDB Sedang Disusun</h3>
                    <p class="text-slate-500 max-w-2xl mx-auto mb-8">
                        Silakan kembali lagi nanti untuk mendapatkan informasi lengkap mengenai jadwal, persyaratan, dan alur pendaftaran penerimaan peserta didik baru tahun ajaran ini.
                    </p>
                    <a href="{{ url(app('tenant')->slug . '/') }}" class="text-indigo-600 font-bold hover:text-indigo-700 hover:underline">
                        &larr; Kembali ke Beranda
                    </a>
                </div>
            @endif
        </div>
        
    </div>
</section>
@endsection
