@extends('layouts.app')

@section('content')
<div class="shopping-cart__totals-wrapper" style="background-color: #fff5f7; padding: 1.5rem;">
    <div class="cart-table__wrapper" style="background-color: #ffffff; border-radius: 1rem; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); padding: 1.5rem;">
        <!-- Header Produk -->
        <h3 style="background: linear-gradient(to right, #ff69b4, #ff85c8); color: #ffffff; padding: 1rem 1.5rem; border-radius: 1rem 1rem 0 0; font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">
            Produk di Keranjang Anda
        </h3>

        <!-- Tabel Produk -->
        <div class="cart-table" style="width: 100%;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #ffc2d6; padding: 1rem 0;">
                <p style="font-size: 1.125rem; font-weight: 600; color: #d63384; width: 25%;">Produk</p>
                <p style="font-size: 1.125rem; font-weight: 600; color: #d63384; width: 25%;">Detail</p>
                <p style="font-size: 1.125rem; font-weight: 600; color: #d63384; text-align: center; width: 16.66%;">Harga</p>
                <p style="font-size: 1.125rem; font-weight: 600; color: #d63384; text-align: center; width: 16.66%;">Jumlah</p>
                <p style="font-weight: bold; font-size: 1.25rem; color: #d63384; text-align: center; width: 16.66%;">Subtotal</p>
            </div>

            @foreach($items as $item)
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 0; border-bottom: 1px solid #ffd7e4; transition: all 0.3s ease; border-radius: 0.5rem;"
                 onmouseover="this.style.backgroundColor='#ffe3ee'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.1)';" 
                 onmouseout="this.style.backgroundColor='transparent'; this.style.boxShadow='none';">
                <div style="width: 25%; display: flex; justify-content: flex-start;">
                    <img 
                        src="{{ asset('uploads/products/thumbnails') }}/{{ $item->produk->image }}" 
                        alt="{{ $item->produk->name }}" 
                        style="border-radius: 0.75rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); width: 80px; height: 80px; object-fit: cover;"
                    />
                </div>
                <div style="width: 25%;">
                    <p style="font-weight: bold; font-size: 1.125rem; color: #d63384;">{{ $item->produk->name }}</p>
                </div>
                <div style="text-align: center; width: 16.66%; font-size: 1rem;">
                    <p style="font-weight: 600; color: #d63384;">Rp. {{ number_format($item->produk->price, 2) }}</p>
                </div>
                <div style="display: flex; align-items: center; justify-content: center; width: 16.66%; gap: 0.5rem;">
                    <form method="POST" action="{{ route('cart.quantity.decrease', $item->id) }}">
                        @csrf
                        @method('PUT')
                        <button 
                            type="submit" 
                            style="background-color: #ff69b4; color: #ffffff; border-radius: 50%; width: 24px; height: 24px; transition: transform 0.3s ease;"
                            onmouseover="this.style.transform='scale(1.1)';" 
                            onmouseout="this.style.transform='scale(1)';">
                            - 
                        </button>
                    </form>
                    <p style="background-color: #f8f8f8; border: 1px solid #ffc2d6; border-radius: 0.5rem; padding: 0.5rem 1rem; color: #d63384; font-weight: 600; text-align: center;">
                        {{ $item->quantity }}
                    </p>
                    <form method="POST" action="{{ route('cart.quantity.increase', $item->id) }}">
                        @csrf
                        @method('PUT')
                        <button 
                            type="submit" 
                            style="background-color: #ff69b4; color: #ffffff; border-radius: 50%; width: 24px; height: 24px; transition: transform 0.3s ease;"
                            onmouseover="this.style.transform='scale(1.1)';" 
                            onmouseout="this.style.transform='scale(1)';">
                            + 
                        </button>
                    </form>
                </div>
                <div style="text-align: center; width: 16.66%; font-size: 1.125rem;">
                    <p style="font-weight: bold; color: #d63384;">Rp. {{ number_format($item->quantity * $item->produk->price, 2) }}</p>
                </div>
            </div>
            @endforeach
        </div>       

        <!-- Tombol Kosongkan Keranjang -->
        <form action="{{ route('cart.clear') }}" method="POST" style="margin-top: 1rem; text-align: center;">
            @csrf
            @method('DELETE')
            <button type="submit"
                style="background: linear-gradient(to right, #ff69b4, #ff85c8); color: #ffffff; padding: 0.75rem 1.5rem; border-radius: 999px; font-weight: bold; transition: all 0.3s ease;"
                onmouseover="this.style.transform='scale(1.05)';" 
                onmouseout="this.style.transform='scale(1)';">
                Kosongkan Keranjang
            </button>
        </form>

        <!-- Ringkasan Keranjang -->
        <div style="margin-top: 1.5rem; padding: 1.5rem; background-color: #f8f8f8; border-radius: 1rem; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
            <h3 style="font-size: 1.25rem; font-weight: bold; color: #d63384; margin-bottom: 1rem;">Ringkasan Keranjang</h3>
            <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                <span style="font-weight: 600;">Subtotal</span>
                <span>Rp. {{ number_format($subtotal, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                <span style="font-weight: 600;">Pajak (10%)</span>
                <span>Rp. {{ number_format($tax, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span style="font-weight: 600;">Total</span>
                <span style="font-weight: bold; color: #d63384;">Rp. {{ number_format($total, 2) }}</span>
            </div>
            <div style="text-align: center; margin-top: 1rem;">
                <a href="{{ route('checkout.index') }}" 
                   style="background: linear-gradient(to right, #ff69b4, #ff85c8); color: #ffffff; padding: 0.75rem 1.5rem; border-radius: 999px; font-weight: bold; transition: transform 0.3s ease;"
                   onmouseover="this.style.transform='scale(1.05)';" 
                   onmouseout="this.style.transform='scale(1)';">
                    Lanjutkan Checkout
                </a>
            </div>
        </div>
    </div>
</div>
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
