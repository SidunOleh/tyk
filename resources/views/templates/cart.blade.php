<section class="cart-section">
    <div class="container">
        <p class="hero__title">Корзина</p>
        @if ($cart->items)
        <div class="cart-body">
            <table class="cart-table">
                <thead>
                    <tr class="cart-head">
                        <th class="col">Товар</th>
                        <th class="col">Ціна</th>
                        <th class="col">Кількість</th>
                        <th class="col">Проміжний підсумок</th>
                        <th class="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart->items as $item)
                    <tr 
                        class="cart-item" 
                        data-id="{{ $item->id }}">
                        <td class="product" data-id="{{ $item->product->id }}">
                            <div class="icon">
                                <img src="{{ $item->product->imageUrl() }}" alt="" />
                            </div>
                            <div class="info">
                                <p class="name">
                                    {{ $item->product->name }}
                                </p>
                                <p class="weight">
                                    {{ $item->product->weight }}
                                </p>
                                <div class="components">
                                    {!! $item->product->ingredients !!}
                                </div>
                            </div>
                        </td>
                        <td class="price">
                            {{ $item->product->formattedPrice() }} грн
                        </td>
                        <td class="quantity">
                            <div class="counter">
                                <button class="counter__button counter__button--decrease">-</button>
                                <input type="text" class="counter__input" value="{{ $item->quantity }}" readonly />
                                <button class="counter__button counter__button--increase">+</button>
                            </div>
                        </td>
                        <td class="subtotal_table">
                            <span>{{ $item->formattedAmount() }} грн</span>
                            <div class="delete">
                                <img src="{{ asset('/assets/img/trash.svg') }}" alt="" />
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        Корзина порожня
        @endif
    </div>
</section>