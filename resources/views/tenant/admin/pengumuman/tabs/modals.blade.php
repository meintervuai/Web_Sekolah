<!-- Modal Konfirmasi Hapus Data -->
<div x-show="showDeleteModal" style="display: none;" 
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 space-y-4 shadow-xl text-center">
        <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 mx-auto flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading">Konfirmasi Hapus Pengumuman</h3>
        <p class="text-xs text-slate-500" x-text="'Apakah Anda yakin ingin menghapus pengumuman \'' + deleteItemName + '\'?'"></p>
        <form :action="deleteActionUrl" method="POST" class="flex gap-2">
            @csrf
            @method('DELETE')
            <button type="button" @click="showDeleteModal = false" class="flex-1 py-2.5 rounded-xl border border-slate-200 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition cursor-pointer">Batal</button>
            <button type="submit" class="flex-1 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition cursor-pointer">Ya, Hapus</button>
        </form>
    </div>
</div>

<!-- Modal Media Picker Reusable -->
@include('tenant.admin.media.picker-modal')
