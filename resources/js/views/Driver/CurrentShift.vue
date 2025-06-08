<template>
    <a-card title="Поточна зміна">
        <template v-if="data?.work_shift">
            <a-flex
                :vertical="true"
                :gap="10">
                <div>
                    Відкрита {{ formatDate(data.work_shift.start) }}
                </div>
                <a-flex 
                    class="top"
                    wrap="wrap"
                    :gap="10">
                    <a-card 
                        title="Загалом" 
                        style="width: 300px;"
                        size="small">
                        {{ formatPrice(total) }}
                    </a-card>

                    <a-card 
                        title="Доставка їжі" 
                        style="width: 300px;"
                        size="small">
                        {{ formatPrice(data.statistic.food_shipping_total) }}
                    </a-card>

                    <a-card 
                        title="Кур'єр" 
                        style="width: 300px;"
                        size="small">
                        {{ formatPrice(data.statistic.shipping_total) }}
                    </a-card>

                    <a-card 
                        title="Таксі" 
                        style="width: 300px;"
                        size="small">
                        {{ formatPrice(data.statistic.taxi_total) }}
                    </a-card>
                </a-flex>
            </a-flex>
        </template>
        
        <template v-else>
            Немає відкритої зміни
        </template>
    </a-card>
</template>

<script>
import { message, } from 'ant-design-vue'
import api from '../../api/driver'
import { 
    formatPrice, 
    formatDate, 
} from '../../helpers/helpers'

export default {
    data() {
        return {
            data: null,
            loading: false,
        }
    },
    methods: {
        formatPrice, 
        formatDate,
        async fetch() {
            try {
                this.loading = true
                this.data = await api.currentWorkShift()
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },  
    },
    computed: {
        total() {
            return this.data.statistic.food_shipping_total 
                + this.data.statistic.shipping_total 
                + this.data.statistic.shipping_total
        },
    },
    mounted() {
        this.fetch()
    }
}
</script>