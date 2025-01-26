<template>
    <a-flex
        wrap="wrap"
        :gap="10">

        <a-card 
            title="Топ закладів" 
            style="flex: 49%;"
            size="small">
            <a-table
                :columns="zakladyColumns"
                :pagination="false"
                :dataSource="data.zaklady_top"
                :bordered="true">
                <template #bodyCell="{column, record}">
                    <template v-if="column.key === 'name'">
                        {{ record.name }}
                    </template>

                    <template v-if="column.key === 'quantity'">
                        {{ record.quantity }}
                    </template>

                    <template v-if="column.key === 'total'">
                        {{ formatPrice(record.total) }}
                    </template>
                </template>
            </a-table>
        </a-card>

        <a-card 
            title="Топ товарів" 
            style="flex: 49%;"
            size="small">
            <a-table
                :columns="productsColumns"
                :pagination="false"
                :dataSource="data.products_top"
                :bordered="true">
                <template #bodyCell="{column, record}">
                    <template v-if="column.key === 'name'">
                        {{ record.name }}
                    </template>

                    <template v-if="column.key === 'quantity'">
                        {{ record.quantity }}
                    </template>

                    <template v-if="column.key === 'total'">
                        {{ formatPrice(record.total) }}
                    </template>
                </template>
            </a-table>
        </a-card>
    </a-flex>
</template>

<script>
import { message } from 'ant-design-vue'
import api from '../../api/analytics'
import { 
    formatPrice,
} from '../../helpers/helpers'

export default {
    props: [
        'time',
    ],
    data() {
        return {
            data: [],
            productsColumns: [
                {
                    title: 'Назва',
                    key: 'name',
                },
                {
                    title: 'К-сть',
                    key: 'quantity',
                    sorter: (a, b) => {
                        return a.quantity - b.quantity
                    },
                },
                {
                    title: 'Сума',
                    key: 'total',
                    sorter: (a, b) => {
                        return a.total - b.total
                    },
                },
            ],
            zakladyColumns: [
                {
                    title: 'Назва',
                    key: 'name',
                },
                {
                    title: 'К-сть',
                    key: 'quantity',
                    sorter: (a, b) => {
                        return a.quantity - b.quantity
                    },
                },
                {
                    title: 'Сума',
                    key: 'total',
                    sorter: (a, b) => {
                        return a.total - b.total
                    },
                },
            ],
            loading: false,
        }
    },
    methods: {
        formatPrice,
        async fetchData() {
            try {
                this.loading = true
                this.data = await api.products(this.time[0], this.time[1])
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        }, 
    },
    watch: {
        async time() {
            if (this.time) {
                this.fetchData()
            }
        },
    },
    mounted() {
        if (this.time) {
            this.fetchData()
        }
    },
}
</script>