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

    .add-address {
        background-color: #ec1220;
        border-radius: 5px;
        padding: 2px;
        text-align: center;
        color: white;
        cursor: pointer;
        margin: -5px 0 10px 0;
        font-size: 16px;
    }

    .remove-address img {
        width: 20px;
        cursor: pointer;
    }

    .order-car .form-group {
        display: flex;
        align-items: center;
        gap: 5px;
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
                    <img src="/assets/img/arrow.svg" alt="">
                </div>

                <div 
                    v-show="! setOnMap.open"
                    class="order-car__order">
                    <div class="order-car__types">
                        <div 
                            :class="{'order-car__type': true, 'chosen': data.service == 'Таксі'}"
                            @click="data.service = 'Таксі'">
                            <img src="/assets/img/car.svg" alt="">
                            <span>Таксі</span>
                        </div>
                        <div 
                            :class="{'order-car__type': true, 'chosen': data.service == 'Кур\'єр'}"
                            @click="data.service = 'Кур\'єр'">
                            <img src="/assets/img/courier.svg" alt="">
                            <span>Кур'єр</span>
                        </div>
                    </div>

                    <div class="order-car__form">
                        
                        <div style="margin-bottom: 15px;">
                            <div class="form-group">
                                <input 
                                    v-if="data.from"
                                    class="address-input"
                                    autocomplete="off"
                                    type="text" 
                                    name="from" 
                                    :value="data.from.address"
                                    v-model="data.from.value"
                                    @input="data.from.showList = !Boolean(data.from.value)"
                                    @focus="data.from.showList = !Boolean(data.from.value)"
                                    @focusout="setTimeout(() => data.from.showList = false, 150)"
                                    placeholder="Звідки*"/>
                            </div>

                            <div 
                                v-if="data.from?.showList"
                                class="address-list">
                                <div 
                                    class="address-item"
                                    @click="openSetOnMap(data.from)">
                                    Вказати на карті
                                </div>
                                <div 
                                    v-for="item in addressHistory"
                                    @click="setAddress(data.from, item)"
                                    class="address-item">
                                    {{ item.address }}
                                </div>
                            </div>
                        </div>

                        <div
                            v-for="(address, i) in data.to" 
                            :key="i"
                            style="margin-bottom: 15px;">
                            <div class="form-group">
                                <input
                                    class="address-input"
                                    autocomplete="off"
                                    type="text" 
                                    name="to[]"
                                    :value="address.address"
                                    :to="`i${i}`" 
                                    placeholder="Куди*"/>
                                <div 
                                    v-if="data.to.length >= 2"
                                    title="Видалити зупинку"
                                    class="remove-address"
                                    @click="deleteToAddress(i)">
                                    <img src="/assets/img/bin.png" alt="">
                                </div>
                            </div>

                            <div class="address-list">
                                <div 
                                    class="address-item"
                                    @click="openSetOnMap(address)">
                                    Вказати на карті
                                </div>
                                <div 
                                    v-for="item in addressHistory"
                                    @click="setAddress(address, item)"
                                    class="address-item">
                                    {{ item.address }}
                                </div>
                            </div>
                        </div>

                        <div 
                            title="Додати зупинку"
                            class="add-address"
                            @click="addToAddress">+</div>

                        <div class="form-group">
                            <input  
                                type="date"
                                autocomplete="off"
                                type="text" 
                                name="time" 
                            
                                placeholder="Час"/>

                                <input type="time" step="1740" />
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
                    
                        @click="send">
                        Замовити <span v-if="route.price !== null"> {{ route.price }}₴</span>
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

    addressHistory: [],

    map: null,
    data: {
        service: 'Таксі',
        from: null,
        to: [],
        time: null,
        payment_method: 'Готівка',
    },
    route: {
        route: null,
        price: null,
    },
    autocompleteOptions: {
        componentRestrictions: {
            country: 'ua'
        },
        types: ['geocode'],
        bounds: new google.maps.LatLngBounds(
            new google.maps.LatLng(49.06547728491617, 22.9082275452199),
            new google.maps.LatLng(50.44206318762908, 25.3252197327199)
        ),
        strictBounds: true,
    },
    createAddress(inputSelector) {
        const address = {
            address: null,
            lat: null,
            lng: null,
            value: '',
            autocomplete: null,
            marker: null,
        }

        setTimeout(() => {
            address.autocomplete = new google
                .maps
                .places
                .Autocomplete(
                    document.querySelector(inputSelector), 
                    this.autocompleteOptions
                )
            address.autocomplete.addListener('place_changed', () => {
                const place = address.autocomplete.getPlace()

                document.querySelector(inputSelector).value = address.value = address.address = this.getAddress(place)
                address.lat = place.geometry.location.lat()
                address.lng = place.geometry.location.lng()

                this.refreshMap()
            })
        })

        return address
    },
    getAddress(place) {
        let formatted = place.formatted_address

        const country = place.address_components.find(
            component => component.types.includes('country')
        )
        if (country) {
            formatted = formatted.replace(`, ${country.long_name}`, '').trim()
        }

        const zip = place.address_components.find(
            component => component.types.includes('postal_code')
        )
        if (zip) {
            formatted = formatted.replace(`, ${zip.long_name}`, '').trim()
        }

        return formatted
    },
    addToAddress() {
        this.data.to.push(this.createAddress(`[to=i${this.data.to.length}]`))
    },
    deleteToAddress(i) {
        this.removeMarker(this.data.to[i].marker)
        this.data.to.splice(i, 1)
        this.refreshMap()
    },
    refreshMap() {
        let showRoute = this.data.from.address && ! this.data.to.some(address => ! address.address)

        if (showRoute) {
            this.clearMap()
            this.renderRoute()
        } else {
            this.refreshMarkers()
        }
    },
    clearMap() {
        this.removeMarker(this.data.from.marker)
        this.data.to.forEach(address => this.removeMarker(address.marker))
        this.route.route?.setMap(null)
    },
    renderRoute() { 
        const directions = new google.maps.DirectionsService()

        this.route.route = new google.maps.DirectionsRenderer()
        this.route.route.setMap(this.map)

        const origin = {
            lat: this.data.from.lat,
            lng: this.data.from.lng,
        }

        const destination = {
            lat: this.data.to[this.data.to.length-1].lat,
            lng: this.data.to[this.data.to.length-1].lng,
        }

        const waypoints = []
        for (let i = 0; i < this.data.to.length-1; i++) {
            waypoints.push({
                location: {
                    lat: this.data.to[i].lat,
                    lng: this.data.to[i].lng,
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
                this.route.route.setDirections(result)
                this.route.price = 0
            }
        })
    },
    refreshMarkers() {
        if (
            this.data.from.lat != this.data.from.marker?.getPosition().lat() ||
            this.data.from.lng != this.data.from.marker?.getPosition().lng()
        ) {
            this.removeMarker(this.data.from.marker)
            this.renderMarker(this.data.from)
        }

        this.data.to.forEach(address => {
            if (
                address.lat != address.marker?.getPosition().lat() ||
                address.lng != address.marker?.getPosition().lng()
            ) {
                this.removeMarker(address.marker)
                this.renderMarker(address)
            }
        })
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
    removeMarker(marker) {
        marker?.setVisible(false)
        marker?.setMap(null)
        marker?.setPosition(null)
        marker = null
    },
    setAddress(address, newAddress) {
        address.value = address.address = newAddress.address
        address.lat = newAddress.lat
        address.lng = newAddress.lng
        this.refreshMap()
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
                address: this.getAddress(location),
                lat: location.geometry.location.lat(),
                lng: location.geometry.location.lng(),
            }
        })
    },
    applySetOnMap() {
        this.setOnMap.for.value = this.setOnMap.for.address = this.setOnMap.address.address
        this.setOnMap.for.lat = this.setOnMap.address.lat
        this.setOnMap.for.lng = this.setOnMap.address.lng
        this.refreshMap()

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
    async send() {
        console.log(this.data.to)
            return
        
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

        this.data.from = this.createAddress('[name=from]')
        this.data.to.push(this.createAddress('[to=i0]'))

        this.datePicker = new AirDatepicker('#time', {
            onSelect: e => this.data.time = e.formattedDate,
            dateFormat: 'yyyy-MM-dd',
            timeFormat: 'HH:mm',
            locale: {
                daysMin: ['Нд', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                months: ['Січень', 'Лютий', 'Березень', 'Квітень', 'Травень', 'Червень', 'Липень', 'Серпень', 'Вересень', 'Жовтень', 'Листопад', 'Грудень'],
                monthsShort: ['Січ', 'Лют', 'Бер', 'Кві', 'Тра', 'Чер', 'Лип', 'Сер', 'Вер', 'Жов', 'Лис', 'Гру'],
                clear: 'Очистити',
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

        this.addressHistory = {{ Js::from($address_history) }}
    },
}

createApp(orderCar).mount('.order-car')
</script>