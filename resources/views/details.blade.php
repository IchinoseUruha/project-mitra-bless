@extends('layouts.app')

@push('styles')
    <link href="https://example.com/custom-page-style.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://example.com/custom-page-script.js"></script>
@endpush

@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
      <div class="col-lg-10">
          <div class="row">
              <!-- Gambar Produk -->
              <div class="col-lg-5 text-center">
                  <img src="{{ asset('uploads/products/' . $product->image) }}" class="img-fluid rounded" style="max-height: 400px; object-fit: contain;" alt="{{ $product->name }}">
              </div>

              <!-- Informasi Produk -->
              <div class="col-lg-7">
                  <div class="ps-lg-4">
                      <!-- Nama Produk -->
                      <h1 class="h4 text-pink mb-2">{{ $product->name }}</h1>

                      <!-- Harga -->
                      <h2 class="text-pink mb-4">
                          Rp{{ number_format($product->price, 0, ',', '.') }}
                      </h2>

                      <!-- Tab Navigation -->
                      <ul class="nav nav-tabs border-0 mb-3">
                          <li class="nav-item">
                              <a class="nav-link active text-pink ps-0" data-bs-toggle="tab" href="#detail">Detail</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link text-pink" data-bs-toggle="tab" href="#info">Info Penting</a>
                          </li>
                      </ul>

                      <!-- Tab Content -->
                      <div class="tab-content mb-4">
                          <div class="tab-pane fade show active" id="detail">
                              <div class="mb-2">
                                <span>Stok Barang: </span>
                                <span class="text-pink">Unknown</span>
                            </div>
                              <div class="mb-2">
                                  <span>Kategori: </span>
                                  <span class="text-pink">{{ $product->category->name }}</span>
                              </div>
                              <div class="mb-2">
                                <span>Brand: </span>
                                <span class="text-pink">{{ $product->brand->name }}</span>
                            </div>
                              <div class="product-description text-muted">
                                  {{ $product->description }}
                              </div>
                          </div>
                          {{-- Content untuk Info_penting --}}
                          <div class="tab-pane fade" id="info">
                            <div class="mb-2">
                              <span>Kondisi: </span>
                              <span class="text-pink">Baru</span>
                          </div>
                          </div>
                      </div>

                     <!-- Purchase Box -->
                          <div class="card border-pink mt-4">
                            <div class="card-body">
                                <h5 class="text-pink mb-3">Detail Pemesanan</h5>
                                
                                <!-- PERBAIKAN: Pisahkan form keranjang dengan form quantity -->
                                
                                <!-- Quantity Control -->
                                <div class="d-flex align-items-center mb-3">
                                    <form action="{{ route('product.decrease', $product->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="quantity" value="{{ session('quantity', 1) }}">
                                        <button type="submit" class="btn btn-outline-pink px-3">-</button>
                                    </form>

                                    <span class="mx-3" style="min-width: 30px; text-align: center;">{{ session('quantity', 1) }}</span>

                                    <form action="{{ route('product.increase', $product->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="quantity" value="{{ session('quantity', 1) }}">
                                        <button type="submit" class="btn btn-outline-pink px-3">+</button>
                                    </form>
                                </div>

                                <!-- Subtotal -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Subtotal</span>
                                    <span class="text-pink">
                                        Rp{{ number_format(session('subtotal', $product->price), 0, ',', '.') }}
                                    </span>
                                </div>

                                <!-- Form Add to Cart (terpisah) -->
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-2">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <input type="hidden" name="name" value="{{ $product->name }}">
                                    <input type="hidden" name="price" value="{{ $product->price }}">
                                    <input type="hidden" name="quantity" value="{{ session('quantity', 1) }}">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-pink">+ Keranjang</button>
                                    </div>
                                </form>

                                <!-- Form Beli Langsung -->
                                <form action="{{ route('checkout.direct') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <input type="hidden" name="name" value="{{ $product->name }}">
                                    <input type="hidden" name="price" value="{{ $product->price }}">
                                    <input type="hidden" name="quantity" value="{{ session('quantity', 1) }}">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-outline-pink">Beli Langsung</button>
                                    </div>
                                </form>

                                <!-- Toast Notification -->
                                @if (session('success'))
                                <div aria-live="polite" aria-atomic="true" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                                    <div class="toast align-items-center text-bg-success border-0 show" role="alert">
                                        <div class="d-flex">
                                            <div class="toast-body">
                                                {{ session('success') }}
                                            </div>
                                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Custom Pop-Up -->
                                <div id="successPopup" class="custom-popup" style="display: none;">
                                    <p>{{ session('success') }}</p>
                                </div>

                                @if(session('error'))
                                    <div class="alert alert-danger mt-3">
                                        {{ session('error') }}
                                    </div>
                                @endif
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

