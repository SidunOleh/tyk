@include('templates.header', ['title' => 'Замовити авто'])

@verbatim
<section 
    class="order-car" 
    v-cloak 
    @vue:mounted="mounted">
    <div class="container">
        <div :class="{'order-car__body': true, 'close': !openPanel,}">

            <div class="order-car__left">
                <div class="order-car__panel">
                    <div 
                        class="arrow"
                        @click="openPanel = !openPanel">
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
                                v-if="map.route?.from"
                                class="input-wrapper">
                                <div class="form-group">
                                    <input
                                        class="address-input"
                                        placeholder="Звідки*"
                                        autocomplete="off"
                                        type="text" 
                                        :id="map.route.from.id"
                                        v-model="map.route.from.value"
                                        @input="map.route.from.showList = !map.route.from.value"
                                        @focus="map.route.from.showList = !map.route.from.value"/>
                                </div>

                                <div 
                                    v-if="map.route.from.showList"
                                    class="address-list">
                                    <div 
                                        class="address-item"
                                        @click="setCurrentAddress(map.route.from)">
                                        <img src="/assets/img/location.png" alt="">
                                        <span>
                                            Ваше місцерозташування
                                        </span>
                                    </div>
                                    <div 
                                        class="address-item"
                                        @click="openSetOnMap(map.route.from)">
                                        <img src="/assets/img/location.png" alt="">
                                        <span>
                                            Вказати на карті
                                        </span>
                                    </div>
                                    <div 
                                        v-for="item in user?.addresses"
                                        class="address-item"
                                        @click="map.route.from.setData(item)">
                                        <img src="/assets/img/addressHistory.svg" alt="">
                                        <span>
                                            {{ item.address }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div
                                v-for="(address, i) in map.route?.to ?? []" 
                                class="input-wrapper"
                                :key="i">
                                <div class="form-group">
                                    <div style="flex-grow: 1; position: relative;">
                                        <input
                                            class="address-input"
                                            :placeholder="map.route.to.length == 1 ? 'Куди*' : 'Зупинка'"
                                            autocomplete="off"
                                            type="text" 
                                            :id="address.id"
                                            v-model="address.value"
                                            @input="address.showList = !address.value"
                                            @focus="address.showList = !address.value"/>
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
                                                v-for="item in user?.addresses"
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
                                        v-if="map.route.to.length >= 2"
                                        title="Видалити зупинку"
                                        class="remove-address"
                                        @click="map.route.removeAddress(i)">
                                        <img src="/assets/img/bin.png" alt="">
                                    </div>
                                </div>
                            </div>

                            <div 
                                v-if="map.route.to.length < 3"
                                class="btn add-address"
                                title="Додати зупинку"
                                @click="map.route.addAddress()">
                                Додати зупинку
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
                                v-show="data.service == 'Кур\'єр'"
                                style="margin-top: 15px;"
                                class="form-group">
                                <select v-model="data.shipping_type">
                                    <option 
                                        value="" 
                                        disabled 
                                        selected>
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
                                class="btn comment-btn"
                                @click="leftSide = 'comment'">
                                Додати коментар
                            </div>

                            <div class="payments">
                                <div class="radio-group">
                                    <label class="radio-option">
                                        <input 
                                            form="checkout-form" 
                                            type="radio" 
                                            value="Готівка"
                                            v-model="data.payment_method"/>
                                        <span class="custom-radio"></span>
                                        Готівка
                                    </label>
                                    <label class="radio-option">
                                        <input
                                            form="checkout-form" 
                                            type="radio" 
                                            value="Карта" 
                                            v-model="data.payment_method"/>
                                        <span class="custom-radio"></span>
                                        Карта
                                    </label>
                                </div>

                                <div  
                                    v-if="user?.bonuses >= 50"
                                    class="form-group">
                                    <input 
                                        id="bonuses"
                                        type="checkbox" 
                                        class="custom-checkbox"
                                        v-model="data.use_bonuses"/>
                                    <label for="bonuses">
                                        <span>
                                            Використати бонуси <b>(50₴)</b>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button 
                            class="btn order-btn"
                            :disabled="price === null"
                            @click="user ? send() : openLoginPopup()">
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
                                placeholder="Коментар"></textarea>
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
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src='https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js'></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"/>
<script type="module">
import { createApp, reactive, } from '{{ asset("/assets/js/petite-vue.es.js") }}'

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
    this.address = data.address ?? ''
    this.lat = data.lat ?? null 
    this.lng = data.lng ?? null
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

        this.route.map.refresh()
    }
    this.addMarker = () => {
        if (this.isEmpty()) {
            return
        }

        this.marker = new google.maps.Marker({
            position: {
                lat: this.lat,
                lng: this.lng,
            },
            map: this.route.getMap(),
        })

        this.route.getMap().setCenter({
            lat: this.lat,
            lng: this.lng,
        })
        this.route.getMap().setZoom(16)
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
            this.route.getMap().setCenter({
                lat: this.lat,
                lng: this.lng,
            })
            this.route.getMap().setZoom(16)
        }
    }
    this.removeMarker = () => {
        this.marker?.setVisible(false)
        this.marker?.setMap(null)
        this.marker?.setPosition(null)
        this.marker = null
    }
    this.isEmpty = () => {
        return  ! this.lat || ! this.lng
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
    this.getMap = () => this.map.map
    this.addAddress = (data = {}) => {
        const address = new Address(this, data)
        this.to.push(address)

        if (! address.isEmpty()) {
            this.map.refresh()
        }
    }
    this.removeAddress = i => {
        const address = this.to[i]
        address.removeMarker()
        this.to.splice(i, 1)

        if (! address.isEmpty()) {
            this.map.refresh()
        }
    }
    this.setRoute = (from, to) => {
        this.from = new Address(this, from)
        this.to = reactive(
            to.map(address => new Address(this, address))
        )

        this.map.refresh()
    },
    this.show = () => { 
        this.from.removeMarker()
        this.to.forEach(address => address.removeMarker())
        this.route?.setMap(null)

        const directions = new google.maps.DirectionsService()

        this.route = new google.maps.DirectionsRenderer({
            preserveViewport: true,
            polylineOptions: {
                strokeColor: '#ec1220',
            }
        })
        this.route.setMap(this.getMap())

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
            travelMode: google.maps.TravelMode.BICYCLING,
        }, (result, status) => {
            if (status === google.maps.DirectionsStatus.OK) {
                this.route.setDirections(result)
                const bounds = this.getBounds()
                this.getMap().setZoom(
                    this.calcMapZoomByBounds(this.getMap(), bounds)
                )
                this.getMap().setCenter(
                    bounds.getCenter()
                )
            } else {
                console.error(result)
            }
        })
    }
    this.remove = () => {
        this.route?.setMap(null)
        this.route = null
        this.from.updateMarker()
        this.to.forEach(address => address.updateMarker())
    }
    this.getBounds = () => {
        let bounds = new google.maps.LatLngBounds()

        const addresses = [this.from, ...this.to]
        addresses.forEach(address => {
            if (! address.isEmpty()) {
                bounds.extend({
                    lat: address.lat,
                    lng: address.lng,
                })
            }
        })

        return bounds
    }
    this.calcMapZoomByBounds = (map, bounds) => {
        let MAX_ZOOM = map.mapTypes.get(map.getMapTypeId()).maxZoom || 21
        let MIN_ZOOM = map.mapTypes.get(map.getMapTypeId()).minZoom || 0

        let ne = map.getProjection().fromLatLngToPoint(bounds.getNorthEast())
        let sw = map.getProjection().fromLatLngToPoint(bounds.getSouthWest()) 

        let worldCoordWidth = Math.abs(ne.x-sw.x)
        let worldCoordHeight = Math.abs(ne.y-sw.y)

        let FIT_PAD = 40

        for(let zoom = MAX_ZOOM; zoom >= MIN_ZOOM; --zoom){ 
            if(
                worldCoordWidth*(1<<zoom)+2*FIT_PAD < $(map.getDiv()).width() && 
                worldCoordHeight*(1<<zoom)+2*FIT_PAD < $(map.getDiv()).height()
            ) {
                return zoom
            }
        }

        return 0
    }
}

