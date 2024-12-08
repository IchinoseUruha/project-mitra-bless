@extends('layouts.app')

@push('styles')
    <link href="https://example.com/custom-page-style.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://example.com/custom-page-script.js"></script>
@endpush


@section('content')
<style>
  .brand-list li, .category-list li {
    line-height: 40px;
  }

  .brand-list li .chk-brand, .category-list li .chk-category {
    width: 1rem;
    height: 1rem;
    color: #e4e4e4;
    border: 0.125rem solid currentColor;
    border-radius: 0;
    margin-right: 0.75rem;
  }

  .swatch-category.active, .swatch-size.active {
    background-color: #000;
    color: #fff;
  }

  .product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    grid-gap: 2rem;
  }

  .product-card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
  }

  .product-image {
    height: 200px; /* Menetapkan tinggi tetap untuk gambar */
    background-color: #f0f0f0;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden; /* Menyembunyikan bagian gambar yang keluar */
  }

  .product-image img {
    width: 100%; /* Membuat gambar memenuhi lebar kontainer */
    height: auto; /* Menjaga rasio aspek gambar */
    object-fit: cover; /* Mengatur agar gambar terpotong dengan proporsional dan mengisi kontainer */
  }

  .product-info {
    padding: 1.5rem;
  }

  .product-name {
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
  }

  .product-category {
    color: #666;
    margin-bottom: 1rem;
  }

  .product-price-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .product-price {
    font-size: 1.2rem;
    font-weight: bold;
    color: #7c3aed;
  }

  .btn {
    display: inline-block;
    background-color: #F062A8;
    color: #fff;
    padding: 0.75rem 1.5rem;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
  }

  .btn:hover {
    background-color: #b93175;
  }

  .btn-cart {
    background-color: #f0f0f0;
    color: #333;
  }

  .btn-cart:hover {
    background-color: #e0e0e0;
  }

  .toast {
        position: absolute;
        top: 20px;
        right: 20px;
        min-width: 300px;
    }

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
    }
</style>

