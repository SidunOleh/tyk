@include('templates.header', ['title' => 'Заклади'])

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
                    <a 
                        href="{{ route('pages.category', ['category' => $zaklad->slug,]) }}" 
                        class="eaterie-item"
                        data-tags="{{ json_encode($zaklad->tags->pluck('id')) }}">
                        <div class="img-card">
                            <img src="{{ $zaklad->imageUrl() }}" alt="" />
                        </div>
                        <div class="info-card">
                            <div class="title">
                                <!-- <div class="icon">
                                    <img src="./img/drink-img.jpg" alt="" />
                                </div> -->
                                {{ $zaklad->name }}
                            </div>
                            <div class="bottom">
                                <div class="work-time">
                                    <img src="{{ asset('/assets/img/clock.svg') }}" alt="" />
                                    {!! $zaklad->description !!}
                                </div>
                                <!-- <div class="label top">
                                    🔥 ТОП
                                </div> -->
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>

@include('templates.footer')