@include('templates.header', [
    'title' => get_content_value('zaklady_meta_title', 'Заклади'),
    'description' => get_content_value('zaklady_meta_description'),
])

<section class="page-hero" style="background-image: url({{ asset('/assets/img/pizza-img.jpg') }})">
    <div class="wrapper">
        <div class="container">
            <h1 class="page-hero_title">
                Заклади
            </h1>
            <p class="subtitle">
                Доставка їжі з ваших улюблених ресторанів
            </p>
        </div>
    </div>
</section>

<div class="container">
    <section class="catalog">
        <div class="categories">
            <p class="title">
                Категорії
            </p>
            <div class="eaterie-filters">
                <div class="filter-item active" data-filter="all">
                    <div class="icon">
                        <img src="{{ asset('/assets/img/all.svg') }}" alt="" />
                    </div>
                    Все
                </div>

                @foreach ($tags as $tag)
                <div class="filter-item" data-filter="{{ $tag->id }}">
                    <div class="icon">
                        <img src="{{ $tag->image }}" alt="" />
                    </div>
                    {{ $tag->name }}
                </div>
                @endforeach
            </div>
        </div>

        <div class="main-catalog">
            <div class="head">
                Кількість закладів: <span class="eaterieNum">{{ $zaklady->count() }}</span>
            </div>
            <div class="container">
                <div class="eaterie-list">
                    @foreach ($zaklady as $zaklad)
                        @include('templates.esteblishment', ['zaklad' => $zaklad])
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>

@include('templates.footer')