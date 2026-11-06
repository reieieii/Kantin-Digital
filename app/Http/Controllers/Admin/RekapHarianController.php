<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
     * Reset rekap harian + total_pendapatan stand.
     * stand_id = tertentu, kosong = semua stand.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'stand_id'    => 'nullable|exists:stands,id',
            'konfirmasi'  => 'required|in:RESET',
        ], [
            'konfirmasi.required' => 'Ketik "RESET" untuk konfirmasi.',
            'konfirmasi.in'       => 'Konfirmasi salah. Ketik persis: RESET',
        ]);

        DB::transaction(function () use ($request) {
            if ($request->filled('stand_id')) {
                // Reset satu stand
                RekapHarian::where('stand_id', $request->stand_id)->delete();
                Stand::where('id', $request->stand_id)->update(['total_pendapatan' => 0]);
                $nama = Stand::find($request->stand_id)?->nama_stand ?? 'Stand';
                session()->flash('success', "Rekap harian & pendapatan \"{$nama}\" berhasil direset.");
            } else {
                // Reset semua stand — pakai delete() bukan truncate() agar aman dalam transaction
                RekapHarian::query()->delete();
                Stand::query()->update(['total_pendapatan' => 0]);
                session()->flash('success', 'Semua rekap harian & pendapatan seluruh stand berhasil direset.');
            }
        });

        return redirect()->route('admin.rekap.index');
    }
}
