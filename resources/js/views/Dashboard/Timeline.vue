<template>
    <div id="timeline">
    </div>
</template>

<script>
import { message } from 'ant-design-vue'
import api from '../../api/orders'
import { 
    formatPrice,
    orderStatusColor,
} from '../../helpers/helpers'

export default {
    props: [
        'time',
        'orders',
        'couriers',
    ],
    data() {
        return {
            timeline: null,
            data: [],
        }
    },
    computed: {
        resources() {
            return this.couriers.map(courier => {
                return {
                    title: `${courier.first_name} ${courier.last_name}`,
                    id: courier.id,
                }
            }).concat({
                title: 'кур\'єра немає',
                id: null,
            })
        },
    },
    methods: {
        changeDateInterval() {
            this.timeline.setOption('date', new Date(this.time[0] ?? ''))

            this.timeline.setOption('duration', {days: this.time ? this.diffInDays(
                new Date(this.time[0]),
                new Date(this.time[1])
            )+1 : 1})
        }, 
        diffInDays(a, b) {
            return Math.floor(Math.abs(b - a) / (1000 * 60 * 60 * 24))
        },
        changeData() {
            this.data.forEach(order => {
                this.timeline.removeEventById(order.id)
            })
            
            this.data = JSON.parse(JSON.stringify(this.orders))
            
            this.data.forEach(order => {
                this.timeline.addEvent(this.orderToEvent(order))
            })
        },
        orderToEvent(order) {
            const event = {}
            event.id = order.id
            event.start = new Date(order.time)
            event.end = new Date(event.start.getTime() + order.duration * 60000)
            event.title = `${order.type}, ${formatPrice(order.total)}`
            event.resourceIds = [order.courier?.id ?? null]
            event.color = orderStatusColor(order.status)
            event.extendedProps = {order}
            return event
        },
        async changeCourier(orderId, courierId) {
            try {
                const res = await api.changeCourier(orderId, courierId)
                // this.orders[
                //     this.orders.findIndex(order => order.id == orderId)
                // ] = res.order
                this.$emit('changeCourier')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
    },
    watch: {
        time: {
            handler(time) {
                this.changeDateInterval()
            },
            deep: true,
        },
        resources:{
            handler(resources) {
                this.timeline.setOption('resources', resources)
            },
            deep: true,
        },
        orders:{
            handler(orders) {
                this.changeData()
            },
            deep: true,
        },
    },
    mounted() {
        this.timeline = new EventCalendar(document.getElementById('timeline'), {
            view: 'resourceTimelineDay',
            headerToolbar: {
                start: '',
                center: '',
                end: '',
            },
            resources: this.resources,
            date: new Date(),
            duration: {
                days: 1
            },
            allDaySlot: false,
            selectable: false,
            pointer: false,
            locale: 'uk-UA',
            eventDrop: info => {
                info.event.start = info.oldEvent.start
                info.event.end = info.oldEvent.end
                this.timeline.updateEvent(info.event)
                const courierId = info.event.resourceIds[0] != 'null' 
                    ? info.event.resourceIds[0] 
                    : null
                this.changeCourier(info.event.id, courierId)
            },
            eventResize: info => {
                info.event.start = info.oldEvent.start
                info.event.end = info.oldEvent.end
                this.timeline.updateEvent(info.event)
            },
            eventClick: e => {
                this.$emit('edit', e.event.extendedProps.order)
            },
        })

        this.changeDateInterval()
        this.changeData()
    }
}
</script>

<style>
.ec-toolbar {
    display: none !important;
}
</style>