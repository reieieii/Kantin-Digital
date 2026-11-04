<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return 'OrderController index - Working!';
    }

    public function create()
    {
        return 'OrderController create - Working!';
    }

    public function store(Request $request)
    {
        return 'OrderController store - Working!';
    }

    public function show($id)
    {
        return 'OrderController show - Working! ID: ' . $id;
    }

    public function updateStatus(Request $request, $id)
    {
        return 'OrderController updateStatus - Working!';
    }
}
