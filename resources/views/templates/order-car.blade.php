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

    @media (max-width: 1250px) {
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

    @media (max-width: 1250px) {
        .order-car__left {
            order: 2;
        }
    }

    @media (max-width: 1250px) {
        .order-car__left {
            width: 100%;
        }
    }

    .order-car__types {
        display: flex;
    }

    .order-car__type {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        padding: 10px;
        border-radius: 5px;
    }

    .order-car__type.chosen {
        background: #ec1220;
    }

    .order-car__type.chosen span {
        color: white;
    }
    
    .order-car__type.chosen img {
        filter: brightness(0) saturate(100%) invert(100%) sepia(99%) saturate(0%) hue-rotate(319deg) brightness(104%) contrast(100%);
    }

    .order-car__type span {
        color: #323232;
    }

    .order-car__type img {
        width: 17px;
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
        overflow: hidden;
    }

    .order-car[v-cloak]::before {
        content: 'завантаження...';
        position: absolute;
        z-index: 1000;
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
        cursor: pointer;
    }

    .order-car__body.close .arrow img {
       rotate: 180deg;
    }

    @media (max-width: 1250px) {
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

    .add-address {
        border-radius: 6px ;
        font-size: 14px !important;
    }

    .remove-address img {
        width: 18px;
        cursor: pointer;
    }

    .order-car .form-group {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .address-list {
        position: absolute;
        top: 45px;
        left: 0;
        z-index: 100;
        width: 100%;
        background: white;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .3);
        max-height: 155px;
        overflow: auto;
    }

    .address-list::-webkit-scrollbar {
        height: 10px;
        width: 10px;
    }

    .address-list::-webkit-scrollbar-track {
        background: white;
    }

    .address-list:hover::-webkit-scrollbar-thumb {
        background-color: hsl(0deg 0% 78.43%);
    }

    .address-list::-webkit-scrollbar-thumb {
        background-color: hsl(0deg 0% 83.53%);
        border-radius: 20px;
        border: 3px solid white;
    }

    .address-list .address-item {
        cursor: pointer;
        padding: 0 4px;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
        line-height: 30px;
        text-align: left;
        border-top: 1px solid #e6e6e6;
        font-size: 11px;
        color: #515151;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .address-list .address:first-child {
        border-top: none;
    }

    .address-list .address-item:hover {
        background-color: #f9f8fa;
    }

    .address-list .address-item svg {
        flex-shrink: 0;
    }

    .address-list .address-item span {
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .input-wrapper {
        margin-bottom: 15px;
        position: relative;
    }

    .comment-btn {
        font-size: 14px !important;
    } 

    .datetime {
        display: flex;
        gap: 15px;
        margin-top: 15px;
    }
    
    .datetime .form-group {
        width: 50%;
    }

    .ui-widget.ui-widget-content {
        border: none !important;
    }

    #ui-datepicker-div {
        z-index: 100 !important;
    }

    .ui-state-active {
        background-color: #ec1220 !important;
        color: white !important;
        border: none !important;
    }

    .datetime .form-group img {
        position: absolute;
        right: 10px;
    }
</style>

@verbatim
<section 
    class="order-car" 
    v-cloak 
    @vue:mounted="mounted">
    <div class="container">
        <div :class="{'order-car__body': true, 'close': ! openPanel,}">

            <div class="order-car__left">

                <div 
                    class="arrow"
                    @click="openPanel = ! openPanel">
                    <img src="/assets/img/arrow.svg" alt="">
                </div>

                <div 
                    v-show="leftSide == 'form'"
                    class="order-car__order">
                    <div class="order-car__types">
                        <div 
                            :class="{'order-car__type': true, 'chosen': data.service == 'Таксі'}"
                            @click="data.service = 'Таксі'">
                            <img src="/assets/img/car.png" alt="">
                            <span>
                                Таксі
                            </span>
                        </div>
                        <div 
                            :class="{'order-car__type': true, 'chosen': data.service == 'Кур\'єр'}"
                            @click="data.service = 'Кур\'єр'">
                            <img src="/assets/img/courier.svg" alt="">
                            <span>
                                Кур'єр
                            </span>
                        </div>
                    </div>

                    <div class="order-car__form">
                        <div 
                            v-if="data.route?.from"
                            class="input-wrapper">
                            <div class="form-group">
                                <input
                                    class="address-input"
                                    placeholder="Звідки*"
                                    autocomplete="off"
                                    type="text" 
                                    :id="data.route.from.id"
                                    v-model="data.route.from.value"
                                    @input="data.route.from.showList = !data.route.from.value"
                                    @focus="data.route.from.showList = !data.route.from.value"
                                    @focusout="setTimeout(() => data.route.from.showList = false, 150)"/>
                            </div>

                            <div 
                                v-if="data.route.from.showList"
                                class="address-list">
                                <div 
                                    class="address-item"
                                    @click="setAddressAsCurrent(data.route.from)">
                                    <img src="/assets/img/location.png" alt="">
                                    <span>
                                        Ваше місцерозташування
                                    </span>
                                </div>
                                <div 
                                    class="address-item"
                                    @click="openSetOnMap(data.route.from)">
                                    <img src="/assets/img/location.png" alt="">
                                    <span>
                                        Вказати на карті
                                    </span>
                                </div>
                                <div 
                                    v-for="item in addressHistory"
                                    class="address-item"
                                    @click="data.route.from.setData(item)">
                                    <img src="/assets/img/addressHistory.svg" alt="">
                                    <span>
                                        {{ item.address }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div
                            v-for="(address, i) in data.route?.to ?? []" 
                            class="input-wrapper"
                            :key="i">
                            <div class="form-group">
                                <div style="flex-grow: 1; position: relative;">
                                    <input
                                        class="address-input"
                                        :placeholder="data.route.to.length == 1 ? 'Куди*' : 'Зупинка'"
                                        autocomplete="off"
                                        type="text" 
                                        :id="address.id"
                                        v-model="address.value"
                                        @input="address.showList = !address.value"
                                        @focus="address.showList = !address.value"
                                        @focusout="setTimeout(() => address.showList = false, 200)"/>
                                    <div 
                                        v-if="address.showList"
                                        class="address-list">
                                        <div 
                                            class="address-item"
                                            @click="openSetOnMap(address)">
                                            <img src="/assets/img/location.png" alt="">
                                            <span>
                                                Вказати на карті
                                            </span>
                                        </div>
                                        <div 
                                            v-for="item in addressHistory"
                                            class="address-item"
                                            @click="address.setData(item)">
                                            <img src="/assets/img/addressHistory.svg" alt="">
                                            <span>
                                                {{ item.address }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div 
                                    v-if="data.route.to.length >= 2"
                                    title="Видалити зупинку"
                                    class="remove-address"
                                    @click="data.route.removeAddress(i)">
                                    <img src="/assets/img/bin.png" alt="">
                                </div>
                            </div>
                        </div>

                        <div 
                            v-if="data.route.to.length < 3"
                            class="btn add-address"
                            title="Додати зупинку"
                            @click="data.route.addAddress()">
                            +
                        </div>

                        <div class="datetime">
                            <div class="form-group">
                                <input 
                                    type="text"
                                    readonly
                                    autocomplete="off"
                                    id="date"
                                    v-model="data.date">
                                <img src="/assets/img/calendar.png" alt="">
                            </div>

                            <div class="form-group">
                                <input 
                                    type="text"
                                    readonly
                                    autocomplete="off"
                                    id="time"
                                    v-model="data.time">
                                <img src="/assets/img/time.png" alt="">
                            </div>
                        </div>

                        <div 
                            v-if="data.service == 'Кур\'єр'"
                            style="margin-top: 15px;"
                            class="form-group">
                            <select v-model="data.shipping_type">
                                <option value="" disabled selected>
                                    Тип доставки
                                </option>
                                <option 
                                    v-for="type in shippingTypes"
                                    :value="type">
                                        {{ type }}
                                </option>
                            </select>
                        </div>

                        <div 
                            v-if="data.service == 'Кур\'єр'"
                            class="btn comment-btn"
                            @click="leftSide = 'comment'">
                            Додати коментарій
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
                        class="btn order-btn"
                        disabled
                        @click="send">
                        Замовити <span v-if="price !== null"> {{ price }}₴</span>
                    </button>
                </div>

                <div
                    v-show="leftSide == 'setOnMap'"
                    class="order-car__set-on-map">
                    <div class="form-group">
                        <input 
                            readonly
                            type="text" 
                            placeholder="Вкажіть адресу на карті"
                            v-model="setOnMap.address.address"/>
                    </div>
                    <button 
                        class="btn"
                        :disabled="!Boolean(setOnMap.address.address)"
                        @click="applySetOnMap">
                        Підтвердити
                    </button>
                    <button 
                        class="btn cancel"
                        @click="closeSetOnMap">
                        Скасувати
                    </button>
                </div>

                <div
                    v-show="leftSide == 'comment'"
                    class="order-car__comment">
                    <div class="form-group">
                        <textarea 
                            rows="5"
                            v-model="data.comment"
                            placeholder="Коментарій"></textarea>
                    </div>
                    <button 
                        class="btn"
                        @click="addComment">
                        Додати
                    </button>
                    <button 
                        class="btn cancel"
                        @click="deleteComment">
                        Видалити
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
<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js'></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script type="module">
import { createApp, reactive } from 'https://unpkg.com/petite-vue?module'

const getAddressFromPlace = place => {
    let address = place.formatted_address

    const country = place.address_components.find(
        component => component.types.includes('country')
    )
    if (country) {
        address = address.replace(`, ${country.long_name}`, '').trim()
    }

    const zip = place.address_components.find(
        component => component.types.includes('postal_code')
    )
    if (zip) {
        address = address.replace(`, ${zip.long_name}`, '').trim()
    }

    return address
}

function Address(route, data = {}) {
    this.route = route
    this.address = data.address
    this.lat = data.lat
    this.lng = data.lng
    this.id = 'id' + Math.random().toString(16).slice(2)
    this.value =  data.address ?? ''
    this.showList = false
    setTimeout(() => {
        this.autocomplete = new google
            .maps
            .places
            .Autocomplete(
                document.getElementById(this.id), 
                {
                    componentRestrictions: {
                        country: 'ua'
                    },
                    types: ['geocode'],
                    bounds: new google.maps.LatLngBounds(
                        new google.maps.LatLng(49.06547728491617, 22.9082275452199),
                        new google.maps.LatLng(50.44206318762908, 25.3252197327199)
                    ),
                    strictBounds: true,
                }
            )
        this.autocomplete.addListener('place_changed', () => {
            const place = this.autocomplete.getPlace()

            this.setData({
                address: getAddressFromPlace(place),
                lat: place.geometry.location.lat(),
                lng: place.geometry.location.lng(),
            })
        })
    })

    this.setData = data => {
        this.address = data.address
        this.lat = data.lat
        this.lng = data.lng 
        this.value = data.address

        const el = document.getElementById(this.id)
        if (el) {
            el.value = this.value
        }

        this.route.refreshMap()
    }
    this.addMarker = () => {
        if (! this.lat || ! this.lng) {
            return
        }

        this.marker = new google.maps.Marker({
            position: {
                lat: this.lat,
                lng: this.lng,
            },
            map: this.route.map,
        })

        this.route.map.setCenter({
            lat: this.lat,
            lng: this.lng,
        })
        this.route.map.setZoom(16)
    }
    this.updateMarker = () => {
        if (! this.marker) {
            this.addMarker()
        } 

        if (this.isChanged()) {
            this.marker.setPosition({
                lat: this.lat,
                lng: this.lng,
            })
            this.route.map.setCenter({
                lat: this.lat,
                lng: this.lng,
            })
            this.route.map.setZoom(16)
        }
    }
    this.removeMarker = () => {
        this.marker?.setVisible(false)
        this.marker?.setMap(null)
        this.marker?.setPosition(null)
        this.marker = null
    }
    this.isChanged = () => {
        return  this.lat != this.marker?.getPosition()?.lat() || this.lng != this.marker?.getPosition()?.lng()
    } 
}

function Route(map) {
    this.map = map
    this.from = new Address(this)
    this.to = reactive([])
    this.to.push(new Address(this))

    this.addAddress = (address = {}) => {
        this.to.push(new Address(this, address))
    }
    this.removeAddress = i => {
        this.to[i].removeMarker()
        this.to.splice(i, 1)

        this.refreshMap()
    }
    this.showRoute = () => { 
        this.from.removeMarker()
        this.to.forEach(address => address.removeMarker())
        this.route?.setMap(null)

        const directions = new google.maps.DirectionsService()

        this.route = new google.maps.DirectionsRenderer()
        this.route.setMap(this.map)

        const origin = {
            lat: this.from.lat,
            lng: this.from.lng,
        }

        const to = this.to.filter(address => address.address)

        const destination = {
            lat: to[to.length-1].lat,
            lng: to[to.length-1].lng,
        }

        const waypoints = []
        for (let i = 0; i < to.length-1; i++) {
            waypoints.push({
                location: {
                    lat: to[i].lat,
                    lng: to[i].lng,
                }
            })
        }

        directions.route({
            origin,
            destination,
            waypoints,
            travelMode: google.maps.TravelMode.DRIVING,
        }, (result, status) => {
            if (status === google.maps.DirectionsStatus.OK) {
                this.route.setDirections(result)
            } else {
                console.error(result)
            }
        })
    }
    this.removeRoute = () => {
        this.route?.setMap(null)
        this.route = null
        this.from.updateMarker()
        this.to.forEach(address => address.updateMarker())
    }
    this.refreshMap = () => {
        let showRoute = this.from.address && this.to.some(address => address.address)

        document.dispatchEvent(new CustomEvent('show-route', {
            detail: {showRoute}
        }))

        if (showRoute) {
            this.showRoute()
        } else {
            this.removeRoute()
        }
    }
}

const app = {
    map: null,
    data: {
        service: 'Таксі',
        route: null,
        date: 'Сьогодні',
        formattedDate: 'Сьогодні',
        time: 'Зараз',
        shipping_type: '',
        comment: '',
        payment_method: 'Готівка',
    },
    shippingTypes: [
        'Посилка з пошти',
        'Посилка з маршрутки',
        'Закуп продуктів',
        'Вручення квітів/подарунків',
        'Забрати замовлення',
        'Набрати води',
        'Набрати бензин',
        'Розвіз зелені',
        'Розвіз хліб',
        'Вантажні перевезення',
        'Тверезий водій',
        'Прикурити авто',
    ],
    leftSide: 'form',
    price: null,
    openPanel: true,
    setOnMap: {
        for: null,
        marker: null,
        address: {
            address: null,
            lat: null,
            lng: null,
        },
    },
    addressHistory: [],
    openSetOnMap(address) {
        this.leftSide = 'setOnMap'
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
            this.animateMarkerTo(this.setOnMap.marker, {
                lat: this.map.getCenter().lat(),
                lng: this.map.getCenter().lng(),
            })
        })

        this.map.addListener('dragend', async () => {
            const place = await this.geocode({
                lat: this.map.getCenter().lat(),
                lng: this.map.getCenter().lng(),
            })

            this.setOnMap.address = {
                address: getAddressFromPlace(place),
                lat: place.geometry.location.lat(),
                lng: place.geometry.location.lng(),
            }
        })
    },
    applySetOnMap() {
        this.setOnMap.for.setData(this.setOnMap.address)
        this.closeSetOnMap()
    },
    closeSetOnMap() {
        this.setOnMap.marker?.setVisible(false)
        this.setOnMap.marker?.setMap(null)
        this.setOnMap.marker?.setPosition(null)
        this.setOnMap.marker = null
        this.setOnMap.address = {
            address: null,
            lat: null,
            lng: null,
        }
        this.leftSide = 'form'
    },
    async geocode(latLng) {
        const geocoder = new google.maps.Geocoder()

        const res = await geocoder.geocode({ 
            location: latLng,
        })

        return res.results[0]
    },
    addComment() {
        this.leftSide = 'form'
    },
    deleteComment() {
        this.data.comment = ''
        this.leftSide = 'form'
    },
    async send() {        
        const container = document.querySelector('.order-car__left')
        try {
            container.classList.add('loading')
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
            container.classList.remove('loading')
        }
    },
    getData() {
        const data = {}

        data.service = this.data.service
        
        data.from = {
            address: this.data.route.from.address,
            lat: this.data.route.from.lat,
            lng: this.data.route.from.lng,
        }
        data.to = this.data.route.to.map(address => {
            return {
                address: address.address,
                lat: address.lat,
                lng: address.lng,
            }
        })

        data.date = this.data.formattedDate
        if (data.date == 'Сьогодні') {
            data.date = `${new Date().getFullYear()}-${String(new Date().getMonth()+1).padStart(2, '0')}-${String(new Date().getDate()).padStart(2, '0')}`
        }

        data.time = this.data.time
        if (data.time == 'Зараз') {
            data.time = `${String(new Date().getHours()).padStart(2, '0')}:${String(new Date().getMinutes()).padStart(2, '0')}`
        }

        data.shipping_type = this.data.shipping_type
        data.comment = this.data.comment
        data.payment_method = this.data.payment_method

        return data
    },
    setDataFromOrder(order) {
        this.data.service = order.type

        if (order.type == 'Таксі') {
            this.data.route.from.setData(order.details.taxi_from)

            order.details.taxi_to.forEach((address, i) => {
                if (! this.data.route.to[i]) {
                    this.data.route.addAddress(address)
                } else {
                    this.data.route.to[i].setData(address)
                }
            })
        }

        if (order.type == 'Кур\'єр') {
            this.data.route.from.setData(order.details.shipping_from)

            order.details.shipping_to.forEach((address, i) => {
                if (! this.data.route.to[i]) {
                    this.data.route.addAddress(address)
                } else {
                    this.data.route.to[i].setData(address)
                }
            })

            this.data.shipping_type = order.details.shipping_type
        }

        setTimeout(() => this.data.route.refreshMap())
    },
    animateMarkerTo(marker, newPosition) {
        var options = {
        duration: 100,
            easing: function (x, t, b, c, d) {
                return -c *(t/=d)*(t-2) + b;
            }
        };

        window.requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
        window.cancelAnimationFrame = window.cancelAnimationFrame || window.mozCancelAnimationFrame;

        marker.AT_startPosition_lat = marker.getPosition().lat();
        marker.AT_startPosition_lng = marker.getPosition().lng();
        var newPosition_lat = newPosition.lat;
        var newPosition_lng = newPosition.lng;

        if (Math.abs(newPosition_lng - marker.AT_startPosition_lng) > 180) {
            if (newPosition_lng > marker.AT_startPosition_lng) {
                newPosition_lng -= 360;
            } else {
                newPosition_lng += 360;
            }
        }

        var animateStep = function(marker, startTime) {
            var ellapsedTime = (new Date()).getTime() - startTime;
            var durationRatio = ellapsedTime / options.duration; // 0 - 1
            var easingDurationRatio = options.easing(durationRatio, ellapsedTime, 0, 1, options.duration);

            if (durationRatio < 1) {
                marker.setPosition({
                    lat: (
                        marker.AT_startPosition_lat +
                        (newPosition_lat - marker.AT_startPosition_lat)*easingDurationRatio
                    ),
                    lng: (
                        marker.AT_startPosition_lng +
                        (newPosition_lng - marker.AT_startPosition_lng)*easingDurationRatio
                    )
                });

                if (window.requestAnimationFrame) {
                    marker.AT_animationHandler = window.requestAnimationFrame(function() {animateStep(marker, startTime)});
                } else {
                    marker.AT_animationHandler = setTimeout(function() {animateStep(marker, startTime)}, 17);
                }

            } else {
                marker.setPosition(newPosition);
            }
        }

        if (window.cancelAnimationFrame) {
            window.cancelAnimationFrame(marker.AT_animationHandler);
        } else {
            clearTimeout(marker.AT_animationHandler);
        }

        animateStep(marker, (new Date()).getTime());
    },
    startTime() {
        let hour = String(new Date().getHours()).padStart(2, '0')
        let minute = new Date().getMinutes()

        if (minute < 15) {
            minute = '15'
        } else if (minute < 30) {
            minute = '30'
        } else if (minute < 45) {
            minute = '45'
        } else if (minute < 60){
            hour = String(new Date().getHours() + 1).padStart(2, '0')
            minute = '00'
        }

        return `${hour}:${minute}`
    },
    setAddressAsCurrent(address) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(async () => {
                const lat = geo.coords.latitude
                const lng = geo.coords.longitude

                const place = await this.geocode({lat, lng})

                address.setData({
                    address: getAddressFromPlace(place),
                    lat: place.geometry.location.lat(),
                    lng: place.geometry.location.lng(),
                })
            }, err => console.error(err))
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

        $('#date').datepicker({
            currentText: "Now",
            dateFormat: 'dd.mm.yy',
            monthNames: [ 'Січень', 'Лютий', 'Березень', 'Квітень', 'Травень', 'Червень', 'Липень', 'Серпень', 'Вересень', 'Жовтень', 'Листопад', 'Грудень',],
            dayNamesMin: ['Нд', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
            onSelect: (text, e) => {
                this.data.date = text
                this.data.formattedDate = `${e.selectedYear}-${String(e.selectedMonth).padStart(2, '0')}-${String(e.selectedDay).padStart(2, '0')}`
            }
        })
        $('#time').timepicker({
            timeFormat: 'HH:mm',
            interval: 15,
            startTime: this.startTime(),
            scrollbar: false
        })

        this.data.route = new Route(this.map)

        document.addEventListener('show-route', e => {
            const el = document.querySelector('.order-btn')
            if (e.detail.showRoute) {
                el.disabled = false
            } else {
                el.disabled = true
            }
        })

        const urlParams = new URLSearchParams(window.location.search)
        if (urlParams.get('service')) {
            this.data.service = urlParams.get('service')
        }

        this.addressHistory = {{ Js::from($address_history) }}

        const order = {{ Js::from($order) }}
        if (order) {
            this.setDataFromOrder(order)
        }
    },
}

createApp(app).mount('.order-car')
</script>