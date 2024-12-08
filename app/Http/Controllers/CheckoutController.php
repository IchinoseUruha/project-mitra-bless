<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem; 
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (session()->has('direct_purchase')) {
            $cartItems = collect([session('cartItems')]);
            $subtotal = session('subtotal');
            $tax = session('tax');
            $total = session('total');
            
            session()->forget(['direct_purchase', 'cartItems', 'subtotal', 'tax', 'total']);
        } else {
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

    public function directCheckout(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:produk,id',
            'quantity' => 'required|integer|min:1'
        ]);

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

        session([
            'direct_purchase' => true,
            'cartItems' => $cartItem,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total
        ]);

        return redirect()->route('checkout.index');
    }

    public function process(Request $request)
    {
        $request->validate([
            'address' => 'required_if:sending_method,diantar',
            'payment_method' => 'required|in:credit_card,bank_transfer,cash_on_delivery',
            'sending_method' => 'required|in:diantar,diambil'
        ]);

        try {
            $orderNumber = 'ORD-' . strtoupper(Str::random(10));

            if (session()->has('direct_purchase')) {
                $cartItem = session('cartItems');
                $subtotal = session('subtotal');
                $tax = session('tax');
                $total = session('total');
            } else {
                $cartItems = Cart::where('customer_id', Auth::id())
                                ->with('produk')
                                ->get();

                $subtotal = $cartItems->sum(function ($item) {
                    return $item->quantity * $item->produk->price;
                });
                $tax = $subtotal * 0.1;
                $total = $subtotal + $tax;
            }

            $initialStatus = 'menunggu_pembayaran';
            
            if ($request->sending_method === 'diambil' && $request->payment_method === 'cash_on_delivery') {
                $initialStatus = 'sedang_diproses';
            }

            $order = Order::create([
                'customer_id' => Auth::id(),
                'order_number' => $orderNumber,
                'address' => $request->sending_method === 'diantar' ? $request->address : null,
                'delivery_method' => $request->sending_method,
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'status' => $initialStatus
            ]);

            if (session()->has('direct_purchase')) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'produk_id' => $cartItem->produk->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->produk->price,
                    'subtotal' => $cartItem->quantity * $cartItem->produk->price
                ]);
                session()->forget(['direct_purchase', 'cartItems', 'subtotal', 'tax', 'total']);
            } else {
                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'produk_id' => $item->produk_id,
                        'quantity' => $item->quantity,
                        'price' => $item->produk->price,
                        'subtotal' => $item->quantity * $item->produk->price
                    ]);
                }
            }

            return redirect()->route('order.details', $order->id)
                           ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat memproses pesanan.')
                           ->withInput();
        }
    }

    public function success()
    {
        return view('checkout.success');
    }
}