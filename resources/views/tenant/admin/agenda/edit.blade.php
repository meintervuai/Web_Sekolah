@extends('layouts.tenant_admin')

@section('title', 'Edit Agenda Kegiatan')
@section('header_title', 'Edit Agenda: ' . $agenda->judul)

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-900">Perbarui Jadwal Agenda</h3>
            <a href="{{ route('tenant.admin.agenda.index', ['tenant' => $tenant->slug]) }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                &larr; Kembali ke Daftar
            </a>
        </div>

        <form action="{{ route('tenant.admin.agenda.update', ['tenant' => $tenant->slug, 'agenda' => $agenda->id]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Kegiatan / Agenda</label>
                    <input type="text" name="judul" value="{{ old('judul', $agenda->judul) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Mulai</label>
                        <input type="date" name="tgl_mulai" value="{{ old('tgl_mulai', $agenda->tgl_mulai ? $agenda->tgl_mulai->format('Y-m-d') : '') }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Selesai</label>
                        <input type="date" name="tgl_selesai" value="{{ old('tgl_selesai', $agenda->tgl_selesai ? $agenda->tgl_selesai->format('Y-m-d') : '') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                    </div>
                    <div>
                        <x-admin.input-waktu name="jam_mulai" label="Jam Mulai" :value="old('jam_mulai', $agenda->jam_mulai)" />
                    </div>
                    <div>
                        <x-admin.input-waktu name="jam_selesai" label="Jam Selesai" :value="old('jam_selesai', $agenda->jam_selesai)" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Lokasi / Tempat Pelaksanaan</label>
                        <input type="text" name="lokasi" value="{{ old('lokasi', $agenda->lokasi) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Penyelenggara / Panitia</label>
                        <input type="text" name="penyelenggara" value="{{ old('penyelenggara', $agenda->penyelenggara) }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                    </div>
                </div>

                <x-admin.input-gambar 
                    name="gambar_sampul" 
                    label="Banner Gambar Sampul Kegiatan" 
                    :value="old('gambar_sampul', $agenda->gambar_sampul)" 
                    maxSize="2MB" 
                    recommendedResolution="Landscape 1200 x 675 px (16:9)" />

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Ringkasan Agenda</label>
                    <textarea name="ringkasan" rows="2" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white leading-relaxed">{{ old('ringkasan', $agenda->ringkasan) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi Lengkap / Rundown Acara</label>
                    <textarea name="deskripsi_lengkap" rows="6" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white leading-relaxed font-mono">{{ old('deskripsi_lengkap', $agenda->deskripsi_lengkap) }}</textarea>
                </div>

                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_aktif" value="1" {{ old('is_aktif', $agenda->is_aktif) ? 'checked' : '' }} class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-xs font-semibold text-slate-700">Aktifkan agenda ini di kalender publik</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex justify-end gap-3">
                <a href="{{ route('tenant.admin.agenda.index', ['tenant' => $tenant->slug]) }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-md transition cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
