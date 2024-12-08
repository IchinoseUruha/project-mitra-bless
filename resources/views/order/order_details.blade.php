@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-pink text-white">
                    <h5 class="mb-0">Daftar Pesanan</h5>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nomor Pesanan</th>
                                    <th>Tanggal</th>
                                    <th>Produk</th>
                                    <th>Alamat</th>
                                    <th>Status Pembayaran</th>
                                    <th>Metode Pengiriman</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td>
                                        @foreach($order->items as $item)
                                            {{ $item->produk->name }} ({{ $item->quantity }})<br>
                                        @endforeach
                                    </td>
                                    <td>{{ $order->address }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status == 'menunggu_pembayaran' ? 'warning' : 
                                            ($order->status == 'diproses' ? 'info' : 
                                            ($order->status == 'dikirim' ? 'primary' : 
                                            ($order->status == 'selesai' ? 'success' : 'danger'))) }}">
                                            {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ ucwords($order->delivery_method) }}</td>
                                    <td>{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</td>
                                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info mb-1" data-bs-toggle="modal" data-bs-target="#orderDetail{{ $order->id }}">
                                            Detail
                                        </button>
                                        @if($order->status == 'menunggu_pembayaran')
                                            <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin membatalkan pesanan?')">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Modal Detail Pesanan -->
                                <div class="modal fade" id="orderDetail{{ $order->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-pink text-white">
                                                <h5 class="modal-title">Detail Pesanan #{{ $order->order_number }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-bordered">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th>Produk</th>
                                                            <th>Harga</th>
                                                            <th>Jumlah</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($order->items as $item)
                                                        <tr>
                                                            <td>{{ $item->produk->name }}</td>
                                                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                                            <td>{{ $item->quantity }}</td>
                                                            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                                        </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                                            <td>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" class="text-end"><strong>Pajak (10%):</strong></td>
                                                            <td>Rp {{ number_format($order->tax, 0, ',', '.') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                                            <td><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-pink {
    background-color: #F062A8 !important;
}
.text-pink {
    color: #F062A8 !important;
}
.table td {
    vertical-align: middle;
}
</style>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@endsection