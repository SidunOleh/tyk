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
                title: 'потребує кур\'єра',
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
            event.title = {html: `${order.type} №${order.number} ${formatPrice(order.total)}`}
            event.resourceIds = [order.courier?.id ?? null]
            event.color = orderStatusColor(order.status)
            event.extendedProps = {order}
            return event
        },
        async changeCourier(orderId, courierId) {
            try {
                this.orders[
                    this.orders.findIndex(order => order.id == orderId)
                ].courier = this.couriers[
                    this.couriers.findIndex(courier => courier.id == courierId)
                ]
                await api.changeCourier(orderId, courierId)
                this.$emit('changeCourier')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        renderCurrentLine() {
            const offset = (new Date().getHours() * 60 + new Date().getMinutes()) / (24 * 60) * 100
            const currentLineEl = document.createElement('div')
            currentLineEl.classList.add('current')
            currentLineEl.style.left = `${offset}%`
            for (const todayEl of document.querySelectorAll('.ec-today')) {
                if (todayEl.querySelector('.current')) {
                    todayEl.querySelector('.current').replaceWith(currentLineEl.cloneNode())
                } else {
                    todayEl.append(currentLineEl.cloneNode())   
                }
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
            scrollTime: `${new Date().getHours()}:00`,
            duration: {
                days: 1
            },
            allDaySlot: false,
            selectable: false,
            pointer: false,
            locale: 'uk-UA',
            slotWidth: 150,
            slotDuration: '00:30:00',
            nowIndicator: true,
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

        this.renderCurrentLine()
        setInterval(() => this.renderCurrentLine(), 1000)
    }
}
</script>

<style>
.ec-toolbar {
    display: none !important;
}

.ec-timeline .ec-time, .ec-timeline .ec-line {
  width: 150px !important;
}

.ec-timeline .ec-event-body {
    flex-direction: column !important;
}

.ec-day {
    position: relative;
}

.ec-today .current {
    position: absolute;
    top: 0;
    left: 0;
    height: calc(100% + 1px);
    width: 1px;
    background: rgb(22 119 255);
    transition: all linear 1s;
    z-index: 10;
}

.ec-days:last-child .ec-today .current {
    height: 100%;
}

.ec-days:nth-child(2) .ec-today .current::before {
    content: '';
    position: absolute;
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: rgb(22 119 255);
    top: 0;
    right: -195%;
}
</style>