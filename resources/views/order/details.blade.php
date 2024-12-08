@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-pink text-white">
                    <h5 class="mb-0">Daftar Pesanan</h5>
                </div>
                
                <div class="card-body p-0">
                    @foreach($orders as $order)
                    <!-- Header Pesanan -->
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>Nomor Pesanan</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Metode Pengiriman</th>
                                    <th>Alamat</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Detail Pembayaran</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        {{ $order->order_number }}<br>
                                        <span class="text-muted small">
                                            @foreach($order->items as $item)
                                                {{ $item->produk->name }} ({{ $item->quantity }})
                                            @endforeach
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status == 'menunggu_pembayaran' ? 'warning' : 
                                            ($order->status == 'sedang_diproses' ? 'info' : 'secondary') }}">
                                            {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ ucwords($order->delivery_method) }}</td>
                                    <td>{{ucwords($order->address)}}</td>
                                    <td>{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</td>
                                    <td>{{ $order->payment_details }}</td>
                                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-pink" onclick="toggleDetail({{ $order->id }})">Detail</button>
                                        @if($order->status == 'menunggu_pembayaran')
                                            <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin membatalkan pesanan?')">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Detail Produk -->
                    <div class="table-responsive detail-table" id="detail{{ $order->id }}" style="display: none;">
                        <table class="table">
                            <thead class="bg-dark text-white">
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
                            <tfoot class="bg-light">
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
                    <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-pink {
    background-color: #F062A8;
}
.text-pink {
    color: #F062A8;
}
.btn-pink {
    background-color: #F062A8;
    color: white;
}
.btn-pink:hover {
    background-color: #d84d8f;
    color: white;
}
.table > :not(caption) > * > * {
    padding: 0.75rem;
    vertical-align: middle;
}
.detail-table {
    background-color: #f8f9fa;
    padding: 15px;
}
</style>

<script>
function toggleDetail(orderId) {
    const detailElement = document.getElementById('detail' + orderId);
    if (detailElement.style.display === 'none') {
        detailElement.style.display = 'block';
    } else {
        detailElement.style.display = 'none';
    }
}
</script>
@endsection