<!-- MODAL KONFIRMASI HAPUS ALBUM -->
<div x-show="modalHapus" x-cloak 
     class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-5 space-y-4 border border-slate-200"
         @click.outside="modalHapus = false">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-sm text-slate-900 font-heading">Hapus Album Beserta Isinya?</h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Anda akan menghapus album <strong class="text-slate-800" x-text="hapusNama"></strong> (<span class="font-bold text-rose-600" x-text="hapusCount + ' media'"></span>). Aksi ini permanen.
                </p>
            </div>
        </div>

        <form :action="hapusActionUrl" method="POST" class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
            @csrf
            @method('DELETE')
            <button type="button" @click="modalHapus = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition cursor-pointer">
                Batal
            </button>
            <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer">
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

<!-- Reusable Media Picker Component -->
@include('tenant.admin.media.picker-modal')
