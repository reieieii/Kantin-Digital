@extends('admin.layouts.app')

@section('title', 'Reset Data Stand')
@section('page-title', 'Reset Data Stand')
@section('page-subtitle', 'Pergantian penjaga mingguan — reset semua data stand')

@section('content')
<div class="mt-4 max-w-2xl">

    {{-- Warning banner --}}
    <div class="bg-red-900/20 border border-red-700/40 rounded-2xl p-5 mb-6 flex items-start gap-4">
        <div class="w-10 h-10 bg-red-600/20 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fas fa-triangle-exclamation text-red-400 text-lg"></i>
        </div>
        <div>
            <h3 class="font-bold text-red-300 text-base mb-1">Zona Berbahaya — Reset Total Data Stand</h3>
            <p class="text-slate-400 text-sm leading-relaxed">
                Gunakan fitur ini saat <strong class="text-white">pergantian penjaga</strong> setiap minggunya.
                Reset akan menghapus secara permanen:
            </p>
            <ul class="mt-2 space-y-1 text-sm text-slate-400">
                <li class="flex items-center gap-2"><i class="fas fa-times text-red-400 text-xs w-3"></i> Seluruh pesanan (dashboard & menu pesanan)</li>
                <li class="flex items-center gap-2"><i class="fas fa-times text-red-400 text-xs w-3"></i> Semua catatan rekap harian</li>
                <li class="flex items-center gap-2"><i class="fas fa-times text-red-400 text-xs w-3"></i> Total pendapatan stand → Rp 0</li>
            </ul>
            <p class="text-red-400 text-xs font-bold mt-2">⚠ Tindakan ini TIDAK BISA DIBATALKAN.</p>
        </div>
    </div>

    {{-- Form reset --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-700">
            <h3 class="font-semibold text-white text-sm flex items-center gap-2">
                <i class="fas fa-rotate-left text-red-400"></i>
                Pilih Stand & Konfirmasi
            </h3>
        </div>
        <div class="p-6 space-y-5">

            <form action="{{ route('admin.rekap.reset') }}" method="POST" id="formReset">
                @csrf

                {{-- Pilih Stand --}}
                <div class="mb-5">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Stand yang Direset</label>
                    <select name="stand_id"
                        class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-red-500">
                        <option value="">🔴 Semua Stand (Reset semua sekaligus)</option>
                        @foreach($stands as $s)
                            <option value="{{ $s->id }}" {{ old('stand_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->nama_stand }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-slate-500 text-xs mt-1">Pilih satu stand tertentu, atau biarkan kosong untuk reset semua stand.</p>
                </div>

                {{-- Konfirmasi --}}
                <div class="mb-5">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
                        Ketik <span class="text-red-400">RESET</span> untuk konfirmasi
                    </label>
                    <input type="text" name="konfirmasi" id="inputKonfirmasi"
                           placeholder="Ketik RESET di sini"
                           autocomplete="off"
                           class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-red-500 tracking-widest">
                    @error('konfirmasi')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol --}}
                <button type="button" id="btnReset"
                    class="w-full bg-red-600 hover:bg-red-500 disabled:opacity-40 disabled:cursor-not-allowed text-white font-bold px-6 py-3.5 rounded-xl text-sm transition flex items-center justify-center gap-2"
                    disabled>
                    <i class="fas fa-rotate-left"></i> Eksekusi Reset Sekarang
                </button>
            </form>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
(function () {
    const input = document.getElementById('inputKonfirmasi');
    const btn   = document.getElementById('btnReset');
    const form  = document.getElementById('formReset');

    input.addEventListener('input', function () {
        btn.disabled = this.value.trim().toUpperCase() !== 'RESET';
    });

    btn.addEventListener('click', function () {
        const standSelect = form.querySelector('[name="stand_id"]');
        const standLabel  = standSelect.options[standSelect.selectedIndex].text;
        const target      = standSelect.value ? '"' + standLabel + '"' : 'SEMUA STAND';

        const ok = confirm(
            '⚠️ PERHATIAN!\n\n' +
            'Kamu akan mereset SEMUA DATA ' + target + ':\n' +
            '• Seluruh pesanan\n' +
            '• Semua catatan rekap harian\n' +
            '• Total pendapatan → Rp 0\n\n' +
            'Tindakan ini TIDAK BISA DIBATALKAN.\n\n' +
            'Lanjutkan?'
        );
        if (ok) form.submit();
    });
})();
</script>
@endpush
