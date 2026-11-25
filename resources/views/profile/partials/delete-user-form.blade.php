<section class="space-y-5">
    <header class="flex items-start gap-3 pb-4 border-b border-rose-100">
        <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-base font-bold text-slate-900">
                Hapus Akun
            </h2>
            <p class="mt-0.5 text-xs text-slate-500 leading-relaxed">
                Setelah akun dihapus, seluruh data dan akses yang terkait dengan akun ini akan dihapus secara permanen. Pastikan Anda telah menyimpan informasi penting sebelum melanjutkan.
            </p>
        </div>
    </header>

    <button type="button"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 active:bg-rose-800 text-white font-semibold text-sm transition shadow-sm shadow-rose-600/20">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        <span>Hapus Akun</span>
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-5">
            @csrf
            @method('delete')

            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-900">
                        Apakah Anda yakin ingin menghapus akun ini?
                    </h2>
                    <p class="mt-1 text-xs text-slate-500 leading-relaxed">
                        Tindakan ini bersifat permanen dan tidak dapat dibatalkan. Masukkan kata sandi Anda untuk mengonfirmasi penghapusan akun.
                    </p>
                </div>
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-slate-600 mb-1.5">
                    Kata Sandi Konfirmasi
                </label>
                <input id="password" name="password" type="password"
                       placeholder="Masukkan kata sandi Anda"
                       class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 focus:bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 focus:outline-none transition">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1.5 text-xs" />
            </div>

            <div class="flex justify-end gap-2.5 pt-2">
                <button type="button" x-on:click="$dispatch('close')"
                        class="px-4 py-2.5 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-semibold text-sm transition">
                    Batal
                </button>

                <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-sm transition shadow-sm">
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>
