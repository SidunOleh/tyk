@include('templates.header', ['title' => 'Корзина'])

@include('templates.cart', ['cart' => $cart])

<div class="upsells-wrapper">
@include('templates.upsells', ['upsells' => $upsells])
</div>

@include('templates.subtotal', ['cart' => $cart])

@include('templates.footer')