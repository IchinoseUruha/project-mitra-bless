@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order History</h1>

    @if ($orders->isEmpty())
        <p>You have no orders yet.</p>
    @else
        <table class="table order-table">
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Date</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td>${{ number_format($order->total_price, 2) }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>
                            <a href="{{ route('order.details', $order->id) }}" class="btn btn-primary btn-sm">View Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

<style>
    .order-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .order-table th, .order-table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    .order-table th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        padding: 5px 10px;
        border-radius: 5px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>
