@include('templates.header', ['title' => 'Корзина'])

@include('templates.cart', ['cart' => $cart])

@include('templates.upsells', ['cart' => $cart])

@include('templates.subtotal', ['cart' => $cart])

@include('templates.footer')