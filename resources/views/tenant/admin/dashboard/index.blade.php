@extends('layouts.tenant_admin')

@section('title', 'Dashboard')
@section('header_title', 'Ringkasan Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Welcome Banner Card (Human-crafted Institutional Solid Navy) -->
    <div class="rounded-2xl p-6 sm:p-7 bg-slate-900 text-white border border-slate-800 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20 mb-3">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                <span>Pusat Kendali CMS Aktif</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-white">
                Selamat Datang di Panel CMS {{ $tenant->nama_sekolah }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1.5 max-w-2xl leading-relaxed">
                Kelola informasi publik sekolah, artikel berita, jurusan, fasilitas, serta data kontak secara terpusat dan langsung terhubung dengan database website publik.
            </p>
        </div>
        <div class="shrink-0 flex flex-wrap gap-2.5 relative z-10">
            <a 
                href="{{ route('tenant.admin.pengaturan.index', ['tenant' => $tenant->slug]) }}" 
                class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs shadow-xs transition inline-flex items-center gap-1.5"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit Informasi Sekolah
            </a>
            <a 
                href="{{ url($tenant->slug) }}" 
                target="_blank" 
                class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 font-bold text-xs transition inline-flex items-center gap-1.5"
            >
                <span>Buka Website Publik</span>
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>
    </div>

    <!-- Quick Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- Berita & Artikel -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Berita Publik</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-bold text-slate-900">{{ $stat['total_berita'] }}</span>
                <span class="text-xs text-slate-400 block mt-0.5">Artikel Terpublikasi</span>
            </div>
        </div>

        <!-- Pengumuman Resmi -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Pengumuman</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-bold text-slate-900">{{ $stat['total_pengumuman'] }}</span>
                <span class="text-xs text-slate-400 block mt-0.5">Pengumuman Aktif</span>
            </div>
        </div>

        <!-- Program Keahlian / Jurusan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Program Keahlian</span>
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-bold text-slate-900">{{ $stat['total_jurusan'] }}</span>
                <span class="text-xs text-slate-400 block mt-0.5">Konsentrasi Keahlian</span>
            </div>
        </div>

        <!-- Pesan Masuk Pengunjung -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Pesan Masuk</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-2xl font-bold text-slate-900">{{ $stat['pesan_belum_dibaca'] }}</span>
                @if($stat['pesan_belum_dibaca'] > 0)
                    <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Belum Dibaca</span>
                @else
                    <span class="text-xs text-slate-400">Semua Terbaca</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Modul Pengaturan Konten Per Navigasi Website -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-6">
        <div class="mb-5">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Modul Pengaturan Konten Per Navigasi Publik</h3>
            <p class="text-xs text-slate-500 mt-0.5">Pilih menu navigasi di bawah ini untuk mengedit teks, gambar, dan data yang tampil langsung di website sekolah.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- 1. Beranda -->
            <a href="{{ route('tenant.admin.slider.index', ['tenant' => $tenant->slug]) }}" class="p-4 rounded-xl border border-slate-100 hover:border-blue-200 bg-slate-50/50 hover:bg-blue-50/30 transition group flex items-start gap-3.5">
                <div class="w-9 h-9 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-xs group-hover:text-blue-700">1. Navigasi Beranda</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">Slider banner utama, statistik angka, dan sambutan.</p>
                </div>
            </a>

            <!-- 2. Profil -->
            <a href="{{ route('tenant.admin.profil.index', ['tenant' => $tenant->slug]) }}" class="p-4 rounded-xl border border-slate-100 hover:border-blue-200 bg-slate-50/50 hover:bg-blue-50/30 transition group flex items-start gap-3.5">
                <div class="w-9 h-9 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-xs group-hover:text-blue-700">2. Navigasi Profil</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">Visi misi, sejarah perjalanan, dan bagan struktur organisasi.</p>
                </div>
            </a>

            <!-- 3. Program Keahlian -->
            <a href="{{ route('tenant.admin.jurusan.index', ['tenant' => $tenant->slug]) }}" class="p-4 rounded-xl border border-slate-100 hover:border-blue-200 bg-slate-50/50 hover:bg-blue-50/30 transition group flex items-start gap-3.5">
                <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-xs group-hover:text-blue-700">3. Program Keahlian</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">7 jurusan kejuruan, silabus vokasi, dan prospek kerja.</p>
                </div>
            </a>

            <!-- 4. Informasi -->
            <a href="{{ route('tenant.admin.berita.index', ['tenant' => $tenant->slug]) }}" class="p-4 rounded-xl border border-slate-100 hover:border-blue-200 bg-slate-50/50 hover:bg-blue-50/30 transition group flex items-start gap-3.5">
                <div class="w-9 h-9 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-xs group-hover:text-blue-700">4. Navigasi Informasi</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">Berita sekolah, pengumuman resmi, agenda, dan galeri.</p>
                </div>
            </a>

            <!-- 5. Kesiswaan -->
            <a href="{{ route('tenant.admin.prestasi.index', ['tenant' => $tenant->slug]) }}" class="p-4 rounded-xl border border-slate-100 hover:border-blue-200 bg-slate-50/50 hover:bg-blue-50/30 transition group flex items-start gap-3.5">
                <div class="w-9 h-9 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-xs group-hover:text-blue-700">5. Navigasi Kesiswaan</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">Prestasi juara siswa dan ragam ekstrakurikuler.</p>
                </div>
            </a>

            <!-- 6. Guru & Staf -->
            <a href="{{ route('tenant.admin.guru.index', ['tenant' => $tenant->slug]) }}" class="p-4 rounded-xl border border-slate-100 hover:border-blue-200 bg-slate-50/50 hover:bg-blue-50/30 transition group flex items-start gap-3.5">
                <div class="w-9 h-9 rounded-lg bg-cyan-100 text-cyan-700 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-xs group-hover:text-blue-700">6. Guru & Staf</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">Direktori tenaga pendidik dan staf tata usaha.</p>
                </div>
            </a>

            <!-- 7. Fasilitas -->
            <a href="{{ route('tenant.admin.fasilitas.index', ['tenant' => $tenant->slug]) }}" class="p-4 rounded-xl border border-slate-100 hover:border-blue-200 bg-slate-50/50 hover:bg-blue-50/30 transition group flex items-start gap-3.5">
                <div class="w-9 h-9 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-xs group-hover:text-blue-700">7. Fasilitas Sekolah</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">Laboratorium komputer, bengkel mesin, dan sarpras.</p>
                </div>
            </a>

            <!-- 8. SPMB 2026 -->
            <a href="{{ route('tenant.admin.spmb.index', ['tenant' => $tenant->slug]) }}" class="p-4 rounded-xl border border-slate-100 hover:border-blue-200 bg-slate-50/50 hover:bg-blue-50/30 transition group flex items-start gap-3.5">
                <div class="w-9 h-9 rounded-lg bg-violet-100 text-violet-700 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-xs group-hover:text-blue-700">8. Navigasi SPMB</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">Juknis PPDB, syarat masuk, dan info tahapan penerimaan.</p>
                </div>
            </a>

            <!-- 9. Kontak & Layanan -->
            <a href="{{ route('tenant.admin.kontak.index', ['tenant' => $tenant->slug]) }}" class="p-4 rounded-xl border border-slate-100 hover:border-blue-200 bg-slate-50/50 hover:bg-blue-50/30 transition group flex items-start gap-3.5">
                <div class="w-9 h-9 rounded-lg bg-orange-100 text-orange-700 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-xs group-hover:text-blue-700">9. Kontak & Layanan</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">Telepon, WhatsApp, medsos resmi, dan pesan masyarakat.</p>
                </div>
            </a>
        </div>
    </div>

    <!-- 2 Column Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Pesan Pengunjung Terkini -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Pesan Kontak Terkini</h3>
                <span class="text-xs text-slate-400">Dari Formulir Publik</span>
            </div>
            @if($pesanTerbaru->isEmpty())
                <div class="py-12 text-center text-slate-400 text-xs">
                    Belum ada pesan yang dikirimkan oleh pengunjung.
                </div>
            @else
                <div class="divide-y divide-slate-100">
                    @foreach($pesanTerbaru as $p)
                        <div class="py-3 flex items-start justify-between gap-4">
                            <div>
                                <div class="font-semibold text-slate-900 text-xs">{{ $p->nama_pengirim }}</div>
                                <div class="text-[11px] text-slate-500">{{ $p->subjek }}</div>
                                <p class="text-xs text-slate-600 mt-1 line-clamp-1">{{ $p->pesan }}</p>
                            </div>
                            <span class="text-[10px] text-slate-400 whitespace-nowrap">{{ $p->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Artikel Berita Terakhir -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Artikel Berita Terakhir</h3>
                <span class="text-xs text-slate-400">Status Publikasi</span>
            </div>
            @if($artikelTerbaru->isEmpty())
                <div class="py-12 text-center text-slate-400 text-xs">
                    Belum ada artikel berita yang diterbitkan.
                </div>
            @else
                <div class="divide-y divide-slate-100">
                    @foreach($artikelTerbaru as $art)
                        <div class="py-3 flex items-start justify-between gap-4">
                            <div>
                                <div class="font-semibold text-slate-900 text-xs line-clamp-1">{{ $art->judul }}</div>
                                <div class="text-[11px] text-blue-600 font-medium">{{ $art->kategori->nama_kategori ?? 'Umum' }}</div>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold {{ $art->status_publikasi === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ ucfirst($art->status_publikasi) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
