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
        @change="changeQuery">

        <template #expandedRowRender="{ record }">
            <a-descriptions 
                :column="1"
                bordered>
                <a-descriptions-item label="Початок" style="padding: 10px;">
                    {{ formatDate(record.start) }}
                </a-descriptions-item>
                <a-descriptions-item label="Кінець" style="padding: 10px;">
                    {{ formatDate(record.end) }}
                </a-descriptions-item>
                <a-descriptions-item label="Автомобіль" style="padding: 10px;">
                    {{ record.car?.brand }}
                </a-descriptions-item>
                <a-descriptions-item label="Статус" style="padding: 10px;">
                    <a-tag :color="record.status == 'open' ? 'green' : 'black'">
                        {{ record.status == 'open' ? 'відкрита' : 'закрита' }}
                    </a-tag>
                </a-descriptions-item>
            </a-descriptions>

            <a-card style="margin-top: 15px;">
                <a-card-grid :hoverable="false">
                </a-card-grid>
                <a-card-grid :hoverable="false">
                    К-сть
                </a-card-grid>
                <a-card-grid :hoverable="false">
                    <div>Тотал <div style="font-size: 10px;">(сума доставки)</div></div>
                </a-card-grid>
                <a-card-grid :hoverable="false">
                    Доставка їжі
                </a-card-grid>
                <a-card-grid :hoverable="false">
                    {{ record.food_shipping_count }}
                </a-card-grid>
                <a-card-grid :hoverable="false">
                    {{ formatPrice(record.food_shipping_total) }}
                </a-card-grid>
                <a-card-grid :hoverable="false">
                    Кур'єр
                </a-card-grid>
                <a-card-grid :hoverable="false">
                    {{ record.shipping_count }}
                </a-card-grid>
                <a-card-grid :hoverable="false">
                    {{ formatPrice(record.shipping_total) }}
                </a-card-grid>
                <a-card-grid :hoverable="false">
                    Таксі
                </a-card-grid>
                <a-card-grid :hoverable="false">
                    {{ record.taxi_count }}
                </a-card-grid>
                <a-card-grid :hoverable="false">
                    {{ formatPrice(record.taxi_total) }}
                </a-card-grid>
                <a-card-grid :hoverable="false">
                    Загалом
                </a-card-grid>
                <a-card-grid :hoverable="false">
                    {{ record.food_shipping_count + record.shipping_count + record.taxi_count }}
                </a-card-grid>
                <a-card-grid :hoverable="false">
                    {{ formatPrice(record.food_shipping_total + record.shipping_total + record.taxi_total) }}
                </a-card-grid>
            </a-card>
        </template>

        <template #bodyCell="{column, record}">

            <template v-if="column.key === 'start'">
                {{ formatDate(record.start) }}
            </template>

            <template v-if="column.key === 'end'">
                {{ formatDate(record.end) }}
            </template>

            <template v-if="column.key === 'car_id'">
                {{ record.car?.brand }}
            </template>

            <template v-if="column.key === 'status'">
                <a-tag :color="record.status == 'open' ? 'green' : 'black'">
                    {{ record.status == 'open' ? 'відкрита' : 'закрита' }}
                </a-tag>
            </template>

        </template>

    </a-table>
</template>

<script>
import { message, } from 'ant-design-vue'
import api from '../../api/driver'
import { 
    formatDate,
    formatPrice,
} from '../../helpers/helpers'

export default {
    data() {
        return {
            columns: [
                {
                    title: 'Початок',
                    key: 'start',
                },
                {
                    title: 'Кінець',
                    key: 'end',
                },
                {
                    title: 'Автомобіль',
                    key: 'car_id',
                },
                {
                    title: 'Статус',
                    key: 'status',
                },
            ],
            query: {
                page: 1,
                perpage: 15,
                orderby: 'created_at',
                order: 'DESC',
                filters: {},
            },
            data: {},
            loading: false,
        }
    },
    methods: {
        formatDate,
        formatPrice,
        async fetch() {
            try {
                this.loading = true
                this.data = await api.shifts(this.query)
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
    }, 
    watch: {
        query: {
            handler() {
               this.fetch()
            },
            deep: true,
        },
    },
    mounted() {
       this.fetch()
    },
}
</script>

<style scoped>
.ant-card-grid {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 33.33%; 
    text-align: center; 
    padding: 10px;
}
</style>