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
                    style="width: 25%; text-align: center"
                    :hoverable="false">
                    Послуга
                </a-card-grid>
                <a-card-grid 
                    style="width: 25%; text-align: center"
                    :hoverable="false">
                    К-сть
                </a-card-grid>
                <a-card-grid 
                    style="width: 25%; text-align: center"
                    :hoverable="false">
                    Бонуси
                </a-card-grid>
                <a-card-grid 
                    style="width: 25%; text-align: center"
                    :hoverable="false">
                    Тотал
                </a-card-grid>
                <a-card-grid 
                    style="width: 25%; text-align: center"
                    :hoverable="false">
                    Доставка їжі
                </a-card-grid>
                <a-card-grid 
                    style="width: 25%; text-align: center"
                    :hoverable="true">
                    {{ stat.food_shipping_count }}
                </a-card-grid>
                <a-card-grid 
                    style="width: 25%; text-align: center"
                    :hoverable="true">
                    {{ formatPrice(stat.food_shipping_bonuses) }}
                </a-card-grid>
                <a-card-grid 
                    style="width: 25%; text-align: center"
                    :hoverable="true">
                    {{ formatPrice(stat.food_shipping_total) }}
                </a-card-grid>
                <a-card-grid 
                    style="width: 25%; text-align: center"
                    :hoverable="false">
                    Кур'єр
                </a-card-grid>
                <a-card-grid 
                    style="width: 25%; text-align: center"
                    :hoverable="true">
                    {{ stat.shipping_count }}
                </a-card-grid>
                <a-card-grid 
                    style="width: 25%; text-align: center"
                    :hoverable="true">
                    {{ formatPrice(stat.shipping_bonuses) }}
                </a-card-grid>
                <a-card-grid 
                    style="width: 25%; text-align: center"
                    :hoverable="true">
                    {{ formatPrice(stat.shipping_total) }}
                </a-card-grid>
                <a-card-grid 
                    style="width: 25%; text-align: center"
                    :hoverable="false">
                    Таксі
                </a-card-grid>
                <a-card-grid 
                    style="width: 25%; text-align: center"
                    :hoverable="true">
                    {{ stat.taxi_count }}
                </a-card-grid>
                <a-card-grid 
                    style="width: 25%; text-align: center"
                    :hoverable="true">
                    {{ formatPrice(stat.taxi_bonuses) }}
                </a-card-grid>
                <a-card-grid 
                    style="width: 25%; text-align: center"
                    :hoverable="true">
                    {{ formatPrice(stat.taxi_total) }}
                </a-card-grid>
                <a-card-grid 
                    style="width: 25%; text-align: center"
                    :hoverable="false">
                    Загалом
                </a-card-grid>
                <a-card-grid 
                    style="width: 25%; text-align: center"
                    :hoverable="true">
                    {{ totalCount }}
                </a-card-grid>
                <a-card-grid 
                    style="width: 25%; text-align: center"
                    :hoverable="true">
                    {{ formatPrice(totalBonuses) }}
                </a-card-grid>
                <a-card-grid 
                    style="width: 25%; text-align: center"
                    :hoverable="true">
                    {{ formatPrice(totalTotal) }}
                </a-card-grid>
            </a-card>

            <a-form-item 
                label="Кінець зміни"
                :required="true"
                has-feedback
                :validate-status="errors['end'] ? 'error' : ''"
                :help="errors.end">
                <a-date-picker
                    style="width: 100%;"
                    showTime
                    placeholder="Виберіть час"
                    format="YYYY-MM-DD HH:mm"
                    valueFormat="YYYY-MM-DD HH:mm:ss"
                    v-model:value="data.end"/>
            </a-form-item>

            <a-button
                danger
                :loading="loading"
                @click="confirmPopup(close, 'Ви впевнені що хочете закрити зміну для диспетчера?')">
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
                end: null,
            },
            stat: {
                food_shipping_count: 0,
                food_shipping_bonuses: 0,
                food_shipping_total: 0,
                shipping_count: 0,
                shipping_bonuses: 0,
                shipping_total: 0,
                taxi_count: 0,
                taxi_bonuses: 0,
                taxi_total: 0,
            },
            errors: {},
            loading: false,
        }
    },     
    computed: {
        totalCount() {
            return this.stat.food_shipping_count 
                + this.stat.shipping_count 
                + this.stat.taxi_count
        }, 
        totalBonuses() {
            return this.stat.food_shipping_bonuses 
                + this.stat.shipping_bonuses
                + this.stat.taxi_bonuses
        },   
        totalTotal() {
            return this.stat.food_shipping_total 
                + this.stat.shipping_total 
                + this.stat.taxi_total
        },  
    },  
    methods: {
        confirmPopup,
        formatPrice,
        async fetchStat() {
            try {
                this.loading = true
                const res = await api.dispatcherWorkShiftStat(this.item.id)
                this.stat = res.stat
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
                await api.closeDispatcherWorkShift(
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