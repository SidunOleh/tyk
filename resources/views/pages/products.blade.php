@include('templates.header')

<section class="page-hero" style="background-image: url('./img/pizza-img.jpg')">
    <div class="wrapper">
        <div class="container">
            <h1 class="page-hero_title">ROLEX+</h1>
            <p class="subtitle workTime">11:00 - 21:30</p>
        </div>
    </div>
</section>

<section class="dishes">
    <div class="dishes__category">
        <p class="title">КАТЕГОРІЇ</p>
        <div class="dishes__select">
            <div class="selected">
                <span>Все</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="12" viewBox="0 0 24 12" fill="none">
            <g clip-path="url(#clip0_182_4471)">
            <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M11.2884 1.84306L5.63137 7.50006L7.04537 8.91406L11.9954 3.96406L16.9454 8.91406L18.3594 7.50006L12.7024 1.84306C12.5148 1.65559 12.2605 1.55028 11.9954 1.55028C11.7302 1.55028 11.4759 1.65559 11.2884 1.84306Z"
                fill="white"
            />
            </g>
            <defs>
            <clipPath id="clip0_182_4471">
                <rect width="12" height="24" fill="white" transform="matrix(0 -1 -1 0 24 12)" />
            </clipPath>
            </defs>
        </svg>
            </div>
            <div class="dishes__menu">
                <div class="menu__item">
                    <div class="head" data-menu="1">
                        Суші та роли
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="12" viewBox="0 0 24 12" fill="none">
                <g clip-path="url(#clip0_182_4471)">
                <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M11.2884 1.84306L5.63137 7.50006L7.04537 8.91406L11.9954 3.96406L16.9454 8.91406L18.3594 7.50006L12.7024 1.84306C12.5148 1.65559 12.2605 1.55028 11.9954 1.55028C11.7302 1.55028 11.4759 1.65559 11.2884 1.84306Z"
                    fill="white"
                />
                </g>
                <defs>
                <clipPath id="clip0_182_4471">
                    <rect width="12" height="24" fill="white" transform="matrix(0 -1 -1 0 24 12)" />
                </clipPath>
                </defs>
            </svg>
                    </div>
                    <div class="sub__menu">
                        <div class="sub__item" data-submenu="1.1">Суші бургери</div>
                        <div class="sub__item" data-submenu="1.2">Роли новинки</div>
                        <div class="sub__item" data-submenu="1.3">Нігірі</div>
                        <div class="sub__item" data-submenu="1.4">Дитячі роли</div>
                        <div class="sub__item" data-submenu="1.5">Роли</div>
                        <div class="sub__item" data-submenu="1.6">Сети</div>
                    </div>
                </div>
                <div class="menu__item">
                    <div class="head" data-menu="2">Пасти</div>
                </div>
                <div class="menu__item">
                    <div class="head" data-menu="3">Піца</div>
                </div>
                <div class="menu__item">
                    <div class="head" data-menu="4">Бургери</div>
                </div>
                <div class="menu__item">
                    <div class="head" data-menu="5">Середземноморська кухня</div>
                </div>
                <div class="menu__item">
                    <div class="head" data-menu="6">Домашні страви</div>
                </div>
                <div class="menu__item">
                    <div class="head" data-menu="7">Перші страви</div>
                </div>
                <div class="menu__item">
                    <div class="head" data-menu="8">Другі страви</div>
                </div>
                <div class="menu__item">
                    <div class="head" data-menu="9">Гарніри</div>
                </div>
                <div class="menu__item">
                    <div class="head" data-menu="10">Салати</div>
                </div>
                <div class="menu__item">
                    <div class="head" data-menu="11">Холодні закуски</div>
                </div>
                <div class="menu__item">
                    <div class="head" data-menu="12">Соуси</div>
                </div>
                <div class="menu__item">
                    <div class="head" data-menu="13">Додатки</div>
                </div>
            </div>
        </div>
    </div>
    <div class="dishes__catalog">
        <div class="catalog__item" data-catalog="1">
            <div class="subCatalog__item" data-subCatalog="1.1">
                <div class="title">Суші Бургери</div>
                <div class="catalog__list">
                    <div class="dish__item">
                        <div class="label new">🔥 Новинка</div>
                        <div class="imgCard">
                            <img src="./img/sushiBurger.jpg" alt="" />
                        </div>
                        <div class="infoCard">
                            <div class="head">
                                <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                                <div class="weight">255 г</div>
                            </div>
                            <div class="components">мясна нарізка, сирна нарізка, мед, помідори,</div>
                            <div class="bottom">
                                <p class="price">999.99₴</p>
                                <div class="quantity-counter">
                                    <button class="quantity-btn--minus">-</button>
                                    <input type="text" class="quantity-input" value="0" readonly />
                                    <button class="quantity-btn--plus">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dish__item">
                        <div class="imgCard">
                            <img src="./img/sushiBurger.jpg" alt="" />
                        </div>
                        <div class="infoCard">
                            <div class="head">
                                <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                                <div class="weight">255 г</div>
                            </div>
                            <div class="components">мясна нарізка, сирна нарізка, мед, помідори,</div>
                            <div class="bottom">
                                <p class="price">999.99₴</p>
                                <div class="quantity-counter">
                                    <button class="quantity-btn--minus">-</button>
                                    <input type="text" class="quantity-input" value="0" readonly />
                                    <button class="quantity-btn--plus">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dish__item">
                        <div class="label new">🔥 Новинка</div>
                        <div class="imgCard">
                            <img src="./img/sushiBurger.jpg" alt="" />
                        </div>
                        <div class="infoCard">
                            <div class="head">
                                <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                                <div class="weight">255 г</div>
                            </div>
                            <div class="components">мясна нарізка, сирна нарізка, мед, помідори, болгарський перець, чілі, огірок квашенний, огірок свіжий, салата</div>
                            <div class="bottom">
                                <p class="price">999.99₴</p>
                                <div class="quantity-counter">
                                    <button class="quantity-btn--minus">-</button>
                                    <input type="text" class="quantity-input" value="0" readonly />
                                    <button class="quantity-btn--plus">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dish__item">
                        <div class="imgCard">
                            <img src="./img/sushiBurger.jpg" alt="" />
                        </div>
                        <div class="infoCard">
                            <div class="head">
                                <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                                <div class="weight">255 г</div>
                            </div>
                            <div class="components">помідори, болгарський перець, чілі, огірок квашенний, огірок свіжий, салата</div>
                            <div class="bottom">
                                <p class="price">999.99₴</p>
                                <div class="quantity-counter">
                                    <button class="quantity-btn--minus">-</button>
                                    <input type="text" class="quantity-input" value="0" readonly />
                                    <button class="quantity-btn--plus">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dish__item">
                        <div class="imgCard">
                            <img src="./img/sushiBurger.jpg" alt="" />
                        </div>
                        <div class="infoCard">
                            <div class="head">
                                <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                                <div class="weight">255 г</div>
                            </div>
                            <div class="components">огірок квашенний, огірок свіжий, салата</div>
                            <div class="bottom">
                                <p class="price">999.99₴</p>
                                <div class="quantity-counter">
                                    <button class="quantity-btn--minus">-</button>
                                    <input type="text" class="quantity-input" value="0" readonly />
                                    <button class="quantity-btn--plus">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dish__item">
                        <div class="imgCard">
                            <img src="./img/sushiBurger.jpg" alt="" />
                        </div>
                        <div class="infoCard">
                            <div class="head">
                                <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                                <div class="weight">255 г</div>
                            </div>
                            <div class="components">чілі, огірок квашенний, огірок свіжий, салата</div>
                            <div class="bottom">
                                <p class="price">999.99₴</p>
                                <div class="quantity-counter">
                                    <button class="quantity-btn--minus">-</button>
                                    <input type="text" class="quantity-input" value="0" readonly />
                                    <button class="quantity-btn--plus">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="subCatalog__item" data-subCatalog="1.2">
                <div class="title">Роли новинки</div>
                <div class="catalog__list">
                    <div class="dish__item">
                        <div class="label new">🔥 Новинка</div>
                        <div class="imgCard">
                            <img src="./img/sushiBurger.jpg" alt="" />
                        </div>
                        <div class="infoCard">
                            <div class="head">
                                <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                                <div class="weight">255 г</div>
                            </div>
                            <div class="components">мясна нарізка, сирна нарізка, мед, помідори,</div>
                            <div class="bottom">
                                <p class="price">999.99₴</p>
                                <div class="quantity-counter">
                                    <button class="quantity-btn--minus">-</button>
                                    <input type="text" class="quantity-input" value="0" readonly />
                                    <button class="quantity-btn--plus">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dish__item">
                        <div class="imgCard">
                            <img src="./img/sushiBurger.jpg" alt="" />
                        </div>
                        <div class="infoCard">
                            <div class="head">
                                <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                                <div class="weight">255 г</div>
                            </div>
                            <div class="components">мясна нарізка, сирна нарізка, мед, помідори,</div>
                            <div class="bottom">
                                <p class="price">999.99₴</p>
                                <div class="quantity-counter">
                                    <button class="quantity-btn--minus">-</button>
                                    <input type="text" class="quantity-input" value="0" readonly />
                                    <button class="quantity-btn--plus">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dish__item">
                        <div class="label new">🔥 Новинка</div>
                        <div class="imgCard">
                            <img src="./img/sushiBurger.jpg" alt="" />
                        </div>
                        <div class="infoCard">
                            <div class="head">
                                <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                                <div class="weight">255 г</div>
                            </div>
                            <div class="components">мясна нарізка, сирна нарізка, мед, помідори, болгарський перець, чілі, огірок квашенний, огірок свіжий, салата</div>
                            <div class="bottom">
                                <p class="price">999.99₴</p>
                                <div class="quantity-counter">
                                    <button class="quantity-btn--minus">-</button>
                                    <input type="text" class="quantity-input" value="0" readonly />
                                    <button class="quantity-btn--plus">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dish__item">
                        <div class="imgCard">
                            <img src="./img/sushiBurger.jpg" alt="" />
                        </div>
                        <div class="infoCard">
                            <div class="head">
                                <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                                <div class="weight">255 г</div>
                            </div>
                            <div class="components">помідори, болгарський перець, чілі, огірок квашенний, огірок свіжий, салата</div>
                            <div class="bottom">
                                <p class="price">999.99₴</p>
                                <div class="quantity-counter">
                                    <button class="quantity-btn--minus">-</button>
                                    <input type="text" class="quantity-input" value="0" readonly />
                                    <button class="quantity-btn--plus">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dish__item">
                        <div class="imgCard">
                            <img src="./img/sushiBurger.jpg" alt="" />
                        </div>
                        <div class="infoCard">
                            <div class="head">
                                <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                                <div class="weight">255 г</div>
                            </div>
                            <div class="components">огірок квашенний, огірок свіжий, салата</div>
                            <div class="bottom">
                                <p class="price">999.99₴</p>
                                <div class="quantity-counter">
                                    <button class="quantity-btn--minus">-</button>
                                    <input type="text" class="quantity-input" value="0" readonly />
                                    <button class="quantity-btn--plus">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dish__item">
                        <div class="imgCard">
                            <img src="./img/sushiBurger.jpg" alt="" />
                        </div>
                        <div class="infoCard">
                            <div class="head">
                                <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                                <div class="weight">255 г</div>
                            </div>
                            <div class="components">чілі, огірок квашенний, огірок свіжий, салата</div>
                            <div class="bottom">
                                <p class="price">999.99₴</p>
                                <div class="quantity-counter">
                                    <button class="quantity-btn--minus">-</button>
                                    <input type="text" class="quantity-input" value="0" readonly />
                                    <button class="quantity-btn--plus">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="catalog__item" data-catalog="2">
            <div class="title">Пасти</div>
            <div class="catalog__list">
                <div class="dish__item">
                    <div class="label new">🔥 Новинка</div>
                    <div class="imgCard">
                        <img src="./img/sushiBurger.jpg" alt="" />
                    </div>
                    <div class="infoCard">
                        <div class="head">
                            <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                            <div class="weight">255 г</div>
                        </div>
                        <div class="components">мясна нарізка, сирна нарізка, мед, помідори,</div>
                        <div class="bottom">
                            <p class="price">999.99₴</p>
                            <div class="quantity-counter">
                                <button class="quantity-btn--minus">-</button>
                                <input type="text" class="quantity-input" value="0" readonly />
                                <button class="quantity-btn--plus">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dish__item">
                    <div class="imgCard">
                        <img src="./img/sushiBurger.jpg" alt="" />
                    </div>
                    <div class="infoCard">
                        <div class="head">
                            <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                            <div class="weight">255 г</div>
                        </div>
                        <div class="components">мясна нарізка, сирна нарізка, мед, помідори,</div>
                        <div class="bottom">
                            <p class="price">999.99₴</p>
                            <div class="quantity-counter">
                                <button class="quantity-btn--minus">-</button>
                                <input type="text" class="quantity-input" value="0" readonly />
                                <button class="quantity-btn--plus">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dish__item">
                    <div class="label new">🔥 Новинка</div>
                    <div class="imgCard">
                        <img src="./img/sushiBurger.jpg" alt="" />
                    </div>
                    <div class="infoCard">
                        <div class="head">
                            <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                            <div class="weight">255 г</div>
                        </div>
                        <div class="components">мясна нарізка, сирна нарізка, мед, помідори, болгарський перець, чілі, огірок квашенний, огірок свіжий, салата</div>
                        <div class="bottom">
                            <p class="price">999.99₴</p>
                            <div class="quantity-counter">
                                <button class="quantity-btn--minus">-</button>
                                <input type="text" class="quantity-input" value="0" readonly />
                                <button class="quantity-btn--plus">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dish__item">
                    <div class="imgCard">
                        <img src="./img/sushiBurger.jpg" alt="" />
                    </div>
                    <div class="infoCard">
                        <div class="head">
                            <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                            <div class="weight">255 г</div>
                        </div>
                        <div class="components">помідори, болгарський перець, чілі, огірок квашенний, огірок свіжий, салата</div>
                        <div class="bottom">
                            <p class="price">999.99₴</p>
                            <div class="quantity-counter">
                                <button class="quantity-btn--minus">-</button>
                                <input type="text" class="quantity-input" value="0" readonly />
                                <button class="quantity-btn--plus">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dish__item">
                    <div class="imgCard">
                        <img src="./img/sushiBurger.jpg" alt="" />
                    </div>
                    <div class="infoCard">
                        <div class="head">
                            <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                            <div class="weight">255 г</div>
                        </div>
                        <div class="components">огірок квашенний, огірок свіжий, салата</div>
                        <div class="bottom">
                            <p class="price">999.99₴</p>
                            <div class="quantity-counter">
                                <button class="quantity-btn--minus">-</button>
                                <input type="text" class="quantity-input" value="0" readonly />
                                <button class="quantity-btn--plus">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dish__item">
                    <div class="imgCard">
                        <img src="./img/sushiBurger.jpg" alt="" />
                    </div>
                    <div class="infoCard">
                        <div class="head">
                            <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                            <div class="weight">255 г</div>
                        </div>
                        <div class="components">чілі, огірок квашенний, огірок свіжий, салата</div>
                        <div class="bottom">
                            <p class="price">999.99₴</p>
                            <div class="quantity-counter">
                                <button class="quantity-btn--minus">-</button>
                                <input type="text" class="quantity-input" value="0" readonly />
                                <button class="quantity-btn--plus">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('templates.footer')