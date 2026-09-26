@extends('layouts.tenant_admin')

@section('title', 'Slider Banner Beranda')
@section('header_title', 'Kelola Slider Beranda')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-base font-bold text-slate-900">Daftar Banner Hero Beranda</h3>
            <p class="text-xs text-slate-500">Banner ini akan tampil secara bergantian di bagian paling atas halaman Beranda.</p>
        </div>
        <a href="{{ route('tenant.admin.slider.create', ['tenant' => $tenant->slug]) }}" class="px-4 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-xs transition inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Slider
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        @if($sliders->isEmpty())
            <div class="p-12 text-center text-slate-400 text-xs">
                Belum ada slider yang ditambahkan. Silakan klik tombol Tambah Slider di atas.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/75 text-slate-600 font-bold uppercase tracking-wider">
                            <th class="py-3.5 px-4 w-16 text-center">Urutan</th>
                            <th class="py-3.5 px-4 w-32">Pratinjau</th>
                            <th class="py-3.5 px-4">Judul & Subjudul</th>
                            <th class="py-3.5 px-4">Tautan Tombol</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($sliders as $slider)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-3 px-4 text-center font-bold text-slate-700">{{ $slider->urutan }}</td>
                                <td class="py-3 px-4">
                                    <div class="w-24 h-14 rounded-lg bg-slate-100 overflow-hidden border border-slate-200">
                                        <img src="{{ $slider->gambar }}" alt="{{ $slider->judul }}" class="w-full h-full object-cover">
                                    </div>
                                </td>
                                <td class="py-3 px-4 max-w-xs sm:max-w-md">
                                    <div class="font-bold text-slate-900 text-sm">{{ $slider->judul ?? '(Tanpa Judul)' }}</div>
                                    <p class="text-slate-500 text-[11px] line-clamp-1 mt-0.5">{{ $slider->subjudul ?? '-' }}</p>
                                </td>
                                <td class="py-3 px-4">
                                    @if($slider->link_tombol)
                                        <span class="inline-flex items-center gap-1 text-[11px] text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md font-medium">
                                            {{ $slider->teks_tombol ?? 'Link' }}: {{ $slider->link_tombol }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-bold {{ $slider->is_aktif ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $slider->is_aktif ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right space-x-2 whitespace-nowrap">
                                    <a href="{{ route('tenant.admin.slider.edit', ['tenant' => $tenant->slug, 'slider' => $slider->id]) }}" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('tenant.admin.slider.destroy', ['tenant' => $tenant->slug, 'slider' => $slider->id]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus slider ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold transition cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection
