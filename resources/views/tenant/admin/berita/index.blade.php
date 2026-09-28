@extends('layouts.tenant_admin')

@section('title', 'Berita & Artikel Sekolah')
@section('header_title', 'Kelola Berita & Artikel')

@section('content')
<div class="max-w-6xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Publikasi Berita & Kegiatan Sekolah</h3>
                <p class="text-xs text-slate-500 mt-0.5">Kelola artikel warta sekolah, prestasi terkini, dan kegiatan akademik.</p>
            </div>
            <div>
                <a href="{{ route('tenant.admin.berita.create', ['tenant' => $tenant->slug]) }}" class="px-4 py-2 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-md transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tulis Berita Baru
                </a>
            </div>
        </div>

        <div class="p-6 overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100/75 text-slate-600 uppercase font-bold text-[10px]">
                    <tr>
                        <th class="px-4 py-3 rounded-l-lg">Sampul</th>
                        <th class="px-4 py-3">Judul Berita</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3 text-right rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($berita as $item)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-4 py-3">
                            @if($item->gambar_sampul)
                            <img src="{{ $item->gambar_sampul }}" alt="{{ $item->judul }}" class="w-14 h-9 rounded-md object-cover border border-slate-200">
                            @else
                            <div class="w-14 h-9 rounded-md bg-slate-200 flex items-center justify-center text-[9px] text-slate-400">NO PIC</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 max-w-sm">
                            <div class="font-bold text-slate-800 text-sm line-clamp-1">{{ $item->judul }}</div>
                            <div class="text-[11px] text-slate-400 line-clamp-1">{{ $item->ringkasan }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-medium text-[11px]">
                                {{ $item->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($item->status_publikasi === 'published')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Published
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700">
                                Draft
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-slate-500 whitespace-nowrap">
                            {{ $item->tgl_publikasi ? $item->tgl_publikasi->format('d M Y') : '-' }}
                        </td>
                        <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                            <a href="{{ route('tenant.admin.berita.edit', ['tenant' => $tenant->slug, 'berita' => $item->id]) }}" class="px-2.5 py-1 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition">
                                Edit
                            </a>
                            <form action="{{ route('tenant.admin.berita.destroy', ['tenant' => $tenant->slug, 'berita' => $item->id]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus artikel berita ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2.5 py-1 rounded-md bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold transition cursor-pointer">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-slate-400">Belum ada berita yang ditulis.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $berita->links() }}
            </div>
        </div>
    </div>

</div>
@endsection
