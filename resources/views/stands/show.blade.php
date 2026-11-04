<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $stand->nama_stand }} - Kantin Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Quantity management
        const quantities = {};
        
        @foreach($stand->produks as $produk)
            quantities[{{ $produk->id }}] = 1;
        @endforeach
        
        function updateQuantity(productId, maxQuantity) {
            const currentQuantity = quantities[productId] || 1;
            const newQuantity = currentQuantity === maxQuantity ? 1 : currentQuantity + 1;
            
            quantities[productId] = newQuantity;
            
            // Update display
            document.getElementById(`quantity-${productId}`).textContent = newQuantity;
            
            // Update button states
            const minusBtn = document.getElementById(`minus-${productId}`);
            const plusBtn = document.getElementById(`plus-${productId}`);
            
            if(newQuantity <= 1) {
                minusBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                minusBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
            
            if(newQuantity >= maxQuantity) {
                plusBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                plusBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
        
        function addToCart(productId) {
            const quantity = quantities[productId] || 1;
            
            $.ajax({
                url: '/cart/add',
                method: 'POST',
                data: {
                    product_id: productId,
                    quantity: quantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Show success message
                    showNotification('Produk ditambahkan ke keranjang!', 'success');
                    
                    // Update cart count in header (if exists)
                    updateCartCount(response.cart_count);
                    
                    // Reset quantity to 1
                    quantities[productId] = 1;
                    document.getElementById(`quantity-${productId}`).textContent = '1';
                },
                error: function() {
                    showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
                }
            });
        }
        
        function updateCartCount(count) {
            // Update cart count in navigation if it exists
            const cartCountElement = document.getElementById('cart-count');
            if(cartCountElement) {
                cartCountElement.textContent = count;
            }
        }
        
        function showNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
                    ${message}
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
        
        // Test function for debugging
        function testModal() {
            console.log('Test modal button clicked');
            alert('JavaScript is working!');
            openPaymentModal(1, 'Test Product', 10000, 'default.jpg');
        }
        
        // Modal Payment Functions
        let currentProduct = {
            id: null,
            name: '',
            price: 0,
            image: ''
        };
        
        function openPaymentModal(element) {
            if (!element) return;
            
            const productId = element.getAttribute('data-id');
            const productName = element.getAttribute('data-name');
            const productPrice = parseFloat(element.getAttribute('data-price'));
            const productImage = element.getAttribute('data-image');
            
            console.log('Opening payment modal for:', productName);
            
            currentProduct = {
                id: productId,
                name: productName,
                price: productPrice,
                image: productImage
            };
            
            // Set product info
            const nameEl = document.getElementById('modalProductName');
            const priceEl = document.getElementById('modalProductPrice');
            const imgEl = document.getElementById('modalProductImage');
            
            if (nameEl) nameEl.textContent = productName;
            if (priceEl) priceEl.textContent = 'Rp ' + productPrice.toLocaleString('id-ID');
            if (imgEl) {
                imgEl.src = productImage;
                imgEl.onerror = function() {
                    this.src = 'https://via.placeholder.com/64x64?text=Food';
                };
            }
            
            // Reset form fields
            const fields = ['modalQuantity', 'modalNama', 'modalEmail', 'modalTelepon', 'modalAlamat'];
            fields.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    if (id === 'modalQuantity') el.value = 1;
                    else el.value = '';
                }
            });
            
            const tunaiRadio = document.querySelector('input[name="modal_payment_method"][value="tunai"]');
            if (tunaiRadio) tunaiRadio.checked = true;
            
            // Update total and hide QR
            updateModalTotal();
            const qrSection = document.getElementById('modalQrSection');
            if (qrSection) qrSection.classList.add('hidden');
            
            // Show modal
            const modal = document.getElementById('paymentModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }
        
        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
            document.getElementById('paymentModal').classList.remove('flex');
        }
        
        function increaseModalQuantity() {
            const input = document.getElementById('modalQuantity');
            input.value = parseInt(input.value) + 1;
            updateModalTotal();
        }
        
        function decreaseModalQuantity() {
            const input = document.getElementById('modalQuantity');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                updateModalTotal();
            }
        }
        
        function updateModalTotal() {
            const quantity = parseInt(document.getElementById('modalQuantity').value);
            const total = currentProduct.price * quantity;
            document.getElementById('modalTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
        
        function processModalPayment() {
            const nama = document.getElementById('modalNama').value.trim();
            if (!nama) {
                showNotification('Nama lengkap harus diisi!', 'error');
                return;
            }
            
            const quantity = parseInt(document.getElementById('modalQuantity').value);
            const paymentMethod = document.querySelector('input[name="modal_payment_method"]:checked').value;
            const email = document.getElementById('modalEmail').value.trim();
            const telepon = document.getElementById('modalTelepon').value.trim();
            const alamat = document.getElementById('modalAlamat').value.trim();
            
            // Add to cart first
            const cartData = {
                product_id: currentProduct.id,
                quantity: quantity,
                _token: '{{ csrf_token() }}'
            };
            
            $.ajax({
                url: '/cart/add',
                method: 'POST',
                data: cartData,
                success: function(response) {
                    // Process payment
                    const paymentData = {
                        payment_method: paymentMethod,
                        nama_pembeli: nama,
                        email: email,
                        no_telepon: telepon,
                        alamat: alamat,
                        catatan: '',
                        _token: '{{ csrf_token() }}'
                    };
                    
                    $.ajax({
                        url: '/pembelians/process-payment',
                        method: 'POST',
                        data: paymentData,
                        success: function(paymentResponse) {
                            closePaymentModal();
                            showNotification('Pembayaran berhasil! Pesanan Anda sedang diproses.', 'success');
                            
                            // Redirect to success page
                            setTimeout(() => {
                                window.location.href = paymentResponse.redirect_url;
                            }, 1000);
                        },
                        error: function() {
                            showNotification('Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.', 'error');
                        }
                    });
                },
                error: function() {
                    showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
                }
            });
        }
        
        // Payment method selection in modal
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.payment-method-modal').forEach(label => {
                label.addEventListener('click', function() {
                    // Remove active state from all
                    document.querySelectorAll('.payment-method-modal').forEach(l => {
                        l.classList.remove('border-blue-500', 'bg-blue-50');
                        l.classList.add('border-gray-300');
                    });
                    
                    // Add active state to selected
                    this.classList.remove('border-gray-300');
                    this.classList.add('border-blue-500', 'bg-blue-50');
                    
                    // Show/hide QR section
                    const method = this.dataset.method;
                    const qrSection = document.getElementById('modalQrSection');
                    const paymentApp = document.getElementById('modalPaymentApp');
                    
                    if (method === 'gopay' || method === 'dana') {
                        qrSection.classList.remove('hidden');
                        paymentApp.textContent = method === 'gopay' ? 'GoPay' : 'Dana';
                    } else {
                        qrSection.classList.add('hidden');
                    }
                });
            });
            
            // Set initial active state
            document.querySelector('.payment-method-modal[data-method="tunai"]').click();
            
            // Quantity input change handler
            document.getElementById('modalQuantity').addEventListener('input', updateModalTotal);
        });
        
        // Initialize Search and Filter Logic
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('productSearch');
            const categorySelect = document.getElementById('categoryFilter');
            const productCards = document.querySelectorAll('.product-card');

            function filterProducts() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedCategory = categorySelect.value;

                productCards.forEach(card => {
                    const name = card.dataset.name;
                    const category = card.dataset.category;
                    const matchesSearch = name.includes(searchTerm);
                    const matchesCategory = selectedCategory === 'all' || category === selectedCategory;

                    if (matchesSearch && matchesCategory) {
                        card.style.display = 'flex';
                        card.style.opacity = '1';
                    } else {
                        card.style.display = 'none';
                        card.style.opacity = '0';
                    }
                });
            }

            if(searchInput) searchInput.addEventListener('input', filterProducts);
            if(categorySelect) categorySelect.addEventListener('change', filterProducts);
        });

        // Initialize button states
        document.addEventListener('DOMContentLoaded', function() {
            @foreach($stand->produks as $produk)
                (function() {
                    const minusBtn = document.getElementById('minus-{{ $produk->id }}');
                    if(minusBtn) {
                        minusBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                })();
            @endforeach
        });
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .banner-gradient {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #f59e0b, #f97316);
            transition: all 0.3s ease;
        }
        
        .btn-buy {
            background: linear-gradient(45deg, #667eea, #764ba2);
            transition: all 0.3s ease;
        }

        .product-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        /* Aspect ratio for images if browser doesn't support it */
        .aspect-card {
            aspect-ratio: 4/3;
        }
    </style>
    <style>
        .bg-gray-50 { background-color: #f9fafb; }
        .bg-white { background-color: white; }
        .bg-gray-100 { background-color: #f3f4f6; }
        .bg-gray-800 { background-color: #1f2937; }
        .bg-gray-900 { background-color: #111827; }
        .bg-green-100 { background-color: #dcfce7; }
        .bg-green-800 { background-color: #166534; }
        .bg-red-100 { background-color: #fef2f2; }
        .bg-red-800 { background-color: #991b1b; }
        .bg-blue-50 { background-color: #eff6ff; }
        .border-b { border-bottom-width: 1px; border-bottom-color: #e5e7eb; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        .px-8 { padding-left: 2rem; padding-right: 2rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .w-6 { width: 1.5rem; }
        .w-full { width: 100%; }
        .h-40 { height: 10rem; }
        .h-64 { height: 16rem; }
        .h-48 { height: 12rem; }
        .h-80 { height: 20rem; }
        .object-cover { object-fit: cover; }
        .hover\:bg-blue-700:hover { background-color: #1d4ed8; }
        .hover\:shadow-xl:hover { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
        .hover\:text-blue-200:hover { color: #bfdbfe; }
        .hover\:text-blue-800:hover { color: #1e40af; }
        .hover\:text-blue-400:hover { color: #60a5fa; }
        .transition { transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
        .cursor-pointer { cursor: pointer; }
        .overflow-hidden { overflow: hidden; }
        .hidden { display: none; }
        .block { display: block; }
        .md\:flex { display: none; }
        .md\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        @media (min-width: 768px) { .md\:flex { display: flex; } .md\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); } }
        .text-xs { font-size: 0.75rem; line-height: 1rem; }
        .disabled\:bg-gray-400:disabled { background-color: #9ca3af; }
        .max-w-2xl { max-width: 42rem; }
        .max-w-7xl { max-width: 80rem; }
        .mx-auto { margin-left: auto; margin-right: auto; }
        .text-left { text-align: left; }
        
        /* New Styles for Redesign */
        .banner-gradient {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .btn-buy {
            background: linear-gradient(45deg, #2563eb, #7c3aed);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-orange-gradient {
            background: linear-gradient(45deg, #f59e0b, #f97316);
            transition: all 0.3s ease;
        }
        
        .btn-buy:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 hero-gradient shadow-lg">
        <div class="container mx-auto px-6 py-4">
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
                
                <div class="hidden md:flex items-center space-x-10">
                    <a href="{{ url('/') }}" class="text-sm font-bold text-white/80 hover:text-white transition-colors">Beranda</a>
                    <a href="{{ url('/stands') }}" class="text-sm font-bold text-white/80 hover:text-white transition-colors">Daftar Stand</a>
                    <a href="{{ url('/cart') }}" class="relative text-white/80 hover:text-white transition-all p-2 bg-white/10 rounded-xl border border-white/10 group">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        <span id="cart-count" class="absolute -top-1 -right-1 bg-gradient-to-br from-orange-400 to-orange-600 text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm">0</span>
                    </a>
                    <a href="{{ url('/pembelians') }}" class="btn-orange-gradient text-sm font-black text-white px-6 py-2.5 rounded-xl hover:scale-105 transition-all shadow-md hover:shadow-lg shadow-orange-900/20 text-center">
                        <i class="fas fa-receipt mr-2"></i>Pesanan Saya
                    </a>
                </div>
                
                <button class="md:hidden w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-white">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Spacer for fixed Nav -->
    <div class="h-24"></div>

    <!-- Breadcrumb -->
    <div class="container mx-auto px-6 mb-8">
        <nav class="flex items-center space-x-3 text-xs font-bold uppercase tracking-widest">
            <a href="{{ route('landing') }}" class="text-slate-400 hover:text-blue-600 transition-colors">Beranda</a>
            <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
            <a href="{{ route('stands.index') }}" class="text-slate-400 hover:text-blue-600 transition-colors">Semua Stand</a>
            <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
            <span class="text-blue-600">{{ $stand->nama_stand }}</span>
        </nav>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-6 pb-24">

        
        <!-- Banner Section -->
        <div class="banner-gradient rounded-[2.5rem] overflow-hidden mb-12 relative border border-gray-100 shadow-sm">
            <div class="absolute inset-0 z-0">
                <div class="absolute top-10 left-10 w-24 h-24 bg-blue-500/5 rounded-full floating"></div>
                <div class="absolute bottom-10 right-1/4 w-32 h-32 bg-purple-500/5 rounded-full floating" style="animation-delay: 1.5s;"></div>
            </div>
            
            <div class="container mx-auto">
                <div class="grid md:grid-cols-2 gap-12 items-center relative z-10 p-8 md:p-16">
                    <div class="order-2 md:order-1 slide-in">
                        <div class="flex items-center space-x-3 mb-6">
                            @if($stand->status_buka)
                                <span class="bg-green-100 text-green-700 px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-widest flex items-center shadow-sm">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span> Buka Sekarang
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-widest flex items-center shadow-sm">
                                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span> Tutup Sementara
                                </span>
                            @endif
                            <span class="bg-blue-50 text-blue-700 px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-widest flex items-center border border-blue-100">
                                <i class="fas fa-check-circle mr-2"></i> Stand Terverifikasi
                            </span>
                        </div>
                        
                        <h1 class="text-3xl md:text-5xl font-bold text-slate-900 mb-5 leading-tight">
                            {{ $stand->nama_stand }}
                        </h1>
                        <p class="text-lg text-slate-500 mb-8 max-w-xl leading-relaxed">
                            {{ $stand->deskripsi }}
                        </p>
                        
                        <div class="flex flex-wrap gap-8 mb-8">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-white rounded-2xl shadow-md flex items-center justify-center border border-slate-50">
                                    <i class="fas fa-user-tie text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Pemilik</p>
                                    <p class="text-sm font-bold text-slate-800">{{ $stand->pemilik }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-white rounded-2xl shadow-md flex items-center justify-center border border-slate-50">
                                    <i class="fas fa-phone-alt text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Kontak</p>
                                    <p class="text-sm font-bold text-slate-800">{{ $stand->no_telepon }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-4">
                            <a href="#produk-section" class="btn-buy px-10 py-4 rounded-2xl font-black text-white shadow-[0_10px_30px_rgba(102,126,234,0.3)] hover:shadow-[0_15px_35px_rgba(102,126,234,0.4)] transition-all flex items-center group">
                                <span>Lihat Menu Lengkap</span>
                                <i class="fas fa-arrow-down ml-3 group-hover:translate-y-1 transition-transform"></i>
                            </a>
                            <button class="bg-white text-slate-800 px-10 py-4 rounded-2xl font-black border border-slate-200 hover:bg-slate-50 transition-all shadow-sm">
                                Ikuti Stand
                            </button>
                        </div>
                    </div>
                    
                    <div class="order-1 md:order-2 relative px-4 text-center">
                        <div class="relative inline-block z-10 floating">
                            @php
                                $bannerImg = null;
                                if (!empty($stand->gambar)) {
                                    if (str_starts_with($stand->gambar, 'http')) {
                                        $bannerImg = (str_contains($stand->gambar, 'placeholder') || str_contains($stand->gambar, 'via.placeholder'))
                                            ? null
                                            : $stand->gambar;
                                    } else {
                                        $bannerImg = asset('storage/' . $stand->gambar);
                                    }
                                }
                                $fallbackImg = 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&q=80&w=800';
                            @endphp
                            <img src="{{ $bannerImg ?? $fallbackImg }}"
                                 alt="{{ $stand->nama_stand }}"
                                 onerror="this.onerror=null;this.src='{{ $fallbackImg }}';"
                                 class="w-full max-w-[450px] h-[450px] object-cover rounded-[3rem] shadow-[0_25px_60px_rgba(0,0,0,0.1)] border-[10px] border-white mx-auto">
                            
                            <!-- Floating Badge -->
                            <div class="absolute -bottom-10 -left-6 bg-white p-6 rounded-[2rem] shadow-2xl z-20 hidden lg:block border border-slate-50 text-left">
                                <div class="flex items-center space-x-4">
                                    <div class="bg-yellow-400 w-12 h-12 rounded-2xl flex items-center justify-center">
                                        <i class="fas fa-star text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-xl font-black text-slate-800">4.9/5.0</p>
                                        <p class="text-xs text-slate-400 font-bold">Rating Stand</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div id="produk-section" class="py-8">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mb-2">Produk Tersedia</h2>
                    <p class="text-slate-500 text-sm font-medium">Temukan hidangan favoritmu dari stand ini</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 w-full lg:max-w-2xl">
                    <!-- Modern Search Bar -->
                    <div class="relative flex-1 group">
                        <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 transition-colors"></i>
                        <input type="text" id="productSearch" placeholder="Mau makan apa hari ini?" 
                               class="w-full pl-14 pr-6 py-4 rounded-2xl border border-slate-200 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all bg-white text-slate-700 font-medium shadow-sm text-sm">
                    </div>
                    
                    <!-- Category Dropdown -->
                    <div class="relative">
                        <select id="categoryFilter" class="appearance-none w-full sm:w-48 pl-6 pr-12 py-4 rounded-2xl border border-slate-200 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all bg-white text-slate-700 font-bold shadow-sm cursor-pointer text-sm">
                            <option value="all">Semua Kategori</option>
                            <option value="Makanan">Makanan</option>
                            <option value="Minuman">Minuman</option>
                            <option value="Snack">Cemilan</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-[10px]"></i>
                    </div>
                </div>
            </div>
            
            @if($stand->produks->count() > 0)
                <div id="productGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
                    @foreach($stand->produks as $produk)
                        <div class="product-card bg-white rounded-[3rem] overflow-hidden border border-slate-100 group flex flex-col h-full hover:border-blue-100" 
                             data-name="{{ strtolower($produk->nama_produk) }}" 
                             data-category="{{ $produk->kategori }}">
                             
                            <!-- Modern Card Image Wrapper -->
                            <div class="relative h-64 overflow-hidden p-3 pb-0">
                                <div class="w-full h-full overflow-hidden rounded-[2.2rem] relative">
                                    @php
                                        $foodPlaceholders = [
                                            'https://images.unsplash.com/photo-1569050467447-ce54b3bbc37d?auto=format&fit=crop&q=80&w=500', // nasi goreng
                                            'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&q=80&w=500', // fried chicken
                                            'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&q=80&w=500', // mie goreng
                                            'https://images.unsplash.com/photo-1562802378-063ec186a863?auto=format&fit=crop&q=80&w=500', // pizza
                                            'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&q=80&w=500', // burger
                                            'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=500', // healthy bowl
                                            'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&q=80&w=500', // grilled fish
                                            'https://images.unsplash.com/photo-1567620905732-2d1ec7bb7445?auto=format&fit=crop&q=80&w=500', // eggs toast
                                            'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&q=80&w=500', // pizza slice
                                            'https://images.unsplash.com/photo-1482049016688-2d3e1b311543?auto=format&fit=crop&q=80&w=500', // fried food
                                            'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&q=80&w=500', // salad bowl
                                            'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=500', // pasta
                                            'https://images.unsplash.com/photo-1551782450-a2132b4ba21d?auto=format&fit=crop&q=80&w=500', // burger close
                                            'https://images.unsplash.com/photo-1563379926898-05f4575a45d8?auto=format&fit=crop&q=80&w=500', // noodles
                                            'https://images.unsplash.com/photo-1455619452474-d2be8b1e70cd?auto=format&fit=crop&q=80&w=500', // curry
                                            'https://images.unsplash.com/photo-1464219551459-ac14ae01fbe0?auto=format&fit=crop&q=80&w=500', // sandwiches
                                            'https://images.unsplash.com/photo-1432139509613-5c4255815697?auto=format&fit=crop&q=80&w=500', // salad
                                            'https://images.unsplash.com/photo-1470124182917-cc6e71b22ecc?auto=format&fit=crop&q=80&w=500', // fried rice
                                            'https://images.unsplash.com/photo-1496116218417-1a781b1c416c?auto=format&fit=crop&q=80&w=500', // prawn
                                            'https://images.unsplash.com/photo-1473093226795-af9932fe5856?auto=format&fit=crop&q=80&w=500', // mixed meal
                                        ];
                                        // Only use the database image if it's a locally uploaded file
                                        $dbImg = $produk->gambar;
                                        $isLocalUpload = !empty($dbImg) && !str_starts_with($dbImg, 'http') && file_exists(public_path('storage/' . $dbImg));
                                        $productImg = $isLocalUpload
                                            ? asset('storage/' . $dbImg)
                                            : $foodPlaceholders[$produk->id % count($foodPlaceholders)];
                                        $fallbackImg = $foodPlaceholders[($produk->id + 5) % count($foodPlaceholders)];
                                    @endphp
                                    <img src="{{ $productImg }}" alt="{{ $produk->nama_produk }}" 
                                         onerror="this.onerror=null;this.src='{{ $fallbackImg }}';"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 ease-out">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                </div>
                                
                                <!-- Status Badge Overlay -->
                                <div class="absolute top-6 left-6 z-20">
                                    @if($produk->tersedia && $produk->stock > 0)
                                        <span class="bg-white/95 backdrop-blur-md text-green-600 px-4 py-1.5 rounded-full text-[11px] font-black uppercase tracking-widest shadow-lg border border-white">
                                            <i class="fas fa-check-circle mr-2"></i> Tersedia
                                        </span>
                                    @else
                                        <span class="bg-white/95 backdrop-blur-md text-red-500 px-4 py-1.5 rounded-full text-[11px] font-black uppercase tracking-widest shadow-lg border border-white">
                                            <i class="fas fa-clock mr-2"></i> Habis
                                        </span>
                                    @endif
                                </div>

                                <!-- Like Button -->
                                <button class="absolute top-6 right-6 w-11 h-11 bg-white/95 backdrop-blur-md rounded-2xl flex items-center justify-center text-slate-400 hover:text-red-500 hover:scale-110 transition-all duration-300 shadow-lg border border-white opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0">
                                    <i class="far fa-heart text-xl"></i>
                                </button>
                            </div>
                            
                            <!-- Enhanced Product Info -->
                            <div class="p-6 flex flex-col flex-1">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="px-2.5 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-bold uppercase tracking-wider">{{ $produk->kategori }}</span>
                                    <div class="flex items-center text-yellow-400">
                                        <i class="fas fa-star text-[10px] mr-1.5"></i>
                                        <span class="text-slate-900 font-bold text-xs">4.8</span>
                                        <span class="text-slate-400 text-[10px] font-medium ml-1">(120)</span>
                                    </div>
                                </div>
                                
                                <h4 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition-colors line-clamp-1 h-7">{{ $produk->nama_produk }}</h4>
                                <p class="text-xs text-slate-450 mb-6 font-medium leading-relaxed line-clamp-2 h-8">{{ $produk->deskripsi }}</p>
                                
                                <div class="mt-auto">
                                    <div class="flex items-center justify-between mb-6">
                                        <div>
                                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Harga</p>
                                            <p class="text-xl font-bold text-slate-900 leading-none">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Stok</p>
                                            <p class="text-xs font-bold text-slate-800">{{ $produk->stock }} pcs</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Premium Interaction Buttons -->
                                    <div class="flex gap-3">
                                        @if($produk->tersedia && $produk->stock > 0)
                                            <button onclick="addToCart({{ $produk->id }})" 
                                                    class="w-12 h-11 bg-slate-900 text-white rounded-xl font-bold text-sm hover:bg-slate-800 transition-all flex items-center justify-center shadow-lg active:scale-95">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button type="button" 
                                                    onclick="openPaymentModal(this)"
                                                    data-id="{{ $produk->id }}"
                                                    data-name="{{ $produk->nama_produk }}"
                                                    data-price="{{ $produk->harga }}"
                                                    data-image="{{ $productImg }}"
                                                    class="flex-1 btn-buy h-11 rounded-xl font-semibold text-white text-xs shadow-md flex items-center justify-center gap-2 group/btn active:scale-95">
                                                <span class="uppercase tracking-widest">Beli Sekarang</span>
                                                <i class="fas fa-shopping-cart text-[10px] group-hover/btn:translate-x-1 transition-transform"></i>
                                            </button>
                                        @else
                                            <button class="w-full bg-slate-50 text-slate-400 h-11 rounded-xl font-bold text-[10px] cursor-not-allowed flex items-center justify-center gap-2 border border-slate-100" disabled>
                                                <i class="fas fa-info-circle"></i>
                                                <span class="uppercase tracking-widest">Maaf, Stok Habis</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-32 bg-slate-50/50 rounded-[4rem] border-2 border-dashed border-slate-200">
                    <div class="w-28 h-28 bg-white rounded-[2.5rem] flex items-center justify-center mx-auto mb-8 shadow-xl border border-slate-100">
                        <i class="fas fa-utensils text-4xl text-slate-200"></i>
                    </div>
                    <h3 class="text-3xl font-black text-slate-900 mb-4">Menu Belum Tersedia</h3>
                    <p class="text-lg text-slate-400 font-medium max-w-sm mx-auto leading-relaxed">Stand ini sedang mempersiapkan hidangan spesial. Kembali lagi nanti ya!</p>
                </div>
            @endif
        </div>
    </main>

    <!-- Modal Pembayaran -->
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-[2.5rem] max-w-md w-full max-h-[90vh] flex flex-col overflow-hidden shadow-2xl">
            <!-- Header Modal -->
            <div class="hero-gradient text-white p-6 flex justify-between items-center shrink-0">
                <div>
                    <h3 class="text-xl font-black tracking-tight">Checkout Cepat</h3>
                    <p class="text-xs text-white/70 font-bold uppercase tracking-widest">Selesaikan Pesananmu</p>
                </div>
                <button onclick="closePaymentModal()" class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center hover:bg-white/30 transition-all">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <!-- Content Modal -->
            <div class="p-6 overflow-y-auto custom-scrollbar">
                <!-- Info Produk -->
                <div class="bg-gray-50 rounded-[1.5rem] p-4 mb-6 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <img id="modalProductImage" src="" alt="" class="w-16 h-16 object-cover rounded-lg">
                        <div class="flex-1">
                            <h4 id="modalProductName" class="font-semibold text-gray-800"></h4>
                            <p class="text-sm text-gray-600">Harga: <span id="modalProductPrice"></span></p>
                        </div>
                    </div>
                </div>

                <!-- Quantity Selector -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah</label>
                    <div class="flex items-center gap-3">
                        <button onclick="decreaseModalQuantity()" class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition">
                            <i class="fas fa-minus text-gray-600"></i>
                        </button>
                        <input type="number" id="modalQuantity" value="1" min="1" class="w-20 text-center border border-gray-300 rounded-lg py-2">
                        <button onclick="increaseModalQuantity()" class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition">
                            <i class="fas fa-plus text-gray-600"></i>
                        </button>
                    </div>
                </div>

                <!-- Metode Pembayaran -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Pilih Metode Pembayaran</label>
                    <div class="space-y-2">
                        <label class="flex items-center gap-3 p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition payment-method-modal" data-method="tunai">
                            <input type="radio" name="modal_payment_method" value="tunai" class="w-4 h-4 text-blue-600" checked>
                            <div class="flex items-center gap-3 flex-1">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-money-bill-wave text-green-600"></i>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-800">Tunai</h5>
                                    <p class="text-xs text-gray-600">Bayar langsung di tempat</p>
                                </div>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition payment-method-modal" data-method="gopay">
                            <input type="radio" name="modal_payment_method" value="gopay" class="w-4 h-4 text-blue-600">
                            <div class="flex items-center gap-3 flex-1">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fab fa-gopay text-blue-600"></i>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-800">GoPay</h5>
                                    <p class="text-xs text-gray-600">Scan QR Code</p>
                                </div>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition payment-method-modal" data-method="dana">
                            <input type="radio" name="modal_payment_method" value="dana" class="w-4 h-4 text-blue-600">
                            <div class="flex items-center gap-3 flex-1">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-wallet text-blue-600"></i>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-800">Dana</h5>
                                    <p class="text-xs text-gray-600">Scan QR Code</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- QR Code Section (Hidden by default) -->
                <div id="modalQrSection" class="hidden mb-6">
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <h5 class="font-semibold text-gray-800 mb-3">Scan QR Code</h5>
                        <div class="w-32 h-32 mx-auto bg-white rounded-lg flex items-center justify-center mb-3">
                            <i class="fas fa-qrcode text-4xl text-gray-400"></i>
                        </div>
                        <p class="text-sm text-gray-600">Scan dengan <span id="modalPaymentApp">GoPay</span></p>
                    </div>
                </div>

                <!-- Total -->
                <div class="border-t pt-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-800">Total:</span>
                        <span id="modalTotal" class="text-xl font-bold text-blue-600"></span>
                    </div>
                </div>

                <!-- Form Data Pembeli -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Data Pembeli</label>
                    <div class="space-y-3">
                        <input type="text" id="modalNama" placeholder="Nama Lengkap *" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <input type="email" id="modalEmail" placeholder="Email (opsional)"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <input type="tel" id="modalTelepon" placeholder="No. Telepon (opsional)"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <textarea id="modalAlamat" placeholder="Kelas" rows="2"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </div>

                <!-- Tombol Bayar -->
                <button onclick="processModalPayment()" id="modalPayBtn" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-black shadow-xl shadow-slate-200 hover:bg-slate-800 transition-all flex items-center justify-center gap-3 active:scale-95">
                    <i class="fas fa-credit-card text-xs"></i>
                    <span>Bayar Sekarang</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Kantin Digital SMK Negeri 1 Jakarta. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
