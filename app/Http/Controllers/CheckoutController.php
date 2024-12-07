<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Model Order untuk menyimpan data pesanan
use App\Models\OrderItem; // Model OrderItem untuk menyimpan item pesanan
use App\Models\Cart; // Model Cart untuk mendapatkan item keranjang
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        // Ambil semua item keranjang berdasarkan customer_id
        $cartItems = Cart::where('customer_id', Auth::id())
                         ->with('produk') // Ambil produk terkait
                         ->get();

        // Hitung subtotal
        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->produk->price;
        });

        // Hitung pajak (10%)
        $tax = $subtotal * 0.1;

        // Hitung total
        $total = $subtotal + $tax;

        // Kirim data ke view checkout
        return view('checkout', compact('cartItems', 'subtotal', 'tax', 'total'));
    }

    // Memproses pesanan setelah checkout
    public function process(Request $request)
    {
        // Validasi input dari form checkout
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        // Membuat pesanan baru
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

        // Menyimpan item pesanan
        foreach (Cart::where('customer_id', Auth::id())->get() as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'produk_id' => $item->produk_id,
                'quantity' => $item->quantity,
                'price' => $item->produk->price,
            ]);
        }

        // Mengosongkan keranjang setelah checkout
        Cart::where('customer_id', Auth::id())->delete();

        // Mengarahkan pengguna ke halaman konfirmasi dengan pesan sukses
        return redirect()->route('checkout.success')->with('success', 'Pesanan Anda berhasil diproses!');
    }

    // Halaman konfirmasi checkout
    public function success()
    {
        return view('checkout.success');
    }
}
