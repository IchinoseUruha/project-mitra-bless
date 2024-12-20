<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OfflineOrderItem;
use App\Models\Product;
use App\Models\User;
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
    public function showOrderOffline()
    {
        $offlineOrders = OfflineOrderItem::orderBy('created_at', 'desc')
        ->paginate(10);
        return view('karyawan.pemesananOffline', compact('offlineOrders'));
    }

    public function cancelOrder($id) {
        $order = OrderItem::findOrFail($id);
        $order->status = 'dibatalkan';
        $order->save();
        
        return back();
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
    public function processOfflineOrder(Request $request)
    {
       try {
           \Log::info('Process Offline Order Request:', $request->all());
    
           DB::beginTransaction();
    
           $validated = $request->validate([
               'customer_email' => 'nullable|email',
               'customer_id' => 'nullable|exists:users,id',
               'payment_method' => 'required|in:cash,bank_transfer,e_wallet',
               'payment_details' => 'required_if:payment_method,bank_transfer,e_wallet',
               'items' => 'required|array|min:1',
               'items.*.produk_id' => 'required|integer',
               'items.*.quantity' => 'required|integer|min:1',
               'items.*.price' => 'required|numeric',
               'items.*.total' => 'required|numeric'
           ]);
    
           \Log::info('Validated Data:', $validated);
    
           // Verifikasi customer_email jika ada
           if (!empty($validated['customer_email'])) {
               $customer = User::where('email', $validated['customer_email'])
                             ->whereIn('utype', ['customer_r', 'customer_b'])
                             ->first();
               
               if (!$customer) {
                   throw new \Exception('Customer email tidak valid atau bukan customer retail/business');
               }
               $validated['customer_id'] = $customer->id;
           }
    
           foreach ($validated['items'] as $item) {
               // Cek stok produk terlebih dahulu
               $produk = DB::table('produk')->where('id', $item['produk_id'])->first();
               if (!$produk) {
                   throw new \Exception("Produk dengan ID {$item['produk_id']} tidak ditemukan");
               }
    
               // Menggunakan nama kolom quantity yang sesuai
               if ($produk->quantity < $item['quantity']) {
                   throw new \Exception("Stok produk {$produk->name} tidak mencukupi. Stok tersedia: {$produk->quantity}");
               }
    
               // Call stored procedure untuk setiap item
               $result = DB::select(
                   'CALL CreateOfflineOrder(?, ?, ?, ?, ?)',
                   [
                       auth()->id(),
                       $validated['customer_email'] ?? null,
                       $item['produk_id'],
                       $item['quantity'],
                       $item['price']
                   ]
               );
    
               \Log::info('Stored Procedure Result:', $result ?? ['No result']);
    
               if (empty($result)) {
                   throw new \Exception('Gagal membuat pesanan');
               }
    
               $orderId = $result[0]->{'Created Order ID'};
               \Log::info('Order ID:', [$orderId]);
    
               // Update payment details
               DB::table('offline_order_items')
                   ->where('order_id', $orderId)
                   ->update([
                       'payment_method' => $validated['payment_method'],
                       'payment_details' => $validated['payment_details'] ?? null,
                       'updated_at' => now()
                   ]);
    
               // Update stok produk
               $newQuantity = $produk->quantity - $item['quantity'];
               DB::table('produk')
                   ->where('id', $item['produk_id'])
                   ->update([
                       'quantity' => $newQuantity,
                       'updated_at' => now()
                   ]);
           }
    
           DB::commit();
           \Log::info('Transaction committed successfully');
           
           return response()->json([
               'success' => true,
               'message' => 'Transaksi berhasil'
           ]);
    
       } catch (\Exception $e) {
           DB::rollBack();
           \Log::error('Offline Order Error:', [
               'message' => $e->getMessage(),
               'file' => $e->getFile(),
               'line' => $e->getLine(),
               'trace' => $e->getTraceAsString()
           ]);
           
           return response()->json([
               'success' => false,
               'message' => 'Error: ' . $e->getMessage()
           ], 500);
       }
    }

}