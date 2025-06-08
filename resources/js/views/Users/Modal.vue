<template>
    <a-modal 
        :title="title"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <a-form layout="vertical">

            <a-form-item
                label="E-mail"
                :required="true"
                has-feedback
                :validate-status="errors['email'] ? 'error' : ''"
                :help="errors.email">
                <a-input
                    placeholder="Введіть e-mail"
                    v-model:value="data.email"/>
            </a-form-item>

            <a-form-item
                label="Пароль"
                :required="action == 'create'"
                has-feedback
                :validate-status="errors['password'] ? 'error' : ''"
                :help="errors.password">
                <a-flex
                    :vertical="true" 
                    :gap="5">
                    <a-input-password
                        placeholder="Введіть пароль"
                        :visible="true"
                        v-model:value="data.password"/>
                    <a-button @click="generatePassword">
                        Створити
                    </a-button>
                </a-flex>
            </a-form-item>

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
                label="Роль"
                :required="true"
                has-feedback
                :validate-status="errors['role'] ? 'error' : ''"
                :help="errors.role">
                <a-select
                    placeholder="Виберіть роль"
                    :options="roleOptions"
                    v-model:value="data.role"/>
            </a-form-item>

            <a-form-item
                v-if="data.role == 'кур\'єр'"
                label="Кур'єр"
                :required="true"
                has-feedback
                :validate-status="errors['courier_id'] ? 'error' : ''"
                :help="errors.courier_id">
                <a-select
                    placeholder="Виберіть кур'єра"
                    :options="courierOptions"
                    v-model:value="data.courier_id"/>
            </a-form-item>

            <a-form-item 
                label="Phonet номер"
                has-feedback
                :validate-status="errors['phone_number'] ? 'error' : ''"
                :help="errors.phonet_number">
                <a-input
                    placeholder="Введіть phonet номер"
                    v-model:value="data.phonet_number"/>
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
import api from '../../api/users'
import { 
    formatPhone,
} from '../../helpers/helpers'
import couriersApi from '../../api/couriers'

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
                email: '',
                password: '',
                first_name: '',
                last_name: '',
                phone: '',
                role: null,
                phonet_number: '',
            },
            errors: {},
            roles: [
               'адмін',
               'диспетчер',
               'кур\'єр',
            ],
            couriers: [],
            loading: false,
        }
    },
    computed: {
        roleOptions() {
            return this.roles.map(role => {
                return {
                    value: role,
                }
            })
        },
        courierOptions() {
            return this.couriers.map(courier => {
                return {
                    label: `${courier.first_name} ${courier.last_name}`,
                    value: courier.id,
                }
            })
        },
    },      
    methods: {
        formatPhone,
        generatePassword() {
            this.data.password = Math.random().toString(36).substring(2)
        },
        async create() {
            try {
                this.loading = true
                this.errors = {}
                const res = await api.create(this.data)
                message.success(`Успішно створено. E-mail з доступами надіслано ${this.data.email}.`)
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
        async fetchCouriers() {
            try {
                this.couriers = await couriersApi.all()
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
    },
    watch: {
        'data.courier_id': {
            handler(id) {
                if (! id) {
                    return
                }

                const courier = this.couriers.find(courier => courier.id == id)
                if (courier) {
                    this.data.first_name = courier.first_name
                    this.data.last_name = courier.last_name
                    this.data.phone = courier.phone
                }
            },
        },  
    },
    mounted() {
        if (this.item) {
            this.data = JSON.parse(JSON.stringify(this.item))
        }

        this.fetchCouriers()
    },
}
</script>