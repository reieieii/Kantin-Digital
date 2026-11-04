<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kantin Digital SMKN 20 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
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
        .input-error {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2) !important;
        }
        .btn-social {
            background-color: #1e293b;
            border: 1px solid #334155;
            transition: all 0.3s ease;
        }
        .btn-social:hover {
            background-color: #334155;
            border-color: #475569;
            transform: translateY(-2px);
        }
        .btn-social:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f97316 100%);
            background-size: 200% auto;
            transition: 0.5s;
            border: none;
        }
        .btn-gradient:hover {
            background-position: right center;
            box-shadow: 0 10px 25px rgba(118, 75, 162, 0.5);
            transform: scale(1.02);
        }
        .hero-gradient-text {
            background: linear-gradient(135deg, #c4b5fd 0%, #f97316 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .image-container {
            position: relative;
            overflow: hidden;
            border-radius: 1.5rem;
        }
        .image-container::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.1) 100%);
            pointer-events: none;
        }
        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.4);
            color: #6ee7b7;
        }
        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #fca5a5;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 sm:p-8">
    
    <div class="w-full max-w-6xl flex bg-glass rounded-3xl overflow-hidden shadow-2xl relative" style="min-height: 750px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7), 0 0 60px rgba(102, 126, 234, 0.15);">
        
        <!-- Background Glow Effects -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div class="absolute -top-40 -left-40 w-96 h-96 bg-purple-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-40"></div>
            <div class="absolute -bottom-40 left-20 w-96 h-96 bg-orange-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-20"></div>
        </div>

        <!-- Left Side - Form -->
        <div class="w-full lg:w-1/2 p-8 sm:p-12 lg:p-14 flex flex-col justify-center relative z-10 my-auto">
            
            <div class="max-w-md mx-auto w-full">
                <!-- Logo -->
                <a href="{{ route('landing') }}" class="flex items-center space-x-3 mb-10 w-fit hover:opacity-80 transition">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-utensils text-orange-500 text-xl"></i>
                    </div>
                </a>

                <h1 class="text-3xl sm:text-4xl font-bold mb-3">Welcome to <span class="hero-gradient-text">Kantin Digital</span></h1>
                <p class="text-gray-400 mb-6">Don't have an account? <a href="{{ route('register') }}" class="text-purple-400 hover:text-purple-300 font-medium transition cursor-pointer">Sign up</a></p>

                {{-- Flash messages --}}
                @if (session('success'))
                    <div class="alert-success rounded-xl px-4 py-3 mb-6 flex items-center space-x-2">
                        <i class="fas fa-check-circle text-emerald-400"></i>
                        <span class="text-sm">{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Error umum (email/password salah) --}}
                @if ($errors->has('email') && !$errors->has('name'))
                    <div class="alert-error rounded-xl px-4 py-3 mb-6 flex items-center space-x-2">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                        <span class="text-sm">{{ $errors->first('email') }}</span>
                    </div>
                @endif

                <!-- Social Buttons -->
                <div class="space-y-3 mb-8">
                    {{-- Google — mengarah ke route OAuth --}}
                    <a href="{{ route('auth.google') }}" class="w-full btn-social py-3 sm:py-3.5 rounded-xl flex items-center justify-center space-x-3 no-underline">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5">
                        <span class="text-gray-300 font-medium tracking-wide text-sm">Continue with Google</span>
                    </a>

                    {{-- Apple — belum tersedia --}}
                    <button type="button" disabled title="Fitur Apple Login belum tersedia"
                        class="w-full btn-social py-3 sm:py-3.5 rounded-xl flex items-center justify-center space-x-3 cursor-not-allowed opacity-50">
                        <i class="fab fa-apple text-white text-xl"></i>
                        <span class="text-gray-400 font-medium tracking-wide text-sm">Continue with Apple <span class="text-xs">(segera hadir)</span></span>
                    </button>

                    {{-- Facebook — belum tersedia --}}
                    <button type="button" disabled title="Fitur Facebook Login belum tersedia"
                        class="w-full btn-social py-3 sm:py-3.5 rounded-xl flex items-center justify-center space-x-3 cursor-not-allowed opacity-50">
                        <i class="fab fa-facebook text-blue-500 text-xl"></i>
                        <span class="text-gray-400 font-medium tracking-wide text-sm">Continue with Facebook <span class="text-xs">(segera hadir)</span></span>
                    </button>
                </div>

                <!-- Divider -->
                <div class="flex items-center my-6">
                    <div class="flex-grow border-t border-gray-700"></div>
                    <span class="mx-4 text-gray-500 text-xs uppercase tracking-wider font-semibold">Or</span>
                    <div class="flex-grow border-t border-gray-700"></div>
                </div>

                <!-- Login Form -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <input
                            type="email"
                            name="email"
                            placeholder="Email"
                            value="{{ old('email') }}"
                            class="w-full input-dark rounded-xl px-5 py-3.5 sm:py-4 focus:ring-0 text-sm {{ $errors->has('email') ? 'input-error' : '' }}"
                            required
                            autocomplete="email">
                    </div>

                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            placeholder="Password"
                            class="w-full input-dark rounded-xl px-5 py-3.5 sm:py-4 focus:ring-0 pr-12 text-sm"
                            required
                            id="password"
                            autocomplete="current-password">
                        <button type="button" onclick="togglePassword()" class="absolute right-5 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-300">
                            <i class="fas fa-eye-slash" id="eye-icon"></i>
                        </button>
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded accent-orange-500">
                            <span class="text-xs text-gray-400">Ingat saya</span>
                        </label>
                        <a href="#" class="text-xs text-gray-400 hover:text-white transition">Forgot Password?</a>
                    </div>

                    <button type="submit" class="w-full btn-gradient text-white font-bold py-4 rounded-xl mt-4 text-sm tracking-widest uppercase">
                        Login
                    </button>
                </form>

                <p class="text-xs text-gray-500 text-center mt-8">
                    By logging in you agree with our <a href="#" class="text-purple-400 hover:text-purple-300 transition hover:underline">Terms of Services</a> and <a href="#" class="text-purple-400 hover:text-purple-300 transition hover:underline">Privacy Policy</a>
                </p>
            </div>
        </div>

        <!-- Right Side - Image -->
        <div class="hidden lg:block lg:w-1/2 p-6 z-10">
            <div class="w-full h-full image-container shadow-2xl relative group">
                <!-- Inner glow for image -->
                <div class="absolute inset-0 border border-white/10 rounded-1.5xl z-20 pointer-events-none"></div>
                
                <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                     alt="Food Background" 
                     class="w-full h-full object-cover rounded-xl transition duration-700 group-hover:scale-105 filter brightness-75 contrast-125 sepia-[.2]">
                     
                <!-- Text overlay on image -->
                <div class="absolute bottom-10 right-10 z-30 text-right">
                    <h3 class="text-2xl font-bold text-white mb-2 shadow-sm drop-shadow-lg">Mulai Beli Makanan</h3>
                    <p class="text-white/80 text-sm max-w-xs ml-auto shadow-sm drop-shadow-md">Pesan berbagai makanan favorit tanpa antri panjang. Kantin Digital SMKN 20 Jakarta.</p>
                </div>
            </div>
        </div>
        
    </div>

    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                pwd.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }
    </script>
</body>
</html>
