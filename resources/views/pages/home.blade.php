@include('templates.header')

<section class="hero">
    <div class="container">
        <div class="hero__head">
            <h1 class="hero__title">
                {!! get_content_value('home_first_title') !!}
            </h1>
            <p class="hero__subtitle">
                {!! get_content_value('home_first_subtitle') !!}
            </p>
        </div>
        <div class="hero__services">
            <div class="left">
                <div class="hero__item">
                    <img src="{{ asset('/assets/img/waveRed.svg') }}" alt="" class="back" />
                    <img src="{{ asset('/assets/img/driver.svg') }}" alt="" class="icon" />
                    <div class="info">
                        <p class="title_32">
                            {!! get_content_value('home_food_title') !!}
                        </p>
                        <p class="text_18">
                            {!! get_content_value('home_food_subtitle') !!}
                        </p>
                        <a href="{{ route('pages.zaklady') }}" class="btn">
                            Замовити їжу
                        </a>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="hero__item">
                    <img src="{{ asset('/assets/img/waveGreen.svg') }}" alt="" class="back" />
                    <img src="{{ asset('/assets/img/heroTaxi.svg') }}" alt="" class="icon" />
                    <div class="info">
                        <p class="title_32">
                            {!! get_content_value('home_taxi_title') !!}
                        </p>
                        <p class="text_18">
                            {!! get_content_value('home_taxi_subtitle') !!}
                        </p>
                        <a 
                            href="{{ route('pages.order-car', ['service' => 'Таксі']) }}" 
                            class="btn taxi_btn">
                            Замовити таксі
                        </a>
                    </div>
                </div>
                <div class="hero__item">
                    <img src="{{ asset('/assets/img/waveGrey.svg') }}" alt="" class="back" />
                    <img src="{{ asset('/assets/img/Box.svg') }}" alt="" class="icon__1 icon" />
                    <img src="{{ asset('/assets/img/Box2.svg') }}" alt="" class="icon__2 icon" />
                    <div class="info">
                        <p class="title_32">
                            {!! get_content_value('home_courier_title') !!}
                        </p>
                        <p class="text_18">
                            {!! get_content_value('home_courier_subtitle') !!}
                        </p>
                        <a 
                            href="{{ route('pages.order-car', ['service' => 'Кур\'єр']) }}" 
                            class="btn delivery_btn">
                            Викликати кур’єра
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero__services-slider">
            <div class="hero__item">
                <img src="{{ asset('/assets/img/wave-red.svg') }}" alt="" class="back" />

                <div class="info">
                    <p class="title_32">
                        {!! get_content_value('home_food_title') !!}
                    </p>
                    <p class="text_18">
                        {!! get_content_value('home_food_subtitle') !!}
                    </p>
                    <a href="{{ route('pages.zaklady') }}" class="btn">
                        Замовити їжу
                    </a>
                </div>
            </div>
            <div class="hero__item">
                <img src="{{ asset('/assets/img/waveGreen.svg') }}" alt="" class="back" />

                <div class="info">
                    <p class="title_32">
                        {!! get_content_value('home_taxi_title') !!}
                    </p>
                    <p class="text_18">
                        {!! get_content_value('home_taxi_subtitle') !!}
                    </p>
                    <a 
                        href="{{ route('pages.order-car', ['service' => 'Таксі']) }}" 
                        class="btn taxi_btn">
                        Замовити таксі
                    </a>
                </div>
            </div>
            <div class="hero__item">
                <img src="{{ asset('/assets/img/waveGrey.svg') }}" alt="" class="back" />

                <div class="info">
                    <p class="title_32">
                        {!! get_content_value('home_courier_title') !!}
                    </p>
                    <p class="text_18">
                        {!! get_content_value('home_courier_subtitle') !!}
                    </p>
                    <a 
                        href="{{ route('pages.order-car', ['service' => 'Кур\'єр']) }}" 
                        class="btn delivery_btn">
                        Викликати кур’єра
                    </a>
                </div>
            </div>
        </div>
        <div class="heroMobile">
            <!-- <img src="/assets/img/map.png" alt="" class="heroMobile__img"> -->
            <div class="heroMobile__list">
                <a href="{{ route('pages.order-car', ['service' => 'Таксі']) }}" class="heroMobile__item">
                    <img src="/assets/img/hero-taxi.svg" alt="">
                    <span>Таксі</span>
                </a>
                <a href="{{ route('pages.zaklady') }}" class="heroMobile__item">
                    <img src="/assets/img/hero-food.png" alt="">
                    <span>Доставка їжі</span>
                </a>
                <a href="{{ route('pages.order-car', ['service' => 'Кур\'єр']) }}" class="heroMobile__item">
                    <img src="/assets/img/hero-shipping.svg" alt="">
                    <span>Кур’єрські послуги</span>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="home-eaterie">
    <div class="container">
        <h2 class="section_title">
            {!! get_content_value('home_zaklady_title') !!}
        </h2>
        <div class="eaterie-filters">
            <div class="filter-item active" data-filter="all">
                <div class="icon">
                    <img src="{{ asset('/assets/img/all.svg') }}" alt="" />
                </div>
                Все
            </div>
            @foreach ($tags as $tag)
            <div class="filter-item" data-filter="{{ $tag->id }}">
                <img src="{{ $tag->image }}" alt="Pizza" />
                {{ $tag->name }}
            </div>
            @endforeach
        </div>
        <div class="eaterie-list">
            @foreach ($zaklady as $i => $zaklad)
            <a 
                href="{{ route('pages.category', ['category' => $zaklad->slug,]) }}" 
                @class(['eaterie-item', 'hide' => $i > 5,])
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
        <a class="btn clear show-more">
            Більше закладів
        </a>
        <a class="btn clear hide-more">
            Приховати
        </a>
    </div>
</section>

@include('templates.promotions', ['promotions' => $promotions])

<section class="delivery-types">
    <div class="container">
        <h2 class="section_title">
            {!! get_content_value('home_courier_title') !!}
        </h2>
        <div class="wrapper">
            <div class="typeFilters">
                @foreach (get_content_value('home_courier_items', []) as $item)
                <div class="typeFilter-item">
                    <div class="filter-body" data-type="{{ $item['title'] }}">
                        <img src="{{ $item['icon'] }}" alt="" />
                        {!! $item['title'] !!}
                    </div>
                    <div class="typeContent-item" data-typeContent="{{ $item['title'] }}">
                        @if($item['img'])
                        <div class="img-card"><img src="{{ $item['img'] }}" alt="" /></div>
                        @endif
                        <div class="info-card">
                            <p class="title_20">
                                {!! $item['title'] !!}
                            </p>
                            <p class="text_16">
                                {!! $item['subtitle'] !!}
                            </p>
                            <a href="{{ route('pages.order-car', ['service' => 'Кур\'єр', 'courier_service' => $item['service'],]) }}" class="btn">
                                Замовити доставку
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@include('templates.app')

<section class="process">
    <div class="container">
        <h2 class="section_title">
            {!! get_content_value('home_steps_title') !!}
        </h2>
        <div class="process-list">
            @foreach (get_content_value('home_step_items', []) as $item)
            <div class="process-item">
                <div class="icon">
                    <img src="{{ $item['img'] }}" alt="" />
                </div>
                <p class="title_20">
                    {!! $item['title'] !!}
                </p>
                <p class="text_16">
                    {!! $item['subtitle'] !!}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>


@include('templates.reviews')

@include('templates.footer')