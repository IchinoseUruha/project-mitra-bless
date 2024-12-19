<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\OfflineOrderItem;
use Illuminate\Http\Request;
use PDF;

class InvoiceController extends Controller
{
    public function downloadOfflineInvoice($id)
    {
        $orderItem = OfflineOrderItem::findOrFail($id);
        
        // Load order with user relationship dan utype
        $order = null;
        $customerName = 'N/A';
        
        if ($orderItem->order_id) {
            $order = Order::with(['user'])->findOrFail($orderItem->order_id);
            
            // Check utype user
            if ($order->user) {
                $customerName = ($order->user->utype == 'ADMIN' || $order->user->utype == 'KARYAWAN') 
                    ? 'Tidak memiliki nama' 
                    : $order->user->name;
            }
            
            // Debug data
            \Log::info('Order and Customer Data:', [
                'order_id' => $order->id,
                'customer_id' => $order->customer_id,
                'customer_name' => $customerName,
                'utype' => $order->user->utype ?? 'No utype'
            ]);
        }
    
        $data = [
            'orderItem' => $orderItem,
            'order' => $order,
            'customerName' => $customerName,
            'company_name' => 'Toko Bless',
            'company_address' => 'Jln. Gacor King',
            'company_phone' => '081 488 sisanya kapan2',
            'invoice_date' => now()->format('d/m/Y'),
        ];
    
        $pdf = PDF::loadView('invoices.offline', $data);
        
        return $pdf->download('Invoice-'.$orderItem->order_number.'.pdf');
    }
    public function downloadOnlineInvoice($id)
    {
        $order = Order::with(['items.produk', 'user'])->findOrFail($id);
        
        // Calculate totals
        $totalAmount = 0;
        $totalDiscount = 0;
        
        foreach ($order->items as $item) {
            $totalAmount += $item->total;
            
            if (auth()->user()->utype != 'customer_b') {
                if ($item->quantity >= 36) {
                    $discount = 10;
                } elseif ($item->quantity >= 12) {
                    $discount = 5;
                } else {
                    $discount = 0;
                }
                $totalDiscount += ($item->total * $discount / 100);
            }
        }

        $data = [
            'order' => $order,
            'company_name' => 'Toko Bless',
            'company_address' => 'Jln. Gacor King',
            'company_phone' => '081 488 sisanya kapan2',
            'invoice_date' => now()->format('d/m/Y'),
            'totalAmount' => $totalAmount,
            'totalDiscount' => $totalDiscount,
            'finalTotal' => $totalAmount - $totalDiscount
        ];

        $pdf = PDF::loadView('invoices.online', $data);
        
        return $pdf->download('Invoice-'.$order->items->first()->order_number.'.pdf');
    }
}