<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Kantin Digital SMKN 20 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .hero-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .btn-orange-gradient {
            background: linear-gradient(45deg, #f59e0b, #f97316);
            color: white;
            transition: all 0.3s ease;
        }
        .input-field {
            background-color: #1e293b;
            border: 1px solid #334155;
            color: #f8fafc;
            transition: all 0.3s ease;
        }
        .input-field:focus {
            border-color: #764ba2;
            outline: none;
            box-shadow: 0 0 0 2px rgba(118,75,162,0.2);
            background-color: #27354f;
        }
        .input-error { border-color: #ef4444 !important; box-shadow: 0 0 0 2px rgba(239,68,68,0.2) !important; }
        .card-glass {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.08);
        }
        .tab-btn { transition: all 0.2s ease; }
        .tab-btn.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        .tab-btn:not(.active) { color: #94a3b8; }
        .tab-btn:not(.active):hover { color: white; background: rgba(255,255,255,0.05); }
    </style>
</head>
<body class="min-h-screen" style="background:#0f172a; background-image: radial-gradient(circle at 30% 20%, #1e1b4b 0%, #0f172a 60%);">

    {{-- NAVBAR --}}
    <header class="hero-gradient text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-4">
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
                <div class="flex items-center space-x-3">
                    <a href="{{ route('landing') }}" class="text-sm font-bold text-white/80 hover:text-white transition-colors hidden md:block">
                        <i class="fas fa-arrow-left mr-1"></i> Beranda
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
                        @csrf
                        <button type="submit" class="text-sm font-bold text-red-300 hover:text-red-200 transition-colors">
                            <i class="fas fa-right-from-bracket mr-1"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-2xl mx-auto px-4 py-10">

        {{-- Header Profil --}}
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-orange-400 rounded-full flex items-center justify-center text-3xl font-black text-white mx-auto mb-4 shadow-xl">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <h1 class="text-2xl font-bold text-white">{{ $user->name }}</h1>
            <p class="text-slate-400 text-sm">{{ $user->email }}</p>
            <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-bold
                {{ $user->role === 'admin' ? 'bg-orange-500/20 text-orange-400' : ($user->role === 'penjaga' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-purple-500/20 text-purple-400') }}">
                {{ $user->role === 'admin' ? 'Administrator' : ($user->role === 'penjaga' ? 'Penjaga Stand' : 'Pengguna') }}
            </span>
        </div>

        {{-- Tabs --}}
        <div class="flex gap-2 mb-6 p-1 rounded-2xl card-glass">
            <button onclick="switchTab('username')" id="tab-username"
                class="tab-btn active flex-1 py-2.5 rounded-xl text-sm font-bold">
                <i class="fas fa-user mr-1.5"></i>Username
            </button>
            <button onclick="switchTab('password')" id="tab-password"
                class="tab-btn flex-1 py-2.5 rounded-xl text-sm font-bold">
                <i class="fas fa-lock mr-1.5"></i>Password
            </button>
            <button onclick="switchTab('hapus')" id="tab-hapus"
                class="tab-btn flex-1 py-2.5 rounded-xl text-sm font-bold text-red-400 hover:bg-red-500/10">
                <i class="fas fa-trash mr-1.5"></i>Hapus Akun
            </button>
        </div>

        {{-- ── TAB: GANTI USERNAME ────────────────────────────────────────── --}}
        <div id="panel-username" class="card-glass rounded-2xl p-6">
            <h2 class="text-lg font-bold text-white mb-1">Ganti Username</h2>
            <p class="text-slate-400 text-sm mb-6">Nama yang tampil di aplikasi dan pesananmu.</p>

            @if(session('success_name'))
                <div class="flex items-center gap-2 bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 rounded-xl px-4 py-3 mb-5 text-sm">
                    <i class="fas fa-check-circle text-emerald-400"></i>
                    {{ session('success_name') }}
                </div>
            @endif

            <form action="{{ route('profile.updateName') }}" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Username Baru</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full input-field rounded-xl px-4 py-3 text-sm {{ $errors->has('name') ? 'input-error' : '' }}"
                        placeholder="Masukkan username baru"
                        autocomplete="username">
                    @error('name')
                        <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1">
                            <i class="fas fa-circle-exclamation"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                <button type="submit"
                    class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 rounded-xl font-bold text-sm hover:opacity-90 transition shadow-lg">
                    <i class="fas fa-save mr-2"></i>Simpan Username
                </button>
            </form>
        </div>

        {{-- ── TAB: GANTI PASSWORD ────────────────────────────────────────── --}}
        <div id="panel-password" class="card-glass rounded-2xl p-6 hidden">
            <h2 class="text-lg font-bold text-white mb-1">Ganti Password</h2>
            <p class="text-slate-400 text-sm mb-6">Masukkan password lama untuk konfirmasi, lalu buat yang baru.</p>

            @if(session('success_password'))
                <div class="flex items-center gap-2 bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 rounded-xl px-4 py-3 mb-5 text-sm">
                    <i class="fas fa-check-circle text-emerald-400"></i>
                    {{ session('success_password') }}
                </div>
            @endif

            <form action="{{ route('profile.updatePassword') }}" method="POST" class="space-y-4">
                @csrf @method('PUT')

                {{-- Password Lama --}}
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Password Lama</label>
                    <div class="relative">
                        <input type="password" name="current_password" id="old-pwd"
                            class="w-full input-field rounded-xl px-4 py-3 pr-12 text-sm {{ $errors->has('current_password') ? 'input-error' : '' }}"
                            placeholder="Password saat ini"
                            autocomplete="current-password">
                        <button type="button" onclick="togglePwd('old-pwd','eye-old')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300">
                            <i class="fas fa-eye-slash" id="eye-old"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1">
                            <i class="fas fa-circle-exclamation"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password Baru --}}
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Password Baru</label>
                    <div class="relative">
                        <input type="password" name="password" id="new-pwd"
                            class="w-full input-field rounded-xl px-4 py-3 pr-12 text-sm {{ $errors->has('password') ? 'input-error' : '' }}"
                            placeholder="Minimal 8 karakter"
                            autocomplete="new-password">
                        <button type="button" onclick="togglePwd('new-pwd','eye-new')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300">
                            <i class="fas fa-eye-slash" id="eye-new"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1">
                            <i class="fas fa-circle-exclamation"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Konfirmasi Password Baru --}}
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="conf-pwd"
                            class="w-full input-field rounded-xl px-4 py-3 pr-12 text-sm"
                            placeholder="Ulangi password baru"
                            autocomplete="new-password">
                        <button type="button" onclick="togglePwd('conf-pwd','eye-conf')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300">
                            <i class="fas fa-eye-slash" id="eye-conf"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 rounded-xl font-bold text-sm hover:opacity-90 transition shadow-lg">
                    <i class="fas fa-lock mr-2"></i>Ganti Password
                </button>
            </form>
        </div>

        {{-- ── TAB: HAPUS AKUN ────────────────────────────────────────────── --}}
        <div id="panel-hapus" class="card-glass rounded-2xl p-6 hidden border border-red-500/20">
            <div class="flex items-start gap-3 mb-6">
                <div class="w-10 h-10 bg-red-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-triangle-exclamation text-red-400"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-red-400 mb-1">Hapus Akun</h2>
                    <p class="text-slate-400 text-sm">Tindakan ini <strong class="text-red-400">permanen dan tidak bisa dibatalkan</strong>. Semua data termasuk riwayat pesanan dan favorit akan ikut terhapus.</p>
                </div>
            </div>

            <form action="{{ route('profile.delete') }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus akun secara permanen? Tindakan ini tidak bisa dibatalkan!')">
                @csrf @method('DELETE')

                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Konfirmasi dengan Password</label>
                    <div class="relative">
                        <input type="password" name="confirm_password" id="del-pwd"
                            class="w-full input-field rounded-xl px-4 py-3 pr-12 text-sm {{ $errors->has('confirm_password') ? 'input-error' : '' }}"
                            placeholder="Masukkan password kamu"
                            autocomplete="current-password">
                        <button type="button" onclick="togglePwd('del-pwd','eye-del')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300">
                            <i class="fas fa-eye-slash" id="eye-del"></i>
                        </button>
                    </div>
                    @error('confirm_password')
                        <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1">
                            <i class="fas fa-circle-exclamation"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-bold text-sm transition shadow-lg">
                    <i class="fas fa-trash mr-2"></i>Ya, Hapus Akun Saya
                </button>
            </form>
        </div>

    </main>

    <script>
        // Tab switcher
        const tabs = ['username', 'password', 'hapus'];

        function switchTab(name) {
            tabs.forEach(t => {
                document.getElementById('tab-' + t).classList.remove('active');
                document.getElementById('panel-' + t).classList.add('hidden');
            });
            document.getElementById('tab-' + name).classList.add('active');
            document.getElementById('panel-' + name).classList.remove('hidden');
        }

        // Toggle password visibility
        function togglePwd(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon  = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            }
        }

        // Buka tab yang sesuai jika ada error/session
        @if(session('tab') === 'password' || $errors->has('current_password') || $errors->has('password'))
            switchTab('password');
        @elseif(session('tab') === 'hapus' || $errors->has('confirm_password'))
            switchTab('hapus');
        @endif
    </script>
</body>
</html>
