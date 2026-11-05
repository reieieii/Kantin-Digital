<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Favorit - Kantin Digital SMKN 20 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .hero-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .btn-orange-gradient {
            background: linear-gradient(45deg, #f59e0b, #f97316);
            color: white;
            transition: all 0.3s ease;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }
        .btn-buy {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Header -->
    <header class="hero-gradient text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('landing') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-utensils text-orange-500"></i>
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-white font-black text-xl tracking-tight">Kantin Digital</span>
                        <p class="text-[10px] text-white/70 font-bold uppercase tracking-widest leading-none">Best School Canteen</p>
                    </div>
                </a>

                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/') }}" class="text-base font-bold text-white/80 hover:text-white transition-colors">Beranda</a>
                    <a href="{{ url('/stands') }}" class="text-base font-bold text-white/80 hover:text-white transition-colors">Daftar Stand</a>
                    <a href="{{ url('/cart') }}" class="relative text-white/80 hover:text-white transition-all p-2 bg-white/10 rounded-xl border border-white/10">
                        <i class="fas fa-shopping-cart text-lg"></i>
                    </a>
                    <a href="{{ url('/pembelians') }}" class="btn-orange-gradient text-sm font-black text-white px-6 py-2.5 rounded-xl hover:scale-105 transition-all shadow-md text-center">
                        <i class="fas fa-receipt mr-2"></i>Pesanan Saya
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Breadcrumb -->
    <div class="max-w-7xl mx-auto px-6 py-4">
        <nav class="flex items-center space-x-3 text-xs font-bold uppercase tracking-widest">
            <a href="{{ route('landing') }}" class="text-slate-400 hover:text-blue-600 transition-colors">Beranda</a>
            <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
            <span class="text-blue-600">Menu Favorit</span>
        </nav>
    </div>

    <!-- Main -->
    <main class="max-w-7xl mx-auto px-6 pb-16">

        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-gradient-to-br from-red-400 to-pink-600 rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas fa-heart text-white text-base"></i>
                </div>
                <h1 class="text-2xl font-bold text-slate-900">Menu Favorit Saya</h1>
            </div>
            <p class="text-slate-500 text-sm ml-13">
                {{ $favorits->count() }} menu tersimpan · Menu yang tidak tersedia akan ditandai otomatis
            </p>
        </div>

        @if($favorits->count() > 0)

            <!-- Grid Produk Favorit -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($favorits as $favorit)
                    @php
                        $produk  = $favorit->produk;
                        $tersedia = $produk && $produk->tersedia && $produk->stock > 0;

                        // Gambar produk
                        $foodPlaceholders = [
                            'https://images.unsplash.com/photo-1569050467447-ce54b3bbc37d?auto=format&fit=crop&q=80&w=500',
                            'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&q=80&w=500',
                            'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&q=80&w=500',
                            'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&q=80&w=500',
                            'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=500',
                            'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&q=80&w=500',
                            'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&q=80&w=500',
                            'https://images.unsplash.com/photo-1482049016688-2d3e1b311543?auto=format&fit=crop&q=80&w=500',
                            'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&q=80&w=500',
                        ];
                        $dbImg = $produk->gambar ?? '';
                        $isLocal = !empty($dbImg) && !str_starts_with($dbImg, 'http') && file_exists(public_path('storage/' . $dbImg));
                        $produkImg = $isLocal
                            ? asset('storage/' . $dbImg)
                            : $foodPlaceholders[$produk->id % count($foodPlaceholders)];
                    @endphp

                    <div class="bg-white rounded-2xl overflow-hidden border border-slate-100 card-hover flex flex-col {{ !$tersedia ? 'opacity-75' : '' }}">

                        <!-- Gambar -->
                        <div class="relative h-44 overflow-hidden p-2 pb-0">
                            <div class="w-full h-full overflow-hidden rounded-xl relative">
                                <img src="{{ $produkImg }}"
                                     alt="{{ $produk->nama_produk }}"
                                     class="w-full h-full object-cover {{ !$tersedia ? 'grayscale' : '' }} transition-all duration-300">
                                @if(!$tersedia)
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center rounded-xl">
                                        <span class="bg-red-500 text-white text-xs font-black px-3 py-1 rounded-full uppercase tracking-widest">
                                            <i class="fas fa-times-circle mr-1"></i>Stok Tidak Ada
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Badge status -->
                            <div class="absolute top-4 left-4 z-10">
                                @if($tersedia)
                                    <span class="bg-white/95 text-green-600 px-3 py-1 rounded-full text-xs font-black uppercase tracking-widest shadow-md border border-white">
                                        <i class="fas fa-check-circle mr-1"></i>Tersedia
                                    </span>
                                @else
                                    <span class="bg-white/95 text-red-500 px-3 py-1 rounded-full text-xs font-black uppercase tracking-widest shadow-md border border-white">
                                        <i class="fas fa-clock mr-1"></i>Tidak Ada
                                    </span>
                                @endif
                            </div>

                            <!-- Tombol hapus favorit -->
                            <button
                                onclick="hapusFavorit(this, {{ $produk->id }})"
                                title="Hapus dari favorit"
                                class="absolute top-4 right-4 w-9 h-9 bg-red-500 text-white rounded-xl flex items-center justify-center shadow-md hover:bg-red-600 hover:scale-110 transition-all duration-200 z-10">
                                <i class="fas fa-heart text-sm"></i>
                            </button>
                        </div>

                        <!-- Info Produk -->
                        <div class="p-4 flex flex-col flex-1">
                            <div class="flex justify-between items-center mb-2">
                                <span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded-md text-xs font-bold uppercase tracking-wider">
                                    {{ $produk->kategori }}
                                </span>
                                @if($produk->stand)
                                    <span class="text-xs text-slate-400 font-medium truncate max-w-[120px]">
                                        {{ $produk->stand->nama_stand }}
                                    </span>
                                @endif
                            </div>

                            <h4 class="text-sm font-bold text-slate-900 mb-1 line-clamp-1">{{ $produk->nama_produk }}</h4>
                            <p class="text-xs text-slate-400 mb-3 leading-relaxed line-clamp-2">{{ $produk->deskripsi }}</p>

                            <div class="mt-auto">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Harga</p>
                                        <p class="text-base font-bold text-slate-900">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Stok</p>
                                        <p class="text-xs font-bold {{ $tersedia ? 'text-slate-800' : 'text-red-500' }}">
                                            {{ $produk->stock > 0 ? $produk->stock . ' pcs' : 'Habis' }}
                                        </p>
                                    </div>
                                </div>

                                @if($tersedia && $produk->stand)
                                    <a href="{{ route('stands.show', $produk->stand->id) }}"
                                       class="block w-full btn-buy text-white text-xs font-black py-2.5 rounded-xl text-center shadow-md hover:opacity-90 transition-all uppercase tracking-widest">
                                        <i class="fas fa-store mr-1.5"></i>Pesan di Stand
                                    </a>
                                @else
                                    <button disabled
                                        class="w-full bg-slate-100 text-slate-400 text-xs font-black py-2.5 rounded-xl cursor-not-allowed uppercase tracking-widest">
                                        <i class="fas fa-clock mr-1.5"></i>Sedang Tidak Tersedia
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-pink-50 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-inner">
                    <i class="far fa-heart text-4xl text-pink-300"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-700 mb-3">Belum Ada Menu Favorit</h3>
                <p class="text-slate-400 text-sm mb-8 max-w-sm mx-auto leading-relaxed">
                    Temukan menu favoritmu di daftar stand dan klik ikon ❤️ untuk menyimpannya di sini.
                </p>
                <a href="{{ route('stands.index') }}"
                   class="inline-flex items-center gap-2 btn-buy text-white px-8 py-3 rounded-xl font-bold text-sm shadow-lg hover:opacity-90 transition-all">
                    <i class="fas fa-store"></i>Jelajahi Stand
                </a>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-8">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-sm">&copy; 2024 Kantin Digital SMKN 20 Jakarta. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function hapusFavorit(btn, produkId) {
            $.ajax({
                url: '{{ route("favorit.toggle") }}',
                method: 'POST',
                data: { _token: '{{ csrf_token() }}', produk_id: produkId },
                success: function(res) {
                    // Hapus card dari DOM dengan animasi
                    const card = btn.closest('.card-hover, [class*="bg-white"]');
                    if (card) {
                        card.style.transition = 'all 0.3s ease';
                        card.style.opacity   = '0';
                        card.style.transform = 'scale(0.9)';
                        setTimeout(() => {
                            card.remove();
                            // Update jumlah
                            const countEl = document.querySelector('[data-fav-count]');
                            if (countEl) countEl.textContent = res.count;
                            // Kalau sudah kosong, reload untuk tampil empty state
                            if (res.count === 0) location.reload();
                        }, 300);
                    }
                }
            });
        }
    </script>
</body>
</html>
