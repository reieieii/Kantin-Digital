@extends('penjaga.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . (Auth::user()->stand->nama_stand ?? Auth::user()->name))

@section('content')
<div class="mt-6 space-y-6">

    {{-- Banner Stand --}}
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl p-6 flex items-center justify-between">
        <div>
            <p class="text-emerald-100 text-sm font-medium mb-1">Stand Kamu</p>
            <h2 class="text-2xl font-bold text-white">{{ $stand->nama_stand }}</h2>
            <p class="text-emerald-100 text-sm mt-1">{{ $stand->deskripsi }}</p>
        </div>
        <div class="hidden sm:flex items-center space-x-3">
            <span class="px-3 py-1.5 rounded-full text-sm font-bold {{ $stand->status_buka ? 'bg-white/20 text-white' : 'bg-red-500/30 text-red-200' }}">
                <i class="fas fa-circle text-xs mr-1 {{ $stand->status_buka ? 'text-green-300' : 'text-red-300' }}"></i>
                {{ $stand->status_buka ? 'Buka' : 'Tutup' }}
            </span>
        </div>
    </div>

    {{-- ── BARIS 1: RINGKASAN PRODUK & PENDAPATAN ───────────────────────────── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total Produk --}}
        <div class="bg-slate-800 rounded-2xl p-5 border border-slate-700">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 bg-purple-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-utensils text-purple-400 text-lg"></i>
                </div>
                <span class="text-xs text-slate-500">Produk</span>
            </div>
            <p class="text-3xl font-bold text-white">{{ $totalProduk }}</p>
            <p class="text-xs text-slate-400 mt-1">Total Produk</p>
        </div>

        {{-- Tersedia --}}
        <div class="bg-slate-800 rounded-2xl p-5 border border-slate-700">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 bg-emerald-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-emerald-400 text-lg"></i>
                </div>
                <span class="text-xs text-emerald-400 font-medium">Tersedia</span>
            </div>
            <p class="text-3xl font-bold text-emerald-400">{{ $produkTersedia }}</p>
            <p class="text-xs text-slate-400 mt-1">Siap Dijual</p>
        </div>

        {{-- Stok Habis --}}
        <div class="bg-slate-800 rounded-2xl p-5 border border-slate-700">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 bg-red-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-triangle-exclamation text-red-400 text-lg"></i>
                </div>
                <span class="text-xs text-red-400 font-medium">Stok Habis</span>
            </div>
            <p class="text-3xl font-bold text-red-400">{{ $stokHabis }}</p>
            <p class="text-xs text-slate-400 mt-1">Perlu Diisi</p>
        </div>

        {{-- Total Pendapatan --}}
        <div class="bg-slate-800 rounded-2xl p-5 border border-slate-700">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 bg-emerald-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-coins text-emerald-400 text-lg"></i>
                </div>
                <span class="text-xs text-slate-500">Pendapatan</span>
            </div>
            <p class="text-xl sm:text-2xl font-bold text-white">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            <p class="text-xs text-slate-400 mt-1">Dari {{ $pesananSelesai }} pesanan selesai</p>
        </div>
    </div>

    {{-- ── BARIS 2: STATUS PESANAN ─────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total Pesanan --}}
        <a href="{{ route('penjaga.pesanans.index') }}"
            class="bg-slate-800 border border-slate-700 rounded-2xl p-4 hover:border-slate-500 transition block">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-receipt text-blue-400 text-lg"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-white">{{ $totalPesanan }}</p>
                    <p class="text-xs text-slate-300">Total Pesanan</p>
                </div>
            </div>
        </a>

        {{-- Pending --}}
        <a href="{{ route('penjaga.pesanans.index', ['status' => 'pending']) }}"
            class="bg-amber-500/10 border border-amber-500/30 rounded-2xl p-4 hover:bg-amber-500/20 transition block">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-clock text-amber-400 text-lg"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-white">{{ $pesananPending }}</p>
                    <p class="text-xs text-amber-300">Pending</p>
                </div>
            </div>
        </a>

        {{-- Diproses --}}
        <a href="{{ route('penjaga.pesanans.index', ['status' => 'diproses']) }}"
            class="bg-blue-500/10 border border-blue-500/30 rounded-2xl p-4 hover:bg-blue-500/20 transition block">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-spinner text-blue-400 text-lg"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-white">{{ $pesananProses }}</p>
                    <p class="text-xs text-blue-300">Diproses</p>
                </div>
            </div>
        </a>

        {{-- Dapat Diambil --}}
        <a href="{{ route('penjaga.pesanans.index', ['status' => 'dapat_diambil']) }}"
            class="bg-indigo-500/10 border border-indigo-500/30 rounded-2xl p-4 hover:bg-indigo-500/20 transition block">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-bag-shopping text-indigo-400 text-lg"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-white">{{ $pesananDapatDiambil }}</p>
                    <p class="text-xs text-indigo-300">Dapat Diambil</p>
                </div>
            </div>
        </a>
    </div>

    {{-- Pesanan Terbaru --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-700">
            <h3 class="font-semibold text-white">Pesanan Terbaru</h3>
            <a href="{{ route('penjaga.pesanans.index') }}" class="text-emerald-400 hover:text-emerald-300 text-sm font-medium">
                Lihat Semua →
            </a>
        </div>
        <div class="divide-y divide-slate-700">
            @forelse($pesananTerbaru as $p)
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-white">{{ $p->nama_pembeli }}</p>
                        <p class="text-xs text-slate-400">{{ $p->kode_pembelian }} · {{ $p->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-white">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span>
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold badge-{{ $p->status }}">
                            {{ $p->status_label }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-slate-500 text-sm">Belum ada pesanan masuk</div>
            @endforelse
        </div>
    </div>

</div>
@endsection
