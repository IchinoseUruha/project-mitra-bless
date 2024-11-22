@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order Details</h1>

    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
    <p><strong>Total Price:</strong> ${{ number_format($order->total_price, 2) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Date:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>

    <h3>Order Items</h3>
    <table class="table order-items-table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

<style>
    .order-items-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .order-items-table th, .order-items-table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    .order-items-table th {
        background-color: #f4f4f4;
        font-weight: bold;
    }
</style>
