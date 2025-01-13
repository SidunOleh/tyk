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
                        <div class="btn open-taxi">Замовити таксі</div>
                    </div>
                </div>
                <div class="hero__item">
                    <img src="{{ asset('/assets/img/waveGrey.svg') }}" alt="" class="back" />
                    <img src="{{ asset('/assets/img/Box.svg') }}" alt="" class="icon__1 icon" />
                    <img src="{{ asset('/assets/img/Box2.svg') }}" alt="" class="icon__2 icon" />
                    <div class="info">
                        <p class="title_32">Кур’єрські послуги</p>
                        <p class="text_18">Створюємо зручний та якісний сервіс для заощадження вашого часу</p>
                        <div class="btn open-delivery">Викликати кур’єра</div>
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
        <a class="btn clear">
            Більше закладів
        </a>
        <a class="btn clear hide">
            Приховати
        </a>
    </div>
</section>

<section class="discounts">
    <div class="container">
        <h2 class="section_title">Знижки, від яких <span>апетит</span> зростає ще більше</h2>
        <div class="slider-wrapper">
            <div class="discounts-slider">
                <div class="discounts-slide">
                    <div class="imgCard"><img src="./img/dis.svg" alt="Shop" /></div>
                    <div class="infoCard">
                        <p class="title_20">святкуєте день народження?</p>
                        <p class="text_16">Святкуйте свій День народження з “Тук-Тук” та отримуйте БЕЗКОШТОВНO Святкуйте свій День</p>
                        <a href="openDiscount.html" class="btn">Дізнатись більше</a>
                    </div>
                </div>
                <div class="discounts-slide">
                    <div class="imgCard"><img src="./img/dis.svg" alt="Shop" /></div>
                    <div class="infoCard">
                        <p class="title_20">святкуєте день народження?</p>
                        <p class="text_16">Святкуйте свій День народження з “Тук-Тук” та отримуйте БЕЗКОШТОВНO Святкуйте свій День</p>
                        <a href="openDiscount.html" class="btn">Дізнатись більше</a>
                    </div>
                </div>
                <div class="discounts-slide">
                    <div class="imgCard"><img src="./img/dis.svg" alt="Shop" /></div>
                    <div class="infoCard">
                        <p class="title_20">святкуєте день народження?</p>
                        <p class="text_16">Святкуйте свій День народження з “Тук-Тук” та отримуйте БЕЗКОШТОВНO Святкуйте свій День</p>
                        <a href="openDiscount.html" class="btn">Дізнатись більше</a>
                    </div>
                </div>
                <div class="discounts-slide">
                    <div class="imgCard"><img src="./img/dis.svg" alt="Shop" /></div>
                    <div class="infoCard">
                        <p class="title_20">святкуєте день народження?</p>
                        <p class="text_16">Святкуйте свій День народження з “Тук-Тук” та отримуйте БЕЗКОШТОВНO Святкуйте свій День</p>
                        <a href="openDiscount.html" class="btn">Дізнатись більше</a>
                    </div>
                </div>
            </div>
            <div class="slider-navigation">
                <div class="prev">
                    <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none">
            <path
                d="M12.0735 6.09162L4.219 13.9462C4.13785 14.0272 4.07348 14.1235 4.02956 14.2294C3.98564 14.3354 3.96304 14.4489 3.96304 14.5636C3.96304 14.6783 3.98564 14.7919 4.02956 14.8978C4.07348 15.0038 4.13785 15.1 4.219 15.1811L12.0735 23.0356C12.2373 23.1994 12.4594 23.2914 12.691 23.2914C12.9226 23.2914 13.1447 23.1994 13.3085 23.0356C13.4722 22.8719 13.5642 22.6498 13.5642 22.4182C13.5642 22.1866 13.4722 21.9645 13.3085 21.8007L6.943 15.4364L24.0365 15.4364C24.2679 15.4364 24.4899 15.3444 24.6536 15.1807C24.8172 15.0171 24.9092 14.7951 24.9092 14.5636C24.9092 14.3322 24.8172 14.1102 24.6536 13.9465C24.4899 13.7828 24.2679 13.6909 24.0365 13.6909L6.943 13.6909L13.3085 7.32653C13.4722 7.16278 13.5642 6.94067 13.5642 6.70908C13.5642 6.47749 13.4722 6.25538 13.3085 6.09162C13.1447 5.92786 12.9226 5.83587 12.691 5.83587C12.4594 5.83587 12.2373 5.92786 12.0735 6.09162Z"
                fill="#EC1220"
            />
            </svg>
                </div>
                <div class="next">
                    <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none">
            <path
                d="M16.9265 6.09162L24.781 13.9462C24.8621 14.0272 24.9265 14.1235 24.9704 14.2294C25.0144 14.3354 25.037 14.4489 25.037 14.5636C25.037 14.6783 25.0144 14.7919 24.9704 14.8978C24.9265 15.0038 24.8621 15.1 24.781 15.1811L16.9265 23.0356C16.7627 23.1994 16.5406 23.2914 16.309 23.2914C16.0774 23.2914 15.8553 23.1994 15.6915 23.0356C15.5278 22.8719 15.4358 22.6498 15.4358 22.4182C15.4358 22.1866 15.5278 21.9645 15.6915 21.8007L22.057 15.4364L4.96355 15.4364C4.73209 15.4364 4.5101 15.3444 4.34644 15.1807C4.18277 15.0171 4.09082 14.7951 4.09082 14.5636C4.09082 14.3322 4.18277 14.1102 4.34644 13.9465C4.5101 13.7828 4.73209 13.6909 4.96355 13.6909L22.057 13.6909L15.6915 7.32653C15.5278 7.16278 15.4358 6.94067 15.4358 6.70908C15.4358 6.47749 15.5278 6.25538 15.6915 6.09162C15.8553 5.92786 16.0774 5.83587 16.309 5.83587C16.5406 5.83587 16.7627 5.92786 16.9265 6.09162Z"
                fill="#EC1220"
            />
            </svg>
                </div>
            </div>
        </div>
    </div>
</section>

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