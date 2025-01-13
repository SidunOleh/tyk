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
                    placeholder="(097) 123-45-67"
                    prefix="+38"
                    v-model:value="data.phone"
                    :maxlength="15"
                    @change="() => data.phone = formatPhone(data.phone)"/>
            </a-form-item>

            <a-form-item 
                label="Адреси"
                :required="true"
                has-feedback
                :validate-status="addressesErrors.length ? 'error' : ''"
                :help="addressesErrors">
                <a-flex
                    :vertical="true"
                    :gap="5">
                    <a-flex 
                        v-for="(address, i) in data.addresses"
                        :gap="5"
                        :align="'center'">
                        <a-input
                            placeholder="Введіть адресу"
                            v-model:value="data.addresses[i]"/>
                        <a-button
                            danger
                            type="text"
                            size="small"
                            @click="removeAddress(i)">
                            X
                        </a-button>
                    </a-flex>

                    <a-button 
                        style="align-self: start;"
                        @click="addAddress">
                        Додати адресу
                    </a-button>
                </a-flex>
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
import api from '../../api/clients'
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
                addresses: [''],
            },
            errors: {},
            loading: false,
        }
    }, 
    computed: {
        addressesErrors() {
            const errors = []
            for (const field in this.errors) {
                if (field.search('addresses') == 0) {
                    errors.push(this.errors[field])
                }
            }
            return errors
        },
    },
    methods: {
        formatPhone,
        addAddress() {
            this.data.addresses.push('')
        },
        removeAddress(i) {
            this.data.addresses.splice(i, 1)
        },
        async create() {
            try {
                this.loading = true
                this.errors = {}
                const res = await api.create(this.data)
                message.success('Успішно створено.')
                this.$emit('create', res.client)
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