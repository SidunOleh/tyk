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
        'locations',
    ],
    data() {
        return {
            markers: [],
        }
    },  
    methods: {
        async showOnMap() {
            this.markers.forEach(marker => marker.setMap(null))

            const { AdvancedMarkerElement } = 
                await google.maps.importLibrary('marker')

            for (const location of this.locations) {
                const marker = new AdvancedMarkerElement({
                    map: this.map,
                    position: { 
                        lat: location.lat, 
                        lng: location.lng,
                    },
                    content: this.createMarkerEl(location),
                })
                marker.addListener('click', () => {
                    marker.content.classList.toggle('highlight')
                })
                this.markers.push(marker)   
            }
        },
        createMarkerEl(location) {
            const el = document.createElement('div')
            el.className = 'courier-tag'
            el.innerHTML = `
                <div class="title">
                    🏃🏼‍♂️ ${location.first_name} ${location.last_name}
                </div>
                <div class="info">
                    <div>🚖 ${location.car}</div>
                    <div>🅿️ ${location.state}</div>
                </div>
            `

            return el
        },
    },
    watch: {
        locations() {
            this.showOnMap()
        },
    },
    mounted() {
        this.map = new google.maps.Map(
            document.getElementById('couriers-map'), {
            center: { 
                lat: 49.8094, 
                lng: 24.9014, 
            },
            zoom: 13,
            mapId: '1',
        })
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