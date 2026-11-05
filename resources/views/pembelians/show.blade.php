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
        .bg-yellow-500 { background-color: #eab308; }
        .bg-yellow-100 { background-color: #fef3c7; }
        .bg-red-500 { background-color: #ef4444; }
        .bg-red-100 { background-color: #fef2f2; }
        .bg-gray-100 { background-color: #f3f4f6; }
        .bg-gray-200 { background-color: #e5e7eb; }
        .text-blue-600 { color: #2563eb; }
        .text-blue-700 { color: #1d4ed8; }
        .text-green-600 { color: #059669; }
        .text-green-700 { color: #047857; }
        .text-yellow-600 { color: #ca8a04; }
        .text-yellow-700 { color: #a16207; }
        .text-red-600 { color: #dc2626; }
        .text-red-700 { color: #b91c1c; }
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
        .space-y-6 > * + * { margin-top: 1.5rem; }
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .gap-6 { gap: 1.5rem; }
        .border { border: 1px solid; }
        .border-gray-200 { border-color: #e5e7eb; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 1rem; }
    </style>
</head>
<body class="bg-gray-100">
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

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Detail Pembelian</h1>
                <p class="text-gray-600">Informasi lengkap pesanan pelanggan</p>
            </div>

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
                        <span class="text-gray-600">Total Harga:</span>
                        <span class="font-bold text-xl text-blue-600">Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        @if($pembelian->status == 'pending')
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        @elseif($pembelian->status == 'diproses')
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Diproses
                            </span>
                        @elseif($pembelian->status == 'selesai')
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Selesai
                            </span>
                        @elseif($pembelian->status == 'dibatalkan')
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
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
                            <img src="{{ $detail->produk->gambar }}" alt="{{ $detail->nama_produk }}" class="w-20 h-20 object-cover rounded-lg">
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
