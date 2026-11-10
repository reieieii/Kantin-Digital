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
            'semua'        => Pembelian::count(),
            'pending'      => Pembelian::where('status', 'pending')->count(),
            'diproses'     => Pembelian::where('status', 'diproses')->count(),
            'dapat_diambil'=> Pembelian::where('status', 'dapat_diambil')->count(),
            'selesai'      => Pembelian::where('status', 'selesai')->count(),
            'dibatalkan'   => Pembelian::where('status', 'dibatalkan')->count(),
        ];

        return view('admin.pesanans.index', compact('pesanans', 'stats', 'stands'));
    }

    public function show(Pembelian $pesanan)
    {
        $pesanan->load('detailPembelians.produk.stand');
        $stands = $pesanan->detailPembelians
            ->map(fn($d) => $d->produk?->stand)
            ->filter()
            ->unique('id')
            ->values();

        return view('admin.pesanans.show', compact('pesanan', 'stands'));
    }

    public function updateStatus(Request $request, Pembelian $pesanan)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,dapat_diambil,selesai,dibatalkan',
        ]);

        $statusLama = $pesanan->status;
        $statusBaru = $request->status;

        $pesanan->load('detailPembelians.produk.stand');

        // Akumulasi pendapatan stand:
        // - Bertambah jika status berubah dari non-selesai ke 'selesai'
        // - Berkurang jika status berubah dari 'selesai' ke status lain (misal 'dibatalkan')
        if ($statusBaru === 'selesai' && $statusLama !== 'selesai') {
            foreach ($pesanan->detailPembelians as $item) {
                if ($item->produk && $item->produk->stand) {
                    $item->produk->stand->tambahPendapatan((float) $item->subtotal);
                }
            }
        } elseif ($statusLama === 'selesai' && $statusBaru !== 'selesai') {
            foreach ($pesanan->detailPembelians as $item) {
                if ($item->produk && $item->produk->stand) {
                    $item->produk->stand->kurangiPendapatan((float) $item->subtotal);
                }
            }
        }

        $pesanan->update(['status' => $statusBaru]);

        // Kirim notifikasi ke user pembeli jika akun terdaftar
        if ($pesanan->user_id) {
            $title = match ($request->status) {
                'diproses'     => 'Pesanan Sedang Diproses 🍳',
                'dapat_diambil'=> 'Pesanan Dapat Diambil! 🛍️',
                'selesai'      => 'Pesanan Selesai! 🎉',
                'dibatalkan'   => 'Pesanan Dibatalkan ❌',
                default        => 'Status Pesanan Diperbarui 📋',
            };
            $msg = match ($request->status) {
                'diproses'     => 'Pesanan #' . $pesanan->kode_pembelian . ' sedang disiapkan oleh pihak stand kantin.',
                'dapat_diambil'=> 'Pesanan #' . $pesanan->kode_pembelian . ' sudah selesai disiapkan dan dapat diambil sekarang di stand!',
                'selesai'      => 'Pesanan #' . $pesanan->kode_pembelian . ' telah selesai diambil. Selamat menikmati!',
                'dibatalkan'   => 'Pesanan #' . $pesanan->kode_pembelian . ' telah dibatalkan oleh pihak pengelola.',
                default        => 'Status pesanan #' . $pesanan->kode_pembelian . ' telah diubah menjadi ' . str_replace('_', ' ', ucfirst($request->status)) . '.',
            };
            \App\Models\UserNotification::create([
                'user_id' => $pesanan->user_id,
                'title'   => $title,
                'message' => $msg,
                'type'    => 'order_' . $request->status,
            ]);
        }

        return redirect()->back()
            ->with('success', 'Status pesanan #' . $pesanan->kode_pembelian . ' diubah ke "' . ucfirst($request->status) . '".');
    }

    public function destroy(Pembelian $pesanan)
    {
        $kode = $pesanan->kode_pembelian;
        $pesanan->load('detailPembelians.produk.stand');

        if ($pesanan->status === 'selesai') {
            foreach ($pesanan->detailPembelians as $item) {
                if ($item->produk && $item->produk->stand) {
                    $item->produk->stand->kurangiPendapatan((float) $item->subtotal);
                }
            }
        }

        $pesanan->detailPembelians()->delete();
        $pesanan->delete();

        return redirect()->route('admin.pesanans.index')
            ->with('success', 'Pesanan #' . $kode . ' berhasil dihapus.');
    }
}
