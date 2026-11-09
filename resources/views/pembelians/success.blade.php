<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - Kantin Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
        .receipt-card { border-radius: 3rem; background: #fff; box-shadow: 0 40px 100px -20px rgba(0,0,0,0.15); }
        .success-checkmark { 
            width: 120px; 
            height: 120px; 
            margin: 0 auto; 
            background: linear-gradient(135deg, #22c55e 0%, #10b981 100%); 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3); 
            animation: bounceIn 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55); 
            border: 8px solid rgba(255, 255, 255, 0.2);
        }
        @keyframes bounceIn { from { transform: scale(0.3); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col items-center justify-center p-6">
    <div class="max-w-xl w-full">
        <div class="receipt-card p-8 md:p-12 relative overflow-hidden">
            <!-- Top Pattern -->
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-green-400 to-emerald-600"></div>
            
            <div class="text-center mb-10">
                <div class="success-checkmark mb-6">
                    <i class="fas fa-check text-white text-5xl"></i>
                </div>
                <h1 class="text-3xl font-black text-slate-900 mb-2">Terima Kasih!</h1>
                <p class="text-slate-500 font-medium">Pesanan Anda telah berhasil diterima dan sedang diproses oleh Kantin.</p>
            </div>

            <div class="border-y border-dashed border-slate-200 py-8 mb-8">
                <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">ID Pesanan</p>
                        <p class="text-sm font-black text-slate-800">#{{ $pembelian->kode_pembelian }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Metode Pembayaran</p>
                        <p class="text-sm font-black text-indigo-600 uppercase">{{ $pembelian->metode_pembayaran }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($pembelian->detailPembelians as $detail)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center font-bold text-slate-600 text-xs">
                                    {{ $detail->quantity }}x
                                </div>
                                <span class="text-sm font-bold text-slate-700">{{ $detail->nama_produk }}</span>
                            </div>
                            <span class="text-sm font-black text-slate-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-between items-center mb-10">
                <span class="text-lg font-bold text-slate-500">Total Akhir</span>
                <span class="text-3xl font-black text-slate-900">Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('pembelians.index') }}" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold flex items-center justify-center gap-2 hover:bg-slate-800 transition-all shadow-lg shadow-slate-200">
                    <i class="fas fa-receipt text-xs"></i>
                    Lacak Pesanan
                </a>
                <a href="{{ route('landing') }}" class="w-full bg-white text-slate-600 border border-slate-200 py-4 rounded-2xl font-bold flex items-center justify-center gap-2 hover:bg-slate-50 transition-all">
                    <i class="fas fa-home text-xs"></i>
                    Beranda
                </a>
            </div>
            
            <p class="text-center text-[10px] font-bold text-slate-300 uppercase tracking-widest mt-10">Kantin Digital SMKN 20 Jakarta</p>
        </div>
    </div>
</body>
</html>
