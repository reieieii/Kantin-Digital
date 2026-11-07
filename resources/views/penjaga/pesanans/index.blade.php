@extends('penjaga.layouts.app')

@section('title', 'Pesanan Masuk')
@section('page-title', 'Pesanan Masuk')
@section('page-subtitle', $stand->nama_stand)

@section('content')
<div class="mt-6 space-y-4">

    {{-- Stats tabs --}}
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
        @foreach([
            ['label'=>'Semua',      'key'=>'semua',      'color'=>'text-white'],
            ['label'=>'Pending',    'key'=>'pending',    'color'=>'text-yellow-400'],
            ['label'=>'Diproses',   'key'=>'diproses',   'color'=>'text-blue-400'],
            ['label'=>'Selesai',    'key'=>'selesai',    'color'=>'text-emerald-400'],
            ['label'=>'Dibatalkan', 'key'=>'dibatalkan', 'color'=>'text-red-400'],
        ] as $s)
        <div class="bg-slate-800 rounded-xl p-4 border border-slate-700">
            <p class="text-xs text-slate-400 uppercase tracking-wider">{{ $s['label'] }}</p>
            <p class="text-2xl font-bold {{ $s['color'] }} mt-1">{{ $stats[$s['key']] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Total Pendapatan --}}
    <div class="bg-gradient-to-r from-emerald-700 to-teal-700 rounded-2xl border border-emerald-600 px-6 py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 shadow-lg">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-coins text-yellow-300 text-lg"></i>
            </div>
            <div>
                <p class="text-emerald-200 text-xs font-semibold uppercase tracking-wider">Total Pendapatan</p>
                <p class="text-white text-xs mt-0.5">Akumulasi dari <span class="font-bold">{{ $stats['selesai'] }}</span> pesanan selesai</p>
            </div>
        </div>
        <p class="text-3xl font-extrabold text-white tracking-tight">
            Rp {{ number_format($stand->total_pendapatan, 0, ',', '.') }}
        </p>
    </div>

    {{-- Filter --}}
    <form method="GET" class="bg-slate-800 rounded-2xl border border-slate-700 p-4">
        <div class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[180px]">
                <label class="text-xs text-slate-400 block mb-1">Cari Pesanan</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Nama atau kode..."
                    class="w-full bg-slate-700 border border-slate-600 rounded-xl px-3 py-2.5 text-white text-sm focus:outline-none focus:border-emerald-500">
            </div>
            <div class="min-w-[140px]">
                <label class="text-xs text-slate-400 block mb-1">Status</label>
                <select name="status"
                    class="w-full bg-slate-700 border border-slate-600 rounded-xl px-3 py-2.5 text-white text-sm focus:outline-none focus:border-emerald-500">
                    <option value="">Semua Status</option>
                    @foreach(['pending','diproses','selesai','dibatalkan'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="min-w-[150px]">
                <label class="text-xs text-slate-400 block mb-1">Kategori</label>
                <select name="kategori"
                    class="w-full bg-slate-700 border border-slate-600 rounded-xl px-3 py-2.5 text-white text-sm focus:outline-none focus:border-emerald-500">
                    <option value="">Semua Kategori</option>
                    <option value="Makanan"       {{ request('kategori') == 'Makanan'       ? 'selected' : '' }}>Makanan</option>
                    <option value="Minuman"       {{ request('kategori') == 'Minuman'       ? 'selected' : '' }}>Minuman</option>
                    <option value="Snack/Cemilan" {{ request('kategori') == 'Snack/Cemilan' ? 'selected' : '' }}>Snack / Cemilan</option>
                </select>
            </div>
            <div class="min-w-[130px]">
                <label class="text-xs text-slate-400 block mb-1">Metode Bayar</label>
                <select name="metode"
                    class="w-full bg-slate-700 border border-slate-600 rounded-xl px-3 py-2.5 text-white text-sm focus:outline-none focus:border-emerald-500">
                    <option value="">Semua</option>
                    <option value="tunai" {{ request('metode') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                    <option value="qris"  {{ request('metode') == 'qris'  ? 'selected' : '' }}>QRIS</option>
                </select>
            </div>
            <button type="submit"
                class="bg-emerald-600 hover:bg-emerald-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition flex items-center gap-2">
                <i class="fas fa-search"></i> Cari
            </button>
            @if(request()->hasAny(['search','status','kategori','metode']))
                <a href="{{ route('penjaga.pesanans.index') }}"
                    class="text-slate-400 hover:text-white text-sm transition px-2 py-2.5">
                    <i class="fas fa-times mr-1"></i>Reset
                </a>
            @endif
        </div>
    </form>

    {{-- Tabel --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-700 text-xs text-slate-400 uppercase tracking-wider">
                        <th class="px-4 py-4 text-left">Kode / Pembeli</th>
                        <th class="px-4 py-4 text-left hidden md:table-cell">Waktu</th>
                        <th class="px-4 py-4 text-left hidden lg:table-cell">Items</th>
                        <th class="px-4 py-4 text-left">Total</th>
                        <th class="px-4 py-4 text-left hidden sm:table-cell">Metode</th>
                        <th class="px-4 py-4 text-left">Status</th>
                        <th class="px-4 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @forelse($pesanans as $p)
                    <tr class="hover:bg-slate-700/30 transition">
                        <td class="px-4 py-4">
                            <p class="font-semibold text-white">{{ $p->nama_pembeli }}</p>
                            <p class="text-xs text-slate-400 font-mono">{{ $p->kode_pembelian }}</p>
                        </td>
                        <td class="px-4 py-4 hidden md:table-cell text-xs text-slate-400">
                            {{ $p->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-4 hidden lg:table-cell text-slate-300 text-xs">
                            {{ $p->detailPembelians->count() }} item
                        </td>
                        <td class="px-4 py-4 font-bold text-emerald-400 whitespace-nowrap">
                            Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-4 hidden sm:table-cell">
                            <span class="bg-slate-700 text-slate-300 text-xs px-2.5 py-1 rounded-full font-medium uppercase">
                                {{ $p->metode_pembayaran }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold badge-{{ $p->status }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-right">
                            <a href="{{ route('penjaga.pesanans.show', $p) }}"
                                class="p-2 text-slate-400 hover:text-emerald-400 hover:bg-emerald-500/10 rounded-lg transition inline-block" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                            <i class="fas fa-receipt text-3xl mb-3 block"></i>
                            Belum ada pesanan masuk
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($pesanans->hasPages())
        <div class="text-slate-400">{{ $pesanans->links() }}</div>
    @endif
</div>
@endsection
