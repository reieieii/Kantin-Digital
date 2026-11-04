<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function index()
    {
        return 'PembelianController index method works!';
    }

    public function create()
    {
        return 'PembelianController create method works!';
    }

    public function store(Request $request)
    {
        return 'PembelianController store method works!';
    }

    public function show($id)
    {
        return 'PembelianController show method works! ID: ' . $id;
    }

    public function updateStatus(Request $request, $id)
    {
        return 'PembelianController updateStatus method works!';
    }
}
