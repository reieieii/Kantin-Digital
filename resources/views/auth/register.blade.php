<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Kantin Digital SMKN 20 Jakarta</title>
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
            background-image: radial-gradient(circle at 100% 100%, #1e1b4b 0%, #0f172a 70%);
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
            border-color: #764ba2;
            outline: none;
            box-shadow: 0 0 0 2px rgba(118, 75, 162, 0.2);
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
        .btn-social:hover:not(:disabled) {
            background-color: #334155;
            border-color: #475569;
            transform: translateY(-2px);
        }
        .btn-gradient {
            background: linear-gradient(135deg, #f97316 0%, #764ba2 50%, #667eea 100%);
            background-size: 200% auto;
            transition: 0.5s;
            border: none;
        }
        .btn-gradient:hover {
            background-position: right center;
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.4);
            transform: scale(1.02);
        }
        .hero-gradient-text {
            background: linear-gradient(135deg, #f97316 0%, #c4b5fd 100%);
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
            background: linear-gradient(to left, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.1) 100%);
            pointer-events: none;
        }
        .field-error {
            color: #fca5a5;
            font-size: 0.75rem;
            margin-top: 0.375rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #fca5a5;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 sm:p-8">
    
    <div class="w-full max-w-6xl flex flex-row-reverse bg-glass rounded-3xl overflow-hidden shadow-2xl relative" style="min-height: 750px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7), 0 0 60px rgba(249, 115, 22, 0.15);">
        
        <!-- Background Glow Effects -->
        <div class="absolute top-0 right-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-orange-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-30"></div>
            <div class="absolute -bottom-40 right-20 w-96 h-96 bg-purple-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-30"></div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 p-8 sm:p-12 lg:p-14 flex flex-col justify-center relative z-10 my-auto">
            
            <div class="max-w-md mx-auto w-full">
                <!-- Logo -->
                <a href="{{ route('landing') }}" class="flex items-center space-x-3 mb-10 w-fit hover:opacity-80 transition">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-utensils text-orange-500 text-xl"></i>
                    </div>
                </a>

                <h1 class="text-3xl sm:text-4xl font-bold mb-3">Create an <span class="hero-gradient-text">Account</span></h1>
                <p class="text-gray-400 mb-6">Already have an account? <a href="{{ route('login') }}" class="text-orange-400 hover:text-orange-300 font-medium transition cursor-pointer">Sign in</a></p>

                {{-- Alert jika ada error validasi --}}
                @if ($errors->any())
                    <div class="alert-error rounded-xl px-4 py-3 mb-6">
                        <div class="flex items-center space-x-2 mb-1">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                            <span class="text-sm font-medium">Mohon periksa kembali isian kamu:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-1 pl-1 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Social Buttons -->
                <div class="flex space-x-4 mb-8">
                    {{-- Google --}}
                    <a href="{{ route('auth.google') }}"
                        class="flex-1 btn-social py-3 sm:py-3.5 rounded-xl flex items-center justify-center"
                        title="Daftar dengan Google">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-6 h-6">
                    </a>
                    {{-- Apple — belum tersedia --}}
                    <button type="button" disabled
                        class="flex-1 btn-social py-3 sm:py-3.5 rounded-xl flex items-center justify-center opacity-50 cursor-not-allowed"
                        title="Apple Login belum tersedia">
                        <i class="fab fa-apple text-white text-2xl"></i>
                    </button>
                    {{-- Facebook — belum tersedia --}}
                    <button type="button" disabled
                        class="flex-1 btn-social py-3 sm:py-3.5 rounded-xl flex items-center justify-center opacity-50 cursor-not-allowed"
                        title="Facebook Login belum tersedia">
                        <i class="fab fa-facebook text-blue-500 text-2xl"></i>
                    </button>
                </div>

                <!-- Divider -->
                <div class="flex items-center my-6">
                    <div class="flex-grow border-t border-gray-700"></div>
                    <span class="mx-4 text-gray-500 text-xs uppercase tracking-wider font-semibold">Or register with email</span>
                    <div class="flex-grow border-t border-gray-700"></div>
                </div>

                <!-- Register Form -->
                <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Nama --}}
                    <div>
                        <input
                            type="text"
                            name="name"
                            placeholder="Full Name"
                            value="{{ old('name') }}"
                            class="w-full input-dark rounded-xl px-5 py-3.5 sm:py-4 focus:ring-0 text-sm {{ $errors->has('name') ? 'input-error' : '' }}"
                            required
                            autocomplete="name">
                        @error('name')
                            <p class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <input
                            type="email"
                            name="email"
                            placeholder="Email Address"
                            value="{{ old('email') }}"
                            class="w-full input-dark rounded-xl px-5 py-3.5 sm:py-4 focus:ring-0 text-sm {{ $errors->has('email') ? 'input-error' : '' }}"
                            required
                            autocomplete="email">
                        @error('email')
                            <p class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                placeholder="Password (min. 8 karakter)"
                                class="w-full input-dark rounded-xl px-5 py-3.5 sm:py-4 focus:ring-0 pr-12 text-sm {{ $errors->has('password') ? 'input-error' : '' }}"
                                required
                                id="password"
                                autocomplete="new-password">
                            <button type="button" onclick="togglePassword('password', 'eye-icon-1')" class="absolute right-5 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-300">
                                <i class="fas fa-eye-slash" id="eye-icon-1"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <div class="relative">
                            <input
                                type="password"
                                name="password_confirmation"
                                placeholder="Confirm Password"
                                class="w-full input-dark rounded-xl px-5 py-3.5 sm:py-4 focus:ring-0 pr-12 text-sm {{ $errors->has('password_confirmation') ? 'input-error' : '' }}"
                                required
                                id="password-confirm"
                                autocomplete="new-password">
                            <button type="button" onclick="togglePassword('password-confirm', 'eye-icon-2')" class="absolute right-5 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-300">
                                <i class="fas fa-eye-slash" id="eye-icon-2"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full btn-gradient text-white font-bold py-4 rounded-xl mt-6 text-sm tracking-widest uppercase">
                        Sign Up
                    </button>
                </form>

                <p class="text-xs text-gray-500 text-center mt-8">
                    By signing up you agree with our <a href="#" class="text-orange-400 hover:text-orange-300 transition hover:underline">Terms of Services</a> and <a href="#" class="text-orange-400 hover:text-orange-300 transition hover:underline">Privacy Policy</a>
                </p>
            </div>
        </div>

        <!-- Left Side - Image -->
        <div class="hidden lg:block lg:w-1/2 p-6 z-10">
            <div class="w-full h-full image-container shadow-2xl relative group">
                <!-- Inner glow for image -->
                <div class="absolute inset-0 border border-white/10 rounded-1.5xl z-20 pointer-events-none"></div>
                
                <img src="https://images.unsplash.com/photo-1543339308-43e59d6b73a6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                     alt="Dining Background" 
                     class="w-full h-full object-cover rounded-xl transition duration-700 group-hover:scale-105 filter brightness-[0.6] contrast-125 saturate-150">
                     
                <!-- Text overlay on image -->
                <div class="absolute bottom-10 left-10 z-30 text-left">
                    <h3 class="text-2xl font-bold text-white mb-2 shadow-sm drop-shadow-lg">Rasa Terbaik</h3>
                    <p class="text-white/80 text-sm max-w-xs shadow-sm drop-shadow-md">Bergabunglah dengan siswa lainnya untuk mendapatkan makanan cepat, enak, dan murah.</p>
                </div>
            </div>
        </div>
        
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const pwd = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
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
