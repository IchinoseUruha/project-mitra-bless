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
            $orderItem = OrderItem::findOrFail($id);
            $order = Order::with('user')->findOrFail($orderItem->order_id);  // Menggunakan relasi yang sudah ada
            // Debug the relationships
            \Log::info('Order Data:', [
                'order_id' => $order->id,
                'customer_id' => $order->customer_id,
                'user' => $order->user
            ]);

            $data = [
                'order' =>$order,
                'orderItem' => $orderItem,
                'company_name' => 'Toko Bless',
                'company_address' => 'Jln. Gacor King',
                'company_phone' => '081 488 sisanya kapan2',
                'invoice_date' => now()->format('d/m/Y'),
            ];

            $pdf = PDF::loadView('invoices.online', $data);
            
            return $pdf->download('Invoice-'.$orderItem->order_number.'.pdf');
        }
}