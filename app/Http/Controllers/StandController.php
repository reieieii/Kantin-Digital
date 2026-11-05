<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Stand;
use App\Models\Produk;
use App\Models\Favorit;

class StandController extends Controller
{
    public function index()
    {
        $stands = Stand::with('produks')->get();
        return view('stands.index', compact('stands'));
    }

    public function show($id)
    {
        $stand = Stand::with('produks')->findOrFail($id);

        // ID produk yang sudah di-favorit user ini (array kosong kalau belum login)
        $userFavorits = Auth::check()
            ? Favorit::where('user_id', Auth::id())
                     ->pluck('produk_id')
                     ->toArray()
            : [];

        return view('stands.show', compact('stand', 'userFavorits'));
    }
}
