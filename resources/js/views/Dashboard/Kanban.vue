<template>
    <div 
        style="min-width: 1200px;"
        id="kanban"></div>
</template>

<script>
import { 
    formatPrice,
    formatDate,
} from '../../helpers/helpers'
import { message } from 'ant-design-vue'
import api from '../../api/orders'

export default {
    props: [
        'orders',
    ],
    data() {
        return {
            kanban: null,
        }
    },
    methods: {
        createKanban() {
            document.querySelector('#kanban').innerHTML = ''
            
            this.kanban = new jKanban({
                element:'#kanban',
                dragBoards: false,
                responsivePercentage: true,
                boards: [
                    {
                        'id' : 'Створено',
                        'title'  : 'Вхідні замовлення',
                        'class': 'created',
                        'item'  : [],
                    },
                    {
                        'id' : 'Готується',
                        'title'  : 'Готується партнером',
                        'class': 'cooking',
                        'item'  : [],
                    },
                    {
                        'id' : 'Доставляється',
                        'title'  : 'Виконується кур\'єром',
                        'class': 'shipping',
                        'item'  : [],
                    },
                    {
                        'id' : 'Виконано',
                        'title'  : 'Виконано',
                        'class': 'done',
                        'item'  : [],
                    },
                    {
                        'id' : 'Скасовано',
                        'title'  : 'Скасовано',
                        'class': 'canceled',
                        'item'  : [],
                    },
                ],
                click: el => {
                    const order = JSON.parse(el.getAttribute('data-data'))
                    this.$emit('edit', order)
                },
                dropEl: (el, target) => {
                    const order = JSON.parse(el.getAttribute('data-data'))
                    const status = target.closest('.kanban-board').getAttribute('data-id')
                    this.changeStatus(order, status)
                },
            })

            this.orders.forEach(order => {
                if (this.kanban.findBoard(order.status)) {
                    this.kanban.addElement(
                        order.status, 
                        this.orderToBoardEl(order)
                    )
                }
            })
        },
        orderToBoardEl(order) {
            return {
                id: order.id,
                title: this.boardElHtml(order),
                data: JSON.stringify(order),
            }
        },
        boardElHtml(order) {
            switch (order.type) {
                case 'Доставка їжі':
                    return this.foodShippingElHtml(order)
                case 'Кур\'єр':
                    return this.shippingElHtml(order)
                case 'Таксі':
                    return this.taxiElHtml(order)
            }
        },
        foodShippingElHtml(order) {
            return `
                <div>
                    ${formatDate(order.created_at, false)} <b>${order.type}</b>
                </div>
                <br>
                <div>
                    Сума: <b>${formatPrice(order.total)}</b>
                    Продути: <b>${order.order_items.map(item => `${item.name} x ${item.quantity}`).join(', ')}</b>
                    Адреса: <b>${order.details.food_to}</b>
                </div>
            `
        },
        shippingElHtml(order) {
            return `
                <div>
                    ${formatDate(order.created_at, false)} <b>${order.type}</b>
                </div>
                <br>
                <div>
                    Сума: <b>${formatPrice(order.total)}</b>
                    Звідки: <b>${order.details.shipping_from}</b>
                    Куди: <b>${order.details.shipping_to.join(', ')}</b>
                </div>
            `
        },
        taxiElHtml(order) {
            return `
                <div>
                    ${formatDate(order.created_at, false)} <b>${order.type}</b>
                </div>
                <br>
                <div>
                    Сума: <b>${formatPrice(order.total)}</b>
                    Звідки: <b>${order.details.taxi_from}</b>
                    Куди: <b>${order.details.taxi_to.join(', ')}</b>
                </div>
            `
        },
        async changeStatus(order, status) {
            try {
                this.orders[
                    this.orders.findIndex(item => item.id == order.id)
                ].status = status
                await api.changeStatus(order.id, status)
                this.$emit('changeStatus')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
    },
    watch: {
        orders: {
            handler() {
                this.createKanban()
            },
            deep: true,
        },
    },
    mounted() {
        this.createKanban()
    }
}
</script>

<style>
.kanban-container div:first-child {
    margin-left: 0px !important;
}

.kanban-container .created {
    background: #65a623;
}

.kanban-container .cooking {
    background: #9ba30094;
}

.kanban-container .shipping {
    background: #f7b7ff;
}

.kanban-container .done {
    background: #8ea6ff;
}

.kanban-container .canceled {
    background: #d31616;
}

.kanban-board-header {
    color: white;
}
</style>