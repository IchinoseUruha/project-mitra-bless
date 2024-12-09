<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    // Halaman Kasir
    public function showKasir()
    {
        // Ambil data pesanan yang belum dibayar
        $orders = Order::with(['items.produk'])
                    ->where('status', 'menunggu_pembayaran') // Filter berdasarkan status
                    ->get();

        if ($orders->isEmpty()) {
            return view('kasir')->with('message', 'Tidak ada pesanan yang belum dibayar.');
        }

        // Menghitung total dan pajak
        $total = 0;
        $tax = 0;
        
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $quantity = $item->quantity;
                $productPrice = $item->produk->price;

                // Hitung subtotal untuk item
                $subtotal = $productPrice * $quantity;

                // Hitung diskon berdasarkan jenis produk
                $discount = 0;
                if ($item->produk->type == 1) {
                    $discount = 5;
                    $quantity *= 12; // 1 lusin = 12 pcs
                } elseif ($item->produk->type == 2) {
                    $discount = 10;
                    $quantity *= 24; // 24 lusin
                } elseif ($item->produk->type == 3) {
                    $discount = 10;
                    $quantity *= 3; // 3 lusin
                }

                // Hitung subtotal item dengan diskon
                $discountAmount = ($subtotal * $discount) / 100;
                $totalItem = $subtotal - $discountAmount;

                // Update total
                $total += $totalItem;
            }
        }

        // Hitung pajak 10% dari total
        $tax = $total * 0.1;

        // Kirim data ke view
        return view('kasir', compact('orders', 'total', 'tax'));
    }

    // Konfirmasi Pembayaran
    public function confirmPayment(Request $request)
    {
        // Proses konfirmasi pembayaran di sini
        // Contoh: update status order menjadi 'lunas'
        
        // Setelah konfirmasi, redirect kembali ke halaman kasir atau halaman lain
        return redirect()->route('kasir.index')->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }
}
