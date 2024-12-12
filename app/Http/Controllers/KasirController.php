<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function showKasir()
    {
        // Ambil semua produk untuk ditampilkan di popup/modal pencarian
        $products = Product::with(['brand', 'category'])
                    ->where('quantity', '>', 0)
                    ->orderBy('name')
                    ->get();
                    
        return view('karyawan.kasir', compact('products'));
    }

    public function searchProducts(Request $request)
    {
        $products = Product::with(['brand', 'category'])
                    ->where('quantity', '>', 0)
                    ->when($request->search, function($query) use ($request) {
                        $query->where('name', 'like', "%{$request->search}%")
                              ->orWhere('id', 'like', "%{$request->search}%");
                    })
                    ->orderBy('name')
                    ->get();

        return response()->json($products);
    }
}