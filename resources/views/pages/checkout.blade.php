@include('templates.header', ['title' => 'Оформлення замовлення'])

<section class="checkout">
    <div class="container">
        <div class="hero__title">Оформлення замовлення</div>
        <div class="wrapper">
            <form class="checkout-form" id="checkout-form">
                <section class="form-section">
                    <h2>Контактні дані</h2>
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Ім’я та прізвище*" required />
                        <p class="error">Введіть ваше ім’я та прізвище</p>
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" placeholder="Номер телефону*" required />
                        <p class="error">Введіть ваш номер телефону</p>
                    </div>
                </section>
                <section class="form-section">
                    <h2>Дані доставки</h2>
                    <div class="form-group">
                        <input type="text" name="city" placeholder="Місто/село*" required />
                        <p class="error">Введіть ваше місто/село</p>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <input type="text" name="street" placeholder="Назва вулиці та номер будинку*" required />
                            <p class="error">Введіть назву вашої вулиці та номер будинку</p>
                        </div>
                        <div class="form-group">
                            <input type="text" name="apartment" placeholder="Квартира/офіс/блок" required />
                        </div>
                    </div>
                </section>
                <section class="form-section">
                    <h2>Shipping Details</h2>
                    <div class="form-group">
                        <label for="delivery-time">Вкажіть годину, на котру бажаєте отримати замовлення (необов’язково):</label>
                        <input type="text" id="delivery-time" placeholder="-:-" name="delivery-time" />
                    </div>
                    <div class="form-group">
                        <label for="notes">Примітки до замовлення (необов’язково)</label>
                        <textarea type="text" name="notes" placeholder="Нотатки щодо вашого замовлення"></textarea>
                    </div>
                </section>
            </form>
        </div>
        <div class="cartSubtotal">
            <h2 class="title_32">Підсумки кошика</h2>
            <div class="subtotal-list">
                <div class="subtotal-item">
                    <p class="position">Проміжний підсумок</p>
                    <p class="sum">
                        {{ $cart->formattedTotal() }}₴
                    </p>
                </div>
                <div class="subtotal-item">
                    <p class="position">Доставка</p>
                    <p class="sum deliver">
                        Єдиний тариф. Варіанти доставки будуть оновлені під час оформлення замовлення.
                    </p>
                </div>
                <div class="subtotal-item">
                    <p class="position">Загалом</p>
                    <p class="sum">
                        {{ $cart->formattedTotal() }}₴
                    </p>
                </div>
                <p class="remark">
                    *Ціна вказана без урахування пакування і вартості послуги доставки
                </p>
            </div>

            <div class="radio-group">
                <label class="radio-option">
                    <input type="radio" name="payment" value="Оплата карткою" checked />
                    <span class="custom-radio"></span>
                    Оплата карткою
                </label>
                <label class="radio-option">
                    <input type="radio" name="payment" value="Готівкою при отриманні" />
                    <span class="custom-radio"></span>
                    Готівкою при отриманні
                </label>
            </div>

            <a type="sabmit" class="btn">
                Підтвердити замовлення
            </a>
        </div>
    </div>
</section>

@include('templates.footer')