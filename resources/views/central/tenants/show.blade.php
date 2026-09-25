@extends('layouts.central')

@section('title', $tenant->nama_sekolah)
@section('page_title', 'Detail Tenant Sekolah')
@section('page_subtitle', 'Informasi terperinci konfigurasi dan status operasional tenant')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Navigation / Breadcrumb -->
    <div class="flex items-center justify-between">
        <a 
            href="{{ route('superadmin.tenants.index') }}" 
            class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-slate-900 transition-colors"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Daftar Sekolah</span>
        </a>

        <div class="flex items-center gap-2">
            <a 
                href="{{ route('superadmin.tenants.edit', $tenant) }}" 
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold transition-colors min-h-[40px]"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Konfigurasi</span>
            </a>
            
            <form method="POST" action="{{ route('superadmin.tenants.toggle-status', $tenant) }}" class="inline">
                @csrf
                @method('PATCH')
                <button 
                    type="submit" 
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold border transition-colors min-h-[40px] {{ $tenant->status_aktif ? 'border-amber-200 bg-amber-50 text-amber-800 hover:bg-amber-100' : 'border-emerald-200 bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}"
                >
                    <span>{{ $tenant->status_aktif ? 'Suspend Tenant' : 'Aktifkan Kembali' }}</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Header Card -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-2xs">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex flex-wrap items-center gap-2.5 mb-2">
                    <span class="inline-flex px-3 py-1 rounded-md text-xs font-bold bg-slate-100 text-slate-800 border border-slate-200">
                        {{ $tenant->jenjang }}
                    </span>
                    @if ($tenant->status_aktif)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Aktif Beroperasi
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            Ditangguhkan (Suspend)
                        </span>
                    @endif
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900">{{ $tenant->nama_sekolah }}</h1>
                <div class="mt-2 text-xs text-slate-500 font-mono">
                    UUID: <span class="bg-slate-100 px-2 py-0.5 rounded text-slate-700">{{ $tenant->id }}</span>
                </div>
            </div>

            <div class="sm:text-right text-xs text-slate-500">
                <div>Terdaftar Sejak:</div>
                <div class="font-semibold text-slate-800 text-sm mt-0.5">{{ $tenant->created_at->format('d F Y, H:i') }} WIB</div>
            </div>
        </div>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Domain & Akses -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                Domain Terhubung
            </h3>

            <div class="space-y-2">
                @forelse ($tenant->domains as $d)
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                            <span class="font-mono text-sm font-semibold text-indigo-600">{{ $d->domain }}</span>
                        </div>
                        <span class="text-[11px] text-slate-400">DNS Aktif</span>
                    </div>
                @empty
                    <div class="text-xs text-slate-400 italic">Belum ada domain terdaftar.</div>
                @endforelse
            </div>
            <p class="text-xs text-slate-400">
                Domain digunakan untuk merutekan pengunjung langsung ke database terisolasi milik sekolah ini.
            </p>
        </div>

        <!-- Masa Berakhir & Langganan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Masa Operasional
            </h3>

            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-500">Batas Waktu Operasional:</span>
                    <span class="font-semibold text-slate-800">
                        {{ $tenant->tgl_berakhir ? $tenant->tgl_berakhir->format('d F Y') : 'Tanpa Batas (Unlimited)' }}
                    </span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-500">Sisa Durasi:</span>
                    <span class="font-semibold {{ $tenant->tgl_berakhir && $tenant->tgl_berakhir->isPast() ? 'text-rose-600' : 'text-emerald-600' }}">
                        @if ($tenant->tgl_berakhir)
                            {{ $tenant->tgl_berakhir->diffForHumans() }}
                        @else
                            Aktif Permanen
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Kontak & Alamat -->
        <div class="md:col-span-2 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Informasi Kontak & Lokasi
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="text-slate-400 font-medium">Nomor Telepon:</div>
                    <div class="text-slate-800 font-semibold mt-1">{{ $tenant->data['telepon'] ?? '-' }}</div>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="text-slate-400 font-medium">Email Resmi:</div>
                    <div class="text-slate-800 font-semibold mt-1">{{ $tenant->data['email'] ?? '-' }}</div>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="text-slate-400 font-medium">Alamat:</div>
                    <div class="text-slate-800 font-semibold mt-1">{{ $tenant->data['alamat'] ?? '-' }}</div>
                </div>
            </div>
        </div>

    </div>

    <!-- Danger Zone Delete -->
    <div class="p-6 rounded-2xl border border-rose-200 bg-rose-50/40 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h4 class="text-sm font-bold text-rose-900">Hapus Permanen Tenant</h4>
            <p class="text-xs text-rose-700 mt-0.5">Menghapus tenant ini akan mencabut seluruh domain terdaftar dan data konfigurasi terkait.</p>
        </div>
        <form 
            method="POST" 
            action="{{ route('superadmin.tenants.destroy', $tenant) }}"
            onsubmit="return confirm('PENTING: Apakah Anda benar-benar yakin ingin menghapus sekolah {{ $tenant->nama_sekolah }} secara permanen?');"
        >
            @csrf
            @method('DELETE')
            <button 
                type="submit" 
                class="px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-xs transition-colors min-h-[40px]"
            >
                Hapus Tenant Sekolah
            </button>
        </form>
    </div>

</div>
@endsection
