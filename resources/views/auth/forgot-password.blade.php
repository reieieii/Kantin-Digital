<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Kantin Digital SMKN 20 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body {
            background-color: #0f172a;
            color: #ffffff;
            background-image: radial-gradient(circle at 50% 0%, #1e1b4b 0%, #0f172a 70%);
        }
        .bg-glass {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.05);
        }
        .input-dark {
            background-color: #1e293b;
            border: 1px solid #334155;
            color: #f8fafc;
            transition: all 0.3s ease;
        }
        .input-dark:focus {
            border-color: #f97316;
            outline: none;
            box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.2);
            background-color: #27354f;
        }
        .input-error { border-color: #ef4444 !important; box-shadow: 0 0 0 2px rgba(239,68,68,0.2) !important; }
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f97316 100%);
            background-size: 200% auto;
            transition: 0.5s;
        }
        .btn-gradient:hover {
            background-position: right center;
            box-shadow: 0 10px 25px rgba(118,75,162,0.5);
            transform: scale(1.02);
        }
        .hero-gradient-text {
            background: linear-gradient(135deg, #c4b5fd 0%, #f97316 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .alert-success { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.4); color: #6ee7b7; }
        .alert-error   { background: rgba(239,68,68,0.15);  border: 1px solid rgba(239,68,68,0.4);  color: #fca5a5; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 sm:p-8">

    <div class="w-full max-w-md bg-glass rounded-3xl p-8 sm:p-12 relative shadow-2xl"
         style="box-shadow: 0 25px 50px -12px rgba(0,0,0,0.7), 0 0 60px rgba(102,126,234,0.15);">

        <!-- Glow -->
        <div class="absolute -top-32 -left-32 w-80 h-80 bg-purple-600 rounded-full blur-[120px] opacity-30 pointer-events-none"></div>
        <div class="absolute -bottom-32 -right-32 w-80 h-80 bg-orange-600 rounded-full blur-[120px] opacity-20 pointer-events-none"></div>

        <div class="relative z-10">
            <!-- Logo -->
            <a href="{{ route('landing') }}" class="flex items-center space-x-3 mb-8 w-fit hover:opacity-80 transition">
                <div class="w-11 h-11 bg-white rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-utensils text-orange-500 text-lg"></i>
                </div>
                <span class="text-white font-bold text-lg">Kantin Digital</span>
            </a>

            <!-- Icon -->
            <div class="w-14 h-14 bg-gradient-to-br from-purple-500/20 to-orange-500/20 border border-white/10 rounded-2xl flex items-center justify-center mb-6">
                <i class="fas fa-key text-orange-400 text-xl"></i>
            </div>

            <h1 class="text-2xl sm:text-3xl font-bold mb-2">Lupa <span class="hero-gradient-text">Password?</span></h1>
            <p class="text-gray-400 text-sm mb-8 leading-relaxed">
                Masukkan alamat Gmail yang terdaftar. Kami akan mengirimkan tautan untuk membuat password baru.
            </p>

            {{-- Status sukses --}}
            @if (session('status'))
                <div class="alert-success rounded-xl px-4 py-4 mb-6 flex items-start space-x-3">
                    <i class="fas fa-check-circle text-emerald-400 mt-0.5 flex-shrink-0"></i>
                    <span class="text-sm leading-relaxed">{{ session('status') }}</span>
                </div>
            @endif

            {{-- Error --}}
            @if ($errors->any())
                <div class="alert-error rounded-xl px-4 py-3 mb-6 flex items-center space-x-2">
                    <i class="fas fa-exclamation-circle text-red-400 flex-shrink-0"></i>
                    <span class="text-sm">{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Alamat Gmail</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="contoh@gmail.com"
                        class="w-full input-dark rounded-xl px-5 py-4 text-sm {{ $errors->has('email') ? 'input-error' : '' }}"
                        required
                        autocomplete="email"
                        autofocus>
                </div>

                <button type="submit"
                    class="w-full btn-gradient text-white font-bold py-4 rounded-xl text-sm tracking-widest uppercase">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim Tautan Reset
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-white transition flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-left text-xs"></i> Kembali ke Login
                </a>
            </div>
        </div>
    </div>

</body>
</html>
