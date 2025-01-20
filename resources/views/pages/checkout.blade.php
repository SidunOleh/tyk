@include('templates.header', ['title' => 'Оформлення замовлення'])

<section class="checkout">
    <div class="container">
        <div class="hero__title">
            Оформлення замовлення
        </div>
        <div class="wrapper">
            <form class="checkout-form" id="checkout-form">

                <section class="form-section">
                    <h2>Контактні дані</h2>
                    <div class="form-group input-box">
                        <input 
                            type="text" 
                            name="full_name" 
                            placeholder="Ім’я та прізвище*" 
                            value="{{ $client?->full_name }}"
                            required />
                    </div>
                    <div class="form-group input-box">
                        <input 
                            type="text" 
                            name="phone" 
                            placeholder="Номер телефону*" 
                            required 
                            value="{{ $client?->phone }}"/>
                    </div>
                </section>
                
                <section class="form-section">
                    <h2>Дані доставки</h2>
                    <div class="address-select">
                        <div class="form-group input-box">
                            <input 
                                class="autocomplete"
                                type="text" 
                                name="address" 
                                placeholder="Адреса*" 
                                required />
                        </div>

                        @if ($client?->addresses)
                        <div class="addresses-history">
                            @foreach ($client->addresses ?? [] as $address)
                            <div class="address" data-address="{{ $address['address'] }}">
                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" fit="" preserveAspectRatio="xMidYMid meet" focusable="false">
                                    <path d="M15.5 15.4996C15.2 15.4996 15 15.3996 14.8 15.1996L11.8 12.1996C11.6 11.9996 11.5 11.7996 11.5 11.4996V6.59961C11.5 5.99961 11.9 5.59961 12.5 5.59961C13.1 5.59961 13.5 5.99961 13.5 6.59961V10.9996L16.2 13.6996C16.6 14.0996 16.6 14.6996 16.2 15.0996C16 15.3996 15.8 15.4996 15.5 15.4996Z" fill="#454754"></path>
                                    <path d="M21.6 8.70038C20 3.70038 14.7 0.900385 9.7 2.50038C4.7 4.10038 1.9 9.40038 3.5 14.4004C3.9 15.8004 4.7 17.0004 5.7 18.1004H4C3.4 18.1004 3 18.5004 3 19.1004C3 19.7004 3.4 20.1004 4 20.1004H8C8.6 20.1004 9 19.7004 9 19.1004V15.1004C9 14.5004 8.6 14.1004 8 14.1004C7.4 14.1004 7 14.5004 7 15.1004V16.7004C6.2 15.9004 5.7 14.9004 5.3 13.9004C4.1 10.0004 6.3 5.70038 10.2 4.50038C14.1 3.30038 18.4 5.50038 19.6 9.40038C20.8 13.3004 18.6 17.6004 14.7 18.8004C13.9 19.0004 13.1 19.2004 12.3 19.1004C11.7 19.1004 11.3 19.5004 11.3 20.1004C11.3 20.7004 11.7 21.1004 12.3 21.1004C12.4 21.1004 12.4 21.1004 12.5 21.1004C13.5 21.1004 14.4 21.0004 15.3 20.7004C20.3 19.0004 23.1 13.7004 21.6 8.70038Z" fill="#454754"></path>
                                </svg>
                                <span>
                                    {{ $address['address'] }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                        @endif

                    </div>
                </section>

                <section class="form-section">
                    <h2>Деталі доставки</h2>
                    <div class="form-group input-box">
                        <label for="delivery-time">
                            Вкажіть годину, на котру бажаєте отримати замовлення (необов’язково):
                        </label>
                        <input 
                            type="text" 
                            id="delivery-time" 
                            placeholder="-:-" 
                            name="delivery_time" />
                    </div>
                    <div class="form-group input-box">
                        <label for="notes">
                            Примітки до замовлення (необов’язково)
                        </label>
                        <textarea 
                            type="text" 
                            name="notes" 
                            placeholder="Нотатки щодо вашого замовлення"></textarea>
                    </div>
                </section>

            </form>
        </div>
        <div class="cartSubtotal">
            <h2 class="title_32">
                Підсумки кошика
            </h2>
            
            <div class="subtotal-list">
                <div class="subtotal-item">
                    <p class="position">
                        Проміжний підсумок
                    </p>
                    <p class="sum">
                        {{ $cart->formattedTotal() }}
                    </p>
                </div>
                <div class="subtotal-item">
                    <p class="position">
                        Доставка
                    </p>
                    <p class="sum deliver">
                        Єдиний тариф. Варіанти доставки будуть оновлені під час оформлення замовлення.
                    </p>
                </div>
                <div class="subtotal-item">
                    <p class="position">
                        Загалом
                    </p>
                    <p class="sum">
                        {{ $cart->formattedTotal() }}
                    </p>
                </div>
                <p class="remark">
                    *Ціна вказана без урахування пакування і вартості послуги доставки
                </p>
            </div>

            <div class="radio-group">
                <label class="radio-option">
                    <input
                        form="checkout-form" 
                        type="radio" 
                        name="payment_method" 
                        value="Карта" 
                        checked />
                    <span class="custom-radio"></span>
                    Оплата карткою
                </label>
                <label class="radio-option">
                    <input 
                        form="checkout-form" 
                        type="radio" 
                        name="payment_method" 
                        value="Готівкою" />
                    <span class="custom-radio"></span>
                    Готівкою при отриманні
                </label>
            </div>

            <button
                id="checkout-form-btn"  
                class="btn">
                Підтвердити замовлення
            </button>
        </div>
    </div>
</section>

<script src="https://maps.googleapis.com/maps/api/js?key={{ config('googlemaps.key') }}&libraries=places&language=uk&region=ua"></script>

@include('templates.footer')