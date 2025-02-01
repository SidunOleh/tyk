@include('templates.header')

<section class="hero">
    <div class="container">
        <div class="hero__head">
            <h1 class="hero__title"><span>Тук-тук</span> — сервіс вашого міста <span>*</span></h1>
            <p class="hero__subtitle">*Ми маємо на увазі найкраще місто — <span>Золочів</span></p>
        </div>
        <div class="hero__services">
            <div class="left">
                <div class="hero__item">
                    <img src="{{ asset('/assets/img/waveRed.svg') }}" alt="" class="back" />
                    <img src="{{ asset('/assets/img/driver.svg') }}" alt="" class="icon" />
                    <div class="info">
                        <p class="title_32">Доставка їжі вашого міста</p>
                        <p class="text_18">Створюємо зручний та якісний сервіс для заощадження вашого часу</p>
                        <a href="{{ route('pages.zaklady') }}" class="btn">Замовити їжу</a>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="hero__item">
                    <img src="{{ asset('/assets/img/waveGreen.svg') }}" alt="" class="back" />
                    <img src="{{ asset('/assets/img/heroTaxi.svg') }}" alt="" class="icon" />
                    <div class="info">
                        <p class="title_32">Таксі</p>
                        <p class="text_18">Створюємо зручний та якісний сервіс для заощадження вашого часу</p>
                        @auth('web')
                        <a 
                            href="{{ route('pages.order-car', ['service' => 'Таксі']) }}" 
                            class="btn taxi_btn">
                            Замовити таксі
                        </a>
                        @endauth

                        @guest('web')
                        <div class="btn taxi_btn unlogged">
                            Замовити таксі
                        </div>
                        @endguest
                    </div>
                </div>
                <div class="hero__item">
                    <img src="{{ asset('/assets/img/waveGrey.svg') }}" alt="" class="back" />
                    <img src="{{ asset('/assets/img/Box.svg') }}" alt="" class="icon__1 icon" />
                    <img src="{{ asset('/assets/img/Box2.svg') }}" alt="" class="icon__2 icon" />
                    <div class="info">
                        <p class="title_32">Кур’єрські послуги</p>
                        <p class="text_18">Створюємо зручний та якісний сервіс для заощадження вашого часу</p>
                        @auth('web')
                        <a 
                            href="{{ route('pages.order-car', ['service' => 'Кур\'єр']) }}" 
                            class="btn delivery_btn">
                            Викликати кур’єра
                        </a>
                        @endauth

                        @guest('web')
                        <div class="btn delivery_btn unlogged">
                            Викликати кур’єра
                        </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
        <div class="hero__services-slider">
            <div class="hero__item">
                <img src="{{ asset('/assets/img/wave-red.svg') }}" alt="" class="back" />

                <div class="info">
                    <p class="title_32">Доставка їжі вашого міста</p>
                    <p class="text_18">Створюємо зручний та якісний сервіс для заощадження вашого часу</p>
                    <a href="{{ route('pages.zaklady') }}" class="btn">Замовити їжу</a>
                </div>
            </div>
            <div class="hero__item">
                <img src="{{ asset('/assets/img/waveGreen.svg') }}" alt="" class="back" />

                <div class="info">
                    <p class="title_32">Таксі</p>
                    <p class="text_18">Створюємо зручний та якісний сервіс для заощадження вашого часу</p>
                    <div class="btn open-taxi">Замовити таксі</div>
                </div>
            </div>
            <div class="hero__item">
                <img src="{{ asset('/assets/img/waveGrey.svg') }}" alt="" class="back" />

                <div class="info">
                    <p class="title_32">Кур’єрські послуги</p>
                    <p class="text_18">Створюємо зручний та якісний сервіс для заощадження вашого часу</p>
                    <div class="btn open-delivery">Викликати кур’єра</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="home-eaterie">
    <div class="container">
        <h2 class="section_title">
            Доставка їжі <br /> з ваших <span>улюблених</span> ресторанів
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
        <h2 class="section_title">Різні потреби – одна <span>доставка.</span> Ми впораємось!</h2>
        <div class="wrapper">
            <div class="typeFilters">
                <div class="typeFilter-item">
                    <div class="filter-body" data-type="flowers"><img src="./img/flowers.svg" alt="" />Квіти та подарунки</div>
                    <div class="typeContent-item" data-typeContent="flowers">
                        <div class="img-card"><img src="./img/flowersImg.svg" alt="" /></div>
                        <div class="info-card">
                            <p class="title_20">Квіти та подарунки</p>
                            <p class="text_16">
                                Не маєте можливості особисто привітати близьких зі святом чи плануєте сюрприз? Звертайтесь, наша команда завжди готова робити свято:)
                            </p>
                            <a href="#" class="btn">Замовити доставку</a>
                        </div>
                    </div>
                </div>
                <div class="typeFilter-item">
                    <div class="filter-body" data-type="post"><img src="./img/post.svg" alt="" />Доставка пошти</div>
                    <div class="typeContent-item" data-typeContent="post">
                        <div class="img-card"><img src="./img/flowersImg.svg" alt="" /></div>
                        <div class="info-card">
                            <p class="title_20">Доставка пошти</p>
                            <p class="text_16">
                                Не маєте можливості особисто привітати близьких зі святом чи плануєте сюрприз? Звертайтесь, наша команда завжди готова робити свято:)
                            </p>
                            <a href="#" class="btn">Замовити доставку</a>
                        </div>
                    </div>
                </div>
                <div class="typeFilter-item">
                    <div class="filter-body" data-type="pills"><img src="./img/pills.svg" alt="" />Медикаменти</div>
                    <div class="typeContent-item" data-typeContent="pills">
                        <div class="img-card"><img src="./img/flowersImg.svg" alt="" /></div>
                        <div class="info-card">
                            <p class="title_20">Медикаменти</p>
                            <p class="text_16">
                                Не маєте можливості особисто привітати близьких зі святом чи плануєте сюрприз? Звертайтесь, наша команда завжди готова робити свято:)
                            </p>
                            <a href="#" class="btn">Замовити доставку</a>
                        </div>
                    </div>
                </div>
                <div class="typeFilter-item">
                    <div class="filter-body" data-type="taxi"><img src="./img/taxi.svg" alt="" />Таксі</div>
                    <div class="typeContent-item" data-typeContent="taxi">
                        <div class="img-card"><img src="./img/flowersImg.svg" alt="" /></div>
                        <div class="info-card">
                            <p class="title_20">Таксі</p>
                            <p class="text_16">
                                Не маєте можливості особисто привітати близьких зі святом чи плануєте сюрприз? Звертайтесь, наша команда завжди готова робити свято:)
                            </p>
                            <a href="#" class="btn">Замовити доставку</a>
                        </div>
                    </div>
                </div>
                <div class="typeFilter-item">
                    <div class="filter-body" data-type="todo"><img src="./img/todolist.svg" alt="" />Виконання доручень</div>
                    <div class="typeContent-item" data-typeContent="todo">
                        <div class="img-card"><img src="./img/flowersImg.svg" alt="" /></div>
                        <div class="info-card">
                            <p class="title_20">Виконання доручень</p>
                            <p class="text_16">
                                Не маєте можливості особисто привітати близьких зі святом чи плануєте сюрприз? Звертайтесь, наша команда завжди готова робити свято:)
                            </p>
                            <a href="#" class="btn">Замовити доставку</a>
                        </div>
                    </div>
                </div>
                <div class="typeFilter-item">
                    <div class="filter-body" data-type="meetTr"><img src="./img/meetTr.svg" alt="" />зустріч транспорту</div>
                    <div class="typeContent-item" data-typeContent="meetTr">
                        <div class="img-card"><img src="./img/flowersImg.svg" alt="" /></div>
                        <div class="info-card">
                            <p class="title_20">зустріч транспорту</p>
                            <p class="text_16">
                                Не маєте можливості особисто привітати близьких зі святом чи плануєте сюрприз? Звертайтесь, наша команда завжди готова робити свято:)
                            </p>
                            <a href="#" class="btn">Замовити доставку</a>
                        </div>
                    </div>
                </div>
                <div class="typeFilter-item">
                    <div class="filter-body" data-type="docs"><img src="./img/doc.svg" alt="" />документи</div>
                    <div class="typeContent-item" data-typeContent="docs">
                        <div class="img-card"><img src="./img/flowersImg.svg" alt="" /></div>
                        <div class="info-card">
                            <p class="title_20">документи</p>
                            <p class="text_16">
                                Не маєте можливості особисто привітати близьких зі святом чи плануєте сюрприз? Звертайтесь, наша команда завжди готова робити свято:)
                            </p>
                            <a href="#" class="btn">Замовити доставку</a>
                        </div>
                    </div>
                </div>
                <div class="typeFilter-item">
                    <div class="filter-body" data-type="cargo"><img src="./img/cargoTrans.svg" alt="" />вантажні перевезення</div>
                    <div class="typeContent-item" data-typeContent="cargo">
                        <div class="img-card"><img src="./img/flowersImg.svg" alt="" /></div>
                        <div class="info-card">
                            <p class="title_20">вантажні перевезення</p>
                            <p class="text_16">
                                Не маєте можливості особисто привітати близьких зі святом чи плануєте сюрприз? Звертайтесь, наша команда завжди готова робити свято:)
                            </p>
                            <a href="#" class="btn">Замовити доставку</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="callToAction">
    <img src="./img/ctaR.webp" alt="" class="back left" />
    <img src="./img/ctaR.webp" alt="" class="back right" />
    <div class="container">
        <img src="./img/ctaPhones.svg" alt="" class="phones" />
        <div class="card">
            <h2 class="section_title">
                Замовляйте їжу <span>швидше</span> <br /> та <span>зручніше</span> з нашим додатком!
            </h2>
            <p class="text_18">Лише кілька кліків – і ваше замовлення вже в дорозі. Забудьте про складнощі, просто вибирайте і насолоджуйтесь.</p>
            <div class="downloadBtns">
                <a href="#"><img src="./img/AppStoreBL.svg" alt="" /></a>
                <a href="#"><img src="./img/googlePlayBl.svg" alt="" /></a>
            </div>
        </div>
    </div>
