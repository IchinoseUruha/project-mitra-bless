<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $orderItem->order_number }}</title>
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
        <p><strong>Invoice Number:</strong> #{{ $orderItem->order_number }}</p>
        <p><strong>Customer:</strong> {{ $order->user->name ?? 'N/A' }}</p> 
        <p><strong>Tanggal:</strong> {{ $invoice_date }}</p>
        <p><strong>Metode Pembayaran:</strong> {{ ucfirst(str_replace('_', ' ', $orderItem->payment_method)) }}</p>
        <p><strong>Detail Pembayaran:</strong> {{ $orderItem->payment_details }}</p>
        <p><strong>Shipping Address:</strong> {{ $orderItem->address }}</p>
        <p><strong>Delivery Method:</strong> {{ ucfirst($orderItem->delivery_method) }}</p>
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
            <tr>
                <td>{{ $orderItem->nama_produk ?? $orderItem->produk_id }}</td>
                <td>{{ $orderItem->quantity }}</td>
                <td>Rp {{ number_format($orderItem->price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($orderItem->total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="total">
        <p><strong>Subtotal:</strong> Rp {{ number_format($orderItem->total, 0, ',', '.') }}</p>
        @if($orderItem->harga_diskon)
            <p><strong>Discount:</strong> Rp {{ number_format($orderItem->total - $orderItem->harga_diskon, 0, ',', '.') }}</p>
            <p><strong>Grand Total:</strong> Rp {{ number_format($orderItem->harga_diskon, 0, ',', '.') }}</p>
        @endif
    </div>

    {{-- <div class="payment-info">
        <p>Thank you for your purchase!</p>
        @if($orderItem->payment_method != 'cash')
            <p>Please complete your payment to process your order.</p>
        @endif
    </div> --}}
</body>
</html>