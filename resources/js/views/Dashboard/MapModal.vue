<template>
    <a-modal 
        width="1400px"
        :title="title"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">
        <div 
            style="height: 700px;"
            id="couriers-map"></div>
    </a-modal>
</template>

<script>
export default {
    props: [
        'open',
        'title',
        'locations',
    ],
    data() {
        return {
            markers: [],
        }
    },  
    methods: {
        createMap() {
            this.map = new google.maps.Map(
                document.getElementById('couriers-map'), {
                center: { 
                    lat: 49.8094, 
                    lng: 24.9014, 
                },
                zoom: 13,
                mapId: '1',
            })
        },
        async showOnMap() {
            for (const location of this.locations) {
                const marker = this.getMarker(location)
                if (marker) {
                    this.animateMarkerTo(marker, {
                        lat: location.car.lat,
                        lng: location.car.lng
                    })
                    marker.content = this.createMarkerEl(
                        location, 
                        marker.open
                    )
                } else {
                    this.markers.push(
                        await this.createMarker(location)
                    )   
                }
            }
        },
        getMarker(location) {
            for (const marker of this.markers) {
                if (
                    marker.location.car.id == location.car.id
                ) {
                    return marker
                }
            }

            return null
        },
        async createMarker(location) {
            const { AdvancedMarkerElement } = 
                await google.maps.importLibrary('marker')
            const marker = new AdvancedMarkerElement({
                map: this.map,
                position: { 
                    lat: location.car.lat, 
                    lng: location.car.lng,
                },
                content: this.createMarkerEl(location),
            })
            marker.location = location
            marker.open = false
            marker.addListener('click', () => {
                marker.content.classList.toggle('highlight')
                marker.open = ! marker.open
            })
            return marker
        },
        createMarkerEl(location, open = false) {
            const el = document.createElement('div')
            el.className = `courier-tag ${open ? 'highlight' : ''}`
            el.innerHTML = `
                <div class="title">
                    🏃🏼‍♂️ ${location.courier.first_name} ${location.courier.last_name}
                </div>
                <div class="info">
                    <div>🚖 ${location.car.brand}</div>
                    <div>🅿️ ${this.formatState(location.car.state)}</div>
                </div>
            `

            return el
        },
        formatState(state) {
            switch (state) {
                case 'standing':
                    return 'Стоїть'
                case 'driving':
                    return 'Їде'
            }
        },  
        animateMarkerTo(marker, newPosition) {
            let options = {
                duration: 1000,
                easing: function (x, t, b, c, d) {
                    return -c *(t/=d)*(t-2) + b
                }
            }

            window.requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame
            window.cancelAnimationFrame = window.cancelAnimationFrame || window.mozCancelAnimationFrame

            marker.AT_startPosition_lat = marker.position.lat
            marker.AT_startPosition_lng = marker.position.lng
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
                    marker.position = {
                        lat:
                            marker.AT_startPosition_lat +
                            (newPosition_lat - marker.AT_startPosition_lat) * easingDurationRatio,
                        lng:
                            marker.AT_startPosition_lng +
                            (newPosition_lng - marker.AT_startPosition_lng) * easingDurationRatio
                    }

                    if (window.requestAnimationFrame) {
                        marker.AT_animationHandler = window.requestAnimationFrame(function() {
                            animateStep(marker, startTime)
                        })
                    } else {
                        marker.AT_animationHandler = setTimeout(function() {
                            animateStep(marker, startTime)
                        }, 17)
                    }
                } else {
                    marker.position = newPosition
                }
            }

            if (window.cancelAnimationFrame) {
                window.cancelAnimationFrame(marker.AT_animationHandler)
            } else {
                clearTimeout(marker.AT_animationHandler)
            }

            animateStep(marker, (new Date()).getTime())
        },
    },
    watch: {
        locations() {
            this.showOnMap()
        },
    },
    mounted() {
        this.createMap()
        this.showOnMap()
    },
}
</script>

<style>
.courier-tag {
    position: relative;
    background-color: #4285F4;
    border-radius: 8px;
    color: #FFFFFF;
    font-size: 14px;
    padding: 10px 15px;
}

.courier-tag::after {
    content: '';
    position: absolute;
    left: 50%;
    top: 100%;
    transform: translate(-50%, 0);
    width: 0;
    height: 0;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-top: 8px solid #4285F4;
}

.courier-tag .info {
    display: none;
    margin-top: 5px;
}

.courier-tag .info div {
    margin-bottom: 5px;
}

.courier-tag .info div:last-child {
    margin-bottom: 0;
}

.courier-tag.highlight .info {
    display: block;
}
</style>