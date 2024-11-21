@extends('layouts.app')

@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <div class="flex items-center justify-center min-h-screen">
        <h2 class="page-title text-center">Keranjang Anda</h2>
    </div>
      <div class="shopping-cart">
        @if($items->count() > 0)
        <div class="cart-table__wrapper">
          <table class="cart-table">
            <thead>
              <tr>
                <th>Product</th>
                <th></th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $item)
              <tr>
                  <td>
                      <div class="shopping-cart__product-item">
                          <img loading="lazy" src="{{ asset('uploads/products/thumbnails') }}/{{ $item->produk->image }}" width="120" height="120" alt="{{ $item->produk->name }}" />
                      </div>
                  </td>
                  <td>
                      <div class="shopping-cart__product-item__detail">
                          <h4>{{ $item->produk->name }}</h4>
                      </div>
                  </td>
                  <td>
                    <span class="shopping-cart__product-price">${{ number_format($item->quantity * $item->produk->price, 1) }}</span>
                </td>
                  <td>{{ $item->quantity }}</td>
                  <td>
                      <div class="qty-control position-relative">
                          <form method="POST" action="{{ route('cart.quantity.decrease', $item->id) }}">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="qty-control__reduce">-</button>
                          </form>
                          <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="qty-control__number text-center">
                          <form method="POST" action="{{ route('cart.quantity.increase', $item->id) }}">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="qty-control__increase">+</button>
                          </form>
                      </div>
                  </td>
                  <td>
                      <span class="shopping-cart__subtotal">${{ number_format($item->quantity * $item->produk->price, 1) }}</span>
                  </td>
                  <td>
                      <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="remove-cart">Remove</button>
                      </form>
                  </td>
              </tr>
              @endforeach 
            </tbody>
          </table>
          <div class="cart-table-footer">
            <form action="#" class="position-relative bg-body">
              <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code">
              <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit"
                value="APPLY COUPON">
            </form>
            <form action="{{ route('cart.clear') }}" method="POST">
              @csrf
              @method('DELETE')
                <button class="btn btn-light" type="submit">CLEAR CART</button>
            </form>
          </div>
        </div>
        <div class="shopping-cart__totals-wrapper">
          <div class="sticky-content">
            <div class="shopping-cart__totals">
              <h3>Cart Totals</h3>
              <table class="cart-totals">
                <tbody>
                  <tr>
                    <th>Subtotal</th>
                    <td>${{ number_format($subtotal, 1)  }}</td>
                  </tr>
                  <tr>
                    <th>Shipping</th>
                    <td>Free</td>
                  </tr>
                  <tr>
                    <th>Tax</th>
                    <td>${{ number_format($tax, 1) }}</td>
                  </tr>
                  <tr>
                    <th>Total</th>
                    <td>${{ number_format($total, 1) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="mobile_fixed-btn_wrapper">
              <div class="button-wrapper container">
                <a href="checkout.html" class="btn btn-primary btn-checkout">PROCEED TO CHECKOUT</a>
              </div>
            </div>
          </div>
        </div>
        @else
            <div class="row">
                <div class="col-md-12 text-center pt-5 bp-5">
                    <p>No item found in your cart</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-info">Shop Now</a>
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