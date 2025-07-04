<template>
    <a-spin :spinning="loading">
        <a-flex 
            class="top"
            wrap="wrap"
            :gap="10">
            <a-card 
                title="Загалом" 
                style="width: 300px;"
                size="small">
                {{ data.total ?? 0 }}
            </a-card>

            <a-card 
                title="Доставка їжі" 
                style="width: 300px;"
                size="small">
                {{ data.food_shipping_total ?? 0 }}
            </a-card>

            <a-card 
                title="Кур'єр" 
                style="width: 300px;"
                size="small">
                {{ data.shipping_total ?? 0 }}
            </a-card>

            <a-card 
                title="Таксі" 
                style="width: 300px;"
                size="small">
                {{ data.taxi_total ?? 0 }}
            </a-card>
        </a-flex>

        <a-flex 
            :vertical="true"
            :gap="10"
            class="top">
            <a-typography-text strong>
                Джерела
            </a-typography-text>
            <a-flex 
                wrap="wrap"
                :gap="10"
                :align="'flex-start'">
                <a-card 
                    title="CRM" 
                    style="width: 300px;"
                    size="small">
                    {{ fromCrm }}
                </a-card>
                <a-card 
                    title="Сайт" 
                    style="width: 300px;"
                    size="small">
                    {{ fromWeb }}
                </a-card>
                <a-card 
                    title="Mобільний додаток" 
                    style="width: 300px;"
                    size="small">
                    {{ fromMobile }}
                </a-card>
            </a-flex>
        </a-flex>

        <div class="chart">
            <canvas 
                style="width: 100%; height: 300px;"
                id="orders-chart"></canvas>
        </div>

        <div class="table">
            <a-table
                :columns="columns"
                :dataSource="tableData"
                :bordered="true">

                <template #bodyCell="{column, record}">
                    <template v-if="column.key === 'date'">
                        {{ formatDate(record.date, false) }}
                    </template>

                    <template v-if="column.key === 'total'">
                        {{ record.total }}
                    </template>

                    <template v-if="column.key === 'food_shipping_total'">
                        {{ record.food_shipping_total }}
                    </template>

                    <template v-if="column.key === 'shipping_total'">
                        {{ record.shipping_total }}
                    </template>

                    <template v-if="column.key === 'taxi_total'">
                        {{ record.taxi_total }}
                    </template>
                </template>

            </a-table>
        </div>
    </a-spin>
</template>

<script>
import { message } from 'ant-design-vue'
import { Chart } from 'chart.js/auto'
import api from '../../api/analytics'
import { 
    formatDate,
    formatPrice,
} from '../../helpers/helpers'

export default {
    props: [
        'time',
    ],
    data() {
        return {
            data: [],
            columns: [
                {
                    title: 'Дата',
                    key: 'date',
                    sorter: (a, b) => {
                        return new Date(a.date).getTime() - new Date(b.date).getTime()
                    },
                },
                {
                    title: 'Загалом',
                    key: 'total',
                    sorter: (a, b) => {
                        return a.total - b.total
                    },
                },
                {
                    title: 'Доставка їжі',
                    key: 'food_shipping_total',
                    sorter: (a, b) => {
                        return a.food_shipping_total - b.food_shipping_total
                    },
                },
                {
                    title: 'Кур\'єр',
                    key: 'shipping_total',
                    sorter: (a, b) => {
                        return a.shipping_total - b.shipping_total
                    },
                },
                {
                    title: 'Таксі',
                    key: 'taxi_total',
                    sorter: (a, b) => {
                        return a.taxi_total - b.taxi_total
                    },
                },
            ],
            loading: false,
        }
    },
    computed: {
        tableData() {
            const data = []
            for (const [i, item] of this.data.data?.entries() ?? []) {
                data.push({
                    date: item.date,
                    total: item.total,
                    food_shipping_total: this.data.food_shipping_data[i].total,
                    shipping_total: this.data.shipping_data[i].total,
                    taxi_total: this.data.taxi_data[i].total,
                })
            }

            return data
        },
        fromCrm() {
            let count = 0
            this.data?.source?.forEach(item => {
                if (item.source == 'crm') {
                    count = item.total
                }
            })

            return count
        },
        fromWeb() {
            let count = 0
            this.data?.source?.forEach(item => {
                if (item.source == 'web') {
                    count = item.total
                }
            })

            return count
        },
        fromMobile() {
            let count = 0
            this.data?.source?.forEach(item => {
                if (item.source == 'mobile') {
                    count = item.total
                }
            })

            return count
        },
    },
    methods: {
        formatPrice,
        formatDate,
        async fetchData() {
            try {
                this.loading = true
                this.data = await api.orders(this.time[0], this.time[1])
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
        async data() {
            const callback = item => {
                return {
                    x: formatDate(item.date, false),
                    y: Number(item.total),
                }
            }

            this.chart.data.datasets[0].data = this.data.data.map(callback)
            this.chart.data.datasets[1].data = this.data.food_shipping_data.map(callback)
            this.chart.data.datasets[2].data = this.data.shipping_data.map(callback)
            this.chart.data.datasets[3].data = this.data.taxi_data.map(callback)
            this.chart.update()
        },
    },
    mounted() {
        if (this.time) {
            this.fetchData()
        }

        this.chart = new Chart(document.getElementById('orders-chart'), {
            type: 'line',
            data: {
                datasets: [
                    {
                        data: this.data.data, 
                        label: 'Загалом',
                    },
                    {
                        data: this.data.food_shipping_data, 
                        label: 'Доставка їжі',
                    },
                    {
                        data: this.data.shipping_data, 
                        label: 'Кур\'єр',
                    },
                    {
                        data: this.data.taxi_data, 
                        label: 'Таксі',
                    },
                ]
            },
            options: {
                scales: {
                    y: {
                        ticks: {
                            callback: value => {
                                if (value % 1 === 0) {
                                    return value
                                }
                            }
                        }
                    }
                }
            }
        })
    },
}
</script>

<style scoped>
.top {
    background: rgb(250 250 250); 
    padding: 10px; 
    border-radius: 5px;
    margin-bottom: 20px;
}

.chart {
    margin-bottom: 20px;
}
</style>