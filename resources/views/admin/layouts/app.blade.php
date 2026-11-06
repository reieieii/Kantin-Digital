<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Admin Kantin Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(249,115,22,0.15);
            color: #f97316;
            border-left: 3px solid #f97316;
        }
        .sidebar-link.active .nav-icon { color: #f97316; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #1e293b; }
        ::-webkit-scrollbar-thumb { background: #475569; border-radius: 3px; }
        .badge-pending   { background:#fef3c7; color:#92400e; }
        .badge-diproses  { background:#dbeafe; color:#1e40af; }
        .badge-selesai   { background:#d1fae5; color:#065f46; }
        .badge-dibatalkan{ background:#fee2e2; color:#991b1b; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-900 text-white min-h-screen flex">

    {{-- ── SIDEBAR ─────────────────────────────────────────────────────────── --}}
    <aside id="sidebar"
        class="w-64 bg-slate-800 border-r border-slate-700 flex flex-col fixed inset-y-0 left-0 z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">

        {{-- Logo --}}
        <div class="flex items-center space-x-3 px-6 py-5 border-b border-slate-700">
            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-utensils text-white text-sm"></i>
            </div>
            <div>
                <p class="font-bold text-white text-sm leading-tight">Kantin Digital</p>
                <p class="text-xs text-orange-400 font-semibold">ADMIN PANEL</p>
            </div>
        </div>

        {{-- Admin info --}}
        <div class="px-4 py-4 border-b border-slate-700">
            <div class="flex items-center space-x-3 bg-slate-700/50 rounded-xl p-3">
                <div class="w-9 h-9 bg-gradient-to-br from-purple-500 to-orange-400 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-orange-400">Administrator</p>
                </div>
            </div>
        </div>

        {{-- Nav links --}}
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <p class="text-xs text-slate-500 uppercase tracking-widest px-3 mb-2 font-semibold">Menu Utama</p>

            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-300 text-sm {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-chart-pie w-5 text-center text-slate-400"></i>
                <span>Dashboard</span>
            </a>

            <p class="text-xs text-slate-500 uppercase tracking-widest px-3 mt-5 mb-2 font-semibold">Kelola</p>

            <a href="{{ route('admin.stands.index') }}"
                class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-300 text-sm {{ request()->routeIs('admin.stands.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-store w-5 text-center text-slate-400"></i>
                <span>Stand</span>
            </a>

            <a href="{{ route('admin.produks.index') }}"
                class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-300 text-sm {{ request()->routeIs('admin.produks.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-utensils w-5 text-center text-slate-400"></i>
                <span>Produk</span>
            </a>

            <a href="{{ route('admin.pesanans.index') }}"
                class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-300 text-sm {{ request()->routeIs('admin.pesanans.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-receipt w-5 text-center text-slate-400"></i>
                <span>Pesanan</span>
                @php $pending = \App\Models\Pembelian::where('status','pending')->count(); @endphp
                @if($pending > 0)
                    <span class="ml-auto bg-orange-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pending }}</span>
                @endif
            </a>

            <p class="text-xs text-slate-500 uppercase tracking-widest px-3 mt-5 mb-2 font-semibold">Lainnya</p>

            <a href="{{ route('admin.kalkulator') }}"
                class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-300 text-sm {{ request()->routeIs('admin.kalkulator') ? 'active' : '' }}">
                <i class="nav-icon fas fa-calculator w-5 text-center text-slate-400"></i>
                <span>Kalkulator</span>
            </a>

            <a href="{{ route('admin.rekap.index') }}"
                class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-300 text-sm {{ request()->routeIs('admin.rekap.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-clipboard-list w-5 text-center text-slate-400"></i>
                <span>Rekap Harian</span>
            </a>

            <a href="{{ route('admin.reset.index') }}"
                class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-red-400 text-sm {{ request()->routeIs('admin.reset.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-rotate-left w-5 text-center"></i>
                <span>Reset Stand</span>
            </a>

            <p class="text-xs text-slate-500 uppercase tracking-widest px-3 mt-5 mb-2 font-semibold">Lainnya</p>

            <a href="{{ route('landing') }}" target="_blank"
                class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-300 text-sm">
                <i class="nav-icon fas fa-globe w-5 text-center text-slate-400"></i>
                <span>Lihat Website</span>
                <i class="fas fa-external-link-alt text-xs text-slate-500 ml-auto"></i>
            </a>
        </nav>

        {{-- Logout --}}
        <div class="px-3 py-4 border-t border-slate-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-red-400 hover:bg-red-500/10 transition text-sm">
                    <i class="fas fa-right-from-bracket w-5 text-center"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Overlay mobile --}}
    <div id="sidebarOverlay" onclick="closeSidebar()"
        class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden"></div>

    {{-- ── MAIN CONTENT ────────────────────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col lg:ml-64 min-h-screen">

        {{-- Top Navbar --}}
        <header class="bg-slate-800 border-b border-slate-700 px-6 py-4 flex items-center justify-between sticky top-0 z-20">
            <div class="flex items-center space-x-4">
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-white">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div>
                    <h1 class="text-lg font-bold text-white">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs text-slate-400">@yield('page-subtitle', 'Selamat datang di panel admin')</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                {{-- Notif badge pesanan baru --}}
                <a href="{{ route('admin.pesanans.index', ['status' => 'pending']) }}"
                    class="relative p-2 text-slate-400 hover:text-white transition">
                    <i class="fas fa-bell text-lg"></i>
                    @if($pending ?? \App\Models\Pembelian::where('status','pending')->count() > 0)
                        <span class="absolute top-1 right-1 w-2 h-2 bg-orange-500 rounded-full"></span>
                    @endif
                </a>
                <div class="w-px h-6 bg-slate-600"></div>
                <div class="flex items-center space-x-2 text-sm">
                    <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-orange-400 rounded-full flex items-center justify-center font-bold text-xs">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="text-slate-300 hidden sm:block">{{ Auth::user()->name }}</span>
                </div>
            </div>
        </header>

        {{-- Flash Messages --}}
        <div class="px-6 pt-4">
            @if(session('success'))
                <div x-data="{ show: true }" class="flex items-center space-x-3 bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 rounded-xl px-4 py-3 mb-4 text-sm">
                    <i class="fas fa-check-circle text-emerald-400"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <script>setTimeout(() => { const el = document.querySelector('.bg-emerald-500\\/15'); if(el) el.remove(); }, 4000);</script>
            @endif
            @if(session('error'))
                <div class="flex items-center space-x-3 bg-red-500/15 border border-red-500/30 text-red-300 rounded-xl px-4 py-3 mb-4 text-sm">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
        </div>

        {{-- Page Content --}}
        <main class="flex-1 px-6 pb-8">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.toggle('hidden');
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.add('hidden');
        }
    </script>
    @stack('scripts')
</body>
</html>
