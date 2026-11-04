<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stand;
use App\Models\Produk;

class StandController extends Controller
{
    public function index()
    {
        $stands = Stand::where('status_buka', true)->get();
        return view('stands.index', compact('stands'));
    }

    public function show($id)
    {
        $stand = Stand::findOrFail($id);
        $produks = Produk::where('stand_id', $id)->where('tersedia', true)->get();
        return view('stands.show', compact('stand', 'produks'));
    }
}
