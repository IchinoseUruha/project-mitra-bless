@extends('layouts.app')

@section('content')
<main class="pt-90 bg-gradient-to-br from-pink-50 to-pink-100 min-h-screen">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container mx-auto px-4">

        <div style="display: flex; justify-content: center; align-items: center; min-height: 5vh;">
            <h2 class="page-title text-center text-3xl sm:text-2xl md:text-xl font-bold text-pink-700 tracking-wide bg-white px-4 py-2 rounded-full shadow-[0_4px_6px_rgba(255,105,180,0.3)]">
                Keranjang Anda
            </h2>
        </div>

        <div class="shopping-cart bg-white rounded-3xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:scale-[1.01]">
            @if($items->count() > 0)
            <div class="cart-table__wrapper p-4">
                <table class="cart-table w-full">
                    <thead class="bg-gradient-to-r from-pink-500 to-pink-600 text-white">
                        <tr>
                            <th class="p-2 text-left">Produk</th>
                            <th class="p-2 text-left">Detail</th>
                            <th class="p-2 text-center">Harga</th>
                            <th class="p-2 text-center">Jumlah</th>
                            <th class="p-2 text-center">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($items as $item)
                        <tr class="border-b border-pink-100 hover:bg-pink-50 transition-colors duration-300">
                            <td class="p-2 w-1/6">
                                <div class="shopping-cart__product-item flex justify-center">
                                    <img 
                                        loading="lazy" 
                                        src="{{ asset('uploads/products/thumbnails') }}/{{ $item->produk->image }}" 
                                        width="100" 
                                        height="100" 
                                        alt="{{ $item->produk->name }}" 
                                        class="rounded-xl shadow-lg transform hover:scale-110 transition-transform"
                                    />
                                </div>
                            </td>
                            <td class="p-2 w-1/4">
                                <div class="shopping-cart__product-item__detail">
                                    <h4 class="font-bold text-pink-800 text-base">{{ $item->produk->name }}</h4>
                                </div>
                            </td>
                            <td class="p-2 w-1/6 text-center">
                                <span class="shopping-cart__product-price text-pink-600 font-semibold block">
                                    Rp. {{ number_format($item->produk->price, 2) }}
                                </span>
                            </td>

                            <td class="p-2 text-center">
                                <div class="qty-control flex items-center justify-center space-x-2">
                                    <form method="POST" action="{{ route('cart.quantity.decrease', $item->id) }}" class="m-0">
                                        @csrf
                                        @method('PUT')
                                        <button 
                                            type="submit" 
                                            class="qty-control__reduce bg-pink-500 text-white w-6 h-6 rounded-full hover:bg-pink-600 transition-all flex items-center justify-center"
                                        >
                                            -
                                        </button>
                                    </form>
                                    
                                    <span 
                                        class="qty-control__number text-center bg-gray-100 border border-pink-300 rounded py-2 px-4 text-pink-800 font-semibold shadow-inner"
                                    >
                                        {{ $item->quantity }}
                                    </span>
                                    
                                    <form method="POST" action="{{ route('cart.quantity.increase', $item->id) }}" class="m-0">
                                        @csrf
                                        @method('PUT')
                                        <button 
                                            type="submit" 
                                            class="qty-control__increase bg-pink-500 text-white w-6 h-6 rounded-full hover:bg-pink-600 transition-all flex items-center justify-center"
                                        >
                                            +
                                        </button>
                                    </form>
                                </div>
                            </td>

                            <td class="p-2 w-1/6 text-center">
                                <span class="shopping-cart__subtotal text-pink-700 font-bold block">
                                    Rp. {{ number_format($item->quantity * $item->produk->price, 2) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="cart-table-footer mt-4 flex justify-end">
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button 
                            class="btn btn-primary btn-checkout bg-gradient-to-r from-pink-500 to-pink-600 text-white px-6 py-3 rounded-full text-lg font-bold hover:from-pink-600 hover:to-pink-700 transition-all shadow-lg" 
                            type="submit"
                        >
                            KOSONGKAN KERANJANG
                        </button>
                    </form>
                </div>          
            </div>

            <div class="shopping-cart__totals-wrapper bg-pink-50 p-6">
                <div class="sticky-content">
                    <div class="shopping-cart__totals bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-2xl font-bold text-white bg-gradient-to-r from-pink-500 to-pink-600 p-4 -mx-6 -mt-6 mb-4 rounded-t-xl">
                            Ringkasan Keranjang
                        </h3>
                        <div class="flex justify-between items-start">
                            <!-- Kolom Kiri -->
                            <div class="text-left">
                                <p class="text-pink-700 font-semibold">Subtotal</p>
                                <p class="text-pink-700 font-semibold">Pengiriman</p>
                                <p class="text-pink-700 font-semibold">Pajak</p>
                                <p class="text-pink-800 font-bold text-lg mt-2">Total</p>
                            </div>
                            <!-- Kolom Kanan -->
                            <div class="text-right">
                                <p class="text-gray-800">Rp. {{ number_format($subtotal, 2) }}</p>
                                <p class="text-gray-800">Gratis</p>
                                <p class="text-gray-800">Rp. {{ number_format($tax, 2) }}</p>
                                <p class="text-pink-800 font-bold text-lg mt-2">
                                    Rp. {{ number_format($total, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mobile_fixed-btn_wrapper mt-6 text-center">
                        <div class="button-wrapper container">
                            <a 
                                href="{{ route('checkout.index') }}" 
                                class="btn btn-primary btn-checkout bg-gradient-to-r from-pink-500 to-pink-600 text-white px-6 py-3 rounded-full text-lg font-bold hover:from-pink-600 hover:to-pink-700 transition-all shadow-lg"
                            >
                                LANJUTKAN KE CHECKOUT
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="row p-12 text-center bg-pink-50">
                <div class="col-md-12">
                    <div class="bg-white p-8 rounded-3xl shadow-xl">
                        <p class="text-3xl text-pink-600 mb-4">Tidak ada item di keranjang Anda</p>
                        <a 
                            href="{{ route('shop.index') }}" 
                            class="btn btn-info bg-pink-600 text-white px-6 py-3 rounded-full hover:bg-pink-700 transition-colors"
                        >
                            Belanja Sekarang
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
</main>

@endsection

@push('scripts')
<script>
    $(function(){
        $(".qty-control__increase").on("click", function(){
          $(this).closest('form').submit();
        });

        $(".qty-control__reduce").on("click", function(){
          $(this).closest('form').submit();
        });        

        $(".remove-cart").on("click", function(){
          $(this).closest('form').submit();
        });
    });
</script>
@endpush
