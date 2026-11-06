@extends('penjaga.layouts.app')

@section('title', 'Rekap Harian')
@section('page-title', 'Rekap Harian')
@section('page-subtitle', $stand->nama_stand)

@section('content')
<div class="mt-6 space-y-6">

    {{-- ── FORM REKAP ─────────────────────────────────────────────────── --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden">

        <div class="px-6 py-4 border-b border-slate-700 flex items-center gap-3">
            <div class="w-9 h-9 bg-emerald-600/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-clipboard-list text-emerald-400"></i>
            </div>
            <div>
                <h2 class="font-bold text-white text-sm">Isi Rekap Harian</h2>
                <p class="text-slate-500 text-xs">Pilih tanggal → klik "Ambil Data" → simpan</p>
            </div>
        </div>

        <div class="p-6">

            {{-- Pilih Tanggal + tombol Ambil Data --}}
            <div class="mb-1">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Pilih Tanggal</label>
                <div class="flex flex-col sm:flex-row gap-3">
                    <input type="date" id="pilihTanggal"
                           value="{{ $today->toDateString() }}"
                           max="{{ $today->toDateString() }}"
                           class="flex-1 bg-slate-700 border border-slate-600 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">
                    <button type="button" id="btnAmbilData"
                        class="bg-emerald-600 hover:bg-emerald-500 active:scale-95 text-white font-bold px-6 py-3 rounded-xl transition flex items-center justify-center gap-2 text-sm whitespace-nowrap">
                        <i class="fas fa-download" id="iconAmbil"></i>
                        <span id="labelAmbil">Ambil Data</span>
                    </button>
                </div>
            </div>

            {{-- Info hari / status -- hanya tampil setelah Ambil Data --}}
            <div id="infoBox" class="hidden mt-4 bg-slate-900/60 rounded-xl px-5 py-4 border border-slate-700 flex flex-col sm:flex-row sm:items-center gap-2">
                <div class="flex items-center gap-3 flex-1">
                    <i class="fas fa-calendar-day text-emerald-400 text-lg"></i>
                    <div>
                        <p class="text-white font-bold text-base" id="labelHariTanggal">—</p>
                        <p class="text-slate-500 text-xs" id="labelStatusRekap">—</p>
                    </div>
                </div>
                <span id="badgeSudah" class="hidden bg-yellow-500/20 text-yellow-400 text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap">
                    Sudah Direkap
                </span>
            </div>

            {{-- Form simpan -- hanya tampil setelah Ambil Data --}}
            <form action="{{ route('penjaga.rekap.store') }}" method="POST" id="formRekap" class="hidden mt-5">
                @csrf
                <input type="hidden" name="tanggal" id="inputTanggal">
                <input type="hidden" name="hari"    id="inputHari">

                {{-- hidden numeric yang dikirim ke server (tanpa titik) --}}
                <input type="hidden" name="total_pendapatan"   id="hidPendapatan">
                <input type="hidden" name="total_keuntungan"   id="hidKeuntungan">
                <input type="hidden" name="total_pesanan"      id="hidTotalPesanan">
                <input type="hidden" name="pesanan_selesai"    id="hidSelesai">
                <input type="hidden" name="pesanan_dibatalkan" id="hidDibatalkan">

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-5">

                    {{-- Total Pendapatan --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
                            <i class="fas fa-coins text-yellow-400 mr-1"></i>Total Pendapatan (Rp)
                        </label>
                        <input type="text" id="dispPendapatan" inputmode="numeric"
                               placeholder="0"
                               class="w-full bg-slate-700 border border-emerald-600/50 rounded-xl px-4 py-3 text-emerald-300 font-bold text-sm focus:outline-none focus:border-emerald-500"
                               autocomplete="off">
                    </div>

                    {{-- Total Keuntungan --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
                            <i class="fas fa-chart-line text-blue-400 mr-1"></i>Total Keuntungan (Rp)
                        </label>
                        <input type="text" id="dispKeuntungan" inputmode="numeric"
                               placeholder="Isi manual atau biarkan 0"
                               class="w-full bg-slate-700 border border-blue-600/50 rounded-xl px-4 py-3 text-blue-300 font-bold text-sm focus:outline-none focus:border-blue-500"
                               autocomplete="off">
                    </div>

                    {{-- Total Pesanan --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
                            <i class="fas fa-shopping-bag text-slate-400 mr-1"></i>Total Pesanan
                        </label>
                        <input type="text" id="dispTotalPesanan" inputmode="numeric"
                               placeholder="0" readonly
                               class="w-full bg-slate-700/50 border border-slate-600 rounded-xl px-4 py-3 text-white text-sm focus:outline-none cursor-default">
                    </div>

                    {{-- Pesanan Selesai --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
                            <i class="fas fa-check-circle text-emerald-400 mr-1"></i>Pesanan Selesai
                        </label>
                        <input type="text" id="dispSelesai" inputmode="numeric"
                               placeholder="0" readonly
                               class="w-full bg-slate-700/50 border border-slate-600 rounded-xl px-4 py-3 text-white text-sm focus:outline-none cursor-default">
                    </div>

                    {{-- Pesanan Dibatalkan --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
                            <i class="fas fa-times-circle text-red-400 mr-1"></i>Pesanan Dibatalkan
                        </label>
                        <input type="text" id="dispDibatalkan" inputmode="numeric"
                               placeholder="0" readonly
                               class="w-full bg-slate-700/50 border border-slate-600 rounded-xl px-4 py-3 text-white text-sm focus:outline-none cursor-default">
                    </div>

                    {{-- Catatan --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
                            <i class="fas fa-sticky-note text-slate-400 mr-1"></i>Catatan (opsional)
                        </label>
                        <input type="text" name="catatan" id="inputCatatan"
                               maxlength="1000"
                               placeholder="Misal: ada promo, ramai, dll."
                               class="w-full bg-slate-700 border border-slate-600 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">
                    </div>
                </div>

                <div class="flex gap-3 flex-wrap">
                    <button type="submit" id="btnSimpan"
                        class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-bold px-8 py-3 rounded-xl text-sm hover:opacity-90 transition shadow-lg flex items-center gap-2">
                        <i class="fas fa-save"></i> Simpan Rekap
                    </button>
                    <button type="button" id="btnReset"
                        class="bg-slate-700 hover:bg-slate-600 text-slate-300 font-bold px-6 py-3 rounded-xl text-sm transition flex items-center gap-2">
                        <i class="fas fa-redo"></i> Reset Form
                    </button>
                </div>
            </form>

        </div>
    </div>

    {{-- ── TABEL RIWAYAT ────────────────────────────────────────────────── --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-700 flex items-center justify-between">
            <h3 class="font-semibold text-white flex items-center gap-2">
                <i class="fas fa-history text-emerald-400 text-sm"></i>
                Riwayat Rekap Harian
            </h3>
            <span class="text-slate-500 text-xs">{{ $riwayat->count() }} catatan</span>
        </div>

        @if($riwayat->isEmpty())
            <div class="px-6 py-12 text-center text-slate-500">
                <i class="fas fa-clipboard text-3xl mb-3 block"></i>
                Belum ada rekap tersimpan. Isi form di atas untuk mulai mencatat.
            </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-700/50">
                    <tr class="text-xs text-slate-400 uppercase tracking-wider">
                        <th class="px-4 py-3 text-left">Hari / Tanggal</th>
                        <th class="px-4 py-3 text-right">Pendapatan</th>
                        <th class="px-4 py-3 text-right">Keuntungan</th>
                        <th class="px-4 py-3 text-center">Total Pesanan</th>
                        <th class="px-4 py-3 text-center">Selesai</th>
                        <th class="px-4 py-3 text-center">Batal</th>
                        <th class="px-4 py-3 text-left hidden lg:table-cell">Catatan</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @foreach($riwayat as $r)
                    <tr class="hover:bg-slate-700/30 transition">
                        <td class="px-4 py-3">
                            <p class="font-semibold text-white">{{ $r->hari }}</p>
                            <p class="text-xs text-slate-400">{{ $r->tanggal->format('d/m/Y') }}</p>
                        </td>
                        <td class="px-4 py-3 text-right font-bold text-emerald-400">
                            Rp {{ number_format($r->total_pendapatan, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-right font-bold text-blue-400">
                            Rp {{ number_format($r->total_keuntungan, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center text-white font-semibold">{{ $r->total_pesanan }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="bg-emerald-500/20 text-emerald-400 text-xs font-bold px-2 py-0.5 rounded-full">{{ $r->pesanan_selesai }}</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="bg-red-500/20 text-red-400 text-xs font-bold px-2 py-0.5 rounded-full">{{ $r->pesanan_dibatalkan }}</span>
                        </td>
                        <td class="px-4 py-3 hidden lg:table-cell text-slate-400 text-xs max-w-[160px] truncate">
                            {{ $r->catatan ?: '—' }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <form action="{{ route('penjaga.rekap.destroy', $r) }}" method="POST"
                                  onsubmit="return confirm('Hapus rekap {{ $r->hari }}, {{ $r->tanggal->format('d/m/Y') }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="p-2 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition text-xs" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-slate-700/30 border-t border-slate-600">
                    <tr class="text-xs font-bold">
                        <td class="px-4 py-3 text-slate-300">TOTAL ({{ $riwayat->count() }} hari)</td>
                        <td class="px-4 py-3 text-right text-emerald-300">
                            Rp {{ number_format($riwayat->sum('total_pendapatan'), 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-right text-blue-300">
                            Rp {{ number_format($riwayat->sum('total_keuntungan'), 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center text-white">{{ $riwayat->sum('total_pesanan') }}</td>
                        <td class="px-4 py-3 text-center text-emerald-300">{{ $riwayat->sum('pesanan_selesai') }}</td>
                        <td class="px-4 py-3 text-center text-red-300">{{ $riwayat->sum('pesanan_dibatalkan') }}</td>
                        <td class="px-4 py-3 hidden lg:table-cell"></td>
                        <td class="px-4 py-3"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
(function () {
    const liveUrl    = "{{ route('penjaga.rekap.live') }}";

    // UI elements
    const btnAmbil   = document.getElementById('btnAmbilData');
    const iconAmbil  = document.getElementById('iconAmbil');
    const labelAmbil = document.getElementById('labelAmbil');
    const pilihTgl   = document.getElementById('pilihTanggal');
    const infoBox    = document.getElementById('infoBox');
    const formRekap  = document.getElementById('formRekap');
    const btnReset   = document.getElementById('btnReset');

    // Display inputs (user-facing, formatted)
    const dispPendapatan  = document.getElementById('dispPendapatan');
    const dispKeuntungan  = document.getElementById('dispKeuntungan');
    const dispTotalPesanan= document.getElementById('dispTotalPesanan');
    const dispSelesai     = document.getElementById('dispSelesai');
    const dispDibatalkan  = document.getElementById('dispDibatalkan');

    // Hidden inputs (sent to server, numeric only)
    const hidPendapatan   = document.getElementById('hidPendapatan');
    const hidKeuntungan   = document.getElementById('hidKeuntungan');
    const hidTotalPesanan = document.getElementById('hidTotalPesanan');
    const hidSelesai      = document.getElementById('hidSelesai');
    const hidDibatalkan   = document.getElementById('hidDibatalkan');

    // Other
    const inputTanggal   = document.getElementById('inputTanggal');
    const inputHari      = document.getElementById('inputHari');
    const inputCatatan   = document.getElementById('inputCatatan');
    const labelHariTgl   = document.getElementById('labelHariTanggal');
    const labelStatus    = document.getElementById('labelStatusRekap');
    const badgeSudah     = document.getElementById('badgeSudah');

    // ── Format helpers ──────────────────────────────────────────────────
    /** "60000" → "60.000" */
    function formatRibuan(val) {
        const angka = String(val).replace(/\D/g, '');
        if (!angka) return '';
        return parseInt(angka, 10).toLocaleString('id-ID');
    }

    /** "60.000" → 60000 */
    function stripFormat(val) {
        return parseInt(String(val).replace(/\./g, '').replace(/,/g, ''), 10) || 0;
    }

    /** Attach format-on-input ke field uang editable */
    function attachFormatter(dispEl, hidEl) {
        dispEl.addEventListener('input', function () {
            const raw   = this.value.replace(/\./g, '').replace(/,/g, '');
            const angka = raw.replace(/\D/g, '');
            this.value  = angka ? parseInt(angka, 10).toLocaleString('id-ID') : '';
            hidEl.value = angka || '0';
        });
    }

    attachFormatter(dispPendapatan, hidPendapatan);
    attachFormatter(dispKeuntungan, hidKeuntungan);

    // ── Ambil Data dari server ──────────────────────────────────────────
    function ambilData() {
        const tanggal = pilihTgl.value;
        if (!tanggal) return;

        btnAmbil.disabled = true;
        iconAmbil.className = 'fas fa-spinner fa-spin';
        labelAmbil.textContent = 'Memuat...';

        fetch(liveUrl + '?tanggal=' + tanggal, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.error) { alert(data.error); return; }

            // Update hidden metadata
            inputTanggal.value = tanggal;
            inputHari.value    = data.hari;

            // Tampilkan info box
            labelHariTgl.textContent = data.hari + ', ' + data.tanggal_display;

            // Isi field angka (display + hidden)
            const pendapatan = data.total_pendapatan || 0;
            dispPendapatan.value  = formatRibuan(pendapatan);
            hidPendapatan.value   = pendapatan;

            dispTotalPesanan.value = data.total_pesanan || 0;
            hidTotalPesanan.value  = data.total_pesanan || 0;

            dispSelesai.value  = data.pesanan_selesai || 0;
            hidSelesai.value   = data.pesanan_selesai || 0;

            dispDibatalkan.value = data.pesanan_dibatalkan || 0;
            hidDibatalkan.value  = data.pesanan_dibatalkan || 0;

            if (data.sudah_direkap) {
                dispKeuntungan.value = formatRibuan(data.total_keuntungan || 0);
                hidKeuntungan.value  = data.total_keuntungan || 0;
                inputCatatan.value   = data.catatan || '';
                badgeSudah.classList.remove('hidden');
                labelStatus.innerHTML = '<span class="text-yellow-400">⚠ Sudah pernah direkap — simpan ulang untuk update</span>';
            } else {
                dispKeuntungan.value = '';
                hidKeuntungan.value  = '0';
                inputCatatan.value   = '';
                badgeSudah.classList.add('hidden');
                labelStatus.textContent = 'Data siap direkap';
            }

            // Tampilkan info box dan form
            infoBox.classList.remove('hidden');
            formRekap.classList.remove('hidden');
        })
        .catch(() => alert('Gagal mengambil data. Coba lagi.'))
        .finally(() => {
            btnAmbil.disabled = false;
            iconAmbil.className = 'fas fa-download';
            labelAmbil.textContent = 'Ambil Data';
        });
    }

    btnAmbil.addEventListener('click', ambilData);

    // ── Sebelum submit: pastikan hidden values up to date ───────────────
    formRekap.addEventListener('submit', function () {
        hidPendapatan.value = stripFormat(dispPendapatan.value) || 0;
        hidKeuntungan.value = stripFormat(dispKeuntungan.value) || 0;
        // total pesanan, selesai, dibatalkan sudah di-set langsung dari fetch
    });

    // ── Reset Form ───────────────────────────────────────────────────────
    btnReset.addEventListener('click', function () {
        // Kosongkan semua field display
        dispPendapatan.value   = '';
        dispKeuntungan.value   = '';
        dispTotalPesanan.value = '';
        dispSelesai.value      = '';
        dispDibatalkan.value   = '';
        inputCatatan.value     = '';

        // Reset hidden
        hidPendapatan.value   = '0';
        hidKeuntungan.value   = '0';
        hidTotalPesanan.value = '0';
        hidSelesai.value      = '0';
        hidDibatalkan.value   = '0';

        // Sembunyikan form & info box
        infoBox.classList.add('hidden');
        formRekap.classList.add('hidden');
        badgeSudah.classList.add('hidden');

        // Kembalikan tanggal ke hari ini
        pilihTgl.value = pilihTgl.max;
    });

})();
</script>
@endpush
