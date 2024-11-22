<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Method untuk menambah quantity di halaman detail
    public function increaseQuantity($id)
    {
        $product = Product::findOrFail($id);
        $quantity = session('quantity', 1);
        
        // Tambah quantity
        $quantity++;
        
        // Hitung subtotal baru
        $subtotal = $product->price * $quantity;
        
        // Simpan ke session
        session([
            'quantity' => $quantity,
            'subtotal' => $subtotal
        ]);
        
        return redirect()->back();
    }

    public function decreaseQuantity($id)
    {
        $product = Product::findOrFail($id);
        $quantity = session('quantity', 1);
        
        // Pastikan quantity tidak kurang dari 1
        if ($quantity > 1) {
            $quantity--;
            
            // Hitung subtotal baru
            $subtotal = $product->price * $quantity;
            
            // Simpan ke session
            session([
                'quantity' => $quantity,
                'subtotal' => $subtotal
            ]);
        }
        
        return redirect()->back();
    }
}