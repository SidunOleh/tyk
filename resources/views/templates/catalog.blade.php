<div class="dishes__catalog">
    <div class="catalog__item">
        <div class="title">
            {{ $category->name }}
        </div>
        <div class="catalog__list">
            @foreach ($products as $product)
            <div class="dish__item" data-id="{{ $product->id }}">
                <!-- <div class="label new">🔥 Новинка</div> -->
                <div class="imgCard">
                    <img 
                        src="{{ asset('assets/img/placeholder.png') }}" 
                        data-src="{{ $product->imageUrl() }}" 
                        class="lazyload"
                        alt=""/>
                </div>
                <div class="infoCard">
                    <div class="head">
                        <p class="name">
                            {{ $product->name }}
                        </p>
                        <div class="weight">
                            {{ $product->weight }}
                        </div>
                    </div>
                    <div class="components">
                        {{ $product->ingredients }}
                    </div>
                    <div class="bottom">
                        <p class="price">
                            {{ $product->formattedPrice() }}
                        </p>
                        <div class="quantity-counter">
                            <button class="quantity-btn--minus">-</button>
                            <input type="text" class="quantity-input" value="{{ $cart->quantity($product->id) }}" readonly />
                            <button class="quantity-btn--plus">+</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            @if (! $products->count())
            <div class="empty">
                Немає товарів
            </div>
            @endif
        </div>
    </div>
</div>