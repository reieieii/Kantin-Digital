@extends('penjaga.layouts.app')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')
@section('page-subtitle', $pesanan->kode_pembelian)

@section('content')
<div class="mt-6 grid lg:grid-cols-3 gap-6">

    {{-- Info Pesanan --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Detail Produk --}}
        <div class="bg-slate-800 rounded-2xl border border-slate-700">
            <div class="px-6 py-4 border-b border-slate-700">
                <h3 class="font-semibold text-white">Item Pesanan</h3>
            </div>
            <div class="divide-y divide-slate-700">
                @foreach($pesanan->detailPembelians as $d)
                <div class="px-6 py-4 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-700 flex-shrink-0">
                        @if($d->produk && $d->produk->gambar)
                            <img src="{{ str_starts_with($d->produk->gambar,'http') ? $d->produk->gambar : asset('storage/'.$d->produk->gambar) }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-500">
                                <i class="fas fa-utensils"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-white">{{ $d->nama_produk }}</p>
                        <p class="text-xs text-slate-400">{{ $d->quantity }} x Rp {{ number_format($d->harga, 0, ',', '.') }}</p>
                    </div>
                    <p class="text-sm font-bold text-emerald-400">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
            <div class="px-6 py-4 border-t border-slate-700 flex justify-between">
                <span class="font-bold text-slate-300">Total</span>
                <span class="font-bold text-xl text-emerald-400">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Info Pembeli --}}
        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6">
            <h3 class="font-semibold text-white mb-4">Info Pembeli</h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between"><dt class="text-slate-400">Nama</dt><dd class="text-white font-medium">{{ $pesanan->nama_pembeli }}</dd></div>
                <div class="flex justify-between"><dt class="text-slate-400">Email</dt><dd class="text-white font-medium">{{ $pesanan->email ?: '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-slate-400">Telepon</dt><dd class="text-white font-medium">{{ $pesanan->no_telepon ?: '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-slate-400">Kelas</dt><dd class="text-white font-medium">{{ $pesanan->alamat ?: '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-slate-400">Pembayaran</dt><dd class="text-white font-medium capitalize">{{ $pesanan->metode_pembayaran ?? '-' }}</dd></div>
                @if($pesanan->catatan)
                <div><dt class="text-slate-400 mb-1">Catatan</dt><dd class="text-white bg-slate-700 rounded-xl px-4 py-3 text-sm">{{ $pesanan->catatan }}</dd></div>
                @endif
            </dl>
        </div>
    </div>

    {{-- Sidebar Status --}}
    <div class="space-y-4">

        {{-- Status sekarang --}}
        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6">
            <h3 class="font-semibold text-white mb-4">Status Pesanan</h3>
            <span class="inline-block px-3 py-1.5 rounded-full text-sm font-bold badge-{{ $pesanan->status }}">
                {{ $pesanan->status_label }}
            </span>
            <p class="text-xs text-slate-400 mt-2">{{ $pesanan->created_at->format('d M Y, H:i') }}</p>
        </div>

        {{-- Bukti Pembayaran --}}
        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6">
            <h3 class="font-semibold text-white mb-3 flex items-center justify-between">
                <span>Bukti Pembayaran</span>
                <span class="text-xs px-2.5 py-1 rounded-lg font-bold uppercase {{ $pesanan->metode_pembayaran === 'qris' ? 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/30' : 'bg-slate-700 text-slate-300' }}">
                    {{ $pesanan->metode_pembayaran ?? 'Tunai' }}
                </span>
            </h3>

            @if($pesanan->bukti_pembayaran)
                <div class="space-y-3">
                    <div class="relative group cursor-pointer overflow-hidden rounded-xl border border-slate-600 bg-slate-900/50" onclick="openBuktiModal('{{ asset('storage/' . $pesanan->bukti_pembayaran) }}')">
                        <img src="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}" 
                             alt="Bukti Transfer" 
                             class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex items-center justify-center transition gap-2 text-white text-xs font-bold">
                            <i class="fas fa-search-plus"></i> Lihat Bukti Penuh
                        </div>
                    </div>
                    <button type="button" onclick="openBuktiModal('{{ asset('storage/' . $pesanan->bukti_pembayaran) }}')"
                        class="w-full mt-2 px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:opacity-90 text-white rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-md">
                        <i class="fas fa-search-plus"></i> Lihat Bukti Penuh
                    </button>
                </div>
            @elseif($pesanan->metode_pembayaran === 'qris')
                <div class="p-3 bg-amber-500/10 border border-amber-500/20 rounded-xl text-amber-400 text-xs flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle flex-shrink-0"></i>
                    <span>Pembeli belum mengunggah bukti pembayaran QRIS.</span>
                </div>
            @else
                <p class="text-xs text-slate-400">Pembayaran tunai dilakukan langsung di tempat saat pesanan diambil.</p>
            @endif
        </div>

        {{-- Update Status --}}
        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6">
            <h3 class="font-semibold text-white mb-4">Update Status</h3>
            <form action="{{ route('penjaga.pesanans.updateStatus', $pesanan) }}" method="POST" class="space-y-3">
                @csrf @method('PATCH')
                <select name="status"
                    class="w-full bg-slate-700 border border-slate-600 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">
                    @foreach(['pending'=>'Pending','diproses'=>'Diproses','dapat_diambil'=>'Dapat Diambil','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'] as $val => $label)
                        <option value="{{ $val }}" {{ $pesanan->status == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit"
                    class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 text-white py-3 rounded-xl font-bold text-sm hover:opacity-90 transition">
                    <i class="fas fa-save mr-2"></i>Simpan Status
                </button>
            </form>
        </div>

        <a href="{{ route('penjaga.pesanans.index') }}"
            class="flex items-center justify-center gap-2 w-full bg-slate-700 text-slate-300 py-3 rounded-xl font-bold text-sm hover:bg-slate-600 transition">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

{{-- Modal Bukti Pembayaran --}}
<div id="buktiModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4" onclick="closeBuktiModal()">
    <div class="relative max-w-2xl w-full bg-slate-800 rounded-2xl border border-slate-700 p-4 shadow-2xl" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between pb-3 border-b border-slate-700 mb-3">
            <h4 class="text-white font-bold text-sm flex items-center gap-2">
                <i class="fas fa-file-invoice text-emerald-400"></i> Bukti Pembayaran QRIS
            </h4>
            <button type="button" onclick="closeBuktiModal()" class="w-8 h-8 rounded-lg bg-slate-700 text-slate-300 hover:text-white flex items-center justify-center transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="max-h-[75vh] overflow-auto flex items-center justify-center bg-slate-900 rounded-xl p-2">
            <img id="buktiModalImg" src="" alt="Bukti Transfer" class="max-h-[70vh] w-auto rounded-lg object-contain">
        </div>
        <div class="mt-3 flex justify-end">
            <button type="button" onclick="closeBuktiModal()" class="px-5 py-2 bg-slate-700 hover:bg-slate-600 text-slate-200 text-xs font-bold rounded-xl transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
function openBuktiModal(src) {
    document.getElementById('buktiModalImg').src = src;
    const modal = document.getElementById('buktiModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeBuktiModal() {
    const modal = document.getElementById('buktiModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endsection
