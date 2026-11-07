<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Kantin Digital SMKN 1 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .hero-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .btn-primary {
            background: linear-gradient(45deg, #f59e0b, #f97316);
            color: white;
            transition: all 0.3s ease;
        }
        .btn-orange-gradient {
            background: linear-gradient(45deg, #f59e0b, #f97316);
            color: white;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);
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
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Keranjang Belanja - Kantin Digital SMKN 20 Jakarta</h1>
            <p class="text-gray-600">Kelola pesanan Anda</p>
        </div>

        @if(count($cart) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Daftar Produk -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cart as $productId => $item)
                        <div class="bg-white rounded-lg shadow-lg p-4">
                            <div class="flex items-center space-x-4">
                                <!-- Foto Produk -->
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover rounded-lg">
                                
                                <!-- Info Produk -->
                                <div class="flex-1">
                                    <h4 class="font-bold text-lg text-gray-800">{{ $item['name'] }}</h4>
                                    <p class="text-sm text-gray-600 mb-2">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                    
                                    <!-- Tombol Aksi -->
                                    <div class="flex space-x-2">
                                        @if($item['quantity'] > 0)
                                            <button onclick="updateQuantity('{{ $productId }}', {{ $item['quantity'] + 1 }})" 
                                                    class="bg-gray-200 text-gray-700 w-8 h-8 rounded-full hover:bg-gray-300 transition">
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                        @endif
                                        <span class="font-semibold text-lg w-12 text-center">{{ $item['quantity'] }}</span>
                                        @if($item['quantity'] > 1)
                                            <button onclick="updateQuantity('{{ $productId }}', {{ $item['quantity'] - 1 }})" 
                                                    class="bg-gray-200 text-gray-700 w-8 h-8 rounded-full hover:bg-gray-300 transition">
                                                <i class="fas fa-minus text-xs"></i>
                                            </button>
                                        @endif
                                        
                                        <button onclick="removeFromCart('{{ $productId }}')" 
                                                class="ml-4 text-red-500 hover:text-red-700 transition">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Subtotal -->
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">Subtotal</p>
                                    <p class="text-xl font-bold text-blue-600">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Ringkasan Pesanan -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-lg p-6 sticky top-4">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Ringkasan Pesanan</h3>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Items:</span>
                                <span class="font-semibold">{{ array_sum(array_column($cart, 'quantity')) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-semibold">Rp {{ number_format(array_sum(array_map(function($item) { return $item['price'] * $item['quantity']; }, $cart)), 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ongkos Kirim:</span>
                                <span class="font-semibold">Rp 0</span>
                            </div>
                        </div>
                        
                        <div class="border-t pt-4">
                            <div class="flex justify-between mb-4">
                                <span class="text-lg font-bold">Total:</span>
                                <span class="text-xl font-bold text-blue-600">Rp {{ number_format(array_sum(array_map(function($item) { return $item['price'] * $item['quantity']; }, $cart)), 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="flex space-x-2">
                                <a href="{{ url('/stands') }}" class="block w-full bg-gray-200 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-300 transition text-center mt-2">
                                    <i class="fas fa-arrow-left mr-2"></i>Lanjut Belanja
                                </a>
                                <a href="{{ route('pembelians.payment') }}" class="block w-full btn-primary py-4 rounded-lg font-bold text-lg text-center mt-2 border-0 inline-block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 shadow-lg">
                                    <i class="fas fa-credit-card mr-2"></i>Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-lg">
                <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Keranjang Belanja Kosong</h3>
                <p class="text-gray-500 mb-4">Belum ada produk di keranjang Anda</p>
                <a href="{{ url('/stands') }}" class="btn-primary px-8 py-4 rounded-lg font-bold text-lg inline-block border-0 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 shadow-lg">
                    <i class="fas fa-store mr-2"></i>Mulai Belanja
                </a>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Kantin Digital SMKN 20 Jakarta. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updateQuantity(productId, quantity) {
            if(quantity < 1) {
                removeFromCart(productId);
                return;
            }
            
            $.ajax({
                url: '/cart/update',
                method: 'POST',
                data: {
                    product_id: productId,
                    quantity: quantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        }
        
        function removeFromCart(productId) {
            if(confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')) {
                $.ajax({
                    url: '/cart/remove',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function() {
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                });
            }
        }
    </script>
</body>
</html>
