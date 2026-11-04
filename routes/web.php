<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StandController as AdminStandController;
use App\Http\Controllers\Admin\ProdukController as AdminProdukController;
use App\Http\Controllers\Admin\PesananController as AdminPesananController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// ─── Auth Routes ────────────────────────────────────────────────────────────

Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->name('login.post');

    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/auth/google',          [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Admin Routes ────────────────────────────────────────────────────────────

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/',          [DashboardController::class, 'index'])->name('dashboard');

    // Stand CRUD
    Route::resource('stands',  AdminStandController::class)->except(['show']);

    // Produk CRUD
    Route::resource('produks', AdminProdukController::class)->except(['show']);

    // Pesanan
    Route::get   ('pesanans',                   [AdminPesananController::class, 'index'])->name('pesanans.index');
    Route::get   ('pesanans/{pesanan}',          [AdminPesananController::class, 'show'])->name('pesanans.show');
    Route::patch ('pesanans/{pesanan}/status',   [AdminPesananController::class, 'updateStatus'])->name('pesanans.updateStatus');
    Route::delete('pesanans/{pesanan}',          [AdminPesananController::class, 'destroy'])->name('pesanans.destroy');
});


// Stands
Route::get('/stands', [App\Http\Controllers\StandController::class, 'index'])->name('stands.index');
Route::get('/stands/{stand}', [App\Http\Controllers\StandController::class, 'show'])->name('stands.show');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');

// Pembelian - Implementasi Lengkap dengan Metode Pembayaran
Route::get('/pembelians', function () {
    $pembelians = \App\Models\Pembelian::with('detailPembelians.produk')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    
    return view('pembelians.index', compact('pembelians'));
})->name('pembelians.index');

Route::get('/pembelians/payment', function () {
    $cart = session('cart', []);
    
    // Jika keranjang kosong, redirect ke stands untuk memilih produk
    if (empty($cart)) {
        return redirect()->route('stands.index')
            ->with('info', 'Silakan pilih produk terlebih dahulu');
    }

    $totalHarga = 0;
    $cartItems = [];

    foreach ($cart as $productId => $item) {
        $produk = \App\Models\Produk::find($productId);
        if ($produk) {
            $subtotal = $item['quantity'] * $item['price'];
            $totalHarga += $subtotal;
            
            $cartItems[] = [
                'produk_id' => $productId,
                'nama_produk' => $produk->nama_produk,
                'quantity' => $item['quantity'],
                'harga' => $item['price'],
                'subtotal' => $subtotal,
                'gambar' => $item['image'] ?? $produk->gambar ?? 'default.jpg'
            ];
        }
    }

    return view('pembelians.payment', compact('cartItems', 'totalHarga'));
})->name('pembelians.payment');

Route::post('/pembelians/process-payment', function (Illuminate\Http\Request $request) {
    $request->validate([
        'payment_method' => 'required|in:tunai,gopay,dana',
        'nama_pembeli' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'no_telepon' => 'nullable|string|max:20',
        'alamat' => 'nullable|string|max:500',
        'catatan' => 'nullable|string|max:1000'
    ]);

    $cart = session('cart', []);
    
    if (empty($cart)) {
        return redirect()->route('cart.index')
            ->with('error', 'Keranjang belanja kosong!');
    }

    $totalHarga = 0;
    $cartItems = [];

    foreach ($cart as $productId => $item) {
        $produk = \App\Models\Produk::find($productId);
        if ($produk) {
            $subtotal = $item['quantity'] * $item['price'];
            $totalHarga += $subtotal;
            
            $cartItems[] = [
                'produk_id' => $productId,
                'nama_produk' => $produk->nama_produk,
                'quantity' => $item['quantity'],
                'harga' => $item['price'],
                'subtotal' => $subtotal
            ];
        }
    }

    $pembelian = \App\Models\Pembelian::create([
        'kode_pembelian' => \App\Models\Pembelian::generateKodePembelian(),
        'nama_pembeli' => $request->nama_pembeli,
        'email' => $request->email,
        'no_telepon' => $request->no_telepon,
        'alamat' => $request->alamat,
        'total_harga' => $totalHarga,
        'status' => 'pending',
        'catatan' => $request->catatan,
        'metode_pembayaran' => $request->payment_method
    ]);

    foreach ($cartItems as $item) {
        \App\Models\DetailPembelian::create([
            'pembelian_id' => $pembelian->id,
            'produk_id' => $item['produk_id'],
            'nama_produk' => $item['nama_produk'],
            'quantity' => $item['quantity'],
            'harga' => $item['harga'],
            'subtotal' => $item['subtotal']
        ]);

        // Update stock produk
        $produk = \App\Models\Produk::find($item['produk_id']);
        if ($produk) {
            $produk->stock -= $item['quantity'];
            $produk->save();
        }
    }

    // Clear cart
    session()->forget('cart');

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'redirect_url' => route('pembelians.success', $pembelian->id),
            'message' => 'Pesanan berhasil dibuat!'
        ]);
    }

    return redirect()->route('pembelians.success', $pembelian->id)
        ->with('success', 'Pesanan berhasil dibuat! Kode pembelian: ' . $pembelian->kode_pembelian);
})->name('pembelians.processPayment');

Route::get('/pembelians/success/{id}', function ($id) {
    $pembelian = \App\Models\Pembelian::with('detailPembelians.produk')
        ->findOrFail($id);
    
    return view('pembelians.success', compact('pembelian'));
})->name('pembelians.success');

Route::get('/pembelians/create', function () {
    return redirect()->route('pembelians.payment');
})->name('pembelians.create');

Route::post('/pembelians', function (Illuminate\Http\Request $request) {
    return redirect()->route('pembelians.payment');
})->name('pembelians.store');

Route::get('/pembelians/{id}', function ($id) {
    $pembelian = \App\Models\Pembelian::with('detailPembelians.produk')
        ->findOrFail($id);
    
    return view('pembelians.show', compact('pembelian'));
})->name('pembelians.show');

Route::put('/pembelians/{id}/status', function (Illuminate\Http\Request $request, $id) {
    $request->validate([
        'status' => 'required|in:pending,diproses,selesai,dibatalkan'
    ]);

    $pembelian = \App\Models\Pembelian::findOrFail($id);
    $pembelian->status = $request->status;
    $pembelian->save();

    return redirect()->back()
        ->with('success', 'Status pembelian berhasil diperbarui!');
})->name('pembelians.updateStatus');
