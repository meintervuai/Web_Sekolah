@extends('layouts.tenant_admin')

@section('title', 'Agenda Kegiatan')
@section('header_title', 'Kelola Agenda Kegiatan')

@section('content')
<div class="max-w-6xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden" x-data="{ viewMode: 'list' }">
        <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Jadwal Kalender & Agenda Sekolah</h3>
                <p class="text-xs text-slate-500 mt-0.5">Kelola agenda akademik, event kejuruan, ujian, dan rapat kedinasan</p>
            </div>
            <div class="flex items-center gap-3">
                <!-- List vs Grid Toggle -->
                <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl border border-slate-200">
                    <button 
                        type="button" 
                        @click="viewMode = 'list'" 
                        :class="viewMode === 'list' ? 'bg-white text-blue-600 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-800'" 
                        class="p-1.5 rounded-lg transition text-xs flex items-center gap-1" 
                        title="Tampilan Tabel"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    </button>
                    <button 
                        type="button" 
                        @click="viewMode = 'grid'" 
                        :class="viewMode === 'grid' ? 'bg-white text-blue-600 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-800'" 
                        class="p-1.5 rounded-lg transition text-xs flex items-center gap-1" 
                        title="Tampilan Grid Kartu"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    </button>
                </div>

                <a href="{{ route('tenant.admin.agenda.create', ['tenant' => $tenant->slug]) }}" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs hover:shadow-sm transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Agenda
                </a>
            </div>
        </div>

        <!-- 1. Tampilan List (Tabel) -->
        <div x-show="viewMode === 'list'" class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 text-slate-500 uppercase font-bold text-[11px] tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Nama Agenda</th>
                        <th class="px-4 py-3.5">Tanggal Pelaksanaan</th>
                        <th class="px-4 py-3.5">Lokasi</th>
                        <th class="px-4 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($agenda as $item)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="px-6 py-4 max-w-sm">
                            <div class="font-bold text-slate-900 text-xs line-clamp-1">{{ $item->judul }}</div>
                            <div class="text-[11px] text-slate-400 line-clamp-1 mt-0.5">{{ $item->ringkasan }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="font-bold text-slate-800 text-xs">{{ $item->tgl_mulai ? $item->tgl_mulai->format('d M Y') : '-' }}</div>
                            <div class="text-[11px] text-blue-600 font-mono font-medium">{{ $item->jam_mulai ?? '08:00' }} WIB</div>
                        </td>
                        <td class="px-4 py-4 text-slate-600 text-xs">
                            {{ $item->lokasi }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            @if($item->is_aktif)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                Nonaktif
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-1.5 whitespace-nowrap">
                            <a href="{{ route('tenant.admin.agenda.edit', ['tenant' => $tenant->slug, 'agenda' => $item->id]) }}" class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-[11px] transition shadow-xs">
                                Edit
                            </a>
                            <form action="{{ route('tenant.admin.agenda.destroy', ['tenant' => $tenant->slug, 'agenda' => $item->id]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus agenda ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-white border border-rose-200 hover:bg-rose-50 text-rose-600 font-bold text-[11px] transition shadow-xs">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada agenda yang dijadwalkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- 2. Tampilan Grid (Kartu Agenda) -->
        <div x-show="viewMode === 'grid'" x-cloak class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse($agenda as $item)
                <div class="border border-slate-200/90 rounded-2xl overflow-hidden bg-white shadow-2xs hover:shadow-xs transition flex flex-col justify-between p-5">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-800 border border-slate-200">
                                {{ $item->tgl_mulai ? $item->tgl_mulai->format('d M Y') : 'Jadwal TBD' }}
                            </span>
                            @if($item->is_aktif)
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200/50">Aktif</span>
                            @else
                            <span class="text-[10px] font-bold text-slate-600 bg-slate-100 px-2.5 py-1 rounded-full">Nonaktif</span>
                            @endif
                        </div>
                        <h4 class="font-bold text-slate-900 text-xs leading-snug line-clamp-2">
                            {{ $item->judul }}
                        </h4>
                        <p class="text-[11px] text-slate-500 mt-2 line-clamp-2 leading-relaxed">
                            {{ $item->ringkasan }}
                        </p>
                        <div class="mt-3 flex items-center gap-1.5 text-[11px] text-slate-600">
                            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="truncate">{{ $item->lokasi ?? 'Kampus Sekolah' }}</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between mt-4">
                        <a href="{{ route('tenant.admin.agenda.edit', ['tenant' => $tenant->slug, 'agenda' => $item->id]) }}" class="text-xs font-bold text-blue-600 hover:text-blue-700">
                            Edit Agenda &rarr;
                        </a>
                        <form action="{{ route('tenant.admin.agenda.destroy', ['tenant' => $tenant->slug, 'agenda' => $item->id]) }}" method="POST" onsubmit="return confirm('Hapus agenda ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="col-span-3 py-12 text-center text-slate-400 text-xs">Belum ada agenda yang dijadwalkan.</div>
                @endforelse
            </div>
        </div>

        <div class="p-5 border-t border-slate-100">
            {{ $agenda->links() }}
        </div>
    </div>

</div>
@endsection
