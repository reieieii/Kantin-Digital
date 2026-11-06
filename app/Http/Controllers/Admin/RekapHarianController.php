<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\RekapHarian;
use App\Models\Stand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapHarianController extends Controller
{
    /**
     * Tampilkan laporan rekap harian semua stand (read-only).
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

    /**
     * Reset TOTAL untuk satu atau semua stand:
     * - Hapus semua pesanan (pembelians + detail_pembelians) milik stand
     * - Hapus semua rekap harian stand
     * - Reset total_pendapatan stand ke 0
     */
    public function reset(Request $request)
    {
        // Normalisasi input konfirmasi ke uppercase sebelum validasi
        $request->merge(['konfirmasi' => strtoupper(trim($request->konfirmasi ?? ''))]);

        $request->validate([
            'stand_id'   => 'nullable|exists:stands,id',
            'konfirmasi' => 'required|in:RESET',
        ], [
            'konfirmasi.required' => 'Ketik "RESET" untuk konfirmasi.',
            'konfirmasi.in'       => 'Konfirmasi salah. Ketik persis: RESET',
        ]);

        DB::transaction(function () use ($request) {
            if ($request->filled('stand_id')) {
                $standId = $request->stand_id;

                // Ambil semua pembelian_id yang punya item dari stand ini
                $pesananIds = DB::table('detail_pembelians')
                    ->join('produks', 'detail_pembelians.produk_id', '=', 'produks.id')
                    ->where('produks.stand_id', $standId)
                    ->pluck('detail_pembelians.pembelian_id')
                    ->unique();

                // Hapus detail_pembelians lalu pembelians
                DB::table('detail_pembelians')->whereIn('pembelian_id', $pesananIds)->delete();
                Pembelian::whereIn('id', $pesananIds)->delete();

                // Hapus rekap harian stand ini
                RekapHarian::where('stand_id', $standId)->delete();

                // Reset pendapatan stand
                Stand::where('id', $standId)->update(['total_pendapatan' => 0]);

                $nama = Stand::find($standId)?->nama_stand ?? 'Stand';
                session()->flash('success', "✅ Stand \"{$nama}\" berhasil direset sepenuhnya: pesanan, rekap, dan pendapatan dihapus.");
            } else {
                // Reset SEMUA stand
                DB::table('detail_pembelians')->delete();
                Pembelian::query()->delete();
                RekapHarian::query()->delete();
                Stand::query()->update(['total_pendapatan' => 0]);

                session()->flash('success', '✅ Semua stand berhasil direset sepenuhnya: seluruh pesanan, rekap, dan pendapatan dihapus.');
            }
        });

        return redirect()->route('admin.rekap.index');
    }
}
