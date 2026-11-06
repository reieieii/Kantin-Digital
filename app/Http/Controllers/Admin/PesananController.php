<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\Stand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembelian::with('detailPembelians.produk');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_pembelian', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_pembeli', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }

        // Filter by stand
        if ($request->filled('stand_id')) {
            $pesananIds = DB::table('detail_pembelians')
                ->join('produks', 'detail_pembelians.produk_id', '=', 'produks.id')
                ->where('produks.stand_id', $request->stand_id)
                ->pluck('detail_pembelians.pembelian_id')
                ->unique();
            $query->whereIn('id', $pesananIds);
        }

        // Filter by kategori produk
        if ($request->filled('kategori')) {
            $pesananIds = DB::table('detail_pembelians')
                ->join('produks', 'detail_pembelians.produk_id', '=', 'produks.id')
                ->where('produks.kategori', $request->kategori)
                ->pluck('detail_pembelians.pembelian_id')
                ->unique();
            $query->whereIn('id', $pesananIds);
        }

        $pesanans = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $stands   = Stand::orderBy('nama_stand')->get();

        $stats = [
            'semua'     => Pembelian::count(),
            'pending'   => Pembelian::where('status', 'pending')->count(),
            'diproses'  => Pembelian::where('status', 'diproses')->count(),
            'selesai'   => Pembelian::where('status', 'selesai')->count(),
            'dibatalkan'=> Pembelian::where('status', 'dibatalkan')->count(),
        ];

        return view('admin.pesanans.index', compact('pesanans', 'stats', 'stands'));
    }

    public function show(Pembelian $pesanan)
    {
        $pesanan->load('detailPembelians.produk');
        return view('admin.pesanans.show', compact('pesanan'));
    }

    public function updateStatus(Request $request, Pembelian $pesanan)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,dibatalkan',
        ]);

        $pesanan->update(['status' => $request->status]);

        return redirect()->back()
            ->with('success', 'Status pesanan #' . $pesanan->kode_pembelian . ' diubah ke "' . ucfirst($request->status) . '".');
    }

    public function destroy(Pembelian $pesanan)
    {
        $kode = $pesanan->kode_pembelian;
        $pesanan->detailPembelians()->delete();
        $pesanan->delete();

        return redirect()->route('admin.pesanans.index')
            ->with('success', 'Pesanan #' . $kode . ' berhasil dihapus.');
    }
}
