@extends('admin.layouts.app')

@section('title', 'Edit Stand')
@section('page-title', 'Edit Stand')
@section('page-subtitle', 'Perbarui informasi stand: {{ $stand->nama_stand }}')

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

        <form method="POST" action="{{ route('admin.stands.update', $stand) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Stand <span class="text-red-400">*</span></label>
                <input type="text" name="nama_stand" value="{{ old('nama_stand', $stand->nama_stand) }}"
                    class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500" required>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Pemilik <span class="text-red-400">*</span></label>
                    <input type="text" name="pemilik" value="{{ old('pemilik', $stand->pemilik) }}"
                        class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">No. Telepon <span class="text-red-400">*</span></label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon', $stand->no_telepon) }}"
                        class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1.5">Deskripsi <span class="text-red-400">*</span></label>
                <textarea name="deskripsi" rows="3"
                    class="w-full bg-slate-700 border border-slate-600 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 resize-none" required>{{ old('deskripsi', $stand->deskripsi) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1.5">Gambar Stand</label>
                {{-- Preview gambar saat ini --}}
                @if($stand->gambar)
                <div class="mb-3">
                    <p class="text-xs text-slate-400 mb-2">Gambar saat ini:</p>
                    <img src="{{ str_starts_with($stand->gambar, 'http') ? $stand->gambar : asset('storage/'.$stand->gambar) }}"
                         alt="Gambar saat ini" class="h-32 rounded-xl object-cover border border-slate-600"
                         onerror="this.style.display='none'">
                </div>
                @endif
                <div class="border-2 border-dashed border-slate-600 rounded-xl p-5 text-center hover:border-orange-500 transition cursor-pointer"
                    onclick="document.getElementById('gambar').click()">
                    <img id="preview" src="" class="mx-auto mb-3 max-h-32 rounded-lg hidden object-cover">
                    <i class="fas fa-cloud-upload-alt text-slate-400 text-2xl mb-2 block" id="uploadIcon"></i>
                    <p class="text-slate-400 text-sm" id="uploadText">Upload gambar baru (opsional)</p>
                    <p class="text-slate-500 text-xs mt-1">JPG, PNG, WEBP — maks. 2MB</p>
                    <input type="file" name="gambar" id="gambar" accept="image/*" class="hidden" onchange="previewImage(event)">
                </div>
            </div>

            {{-- QRIS --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1.5">
                    <i class="fas fa-qrcode mr-1 text-orange-400"></i>Foto QRIS Stand
                </label>
                @if($stand->qris_gambar)
                <div class="mb-3">
                    <p class="text-xs text-slate-400 mb-2">QRIS saat ini:</p>
                    <img src="{{ asset('storage/'.$stand->qris_gambar) }}"
                         alt="QRIS saat ini" class="h-40 rounded-xl object-contain border border-slate-600 bg-white p-1"
                         onerror="this.style.display='none'">
                </div>
                @endif
                <div class="border-2 border-dashed border-slate-600 rounded-xl p-5 text-center hover:border-orange-500 transition cursor-pointer"
                    onclick="document.getElementById('qris_gambar').click()">
                    <img id="previewQris" src="" class="mx-auto mb-3 max-h-40 rounded-lg hidden object-contain">
                    <i class="fas fa-qrcode text-slate-400 text-2xl mb-2 block" id="uploadQrisIcon"></i>
                    <p class="text-slate-400 text-sm" id="uploadQrisText">Upload foto QRIS baru (opsional)</p>
                    <p class="text-slate-500 text-xs mt-1">JPG, PNG, WEBP — maks. 3MB</p>
                    <input type="file" name="qris_gambar" id="qris_gambar" accept="image/*" class="hidden" onchange="previewQris(event)">
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <input type="checkbox" name="status_buka" id="status_buka" value="1"
                    {{ old('status_buka', $stand->status_buka) ? 'checked' : '' }}
                    class="w-5 h-5 rounded accent-orange-500 cursor-pointer">
                <label for="status_buka" class="text-sm text-slate-300 cursor-pointer">Stand sedang buka</label>
            </div>

            <div class="flex items-center justify-between pt-2">
                <a href="{{ route('admin.stands.index') }}"
                    class="text-slate-400 hover:text-white text-sm transition">← Kembali</a>
                <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
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

function previewQris(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = ev => {
        document.getElementById('previewQris').src = ev.target.result;
        document.getElementById('previewQris').classList.remove('hidden');
        document.getElementById('uploadQrisIcon').classList.add('hidden');
        document.getElementById('uploadQrisText').textContent = file.name;
    };
    reader.readAsDataURL(file);
}
</script>
@endpush

@endsection
