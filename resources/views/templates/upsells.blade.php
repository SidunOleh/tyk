<div class="upsells">
    @if ($upsells->count())
    <section class="additions">
        <div class="container">
            <h2 class="section_title">Не забудьте додати до корзини ці товари</h2>
            <div class="additions-list">
                @foreach ($upsells as $i => $product)
                <div  class="additions-item" data-id="{{ $product->id }}">
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
                            {{ format_price($product->price) }}
                        </p>
                        <button class="add">+</button>
                    </div>
                </div>
                @endforeach
            </div>

            @if ($upsells->count() > 4)
            <a class="btn clear show-more">
                Показати більше
            </a>
            <a class="btn clear hide-more">
                Приховати
            </a>
            @endif
        </div>
    </section>
    @endif
</div>