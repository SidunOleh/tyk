<template>
    <a-list
        style="margin-bottom: 15px;"
        size="small"
        item-layout="horizontal"
        :data-source="orders"
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
            <a-list-item style="padding: 10px 0;">
                <a-list-item-meta>
                    <template #title>
                        <a-flex :gap="5">
                            {{ new Date(item.created_at).toLocaleDateString('uk-UA', {day: 'numeric', month: 'long', year:'numeric',}) }}
                            <a-tag 
                                style="margin: 0;"
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
                        </a-flex>
                    </template>

                    <template #description>
                        <a-flex
                            v-if="item.type == 'Доставка їжі'"
                            :wrap="'wrap'"
                            :gap="5">
                            <span>Сума: <a-typography-text strong>{{ formatPrice(item.total) }}</a-typography-text></span>
                            <span>Продукти: <a-typography-text strong>{{ item.order_items.map(item => `${item.name} x ${item.quantity}`).join(', ') }}</a-typography-text></span>
                            <span>Адреса: <a-typography-text strong>{{ item.details.to }}</a-typography-text></span>
                        </a-flex>

                        <a-flex
                            v-if="item.type == 'Кур\'єр'"
                            :wrap="'wrap'"
                            :gap="5">
                            <span>Сума: <a-typography-text strong>{{ formatPrice(item.total) }}</a-typography-text></span>
                            <span>Звідки: <a-typography-text strong>{{ item.details.from }}</a-typography-text></span>
                            <span>Куди: <a-typography-text strong>{{ item.details.to.join(', ') }}</a-typography-text></span>
                        </a-flex>

                        <a-flex
                            v-if="item.type == 'Таксі'"
                            :wrap="'wrap'"
                            :gap="5">
                            <span>Сума: <a-typography-text strong>{{ formatPrice(item.total) }}</a-typography-text></span>
                            <span>Звідки: <a-typography-text strong>{{ item.details.from }}</a-typography-text></span>
                            <span>Куди: <a-typography-text strong>{{ item.details.to.join(', ') }}</a-typography-text></span>
                        </a-flex>

                        <a-flex 
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
    </a-list>
</template>

<script>
import {
    formatPrice,
    serviceColor,
    orderStatusColor,
} from '../../../helpers/helpers'

export default {
    props: [
        'orders',
    ],
    data() {
        return {
            show: true,
        }
    },
    methods: {
        formatPrice,
        serviceColor,
        orderStatusColor,
    },
}
</script>