<template>
    <a-modal 
        :title="title"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <a-form layout="vertical">

            <a-form-item 
                label="Марка"
                :required="true"
                has-feedback
                :validate-status="errors['brand'] ? 'error' : ''"
                :help="errors.brand">
                <a-input
                    placeholder="Введіть марка"
                    v-model:value="data.brand"/>
            </a-form-item>

            <a-form-item 
                label="Номер"
                :required="true"
                has-feedback
                :validate-status="errors['number'] ? 'error' : ''"
                :help="errors.number">
                <a-input
                    placeholder="Введіть номер"
                    v-model:value="data.number"/>
            </a-form-item>

            <a-form-item 
                label="Mapon id"
                has-feedback
                :validate-status="errors['mapon_id'] ? 'error' : ''"
                :help="errors.mapon_id">
                <a-input
                    placeholder="Введіть mapon id"
                    v-model:value="data.mapon_id"/>
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
import api from '../../api/cars'

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
                brand: '',
                number: '',
                mapon_id: '',
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