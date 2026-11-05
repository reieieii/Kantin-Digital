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
                {{ ucfirst($pesanan->status) }}
            </span>
            <p class="text-xs text-slate-400 mt-2">{{ $pesanan->created_at->format('d M Y, H:i') }}</p>
        </div>

        {{-- Update Status --}}
        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6">
            <h3 class="font-semibold text-white mb-4">Update Status</h3>
            <form action="{{ route('penjaga.pesanans.updateStatus', $pesanan) }}" method="POST" class="space-y-3">
                @csrf @method('PATCH')
                <select name="status"
                    class="w-full bg-slate-700 border border-slate-600 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">
                    @foreach(['pending'=>'Pending','diproses'=>'Diproses','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'] as $val => $label)
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
@endsection
