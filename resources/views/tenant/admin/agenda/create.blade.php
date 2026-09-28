@extends('layouts.tenant_admin')

@section('title', 'Tambah Agenda Kegiatan')
@section('header_title', 'Tambah Agenda Baru')

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900 tracking-tight">Formulir Jadwal Agenda</h3>
                <p class="text-xs text-slate-500 mt-0.5">Tambah agenda kegiatan, jadwal ujian, atau event sekolah</p>
            </div>
            <a href="{{ route('tenant.admin.agenda.index', ['tenant' => $tenant->slug]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>

        <form action="{{ route('tenant.admin.agenda.store', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf

            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Kegiatan / Agenda <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required placeholder="Contoh: Workshop Pembelajaran Berbasis AI dan Cloud" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Mulai <span class="text-rose-500">*</span></label>
                        <input type="date" name="tgl_mulai" value="{{ old('tgl_mulai') }}" required class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Selesai</label>
                        <input type="date" name="tgl_selesai" value="{{ old('tgl_selesai') }}" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                    <div>
                        <x-admin.input-waktu name="jam_mulai" label="Jam Mulai" :value="old('jam_mulai', '08:00 WIB')" />
                    </div>
                    <div>
                        <x-admin.input-waktu name="jam_selesai" label="Jam Selesai" :value="old('jam_selesai', '15:30 WIB')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Lokasi / Tempat Pelaksanaan <span class="text-rose-500">*</span></label>
                        <input type="text" name="lokasi" value="{{ old('lokasi') }}" required placeholder="Contoh: Aula Utama Graha SMKN 2" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Penyelenggara / Panitia</label>
                        <input type="text" name="penyelenggara" value="{{ old('penyelenggara', 'Panitia Sekolah') }}" class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition">
                    </div>
                </div>

                <x-admin.input-gambar 
                    name="gambar_sampul" 
                    label="Banner Gambar Sampul Kegiatan" 
                    :value="old('gambar_sampul')" 
                    recommended="Format JPG, PNG, atau WebP. Maks 2MB. Rekomendasi 1200x675px." />

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Ringkasan Intisari Agenda</label>
                    <textarea name="ringkasan" rows="2" placeholder="Tuliskan 1-2 kalimat ringkasan agenda..." class="w-full px-4 py-2.5 bg-slate-50/70 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition leading-relaxed">{{ old('ringkasan') }}</textarea>
                </div>

                <div>
                    <x-admin.quill-editor 
                        name="deskripsi" 
                        value="{{ old('deskripsi') }}" 
                        label="Rincian Rundown & Jadwal Lengkap Kegiatan" 
                        placeholder="Uraikan deskripsi agenda, narasumber, target peserta, dan susunan rundown acara..." 
                        height="240px"
                    />
                </div>

                <div class="pt-2">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="is_aktif" value="1" {{ old('is_aktif', true) ? 'checked' : '' }} class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                        <span class="text-xs sm:text-sm font-semibold text-slate-700">Aktifkan dan tampilkan di agenda publik</span>
                    </label>
                </div>
            </div>

            <div class="pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('tenant.admin.agenda.index', ['tenant' => $tenant->slug]) }}" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs hover:shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Agenda
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
