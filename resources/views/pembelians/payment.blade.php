<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metode Pembayaran - Kantin Digital SMKN 20 Jakarta</title>
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
        .bg-green-600 { background-color: #059669; }
        .bg-green-100 { background-color: #dcfce7; }
        .bg-gray-100 { background-color: #f3f4f6; }
        .bg-gray-200 { background-color: #e5e7eb; }
        .bg-gray-50 { background-color: #f9fafb; }
        .bg-white { background-color: white; }
        .text-blue-600 { color: #2563eb; }
        .text-blue-700 { color: #1d4ed8; }
        .text-green-600 { color: #059669; }
        .text-green-700 { color: #047857; }
        .text-white { color: white; }
        .text-gray-800 { color: #1f2937; }
        .text-gray-600 { color: #4b5563; }
        .text-gray-500 { color: #6b7280; }
        .text-gray-700 { color: #374151; }
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        .rounded-lg { border-radius: 0.5rem; }
        .rounded-xl { border-radius: 0.75rem; }
        .p-4 { padding: 1rem; }
        .p-6 { padding: 1.5rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
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
        .border-2 { border: 2px solid #e5e7eb; }
        .border-gray-300 { border-color: #d1d5db; }
        .border-green-500 { border-color: #10b981; }
        .border-blue-500 { border-color: #2563eb; }
        .hover\:bg-blue-700:hover { background-color: #1d4ed8; }
        .hover\:bg-green-600:hover { background-color: #059669; }
        .transition { transition: all 0.3s ease; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .justify-center { justify-content: center; }
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .lg\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .space-y-4 > * + * { margin-top: 1rem; }
        .space-y-6 > * + * { margin-top: 1.5rem; }
        .h-16 { height: 4rem; }
        .h-20 { height: 5rem; }
        .h-24 { height: 6rem; }
        .h-32 { height: 8rem; }
        .h-40 { height: 10rem; }
        .w-16 { width: 4rem; }
        .w-20 { width: 5rem; }
        .w-24 { width: 6rem; }
        .w-32 { width: 8rem; }
        .w-40 { width: 10rem; }
        .object-cover { object-fit: cover; }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }
        .cursor-pointer { cursor: pointer; }
        .hidden { display: none; }
        .block { display: block; }
        .relative { position: relative; }
        .absolute { position: absolute; }
        .top-2 { top: 0.5rem; }
        .right-2 { right: 0.5rem; }
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
                    <a href="{{ route('landing') }}" class="text-sm font-bold text-white/80 hover:text-white transition-colors">Beranda</a>
                    <a href="{{ route('stands.index') }}" class="text-sm font-bold text-white/80 hover:text-white transition-colors">Daftar Stand</a>
                    <a href="{{ route('cart.index') }}" class="relative text-white/80 hover:text-white transition-all p-2 bg-white/10 rounded-xl border border-white/10 group">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        <span id="cart-count" class="absolute -top-1 -right-1 bg-gradient-to-br from-orange-400 to-orange-600 text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm">0</span>
                    </a>
                    <a href="{{ route('pembelians.index') }}" class="btn-orange-gradient text-sm font-black text-white px-6 py-2.5 rounded-xl hover:scale-105 transition-all shadow-md hover:shadow-lg shadow-orange-900/20 text-center">
                        <i class="fas fa-receipt mr-2"></i>Pesanan
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

    <main class="container mx-auto px-6 py-12">
        <div class="max-w-6xl mx-auto">
            <div class="mb-12">
                <h1 class="text-3xl md:text-4xl font-black text-slate-900 mb-3 tracking-tight">Penyelesaian Pesanan</h1>
                <p class="text-slate-500 font-medium">Lengkapi rincian pembayaran untuk memproses pesanan Anda.</p>
            </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Form Pembayaran & Data Pembeli -->
            <div class="space-y-6">
                <!-- Metode Pembayaran -->
                <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] p-8 border border-slate-100">
                    <h2 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-3">
                        <span class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-sm">1</span>
                        Metode Pembayaran
                    </h2>
                    
                    <div class="space-y-4">
                        <!-- Tunai -->
                        <label class="flex items-center gap-4 p-5 border-2 border-slate-100 rounded-2xl cursor-pointer hover:border-indigo-500 transition-all duration-300 payment-method group" data-method="tunai">
                            <input type="radio" name="payment_method" value="tunai" class="w-5 h-5 text-indigo-600" checked>
                            <div class="flex items-center gap-4 flex-1">
                                <div class="w-14 h-14 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fas fa-money-bill-wave text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800">Tunai / Cash</h3>
                                    <p class="text-xs text-slate-500 font-medium">Bayar langsung di kasir kantin</p>
                                </div>
                            </div>
                        </label>

                        <!-- Gopay -->
                        <label class="flex items-center gap-4 p-5 border-2 border-slate-100 rounded-2xl cursor-pointer hover:border-indigo-500 transition-all duration-300 payment-method group" data-method="gopay">
                            <input type="radio" name="payment_method" value="gopay" class="w-5 h-5 text-indigo-600">
                            <div class="flex items-center gap-4 flex-1">
                                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fab fa-gopay text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800">GoPay</h3>
                                    <p class="text-xs text-slate-500 font-medium">Scan QRIS untuk pembayaran digital</p>
                                </div>
                            </div>
                        </label>

                        <!-- Dana -->
                        <label class="flex items-center gap-4 p-5 border-2 border-slate-100 rounded-2xl cursor-pointer hover:border-indigo-500 transition-all duration-300 payment-method group" data-method="dana">
                            <input type="radio" name="payment_method" value="dana" class="w-5 h-5 text-indigo-600">
                            <div class="flex items-center gap-4 flex-1">
                                <div class="w-14 h-14 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fas fa-wallet text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800">Dana</h3>
                                    <p class="text-xs text-slate-500 font-medium">Pembayaran mudah melalui aplikasi Dana</p>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- QR Code Section (Hidden by default) -->
                    <div id="qr-section" class="hidden mt-8 animate-fade-in">
                        <div class="bg-indigo-50/50 rounded-3xl p-8 text-center border border-indigo-100 border-dashed">
                            <p class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-4">Pindai QRIS Sekarang</p>
                            <div class="w-48 h-48 mx-auto bg-white rounded-2xl flex items-center justify-center mb-6 shadow-sm border border-indigo-50">
                                <i class="fas fa-qrcode text-7xl text-slate-200"></i>
                            </div>
                            <p class="text-sm font-bold text-slate-600">Buka aplikasi <span id="payment-app" class="text-indigo-600 italic">GoPay</span></p>
                            <p class="text-2xl font-black text-slate-900 mt-2 tracking-tight">Rp {{ number_format($totalHarga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Data Pembeli -->
                <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] p-8 border border-slate-100">
                    <h2 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-3">
                        <span class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-sm">2</span>
                        Data Diri & Pengiriman
                    </h2>
                    
                    <form action="{{ route('pembelians.processPayment') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap *</label>
                                <input type="text" name="nama_pembeli" required placeholder="Masukkan nama Anda"
                                       class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium text-slate-700">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">No. Telepon</label>
                                <input type="tel" name="no_telepon" placeholder="Contoh: 0812..."
                                       class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium text-slate-700">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Email (Opsional)</label>
                            <input type="email" name="email" placeholder="pembeli@email.com"
                                   class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium text-slate-700">
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Kelas</label>
                            <textarea name="alamat" rows="2" placeholder="Contoh: XII RPL 1 atau Lab Komputer"
                                      class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium text-slate-700"></textarea>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Catatan Pesanan</label>
                            <textarea name="catatan" rows="2" placeholder="Contoh: Pedas dikit, atau tanpa sayur..."
                                      class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium text-slate-700"></textarea>
                        </div>

                        <!-- Tombol Bayar -->
                        <div class="pt-4">
                            <button type="submit" 
                                    class="w-full bg-slate-900 text-white py-5 rounded-[1.5rem] font-black shadow-2xl shadow-slate-200 hover:bg-slate-800 transition-all flex items-center justify-center gap-3 active:scale-95 group">
                                <i class="fas fa-lock text-xs group-hover:animate-bounce"></i>
                                <span>Konfirmasi & Bayar Sekarang</span>
                            </button>
                            <p class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-6">
                                <i class="fas fa-shield-alt mr-1"></i> Pembayaran Aman & Terenkripsi
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] p-8 border border-slate-100 flex flex-col h-full">
                <h2 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-3">
                    <span class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-sm">3</span>
                    Ringkasan Pesanan
                </h2>
                
                @if(empty($cartItems))
                    <div class="text-center py-20 bg-slate-50/50 rounded-[2rem] border-2 border-dashed border-slate-200">
                        <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                            <i class="fas fa-shopping-basket text-3xl text-slate-200"></i>
                        </div>
                        <p class="text-slate-500 font-bold">Keranjang belanja kosong</p>
                        <a href="{{ route('stands.index') }}" class="inline-block mt-4 text-indigo-600 font-black text-sm uppercase tracking-widest hover:text-indigo-700 transition">
                            Mulai Belanja <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                @else
                    <!-- Daftar Produk -->
                    <div class="space-y-4 mb-8 flex-1 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($cartItems as $item)
                            <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100 group hover:border-indigo-100 transition-all">
                                <img src="{{ (strpos($item['gambar'], 'http') === 0 || strpos($item['gambar'], 'unsplash') !== false) ? $item['gambar'] : asset('storage/' . $item['gambar']) }}" 
                                     alt="{{ $item['nama_produk'] }}"
                                     class="w-20 h-20 object-cover rounded-xl shadow-sm group-hover:scale-105 transition-transform"
                                     onerror="this.src='https://via.placeholder.com/80x80?text=Food'">
                                
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-slate-800 text-sm truncate">{{ $item['nama_produk'] }}</h3>
                                    <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest">{{ $item['quantity'] }} Unit</p>
                                    <p class="font-black text-slate-900 mt-1">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Total -->
                    <div class="bg-slate-900 rounded-[2rem] p-8 text-white relative overflow-hidden">
                        <!-- Decorative element -->
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/5 rounded-full"></div>
                        
                        <div class="flex justify-between items-center mb-6 relative z-10">
                            <div>
                                <p class="text-[10px] font-black text-white/50 uppercase tracking-[0.2em] mb-1">Total Pembayaran</p>
                                <span class="text-3xl font-black tracking-tight">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                            </div>
                            <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-wallet text-xl"></i>
                            </div>
                        </div>

                        <!-- Info Pembayaran -->
                        <div class="bg-white/10 rounded-xl p-4 flex items-start gap-3 border border-white/10 relative z-10">
                            <i class="fas fa-info-circle text-white/50 mt-0.5"></i>
                            <p class="text-[11px] font-medium leading-relaxed text-white/70">
                                Pastikan saldo mencukupi jika menggunakan pembayaran digital. Pesanan akan langsung kami sampaikan ke pihak Kantin.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <script>
        // Payment method selection
        document.querySelectorAll('.payment-method').forEach(label => {
            label.addEventListener('click', function() {
                // Remove active state from all
                document.querySelectorAll('.payment-method').forEach(l => {
                    l.classList.remove('border-blue-500', 'bg-blue-50');
                    l.classList.add('border-gray-300');
                });
                
                // Add active state to selected
                this.classList.remove('border-gray-300');
                this.classList.add('border-blue-500', 'bg-blue-50');
                
                // Show/hide QR section
                const method = this.dataset.method;
                const qrSection = document.getElementById('qr-section');
                const paymentApp = document.getElementById('payment-app');
                
                if (method === 'gopay' || method === 'dana') {
                    qrSection.classList.remove('hidden');
                    paymentApp.textContent = method === 'gopay' ? 'GoPay' : 'Dana';
                } else {
                    qrSection.classList.add('hidden');
                }
            });
        });

        // Set initial active state
        document.querySelector('.payment-method[data-method="tunai"]').click();
    </script>
</body>
</html>
