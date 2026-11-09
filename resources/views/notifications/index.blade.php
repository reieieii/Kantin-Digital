<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Saya - Kantin Digital SMKN 20 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }

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
        .card-glass {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.08);
        }
    </style>
</head>
<body class="min-h-screen bg-slate-900 text-white" style="background-image: radial-gradient(circle at 30% 20%, #1e1b4b 0%, #0f172a 60%);">

    {{-- NAVBAR --}}
    <header class="hero-gradient text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('landing') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow">
                        <i class="fas fa-utensils text-orange-500"></i>
                    </div>
                    <div>
                        <span class="text-white font-black text-xl tracking-tight">Kantin Digital</span>
                        <p class="text-[10px] text-white/70 font-bold uppercase tracking-widest leading-none">Best School Canteen</p>
                    </div>
                </a>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('landing') }}" class="text-sm font-bold text-white/80 hover:text-white transition-colors flex items-center gap-1.5">
                        <i class="fas fa-arrow-left text-xs"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-8">
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500/20 to-orange-500/20 border border-white/10 flex items-center justify-center shadow-lg">
                    <i class="fas fa-bell text-orange-400 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-white">Notifikasi Saya</h1>
                    <p class="text-xs text-gray-400">Pemberitahuan aktivitas pesanan, pembaruan akun, dan keamanan</p>
                </div>
            </div>

            @if($notifications->count() > 0)
                <form action="{{ route('notifications.readAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs font-semibold text-purple-300 hover:text-purple-200 bg-purple-500/10 hover:bg-purple-500/20 border border-purple-500/20 px-3.5 py-2 rounded-xl transition flex items-center gap-1.5">
                        <i class="fas fa-check-double text-[11px]"></i> Tandai Semua Dibaca
                    </button>
                </form>
            @endif
        </div>

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-xl mb-5 flex items-center gap-2.5 text-sm">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Notifications List --}}
        @if($notifications->count() > 0)
            <div class="space-y-3">
                @foreach($notifications as $notif)
                    @php
                        $iconClass = 'fas fa-bell';
                        $iconBg = 'bg-blue-500/20 text-blue-400 border-blue-500/30';
                        
                        if (str_contains($notif->type, 'password')) {
                            $iconClass = 'fas fa-key';
                            $iconBg = 'bg-purple-500/20 text-purple-400 border-purple-500/30';
                        } elseif (str_contains($notif->type, 'profile')) {
                            $iconClass = 'fas fa-user-pen';
                            $iconBg = 'bg-indigo-500/20 text-indigo-400 border-indigo-500/30';
                        } elseif ($notif->type === 'order_created') {
                            $iconClass = 'fas fa-cart-shopping';
                            $iconBg = 'bg-blue-500/20 text-blue-400 border-blue-500/30';
                        } elseif ($notif->type === 'order_diproses') {
                            $iconClass = 'fas fa-fire-burner';
                            $iconBg = 'bg-amber-500/20 text-amber-400 border-amber-500/30';
                        } elseif ($notif->type === 'order_dapat_diambil') {
                            $iconClass = 'fas fa-bag-shopping';
                            $iconBg = 'bg-indigo-500/20 text-indigo-400 border-indigo-500/30';
                        } elseif ($notif->type === 'order_selesai') {
                            $iconClass = 'fas fa-circle-check';
                            $iconBg = 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30';
                        } elseif ($notif->type === 'order_dibatalkan') {
                            $iconClass = 'fas fa-ban';
                            $iconBg = 'bg-red-500/20 text-red-400 border-red-500/30';
                        }
                    @endphp

                    <div class="card-glass rounded-2xl p-4 sm:p-5 transition hover:border-white/20 relative {{ !$notif->is_read ? 'border-purple-500/40 bg-purple-900/10' : '' }}">
                        <div class="flex items-start gap-4">
                            {{-- Icon --}}
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5 border {{ $iconBg }}">
                                <i class="{{ $iconClass }} text-sm"></i>
                            </div>

                            {{-- Text & Details --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <h3 class="text-sm font-bold text-white flex items-center gap-2">
                                        {{ $notif->title }}
                                        @if(!$notif->is_read)
                                            <span class="w-2 h-2 rounded-full bg-orange-400 inline-block animate-pulse" title="Belum dibaca"></span>
                                        @endif
                                    </h3>
                                    <span class="text-[11px] text-gray-400 flex-shrink-0">{{ $notif->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-xs text-gray-300 leading-relaxed mb-3">{{ $notif->message }}</p>

                                {{-- Action Link or Mark as Read --}}
                                <div class="flex flex-wrap items-center gap-3">
                                    @if(str_contains($notif->type, 'order'))
                                        <a href="{{ route('pembelians.index') }}"
                                            class="text-xs text-orange-400 hover:text-orange-300 font-semibold transition flex items-center gap-1">
                                            <i class="fas fa-receipt text-[10px]"></i> Lihat Pesanan Saya
                                        </a>
                                    @endif

                                    @if(!$notif->is_read)
                                        <form action="{{ route('notifications.read', $notif->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-xs text-gray-400 hover:text-white transition flex items-center gap-1">
                                                <i class="fas fa-check text-[10px]"></i> Tandai Dibaca
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[11px] text-gray-500 flex items-center gap-1">
                                            <i class="fas fa-check-double text-[10px]"></i> Sudah dibaca
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="card-glass rounded-2xl p-12 text-center">
                <div class="w-16 h-16 rounded-full bg-slate-800 flex items-center justify-center mx-auto mb-4 border border-slate-700">
                    <i class="fas fa-bell-slash text-slate-500 text-2xl"></i>
                </div>
                <h3 class="text-base font-bold text-white mb-1">Belum Ada Notifikasi</h3>
                <p class="text-xs text-gray-400 max-w-sm mx-auto">
                    Semua pemberitahuan mengenai pesanan, pembaruan akun, dan aktivitas akan ditampilkan di sini.
                </p>
            </div>
        @endif
    </main>

</body>
</html>
