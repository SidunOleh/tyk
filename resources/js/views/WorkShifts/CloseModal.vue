<template>
    <a-modal 
        :title="title"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <a-form layout="vertical">

            <a-card 
                style="margin-bottom: 15px;"
                title="Статистика за зміну">
                <a-card-grid 
                    style="width: 33.33%; text-align: center"
                    :hoverable="false">
                    Доставка їжі
                </a-card-grid>
                <a-card-grid 
                    style="width: 33.33%; text-align: center"
                    :hoverable="false">
                    {{ data.food_shipping_count }}
                </a-card-grid>
                <a-card-grid 
                    style="width: 33.33%; text-align: center"
                    :hoverable="false">
                    {{ formatPrice(data.food_shipping_total) }}
                </a-card-grid>
                <a-card-grid 
                    style="width: 33.33%; text-align: center"
                    :hoverable="false">
                    Кур'єр
                </a-card-grid>
                <a-card-grid 
                    style="width: 33.33%; text-align: center"
                    :hoverable="false">
                    {{ data.shipping_count }}
                </a-card-grid>
                <a-card-grid 
                    style="width: 33.33%; text-align: center"
                    :hoverable="false">
                    {{ formatPrice(data.shipping_total) }}
                </a-card-grid>
                <a-card-grid 
                    style="width: 33.33%; text-align: center"
                    :hoverable="false">
                    Таксі
                </a-card-grid>
                <a-card-grid 
                    style="width: 33.33%; text-align: center"
                    :hoverable="false">
                    {{ data.taxi_count }}
                </a-card-grid>
                <a-card-grid 
                    style="width: 33.33%; text-align: center"
                    :hoverable="false">
                    {{ formatPrice(data.taxi_total) }}
                </a-card-grid>
                <a-card-grid 
                    style="width: 33.33%; text-align: center"
                    :hoverable="false">
                    Загалом
                </a-card-grid>
                <a-card-grid 
                    style="width: 33.33%; text-align: center"
                    :hoverable="false">
                    {{ totalCount }}
                </a-card-grid>
                <a-card-grid 
                    style="width: 33.33%; text-align: center"
                    :hoverable="false">
                    {{ formatPrice(totalTotal) }}
                </a-card-grid>
            </a-card>
            
            <a-button
                danger
                :loading="loading"
                @click="confirmPopup(close, 'Ви впевнені що хочете закрити зміну?')">
                Закрити
            </a-button>

        </a-form>

    </a-modal>
</template>

<script>
import { message } from 'ant-design-vue'
import api from '../../api/work-shifts'
import { 
    confirmPopup, 
    formatPrice,
} from '../../helpers/helpers'

export default {
    props: [
        'title',
        'open',
        'item',
    ],
    data() {
        return {
            data: {
                food_shipping_count: 0,
                food_shipping_total: 0,
                shipping_count: 0,
                shipping_total: 0,
                taxi_count: 0,
                taxi_total: 0,
            },
            errors: {},
            loading: false,
        }
    },     
    computed: {
        totalCount() {
            return this.data.food_shipping_count 
                + this.data.shipping_count 
                + this.data.taxi_count
        },  
        totalTotal() {
            return this.data.food_shipping_total 
                + this.data.shipping_total 
                + this.data.taxi_total
        },  
    },  
    methods: {
        confirmPopup,
        formatPrice,
        async fetchStat() {
            try {
                this.loading = true
                const res = await api.workShiftStat(this.item.id)
                this.data = {...this.data, ...res.stat}
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        async close() {
            try {
                this.loading = true
                this.errors = {}
                const res = await api.close(
                    this.item.id, 
                    this.data
                )
                message.success('Успішно закрита.')
                this.$emit('close')
                this.$emit('update:open', false)
            } catch (err) {
                if (err?.response?.status == 422) {
                    this.errors = err?.response?.data?.errors
                } else {
                    message.error(err?.response?.data?.message ?? err.message)
                }
            } finally {
                this.loading = false
            }
        },
    },
    mounted() {
        this.fetchStat()
    },
}
</script>