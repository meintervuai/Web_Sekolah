@extends('layouts.public')

@section('title', 'Hubungi Kami & Layanan Informasi - ' . $sekolah['nama'])
@section('meta_description', 'Kontak resmi, lokasi peta Google Maps, jam operasional layanan, dan formulir pesan informasi ' . $sekolah['nama'] . ' Bandung.')

@section('content')
<!-- Header & Breadcrumb -->
<section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium">Kontak & Lokasi</li>
            </ol>
        </nav>
        <div class="max-w-2xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3">
                Hubungi Kami
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed">
                Kami siap melayani kebutuhan informasi seputar akademik, kemitraan industri (DUDI), legalisir dokumen, dan pendaftaran peserta didik baru.
            </p>
        </div>
    </div>
</section>

<!-- Main Contact Section -->
<section class="section-py bg-slate-50">
    <div class="container-custom">
        
        <!-- Flash Success Notification -->
        @if(session('sukses'))
        <div class="mb-8 p-5 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center space-x-4 text-emerald-800">
            <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <h4 class="font-bold text-sm">Pesan Berhasil Dikirim!</h4>
                <p class="text-xs text-emerald-700">{{ session('sukses') }}</p>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            
            <!-- Left: Contact Details & Map (5 cols) -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-xs">
                    <h2 class="text-xl font-bold text-slate-900 font-heading mb-6 pb-3 border-b border-slate-100">
                        Informasi Kantor & Layanan
                    </h2>

                    <ul class="space-y-5 text-xs md:text-sm">
                        <!-- Alamat -->
                        <li class="flex items-start space-x-3.5">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 block mb-0.5">Alamat Sekolah</span>
                                <p class="text-slate-600 leading-relaxed">{{ $sekolah['alamat'] ?? 'Jl. Ciliwung No. 4, Cihapit, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40114' }}</p>
                            </div>
                        </li>

                        <!-- Telepon -->
                        <li class="flex items-start space-x-3.5">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 block mb-0.5">Telepon Kantor</span>
                                <p class="text-slate-600">{{ $sekolah['telepon'] ?? '(022) 7234285' }}</p>
                            </div>
                        </li>

                        <!-- Email -->
                        <li class="flex items-start space-x-3.5">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 block mb-0.5">Surat Elektronik (Email)</span>
                                <a href="mailto:{{ $sekolah['email'] ?? 'humas@smkn2bandung.sch.id' }}" class="text-blue-600 hover:underline">
                                    {{ $sekolah['email'] ?? 'humas@smkn2bandung.sch.id' }}
                                </a>
                            </div>
                        </li>

                        <!-- WhatsApp Hotline -->
                        <li class="flex items-start space-x-3.5">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M18.403 5.638A8.955 8.955 0 0 0 12.053 3c-4.968 0-9.013 4.045-9.015 9.017a8.98 8.98 0 0 0 1.374 4.815L3 21l4.303-1.129a9.014 9.014 0 0 0 4.748 1.325h.004c4.968 0 9.013-4.046 9.015-9.017a8.963 8.963 0 0 0-2.667-6.541zm-6.35 13.684h-.003a7.51 7.51 0 0 1-3.832-1.051l-.275-.163-2.85.748.76-2.778-.179-.284a7.485 7.485 0 0 1-1.147-3.978c.002-4.14 3.37-7.508 7.513-7.508a7.472 7.472 0 0 1 5.309 2.199 7.48 7.48 0 0 1 2.196 5.31c-.002 4.14-3.37 7.508-7.512 7.508zm4.12-5.625c-.225-.113-1.334-.658-1.541-.733-.207-.075-.357-.113-.508.113-.15.225-.583.733-.715.884-.131.15-.263.169-.489.056-.225-.113-.951-.35-1.812-1.118-.671-.598-1.124-1.338-1.256-1.564-.132-.226-.014-.348.099-.46.102-.101.226-.263.339-.395.113-.131.15-.225.226-.375.075-.15.038-.282-.019-.395-.056-.113-.508-1.224-.696-1.677-.183-.441-.369-.381-.508-.388l-.433-.008c-.15 0-.395.056-.602.282-.207.226-.79.771-.79 1.88 0 1.109.809 2.179.921 2.33.113.15 1.59 2.428 3.854 3.404.538.233.959.372 1.286.476.541.172 1.034.148 1.423.09.434-.065 1.334-.546 1.522-1.072.188-.527.188-.978.132-1.072-.057-.094-.207-.15-.433-.263z"/></svg>
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 block mb-0.5">Hotline Pelayanan Publik (WhatsApp)</span>
                                <a href="https://wa.me/62{{ ltrim($sekolah['whatsapp'] ?? '081222333444', '0') }}" target="_blank" class="text-emerald-700 font-semibold hover:underline">
                                    {{ $sekolah['whatsapp'] ?? '081222333444' }}
                                </a>
                            </div>
                        </li>

                        <!-- Jam Layanan -->
                        <li class="flex items-start space-x-3.5">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 block mb-0.5">Jam Operasional Layanan</span>
                                <p class="text-slate-600">{{ $sekolah['jam_layanan'] ?? 'Senin - Jumat: 07.00 - 16.00 WIB' }}</p>
                                <span class="text-[11px] text-slate-400 block">(Sabtu, Minggu & Libur Nasional Tutup)</span>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Google Maps Card -->
                <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-xs">
                    <div class="p-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-800">Peta Lokasi Kampus</span>
                        <a href="https://maps.google.com/?q=SMK+Negeri+2+Bandung" target="_blank" class="text-[11px] text-blue-600 hover:underline">Buka di Google Maps &raquo;</a>
                    </div>
                    <div class="aspect-4/3 w-full bg-slate-100">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.8938743132714!2d107.6253406!3d-6.9033036!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e64c483d2fc1%3A0x6a2c222ffda9c72e!2sSMK%20Negeri%202%20Bandung!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>

            <!-- Right: Interactive Contact Form (7 cols) -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-2xl p-6 sm:p-10 border border-slate-200/80 shadow-xs">
                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 font-heading mb-2">
                        Kirim Pesan atau Pertanyaan
                    </h2>
                    <p class="text-xs md:text-sm text-slate-500 mb-8">
                        Silakan lengkapi formulir di bawah ini. Tim humas kami akan merespons pesan Anda dalam waktu 1x24 jam kerja.
                    </p>

                    <form method="POST" onsubmit="sendToWhatsApp(event)" class="space-y-5">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div>
                            <label for="nama_pengirim" class="block text-xs md:text-sm font-semibold text-slate-800 mb-1.5">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="nama_pengirim" name="nama_pengirim" value="{{ old('nama_pengirim') }}" required
                                   placeholder="Contoh: Budi Santoso"
                                   class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('nama_pengirim') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-200' }} rounded-xl text-xs md:text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            @error('nama_pengirim')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor Telepon / WhatsApp -->
                        <div>
                            <label for="no_telepon" class="block text-xs md:text-sm font-semibold text-slate-800 mb-1.5">
                                Nomor WhatsApp / HP <span class="text-slate-400 font-normal">(Opsional)</span>
                            </label>
                            <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}"
                                   placeholder="Contoh: 081234567890"
                                   class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('no_telepon') ? 'border-rose-500' : 'border-slate-200' }} rounded-xl text-xs md:text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            @error('no_telepon')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subjek Pesan -->
                        <div>
                            <label for="subjek" class="block text-xs md:text-sm font-semibold text-slate-800 mb-1.5">
                                Subjek / Kategori Pesan <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="subjek" name="subjek" value="{{ old('subjek') }}" required
                                   placeholder="Contoh: Informasi Pendaftaran Siswa Baru / Kerja Sama Industri"
                                   class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('subjek') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-200' }} rounded-xl text-xs md:text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            @error('subjek')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Isi Pesan -->
                        <div>
                            <label for="pesan" class="block text-xs md:text-sm font-semibold text-slate-800 mb-1.5">
                                Pesan Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <textarea id="pesan" name="pesan" rows="5" required
                                      placeholder="Tuliskan pertanyaan, masukan, atau permohonan informasi Anda secara rinci di sini..."
                                      class="w-full px-4 py-3 bg-slate-50 border {{ $errors->has('pesan') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-200' }} rounded-xl text-xs md:text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">{{ old('pesan') }}</textarea>
                            @error('pesan')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" 
                                    class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs md:text-sm rounded-xl shadow-md hover:shadow-lg transition">
                                <svg class="w-4 h-4 mr-2 fill-current" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M18.403 5.638A8.955 8.955 0 0 0 12.053 3c-4.968 0-9.013 4.045-9.015 9.017a8.98 8.98 0 0 0 1.374 4.815L3 21l4.303-1.129a9.014 9.014 0 0 0 4.748 1.325h.004c4.968 0 9.013-4.046 9.015-9.017a8.963 8.963 0 0 0-2.667-6.541zm-6.35 13.684h-.003a7.51 7.51 0 0 1-3.832-1.051l-.275-.163-2.85.748.76-2.778-.179-.284a7.485 7.485 0 0 1-1.147-3.978c.002-4.14 3.37-7.508 7.513-7.508a7.472 7.472 0 0 1 5.309 2.199 7.48 7.48 0 0 1 2.196 5.31c-.002 4.14-3.37 7.508-7.512 7.508zm4.12-5.625c-.225-.113-1.334-.658-1.541-.733-.207-.075-.357-.113-.508.113-.15.225-.583.733-.715.884-.131.15-.263.169-.489.056-.225-.113-.951-.35-1.812-1.118-.671-.598-1.124-1.338-1.256-1.564-.132-.226-.014-.348.099-.46.102-.101.226-.263.339-.395.113-.131.15-.225.226-.375.075-.15.038-.282-.019-.395-.056-.113-.508-1.224-.696-1.677-.183-.441-.369-.381-.508-.388l-.433-.008c-.15 0-.395.056-.602.282-.207.226-.79.771-.79 1.88 0 1.109.809 2.179.921 2.33.113.15 1.59 2.428 3.854 3.404.538.233.959.372 1.286.476.541.172 1.034.148 1.423.09.434-.065 1.334-.546 1.522-1.072.188-.527.188-.978.132-1.072-.057-.094-.207-.15-.433-.263z"/></svg>
                                <span>Kirim via WhatsApp</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

@push('scripts')
<script>
function sendToWhatsApp(event) {
    event.preventDefault();
    
    const nama = document.getElementById('nama_pengirim').value;
    const telepon = document.getElementById('no_telepon').value;
    const subjek = document.getElementById('subjek').value;
    const pesan = document.getElementById('pesan').value;
    
    const waNumber = "62{{ ltrim($sekolah['whatsapp'] ?? '081222333444', '0') }}";
    
    const template = `*Halo, saya ingin menghubungi ${ '{{ $sekolah["nama"] ?? "Humas" }}' }*
    
*Nama Lengkap:* ${nama}
*No. WhatsApp / HP:* ${telepon ? telepon : '-'}
*Subjek/Kategori:* ${subjek}

*Pesan:*
${pesan}`;

    const textEncoded = encodeURIComponent(template);
    const waUrl = `https://wa.me/${waNumber}?text=${textEncoded}`;
    
    window.open(waUrl, '_blank');
}
</script>
@endpush
@endsection
