<template>
    <a-list
        style="margin-bottom: 15px;"
        size="small"
        item-layout="horizontal"
        :data-source="ordersToShow"
        :locale="{emptyText: 'Немає замовлень'}">  
        <template #header>
            <a-flex
                :gap="5"
                :justify="'space-between'">
                <a-typography-text strong>
                    Історія замовлень
                </a-typography-text>
                <a-typography-link 
                    v-if="show"
                    @click="show = false">
                    Приховати
                </a-typography-link>
                <a-typography-link
                    v-if="! show"
                    @click="show = true">
                    Показати
                </a-typography-link>
            </a-flex>
        </template>

        <template 
            v-if="show"
            #renderItem="{ item }">
            <a-list-item 
                :class="{current: current == item.id}"
                style="padding: 10px 5px;">
                <a-list-item-meta>
                    <template #title>
                        <a-flex>
                            {{ formatDate(item.created_at, false) }}
                            <a-tag 
                                style="margin-left: 10px;"
                                :color="serviceColor(item.type)">
                                <template v-if="item.type == 'Доставка їжі'">
                                    {{ 'Ї' }}
                                </template>
                                <template v-if="item.type == 'Кур\'єр'">
                                    {{ 'К' }}
                                </template>
                                <template v-if="item.type == 'Таксі'">
                                    {{ 'Т' }}
                                </template>
                            </a-tag>
                            <a-tag :color="orderStatusColor(item.status)">
                                {{ item.status }}
                            </a-tag>
                            <a-tag>
                                {{ item.paid ? 'Оплачено' : 'Не оплачено' }}
                            </a-tag>
                        </a-flex>
                    </template>

                    <template #description>
                        <a-flex
                            :wrap="'wrap'"
                            :gap="5">
                            <template v-if="item.type == 'Доставка їжі'">
                                <div>Сума: <a-typography-text strong>{{ formatPrice(item.total) }}</a-typography-text></div>
                                <div>Продукти: <a-typography-text strong>{{ item.order_items?.map(item => `${item.name} x ${item.quantity}`).join(' | ') }}</a-typography-text></div>
                                <div>Адреса: <a-typography-text strong>{{ item.details.food_to.map(address => address.address).join(' | ') }}</a-typography-text></div>
                            </template>

                            <template v-if="item.type == 'Кур\'єр'">
                                <div>Сума: <a-typography-text strong>{{ formatPrice(item.total) }}</a-typography-text></div>
                                <div>Звідки: <a-typography-text strong>{{ item.details.shipping_from.address }}</a-typography-text></div>
                                <div>Куди: <a-typography-text strong>{{ item.details.shipping_to.map(address => address.address).join(' | ') }}</a-typography-text></div>
                            </template>
                            
                            <template v-if="item.type == 'Таксі'">
                                <div>Сума: <a-typography-text strong>{{ formatPrice(item.total) }}</a-typography-text></div>
                                <div>Звідки: <a-typography-text strong>{{ item.details.taxi_from.address }}</a-typography-text></div>
                                <div>Куди: <a-typography-text strong>{{ item.details.taxi_to.map(address => address.address).join(' | ') }}</a-typography-text></div>
                            </template>
                        </a-flex>

                        <a-flex
                            v-if="! current || current != item.id" 
                            style="margin-top: 10px;"
                            :gap="5">
                            <a-typography-link @click="$emit('repeat', item)">
                                Повторити
                            </a-typography-link>
                        </a-flex>
                    </template>
                </a-list-item-meta>
            </a-list-item>
        </template>

        <a-flex 
            v-if="show && orders.length > 3"
            :justify="'center'">
            <a-typography-link
                v-if="! showAll"
                @click="showAll = true">
                Показати всі замовлення
            </a-typography-link>

            <a-typography-link
                v-if="showAll"
                @click="showAll = false">
                Приховати всі замовлення
            </a-typography-link>
        </a-flex>
    </a-list>
</template>

<script>
import {
    formatPrice,
    serviceColor,
    orderStatusColor,
    formatDate,
} from '../../../helpers/helpers'

export default {
    props: [
        'orders',
        'current',
    ],
    data() {
        return {
            show: true,
            showAll: false,
        }
    },
    computed: {
        ordersToShow() {
            return this.showAll ? this.orders : this.orders.slice(0, 3)
        },
    },
    methods: {
        formatPrice,
        serviceColor,
        orderStatusColor,
        formatDate,
    },
}
</script>

<style scoped>
.current {
    background: #353a3a0a;
}
</style>
