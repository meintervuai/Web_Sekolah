<!-- MODAL KONFIRMASI HAPUS JURUSAN -->
<div x-show="modalDeleteOpen" x-cloak 
     class="admin-modal-overlay">
    <div class="admin-modal-card max-w-sm w-full p-5 space-y-4"
         @click.outside="modalDeleteOpen = false">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-sm text-slate-900 font-heading">Hapus Program Keahlian?</h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Yakin ingin menghapus <strong class="text-slate-800" x-text="deleteTargetNama"></strong>? Data yang dihapus tidak dapat dipulihkan.
                </p>
            </div>
        </div>

        <form :action="`{{ url(app('tenant')->slug . '/admin/program-keahlian') }}/${deleteTargetId}`" method="POST" class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
            @csrf
            @method('DELETE')
            <button type="button" @click="modalDeleteOpen = false" 
                    class="admin-btn-cancel text-xs">
                Batal
            </button>
            <button type="submit" 
                    class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer">
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

<!-- MEDIA PICKER MODAL INCLUDE -->
@include('tenant.admin.media.picker-modal')
