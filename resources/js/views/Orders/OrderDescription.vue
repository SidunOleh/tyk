<template>
    <a-descriptions 
        style="margin-top: 10px;"
        size="small"
        bordered
        :column="1">
        <a-descriptions-item label="Тип">
            {{ order.type }} 
        </a-descriptions-item>

        <a-descriptions-item label="Статус">
            <a-tag :color="orderStatusColor(order.status)">
                {{ order.status }}
            </a-tag>
        </a-descriptions-item>

        <template v-if="order.type == 'Доставка їжі'">
            <a-descriptions-item label="Замовлення">
                {{ order.order_items.map(orderItem => `${orderItem.name} x ${orderItem.quantity}`).join(' | ') }}
            </a-descriptions-item>

            <a-descriptions-item label="Куди">
                {{ order.details.food_to.map(address => address.address).join(' | ') }}
            </a-descriptions-item>
        </template>

        <template v-if="order.type == 'Кур\'єр'">
            <a-descriptions-item label="Тип доставки">
                {{ order.details.shipping_type }}
            </a-descriptions-item>
            <a-descriptions-item label="Звідки">
                {{ order.details.shipping_from.address  }}
            </a-descriptions-item>
            <a-descriptions-item label="Куди">
                {{ order.details.shipping_to.map(address => address.address).join(' | ') }}
            </a-descriptions-item>
        </template>

        <template v-if="order.type == 'Таксі'">
            <a-descriptions-item label="Звідки">
                {{ order.details.taxi_from.address }}
            </a-descriptions-item>
            <a-descriptions-item label="Куди">
                {{ order.details.taxi_to.map(address => address.address).join(' | ') }}
            </a-descriptions-item>
        </template>

        <a-descriptions-item label="Клієнт">
            {{ order.client.full_name ? order.client.full_name : order.client.phone  }}
        </a-descriptions-item>
        <a-descriptions-item label="Час">
            {{ formatDate(order.time) }}
        </a-descriptions-item>
        <a-descriptions-item label="Тривалість">
            {{ order.duration }} хв.
        </a-descriptions-item>
        <a-descriptions-item label="Проміжна сума">
            {{ formatPrice(order.subtotal) }}
        </a-descriptions-item>
        <a-descriptions-item label="Сума доставки">
            {{ formatPrice(order.shipping_price) }}
        </a-descriptions-item>
        <a-descriptions-item label="Додаткові витрати">
            {{ formatPrice(order.additional_costs) }}
        </a-descriptions-item>      
        <a-descriptions-item label="Бонуси">
            {{ formatPrice(order.bonuses) }}
        </a-descriptions-item>  
        <a-descriptions-item label="Повна сума">
            {{ formatPrice(order.total) }}
        </a-descriptions-item>
        <a-descriptions-item label="Оплачено">
            {{ order.paid ? 'Так' : 'Ні' }}
        </a-descriptions-item>  
        <a-descriptions-item label="Метод оплати">
            {{ order.payment_method }}
        </a-descriptions-item>    
        <a-descriptions-item label="Нотатки">
            <div v-html="order.notes"></div>
        </a-descriptions-item>  
        <a-descriptions-item label="Джерело">
            {{ formatSource(order.source) }}
        </a-descriptions-item>          
    </a-descriptions>
</template>

<script>
import { 
    formatPrice,
    formatDate,
    orderStatusColor,
    formatSource,
} from '../../helpers/helpers'

export default {
    props: [
        'order',
    ],
    methods: {
        formatPrice,
        formatDate,
        orderStatusColor,
        formatSource,
    },
}
</script>
