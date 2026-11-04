<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\Produk;
use App\Models\Stand;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_stand'    => Stand::count(),
            'total_produk'   => Produk::count(),
            'total_pesanan'  => Pembelian::count(),
            'total_user'     => User::where('role', 'user')->count(),
            'pesanan_pending'   => Pembelian::where('status', 'pending')->count(),
            'pesanan_diproses'  => Pembelian::where('status', 'diproses')->count(),
            'pesanan_selesai'   => Pembelian::where('status', 'selesai')->count(),
            'pendapatan_total'  => Pembelian::where('status', 'selesai')->sum('total_harga'),
        ];

        $pesanan_terbaru = Pembelian::with('detailPembelians')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $stand_aktif = Stand::where('status_buka', true)
            ->withCount('produks')
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        return view('admin.dashboard', compact('stats', 'pesanan_terbaru', 'stand_aktif'));
    }
}
