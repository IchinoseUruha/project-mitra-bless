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
        $orders = Order::with(['items.produk','customer'])
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
    
        // Update status di order items
        OrderItem::where('order_id', $id)
                 ->update(['status' => 'dibatalkan']);
    
        return redirect()->back()
                        ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    // // Konfirmasi pesanan diterima
    // public function confirm($id)
    // {
    //     $order = Order::where('id', $id)
    //                  ->where('customer_id', Auth::id())
    //                  ->firstOrFail();

    //     if ($order->status !== 'sedang_dikirim') {
    //         return back()->with('error', 'Status pesanan tidak dapat diubah.');
    //     }

    //     $order->update(['status' => 'dikirim']);

    //     return redirect()->route('order.details', $order->id)
    //                     ->with('success', 'Pesanan telah dikonfirmasi diterima.');
    // }

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

    public function uploadBukti(Request $request, $id)
    {
        \Log::info('Upload Bukti Started for Order ID: ' . $id);
        
        try {
            // Validate with a larger file size limit if needed
            $request->validate([
                'bukti_pembayaran' => 'required|image|mimes:jpg,png,jpeg|max:5120' // Increased to 5MB
            ]);
    
            // Find the order first, then get its first item
            $order = Order::findOrFail($id);
            $orderItem = $order->items()->first();
            
            if (!$orderItem) {
                \Log::error('OrderItem not found for Order ID: ' . $id);
                return redirect()->back()->with('error', 'Order item tidak ditemukan');
            }
    
            if ($request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');
                
                // Log file information
                \Log::info('File Details:', [
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize()
                ]);
                
                // Create upload directory if it doesn't exist
                $uploadPath = public_path('uploads/bukti_pembayaran');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
    
                $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                
                try {
                    // Move the file
                    $file->move($uploadPath, $filename);
                    
                    // Update database with transaction
                    \DB::beginTransaction();
                    
                    $orderItem->bukti_pembayaran = $filename;
                    $orderItem->status = 'sedang_diproses';
                    $orderItem->save();
                    
                    \DB::commit();
                    \Log::info('Upload successful for Order ID: ' . $id . ', File: ' . $filename);
                    
                    return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload');
                    
                } catch (\Exception $e) {
                    \DB::rollBack();
                    \Log::error('Error in file upload or database update: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'Gagal mengupload bukti pembayaran: ' . $e->getMessage());
                }
            }
    
            return redirect()->back()->with('error', 'Tidak ada file yang diupload');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Error: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors($e->validator)
                ->with('error', 'File terlalu besar. Maksimal ukuran file adalah 5MB.');
        } catch (\Exception $e) {
            \Log::error('Upload Bukti Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

public function updateStatus($id)
{
    $orderItem = OrderItem::findOrFail($id);
    
    // Logic untuk update status sesuai enum di database
    switch($orderItem->status) {
        case 'menunggu_pembayaran':
            $orderItem->status = 'sedang_diproses';
            break;
        case 'sedang_diproses':
            $orderItem->status = 'dikirim';  // bukan sedang_dikirim
            break;
        case 'dikirim':
            $orderItem->status = 'selesai';
            break;
        default:
            return back()->with('error', 'Status tidak dapat diubah');
    }
    
    try {
        $orderItem->save();
        return back()->with('success', 'Status berhasil diperbarui');
    } catch (\Exception $e) {
        return back()->with('error', 'Gagal mengupdate status: ' . $e->getMessage());
    }
}
public function getOrderDetail($id)
{
    $order = OrderItem::findOrFail($id);
    return response()->json($order);
}

}

