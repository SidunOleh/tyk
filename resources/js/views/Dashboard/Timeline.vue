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
            const resources = this.couriers.map(courier => {
                return {
                    title: `${courier.first_name} ${courier.last_name}`,
                    id: courier.id,
                }
            })
            
            resources.unshift({
                title: {html: '<b>потребує кур\'єра</b>'},
                id: null,
            })

            return resources
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
            event.title = {html: this.eventHtml(order)}
            event.resourceIds = [order.courier?.id ?? null]
            event.color = orderStatusColor(order.status)
            event.extendedProps = {order}
            return event
        },
        async changeCourier(orderId, courierId) {
            try {
                const order = this.orders[
                    this.orders.findIndex(order => order.id == orderId)
                ]
                order.courier = this.couriers[
                    this.couriers.findIndex(courier => courier.id == courierId)
                ]
                
                await api.changeCourier(orderId, courierId)

                this.$emit('changeCourier')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        async changeTime(orderId, start, end) {
            try {
                const time = `${start.getFullYear()}-${String(start.getMonth()+1).padStart(2, 0)}-${String(start.getDate()).padStart(2, 0)} ${String(start.getHours()).padStart(2, 0)}:${String(start.getMinutes()).padStart(2, 0)}:${String(start.getSeconds()).padStart(2, 0)}`
                const duration = Math.floor((Math.abs(end - start)/1000)/60)
                
                const order = this.orders[
                    this.orders.findIndex(order => order.id == orderId)
                ]
                order.time = time
                order.duration = duration

                await api.changeTime(orderId, time, duration)

                this.$emit('changeTime')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        eventHtml(order) {
            if (order.type == 'Доставка їжі') {
                return this.foodShippingHtml(order)
            }

            if (order.type == 'Кур\'єр') {
                return this.shippingHtml(order)
            }

            if (order.type == 'Таксі') {
                return this.taxiHtml(order)
            }
        },
        foodShippingHtml(order) {
            return `
            <div>
                <b>${order.type} ${order.number}</b>
                <br> 
                <br> 
                <b>Час приготування:</b> ${this.formatCookingTime(order.details.cooking_time)}
                <br>
                <b>Куди:</b> ${order.details.food_to.map(item => item.address).join(' | ')}
                <br>
                ${order.notes?.replace(/\n/g, '<br/>') ?? ''}
            </div>`
        },
        shippingHtml(order) {
            return `
            <div>
                <b>${order.type} ${order.number}</b>
                <br>
                <br>
                <b>Звідки:</b> ${order.details.shipping_from.address}
                <br>
                <b>Куди:</b> ${order.details.shipping_to.map(item => item.address).join(' | ')}
                <b>
                ${order.notes?.replace(/\n/g, '<br/>') ?? ''}
            </div>`
        },
        taxiHtml(order) {
            return `
            <div>
                <b>${order.type} ${order.number}</b>
                <br>
                <br>
                <b>Звідки:</b> ${order.details.taxi_from.address}
                <br>
                <b>Куди:</b> ${order.details.taxi_to.map(item => item.address).join(' | ')}
                <b>
                ${order.notes?.replace(/\n/g, '<br/>') ?? ''}
            </div>`
        },
        formatCookingTime(time) {
            const date = new Date(time)

            return `${String(date.getHours()).padStart(2, 0)}:${String(date.getMinutes()).padStart(2, 0)}`
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
            view: 'resourceTimeGridDay',
            headerToolbar: {
                start: '',
                center: '',
                end: '',
            },
            resources: this.resources,
            date: new Date(),
            scrollTime: `${new Date().getHours()}:00`,
            duration: {
                days: 1
            },
            allDaySlot: false,
            selectable: false,
            pointer: false,
            locale: 'uk-UA',
            slotHeight: 150,
            slotDuration: '00:30:00',
            nowIndicator: true,
            eventDrop: info => {
                this.changeTime(info.event.id, new Date(info.event.start), new Date(info.event.end))

                const courierId = info.event.resourceIds[0] != 'null' 
                    ? info.event.resourceIds[0] 
                    : null
                this.changeCourier(info.event.id, courierId)
            },
            eventResize: info => {
                this.changeTime(info.event.id, new Date(info.event.start), new Date(info.event.end))
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
#timeline {
    position: relative;
    z-index: 0;
}

#timeline .ec-body {
    height: calc(100vh - 178px); 
}

.ec-toolbar {
    display: none !important;
}

.ec-time-grid .ec-content .ec-time, .ec-time-grid .ec-line {
    height: 150px !important;
}

.ec-timeline .ec-event-body {
    flex-direction: column !important;
}

.ec-day {
    position: relative;
}
</style>