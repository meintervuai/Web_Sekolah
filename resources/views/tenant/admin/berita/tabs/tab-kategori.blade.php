<!-- TAB 3: MANAJEMEN KATEGORI BERITA -->
<div x-show="activeTab === 'kategori'" x-cloak class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <!-- Form Tambah/Edit Kategori (5 cols) -->
        <div class="md:col-span-5 bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading" x-text="kategoriForm.id ? 'Edit Kategori Berita' : 'Tambah Kategori Baru'"></h3>
                <p class="text-xs text-slate-500">Kelompokkan berita agar pengunjung mudah mencari topik relevan.</p>
            </div>

            <form :action="kategoriForm.id ? '{{ url(app('tenant')->slug . '/admin/informasi/kategori') }}/' + kategoriForm.id : '{{ route('tenant.admin.informasi.kategori.store', ['tenant' => app('tenant')->slug]) }}'" method="POST" class="space-y-4">
                @csrf
                <template x-if="kategoriForm.id">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_kategori" x-model="kategoriForm.nama_kategori" required placeholder="Contoh: Prestasi, Kemitraan Industri, TEFA"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <template x-if="kategoriForm.id">
                        <button type="button" @click="resetKategoriForm()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition cursor-pointer">
                            Batal
                        </button>
                    </template>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center gap-2 cursor-pointer">
                        <span x-text="kategoriForm.id ? 'Perbarui Kategori' : 'Tambah Kategori'"></span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Daftar Kategori (7 cols) -->
        <div class="md:col-span-7 bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading">Daftar Kategori Aktif</h3>
                <p class="text-xs text-slate-500">Kategori dengan jumlah artikel yang terhubung.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-2.5">Nama Kategori</th>
                            <th class="px-4 py-2.5">Slug URL</th>
                            <th class="px-4 py-2.5 text-center">Jumlah Artikel</th>
                            <th class="px-4 py-2.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($kategoriList as $kat)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-3 font-bold text-slate-900">{{ $kat->nama_kategori }}</td>
                                <td class="px-4 py-3 font-mono text-[11px] text-slate-400">{{ $kat->slug }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                        {{ $kat->artikels_count }} artikel
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button type="button" @click="editKategori({{ Js::from($kat) }})" class="p-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-blue-600 transition cursor-pointer">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </button>
                                        <button type="button" @click="confirmDelete('kategori', {{ $kat->id }}, '{{ addslashes($kat->nama_kategori) }}')" class="p-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-600 transition cursor-pointer">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
