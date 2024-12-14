<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
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
        $order_items = OrderItem::orderBy('id', 'desc')
            ->paginate(10);  // Menampilkan 10 item per halaman
    
        return view('karyawan.daftar_pemesanan', compact('order_items'));
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

    public function checkout(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validasi request
            $request->validate([
                'customer' => 'required|string',
                'location' => 'required|string',
                'payment_method' => 'required|string',
                'items' => 'required|array|min:1',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
                'summary.subtotal' => 'required|numeric',
                'summary.total_discount' => 'required|numeric',
                'summary.grand_total' => 'required|numeric'
            ]);

            // // Generate order number
            // $orderNumber = 'ORD-' . date('Ymd') . '-' . rand(1000, 9999);

            // Buat order baru
            $order = Order::create([
                'customer_id' => auth()->id(), // Jika ada sistem login
                'address' => $request->location,
                'delivery_method' => 'pickup', // Karena ini kasir offline
                'payment_method' => $request->payment_method,
                'payment_details' => json_encode([
                    'customer_name' => $request->customer,
                    'payment_date' => date('Y-m-d H:i:s')
                ]),
                'subtotal' => $request->summary['subtotal'],
                'tax' => 0, // Sesuaikan jika ada perhitungan pajak
                'total' => $request->summary['grand_total'],
                'status' => 'sedang_diproses'
            ]);

            // Simpan items dan update stok
            foreach ($request->items as $item) {
                // Simpan order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'produk_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['total']
                ]);

                // Update stok produk
                $product = Product::find($item['product_id']);
                $product->quantity -= $item['quantity'];
                $product->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil disimpan',
                'order_id' => $order->id
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}