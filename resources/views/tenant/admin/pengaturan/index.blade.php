@extends('layouts.tenant_admin')

@section('title', 'Identitas & Media Sosial')
@section('header_title', 'Pengaturan Informasi Sekolah')

@section('content')
<div class="max-w-5xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Kelola Informasi Publik & Identitas</h3>
                <p class="text-xs text-slate-500 mt-0.5">Seluruh perubahan yang disimpan di sini akan langsung tampil pada halaman publik website sekolah.</p>
            </div>
            <a href="{{ url($tenant->slug) }}" target="_blank" class="px-3.5 py-1.5 rounded-lg bg-white border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 shadow-2xs transition inline-flex items-center gap-1.5 self-start sm:self-auto">
                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Lihat Website
            </a>
        </div>

        <form action="{{ route('tenant.admin.pengaturan.update', ['tenant' => $tenant->slug]) }}" method="POST" class="p-6 sm:p-8 space-y-8">
            @csrf
            @method('PUT')

            <!-- Bagian 1: Identitas Pokok Sekolah -->
            <div>
                <h4 class="text-xs font-bold text-blue-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    1. Identitas Pokok Sekolah
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Resmi Sekolah</label>
                        <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $pengaturanRaw['nama_sekolah'] ?? $tenant->nama_sekolah) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jenjang Pendidikan</label>
                        <input type="text" name="jenjang" value="{{ old('jenjang', $pengaturanRaw['jenjang'] ?? $tenant->jenjang) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Slogan / Tagline Sekolah</label>
                        <input type="text" name="slogan" value="{{ old('slogan', $pengaturanRaw['slogan'] ?? '') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">NPSN (Nomor Pokok Sekolah Nasional)</label>
                        <input type="text" name="npsn" value="{{ old('npsn', $pengaturanRaw['npsn'] ?? '') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status Akreditasi</label>
                        <input type="text" name="akreditasi" value="{{ old('akreditasi', $pengaturanRaw['akreditasi'] ?? 'A') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tahun Berdiri</label>
                        <input type="text" name="tahun_berdiri" value="{{ old('tahun_berdiri', $pengaturanRaw['tahun_berdiri'] ?? '1951') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi Profil Singkat</label>
                        <textarea name="deskripsi" rows="3" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 leading-relaxed">{{ old('deskripsi', $pengaturanRaw['deskripsi'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Kontak & Layanan Publik -->
            <div>
                <h4 class="text-xs font-bold text-blue-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    2. Kontak & Jam Operasional Layanan
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Lengkap Kampus</label>
                        <textarea name="alamat" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 leading-relaxed">{{ old('alamat', $pengaturanRaw['alamat'] ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">No. Telepon Sekolah</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon', $pengaturanRaw['no_telepon'] ?? '') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Email Resmi</label>
                        <input type="email" name="email_sekolah" value="{{ old('email_sekolah', $pengaturanRaw['email_sekolah'] ?? '') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">WhatsApp Hotline Pelayanan</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $pengaturanRaw['whatsapp'] ?? '081222333444') }}" placeholder="Contoh: 081222333444" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jam Operasional Layanan</label>
                        <input type="text" name="jam_layanan" value="{{ old('jam_layanan', $pengaturanRaw['jam_layanan'] ?? 'Senin - Jumat: 07.00 - 16.00 WIB') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">URL Google Maps Embed</label>
                        <input type="text" name="peta_embed" value="{{ old('peta_embed', $pengaturanRaw['peta_embed'] ?? '') }}" placeholder="https://www.google.com/maps/embed?pb=..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Bagian 3: Media Sosial Resmi -->
            <div>
                <h4 class="text-xs font-bold text-blue-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    3. Media Sosial Resmi Sekolah (Footer & Halaman Kontak)
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Instagram URL</label>
                        <input type="url" name="instagram" value="{{ old('instagram', $pengaturanRaw['instagram'] ?? 'https://instagram.com/smkn2bandung') }}" placeholder="https://instagram.com/akun" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">TikTok URL</label>
                        <input type="url" name="tiktok" value="{{ old('tiktok', $pengaturanRaw['tiktok'] ?? 'https://tiktok.com/@smkn2bandung') }}" placeholder="https://tiktok.com/@akun" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">YouTube URL</label>
                        <input type="url" name="youtube" value="{{ old('youtube', $pengaturanRaw['youtube'] ?? 'https://youtube.com/@smkn2bandung') }}" placeholder="https://youtube.com/@channel" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Facebook URL</label>
                        <input type="url" name="facebook" value="{{ old('facebook', $pengaturanRaw['facebook'] ?? 'https://facebook.com/smkn2bandung') }}" placeholder="https://facebook.com/page" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">X (Twitter) URL</label>
                        <input type="url" name="twitter" value="{{ old('twitter', $pengaturanRaw['twitter'] ?? 'https://x.com/smkn2bandung') }}" placeholder="https://x.com/akun" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Bagian 4: Kepala Sekolah & Sambutan -->
            <div>
                <h4 class="text-xs font-bold text-blue-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    4. Kepala Sekolah & Sambutan Beranda
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap Kepala Sekolah</label>
                        <input type="text" name="nama_kepsek" value="{{ old('nama_kepsek', $pengaturanRaw['nama_kepsek'] ?? '') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">NIP Kepala Sekolah</label>
                        <input type="text" name="nip_kepsek" value="{{ old('nip_kepsek', $pengaturanRaw['nip_kepsek'] ?? '') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">URL Foto Kepala Sekolah</label>
                        <input type="text" name="foto_kepsek" value="{{ old('foto_kepsek', $pengaturanRaw['foto_kepsek'] ?? '') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Teks Sambutan Resmi Kepala Sekolah</label>
                        <textarea name="sambutan_kepsek" rows="4" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 leading-relaxed">{{ old('sambutan_kepsek', $pengaturanRaw['sambutan_kepsek'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Bagian 5: Statistik Resmi Beranda -->
            <div>
                <h4 class="text-xs font-bold text-blue-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    5. Statistik Sekolah (Tampil di Beranda)
                </h4>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Total Guru/Staf</label>
                        <input type="text" name="stat_guru" value="{{ old('stat_guru', $pengaturanRaw['stat_guru'] ?? '98') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Total Siswa</label>
                        <input type="text" name="stat_siswa" value="{{ old('stat_siswa', $pengaturanRaw['stat_siswa'] ?? '1972') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Total Rombel</label>
                        <input type="text" name="stat_rombel" value="{{ old('stat_rombel', $pengaturanRaw['stat_rombel'] ?? '54') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Ruang Kelas</label>
                        <input type="text" name="stat_kelas" value="{{ old('stat_kelas', $pengaturanRaw['stat_kelas'] ?? '41') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Total Jurusan</label>
                        <input type="text" name="stat_jurusan" value="{{ old('stat_jurusan', $pengaturanRaw['stat_jurusan'] ?? '7') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Mitra Industri (DUDI)</label>
                        <input type="text" name="stat_mitra" value="{{ old('stat_mitra', $pengaturanRaw['stat_mitra'] ?? '85') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Sumber Label Statistik</label>
                        <input type="text" name="stat_sumber_label" value="{{ old('stat_sumber_label', $pengaturanRaw['stat_sumber_label'] ?? 'Data Pokok Pendidikan (Dapodik)') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900">
                    </div>
                </div>
            </div>

            <!-- Submit Button Footer -->
            <div class="pt-6 border-t border-slate-200 flex justify-end">
                <button type="submit" class="px-6 py-3 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-sm shadow-md transition cursor-pointer">
                    Simpan Seluruh Pengaturan
                </button>
            </div>
        </form>

    </div>

</div>
@endsection
