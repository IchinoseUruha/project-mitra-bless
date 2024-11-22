@extends('layouts.app')

@section('content')
<main class="py-4">
    <div class="container">

        <div class="row">
            <!-- Left Column - Product Images -->
            <div class="col-lg-4">
                <div class="product-main-image mb-3">
                    <img src="{{ asset('uploads/products/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}" id="mainImage">
                </div>
                <div class="product-thumbnails d-flex gap-2">
                    @foreach(['image1', 'image2', 'image3', 'image4'] as $img)
                        @if($product->$img)
                            <div class="thumbnail-item border rounded p-1" style="width: 60px; height: 60px;">
                                <img src="{{ asset('uploads/products/' . $product->$img) }}" 
                                     class="img-fluid" 
                                     alt="Thumbnail"
                                     onclick="document.getElementById('mainImage').src = this.src">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Middle Column - Product Details -->
            <div class="col-lg-5">
                <h1 class="h4 mb-3">{{ $product->name }}</h1>
                
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="text-warning">Terjual {{ $product->sold_count ?? 0 }}</div>
                    <div class="vr"></div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-star-fill text-warning"></i>
                        <span class="ms-1">{{ number_format($product->rating ?? 0, 1) }}</span>
                        <span class="text-muted">({{ $product->review_count ?? 0 }} rating)</span>
                    </div>
                </div>

                <div class="product-price mb-4">
                    <h2 class="h3 mb-1">
                        @if ($product->sale_price)
                            Rp{{ number_format($product->sale_price, 0, ',', '.') }}
                        @else
                            Rp{{ number_format($product->regular_price, 0, ',', '.') }}
                        @endif
                    </h2>
                    @if ($product->sale_price)
                        <div>
                            <span class="text-decoration-line-through text-muted">Rp{{ number_format($product->regular_price, 0, ',', '.') }}</span>
                            <span class="badge bg-danger ms-2">{{ round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100) }}%</span>
                        </div>
                    @endif
                </div>

                <!-- Variant Selection -->
                @if($product->has_variants)
                <div class="mb-4">
                    <div class="text-muted mb-2">Pilih warna:</div>
                    <div class="d-flex gap-2">
                        @foreach(['Black', 'Blue'] as $color)
                            <div class="variant-option position-relative">
                                <input type="radio" name="color" id="color_{{ $color }}" class="d-none" value="{{ $color }}">
                                <label for="color_{{ $color }}" class="btn btn-outline-secondary {{ $loop->first ? 'active' : '' }}">
                                    {{ $color }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Product Info Tabs -->
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#detail">Detail</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#info">Info Penting</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="detail">
                        <div class="mb-3">
                            <small class="text-muted">Kondisi: </small>
                            <span>{{ $product->condition ?? 'Baru' }}</span>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Min. Pemesanan: </small>
                            <span>1 Buah</span>
                        </div>
                        <div class="mb-3">
                            <div class="product-description">
                                {!! $product->description !!}
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="info">
                        <!-- Info content here -->
                    </div>
                </div>
            </div>

            <!-- Right Column - Purchase Box -->
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Atur jumlah dan catatan</h5>
                        
                        <form method="post" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price" value="{{ $product->sale_price ?: $product->regular_price }}">

                            <div class="mb-3">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="input-group" style="width: 120px;">
                                        <button type="button" class="btn btn-outline-secondary" onclick="decrementQuantity()">-</button>
                                        <input type="number" name="quantity" class="form-control text-center" min="1" max="{{ $product->stock }}" value="1" id="quantity">
                                        <button type="button" class="btn btn-outline-secondary" onclick="incrementQuantity()">+</button>
                                    </div>
                                    <div class="text-muted">Stok: {{ $product->stock }}</div>
                                </div>
                                <small class="text-muted">Max. pembelian {{ $product->max_purchase ?? 1 }} pcs</small>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <span class="fw-bold" id="subtotal">Rp{{ number_format($product->sale_price ?: $product->regular_price, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">+ Keranjang</button>
                                <button type="button" class="btn btn-outline-success">Beli Langsung</button>
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <button type="button" class="btn btn-link text-dark p-0">
                                    <i class="bi bi-chat"></i> Chat
                                </button>
                                <button type="button" class="btn btn-link text-dark p-0">
                                    <i class="bi bi-heart"></i> Wishlist
                                </button>
                                <button type="button" class="btn btn-link text-dark p-0">
                                    <i class="bi bi-share"></i> Share
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    const price = {{ $product->sale_price ?: $product->regular_price }};
    
    function updateSubtotal(quantity) {
        const subtotal = price * quantity;
        document.getElementById('subtotal').innerText = 'Rp' + new Intl.NumberFormat('id-ID').format(subtotal);
    }

    function incrementQuantity() {
        let quantityInput = document.getElementById('quantity');
        let quantity = parseInt(quantityInput.value);
        let maxStock = {{ $product->stock }};
        if (quantity < maxStock) {
            quantity += 1;
            quantityInput.value = quantity;
            updateSubtotal(quantity);
        }
    }

    function decrementQuantity() {
        let quantityInput = document.getElementById('quantity');
        let quantity = parseInt(quantityInput.value);
        if (quantity > 1) {
            quantity -= 1;
            quantityInput.value = quantity;
            updateSubtotal(quantity);
        }
    }

    // Update subtotal when quantity is changed directly
    document.getElementById('quantity').addEventListener('change', function(e) {
        updateSubtotal(parseInt(e.target.value));
    });
</script>
@endsection