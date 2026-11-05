@extends('penjaga.layouts.app')

@section('title', 'Produk Saya')
@section('page-title', 'Produk Saya')
@section('page-subtitle', $stand->nama_stand)

@section('content')
<div class="mt-6 space-y-4">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <form method="GET" class="flex gap-3 flex-wrap">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari produk..."
                class="bg-slate-700 border border-slate-600 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-emerald-500 w-64">
            <select name="kategori"
                class="bg-slate-700 border border-slate-600 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-emerald-500">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $k)
                    <option value="{{ $k }}" {{ request('kategori') == $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-slate-700 border border-slate-600 px-4 py-2.5 rounded-xl text-sm text-slate-300 hover:text-white transition">
                <i class="fas fa-search"></i>
            </button>
        </form>
        <a href="{{ route('penjaga.produks.create') }}"
            class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:opacity-90 transition shadow-lg flex items-center gap-2 whitespace-nowrap">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>

    {{-- Tabel --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-slate-700 text-xs text-slate-400 uppercase tracking-wider">
                    <th class="px-6 py-4 text-left">Produk</th>
                    <th class="px-6 py-4 text-left hidden sm:table-cell">Kategori</th>
                    <th class="px-6 py-4 text-left">Harga</th>
                    <th class="px-6 py-4 text-left hidden md:table-cell">Stok</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                @forelse($produks as $p)
                <tr class="hover:bg-slate-700/30 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0 bg-slate-700">
                                <img src="{{ $p->gambar && !str_starts_with($p->gambar,'http') ? asset('storage/'.$p->gambar) : ($p->gambar ?? 'https://via.placeholder.com/40') }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-white">{{ $p->nama_produk }}</p>
                                <p class="text-xs text-slate-400 line-clamp-1">{{ $p->deskripsi }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 hidden sm:table-cell">
                        <span class="px-2.5 py-1 bg-slate-700 text-slate-300 rounded-lg text-xs font-medium">{{ $p->kategori }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-emerald-400">
                        Rp {{ number_format($p->harga, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell">
                        <span class="text-sm font-bold {{ $p->stock > 0 ? 'text-white' : 'text-red-400' }}">{{ $p->stock }}</span>
                        <span class="text-xs text-slate-500"> pcs</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $p->tersedia && $p->stock > 0 ? 'bg-emerald-500/20 text-emerald-400' : 'bg-red-500/20 text-red-400' }}">
                            {{ $p->tersedia && $p->stock > 0 ? 'Tersedia' : 'Habis' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('penjaga.produks.edit', $p) }}"
                                class="p-2 text-slate-400 hover:text-emerald-400 hover:bg-emerald-500/10 rounded-lg transition" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('penjaga.produks.destroy', $p) }}" method="POST"
                                onsubmit="return confirm('Hapus produk {{ addslashes($p->nama_produk) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="p-2 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                        <i class="fas fa-utensils text-3xl mb-3 block"></i>
                        Belum ada produk. <a href="{{ route('penjaga.produks.create') }}" class="text-emerald-400 hover:underline">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($produks->hasPages())
        <div class="text-slate-400">{{ $produks->links() }}</div>
    @endif
</div>
@endsection
