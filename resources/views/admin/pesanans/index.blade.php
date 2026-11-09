@extends('admin.layouts.app')

@section('title', 'Kelola Pesanan')
@section('page-title', 'Kelola Pesanan')
@section('page-subtitle', 'Pantau dan perbarui status semua pesanan')

@push('styles')
<style>
    body {
        overflow-x: hidden;
    }
</style>
@endpush

@section('content')

{{-- Status Tabs --}}
<div class="flex flex-wrap gap-2 mb-5 mt-2">
    @php
        $tabs = [
            'semua'        => ['label' => 'Semua',        'color' => 'bg-slate-600'],
            'pending'      => ['label' => 'Pending',      'color' => 'bg-amber-500'],
            'diproses'     => ['label' => 'Diproses',     'color' => 'bg-blue-500'],
            'dapat_diambil'=> ['label' => 'Dapat Diambil','color' => 'bg-indigo-500'],
            'selesai'      => ['label' => 'Selesai',      'color' => 'bg-emerald-500'],
            'dibatalkan'   => ['label' => 'Dibatalkan',   'color' => 'bg-red-500'],
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
    <div class="flex flex-wrap gap-2.5 items-end">
        <div class="flex-1 min-w-[150px]">
            <label class="text-xs text-slate-400 block mb-1">Cari Pesanan</label>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Kode, nama, atau email..."
                class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-orange-500">
        </div>
        <div class="w-full sm:w-auto flex-1 sm:flex-initial sm:min-w-[130px]">
            <label class="text-xs text-slate-400 block mb-1">Stand</label>
            <select name="stand_id" class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-orange-500">
                <option value="">Semua Stand</option>
                @foreach($stands as $s)
                    <option value="{{ $s->id }}" {{ request('stand_id') == $s->id ? 'selected' : '' }}>{{ $s->nama_stand }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-full sm:w-auto flex-1 sm:flex-initial sm:min-w-[130px]">
            <label class="text-xs text-slate-400 block mb-1">Kategori</label>
            <select name="kategori" class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-orange-500">
                <option value="">Semua Kategori</option>
                <option value="Makanan"      {{ request('kategori') == 'Makanan'      ? 'selected' : '' }}>Makanan</option>
                <option value="Minuman"      {{ request('kategori') == 'Minuman'      ? 'selected' : '' }}>Minuman</option>
                <option value="Snack/Cemilan"{{ request('kategori') == 'Snack/Cemilan'? 'selected' : '' }}>Snack / Cemilan</option>
            </select>
        </div>
        <div class="w-full sm:w-auto flex-1 sm:flex-initial sm:min-w-[120px]">
            <label class="text-xs text-slate-400 block mb-1">Metode Bayar</label>
            <select name="metode" class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-orange-500">
                <option value="">Semua</option>
                <option value="tunai" {{ request('metode') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                <option value="qris"  {{ request('metode') == 'qris'  ? 'selected' : '' }}>QRIS</option>
            </select>
        </div>
        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition flex items-center justify-center gap-1">
            <i class="fas fa-search"></i> Cari
        </button>
        @if(request()->hasAny(['search','metode','stand_id','kategori']))
            <a href="{{ route('admin.pesanans.index', ['status' => request('status')]) }}" class="text-slate-400 hover:text-white text-sm px-2">Reset</a>
        @endif
    </div>
</form>

<div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden w-full max-w-full">
    <div class="overflow-x-auto w-full">
        <table class="w-full text-sm">
            <thead class="bg-slate-700/50 text-slate-400 uppercase text-xs">
                <tr>
                    <th class="px-3 py-3 text-left whitespace-nowrap">Kode</th>
                    <th class="px-3 py-3 text-left">Pembeli</th>
                    <th class="px-3 py-3 text-center whitespace-nowrap">Items</th>
                    <th class="px-3 py-3 text-right whitespace-nowrap">Total</th>
                    <th class="px-3 py-3 text-center whitespace-nowrap">Metode</th>
                    <th class="px-3 py-3 text-center whitespace-nowrap">Status</th>
                    <th class="px-3 py-3 text-left whitespace-nowrap">Waktu</th>
                    <th class="px-3 py-3 text-center whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                @forelse($pesanans as $p)
                @php
                    $badgeClass = match($p->status) {
                        'pending'       => 'bg-amber-100 text-amber-800',
                        'diproses'      => 'bg-blue-100 text-blue-800',
                        'dapat_diambil' => 'bg-indigo-100 text-indigo-800',
                        'selesai'       => 'bg-emerald-100 text-emerald-800',
                        'dibatalkan'    => 'bg-red-100 text-red-800',
                        default         => 'bg-slate-100 text-slate-800',
                    };
                @endphp
                <tr class="hover:bg-slate-700/30 transition">
                    <td class="px-3 py-3 font-mono text-xs text-orange-400 whitespace-nowrap">{{ $p->kode_pembelian }}</td>
                    <td class="px-3 py-3 max-w-[180px]">
                        <p class="font-medium text-white truncate">{{ $p->nama_pembeli }}</p>
                        <p class="text-xs text-slate-400 truncate" title="{{ $p->email }}">{{ $p->email ?: '-' }}</p>
                    </td>
                    <td class="px-3 py-3 text-center text-slate-300 whitespace-nowrap">{{ $p->detailPembelians->count() }} item</td>
                    <td class="px-3 py-3 text-right font-semibold text-white whitespace-nowrap">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                    <td class="px-3 py-3 text-center whitespace-nowrap">
                        <span class="bg-slate-700 text-slate-300 text-xs px-2 py-0.5 rounded-full capitalize">{{ $p->metode_pembayaran }}</span>
                    </td>
                    <td class="px-3 py-3 text-center whitespace-nowrap">
                        <span class="text-xs px-2.5 py-1 rounded-full font-bold whitespace-nowrap inline-block {{ $badgeClass }}">{{ $p->status_label }}</span>
                    </td>
                    <td class="px-3 py-3 text-xs text-slate-400 whitespace-nowrap">{{ $p->created_at->format('d M, H:i') }}</td>
                    <td class="px-3 py-3 whitespace-nowrap">
                        <div class="flex items-center justify-center space-x-1.5">
                            <a href="{{ route('admin.pesanans.show', $p) }}"
                                class="bg-slate-700 hover:bg-slate-600 text-white text-xs px-2.5 py-1.5 rounded-lg transition" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            {{-- Quick status update --}}
                            <form method="POST" action="{{ route('admin.pesanans.updateStatus', $p) }}">
                                @csrf @method('PATCH')
                                @php
                                    $nextStatus = match($p->status) {
                                        'pending'       => 'diproses',
                                        'diproses'      => 'dapat_diambil',
                                        'dapat_diambil' => 'selesai',
                                        default         => null,
                                    };
                                    $nextLabel = match($p->status) {
                                        'pending'       => 'Proses',
                                        'diproses'      => 'Siap Ambil',
                                        'dapat_diambil' => 'Selesai',
                                        default         => null,
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
