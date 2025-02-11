<style>
    .order-car {
        margin-top: 80px;
        height: calc(100vh - 132px);
    }

    @media (max-width: 1024px) {
        .order-car {
            margin-top: 70px;
            height: calc(100vh - 122px);
        }
    }

    @media (max-width: 768px) {
        .order-car {
            height: calc(100vh - 118px);
        }
    }

    .order-car .container {
        height: 100%;
    }

    .order-car__body {
        gap: 20px;
        display: flex;
        height: 100%;
        overflow: auto;
    }

    @media (max-width: 768px) {
        .order-car__body {
            flex-direction: column;
        }
    }

    .order-car__left {
        align-self: flex-start;
        flex: 30%;
        border: 2px solid rgb(243 243 243);
        padding: 15px;
        border-radius: 5px;
    }

    @media (max-width: 768px) {
        .order-car__left {
            order: 2;
        }
    }

    @media (max-width: 768px) {
        .order-car__left {
            width: 100%;
        }
    }

    .order-car__types {
        display: flex;
        gap: 20px;
    }

    .order-car__type {
        display: flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        position: relative;
    }

    .order-car__type.chosen::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 4px;
        background: black;
        bottom: -10px;
        left: 0;
    }

    .order-car__form {
        margin-top: 30px;
    }

    .order-car__left .btn {
        margin-top: 15px;
        width: 100%;
        font-size: 16px;
        padding: 12px 24px;
        display: flex;
        gap: 5px;
    }

    .order-car__left .btn:disabled {
        opacity: 0.6;
        pointer-events: none;
    }

    .order-car__right {
        flex: 70%;
    }

    @media (max-width: 768px) {
        .order-car__right {
            width: 100%;
            order: 1;
        }
    }

    #map {
        width: 100%;
        height: 100%;
        border-radius: 5px;
    }

    #map img[alt=Google] {
        display: none;
    }

    #map .gm-style-cc {
        display: none;
    }

    .form-group {
        position: relative
    }

    .form-group label {
        color: var(--Grey-100, #323232);
        font-family: Montserrat;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        display: block;
    }

    .form-group .error {
        display: none;
        color: red;
        position: absolute;
        left: 3px;
        top: 102%;
        font-size: 14px
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        background: var(--White, #fff);
        -webkit-box-shadow: 0px 4px 34.3px 0px rgba(62, 132, 127, 0.11);
        box-shadow: 0px 4px 34.3px 0px rgba(62, 132, 127, 0.11);
        border: none;
        font-size: 16px
    }

    .form-group input::-webkit-input-placeholder,
    .form-group select::-webkit-input-placeholder,
    .form-group textarea::-webkit-input-placeholder {
        color: #868686;
        font-size: 14px;
        font-weight: 400;
        line-height: normal;
        font-family: Montserrat
    }

    .form-group input::-moz-placeholder,
    .form-group select::-moz-placeholder,
    .form-group textarea::-moz-placeholder {
        color: #868686;
        font-size: 14px;
        font-weight: 400;
        line-height: normal;
        font-family: Montserrat
    }

    .form-group input:-ms-input-placeholder,
    .form-group select:-ms-input-placeholder,
    .form-group textarea:-ms-input-placeholder {
        color: #868686;
        font-size: 14px;
        font-weight: 400;
        line-height: normal;
        font-family: Montserrat
    }

    .form-group input::-ms-input-placeholder,
    .form-group select::-ms-input-placeholder,
    .form-group textarea::-ms-input-placeholder {
        color: #868686;
        font-size: 14px;
        font-weight: 400;
        line-height: normal;
        font-family: Montserrat
    }

    .form-group input::placeholder,
    .form-group select::placeholder,
    .form-group textarea::placeholder {
        color: #868686;
        font-size: 14px;
        font-weight: 400;
        line-height: normal;
        font-family: Montserrat
    }

    .custom-checkbox {
        position: absolute;
        z-index: -1;
        opacity: 0;
        display: none;
    }

    .custom-checkbox+label {
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .custom-checkbox+label::before {
        content: '';
        display: inline-block;
        width: 20px;
        height: 20px;
        flex-shrink: 0;
        flex-grow: 0;
        border: 1px solid #ec1220;
        border-radius: 0.25em;
        margin-right: 0.5em;
        background-repeat: no-repeat;
        background-position: center center;
        background-size: 50% 50%;
    }

    .custom-checkbox:checked+label::before {
        border-color: #ec1220;
        background-color: #ec1220;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
    }

    .payment-methods {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .btn.cancel {
        background-color: black;
    }

    .btn.cancel:hover {
        background-color: white;
        color: black;
    }

    .address-select .icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translate(0, -50%);
        cursor: pointer;
    }

    .address-select input {
        padding-right: 35px;
    }

    .order-car__left.loading {
        border-radius: 5px;
    }

    .order-car {
        position: relative;
    }

    .order-car[v-cloak]::before {
        content: 'завантаження...';
        position: absolute;
        z-index: 1;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #f8f8f8;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .order-car__left .arrow {
        display: none;
    }

    @media (max-width: 425px) {
        .order-car {
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
        }

        .order-car .container {
            padding: 0 !important;
        }

        .order-car__body {
            height: 100vh;
            gap: 0;
        }

        .footer {
            display: none;
        }

        .order-car__left {
            position: relative;
        }

        .order-car__left .arrow {
            width: 100px;
            height: 20px;
            position: absolute;
            top: -20px;
            left: 50%;
            z-index: 2;
            transform: translate(-50%, 0);
            background-color: #f8f8f8;
            border-radius: 10px 10px 0 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .order-car__body.close .order-car__left {
           flex: 0;
           padding: 0;
           border: 0;
        }

        .order-car__body.close .arrow svg {
            transform: rotate(180deg);
        }

        .order-car__body.close .order-car__order {
            display: none;
        }

        .order-car__body.close .order-car__set-on-map {
            display: none;
        }
    }

    .order-car__left.loading {
        border-radius: 5px;
    }
</style>

<section 
    class="order-car" 
    data-order="{{ $order ? json_encode($order) : '' }}"
    v-cloak 
    @vue:mounted="mounted">
    @verbatim
    <div class="container">
        <div :class="{'order-car__body': true, 'close': ! openPanel,}">

            <div class="order-car__left">
                <div 
                    class="arrow"
                    @click="openPanel = ! openPanel">
                    <svg fill="#000000" height="15px" width="15px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                        viewBox="0 0 330 330" xml:space="preserve">
                        <path id="XMLID_225_" d="M325.607,79.393c-5.857-5.857-15.355-5.858-21.213,0.001l-139.39,139.393L25.607,79.393
                            c-5.857-5.857-15.355-5.858-21.213,0.001c-5.858,5.858-5.858,15.355,0,21.213l150.004,150c2.813,2.813,6.628,4.393,10.606,4.393
                            s7.794-1.581,10.606-4.394l149.996-150C331.465,94.749,331.465,85.251,325.607,79.393z"/>
                    </svg>
                </div>

                <div 
                    v-show="! setOnMap.open"
                    class="order-car__order">
                    <div class="order-car__types">
                        <div 
                            :class="{'order-car__type': true, 'chosen': data.service == 'Таксі'}"
                            @click="data.service = 'Таксі'">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path d="m20.9 9-1.5-4.6c-.3-.8-1-1.4-1.9-1.4H6.4c-.9 0-1.6.5-1.9 1.4L3 9H1v3h1v9h4v-2h12v2h4v-9h1V9h-2.1ZM5 14h4v2H5v-2Zm10 2v-2h4v2h-4ZM7.1 6h9.7l1.3 4H5.8l1.3-4Z" fill="currentColor"></path>
                            </svg>
                            <span>Таксі</span>
                        </div>
                        <div 
                            :class="{'order-car__type': true, 'chosen': data.service == 'Кур\'єр'}"
                            @click="data.service = 'Кур\'єр'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path d="M17.5777 4.43152L15.5777 3.38197C13.8221 2.46066 12.9443 2 12 2C11.0557 2 10.1779 2.46066 8.42229 3.38197L6.42229 4.43152C4.64855 5.36234 3.6059 5.9095 2.95969 6.64132L12 11.1615L21.0403 6.64132C20.3941 5.9095 19.3515 5.36234 17.5777 4.43152Z" fill="currentColor"/>
                                <path d="M21.7484 7.96435L12.75 12.4635V21.904C13.4679 21.7252 14.2848 21.2965 15.5777 20.618L17.5777 19.5685C19.7294 18.4393 20.8052 17.8748 21.4026 16.8603C22 15.8458 22 14.5833 22 12.0585V11.9415C22 10.0489 22 8.86558 21.7484 7.96435Z" fill="currentColor"/>
                                <path d="M11.25 21.904V12.4635L2.25164 7.96434C2 8.86557 2 10.0489 2 11.9415V12.0585C2 14.5833 2 15.8458 2.5974 16.8603C3.19479 17.8748 4.27063 18.4393 6.42229 19.5685L8.42229 20.618C9.71524 21.2965 10.5321 21.7252 11.25 21.904Z" fill="currentColor"/>
                            </svg>
                            <span>Кур'єр</span>
                        </div>
                    </div>

                    <div class="order-car__form">
                        <div class="address-select" style="margin-bottom: 15px;">
                            <div class="form-group">
                                <input 
                                    data-with-history
                                    autocomplete="off"
                                    type="text" 
                                    name="from" 
                                    placeholder="Звідки*" 
                                    required
                                    v-model="addresses[0].value"
                                    @focusout="addresses[0].value = addresses[0].address"/>
                                    <span title="Вказати на карті">
                                        <svg @click="openSetOnMap(addresses[0])" class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="20px" width="20px" version="1.1" id="Capa_1" viewBox="0 0 293.334 293.334" xml:space="preserve">
                                            <g>
                                                <g>
                                                    <path style="fill:#010002;" d="M146.667,0C94.903,0,52.946,41.957,52.946,93.721c0,22.322,7.849,42.789,20.891,58.878    c4.204,5.178,11.237,13.331,14.903,18.906c21.109,32.069,48.19,78.643,56.082,116.864c1.354,6.527,2.986,6.641,4.743,0.212    c5.629-20.609,20.228-65.639,50.377-112.757c3.595-5.619,10.884-13.483,15.409-18.379c6.554-7.098,12.009-15.224,16.154-24.084    c5.651-12.086,8.882-25.466,8.882-39.629C240.387,41.962,198.43,0,146.667,0z M146.667,144.358    c-28.892,0-52.313-23.421-52.313-52.313c0-28.887,23.421-52.307,52.313-52.307s52.313,23.421,52.313,52.307    C198.98,120.938,175.559,144.358,146.667,144.358z"/>
                                                    <circle style="fill:#010002;" cx="146.667" cy="90.196" r="21.756"/>
                                                </g>
                                            </g>
                                        </svg>
                                    </span>
                            </div>

                            @endverbatim

                            @if ($address_history)
                            <div class="addresses-history">
                                @foreach ($address_history as $address)
                                <div 
                                    class="address"
                                    data-address="{{ $address['address'] }}"
                                    @click="changeAddress(addresses[0], {{ Js::from($address) }})">
                                    <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" fit="" preserveAspectRatio="xMidYMid meet" focusable="false">
                                        <path d="M15.5 15.4996C15.2 15.4996 15 15.3996 14.8 15.1996L11.8 12.1996C11.6 11.9996 11.5 11.7996 11.5 11.4996V6.59961C11.5 5.99961 11.9 5.59961 12.5 5.59961C13.1 5.59961 13.5 5.99961 13.5 6.59961V10.9996L16.2 13.6996C16.6 14.0996 16.6 14.6996 16.2 15.0996C16 15.3996 15.8 15.4996 15.5 15.4996Z" fill="#454754"></path>
                                        <path d="M21.6 8.70038C20 3.70038 14.7 0.900385 9.7 2.50038C4.7 4.10038 1.9 9.40038 3.5 14.4004C3.9 15.8004 4.7 17.0004 5.7 18.1004H4C3.4 18.1004 3 18.5004 3 19.1004C3 19.7004 3.4 20.1004 4 20.1004H8C8.6 20.1004 9 19.7004 9 19.1004V15.1004C9 14.5004 8.6 14.1004 8 14.1004C7.4 14.1004 7 14.5004 7 15.1004V16.7004C6.2 15.9004 5.7 14.9004 5.3 13.9004C4.1 10.0004 6.3 5.70038 10.2 4.50038C14.1 3.30038 18.4 5.50038 19.6 9.40038C20.8 13.3004 18.6 17.6004 14.7 18.8004C13.9 19.0004 13.1 19.2004 12.3 19.1004C11.7 19.1004 11.3 19.5004 11.3 20.1004C11.3 20.7004 11.7 21.1004 12.3 21.1004C12.4 21.1004 12.4 21.1004 12.5 21.1004C13.5 21.1004 14.4 21.0004 15.3 20.7004C20.3 19.0004 23.1 13.7004 21.6 8.70038Z" fill="#454754"></path>
                                    </svg>
                                    <span>{{ $address['address'] }}</span>
                                </div>
                                @endforeach
                            </div>
                            @endif

                            @verbatim
                        </div>

                        <div class="address-select" style="margin-bottom: 15px;">
                            <div class="form-group">
                                <input
                                    data-with-history
                                    autocomplete="off"
                                    type="text" 
                                    name="to" 
                                    placeholder="Куди*" 
                                    required
                                    v-model="addresses[1].value"
                                    @focusout="addresses[1].value = addresses[1].address"/>
                                    <span title="Вказати на карті">
                                        <svg @click="openSetOnMap(addresses[1])" class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="20px" width="20px" version="1.1" id="Capa_1" viewBox="0 0 293.334 293.334" xml:space="preserve">
                                            <g>
                                                <g>
                                                    <path style="fill:#010002;" d="M146.667,0C94.903,0,52.946,41.957,52.946,93.721c0,22.322,7.849,42.789,20.891,58.878    c4.204,5.178,11.237,13.331,14.903,18.906c21.109,32.069,48.19,78.643,56.082,116.864c1.354,6.527,2.986,6.641,4.743,0.212    c5.629-20.609,20.228-65.639,50.377-112.757c3.595-5.619,10.884-13.483,15.409-18.379c6.554-7.098,12.009-15.224,16.154-24.084    c5.651-12.086,8.882-25.466,8.882-39.629C240.387,41.962,198.43,0,146.667,0z M146.667,144.358    c-28.892,0-52.313-23.421-52.313-52.313c0-28.887,23.421-52.307,52.313-52.307s52.313,23.421,52.313,52.307    C198.98,120.938,175.559,144.358,146.667,144.358z"/>
                                                    <circle style="fill:#010002;" cx="146.667" cy="90.196" r="21.756"/>
                                                </g>
                                            </g>
                                        </svg>
                                    </span>
                            </div>

                            @endverbatim

                            @if ($address_history)
                            <div class="addresses-history">
                                @foreach ($address_history as $address)
                                <div 
                                    class="address"
                                    data-address="{{ $address['address'] }}"
                                    @click="changeAddress(addresses[1], {{ Js::from($address) }})">
                                    <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" fit="" preserveAspectRatio="xMidYMid meet" focusable="false">
                                        <path d="M15.5 15.4996C15.2 15.4996 15 15.3996 14.8 15.1996L11.8 12.1996C11.6 11.9996 11.5 11.7996 11.5 11.4996V6.59961C11.5 5.99961 11.9 5.59961 12.5 5.59961C13.1 5.59961 13.5 5.99961 13.5 6.59961V10.9996L16.2 13.6996C16.6 14.0996 16.6 14.6996 16.2 15.0996C16 15.3996 15.8 15.4996 15.5 15.4996Z" fill="#454754"></path>
                                        <path d="M21.6 8.70038C20 3.70038 14.7 0.900385 9.7 2.50038C4.7 4.10038 1.9 9.40038 3.5 14.4004C3.9 15.8004 4.7 17.0004 5.7 18.1004H4C3.4 18.1004 3 18.5004 3 19.1004C3 19.7004 3.4 20.1004 4 20.1004H8C8.6 20.1004 9 19.7004 9 19.1004V15.1004C9 14.5004 8.6 14.1004 8 14.1004C7.4 14.1004 7 14.5004 7 15.1004V16.7004C6.2 15.9004 5.7 14.9004 5.3 13.9004C4.1 10.0004 6.3 5.70038 10.2 4.50038C14.1 3.30038 18.4 5.50038 19.6 9.40038C20.8 13.3004 18.6 17.6004 14.7 18.8004C13.9 19.0004 13.1 19.2004 12.3 19.1004C11.7 19.1004 11.3 19.5004 11.3 20.1004C11.3 20.7004 11.7 21.1004 12.3 21.1004C12.4 21.1004 12.4 21.1004 12.5 21.1004C13.5 21.1004 14.4 21.0004 15.3 20.7004C20.3 19.0004 23.1 13.7004 21.6 8.70038Z" fill="#454754"></path>
                                    </svg>
                                    <span>{{ $address['address'] }}</span>
                                </div>
                                @endforeach
                            </div>
                            @endif

                            @verbatim
                        </div>

                        <div class="form-group">
                            <input  
                                readonly
                                autocomplete="off"
                                type="text" 
                                name="time" 
                                id="time"
                                placeholder="Час"/>
                        </div>

                        <div class="payment-methods">
                            <div class="form-group">
                                <input 
                                    checked
                                    name="payment_method"
                                    value="Готівка"
                                    type="radio" 
                                    class="custom-checkbox"
                                    id="cash"
                                    v-model="data.payment_method"/>
                                <label for="cash">
                                    Готівка
                                </label>
                            </div>
                            <div class="form-group">
                                <input 
                                    name="payment_method"
                                    value="Карта"
                                    type="radio" 
                                    class="custom-checkbox"
                                    id="card"
                                    v-model="data.payment_method"/>
                                <label for="card">
                                    Карта
                                </label>
                            </div>
                        </div>
                    </div>

                    <button 
                        class="btn"
                        :disabled="! route.route"
                        @click="send">
                        Замовити <span v-if="price !== null"> {{ price }}₴</span>
                    </button>
                </div>

                <div
                    v-show="setOnMap.open" 
                    class="order-car__set-on-map">
                    <div class="form-group">
                        <input 
                            readonly
                            type="text" 
                            name="set_address" 
                            placeholder="Вкажіть адресу на карті"
                            v-model="setOnMap.address.address"/>
                    </div>
                    <button 
                        class="btn"
                        :disabled="setOnMap.address.address ? false : true"
                        @click="applySetOnMap">
                        Підтвердити
                    </button>
                    <button 
                        class="btn cancel"
                        @click="closeSetOnMap">
                        Скасувати
                    </button>
                </div>
            </div>

            <div class="order-car__right">
                <div id="map"></div>
            </div>

        </div>
    </div>
</section>
@endverbatim

<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps_key') }}&libraries=places&language=uk&region=ua"></script>

<script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.min.css" rel="stylesheet">

<script type="module">
import { createApp } from 'https://unpkg.com/petite-vue?module'

const orderCar = {
    map: null,
    addresses: [],
    route: {
        route: null,
        distance: null,
        duration: null,
    },
    price: null,
    data: {
        service: 'Таксі',
        time: null,
        payment_method: 'Готівка',
    },
    datePicker: null,
    setOnMap: {
        open: false,
        for: null,
        marker: null,
        address: {
            address: null,
            lat: null,
            lng: null,
        }
    },
    openPanel: true,
    changeAddress(address, data) {
        address.address = data.address
        address.lat = data.lat
        address.lng = data.lng
        address.value = data.address

        if (
            this.addresses[0].address && 
            this.addresses[1].address
        ) {
            this.addresses.forEach(item => this.removeMarker(item.marker))
            this.route.route?.setMap(null)
            this.renderRoute()
        } else {
            this.addresses.forEach(item => item === address && this.removeMarker(item.marker))
            this.renderMarker(address)
        }
    },
    removeMarker(marker) {
        marker?.setVisible(false)
        marker?.setMap(null)
        marker?.setPosition(null)
        marker = null
    },
    renderMarker(address) {
        address.marker = new google.maps.Marker({
            position: {
                lat: address.lat,
                lng: address.lng,
            },
            map: this.map,
        })

        this.map.setCenter({
            lat: address.lat,
            lng: address.lng,
        })
        this.map.setZoom(16)
    },
    renderRoute() { 
        const directionsService = new google.maps.DirectionsService()

        this.route.route = new google.maps.DirectionsRenderer()
        this.route.route.setMap(this.map)

        directionsService.route({
            origin: {
                lat: this.addresses[0].lat,
                lng: this.addresses[0].lng,
            },
            destination: {
                lat: this.addresses[1].lat,
                lng: this.addresses[1].lng,
            },
            travelMode: google.maps.TravelMode.DRIVING,
        }, (result, status) => {
            if (status === google.maps.DirectionsStatus.OK) {
                this.route.route.setDirections(result)
                this.route.distance = result.routes[0].legs[0].distance.text
                this.route.duration = result.routes[0].legs[0].duration.text
                this.price = 0
            }
        })
    },
    openSetOnMap(address) {
        this.setOnMap.open = true  
        this.setOnMap.for = address  
        this.setOnMap.marker = new google.maps.Marker({
            position: {
                lat: this.map.getCenter().lat(),
                lng: this.map.getCenter().lng(),
            },
            map: this.map,
            animation: google.maps.Animation.DROP,
        })

        this.map.addListener('center_changed', () => {
            this.setOnMap.marker.setPosition({
                lat: this.map.getCenter().lat(),
                lng: this.map.getCenter().lng(),
            })
        })

        this.map.addListener('dragend', async () => {
            const location = await this.geocode({
                lat: this.map.getCenter().lat(),
                lng: this.map.getCenter().lng(),
            })

            this.setOnMap.address = {
                address: this.formatAddress(
                    location.formatted_address, 
                    location.address_components
                ),
                lat: location.geometry.location.lat(),
                lng: location.geometry.location.lng(),
            }
        })
    },
    applySetOnMap() {
        this.changeAddress(this.setOnMap.for, {
            address: this.setOnMap.address.address,
            lat: this.setOnMap.address.lat,
            lng: this.setOnMap.address.lng,
        })

        this.closeSetOnMap()
    },
    closeSetOnMap() {
        this.removeMarker(this.setOnMap.marker)
        this.setOnMap.address = {
            address: null,
            lat: null,
            lng: null,
        }
        this.setOnMap.open = false
    },
    async geocode(latLng) {
        const geocoder = new google.maps.Geocoder()

        const res = await geocoder.geocode({ 
            location: latLng,
        })

        return res.results[0]
    },
    formatAddress(address, components) {
        const country = components.find(
            component => component.types.includes('country')
        )
        const zip = components.find(
            component => component.types.includes('postal_code')
        )

        if (country) {
            address = address.replace(`, ${country.long_name}`, '').trim()
        }

        if (zip) {
            address = address.replace(`, ${zip.long_name}`, '').trim()
        }

        return address
    },
    async send() {
        try {
            document.querySelector('.order-car__left').classList.add('loading')
            const res = await fetch('/orders/order-car', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(this.getData())
            })
            const data = await res.json()
            location.href = `/zaversheno?order=${data.id}`
        } catch (err) {
            console.error(err)
        } finally {
            document.querySelector('.order-car__left').classList.remove('loading')
        }
    },
    getData() {
        const data = JSON.parse(JSON.stringify(this.data))
        
        data.from = {
            address: this.addresses[0].address,
            lat: this.addresses[0].lat,
            lng: this.addresses[0].lng,
        }
        data.to = {
            address: this.addresses[1].address,
            lat: this.addresses[1].lat,
            lng: this.addresses[1].lng,
        }
        
        if (data.time) {
            data.time = `${data.time}:00`
        }

        return data
    },
    setDataFromOrder(order) {
        this.data.service = order.type

        if (order.type == 'Таксі') {
            this.changeAddress(this.addresses[0], order.details.taxi_from)
            this.changeAddress(this.addresses[1], order.details.taxi_to[0])
        }

        if (order.type == 'Кур\'єр') {
            this.changeAddress(this.addresses[0], order.details.shipping_from)
            this.changeAddress(this.addresses[1], order.details.shipping_to[0])
        }
    },
    mounted() {
        this.map = new google.maps.Map(
            document.getElementById('map'), {
            center: { 
                lat: 49.8094, 
                lng: 24.9014, 
            },
            zoom: 13,
            mapId: '1',
            disableDefaultUI: true,
            gestureHandling: 'greedy',
        })

        this.addresses.push({
            address: null,
            lat: null,
            lng: null,
            value: null,
            autocomplete: null,
            marker: null,
        })
        this.addresses.push({
            address: null,
            lat: null,
            lng: null,
            value: null,
            autocomplete: null,
            marker: null,
        })

        this.addresses[0].autocomplete = new google
            .maps
            .places
            .Autocomplete(document.querySelector('[name=from]'), {
                componentRestrictions: {
                    country: 'ua'
                },
                types: ['geocode'],
            })
        this.addresses[0].autocomplete.addListener('place_changed', () => {
            const place = this.addresses[0].autocomplete.getPlace()

            this.changeAddress(this.addresses[0], {
                address: this.formatAddress(place.formatted_address, place.address_components),
                lat: place.geometry.location.lat(),
                lng: place.geometry.location.lng(),
            })
        })
        
        this.addresses[1].autocomplete = new google
            .maps
            .places
            .Autocomplete(document.querySelector('[name=to]'), {
                componentRestrictions: {
                    country: 'ua'
                },
                types: ['geocode'],
            })
        this.addresses[1].autocomplete.addListener('place_changed', () => {
            const place = this.addresses[1].autocomplete.getPlace()

            this.changeAddress(this.addresses[1], {
                address: this.formatAddress(place.formatted_address, place.address_components),
                lat: place.geometry.location.lat(),
                lng: place.geometry.location.lng(),
            })
        })

        this.datePicker = new AirDatepicker('#time', {
            timepicker: true,
            onSelect: e => this.data.time = e.formattedDate,
            dateFormat: 'yyyy-MM-dd',
            timeFormat: 'HH:mm',
            locale: {
                daysMin: ['Нд', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                months: ['Січень', 'Лютий', 'Березень', 'Квітень', 'Травень', 'Червень', 'Липень', 'Серпень', 'Вересень', 'Жовтень', 'Листопад', 'Грудень'],
                monthsShort: ['Січ', 'Лют', 'Бер', 'Кві', 'Тра', 'Чер', 'Лип', 'Сер', 'Вер', 'Жов', 'Лис', 'Гру'],
                lear: 'Очистити',
            },
            buttons: ['clear'],
        })

        const urlParams = new URLSearchParams(window.location.search)
        if (urlParams.get('service')) {
            this.data.service = urlParams.get('service')
        }

        const order = document
            .querySelector('.order-car')
            .getAttribute('data-order')
        if (order) {
            this.setDataFromOrder(JSON.parse(order))
        }
    },
}

createApp(orderCar).mount('.order-car')
</script>