<template>
    <a-modal 
        :title="title"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <a-form layout="vertical">

            <a-form-item 
                label="Назва"
                :required="true"
                has-feedback
                :validate-status="errors['name'] ? 'error' : ''"
                :help="errors.name">
                <a-input
                    placeholder="Введіть назву"
                    v-model:value="data.name"/>
            </a-form-item>

            <a-form-item 
                label="Ціна"
                :required="true"
                has-feedback
                :validate-status="errors['price'] ? 'error' : ''"
                :help="errors.price">
                <a-input-number
                    style="width: 100%"
                    placeholder="Введіть ціну"
                    :min="0"
                    v-model:value="data.price"/>
            </a-form-item>

            <a-form-item 
                label="Видимість"
                :required="true"
                has-feedback
                :validate-status="errors['visibility'] ? 'error' : ''"
                :help="errors.visibility">
                <a-switch v-model:checked="data.visibility"/>
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
import api from '../../api/courier-services'

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
                name: '',
                price: null,
                visibility: true,
            },
            errors: {},
            loading: false,
        }
    },    
    methods: {
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