function Map(map) {
    this.map = map
    this.route = new Route(this)
    this.refresh = () => {
        let showRoute = ! this.route.from.isEmpty() && this.route.to.some(address => ! address.isEmpty())

        if (showRoute) {
            this.route.show()
        } else {
            this.route.remove()
        }

        document.dispatchEvent(new CustomEvent('refresh-map', {
            detail: {showRoute}
        }))
    }
}

const app = {
    map: null,
    data: {
        service: 'Таксі',
        date: 'Сьогодні',
        formattedDate: 'Сьогодні',
        time: 'Зараз',
        shipping_type: '',
        comment: '',
        payment_method: 'Готівка',
        use_bonuses: false,
    },
    shippingTypes: {{ Js::from($courierServices->pluck('name')) }},
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
    shippingTypesSelect: null,
    user: null,
    openSetOnMap(address) {
        this.leftSide = 'setOnMap'
        this.setOnMap.for = address  
        this.setOnMap.marker = new google.maps.Marker({
            position: {
                lat: this.map.map.getCenter().lat(),
                lng: this.map.map.getCenter().lng(),
            },
            map: this.map.map,
            animation: google.maps.Animation.DROP,
        })

        this.map.map.addListener('center_changed', this.centerChangedHandler)
        this.map.map.addListener('zoom_changed', this.findSetOnMapAddress)
        this.map.map.addListener('dragend', this.findSetOnMapAddress)
    },
    centerChangedHandler() {
        if (this.leftSide != 'setOnMap') {
            return
        }

        this.animateMarkerTo(this.setOnMap.marker, {
            lat: this.map.map.getCenter().lat(),
            lng: this.map.map.getCenter().lng(),
        })
    },
    async findSetOnMapAddress() {        
        if (this.leftSide != 'setOnMap') {
            return
        }
        
        const position = this.map.map.getCenter()

        this.setOnMap.marker.setPosition(position)
        this.map.map.setCenter(position)

        const place = await this.geocode({
            lat: position.lat(),
            lng: position.lng(),
        })

        this.setOnMap.address = {
            address: getAddressFromPlace(place),
            lat: place.geometry.location.lat(),
            lng: place.geometry.location.lng(),
        }
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
    setDataFromOrder(order) {
        this.data.service = order.type

        if (order.type == 'Таксі') {
            this.map.route.setRoute(order.details.taxi_from, order.details.taxi_to)
        }

        if (order.type == 'Кур\'єр') {
            this.map.route.setRoute(order.details.shipping_from, order.details.shipping_to)
            this.data.shipping_type = order.details.shipping_type

            this.shippingTypesSelect.setChoiceByValue(order.details.shipping_type)
        }

        this.updatePrice()
    },
    animateMarkerTo(marker, newPosition) {
        let options = {
        duration: 100,
            easing: function (x, t, b, c, d) {
                return -c *(t/=d)*(t-2) + b
            }
        };

        window.requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame
        window.cancelAnimationFrame = window.cancelAnimationFrame || window.mozCancelAnimationFrame

        marker.AT_startPosition_lat = marker.getPosition().lat()
        marker.AT_startPosition_lng = marker.getPosition().lng()
        let newPosition_lat = newPosition.lat
        let newPosition_lng = newPosition.lng

        if (Math.abs(newPosition_lng - marker.AT_startPosition_lng) > 180) {
            if (newPosition_lng > marker.AT_startPosition_lng) {
                newPosition_lng -= 360
            } else {
                newPosition_lng += 360
            }
        }

        let animateStep = function(marker, startTime) {
            let ellapsedTime = (new Date()).getTime() - startTime
            let durationRatio = ellapsedTime / options.duration
            let easingDurationRatio = options.easing(durationRatio, ellapsedTime, 0, 1, options.duration)

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
                    marker.AT_animationHandler = window.requestAnimationFrame(function() {animateStep(marker, startTime)})
                } else {
                    marker.AT_animationHandler = setTimeout(function() {animateStep(marker, startTime)}, 17)
                }

            } else {
                marker.setPosition(newPosition)
            }
        }

        if (window.cancelAnimationFrame) {
            window.cancelAnimationFrame(marker.AT_animationHandler)
        } else {
            clearTimeout(marker.AT_animationHandler)
        }

        animateStep(marker, (new Date()).getTime())
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
    setCurrentAddress(address) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(async geo => {
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
    async updatePrice() {
        try {
            this.price = null

            const data = {}
            data.service = this.data.service
            data.courier_service = this.data.shipping_type
            
            data.route = []
            if (this.map.route.from.isEmpty()) {
                return
            }
            data.route.push({
                lat: this.map.route.from.lat,
                lng: this.map.route.from.lng,
            })
            this.map.route.to
                .filter(address => !address.isEmpty())
                .forEach(address => {
                    data.route.push({
                        lat: address.lat,
                        lng: address.lng,
                    })
                })
            if (data.route.length < 2) {
                return
            }

            const res = await fetch('/orders/order-car/price', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', 
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data)
            })
            const json = await res.json()

            this.price = json.price
        } catch (err) {
            console.error(err)
        }
    },
    getData() {
        const data = {}

        data.service = this.data.service
        
        data.from = {
            address: this.map.route.from.address,
            lat: this.map.route.from.lat,
            lng: this.map.route.from.lng,
        }
        data.to = this.map.route.to
            .filter(address => !address.isEmpty())
            .map(address => {
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
        data.use_bonuses = this.data.use_bonuses

        return data
    },
    async send() {        
        const container = document.querySelector('.order-car__left')
        container.classList.add('loading')
        try {
            const res = await fetch('/orders/order-car', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(this.getData())
            })
            
            if (res.status != 200) {
                throw new Error(res.statusText)
            }

            const data = await res.json()

            location.href = `/zaversheno?order=${data.id}`
        } catch (err) {
            console.error(err)
        } finally {
            container.classList.remove('loading')
        }
    },
    openLoginPopup() {
        const popup = document.querySelector('.popUp-Wrapper.signIn')
        popup.classList.add('open')

        const loginForm = document.querySelector('#login')
        loginForm.setAttribute('data-event', 'order-car')
        loginForm.addEventListener('order-car', () => this.send())
    },
    mounted() {
        this.map = new Map(
            new google.maps.Map(
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
        )

        document.addEventListener('refresh-map', () => this.updatePrice())

        document.addEventListener('click', e => {
            const inputs = document.querySelectorAll('input')
            inputs.forEach(input => {
                const id = input.getAttribute('id')
                const addresses = [this.map.route.from, ...this.map.route.to]
                addresses.forEach(address => {
                    if (
                        address.id == id && 
                        input != document.activeElement
                    ) {
                        address.showList = false
                    } 
                })
            })
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
            scrollbar: false,
        })

        const shippingTypesSelectEl = document.querySelector('select')
        this.shippingTypesSelect = new Choices(shippingTypesSelectEl, {
            noResultsText: 'Немає результатів',
            itemSelectText: 'Натисни',
        })
        shippingTypesSelectEl.addEventListener('change', () => {
            this.updatePrice()
        })

        const urlParams = new URLSearchParams(window.location.search)
        if (urlParams.get('service')) {
            this.data.service = urlParams.get('service')
        }
        if (urlParams.get('courier_service')) {
            this.data.shipping_type = urlParams.get('courier_service')
            this.shippingTypesSelect.setChoiceByValue(urlParams.get('courier_service'))
        }

        this.user = {{ Js::from(auth('web')->user()) }}

        const order = {{ Js::from($order) }}
        if (order) {
            this.setDataFromOrder(order)
        }
    },
}
 
createApp(app).mount('.order-car')
</script>

@include('templates.order-car-footer')