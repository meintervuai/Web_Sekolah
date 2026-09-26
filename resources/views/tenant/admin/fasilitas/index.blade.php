@extends('layouts.tenant_admin')

@section('title', 'Fasilitas Sekolah')
@section('header_title', 'Kelola Fasilitas & Sarana Belajar')

@section('content')
<div class="max-w-6xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Daftar Fasilitas, Bengkel & Lab Sekolah</h3>
                <p class="text-xs text-slate-500 mt-0.5">Kelola sarana dan prasarana pendukung belajar mengajar dan standar industri.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ url($tenant->slug . '/fasilitas') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 shadow-2xs transition inline-flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Lihat di Publik
                </a>
                <a href="{{ route('tenant.admin.fasilitas.create', ['tenant' => $tenant->slug]) }}" class="px-4 py-2 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-md transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Fasilitas
                </a>
            </div>
        </div>

        <div class="p-6 overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100/75 text-slate-600 uppercase font-bold text-[10px]">
                    <tr>
                        <th class="px-4 py-3 rounded-l-lg">Foto Utama</th>
                        <th class="px-4 py-3">Nama Sarana / Fasilitas</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($fasilitas as $item)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-4 py-3">
                            @if($item->foto_utama)
                            <img src="{{ $item->foto_utama }}" alt="{{ $item->nama_fasilitas }}" class="w-14 h-9 rounded-md object-cover border border-slate-200">
                            @else
                            <div class="w-14 h-9 rounded-md bg-slate-200 flex items-center justify-center text-[9px] text-slate-400">NO PIC</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 max-w-md">
                            <div class="font-bold text-slate-800 text-sm">{{ $item->nama_fasilitas }}</div>
                            <div class="text-[11px] text-slate-400 line-clamp-1 mt-0.5">{{ $item->deskripsi }}</div>
                        </td>
                        <td class="px-4 py-3">
                            @if($item->is_aktif)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                                Nonaktif
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                            <a href="{{ route('tenant.admin.fasilitas.edit', ['tenant' => $tenant->slug, 'fasilitas' => $item->id]) }}" class="px-2.5 py-1 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition">
                                Edit
                            </a>
                            <form action="{{ route('tenant.admin.fasilitas.destroy', ['tenant' => $tenant->slug, 'fasilitas' => $item->id]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus fasilitas ini?')">
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
                        <td colspan="4" class="px-4 py-8 text-center text-slate-400">Belum ada fasilitas yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
