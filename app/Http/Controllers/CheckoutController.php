<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
{
    \Log::info('Entering checkout index');
    \Log::info('Auth ID: ' . Auth::id());

    // Check if this is direct purchase
    if (session()->has('direct_purchase')) {
        \Log::info('Direct purchase path');
        $cartItems = collect([session('cartItems')]);
        $total = session('total');
        
        return view('checkout', compact('cartItems', 'total'));
    } 
    
    // If not direct purchase, check cart
    $cartItems = Cart::where('customer_id', Auth::id())
        ->with('produk')
        ->get();

    \Log::info('Regular checkout path - Cart items: ' . $cartItems->count());
    
    // Store cart items in session as backup
    if (!$cartItems->isEmpty()) {
        session(['checkout_cart_items' => $cartItems]);
        session(['checkout_total' => $cartItems->sum(function ($item) {
            return $item->quantity * $item->produk->price;
        })]);
    }

    // If cart is empty, try to recover from session
    if ($cartItems->isEmpty() && session()->has('checkout_cart_items')) {
        \Log::info('Recovering cart items from session');
        $cartItems = session('checkout_cart_items');
        $total = session('checkout_total');
        return view('checkout', compact('cartItems', 'total'));
    }

    // If cart is empty and no session backup, redirect back
    if ($cartItems->isEmpty()) {
        \Log::info('Cart completely empty, redirecting to cart');
        return redirect()->route('cart.index')
            ->with('error', 'Keranjang belanja Anda kosong. Silahkan tambahkan produk terlebih dahulu.');
    }

    $total = $cartItems->sum(function ($item) {
        return $item->quantity * $item->produk->price;
    });

    return view('checkout', compact('cartItems', 'total'));
}

    
public function process(Request $request)
{
    try {
        DB::beginTransaction();
        
        // Log data request
        \Log::info('Process Request Data:', $request->all());
        
        $validated = $request->validate([
            'delivery_method' => 'required|in:diantar,diambil',
            'address' => 'required_if:delivery_method,diantar',
            'payment_method' => 'required|in:e-wallet,bank_transfer,bayar_ditempat',
            'bank_account' => 'required_if:payment_method,bank_transfer',
            'wallet_account' => 'required_if:payment_method,e-wallet'
        ]);

        \Log::info('Validated Data:', $validated);
        \Log::info('User ID:', [Auth::id()]);

        // Call stored procedure
        if (session()->has('direct_purchase')) {
            $cartItem = session('cartItems');
            $result = DB::select(
                'CALL CreateOrder(?, ?, ?, ?, ?, ?, ?, ?, ?)',
                [
                    Auth::id(),
                    $validated['delivery_method'],
                    $validated['payment_method'],
                    $this->getPaymentDetails($request),
                    $validated['delivery_method'] === 'diambil' ? 'Diambil di toko' : $validated['address'],
                    true, // isDirectPurchase
                    $cartItem->produk->id,
                    $cartItem->quantity,
                    $cartItem->produk->price
                ]
            );
        } else {
            $result = DB::select(
                'CALL CreateOrder(?, ?, ?, ?, ?, ?, ?, ?, ?)',
                [
                    Auth::id(),
                    $validated['delivery_method'],
                    $validated['payment_method'],
                    $this->getPaymentDetails($request),
                    $validated['delivery_method'] === 'diambil' ? 'Diambil di toko' : $validated['address'],
                    false, // isDirectPurchase
                    null,
                    null,
                    null
                ]
            );
        }

        \Log::info('Stored Procedure Result:', $result ?? ['No result']);

        if (empty($result)) {
            throw new \Exception('Gagal membuat pesanan');
        }

        $orderId = $result[0]->{'Created Order ID'};
        \Log::info('Order ID Created:', [$orderId]);
        
        DB::commit();
        \Log::info('Transaction committed successfully');
        
        return redirect()->route('order.details')
            ->with('success', 'Pesanan berhasil dibuat!');

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Checkout Error: ' . $e->getMessage());
        \Log::error('Full Error:', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->back()
            ->with('error', 'Terjadi kesalahan dalam pemrosesan pesanan: ' . $e->getMessage())
            ->withInput();
    }
}
// Tambahkan method baru untuk handle update status
public function updateOrderStatus($orderId, $status)
{
    try {
        DB::beginTransaction();
        
        $orderItem = DB::table('order_items')
            ->where('order_id', $orderId)
            ->first();

        if ($orderItem) {
            // Update status
            DB::table('order_items')
                ->where('order_id', $orderId)
                ->update(['status' => $status]);

            // Jika status selesai atau dibatalkan, hapus dari cart
            if (in_array($status, ['selesai', 'dibatalkan'])) {
                Cart::where('customer_id', Auth::id())
                    ->whereIn('produk_id', function($query) use ($orderId) {
                        $query->select('produk_id')
                            ->from('order_items')
                            ->where('order_id', $orderId);
                    })
                    ->delete();
            }
        }

        DB::commit();
        return true;

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Update Status Error: ' . $e->getMessage());
        return false;
    }
}


    public function directCheckout(Request $request)
{
    $request->validate([
        'id' => 'required|exists:produk,id',  // Diubah dari produks menjadi produk
        'name' => 'required|string',
        'price' => 'required|numeric',
        'quantity' => 'required|integer|min:1'
    ]);

    // Get the product data
    $product = Product::findOrFail($request->id);

    // Buat object cart item dengan semua informasi yang diperlukan
    $cartItem = (object)[
        'produk' => $product,
        'quantity' => $request->quantity,
        'name' => $request->name,
        'price' => $request->price
    ];

    // Hitung total
    $total = $request->price * $request->quantity;

    // Simpan ke session
    session([
        'direct_purchase' => true,
        'cartItems' => $cartItem,
        'total' => $total
    ]);

    return redirect()->route('checkout.index');
}

private function getPaymentDetails($request)
{
    switch ($request->payment_method) {
        case 'bank_transfer':
            return $request->bank_account;
        case 'e-wallet':
            return $request->wallet_account;
        case 'bayar_ditempat':
            return 'Cash';
        default:
            return null;
    }
}

private function getOrderStatus($request)
{
    if ($request->delivery_method === 'diambil' && $request->payment_method === 'bayar_ditempat') {
        return 'sedang_diproses';
    }
    return 'menunggu_pembayaran';
}
    public function success()
    {
        return view('checkout.success');
    }
}