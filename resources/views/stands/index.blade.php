<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Stand - Kantin Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .hero-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .btn-orange-gradient {
            background: linear-gradient(45deg, #f59e0b, #f97316);
            color: white;
            transition: all 0.3s ease;
        }
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50">
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
                        <span id="cart-count" class="absolute -top-1 -right-1 bg-gradient-to-br from-orange-400 to-orange-600 text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm">0</span>
                    </a>
                    <a href="{{ url('/pembelians') }}" class="btn-orange-gradient text-sm font-black text-white px-6 py-2.5 rounded-xl hover:scale-105 transition-all shadow-md hover:shadow-lg shadow-orange-900/20 text-center">
                        <i class="fas fa-receipt mr-2"></i>Pesanan Saya
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-6 py-12">
        <div class="mb-12">
            <h2 class="text-2xl md:text-3xl font-black mb-2 tracking-tight leading-tight"
                style="font-family:'Poppins',sans-serif; background: linear-gradient(135deg,#667eea 0%,#764ba2 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">
                Daftar Stand Kantin
            </h2>
            <p class="text-slate-500 text-sm font-medium" style="font-family:'Poppins',sans-serif;">
                Pilih stand favoritmu dan nikmati hidangan lezat hari ini
            </p>
        </div>

        @if($stands->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($stands as $stand)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 cursor-pointer flex flex-col"
                         onclick="window.location.href='{{ route('stands.show', $stand->id) }}'">

                        <!-- Foto Stand -->
                        <div class="relative">
                            @php
                                $standImg = null;
                                if (!empty($stand->gambar)) {
                                    if (str_starts_with($stand->gambar, 'http')) {
                                        if (str_contains($stand->gambar, 'via.placeholder.com') || str_contains($stand->gambar, 'placeholder')) {
                                            $standImg = null;
                                        } else {
                                            $standImg = $stand->gambar;
                                        }
                                    } else {
                                        $standImg = asset('storage/' . $stand->gambar);
                                    }
                                }
                                $fallbackImg = 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&q=80&w=800';
                            @endphp
                            <img src="{{ $standImg ?? $fallbackImg }}"
                                 alt="{{ $stand->nama_stand }}"
                                 onerror="this.onerror=null;this.src='{{ $fallbackImg }}';"
                                 class="w-full h-44 object-cover">

                            <!-- Status Badge -->
                            @if($stand->status_buka)
                                <span class="absolute top-2 right-2 bg-green-500 text-white px-2.5 py-1 rounded-full text-xs font-bold shadow">
                                    <i class="fas fa-check-circle mr-1"></i>Buka
                                </span>
                            @else
                                <span class="absolute top-2 right-2 bg-red-500 text-white px-2.5 py-1 rounded-full text-xs font-bold shadow">
                                    <i class="fas fa-times-circle mr-1"></i>Tutup
                                </span>
                            @endif
                        </div>

                        <!-- Info Stand -->
                        <div class="p-5 flex flex-col flex-1">
                            <!-- Nama & Deskripsi -->
                            <h3 class="font-bold text-base text-slate-900 mb-1.5 leading-snug">{{ $stand->nama_stand }}</h3>
                            <p class="text-sm text-slate-500 mb-4 leading-relaxed line-clamp-2">{{ $stand->deskripsi }}</p>

                            <!-- Produk Populer -->
                            <div class="border-t border-slate-100 pt-3 flex-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2.5">Produk Populer</p>
                                @php $produkPopuler = $stand->produks->take(3); @endphp
                                @foreach($produkPopuler as $produk)
                                    <div class="flex justify-between items-start mb-2.5 last:mb-0 gap-2">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $produk->nama_produk }}</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Stok: {{ $produk->stock }} pcs</p>
                                        </div>
                                        <p class="text-sm font-bold text-blue-600 whitespace-nowrap">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Info Pemilik -->
                            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between gap-1">
                                <div class="flex items-center gap-1.5 text-slate-500 min-w-0">
                                    <i class="fas fa-user-circle text-sm flex-shrink-0"></i>
                                    <span class="text-sm font-semibold uppercase tracking-wide truncate">{{ $stand->pemilik }}</span>
                                </div>
                                <div class="flex items-center gap-1.5 text-blue-500 flex-shrink-0">
                                    <i class="fas fa-phone-alt text-xs"></i>
                                    <span class="text-sm font-bold">{{ $stand->no_telepon }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-store-slash text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum ada stand tersedia</h3>
                <p class="text-sm text-gray-500">Silakan hubungi admin untuk menambahkan stand</p>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Kantin Digital SMKN 20 Jakarta. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