</section>

<section class="process">
    <div class="container">
        <h2 class="section_title">
            Наш процес, як швейцарський годинник, <br /> тільки <span>смачнішe</span>
        </h2>
        <div class="process-list">
            <div class="process-item">
                <div class="icon">
                    <img src="./img/process1.svg" alt="" />
                </div>
                <p class="title_20">Обери їжу</p>
                <p class="text_16">Наші гарантії включають швидку доставку, повну конфідеційність та відповідальність за якість доставки продуктів, а також своєчасне</p>
            </div>
            <div class="process-item">
                <div class="icon">
                    <img src="./img/process2.svg" alt="" />
                </div>
                <p class="title_20">Зроби замовлення</p>
                <p class="text_16">Наші гарантії включають швидку доставку, повну конфідеційність та відповідальність за якість доставки продуктів, а також своєчасне</p>
            </div>
            <div class="process-item">
                <div class="icon">
                    <img src="./img/process3.svg" alt="" />
                </div>
                <p class="title_20">Насолоджуйся</p>
                <p class="text_16">Наші гарантії включають швидку доставку, повну конфідеційність та відповідальність за якість доставки продуктів, а також своєчасне</p>
            </div>
        </div>
    </div>
</section>

<section class="reviews">
    <div class="container">
        <h2 class="section_title">
            Відгуки, які <span>зігрівають</span> душу <br /> (як гарячий суп)
        </h2>
    </div>
</section>

@include('templates.footer')