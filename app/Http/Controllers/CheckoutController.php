<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        if (session()->has('direct_purchase')) {
            // Get data for direct purchase
            $cartItems = session('cartItems');
            $subtotal = session('subtotal');
            $tax = session('tax');
            $total = session('total');
            
            // Clear the session after getting the data
            session()->forget(['direct_purchase', 'cartItems', 'subtotal', 'tax', 'total']);
        } else {
            // Get cart items from database
            $cartItems = Cart::where('customer_id', Auth::id())
                           ->with('produk')
                           ->get();

            // Calculate subtotal
            $subtotal = $cartItems->sum(function ($item) {
                return $item->quantity * $item->produk->price;
            });

            // Calculate tax (10%)
            $tax = $subtotal * 0.1;

            // Calculate total
            $total = $subtotal + $tax;
        }

        // Send data to checkout view
        return view('checkout', compact('cartItems', 'subtotal', 'tax', 'total'));
    }

    public function directCheckout(Request $request)
    {
        // Create data for single item checkout
        $cartItem = (object)[
            'produk' => (object)[
                'id' => $request->id,
                'name' => $request->name,
                'price' => $request->price
            ],
            'quantity' => $request->quantity
        ];

        $subtotal = $request->price * $request->quantity;
        $tax = $subtotal * 0.1;
        $total = $subtotal + $tax;

        // Store in session
        session([
            'direct_purchase' => true,
            'cartItems' => [$cartItem],
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total
        ]);

        return redirect()->route('checkout.index');
    }

    public function process(Request $request)
    {
        // Validate checkout form input
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        // Create new order
        $order = Order::create([
            'customer_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'payment_method' => $request->payment_method,
            'subtotal' => $request->subtotal,
            'tax' => $request->tax,
            'total' => $request->total,
        ]);

        if (session()->has('direct_purchase')) {
            // Process direct purchase items
            $cartItems = session('cartItems');
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'produk_id' => $item->produk->id,
                    'quantity' => $item->quantity,
                    'price' => $item->produk->price,
                ]);
            }
            
            // Clear direct purchase session
            session()->forget(['direct_purchase', 'cartItems', 'subtotal', 'tax', 'total']);
        } else {
            // Process cart items
            foreach (Cart::where('customer_id', Auth::id())->get() as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'produk_id' => $item->produk_id,
                    'quantity' => $item->quantity,
                    'price' => $item->produk->price,
                ]);
            }

            // Clear cart after checkout
            Cart::where('customer_id', Auth::id())->delete();
        }

        // Redirect to success page with message
        return redirect()->route('checkout.success')->with('success', 'Pesanan Anda berhasil diproses!');
    }

    public function success()
    {
        return view('checkout.success');
    }
}