@extends('layouts.app')

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
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <input type="hidden" name="name" value="{{ $product->name }}">
                                    <input type="hidden" name="price" value="{{ $product->price }}">
                                    <input type="hidden" name="quantity" value="{{ session('quantity', 1) }}">
                                    <div class="d-grid gap-2 mb-3">
                                        <button type="submit" class="btn btn-pink">+ Keranjang</button>
                                        <button type="button" class="btn btn-outline-pink">Beli Langsung</button>
                                    </div>
                                </form>

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

<style>
.text-pink {
    color: #FF1493 !important;
}

.border-pink {
    border-color: #FF1493 !important;
}

.btn-pink {
    background-color: #FF1493;
    color: white;
    border: 1px solid #FF1493;
}

.btn-pink:hover {
    background-color: #FF69B4;
    color: white;
    border: 1px solid #FF69B4;
}

.btn-outline-pink {
    color: #FF1493;
    border: 1px solid #FF1493;
    background-color: white;
}

.btn-outline-pink:hover {
    background-color: #FF1493;
    color: white;
}

.nav-tabs .nav-link.active {
    color: #FF1493 !important;
    border-bottom: 2px solid #FF1493;
    border-top: none;
    border-left: none;
    border-right: none;
    background: none;
}

.nav-tabs .nav-link {
    border: none;
    color: #666;
}

.nav-tabs {
    border-bottom: none;
}

.btn-link {
    text-decoration: none;
}

.btn-link:hover {
    color: #FF69B4;
}

input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type="number"] {
    -moz-appearance: textfield;
}

.form-control:focus {
    border-color: #FF1493;
    box-shadow: 0 0 0 0.2rem rgba(255, 20, 147, 0.25);
}
</style>
@endsection