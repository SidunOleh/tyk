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
                label="Фото"
                :required="true"
                has-feedback
                :validate-status="errors['image'] ? 'error' : ''"
                :help="errors.image">
                <Upload v-model:uploaded="data.image"/>
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
import api from '../../../api/categories'
import Upload from '../../components/Upload.vue'

export default {
    props: [
        'title',
        'open',
        'action',
        'item',
    ],
    components: {
        Upload,
    },
    data() {
        return {
            data: {
                name: '',
                image: null,
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
                const res = await api.createTag(this.data)
                message.success('Успішно створено.')
                this.$emit('create', res)
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
                const res = await api.editTag(this.data.id, this.data)
                message.success('Успішно збережено.')
                this.$emit('edit', res)
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