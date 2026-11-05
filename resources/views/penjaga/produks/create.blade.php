@extends('penjaga.layouts.app')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk Baru')
@section('page-subtitle', $stand->nama_stand)

@section('content')
<div class="mt-6 max-w-2xl">
    <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6">
        <form action="{{ route('penjaga.produks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nama Produk <span class="text-red-400">*</span></label>
                <input type="text" name="nama_produk" value="{{ old('nama_produk') }}"
                    class="w-full bg-slate-700 border border-slate-600 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">
                @error('nama_produk') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Deskripsi <span class="text-red-400">*</span></label>
                <textarea name="deskripsi" rows="3"
                    class="w-full bg-slate-700 border border-slate-600 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Harga (Rp) <span class="text-red-400">*</span></label>
                    <input type="number" name="harga" value="{{ old('harga') }}" min="0"
                        class="w-full bg-slate-700 border border-slate-600 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">
                    @error('harga') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Stok <span class="text-red-400">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0"
                        class="w-full bg-slate-700 border border-slate-600 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">
                    @error('stock') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Kategori <span class="text-red-400">*</span></label>
                <select name="kategori"
                    class="w-full bg-slate-700 border border-slate-600 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500">
                    <option value="Makanan" {{ old('kategori') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="Minuman" {{ old('kategori') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="Snack"   {{ old('kategori') == 'Snack'   ? 'selected' : '' }}>Snack / Cemilan</option>
                </select>
                @error('kategori') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Foto Produk</label>
                <input type="file" name="gambar" accept="image/*"
                    class="w-full bg-slate-700 border border-slate-600 rounded-xl px-4 py-3 text-slate-300 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-600 file:text-white file:text-xs file:font-bold cursor-pointer">
                <p class="text-xs text-slate-500 mt-1">JPG, PNG, WebP. Maks 2MB. Kosongkan untuk pakai foto otomatis.</p>
                @error('gambar') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center space-x-3">
                <input type="checkbox" name="tersedia" id="tersedia" value="1" checked
                    class="w-5 h-5 accent-emerald-500 cursor-pointer">
                <label for="tersedia" class="text-sm text-slate-300 cursor-pointer">Produk <strong class="text-emerald-400">Tersedia</strong> untuk dipesan</label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-8 py-3 rounded-xl font-bold text-sm hover:opacity-90 transition shadow-lg">
                    <i class="fas fa-plus mr-2"></i>Tambah Produk
                </button>
                <a href="{{ route('penjaga.produks.index') }}"
                    class="bg-slate-700 text-slate-300 px-6 py-3 rounded-xl font-bold text-sm hover:bg-slate-600 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
