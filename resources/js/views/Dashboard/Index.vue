<template>
    <a-flex 
        :gap="10"
        :align="'center'">
        <a-range-picker 
            v-model:value="time"
            format="YYYY-MM-DD"
            valueFormat="YYYY-MM-DD"/>

        <a-button 
            v-if="component == 'Kanban'"
            @click="component = 'Timeline'">
            <FieldTimeOutlined/>
        </a-button>
        <a-button 
            v-if="component == 'Timeline'"
            @click="component = 'Kanban'">
            <ShoppingOutlined/>
        </a-button>
        <a-button @click="create.open = true">
            <PlusOutlined/>
        </a-button>
        <a-button @click="map.open = true">
            <EnvironmentOutlined />
        </a-button>
    </a-flex>

    <a-spin :spinning="loading">
        <div style="margin-top: 20px; overflow: auto;">
            <component
                :is="component"
                :time="time"
                :orders="orders"
                :couriers="couriers"
                @edit="order => {edit.record = order; edit.open = true;}"/>
        </div>
    </a-spin>

    <Modal
        v-if="edit.open"
        title="Редагування замовлення"
        v-model:open="edit.open"
        action="edit"
        :item="edit.record"
        @edit="order => orders = orders.map(item => item.id == order.id ? order : item)"/>

    <Modal
        v-if="create.open"
        title="Створення замовлення"
        action="create"
        v-model:open="create.open"/>

    <MapModal
        v-if="map.open"
        title="Місцезнаходження кур'єрів"
        :locations="locations"
        v-model:open="map.open"/>
</template>

<script>
import Kanban from './Kanban.vue'
import Timeline from './Timeline.vue'
import { 
    FieldTimeOutlined,
    ShoppingOutlined,
    PlusOutlined,
    EnvironmentOutlined,
} from '@ant-design/icons-vue'
import { message } from 'ant-design-vue'
import ordersApi from '../../api/orders'
import couriersApi from '../../api/couriers'
import Modal from '../Orders/Modal/Modal.vue'
import newOrderAudio from '../../../audio/new-order.mp3'
import MapModal from './MapModal.vue'

export default {
    components: {
        Kanban,
        Timeline,
        FieldTimeOutlined,
        ShoppingOutlined,
        Modal,
        PlusOutlined,
        EnvironmentOutlined,
        MapModal,
    },
    data() {
        return {
            time: null,
            orders: [],
            couriers: [],
            locations: [],
            component: 'Kanban',
            edit: {
                open: false,
                record: null,
            },
            create: {
                open: false,
            },
            map: {
                open: false,
            },
            interval: null,
            loading: false,
        }
    },
    methods: {
        setTime() {
            const start = new Date()

            const end = new Date()
            end.setDate(end.getDate())

            const format = d => `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2, 0)}-${String(d.getDate()).padStart(2, 0)}`

            this.time = [
                format(start),
                format(end),
            ]
        },
        async fetchOrders(withLoading = true, alert = false) {
            try {
                this.loading = withLoading
                const orders = await ordersApi.fetchBetween(this.time[0], this.time[1])

                if (alert && this.hasNew(orders)) {
                    new Audio(newOrderAudio).play()
                    message.info('Нове замовлення')
                }
                
                this.setOrders(orders)
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        setOrders(orders) {
            const newOrders = orders.map(order => {
                const index = this.orders.findIndex(item => item.id == order.id)
                if (index == -1) {
                    return order
                } else {
                    return this.orders[index]
                }
            })

            this.orders = newOrders
        },
        hasNew(orders) {
            return orders.some(order => ! this.orders.some(item => item.id == order.id))
        },
        async fetchCouriers() {
            try {
                this.couriers = await couriersApi.all()
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        async fetchCouriersCurrentLocations() {
            try {
                // this.locations = await couriersApi.currentLocations()
                this.locations = [{
                    first_name: 'Іван',
                    last_name: 'Ганапольський',
                    car: 'Dacia біла Sandero',
                    state: 'Стоїть',
                    lat: 49.8094, 
                    lng: 24.9014,
                }, {
                    first_name: 'Петро',
                    last_name: 'Ганапольський',
                    car: 'Dacia біла Sandero',
                    state: 'Стоїть',
                    lat: 49.8195, 
                    lng: 24.9014,
                }]
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
    },
    watch: {
        time(time) {
            if (time) {
                this.fetchOrders()
            }   
        },
    },
    mounted() {
        this.setTime()
        this.fetchCouriers()
        this.fetchCouriersCurrentLocations()

        this.interval = setInterval(() => {
            if (this.time) {
                this.fetchOrders(false, true)
            }
        }, 10 * 1000)
    },
    unmounted() {
        clearInterval(this.interval)
    },
}
</script>