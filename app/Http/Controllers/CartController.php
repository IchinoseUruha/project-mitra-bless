<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart; // Model Cart untuk database
use App\Models\Product; // Model product
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user/customer ID

class CartController extends Controller
{
    // Menampilkan keranjang
    public function index()
    {
        // Ambil semua item keranjang dari database berdasarkan customer_id
        $items = Cart::where('customer_id', Auth::id())
            ->with('produk') // Ambil data product terkait
            ->get();

        // Hitung subtotal
        $subtotal = $items->sum(function ($item) {
            return $item->quantity * $item->produk->price;
        });

        // Hitung pajak (10% dari subtotal)
        $tax = $subtotal * 0.1;

        // Hitung total
        $total = $subtotal + $tax;

        // Kirim data ke view
        return view('cart', compact('items', 'subtotal', 'tax', 'total'));
    }

    // Menambahkan item ke keranjang
    public function add_items(Request $request)
    {
        // dd($request->all());

         // Cek apakah pengguna sudah login
    if (!Auth::check()) {
        // Jika belum login, kirim pesan ke sesi
        return redirect()->route('login')->with('login_error', 'Anda belum login, silakan login terlebih dahulu.');
    }

        // Validasi input
        $request->validate([
            'id' => 'required|exists:produk,id', // Pastikan 'id' adalah ID valid di tabel 'produk'
            'name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
        ]);
    
        // Simpan atau update item di tabel cart
        Cart::updateOrCreate(
            [
                'customer_id' => Auth::id(),
                'produk_id' => $request->id,
            ],
            [
                'quantity' => Cart::where('customer_id', Auth::id())
                    ->where('produk_id', $request->id)
                    ->exists()
                    ? Cart::where('customer_id', Auth::id())
                        ->where('produk_id', $request->id)
                        ->first()
                        ->quantity + $request->quantity
                    : $request->quantity,
            ]
        );
    
        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
    

    // Menambah kuantitas item
    public function increase_quantity($id)
    {
        Cart::where('customer_id', Auth::id())
            ->where('id', $id)
            ->increment('quantity');

        return redirect()->route('cart.index');
    }

    // Mengurangi kuantitas item
    public function decrease_quantity($id)
    {
        $cartItem = Cart::where('customer_id', Auth::id())->findOrFail($id);
        if ($cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        } else {
            $cartItem->delete();
        }
        return redirect()->route('cart.index');
    }

    // Menghapus item dari keranjang
    public function remove_item($id)
    {
        $cartItem = Cart::where('customer_id', Auth::id())->findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    // Mengosongkan keranjang
    public function clear_cart()
    {
        Cart::where('customer_id', Auth::id())->delete();
        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan.');
    }

    public function produk()
{
    return view('cart', compact('items', 'subtotal', 'tax', 'total'));
    return $this->belongsTo(Product::class, 'produk_id');
}
}
