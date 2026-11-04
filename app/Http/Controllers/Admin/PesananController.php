<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembelian::with('detailPembelians');

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

        $pesanans = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        $stats = [
            'semua'     => Pembelian::count(),
            'pending'   => Pembelian::where('status', 'pending')->count(),
            'diproses'  => Pembelian::where('status', 'diproses')->count(),
            'selesai'   => Pembelian::where('status', 'selesai')->count(),
            'dibatalkan'=> Pembelian::where('status', 'dibatalkan')->count(),
        ];

        return view('admin.pesanans.index', compact('pesanans', 'stats'));
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
