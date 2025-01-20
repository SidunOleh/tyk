<a href="{{ route('pages.cart') }}" class="cart_btn">
    <img src="{{ asset('/assets/img/cart.svg') }}" alt="" />
    <div class="price">
        {{ $cartTotal }}
    </div>
</a>