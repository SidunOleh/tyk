<template>
    <a-spin :spinning="loading">
        <a-flex
            :vertical="'vertical'"
            :gap="10">
            <a-flex :gap="10">
                <a-select
                    style="width: 150px;"
                    :options="intervalOptions"
                    v-model:value="interval"/>
                <a-select
                    style="width: 150px;"
                    :options="typeOptions"
                    v-model:value="type"/>
                <a-range-picker 
                    style="width: 350px;"
                    :allowClear="false"
                    v-model:value="between"
                    :picker="picker"
                    valueFormat="YYYY-MM-DD"
                    @change="changeBetween"/>
            </a-flex>

            <a-flex style="height:400px;">
                <Bar
                    :data="chartData" 
                    :options="options"/>
            </a-flex>
        </a-flex>
    </a-spin>
</template>

<script>
import { message, } from 'ant-design-vue'
import api from '../../api/driver'
import { daysInMonth, formatPrice, } from '../../helpers/helpers'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
import { Bar } from 'vue-chartjs'
import ChartDataLabels from 'chartjs-plugin-datalabels'
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ChartDataLabels)

export default {
    components: {
        Bar,
    },
    data() {
        return {
            interval: 'days',
            type: 'amount',
            between: [null, null],
            data: [],
            loading: false,
            intervals: [
                {
                    name: 'По дням',
                    value: 'days',
                },
                {
                    name: 'По місяцям',
                    value: 'months',
                },
                {
                    name: 'По рокам',
                    value: 'years',
                },
            ],
            types: [
                {
                    name: 'Сума',
                    value: 'amount',
                },
                {
                    name: 'Кількість',
                    value: 'count',
                },
            ],
            options: { 
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: context => this.type == 'amount' ? formatPrice(context.raw) : context.raw
                        }
                    },
                    datalabels: {
                        color: 'black',
                        font: {
                            size: 14,
                            weight: 700,
                        },
                        formatter: val => this.type == 'amount' ?  formatPrice(val) : val,
                    },
                },
                scales: {
                    y: {
                        ticks: {
                            callback: val => this.type == 'amount' ?  formatPrice(val) : val,
                            color: 'black',
                            font: {
                                size: 14,
                                weight: 700,
                            }
                        },
                    }
                }
            },
        }
    },
    computed: {
        intervalOptions() {
            return this.intervals.map(interval => {
                return {
                    label: interval.name,
                    value: interval.value,
                }
            })
        },  
        typeOptions() {
            return this.types.map(type => {
                return {
                    label: type.name,
                    value: type.value,
                }
            })
        }, 
        picker() {
            if (this.interval == 'days') {
                return 'date'
            } else if (this.interval == 'months') {
                return 'month'
            } else if (this.interval == 'years') {
                return 'year'
            }
        },
        chartData() {
            const data = {}

            data.labels = [...new Set(this.data.map(item => this.makeLabel(item)))]

            data.datasets = []

            const backgroundColor = [
                'rgba(255, 99, 132, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(75, 192, 192, 0.5)',
            ]
            const borderColor = [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(75, 192, 192)',
            ]

            const types = [...new Set(this.data.map(item => item.type))]

            types.forEach((type, i) => {
                const dataset = {
                    label: type,
                    data: [], 
                    backgroundColor: backgroundColor[i],
                    borderColor: borderColor[i],
                    borderWidth: 1,
                }

                data.labels.forEach(label => {
                    let value = 0
                    this.data?.forEach(item => {
                        if (item.type != type) {
                            return
                        }

                        if (this.makeLabel(item) == label) {
                            value = this.type == 'amount' ? item.total : item.count
                        }
                    })
                    dataset.data.push(value)
                })
                
                data.datasets.push(dataset)
            })

            return data
        },
    },
    methods: {
        formatDate(date) {
            return `${date.getFullYear()}-${String(date.getMonth()+1).padStart(2, 0)}-${String(date.getDate()).padStart(2, 0)}`
        },
        makeLabel(item) {
            if (this.interval == 'days') {
                return new Date(item.date).toLocaleDateString('uk-UA', { year: 'numeric', month: 'long', day: 'numeric' })
            } else if (this.interval == 'months') {
               return new Date(`${item.year}-${item.month}`).toLocaleDateString('uk-UA', { year: 'numeric', month: 'long', })
            } else if (this.interval == 'years') {
                return item.year
            }
        },
        setBetween() {
            if (this.interval == 'days') {
                const start = new Date()
                const end = new Date()
                start.setDate(end.getDate() - 14)
                this.between = [this.formatDate(start), this.formatDate(end)]
            }

            if (this.interval == 'months') {
                const start = new Date()
                const end = new Date()
                start.setMonth(start.getMonth() - 2)
                start.setDate(1)
                this.between = [this.formatDate(start), this.formatDate(end)]
            }

            if (this.interval == 'years') {
                const start = new Date()
                const end = new Date()
                start.setMonth(0)
                start.setDate(1)
                this.between = [this.formatDate(start), this.formatDate(end)]
            }
        },
        changeBetween() {
            if (this.interval == 'years') {
                const date = new Date(this.between[1])
                date.setMonth(11)
                date.setDate(daysInMonth(date.getFullYear(), date.getMonth()))
                this.between[1] = this.formatDate(date)
            }

            if (this.interval == 'months') {
                const date = new Date(this.between[1])
                date.setDate(daysInMonth(date.getFullYear(), date.getMonth()))
                this.between[1] = this.formatDate(date)
            }
        },
        async fetch() {
            try {
                this.loading = true
                this.data = await api.statistic(
                    this.between[0], 
                    this.between[1], 
                    this.interval
                )
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },  
    },
    watch: {
        between: {
            handler() {
                this.fetch()
            },
            deep: true,
        },
        interval() {
            this.data = []
            this.setBetween()
        },  
    },
    mounted() {
        this.setBetween()
    }
}
</script>