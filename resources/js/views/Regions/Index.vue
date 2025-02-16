<template>
    <a-spin :spinning="loading">
        <a-button 
            v-if="! draw.on"
            style="margin-bottom: 15px;"
            type="primary"
            @click="onDraw">
            Створити область
        </a-button>

        <a-button 
            v-if="draw.on"
            style="margin-bottom: 15px;"
            danger
            @click="offDraw">
            Відмінити
        </a-button>
        
        <div 
            style="height: calc(100vh - 145px);"
            id="regions-map"></div>
    </a-spin>

    <Modal
        v-if="create.open"
        title="Створення області"
        action="create"
        :points="create.points"
        :tariffs="tariffs"
        v-model:open="create.open"
        @create="fetchRegions"/>

    <Modal
        v-if="edit.open"
        title="Редагування області"
        action="edit"
        :tariffs="tariffs"
        :item="edit.record"
        v-model:open="edit.open"
        @edit="fetchRegions"
        @delete="fetchRegions"/>
</template>

<script>
import { message } from 'ant-design-vue'
import api from '../../api/regions'
import tariffsApi from '../../api/tariffs'
import Modal from './Modal.vue'
import { toRaw } from 'vue'

export default {
    components: {
        Modal,
    },
    data() {
        return {
            map: null,
            regions: [],
            polygons: [],
            tariffs: [],
            draw: {
                on: false,
                manager: null,
            },
            create: {
                open: false,
                points: [],
            },
            edit: {
                open: false,
                record: null,
            },
            loading: false,
        }
    },
    methods: {
        async fetchRegions() {
            try {
                this.loading = true
                this.regions = await api.all()
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        async fetchTariffs() {
            try {
                this.tariffs = await tariffsApi.all()
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        renderPolygons() {
            this.polygons.forEach(polygon => toRaw(polygon).setMap(null))

            this.regions.forEach((region, i) => {                
                const polygon = new google.maps.Polygon({
                    paths: region.points.map(point => new google.maps.LatLng(point['lat'], point['lng'])),
                    strokeColor: region.tariff.color,
                    strokeOpacity: 0.8,
                    fillColor: region.tariff.color,
                    fillOpacity: 0.4,
                    editable: true,
                    index: i,
                })

                polygon.setMap(this.map)
                
                google.maps.event.addListener(
                    polygon.getPath(), 'insert_at', () => this.changeRegionPointsBasedOnPolygon(polygon)
                )
                google.maps.event.addListener(
                    polygon.getPath(), 'set_at', () => this.changeRegionPointsBasedOnPolygon(polygon)
                )
                google.maps.event.addListener(
                    polygon, 'click', () => this.openEditRegion(this.regions[i])
                )

                this.polygons.push(polygon)
            })
        },
        changeRegionPointsBasedOnPolygon(polygon) {
            const points = []
            polygon.getPath().getArray().forEach(point => points.push({
                lat: point.lat(),
                lng: point.lng()
            }))
            this.regions[polygon.index].points = points
            this.editRegion(this.regions[polygon.index])
        },
        async editRegion(region) {
            try {
                await api.edit(region.id, {
                    points: region.points,
                    tariff_id: region.tariff.id,
                })
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        openEditRegion(region) {
            this.edit.record = region
            this.edit.open = true
        },
        onDraw() {
            this.draw.on = true

            if (! this.draw.manager) {
                this.draw.manager = this.createDrawManager()
            }

            this.draw.manager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON)
            this.draw.manager.setMap(this.map)
        },
        createDrawManager() {
            const manager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [google.maps.drawing.OverlayType.POLYGON]
                },
                polygonOptions: {
                    editable: true
                },
            })

            google.maps.event.addListener(manager, 'overlaycomplete', e => this.handleOverlayComplete(e.overlay))

            return manager
        },
        handleOverlayComplete(overlay) {
            this.create.points = []
            overlay.getPath().getArray().forEach(point => this.create.points.push({
                lat: point.lat(),
                lng: point.lng()
            }))
            overlay.setMap(null)
            this.offDraw()
            this.create.open = true
        },
        offDraw() {
            this.draw.on = false
            toRaw(this.draw.manager).setMap(null)
        },
    },
    watch: {
        regions: {
            handler(regions) {
                this.renderPolygons()
            },
            deep: true,
        },
    },
    mounted() {
        this.fetchRegions()
        this.fetchTariffs()

        this.map = new google.maps.Map(
            document.getElementById('regions-map'), {
            center: { 
                lat: 49.8094, 
                lng: 24.9014, 
            },
            zoom: 13,
            disableDefaultUI: true,
        })
    },
}
</script>
