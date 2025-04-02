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
                label="Тип"
                :required="true"
                has-feedback
                :validate-status="errors['type'] ? 'error' : ''"
                :help="errors.type">
                <a-select
                    :options="typesOptions"
                    v-model:value="data.type"/>
            </a-form-item>

            <a-form-item 
                v-if="data.type == 'Фіксований' || data.type == 'Змішаний'"
                label="Фіксована ціна"
                :required="true"
                has-feedback
                :validate-status="errors['fixed_price'] ? 'error' : ''"
                :help="errors.fixed_price">
                <a-input-number 
                    style="width: 100%;"
                    placeholder="Введіть фіксовану ціну"
                    v-model:value="data.fixed_price"/>
            </a-form-item>

            <a-form-item 
                v-if="data.type == 'Змішаний'"
                label="Фіксована до км"
                :required="true"
                has-feedback
                :validate-status="errors['fixed_up_to_km'] ? 'error' : ''"
                :help="errors.fixed_up_to_km">
                <a-input-number 
                    style="width: 100%;"
                    placeholder="Введіть км"
                    v-model:value="data.fixed_up_to_km"/>
            </a-form-item>

            <a-form-item 
               v-if="data.type == 'За км' || data.type == 'Змішаний'"
                label="Ціна за км"
                :required="true"
                has-feedback
                :validate-status="errors['per_km'] ? 'error' : ''"
                :help="errors.per_km">
                <a-input-number 
                    style="width: 100%;"
                    placeholder="Введіть ціну за км"
                    v-model:value="data.per_km"/>
            </a-form-item>

            <a-form-item 
                label="Колір"
                :required="true"
                has-feedback
                :validate-status="errors['color'] ? 'error' : ''"
                :help="errors.color">
                <Vue3ColorPicker 
                    shape="circle" 
                    v-model:pureColor="data.color"/>
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
import api from '../../api/tariffs'

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
                type: 'За км',
                fixed_price: null,
                fixed_up_to_km: null,
                per_km: null,
                color: '#42a5f6',
            },
            errors: {},
            types: [
                'За км',
                'Фіксований',
                'Змішаний'            
            ],
            loading: false,
        }
    },     
    computed: {
        typesOptions() {
            return this.types.map(type => {
                return {
                    value: type,
                }
            })
        },
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