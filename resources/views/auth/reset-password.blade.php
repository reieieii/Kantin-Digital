<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Kantin Digital SMKN 20 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body {
            background-color: #0f172a;
            color: #ffffff;
            background-image: radial-gradient(circle at 50% 100%, #1e1b4b 0%, #0f172a 70%);
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
            box-shadow: 0 0 0 2px rgba(249,115,22,0.2);
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
        .alert-error { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.4); color: #fca5a5; }
        .field-error { color: #fca5a5; font-size: 0.75rem; margin-top: 0.375rem; display: flex; align-items: center; gap: 0.25rem; }
        .strength-bar { height: 4px; border-radius: 2px; transition: all 0.3s ease; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 sm:p-8">

    <div class="w-full max-w-md bg-glass rounded-3xl p-8 sm:p-12 relative shadow-2xl"
         style="box-shadow: 0 25px 50px -12px rgba(0,0,0,0.7), 0 0 60px rgba(102,126,234,0.15);">

        <!-- Glow -->
        <div class="absolute -top-32 -right-32 w-80 h-80 bg-purple-600 rounded-full blur-[120px] opacity-30 pointer-events-none"></div>
        <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-orange-600 rounded-full blur-[120px] opacity-20 pointer-events-none"></div>

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
                <i class="fas fa-lock-open text-purple-400 text-xl"></i>
            </div>

            <h1 class="text-2xl sm:text-3xl font-bold mb-2">Buat <span class="hero-gradient-text">Password Baru</span></h1>
            <p class="text-gray-400 text-sm mb-8">Password baru harus minimal 8 karakter.</p>

            {{-- Error --}}
            @if ($errors->any())
                <div class="alert-error rounded-xl px-4 py-3 mb-6 flex items-center space-x-2">
                    <i class="fas fa-exclamation-circle text-red-400 flex-shrink-0"></i>
                    <span class="text-sm">{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('password.reset') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                {{-- Password Baru --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Password Baru</label>
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="new-password"
                            placeholder="Minimal 8 karakter"
                            class="w-full input-dark rounded-xl px-5 py-4 pr-12 text-sm {{ $errors->has('password') ? 'input-error' : '' }}"
                            required
                            oninput="checkStrength(this.value)"
                            autocomplete="new-password">
                        <button type="button" onclick="togglePwd('new-password','eye1')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300">
                            <i class="fas fa-eye-slash" id="eye1"></i>
                        </button>
                    </div>
                    <!-- Strength bar -->
                    <div class="flex gap-1 mt-2">
                        <div class="strength-bar flex-1 bg-gray-700" id="bar1"></div>
                        <div class="strength-bar flex-1 bg-gray-700" id="bar2"></div>
                        <div class="strength-bar flex-1 bg-gray-700" id="bar3"></div>
                        <div class="strength-bar flex-1 bg-gray-700" id="bar4"></div>
                    </div>
                    <p id="strength-text" class="text-xs text-gray-500 mt-1"></p>
                    @error('password')
                        <p class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Konfirmasi Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            name="password_confirmation"
                            id="confirm-password"
                            placeholder="Ulangi password baru"
                            class="w-full input-dark rounded-xl px-5 py-4 pr-12 text-sm"
                            required
                            autocomplete="new-password">
                        <button type="button" onclick="togglePwd('confirm-password','eye2')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300">
                            <i class="fas fa-eye-slash" id="eye2"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full btn-gradient text-white font-bold py-4 rounded-xl text-sm tracking-widest uppercase mt-2">
                    <i class="fas fa-check-circle mr-2"></i>Simpan Password Baru
                </button>
            </form>
        </div>
    </div>

    <script>
        function togglePwd(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon  = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye-slash','fa-eye');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye','fa-eye-slash');
            }
        }

        function checkStrength(val) {
            const bars   = ['bar1','bar2','bar3','bar4'];
            const colors = ['#ef4444','#f97316','#eab308','#22c55e'];
            const labels = ['','Lemah','Cukup','Kuat','Sangat Kuat'];

            let score = 0;
            if (val.length >= 8)                          score++;
            if (/[A-Z]/.test(val))                        score++;
            if (/[0-9]/.test(val))                        score++;
            if (/[^A-Za-z0-9]/.test(val))                 score++;

            bars.forEach((id, i) => {
                document.getElementById(id).style.background = i < score ? colors[score - 1] : '#374151';
            });
            document.getElementById('strength-text').textContent = val.length ? labels[score] : '';
            document.getElementById('strength-text').style.color = score ? colors[score - 1] : '#6b7280';
        }
    </script>
</body>
</html>
