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
                <a-descriptions-item label="Початок">
                    {{ formatDate(record.start) }}
                </a-descriptions-item>  
                <a-descriptions-item label="Кінець">
                    {{ formatDate(record.end) }}
                </a-descriptions-item> 
                <a-descriptions-item label="Доставка їжі">
                    К-сть - {{ record.food_shipping_count }}, Сума - {{ formatPrice(record.food_shipping_total) }}
                </a-descriptions-item> 
                <a-descriptions-item label="Заклади">
                    <a-descriptions 
                        v-if="record.zaklady_reports.length"
                        style="margin-top: 10px;"
                        size="small"
                        bordered
                        :column="1">
                        <a-descriptions-item 
                            v-for="report in record.zaklady_reports"
                            :label="report.zaklad.name">
                            Загалом - {{ formatPrice(report.total) }}, Повернуто - {{ formatPrice(report.returned_amount) }} 
                            <a-typography-link @click="$emit('zakladReport', report)">
                                <EditOutlined/>
                            </a-typography-link>
                        </a-descriptions-item> 
                    </a-descriptions>
                </a-descriptions-item> 
                <a-descriptions-item label="Кур'єр">
                    К-сть - {{ record.shipping_count }}, Сума - {{ formatPrice(record.shipping_total) }}
                </a-descriptions-item> 
                <a-descriptions-item label="Таксі">
                    К-сть - {{ record.taxi_count }}, Сума - {{ formatPrice(record.taxi_total) }}
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
            <template v-if="column.key === 'start'">
                {{ formatDate(record.start) }}
            </template>

            <template v-if="column.key === 'end'">
                {{ formatDate(record.end) }}
            </template>
        </template>

    </a-table>

</template>

<script>
import { message, } from 'ant-design-vue'
import api from '../../api/work-shifts'
import { confirmPopup, formatDate, formatPrice, } from '../../helpers/helpers'
import {
    EditOutlined,
} from '@ant-design/icons-vue'

export default {
    components: {
        EditOutlined,
    },
    data() {
        return {
            columns: [
                {
                    title: 'Початок',
                    key: 'start',
                    sorter: true,
                },
                {
                    title: 'Кінець',
                    key: 'end',
                    sorter: true,
                },
            ],
            data: {},
            bulkOptions: [
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
        formatDate,
        formatPrice,
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
        doBulk() {

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
