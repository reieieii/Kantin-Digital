<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekapHarian;
use App\Models\Stand;
use Illuminate\Http\Request;

class RekapHarianController extends Controller
{
    /**
     * Tampilkan laporan rekap harian semua stand (read-only).
     * Admin bisa filter per stand dan per rentang tanggal.
     */
    public function index(Request $request)
    {
        $stands = Stand::orderBy('nama_stand')->get();

        $query = RekapHarian::with('stand')->orderByDesc('tanggal')->orderBy('stand_id');

        if ($request->filled('stand_id')) {
            $query->where('stand_id', $request->stand_id);
        }

        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }

        $rekaps = $query->paginate(30)->withQueryString();

        // Ringkasan total semua stand (setelah filter)
        $queryRingkasan = RekapHarian::query();
        if ($request->filled('stand_id'))  $queryRingkasan->where('stand_id', $request->stand_id);
        if ($request->filled('dari'))      $queryRingkasan->whereDate('tanggal', '>=', $request->dari);
        if ($request->filled('sampai'))    $queryRingkasan->whereDate('tanggal', '<=', $request->sampai);

        $ringkasan = [
            'total_pendapatan'   => $queryRingkasan->sum('total_pendapatan'),
            'total_keuntungan'   => $queryRingkasan->sum('total_keuntungan'),
            'total_pesanan'      => $queryRingkasan->sum('total_pesanan'),
            'pesanan_selesai'    => $queryRingkasan->sum('pesanan_selesai'),
            'pesanan_dibatalkan' => $queryRingkasan->sum('pesanan_dibatalkan'),
            'jumlah_rekap'       => $queryRingkasan->count(),
        ];

        return view('admin.rekap.index', compact('stands', 'rekaps', 'ringkasan'));
    }
}
