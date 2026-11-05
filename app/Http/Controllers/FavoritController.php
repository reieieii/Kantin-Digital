<?php

namespace App\Http\Controllers;

use App\Models\Favorit;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritController extends Controller
{
    /**
     * Tampilkan halaman Menu Favorit user.
     */
    public function index()
    {
        $favorits = Favorit::with(['produk.stand'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('favorits.index', compact('favorits'));
    }

    /**
     * Toggle favorit: tambah jika belum ada, hapus jika sudah ada.
     */
    public function toggle(Request $request)
    {
        $request->validate(['produk_id' => 'required|exists:produks,id']);

        $userId   = Auth::id();
        $produkId = $request->produk_id;

        $existing = Favorit::where('user_id', $userId)
                           ->where('produk_id', $produkId)
                           ->first();

        if ($existing) {
            $existing->delete();
            $favorited = false;
        } else {
            Favorit::create(['user_id' => $userId, 'produk_id' => $produkId]);
            $favorited = true;
        }

        $count = Favorit::where('user_id', $userId)->count();

        return response()->json([
            'favorited' => $favorited,
            'count'     => $count,
        ]);
    }
}
