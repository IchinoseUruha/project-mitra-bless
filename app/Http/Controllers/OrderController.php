<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderDetailsView;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Halaman Order History dengan View
    public function index()
    {
        $orders = Order::with(['items.produk'])
                        ->where('customer_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();
                
        return view('order.details', compact('orders'));
    }

    // Halaman Detail Order dengan View
    public function show($id)
    {
        $orders = Order::with(['items.produk'])
                  ->where('customer_id', Auth::id())
                  ->orderBy('created_at', 'desc')
                  ->get();
                  
        return view('order.details', compact('orders'));
    }

    // Membatalkan pesanan
    public function cancel($id)
    {
        $order = Order::where('id', $id)
                     ->where('customer_id', Auth::id())
                     ->firstOrFail();

        if ($order->status !== 'menunggu_pembayaran') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        $order->update(['status' => 'dibatalkan']);

        return redirect()->route('order.details', $order->id)
                        ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    // Konfirmasi pesanan diterima
    public function confirm($id)
    {
        $order = Order::where('id', $id)
                     ->where('customer_id', Auth::id())
                     ->firstOrFail();

        if ($order->status !== 'sedang_dikirim') {
            return back()->with('error', 'Status pesanan tidak dapat diubah.');
        }

        $order->update(['status' => 'dikirim']);

        return redirect()->route('order.details', $order->id)
                        ->with('success', 'Pesanan telah dikonfirmasi diterima.');
    }

    // Filter pesanan berdasarkan status menggunakan View
    public function filter(Request $request)
    {
        $status = $request->status;
        
        $query = OrderDetailsView::where('customer_email', Auth::user()->email);
        
        if ($status && $status !== 'all') {
            $query = $query->where('status', $status);
        }
        
        $orders = $query->orderBy('order_date', 'desc')
                       ->get()
                       ->unique('order_id');

        if ($request->ajax()) {
            return view('order.partials.order-list', compact('orders'))->render();
        }

        return view('order.history', compact('orders'));
    }

    // Download invoice pesanan menggunakan View
    public function invoice($id)
    {
        $orderDetails = OrderDetailsView::where('order_id', $id)
                                      ->where('customer_email', Auth::user()->email)
                                      ->get();

        if ($orderDetails->isEmpty()) {
            abort(404);
        }

        return view('order.invoice', compact('orderDetails'));
    }

    // Track status pesanan menggunakan View
    public function track($orderNumber)
    {
        $orderDetails = OrderDetailsView::where('order_number', $orderNumber)
                                      ->where('customer_email', Auth::user()->email)
                                      ->first();

        if (!$orderDetails) {
            abort(404);
        }

        return view('order.tracking', compact('orderDetails'));
    }

    // API untuk mendapatkan status pesanan
    public function getStatus($id)
    {
        $orderDetail = OrderDetailsView::where('order_id', $id)
                                     ->where('customer_email', Auth::user()->email)
                                     ->first();

        if (!$orderDetail) {
            return response()->json(['error' => 'Pesanan tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => $orderDetail->status,
            'updated_at' => $orderDetail->order_date
        ]);
    }

    // Helper untuk mendapatkan daftar status yang tersedia
    private function getAvailableStatuses()
    {
        return [
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'sedang_diproses' => 'Sedang Diproses',
            'sedang_dikirim' => 'Sedang Dikirim',
            'dikirim' => 'Dikirim',
            'dibatalkan' => 'Dibatalkan'
        ];
    }
}