@extends('admin.layouts.app')

@section('title', 'Rekap Harian Stand')
@section('page-title', 'Rekap Harian Stand')
@section('page-subtitle', 'Laporan rekap dari semua penjaga stand')

@section('content')
<div class="mt-4 space-y-6">

    {{-- ── RINGKASAN TOTAL ────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-3">
        <div class="bg-gradient-to-br from-emerald-700 to-teal-700 rounded-xl p-4 border border-emerald-600 col-span-2 lg:col-span-1">
            <p class="text-emerald-200 text-xs font-semibold uppercase tracking-wider flex items-center gap-1">
                <i class="fas fa-coins text-yellow-300"></i> Total Pendapatan
            </p>
            <p class="text-white text-xl font-extrabold mt-1">Rp {{ number_format($ringkasan['total_pendapatan'], 0, ',', '.') }}</p>
            <p class="text-emerald-300 text-xs mt-0.5">{{ $ringkasan['jumlah_rekap'] }} catatan rekap</p>
        </div>
        <div class="bg-slate-800 rounded-xl p-4 border border-slate-700">
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Keuntungan</p>
            <p class="text-blue-400 text-xl font-bold mt-1">Rp {{ number_format($ringkasan['total_keuntungan'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-slate-800 rounded-xl p-4 border border-slate-700">
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Total Pesanan</p>
            <p class="text-white text-xl font-bold mt-1">{{ $ringkasan['total_pesanan'] }}</p>
        </div>
        <div class="bg-slate-800 rounded-xl p-4 border border-slate-700">
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Selesai</p>
            <p class="text-emerald-400 text-xl font-bold mt-1">{{ $ringkasan['pesanan_selesai'] }}</p>
        </div>
        <div class="bg-slate-800 rounded-xl p-4 border border-slate-700">
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Dibatalkan</p>
            <p class="text-red-400 text-xl font-bold mt-1">{{ $ringkasan['pesanan_dibatalkan'] }}</p>
        </div>
    </div>

    {{-- ── FILTER ─────────────────────────────────────────────────────── --}}
    <form method="GET" class="bg-slate-800 rounded-2xl border border-slate-700 p-4">
        <div class="flex flex-wrap gap-3 items-end">
            <div class="min-w-[180px] flex-1">
                <label class="text-xs text-slate-400 block mb-1">Stand</label>
                <select name="stand_id"
                    class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-orange-500">
                    <option value="">Semua Stand</option>
                    @foreach($stands as $s)
                        <option value="{{ $s->id }}" {{ request('stand_id') == $s->id ? 'selected' : '' }}>
                            {{ $s->nama_stand }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="min-w-[150px]">
                <label class="text-xs text-slate-400 block mb-1">Dari Tanggal</label>
                <input type="date" name="dari" value="{{ request('dari') }}"
                    class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-orange-500">
            </div>
            <div class="min-w-[150px]">
                <label class="text-xs text-slate-400 block mb-1">Sampai Tanggal</label>
                <input type="date" name="sampai" value="{{ request('sampai') }}"
                    class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-orange-500">
            </div>
            <button type="submit"
                class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition flex items-center gap-2">
                <i class="fas fa-filter"></i> Filter
            </button>
            @if(request()->hasAny(['stand_id','dari','sampai']))
                <a href="{{ route('admin.rekap.index') }}"
                    class="text-slate-400 hover:text-white text-sm transition px-2 py-2.5">
                    <i class="fas fa-times mr-1"></i>Reset
                </a>
            @endif
        </div>
    </form>

    {{-- ── TABEL REKAP ────────────────────────────────────────────────── --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-700 flex items-center justify-between">
            <h3 class="font-semibold text-white flex items-center gap-2">
                <i class="fas fa-clipboard-list text-orange-400 text-sm"></i>
                Catatan Rekap Harian
            </h3>
            <span class="text-slate-500 text-xs">{{ $rekaps->total() }} rekap ditemukan</span>
        </div>

        @if($rekaps->isEmpty())
            <div class="px-6 py-16 text-center text-slate-500">
                <i class="fas fa-clipboard text-4xl mb-3 block opacity-40"></i>
                <p class="font-medium">Belum ada rekap harian tersimpan.</p>
                <p class="text-xs mt-1">Rekap akan muncul di sini setelah penjaga stand mengisi formulir rekap.</p>
            </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-700/50">
                    <tr class="text-xs text-slate-400 uppercase tracking-wider">
                        <th class="px-4 py-3 text-left">Stand</th>
                        <th class="px-4 py-3 text-left">Hari / Tanggal</th>
                        <th class="px-4 py-3 text-right">Pendapatan</th>
                        <th class="px-4 py-3 text-right">Keuntungan</th>
                        <th class="px-4 py-3 text-center">Total Pesanan</th>
                        <th class="px-4 py-3 text-center">Selesai</th>
                        <th class="px-4 py-3 text-center">Batal</th>
                        <th class="px-4 py-3 text-left hidden xl:table-cell">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @foreach($rekaps as $r)
                    <tr class="hover:bg-slate-700/30 transition">
                        <td class="px-4 py-3">
                            <span class="font-semibold text-white text-xs">{{ $r->stand->nama_stand ?? '—' }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <p class="font-semibold text-white">{{ $r->hari }}</p>
                            <p class="text-xs text-slate-400">{{ $r->tanggal->format('d/m/Y') }}</p>
                        </td>
                        <td class="px-4 py-3 text-right font-bold text-emerald-400 whitespace-nowrap">
                            Rp {{ number_format($r->total_pendapatan, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-right font-bold text-blue-400 whitespace-nowrap">
                            Rp {{ number_format($r->total_keuntungan, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center text-white font-semibold">{{ $r->total_pesanan }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="bg-emerald-500/20 text-emerald-400 text-xs font-bold px-2 py-0.5 rounded-full">{{ $r->pesanan_selesai }}</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="bg-red-500/20 text-red-400 text-xs font-bold px-2 py-0.5 rounded-full">{{ $r->pesanan_dibatalkan }}</span>
                        </td>
                        <td class="px-4 py-3 hidden xl:table-cell text-slate-400 text-xs max-w-[180px] truncate">
                            {{ $r->catatan ?: '—' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                {{-- Footer total halaman ini --}}
                <tfoot class="bg-slate-700/30 border-t border-slate-600">
                    <tr class="text-xs font-bold">
                        <td class="px-4 py-3 text-slate-300" colspan="2">
                            TOTAL ({{ $rekaps->count() }} rekap halaman ini)
                        </td>
                        <td class="px-4 py-3 text-right text-emerald-300 whitespace-nowrap">
                            Rp {{ number_format($rekaps->sum('total_pendapatan'), 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-right text-blue-300 whitespace-nowrap">
                            Rp {{ number_format($rekaps->sum('total_keuntungan'), 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center text-white">{{ $rekaps->sum('total_pesanan') }}</td>
                        <td class="px-4 py-3 text-center text-emerald-300">{{ $rekaps->sum('pesanan_selesai') }}</td>
                        <td class="px-4 py-3 text-center text-red-300">{{ $rekaps->sum('pesanan_dibatalkan') }}</td>
                        <td class="px-4 py-3 hidden xl:table-cell"></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Pagination --}}
        @if($rekaps->hasPages())
            <div class="px-6 py-4 border-t border-slate-700">
                {{ $rekaps->links() }}
            </div>
        @endif
        @endif
    </div>

</div>
@endsection
