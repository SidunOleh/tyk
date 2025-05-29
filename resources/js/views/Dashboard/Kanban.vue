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
                    if (!order.reviewed) {
                        this.$emit('review', order)
                    }
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
                    ${order.reviewed ? '' : '<span class="not-reviewed"></span>'}<b>${order.type}</b> <b>№${order.number}</b> ${formatDate(order.created_at, false)} ${order.callback ? '📞' : ''}
                </div>
                <br>
                <div>
                    Сума: <b>${formatPrice(order.total)}</b>
                    Продути: <b>${order.order_items?.map(item => `${item.product?.categories?.find(category => category.parent_id === null)?.name} x ${item.quantity}`).join(' | ')}</b>
                    Адреса: <b>${order.details.food_to.map(address => address.address).join(' | ')}</b>
                </div>
            `
        },
        shippingElHtml(order) {
            return `
                <div>
                    ${order.reviewed ? '' : '<span class="not-reviewed"></span>'}<b>${order.type}</b> <b>№${order.number}</b> ${formatDate(order.created_at, false)} ${order.callback ? '📞' : ''}
                </div>
                <br>
                <div>
                    Сума: <b>${formatPrice(order.total)}</b>
                    Звідки: <b>${order.details.shipping_from.address}</b>
                    Куди: <b>${order.details.shipping_to.map(address => address.address).join(' | ')}</b>
                </div>
            `
        },
        taxiElHtml(order) {
            return `
                <div>
                    ${order.reviewed ? '' : '<span class="not-reviewed"></span>'}<b>${order.type}</b> <b>№${order.number}</b> ${formatDate(order.created_at, false)} ${order.callback ? '📞' : ''}
                </div>
                <br>
                <div>
                    Сума: <b>${formatPrice(order.total)}</b>
                    Звідки: <b>${order.details.taxi_from.address}</b>
                    Куди: <b>${order.details.taxi_to.map(address => address.address).join(' | ')}</b>
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

.not-reviewed {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #90ea37;
    margin-right: 7px;
    animation: pulse-animation 2s infinite;
}

@keyframes pulse-animation {
  0% {
    box-shadow: 0 0 0 0px rgba(0, 0, 0, 0.2);
  }
  100% {
    box-shadow: 0 0 0 7px rgba(0, 0, 0, 0);
  }
}

</style>