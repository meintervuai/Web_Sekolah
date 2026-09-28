@extends('layouts.tenant_admin')

@section('title', 'Kontak, Medsos & Pesan Masuk')
@section('header_title', 'Kelola Kontak & Layanan Publik')

@section('content')
<div class="max-w-6xl space-y-6">

    <!-- Tab / Nav Section -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Pengaturan Kontak, WhatsApp, & Media Sosial Resmi</h3>
                <p class="text-xs text-slate-500 mt-0.5">Seluruh saluran informasi, alamat fisik, helpdesk, dan integrasi maps sekolah</p>
            </div>
        </div>

        <form action="{{ route('tenant.admin.kontak.update', ['tenant' => $tenant->slug]) }}" method="POST" class="p-6 sm:p-8 space-y-8">
            @csrf
            @method('PUT')

            <!-- Bagian 1: Kontak & Pelayanan -->
            <div class="space-y-5">
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    1. Saluran Kontak & Jam Layanan
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Lengkap Sekolah</label>
                        <textarea name="alamat" rows="2" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition leading-relaxed">{{ old('alamat', $kontakData['alamat']) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">No. Telepon Kantor</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon', $kontakData['no_telepon']) }}" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Resmi Sekolah</label>
                        <input type="email" name="email_sekolah" value="{{ old('email_sekolah', $kontakData['email_sekolah']) }}" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">WhatsApp Hotline / Pelayanan Publik</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $kontakData['whatsapp']) }}" placeholder="081222333444" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jam Layanan Operasional</label>
                        <input type="text" name="jam_layanan" value="{{ old('jam_layanan', $kontakData['jam_layanan']) }}" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">URL Google Maps Embed</label>
                        <input type="text" name="peta_embed" value="{{ old('peta_embed', $kontakData['peta_embed']) }}" placeholder="https://www.google.com/maps/embed?pb=..." class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Media Sosial Resmi -->
            <div class="space-y-5">
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    2. Akun Media Sosial Resmi Sekolah
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Instagram URL</label>
                        <input type="url" name="instagram" value="{{ old('instagram', $kontakData['instagram']) }}" placeholder="https://instagram.com/akun" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">TikTok URL</label>
                        <input type="url" name="tiktok" value="{{ old('tiktok', $kontakData['tiktok']) }}" placeholder="https://tiktok.com/@akun" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">YouTube URL</label>
                        <input type="url" name="youtube" value="{{ old('youtube', $kontakData['youtube']) }}" placeholder="https://youtube.com/@channel" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Facebook URL</label>
                        <input type="url" name="facebook" value="{{ old('facebook', $kontakData['facebook']) }}" placeholder="https://facebook.com/page" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">X (Twitter) URL</label>
                        <input type="url" name="twitter" value="{{ old('twitter', $kontakData['twitter']) }}" placeholder="https://x.com/akun" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                </div>
            </div>

            <div class="pt-5 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs hover:shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan Kontak & Medsos
                </button>
            </div>
        </form>
    </div>

    <!-- Inbox Pesan Masuk -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden" x-data="{ viewMode: 'list' }">
        <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Inbox Pesan Pengunjung Website</h3>
                <p class="text-xs text-slate-500 mt-0.5">Pesan, konsultasi SPMB, dan pertanyaan yang masuk melalui formulir kontak</p>
            </div>
            <div class="flex items-center gap-3">
                <!-- View Mode Toggle -->
                <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl border border-slate-200">
                    <button type="button" @click="viewMode = 'list'" :class="viewMode === 'list' ? 'bg-white text-blue-600 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-800'" class="p-1.5 rounded-lg transition text-xs flex items-center gap-1" title="Tampilan Tabel">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <button type="button" @click="viewMode = 'grid'" :class="viewMode === 'grid' ? 'bg-white text-blue-600 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-800'" class="p-1.5 rounded-lg transition text-xs flex items-center gap-1" title="Tampilan Grid">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    </button>
                </div>

                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200">Total: {{ $totalPesan }}</span>
                    <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200/50">Belum: {{ $pesanBelumDibaca }}</span>
                </div>
            </div>
        </div>

        <!-- Mode List (Tabel) -->
        <div x-show="viewMode === 'list'" class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 text-slate-500 uppercase font-bold text-[11px] tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-4 py-3.5">Pengirim</th>
                        <th class="px-4 py-3.5">Subjek & Pesan</th>
                        <th class="px-4 py-3.5">Waktu Masuk</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pesanList as $pesan)
                    <tr class="hover:bg-slate-50/60 transition {{ !$pesan->is_dibaca ? 'bg-blue-50/20 font-semibold' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if(!$pesan->is_dibaca)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200/50">Baru</span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">Dibaca</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-slate-900 font-bold">{{ $pesan->nama_pengirim }}</div>
                            <div class="text-[11px] text-slate-400 font-normal">{{ $pesan->email_pengirim }}</div>
                            @if($pesan->no_telepon)
                            <div class="text-[11px] text-blue-600 font-mono font-medium">WA: {{ $pesan->no_telepon }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-4 max-w-sm">
                            <div class="text-slate-900 font-semibold text-xs">{{ $pesan->subjek }}</div>
                            <div class="text-[11px] text-slate-500 font-normal line-clamp-2 mt-0.5">{{ $pesan->pesan }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-slate-400 font-normal text-[11px]">
                            {{ $pesan->created_at ? $pesan->created_at->diffForHumans() : '-' }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-1.5 whitespace-nowrap">
                            <form action="{{ route('tenant.admin.kontak.pesan.toggle', ['tenant' => $tenant->slug, 'id' => $pesan->id]) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-[11px] font-bold transition shadow-xs">
                                    {{ $pesan->is_dibaca ? 'Tandai Belum Dibaca' : 'Tandai Dibaca' }}
                                </button>
                            </form>
                            <form action="{{ route('tenant.admin.kontak.pesan.destroy', ['tenant' => $tenant->slug, 'id' => $pesan->id]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pesan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-white border border-rose-200 hover:bg-rose-50 text-rose-600 text-[11px] font-bold transition shadow-xs">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada pesan masuk dari pengunjung.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-5 border-t border-slate-100">
                {{ $pesanList->links() }}
            </div>
        </div>

        <!-- Mode Grid (Kartu Pesan) -->
        <div x-show="viewMode === 'grid'" x-cloak class="p-6">
            @if($pesanList->isEmpty())
                <div class="py-12 text-center text-slate-400 text-xs">
                    Belum ada pesan masuk dari pengunjung.
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($pesanList as $pesan)
                        <div class="bg-white rounded-2xl border {{ !$pesan->is_dibaca ? 'border-amber-300 ring-2 ring-amber-100' : 'border-slate-200/90' }} p-5 flex flex-col justify-between hover:border-blue-300 transition shadow-2xs">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between gap-2">
                                    @if(!$pesan->is_dibaca)
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200/50">Pesan Baru</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">Dibaca</span>
                                    @endif
                                    <span class="text-[11px] text-slate-400 font-medium">{{ $pesan->created_at ? $pesan->created_at->diffForHumans() : '-' }}</span>
                                </div>

                                <div>
                                    <h4 class="font-bold text-slate-900 text-xs line-clamp-1">{{ $pesan->subjek }}</h4>
                                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-3 leading-relaxed">{{ $pesan->pesan }}</p>
                                </div>

                                <div class="pt-3 border-t border-slate-100 text-[11px] space-y-1">
                                    <div class="font-bold text-slate-800">{{ $pesan->nama_pengirim }}</div>
                                    <div class="text-slate-400 truncate">{{ $pesan->email_pengirim }}</div>
                                    @if($pesan->no_telepon)
                                        <div class="text-blue-600 font-mono text-[11px] font-medium">WA: {{ $pesan->no_telepon }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                                <form action="{{ route('tenant.admin.kontak.pesan.toggle', ['tenant' => $tenant->slug, 'id' => $pesan->id]) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs text-slate-600 hover:text-blue-600 font-bold">
                                        {{ $pesan->is_dibaca ? 'Tandai Belum Dibaca' : 'Tandai Dibaca' }}
                                    </button>
                                </form>
                                <form action="{{ route('tenant.admin.kontak.pesan.destroy', ['tenant' => $tenant->slug, 'id' => $pesan->id]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pesan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-rose-600 hover:text-rose-700 font-bold">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-5">
                    {{ $pesanList->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
