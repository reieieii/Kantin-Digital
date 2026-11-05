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
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
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
            color: white;
        }
        
        .bg-blue-600 { background-color: #2563eb; }
        .bg-blue-700 { background-color: #1d4ed8; }
        .bg-blue-100 { background-color: #dbeafe; }
        .text-blue-600 { color: #2563eb; }
        .text-blue-700 { color: #1d4ed8; }
        .text-white { color: white; }
        .text-gray-800 { color: #1f2937; }
        .text-gray-600 { color: #4b5563; }
        .text-gray-700 { color: #374151; }
        .text-gray-500 { color: #6b7280; }
        .bg-white { background-color: white; }
        .bg-gray-100 { background-color: #f3f4f6; }
        .bg-gray-200 { background-color: #e5e7eb; }
        .bg-red-500 { background-color: #ef4444; }
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        .rounded-lg { border-radius: 0.5rem; }
        .rounded-full { border-radius: 9999px; }
        .p-4 { padding: 1rem; }
        .p-6 { padding: 1.5rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mb-8 { margin-bottom: 2rem; }
        .text-sm { font-size: 0.875rem; font-weight: 400; }
        .text-base { font-size: 1rem; font-weight: 500; }
        .text-lg { font-size: 1.125rem; font-weight: 500; }
        .text-xl { font-size: 1.25rem; font-weight: 600; }
        .text-2xl { font-size: 1.5rem; font-weight: 700; }
        .font-bold { font-weight: 700; }
        .font-semibold { font-weight: 600; }
        .font-medium { font-weight: 500; }
        .hover:bg-blue-700:hover { background-color: #1d4ed8; }
        .hover:bg-gray-300:hover { background-color: #d1d5db; }
        .hover:text-red-500:hover { color: #ef4444; }
        .transition { transition: all 0.3s ease; }
        .cursor-pointer { cursor: pointer; }
        .w-full { width: 100%; }
        .w-8 { width: 2rem; }
        .w-12 { width: 3rem; }
        .h-20 { height: 5rem; }
        .object-cover { object-fit: cover; }
        .rounded-lg { border-radius: 0.5rem; }
        .overflow-hidden { overflow: hidden; }
        .relative { position: relative; }
        .absolute { position: absolute; }
        .top-2 { top: 0.5rem; }
        .right-2 { right: 0.5rem; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .space-x-4 > * + * { margin-left: 1rem; }
        .space-y-4 > * + * { margin-top: 1rem; }
        .space-x-2 > * + * { margin-left: 0.5rem; }
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .gap-6 { gap: 1.5rem; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 1rem; }
        .sticky { position: sticky; top: 4rem; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="hero-gradient text-white shadow-lg">
        <div class="container py-4">
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
                    <a href="{{ url('/cart') }}" class="relative text-white/80 hover:text-white transition-all p-2 group" style="background:rgba(255,255,255,0.1); border-radius:0.75rem; border:1px solid rgba(255,255,255,0.1); display:inline-flex; align-items:center; justify-content:center; width:2.5rem; height:2.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <span id="cart-count" class="absolute -top-1 -right-1 text-white font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm" style="background:linear-gradient(135deg,#f97316,#ea580c); font-size:10px;">0</span>
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
