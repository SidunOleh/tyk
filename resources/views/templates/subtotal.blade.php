<section class="cartSubtotal">
    <div class="container">
        <h2 class="title_32">Підсумки кошика</h2>
        <div class="subtotal-list">
            <div class="subtotal-item">
                <p class="position">Проміжний підсумок</p>
                <p class="sum">{{ $cart->formattedTotal() }}₴</p>
            </div>
            <div class="subtotal-item">
                <p class="position">Доставка</p>
                <p class="sum deliver">Єдиний тариф. Варіанти доставки будуть оновлені під час оформлення замовлення.</p>
            </div>
            <div class="subtotal-item">
                <p class="position">Загалом</p>
                <p class="sum">{{ $cart->formattedTotal() }}₴</p>
            </div>
        </div>
        @if ($cart->items)
        <a 
            href="{{ route('pages.checkout') }}" 
            class="btn">
            Перейти до оформлення
        </a>
        @endif
    </div>
</section>