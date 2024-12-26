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
        @edit="fetchOrders"/>
</template>

<script>
import Kanban from './Kanban.vue'
import Timeline from './Timeline.vue'
import { 
    FieldTimeOutlined,
    ShoppingOutlined,
} from '@ant-design/icons-vue'
import { message } from 'ant-design-vue'
import ordersApi from '../../api/orders'
import couriersApi from '../../api/couriers'
import Modal from '../Orders/Modal/Modal.vue'

export default {
    components: {
        Kanban,
        Timeline,
        FieldTimeOutlined,
        ShoppingOutlined,
        Modal,
    },
    data() {
        return {
            time: null,
            orders: [],
            couriers: [],
            component: 'Kanban',
            edit: {
                open: false,
                record: null,
            },
            loading: false,
        }
    },
    methods: {
        setTime() {
            const start = new Date()

            const end = new Date()
            end.setDate(end.getDate() + 1)

            this.time = [
                start.toISOString().split('T')[0],
                end.toISOString().split('T')[0]
            ]
        },
        async fetchOrders() {
            try {
                this.loading = true
                this.orders = await ordersApi.fetchBetween(this.time[0], this.time[1])
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        async fetchCouriers() {
            try {
                this.couriers = await couriersApi.all()
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
    },
}
</script>