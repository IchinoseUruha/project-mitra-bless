@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Order Status -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-pink mb-0">Order #{{ $order->order_number }}</h3>
                        <span class="badge bg-pink">{{ ucwords(str_replace('_', ' ', $order->status)) }}</span>
                    </div>

                    <!-- Status Timeline -->
                    <div class="status-track mb-4">
                        <div class="status-line">
                            <div class="status-step {{ $order->status == 'menunggu_pembayaran' ? 'active' : '' }} 
                                {{ in_array($order->status, ['sedang_diproses', 'sedang_dikirim', 'dikirim']) ? 'completed' : '' }}">
                                <div class="step-icon">1</div>
                                <div class="step-text">Menunggu Pembayaran</div>
                            </div>
                            <div class="status-step {{ $order->status == 'sedang_diproses' ? 'active' : '' }}
                                {{ in_array($order->status, ['sedang_dikirim', 'dikirim']) ? 'completed' : '' }}">
                                <div class="step-icon">2</div>
                                <div class="step-text">Sedang Diproses</div>
                            </div>
                            <div class="status-step {{ $order->status == 'sedang_dikirim' ? 'active' : '' }}
                                {{ in_array($order->status, ['dikirim']) ? 'completed' : '' }}">
                                <div class="step-icon">3</div>
                                <div class="step-text">Sedang Dikirim</div>
                            </div>
                            <div class="status-step {{ $order->status == 'dikirim' ? 'active' : '' }}">
                                <div class="step-icon">4</div>
                                <div class="step-text">Dikirim</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Details -->
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="text-pink mb-4">Detail Pesanan</h4>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Informasi Pengiriman</h5>
                            <p><strong>Metode Pengiriman:</strong> {{ ucwords($order->delivery_method) }}</p>
                            @if($order->address)
                                <p><strong>Alamat:</strong> {{ $order->address }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5>Informasi Pembayaran</h5>
                            <p><strong>Metode Pembayaran:</strong> {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p>
                        </div>
                    </div>

                    <!-- Product List -->
                    <h5>Produk yang Dibeli</h5>
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
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.text-pink {
    color: #F062A8;
}

.bg-pink {
    background-color: #F062A8;
}

.badge.bg-pink {
    font-size: 0.9rem;
    padding: 8px 12px;
}

.card {
    border: none;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

/* Status Timeline Styling */
.status-track {
    padding: 20px 0;
}

.status-line {
    display: flex;
    justify-content: space-between;
    position: relative;
    margin: 0 40px;
}

.status-line:before {
    content: '';
    position: absolute;
    top: 25px;
    left: 50px;
    right: 50px;
    height: 2px;
    background: #e0e0e0;
    z-index: 1;
}

.status-step {
    position: relative;
    z-index: 2;
    text-align: center;
    width: 150px;
}

.step-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #e0e0e0;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    font-weight: bold;
}

.step-text {
    font-size: 0.9rem;
    color: #666;
}

.status-step.active .step-icon {
    background: #F062A8;
}

.status-step.active .step-text {
    color: #F062A8;
    font-weight: bold;
}

.status-step.completed .step-icon {
    background: #28a745;
}

@media (max-width: 768px) {
    .status-line {
        margin: 0 20px;
    }
    
    .step-text {
        font-size: 0.8rem;
    }
    
    .status-step {
        width: 100px;
    }
}
</style>
@endsection