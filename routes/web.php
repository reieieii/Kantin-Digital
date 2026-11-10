<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoritController;
use App\Http\Controllers\PasswordResetController;
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

    // ─── Forgot & Reset Password ─────────────────────────────────────────────
    Route::get ('/forgot-password',        [PasswordResetController::class, 'showForgotForm'])->name('password.forgot');
    Route::post('/forgot-password',        [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get ('/forgot-password/status', [PasswordResetController::class, 'checkStatus'])->name('password.status');
    Route::get ('/reset-password',         [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/reset-password',         [PasswordResetController::class, 'resetPassword'])->name('password.reset');
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

    // Kalkulator
    Route::get('kalkulator', function () {
        return view('admin.kalkulator');
    })->name('kalkulator');

    // Rekap Harian (read-only)
    Route::get ('rekap',       [\App\Http\Controllers\Admin\RekapHarianController::class, 'index'])->name('rekap.index');
    Route::post('rekap/reset', [\App\Http\Controllers\Admin\RekapHarianController::class, 'reset'])->name('rekap.reset');

    // Halaman Reset terpisah
    Route::get('reset', function () {
        $stands = \App\Models\Stand::orderBy('nama_stand')->get();
        return view('admin.reset.index', compact('stands'));
    })->name('reset.index');

    // Konfirmasi Reset Password User
    Route::get   ('password-resets',                  [\App\Http\Controllers\Admin\PasswordResetController::class, 'index'])->name('password-resets.index');
    Route::post  ('password-resets/{id}/approve',     [\App\Http\Controllers\Admin\PasswordResetController::class, 'approve'])->name('password-resets.approve');
    Route::post  ('password-resets/{id}/reject',      [\App\Http\Controllers\Admin\PasswordResetController::class, 'reject'])->name('password-resets.reject');
    Route::delete('password-resets/{id}',             [\App\Http\Controllers\Admin\PasswordResetController::class, 'destroy'])->name('password-resets.destroy');
});


// Stands
Route::get('/stands', [App\Http\Controllers\StandController::class, 'index'])->name('stands.index');
Route::get('/stands/{stand}', [App\Http\Controllers\StandController::class, 'show'])->name('stands.show');

// ─── Favorit Routes (butuh login) ────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get ('/favorit',        [FavoritController::class, 'index'])->name('favorit.index');
    Route::post('/favorit/toggle', [FavoritController::class, 'toggle'])->name('favorit.toggle');

    // ─── Profil ───────────────────────────────────────────────────────────────
    Route::get   ('/profil',                  [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put   ('/profil/nama',             [\App\Http\Controllers\ProfileController::class, 'updateName'])->name('profile.updateName');
    Route::put   ('/profil/password',         [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/profil/hapus',            [\App\Http\Controllers\ProfileController::class, 'deleteAccount'])->name('profile.delete');

    // ─── Notifikasi Pengguna ──────────────────────────────────────────────────
    Route::get ('/notifikasi',                [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifikasi/{id}/read',      [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifikasi/read-all',       [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::get ('/notifikasi/latest',         [\App\Http\Controllers\NotificationController::class, 'getLatest'])->name('notifications.latest');
});

// ─── Penjaga Stand Routes ─────────────────────────────────────────────────────
Route::prefix('penjaga')->name('penjaga.')->middleware(['auth', 'penjaga'])->group(function () {
    // Dashboard
    Route::get('/', [\App\Http\Controllers\Penjaga\DashboardController::class, 'index'])->name('dashboard');

    // Stand sendiri
    Route::get ('stand/edit',   [\App\Http\Controllers\Penjaga\StandController::class, 'edit'])->name('stand.edit');
    Route::put ('stand/update', [\App\Http\Controllers\Penjaga\StandController::class, 'update'])->name('stand.update');

    // Produk CRUD
    Route::resource('produks', \App\Http\Controllers\Penjaga\ProdukController::class)->except(['show']);

    // Pesanan
    Route::get   ('pesanans',                     [\App\Http\Controllers\Penjaga\PesananController::class, 'index'])->name('pesanans.index');
    Route::get   ('pesanans/{pesanan}',            [\App\Http\Controllers\Penjaga\PesananController::class, 'show'])->name('pesanans.show');
    Route::patch ('pesanans/{pesanan}/status',     [\App\Http\Controllers\Penjaga\PesananController::class, 'updateStatus'])->name('pesanans.updateStatus');

    // Kalkulator
    Route::get('kalkulator', function () {
        return view('penjaga.kalkulator');
    })->name('kalkulator');

    // Rekap Harian
    Route::get ('rekap',          [\App\Http\Controllers\Penjaga\RekapHarianController::class, 'index'])->name('rekap.index');
    Route::get ('rekap/live',     [\App\Http\Controllers\Penjaga\RekapHarianController::class, 'liveData'])->name('rekap.live');
    Route::post('rekap',          [\App\Http\Controllers\Penjaga\RekapHarianController::class, 'store'])->name('rekap.store');
    Route::delete('rekap/{rekap}',[\App\Http\Controllers\Penjaga\RekapHarianController::class, 'destroy'])->name('rekap.destroy');
});

// Cart — butuh login
Route::middleware('auth')->group(function () {
    Route::get ('/cart',         [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add',    [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
});

// Pesanan Saya — hanya pesanan milik user yang login
Route::middleware('auth')->get('/pembelians', function () {
    $pembelians = \App\Models\Pembelian::with('detailPembelians.produk')
        ->where('user_id', auth()->id())
        ->orderByDesc('created_at')
        ->paginate(10);

    return view('pembelians.index', compact('pembelians'));
})->name('pembelians.index');

Route::middleware('auth')->get('/pembelians/payment', function () {
    $cart = session('cart', []);
    
    // Jika keranjang kosong, redirect ke stands untuk memilih produk
    if (empty($cart)) {
        return redirect()->route('stands.index')
            ->with('info', 'Silakan pilih produk terlebih dahulu');
    }

    $totalHarga = 0;
    $cartItems = [];
    $qrisGambar = null; // QRIS dari stand produk pertama di cart

    foreach ($cart as $productId => $item) {
        $produk = \App\Models\Produk::with('stand')->find($productId);
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

            // Ambil QRIS dari stand produk pertama
            if (!$qrisGambar && $produk->stand && $produk->stand->qris_gambar) {
                $qrisGambar = $produk->stand->qris_gambar;
            }
        }
    }

    return view('pembelians.payment', compact('cartItems', 'totalHarga', 'qrisGambar'));
})->name('pembelians.payment');

Route::middleware('auth')->post('/pembelians/process-payment', function (Illuminate\Http\Request $request) {
    $request->validate([
        'payment_method' => 'required|in:tunai,qris',
        'nama_pembeli' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'no_telepon' => 'nullable|string|max:20',
        'alamat' => 'nullable|string|max:500',
        'catatan' => 'nullable|string|max:1000',
        'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'
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

    $buktiPath = null;
    if ($request->hasFile('bukti_pembayaran')) {
        $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
    }

    $pembelian = \App\Models\Pembelian::create([
        'user_id'          => auth()->id(), // null jika tidak login (guest)
        'kode_pembelian'   => \App\Models\Pembelian::generateKodePembelian(),
        'nama_pembeli'     => $request->nama_pembeli,
        'email'            => $request->email,
        'no_telepon'       => $request->no_telepon,
        'alamat'           => $request->alamat,
        'total_harga'      => $totalHarga,
        'status'           => 'pending',
        'catatan'          => $request->catatan,
        'metode_pembayaran'=> $request->payment_method,
        'bukti_pembayaran' => $buktiPath
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

    // Kirim notifikasi pesanan ke user
    if ($pembelian->user_id) {
        \App\Models\UserNotification::create([
            'user_id' => $pembelian->user_id,
            'title'   => 'Pesanan Berhasil Dibuat 🛒',
            'message' => 'Pesanan #' . $pembelian->kode_pembelian . ' sebesar Rp ' . number_format($pembelian->total_harga, 0, ',', '.') . ' berhasil dibuat dan sedang menunggu konfirmasi stand.',
            'type'    => 'order_created',
        ]);
    }

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
        'status' => 'required|in:pending,diproses,dapat_diambil,selesai,dibatalkan'
    ]);

    $pembelian = \App\Models\Pembelian::findOrFail($id);
    $statusLama = $pembelian->status;
    $statusBaru = $request->status;

    $pembelian->load('detailPembelians.produk.stand');

    if ($statusBaru === 'selesai' && $statusLama !== 'selesai') {
        foreach ($pembelian->detailPembelians as $item) {
            if ($item->produk && $item->produk->stand) {
                $item->produk->stand->tambahPendapatan((float) $item->subtotal);
            }
        }
    } elseif ($statusLama === 'selesai' && $statusBaru !== 'selesai') {
        foreach ($pembelian->detailPembelians as $item) {
            if ($item->produk && $item->produk->stand) {
                $item->produk->stand->kurangiPendapatan((float) $item->subtotal);
            }
        }
    }

    $pembelian->status = $statusBaru;
    $pembelian->save();

    if ($pembelian->user_id) {
        $title = match ($request->status) {
            'diproses'     => 'Pesanan Sedang Diproses 🍳',
            'dapat_diambil'=> 'Pesanan Dapat Diambil! 🛍️',
            'selesai'      => 'Pesanan Selesai! 🎉',
            'dibatalkan'   => 'Pesanan Dibatalkan ❌',
            default        => 'Status Pesanan Diperbarui 📋',
        };
        $msg = match ($request->status) {
            'diproses'     => 'Pesanan #' . $pembelian->kode_pembelian . ' sedang disiapkan.',
            'dapat_diambil'=> 'Pesanan #' . $pembelian->kode_pembelian . ' sudah selesai disiapkan dan dapat diambil sekarang di stand!',
            'selesai'      => 'Pesanan #' . $pembelian->kode_pembelian . ' sudah selesai diambil. Selamat menikmati!',
            'dibatalkan'   => 'Pesanan #' . $pembelian->kode_pembelian . ' telah dibatalkan.',
            default        => 'Status pesanan #' . $pembelian->kode_pembelian . ' telah diubah menjadi ' . str_replace('_', ' ', ucfirst($request->status)) . '.',
        };
        \App\Models\UserNotification::create([
            'user_id' => $pembelian->user_id,
            'title'   => $title,
            'message' => $msg,
            'type'    => 'order_' . $request->status,
        ]);
    }

    return redirect()->back()
        ->with('success', 'Status pembelian berhasil diperbarui!');
})->name('pembelians.updateStatus');
