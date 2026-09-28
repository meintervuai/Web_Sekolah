@extends('layouts.tenant_admin')

@section('title', 'Dashboard')
@section('header_title', 'Dashboard')

@section('content')
<div class="space-y-7">

    <!-- TailDash Welcome & Action Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/90 shadow-2xs">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                Pusat Kendali Portal {{ $tenant->nama_sekolah }}
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Kelola konten informasi, jadwal kegiatan, direktori guru, prestasi, dan sarana sekolah secara real-time.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a 
                href="{{ route('tenant.admin.pengaturan.index', ['tenant' => $tenant->slug]) }}" 
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white transition shadow-sm cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Konfigurasi Sekolah</span>
            </a>
            <a 
                href="{{ url($tenant->slug) }}" 
                target="_blank" 
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 transition shadow-2xs"
            >
                <span>Lihat Web</span>
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>
    </div>

    <!-- TailDash 4 Metric Statistics Cards Grid (Identik dengan format TailDash Dashboard) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Card 1: Total Berita -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-2xs hover:shadow-sm transition-all">
            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-50 text-blue-600 mb-5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        {{ $stat['total_berita'] }}
                    </h3>
                    <p class="text-xs font-semibold text-slate-500 mt-1">Artikel Berita</p>
                </div>
                <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
                    <span>Terbit</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                </span>
            </div>
        </div>

        <!-- Card 2: Pengumuman -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-2xs hover:shadow-sm transition-all">
            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 mb-5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        {{ $stat['total_pengumuman'] }}
                    </h3>
                    <p class="text-xs font-semibold text-slate-500 mt-1">Pengumuman Aktif</p>
                </div>
                <span class="inline-flex items-center gap-1 text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md">
                    <span>Edaran</span>
                </span>
            </div>
        </div>

        <!-- Card 3: Jurusan Vokasi -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-2xs hover:shadow-sm transition-all">
            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-cyan-50 text-cyan-600 mb-5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        {{ $stat['total_jurusan'] }}
                    </h3>
                    <p class="text-xs font-semibold text-slate-500 mt-1">Program Keahlian</p>
                </div>
                <span class="inline-flex items-center gap-1 text-xs font-bold text-cyan-600 bg-cyan-50 px-2 py-0.5 rounded-md">
                    <span>Vokasi</span>
                </span>
            </div>
        </div>

        <!-- Card 4: Pesan Pengunjung -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-2xs hover:shadow-sm transition-all">
            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-amber-50 text-amber-600 mb-5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        {{ $stat['pesan_belum_dibaca'] }}
                    </h3>
                    <p class="text-xs font-semibold text-slate-500 mt-1">Pesan Masuk</p>
                </div>
                @if($stat['pesan_belum_dibaca'] > 0)
                    <span class="inline-flex items-center gap-1 text-xs font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-md">
                        <span>Perlu Respon</span>
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 text-xs font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md">
                        <span>Selesai</span>
                    </span>
                @endif
            </div>
        </div>

    </div>

    <!-- TailDash Matrix Navigation Grid Section -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Akses Modul Navigasi & Konten Website</h3>
                <p class="text-xs text-slate-500 mt-0.5">Kelola setiap segmen portal publik sekolah langsung dari kartu di bawah ini.</p>
            </div>
        </div>

        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <!-- 1. Beranda -->
            <a href="{{ route('tenant.admin.slider.index', ['tenant' => $tenant->slug]) }}" class="p-5 rounded-2xl border border-slate-200/80 hover:border-blue-400 hover:bg-blue-50/20 transition group flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                <div class="min-w-0">
                    <div class="font-bold text-slate-900 text-sm group-hover:text-blue-600 transition-colors">1. Navigasi Beranda</div>
                    <p class="text-xs text-slate-500 mt-1">Slider banner hero utama, angka capaian statistik, dan sambutan.</p>
                </div>
            </a>

            <!-- 2. Profil -->
            <a href="{{ route('tenant.admin.profil.index', ['tenant' => $tenant->slug]) }}" class="p-5 rounded-2xl border border-slate-200/80 hover:border-blue-400 hover:bg-blue-50/20 transition group flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div class="min-w-0">
                    <div class="font-bold text-slate-900 text-sm group-hover:text-indigo-600 transition-colors">2. Navigasi Profil</div>
                    <p class="text-xs text-slate-500 mt-1">Visi misi, sejarah pendirian sekolah, dan bagan struktur organisasi.</p>
                </div>
            </a>

            <!-- 3. Program Keahlian -->
            <a href="{{ route('tenant.admin.jurusan.index', ['tenant' => $tenant->slug]) }}" class="p-5 rounded-2xl border border-slate-200/80 hover:border-blue-400 hover:bg-blue-50/20 transition group flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center shrink-0 group-hover:bg-cyan-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div class="min-w-0">
                    <div class="font-bold text-slate-900 text-sm group-hover:text-cyan-600 transition-colors">3. Program Keahlian</div>
                    <p class="text-xs text-slate-500 mt-1">Konsentrasi kejuruan vokasi, silabus, prospek karir, dan mitra DUDI.</p>
                </div>
            </a>

            <!-- 4. Informasi & Publikasi -->
            <a href="{{ route('tenant.admin.berita.index', ['tenant' => $tenant->slug]) }}" class="p-5 rounded-2xl border border-slate-200/80 hover:border-blue-400 hover:bg-blue-50/20 transition group flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <div class="min-w-0">
                    <div class="font-bold text-slate-900 text-sm group-hover:text-emerald-600 transition-colors">4. Informasi & Publikasi</div>
                    <p class="text-xs text-slate-500 mt-1">Warta berita, pengumuman resmi ujian, agenda kalender, dan album galeri.</p>
                </div>
            </a>

            <!-- 5. Kesiswaan -->
            <a href="{{ route('tenant.admin.prestasi.index', ['tenant' => $tenant->slug]) }}" class="p-5 rounded-2xl border border-slate-200/80 hover:border-blue-400 hover:bg-blue-50/20 transition group flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <div class="min-w-0">
                    <div class="font-bold text-slate-900 text-sm group-hover:text-amber-600 transition-colors">5. Kesiswaan & Prestasi</div>
                    <p class="text-xs text-slate-500 mt-1">Daftar juara lomba kejuaraan dan kegiatan ekstrakurikuler siswa.</p>
                </div>
            </a>

            <!-- 6. Fasilitas & Lab -->
            <a href="{{ route('tenant.admin.fasilitas.index', ['tenant' => $tenant->slug]) }}" class="p-5 rounded-2xl border border-slate-200/80 hover:border-blue-400 hover:bg-blue-50/20 transition group flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div class="min-w-0">
                    <div class="font-bold text-slate-900 text-sm group-hover:text-purple-600 transition-colors">6. Fasilitas & Sarana</div>
                    <p class="text-xs text-slate-500 mt-1">Laboratorium komputer, bengkel praktik kerja, dan sarana olahraga.</p>
                </div>
            </a>
        </div>
    </div>

    <!-- 2 Column Section: TailDash Table / List Style -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-7">

        <!-- Pesan Pengunjung Terkini (TailDash Card Table Format) -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Pesan Pengunjung Terbaru</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Pertanyaan masuk dari formulir kontak</p>
                </div>
                <a href="{{ route('tenant.admin.kontak.index', ['tenant' => $tenant->slug]) }}" class="text-xs font-bold text-blue-600 hover:text-blue-700">Lihat Semua &rarr;</a>
            </div>
            @if($pesanTerbaru->isEmpty())
                <div class="py-14 text-center text-slate-400 text-xs">
                    Belum ada pesan yang masuk dari pengunjung website.
                </div>
            @else
                <div class="divide-y divide-slate-100">
                    @foreach($pesanTerbaru as $p)
                        <div class="p-5 hover:bg-slate-50/60 transition flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <div class="font-bold text-slate-900 text-xs sm:text-sm truncate">{{ $p->nama_pengirim }}</div>
                                <div class="text-xs font-semibold text-blue-600 mt-0.5 truncate">{{ $p->subjek }}</div>
                                <p class="text-xs text-slate-500 mt-1 line-clamp-1 leading-relaxed">{{ $p->pesan }}</p>
                            </div>
                            <span class="text-[11px] font-semibold text-slate-400 shrink-0 whitespace-nowrap">{{ $p->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Artikel Berita Terakhir (TailDash Card Format) -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Warta Berita Terakhir</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Publikasi warta & kegiatan sekolah</p>
                </div>
                <a href="{{ route('tenant.admin.berita.index', ['tenant' => $tenant->slug]) }}" class="text-xs font-bold text-blue-600 hover:text-blue-700">Kelola Berita &rarr;</a>
            </div>
            @if($artikelTerbaru->isEmpty())
                <div class="py-14 text-center text-slate-400 text-xs">
                    Belum ada artikel berita yang diterbitkan.
                </div>
            @else
                <div class="divide-y divide-slate-100">
                    @foreach($artikelTerbaru as $art)
                        <div class="p-5 hover:bg-slate-50/60 transition flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <div class="font-bold text-slate-900 text-xs sm:text-sm truncate">{{ $art->judul }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $art->kategori->nama_kategori ?? 'Berita Sekolah' }}</div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold shrink-0 {{ $art->status_publikasi === 'published' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }}">
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

