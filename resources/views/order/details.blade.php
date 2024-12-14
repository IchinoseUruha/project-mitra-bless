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
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    {{ $item->order_number }}<br>
                                    <span class="text-muted small">
                                        {{ $item->produk->name }} ({{ $item->quantity }})
                                    </span>
                                </td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->status == 'menunggu_pembayaran' ? 'warning' : 
                                        ($item->status == 'sedang_diproses' ? 'info' : 'secondary') }}">
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
                                                data-bs-target="#uploadBukti{{ $item->id }}">
                                            Upload Bukti
                                        </button>
                                        @else
                                        <span class="badge bg-secondary">Tidak ada bukti</span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-pink mb-1" onclick="toggleDetail({{ $order->id }})">Detail</button>
                                    @if($item->status == 'menunggu_pembayaran')
                                        <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin membatalkan pesanan?')">
                                                Batalkan
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>

                            
            <!-- Modal Upload Bukti -->
            <div class="modal fade" id="uploadBukti{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-pink text-white">
                            <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('order.upload-bukti', $item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Pilih File Bukti Pembayaran</label>
                                    <input type="file" name="bukti_pembayaran" class="form-control" accept="image/*" required>
                                    <small class="text-muted">Format: JPG, PNG, JPEG. Max: 2MB</small>
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
            @endforeach
        </tbody>
    </table>
</div>


                    <!-- Modal Upload Bukti -->
                    <div class="modal fade" id="uploadBukti{{ $order->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-pink text-white">
                                    <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('order.upload-bukti', $order->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Pilih File Bukti Pembayaran</label>
                                            <input type="file" name="bukti_pembayaran" class="form-control" accept="image/*" required>
                                            <small class="text-muted">Format: JPG, PNG, JPEG. Max: 2MB</small>
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

                <!-- Detail Produk -->
                <div class="table-responsive detail-table" id="detail{{ $order->id }}" style="display: none;">
                    <table class="table">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->produk->name }}</td>
                                <td>Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Diskon:</strong></td>
                                <td>
                                    <strong>
                                        @if(Auth::user()->utype == 'customer_b')
                                            0%
                                        @else
                                            @if($item->quantity >= 36)
                                                10%
                                            @elseif($item->quantity >= 12)
                                                5%
                                            @else
                                                0%
                                            @endif
                                        @endif
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td>
                                    <strong>
                                            @if(Auth::user()->utype == 'customer_b')
                                                Rp {{ number_format($item->total, 2) }}
                                            @else
                                                Rp {{ number_format($item->harga_diskon, 2) }}
                                            @endif
                                    </strong>
                                
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    function toggleDetail(orderId) {
        const detailElement = document.getElementById('detail' + orderId);
        detailElement.style.display = detailElement.style.display === 'none' ? 'block' : 'none';
    }
</script>
@endsection
