<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function showKasir()
    {
        // Ambil semua produk untuk ditampilkan di popup/modal pencarian
        $products = Product::with(['brand', 'category'])
            ->where('quantity', '>', 0)
            ->orderBy('name')
            ->get();

        // Mapping products untuk menambahkan image_url
        $products = $products->map(function($product) {
            $imagePathJpg = public_path("uploads/products/{$product->id}.jpg");
            $imagePathPng = public_path("uploads/products/{$product->id}.png");
            if (file_exists($imagePathJpg)) {
                $product->image_url = url("uploads/products/{$product->id}.jpg");
            } elseif (file_exists($imagePathPng)) {
                $product->image_url = url("uploads/products/{$product->id}.png");
            } else {
                $product->image_url = url("images/no-image.jpg");
            }
            return $product;
        });

        $order = request()->query('order', 'name');
        
        return view('karyawan.kasir', compact('products', 'order'));
    }

    public function showDaftarPemesanan(){
        // Menggunakan model Order seperti cara Product digunakan di showKasir
        $orders = Order::with('user')  // Gunakan eager loading untuk relasi user
        ->orderBy('created_at', 'desc')
        ->paginate(10);  // Menampilkan 10 item per halaman

    return view('karyawan.daftar_pemesanan', compact('orders'));
    }

    public function cancelOrder($id) {
        $order = Order::findOrFail($id);
        $order->status = 'Dibatalkan';
        $order->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibatalkan'
        ]);
    }

    public function searchProducts(Request $request)
    {
        $products = Product::with(['brand', 'category'])
            ->where('quantity', '>', 0)
            ->when($request->search, function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', "%{$request->search}%")
                      ->orWhere('id', 'like', "%{$request->search}%")
                      ->orWhereHas('brand', function($q) use ($request) {
                          $q->where('name', 'like', "%{$request->search}%");
                      })
                      ->orWhereHas('category', function($q) use ($request) {
                          $q->where('name', 'like', "%{$request->search}%");
                      });
                });
            })
            ->orderBy('name')
            ->get();

        // Mapping products untuk hasil pencarian
        $products = $products->map(function($product) {
            $imagePathJpg = public_path("uploads/products/{$product->id}.jpg");
            $imagePathPng = public_path("uploads/products/{$product->id}.png");
            if (file_exists($imagePathJpg)) {
                $product->image_url = url("uploads/products/{$product->id}.jpg");
            } elseif (file_exists($imagePathPng)) {
                $product->image_url = url("uploads/products/{$product->id}.png");
            } else {
                $product->image_url = url("images/no-image.jpg");
            }
            return $product;
        });

        return response()->json($products);
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        // Validasi stok
        if($product->quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi'
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang'
        ]);
    }

    public function showOrder()
    {
        // Get all products untuk referensi data produk
        $products = Product::with(['brand', 'category'])->get();
        
        return view('karyawan.order_offline', compact('products'));
    }
}