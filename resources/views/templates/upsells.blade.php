<div class="upsells">
    @if (($upsells = $cart->upsells())->count())
    <section class="additions">
        <div class="container">
            <h2 class="section_title">Не забудьте додати до корзини ці товари</h2>
            <div class="additions-list">
                @foreach ($upsells as $i => $product)
                <div 
                    @class(['additions-item', 'hide' => $i > 3,]) 
                    data-id="{{ $product->id }}">
                    <div class="top">
                        <div class="icon">
                            <img src="{{ $product->imageUrl() }}" alt="" />
                        </div>
                        <div class="info">
                            <p class="name">
                                {{ $product->name }}
                            </p>
                            <div class="var">
                                {{ $product->weight }}
                            </div>
                        </div>
                    </div>
                    <div class="bottom">
                        <p class="price">
                            {{ $product->formattedPrice() }}₴
                        </p>
                        <button class="add">+</button>
                    </div>
                </div>
                @endforeach
            </div>

            @if ($upsells->count() > 4)
            <a class="btn clear">
                Показати більше
            </a>
            <a class="btn clear hide">
                Приховати
            </a>
            @endif
        </div>
    </section>
    @endif
</div>