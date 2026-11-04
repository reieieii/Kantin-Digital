@extends('admin.layouts.app')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')
@section('page-subtitle', '#{{ $pesanan->kode_pembelian }}')

@section('content')

<div class="max-w-3xl mx-auto mt-2 space-y-5">

    {{-- Header Card --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700 p-5">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="text-xs text-slate-400 mb-1">Kode Pembelian</p>
                <p class="font-mono text-xl font-bold text-orange-400">{{ $pesanan->kode_pembelian }}</p>
                <p class="text-xs text-slate-400 mt-1">{{ $pesanan->created_at->format('l, d F Y — H:i') }}</p>
            </div>
            @php
                $badgeClass = match($pesanan->status) {
                    'pending'    => 'bg-amber-100 text-amber-800',
                    'diproses'   => 'bg-blue-100 text-blue-800',
                    'selesai'    => 'bg-emerald-100 text-emerald-800',
                    'dibatalkan' => 'bg-red-100 text-red-800',
                    default      => 'bg-slate-100 text-slate-800',
                };
            @endphp
            <span class="text-sm px-4 py-1.5 rounded-full font-semibold {{ $badgeClass }}">{{ ucfirst($pesanan->status) }}</span>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 gap-5">
        {{-- Info Pembeli --}}
        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-5">
            <h3 class="font-semibold text-white mb-4 flex items-center space-x-2">
                <i class="fas fa-user text-slate-400"></i><span>Info Pembeli</span>
            </h3>
            <div class="space-y-3 text-sm">
                <div><p class="text-xs text-slate-500">Nama</p><p class="text-white font-medium">{{ $pesanan->nama_pembeli }}</p></div>
                <div><p class="text-xs text-slate-500">Email</p><p class="text-slate-300">{{ $pesanan->email ?: '-' }}</p></div>
                <div><p class="text-xs text-slate-500">Telepon</p><p class="text-slate-300">{{ $pesanan->no_telepon ?: '-' }}</p></div>
                <div><p class="text-xs text-slate-500">Alamat</p><p class="text-slate-300">{{ $pesanan->alamat ?: '-' }}</p></div>
                @if($pesanan->catatan)
                <div><p class="text-xs text-slate-500">Catatan</p><p class="text-slate-300 italic">{{ $pesanan->catatan }}</p></div>
                @endif
            </div>
        </div>

        {{-- Info Pembayaran --}}
        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-5">
            <h3 class="font-semibold text-white mb-4 flex items-center space-x-2">
                <i class="fas fa-wallet text-slate-400"></i><span>Info Pembayaran</span>
            </h3>
            <div class="space-y-3 text-sm">
                <div><p class="text-xs text-slate-500">Metode</p>
                    <p class="text-white font-medium capitalize">{{ $pesanan->metode_pembayaran }}</p></div>
                <div><p class="text-xs text-slate-500">Total Harga</p>
                    <p class="text-2xl font-bold text-white">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p></div>
            </div>

            {{-- Update Status --}}
            <div class="mt-5 pt-4 border-t border-slate-700">
                <p class="text-xs text-slate-400 mb-2">Ubah Status Pesanan</p>
                <form method="POST" action="{{ route('admin.pesanans.updateStatus', $pesanan) }}" class="flex items-center space-x-2">
                    @csrf @method('PATCH')
                    <select name="status"
                        class="flex-1 bg-slate-700 border border-slate-600 text-white rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-orange-500">
                        <option value="pending"    {{ $pesanan->status == 'pending'    ? 'selected' : '' }}>Pending</option>
                        <option value="diproses"   {{ $pesanan->status == 'diproses'   ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai"    {{ $pesanan->status == 'selesai'    ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ $pesanan->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition whitespace-nowrap">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Detail Items --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-700">
            <h3 class="font-semibold text-white">Item Pesanan ({{ $pesanan->detailPembelians->count() }} item)</h3>
        </div>
        <div class="divide-y divide-slate-700">
            @foreach($pesanan->detailPembelians as $item)
            <div class="flex items-center justify-between px-5 py-4">
                <div class="flex items-center space-x-3">
                    @if($item->produk && $item->produk->gambar)
                    <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-700 flex-shrink-0">
                        <img src="{{ str_starts_with($item->produk->gambar, 'http') ? $item->produk->gambar : asset('storage/'.$item->produk->gambar) }}"
                             class="w-full h-full object-cover"
                             onerror="this.src='https://via.placeholder.com/48x48/334155/94a3b8?text=P'">
                    </div>
                    @else
                    <div class="w-12 h-12 rounded-xl bg-slate-700 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-utensils text-slate-500"></i>
                    </div>
                    @endif
                    <div>
                        <p class="font-medium text-white text-sm">{{ $item->nama_produk }}</p>
                        <p class="text-xs text-slate-400">Rp {{ number_format($item->harga, 0, ',', '.') }} × {{ $item->quantity }}</p>
                    </div>
                </div>
                <p class="font-semibold text-white">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>
        <div class="flex justify-between px-5 py-4 bg-slate-700/30 border-t border-slate-700">
            <span class="font-semibold text-slate-300">Total</span>
            <span class="font-bold text-xl text-white">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.pesanans.index') }}"
            class="text-slate-400 hover:text-white text-sm transition">← Kembali ke Daftar Pesanan</a>
        <form method="POST" action="{{ route('admin.pesanans.destroy', $pesanan) }}"
            onsubmit="return confirm('Hapus pesanan ini secara permanen?')">
            @csrf @method('DELETE')
            <button type="submit" class="text-red-400 hover:text-red-300 text-sm transition">
                <i class="fas fa-trash mr-1"></i>Hapus Pesanan
            </button>
        </form>
    </div>

</div>

@endsection
