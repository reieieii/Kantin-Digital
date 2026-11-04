@extends('admin.layouts.app')

@section('title', 'Kelola Produk')
@section('page-title', 'Kelola Produk')
@section('page-subtitle', 'Tambah, edit, dan hapus produk kantin')

@section('content')

{{-- Filter & Search --}}
<form method="GET" class="bg-slate-800 rounded-2xl border border-slate-700 p-4 mb-6 mt-2">
    <div class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[180px]">
            <label class="text-xs text-slate-400 block mb-1">Cari Produk</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama produk..."
                class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-orange-500">
        </div>
        <div class="min-w-[160px]">
            <label class="text-xs text-slate-400 block mb-1">Stand</label>
            <select name="stand_id" class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-orange-500">
                <option value="">Semua Stand</option>
                @foreach($stands as $s)
                    <option value="{{ $s->id }}" {{ request('stand_id') == $s->id ? 'selected' : '' }}>{{ $s->nama_stand }}</option>
                @endforeach
            </select>
        </div>
        <div class="min-w-[140px]">
            <label class="text-xs text-slate-400 block mb-1">Kategori</label>
            <select name="kategori" class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-orange-500">
                <option value="">Semua</option>
                @foreach($kategoris as $k)
                    <option value="{{ $k }}" {{ request('kategori') == $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition">
            <i class="fas fa-search mr-1"></i>Filter
        </button>
        @if(request()->hasAny(['search','stand_id','kategori']))
            <a href="{{ route('admin.produks.index') }}" class="text-slate-400 hover:text-white text-sm transition px-2">Reset</a>
        @endif
        <div class="ml-auto">
            <a href="{{ route('admin.produks.create') }}"
                class="flex items-center space-x-2 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition">
                <i class="fas fa-plus"></i><span>Tambah Produk</span>
            </a>
        </div>
    </div>
</form>

<p class="text-slate-400 text-sm mb-4">Menampilkan <span class="text-white font-semibold">{{ $produks->total() }}</span> produk</p>

<div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-700/50 text-slate-400 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Produk</th>
                    <th class="px-4 py-3 text-left">Stand</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-right">Harga</th>
                    <th class="px-4 py-3 text-center">Stock</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                @forelse($produks as $produk)
                <tr class="hover:bg-slate-700/30 transition">
                    <td class="px-4 py-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg overflow-hidden bg-slate-700 flex-shrink-0">
                                <img src="{{ str_starts_with($produk->gambar, 'http') ? $produk->gambar : asset('storage/'.$produk->gambar) }}"
                                     alt="{{ $produk->nama_produk }}"
                                     class="w-full h-full object-cover"
                                     onerror="this.src='https://via.placeholder.com/40x40/334155/94a3b8?text=P'">
                            </div>
                            <div>
                                <p class="font-medium text-white">{{ $produk->nama_produk }}</p>
                                <p class="text-xs text-slate-400 line-clamp-1">{{ $produk->deskripsi }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-slate-300">{{ $produk->stand->nama_stand ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="bg-slate-700 text-slate-300 text-xs px-2 py-1 rounded-full">{{ $produk->kategori }}</span>
                    </td>
                    <td class="px-4 py-3 text-right font-semibold text-white">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="{{ $produk->stock <= 5 ? 'text-red-400' : 'text-white' }} font-medium">{{ $produk->stock }}</span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($produk->tersedia)
                            <span class="bg-emerald-100 text-emerald-800 text-xs px-2 py-0.5 rounded-full font-medium">Tersedia</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs px-2 py-0.5 rounded-full font-medium">Habis</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('admin.produks.edit', $produk) }}"
                                class="bg-slate-700 hover:bg-slate-600 text-white text-xs px-3 py-1.5 rounded-lg transition">
                                <i class="fas fa-pen-to-square"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.produks.destroy', $produk) }}"
                                onsubmit="return confirm('Hapus produk {{ addslashes($produk->nama_produk) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500/20 hover:bg-red-500/40 text-red-400 text-xs px-3 py-1.5 rounded-lg transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-12 text-center text-slate-500">
                        <i class="fas fa-utensils text-3xl mb-3 block"></i>
                        <p>Belum ada produk</p>
                        <a href="{{ route('admin.produks.create') }}" class="text-purple-400 text-sm mt-1 inline-block hover:underline">+ Tambah produk</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $produks->links() }}</div>

@endsection
