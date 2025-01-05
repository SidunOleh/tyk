@include('templates.header')

<section class="cart-section">
    <div class="container">
        <p class="hero__title">Корзина</p>
        <div class="cart-body">
            <table class="cart-table">
                <thead>
                    <tr class="cart-head">
                        <th class="col">Товар</th>
                        <th class="col">Ціна</th>
                        <th class="col">Кількість</th>
                        <th class="col">Проміжний підсумок</th>
                        <th class="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="cart-item">
                        <td class="product">
                            <div class="icon"><img src="./img/pizza-img.jpg" alt="" /></div>
                            <div class="info">
                                <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                                <p class="weight">255 г</p>
                                <div class="components">Мясна нарізка, сирна нарізка, мед, помідори, болгарський перець, чілі, огірок квашенний, огірок свіжий, салата</div>
                            </div>
                        </td>
                        <td class="price">700.00 грн</td>
                        <td class="quantity">
                            <div class="counter">
                                <button class="counter__button counter__button--decrease">-</button>
                                <input type="text" class="counter__input" value="1" readonly />
                                <button class="counter__button counter__button--increase">+</button>
                            </div>
                        </td>
                        <td class="subtotal_table">
                            <span>700.00 грн</span>
                            <div class="delete"><img src="./img/trash.svg" alt="" /></div>
                        </td>
                    </tr>
                    <tr class="cart-item">
                        <td class="product">
                            <div class="icon"><img src="./img/pizza-img.jpg" alt="" /></div>
                            <div class="info">
                                <p class="name">Філе курки з картоплею пай та лісовими грибами</p>
                                <p class="weight">255 г</p>
                                <div class="components">Мясна нарізка, сирна нарізка, мед, помідори, болгарський перець, чілі, огірок квашенний, огірок свіжий, салата</div>
                            </div>
                        </td>
                        <td class="price">700.00 грн</td>
                        <td class="quantity">
                            <div class="counter">
                                <button class="counter__button counter__button--decrease">-</button>
                                <input type="text" class="counter__input" value="1" readonly />
                                <button class="counter__button counter__button--increase">+</button>
                            </div>
                        </td>
                        <td class="subtotal_table">
                            <span>700.00 грн</span>
                            <div class="delete"><img src="./img/trash.svg" alt="" /></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<section class="additions">
    <div class="container">
        <h2 class="section_title">Не забудьте додати до корзини ці товари</h2>
        <div class="additions-list">
            <div class="additions-item">
                <div class="top">
                    <div class="icon">
                        <img src="./img/cola.jpg" alt="" />
                    </div>
                    <div class="info">
                        <p class="name">Coca-Cola</p>
                        <div class="var">0.33 л</div>
                    </div>
                </div>
                <div class="bottom">
                    <p class="price">30.00₴</p>
                    <button class="add">+</button>
                </div>
            </div>
            <div class="additions-item">
                <div class="top">
                    <div class="icon">
                        <img src="./img/cola.jpg" alt="" />
                    </div>
                    <div class="info">
                        <p class="name">Coca-Cola</p>
                        <div class="var">0.33 л</div>
                    </div>
                </div>
                <div class="bottom">
                    <p class="price">30.00₴</p>
                    <button class="add">+</button>
                </div>
            </div>
            <div class="additions-item">
                <div class="top">
                    <div class="icon">
                        <img src="./img/cola.jpg" alt="" />
                    </div>
                    <div class="info">
                        <p class="name">Coca-Cola</p>
                        <div class="var">0.33 л</div>
                    </div>
                </div>
                <div class="bottom">
                    <p class="price">30.00₴</p>
                    <button class="add">+</button>
                </div>
            </div>
            <div class="additions-item">
                <div class="top">
                    <div class="icon">
                        <img src="./img/cola.jpg" alt="" />
                    </div>
                    <div class="info">
                        <p class="name">Coca-Cola</p>
                        <div class="var">0.33 л</div>
                    </div>
                </div>
                <div class="bottom">
                    <p class="price">30.00₴</p>
                    <button class="add">+</button>
                </div>
            </div>
        </div>
        <a href="" class="btn clear">Показати більше</a>
    </div>
</section>

<section class="cartSubtotal">
    <div class="container">
        <h2 class="title_32">Підсумки кошика</h2>
        <div class="subtotal-list">
            <div class="subtotal-item">
                <p class="position">Проміжний підсумок</p>
                <p class="sum">2100.00₴</p>
            </div>
            <div class="subtotal-item">
                <p class="position">Доставка</p>
                <p class="sum deliver">Єдиний тариф. Варіанти доставки будуть оновлені під час оформлення замовлення.</p>
            </div>
            <div class="subtotal-item">
                <p class="position">Загалом</p>
                <p class="sum">2100.00₴</p>
            </div>
        </div>
        <a href="#" class="btn">Перейти до оформлення</a>
    </div>
</section>

@include('templates.footer')