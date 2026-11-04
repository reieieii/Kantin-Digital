<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kantin Digital SMKN 20 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .feature-card {
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        
        .slide-in {
            animation: slideIn 0.8s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #fbbf24;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #f59e0b, #f97316);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid #ffffff;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-white/10 backdrop-blur-lg border-b border-white/20">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-utensils text-orange-500"></i>
                    </div>
                    <span class="text-white font-bold text-xl">Kantin Digital</span>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="nav-link text-white hover:text-yellow-300">Beranda</a>
                    <a href="#tentang" class="nav-link text-white hover:text-yellow-300">Tentang</a>
                    <a href="#layanan" class="nav-link text-white hover:text-yellow-300">Layanan</a>
                    <a href="#kontak" class="nav-link text-white hover:text-yellow-300">Kontak</a>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        {{-- User sudah login: tampilkan nama + dropdown --}}
                        <div class="relative hidden md:block" id="userMenuWrapper">
                            <button onclick="toggleUserMenu()"
                                class="flex items-center space-x-2 text-white hover:text-yellow-300 font-semibold transition focus:outline-none">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-orange-400 rounded-full flex items-center justify-center text-sm font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>

                            {{-- Dropdown menu --}}
                            <div id="userDropdown"
                                class="hidden absolute right-0 mt-2 w-48 rounded-xl shadow-2xl z-50 overflow-hidden"
                                style="background: rgba(15,23,42,0.95); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(12px);">
                                <div class="px-4 py-3 border-b border-white/10">
                                    <p class="text-xs text-gray-400">Masuk sebagai</p>
                                    <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-3 text-sm text-red-400 hover:bg-white/10 hover:text-red-300 transition flex items-center space-x-2">
                                        <i class="fas fa-right-from-bracket w-4"></i>
                                        <span>Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        {{-- Tamu: tampilkan tombol Masuk --}}
                        <a href="{{ route('login') }}" class="text-white hover:text-yellow-300 font-semibold hidden md:block transition mr-2">Masuk</a>
                    @endauth

                    <a href="{{ route('stands.index') }}" class="btn-primary text-white px-5 sm:px-6 py-2 rounded-full font-semibold text-sm sm:text-base">
                        <i class="fa-solid fa-store sm:mr-2"></i><span class="hidden sm:inline">Mulai Belanja</span><span class="sm:hidden">Belanja</span>
                    </a>
                    <button class="md:hidden text-white" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-white/10 backdrop-blur-lg border-b border-white/20">
            <div class="container mx-auto px-6 py-4 space-y-3">
                <a href="#beranda" class="block text-white hover:text-yellow-300 transition">Beranda</a>
                <a href="#tentang" class="block text-white hover:text-yellow-300 transition">Tentang</a>
                <a href="#layanan" class="block text-white hover:text-yellow-300 transition">Layanan</a>
                <a href="#kontak" class="block text-white hover:text-yellow-300 transition">Kontak</a>
                <div class="border-t border-white/20 pt-2 mt-2">
                    @auth
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-orange-400 rounded-full flex items-center justify-center text-sm font-bold text-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-white font-semibold text-sm">{{ Auth::user()->name }}</p>
                                <p class="text-gray-400 text-xs">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center space-x-2 text-red-400 hover:text-red-300 font-semibold transition text-sm">
                                <i class="fas fa-right-from-bracket"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block text-yellow-300 hover:text-yellow-400 font-bold transition">Masuk / Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="hero-gradient min-h-screen flex items-center relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-32 h-32 bg-yellow-400/20 rounded-full floating"></div>
            <div class="absolute top-40 right-20 w-24 h-24 bg-pink-400/20 rounded-full floating" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-20 left-1/4 w-40 h-40 bg-blue-400/20 rounded-full floating" style="animation-delay: 2s;"></div>
        </div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="slide-in">
                    <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                        Kantin Digital<br>
                        <span class="text-yellow-300">SMKN 20 Jakarta</span>
                    </h1>
                    <p class="text-xl text-white/90 mb-8 leading-relaxed">
                        Solusi modern untuk kebutuhan Anda. Pesan makanan favorit dengan mudah, cepat, dan aman melalui platform digital terpercaya.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('stands.index') }}" class="btn-primary text-white px-8 py-4 rounded-full font-semibold text-center">
                            <i class="fa-solid fa-cart-shopping mr-2"></i>Pesan Sekarang
                        </a>
                        <button class="btn-secondary text-white px-8 py-4 rounded-full font-semibold">
                            <i class="fas fa-heart mr-2"></i>Menu Favorit
                        </button>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 mt-12">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-yellow-300">50+</div>
                            <div class="text-white/80">Menu Makanan</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-yellow-300">8+</div>
                            <div class="text-white/80">Stand Kuliner</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-yellow-300">1000+</div>
                            <div class="text-white/80">Pelanggan Puas</div>
                        </div>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="floating">
                        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                             alt="Kantin Digital" 
                             class="rounded-2xl shadow-2xl w-full">
                    </div>
                    <!-- Floating Cards -->
                    <div class="absolute -top-6 -right-6 bg-white rounded-xl shadow-lg p-4 floating" style="animation-delay: 0.5s;">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">Pesanan Selesai</div>
                                <div class="text-sm text-gray-600">Dalam 5 menit</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute -bottom-6 -left-6 bg-white rounded-xl shadow-lg p-4 floating" style="animation-delay: 1.5s;">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-star text-orange-500"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">Rating 4.8</div>
                                <div class="text-sm text-gray-600">Dari 500+ ulasan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="layanan" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16 slide-in">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Mengapa Memilih Kami?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Platform kantin digital yang dirancang khusus untuk memenuhi kebutuhan Kantin Anda dengan kemudahan dan kenyamanan maksimal.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="feature-card rounded-2xl p-8 text-center slide-in">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Pemesanan Mudah</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Aplikasi user-friendly yang memudahkan Anda memesan makanan favorit hanya dengan beberapa klik.
                    </p>
                </div>
                
                <div class="feature-card rounded-2xl p-8 text-center slide-in" style="animation-delay: 0.2s;">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-bolt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Pelayanan Cepat</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Pesanan Anda diproses secara cepat dan siap diambil dalam waktu singkat tanpa antri lama.
                    </p>
                </div>
                
                <div class="feature-card rounded-2xl p-8 text-center slide-in" style="animation-delay: 0.4s;">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Pembayaran Aman</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Berbagai metode pembayaran yang aman dan terpercaya untuk kenyamanan transaksi Anda.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">Tentang Kantin Digital</h2>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        Kantin Digital SMKN 20 Jakarta adalah inovasi modern dalam layanan Kantin sekolah. Kami menghadirkan solusi teknologi untuk memudahkan siswa dan guru dalam memesan makanan di kantin sekolah.
                    </p>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Dengan sistem digital, kami menghilangkan antrian panjang, mempercepat pelayanan, dan memberikan pengalaman berbelanja yang menyenangkan dan efisien.
                    </p>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-users text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">Tim Profesional</div>
                                <div class="text-sm text-gray-600">Berpengalaman di bidang F&B</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-leaf text-green-600"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">Bahan Berkualitas</div>
                                <div class="text-sm text-gray-600">Hanya menggunakan bahan segar</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                         alt="About Us" 
                         class="rounded-2xl shadow-xl w-full">
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 hero-gradient">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">Siap Memulai Pengalaman Kantin Digital?</h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                Bergabunglah dengan ribuan siswa yang telah menikmati kemudahan berbelanja di Kantin Digital SMKN 20 Jakarta.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('stands.index') }}" class="btn-primary text-white px-8 py-4 rounded-full font-semibold text-center">
                    <i class="fa-solid fa-cart-shopping mr-2"></i>Mulai Belanja Sekarang
                </a>
                <button class="btn-secondary text-white px-8 py-4 rounded-full font-semibold">
                    <i class="fas fa-info-circle mr-2"></i>Info Lebih Lanjut
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-utensils text-white"></i>
                        </div>
                        <span class="font-bold text-xl">Kantin Digital</span>
                    </div>
                    <p class="text-gray-400">
                        Solusi modern untuk kebutuhan Kantin Anda di SMKN 20 Jakarta.
                    </p>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#beranda" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="#tentang" class="hover:text-white transition">Tentang</a></li>
                        <li><a href="#layanan" class="hover:text-white transition">Layanan</a></li>
                        <li><a href="{{ route('stands.index') }}" class="hover:text-white transition">Menu</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Layanan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Pesan Makanan</a></li>
                        <li><a href="#" class="hover:text-white transition">Delivery</a></li>
                        <li><a href="#" class="hover:text-white transition">Reservasi</a></li>
                        <li><a href="#" class="hover:text-white transition">Promo</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>SMKN 20 Jakarta</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-phone"></i>
                            <span>+62 21 1234 5678</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-envelope"></i>
                            <span>info@kantindigital.sch.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Kantin Digital SMKN 20 Jakarta. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Flash Notification -->
    @if (session('success'))
        <div id="flashNotif"
            class="fixed top-6 right-6 z-[9999] flex items-center space-x-3 px-5 py-4 rounded-2xl shadow-2xl text-sm font-medium text-white transition-all duration-500"
            style="background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.4); backdrop-filter: blur(12px);">
            <i class="fas fa-check-circle text-emerald-400 text-lg"></i>
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('flashNotif').remove()" class="ml-2 text-gray-400 hover:text-white">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        <script>
            setTimeout(() => {
                const el = document.getElementById('flashNotif');
                if (el) { el.style.opacity = '0'; setTimeout(() => el.remove(), 500); }
            }, 4000);
        </script>
    @endif

    <script>
        // User Dropdown
        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Tutup dropdown kalau klik di luar
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('userMenuWrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                document.getElementById('userDropdown')?.classList.add('hidden');
            }
        });

        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
        
        // Smooth Scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Navbar Background on Scroll
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('bg-white/20');
            } else {
                nav.classList.remove('bg-white/20');
            }
        });
        
        // Intersection Observer for Animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.slide-in').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.8s ease-out';
            observer.observe(el);
        });
    </script>
</body>
</html>
