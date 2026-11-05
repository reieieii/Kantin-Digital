<?php

namespace App\Http\Controllers\Penjaga;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $stand = Auth::user()->stand;

        if (!$stand) {
            abort(403, 'Akun ini belum terhubung ke stand manapun.');
        }

        // Statistik stand ini
        $totalProduk   = Produk::where('stand_id', $stand->id)->count();
        $produkTersedia = Produk::where('stand_id', $stand->id)->where('tersedia', true)->where('stock', '>', 0)->count();
        $stokHabis     = Produk::where('stand_id', $stand->id)->where(function($q) {
            $q->where('stock', 0)->orWhere('tersedia', false);
        })->count();

        // Pesanan yang berisi produk dari stand ini
        $pesananIds = \DB::table('detail_pembelians')
            ->join('produks', 'detail_pembelians.produk_id', '=', 'produks.id')
            ->where('produks.stand_id', $stand->id)
            ->pluck('detail_pembelians.pembelian_id')
            ->unique();

        $totalPesanan  = Pembelian::whereIn('id', $pesananIds)->count();
        $pesananPending = Pembelian::whereIn('id', $pesananIds)->where('status', 'pending')->count();
        $pesananProses  = Pembelian::whereIn('id', $pesananIds)->where('status', 'diproses')->count();

        // 5 pesanan terbaru
        $pesananTerbaru = Pembelian::with('detailPembelians.produk')
            ->whereIn('id', $pesananIds)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('penjaga.dashboard', compact(
            'stand', 'totalProduk', 'produkTersedia', 'stokHabis',
            'totalPesanan', 'pesananPending', 'pesananProses', 'pesananTerbaru'
        ));
    }
}
