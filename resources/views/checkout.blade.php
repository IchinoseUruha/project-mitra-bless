@extends('layouts.app')

@section('content')
<!-- Styling CSS tetap sama seperti sebelumnya -->
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
        color: #F062A8;
    }
    
    .cart-details table {
        width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
    }
    
    .cart-details table th {
        background-color: #F062A8 !important;
        color: white !important;
        font-size: 1rem;
        padding: 12px;
        text-align: center;
    }
    
    /* Tabel Data */
    .cart-details table td {
        text-align: center;
        padding: 12px;
        font-size: 1rem;
        color: #333;
    }

    .cart-details, .checkout-form {
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
    transition: box-shadow 0.3s ease;
    }

    .cart-details:hover, .checkout-form:hover {
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
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
        color: #F062A8;
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
        background-color: #F062A8;
        color: white;
        font-size: 1.1rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    
    .checkout-form button:hover {
        background-color: #F062A8;
    }
    
    /* CSS untuk memastikan form pengiriman di bawah judul secara vertikal */
    .checkout-form .form-group {
        margin-bottom: 20px;
    }
    
    /* Menata bagian payment secara vertikal */
    .payment-options {
        display: flex;
        flex-direction: column;
    }
    
    /* Menata radio button dan label agar sejajar */
    .payment-options input[type="radio"] {
        display: inline-block;
        margin-right: 10px;
    }
    
    .payment-options label {
        display: inline-block;
        font-size: 1.1rem;
        vertical-align: middle;
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

    table {
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 12px;
    overflow: hidden;
}
th:first-child, td:first-child {
    border-top-left-radius: 12px;
    border-bottom-left-radius: 12px;
}
th:last-child, td:last-child {
    border-top-right-radius: 12px;
    border-bottom-right-radius: 12px;
}
</style>

<div class="container mt-5">
    <div class="row">
        <!-- Detail Barang yang Dipesan -->
        <div class="col-md-12">
            <div class="cart-details">
                <h3>Detail Barang yang Dipesan</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Harga Satuan</th>
                            <th>Kuantitas</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                            <tr>
                                <td>{{ $item->produk->name }}</td>
                                <td>Rp {{ number_format($item->produk->price, 0, ',', '.') }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp {{ number_format($item->quantity * $item->produk->price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- <!-- Total Harga -->
                <div class="total-price text-end">
                    <h5><strong>Total: Rp {{ number_format($total, 0, ',', '.') }}</strong></h5>
                </div> --}}
            </div>
        </div>

        <!-- Form Checkout -->
        <div class="col-md-12 mt-4">
            <div class="checkout-form">
                <h3>Formulir Checkout</h3>
                
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf

                    <!-- Metode Pengiriman -->
                    <div class="form-group">
                        <label for="delivery_method">Pilih Metode Pengiriman</label>
                        <select name="delivery_method" id="delivery_method" class="form-control" required onchange="toggleAddressInput()">
                            <option value="diantar">Diantar ke rumah</option>
                            <option value="diambil">Ambil di toko</option>
                        </select>
                    </div>

                    <!-- Alamat Pengiriman -->
                    <div class="form-group" id="address-container">
                        <label for="address">Alamat Pengiriman</label>
                        <input type="text" name="address" id="address" class="form-control">
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="form-group">
                        <label>Metode Pembayaran</label>
                        <div class="payment-options">
                            <div>
                                <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer" onclick="togglePaymentFields()">
                                <label for="bank_transfer">Transfer Bank</label>
                                <select name="bank_account" id="bank_account" class="form-control" style="display:none;">
                                    <option value="BNI 081972861">Bank BNI</option>
                                    <option value="BCA">Bank BCA</option>
                                </select>
                            </div>
                            <div>
                                <input type="radio" id="e_wallet" name="payment_method" value="e-wallet" onclick="togglePaymentFields()">
                                <label for="e_wallet">E-wallet</label>
                                <select name="wallet_account" id="wallet_account" class="form-control" style="display:none;">
                                    <option value="GoPay">GoPay</option>
                                    <option value="DANA">DANA</option>
                                </select>
                            </div>
                            <div>
                                <input type="radio" id="cash_on_delivery" name="payment_method" value="bayar_ditempat" onclick="togglePaymentFields()">
                                <label for="cash_on_delivery">Bayar di Tempat</label>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="btn btn-primary">Konfirmasi Pemesanan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
function togglePaymentFields() {
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    
    document.getElementById('bank_account').style.display = 'none';
    document.getElementById('wallet_account').style.display = 'none';
    
    if (paymentMethod === 'bank_transfer') {
        document.getElementById('bank_account').style.display = 'block';
        document.getElementById('bank_account').required = true;
        document.getElementById('wallet_account').required = false;
    } else if (paymentMethod === 'e-wallet') {
        document.getElementById('wallet_account').style.display = 'block';
        document.getElementById('wallet_account').required = true;
        document.getElementById('bank_account').required = false;
    }
}

function toggleAddressInput() {
    const deliveryMethod = document.getElementById('delivery_method').value;
    const addressContainer = document.getElementById('address-container');
    const addressInput = document.getElementById('address');
    
    if (deliveryMethod === 'diantar') {
        addressContainer.style.display = 'block';
        addressInput.required = true;
    } else {
        addressContainer.style.display = 'none';
        addressInput.required = false;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    toggleAddressInput();
    const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
    if (selectedPayment) {
        togglePaymentFields();
    }
});
</script>
@endsection