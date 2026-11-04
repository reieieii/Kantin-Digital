@extends('admin.layouts.app')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')
@section('page-subtitle', 'Tambahkan produk baru ke salah satu stand')

@section('content')

<div class="max-w-2xl mx-auto mt-2">
    <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6">

        @if($errors->any())
        <div class="bg-red-500/15 border border-red-500/30 text-red-300 rounded-xl px-4 py-3 mb-6 text-sm">
            <p class="font-semibold mb-1"><i class="fas fa-circle-exclamation mr-1"></i>Ada kesalahan:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.produks.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1.5">Stand <span class="text-red-400">*</span></label>
                <select name="stand_id" required
                    class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                    <option value="">— Pilih Stand —</option>
                    @foreach($stands as $s)
                        <option value="{{ $s->id }}" {{ old('stand_id') == $s->id ? 'selected' : '' }}>{{ $s->nama_stand }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Produk <span class="text-red-400">*</span></label>
                <input type="text" name="nama_produk" value="{{ old('nama_produk') }}"
                    class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500"
                    placeholder="Contoh: Nasi Rendang" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1.5">Deskripsi <span class="text-red-400">*</span></label>
                <textarea name="deskripsi" rows="3"
                    class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 resize-none"
                    placeholder="Deskripsi produk..." required>{{ old('deskripsi') }}</textarea>
            </div>

            <div class="grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Harga (Rp) <span class="text-red-400">*</span></label>
                    <input type="number" name="harga" value="{{ old('harga') }}" min="0"
                        class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-purple-500"
                        placeholder="15000" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Stock <span class="text-red-400">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', 10) }}" min="0"
                        class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-purple-500"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Kategori <span class="text-red-400">*</span></label>
                    <select name="kategori" required
                        class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-purple-500">
                        <option value="">Pilih</option>
                        <option value="Makanan Berat" {{ old('kategori') == 'Makanan Berat' ? 'selected' : '' }}>Makanan Berat</option>
                        <option value="Makanan Ringan" {{ old('kategori') == 'Makanan Ringan' ? 'selected' : '' }}>Makanan Ringan</option>
                        <option value="Minuman" {{ old('kategori') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                        <option value="Snack" {{ old('kategori') == 'Snack' ? 'selected' : '' }}>Snack</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1.5">Gambar Produk</label>
                <div class="border-2 border-dashed border-slate-600 rounded-xl p-6 text-center hover:border-purple-500 transition cursor-pointer"
                    onclick="document.getElementById('gambar').click()">
                    <img id="preview" src="" class="mx-auto mb-3 max-h-36 rounded-lg hidden object-cover">
                    <i class="fas fa-cloud-upload-alt text-slate-400 text-3xl mb-2 block" id="uploadIcon"></i>
                    <p class="text-slate-400 text-sm" id="uploadText">Klik untuk upload gambar</p>
                    <p class="text-slate-500 text-xs mt-1">JPG, PNG, WEBP — maks. 2MB</p>
                    <input type="file" name="gambar" id="gambar" accept="image/*" class="hidden" onchange="previewImage(event)">
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <input type="checkbox" name="tersedia" id="tersedia" value="1"
                    {{ old('tersedia', true) ? 'checked' : '' }}
                    class="w-5 h-5 rounded accent-purple-500 cursor-pointer">
                <label for="tersedia" class="text-sm text-slate-300 cursor-pointer">Produk tersedia untuk dipesan</label>
            </div>

            <div class="flex items-center justify-between pt-2">
                <a href="{{ route('admin.produks.index') }}"
                    class="text-slate-400 hover:text-white text-sm transition">← Kembali</a>
                <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition">
                    <i class="fas fa-save mr-2"></i>Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewImage(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = ev => {
        document.getElementById('preview').src = ev.target.result;
        document.getElementById('preview').classList.remove('hidden');
        document.getElementById('uploadIcon').classList.add('hidden');
        document.getElementById('uploadText').textContent = file.name;
    };
    reader.readAsDataURL(file);
}
</script>
@endpush

@endsection
