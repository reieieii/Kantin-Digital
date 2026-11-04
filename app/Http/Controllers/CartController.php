<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        
        $product = Produk::findOrFail($productId);
        
        $cart = Session::get('cart', []);
        
        if(isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'name' => $product->nama_produk,
                'price' => $product->harga,
                'quantity' => $quantity,
                'image' => $product->gambar ?? 'default.jpg',
                'stand_id' => $product->stand_id
            ];
        }
        
        Session::put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'Produk ditambahkan ke keranjang',
            'cart_count' => $this->getCartCount(),
            'cart_total' => $this->getCartTotal()
        ]);
    }
    
    public function updateCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        
        $cart = Session::get('cart', []);
        
        if(isset($cart[$productId])) {
            if($quantity > 0) {
                $cart[$productId]['quantity'] = $quantity;
            } else {
                unset($cart[$productId]);
            }
        }
        
        Session::put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'cart_count' => $this->getCartCount(),
            'cart_total' => $this->getCartTotal()
        ]);
    }
    
    public function removeFromCart(Request $request)
    {
        $productId = $request->input('product_id');
        
        $cart = Session::get('cart', []);
        
        if(isset($cart[$productId])) {
            unset($cart[$productId]);
        }
        
        Session::put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'cart_count' => $this->getCartCount(),
            'cart_total' => $this->getCartTotal()
        ]);
    }
    
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }
    
    private function getCartCount()
    {
        $cart = Session::get('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }
    
    private function getCartTotal()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}
