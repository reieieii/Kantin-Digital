<?php

namespace App\Http\Controllers\Penjaga;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\RekapHarian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekapHarianController extends Controller
{
    private function getStand()
    {
        return Auth::user()->stand;
    }

    /** Helper: hitung statistik stand untuk rentang tanggal tertentu */
    private function hitungStatistik(int $standId, string $dari, string $sampai): array
    {
        // Ambil semua pembelian_id yang mengandung produk dari stand ini
        // dalam rentang tanggal
        $pesananIds = DB::table('detail_pembelians')
            ->join('produks', 'detail_pembelians.produk_id', '=', 'produks.id')
            ->join('pembelians', 'detail_pembelians.pembelian_id', '=', 'pembelians.id')
            ->where('produks.stand_id', $standId)
            ->whereBetween('pembelians.created_at', [$dari . ' 00:00:00', $sampai . ' 23:59:59'])
            ->pluck('detail_pembelians.pembelian_id')
            ->unique();

        $totalPesanan      = Pembelian::whereIn('id', $pesananIds)->count();
        $pesananSelesai    = Pembelian::whereIn('id', $pesananIds)->where('status', 'selesai')->count();
        $pesananDibatalkan = Pembelian::whereIn('id', $pesananIds)->where('status', 'dibatalkan')->count();

        // Total pendapatan = subtotal item stand dari pesanan selesai
        $totalPendapatan = DB::table('detail_pembelians')
            ->join('produks', 'detail_pembelians.produk_id', '=', 'produks.id')
            ->join('pembelians', 'detail_pembelians.pembelian_id', '=', 'pembelians.id')
            ->where('produks.stand_id', $standId)
            ->where('pembelians.status', 'selesai')
            ->whereBetween('pembelians.created_at', [$dari . ' 00:00:00', $sampai . ' 23:59:59'])
            ->sum('detail_pembelians.subtotal');

        return [
            'total_pesanan'      => $totalPesanan,
            'pesanan_selesai'    => $pesananSelesai,
            'pesanan_dibatalkan' => $pesananDibatalkan,
            'total_pendapatan'   => (float) $totalPendapatan,
        ];
    }

    /** GET /penjaga/rekap — tampilkan form + riwayat */
    public function index()
    {
        $stand   = $this->getStand();
        $today   = Carbon::today();
        $hariIni = RekapHarian::namaHariDari($today);

        // Data live hari ini untuk auto-fill
        $liveData = $this->hitungStatistik($stand->id, $today->toDateString(), $today->toDateString());

        // Riwayat rekap stand ini (50 terakhir)
        $riwayat = RekapHarian::where('stand_id', $stand->id)
            ->orderByDesc('tanggal')
            ->limit(50)
            ->get();

        // Rekap hari ini kalau sudah ada (untuk prefill form)
        $rekapHariIni = RekapHarian::where('stand_id', $stand->id)
            ->where('tanggal', $today->toDateString())
            ->first();

        return view('penjaga.rekap.index', compact(
            'stand', 'today', 'hariIni', 'liveData', 'riwayat', 'rekapHariIni'
        ));
    }

    /** GET /penjaga/rekap/live — AJAX: data live untuk tanggal tertentu */
    public function liveData(Request $request)
    {
        $stand  = $this->getStand();
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());

        try {
            $dt   = Carbon::parse($tanggal);
            $data = $this->hitungStatistik($stand->id, $tanggal, $tanggal);
            $data['hari'] = RekapHarian::namaHariDari($dt);
            $data['tanggal_display'] = $dt->format('d/m/Y');

            // Cek apakah sudah pernah direkap
            $existing = RekapHarian::where('stand_id', $stand->id)
                ->where('tanggal', $tanggal)
                ->first();

            $data['sudah_direkap']      = (bool) $existing;
            $data['total_keuntungan']   = $existing ? $existing->total_keuntungan : 0;
            $data['catatan']            = $existing?->catatan ?? '';

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Tanggal tidak valid'], 422);
        }
    }

    /** POST /penjaga/rekap — simpan rekap harian */
    public function store(Request $request)
    {
        $stand = $this->getStand();

        $request->validate([
            'tanggal'           => 'required|date',
            'hari'              => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'total_pendapatan'  => 'required|numeric|min:0',
            'total_keuntungan'  => 'required|numeric',
            'total_pesanan'     => 'required|integer|min:0',
            'pesanan_selesai'   => 'required|integer|min:0',
            'pesanan_dibatalkan'=> 'required|integer|min:0',
            'catatan'           => 'nullable|string|max:1000',
        ]);

        RekapHarian::updateOrCreate(
            ['stand_id' => $stand->id, 'tanggal' => $request->tanggal],
            [
                'hari'               => $request->hari,
                'total_pendapatan'   => $request->total_pendapatan,
                'total_keuntungan'   => $request->total_keuntungan,
                'total_pesanan'      => $request->total_pesanan,
                'pesanan_selesai'    => $request->pesanan_selesai,
                'pesanan_dibatalkan' => $request->pesanan_dibatalkan,
                'catatan'            => $request->catatan,
            ]
        );

        return redirect()->route('penjaga.rekap.index')
            ->with('success', 'Rekap harian ' . $request->hari . ', ' . Carbon::parse($request->tanggal)->format('d/m/Y') . ' berhasil disimpan.');
    }

    /** DELETE /penjaga/rekap/{id} — hapus satu rekap */
    public function destroy(RekapHarian $rekap)
    {
        $stand = $this->getStand();

        if ($rekap->stand_id !== $stand->id) {
            abort(403, 'Rekap ini bukan milik stand kamu.');
        }

        $tanggal = $rekap->tanggal->format('d/m/Y');
        $rekap->delete();

        return redirect()->route('penjaga.rekap.index')
            ->with('success', "Rekap tanggal {$tanggal} berhasil dihapus.");
    }
}
