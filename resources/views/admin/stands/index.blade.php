@extends('admin.layouts.app')

@section('title', 'Kelola Stand')
@section('page-title', 'Kelola Stand')
@section('page-subtitle', 'Tambah, edit, dan hapus stand kantin')

@section('content')

<div class="flex items-center justify-between mb-6 mt-2">
    <p class="text-slate-400 text-sm">Total <span class="text-white font-semibold">{{ $stands->total() }}</span> stand</p>
    <a href="{{ route('admin.stands.create') }}"
        class="flex items-center space-x-2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition">
        <i class="fas fa-plus"></i><span>Tambah Stand</span>
    </a>
</div>

<div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-4">
    @forelse($stands as $stand)
    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden hover:border-slate-500 transition">
        {{-- Gambar --}}
        <div class="h-40 bg-slate-700 overflow-hidden relative">
            <img src="{{ str_starts_with($stand->gambar, 'http') ? $stand->gambar : asset('storage/'.$stand->gambar) }}"
                 alt="{{ $stand->nama_stand }}"
                 class="w-full h-full object-cover"
                 onerror="this.src='https://via.placeholder.com/400x160/334155/94a3b8?text=No+Image'">
            <div class="absolute top-3 right-3">
                @if($stand->status_buka)
                    <span class="bg-emerald-500 text-white text-xs px-2 py-1 rounded-full font-medium">Buka</span>
                @else
                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-medium">Tutup</span>
                @endif
            </div>
        </div>
        {{-- Info --}}
        <div class="p-4">
            <h3 class="font-semibold text-white mb-1 truncate">{{ $stand->nama_stand }}</h3>
            <p class="text-xs text-slate-400 mb-1"><i class="fas fa-user mr-1"></i>{{ $stand->pemilik }}</p>
            <p class="text-xs text-slate-400 mb-3"><i class="fas fa-box-open mr-1"></i>{{ $stand->produks_count }} produk</p>
            <p class="text-xs text-slate-500 line-clamp-2 mb-4">{{ $stand->deskripsi }}</p>
            <div class="flex space-x-2">
                <a href="{{ route('admin.stands.edit', $stand) }}"
                    class="flex-1 text-center bg-slate-700 hover:bg-slate-600 text-white text-xs py-2 rounded-lg transition">
                    <i class="fas fa-pen-to-square mr-1"></i>Edit
                </a>
                <form method="POST" action="{{ route('admin.stands.destroy', $stand) }}"
                    onsubmit="return confirm('Hapus stand {{ addslashes($stand->nama_stand) }}? Semua produk di stand ini akan ikut terhapus.')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="bg-red-500/20 hover:bg-red-500/40 text-red-400 text-xs py-2 px-3 rounded-lg transition">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-16 text-slate-500">
        <i class="fas fa-store-slash text-4xl mb-3 block"></i>
        <p class="text-lg font-medium">Belum ada stand</p>
        <a href="{{ route('admin.stands.create') }}" class="text-orange-400 text-sm mt-2 inline-block hover:underline">+ Tambah stand pertama</a>
    </div>
    @endforelse
</div>

<div class="mt-6">{{ $stands->links() }}</div>

@endsection
