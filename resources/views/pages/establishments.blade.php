@include('templates.header')

<section class="page-hero" style="background-image: url('./img/pizza-img.jpg')">
    <div class="wrapper">
        <div class="container">
            <h1 class="page-hero_title">Заклади</h1>
            <p class="subtitle">Доставка їжі з ваших улюблених ресторанів</p>
        </div>
    </div>
</section>

<section class="catalog">
    <div class="categories">
        <p class="title">Категорії</p>
        <div class="eaterie-filters">
            <div class="filter-item" data-filter="all">
                <div class="icon"><img src="./img/all.svg" alt="Pizza" /></div>
                Все
            </div>
            <div class="filter-item" data-filter="pizza">
                <div class="icon"><img src="./img/pizza.svg" alt="Pizza" /></div>
                Піца
            </div>
            <div class="filter-item" data-filter="fastfood">
                <div class="icon"><img src="./img/burger.svg" alt="Fastfood" /></div>
                Фастфуд
            </div>
            <div class="filter-item" data-filter="shawarma">
                <div class="icon"><img src="./img/shau.svg" alt="Shawarma" /></div>
                Шаурма
            </div>
            <div class="filter-item" data-filter="sushi">
                <div class="icon"><img src="./img/sushi.svg" alt="Sushi" /></div>
                Суші
            </div>
            <div class="filter-item" data-filter="drinks">
                <div class="icon"><img src="./img/drinks.svg" alt="Drinks" /></div>
                Напої
            </div>
            <div class="filter-item" data-filter="sweets">
                <div class="icon"><img src="./img/sweets.svg" alt="Sweets" /></div>
                Солодощі
            </div>
            <div class="filter-item" data-filter="homefood">
                <div class="icon"><img src="./img/homeFood.svg" alt="Home food" /></div>
                Як вдома
            </div>
            <div class="filter-item" data-filter="flowers">
                <div class="icon"><img src="./img/flowers.svg" alt="Home food" /></div>
                Квіти
            </div>
        </div>
    </div>
    <div class="main-catalog">
        <div class="head">Кількість закладів: <span class="eaterieNum">28</span></div>
        <div class="container">
            <div class="eaterie-list">
                <a href="openProduct.html" class="eaterie-item" data-category="drinks">
                    <div class="img-card"><img src="./img/drink-img.jpg" alt="" /></div>
                    <div class="info-card">
                        <div class="title">
                            <div class="icon"><img src="./img/drink-img.jpg" alt="" /></div>
                            Drink-Market
                        </div>
                        <div class="bottom">
                            <div class="work-time"><img src="./img/clock.svg" alt="" />08:00 - 21:00</div>
                            <div class="label top">🔥 ТОП</div>
                        </div>
                    </div>
                </a>
                <a href="openProduct.html" class="eaterie-item" data-category="pizza">
                    <div class="img-card"><img src="./img/pizza-img.jpg" alt="" /></div>
                    <div class="info-card">
                        <div class="title">Drink-Market</div>
                        <div class="bottom">
                            <div class="work-time"><img src="./img/clock.svg" alt="" />08:00 - 21:00</div>
                            <div class="label sale">😱 Знижки до -15%</div>
                        </div>
                    </div>
                </a>
                <a href="openProduct.html" class="eaterie-item" data-category="homefood">
                    <div class="img-card"><img src="./img/terasa.jpg" alt="" /></div>
                    <div class="info-card">
                        <div class="title">Drink-Market</div>
                        <div class="bottom">
                            <div class="work-time"><img src="./img/clock.svg" alt="" />08:00 - 21:00</div>
                            <div class="label new">✨ Новинка</div>
                        </div>
                    </div>
                </a>
                <a href="openProduct.html" class="eaterie-item" data-category="fastfood">
                    <div class="img-card"><img src="./img/rolex.jpg" alt="" /></div>
                    <div class="info-card">
                        <div class="title">Drink-Market</div>
                        <div class="bottom">
                            <div class="work-time"><img src="./img/clock.svg" alt="" />08:00 - 21:00</div>
                            <div class="label top">🔥 ТОП</div>
                        </div>
                    </div>
                </a>
                <a href="openProduct.html" class="eaterie-item" data-category="shawarma">
                    <div class="img-card"><img src="./img/prima.jpg" alt="" /></div>
                    <div class="info-card">
                        <div class="title">
                            <div class="icon"><img src="./img/drink-img.jpg" alt="" /></div>
                            Drink-Market
                        </div>
                        <div class="bottom">
                            <div class="work-time"><img src="./img/clock.svg" alt="" />08:00 - 21:00</div>
                            <div class="label new">✨ Новинка</div>
                        </div>
                    </div>
                </a>
                <a href="openProduct.html" class="eaterie-item" data-category="sushi">
                    <div class="img-card"><img src="./img/ilove.jpg" alt="" /></div>
                    <div class="info-card">
                        <div class="title">
                            <div class="icon"><img src="./img/drink-img.jpg" alt="" /></div>
                            Drink-Market
                        </div>
                        <div class="bottom">
                            <div class="work-time"><img src="./img/clock.svg" alt="" />08:00 - 21:00</div>
                            <div class="label sale">😱 Знижки до -15%</div>
                        </div>
                    </div>
                </a>
                <a href="openProduct.html" class="eaterie-item" data-category="homefood">
                    <div class="img-card"><img src="./img/terasa.jpg" alt="" /></div>
                    <div class="info-card">
                        <div class="title">Drink-Market</div>
                        <div class="bottom">
                            <div class="work-time"><img src="./img/clock.svg" alt="" />08:00 - 21:00</div>
                            <div class="label new">✨ Новинка</div>
                        </div>
                    </div>
                </a>
                <a href="openProduct.html" class="eaterie-item" data-category="fastfood">
                    <div class="img-card"><img src="./img/rolex.jpg" alt="" /></div>
                    <div class="info-card">
                        <div class="title">Drink-Market</div>
                        <div class="bottom">
                            <div class="work-time"><img src="./img/clock.svg" alt="" />08:00 - 21:00</div>
                            <div class="label top">🔥 ТОП</div>
                        </div>
                    </div>
                </a>
                <a href="openProduct.html" class="eaterie-item" data-category="shawarma">
                    <div class="img-card"><img src="./img/prima.jpg" alt="" /></div>
                    <div class="info-card">
                        <div class="title">
                            <div class="icon"><img src="./img/drink-img.jpg" alt="" /></div>
                            Drink-Market
                        </div>
                        <div class="bottom">
                            <div class="work-time"><img src="./img/clock.svg" alt="" />08:00 - 21:00</div>
                            <div class="label new">✨ Новинка</div>
                        </div>
                    </div>
                </a>
                <a href="openProduct.html" class="eaterie-item" data-category="sushi">
                    <div class="img-card"><img src="./img/ilove.jpg" alt="" /></div>
                    <div class="info-card">
                        <div class="title">
                            <div class="icon"><img src="./img/drink-img.jpg" alt="" /></div>
                            Drink-Market
                        </div>
                        <div class="bottom">
                            <div class="work-time"><img src="./img/clock.svg" alt="" />08:00 - 21:00</div>
                            <div class="label sale">😱 Знижки до -15%</div>
                        </div>
                    </div>
                </a>
                <a href="openProduct.html" class="eaterie-item" data-category="homefood">
                    <div class="img-card"><img src="./img/terasa.jpg" alt="" /></div>
                    <div class="info-card">
                        <div class="title">Drink-Market</div>
                        <div class="bottom">
                            <div class="work-time"><img src="./img/clock.svg" alt="" />08:00 - 21:00</div>
                            <div class="label new">✨ Новинка</div>
                        </div>
                    </div>
                </a>
                <a href="openProduct.html" class="eaterie-item" data-category="fastfood">
                    <div class="img-card"><img src="./img/rolex.jpg" alt="" /></div>
                    <div class="info-card">
                        <div class="title">Drink-Market</div>
                        <div class="bottom">
                            <div class="work-time"><img src="./img/clock.svg" alt="" />08:00 - 21:00</div>
                            <div class="label top">🔥 ТОП</div>
                        </div>
                    </div>
                </a>
                <a href="openProduct.html" class="eaterie-item" data-category="shawarma">
                    <div class="img-card"><img src="./img/prima.jpg" alt="" /></div>
                    <div class="info-card">
                        <div class="title">
                            <div class="icon"><img src="./img/drink-img.jpg" alt="" /></div>
                            Drink-Market
                        </div>
                        <div class="bottom">
                            <div class="work-time"><img src="./img/clock.svg" alt="" />08:00 - 21:00</div>
                            <div class="label new">✨ Новинка</div>
                        </div>
                    </div>
                </a>
                <a href="openProduct.html" class="eaterie-item" data-category="sushi">
                    <div class="img-card"><img src="./img/ilove.jpg" alt="" /></div>
                    <div class="info-card">
                        <div class="title">
                            <div class="icon"><img src="./img/drink-img.jpg" alt="" /></div>
                            Drink-Market
                        </div>
                        <div class="bottom">
                            <div class="work-time"><img src="./img/clock.svg" alt="" />08:00 - 21:00</div>
                            <div class="label sale">😱 Знижки до -15%</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

@include('templates.footer')