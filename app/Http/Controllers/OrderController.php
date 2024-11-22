<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    // Halaman Order History
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('order.history', compact('orders'));
    }

    // Halaman Detail Order
    public function show($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->with('orderItems.product')->firstOrFail();
        return view('order.details', compact('order'));
    }
}

