<template>
    <a-table
        :columns="columns"
        :dataSource="data"
        :pagination="false"
        :bordered="true">

        <template #expandedRowRender="{ record }">
            <a-descriptions 
                style="margin-top: 10px;"
                size="small"
                bordered
                :column="1">
                <a-descriptions-item label="Тип">
                    {{ record.type }} 
                </a-descriptions-item>

                <a-descriptions-item label="Статус">
                    <a-tag :color="orderStatusColor(record.status)">
                        {{ record.status }}
                    </a-tag>
                </a-descriptions-item>

                <template v-if="record.type == 'Доставка їжі'">
                    <a-descriptions-item label="Замовлення">
                        {{ record.order_items.map(item => `${item.name} x ${item.quantity}`).join(', ') }}
                    </a-descriptions-item>

                    <a-descriptions-item label="Куди">
                        {{ record.details.food_to }}
                    </a-descriptions-item>
                </template>

                <template v-if="record.type == 'Кур\'єр'">
                    <a-descriptions-item label="Тип доставки">
                        {{ record.details.shipping_type }}
                    </a-descriptions-item>
                    <a-descriptions-item label="Звідки">
                        {{ record.details.shipping_from }}
                    </a-descriptions-item>
                    <a-descriptions-item label="Куди">
                        {{ record.details.shipping_to.join(', ') }}
                    </a-descriptions-item>
                </template>

                <template v-if="record.type == 'Таксі'">
                    <a-descriptions-item label="Звідки">
                        {{ record.details.taxi_from }}
                    </a-descriptions-item>
                    <a-descriptions-item label="Куди">
                        {{ record.details.taxi_to.join(', ') }}
                    </a-descriptions-item>
                </template>

                <a-descriptions-item label="Клієнт">
                    {{ record.client?.first_name + ' ' + (record.client?.last_name ?? '') }}
                </a-descriptions-item>
                <a-descriptions-item label="Час">
                    {{ formatDate(record.time) }}
                </a-descriptions-item>
                <a-descriptions-item label="Тривалість">
                    {{ record.duration }} хв.
                </a-descriptions-item>
                <a-descriptions-item label="Проміжна сума">
                    {{ formatPrice(record.subtotal) }}
                </a-descriptions-item>
                <a-descriptions-item label="Сума доставки">
                    {{ formatPrice(record.shipping_price) }}
                </a-descriptions-item>
                <a-descriptions-item label="Додаткові витрати">
                    {{ formatPrice(record.additional_costs) }}
                </a-descriptions-item>      
                <a-descriptions-item label="Бонуси">
                    {{ formatPrice(record.bonuses) }}
                </a-descriptions-item>  
                <a-descriptions-item label="Повна сума">
                    {{ formatPrice(record.total) }}
                </a-descriptions-item>
                <a-descriptions-item label="Сплачено">
                    {{ record.payed ? 'Так' : 'Ні' }}
                </a-descriptions-item>  
                <a-descriptions-item label="Метод оплати">
                    {{ record.payment_method }}
                </a-descriptions-item>    
                <a-descriptions-item label="Нотатки">
                    <div v-html="record.notes"></div>
                </a-descriptions-item>          
            </a-descriptions>
        </template>

        <template #bodyCell="{column, record}">

            <template v-if="column.key === 'type'">
                {{ record.type }}
            </template>

            <template v-if="column.key === 'total'">
                {{ formatPrice(record.total) }}
            </template>

            <template v-if="column.key === 'time'">
                {{ formatDate(record.time) }}
            </template>

            <template v-if="column.key === 'status'">
                <a-tag :color="orderStatusColor(record.status)">
                    {{ record.status }}
                </a-tag>
            </template>

            <template v-if="column.key === 'payed'">
                {{ record.payed ? 'Так' : 'Ні' }}
            </template>

            <template v-if="column.key === 'created_at'">
                {{ formatDate(record.created_at) }}
            </template>

            <template v-if="column.key === 'actions'">
                <a-dropdown>
                    <a 
                        class="ant-dropdown-link" 
                        @click.prevent>
                        Дії
                        <DownOutlined/>
                    </a>
                    <template #overlay>
                        <a-menu>
                            <a-menu-item @click="history.open = true; history.record = record;">
                                <a href="javascript:;">
                                    Історія
                                </a>
                            </a-menu-item>
                            <a-menu-item @click="edit.open = true; edit.record = record;">
                                <a href="javascript:;">
                                    Редагувати
                                </a>
                            </a-menu-item>
                            <a-menu-item 
                                danger
                                @click="confirmPopup(() => deleteRecord(record), `Ви впевнені що хочете видалити ${record.type}(${formatPrice(record.total)})?`)">
                                <a href="javascript:;">
                                    Видалити
                                </a>
                            </a-menu-item>
                        </a-menu>
                    </template>
                </a-dropdown>
            </template>

        </template>

    </a-table>

    <Modal
        v-if="edit.open"
        title="Редагування замовлення"
        v-model:open="edit.open"
        action="edit"
        :item="edit.record"
        @edit="$emit('edit')"/>
    
    <History
        v-model:open="history.open"
        :history="history.record?.history"/>
</template>

<script>
import { message, } from 'ant-design-vue'
import {
    DownOutlined,
} from '@ant-design/icons-vue'
import api from '../../api/orders'
import { 
    confirmPopup, 
    formatPrice,
    formatDate,
    orderStatusColor,
} from '../../helpers/helpers'
import Modal from '../Orders/Modal/Modal.vue'
import History from '../components/History.vue'

export default {
    props: [
        'data',
    ],
    components: {
        DownOutlined,
        Modal,
        History,
    },
    data() {
        return {
            columns: [
                {
                    title: 'Тип',
                    key: 'type',
                },
                {
                    title: 'Повна сума',
                    key: 'total',
                    sorter: (a, b) => a.total - b.total,
                },
                {
                    title: 'Час',
                    key: 'time',
                },
                {
                    title: 'Статус',
                    key: 'status',
                },
                {
                    title: 'Оплачено',
                    key: 'payed',
                },
                {
                    title: 'Створено',
                    key: 'created_at',
                },
                {
                    key: 'actions',
                    align: 'center',
                },
            ],
            edit: {
                open: false,
                record: null,
            },
            history: {
                open: false,
                record: null,
            },
        }
    },
    methods: {
        confirmPopup,
        formatPrice,
        formatDate,
        orderStatusColor,
        async deleteRecord(record) {
            try {
                await api.delete(record.id)
                message.success('Успішно видалено')
                this.$emit('delete')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
    },
    mounted() {
        this.data.map(item => item.key = item.id)
    },
}
</script>
