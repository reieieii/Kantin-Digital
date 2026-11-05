<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Kantin Digital SMKN 20 Jakarta</title>
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
        .btn-orange-gradient {
            background: linear-gradient(45deg, #f59e0b, #f97316);
            color: white;
            transition: all 0.3s ease;
        }
        .bg-blue-600 { background-color: #2563eb; }
        .bg-blue-700 { background-color: #1d4ed8; }
        .bg-blue-100 { background-color: #dbeafe; }
        .bg-green-500 { background-color: #10b981; }
        .bg-green-100 { background-color: #dcfce7; }
        .bg-gray-100 { background-color: #f3f4f6; }
        .bg-gray-200 { background-color: #e5e7eb; }
        .text-blue-600 { color: #2563eb; }
        .text-blue-700 { color: #1d4ed8; }
        .text-green-600 { color: #059669; }
        .text-green-700 { color: #047857; }
        .text-white { color: white; }
        .text-gray-800 { color: #1f2937; }
        .text-gray-600 { color: #4b5563; }
        .text-gray-500 { color: #6b7280; }
        .bg-white { background-color: white; }
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
        .text-2xl { font-size: 1.5rem; font-weight: 600; }
        .text-3xl { font-size: 1.875rem; font-weight: 700; }
        .w-full { width: 100%; }
        .border { border: 1px solid #e5e7eb; }
        .border-gray-300 { border-color: #d1d5db; }
        .hover\:bg-blue-700:hover { background-color: #1d4ed8; }
        .hover\:bg-green-600:hover { background-color: #059669; }
        .transition { transition: all 0.3s ease; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-4 { gap: 1rem; }
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .lg\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .space-y-4 > * + * { margin-top: 1rem; }
        .space-y-6 > * + * { margin-top: 1.5rem; }
        .h-16 { height: 4rem; }
        .h-20 { height: 5rem; }
        .h-24 { height: 6rem; }
        .w-16 { width: 4rem; }
        .w-20 { width: 5rem; }
        .w-24 { width: 6rem; }
        .object-cover { object-fit: cover; }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <header class="hero-gradient text-white shadow-lg">
        <div class="container mx-auto py-4">
            <div class="flex justify-between items-center px-4">
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
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('landing') }}" class="text-base font-bold text-white/80 hover:text-white transition-colors">Beranda</a>
                    <a href="{{ route('stands.index') }}" class="text-base font-bold text-white/80 hover:text-white transition-colors">Daftar Stand</a>
                    <a href="{{ route('cart.index') }}" class="relative text-white/80 hover:text-white transition-all p-2 bg-white/10 rounded-xl border border-white/10 group">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        <span id="cart-count" class="absolute -top-1 -right-1 bg-gradient-to-br from-orange-400 to-orange-600 text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm">0</span>
                    </a>
                    <a href="{{ route('pembelians.index') }}" class="btn-orange-gradient text-sm font-black text-white px-6 py-2.5 rounded-xl hover:scale-105 transition-all shadow-md hover:shadow-lg shadow-orange-900/20 text-center">
                        <i class="fas fa-receipt mr-2"></i>Pesanan Saya
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto p-6">
        <!-- Flash Messages -->
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Checkout</h1>
            <p class="text-gray-600">Lengkapi data diri Anda untuk menyelesaikan pesanan</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Form Data Pembeli -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Data Pembeli</h2>
                <form action="{{ route('pembelians.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Nama Lengkap *</label>
                        <input type="text" name="nama_pembeli" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                        <input type="email" name="email" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">No. Telepon</label>
                        <input type="tel" name="no_telepon" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Kelas</label>
                        <textarea name="alamat" rows="3" placeholder="Contoh: XII RPL 1"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Catatan</label>
                        <textarea name="catatan" rows="2" placeholder="Catatan khusus untuk pesanan Anda..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </form>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h2>
                
                @if(empty($cartItems))
                    <div class="text-center py-8">
                        <i class="fas fa-shopping-cart text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-600">Keranjang belanja kosong</p>
                        <a href="{{ route('stands.index') }}" class="inline-block mt-4 bg-blue-600 text-white px-8 py-4 rounded-lg hover:bg-blue-700 transition font-bold text-lg shadow-lg">
                            <i class="fas fa-shopping-bag mr-2"></i>Mulai Belanja
                        </a>
                    </div>
                @else
                    <!-- Daftar Produk -->
                    <div class="space-y-3 mb-6 max-h-96 overflow-y-auto">
                        @foreach($cartItems as $item)
                            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                                <img src="{{ asset('storage/' . $item['gambar']) }}" 
                                     alt="{{ $item['nama_produk'] }}"
                                     class="w-16 h-16 object-cover rounded-lg"
                                     onerror="this.src='https://via.placeholder.com/64x64?text=No+Image'">
                                
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">{{ $item['nama_produk'] }}</h3>
                                    <p class="text-sm text-gray-600">{{ $item['quantity'] }} x Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                                </div>
                                
                                <div class="text-right">
                                    <p class="font-semibold text-gray-800">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Total -->
                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg font-semibold text-gray-800">Total:</span>
                            <span class="text-xl font-bold text-blue-600">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                        </div>

                        <!-- Tombol Checkout -->
                        <button type="submit" form="checkout-form" 
                                class="w-full bg-green-500 text-white py-4 rounded-lg font-bold text-lg hover:bg-green-600 transition shadow-lg">
                            <i class="fas fa-check-circle mr-2"></i>Buat Pesanan
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Hidden form untuk submit -->
        <form id="checkout-form" action="{{ route('pembelians.store') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <script>
        // Copy form data ke hidden form saat tombol checkout diklik
        document.querySelector('button[form="checkout-form"]').addEventListener('click', function() {
            const mainForm = document.querySelector('form[action="{{ route("pembelians.store") }}"]');
            const hiddenForm = document.getElementById('checkout-form');
            
            // Copy all form data
            const formData = new FormData(mainForm);
            for (let [key, value] of formData.entries()) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = value;
                hiddenForm.appendChild(input);
            }
            
            hiddenForm.submit();
        });
    </script>
</body>
</html>
        .text-2xl { font-size: 1.5rem; font-weight: 700; }
        .text-3xl { font-size: 1.875rem; font-weight: 700; }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }
        .hover:bg-blue-700:hover { background-color: #1d4ed8; }
        .transition { transition: all 0.3s ease; }
        .cursor-pointer { cursor: pointer; }
        .w-full { width: 100%; }
        .w-20 { width: 5rem; }
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
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .gap-6 { gap: 1.5rem; }
        .border { border: 1px solid; }
        .border-gray-200 { border-color: #e5e7eb; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 1rem; }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-blue-600 text-white shadow-lg">
        <div class="container py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('landing') }}" class="flex items-center space-x-4">
                        <i class="fas fa-school text-3xl"></i>
                        <div>
                            <h1 class="text-2xl font-bold">Kantin Digital SMKN 20 Jakarta</h1>
                            <p class="text-sm text-blue-100">SMKN 20 Jakarta</p>
                        </div>
                    </a>
                </div>
                <nav class="hidden md:flex space-x-6">
                    <a href="{{ url('/') }}" class="hover:text-blue-300 transition">Beranda</a>
                    <a href="{{ url('/stands') }}" class="hover:text-blue-300 transition">Kantin Digital</a>
                    <a href="{{ url('/cart') }}" class="hover:text-blue-300 transition">Keranjang</a>
                    <a href="{{ url('/pembelians') }}" class="hover:text-blue-300 transition font-semibold">Pembelian</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Checkout</h1>
                <p class="text-gray-600">Konfirmasi pesanan Anda</p>
            </div>

            @if($cartItems->count() > 0)
                <form action="{{ route('pembelians.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Ringkasan Pesanan -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h2>
                        <div class="space-y-3">
                            @foreach($cartItems as $item)
                                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                    <img src="{{ \App\Models\Produk::find($item['produk_id'])->gambar }}" alt="{{ $item['nama_produk'] }}" class="w-20 h-20 object-cover rounded-lg">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-800">{{ $item['nama_produk'] }}</h3>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-gray-600">Qty: {{ $item['quantity'] }}</span>
                                            <span class="text-gray-600">Rp {{ number_format($item['harga'], 0, ',', '.') }} x {{ $item['quantity'] }}</span>
                                            <span class="font-bold text-blue-600">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="border-t pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-gray-800">Total:</span>
                                <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Form Data Pembeli -->
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Data Pembeli</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                    <input type="text" name="nama_pembeli" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan nama lengkap">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="email@example.com">
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Kontak & Pengiriman</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                                    <input type="tel" name="no_telepon" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="0812-3456-7890">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                                    <textarea name="alamat" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan kelas Anda"></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                                    <textarea name="catatan" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Catatan khusus (opsional)"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('cart.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Keranjang
                        </a>
                        <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-check mr-2"></i>Buat Pesanan
                        </button>
                    </div>
                </form>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Keranjang Kosong</h3>
                    <p class="text-gray-500 mb-4">Silakan tambahkan produk ke keranjang terlebih dahulu</p>
                    <a href="{{ route('stands.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition inline-block">
                        <i class="fas fa-store mr-2"></i>Lihat Produk
                    </a>
                </div>
            @endif
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
