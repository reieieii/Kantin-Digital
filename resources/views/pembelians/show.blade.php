<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembelian - Kantin Digital SMKN 20 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }

        /* Sembunyikan scrollbar tapi tetap bisa scroll */
        html, body {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        html::-webkit-scrollbar,
        body::-webkit-scrollbar {
            display: none;
            width: 0;
            height: 0;
        }

        .hero-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .btn-orange-gradient {
            background: linear-gradient(45deg, #f59e0b, #f97316);
            color: white;
            transition: all 0.3s ease;
        }
        .badge-pending    { background:#fef3c7; color:#92400e; }
        .badge-diproses   { background:#dbeafe; color:#1e40af; }
        .badge-dapat_diambil, .badge-dapat-diambil { background:#e0e7ff; color:#3730a3; }
        .badge-selesai    { background:#d1fae5; color:#065f46; }
        .badge-dibatalkan { background:#fee2e2; color:#991b1b; }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="hero-gradient text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('landing') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                            <i class="fas fa-utensils text-orange-500"></i>
                        </div>
                        <div class="hidden sm:block">
                            <span class="text-white font-black text-xl tracking-tight">Kantin Digital</span>
                            <p class="text-[10px] text-white/70 font-bold uppercase tracking-widest leading-none">Best School Canteen</p>
                        </div>
                    </a>
                </div>
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/') }}" class="text-base font-bold text-white/80 hover:text-white transition-colors">Beranda</a>
                    <a href="{{ url('/stands') }}" class="text-base font-bold text-white/80 hover:text-white transition-colors">Daftar Stand</a>
                    <a href="{{ url('/cart') }}" class="relative text-white/80 hover:text-white transition-all p-2 bg-white/10 rounded-xl border border-white/10 group">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        @php $cartCount = count(session('cart', [])); @endphp
                        <span class="absolute -top-1 -right-1 bg-gradient-to-br from-orange-400 to-orange-600 text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm">{{ $cartCount }}</span>
                    </a>
                    <a href="{{ url('/pembelians') }}" class="btn-orange-gradient text-sm font-black text-white px-6 py-2.5 rounded-xl hover:scale-105 transition-all shadow-md hover:shadow-lg shadow-orange-900/20 text-center">
                        <i class="fas fa-receipt mr-2"></i>Pesanan Saya
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($pembelian->status === 'dapat_diambil')
            <div class="bg-indigo-50 border-2 border-indigo-300 text-indigo-900 px-5 py-4 rounded-xl mb-6 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-bag-shopping text-lg"></i>
                </div>
                <div>
                    <h4 class="font-bold text-sm text-indigo-900">Pesanan Sudah Dapat Diambil!</h4>
                    <p class="text-xs text-indigo-700">Silakan kunjungi stand kantin dan tunjukkan kode pesanan <strong>{{ $pembelian->kode_pembelian }}</strong> untuk mengambil hidanganmu.</p>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Detail Pembelian</h1>
                <p class="text-gray-600">Informasi lengkap pesanan pelanggan</p>
            </div>

            {{-- Stepper Status Pesanan --}}
            @if($pembelian->status !== 'dibatalkan')
                @php
                    $steps = [
                        'pending' => ['label' => 'Menunggu Konfirmasi', 'icon' => 'fa-clock'],
                        'diproses' => ['label' => 'Sedang Diproses', 'icon' => 'fa-fire-burner'],
                        'dapat_diambil' => ['label' => 'Dapat Diambil', 'icon' => 'fa-bag-shopping'],
                        'selesai' => ['label' => 'Selesai', 'icon' => 'fa-check-circle'],
                    ];
                    $orderMap = ['pending' => 1, 'diproses' => 2, 'dapat_diambil' => 3, 'selesai' => 4];
                    $currIndex = $orderMap[$pembelian->status] ?? 1;
                @endphp
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 sm:p-6 mb-8">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        @foreach($steps as $k => $step)
                            @php
                                $sIndex = $orderMap[$k];
                                $isDone = $sIndex < $currIndex;
                                $isCurrent = $sIndex === $currIndex;
                            @endphp
                            <div class="flex flex-col items-center text-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold mb-2 shadow-sm
                                    {{ $isCurrent ? 'bg-indigo-600 text-white ring-4 ring-indigo-100' : ($isDone ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-400') }}">
                                    <i class="fas {{ $isDone ? 'fa-check' : $step['icon'] }}"></i>
                                </div>
                                <span class="text-xs font-bold {{ $isCurrent ? 'text-indigo-600' : ($isDone ? 'text-emerald-600' : 'text-gray-400') }}">
                                    {{ $step['label'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Info Pembelian -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Pembelian</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Kode Pembelian:</span>
                        <span class="font-semibold">{{ $pembelian->kode_pembelian }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nama Pembeli:</span>
                        <span class="font-semibold">{{ $pembelian->nama_pembeli }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Email:</span>
                        <span class="font-semibold">{{ $pembelian->email ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">No. Telepon:</span>
                        <span class="font-semibold">{{ $pembelian->no_telepon ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Kelas:</span>
                        <span class="font-semibold">{{ $pembelian->alamat ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Metode Pembayaran:</span>
                        <span class="font-bold text-gray-800 uppercase">{{ $pembelian->metode_pembayaran ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Harga:</span>
                        <span class="font-bold text-xl text-blue-600">Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        @if($pembelian->status == 'pending')
                            <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        @elseif($pembelian->status == 'diproses')
                            <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Diproses
                            </span>
                        @elseif($pembelian->status == 'dapat_diambil')
                            <span class="px-2.5 py-1 inline-flex items-center gap-1.5 text-xs leading-5 font-bold rounded-full bg-indigo-100 text-indigo-800 border border-indigo-200">
                                <i class="fas fa-bag-shopping"></i> Dapat Diambil
                            </span>
                        @elseif($pembelian->status == 'selesai')
                            <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Selesai
                            </span>
                        @elseif($pembelian->status == 'dibatalkan')
                            <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Dibatalkan
                            </span>
                        @endif
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tanggal:</span>
                        <span class="font-semibold">{{ $pembelian->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @if($pembelian->catatan)
                        <div class="mt-4">
                            <span class="text-gray-600">Catatan:</span>
                            <p class="mt-2 text-gray-800 bg-gray-100 p-3 rounded">{{ $pembelian->catatan }}</p>
                        </div>
                    @endif

                    @if($pembelian->bukti_pembayaran)
                        <div class="mt-5 pt-5 border-t border-gray-200">
                            <span class="text-gray-700 font-bold block mb-2 text-sm flex items-center gap-1.5">
                                <i class="fas fa-file-invoice text-indigo-600"></i> Bukti Pembayaran QRIS:
                            </span>
                            <div class="max-w-xs">
                                <a href="{{ asset('storage/' . $pembelian->bukti_pembayaran) }}" target="_blank" class="block group relative overflow-hidden rounded-xl border-2 border-indigo-100 shadow-sm">
                                    <img src="{{ asset('storage/' . $pembelian->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="w-full h-44 object-cover group-hover:scale-105 transition duration-300">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs font-bold transition gap-1">
                                        <i class="fas fa-external-link-alt"></i> Lihat Penuh
                                    </div>
                                </a>
                                <p class="text-[11px] text-gray-400 mt-1 italic">*Klik gambar untuk melihat resolusi penuh</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Detail Produk -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Detail Produk</h2>
            @if($pembelian->detailPembelians->count() > 0)
                <div class="space-y-4">
                    @foreach($pembelian->detailPembelians as $detail)
                        <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                            @php
                                $itemImg = 'https://via.placeholder.com/80x80?text=Food';
                                if ($detail->produk && $detail->produk->gambar) {
                                    $itemImg = str_starts_with($detail->produk->gambar, 'http') ? $detail->produk->gambar : asset('storage/' . $detail->produk->gambar);
                                }
                            @endphp
                            <img src="{{ $itemImg }}" alt="{{ $detail->nama_produk }}" class="w-20 h-20 object-cover rounded-lg" onerror="this.src='https://via.placeholder.com/80x80?text=Food'">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">{{ $detail->nama_produk }}</h3>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-gray-600">Qty: {{ $detail->quantity }}</span>
                                    <span class="text-gray-600">Rp {{ number_format($detail->harga, 0, ',', '.') }} x {{ $detail->quantity }}</span>
                                    <span class="font-bold text-blue-600">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Tidak ada detail produk</p>
                </div>
            @endif
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('pembelians.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Pembelian
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Kantin Digital SMKN 20 Jakarta. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
