@extends('layouts.tenant_admin')

@section('title', 'Direktori Guru & Staf')
@section('header_title', 'Kelola Guru & Tenaga Kependidikan')

@section('content')
<div class="max-w-6xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Direktori Guru & Tenaga Kependidikan</h3>
                <p class="text-xs text-slate-500 mt-0.5">Kelola data pendidik, bidang mata pelajaran yang diampu, jabatan, serta foto profil resmi.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('tenant.admin.guru.create', ['tenant' => $tenant->slug]) }}" class="px-4 py-2 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-md transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Guru/Staf
                </a>
            </div>
        </div>

        <div class="p-6 overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100/75 text-slate-600 uppercase font-bold text-[10px]">
                    <tr>
                        <th class="px-4 py-3 rounded-l-lg">Foto</th>
                        <th class="px-4 py-3">Nama Lengkap & NIP</th>
                        <th class="px-4 py-3">Jabatan</th>
                        <th class="px-4 py-3">Mata Pelajaran</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($guru as $item)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-4 py-3">
                            @if($item->foto)
                            <img src="{{ $item->foto }}" alt="{{ $item->nama_lengkap }}" class="w-9 h-9 rounded-full object-cover border border-slate-200">
                            @else
                            <div class="w-9 h-9 rounded-full bg-slate-200 flex items-center justify-center text-[10px] text-slate-500 font-bold">
                                {{ substr($item->nama_lengkap, 0, 1) }}
                            </div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-bold text-slate-800 text-sm">{{ $item->nama_lengkap }}</div>
                            <div class="text-[11px] text-slate-400 font-mono">NIP: {{ $item->nip ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-3 font-semibold text-slate-700">
                            {{ $item->jabatan }}
                        </td>
                        <td class="px-4 py-3 text-slate-600">
                            {{ $item->mata_pelajaran ?? '-' }}
                        </td>
                        <td class="px-4 py-3">
                            @if($item->status_aktif)
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
                            <a href="{{ route('tenant.admin.guru.edit', ['tenant' => $tenant->slug, 'guru' => $item->id]) }}" class="px-2.5 py-1 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition">
                                Edit
                            </a>
                            <form action="{{ route('tenant.admin.guru.destroy', ['tenant' => $tenant->slug, 'guru' => $item->id]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data pendidik ini?')">
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
                        <td colspan="6" class="px-4 py-8 text-center text-slate-400">Belum ada data guru/staf yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $guru->links() }}
            </div>
        </div>
    </div>

</div>
@endsection