<main class="pt-90">

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

    <section class="shop-main container d-flex pt-4 pt-xl-5">
        <!-- Sidebar -->
        <div class="shop-sidebar side-sticky bg-body w-25" id="shopFilter">
            <!-- Product Brands -->
            <div class="accordion" id="brands-list">
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="accordion-heading-brand">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                            data-bs-target="#accordion-filter-brand" aria-expanded="true" aria-controls="accordion-filter-brand">
                            Product Brands
                        </button>
                    </h5>
                    <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0"
                        aria-labelledby="accordion-heading-brand" data-bs-parent="#brands-list">
                        <div class="accordion-body px-0 pb-0 pt-3 brand-list">
                            <div class="d-flex flex-wrap">
                                <a href="#" class="swatch-size btn btn-sm btn-outline-purple mb-3 me-3 js-filter-size" data-size="XS">Pantene</a>
                                <a href="#" class="swatch-size btn btn-sm btn-outline-purple mb-3 me-3 js-filter-size" data-size="S">HotWheels</a>
                                <a href="#" class="swatch-size btn btn-sm btn-outline-purple mb-3 me-3 js-filter-size" data-size="M">Isi aja mereknya We</a>
                                <!-- Add more brands as needed -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Categories -->
            <div class="accordion" id="categories-list">
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="accordion-heading-1">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                            data-bs-target="#accordion-filter-1" aria-expanded="true" aria-controls="accordion-filter-1">
                            Product Categories
                        </button>
                    </h5>
                    <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
                        aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list">
                        <div class="accordion-body px-0 pb-0 pt-3 category-list">
                            @foreach ($categories as $kategori)
                                <a href="#" class="swatch-category btn btn-sm btn-outline-purple mb-3 me-3 js-filter-category" data-category-id="{{ $kategori->id }}">
                                    {{ $kategori->name }}
                                </a>
                            @endforeach
                            <div class="d-flex flex-wrap">
                                <a href="#" class="swatch-category btn btn-sm btn-outline-purple mb-3 me-3 js-filter-category" data-category-id="1">Shampoo</a>
                                <a href="#" class="swatch-category btn btn-sm btn-outline-purple mb-3 me-3 js-filter-category" data-category-id="2">Soap</a>
                                <a href="#" class="swatch-category btn btn-sm btn-outline-purple mb-3 me-3 js-filter-category" data-category-id="3">Lipstic</a>
                                <a href="#" class="swatch-category btn btn-sm btn-outline-purple mb-3 me-3 js-filter-category" data-category-id="4">Deodorant</a>
                                <a href="#" class="swatch-category btn btn-sm btn-outline-purple mb-3 me-3 js-filter-category" data-category-id="5">Face Makeup</a>
                                <a href="#" class="swatch-category btn btn-sm btn-outline-purple mb-3 me-3 js-filter-category" data-category-id="6">Perfume</a>
                                <a href="#" class="swatch-category btn btn-sm btn-outline-purple mb-3 me-3 js-filter-category" data-category-id="7">Cosmetic Tools</a>
                                <a href="#" class="swatch-category btn btn-sm btn-outline-purple mb-3 me-3 js-filter-category" data-category-id="8">Bathing Tools</a>
                                <a href="#" class="swatch-category btn btn-sm btn-outline-purple mb-3 me-3 js-filter-category" data-category-id="9">Tissue</a>
                                <!-- Add more categories as needed -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="d-flex flex-grow-1">
            <!-- Existing Product Grid -->

            <!-- Daftar product Kosmetik -->
            <div class="container mx-auto px-4 w-full">
                <h1 class="text-3xl font-bold mb-8">Produk Kosmetik</h1>
        <!-- Produk Grid -->
        <div class="product-grid">
            @foreach ($products as $product)
            <div class="product-card">
                <div class="product-image">
                    <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                        <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}">
                    </a>
                </div>
                <div class="product-info">
                    <h3 class="product-name">
                        <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}" class="text-lg font-bold text-gray-800 hover:text-purple-600 transition-colors">
                            {{ $product->name }}
                        </a>
                    </h3>
                    <p class="product-category text-sm text-gray-500">{{ $product->kategori->name ?? 'No Category' }}</p>
                    <div class="product-price-actions">
                        <p class="product-price">Rp. {{ number_format($product->price) }}</p>
                        <div class="product-actions">
                            <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}" class="btn btn-detail">Detail</a>
                            <form action="{{ route('cart.add') }}" method="POST"style="display:inline;">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="name" value="{{ $product->name }}">
                                <input type="hidden" name="price" value="{{ $product->price }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-cart">+ Keranjang</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
            </div>
        </div>
    </section>
</main>


<!-- Hapus atau modifikasi form filter -->
<form id="frmfilter" method="GET" action="{{ route('shop.index') }}">
    <input type="hidden" name="order" id="order" value={{ $order }} />
    <input type="hidden" name="brands" id="hdnBrands" value="{{ $filter_brands }}" />
    <input type="hidden" name="categories" id="hdnCategories" value="{{ $filter_categories }}" />
    <input type="hidden" name="min" id="hdnMinPrice" value="{{ $min_price }}" />
    <input type="hidden" name="max" id="hdnMaxPrice" value="{{ $max_price }}" />
    <input type="hidden" name="sizes" id="hdnSizes" />
</form>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        // Handle brand selection
        $(".chk-brand").on("change", function () {
            let brands = [];
            $(".chk-brand:checked").each(function () {
                brands.push($(this).val());
            });

            $("#hdnBrands").val(brands.join(","));
            $("#frmfilter").submit();
        });

        // Handle category selection
        $(".js-filter-category").on("click", function (e) {
            e.preventDefault();
            $(this).toggleClass("active");

            let categories = [];
            $(".js-filter-category.active").each(function () {
                categories.push($(this).data("category-id"));
            });

            $("#hdnCategories").val(categories.join(","));
            $("#frmfilter").submit();
        });

        // Handle size selection
        $(".js-filter-size").on("click", function (e) {
            e.preventDefault();
            $(this).toggleClass("active");

            let sizes = [];
            $(".js-filter-size.active").each(function () {
                sizes.push($(this).data("size"));
            });

            $("#hdnSizes").val(sizes.join(","));
            $("#frmfilter").submit();
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        @if (session('success'))
            const popup = document.getElementById('successPopup');
            popup.style.display = 'block';
            setTimeout(() => popup.style.display = 'none', 3000); // Hide after 3 seconds
        @endif
    });
</script>
@endpush