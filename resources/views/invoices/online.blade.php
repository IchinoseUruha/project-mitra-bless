<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->items->first()->order_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px 0;
            border-bottom: 2px solid #f3f3f3;
        }
        .header h1 {
            font-size: 28px;
            color: #333;
            margin: 0 0 10px 0;
        }
        .header p {
            color: #666;
            margin: 5px 0;
        }
        .invoice-details {
            margin-bottom: 40px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .invoice-details p {
            margin: 8px 0;
            color: #444;
        }
        .invoice-details strong {
            color: #333;
            width: 150px;
            display: inline-block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0 30px;
            background: white;
        }
        th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
            text-align: left;
            padding: 12px;
            border: 1px solid #ddd;
            text-transform: uppercase;
            font-size: 12px;
        }
        td {
            padding: 12px;
            border: 1px solid #ddd;
            color: #444;
        }
        tr:hover {
            background-color: #f8f9fa;
        }
        .total {
            text-align: right;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #f3f3f3;
        }
        .total p {
            margin: 8px 0;
            font-size: 15px;
            color: #444;
        }
        .total p:last-child {
            font-size: 16px;
            color: #333;
            font-weight: bold;
        }
        .total strong {
            width: 150px;
            display: inline-block;
        }
        .payment-info {
            margin-top: 40px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 5px;
            color: #666;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <p>{{ $company_name }}</p>
        <p>{{ $company_address }}</p>
        <p>{{ $company_phone }}</p>
    </div>

    <div class="invoice-details">
        <p><strong>Invoice Number:</strong> #{{ $order->items->first()->order_number }}</p>
        <p><strong>Customer:</strong> {{ $order->user->name ?? 'N/A' }}</p> 
        <p><strong>Tanggal:</strong> {{ $invoice_date }}</p>
        <p><strong>Metode Pembayaran:</strong> {{ ucfirst(str_replace('_', ' ', $order->items->first()->payment_method)) }}</p>
        <p><strong>Detail Pembayaran:</strong> {{ $order->items->first()->payment_details }}</p>
        <p><strong>Shipping Address:</strong> {{ $order->items->first()->address }}</p>
        <p><strong>Delivery Method:</strong> {{ ucfirst($order->items->first()->delivery_method) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalAmount = 0;
                $totalDiscount = 0;
            @endphp
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->produk->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
            </tr>
            @php
                $totalAmount += $item->total;
                if(Auth::user()->utype != 'customer_b') {
                    if($item->quantity >= 36) {
                        $discount = 10;
                    } elseif($item->quantity >= 12) {
                        $discount = 5;
                    } else {
                        $discount = 0;
                    }
                    $totalDiscount += ($item->total * $discount / 100);
                }
            @endphp
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p><strong>Subtotal:</strong> Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
        @if($totalDiscount > 0)
            <p><strong>Discount:</strong> Rp {{ number_format($totalDiscount, 0, ',', '.') }}</p>
            <p><strong>Grand Total:</strong> Rp {{ number_format($totalAmount - $totalDiscount, 0, ',', '.') }}</p>
        @else
            <p><strong>Grand Total:</strong> Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
        @endif
    </div>

    <div class="payment-info">
        <p>Terima kasih telah berbelanja di {{ $company_name }}.</p>
        <p>Jika ada pertanyaan, silakan hubungi kami di {{ $company_phone }}.</p>
    </div>
</body>
</html>