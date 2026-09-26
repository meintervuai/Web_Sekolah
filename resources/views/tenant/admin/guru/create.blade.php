@extends('layouts.tenant_admin')

@section('title', 'Tambah Guru / Staf')
@section('header_title', 'Tambah Tenaga Pendidik / Staf')

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-900">Formulir Pendidik / Tenaga Kependidikan</h3>
            <a href="{{ route('tenant.admin.guru.index', ['tenant' => $tenant->slug]) }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                &larr; Kembali ke Daftar
            </a>
        </div>

        <form action="{{ route('tenant.admin.guru.store', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf

            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Contoh: Dra. Hj. Siti Aminah, M.Si." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">NIP (Nomor Induk Pegawai)</label>
                        <input type="text" name="nip" value="{{ old('nip') }}" placeholder="19700101 199503 1 001" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jenis Kelamin</label>
                        <select name="jenis_kelamin" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jabatan / Tugas</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan') }}" required placeholder="Contoh: Guru Kejuruan / Kepala Lab" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Mata Pelajaran yang Diampu</label>
                        <input type="text" name="mata_pelajaran" value="{{ old('mata_pelajaran') }}" placeholder="Contoh: Pemrograman Web / CNC" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white">
                    </div>
                </div>

                <x-admin.input-gambar 
                    name="foto" 
                    label="Pas Foto Resmi Guru / Pendidik" 
                    :value="old('foto')" 
                    maxSize="2MB" 
                    recommendedResolution="Format Potret 3:4 atau Kotak (600 x 800 px)" />

                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="status_aktif" value="1" {{ old('status_aktif', true) ? 'checked' : '' }} class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-xs font-semibold text-slate-700">Pendidik aktif dan tampilkan di direktori publik</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex justify-end gap-3">
                <a href="{{ route('tenant.admin.guru.index', ['tenant' => $tenant->slug]) }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-md transition cursor-pointer">
                    Simpan Data Pendidik
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
