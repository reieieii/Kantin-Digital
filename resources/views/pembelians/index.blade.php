<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya — Kantin Digital SMKN 20 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .hero-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .btn-orange { background: linear-gradient(45deg, #f59e0b, #f97316); }
        .badge-pending    { background:#fef3c7; color:#92400e; }
        .badge-diproses   { background:#dbeafe; color:#1e40af; }
        .badge-selesai    { background:#d1fae5; color:#065f46; }
        .badge-dibatalkan { background:#fee2e2; color:#991b1b; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    {{-- ── NAVBAR ────────────────────────────────────────────────────────── --}}
    <nav class="fixed top-0 w-full z-50 hero-gradient shadow-lg">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('landing') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-utensils text-white text-sm"></i>
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-white font-black text-base leading-tight">Kantin Digital</p>
                        <p class="text-purple-200 text-xs font-medium">BEST SCHOOL CANTEEN</p>
                    </div>
                </a>
                <div class="flex items-center gap-3">
                    <a href="{{ route('landing') }}" class="text-white/80 hover:text-white text-sm font-medium transition">Beranda</a>
                    <a href="{{ route('stands.index') }}" class="text-white/80 hover:text-white text-sm font-medium transition">Daftar Stand</a>
                    @auth
                        <a href="{{ route('pembelians.index') }}"
                            class="btn-orange text-sm font-black text-white px-5 py-2.5 rounded-xl hover:scale-105 transition-all shadow-md">
                            <i class="fas fa-receipt mr-2"></i>Pesanan Saya
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="btn-orange text-sm font-black text-white px-5 py-2.5 rounded-xl hover:scale-105 transition-all shadow-md">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- ── CONTENT ────────────────────────────────────────────────────────── --}}
    <main class="flex-1 container mx-auto px-4 pt-28 pb-12 max-w-3xl">

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 hero-gradient rounded-xl flex items-center justify-center">
                    <i class="fas fa-receipt text-white text-sm"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-gray-800">Pesanan Saya</h1>
                    <p class="text-gray-500 text-sm">Halo, <strong>{{ Auth::user()->name }}</strong> — berikut riwayat pesananmu</p>
                </div>
            </div>
        </div>

        {{-- Flash --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Daftar Pesanan --}}
        @if($pembelians->count() > 0)
            <div class="space-y-4">
                @foreach($pembelians as $p)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">

                    {{-- Header card --}}
                    <div class="flex items-center justify-between px-5 py-3 bg-gray-50 border-b border-gray-100">
                        <span class="text-xs font-mono font-bold text-gray-500">{{ $p->kode_pembelian }}</span>
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full badge-{{ $p->status }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </div>

                    {{-- Item produk --}}
                    <div class="px-5 py-4">
                        @foreach($p->detailPembelians as $d)
                        <div class="flex items-center gap-3 {{ !$loop->last ? 'mb-3 pb-3 border-b border-gray-50' : '' }}">
                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                                @if($d->produk && $d->produk->gambar)
                                    <img src="{{ str_starts_with($d->produk->gambar, 'http') ? $d->produk->gambar : asset('storage/'.$d->produk->gambar) }}"
                                         alt="{{ $d->nama_produk }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-utensils text-gray-300 text-sm"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 text-sm truncate">{{ $d->nama_produk }}</p>
                                <p class="text-gray-400 text-xs">{{ $d->quantity }}x &times; Rp {{ number_format($d->harga, 0, ',', '.') }}</p>
                            </div>
                            <p class="font-bold text-gray-700 text-sm whitespace-nowrap">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>

                    {{-- Footer card --}}
                    <div class="flex items-center justify-between px-5 py-3 bg-gray-50 border-t border-gray-100">
                        <div class="text-xs text-gray-400 flex items-center gap-3">
                            <span><i class="fas fa-clock mr-1"></i>{{ $p->created_at->format('d/m/Y H:i') }}</span>
                            <span class="capitalize">
                                <i class="fas fa-{{ $p->metode_pembayaran === 'qris' ? 'qrcode' : 'money-bill' }} mr-1"></i>
                                {{ strtoupper($p->metode_pembayaran) }}
                            </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-black text-purple-600">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span>
                            <a href="{{ route('pembelians.show', $p->id) }}"
                                class="text-xs font-bold text-purple-600 hover:text-purple-800 transition border border-purple-200 px-3 py-1 rounded-lg hover:bg-purple-50">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($pembelians->hasPages())
                <div class="mt-6">{{ $pembelians->links() }}</div>
            @endif

        @else
            {{-- Empty state --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 py-16 text-center">
                <div class="w-20 h-20 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-receipt text-3xl text-purple-300"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-600 mb-2">Belum ada pesanan</h3>
                <p class="text-gray-400 text-sm mb-6">Kamu belum pernah memesan apapun. Yuk mulai pesan!</p>
                <a href="{{ route('stands.index') }}"
                    class="inline-flex items-center gap-2 hero-gradient text-white font-bold px-6 py-3 rounded-xl hover:opacity-90 transition text-sm">
                    <i class="fas fa-store"></i> Lihat Stand Kantin
                </a>
            </div>
        @endif

    </main>

    {{-- ── FOOTER ────────────────────────────────────────────────────────── --}}
    <footer class="bg-gray-800 text-white py-6 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p class="text-sm text-gray-400">&copy; 2024 Kantin Digital SMKN 20 Jakarta. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
