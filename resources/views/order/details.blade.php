@extends('layouts.app')

@section('content')
<style>
    /* Header Tabel dengan Gradient */
    tr th {
        background: linear-gradient(to bottom, #F062A8, #E15797) !important;
        color: white !important;
        text-align: center;
        padding: 12px;
        transition: background-color 0.3s ease;
    }
    tr th:hover {
        background-color: #E15797 !important;
    }

    /* Efek Rounded Corners & Shadow */
    .table-responsive {
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 20px;
    }

    /* Hover Effect untuk Baris */
    .table tbody tr:hover {
        background-color: #FFF3F8;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    /* Badge Styling */
    .badge {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 12px;
        font-weight: bold;
        text-transform: capitalize;
    }
    .badge-warning { background-color: #FFC107; color: white; }
    .badge-info { background-color: #17A2B8; color: white; }
    .badge-secondary { background-color: #6C757D; color: white; }

    /* Pink Button Hover Effect */
    .btn-pink {
        background-color: #F062A8;
        color: white;
        transition: all 0.3s ease;
        padding: 8px 16px;
        margin-top: 10px;
    }
    .btn-pink:hover {
        background-color: #E15797;
        box-shadow: 0 0 10px rgba(240, 98, 168, 0.7);
        transform: scale(1.05);
    }

    /* Footer Total Berbeda */
    tfoot tr {
        background-color: #FEEBF5;
        font-weight: bold;
        color: #F062A8;
    }
    .badge-bright-success { background-color: #00FF00 !important; color: black !important; }
    .badge-bright-danger { background-color: #FF0000 !important; color: white !important; }
    .badge-bright-warning { background-color: #FFD700 !important; color: black !important; }
    .badge-bright-info { background-color: #00BFFF !important; color: black !important; }
    .badge-bright-primary { background-color: #0066FF !important; color: white !important; }
    .detail-table th, .detail-table td {
        text-align: center;
        vertical-align: middle;
        padding: 8px;
    }

    /* Modal Custom Styling */
    .modal-header.bg-pink {
        background-color: #F062A8;
    }
    .btn-close {
        color: white;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div>
                <h5 class="mb-0">Daftar Pesanan</h5>
            </div>

            <div class="card-body p-0">
                @foreach($orders as $order)
                    <!-- Header Pesanan -->
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Nomor Pesanan</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Metode Pengiriman</th>
                                    <th>Alamat</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Detail Pembayaran</th>
                                    <th>Total</th>
                                    <th>Bukti Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $key => $item)
                                <tr>
                                    <td>
                                        {{ $item->order_number }}<br>
                                        <span class="text-muted small">
                                            {{ $item->produk->name }} ({{ $item->quantity }})
                                        </span>
                                    </td>
                                    <td>{{ $item->created_at->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge {{ 
                                            $item->status == 'menunggu_pembayaran' ? 'badge-bright-warning' : 
                                            ($item->status == 'sedang_diproses' ? 'badge-bright-info' : 
                                            ($item->status == 'sedang_dikirim' ? 'badge-bright-primary' :
                                            ($item->status == 'selesai' ? 'badge-bright-success' :
                                            ($item->status == 'dibatalkan' ? 'badge-bright-danger' : 'bg-secondary')))) 
                                        }}">
                                            {{ ucwords(str_replace('_', ' ', $item->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ ucwords($item->delivery_method) }}</td>
                                    <td>{{ ucwords($item->address) }}</td>
                                    <td>{{ ucwords(str_replace('_', ' ', $item->payment_method)) }}</td>
                                    <td>{{ $item->payment_details }}</td>
                                    <td>
                                        @if(Auth::user()->utype == 'customer_b')
                                            Rp. {{ number_format($item->total, 2) }}
                                        @else
                                            Rp. {{ number_format($item->harga_diskon, 2) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($key === 0)
                                            @if($item->bukti_pembayaran)
                                                <a href="{{ asset('uploads/bukti_pembayaran/'.$item->bukti_pembayaran) }}" 
                                                target="_blank">
                                                    <img src="{{ asset('uploads/bukti_pembayaran/'.$item->bukti_pembayaran) }}" 
                                                        alt="Bukti Pembayaran" 
                                                        class="img-thumbnail" 
                                                        style="max-width: 100px;">
                                                </a>
                                            @else
                                                @if($item->status == 'menunggu_pembayaran')
                                                <button type="button" 
                                                        class="btn btn-sm btn-pink" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#uploadBuktiModal{{ $order->id }}">
                                                    Upload Bukti
                                                </button>
                                                @else
                                                <span class="badge bg-secondary">Tidak ada bukti</span>
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($key === 0)
                                            <div class="d-flex flex-column gap-2">
                                                <button type="button" class="btn btn-sm btn-pink" onclick="toggleDetail({{ $order->id }})">
                                                    Detail
                                                </button>
                                                @if($item->status == 'menunggu_pembayaran')
                                                    <form action="{{ route('order.cancel', $order->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100" onclick="return confirm('Yakin ingin membatalkan pesanan?')">
                                                            Batalkan
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Detail Produk -->
                    <div class="table-responsive detail-table" id="detail{{ $order->id }}" style="display: none;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
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
                                    <td>Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
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
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total Sebelum Diskon:</strong></td>
                                    <td><strong>Rp. {{ number_format($totalAmount, 0, ',', '.') }}</strong></td>
                                </tr>
                                @if(Auth::user()->utype != 'customer_b' && $totalDiscount > 0)
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total Diskon:</strong></td>
                                    <td><strong>Rp. {{ number_format($totalDiscount, 0, ',', '.') }}</strong></td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total Akhir:</strong></td>
                                    <td>
                                        <strong>
                                            @if(Auth::user()->utype == 'customer_b')
                                                Rp. {{ number_format($totalAmount, 0, ',', '.') }}
                                            @else
                                                Rp. {{ number_format($totalAmount - $totalDiscount, 0, ',', '.') }}
                                            @endif
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end">
                                        <a href="{{ route('customer.invoice', ['id' => $order->id]) }}" 
                                        class="btn btn-pink" 
                                        style="min-width: 150px;">
                                            <i class="fas fa-download me-2"></i>
                                            Download Invoice
                                        </a>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Modal Upload Bukti -->
                    @if($order->items->first()->status == 'menunggu_pembayaran' && !$order->items->first()->bukti_pembayaran)
                    <div class="modal fade" id="uploadBuktiModal{{ $order->id }}" tabindex="-1" aria-labelledby="uploadBuktiLabel{{ $order->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-pink text-white">
                                    <h5 class="modal-title" id="uploadBuktiLabel{{ $order->id }}">Upload Bukti Pembayaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('order.upload-bukti', $order->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Pilih File Bukti Pembayaran</label>
                                            <input type="file" 
                                                   name="bukti_pembayaran" 
                                                   class="form-control" 
                                                   accept="image/*" 
                                                   required>
                                            <small class="text-muted">Format: JPG, PNG, JPEG. Maksimal: 5MB</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-pink">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleDetail(orderId) {
        const detailElement = document.getElementById('detail' + orderId);
        detailElement.style.display = detailElement.style.display === 'none' ? 'block' : 'none';
    }
    // Add this to your scripts section
document.querySelector('input[name="bukti_pembayaran"]').addEventListener('change', function() {
    if (this.files[0].size > 5 * 1024 * 1024) {
        alert('File terlalu besar! Maksimal ukuran file adalah 5MB.');
        this.value = '';
    }
});

    // Initialize Bootstrap modals
    document.addEventListener('DOMContentLoaded', function() {
        var modals = document.querySelectorAll('.modal');
        modals.forEach(function(modal) {
            new bootstrap.Modal(modal);
        });
    });
</script>
@endpush
@endsection