@extends('admin.layouts.app')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')
@section('page-subtitle', '#' . $pesanan->kode_pembelian)

@section('content')

<div class="max-w-4xl mx-auto mt-2 space-y-5">

    {{-- Header Card --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700 p-5">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="text-xs text-slate-400 mb-1">Kode Pembelian</p>
                <p class="font-mono text-xl font-bold text-orange-400">{{ $pesanan->kode_pembelian }}</p>
                <p class="text-xs text-slate-400 mt-1">{{ $pesanan->created_at->format('l, d F Y — H:i') }}</p>
            </div>
            @php
                $badgeClass = match($pesanan->status) {
                    'pending'       => 'bg-amber-100 text-amber-800',
                    'diproses'      => 'bg-blue-100 text-blue-800',
                    'dapat_diambil' => 'bg-indigo-100 text-indigo-800',
                    'selesai'       => 'bg-emerald-100 text-emerald-800',
                    'dibatalkan'    => 'bg-red-100 text-red-800',
                    default         => 'bg-slate-100 text-slate-800',
                };
            @endphp
            <span class="text-sm px-4 py-1.5 rounded-full font-bold whitespace-nowrap inline-block {{ $badgeClass }}">{{ $pesanan->status_label }}</span>
        </div>

        @if($stands->isNotEmpty())
        <div class="mt-4 pt-4 border-t border-slate-700/70 flex flex-wrap items-center gap-2">
            <span class="text-xs text-slate-400 font-medium flex items-center gap-1.5">
                <i class="fas fa-store text-orange-400"></i> Pesanan Dari Stand:
            </span>
            @foreach($stands as $std)
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-orange-500/10 text-orange-400 border border-orange-500/30">
                    <i class="fas fa-store text-[10px]"></i> {{ $std->nama_stand }}
                </span>
            @endforeach
        </div>
        @endif
    </div>

    <div class="grid md:grid-cols-3 gap-5">
        {{-- Info Pembeli --}}
        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-5">
            <h3 class="font-semibold text-white mb-4 flex items-center space-x-2">
                <i class="fas fa-user text-slate-400"></i><span>Info Pembeli</span>
            </h3>
            <div class="space-y-3 text-sm">
                <div><p class="text-xs text-slate-500">Nama</p><p class="text-white font-medium">{{ $pesanan->nama_pembeli }}</p></div>
                <div><p class="text-xs text-slate-500">Email</p><p class="text-slate-300">{{ $pesanan->email ?: '-' }}</p></div>
                <div><p class="text-xs text-slate-500">Telepon</p><p class="text-slate-300">{{ $pesanan->no_telepon ?: '-' }}</p></div>
                <div><p class="text-xs text-slate-500">Alamat / Kelas</p><p class="text-slate-300">{{ $pesanan->alamat ?: '-' }}</p></div>
                @if($pesanan->catatan)
                <div><p class="text-xs text-slate-500">Catatan</p><p class="text-slate-300 italic">{{ $pesanan->catatan }}</p></div>
                @endif
            </div>
        </div>

        {{-- Info Stand --}}
        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-5">
            <h3 class="font-semibold text-white mb-4 flex items-center space-x-2">
                <i class="fas fa-store text-slate-400"></i><span>Info Stand</span>
            </h3>
            @forelse($stands as $std)
            <div class="space-y-3 text-sm {{ !$loop->first ? 'pt-3 mt-3 border-t border-slate-700' : '' }}">
                <div>
                    <p class="text-xs text-slate-500">Nama Stand</p>
                    <p class="text-white font-bold text-sm flex items-center gap-1.5 mt-0.5">
                        <i class="fas fa-store text-orange-400 text-xs"></i>
                        {{ $std->nama_stand }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Pemilik</p>
                    <p class="text-slate-300">{{ $std->pemilik ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Kontak Stand</p>
                    <p class="text-slate-300">{{ $std->no_telepon ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Status Stand</p>
                    <span class="inline-block mt-0.5 px-2 py-0.5 text-[11px] font-bold rounded-full {{ $std->status_buka ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                        {{ $std->status_buka ? '● Buka' : '○ Tutup' }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-slate-500 text-xs italic">Data stand tidak ditemukan</p>
            @endforelse
        </div>

        {{-- Info Pembayaran --}}
        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-5">
            <h3 class="font-semibold text-white mb-4 flex items-center space-x-2">
                <i class="fas fa-wallet text-slate-400"></i><span>Info Pembayaran</span>
            </h3>
            <div class="space-y-3 text-sm">
                <div><p class="text-xs text-slate-500">Metode</p>
                    <p class="text-white font-medium capitalize">{{ $pesanan->metode_pembayaran }}</p></div>
                <div><p class="text-xs text-slate-500">Total Harga</p>
                    <p class="text-2xl font-bold text-white">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p></div>
            </div>

            {{-- Update Status --}}
            <div class="mt-5 pt-4 border-t border-slate-700">
                <p class="text-xs text-slate-400 mb-2">Ubah Status Pesanan</p>
                <form method="POST" action="{{ route('admin.pesanans.updateStatus', $pesanan) }}" class="flex items-center space-x-2">
                    @csrf @method('PATCH')
                    <select name="status"
                        class="flex-1 bg-slate-700 border border-slate-600 text-white rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-orange-500">
                        <option value="pending"       {{ $pesanan->status == 'pending'       ? 'selected' : '' }}>Pending</option>
                        <option value="diproses"      {{ $pesanan->status == 'diproses'      ? 'selected' : '' }}>Diproses</option>
                        <option value="dapat_diambil" {{ $pesanan->status == 'dapat_diambil' ? 'selected' : '' }}>Dapat Diambil</option>
                        <option value="selesai"       {{ $pesanan->status == 'selesai'       ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan"    {{ $pesanan->status == 'dibatalkan'    ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition whitespace-nowrap">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Card Bukti Pembayaran (Khusus jika ada bukti pembayaran atau metode QRIS) --}}
    @if($pesanan->bukti_pembayaran || $pesanan->metode_pembayaran === 'qris')
    <div class="bg-slate-800 rounded-2xl border border-slate-700 p-5">
        <div class="flex items-center justify-between pb-4 border-b border-slate-700 mb-4">
            <h3 class="font-semibold text-white flex items-center space-x-2">
                <i class="fas fa-file-invoice text-orange-400"></i>
                <span>Bukti Pembayaran</span>
            </h3>
            <span class="text-xs px-3 py-1 rounded-full font-bold uppercase {{ $pesanan->bukti_pembayaran ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-amber-500/20 text-amber-400 border border-amber-500/30' }}">
                <i class="fas {{ $pesanan->bukti_pembayaran ? 'fa-check-circle' : 'fa-clock' }} mr-1"></i>
                {{ $pesanan->bukti_pembayaran ? 'Bukti Terlampir' : 'Belum Ada Bukti' }}
            </span>
        </div>

        @if($pesanan->bukti_pembayaran)
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
            {{-- Image Thumbnail with Zoom Hover --}}
            <div class="relative group cursor-pointer overflow-hidden rounded-xl border border-slate-600 bg-slate-900/60 w-full sm:w-64 flex-shrink-0" onclick="openBuktiModal('{{ asset('storage/' . $pesanan->bukti_pembayaran) }}')">
                <img src="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}" 
                     alt="Bukti Transfer QRIS" 
                     class="w-full h-44 sm:h-36 object-contain sm:object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex items-center justify-center transition gap-2 text-white text-xs font-bold">
                    <i class="fas fa-search-plus"></i> Klik untuk Perbesar
                </div>
            </div>

            {{-- Info & Action --}}
            <div class="flex-1 space-y-2.5 w-full">
                <div>
                    <p class="text-xs text-slate-500">Metode Pembayaran</p>
                    <div class="mt-1">
                        <span class="px-2.5 py-1 rounded-lg bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 text-xs font-bold uppercase inline-flex items-center gap-1.5">
                            <i class="fas fa-qrcode"></i> QRIS
                        </span>
                    </div>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Total Nominal Pembayaran</p>
                    <p class="text-xl font-bold text-orange-400 mt-0.5">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                </div>
                <div class="pt-2">
                    <button type="button" onclick="openBuktiModal('{{ asset('storage/' . $pesanan->bukti_pembayaran) }}')"
                        class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-xl text-xs font-bold transition inline-flex items-center gap-1.5 shadow-md">
                        <i class="fas fa-search-plus"></i> Lihat Bukti Penuh
                    </button>
                </div>
            </div>
        </div>
        @else
        <div class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-300 text-xs flex items-center gap-3">
            <i class="fas fa-exclamation-triangle text-base flex-shrink-0 text-amber-400"></i>
            <div>
                <p class="font-bold">Belum ada bukti pembayaran diunggah</p>
                <p class="text-slate-400 mt-0.5">Pesanan ini menggunakan metode QRIS, namun pembeli belum melampirkan foto/screenshot bukti transfer.</p>
            </div>
        </div>
        @endif
    </div>
    @endif

    {{-- Detail Items --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-700">
            <h3 class="font-semibold text-white">Item Pesanan ({{ $pesanan->detailPembelians->count() }} item)</h3>
        </div>
        <div class="divide-y divide-slate-700">
            @foreach($pesanan->detailPembelians as $item)
            <div class="flex items-center justify-between px-5 py-4">
                <div class="flex items-center space-x-3">
                    @if($item->produk && $item->produk->gambar)
                    <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-700 flex-shrink-0">
                        <img src="{{ str_starts_with($item->produk->gambar, 'http') ? $item->produk->gambar : asset('storage/'.$item->produk->gambar) }}"
                             class="w-full h-full object-cover"
                             onerror="this.src='https://via.placeholder.com/48x48/334155/94a3b8?text=P'">
                    </div>
                    @else
                    <div class="w-12 h-12 rounded-xl bg-slate-700 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-utensils text-slate-500"></i>
                    </div>
                    @endif
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <p class="font-medium text-white text-sm">{{ $item->nama_produk }}</p>
                            @if($item->produk && $item->produk->stand)
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-lg bg-orange-500/10 text-orange-400 border border-orange-500/20">
                                <i class="fas fa-store text-[9px] mr-0.5"></i> {{ $item->produk->stand->nama_stand }}
                            </span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-400 mt-0.5">Rp {{ number_format($item->harga, 0, ',', '.') }} × {{ $item->quantity }}</p>
                    </div>
                </div>
                <p class="font-semibold text-white">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>
        <div class="flex justify-between px-5 py-4 bg-slate-700/30 border-t border-slate-700">
            <span class="font-semibold text-slate-300">Total</span>
            <span class="font-bold text-xl text-white">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.pesanans.index') }}"
            class="text-slate-400 hover:text-white text-sm transition">← Kembali ke Daftar Pesanan</a>
        <form method="POST" action="{{ route('admin.pesanans.destroy', $pesanan) }}"
            onsubmit="return confirm('Hapus pesanan ini secara permanen?')">
            @csrf @method('DELETE')
            <button type="submit" class="text-red-400 hover:text-red-300 text-sm transition">
                <i class="fas fa-trash mr-1"></i>Hapus Pesanan
            </button>
        </form>
    </div>

</div>

{{-- Modal Bukti Pembayaran --}}
<div id="buktiModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4" onclick="closeBuktiModal()">
    <div class="relative max-w-2xl w-full bg-slate-800 rounded-2xl border border-slate-700 p-4 shadow-2xl" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between pb-3 border-b border-slate-700 mb-3">
            <h4 class="text-white font-bold text-sm flex items-center gap-2">
                <i class="fas fa-file-invoice text-orange-400"></i> Bukti Pembayaran QRIS
            </h4>
            <button type="button" onclick="closeBuktiModal()" class="w-8 h-8 rounded-lg bg-slate-700 text-slate-300 hover:text-white flex items-center justify-center transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="max-h-[75vh] overflow-auto flex items-center justify-center bg-slate-900 rounded-xl p-2">
            <img id="buktiModalImg" src="" alt="Bukti Transfer" class="max-h-[70vh] w-auto rounded-lg object-contain">
        </div>
        <div class="mt-3 flex justify-end">
            <button type="button" onclick="closeBuktiModal()" class="px-5 py-2 bg-slate-700 hover:bg-slate-600 text-slate-200 text-xs font-bold rounded-xl transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
function openBuktiModal(src) {
    document.getElementById('buktiModalImg').src = src;
    const modal = document.getElementById('buktiModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeBuktiModal() {
    const modal = document.getElementById('buktiModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>

@endsection
