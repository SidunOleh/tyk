<template>
    <a-modal 
        :title="title"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <a-form layout="vertical">

            <a-form-item
                v-if="action == 'open'"
                label="Кур'єр"
                :required="true"
                has-feedback
                :validate-status="errors['courier_id'] ? 'error' : ''"
                :help="errors.courier_id">
                <a-select
                    placeholder="Виберіть кур'єр"
                    :options="courierOptions"
                    v-model:value="data.courier_id"/>
            </a-form-item>

            <a-form-item
                label="Автомобіль"
                :required="true"
                has-feedback
                :validate-status="errors['car_id'] ? 'error' : ''"
                :help="errors.car_id">
                <a-select
                    placeholder="Виберіть автомобіль"
                    :options="carOptions"
                    v-model:value="data.car_id"/>
            </a-form-item>

            <a-form-item 
                label="Початок зміни"
                :required="true"
                has-feedback
                :validate-status="errors['start'] ? 'error' : ''"
                :help="errors.start">
                <a-date-picker
                    style="width: 100%;"
                    showTime
                    placeholder="Виберіть час"
                    format="YYYY-MM-DD HH:mm"
                    valueFormat="YYYY-MM-DD HH:mm:ss"
                    v-model:value="data.start"/>
            </a-form-item>

            <a-form-item 
                label="Приблизний кінець"
                has-feedback
                :validate-status="errors['approximate_end'] ? 'error' : ''"
                :help="errors.approximate_end">
                <a-date-picker
                    style="width: 100%;"
                    showTime
                    placeholder="Виберіть час"
                    format="YYYY-MM-DD HH:mm"
                    valueFormat="YYYY-MM-DD HH:mm:ss"
                    v-model:value="data.approximate_end"/>
            </a-form-item>

            <a-form-item 
                label="Розмінна каса"
                :required="true"
                has-feedback
                :validate-status="errors['exchange_office'] ? 'error' : ''"
                :help="errors.exchange_office">
                <a-input-number
                    style="width: 100%"
                    placeholder="Введіть розмінну касу"
                    :min="0"
                    v-model:value="data.exchange_office"/>
            </a-form-item>

            <a-button
                type="primary"
                :loading="loading"
                @click="action == 'open' ? open() : edit()">
                Зберегти
            </a-button>

        </a-form>

    </a-modal>
</template>

<script>
import { message } from 'ant-design-vue'
import api from '../../api/work-shifts'

export default {
    props: [
        'title',
        'open',
        'action',
        'couriers',
        'cars',
        'workShift',
        'item',
    ],
    data() {
        return {
            data: {
                courier_id: null,
                car_id: null,
                start: null,
                approximate_end: null,
                exchange_office: 0,
            },
            errors: {},
            loading: false,
        }
    },
    computed: {
        courierOptions() {
            return this.couriers.filter(courier => {
                if (this.chosenCar && this.chosenCar.owner) {
                    return this.chosenCar.owner.id == courier.id
                } else {
                    return true
                }
            }).map(courier => {
                return {
                    label: `${courier.first_name} ${courier.last_name}`,
                    value: courier.id,
                }
            })
        },
        carOptions() {
            return this.cars.filter(car => {
                if (! car.owner_id || ! this.data.courier_id) {
                    return true
                } else {
                    return this.data.courier_id == car.owner_id
                }
            }).map(car => {
                return {
                    label: `${car.brand}, ${car.owner ? `авто ${car.owner.first_name} ${car.owner.last_name}` : 'авто компанії'}`,
                    value: car.id,
                }
            })
        },
        chosenCar() {
            return this.cars.find(car => this.data.car_id == car.id)
        },
    },      
    methods: {
        async open() {
            try {
                this.loading = true
                this.errors = {}
                const res = await api.openDriverWorkShift(
                    this.workShift.id, 
                    this.data
                )
                message.success('Успішно відкрита.')
                this.$emit('open')
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
        async edit() {
            try {
                this.loading = true
                this.errors = {}
                const res = await api.editDriverWorkShift(
                    this.item.id, 
                    this.data
                )
                message.success('Успішно збережено.')
                this.$emit('edit')
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
        if (this.item) {
            this.data = JSON.parse(JSON.stringify(this.item))
        }
    },
}
</script>