@extends('penjaga.layouts.app')

@section('title', 'Pesanan Masuk')
@section('page-title', 'Pesanan Masuk')
@section('page-subtitle', $stand->nama_stand)

@section('content')
<div class="mt-6 space-y-4">

    {{-- Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
        @foreach([['label'=>'Semua','key'=>'semua','color'=>'text-white'],['label'=>'Pending','key'=>'pending','color'=>'text-yellow-400'],['label'=>'Diproses','key'=>'diproses','color'=>'text-blue-400'],['label'=>'Selesai','key'=>'selesai','color'=>'text-emerald-400'],['label'=>'Dibatalkan','key'=>'dibatalkan','color'=>'text-red-400']] as $s)
        <div class="bg-slate-800 rounded-xl p-4 border border-slate-700">
            <p class="text-xs text-slate-400 uppercase tracking-wider">{{ $s['label'] }}</p>
            <p class="text-2xl font-bold {{ $s['color'] }} mt-1">{{ $stats[$s['key']] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Filter --}}
    <form method="GET" class="flex gap-3 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama / kode..."
            class="bg-slate-700 border border-slate-600 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-emerald-500 w-64">
        <select name="status"
            class="bg-slate-700 border border-slate-600 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-emerald-500">
            <option value="">Semua Status</option>
            @foreach(['pending','diproses','selesai','dibatalkan'] as $s)
                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-slate-700 border border-slate-600 px-4 py-2.5 rounded-xl text-sm text-slate-300 hover:text-white transition">
            <i class="fas fa-search"></i>
        </button>
    </form>

    {{-- Tabel --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-slate-700 text-xs text-slate-400 uppercase tracking-wider">
                    <th class="px-6 py-4 text-left">Kode / Pembeli</th>
                    <th class="px-6 py-4 text-left hidden md:table-cell">Waktu</th>
                    <th class="px-6 py-4 text-left">Total</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                @forelse($pesanans as $p)
                <tr class="hover:bg-slate-700/30 transition">
                    <td class="px-6 py-4">
                        <p class="text-sm font-semibold text-white">{{ $p->nama_pembeli }}</p>
                        <p class="text-xs text-slate-400 font-mono">{{ $p->kode_pembelian }}</p>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell text-xs text-slate-400">
                        {{ $p->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-emerald-400">
                        Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold badge-{{ $p->status }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('penjaga.pesanans.show', $p) }}"
                            class="p-2 text-slate-400 hover:text-emerald-400 hover:bg-emerald-500/10 rounded-lg transition inline-block" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                        <i class="fas fa-receipt text-3xl mb-3 block"></i>
                        Belum ada pesanan masuk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pesanans->hasPages())
        <div class="text-slate-400">{{ $pesanans->links() }}</div>
    @endif
</div>
@endsection
