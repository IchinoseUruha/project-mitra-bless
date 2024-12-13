<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // This method handles displaying the checkout page
    public function index()
    {
        if (session()->has('direct_purchase')) {
            // For direct purchase, get data from session
            $cartItems = collect([session('cartItems')]);
            $subtotal = session('subtotal');
            $tax = session('tax');
            $total = session('total');

            // Don't forget session here - we need it for processing
            // session()->forget(['direct_purchase', 'cartItems', 'subtotal', 'tax', 'total']);
        } else {
            // For cart purchase, get data from database
            $cartItems = Cart::where('customer_id', Auth::id())
                ->with('produk')
                ->get();

            $subtotal = $cartItems->sum(function ($item) {
                return $item->quantity * $item->produk->price;
            });

            $tax = $subtotal * 0.1;
            $total = $subtotal + $tax;
        }

        return view('checkout', compact('cartItems', 'subtotal', 'tax', 'total'));
    }

    // This method handles direct product purchase
    public function directCheckout(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:produk,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Get the actual product data from database
        $product = Product::findOrFail($request->id);

        // Create cart item object with actual product data
        $cartItem = (object)[
            'produk' => $product, // Use the full product model
            'quantity' => $request->quantity,
        ];

        // Calculate totals using product price from database
        $subtotal = $product->price * $request->quantity;
        $tax = $subtotal * 0.1;
        $total = $subtotal + $tax;

        // Store in session for checkout process
        session([
            'direct_purchase' => true,
            'cartItems' => $cartItem,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);

        return redirect()->route('checkout.index');
    }

    // This method processes the checkout
    public function process(Request $request)
    {
        $validated = $request->validate([
            'sending_method' => 'required|in:diantar,diambil',
            'address' => 'required_if:sending_method,diantar', 
            'payment_method' => 'required|in:bank_transfer,e-wallet,bayar_ditempat',
            'bank_account' => 'required_if:payment_method,bank_transfer',
            'wallet_account' => 'required_if:payment_method,e-wallet'
        ]);

        try {
            $orderNumber = 'ORD-' . strtoupper(Str::random(10));

            if (session()->has('direct_purchase')) {
                // Direct purchase process
                $cartItem = session('cartItems');
                // Get fresh product data
                $product = Product::findOrFail($cartItem->produk->id);
                
                $subtotal = (float)$product->price * (float)$cartItem->quantity;
                $tax = $subtotal * 0.1;
                $total = $subtotal + $tax;

                // Create order
                $order = $this->createOrder($request, $orderNumber, $subtotal, $tax, $total);

                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'produk_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $product->price,
                    'subtotal' => $cartItem->quantity * $product->price
                ]);

                // Clear session after successful order
                session()->forget(['direct_purchase', 'cartItems', 'subtotal', 'tax', 'total']);
            } else {
                // Cart purchase process
                $cartItems = Cart::where('customer_id', Auth::id())
                    ->with('produk')
                    ->get();

                $subtotal = 0;
                foreach ($cartItems as $item) {
                    $product = Product::find($item->produk_id); // Get fresh product data
                    $subtotal += (float)$item->quantity * (float)$product->price;
                }
                $tax = $subtotal * 0.1;
                $total = $subtotal + $tax;

                // Create order
                $order = $this->createOrder($request, $orderNumber, $subtotal, $tax, $total);

                // Create order items
                foreach ($cartItems as $item) {
                    $product = Product::find($item->produk_id); // Get fresh product data
                    OrderItem::create([
                        'order_id' => $order->id,
                        'produk_id' => $product->id,
                        'quantity' => $item->quantity,
                        'price' => $product->price,
                        'subtotal' => $item->quantity * $product->price
                    ]);
                }

                // Clear cart after successful order
                Cart::where('customer_id', Auth::id())->delete();
            }

            return redirect()->route('order.details', $order->id)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Helper method to create order
    private function createOrder($request, $orderNumber, $subtotal, $tax, $total)
    {
        $paymentDetails = null;
        if ($request->payment_method === 'bank_transfer') {
            $paymentDetails = $request->bank_account;
        } elseif ($request->payment_method === 'e-wallet') {
            $paymentDetails = $request->wallet_account;
        } elseif ($request->payment_method === 'bayar_ditempat') {
            $paymentDetails = 'Cash';
        }

        return Order::create([
            'customer_id' => Auth::id(),
            'order_number' => $orderNumber,
            'address' => $request->sending_method === 'diambil' ? 'Diambil di toko' : $request->address,
            'delivery_method' => $request->sending_method,
            'payment_method' => $request->payment_method,
            'payment_details' => $paymentDetails,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'status' => $request->sending_method === 'diambil' && $request->payment_method === 'bayar_ditempat' 
                       ? 'sedang_diproses' : 'menunggu_pembayaran'
        ]);
    }

    public function success()
    {
        return view('checkout.success');
    }
}