<style><style>
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
    
    /* Gambar Produk */
    .img-fluid {
        max-height: 400px;
        object-fit: contain;
    }
    
    /* Produk Info */
    h1, h2 {
        font-weight: bold;
    }
    
    /* Nama Produk */
    h1.h4 {
        color: #F062A8;
        font-size: 1.8rem;
        margin-bottom: 10px;
    }
    
    /* Harga Produk */
    h2 {
        color: #F062A8;
        font-size: 2rem;
        margin-bottom: 20px;
    }
    
    /* Tab Navigation */
    .nav-tabs .nav-item {
        margin-right: 15px;
    }
    
    .nav-tabs .nav-link {
        color: #F062A8 !important;
        font-size: 1.1rem;
    }
    
    .nav-tabs .nav-link.active {
        color: white;
        background-color: #F062A8 !important;
        border-radius: 8px;
    }
    
    /* Tab Content */
    .tab-content {
        margin-top: 20px;
    }
    
    .text-pink {
        color: #F062A8;
    }
    
    /* Product Description */
    .product-description {
        font-size: 1rem;
        color: #333;
        margin-top: 15px;
    }
    
    /* Purchase Box */
    .card {
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-top: 30px;
    }
    
    .card-body {
        padding: 20px;
    }
    
    .card-header {
        background-color: #F062A8;
        color: white;
        font-size: 1.3rem;
        font-weight: bold;
        padding: 12px 15px;
        border-radius: 8px 8px 0 0;
    }
    
    .btn-pink {
        background-color: #F062A8;
        color: white;
        border: 1px solid #F062A8;
        padding: 12px 15px;
        font-size: 1.1rem;
        border-radius: 8px;
        width: 100%;
        transition: background-color 0.3s ease;
    }
    
    .btn-pink:hover {
        background-color: #F062A8;
        border-color: #F062A8;
    }
    
    .btn-outline-pink {
        color: #F062A8;
        border: 1px solid #F062A8;
        padding: 12px 15px;
        font-size: 1.1rem;
        border-radius: 8px;
        width: 100%;
        transition: background-color 0.3s ease;
    }
    
    .btn-outline-pink:hover {
        background-color: #F062A8;
        color: white;
    }
    
    /* Quantity Controls */
    .d-flex {
        display: flex;
        align-items: center;
    }
    
    .d-flex form {
        margin-right: 10px;
    }
    
    .d-flex span {
        font-size: 1.2rem;
        font-weight: bold;
        min-width: 30px;
        text-align: center;
    }
    
    /* Subtotal */
    .d-flex.justify-content-between {
        font-size: 1.1rem;
        font-weight: bold;
        margin-bottom: 15px;
    }
    
    .d-flex.justify-content-between span:last-child {
        color: #F062A8;
    }
    
    /* Toast Notification */
    .toast {
        position: absolute;
        top: 20px;
        right: 20px;
        min-width: 300px;
        background-color: #28a745;
        color: white;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    /* Custom Popup */
    .custom-popup {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #28a745;
        color: white;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        display: none;
    }
    
    .custom-popup p {
        margin: 0;
    }
    
    /* Input Focus */
    .form-control:focus {
        border-color: #F062A8;
        box-shadow: 0 0 0 0.2rem rgba(240, 98, 168, 0.25);
    }
    
    .nav-tabs .nav-link {
        color: #666;
    }
    
    /* Media Query for Mobile */
    @media screen and (max-width: 768px) {
        .container {
            width: 95%;
        }
    
        .col-lg-5, .col-lg-7 {
            width: 100%;
            text-align: center;
        }
    
        .card-body {
            padding: 15px;
        }
    
        .nav-tabs .nav-link {
            font-size: 1rem;
        }
    
        .btn-pink,
        .btn-outline-pink {
            padding: 12px;
        }
    
        .custom-popup {
            width: auto;
            left: 50%;
            transform: translateX(-50%);
        }
    }
    </style>
    
</style>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('success'))
            const popup = document.getElementById('successPopup');
            popup.style.display = 'block';
            setTimeout(() => popup.style.display = 'none', 3000); // Hide after 3 seconds
        @endif
    });
</script>