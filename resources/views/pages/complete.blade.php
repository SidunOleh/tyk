@include('templates.header', ['title' => 'Успішно створено'])

<section class="orderReceived">
    <div class="container">
        <h2 class="hero__title">
            Замовлення отримано
        </h2>
        <p class="received title_20">
            <img src="{{ asset('/assets/img/checkbox.svg') }}" alt="" />
            Дякуємо. Ваше замовлення отримано.
        </p>
        <div class="wrapper">
            <div class="card">
                <img src="{{ asset('/assets/img/redBack.svg') }}" alt="" class="back" />

                <div class="info">
                    <p class="title_20">
                        Ваш запит обробляється
                    </p>
                    <p class="text_18">
                        Детальну інформацію щодо свого замовлення ви можете побачити в особистому кабінеті
                    </p>
                    <img src="{{ asset('/assets/img/delMan.svg') }}" alt="" class="man" />
                </div>
            </div>
            <div class="cartSubtotal">
                <div class="subtotal-list">
                    <div class="subtotal-item">
                        <p class="position">
                            Проміжний підсумок
                        </p>
                        <p class="sum">
                            {{ $order->totalFormatted() }}
                        </p>
                    </div>
                    <div class="subtotal-item">
                        <p class="position">
                            Доставка
                        </p>
                        <p class="sum deliver">
                            Єдиний тариф. Варіанти доставки будуть оновлені під час оформлення замовлення.
                        </p>
                    </div>
                    <div class="subtotal-item">
                        <p class="position">
                            Загалом
                        </p>
                        <p class="sum">
                            {{ $order->totalFormatted() }}
                        </p>
                    </div>
                    <p class="remark">
                        *Ціна вказана без урахування пакування і вартості послуги доставки
                    </p>
                </div>
            </div>
        </div>
        <a href="{{ route('pages.home') }}" class="btn">
            Повернутися на головну
        </a>
    </div>
</section>

@include('templates.footer')