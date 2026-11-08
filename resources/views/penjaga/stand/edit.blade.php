@extends('penjaga.layouts.app')

@section('title', 'Info Stand')
@section('page-title', 'Info Stand Saya')
@section('page-subtitle', $stand->nama_stand)

@section('content')
<div class="mt-6 max-w-2xl">
    <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6">

        {{-- Preview gambar --}}
        @if($stand->gambar)
        <div class="mb-6">
            <img src="{{ str_starts_with($stand->gambar, 'http') ? $stand->gambar : asset('storage/'.$stand->gambar) }}"
                 alt="{{ $stand->nama_stand }}"
                 class="w-full h-48 object-cover rounded-xl">
        </div>
        @endif

        <form action="{{ route('penjaga.stand.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nama Stand</label>
                <input type="text" value="{{ $stand->nama_stand }}" disabled
                    class="w-full bg-slate-700/50 border border-slate-600 rounded-xl px-4 py-3 text-slate-400 text-sm cursor-not-allowed">
                <p class="text-xs text-slate-500 mt-1">Nama stand hanya bisa diubah oleh admin.</p>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                    class="w-full bg-slate-700 border border-slate-600 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">{{ old('deskripsi', $stand->deskripsi) }}</textarea>
                @error('deskripsi') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">No. Telepon</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon', $stand->no_telepon) }}"
                    class="w-full bg-slate-700 border border-slate-600 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                @error('no_telepon') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Foto Stand</label>
                <input type="file" name="gambar" accept="image/*"
                    class="w-full bg-slate-700 border border-slate-600 rounded-xl px-4 py-3 text-slate-300 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-600 file:text-white file:text-xs file:font-bold cursor-pointer">
                <p class="text-xs text-slate-500 mt-1">JPG, PNG, WebP. Maks 2MB.</p>
                @error('gambar') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- QRIS --}}
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
                    <i class="fas fa-qrcode mr-1 text-emerald-400"></i>Foto QRIS Stand
                </label>
                @if($stand->qris_gambar)
                <div class="mb-3">
                    <p class="text-xs text-slate-500 mb-2">QRIS saat ini:</p>
                    <img src="{{ asset('storage/'.$stand->qris_gambar) }}"
                         alt="QRIS saat ini"
                         class="h-48 rounded-xl object-contain border border-slate-600 bg-white p-2">
                </div>
                @else
                <p class="text-xs text-slate-500 mb-2">Belum ada foto QRIS — upload sekarang.</p>
                @endif
                <input type="file" name="qris_gambar" accept="image/*"
                    class="w-full bg-slate-700 border border-slate-600 rounded-xl px-4 py-3 text-slate-300 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-600 file:text-white file:text-xs file:font-bold cursor-pointer">
                <p class="text-xs text-slate-500 mt-1">JPG, PNG, WebP. Maks 3MB. Kosongkan jika tidak ingin ganti.</p>
                @error('qris_gambar') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center space-x-3">
                <input type="checkbox" name="status_buka" id="status_buka" value="1"
                    {{ $stand->status_buka ? 'checked' : '' }}
                    class="w-5 h-5 accent-emerald-500 cursor-pointer">
                <label for="status_buka" class="text-sm text-slate-300 cursor-pointer">Stand sedang <strong class="text-emerald-400">Buka</strong></label>
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-8 py-3 rounded-xl font-bold text-sm hover:opacity-90 transition shadow-lg">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
