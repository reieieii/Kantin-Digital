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

        $totalPesanan       = Pembelian::whereIn('id', $pesananIds)->count();
        $pesananPending     = Pembelian::whereIn('id', $pesananIds)->where('status', 'pending')->count();
        $pesananProses      = Pembelian::whereIn('id', $pesananIds)->where('status', 'diproses')->count();
        $pesananDapatDiambil= Pembelian::whereIn('id', $pesananIds)->where('status', 'dapat_diambil')->count();
        $pesananSelesai     = Pembelian::whereIn('id', $pesananIds)->where('status', 'selesai')->count();
        $pesananDibatalkan  = Pembelian::whereIn('id', $pesananIds)->where('status', 'dibatalkan')->count();

        // Total pendapatan riil dari pesanan selesai produk stand ini
        $totalPendapatan = (float) \DB::table('detail_pembelians')
            ->join('produks', 'detail_pembelians.produk_id', '=', 'produks.id')
            ->join('pembelians', 'detail_pembelians.pembelian_id', '=', 'pembelians.id')
            ->where('produks.stand_id', $stand->id)
            ->where('pembelians.status', 'selesai')
            ->sum('detail_pembelians.subtotal');

        if ((float) $stand->total_pendapatan !== $totalPendapatan) {
            $stand->update(['total_pendapatan' => $totalPendapatan]);
        }

        // 5 pesanan terbaru
        $pesananTerbaru = Pembelian::with('detailPembelians.produk')
            ->whereIn('id', $pesananIds)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('penjaga.dashboard', compact(
            'stand', 'totalProduk', 'produkTersedia', 'stokHabis',
            'totalPesanan', 'pesananPending', 'pesananProses', 'pesananDapatDiambil', 'pesananSelesai', 'pesananDibatalkan',
            'totalPendapatan', 'pesananTerbaru'
        ));
    }
}
