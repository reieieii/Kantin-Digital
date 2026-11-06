@extends('penjaga.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . Auth::user()->name)

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

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-6 gap-4">
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700">
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Total Produk</p>
            <p class="text-3xl font-bold text-white mt-2">{{ $totalProduk }}</p>
            <p class="text-slate-500 text-xs mt-1">semua produk</p>
        </div>
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700">
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Tersedia</p>
            <p class="text-3xl font-bold text-emerald-400 mt-2">{{ $produkTersedia }}</p>
            <p class="text-slate-500 text-xs mt-1">siap dijual</p>
        </div>
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700">
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Stok Habis</p>
            <p class="text-3xl font-bold text-red-400 mt-2">{{ $stokHabis }}</p>
            <p class="text-slate-500 text-xs mt-1">perlu diisi</p>
        </div>
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700">
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Total Pesanan</p>
            <p class="text-3xl font-bold text-blue-400 mt-2">{{ $totalPesanan }}</p>
            <p class="text-slate-500 text-xs mt-1">semua waktu</p>
        </div>
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700">
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Perlu Diproses</p>
            <p class="text-3xl font-bold text-orange-400 mt-2">{{ $pesananPending }}</p>
            <p class="text-slate-500 text-xs mt-1">pending</p>
        </div>
        {{-- Widget Total Pendapatan --}}
        <div class="col-span-2 lg:col-span-1 bg-gradient-to-br from-emerald-700 to-teal-700 rounded-xl p-5 border border-emerald-600 shadow-lg">
            <p class="text-emerald-200 text-xs font-semibold uppercase tracking-wider flex items-center gap-1">
                <i class="fas fa-coins text-yellow-300"></i> Total Pendapatan
            </p>
            <p class="text-2xl font-extrabold text-white mt-2 leading-tight">
                Rp {{ number_format($stand->total_pendapatan, 0, ',', '.') }}
            </p>
            <p class="text-emerald-300 text-xs mt-1">{{ $pesananSelesai }} pesanan selesai</p>
        </div>
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
                        <span class="px-2 py-1 rounded-full text-xs font-bold badge-{{ $p->status }}">
                            {{ ucfirst($p->status) }}
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
