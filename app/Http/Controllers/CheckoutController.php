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
        // Check if this is direct purchase
        if (session()->has('direct_purchase')) {
            $cartItems = collect([session('cartItems')]);
            $total = session('total');
            
            return view('checkout', compact('cartItems', 'total'));
        } 
        
        // If not direct purchase, check cart
        $cartItems = Cart::where('customer_id', Auth::id())
            ->with('produk')
            ->get();
    
        // If cart is empty, redirect back
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja Anda kosong. Silahkan tambahkan produk terlebih dahulu.');
        }
    
        // Calculate total from cart items
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->produk->price;
        });
    
        return view('checkout', compact('cartItems', 'total'));
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

public function process(Request $request)
{
    $validated = $request->validate([
        'delivery_method' => 'required|in:diantar,diambil',
        'address' => 'required_if:delivery_method,diantar',
        'payment_method' => 'required|in:e-wallet,bank_transfer,bayar_ditempat',
        'bank_account' => 'required_if:payment_method,bank_transfer',
        'wallet_account' => 'required_if:payment_method,e-wallet'
    ]);

    try {
        DB::beginTransaction();

        if (session()->has('direct_purchase')) {
            Cart::create([
                'customer_id' => Auth::id(),
                'produk_id' => session('cartItems')->produk->id,
                'quantity' => session('cartItems')->quantity
            ]);
        }
        
        // Panggil procedure (order_number sudah di-generate di dalam procedure)
        DB::statement('CALL InsertOrderAndItems(?)', [Auth::id()]);
        
        // Get latest order untuk data tambahan
        $order = Order::where('customer_id', Auth::id())
                     ->latest()
                     ->first();

        // Update order items dengan additional details
        OrderItem::where('order_id', $order->id)->update([
            'address' => $request->delivery_method === 'diambil' ? 'Diambil di toko' : $request->address,
            'delivery_method' => $request->delivery_method,
            'payment_method' => $request->payment_method,
            'payment_details' => $this->getPaymentDetails($request),
            'status' => $this->getOrderStatus($request)
        ]);

        if (session()->has('direct_purchase')) {
            session()->forget(['direct_purchase', 'cartItems', 'total']);
        }

        DB::commit();
        return redirect()->route('order.details', $order->id)
            ->with('success', 'Pesanan berhasil dibuat!');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
            ->withInput();
    }
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
            return OrderItem::STATUS['SEDANG_DIPROSES'];
        }
        return OrderItem::STATUS['MENUNGGU_PEMBAYARAN'];
    }

    public function success()
    {
        return view('checkout.success');
    }
}