<div class="popUp-Wrapper delivery">
    <div class="servicePopUp popUp">
        <img src="{{ asset('/assets/img/popUP-grey.jpg') }}" alt="" class="back" />
        <div class="close"><img src="{{ asset('/assets/img/close.svg') }}" alt="" /></div>
        <div class="wrapper">
            <div class="left">
                <p class="title">
                    Кур’єрська <br /> доставка
                </p>
                <img src="{{ asset('/assets/img/Box.svg') }}" alt="" class="icon" />
            </div>
            <div class="right">
                <form action="">
                    <input type="text" name="name" placeholder="Ім’я та прізвище*" />
                    <input type="text" name="phone" placeholder="Номер телефону*" />
                    <input type="text" name="address" placeholder="Адреса відправлення*" />
                    <input type="text" name="address" placeholder="Адреса прибуття*" />
                    <input type="text" name="time" placeholder="Час замовлення" />
                    <input type="text" name="notes" placeholder="Форма розрахунку" />
                    <div class="pay">
                        <p class="title_16">Форма розрахунку</p>
                        <div class="radio-buttons">
                            <label class="radio-button">
                                <input type="radio" name="payment" value="cash" />
                                <span>Готівка</span>
                            </label>
                            <label class="radio-button">
                                <input type="radio" name="payment" value="card" />
                                <span>Карта</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn grey">Поїхали!</button>
                </form>
            </div>
        </div>
    </div>
</div>