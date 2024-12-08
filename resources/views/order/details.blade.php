@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-pink text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Pesanan #{{ $order->order_number }}</h5>
                    <span class="badge bg-white text-pink">{{ ucwords(str_replace('_', ' ', $order->status)) }}</span>
                </div>
                
                <div class="card-body">
                    <!-- Informasi Pengiriman -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Informasi Pengiriman</h6>
                            <p><strong>Metode:</strong> {{ ucwords($order->delivery_method) }}</p>
                            @if($order->address)
                                <p><strong>Alamat:</strong> {{ $order->address }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6>Informasi Pembayaran</h6>
                            <p><strong>Metode:</strong> {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p>
                            <p><strong>Status:</strong> {{ ucwords(str_replace('_', ' ', $order->status)) }}</p>
                        </div>
                    </div>

                    <!-- Detail Produk -->
                    <h6>Detail Produk</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-pink text-white">
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
                            </tbody>
                            <tfoot>
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
                            </tfoot>
                        </table>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-4">
                        @if($order->status === 'menunggu_pembayaran')
                            <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin membatalkan pesanan?')">Batalkan Pesanan</button>
                            </form>
                        @endif

                        @if($order->status === 'sedang_dikirim')
                            <form action="{{ route('order.confirm', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success">Konfirmasi Diterima</button>
                            </form>
                        @endif
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
.badge {
    padding: 8px 12px;
}
</style>
@endsection