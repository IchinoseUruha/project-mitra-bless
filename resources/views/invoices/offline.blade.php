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
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .company-info {
            margin-bottom: 30px;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        .total {
            text-align: right;
            margin-top: 30px;
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
        <p><strong>Customer:</strong> {{ $customerName }}</p>
        <p><strong>Date:</strong> {{ $invoice_date }}</p>
        <p><strong>Payment Method:</strong> {{ ucfirst($orderItem->payment_method) }}</p>
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
                <td>{{ $orderItem->nama_produk ?? $orderItem->produk_id}}</td>
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
</body>
</html>
