<template>
    <a-modal 
        :title="title"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <a-form layout="vertical">

            <a-form-item 
                label="Ім'я"
                :required="true"
                has-feedback
                :validate-status="errors['first_name'] ? 'error' : ''"
                :help="errors.first_name">
                <a-input
                    placeholder="Введіть ім'я"
                    v-model:value="data.first_name"/>
            </a-form-item>

            <a-form-item 
                label="Прізвище"
                :required="true"
                has-feedback
                :validate-status="errors['last_name'] ? 'error' : ''"
                :help="errors.last_name">
                <a-input
                    placeholder="Введіть прізвище"
                    v-model:value="data.last_name"/>
            </a-form-item>

            <a-form-item 
                label="Телефон"
                :required="true"
                has-feedback
                :validate-status="errors['phone'] ? 'error' : ''"
                :help="errors.phone">
                <a-input
                    prefix="+38"
                    placeholder="(097) 123-45-67"
                    v-model:value="data.phone"
                    :maxlength="15"
                    @change="() => data.phone = formatPhone(data.phone)"/>
            </a-form-item>

            <a-form-item 
                label="Телеграм"
                has-feedback
                :validate-status="errors['tg'] ? 'error' : ''"
                :help="errors.tg">
                <a-input
                    prefix="@"
                    placeholder="Введіть телеграм"
                    v-model:value="data.tg"/>
            </a-form-item>

            <a-form-item
                label="Транспорт"
                :required="true"
                has-feedback
                :validate-status="errors['vehicles'] ? 'error' : ''"
                :help="errors.vehicles">
                <a-select
                    placeholder="Виберіть транспорт"
                    mode="multiple"
                    :options="vehicleOptions"
                    v-model:value="data.vehicles"/>
            </a-form-item>

            <a-button   
                type="primary"
                :loading="loading"
                @click="action == 'create' ? create() : edit()">
                Зберегти
            </a-button>

        </a-form>

    </a-modal>
</template>

<script>
import { message } from 'ant-design-vue'
import api from '../../api/couriers'
import { 
    formatPhone,
} from '../../helpers/helpers'

export default {
    props: [
        'title',
        'open',
        'action',
        'item',
    ],
    data() {
        return {
            data: {
                first_name: '',
                last_name: '',
                phone: '',
                tg: '',
                vehicles: [],
            },
            errors: {},
            vehicles: [
               'автомобіль',
               'скутер',
            ],
            loading: false,
        }
    },
    computed: {
        vehicleOptions() {
            return this.vehicles.map(vehicle => {
                return {
                    value: vehicle,
                }
            })
        },
    },      
    methods: {
        formatPhone,
        async create() {
            try {
                this.loading = true
                this.errors = {}
                const res = await api.create(this.data)
                message.success('Успішно створено.')
                this.$emit('create')
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
                const res = await api.edit(this.data.id, this.data)
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