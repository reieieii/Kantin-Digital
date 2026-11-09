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
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.08);
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
        .alert-amber   { background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.4); color: #fcd34d; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 sm:p-8">

    <div class="w-full max-w-lg bg-glass rounded-3xl p-8 sm:p-12 relative shadow-2xl"
         style="box-shadow: 0 25px 50px -12px rgba(0,0,0,0.7), 0 0 60px rgba(102,126,234,0.15);">

        <!-- Glow Decor -->
        <div class="absolute -top-32 -left-32 w-80 h-80 bg-purple-600 rounded-full blur-[120px] opacity-30 pointer-events-none"></div>
        <div class="absolute -bottom-32 -right-32 w-80 h-80 bg-orange-600 rounded-full blur-[120px] opacity-20 pointer-events-none"></div>

        <div class="relative z-10">
            <!-- Logo -->
            <a href="{{ route('landing') }}" class="flex items-center space-x-3 mb-8 w-fit hover:opacity-80 transition">
                <div class="w-11 h-11 bg-white rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-utensils text-orange-500 text-lg"></i>
                </div>
                <div>
                    <span class="text-white font-bold text-lg leading-tight block">Kantin Digital</span>
                    <span class="text-[10px] text-gray-400 font-semibold tracking-wider uppercase block">SMKN 20 Jakarta</span>
                </div>
            </a>

            <!-- Header Icon & Title -->
            <div class="flex items-center space-x-4 mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500/20 to-orange-500/20 border border-white/10 rounded-2xl flex items-center justify-center shadow-inner">
                    <i class="fas fa-user-shield text-orange-400 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold">Lupa <span class="hero-gradient-text">Password?</span></h1>
                    <p class="text-xs text-orange-300 font-semibold flex items-center gap-1.5 mt-0.5">
                        <i class="fas fa-shield-halved text-[11px]"></i> Verifikasi Langsung oleh Admin
                    </p>
                </div>
            </div>

            <p class="text-gray-400 text-sm mb-6 leading-relaxed">
                Masukkan alamat email yang terdaftar. Permintaan Anda akan dikirimkan ke <strong>Admin Kantin</strong> untuk diverifikasi. Setelah dikonfirmasi, Anda dapat langsung membuat password baru.
            </p>

            {{-- Pesan Status Umum --}}
            @if (session('status'))
                <div class="alert-amber rounded-xl px-4 py-3 mb-6 flex items-start space-x-3">
                    <i class="fas fa-clock text-amber-400 mt-0.5 flex-shrink-0 text-base animate-pulse"></i>
                    <span class="text-sm leading-relaxed">{{ session('status') }}</span>
                </div>
            @endif

            {{-- Pesan Error --}}
            @if ($errors->any())
                <div class="alert-error rounded-xl px-4 py-3 mb-6 flex items-center space-x-2">
                    <i class="fas fa-exclamation-circle text-red-400 flex-shrink-0"></i>
                    <span class="text-sm">{{ $errors->first() }}</span>
                </div>
            @endif

            {{-- ── KARTU STATUS PERMINTAAN (Jika sudah ada request aktif) ────────────────────── --}}
            @if($activeRequest && in_array($activeRequest->status, ['pending', 'approved', 'rejected']))
                <div id="statusCard" class="mb-6 rounded-2xl p-5 border transition-all duration-300
                    {{ $activeRequest->status === 'approved' ? 'bg-emerald-500/15 border-emerald-500/40 text-emerald-300 shadow-[0_0_30px_rgba(16,185,129,0.2)]' : ($activeRequest->status === 'pending' ? 'bg-amber-500/15 border-amber-500/40 text-amber-300' : 'bg-red-500/15 border-red-500/40 text-red-300') }}">
                    
                    {{-- Status Header --}}
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-2.5">
                            @if($activeRequest->status === 'pending')
                                <div class="w-3 h-3 rounded-full bg-amber-400 animate-ping"></div>
                                <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Menunggu Konfirmasi Admin</span>
                            @elseif($activeRequest->status === 'approved')
                                <i class="fas fa-check-circle text-emerald-400 text-lg"></i>
                                <span class="text-xs font-bold uppercase tracking-wider text-emerald-400">Permintaan Disetujui Admin!</span>
                            @else
                                <i class="fas fa-times-circle text-red-400 text-lg"></i>
                                <span class="text-xs font-bold uppercase tracking-wider text-red-400">Permintaan Ditolak</span>
                            @endif
                        </div>
                        <span class="text-[11px] text-gray-400">{{ $activeRequest->created_at->format('H:i') }} WIB</span>
                    </div>

                    {{-- Status Content --}}
                    @if($activeRequest->status === 'pending')
                        <p class="text-xs text-gray-300 leading-relaxed mb-3">
                            Permintaan reset password untuk akun <strong>{{ $activeRequest->email }}</strong> sedang menunggu persetujuan Admin Kantin.
                        </p>
                        <div class="bg-slate-900/60 rounded-xl p-3 border border-slate-700/60 flex items-center justify-between">
                            <span class="text-[11px] text-gray-400 flex items-center gap-2">
                                <i class="fas fa-spinner fa-spin text-amber-400"></i> Memeriksa status otomatis...
                            </span>
                            <button type="button" onclick="checkStatusManual('{{ $activeRequest->email }}')" class="text-xs font-bold text-amber-400 hover:text-amber-300 transition underline">
                                Cek Sekarang
                            </button>
                        </div>
                    @elseif($activeRequest->status === 'approved')
                        <p class="text-xs text-gray-200 leading-relaxed mb-4">
                            🎉 Kabar baik! Admin telah mengonfirmasi permintaan reset password untuk <strong>{{ $activeRequest->name }}</strong>. Anda sekarang dapat langsung membuat password baru.
                        </p>
                        <a href="{{ route('password.reset.form', ['token' => $activeRequest->token, 'email' => $activeRequest->email]) }}"
                            class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white font-bold py-3.5 px-6 rounded-xl text-sm tracking-wider uppercase flex items-center justify-center gap-2 shadow-lg hover:shadow-emerald-500/30 transition transform hover:scale-[1.02]">
                            <i class="fas fa-key"></i> Ganti Password Sekarang
                            <i class="fas fa-arrow-right text-xs ml-1"></i>
                        </a>
                    @else
                        <p class="text-xs text-red-200 leading-relaxed mb-2">
                            Permintaan reset password Anda ditolak oleh admin.
                        </p>
                        @if($activeRequest->admin_notes)
                            <div class="bg-slate-900/60 rounded-xl p-3 border border-red-500/20 text-xs text-gray-300 italic mb-3">
                                "{{ $activeRequest->admin_notes }}"
                            </div>
                        @endif
                        <p class="text-[11px] text-gray-400">Silakan hubungi admin secara langsung atau ajukan permintaan baru di bawah.</p>
                    @endif
                </div>
            @endif

            {{-- ── FORM INPUT EMAIL ──────────────────────────────────────────────────────── --}}
            <form action="{{ route('password.email') }}" method="POST" class="space-y-5" id="forgotForm">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-300 uppercase tracking-widest mb-2">Alamat Email Terdaftar</label>
                    <div class="relative">
                        <input
                            type="email"
                            name="email"
                            id="inputEmail"
                            value="{{ old('email', $email ?? '') }}"
                            placeholder="nama@gmail.com"
                            class="w-full input-dark rounded-xl pl-11 pr-4 py-4 text-sm {{ $errors->has('email') ? 'input-error' : '' }}"
                            required
                            autocomplete="email"
                            autofocus>
                        <i class="fas fa-envelope text-gray-500 absolute left-4 top-1/2 -translate-y-1/2 text-sm"></i>
                    </div>
                </div>

                <button type="submit"
                    class="w-full btn-gradient text-white font-bold py-4 rounded-xl text-sm tracking-widest uppercase shadow-lg">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim Permintaan ke Admin
                </button>
            </form>

            {{-- Footer Links --}}
            <div class="mt-8 pt-6 border-t border-white/10 flex items-center justify-between text-xs text-gray-400">
                <a href="{{ route('login') }}" class="hover:text-white transition flex items-center gap-1.5 font-medium">
                    <i class="fas fa-arrow-left text-[10px]"></i> Kembali ke Login
                </a>
                <a href="{{ route('landing') }}" class="hover:text-white transition flex items-center gap-1.5 font-medium">
                    <i class="fas fa-home text-[10px]"></i> Beranda
                </a>
            </div>
        </div>
    </div>

    {{-- Live Auto-Check Polling Script --}}
    @if($activeRequest && $activeRequest->status === 'pending')
    <script>
        const targetEmail = "{{ $activeRequest->email }}";
        let pollInterval = setInterval(() => {
            checkStatusManual(targetEmail);
        }, 3500);

        function checkStatusManual(email) {
            fetch("{{ route('password.status') }}?email=" + encodeURIComponent(email))
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'approved') {
                        clearInterval(pollInterval);
                        // Update UI to approved card immediately with animation
                        const card = document.getElementById('statusCard');
                        if (card) {
                            card.className = "mb-6 rounded-2xl p-5 border transition-all duration-500 bg-emerald-500/20 border-emerald-500/50 text-emerald-300 shadow-[0_0_35px_rgba(16,185,129,0.3)] animate-bounce";
                            card.innerHTML = `
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-2.5">
                                        <i class="fas fa-check-circle text-emerald-400 text-lg"></i>
                                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-400">Permintaan Disetujui Admin!</span>
                                    </div>
                                    <span class="text-[11px] text-gray-400">Baru saja</span>
                                </div>
                                <p class="text-xs text-gray-200 leading-relaxed mb-4">
                                    🎉 Admin baru saja menyetujui permintaan Anda! Silakan klik tombol di bawah untuk membuat password baru.
                                </p>
                                <a href="${data.reset_url}"
                                    class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white font-bold py-3.5 px-6 rounded-xl text-sm tracking-wider uppercase flex items-center justify-center gap-2 shadow-lg transition transform hover:scale-[1.02]">
                                    <i class="fas fa-key"></i> Ganti Password Sekarang
                                    <i class="fas fa-arrow-right text-xs ml-1"></i>
                                </a>
                            `;
                            setTimeout(() => card.classList.remove('animate-bounce'), 1000);
                        }
                    } else if (data.status === 'rejected') {
                        clearInterval(pollInterval);
                        window.location.reload();
                    }
                })
                .catch(err => console.log('Poll check status:', err));
        }
    </script>
    @endif

</body>
</html>
