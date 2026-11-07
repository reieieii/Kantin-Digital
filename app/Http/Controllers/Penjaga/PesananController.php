<?php

namespace App\Http\Controllers\Penjaga;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    private function getPesananIds()
    {
        $stand = Auth::user()->stand;

        return DB::table('detail_pembelians')
            ->join('produks', 'detail_pembelians.produk_id', '=', 'produks.id')
            ->where('produks.stand_id', $stand->id)
            ->pluck('detail_pembelians.pembelian_id')
            ->unique();
    }

    public function index(Request $request)
    {
        $stand      = Auth::user()->stand;
        $pesananIds = $this->getPesananIds();

        $query = Pembelian::with('detailPembelians.produk')
            ->whereIn('id', $pesananIds);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_pembelian', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_pembeli', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }
        if ($request->filled('kategori')) {
            $katIds = \DB::table('detail_pembelians')
                ->join('produks', 'detail_pembelians.produk_id', '=', 'produks.id')
                ->where('produks.stand_id', $stand->id)
                ->where('produks.kategori', $request->kategori)
                ->pluck('detail_pembelians.pembelian_id')
                ->unique();
            $query->whereIn('id', $katIds);
        }

        $pesanans = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        $stats = [
            'semua'     => Pembelian::whereIn('id', $pesananIds)->count(),
            'pending'   => Pembelian::whereIn('id', $pesananIds)->where('status', 'pending')->count(),
            'diproses'  => Pembelian::whereIn('id', $pesananIds)->where('status', 'diproses')->count(),
            'selesai'   => Pembelian::whereIn('id', $pesananIds)->where('status', 'selesai')->count(),
            'dibatalkan'=> Pembelian::whereIn('id', $pesananIds)->where('status', 'dibatalkan')->count(),
        ];

        return view('penjaga.pesanans.index', compact('pesanans', 'stats', 'stand'));
    }

    public function show(Pembelian $pesanan)
    {
        $pesananIds = $this->getPesananIds();

        if (!$pesananIds->contains($pesanan->id)) {
            abort(403, 'Pesanan ini bukan dari stand kamu.');
        }

        $pesanan->load('detailPembelians.produk');
        $stand = Auth::user()->stand;

        return view('penjaga.pesanans.show', compact('pesanan', 'stand'));
    }

    public function updateStatus(Request $request, Pembelian $pesanan)
    {
        $pesananIds = $this->getPesananIds();

        if (!$pesananIds->contains($pesanan->id)) {
            abort(403, 'Pesanan ini bukan dari stand kamu.');
        }

        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,dibatalkan',
        ]);

        $stand      = Auth::user()->stand;
        $statusLama = $pesanan->status;
        $statusBaru = $request->status;

        // Hitung subtotal item milik stand ini dalam pesanan ini
        $subtotalStand = DB::table('detail_pembelians')
            ->join('produks', 'detail_pembelians.produk_id', '=', 'produks.id')
            ->where('detail_pembelians.pembelian_id', $pesanan->id)
            ->where('produks.stand_id', $stand->id)
            ->sum('detail_pembelians.subtotal');

        // Akumulasi pendapatan secara atomik
        // Pendapatan hanya bertambah saat status berubah ke 'selesai'.
        // Pembatalan atau perubahan status lain tidak mengurangi pendapatan.
        if ($statusBaru === 'selesai' && $statusLama !== 'selesai') {
            $stand->tambahPendapatan((float) $subtotalStand);
        }

        $pesanan->update(['status' => $statusBaru]);

        return redirect()->back()
            ->with('success', 'Status pesanan berhasil diubah ke "' . ucfirst($statusBaru) . '".');
    }
}
