@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data Kantin Digital SMKN 20 Jakarta')

@section('content')

{{-- ── STAT CARDS ──────────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-2 mb-6">

    <div class="bg-slate-800 rounded-2xl p-5 border border-slate-700">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-blue-500/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-store text-blue-400 text-lg"></i>
            </div>
            <span class="text-xs text-slate-500">Stand</span>
        </div>
        <p class="text-3xl font-bold text-white">{{ $stats['total_stand'] }}</p>
        <p class="text-xs text-slate-400 mt-1">Stand Terdaftar</p>
    </div>

    <div class="bg-slate-800 rounded-2xl p-5 border border-slate-700">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-purple-500/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-utensils text-purple-400 text-lg"></i>
            </div>
            <span class="text-xs text-slate-500">Produk</span>
        </div>
        <p class="text-3xl font-bold text-white">{{ $stats['total_produk'] }}</p>
        <p class="text-xs text-slate-400 mt-1">Total Produk</p>
    </div>

    <div class="bg-slate-800 rounded-2xl p-5 border border-slate-700">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-orange-500/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-receipt text-orange-400 text-lg"></i>
            </div>
            <span class="text-xs text-slate-500">Pesanan</span>
        </div>
        <p class="text-3xl font-bold text-white">{{ $stats['total_pesanan'] }}</p>
        <p class="text-xs text-slate-400 mt-1">Total Pesanan</p>
    </div>

    <div class="bg-slate-800 rounded-2xl p-5 border border-slate-700">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-emerald-500/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-coins text-emerald-400 text-lg"></i>
            </div>
            <span class="text-xs text-slate-500">Pendapatan</span>
        </div>
        <p class="text-xl font-bold text-white">Rp {{ number_format($stats['pendapatan_total'], 0, ',', '.') }}</p>
        <p class="text-xs text-slate-400 mt-1">Dari pesanan selesai</p>
    </div>
</div>

{{-- ── STATUS PESANAN ───────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <a href="{{ route('admin.pesanans.index', ['status' => 'pending']) }}"
        class="bg-amber-500/10 border border-amber-500/30 rounded-2xl p-4 hover:bg-amber-500/20 transition">
        <div class="flex items-center space-x-3">
            <i class="fas fa-clock text-amber-400 text-xl"></i>
            <div>
                <p class="text-2xl font-bold text-white">{{ $stats['pesanan_pending'] }}</p>
                <p class="text-xs text-amber-300">Pending</p>
            </div>
        </div>
    </a>
    <a href="{{ route('admin.pesanans.index', ['status' => 'diproses']) }}"
        class="bg-blue-500/10 border border-blue-500/30 rounded-2xl p-4 hover:bg-blue-500/20 transition">
        <div class="flex items-center space-x-3">
            <i class="fas fa-spinner text-blue-400 text-xl"></i>
            <div>
                <p class="text-2xl font-bold text-white">{{ $stats['pesanan_diproses'] }}</p>
                <p class="text-xs text-blue-300">Diproses</p>
            </div>
        </div>
    </a>
    <a href="{{ route('admin.pesanans.index', ['status' => 'selesai']) }}"
        class="bg-emerald-500/10 border border-emerald-500/30 rounded-2xl p-4 hover:bg-emerald-500/20 transition">
        <div class="flex items-center space-x-3">
            <i class="fas fa-check-circle text-emerald-400 text-xl"></i>
            <div>
                <p class="text-2xl font-bold text-white">{{ $stats['pesanan_selesai'] }}</p>
                <p class="text-xs text-emerald-300">Selesai</p>
            </div>
        </div>
    </a>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    {{-- ── PESANAN TERBARU ──────────────────────────────────────────────────── --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-700">
            <h3 class="font-semibold text-white">Pesanan</h3>
            <a href="{{ route('admin.pesanans.index') }}"
                class="text-xs text-orange-400 hover:text-orange-300 transition">Lihat semua →</a>
        </div>
        <div class="divide-y divide-slate-700">
            @forelse($pesanan_terbaru as $p)
            <div class="flex items-center justify-between px-5 py-3">
                <div>
                    <p class="text-sm font-medium text-white">{{ $p->nama_pembeli }}</p>
                    <p class="text-xs text-slate-400">{{ $p->kode_pembelian }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-white">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</p>
                    @php
                        $badgeClass = match($p->status) {
                            'pending'    => 'bg-amber-100 text-amber-800',
                            'diproses'   => 'bg-blue-100 text-blue-800',
                            'selesai'    => 'bg-emerald-100 text-emerald-800',
                            'dibatalkan' => 'bg-red-100 text-red-800',
                            default      => 'bg-slate-100 text-slate-800',
                        };
                    @endphp
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $badgeClass }}">
                        {{ ucfirst($p->status) }}
                    </span>
                </div>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-slate-500 text-sm">
                <i class="fas fa-inbox text-2xl mb-2 block"></i>
                Belum ada pesanan
            </div>
            @endforelse
        </div>
    </div>

    {{-- ── STAND AKTIF ─────────────────────────────────────────────────────── --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-700">
            <h3 class="font-semibold text-white">Stand</h3>
            <a href="{{ route('admin.stands.index') }}"
                class="text-xs text-orange-400 hover:text-orange-300 transition">Kelola →</a>
        </div>
        <div class="divide-y divide-slate-700">
            @forelse($stand_aktif as $s)
            <div class="flex items-center justify-between px-5 py-3">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-slate-700 rounded-lg overflow-hidden flex-shrink-0">
                        <img src="{{ str_starts_with($s->gambar, 'http') ? $s->gambar : asset('storage/'.$s->gambar) }}"
                             alt="{{ $s->nama_stand }}"
                             class="w-full h-full object-cover"
                             onerror="this.src='https://via.placeholder.com/40x40/334155/94a3b8?text=S'">
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">{{ $s->nama_stand }}</p>
                        <p class="text-xs text-slate-400">{{ $s->pemilik }}</p>
                    </div>
                </div>
                <span class="text-xs text-slate-400">{{ $s->produks_count }} produk</span>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-slate-500 text-sm">
                <i class="fas fa-store-slash text-2xl mb-2 block"></i>
                Belum ada stand
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- ── QUICK ACTIONS ────────────────────────────────────────────────────────── --}}
<div class="mt-6 bg-slate-800 rounded-2xl border border-slate-700 p-5">
    <h3 class="font-semibold text-white mb-4">Aksi Cepat</h3>
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('admin.stands.create') }}"
            class="flex items-center space-x-2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition">
            <i class="fas fa-plus"></i><span>Tambah Stand</span>
        </a>
        <a href="{{ route('admin.produks.create') }}"
            class="flex items-center space-x-2 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition">
            <i class="fas fa-plus"></i><span>Tambah Produk</span>
        </a>
        <a href="{{ route('admin.pesanans.index', ['status' => 'pending']) }}"
            class="flex items-center space-x-2 bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition">
            <i class="fas fa-clock"></i><span>Pesanan Pending ({{ $stats['pesanan_pending'] }})</span>
        </a>
    </div>
</div>

@endsection
