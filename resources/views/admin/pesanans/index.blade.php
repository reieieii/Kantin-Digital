@extends('admin.layouts.app')

@section('title', 'Kelola Pesanan')
@section('page-title', 'Kelola Pesanan')
@section('page-subtitle', 'Pantau dan perbarui status semua pesanan')

@section('content')

{{-- Status Tabs --}}
<div class="flex flex-wrap gap-2 mb-5 mt-2">
    @php
        $tabs = [
            'semua'      => ['label' => 'Semua',      'color' => 'bg-slate-600'],
            'pending'    => ['label' => 'Pending',    'color' => 'bg-amber-500'],
            'diproses'   => ['label' => 'Diproses',   'color' => 'bg-blue-500'],
            'selesai'    => ['label' => 'Selesai',    'color' => 'bg-emerald-500'],
            'dibatalkan' => ['label' => 'Dibatalkan', 'color' => 'bg-red-500'],
        ];
    @endphp
    @foreach($tabs as $key => $tab)
    <a href="{{ route('admin.pesanans.index', array_merge(request()->query(), ['status' => $key === 'semua' ? '' : $key])) }}"
        class="flex items-center space-x-2 px-4 py-2 rounded-xl text-sm font-medium transition
            {{ (request('status', '') === ($key === 'semua' ? '' : $key))
                ? $tab['color'] . ' text-white shadow-lg'
                : 'bg-slate-800 border border-slate-700 text-slate-400 hover:text-white' }}">
        <span>{{ $tab['label'] }}</span>
        <span class="bg-white/20 text-white text-xs px-1.5 rounded-full">{{ $stats[$key === 'semua' ? 'semua' : $key] }}</span>
    </a>
    @endforeach
</div>

{{-- Search & Filter --}}
<form method="GET" class="bg-slate-800 rounded-2xl border border-slate-700 p-4 mb-5">
    <input type="hidden" name="status" value="{{ request('status') }}">
    <div class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="text-xs text-slate-400 block mb-1">Cari Pesanan</label>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Kode, nama, atau email..."
                class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-orange-500">
        </div>
        <div class="min-w-[140px]">
            <label class="text-xs text-slate-400 block mb-1">Metode Bayar</label>
            <select name="metode" class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-orange-500">
                <option value="">Semua</option>
                <option value="tunai" {{ request('metode') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                <option value="qris" {{ request('metode') == 'qris' ? 'selected' : '' }}>QRIS</option>
            </select>
        </div>
        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition">
            <i class="fas fa-search mr-1"></i>Cari
        </button>
        @if(request()->hasAny(['search','metode']))
            <a href="{{ route('admin.pesanans.index', ['status' => request('status')]) }}" class="text-slate-400 hover:text-white text-sm px-2">Reset</a>
        @endif
    </div>
</form>

<div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-700/50 text-slate-400 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Kode</th>
                    <th class="px-4 py-3 text-left">Pembeli</th>
                    <th class="px-4 py-3 text-center">Items</th>
                    <th class="px-4 py-3 text-right">Total</th>
                    <th class="px-4 py-3 text-center">Metode</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-left">Waktu</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                @forelse($pesanans as $p)
                @php
                    $badgeClass = match($p->status) {
                        'pending'    => 'bg-amber-100 text-amber-800',
                        'diproses'   => 'bg-blue-100 text-blue-800',
                        'selesai'    => 'bg-emerald-100 text-emerald-800',
                        'dibatalkan' => 'bg-red-100 text-red-800',
                        default      => 'bg-slate-100 text-slate-800',
                    };
                @endphp
                <tr class="hover:bg-slate-700/30 transition">
                    <td class="px-4 py-3 font-mono text-xs text-orange-400">{{ $p->kode_pembelian }}</td>
                    <td class="px-4 py-3">
                        <p class="font-medium text-white">{{ $p->nama_pembeli }}</p>
                        <p class="text-xs text-slate-400">{{ $p->email ?: '-' }}</p>
                    </td>
                    <td class="px-4 py-3 text-center text-slate-300">{{ $p->detailPembelians->count() }} item</td>
                    <td class="px-4 py-3 text-right font-semibold text-white">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="bg-slate-700 text-slate-300 text-xs px-2 py-0.5 rounded-full capitalize">{{ $p->metode_pembayaran }}</span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $badgeClass }}">{{ ucfirst($p->status) }}</span>
                    </td>
                    <td class="px-4 py-3 text-xs text-slate-400">{{ $p->created_at->format('d M, H:i') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center space-x-1.5">
                            <a href="{{ route('admin.pesanans.show', $p) }}"
                                class="bg-slate-700 hover:bg-slate-600 text-white text-xs px-2.5 py-1.5 rounded-lg transition">
                                <i class="fas fa-eye"></i>
                            </a>
                            {{-- Quick status update --}}
                            <form method="POST" action="{{ route('admin.pesanans.updateStatus', $p) }}">
                                @csrf @method('PATCH')
                                @php
                                    $nextStatus = match($p->status) {
                                        'pending'  => 'diproses',
                                        'diproses' => 'selesai',
                                        default    => null,
                                    };
                                    $nextLabel = match($p->status) {
                                        'pending'  => 'Proses',
                                        'diproses' => 'Selesai',
                                        default    => null,
                                    };
                                @endphp
                                @if($nextStatus)
                                <input type="hidden" name="status" value="{{ $nextStatus }}">
                                <button type="submit"
                                    class="bg-emerald-500/20 hover:bg-emerald-500/40 text-emerald-400 text-xs px-2.5 py-1.5 rounded-lg transition whitespace-nowrap">
                                    {{ $nextLabel }}
                                </button>
                                @endif
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-12 text-center text-slate-500">
                        <i class="fas fa-inbox text-3xl mb-3 block"></i>
                        <p>Belum ada pesanan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $pesanans->links() }}</div>

@endsection
