@extends('layouts.public')

@section('title', 'SPMB & PPDB - ' . $sekolah['nama'])
@section('meta_description', 'Informasi resmi Sistem Penerimaan Murid Baru (SPMB / PPDB) di ' . $sekolah['nama'] . '. Jalur pendaftaran, persyaratan, alur, dan jadwal.')

@section('content')
<!-- Header & Breadcrumb -->
<section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium">SPMB / PPDB</li>
            </ol>
        </nav>
        <div class="max-w-3xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3">
                Bergabung Bersama SMK Negeri 2 Bandung
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed">
                Wujudkan cita-cita masa depanmu melalui pendidikan vokasi berkualitas, fasilitas teaching factory berstandar industri, dan jaringan kerja sama 85+ mitra DUDI nasional & internasional.
            </p>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="section-py bg-slate-50">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            
            <!-- Left: Main Information (8 cols) -->
            <div class="lg:col-span-8 space-y-10">
                
                <!-- If Custom CMS Content Exists -->
                @if($halaman && !empty($halaman->isi_konten))
                <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-200/80 shadow-xs prose prose-slate max-w-none">
                    {!! $halaman->isi_konten !!}
                </div>
                @endif

                <!-- Jalur Pendaftaran Box -->
                <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-200/80 shadow-xs">
                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 font-heading mb-6 flex items-center">
                        <svg class="w-6 h-6 text-blue-600 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Jalur Seleksi Pendaftaran PPDB
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl border border-slate-100 bg-slate-50/50">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 uppercase mb-2">Tahap 1</span>
                            <h3 class="text-sm font-bold text-slate-900 font-heading mb-1">Jalur Afirmasi (KETM & PDBK)</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">Bagi calon peserta didik dari keluarga ekonomi tidak mampu yang terdaftar pada DTKS Kemensos.</p>
                        </div>

                        <div class="p-4 rounded-xl border border-slate-100 bg-slate-50/50">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 uppercase mb-2">Tahap 1</span>
                            <h3 class="text-sm font-bold text-slate-900 font-heading mb-1">Jalur Prioritas Terdekat</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">Seleksi berdasarkan radius jarak domisili tempat tinggal calon siswa ke lokasi kampus SMK Negeri 2 Bandung.</p>
                        </div>

                        <div class="p-4 rounded-xl border border-slate-100 bg-slate-50/50">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-800 uppercase mb-2">Tahap 2</span>
                            <h3 class="text-sm font-bold text-slate-900 font-heading mb-1">Jalur Prestasi Nilai Rapor</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">Seleksi peringkat berdasarkan rata-rata kumulatif nilai rapor SMP/MTs semester 1 hingga semester 5.</p>
                        </div>

                        <div class="p-4 rounded-xl border border-slate-100 bg-slate-50/50">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-800 uppercase mb-2">Tahap 2</span>
                            <h3 class="text-sm font-bold text-slate-900 font-heading mb-1">Jalur Prestasi Kejuaraan</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">Apresiasi bagi calon siswa peraih medali perlombaan sains, teknologi, olahraga, dan seni minimal tingkat kota/provinsi.</p>
                        </div>
                    </div>
                </div>

                <!-- Alur Pendaftaran Step-by-Step -->
                <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-200/80 shadow-xs">
                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 font-heading mb-6 flex items-center">
                        <svg class="w-6 h-6 text-blue-600 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Alur & Prosedur Pendaftaran
                    </h2>

                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shrink-0">1</div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Registrasi Akun PPDB Online</h3>
                                <p class="text-xs text-slate-600 mt-1">Siswa mendapatkan akun dari sekolah asal (SMP/MTs) dan login ke portal resmi PPDB Jawa Barat.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shrink-0">2</div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Pemilihan Sekolah & Kompetensi Keahlian</h3>
                                <p class="text-xs text-slate-600 mt-1">Pilih SMK Negeri 2 Bandung dan tentukan prioritas Program Keahlian yang diminati.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shrink-0">3</div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Unggah Berkas & Verifikasi Data</h3>
                                <p class="text-xs text-slate-600 mt-1">Upload dokumen persyaratan: KK, Akta Kelahiran, Nilai Rapor, Surat Sehat & Tidak Buta Warna (khusus jurusan keteknikan).</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shrink-0">4</div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Pengumuman & Daftar Ulang</h3>
                                <p class="text-xs text-slate-600 mt-1">Cek hasil seleksi secara online. Peserta yang dinyatakan lolos wajib melakukan daftar ulang di kampus SMKN 2 Bandung.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Persyaratan Berkas -->
                <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-200/80 shadow-xs">
                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 font-heading mb-4">Persyaratan Dokumen Umum</h2>
                    <ul class="space-y-2.5 text-xs md:text-sm text-slate-700">
                        <li class="flex items-start"><span class="text-blue-600 mr-2 font-bold">✓</span> Ijazah SMP/MTs/Sederajat atau Surat Keterangan Lulus (SKL) asli.</li>
                        <li class="flex items-start"><span class="text-blue-600 mr-2 font-bold">✓</span> Akta Kelahiran asli dan fotokopi legalisir.</li>
                        <li class="flex items-start"><span class="text-blue-600 mr-2 font-bold">✓</span> Kartu Keluarga (KK) yang diterbitkan minimal 1 tahun sebelum tanggal pendaftaran.</li>
                        <li class="flex items-start"><span class="text-blue-600 mr-2 font-bold">✓</span> Buku Rapor SMP/MTs semester 1 sampai semester 5.</li>
                        <li class="flex items-start"><span class="text-blue-600 mr-2 font-bold">✓</span> Surat Keterangan Sehat dan Tidak Buta Warna dari dokter pemerintah/Puskesmas.</li>
                        <li class="flex items-start"><span class="text-blue-600 mr-2 font-bold">✓</span> Surat Tanggung Jawab Mutlak (SPTJM) bermaterai dari orang tua/wali.</li>
                    </ul>
                </div>

            </div>

            <!-- Right: Sidebar Info (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Portal Link Card -->
                <div class="public-hero-gradient text-white rounded-2xl p-6 shadow-md">
                    <span class="text-xs uppercase tracking-wider font-bold block mb-1 text-white/80">Portal Pendaftaran Resmi</span>
                    <h3 class="text-lg font-bold font-heading mb-3">Portal PPDB Jawa Barat</h3>
                    <p class="text-xs text-white/90 leading-relaxed mb-5">
                        Seluruh pendaftaran dilaksanakan secara daring melalui sistem resmi Dinas Pendidikan Provinsi Jawa Barat.
                    </p>
                    <a href="https://ppdb.jabarprov.go.id" target="_blank" rel="noopener noreferrer" 
                       class="inline-flex items-center justify-center w-full px-5 py-3 rounded-xl bg-white text-slate-900 font-bold text-xs shadow hover:bg-slate-100 transition">
                        <span>Akses Portal PPDB Jabar</span>
                        <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>

                <!-- Daya Tampung Jurusan -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200/80">
                    <h3 class="text-base font-bold text-slate-900 font-heading mb-4 pb-3 border-b border-slate-200">
                        7 Program Keahlian Tersedia
                    </h3>
                    <ul class="space-y-2 text-xs text-slate-700">
                        <li class="flex justify-between py-1 border-b border-slate-100">
                            <span>1. Teknik Pemesinan (TP)</span>
                            <strong class="text-slate-900">4 Rombel</strong>
                        </li>
                        <li class="flex justify-between py-1 border-b border-slate-100">
                            <span>2. Teknik Kendaraan Ringan (TKR)</span>
                            <strong class="text-slate-900">4 Rombel</strong>
                        </li>
                        <li class="flex justify-between py-1 border-b border-slate-100">
                            <span>3. Rekayasa Perangkat Lunak (RPL)</span>
                            <strong class="text-slate-900">3 Rombel</strong>
                        </li>
                        <li class="flex justify-between py-1 border-b border-slate-100">
                            <span>4. Teknik Komputer & Jaringan (TKJ)</span>
                            <strong class="text-slate-900">3 Rombel</strong>
                        </li>
                        <li class="flex justify-between py-1 border-b border-slate-100">
                            <span>5. Desain Komunikasi Visual (DKV)</span>
                            <strong class="text-slate-900">2 Rombel</strong>
                        </li>
                        <li class="flex justify-between py-1 border-b border-slate-100">
                            <span>6. Teknik Otomasi Industri (TOI)</span>
                            <strong class="text-slate-900">2 Rombel</strong>
                        </li>
                        <li class="flex justify-between py-1">
                            <span>7. Teknik Audio Video (TAV)</span>
                            <strong class="text-slate-900">2 Rombel</strong>
                        </li>
                    </ul>
                </div>

                <!-- Helpdesk Card -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
                    <h3 class="text-base font-bold text-slate-900 font-heading mb-2">Helpdesk PPDB SMKN 2</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-4">
                        Posko layanan konsultasi dan verifikasi berkas luring dibuka pada jam kerja di Gedung Humas SMKN 2 Bandung, Jl. Ciliwung No. 4.
                    </p>
                    <div class="space-y-2 text-xs text-slate-700">
                        <div class="flex items-center">
                            <span class="w-20 text-slate-400">Telepon:</span>
                            <strong class="text-slate-900">{{ $sekolah['telepon'] }}</strong>
                        </div>
                        <div class="flex items-center">
                            <span class="w-20 text-slate-400">WhatsApp:</span>
                            <strong class="text-slate-900">{{ $sekolah['whatsapp'] ?? '081222333444' }}</strong>
                        </div>
                        <div class="flex items-center">
                            <span class="w-20 text-slate-400">Jam Layanan:</span>
                            <strong class="text-slate-900">08.00 - 15.00 WIB</strong>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>
@endsection
