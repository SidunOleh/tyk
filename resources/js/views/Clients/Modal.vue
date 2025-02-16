<template>
    <a-modal 
        :title="title"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <a-form layout="vertical">

            <a-form-item 
                label="Ім'я та прізвище"
                :required="true"
                has-feedback
                :validate-status="errors['full_name'] ? 'error' : ''"
                :help="errors.full_name">
                <a-input
                    placeholder="Введіть ім'я та прізвище"
                    v-model:value="data.full_name"/>
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
                has-feedback
                :validate-status="addressesErrors.length ? 'error' : ''"
                :help="addressesErrors">
                <AddressSelect
                    :addresses="addresses"
                    :multiple="true"
                    v-model:value="data.addresses"/>
            </a-form-item>

            <a-form-item 
                label="Опис"
                has-feedback
                :validate-status="errors['description'] ? 'error' : ''"
                :help="errors.description">
                <a-textarea
                    :rows="5"
                    v-model:value="data.description"/>
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
import AddressSelect from '../components/AddressSelect.vue'

export default {
    props: [
        'title',
        'open',
        'action',
        'item',
    ],
    components: {
        AddressSelect,
    },
    data() {
        return {
            data: {
                full_name: '',
                phone: '',
                addresses: [],
                description: '',
            },
            addresses: [],
            errors: {},
            loading: false,
        }
    }, 
    computed: {
        addressesErrors() {
            const errors = []
            for (const field in this.errors) {
                if (field == 'addresses') {
                    errors.push(this.errors[field])
                }

                let matches = field.match(/^addresses\.(\d)\.address$/)
                if (matches) {
                    errors.push(`${this.errors[field]} №${Number(matches[1])+1}`)
                }
            }

            return errors
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
            this.data.addresses = this.data.addresses ?? []
            this.addresses = this.data.addresses
        }
    },
}
</script>