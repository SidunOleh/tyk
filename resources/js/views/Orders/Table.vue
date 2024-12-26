<template>

    <a-table
        :columns="columns"
        :dataSource="data.data"
        :pagination="{
            pageSize: query.perpage, 
            total: data.meta?.total, 
            onChange: (page, size) => query.perpage = size
        }"
        :bordered="true"
        :loading="loading"
        :rowSelection="{onChange: (selectedRowKeys, selectedRows) => selected = selectedRows}"
        @change="changeQuery">

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
                <a-descriptions-item label="Оплачено">
                    {{ record.paid ? 'Так' : 'Ні' }}
                </a-descriptions-item>  
                <a-descriptions-item label="Метод оплати">
                    {{ record.payment_method }}
                </a-descriptions-item>    
                <a-descriptions-item label="Нотатки">
                    <div v-html="record.notes"></div>
                </a-descriptions-item>          
            </a-descriptions>
        </template>

        <template #title>
            <a-flex
                :wrap="'wrap'"
                :justify="'space-between'"
                :gap="5">

                <a-flex
                    :wrap="'wrap'" 
                    :gap="5">
                    <a-select 
                        class="bulk-select"
                        placeholder="Масові дії"
                        :options="bulkOptions"
                        v-model:value="bulkAction"/>
                    <a-button @click="doBulk">
                        Застосувати
                    </a-button>
                </a-flex>

                <a-input-search
                    style="display: block; max-width: 400px;"
                    placeholder="Пошук"
                    v-model:value="query.s"
                    @search="updateData"/>
            </a-flex>
        </template>

        <template #footer>
            <a-flex
                :wrap="'wrap'" 
                :gap="5">
                <a-select 
                    class="bulk-select"
                    placeholder="Масові дії"
                    :options="bulkOptions"
                    v-model:value="bulkAction"/>
                <a-button 
                    @click="doBulk">
                    Застосувати
                </a-button>
            </a-flex>
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

            <template v-if="column.key === 'paid'">
                {{ record.paid ? 'Так' : 'Ні' }}
            </template>

            <template v-if="column.key === 'client'">
                {{ record.client ? record.client?.first_name + ' ' + (record.client?.last_name ?? '') : '' }}
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
                            <a-menu-item @click="$emit('history', record)">
                                <a href="javascript:;">
                                    Історія
                                </a>
                            </a-menu-item>
                            <a-menu-item @click="$emit('edit', record)">
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

export default {
    components: {
        DownOutlined,
    },
    data() {
        return {
            columns: [
                {
                    title: 'Тип',
                    key: 'type',
                    filters: [
                        {
                            text: 'Доставка їжі',
                            value: 'Доставка їжі',
                        },
                        {
                            text: 'Кур\'єр',
                            value: 'Кур\'єр',
                        },
                        {
                            text: 'Таксі',
                            value: 'Таксі',
                        },
                    ],
                },
                {
                    title: 'Повна сума',
                    key: 'total',
                    sorter: true,
                },
                {
                    title: 'Час',
                    key: 'time',
                    sorter: true,
                },
                {
                    title: 'Статус',
                    key: 'status',
                    filters: [
                        {
                            text: 'Створено',
                            value: 'Створено',
                        },
                        {
                            text: 'Готується',
                            value: 'Готується',
                        },
                        {
                            text: 'Доставляється',
                            value: 'Доставляється',
                        },
                        {
                            text: 'Виконано',
                            value: 'Виконано',
                        },
                    ],
                },
                {
                    title: 'Оплачено',
                    key: 'paid',
                    filters: [
                        {
                            text: 'Так',
                            value: true,
                        },
                        {
                            text: 'Ні',
                            value: false,
                        },
                    ],
                },
                {
                    title: 'Клієнт',
                    key: 'client',
                },
                {
                    title: 'Створено',
                    key: 'created_at',
                    sorter: true,
                },
                {
                    key: 'actions',
                    align: 'center',
                },
            ],
            data: {},
            bulkOptions: [
                {
                    label: 'Видалити',
                    value: 'delete',
                },
            ],
            bulkAction: null,
            selected: [],
            data: {},
            query: {
                page: 1,
                perpage: 15,
                orderby: 'created_at',
                order: 'DESC',
                s: '',
                filters: {},
            },
            loading: false,
        }
    },
    methods: {
        confirmPopup,
        formatPrice,
        formatDate,
        orderStatusColor,
        async updateData() {
            try {
                this.loading = true
                this.data = await api.fetch(this.query) 
                this.data.data.map(item => item.key = item.id)
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        changeQuery(pagination, filters, sorter) {
            this.query.page = pagination.current
    
            this.query.filters = filters

            if (sorter.columnKey) {
                this.query.orderby = sorter.columnKey
            }
            
            if (sorter.order) {
                this.query.order = sorter.order
                    .replace('ascend', 'ASC')
                    .replace('descend', 'DESC')
            }
        },
        async deleteRecord(record) {
            try {
                await api.delete(record.id)
                message.success('Успішно видалено')
                this.updateData()
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        async bulkDelete() {
            try {
                await api.bulkDelete(this.selected.map(row => row.id))
                this.selected = []
                this.updateData()
                message.success('Успішно видалено')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        doBulk() {
            if (
                this.bulkAction == 'delete' && 
                this.selected.length
            ) {
                confirmPopup(this.bulkDelete, 'Ви впевнені що хочете видалити обраних користувачів?')
            }
        },
    },
    watch: {
        query: {
            handler() {
               this.updateData()
            },
            deep: true,
        },
    },
    mounted() {
       this.updateData()
    },
}
</script>
