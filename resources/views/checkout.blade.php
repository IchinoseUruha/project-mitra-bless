@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Detail Barang yang Dipesan -->
        <div class="col-md-8">
            <div class="cart-details">
                <h3>Detail Barang yang Dipesan</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <!-- Judul tabel, bagian header tabel -->
                            <th>Nama Produk</th>
                            <th>Harga Satuan</th>
                            <th>Kuantitas</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                            <tr>
                                <td>{{ $item->produk->name }}</td>
                                <td>Rp {{ number_format($item->produk->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp {{ number_format($item->quantity * $item->produk->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Total Harga -->
                <div class="total-price">
                    <p class="text-gray-800">subtotal: Rp. {{ number_format($subtotal, 2) }}</p>
                    <p><strong>Pajak (10%): </strong>Rp {{ number_format($tax, 2) }}</p>
                    <p><strong>Total: </strong>Rp {{ number_format($total, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Form Checkout -->
        <div class="col-md-4">
            <div class="checkout-form">
               <h3>Formulir Checkout</h3>
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf

                    <!-- Alamat Pengiriman -->
                    <div class="form-group">
                        <label for="address">Alamat Pengiriman</label>
                        <input type="text" name="address" id="address" class="form-control" required>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="form-group">
                        <label for="payment_method">Metode Pembayaran</label>
                        <select name="payment_method" id="payment_method" class="form-control" required>
                            <option value="credit_card">Kartu Kredit</option>
                            <option value="bank_transfer">Transfer Bank</option>
                            <option value="cash_on_delivery">Bayar di Tempat</option>
                        </select>
                    </div>

                                        <!-- Metode Pengiriman -->
                                        <div class="form-group">
                                            <label for="payment_method">Silahkan pilih pengiriman</label>
                                            <select name="sending_method" id="sending_method" class="form-control" required>
                                                <option value="diantar">Diantar ke rumah</option>
                                                <option value="diambil">Ambil di toko</option>
                                            </select>
                                        </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="btn btn-primary">Lanjutkan ke Pembayaran</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Styling CSS -->
<style>
/* Reset beberapa default style */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f7f7f7;
    line-height: 1.6;
}

/* Container */
.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
}

/* Cart Details */
.cart-details {
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.cart-details h3 {
    font-size: 1.8rem;
    margin-bottom: 20px;
    color:  #F062A8; /* Ubah warna judul menjadi lebih gelap */
}

.cart-details table {
    width: 100%;
    margin-bottom: 20px;
}

.cart-details table th {

    background-color:  #F062A8 !important; /* Warna latar belakang header tabel menjadi pink */
    color: white !important; /* Warna teks menjadi putih agar kontras */
    font-size: 1rem;
    padding: 12px;
}


/* Tabel Data */
.cart-details table td {
    text-align: center;
    padding: 12px;
    font-size: 1rem;
    color: #333; /* Warna teks tetap hitam agar jelas */
}

/* Checkout Form */
.checkout-form {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.checkout-form h3 {
    font-size: 1.8rem;
    margin-bottom: 20px;
    color: #F062A8; /* Ubah warna judul form menjadi pink */
}

.checkout-form label {
    font-size: 1.1rem;
    margin-bottom: 8px;
    display: block;
}

.checkout-form input[type="text"],
.checkout-form select {
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    margin-bottom: 20px;
    border: 2px solid #ddd;
    border-radius: 8px;
    transition: border-color 0.3s ease;
}

.checkout-form input[type="text"]:focus,
.checkout-form select:focus {
    border-color: #d084a3;
    outline: none;
}

.checkout-form button {
    width: 100%;
    padding: 12px;
    background-color:  #F062A8; /* Sesuaikan tombol dengan warna pink */
    color: white;
    font-size: 1.1rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.checkout-form button:hover {
    background-color:  #F062A8;
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    .cart-details, .checkout-form {
        padding: 15px;
    }

    .checkout-form button {
        padding: 12px 0;
    }
}

</style>
@endsection
